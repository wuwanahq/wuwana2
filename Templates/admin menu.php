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
<div class="column-left">
	<div class="box-panel">
		<div class="panel-cover"><img src="/static/logo/ribbon-long.svg" alt="wuwana ribbon logo"></div>
		<section>
			<h1>Administrator's name</h1>
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
	<div id="version">Wuwana v2.1.10</div>
</div>