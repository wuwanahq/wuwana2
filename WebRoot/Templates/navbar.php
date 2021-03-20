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
<div class="navbar-box" id="navbar">
	<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
	<?php if ($url =='/'): ?>
	<!-- Navbar for the homepage -->
		<section>
		<?php if (isset($user) && $user->isLogin()): ?>
			<h2><?php echo $_SESSION['Name'] ?></h2>
			<a href="/admin/companies">
				<div class="icon-label-h">
					<img src="/static/icon/gray/slider.svg" alt="">
					Admin page
				</div>
			</a>
			<a href="/?logout">
				<div class="icon-label-h">
					<img src="/static/icon/gray/close.svg" alt="">
					Logout
				</div>
			</a>
		<?php elseif (filter_has_var(INPUT_GET, 'login')): ?>
			<form method="post">
				<div class="form-layout-column">
					<label for="email">Email</label>
					<input id="email" type="email" name="email">
				</div>
				<div class="form-layout-column">
					<label for="code">Code</label>
					<input id="code" type="password" name="code" inputmode="tel">
				</div>
				<input class="button-second" type="submit" value="Access admin view">
			</form>
		<?php else: ?>
			<h2><?php echo TEXT[13] ?></h2>
			<p><?php echo TEXT[9] ?></p>
		<?php endif ?>
		</section>
		<hr>
		<section>
			<h3><?php echo TEXT[11] ?></h3>
			<ul>
				<li>
					<a class="icon-label-h" href="mailto:jonathan@wuwana.com">
						<img src="/static/icon/gray/email.svg" alt="">
						Email
					</a>
				</li>
			</ul>
		</section>
	</div>

	<?php elseif (strpos($url, '/admin') !== false): ?>
	<!-- Navbar for admin -->
		<?php if($user->isLogin()): ?>
		<section>
			<h2><?php echo $_SESSION['Name'] ?></h2>
			<a href="/">
				<div class="icon-label-h">
					<img src="/static/icon/gray/home.svg" alt="">
					Go back home
				</div>
			</a>
			<a href="/?logout">
				<div class="icon-label-h">
					<img src="/static/icon/gray/close.svg" alt="">
					Logout
				</div>
			</a>
		</section>
		<hr>
		<section>
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
		<?php else: ?>
		<section>
			<h2>🚨 Please login 🚨</h2>
			<p>You need to login to access this section.</p>
			<form method="post">
				<div class="form-layout-column">
					<label for="email">Email</label>
					<input id="email" type="text" name="email">
				</div>
				<div class="form-layout-column">
					<label for="code">Code</label>
					<input id="code" type="password" name="code">
				</div>
				<input class="button-second" type="submit" value="Access admin view">
			</form>
		</section>
		<?php endif ?>
	</div>
	<div id="version">Wuwana version 2.2.1</div>	
<?php endif ?>
<div class="navbar-background" id="navbar-background" onclick="showNavbar()"></div>