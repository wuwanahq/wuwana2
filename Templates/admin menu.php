<?php
	$sections = [
		'/admin/statistics' => ['Statistics', 'chart-bar_grey50.svg'],
		'/admin/companies'  => ['Companies', 'company_grey50.svg'],
		'/admin/users'      => ['Users', 'users_grey50.svg'],
		'/admin/tags'       => ['Tags', 'tag_grey50.svg'],
		'/admin/categories' => ['Categories', 'label_grey50.svg']
		// '/admin/database'   => ['Database', 'dns_grey50.svg']
	];
?>
<div class="column-left">
	<div class="boxPanel sticky">
		<div class="panelCover"><img src="/static/logo/ribbon-long.svg"></div>
		<section>
			<h1>Administrator's name</h1>
			<a href=#>
				<div class="icon-label-h">
					<img src="/static/icon/close_grey50.svg">
					Logout
				</div>
			</a>
		</section>
		<hr>
		<section class="adminControl">
			<h3>Admin controls</h3>
			<?php
				$request = substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 0, 11);
				foreach ($sections as $url => $section)
				{
					$sectionURL = substr($url, 0, 11);

					if ($request != $sectionURL)
					{ echo '<a href="', $url, '">'; }

					echo '<div class="icon-label-h">';
					echo   '<img src="/static/icon/', $section[1], '">', $section[0];
					echo '</div>';

					if ($request != $sectionURL)
					{ echo '</a>'; }
				}
			?>
			<br>
			<a href="/admin/database">
				<div class="icon-label-h">
					<img src="/static/icon/dns_grey50.svg">
					Database
				</div>
			</a>
		</section>
	</div>
</div>