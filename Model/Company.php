<?php

class Company
{
	const RANDOM_1ST_WORDS = ['Super', 'New', 'Good'];
	const RANDOM_2ND_WORDS = ['Familial', 'Wired', 'Tasty'];
	const RANDOM_3RD_WORDS = ['Coffee', 'Café', 'Roaster'];
	const RANDOM_DESCRIPTIONS = ['So goooood!', 'Made in Spain.', 'Torified with passion...'];
	const RANDOM_ICONS = ['rs', 'camden'];
	const REGIONS = [
		'Andalucia',
		'Aragon',
		'Canarias',
		'Cantabria',
		'Castilla y Leon',
		'Castilla-La Mancha',
		'Cantaluna',
		'Ceuta',
		'Comunidad de Madrid',
		'Comunidad Foral de Navarra',
		'Comunidad Valenciana',
		'Extremadura',
		'Galicia',
		'Islas Baleares',
		'La Rioja',
		'Melilla',
		'Pais Vasco',
		'Principado de Auturias',
		'Region de Murcia'
	];

	public $name;
	public $description;
	public $icon;
	public $region;

	static function getRandomCompany()
	{
		$company = new Company();
		$company->name =
			self::RANDOM_1ST_WORDS[rand(0,2)] . ' ' .
			self::RANDOM_2ND_WORDS[rand(0,2)] . ' ' .
			self::RANDOM_3RD_WORDS[rand(0,2)];

		$company->description = self::RANDOM_DESCRIPTIONS[rand(0,2)];
		$company->icon = self::RANDOM_ICONS[rand(0,1)];
		$company->region = self::REGIONS[rand(0,18)];

		return $company;
	}
}