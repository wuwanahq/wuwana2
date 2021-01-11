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
	<link rel="stylesheet" type="text/css" href="/static/dhtml/company.css">
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
						<img src="/static/icon/small/map-small-grey50.svg">
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
								printf('
									<li>
										<a class="item-label" href="%s" target="_blank">
											<div class="button-social">
												<img src="/static/icon/instagram.svg">
											</div>
											Instagram
										</a>
									</li>',
									$company->instagram->url
								);
							}

							if (!empty($company->website))
							{
								printf('
									<li>
										<a class="item-label" href="%s" target="_blank">
											<div class="button-social">
												<img src="/static/icon/globe.svg">
											</div>
											Web
										</a>
									</li>',
									$company->website
								);
							}

							if (isset($company->phone) && (int)$company->phone = 0)
							{
								printf('
									<li>
										<a class="item-label" href="https://wa.me/%s?text=%s" target="_blank">
											<div class="button-social">
												<img src="/static/icon/whatsapp.svg">
											</div>
											WhatsApp
										</a>
									</li>',
									$company->phone,
									sprintf(TEXT[8], $company->name)
								);
							}

							if (!empty($company->email))
							{
								printf('
									<li>
										<a class="item-label" href="mailto:%s">
											<div class="button-social">
												<img src="/static/icon/email.svg">
											</div>
											Email
										</a>
									</li>',
									$company->email
								);
							}
						?>
					</ul>
				</section>
				<?php
					if (isset($user) && $user->isAdmin())
					{
						printf('
							<form method="post">
								<label for="permalink">Permanent link:</label>
								<input id="permalink" type="text" size="26" value="%s">
								<br>
								<label for="insta">Instagram profile:</label>
								<input id="insta" type="text" size="25" value="%s">
								<br>
								<label for="whatsapp">WhatsApp number:</label>
								<input id="whatsapp" type="text" size="24" value="%s">
								<br><br>
								<label for="email">Email address:</label>
								<input id="email" type="text" size="26" value="%s">
								<br><br>
								<label for="website">Website URL:</label>
								<input id="website" type="text" size="27" value="%s">
								<br>
								<input type="submit" value="Update info sources">
							</form>',
							WebApp\WebApp::getPermalink(),
							$company->instagram->url,
							$company->phone,
							$company->email,
							$company->website
						);
					}
				?>
			</div>
		</section>
		<section class="column-main">
			<?php
				if (isset($company->instagram))
				{
					printf('
						<section class="instagram"><section>
							<h2>%s</h2>
							<div class="box">
								<div class="instagram-info">
									<h3>%s</h3>
									<p>%s<br><a href="%s" target="_blank">%s</a></p>
									<ul>
										<li>
											<div class="item-label">
												<span class="number">%s</span>
												<span class="text">Posts</span>
											</div>
										</li>
										<li>
											<div class="item-label">
												<span class="number">%s</span>
												<span class="text">Followers</span>
											</div>
										</li>
										<li>
											<div class="item-label">
												<span class="number">%s</span>
												<span class="text">Following</span>
											</div>
										</li>
									</ul>
								</div>
								<div class="Aspect2-3"><div class="instagram-gallery">
									<div class="instagram-row">
										<div class="instagram-picture"><img src="%s"></div>
										<div class="instagram-picture"><img src="%s"></div>
									</div>
									<div class="instagram-row">
										<div class="instagram-picture"><img src="%s"></div>
										<div class="instagram-picture"><img src="%s"></div>
									</div>
									<div class="instagram-row">
										<div class="instagram-picture"><img src="%s"></div>
										<div class="instagram-picture"><img src="%s"></div>
									</div>
								</div></div>
								<a class="button-icon" href="%s" target="_blank">
									<img src="/static/icon/instagram.svg">%s
								</a>
							</div>
						</section></section>',
						sprintf(TEXT[2], $company->name),
						$company->instagram->profileName,
						$company->instagram->getHtmlBiography(),
						$company->instagram->link,
						str_replace(['http://','https://'], '', $company->instagram->link),
						$language->formatShortNumber($company->instagram->nbPost),
						$language->formatShortNumber($company->instagram->nbFollower),
						$language->formatShortNumber($company->instagram->nbFollowing),
						$company->instagram->pictures[0],
						$company->instagram->pictures[1],
						$company->instagram->pictures[2],
						$company->instagram->pictures[3],
						$company->instagram->pictures[4],
						$company->instagram->pictures[5],
						$company->instagram->url,
						TEXT[5]
					);
				}
			?>
			<a class="button-icon center" href="/">
				<img src="/static/icon/home.svg">
				<?php echo TEXT[4] ?>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>