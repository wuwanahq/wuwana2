<?php
/**
 * Controller for the admin page to manage companies.
 * @link https://wuwana.com/admin/companies
 */

if (/* $user->isAdmin() && */ filter_has_var(INPUT_POST, 'instagram'))
{
	$instagram = new DataAccess\SocialMediaObject();
	$instagram->url = filter_input(INPUT_POST, 'instagram');
	$instagram->link = filter_input(INPUT_POST, 'ExternalURL');
	$instagram->profileName = filter_input(INPUT_POST, 'name');
	$instagram->biography = filter_input(INPUT_POST, 'biography');
	$instagram->nbPost = filter_input(INPUT_POST, 'posts');
	$instagram->nbFollower = filter_input(INPUT_POST, 'followers');
	$instagram->nbFollowing = filter_input(INPUT_POST, 'following');

	for ($i=0; filter_has_var(INPUT_POST, 'ThumbnailSrc' . $i); ++$i)
	{ $instagram->pictures[] = filter_input(INPUT_POST, 'ThumbnailSrc' . $i); }

	$scraper = new Scraper\Scraper(WebApp\Data::getTag(), WebApp\Data::getCompany());
	$scraper->storeCompany(
		filter_input(INPUT_POST, 'website'),
		filter_input(INPUT_POST, 'email'),
		filter_input(INPUT_POST, 'ProfilePicURL'),
		filter_input(INPUT_POST, 'ExtraInfo'),
		$instagram);
}

//TODO: create CompanyIterator
$companies = WebApp\Data::getCompany()->selectAll();