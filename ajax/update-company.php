<?php
/**
 * Handle the XmlHttpRequest to update a company.
 * @link https://wuwana.com/ajax/update-company.php
 */

ignore_user_abort(true);

if (filter_has_var(INPUT_POST, 'instagram'))
{
	$instagram = new DataAccess\SocialMediaData();
	$instagram->setPageURL(filter_input(INPUT_POST, 'instagram'), FILTER_SANITIZE_URL);
	$instagram->externalLink = filter_input(INPUT_POST, 'ExternalURL', FILTER_SANITIZE_URL);
	$instagram->setProfileName(filter_input(INPUT_POST, 'name'));
	$instagram->setBiography(filter_input(INPUT_POST, 'biography'));
	$instagram->nbPost = filter_input(INPUT_POST, 'posts', FILTER_SANITIZE_NUMBER_INT);
	$instagram->nbFollower = filter_input(INPUT_POST, 'followers', FILTER_SANITIZE_NUMBER_INT);
	$instagram->nbFollowing = filter_input(INPUT_POST, 'following', FILTER_SANITIZE_NUMBER_INT);

	for ($i=0; filter_has_var(INPUT_POST, 'ThumbnailSrc' . $i); ++$i)
	{ $instagram->pictures[] = filter_input(INPUT_POST, 'ThumbnailSrc' . $i); }

	$scraper = new Scraper\Scraper(WebApp\Data::getTag(), WebApp\Data::getCompany(), WebApp\Data::getSocialMedia());
	$scraper->updateCompany(
		filter_input(INPUT_POST, 'website', FILTER_SANITIZE_URL),
		filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
		filter_input(INPUT_POST, 'ProfilePicURL'),
		filter_input(INPUT_POST, 'ExtraInfo'),
		$instagram);
}