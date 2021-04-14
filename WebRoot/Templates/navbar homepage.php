<div class="navbar-box" id="navbar">
	<div class="panel-ribbon">
		<img src="/static/logo/ribbon.svg" alt="">
	</div>
	<section>
	<?php if (isset($user) && $user->isLogin()): ?>
		<h2><?php echo $_SESSION['Name'] ?></h2>
		<ul class="ul-list">
			<li>
				<a href="/admin/companies">
					<img class="icon" src="/static/icon/slider.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[13] ?>
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
			<input class="button-main-new" type="submit" value="<?php echo TEMP_TEXT[18] ?>">
		</form>
	<?php else: ?>
		<h2><?php echo TEMP_TEXT[10] ?></h2>
		<p><?php echo TEMP_TEXT[8] ?></p>
		<br>
	<?php endif ?>
	</section>
	<!-- <section>
		<h3><?php echo TEMP_TEXT[9] ?></h3>
		<ul class="ul-list">
			<li>
				<a href="mailto:jonathan@wuwana.com">
					<img src="/static/icon/gray/email.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[16] ?>
						<img src="/static/icon/gray/open-in-new.svg" alt="">
					</div>
				</a>
			</li>
		</ul>
	</section> -->
</div>

<!--  Not Connected with JS -->

<!-- <section>
	<h2><?php echo TEMP_TEXT[3] ?></h2>
	<div class="box">
		<details class="details-list">
			<summary>
				<div>
					<img class="icon" src="/static/icon/language.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[19] ?>
						<img src="/static/icon/gray/chevron-down.svg" alt="">
					</div>
				</div>
			</summary>
			<ul>
				<?php
					foreach (WebApp\Language::CODES as $code => $lang)
					{ echo '<li><a href="', WebApp\WebApp::changeSubdomain($code), '">', $lang, '</a></li>'; }
				?>
			</ul>
		</details>
	</div>
</section> -->
	
<!-- <section>
	<h2>About Wuwana</h2>
	<div class="box" style="min-height: 80px;">
		<a href="/wuwana" class="card">
			<div class="logo-main">
				<img src="/static/logo/square0.svg">
			</div>
			<div class="company-card-info">
				<h3>Wuwana</h3>
				<ul>
					<li>Online Directory</li>
				</ul>
			</div>
		</a>
		<ul class="ul-list">
			<li>
				<a href="/privacy">
					<img class="icon" src="/static/icon/file.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[5] ?>
						<img src="/static/icon/gray/chevron-right.svg" alt="">
					</div>
				</a>
			</li>
			<li>
				<a href="https://github.com/wuwanahq/wuwana2" target=”_blank” rel="noopener">
					<img class="icon" src="/static/icon/github.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[6] ?>
						<img src="/static/icon/gray/open-in-new.svg" alt="">
					</div>
				</a>
			</li>
			<li>
				<a href="mailto:jonathan@wuwana.com">
					<img class="icon" src="/static/icon/email.svg" alt="">
					<div>
						<?php echo TEMP_TEXT[9] ?>
						<img src="/static/icon/gray/open-in-new.svg" alt="">
					</div>
				</a>
			</li>
		</ul>
	</div>
</section> -->

<div class="navbar-background" id="navbar-background" onclick="toggleNavbar()"></div>