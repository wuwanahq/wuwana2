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
		<nav>
			<?php include 'Templates/navbar homepage.php' ?>
		</nav>
		<main>	
			<h1><?php echo $company->name ?></h1>
			<?php include 'Templates/search.php' ?>
			<section>
				<div class="section-title">
					<h2><?php echo TEXT[14] ?></h2>	
					<?php if (isset($user) && $user->isAdmin()): ?>
						<div onclick="toggleEdit()"><?php echo TEXT[10] ?></div>
					<?php endif ?>
				</div>
				<div class="box" id="main-info">
					<section class="card">
						<div class="logo-main">
							<img class="logo-main"
							src="<?php echo $company->logo ?>"
							alt="<?php echo $company->name ?> logo">
						</div>
						<div class="company-card-info">
							<h3><?php echo $company->name ?></h3>
							<ul>
								<li>
									<?php echo implode('</li><li>', $company->tags) ?>
								</li>
							</ul>
							<div class="button-icon-small">
								<img src="/static/icon/tiny/map.svg" alt="">
								<?php echo $company->region ?>
							</div>
						</div>
					</section>
					<hr>
					<section class="company-about">
						<h3><?php echo TEXT[6] ?></h3>
						<p><?php echo $company->description ?></p>
					</section>
					<ul class="ul-list">
						<?php if (!empty($company->website)): ?>
							<li>
								<a href="<?php echo $company->website ?>"
									target="_blank"
									rel="noopener">
									<img class="icon" src="/static/icon/globe.svg" alt="">
									<div>
										Website
										<img src="/static/icon/gray/open-in-new.svg" alt="">
									</div>
								</a>
							</li>
						<?php endif ?>
						<?php if ($company->instagram->pageURL != ''): ?>
							<li>
								<a  href="<?php echo $company->instagram->getPageURL() ?>" 
									target="_blank"
									rel="noopener">
									<img class="icon" src="/static/icon/instagram.svg" alt="">
									<div>
										Instagram
										<img src="/static/icon/gray/open-in-new.svg" alt="">
									</div>
								</a>
							</li>
						<?php endif ?>
						<?php if (isset($company->phone) && (int)$company->phone = 0): ?>
							<li>
								<a 	target="_blank"
									href="https://wa.me/<?php
								echo $company->phone, '?text='; printf(TEXT[8], $company->name) ?>"
									rel="noopener">
									<img class="icon" src="/static/icon/whatsapp.svg" alt="">
									<div>
										Whatsapp
										<img src="/static/icon/gray/open-in-new.svg" alt="">
									</div>
								</a>
							</li>
						<?php endif ?>
						<?php if (!empty($company->email)): ?>
							<li>
								<a href="mailto:<?php echo $company->email ?>">
									<img class="icon" src="/static/icon/email.svg" alt="">
									<div>
										Email
										<img src="/static/icon/gray/open-in-new.svg" alt="">
									</div>
								</a>
							</li>
						<?php endif ?>
					</ul>
				</div>
				<div class="last-updated">
					<?php echo TEXT[9], ' ', $language->formatDate($company->lastUpdate) ?>
				</div>
			</section>
			<?php if (isset($company->instagram)): ?>
				<section class="instagram">
					<div class="section-title">
						<h2><?php printf(TEXT[2], $company->name) ?></h2>
						<a href="<?php echo $company->instagram->getPageURL() ?>" target="_blank" rel="noopener">
							<?php echo TEXT[5] ?>
						</a>
					</div>		
					<div class="box">
						<div class="box-text">
							<h3><?php echo $company->instagram->profileName ?></h3>
							<p><?php echo $company->instagram->getHtmlBiography() ?></p>
							<?php if ($company->instagram->externalLink): ?>
								<a href="<?php echo $company->instagram->externalLink ?>" target="_blank" rel="noopener">
									<?php echo str_replace(['http://','https://'], '', $company->instagram->externalLink) ?>
								</a>
							<?php endif ?>
							<ul>
								<li>
									<?php echo $language->formatShortNumber($company->instagram->nbPost) ?>
									<span><?php echo TEXT[11] ?></span>
								</li>
								<li>
									<?php echo $language->formatShortNumber($company->instagram->nbFollower) ?>
									<span><?php echo TEXT[12] ?></span>	
								</li>
								<li>
									<?php echo $language->formatShortNumber($company->instagram->nbFollowing) ?>
									<span><?php echo TEXT[13] ?></span>
								</li>
							</ul>
						</div>
						<div class="box-aspect-2-3">
							<div class="instagram-gallery">
								<div class="instagram-row">
									<div class="instagram-picture">
										<img src="<?php echo $company->instagram->pictures[0] ?>" >
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
							</div>
						</div>
					</div>
				</section>
				<div class="last-updated">
					<?php echo TEXT[9], ' ', $language->formatDate($company->lastUpdate) ?>
				</div>
			<?php endif ?>
			<div class="button-main-new icon-button" onclick="goBack()">
				<img class="icon" src="/static/icon/arrow-circle-left.svg" alt="">
				<?php echo TEMP_TEXT[21] ?>
			</div>
			<?php if (isset($user) && $user->isAdmin())
				{
					include 'company/edit.php';
				}
			?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>