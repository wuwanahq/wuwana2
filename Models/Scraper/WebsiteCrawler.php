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
	const PAGES = ['contacto', 'contact', 'contactanos'];  // Pages to scrape
	const BLOCKED_WEBSITES = [
		'facebook.com',
		'linktr.ee',
		'pinterest.com',
		'nokuesapp.com',
		'abc.es',
		'google',  // google.* (google.com, google.es...)
		'traveler.es',
		'sprudge.com',
		'girlygirlmagazine.com',
		'alicanteplaza.es',
		'comerciosyempresasnavarras.com',
		'wa.me',
		'madridsecreto.co',
		'yelp.com'
	];

	private $description;
	private $address;
	private $postalCode;
	private $phoneNumber;
	private $mobileNumber;
	private $extraText;
	private $emailAddresses = [];

	/**
	 * Read-only property accessor.
	 */
	public function __get($property)
	{
		switch ($property)
		{
			case 'description': return $this->description;
			case 'address': return $this->address;
			case 'postalCode': return $this->postalCode;
			case 'phoneNumber': return $this->phoneNumber;
			case 'mobileNumber': return $this->mobileNumber;
			case 'extraText': return $this->extraText;
			case 'emailAddresses': return $this->emailAddresses;
		}

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	/**
	 * Automatically scrape website pages.
	 * @param string $url
	 */
	public function crawlWebsite($url)
	{
		// Scrape homepage
		$result = $this->scrapePage($url);

		if ($result == true)
		{
			foreach (self::PAGES as $page)
			{
				$this->scrapePage($url . '/' . $page);

				// Minimum info required to stop scraping
				if (!empty($this->description) && !empty($this->postalCode) && isset($this->emailAddresses[0]))
				{ break; }
			}
		}
	}

	/**
	 * Manually scrape a website page by page.
	 * @param string $url
	 * @return bool True on success else false
	 */
	public function scrapePage($url)
	{
		if ($this->isInvalidURL($url))
		{ return false; }

		$dom = $this->downloadDOM($url);

		// Verify if it's a valid website
		if ($dom == null || $dom->getElementsByTagName('body')->length == 0)
		{ return false; }

		if (empty($this->description))
		{
			$this->description =
				$this->getDescription($dom->getElementsByTagName('meta'), $dom->getElementsByTagName('title'));
		}

		$text = $dom->getElementsByTagName('body')->item(0)->textContent;

		if (empty($this->postalCode))
		{ $this->postalCode = $this->getPostalCodeES($text); }

		foreach ($this->getEmail($text) as $email)
		{ $this->emailAddresses[] = $email; }

		$this->emailAddresses = array_unique($this->emailAddresses);  // Remove duplicate emails

		$numbersES = $this->getNumbersES($text);

		if (empty($this->phoneNumber))
		{ $this->phoneNumber = $this->getPhoneES($numbersES); }

		if (empty($this->mobileNumber))
		{ $this->mobileNumber = $this->getMobileES($numbersES); }

		return true;
	}

	/**
	 * Check if the URL is invalid or blocked.
	 * @param string $url
	 * @return bool
	 */
	private function isInvalidURL($url)
	{
		// Check if the URL is valid
		if (filter_var($url, FILTER_VALIDATE_URL) == false)
		{ return true; }

		$domain = parse_url($url, PHP_URL_HOST);

		// Decide to scrape or not
		foreach (self::BLOCKED_WEBSITES as $website)
		{
			if (stripos($domain, $website) !== false)
			{ return true; }
		}

		return false;
	}

	/**
	 * Open the web page, parse the HTML to a DOM document and remove useless tags.
	 * @param string $url
	 * @return DOMDocument
	 */
	private function downloadDOM($url)
	{
		$html = file_get_contents($url);

		if ($html == false)  // if HTTP request failed (HTTP/1.1 404 Not Found)
		{ return null; }

		$dom = new DOMDocument();
		libxml_use_internal_errors(true);  // Mute warning with incorrect HTML syntax
		$dom->loadHTML($html);

		$scriptElements = [];

		foreach($dom->getElementsByTagName('script') as $item)
		{ $scriptElements[] = $item; }

		foreach ($scriptElements as $item)
		{ $item->parentNode->removeChild($item); }

		return $dom;
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
	 * @param string $text
	 * @see https://en.wikipedia.org/wiki/List_of_postal_codes_in_Spain
	 * @return string One Spanish postal code or empty
	 */
	private function getPostalCodeES($text)
	{
		preg_match('/\b[0-5][0-9]{4}\b/', $text, $postalCodeES);
		return isset($postalCodeES[0]) ? $postalCodeES[0] : '';
	}

	/**
	 * Find emails (Limitation: Does not find email inside <a mailto:>)
	 * @param string $text
	 * @return string[] Email addresses or empty array
	 */
	private function getEmail($text)
	{
		preg_match_all('/[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6}/', $text, $emails);
		return empty($emails[0]) ? [] : $emails[0];
	}

	/**
	 * Find Spanish phone numbers (country calling code: +34 or 0034 with 9 digits)
	 * @see https://en.wikipedia.org/wiki/Telephone_numbers_in_Spain
	 * @param string $text
	 * @return string
	 */
	private function getNumbersES($text)
	{
		// Spain calling Code
		$callingCodeES = '+34';
		$callingCodeES2 = '0034';

		// Look for a Spanish phone number
		$pattern = '/\b(?:([+]|00)34(.)?)?(6|9)[0-9]{1,}.[0-9]{1,}.[0-9]{1,}.[0-9]{1,}(.[0-9]{1,})?\b/';

		// Find phone number & sanitize results
		preg_match_all($pattern, $text, $numbersES);
		$numbersES = array_unique($numbersES[0]); // Remove duplicates
		$numbersES = str_replace(['.', ' ', '-'], '', $numbersES); // Remove special characters

		// Standardize numbers
		foreach ($numbersES as &$number)
		{
			if (substr($number, 0, 4) === $callingCodeES2)  // Replace "0034" with "+34"
			{ $number = $callingCodeES . substr($number, 4); }
			elseif (substr($number, 0, 3) !== $callingCodeES)
			{ $number = $callingCodeES . $number; }  // Add "+34" to mobile number
		}

		//Turn array into string
		return implode('; ', $numbersES);
	}

	/**
	 * Find Spanish mobile numbers.
	 * @param string $numbersES
	 * @return string
	 */
	private function getMobileES($numbersES)
	{
		preg_match('/[+]34(6|7)[0-9]{8}/', $numbersES, $mobilesES);  // Find Spanish mobile number
		return isset($mobilesES[0]) ? $mobilesES[0] : '';  // select the first number
	}

	/**
	 * Find Spanish landline numbers.
	 * @param string $numbersES
	 * @return string
	 */
	private function getPhoneES($numbersES)
	{
		preg_match('/[+]349[0-9]{8}/', $numbersES, $phoneNumbers);  // Find Spanish landline number
		return isset($phoneNumbers[0]) ? $phoneNumbers[0] : '';  // select the first number
	}
}