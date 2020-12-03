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
			<div class="boxPanel">
				<div class="panelCover">
					<img src="/static/logo/ribbon.svg">
				</div>
				<p>Encontrar la información que necesitas debería ser más fácil.</p>
				<a class="buttonMain Center" href="https://medium.com/wuwana/qué-es-wuwana-7c2defac2302" >
					Descubre qué es Wuwana
				</a>
				<hr>
				<section class="contactSection">
					<h3>Contáctanos</h3>
					<ul>
						<li>
							<a class="ItemLabel" href="/">
								<div class="buttonSocial"><img src="/static/icon/instagram.svg"></div>
								Instagram
							</a>
						</li>
						<li>
							<a class="ItemLabel" href="/">
								<div class="buttonSocial"><img src="/static/icon/instagram.svg"></div>
								Instagram
							</a>
						</li>
					</ul>
				</section>
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
			<div class="banner">
				<div class="bannerText">
					<h2><?php echo TEMP_TEXT[0] ?></h2>
					<p><?php echo TEMP_TEXT[1] ?></p>
				</div>
			</div>
			<section>
				<h2>Empresas destacadas</h2>
				<div class="Box">
					<a class="Card" href="company">
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
								<div class="tagRegion">Cataluna</div>
							</div>
							<div class="BadgeArea">
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
							echo '<a class="Card" href="company/', $permalink, '">';
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
							echo     '<div class="tagRegion">', $locations[$company->region]->region, '</div>';
							echo    '</div>';
							echo    '<div class="BadgeArea"></div>';
							echo   '</div>';;
							echo '</a>';

							if (--$counter > 0)
							{ echo '<hr>'; }
						}
					?>
				</div>
			</section>
			<a class="buttonIcon Center" href="?show=all">
				<img src="/static/icon/plus.svg">
				Ver mas empresas
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>