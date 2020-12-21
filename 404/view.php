<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
</head>
<body class="error-page">
	<?php include 'Templates/page header.php' ?>
	<div class="error-image">
		<img src="/static/picture/error.svg">
	</div>
	<section class="error-explanation">
		<h1><?php echo TEXT[0] ?></h1>
		<p><?php echo TEXT[1] ?></p>
	</section>
<!--
	<section class="error-companies">
		<h2><?php echo TEXT[2] ?></h2>
		<div class="Box Center">
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
	<a class="buttonIcon Center" href="/">
		<img src="/static/icon/home.svg"><?php echo TEXT[3] ?>
	</a>
</body>
</html>