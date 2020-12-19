<h1 class="VisuallyHidden">Wuwana</h1>
<header class="headerBar">
	<div class="headerContainer">
		<div class="header-lang" onclick="showLang()">
			<div class="lang">
				<?php echo $language == 'zh' ? WebApp\Config::LANGUAGES[$language] : strtoupper($language) ?>
			</div>
			<div class="popup-lang" id="popup-lang">
				<div class="popup-title">
					<h2><?php echo TEMP_TEXT[3] ?></h2>
					<img src="/static/icon/close.svg" id="popup-lang-close">
				</div>
				<?php
					foreach (WebApp\Config::LANGUAGES as $code => $lang)
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
				echo   $user->isAdmin() ? '<a href="/admin/companies">Admin page</a>' : $user->companyID;
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
			elseif (filter_input(INPUT_SERVER, 'REQUEST_URI') == '/')
			{
				echo '<div class="HeaderIcon" onclick="showMenu()">';
				echo   '<img id="TestImg" src="/static/icon/menu.svg">';
				echo '</div>';
			}
			else
			{
				echo '<div class="HeaderIcon" onclick="showMenu()">';
				echo   '<a href="/"><img id="TestImg" src="/static/icon/home.svg"></a>';
				echo '</div>';
			}
		?>
	</div>
</header>