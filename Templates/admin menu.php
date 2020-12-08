<?php
	$sections = [
		'Companies'   => '/admin/companies',
		'Users'       => '/admin/users',
		'Tags'        => '/admin/tags',
		'Categories'  => '/admin/categories',
		'Database' => '/admin/database'];

	$icons = [
		'Companies'   => 'company_grey50.svg',
		'Users'       => 'users_grey50.svg',
		'Tags'        => 'tag_grey50.svg',
		'Categories'  => 'label_grey50.svg',
		'Database'		=> 'dns_grey50.svg'];
?>
<div class="ColumnLeft">
	<div class="boxPanel">
		<div class="panelCover"><img src="/static/logo/ribbon.svg"></div>
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
				foreach ($sections as $name => $url)
				{
					if (filter_input(INPUT_SERVER, 'REQUEST_URI') != $url)
					{
						echo '<a href="', $url, '">';
					}

					echo '<div class="iconLabelHorizontal">';
					echo  '<img src="/static/icon/', $icons[$name], '">';
					echo $name, '</div>';

					if (filter_input(INPUT_SERVER, 'REQUEST_URI') != $url)
					{
						echo '</a>';
					}
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