<?php
namespace WebApp;

/**
 * Visual components for user interfaces.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class ViewComponent
{
	/**
	 * Print companies card.
	 * @param array $companies
	 * @param boolean $addHorizontalLine Start with <hr> or not
	 */
	static function printCompanyCards($companies, $addHorizontalLine = false)
	{
		foreach ($companies as $permalink => $company)
		{
			if (!($company instanceof \DataAccess\CompanyData))
			{ continue; }

			if ($addHorizontalLine)
			{ echo '<hr>'; }

			printf(
				'<a class="card" href="/%s">
					<div class="logo-main">
						<img src="%s"
						onerror="replaceMultipleBrokenImgs()">
					</div>
					<div class="company-card-info">
						<h3>%s</h3>
						<ul><li>%s</li></ul>
						<div class="button-icon-small">
							<img src="/static/icon/tiny/map.svg" alt="">%s
						</div>
					</div>
				</a>',
				$permalink,
				$company->logo,
				$company->name,
				implode('</li><li>', array_slice($company->tags, 0, 2)),
				$company->region);

			$addHorizontalLine = true;
		}
	}
}