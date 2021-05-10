// ECMAScript 5
"use strict";

function displayMessage(text)
{
	document.getElementById("MsgTxt").innerText = text;
	// document.getElementById("MsgBox").style.display = "flex";
}

function scrapeInstagramForAutoUpdate(url)
{
	if (url != "")
	{
		displayMessage("Trying to scrape " + url + "...");

		var xhr = new XMLHttpRequest();
		xhr.addEventListener("load", handleProfilePageAndSubmitForm);
		xhr.addEventListener("error", function() {
			displayMessage("Scraper blocked by Cross-Origin Restrictions");
		});

		xhr.open("get", "https://www." + url + "/");  // Do not use "/?__a=1" to stay incognito
		xhr.send();
	}
}

function handleProfilePageAndSubmitForm()
{
	var profile = parseGraphQL(this.responseText);

	if (profile != null)
	{
		var form = new FormData();
		form.append("instagram", this.responseURL);
		form.append("email", profile.email);
		form.append("biography", profile.biography);
		//form.append("website", profile.externalURL);
		form.append("ExternalURL", profile.externalURL);
		form.append("name", profile.name);
		form.append("following", profile.nbFollowing);
		form.append("followers", profile.nbFollower);
		form.append("posts", profile.nbPost);
		form.append("ProfilePicURL", profile.picURL);
		form.append("ExtraInfo", profile.extraInfo);

		for (var i=0; i < 6; i++)
		{ form.append("ThumbnailSrc" + i, profile.pictures[i]); }

		var xhr = new XMLHttpRequest();
		xhr.open("post", "/ajax/update-company.php");
		xhr.send(form);

		displayMessage("Hooray! The scraper fetched data from " + this.responseURL);
	}
}

function scrapeInstagramToFillForm()
{
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("load", handleProfilePageAndFillForm);
	xhr.addEventListener("error", function() {
		displayMessage("Scraper blocked by Cross-Origin Restrictions");
	});

	url = document.getElementById("instagram").value;

	if (url.indexOf("www.") == 0)
	{ xhr.open("get", "https://" + url); }
	else if (url.indexOf("http") != 0)
	{ xhr.open("get", "https://www." + url); }

	xhr.send();
}

function handleProfilePageAndFillForm()
{
	var profile = parseGraphQL(this.responseText);

	if (profile != null)
	{
		document.getElementById("email").value = profile.email;
		document.getElementById("biography").value = profile.biography;
		//document.getElementById("website").value = profile.externalURL;
		document.getElementById("ExternalURL").value = profile.externalURL;
		document.getElementById("name").value = profile.name;
		document.getElementById("following").value = profile.nbFollowing;
		document.getElementById("followers").value = profile.nbFollower;
		document.getElementById("posts").value = profile.nbPost;
		document.getElementById("ProfilePicURL").value = profile.picURL;
		document.getElementById("ExtraInfo").value = profile.extraInfo;

		for (var i=0; i < 6; i++)
		{ document.getElementById("ThumbnailSrc" + i).value = profile.pictures[i]; }
	}
}

function parseGraphQL(html)
{
	var index1 = html.indexOf('<script type="text/javascript">window._sharedData =') + 51;
	var index2 = html.indexOf(";</script>", index1);

	if (index1 < 51 || index2 <= index1)
	{
		displayMessage("The scraper got an Error from Instagram");
		return null;
	}

	var graphql = JSON.parse(html.substring(index1, index2));

	if (graphql.entry_data.ProfilePage === undefined)
	{
		if (graphql.entry_data.LoginAndSignupPage === undefined)
		{ displayMessage("Instagram profile not found by the Scraper"); }
		else
		{ displayMessage("Scraper blocked by Instagram login page"); }

		return null;
	}

	graphql = graphql.entry_data.ProfilePage[0].graphql;

	var profile = {
		email:       graphql.user.business_email,
		biography:   graphql.user.biography,
		externalURL: graphql.user.external_url,
		name:        graphql.user.full_name,
		nbFollowing: graphql.user.edge_follow.count,
		nbFollower:  graphql.user.edge_followed_by.count,
		nbPost:      graphql.user.edge_owner_to_timeline_media.count,
		extraInfo:   graphql.user.category_name + ";" + graphql.user.business_category_name,
		picURL:      graphql.user.profile_pic_url,
		pictures:    []
	};

	for (var i=0; i < 6; i++)
	{
		if (graphql.user.edge_owner_to_timeline_media.edges[i] === undefined)
		{ break; }

		profile.pictures.push(graphql.user.edge_owner_to_timeline_media.edges[i].node.thumbnail_src);

		for (var j=0; j < 9; j++)
		{
			if (graphql.user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j] === undefined)
			{ break; }

			profile.extraInfo += ";"
				+ graphql.user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j].node.text;
		}
	}

	return profile;
}