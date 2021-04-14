<header class="header-bar">
	<div class="header-container">
		<?php if ($url == '/' || strpos($url, '/admin') !== false): ?>
			<div class="header-icon" onclick="toggleNavbar()">
				<img class="icon" id="menu-icon" src="/static/icon/menu.svg" alt="menu icon">
			</div>
		<?php else: ?>
			<div class="header-icon" onclick="goBack()">
				<img class="icon" src="/static/icon/arrow-circle-left.svg" alt="back arrow icon">
			</div>
		<?php endif ?>
		<div class="header-logo">
			<a href="/">
				<picture class="icon">
					<source media="(max-width: 500px)" srcset="/static/logo/w-logo.svg" alt="wuwana logo">
					<source media="(min-width: 500px)" srcset="/static/logo/website.svg" alt="wuwana logo">
					<img src="/static/logo/website.svg" alt="wuwana logo">
				</picture>
			</a>
		</div>
	</div>
</header>