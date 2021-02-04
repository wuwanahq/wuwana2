<?php
/**
 * To run this script open the Terminal in this folder then type:
 * php testWebsiteCrawler.php
 */

require 'WebsiteCrawler.php';

$timer = microtime(true);
$webCrawler = new Scraper\WebsiteCrawler();

// URL to test
$webCrawler->crawlWebsite('https://camdencoffeeroasters.com');
//$webCrawler->crawlWebsite('https://camdencoffeeroasters.com/tienda/');

// Display result from the object properties
var_dump($webCrawler);
echo 'Elapsed time: ', microtime(true) - $timer, 's';