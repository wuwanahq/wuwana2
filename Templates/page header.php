<h1 class="VisuallyHidden">Wuwana</h1>
<header class="headerBar">
	<div class="headerContainer">
		<div class="header-lang-wrapper" onclick="showLang()">
			<div class="header-lang">
				<?php echo $language->code == 'zh' ? WebApp\Language::CODES[$language->code] : strtoupper($language->code) ?>
			</div>
			<div class="popup-lang" id="popup-lang">
				<div class="popup-title">
					<h2><?php echo TEMP_TEXT[3] ?></h2>
					<img src="/static/icon/close.svg" id="popup-lang-close">
				</div>
				<?php
					foreach (WebApp\Language::CODES as $code => $lang)
					{ echo '<a href="', WebApp\WebApp::changeSubdomain($code), '">', $lang, '</a>'; }
				?>
			</div>
		</div>
		<div class="headerLogo"><a href="/"><img src="/static/logo/wuwana.svg"></a></div>
		<div class="header-invisible"></div>
		<?php
			if (isset($user) && $user->isLogin())
			{
				echo '<span>';
				echo   $user->isAdmin() ? '<a href="/admin/companies">Admin page</a>' : $_SESSION['CompanyID'];
				echo   ' | ', $_SESSION['Name'];
				echo '</span>';
			}
			elseif (filter_has_var(INPUT_GET, 'login'))
			{
				echo '<form method="post">';
				echo   '<label for="email">Email: </label>';
				echo   '<input id="email" type="text" name="email">';
				echo   '<input type="button" value="Send email" onclick="askEmail()"> ';
				echo   '<label for="code">Code: </label>';
				echo   '<input id="code" type="password" name="code"> <input type="submit" value="Login">';
				echo '</form>';
			}
			elseif ($url == '/')
			{
				echo '<div class="header-icon" onclick="showMenu()">';
				echo   '<img id="menu-icon" src="/static/icon/menu.svg">';
				echo '</div>';
			}
			else
			{
				echo '<div class="header-icon" onclick="showMenu()">';
				echo   '<a href="/"><img id="menu-icon" src="/static/icon/home.svg"></a>';
				echo '</div>';
			}
		?>
	</div>
</header>