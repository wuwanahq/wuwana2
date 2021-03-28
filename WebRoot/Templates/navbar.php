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

<?php if (strpos($url, '/admin') !== false): ?>
<!-- Navbar for admin -->
<div class="sticky">
	<div class="navbar-box" id="navbar">
		<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
		<?php if($user->isLogin()): ?>
			<section>
				<h2><?php echo $_SESSION['Name'] ?></h2>
				<a href="/">
					<div class="icon-label-h">
						<img src="/static/icon/gray/home.svg" alt="">
						<?php echo TEMP_TEXT[11] ?>
					</div>
				</a>
				<a href="/?logout">
					<div class="icon-label-h">
						<img src="/static/icon/gray/close.svg" alt="">
						<?php echo TEMP_TEXT[12] ?>
					</div>
				</a>
			</section>
			<hr>
			<section>
				<h3><?php echo TEMP_TEXT[13] ?></h3>
				<?php foreach ($sections as $sectionURL => $section): ?>
					<?php if ($url != $sectionURL) { echo '<a href="', $sectionURL, '">'; } ?>
					<div class="icon-label-h">
						<img src="/static/icon/gray/<?php echo $section[1] ?>" alt="">
						<?php echo $section[0] ?>
					</div>
					<?php if ($url != $sectionURL) { echo '</a>'; } ?>
				<?php endforeach ?>
			</section>
		<?php else: ?>
			<section>
				<h2>🚨 <?php echo TEMP_TEXT[14] ?> 🚨</h2>
				<p><?php echo TEMP_TEXT[15] ?></p>
				<form method="post">
					<div class="form-layout-column">
						<label for="email"><?php echo TEMP_TEXT[16] ?></label>
						<input id="email" type="email" name="email">
					</div>
					<div class="form-layout-column">
						<label for="code"><?php echo TEMP_TEXT[17] ?></label>
						<input id="code" type="text" name="code" inputmode="tel">
					</div>
					<input class="button-second" type="submit" value="<?php echo TEMP_TEXT[18] ?>">
				</form>
			</section>
		<?php endif ?>
	</div>
	<div id="version">Wuwana version 2.2</div>
</div>

<?php else: ?>
	<!-- Navbar for the homepage -->
	<div class="navbar-box" id="navbar">
		<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
		<section>
		<?php if (isset($user) && $user->isLogin()): ?>
			<h2><?php echo $_SESSION['Name'] ?></h2>
			<a href="/admin/companies">
				<div class="icon-label-h">
					<img src="/static/icon/gray/slider.svg" alt="">
					<?php echo TEMP_TEXT[18] ?>
				</div>
			</a>
			<a href="/?logout">
				<div class="icon-label-h">
					<img src="/static/icon/gray/close.svg" alt="">
					<?php echo TEMP_TEXT[12] ?>
				</div>
			</a>
		<?php elseif (filter_has_var(INPUT_GET, 'login')): ?>
			<form method="post">
				<div class="form-layout-column">
					<label for="email"><?php echo TEMP_TEXT[16] ?></label>
					<input id="email" type="email" name="email">
				</div>
				<div class="form-layout-column">
					<label for="code"><?php echo TEMP_TEXT[17] ?></label>
					<input id="code" type="text" name="code" inputmode="tel">
				</div>
				<input class="button-second" type="submit"
				value="<?php echo TEMP_TEXT[19] ?>">
			</form>
		<?php else: ?>
			<h2><?php echo TEMP_TEXT[10] ?></h2>
			<p><?php echo TEMP_TEXT[8] ?></p>
		<?php endif ?>
		</section>
		<hr>
		<section>
			<h3><?php echo TEMP_TEXT[9] ?></h3>
			<ul>
				<li>
					<a class="icon-label-h" href="mailto:jonathan@wuwana.com">
						<img src="/static/icon/gray/email.svg" alt="">
						<?php echo TEMP_TEXT[16] ?>
					</a>
				</li>
			</ul>
		</section>
	</div>
<?php endif ?>
<div class="navbar-background" id="navbar-background" onclick="showNavbar()"></div>