<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="<?php echo TEXT[5], ' ', TEXT[6] ?>">
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<link rel="icon" type="image/png" href="/static/favicon/16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/static/favicon/32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/static/favicon/48.png" sizes="48x48">
	<link rel="icon" type="image/png" href="/static/favicon/64.png" sizes="64x64">
	<link rel="icon" type="image/png" href="/static/favicon/96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/static/favicon/160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="/static/favicon/196.png" sizes="196x196">
	<link rel="apple-touch-icon" href="/static/favicon/57.png" sizes="57x57">
	<link rel="apple-touch-icon" href="/static/favicon/60.png" sizes="60x60">
	<link rel="apple-touch-icon" href="/static/favicon/72.png" sizes="72x72">
	<link rel="apple-touch-icon" href="/static/favicon/76.png" sizes="76x76">
	<link rel="apple-touch-icon" href="/static/favicon/114.png" sizes="114x114">
	<link rel="apple-touch-icon" href="/static/favicon/120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="/static/favicon/144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="/static/favicon/152.png" sizes="152x152">
	<link rel="apple-touch-icon" href="/static/favicon/180.png" sizes="180x180">
	<link rel="stylesheet" type="text/css" href="/static/style.css">
	<script src="/static/es5.js" defer></script>
</head>
<body>
	<header class="HeaderBar">
		<div class="HeaderContainer">
			<div class="HeaderLogo"><a href="/"><img src="/static/wuwana-black.svg"></a></div>
			<div class="HeaderIcon" onclick="showMenu()"><img id="TestImg" src="/static/icon/menu.svg"></div>
		</div>
	</header>

	<div class="Container">
		<div class="ColumnLeft Home">

			<div class="Box About">
				<div class="AboutCover">
					<img src="/static/cover/oct2020.svg">
				</div>
				<p class="AboutText">Encontrar la informacion que necesitas deberia ser mas facil.</p>
				<div class="Hidden" id="AboutUs">
					<div class="Button">Descubre que es Wuwana</div>
					<hr class="AboutLine">
					<h3>Contactanos</h3>
					<div class="AboutSocial">
						<div class="ItemLabel">
							<div class="Button Circle"><img src="/static/icon/instagram.svg"></div>
							<span class="Label Circle">Instagram</span>
						</div>
						<div class="ItemLabel">
							<div class="Button Circle"><img src="/static/icon/whatsapp.svg"></div>
							<span class="Label Circle">Whatsapp</span>
						</div>
					</div>
				</div>
				<hr>
				<div class="Button Toggle" onclick="hide()">
					<img id="ToggleAboutUsImg" src="/static/icon/chevron-down.svg">
					<label class="TextButton" id="ToggleAboutUsLabel">Ver mas</label>
				</div>
			</div>

			<div class="Sticky" id="menu">
				<h2>Personaliza la buqueda</h2>
				<div class="Box Filter">
					<form method="get" action="/">
					<dl>
						<dt><?php echo TEXT[1] ?></dt>
						<dd>
							<input type="checkbox" name="cat" id="C0"
								<?php echo $selectedCategories==[] ? ' checked disabled' : '' ?>>
							<label for="C0"><?php echo TEXT[2] ?></label>
						</dd>
						<?php
							foreach ($categories as $id => $languages)
							{
								echo '<dd><input type="checkbox" name="cat', $id, '" id="C', $id, '"';

								if (in_array($id, $selectedCategories))
								{ echo ' checked'; }

								echo '><label for="C', $id, '">', $languages[$language], '</label></dd>';
							}
						?>
					</dl>
					<dl>
						<dt><?php echo TEXT[3] ?></dt>
						<dd>
							<input type="checkbox" name="region" id="R0"
								<?php echo $selectedRegions==[] ? 'checked disabled' : '' ?>>
							<label for="R0"><?php echo TEXT[4] ?></label>
						</dd>
						<?php
							foreach ($locations as $id => $location)
							{
								echo '<dd><input type="checkbox" name="region', $id, '" id="R', $id, '"';

								if (in_array($id, $selectedRegions))
								{ echo ' checked'; }

								echo '><label for="R', $id, '">', $location->region, '</label></dd>';
							}
						?>
					</dl>
					</form>
					<div class="Button Center"><img src="/static/icon/filter.svg">Aplicar filtros</div>
				</div>
			</div>
		</div>
		<div class="ColumnMain Home">
			<div class="Box Banner">
				<div class="BannerText">
					<h1 class="BannerTitle"><?php echo TEXT[5] ?></h1>
					<p class="BannerSubtitle"><?php echo TEXT[6] ?></p>
				</div>
			</div>

			<h2>Empresas destacadas</h2>
			<div class="Box">
				<a class="NoStyle" href="company">
					<div class="Card">
						<div class="Logo">
							<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">
						</div>
						<div class="CompanyMain">
							<div class="CompanyContent">
								<h3>Company 1</h3>
								<div class="Category">
									<span class="Label">Tostador</span>
									<span class="Label">Cafeteria</span>
								</div>
								<div class="Tag Region">Cataluna</div>
							</div>
							<div class="BadgeArea"><!-- Badge area -->
								<div class="ItemLabel">
									<div class="GoogleReview">
											4,5
											<span class="ReviewScale">/5</span>
									</div>
									<span class="Label Circle">Google review</span>
								</div>
								<div class="ItemLabel">
									<img src="/static/badge/sustainability.svg">
									<span class="Label Circle">Sostenible</span>
								</div>
								<div class="ItemLabel">
									<img src="/static/badge/social-impact.svg">
									<span class="Label Circle">Compromiso social</span>
								</div>
							</div>
						</div>
					</div>
				</a>
				<hr/>
				<a href="company">
					<div class="Card">
						<div class="Logo">
							<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">
						</div>
						<div class="CompanyMain">
							<div class="CompanyContent">
								<h3>Company Long Name</h3>
								<div class="Category">
									<span class="Label">Tostador</span>
									<span class="Label">Cafeteria</span>
								</div>
								<div class="Tag Region">Cataluna</div>
							</div>
							<div class="BadgeArea"><!-- Badge area -->
								<div class="ItemLabel">
									<div class="GoogleReview">
											4,8
											<span class="ReviewScale">/5</span>
									</div>
									<span class="Label Circle">Google review</span>
								</div>
								<div class="ItemLabel">
									<img src="/static/badge/sustainability.svg">
									<span class="Label Circle">Sostenible</span>
								</div>
								<div class="ItemLabel">
									<img src="/static/badge/social-impact.svg">
									<span class="Label Circle">Compromiso social</span>
								</div>
								<div class="ItemLabel">
									<img src="/static/badge/sca.svg">
									<span class="Label Circle">Certificado</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<h2>Otras empresas</h2>
			<div class="Box">
				<?php
					$counter = count($companies);

					foreach ($companies as $company)
					{
						echo '<a href="company">';
						echo  '<div class="Card">';
						echo   '<div class="Logo">';
						echo    '<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">';
						echo   '</div>';
						echo   '<div class="CompanyMain">';
						echo    '<div class="CompanyContent">';
						echo     '<h3>', $company->name, '</h3>';
						echo     '<div class="Category">';

						foreach ($company->categories as $category)
						{ echo '<span class="Label">', $categories[$category][$language], '</span>'; }

						echo     '</div>';
						echo     '<div class="Tag Region">', $locations[$company->region]->region, '</div>';
						echo    '</div>';
						echo    '<div class="BadgeArea"></div>';
						echo   '</div>';
						echo  '</div>';
						echo '</a>';

						if (--$counter > 0)
						{ echo '<hr>'; }
					}
				?>
			</div>
			<a class="Center" href="?show=all">
				<div class="Button Center"><img src="static/icon/plus.svg">Ver mas empresas</div>
			</a>
		</div>
	</div>
	<a href="#">
		<div id="toTop" class="Button ToTop"><img src="/static/icon/arrow-circle-top.svg">Volver arriba</div>
	</a>
</body>
</html>