<h1 class="visually-hidden">Wuwana</h1>
<header class="header-bar">
	<div class="header-container">
		<?php if ($url == '/' || strpos($url, '/admin') !== false): ?>
			<div class="header-icon" onclick="showNavbar()">
				<img id="menu-icon" src="/static/icon/menu.svg" alt="menu icon">
			</div>
		<?php else: ?>
			<div class="header-icon" onclick="goBack()">
				<img src="/static/icon/arrow-circle-left.svg" alt="back arrow icon">
			</div>
		<?php endif ?>
		<div class="header-logo">
			<a href="/">
				<picture>
					<source media="(max-width: 500px)" srcset="/static/logo/w-logo.svg" alt="wuwana logo">
					<source media="(min-width: 500px)" srcset="/static/logo/website.svg" alt="wuwana logo">
					<img src="/static/logo/website.svg" alt="wuwana logo">
				</picture>
			</a>
		</div>
		<?php include 'Templates/search.php' ?>
		<?php if (isset($user) && $user->isLogin()): ?>
			<span>
				<?php
					echo $user->isAdmin() ? '<a href="/admin/companies">Admin page</a>' : $_SESSION['CompanyID'];
					echo ' | ', $_SESSION['Name'];
				?>
			</span>
		<?php elseif (filter_has_var(INPUT_GET, 'login')): ?>
			<form method="post">
				<label for="email">Email: </label>
				<input id="email" type="text" name="email">
				<input type="button" value="Send email" onclick="sendEmail()">
				<label for="code">Code: </label>
				<input id="code" type="password" name="code"> <input type="submit" value="Login">
			</form>
		<?php endif ?>
	</div>
</header>