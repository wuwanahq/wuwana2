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

	document.getElementById("Biography").value = graphql.user.biography;
	document.getElementById("BusinessEmail").value = graphql.user.business_email;
	document.getElementById("ExternalURL").value = graphql.user.external_url;
	document.getElementById("FullName").value = graphql.user.full_name;
	document.getElementById("FollowingCount").value = graphql.user.edge_follow.count;
	document.getElementById("FollowerCount").value = graphql.user.edge_followed_by.count;
	document.getElementById("PostCount").value = graphql.user.edge_owner_to_timeline_media.count;

	document.getElementById("ProfilePicURL").value = graphql.user.profile_pic_url;
	document.getElementById("ThumbnailSrc0").value = graphql.user.edge_owner_to_timeline_media.edges[0].node.thumbnail_src;
	document.getElementById("ThumbnailSrc1").value = graphql.user.edge_owner_to_timeline_media.edges[1].node.thumbnail_src;
	document.getElementById("ThumbnailSrc2").value = graphql.user.edge_owner_to_timeline_media.edges[2].node.thumbnail_src;
	document.getElementById("ThumbnailSrc3").value = graphql.user.edge_owner_to_timeline_media.edges[3].node.thumbnail_src;
	document.getElementById("ThumbnailSrc4").value = graphql.user.edge_owner_to_timeline_media.edges[4].node.thumbnail_src;
	document.getElementById("ThumbnailSrc5").value = graphql.user.edge_owner_to_timeline_media.edges[5].node.thumbnail_src;

	document.getElementById("button").disabled = false;
}