<?php
	$sections = [
		'/admin/companies'  => ['Companies', 'company_grey50.svg'],
		'/admin/users'      => ['Users', 'users_grey50.svg'],
		'/admin/tags'       => ['Tags', 'tag_grey50.svg'],
		'/admin/categories' => ['Categories', 'label_grey50.svg'],
		'/admin/database'   => ['Database', 'dns_grey50.svg']
	];
?>
<div class="ColumnLeft">
	<div class="boxPanel">
		<div class="panelCover"><img src="/static/logo/ribbon-long.svg"></div>
		<h1>Administrator's name</h1>
		<a href=#>
			<div class="iconLabelHorizontal">
				<img src="/static/icon/close_grey50.svg">
				Logout
			</div>
		</a>
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

					echo '<div class="iconLabelHorizontal">';
					echo   '<img src="/static/icon/', $section[1], '">', $section[0];
					echo '</div>';

					if ($request != $sectionURL)
					{ echo '</a>'; }
				}
			?>
		</section>

	</div>
	<h2>Statistics</h2>
	<div>
		2 companies<br>
		4 users registered<br>
		1 users connected this week<br>
		2 users connected this month<br>
	</div>

</div>