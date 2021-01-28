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

		var xhr = new XMLHttpRequest();
		xhr.open("get", "/ajax/update-company.php");
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
		document.getElementById("button").disabled = false;
	}
}

function scrapeInstagram(html)
{
	var index1 = html.indexOf('<script type="text/javascript">window._sharedData =') + 51;
	var index2 = html.indexOf(";</script>", index1);

	if (index1 < 60 || index2 < 70)
	{ return null; }

	var graphql = JSON.parse(html.substring(index1, index2)).entry_data.ProfilePage[0].graphql.user;
	var user = {
		email: graphql.business_email,
		biography: graphql.biography,
		externalURL: graphql.external_url,
		name: graphql.full_name,
		nbFollowing: graphql.edge_follow.count,
		nbFollower: graphql.edge_followed_by.count,
		nbPost: graphql.edge_owner_to_timeline_media.count,
		profilePicURL: graphql.profile_pic_url,
		extraInfo: graphql.category_name + ";" + graphql.business_category_name,
		pictures: []
	};

	for (var i=0; i < 6; i++)
	{
		if (typeof graphql.edge_owner_to_timeline_media.edges[i] === "undefined")
		{ break; }

		user.pictures.push(graphql.edge_owner_to_timeline_media.edges[i].node.thumbnail_src);

		for (var j=0; j < 9; j++)
		{
			if (typeof graphql.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j] == "undefined")
			{ break; }

			user.extraInfo += ";"
				+ graphql.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j].node.text;
		}
	}

	return user;
}