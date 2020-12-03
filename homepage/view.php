<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<meta name="twitter:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta property="og:title" content="<?php echo TEXT[0] ?> | Wuwana" />
	<title><?php echo TEXT[0] ?> | Wuwana</title>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="Container">
		<section class="ColumnLeft">
			<div class="Box About">
				<div class="AboutCover">
					<img src="/static/logo/ribbon.svg">
				</div>
				<p>Encontrar la informacion que necesitas deberia ser mas facil.</p>
				<div class="Hidden" id="AboutUs">
					<div class="buttonMain">Descubre que es Wuwana</div>
					<hr>
					<h3>Contáctanos</h3>
					<ul>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="buttonSocial"><img src="/static/icon/instagram.svg"></div>
									Instagram
								</div>
							</a>
						</li>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="buttonSocial"><img src="/static/icon/instagram.svg"></div>
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
		</section>
		<section class="ColumnMain">
			<div class="Box Banner">
				<div class="BannerText">
					<h2 class="BannerTitle"><?php echo TEMP_TEXT[0] ?></h2>
					<p class="BannerSubtitle"><?php echo TEMP_TEXT[1] ?></p>
				</div>
			</div>
			<section>
				<h2>Empresas destacadas</h2>
				<div class="Box">
					<a href="company">
						<div class="Card">
							<div class="Logo">
								<img src="/static/logo/square1.svg">
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
								<div class="BadgeArea"><!-- Badge area -->
									<div class="ItemLabel">
										<div class="GoogleReview">
											4,8
											<span class="ReviewScale">/5</span>
										</div>
										Google review
									</div>
									<div class="ItemLabel">
										<img src="/static/badge/sustainability.svg">
										<span>Sostenible</span>
									</div>
									<div class="ItemLabel">
										<img src="/static/badge/sustainability.svg">
										<span>Sostenible</span>
									</div>
									<div class="ItemLabel">
										<img src="/static/badge/sustainability.svg">
										<span>Sostenible</span>
									</div>
									<div class="ItemLabel">
										<img src="/static/badge/social-impact.svg">
										<span>Compromiso social</span>
									</div>
								</div>
							</div>
						</div>
					</a>
					<hr/>
				</div>
			</section>
			<section>
				<h2>Otras empresas</h2>
				<div class="Box">
					<?php
						$counter = count($companies);

						foreach ($companies as $permalink => $company)
						{
							echo '<a href="company/', $permalink, '">';
							echo  '<div class="Card">';
							echo   '<div class="Logo">';
							echo    '<img src="/static/logo/square', rand(1,8), '.svg">';
							echo   '</div>';
							echo   '<div class="CompanyMain">';
							echo    '<div class="CompanyContent">';
							echo     '<h3>', $company->name, '</h3>';
							echo     '<ul class="Label">';

							foreach ($company->tags as $tag)
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
				<div class="buttonIcon"><img src="/static/icon/plus.svg">Ver mas empresas</div>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>