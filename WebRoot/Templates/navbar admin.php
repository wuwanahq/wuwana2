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
<div class="sticky" id="navbar">
	<section>
		<div class="box greeting-box">
			<div class="panel-ribbon">
				<img src="/static/logo/ribbon.svg" alt="">
			</div>
			<?php if($user->isLogin()): ?>
				<a href="/"><h2><?php echo $_SESSION['Name'] ?></h2></a>
				<br><hr>
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
							</div>
						</a>
					</li>
				</ul>
			<?php else: ?>
				<h2>🚨 <?php echo TEMP_TEXT[14] ?> 🚨</h2>
				<p><?php echo TEMP_TEXT[15] ?></p>
				<form method="post">
					<label for="email">
						<?php echo TEMP_TEXT[16] ?>
						<input id="email" type="email" name="email">
					</label>
					<label for="code">
						<?php echo TEMP_TEXT[17] ?>
						<input id="code" type="text" name="code" inputmode="tel" autocomplete="off">
					</label>
					<input class="button-main-new" type="submit" value="<?php echo TEMP_TEXT[18] ?>">
				</form>
			<?php endif ?>
		</div>
	</section>
	<?php if (isset($user) && $user->isLogin()): ?>
	<section>
		<h2><?php echo TEMP_TEXT[13] ?></h2>
		<div class="box">
			<ul class="ul-list">
				<li>
					<a href="/admin">
						<img class="icon" src="/static/icon/dashboard.svg" alt="">
						<div>
							Dashboard
							<img src="/static/icon/gray/chevron-right.svg" alt="">
						</div>
					</a>
				</li>
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
		</div>
	</section>
	<?php endif ?>
	<!-- <div id="version">Wuwana version 2.2.1</div> -->
</div>
<div class="navbar-background" id="navbar-background" onclick="toggleNavbar()"></div>