<?php
/**
 * To run this script open the Terminal in this folder then type:
 * php testWebsiteCrawler.php
 */

require 'WebsiteCrawler.php';

$timer = microtime(true);
$webCrawler = new Scraper\WebsiteCrawler();  // instanciate the object

// Crawl a website automatically
$webCrawler->crawlWebsite('https://cervezacastrena.com');

// Crawl a specific path
//$webCrawler->scrapePage('https://cervezacastrena.com/contactanos');
//$webCrawler->scrapePage('http://camdencoffeeroasters.com');
//$webCrawler->scrapePage('http://camdencoffeeroasters.com/tienda');
//$webCrawler->scrapePage('https://camdencoffeeroasters.com/contacto');
//$webCrawler->scrapePage('https://wuwana.com/error-page');

// Display result from the object properties
echo 'WEBSITE CRAWLER', PHP_EOL, PHP_EOL;
echo 'Description: ', $webCrawler->description, PHP_EOL;
echo 'Address: ', $webCrawler->address, PHP_EOL;
echo 'Postal code: ', $webCrawler->postalCode, PHP_EOL;
echo 'Phone number: ', $webCrawler->phoneNumber, PHP_EOL;
echo 'Mobile number: ', $webCrawler->mobileNumber, PHP_EOL;
echo 'Extra text: ', $webCrawler->extraText, PHP_EOL;
echo 'Email addresses: ';
print_r($webCrawler->emailAddresses);

echo PHP_EOL, PHP_EOL, 'Elapsed time: ', microtime(true) - $timer, ' sec', PHP_EOL;