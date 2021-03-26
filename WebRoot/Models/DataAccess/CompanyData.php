<?php
namespace DataAccess;

/**
 * Data object representing company info.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class CompanyData
{
	public $name;
	public $logo = '';
	public $description = '';
	public $website = '';
	public $email = '';
	public $phone = '0000000000';
	public $address = '';
	public $region = 'ES';
	public $visibleTags = [];
	public $otherTags;
	public $instagram;
	public $facebook;
	public $lastUpdate;
	public $postalCode;

	/**
	 * Clean the name by removing emoji and special characters then store it.
	 * @param string $name
	 */
	public function setName($name)
	{
		// Remove invisible characters and emoji:
		// - between 1F000 and 1F0FF there is only game symbols
		// - between 1F300 and 1FBFF there is no alphabetic or language writing symbol, enclosed...
		// - between E0000 and E007D there is the mysterious Tags code block
		// - between 1F1E6 and 1F1FF there are flags
		$this->name = preg_replace(
			'/[\r|\n|\t|\v|\f|\e|\x{1F000}-\x{1F0FF}|\x{1F300}-\x{1FBFF}|\x{E0000}-\x{E007D}|\x{1F1E6}-\x{1F1FF}]/u',
			' ', $name);

		// Transform Unicode Dingbats (circled and squared capital letters)

		$letters =
			['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

		$this->name = str_replace(['🅰','🅱','🅲','🅳','🅴','🅵','🅶','🅷','🅸','🅹','🅺','🅻','🅼',
			'🅽','🅾','🅿','🆀','🆁','🆂','🆃','🆄','🆅','🆆','🆇','🆈','🆉'], $letters, $this->name);

		$this->name = str_replace(['🄰','🄱','🄲','🄳','🄴','🄵','🄶','🄷','🄸','🄹','🄺','🄻','🄼'
			,'🄽','🄾','🄿','🅀','🅁','🅂','🅃','🅄','🅅','🅆','🅇','🅈','🅉'], $letters, $this->name);

		$this->name = str_replace(['🅐','🅑','🅒','🅓','🅔','🅕','🅖','🅗','🅘','🅙','🅚','🅛','🅜',
			'🅝','🅞','🅟','🅠','🅡','🅢','🅣','🅨','🅤','🅥','🅦','🅧','🅨','🅩'], $letters, $this->name);

		$this->name = str_replace(['Ⓐ','Ⓑ','Ⓒ','Ⓓ','Ⓔ','Ⓕ','Ⓖ','Ⓗ','Ⓘ','Ⓙ','Ⓚ','Ⓛ','Ⓜ',
			'Ⓝ','Ⓞ','Ⓟ','Ⓠ','Ⓡ','Ⓢ','Ⓣ','Ⓨ','Ⓤ','Ⓥ','Ⓦ','Ⓧ','Ⓨ','Ⓩ'], $letters, $this->name);

		$this->name = str_replace(
			['ⓐ','ⓑ','ⓒ','ⓓ','ⓔ','ⓕ','ⓖ','ⓗ','ⓘ','ⓙ','ⓚ','ⓛ','ⓜ','ⓝ','ⓞ','ⓟ','ⓠ','ⓡ',
				'ⓢ','ⓣ','ⓤ','ⓥ','ⓦ','ⓧ','ⓨ','ⓩ','①','②','③','④','⑤','⑥','⑦','⑧','⑨'],
			['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r',
				's','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9'],
			$this->name);

		// Remove all useless spaces
		do
		{
			$length = strlen($this->name);
			$this->name = str_replace('  ', ' ', $this->name);
		}
		while (strlen($this->name) < $length);

		$this->name = trim($this->name);
	}

	public function setWebsite($url)
	{
		if (substr($url, 0, 4) != 'http')
		{ $url = 'http://' . $url; }

		if (filter_var($url, FILTER_VALIDATE_URL) != false)
		{ $this->website = rtrim($url, '/'); }
	}

	/**
	 * Generate the default permanent like.
	 * @return string
	 */
	public function getDefaultPermalink()
	{
		$permalink = preg_replace('/[^a-z0-9\-]/', '-', strtolower($this->name));

		// Remove all useless dashes
		do
		{
			$length = strlen($permalink);
			$permalink = str_replace('--', '-', $permalink);
		}
		while (strlen($permalink) < $length);

		$permalink = trim($permalink, '-');

		if (strlen($permalink) < 3 && $this->instagram instanceof SocialMediaData)
		{ $permalink = $this->instagram->getUsername(); }

		return $permalink;
	}
}