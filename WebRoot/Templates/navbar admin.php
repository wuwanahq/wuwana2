<?php
	$sections = [
		//'/admin/stat' => ['Statistics', 'chart-bar.svg'],
		'/admin/companies' => ['Companies', 'company.svg'],
		//'/admin/users' => ['Users', 'users.svg'],
		'/admin/tags' => ['Tags', 'tag.svg'],
		'/admin/database' => ['Database', 'dns.svg'],
		'/admin/settings' => ['Settings', 'slider.svg']
	];
?>
<div class="sticky">
	<div class="navbar-box" id="navbar">
		<div class="panel-ribbon">
			<img src="/static/logo/ribbon.svg" alt="">
		</div>
		<?php if($user->isLogin()): ?>
			<section>
				<h2><?php echo $_SESSION['Name'] ?></h2>
				<ul class="ul-list">
					<li>
						<a href="/">
							<img class="icon" src="/static/icon/home.svg" alt="">
							<div>
								<?php echo TEMP_TEXT[11] ?>
								<img src="/static/icon/gray/chevron-right.svg" alt="">
							</div>
						</a>
					</li>
					<li>
						<a href="/?logout">
							<img class="icon" src="/static/icon/close.svg" alt="">
							<div>
								<?php echo TEMP_TEXT[12] ?>
								<img src="/static/icon/gray/chevron-right.svg" alt="">
							</div>
						</a>
					</li>
				</ul>
			</section>
			<section>
				<h3><?php echo TEMP_TEXT[13] ?></h3>
				<ul class="ul-list">
				<?php foreach ($sections as $sectionURL => $section): ?>
					<li>
						<a href="<?php echo $sectionURL; ?>">
							<img class="icon" src="/static/icon/<?php echo $section[1] ?>" alt="">
							<div>
								<?php echo $section[0] ?>
								<img src="/static/icon/gray/chevron-right.svg" alt="">
							</div>
						</a>
					</li>
				<?php endforeach ?>
				</ul>
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
						<input id="code" type="text" name="code" inputmode="tel" autocomplete="off">
					</div>
					<input class="button-main-new" type="submit" value="<?php echo TEMP_TEXT[18] ?>">
				</form>
			</section>
		<?php endif ?>
	</div>
	<div id="version">Wuwana version 2.2.1</div>
</div>
<div class="navbar-background" id="navbar-background" onclick="toggleNavbar()"></div>