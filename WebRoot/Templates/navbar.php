<?php
	$sections = [
		//'/admin/statistics' => ['Statistics', 'chart-bar.svg'],
		'/admin/companies'  => ['Companies', 'company.svg'],
		//'/admin/users'      => ['Users', 'users.svg'],
		'/admin/tags'       => ['Tags', 'tag.svg'],
		//'/admin/categories' => ['Categories', 'label.svg'],
		'/admin/database'   => ['Database', 'dns.svg']
	];
?>
<section class="navbar-box" id="navbar">
	<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
	<section>
		<?php if ($url =='/'): ?>
			<h2><?php echo TEXT[13] ?></h2>
			<p><?php echo TEXT[9] ?></p>
		<?php elseif($user->isLogin()): ?>
			<h2><?php echo $_SESSION['Name'] ?></h2>
			<a href="/?logout">
				<div class="icon-label-h">
					<img src="/static/icon/gray/close.svg" alt="">
					Logout
				</div>
			</a>
		<?php endif ?>
	</section>
	<hr>
	<section>
		<?php if ($url =='/'): ?>
			<h3><?php echo TEXT[11] ?></h3>
			<ul>
				<li>
					<a class="icon-label-h" href="mailto:jonathan@wuwana.com">
						<img src="/static/icon/gray/email.svg" alt="">
						Email
					</a>
				</li>
			</ul>
		<?php else: ?>
			<h3>Admin controls</h3>
			<?php foreach ($sections as $sectionURL => $section): ?>
				<?php if ($url != $sectionURL) { echo '<a href="', $sectionURL, '">'; } ?>
				<div class="icon-label-h">
					<img src="/static/icon/gray/<?php echo $section[1] ?>" alt="">
					<?php echo $section[0] ?>
				</div>
				<?php if ($url != $sectionURL) { echo '</a>'; } ?>
			<?php endforeach ?>
		<?php endif ?>
	</section>
</section>
<?php if (strpos($url, '/admin') !== false): ?>
	<div id="version">Wuwana version 2.2.1</div>
<?php endif ?>
<div class="navbar-background" id="navbar-background" onclick="showNavbar()"></div>