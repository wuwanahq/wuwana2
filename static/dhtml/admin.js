// ECMAScript 5
"use strict";

function scrape()
{
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("load", handleEventLoad);
	xhr.open("get", document.getElementById("instagram").value);
	xhr.send();
}

function handleEventLoad()
{
	var html = this.responseText;
	var index1 = html.indexOf('<script type="text/javascript">window._sharedData =') + 51;
	var index2 = html.indexOf(";</script>", index1);
	var graphql = JSON.parse(html.substring(index1, index2)).entry_data.ProfilePage[0].graphql;

	document.getElementById("email").value = graphql.user.business_email;
	document.getElementById("biography").value = graphql.user.biography;
	document.getElementById("website").value = graphql.user.external_url;
	document.getElementById("ExternalURL").value = graphql.user.external_url;
	document.getElementById("name").value = graphql.user.full_name;
	document.getElementById("following").value = graphql.user.edge_follow.count;
	document.getElementById("followers").value = graphql.user.edge_followed_by.count;
	document.getElementById("posts").value = graphql.user.edge_owner_to_timeline_media.count;
	document.getElementById("ProfilePicURL").value = graphql.user.profile_pic_url;

	var extraInfo = graphql.user.category_name + ";" + graphql.user.business_category_name;

	for (var i=0; i < 6; i++)
	{
		if (typeof graphql.user.edge_owner_to_timeline_media.edges[i] === "undefined")
		{ break; }

		document.getElementById("ThumbnailSrc" + i).value =
			graphql.user.edge_owner_to_timeline_media.edges[i].node.thumbnail_src;

		for (var j=0; j < 9; j++)
		{
			if (typeof graphql.user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j] == "undefined")
			{ break; }

			extraInfo += ";"
				+ graphql.user.edge_owner_to_timeline_media.edges[i].node.edge_media_to_caption.edges[j].node.text;
		}
	}

	document.getElementById("ExtraInfo").value = extraInfo;
	document.getElementById("button").disabled = false;
}
