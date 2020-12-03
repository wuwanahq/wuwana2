<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include '../Templates/page metadata.php' ?>
	<meta name="twitter:title" content="<?php echo $company->name ?> | Wuwana">
	<meta property="og:title" content="<?php echo $company->name ?> | Wuwana" />
	<title><?php echo $company->name ?> | Wuwana</title>
</head>
<body>
	<?php include '../Templates/page header.php' ?>
	<div class="Container">
		<section class="ColumnLeft">
			<div class="companyPanel">
				<section class="companyAbout">
					<div class="Logo">
						<img src="<?php echo $company->logo ?>">
					</div>
					<h1><?php echo $company->name ?></h1>
					<?php
						if (isset($user) && $user->isLogin() && $user->isAdmin())
						{
							echo '<form method="post">';
							echo  '<textarea></textarea><br>';
							echo  '<input type="submit" value="Update description">';
							echo '</form>';
						}
					?>
					<ul class="Label">
						<?php
							foreach ($company->tags as $tag)
							{ echo '<li>', $tag, '</li>'; }
						?>
						<li>Tagone</li>
						<li>Tagtwo</li>
						
					</ul>
					<div class="tagRegion">Cataluna</div>
				</section>
				<section class="companyDescription">
					<hr>
					<?php
						if (isset($user) && $user->isLogin() && $user->isAdmin())
						{
							echo '<form method="post">';
							echo  '<input type="text" placeholder="New company"><br>';
							echo  '<input type="submit" value="Update name">';
							echo '</form>';
						}
						else
						{
							echo '<h3>', $company->description, '</h3>';
						}
					?>
					<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae praesentium, doloremque alias ipsa odio inventore reiciendis soluta fugit earum sit natus deserunt. Velit maxime, eum recusandae sed eos commodi molestiae! </p>
				</section>
				<section class="companyAddress">
					<hr>
					<h3>Address</h3>
					<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae praesentium, doloremque alias ipsa odio inventore reiciendis soluta fugit earum sit natus deserunt. Velit maxime, eum recusandae sed eos commodi molestiae! </p>
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
				<section class="contactInfo">
					<hr>
					<h3><?php printf(TEXT[1], $company->name) ?></h3>
					<ul>
						<li>
							<a class="ItemLabel" href="/">

									<div class="buttonSocial">
										<img src="/static/icon/instagram.svg">
									</div>
									Instagram
							</a>
						</li>
						<li>
							<a class="ItemLabel" href="/">

									<div class="buttonSocial">
										<img src="/static/icon/whatsapp.svg">
									</div>
									Whatsapp

							</a>
						</li>
					</ul>
				</section>
				<?php
					if (isset($user) && $user->isLogin() && $user->isAdmin())
					{
						echo '<form method="post">';
						echo  '<label for="permalink">Permanent link:</label>';
						echo  '<input id="permalink" type="text" size="26" value="https://wuwana.com/my-profile-page">';
						echo  '<br>';
						echo  '<label for="insta">Instagram profile:</label>';
						echo  '<input id="insta" type="text" size="25" placeholder="https://instagram.com/username...">';
						echo  '<br>';
						echo  '<label for="whatsapp">WhatsApp number:</label>';
						echo  '<input id="whatsapp" type="text" size="24" placeholder="+34 123 45 67 89"><br>';
						echo  '<br>';
						echo  '<label for="email">Email address:</label>';
						echo  '<input id="email" type="text" size="26" placeholder="me@email.com"><br>';
						echo  '<br>';
						echo  '<label for="website">Website URL:</label>';
						echo  '<input id="website" type="text" size="27" placeholder="https://www.my-website.com">';
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
				if ($company->instagram != null)
				{
					echo '<section>';
					echo  '<h2>', sprintf(TEXT[2], $company->name), '</h2>';
					echo  '<div class="Box">';
					echo   '<div class="InstagramInfo">';
					echo    '<h3>', $company->instagram->profileName, '</h3>';
					echo    '<p>', $company->instagram->biography, '<br>', $company->instagram->link, '</p>';
					echo    '<ul>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->instagramNbPost, '</span>';
					echo       '<span class="Text">Posts</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->instagramNbFollower, '</span>';
					echo       '<span class="Text">Followers</span>';
					echo      '</div>';
					echo     '</li>';
					echo     '<li>';
					echo      '<div class="ItemLabel">';
					echo       '<span class="Number">', $company->instagram->instagramNbFollowing, '</span>';
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
	<?php include '../Templates/page footer.php' ?>
</body>
</html>