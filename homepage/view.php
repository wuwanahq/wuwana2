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
	<h1 class="VisuallyHidden">Wuwana</h1>
	<header class="HeaderBar">
		<div class="HeaderContainer">
			<div class="HeaderLogo"><a href="/"><img src="/static/wuwana-black.svg" alt="Wuwana logo"></a></div>
			<div class="HeaderIcon" onclick="showMenu()"><img id="TestImg" src="/static/icon/menu.svg" alt="Menu icon"></div>
		</div>
	</header>

	<div class="Container">
		<div class="ColumnLeft">

			<div class="Box About">
				<div class="AboutCover">
					<img src="/static/cover/oct2020.svg">
				</div>
				<p>Encontrar la informacion que necesitas deberia ser mas facil.</p>
				<div class="Hidden" id="AboutUs">
					<div class="Button">Descubre que es Wuwana</div>
					<hr>
					<h3>Contactanos</h3>
					<ul>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="Button Circle"><img src="/static/icon/instagram.svg"></div>
									Instagram
								</div>
							</a>
						</li>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="Button Circle"><img src="/static/icon/instagram.svg"></div>
									Instagram
								</div>
							</a>
						</li>
					</ul>
				</div>
				<hr>
				<div class="Button Toggle" onclick="hide()">
					<img id="ToggleAboutUsImg" src="/static/icon/chevron-down.svg">
					<label class="TextButton" id="ToggleAboutUsLabel">Ver mas</label>
				</div>
			</div>

			<section class="Sticky" id="menu">
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
			</section>
		</div>
		<div class="ColumnMain">
			<div class="Box Banner">
				<div class="BannerText">
					<h2 class="BannerTitle"><?php echo TEXT[5] ?></h2>
					<p class="BannerSubtitle"><?php echo TEXT[6] ?></p>
				</div>
			</div>

			<section>
				<h2>Empresas destacadas</h2>
				<div class="Box">
					<a href="company">
						<div class="Card">
							<div class="Logo">
								<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">
							</div>
							<div class="CompanyMain">
								<div class="CompanyContent">
									<h3>Company 1</h3>
									<ul class="Label">
										<li>Tostador</li>
										<li>Cafeteria</li>
									</ul>
									<div class="Tag Region">Cataluna</div>
								</div>
								<div class="BadgeArea">
									<ul>
										<li>
											<div class="ItemLabel">
												<div class="GoogleReview">
														4,8
														<span class="ReviewScale">/5</span>
												</div>
												Google review
											</div>
										</li>
										<li>
											<div class="ItemLabel">
												<img src="/static/badge/sustainability.svg">
												Sostenible
											</div>
										</li>
										<li>
											<div class="ItemLabel">
												<img src="/static/badge/social-impact.svg">
												Compromiso social
											</div>
										</li>
									</ul>
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
									<h3>Company 1</h3>
									<ul class="Label">
										<li>Tostador</li>
										<li>Cafeteria</li>
									</ul>
									<div class="Tag Region">Cataluna</div>
								</div>
								<div class="BadgeArea">
									<ul>
										<li>
											<div class="ItemLabel">
												<div class="GoogleReview">
														4,8
														<span class="ReviewScale">/5</span>
												</div>
												Google review
											</div>
										</li>
										<li>
											<div class="ItemLabel">
												<img src="/static/badge/sustainability.svg">
												Sostenible
											</div>
										</li>
										<li>
											<div class="ItemLabel">
												<img src="/static/badge/social-impact.svg">
												Compromiso social
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</a>
				</div>
			</section>

			<section>
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
							echo     '<ul class="Label">';

							foreach ($company->categories as $category)
							{ echo '<li>', $categories[$category][$language], '</li>'; }

							echo     '</ul>';
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
			</section>

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