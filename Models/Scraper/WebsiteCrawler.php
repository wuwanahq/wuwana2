<?php
namespace Scraper;
use DOMDocument;
use DOMNodeList;

/**
 * Web crawler that browses a website in order to find information.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class WebsiteCrawler
{
	const BLOCKED_WEBSITES = ['facebook.com', 'linktr.ee', 'pinterest.com', 'nokuesapp.com', 'abc.es', 'google.com', 'google.es', 'traveler.es', 'sprudge.com', 'girlygirlmagazine.com', 'alicanteplaza.es', 'comerciosyempresasnavarras.com', 'wa.me', 'madridsecreto.co', 'yelp.com'];
	const PAGES = ['contacto', 'contact'];  // Pages to scrape

	private $description;
	private $address;
	private $postalCode;
	private $phoneNumber;
	private $mobileNumber;
	private $extraText;
	private $emailAddresses;

	/**
	 * Scrape many pages.
	 * @param string $url
	 */
	public function crawlWebsite($url)
	{
		// Scrape homepage
		$this->scrapePage($url);

		foreach (self::PAGES as $page)
		{ $this->scrapePage($url . '/' . $page); }
	}

	/**
	 * Scrape one page.
	 * @param string $url
	 */
	public function scrapePage($url)
	{
		// Check if the URL is valid (and start by http...)
		if (filter_var($url, FILTER_VALIDATE_URL) == false)
		{ return; }

		// Decide to scrape or not
		if (in_array(strtolower(parse_url($url, PHP_URL_HOST)), self::BLOCKED_WEBSITES))
		{ return; }

		$dom = new DOMDocument();
		libxml_use_internal_errors(true);  // Mute possible warnings
		$dom->loadHTML(file_get_contents($url));  // Load the HTML page directly

		// Verify if it's a valid website
		if ($dom->getElementsByTagName('body')->length == 0)
		{ return; }

		if (empty($this->description))
		{
			$this->description =
				$this->getDescription($dom->getElementsByTagName('meta'), $dom->getElementsByTagName('title'));
		}

		foreach($dom->getElementsByTagName('script') as $item)
		{ $item->parentNode->removeChild($item); }

		$text = $dom->getElementsByTagName('body')->item(0)->textContent;

		$this->postalCode = getPostalCodeES($text);
		$this->emailAddresses = $this->getEmail($text);

		$numbersES = $this->getNumbersES($text);
		$this->phoneNumber = $this->getPhoneES($numbersES);
		$this->mobileNumber = $this->getMobileES($numbersES);
	}

	/**
	 * Get the website description.
	 * @param DOMNodeList $metaElements
	 * @param DOMNodeList $titleElements
	 * @return string
	 */
	private function getDescription(DOMNodeList $metaElements, DOMNodeList $titleElements)
	{
		$metaTags = [];

		foreach ($metaElements as $meta)
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
		$title = $titleElements->item(0);

		if ($title != null && !empty($title->nodeValue))
		{ return trim($title->nodeValue); }

		if (!empty($metaTags['og:title']))
		{ return trim($metaTags['og:title']); }

		if (!empty($metaTags['twitter:title']))
		{ return trim($metaTags['twitter:title']); }

		return '';
	}

	/**
	 * Find Spanish postal code with 5 digits (range 03000 - 52081)
	 * @param string $texts
	 * @see https://en.wikipedia.org/wiki/List_of_postal_codes_in_Spain
	 * @return array $postalCodeES
	 */
	private function getPostalCodeES($texts)
	{
		$patternPostalCodeES = '/\b[0-5][0-9]{4}\b/';

		preg_match_all($patternPostalCodeES, $texts, $postalCodeES);
		$postalCodeES = array_values(array_unique($postalCodeES[0]));

		return $postalCodeES[0];
	}

	/**
	 * Find emails (Limitation: Does not find email inside <a>)
	 * @param string $texts
	 * @return string $email
	 */
	private function getEmail($texts)
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
	 * @see https://en.wikipedia.org/wiki/Telephone_numbers_in_Spain
	 * Country calling code: +34 or 0034
	 * Number of digits: 9 digits
	 */
	private function getNumbersES($texts)
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
	 * Find Spanish mobile numbers.
	 * @param string $numbersES
	 * @return string
	 */
	private function getMobileES($texts)
	{
		$patternMobileES = '/[+]34(6|7)[0-9]{8}/';

		preg_match_all($patternMobileES, $texts, $mobilesES); // Find Spanish mobile number
		$mobilesES = $mobilesES[0];

		return $mobilesES[0]; // select the first number
	}

	/**
	 * Find Spanish landline numbers.
	 * @param string $numbersES
	 * @return string
	 */
	private function getPhoneES($texts)
	{
		$patternPhoneES = '/[+]349[0-9]{8}/';

		preg_match_all($patternPhoneES, $texts, $phonesES); // Find Spanish landline number
		$phonesES = $phonesES[0];

		return $phonesES[0]; // select the first number
	}
}