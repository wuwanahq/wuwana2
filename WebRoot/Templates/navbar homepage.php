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
				<input id="code" type="text" name="code" inputmode="tel" autocomplete="off">
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
<div class="navbar-background" id="navbar-background" onclick="showNavbar()"></div>