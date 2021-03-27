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
					<div class="logo-main margin-r16">
						<img src="%s" alt="logo" onerror="setDefaultImg()">
					</div>
					<div class="company-card-wrapper">
						<div class="company-card-info">
							<h3>%s</h3>
							<ul><li>%s</li></ul>
							<div class="button-icon-small margin-t-auto">
								<img src="/static/icon/tiny/map.svg" alt="">%s
							</div>
						</div>
					</div>
				</a>',
				$permalink,
				$company->logo,
				$company->name,
				implode('</li><li>', $company->visibleTags),
				$company->region);

			/*
			<div class="company-card-info">
				<h3>...</h3>
				<ul class="tag-area">...</ul>
				...
			</div>
			<div class="company-card-badge-wrapper"></div>
			*/

			$addHorizontalLine = true;
		}
	}
}