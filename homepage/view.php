<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<meta property="og:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta property="og:image" content="/static/Wuwana-link-2020.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1264">
	<meta property="og:image:height" content="640">
	<meta name="twitter:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta name="twitter:image" content="https://wuwana.com/static/Wuwana-link-2020.png">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<div class="boxPanel">
				<div class="panelCover">
					<img src="/static/logo/ribbon-long.svg" alt="wuwana ribbon">
				</div>
				<p><?php echo TEXT[9] ?></p>
				<a class="buttonMain center" href="https://medium.com/wuwana/qué-es-wuwana-7c2defac2302" target="_blank">
					<?php echo TEXT[10] ?>
				</a>
				<hr>
				<section class="contactSection">
					<h3><?php echo TEXT[11] ?></h3>
					<ul>
						<li>
							<a class="ItemLabel" href="https://www.instagram.com/wuwana.es/" target="_blank">
								<div class="buttonSocial"><img src="/static/icon/instagram.svg"></div>
								Instagram
							</a>
						</li>
						<li>
							<a class="ItemLabel" href="mailto:jonathan@wuwana.com">
								<div class="buttonSocial"><img src="/static/icon/email.svg"></div>
								Email
							</a>
						</li>
					</ul>
				</section>
			</div>
			<section class="sticky" id="menu">
				<h2><?php echo TEXT[8] ?></h2>
				<div class="box pad-16 flow-y">
					<form method="get" action="/">
<!--
					<dl>
						<dt><?php /* echo TEXT[1] */ ?></dt>
						<dd>
							<input type="checkbox" name="cat" id="C0"
								<?php echo $selectedCategories==[] ? ' checked disabled' : '' ?>>
							<label for="C0"><?php echo TEXT[2] ?></label>
						</dd>
						<?php /*
							foreach ($categories as $id => $languages)
							{
								echo '<dd><input type="checkbox" name="cat', $id, '" id="C', $id, '"';

								if (in_array($id, $selectedCategories))
								{ echo ' checked'; }

								echo '><label for="C', $id, '">', $languages[$language], '</label></dd>';
							} */
						?>
					</dl>
-->
					<dl>
						<dt><?php echo TEXT[3] ?></dt>
						<dd>
							<input type="checkbox" name="region" id="R0"
								<?php echo $selectedRegions==[] ? 'checked disabled' : '' ?>
								><label for="R0"><?php echo TEXT[4] ?></label>
						</dd>
						<?php
							foreach ($locations as $id => $regionName)
							{
								echo '<dd><input type="checkbox" name="region', $id, '" id="R', $id, '"';

								if (in_array($id, $selectedRegions))
								{ echo ' checked'; }

								echo '><label for="R', $id, '">', $regionName, '</label></dd>';
							}
						?>
					</dl>
					</form>
					<div id="apply-filter" class="buttonIcon center mobile"><img src="/static/icon/filter.svg"><?php echo TEXT[7] ?></div>
				</div>
			</section>
		</section>
		<section class="column-main">
			<div class="banner">
				<div class="bannerText">
					<h2><?php echo TEMP_TEXT[0] ?></h2>
					<p><?php echo TEMP_TEXT[1] ?></p>
				</div>
			</div>
			<div class="information-error-box">
				<div class="information-error-vertical"></div>
				<h2><?php echo TEXT[12] ?></h2>
			</div>
			<section>
				<h2><?php echo TEXT[5] ?></h2>
				<div class="box">
					<?php
						$counter = count($companies);

						foreach ($companies as $permalink => $company)
						{
							echo '<a class="Card" href="/', $permalink, '">';
							echo   '<div class="Logo">';
							echo     '<img src="', $company->logo, '" alt="', $company->name, ' logo">';
							echo   '</div>';
							echo   '<div class="CompanyMain">';
							echo     '<div class="CompanyContent">';
							echo       '<h3>', $company->name, '</h3>';
							echo       '<ul class="tag-area">';
							echo         '<li>', implode('</li><li>', $company->tags), '</li>';
							echo       '</ul>';
							echo       '<div class="button-icon-small">'; 
							echo         '<img src=/static/icon/small/map-small-grey50.svg>';
							echo         $locations[$company->region];
							echo       '</div>';
							echo     '</div>';
							echo     '<div class="BadgeArea"></div>';
							echo   '</div>';
							echo '</a>';

							if (--$counter > 0)
							{ echo '<hr>'; }
						}
					?>
				</div>
			</section>
			<a class="buttonIcon center" href="?show=all">
				<img src="/static/icon/plus.svg">
				<?php echo TEXT[6] ?>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>
