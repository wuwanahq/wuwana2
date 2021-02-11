<h1 class="visually-hidden">Wuwana</h1>
<header class="header-bar">
	<div class="header-container">
		<div class="header-logo"><a href="/"><img src="/static/logo/website.svg" alt="wuwana logo"></a></div>
		<div class="header-invisible"></div>
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
		<?php elseif ($url == '/'): ?>
			<div class="header-icon" onclick="showMenu()">
				<img id="menu-icon" src="/static/icon/menu.svg" alt="menu icon">
			</div>
		<?php else: ?>
			<div class="header-icon" onclick="showMenu()">
				<a href="/"><img id="menu-icon" src="/static/icon/home.svg" alt="home icon"></a>
			</div>
		<?php endif ?>
	</div>
</header>