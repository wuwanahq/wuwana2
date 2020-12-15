<h1 class="VisuallyHidden">Wuwana</h1>
<header class="headerBar">
	<div class="headerContainer">
		<div class="header-lang" onclick="showLang()">
			<div class="lang">ES</div>
			<div class="popup-lang" id="popup-lang">
				<h2><?php echo TEMP_TEXT[3] ?></h2>
				<a href="#">English</a>
				<a href="#">Español</a>
			</div>
		</div>
		<div class="headerLogo"><a href="/"><img src="/static/logo/wuwana.svg"></a></div>
		<div class="header-invisible"></div>
		<?php
			if (isset($user) && $user->isLogin())
			{
				echo '<span>';
				echo  $user->isAdmin() ? '<a href="/admin/companies">Admin page</a>' : $user->companyID;
				echo  ' | ', $_SESSION['Name'];
				echo '</span>';
			}
			elseif (filter_has_var(INPUT_GET, 'login'))
			{
				echo '<form method="post">';
				echo  '<label for="email">Email: </label>';
				echo  '<input id="email" type="text" name="email">';
				echo  '<input type="button" value="Send email" onclick="askEmail()"> ';
				echo  '<label for="code">Code: </label>';
				echo  '<input id="code" type="password" name="code"> <input type="submit" value="Login">';
				echo '</form>';
			}
			else
			{
				echo '<div class="HeaderIcon" onclick="showMenu()">';
				echo  '<img id="TestImg" src="/static/icon/menu.svg" alt="Menu icon">';
				echo '</div>';
			}
		?>
	</div>
</header>