<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<meta name="twitter:title" content="<?php echo $company->name ?> | Wuwana">
	<meta property="og:title" content="<?php echo $company->name ?> | Wuwana" />
	<title><?php echo $company->name ?> | Wuwana</title>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="Container">
		<section class="ColumnLeft">
			<div class="companyPanel">
				<section class="companyAbout">
					<div class="Logo">
						<img src="<?php echo $company->logo ?>" alt="<?php echo $company->name, ' logo' ?>" >
					</div>
					<?php
						if (isset($user) && $user->isAdmin())
						{ echo '<input type="text" value="', $company->name, '">'; }
						else
						{ echo '<h1>', $company->name, '</h1>'; }
					?>
					<ul class="Label">
						<?php
							foreach ($company->tags as $tag)
							{ echo '<li>', $tag, '</li>'; }
						?>
					</ul>
					<div class="tagRegion"><?php echo $company->region ?></div>
				</section>
				<section class="companyDescription">
					<hr>
					<h3><?php printf(TEXT[6], $company->name) ?></h3>
					<?php
						if (isset($user) && $user->isAdmin())
						{ echo '<textarea>', $company->description, '</textarea><br>'; }
						else
						{ echo '<p>', $company->description, '</p>'; }
					?>
				</section>
<!--
				<section class="companyAddress">
					<hr>
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
				<section class="contactInfo">
					<hr>
					<h3><?php printf(TEXT[1], $company->name) ?></h3>
					<ul>
						<?php
							if (!empty($company->instagram->url))
							{
								echo '<li>';
								echo  '<a class="ItemLabel" href="', $company->instagram->url, '" target="_blank">';
								echo   '<div class="buttonSocial">';
								echo    '<img src="/static/icon/instagram.svg">';
								echo   '</div>';
								echo   'Instagram';
								echo  '</a>';
								echo '</li>';
							}

							if (!empty($company->website))
							{
								echo '<li>';
								echo  '<a class="ItemLabel" href="', $company->website, '" target="_blank">';
								echo   '<div class="buttonSocial">';
								echo    '<img src="/static/icon/globe.svg">';
								echo   '</div>';
								echo   'Web';
								echo  '</a>';
								echo '</li>';
							}

							if (isset($company->phone) && (int)$company->phone = 0)
							{
								echo '<li>';
								echo  '<a class="ItemLabel" href="https://wa.me/', $company->phone, '?text=';
									printf(TEXT[8], $company->name);
								echo    '" target="_blank">';
								echo   '<div class="buttonSocial">';
								echo    '<img src="/static/icon/whatsapp.svg">';
								echo   '</div>';
								echo   'WhatsApp';
								echo  '</a>';
								echo '</li>';
							}

							if (!empty($company->email))
							{
								echo '<li>';
								echo  '<a class="ItemLabel" href="mailto:', $company->email, '" >';
								echo   '<div class="buttonSocial">';
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
		<section class="ColumnMain">
			<section class="companyInstagram">
			<?php
				if (isset($company->instagram))
				{
					echo '<section>';
					echo  '<h2>';
						printf(TEXT[2], $company->name);
					echo  '</h2>';
					echo  '<div class="Box">';
					echo   '<div class="InstagramInfo">';
					echo    '<h3>', $company->instagram->profileName, '</h3>';
					echo    '<p>', nl2br($company->instagram->biography), '<br>';
					echo    '<a href="', $company->instagram->link, '" target="_blank">', str_replace(['http://','https://'], '', $company->instagram->link), '</a></p>';
					echo    '<ul>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->nbPost, '</span>';
					echo       '<span class="Text">Posts</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->nbFollower, '</span>';
					echo       '<span class="Text">Followers</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->nbFollowing, '</span>';
					echo       '<span class="Text">Following</span>';
					echo      '</div>';
					echo     '</li>';
					echo    '</ul>';
					echo   '</div>';
					echo   '<div class="Aspect2-3">';
					echo    '<div class="InstagramGallery">';
					echo     '<div class="InstagramRow">';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[0], '"></div>';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[1], '"></div>';
					echo     '</div>';
					echo     '<div class="InstagramRow">';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[2], '"></div>';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[3], '"></div>';
					echo     '</div>';
					echo     '<div class="InstagramRow">';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[4], '"></div>';
					echo      '<div class="InstagramPicture"><img src="', $company->instagram->pictures[5], '"></div>';
					echo     '</div>';
					echo    '</div>';
					echo   '</div>';
					echo    '<a class="buttonIcon" href="', $company->instagram->url, '" target="_blank">';
					echo     '<img src="/static/icon/instagram.svg">', TEXT[5];
					echo    '</a>';
					echo  '</div>';
					echo '</section>';
				}
			?>
			</section>
			<a class="buttonIcon Center" href="/">
				<img src="/static/icon/home.svg">
				<?php echo TEXT[4] ?>
			</a>
			</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>