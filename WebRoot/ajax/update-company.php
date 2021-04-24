<?php
/**
 * Handle the XmlHttpRequest to update a company.
 * @link https://wuwana.com/ajax/update-company.php
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

spl_autoload_register(function($className) {
	require '../Models/' . str_replace('\\', '/', $className) . '.php';
});

ignore_user_abort(true);

$inputs = filter_input_array(INPUT_POST,
[
	'instagram'     => FILTER_VALIDATE_URL,
	'ExternalURL'   => FILTER_VALIDATE_URL,
	'name'          => FILTER_SANITIZE_STRING,
	'biography'     => FILTER_SANITIZE_STRING,
	'posts'         => FILTER_VALIDATE_INT,
	'followers'     => FILTER_VALIDATE_INT,
	'following'     => FILTER_VALIDATE_INT,
	'website'       => FILTER_VALIDATE_URL,
	'email'         => FILTER_VALIDATE_EMAIL,
	'ProfilePicURL' => FILTER_VALIDATE_URL,
	'ExtraInfo'     => FILTER_SANITIZE_STRING
]);

$inputs['name'] = $inputs['name'] == null ? '' : trim($inputs['name']);

if ($inputs['instagram'] != null && strpos($inputs['instagram'], 'https://www.instagram.com/') === 0
	&& strlen($inputs['name']) > 0
	&& $inputs['biography'] !== null
	&& $inputs['posts'] !== null && $inputs['posts'] !== false && $inputs['posts'] >= 0
	&& $inputs['followers'] !== null && $inputs['followers'] !== false && $inputs['followers'] >= 0
	&& $inputs['following'] !== null && $inputs['following'] !== false && $inputs['following'] >= 0)
{
	$instagram = new DataAccess\SocialMediaData();
	$instagram->setPageURL($inputs['instagram']);
	$instagram->setProfileName($inputs['name']);
	$instagram->setBiography($inputs['biography']);
	$instagram->nbPost = $inputs['posts'];
	$instagram->nbFollower = $inputs['followers'];
	$instagram->nbFollowing = $inputs['following'];

	if (!empty($inputs['ExternalURL']))
	{ $instagram->externalLink = $inputs['ExternalURL']; }

	for ($i=0; $i < 10; ++$i)
	{
		$input = filter_input(INPUT_POST, 'ThumbnailSrc' . $i, FILTER_VALIDATE_URL);

		if ($input == null)  // or false
		{ break; }

		$instagram->pictures[] = $input;
	}

	$scraper = new Scraper\Scraper(
		new DataAccess\Tag(),
		new DataAccess\Company(),
		new DataAccess\SocialMedia());

	$scraper->updateCompany(
		$inputs['website'],
		$inputs['email'],
		$inputs['ProfilePicURL'],
		$inputs['ExtraInfo'],
		$instagram);
}