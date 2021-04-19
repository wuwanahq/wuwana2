<?php

/**
 * Facebook Rating Scraper
 * 
 */

// $url = 'https://www.facebook.com/CamdenCoffeeRoasters/reviews/';
// $url = 'https://www.facebook.com/RightSideCoffee';
// $url = 'https://www.facebook.com/CamdenCoffeeRoasters';
// $url = 'https://www.facebook.com/IAMay-Coffee-1599173000317845';
$url = 'https://www.facebook.com/hansocafe/reviews';

$text = loadFacebookReviewPage($url);

$facebookRating = getFacebookRating($text);

$facebookUpdate = array();
array_push($facebookUpdate, 'lastUpdated', time());

array_push($facebookRating, $facebookUpdate);

print_r($facebookRating);
echo '<br><hr>' . date("Y/m/d", $facebookRating[2][1]) . '<hr>';


/**
 * Function to get the company faceboook review page
 * @param string $url
 * @return string
 */
function loadFacebookReviewPage($url)
{
	$review = '/reviews';

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
					// "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 11_2_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15\r\n"
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
	// Check if the company has any review on facebook
	if (strpos($text, 'Content Not Found') === 0)
	{
		return null;
	}

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