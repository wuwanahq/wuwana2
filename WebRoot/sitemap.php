<?php

$connect = mysqli_connect("localhost", "root", "", "testing");
$query = "SELECT page_url FROM page";
$result = mysqli_query($connect, $query);
$base_url = "https://wuwana.com/";
$allCompanies = (new DataAccess\Company());

// Dynamic sitemap code

header("Conten-Type: application/xml; charset=uft-8");

echo '<? xml version="1.0" enconding="UFT-8" ?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

foreach ($companies as $permalink => $companies)
{
	echo '<url>' . PHP_EOL;
		echo '<loc>' . $base_url . $row["page_url"] . '/</loc>' . PHP_EOL;
		echo '<lastmod>' . 'date' . '</lastmod>' . PHP_EOL;
	echo '</url>' . PHP_EOL;
}

?>