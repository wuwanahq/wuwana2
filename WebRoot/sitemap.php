<?php 
header("Content-type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
	<loc>https://wuwana.com/</loc>
	<changefreq>daily</changefreq>
	<priority>1.0</priority>
</url>

<?php
// Dynamically generated sitemap for each company

$root = 'https://wuwana.com/';
$urls = array("permalink1", "permalink2", "permalink3");

foreach ($urls as $permalink) {
	echo '<url>';
	echo 	'<loc>' . $root . $permalink . '</loc>';
	echo	'<changefreq>weekly</changefreq>';
	echo '</url>';
}

?>
	
</urlset>