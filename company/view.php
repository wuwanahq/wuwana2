<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title><?php echo $company->name ?> | Wuwana</title>
	<meta property="og:title" content="<?php echo $company->name ?> | Wuwana">
	<meta property="og:image" content="<?php echo $company->logo ?>">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:image:width" content="150">
	<meta property="og:image:height" content="150">
	<meta name="twitter:title" content="<?php echo $company->name ?> | Wuwana">
	<meta name="twitter:image" content="<?php echo $company->logo ?>">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<div class="box-panel">
				<section class="company-about">
					<div class="logo-main">
						<img src="<?php echo $company->logo ?>" alt="<?php echo $company->name, ' logo' ?>" >
					</div>
					<?php
						if (isset($user) && $user->isAdmin())
						{ echo '<input type="text" value="', $company->name, '">'; }
						else
						{ echo '<h1>', $company->name, '</h1>'; }
					?>
					<ul class="tag-area">
						<li><?php echo implode('</li><li>', $company->tags) ?></li>
					</ul>
					<div class="button-icon-small margin-t16">
						<img src=/static/icon/small/map-small-grey50.svg>
						<?php echo $company->region ?>
					</div>
				</section>
				<hr>
				<section class="company-description">
					<h3><?php printf(TEXT[6], $company->name) ?></h3>
					<?php
						if (isset($user) && $user->isAdmin())
						{ echo '<textarea>', $company->description, '</textarea><br>'; }
						else
						{ echo '<p>', $company->description, '</p>'; }
					?>
				</section>
				<hr>
<!--
				<section class="companyAddress">

					<h3><?php echo TEXT[7] ?></h3>
					<p><?php echo $company->address ?></p>
				</section>
				<section class="companyWhy">
					<hr>
					<h3><?php printf(TEXT[0], $company->name) ?></h3>
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
				</section>
-->
				<section class="company-contact">
					<h3><?php printf(TEXT[1], $company->name) ?></h3>
					<ul>
						<?php
							if ($company->instagram->url != '')
							{
								echo '<li>';
								echo  '<a class="item-label" href="', $company->instagram->url, '" target="_blank">';
								echo   '<div class="button-social">';
								echo    '<img src="/static/icon/instagram.svg">';
								echo   '</div>';
								echo   'Instagram';
								echo  '</a>';
								echo '</li>';
							}

							if (!empty($company->website))
							{
								echo '<li>';
								echo  '<a class="item-label" href="', $company->website, '" target="_blank">';
								echo   '<div class="button-social">';
								echo    '<img src="/static/icon/globe.svg">';
								echo   '</div>';
								echo   'Web';
								echo  '</a>';
								echo '</li>';
							}

							if (isset($company->phone) && (int)$company->phone = 0)
							{
								echo '<li>';
								echo  '<a class="item-label" href="https://wa.me/', $company->phone, '?text=';
									printf(TEXT[8], $company->name);
								echo    '" target="_blank">';
								echo   '<div class="button-social">';
								echo    '<img src="/static/icon/whatsapp.svg">';
								echo   '</div>';
								echo   'WhatsApp';
								echo  '</a>';
								echo '</li>';
							}

							if (!empty($company->email))
							{
								echo '<li>';
								echo  '<a class="item-label" href="mailto:', $company->email, '" >';
								echo   '<div class="button-social">';
								echo    '<img src="/static/icon/email.svg">';
								echo   '</div>';
								echo   'Email';
								echo  '</a>';
								echo '</li>';
							}
						?>
					</ul>
				</section>
				<?php
					if (isset($user) && $user->isAdmin())
					{
						echo '<form method="post">';
						echo  '<label for="permalink">Permanent link:</label>';
						echo  '<input id="permalink" type="text" size="26" value="', WebApp\WebApp::getPermalink(), '">';
						echo  '<br>';
						echo  '<label for="insta">Instagram profile:</label>';
						echo  '<input id="insta" type="text" size="25" value="',
							empty($company->instagram->url) ? '' : $company->instagram->url, '">';
						echo  '<br>';
						echo  '<label for="whatsapp">WhatsApp number:</label>';
						echo  '<input id="whatsapp" type="text" size="24" value="', $company->phone, '"><br>';
						echo  '<br>';
						echo  '<label for="email">Email address:</label>';
						echo  '<input id="email" type="text" size="26" value="', $company->email, '"><br>';
						echo  '<br>';
						echo  '<label for="website">Website URL:</label>';
						echo  '<input id="website" type="text" size="27" value="', $company->website, '">';
						echo  '<br>';
						echo  '<input type="submit" value="Update info sources">';
						echo '</form>';
					}
				?>
			</div>
		</section>
		<section class="column-main">
			<section class="instagram">
			<?php
				if (isset($company->instagram))
				{
					echo '<section>';
					echo  '<h2>';
						printf(TEXT[2], $company->name);
					echo  '</h2>';
					echo  '<div class="box">';
					echo   '<div class="instagram-info">';
					echo    '<h3>', $company->instagram->profileName, '</h3>';
					echo    '<p>', nl2br($company->instagram->biography), '<br>';
					echo    '<a href="', $company->instagram->link, '" target="_blank">', str_replace(['http://','https://'], '', $company->instagram->link), '</a></p>';
					echo    '<ul>';
					echo     '<li>';
					echo      '<div class="item-label">';
					echo       '<span class="number">', $language->formatShortNumber($company->instagram->nbPost), '</span>';
					echo       '<span class="text">Posts</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="item-label">';
					echo       '<span class="number">', $language->formatShortNumber($company->instagram->nbFollower), '</span>';
					echo       '<span class="text">Followers</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="item-label">';
					echo       '<span class="number">', $language->formatShortNumber($company->instagram->nbFollowing), '</span>';
					echo       '<span class="text">Following</span>';
					echo      '</div>';
					echo     '</li>';
					echo    '</ul>';
					echo   '</div>';
					echo   '<div class="Aspect2-3">';
					echo    '<div class="instagram-gallery">';
					echo     '<div class="instagram-row">';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[0], '"></div>';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[1], '"></div>';
					echo     '</div>';
					echo     '<div class="instagram-row">';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[2], '"></div>';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[3], '"></div>';
					echo     '</div>';
					echo     '<div class="instagram-row">';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[4], '"></div>';
					echo      '<div class="instagram-picture"><img src="', $company->instagram->pictures[5], '"></div>';
					echo     '</div>';
					echo    '</div>';
					echo   '</div>';
					echo    '<a class="button-icon" href="', $company->instagram->url, '" target="_blank">';
					echo     '<img src="/static/icon/instagram.svg">', TEXT[5];
					echo    '</a>';
					echo  '</div>';
					echo '</section>';
				}
			?>
			</section>
			<a class="button-icon center" href="/">
				<img src="/static/icon/home.svg">
				<?php echo TEXT[4] ?>
			</a>
			</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>