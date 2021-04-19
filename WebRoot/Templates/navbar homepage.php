<div id="navbar" class="sticky">
	<section>
		<div class="box greeting-box">
			<div class="panel-ribbon">
				<img src="/static/logo/ribbon.svg" alt="">
			</div>
			<?php if (isset($user) && $user->isLogin()): ?>
			<section>
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
			</section>
			<?php elseif (filter_has_var(INPUT_GET, 'login')): ?>
			<section>
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
			<?php else: ?>
			<section class="greeting-section-default">
				<h2><?php echo TEMP_TEXT[10] ?></h2>
				<p><?php echo TEMP_TEXT[8] ?></p>
				<div>
					<a class="button-main-new" href="/">
						<?php echo TEMP_TEXT[11] ?>
					</a> 
				</div>
			</section>
			<?php endif ?>
		</div>
	</section>

	<section>
		<h2><?php echo TEMP_TEXT[3] ?></h2>
		<div class="box">
			<ul class="ul-list">
				<li>
					<div onclick="lightMode()">
						<img class="icon" src="/static/icon/sun.svg" alt="">
						<div>
							<?php echo TEMP_TEXT[22] ?>
							<img src="/static/icon/gray/chevron-right.svg" alt="">
						</div>
					</div>
				</li>
				<li>
					<div onclick="darkMode()">
						<img class="icon" src="/static/icon/moon.svg" alt="">
						<div>
							<?php echo TEMP_TEXT[23] ?>
							<img src="/static/icon/gray/chevron-right.svg" alt="">
						</div>
					</div>
				</li>
			</ul>
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
	</section>
	
	<section>
		<h2><?php echo TEMP_TEXT[4] ?></h2>
		<div class="box" style="min-height: 80px;">
			<a href="/wuwana" class="card">
				<div class="logo-main">
					<img src="/static/logo/square0.svg">
				</div>
				<div class="company-card-info">
					<h3>Wuwana</h3>
					<ul>
						<li><?php echo TEMP_TEXT[20] ?></li>
					</ul>
				</div>
			</a>
			<hr>
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
	</section>
</div>
<div id="navbar-background" onclick="toggleNavbar()"></div>