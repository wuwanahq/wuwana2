<?php
	$sections = [
		'/admin/statistics' => ['Statistics', 'chart-bar_grey50.svg'],
		'/admin/companies'  => ['Companies', 'company_grey50.svg'],
		'/admin/users'      => ['Users', 'users_grey50.svg'],
		'/admin/tags'       => ['Tags', 'tag_grey50.svg'],
		'/admin/categories' => ['Categories', 'label_grey50.svg'],
		'/admin/database'   => ['Database', 'dns_grey50.svg']
	];
?>
<div class="column-left">
	<div class="box-panel">
		<div class="panel-cover"><img src="/static/logo/ribbon-long.svg"></div>
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
		<section class="admin-control">
			<h3>Admin controls</h3>
			<?php
				foreach ($sections as $sectionURL => $section)
				{
					if ($url != $sectionURL)
					{ echo '<a href="', $sectionURL, '">'; }

					echo '<div class="icon-label-h">';
					echo   '<img src="/static/icon/', $section[1], '">', $section[0];
					echo '</div>';

					if ($url != $sectionURL)
					{ echo '</a>'; }
				}
			?>
		</section>
	</div>
	<div id="version">Wuwana v2.1.7</div>
</div>