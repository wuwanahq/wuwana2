<?php
	$sections = [
		'/admin/statistics' => ['Statistics', 'chart-bar.svg'],
		'/admin/companies'  => ['Companies', 'company.svg'],
		'/admin/users'      => ['Users', 'users.svg'],
		'/admin/tags'       => ['Tags', 'tag.svg'],
		'/admin/categories' => ['Categories', 'label.svg'],
		'/admin/database'   => ['Database', 'dns.svg']
	];
?>
<section class="column-left">
	<div class="navbar-box" id="navbar-admin">
		<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
		<section>
			<h2>Administrator's name</h2>
			<a href="#">
				<div class="icon-label-h">
					<img src="/static/icon/gray/close.svg" alt="">
					Logout
				</div>
			</a>
		</section>
		<hr>
		<section class="admin-control">
			<h3>Admin controls</h3>
			<?php foreach ($sections as $sectionURL => $section): ?>
				<?php if ($url != $sectionURL) { echo '<a href="', $sectionURL, '">'; } ?>
				<div class="icon-label-h">
					<img src="/static/icon/gray/<?php echo $section[1] ?>" alt="">
					<?php echo $section[0] ?>
				</div>
				<?php if ($url != $sectionURL) { echo '</a>'; } ?>
			<?php endforeach ?>
		</section>
	</div>
	<div id="version">Wuwana v2.1.12</div>
	<div id="navbar-background" onclick="showNavbar()"></div>
</section>
