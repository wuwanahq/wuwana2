<?php
namespace WebApp;

/**
 * Language.
 * @property-read string $code Current language code (ISO 639-1)
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */
class Language
{
	/**
	 * Available languages.
	 */
	const CODES = [
		'en' => 'English',
		'es' => 'Español',
		'fr' => 'Français',
		'zh' => '中文'];

	private $code;

	public function __get($property)
	{
		if ($property == 'code')
		{ return $this->code; }

		trigger_error('Undefined property ' . $property, E_USER_ERROR);
	}

	/**
	 * Constructor.
	 * @param string $code Language code (ISO 639-1)
	 */
	public function __construct($code)
	{
		$this->code = isset(self::CODES[$code]) ? $code : 'en';
		date_default_timezone_set('UTC');
	}

	/**
	 * Format a number according to the current language.
	 * @param int|float $number
	 * @param int $decimal
	 * @return string
	 */
	public function formatNumber($number, $decimal = 0)
	{
		switch ($this->code)
		{
			case 'en': return number_format($number, $decimal, '.', ',');
			case 'es': return number_format($number, $decimal, ',', '.');
			case 'fr': return number_format($number, $decimal, ',', ' ');
			case 'zh': return number_format($number, $decimal, '.', '');
			case 'ja': return number_format($number, $decimal, '', ',');
		}

		return $number;
	}

	/**
	 * Format an abbreviated number with "k" for thousand or "M" for million.
	 * @param int $number
	 * @return string
	 */
	public function formatShortNumber($number)
	{
		if ($number >= 1000000)
		{ return $this->formatNumber($number / 1000000, 1) . 'M'; }

		if ($number >= 10000)
		{ return $this->formatNumber($number / 1000, 1) . 'k'; }

		return $this->formatNumber($number);
	}

	/**
	 * Format a timestamp to a date and avoid time zone problem.
	 * @param int $timestamp
	 * @return string
	 */
	public function formatDate($timestamp)
	{
		$interval = time() - $timestamp;

		if ($interval < 2)  // minimum interval
		{ $interval = 2; }

		if ($interval <= 90)  // seconds
		{
			switch ($this->code)
			{
				case 'es': return 'hace ' . $interval . ' segundos';
				case 'fr': return 'il y a ' . $interval . ' secondes';
				case 'zh': return $interval . '秒前';
				case 'ja': return $interval . '秒前';
			}

			return $interval . ' seconds ago';
		}

		if ($interval <= 5400)  // 90 minutes
		{
			switch ($this->code)
			{
				case 'es': return 'hace ' . round($interval / 60) . ' minutos';
				case 'fr': return 'il y a ' . round($interval / 60) . ' minutes';
				case 'zh': return round($interval / 60) . '分钟前';
				case 'ja': return round($interval / 60) . '分前';
			}

			return round($interval / 60) . ' minutes ago';
		}

		if ($interval <= 82800)  // 23 hours
		{
			switch ($this->code)
			{
				case 'es': return 'hace ' . round($interval / 3600) . ' horas';
				case 'fr': return 'il y a ' . round($interval / 3600) . ' heures';
				case 'zh': return round($interval / 3600) . '小时前';
				case 'ja': return round($interval / 3600) . '時間前';
			}

			return round($interval / 3600) . ' hours ago';
		}

		switch ($this->code)
		{
			case 'es': $months = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic']; break;
			case 'fr': $months = ['jan','fév','mar','avr','mai','juin','juil','aoû','sep','oct','nov','déc']; break;
			case 'zh':
			case 'ja': return date('Y年n月j日', $timestamp);
			default: return date('M j, Y', $timestamp);
		}

		return str_replace(
			['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			$months, date('j M Y', $timestamp)
		);
	}
}