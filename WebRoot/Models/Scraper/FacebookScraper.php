<?php

/**
 * Facebook Rating Scraper
 * TO DO: Verify if facebook.com/company/reviews exists before scraping
 */

// $url = 'https://www.facebook.com/CamdenCoffeeRoasters/reviews/';
// $url = 'https://www.facebook.com/RightSideCoffee';
$url = 'https://www.facebook.com/CamdenCoffeeRoasters';

$text = loadFacebookReviewPage($url);
$facebookRating = getFacebookRating($text);

print_r($facebookRating);


/**
 * Function to get the company faceboook review page
 * @param string $url
 * @return string
 */
function loadFacebookReviewPage($url)
{
	$review = '/reviews/';

	if (strpos($url, $review) == FALSE)
	{
		$url = $url . $review;
	}

	// Get Facebook DOM
	$options = array(
		'http'=>array(
		  'method'=>"GET",
		  'header'=>"Accept-language: en\r\n" .
					"Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
					"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
		)
	);
	$context = stream_context_create($options);
	$html = file_get_contents($url, false, $context);

	$dom = new DOMDocument();
	$dom->loadHTML($html); 

	$text = $dom->textContent;
	return $text;
}

/**
 * Function to output facebook rating
 * @param string $text
 * @param array
 */
function getFacebookRating($text) 
{
	$start = strpos($text, '"ratingValue');
	$end = strpos($text, '}', $start) - $start;

	$rating = str_replace('"', '', substr($text, $start, $end));

	$facebookRating = explode(',', $rating);
	for ($i = 0; $i < count($facebookRating); $i++)
	{
		$facebookRating[$i] = explode(':', $facebookRating[$i]);
	}

	return $facebookRating;
}