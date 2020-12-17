<?php
/**
 * Controller for the admin page.
 * @link https://wuwana.com/admin/companies
 */

spl_autoload_register(function($className) {
	require '../../Models/' . str_replace('\\', '/', $className) . '.php';
});

$user = new WebApp\UserSession(WebApp\Data::getUser());

if (/* $user->isAdmin() && */ filter_has_var(INPUT_POST, 'instagram'))
{
	$instagram = new DataAccess\SocialMediaObject();
	$instagram->url = filter_input(INPUT_POST, 'instagram');
	$instagram->link = filter_input(INPUT_POST, 'ExternalURL');
	$instagram->profileName = filter_input(INPUT_POST, 'FullName');
	$instagram->biography = filter_input(INPUT_POST, 'Biography');
	$instagram->nbPost = filter_input(INPUT_POST, 'PostCount');
	$instagram->nbFollower = filter_input(INPUT_POST, 'FollowerCount');
	$instagram->nbFollowing = filter_input(INPUT_POST, 'FollowingCount');

	for ($i=0; filter_has_var(INPUT_POST, 'ThumbnailSrc' . $i); ++$i)
	{ $instagram->pictures[] = filter_input(INPUT_POST, 'ThumbnailSrc' . $i); }

	$scraper = new Scraper\Scraper(WebApp\Data::getTag(), WebApp\Data::getCompany());
	$scraper->storeCompany(
		filter_input(INPUT_POST, 'website'),
		filter_input(INPUT_POST, 'email'),
		filter_input(INPUT_POST, 'BusinessEmail'),
		filter_input(INPUT_POST, 'ProfilePicURL'),
		$instagram);
}

//TODO: create CompaniesIterator
$companies = WebApp\Data::getCompany()->selectAll();

$language = WebApp\WebApp::getLanguageCode();
require '../../Templates/text ' . $language . '.php';
//require 'text ' . $language . '.php';
require 'view.php';