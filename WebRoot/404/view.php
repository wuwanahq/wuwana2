<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/dhtml/404.css">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="error-page-wrapper">
		<div class="error-image">
			<img src="/static/image/schemekle.jpg" alt="a picture of Schemekle, Wuwana's mascot, looking goofy">
		</div>
		<h1><?php echo TEXT[0] ?></h1>
		<p><?php echo TEXT[1] ?></p>
<!--
		<section class="error-companies">
			<h2><?php echo TEXT[2] ?></h2>
			<div class="box center">
			<?php
				/*
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
						echo       '<ul class="Label">';

						foreach ($company->tags as $tag)
						{
							echo     '<li>', $tag, '</li>';
						}

						echo       '</ul>';
						echo       '<div class="tagRegion">', $locations[$company->region]->region, '</div>';
						echo     '</div>';
						echo     '<div class="BadgeArea"></div>';
						echo   '</div>';
						echo '</a>';

						if (--$counter > 0)
						{ echo '<hr>'; }
					}
				*/
				?>
			</div>
		</section>
-->
	</div>
	<a class="button-icon Center" href="/">
		<img src="/static/icon/home.svg" alt=""><?php echo TEXT[3] ?>
	</a>
</body>
</html>