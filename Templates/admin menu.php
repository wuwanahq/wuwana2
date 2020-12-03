<?php
	$sections = [
		'Companies'   => '/admin/companies',
		'Users'       => '/admin/users',
		'Tags'        => '/admin/tags',
		'Categories'  => '/admin/categories',
		'Import data' => '/admin/database',
		'Export data' => '/admin/database'];
?>
<div class="ColumnLeft">
	<div class="Box">
		<div class="AboutCover"><img src="/static/logo/ribbon.svg"></div>
		<p>Administrator</p>
		<ul>
			<li>Logout</li>
		</ul>
		<hr><br>
		Admin sections
		<ul>
			<?php
				foreach ($sections as $name => $url)
				{
					if (filter_input(INPUT_SERVER, 'REQUEST_URI') == $url)
					{ echo '<li>', $name, '</li>'; }
					else
					{ echo '<li><a href="', $url, '">', $name, '</a></li>'; }
				}
			?>
		</ul>
	</div>
	<section class="Sticky" id="menu">
		<h2>Statistics</h2>
		<div class="Box Filter">
			2 companies<br>
			4 users registered<br>
			1 users connected this week<br>
			2 users connected this month<br>
		</div>
	</section>
</div>