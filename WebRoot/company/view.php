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
	<script src="/static/dhtml/company.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="mobile-summary" aria-hidden="true" id="mobile-summary">
		<img class="mobile-summary-logo" src="<?php echo $company->logo ?>">
		<div class="mobile-summary-title">
			<h3><?php echo $company->name ?></h3>
			<div class="button-icon-small">
				<img src="/static/icon/tiny/map.svg" alt="">
			<?php echo $company->region ?>
			</div>
		</div>
	</div>
	<div class="container">
		<section class="column-left">
			<div class="company-sticky">
				<div class="box-panel" id="company-panel">
					<section class="company-about">
						<img class="logo-main"
							src="<?php echo $company->logo ?>"
							alt="<?php echo $company->name ?> logo">
						<h1> <?php echo $company->name ?> </h1>
						<ul>
							<li>
								<?php echo implode('</li><li>', $company->tags) ?>
							</li>
						</ul>
						<div class="button-icon-small margin-t16">
							<img src="/static/icon/tiny/map.svg" alt="">
							<?php echo $company->region ?>
						</div>
					</section>
					<hr>
					<section class="company-description">
						<h3>
							<?php printf(TEXT[6], $company->name) ?>
						</h3>
						<p> <?php echo $company->description ?>  </p>
					</section>
					<hr>
					<section class="company-contact">
						<h3>
							<?php printf(TEXT[1], $company->name) ?>
						</h3>
						<ul>
							<?php if ($company->instagram->pageURL != ''): ?>
								<li>
									<a class="item-label" href="<?php echo $company->instagram->getPageURL() ?>" target="_blank" rel="noopener">
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
					<hr>
					<?php if (isset($user) && $user->isAdmin()): ?>
					<!-- Not sure if this make sense -->
					<a href="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];?>/?edit">
						<div class="icon-label-h">
							<img src="/static/icon/gray/edit.svg" alt="">
							<?php echo TEXT[10] ?>
						</div>
					</a>
					<?php endif ?>
				</div>
				<div id="last-updated">
					<?php echo TEXT[9], ' ', $language->formatDate($company->lastUpdate) ?>
				</div>
				<?php if (isset($user) && $user->isAdmin())
				{
					include 'company/edit.php';
				}
				?>
			</div>
		</section>
		<main>
			<?php if (isset($company->instagram)): ?>
				<section class="instagram">
					<h2><?php printf(TEXT[2], $company->name) ?></h2>
					<div class="box">
						<div class="instagram-info">
							<h3>
								<?php echo $company->instagram->profileName ?>
							</h3>
							<p>
								<?php echo $company->instagram->getHtmlBiography() ?><br>
								<a id="ig-external-url" href="<?php echo $company->instagram->externalLink ?>" target="_blank" rel="noopener">
									<?php echo str_replace(['http://','https://'], '', $company->instagram->externalLink) ?>
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
									<img src="<?php echo $company->instagram->pictures[0] ?>" onerror="this.onerror=null;this.src='/static/logo/square1.svg'">
								</div>
								<div class="instagram-picture">
									<img src="<?php echo $company->instagram->pictures[1] ?>" >
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
						<a class="button-icon" href="<?php echo $company->instagram->getPageURL() ?>" target="_blank" rel="noopener">
							<img src="/static/icon/instagram.svg" alt="">
							<?php echo TEXT[5] ?>
						</a>
					</div>
				</section>
			<?php endif ?>
			<div class="button-icon center" onclick="goBack()">
				<img src="/static/icon/arrow-circle-left.svg" alt="">
				<?php echo TEXT[4] ?>
			</div>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>