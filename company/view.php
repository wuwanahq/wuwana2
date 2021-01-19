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
						<img src="<?php echo $company->logo ?>" alt="<?php echo $company->name ?> logo" >
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
						<img src="/static/icon/tiny/map.svg" alt="">
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
						<?php if ($company->instagram->url != ''): ?>
							<li>
								<a class="item-label" href="<?php echo $company->instagram->url ?>" target="_blank" rel="noopener">
									<div class="button-social">
										<img src="/static/icon/instagram.svg" alt="">
									</div>
									Instagram
								</a>
							</li>
						<?php endif ?>
						<?php if (!empty($company->website)): ?>
							<li>
								<a class="item-label" href="<?php echo $company->website ?>" target="_blank" rel="noopener">
									<div class="button-social">
										<img src="/static/icon/globe.svg" alt="">
									</div>
									Web
								</a>
							</li>
						<?php endif ?>
						<?php if (isset($company->phone) && (int)$company->phone = 0): ?>
							<li>
								<a class="item-label" target="_blank" href="https://wa.me/<?php
								 echo $company->phone, '?text='; printf(TEXT[8], $company->name) ?>" rel="noopener">
									<div class="button-social">
										<img src="/static/icon/whatsapp.svg" alt="">
									</div>
									WhatsApp
								</a>
							</li>
						<?php endif ?>
						<?php if (!empty($company->email)): ?>
							<li>
								<a class="item-label" href="mailto:<?php echo $company->email ?>">
									<div class="button-social">
										<img src="/static/icon/email.svg" alt="">
									</div>
									Email
								</a>
							</li>
						<?php endif ?>
					</ul>
				</section>
				<?php if (isset($user) && $user->isAdmin()): ?>
					<form method="post">
						<label for="permalink">Permanent link:</label>
						<input id="permalink" type="text" size="26" value="<?php echo WebApp\WebApp::getPermalink() ?>">
						<br>
						<label for="insta">Instagram profile:</label>
						<input id="insta" type="text" size="25" value="<?php echo $company->instagram->url ?>">
						<br>
						<label for="whatsapp">WhatsApp number:</label>
						<input id="whatsapp" type="text" size="24" value="<?php echo $company->phone ?>">
						<br><br>
						<label for="email">Email address:</label>
						<input id="email" type="text" size="26" value="<?php echo $company->email ?>">
						<br><br>
						<label for="website">Website URL:</label>
						<input id="website" type="text" size="27" value="<?php echo $company->website ?>">
						<br>
						<input type="submit" value="Update info sources">
					</form>
				<?php endif ?>
			</div>
			<div id="last-updated">
				<?php echo TEXT[9], ' ', $language->formatDate($company->lastUpdate) ?>
			</div>
		</section>
		<section class="column-main">
			<?php if (isset($company->instagram)): ?>
				<section class="instagram"><section>
					<h2><?php printf(TEXT[2], $company->name) ?></h2>
					<div class="box">
						<div class="instagram-info">
							<h3><?php echo $company->instagram->profileName ?></h3>
							<p>
								<?php echo $company->instagram->getHtmlBiography() ?><br>
								<a href="<?php echo $company->instagram->link ?>" target="_blank" rel="noopener">
									<?php echo str_replace(['http://','https://'], '', $company->instagram->link) ?>
								</a>
							</p>
							<ul>
								<li>
									<div class="item-label">
										<span class="number">
											<?php echo $language->formatShortNumber($company->instagram->nbPost) ?>
										</span>
										<span class="text">Posts</span>
									</div>
								</li>
								<li>
									<div class="item-label">
										<span class="number">
											<?php echo $language->formatShortNumber($company->instagram->nbFollower) ?>
										</span>
										<span class="text">Followers</span>
									</div>
								</li>
								<li>
									<div class="item-label">
										<span class="number">
											<?php echo $language->formatShortNumber($company->instagram->nbFollowing) ?>
										</span>
										<span class="text">Following</span>
									</div>
								</li>
							</ul>
						</div>
						<div class="Aspect2-3"><div class="instagram-gallery">
							<div class="instagram-row">
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[0] ?>">
								</div>
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[1] ?>">
								</div>
							</div>
							<div class="instagram-row">
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[2] ?>">
								</div>
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[3] ?>">
								</div>
							</div>
							<div class="instagram-row">
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[4] ?>">
								</div>
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[5] ?>">
								</div>
							</div>
						</div></div>
						<a class="button-icon" href="<?php echo $company->instagram->url ?>" target="_blank" rel="noopener">
							<img src="/static/icon/instagram.svg" alt="">
							<?php echo TEXT[5] ?>
						</a>
					</div>
				</section></section>
			<?php endif ?>
			<a class="button-icon center" href="/">
				<img src="/static/icon/home.svg" alt="">
				<?php echo TEXT[4] ?>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>