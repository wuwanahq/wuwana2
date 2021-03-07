// ECMAScript 5
"use strict";

function updateCompany(url)
{
	if (url != "")
	{
		var xhr = new XMLHttpRequest();
		xhr.addEventListener("load", handleProfilePageAndSubmitForm);
		xhr.open("get", url);
		xhr.send();
	}
}

function handleProfilePageAndSubmitForm()
{
	var user = scrapeInstagram(this.responseText);

	if (user != null)
	{
		var form = new FormData();
		form.append("instagram", this.responseURL);
		form.append("email", user.email);
		form.append("biography", user.biography);
		form.append("website", user.externalURL);
		form.append("ExternalURL", user.externalURL);
		form.append("name", user.name);
		form.append("following", user.nbFollowing);
		form.append("followers", user.nbFollower);
		form.append("posts", user.nbPost);
		form.append("ProfilePicURL", user.profilePicURL);
		form.append("ExtraInfo", user.extraInfo);

		for (var i=0; i < 6; i++)
		{ form.append("ThumbnailSrc" + i, user.pictures[i]); }

		var xhr = new XMLHttpRequest();
		xhr.open("post", "/ajax/update-company.php");
		xhr.send(form);
	}
}

function scrape()
{
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("load", handleProfilePageAndFillForm);
	xhr.open("get", document.getElementById("instagram").value);
	xhr.send();
}

function handleProfilePageAndFillForm()
{
	var user = scrapeInstagram(this.responseText);

	if (user != null)
	{
		document.getElementById("email").value = user.email;
		document.getElementById("biography").value = user.biography;
		document.getElementById("website").value = user.externalURL;
		document.getElementById("ExternalURL").value = user.externalURL;
		document.getElementById("name").value = user.name;
		document.getElementById("following").value = user.nbFollowing;
		document.getElementById("followers").value = user.nbFollower;
		document.getElementById("posts").value = user.nbPost;
		document.getElementById("ProfilePicURL").value = user.profilePicURL;
		document.getElementById("ExtraInfo").value = user.extraInfo;

		for (var i=0; i < 6; i++)
		{ document.getElementById("ThumbnailSrc" + i).value = user.pictures[i]; }
	}
}

function scrapeInstagram(html)
{
	var index1 = html.indexOf('<script type="text/javascript">window._sharedData =') + 51;
	var index2 = html.indexOf(";</script>", index1);

	if (index1 < 60 || index2 < 70)
	{
		console.log("Instagram page not found");
		return null;
	}

	var user = JSON.parse(html.substring(index1, index2));

	if (user.entry_data.ProfilePage === undefined)
	{
		console.log("Scraper blocked by Instagram login page");
		return null;
	}

	user = user.entry_data.ProfilePage[0].graphql.user;
	var data = {
		email: user.business_email,
		biography: user.biography,
		externalURL: user.external_url,
		name: user.full_name,
		nbFollowing: user.edge_follow.count,
		nbFollower: user.edge_followed_by.count,
		nbPost: user.edge_owner_to_timeline_media.count,
		profilePicURL: user.profile_pic_url,
		extraInfo: user.category_name + ";" + user.business_category_name,
		pictures: []
	};

	for (var i=0; i < 6; i++)
	{
		if (user.edge_owner_to_timeline_media.edges[i] === undefined)
		{ break; }

		data.pictures.push(user.edge_owner_to_timeline_media.edges[i].node.thumbnail_src);

		for (var j=0; j < 9; j++)
		{
			if (user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j] === undefined)
			{ break; }

			data.extraInfo += ";"
				+ user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j].node.text;
		}
	}

	return data;
}