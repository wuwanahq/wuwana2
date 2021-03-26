<?php
/**
 * Dynamically generated sitemap for each company.
 * Note: Google doesn't consume the <priority> attribute in sitemaps.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

$limit = 50000;  // Max number of URL
$root = WebApp\WebApp::getHostname();

header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>',
	'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
	'<url>',
	'<loc>', $root, '</loc>',
	'<changefreq>daily</changefreq>',
	'</url>';

foreach ((new DataAccess\Company())->selectAll() as $permalink => $company)
{
	if (--$limit == 0)
	{ break; }

	echo '<url>',
		'<loc>', $root, '/', $permalink, '</loc>',
		'<lastmod>', date('Y-m-d', $company->lastUpdate), '</lastmod>',
		'<changefreq>weekly</changefreq>',
		'</url>';
}

echo '</urlset>';