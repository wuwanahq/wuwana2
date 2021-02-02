<?php

$url = 'https://camdencoffeeroasters.com';

// Shared variables
$dom = new DOMDocument();
$noScrape = ['facebook.com', 'linktr.ee']; // Websites to avoid
$pages = ['contacto', 'contact', 'privacy']; // Pages to scrape
$bodyTexts = ''; // Text of the company

// Get base website
$urlHost = getWebsiteBase($url);

// Decide to scrape or not 
if (in_array($urlHost, $noScrape)) {
	return '';
} else {
	$url = 'http://' . $urlHost; // Create homepage url
	$html = file_get_contents($url);  // Download the HTML page
	
	// Scrape homepage
	@$dom->loadHTML($html);
	getWebsiteDescription($dom); // Get website description
	$bodyTexts = $bodyTexts . getBodyTexts($dom); // Get texts from body
	
	// Scrape other pages
	foreach ($pages as &$page) {
		$newURL = $url . '/' . $page; // Create url to scrape
		
		// Verify if it is a valid website
		$file_headers = @get_headers($newURL);
		if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found')
		{
			// do nothing
		} 
		else 
		{
			$html = file_get_contents($newURL);
			@$dom->loadHTML($html);
			$bodyTexts = $bodyTexts . getBodyTexts($dom); // Get texts from body
		}
	}
}

$emails = getEmails($bodyTexts);
$numbersES = getNumbersES($bodyTexts);
$phonesES = getPhonesES($numbersES);
$mobilesES = getMobilesES($numbersES);
$postalCodeES = getPostalCodeES($bodyTexts);

/**
 * Get website base url
 * @param string $url
 * @return string $urlHost
 */
function getWebsiteBase($url) {
	if (strpos($url, '://') > 0){
		$urlHost = parse_url($url, PHP_URL_HOST);
	} else {
		$urlHost = parse_url('http://' . $url, PHP_URL_HOST); //PHP_URL_HOST does not work without 'http://' 
	}

	return $urlHost;
}

/**
 * Get the website description.
 * @param $dom 
 * @return string
 */
function getWebsiteDescription($dom)
{
	$metaTags = [];

	foreach ($dom->getElementsByTagName('meta') as $meta)
	{
		if ($meta->hasAttribute('property'))
		{ $metaTags[strtolower($meta->getAttribute('property'))] = trim($meta->getAttribute('content')); }
		elseif ($meta->hasAttribute('name'))
		{ $metaTags[strtolower($meta->getAttribute('name'))] = trim($meta->getAttribute('content')); }
	}

	foreach (['description', 'og:description', 'twitter:description'] as $attribute)
	{
		if (!empty($metaTags[$attribute]))
		{ return $metaTags[$attribute]; }
	}

	// If there were no description available maybe we can use the page title...
	$title = $dom->getElementsByTagName('title')->item(0);

	if ($title != null && !empty($title->nodeValue))
	{ return trim($title->nodeValue); }

	if (!empty($metaTags['og:title']))
	{ return $metaTags['og:title']; }

	if (!empty($metaTags['twitter:title']))
	{ return $metaTags['twitter:title']; }

	return '';
}

/**
 * Get the text between <body></body>
 * @param $dom 
 * @return string $bodyTexts
 */
function getBodyTexts($dom)
{
	// Remove script tags
	// https://stackoverflow.com/questions/7130867/remove-script-tag-from-html-content

	$script = $dom->getElementsByTagName('script');

	$remove = [];
	foreach($script as $item) {
		$remove[] = $item;
	}

	foreach ($remove as $item) {
		$item->parentNode->removeChild($item); 
	}

	foreach ($dom->getElementsByTagName('body') as $body) {
		// Get the body text and add it as a string
		$bodyTexts = $body->textContent . ' ';
	}

	return $bodyTexts;
}

/**
 * Find emails
 * @param string $texts
 * @return array $emails
 * 
 * Limitation:
 * - Does not find email inside <a>
 * 
 * TO DO:
 * - Bug: Array ( [0] => info@rightsidecoffee.comTel )
 */
function getEmails($texts)
{
	// Pattern By Eugene Kudashev
	// https://anchor.fm/slashcircumflex/episodes/a-zA-Z0-9-_-a-zA-Z0-9---a-zA-Z2-6-enq826

	$patternEmail = '/[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6}/';
	preg_match_all($patternEmail, $texts, $emails);
	$emails = array_values(array_unique($emails[0])); // Remove duplicate emails

	return $emails[0];
}

/**
 * Find Spanish phone numbers
 * @param string 
 * @return string $numbersES
 * 
 * Resource:
 * https://en.wikipedia.org/wiki/Telephone_numbers_in_Spain
 * Country calling code: +34 or 0034
 * Number of digits: 9 digits
 */
function getNumbersES($texts)
{
	// Spain calling Code
	$callingCodeES = '+34';
	$callingCodeES2 = "0034";
	$patternNumberES = '/(?:([+]|00)34(.)?)?(6|9)[0-9]{1,}.[0-9]{1,}.[0-9]{1,}.[0-9]{1,}(.[0-9]{1,})?/'; // Look for a Spanish phone number

	// Find phone number & sanitize results
	preg_match_all($patternNumberES, $texts, $numbersES);
	$numbersES = array_values(array_unique($numbersES[0])); // Remove duplicates
	$eliminate = ['.', ' ', '-']; // Characters to be replaced
	$numbersES = str_replace($eliminate, '', $numbersES); // Remove special characters

	// Standardize numbers
	foreach ($numbersES as &$number) {
		if (substr($number, 0, 3) === $callingCodeES) { // Check for "+34" in string 
			$number = $number;
		} elseif (substr($number, 0, 4) === $callingCodeES2) { // Replace "0034" with "+34"
			$number = str_replace($callingCodeES2, $callingCodeES, substr($number, 0, 4)) . substr($number, 4, 9); 
		} else {
			$number = $callingCodeES . $number; // Add "+34" to mobile number
		}
	}

	//Turn array into string
	$numbersES = implode('; ', $numbersES);

	return $numbersES;
}

/**
 * Find Spanish mobile numbers
 * @param string $numbersES
 * @return array $mobilesES
 */
function getMobilesES($texts)
{
	$patternMobileES = '/[+]34(6|7)[0-9]{8}/';

	preg_match_all($patternMobileES, $texts, $mobilesES); // Find Spanish mobile number
	return $mobilesES[0];
}

/**
 * Find Spanish landline numbers
 * @param string $numbersES
 * @return array $phonesES
 */
function getPhonesES($texts)
{
	$patternPhoneES = '/[+]349[0-9]{8}/';

	preg_match_all($patternPhoneES, $texts, $phonesES); // Find Spanish landline number
	return $phonesES[0];
}

/**
 * Find Spanish postal code
 * @param string $texts
 * @return array $postalCodeES
 * https://en.wikipedia.org/wiki/List_of_postal_codes_in_Spain
 * 5 digits
 * Range [03000 - 52081]
 */
function getPostalCodeES($texts) {
	$patternPostalCodeES = '/\b[0-5][0-9]{4}\b/';

	preg_match_all($patternPostalCodeES, $texts, $onlyDigits);
	$postalCodeES = array_values(array_unique($onlyDigits[0]));

	return $postalCodeES;

}