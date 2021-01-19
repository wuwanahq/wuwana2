<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<meta property="og:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta property="og:image" content="/static/image/wuwana-link-2020.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1264">
	<meta property="og:image:height" content="640">
	<meta name="twitter:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta name="twitter:image" content="https://wuwana.com/static/image/wuwana-link-2020.png">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/homepage.css">
	<script src="/static/dhtml/homepage.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<div class="box-panel">
				<div class="panel-cover">
					<img src="/static/logo/ribbon-long.svg" alt="wuwana logo ribbon">
				</div>
				<section>
					<h2><?php echo TEXT[13] ?></h2>
					<p><?php echo TEXT[9] ?></p>
					<a class="button-main center" target="_blank"
					 href="https://medium.com/wuwana/qué-es-wuwana-7c2defac2302" rel="noopener">
						<?php echo TEXT[10] ?>
					</a>
				</section>
				<hr>
				<section class="contact-section">
					<h3><?php echo TEXT[11] ?></h3>
					<ul>
						<li>
							<a class="item-label" href="https://www.instagram.com/wuwana.es/" target="_blank" rel="noopener">
								<div class="button-social"><img src="/static/icon/instagram.svg" alt=""></div>
								Instagram
							</a>
						</li>
						<li>
							<a class="item-label" href="mailto:jonathan@wuwana.com">
								<div class="button-social"><img src="/static/icon/email.svg" alt=""></div>
								Email
							</a>
						</li>
					</ul>
				</section>
			</div>
			<section class="sticky" id="menu">
				<h2><?php echo TEXT[8] ?></h2>
				<div class="box filter">
					<form method="get" action="/">
						<dl>
							<dt><?php echo TEXT[3] ?></dt>
							<dd>
								<input type="checkbox" name="region" id="R0"
									<?php if ($selectedRegions == []) { echo 'checked disabled'; } ?>
									><label for="R0"><?php echo TEXT[4] ?></label>
							</dd>
							<?php foreach ($locations as $id => $regionName): ?>
								<dd>
									<input type="checkbox" name="region<?php echo $id ?>" id="R<?php echo $id ?>"
									 <?php if (in_array($id, $selectedRegions)) { echo 'checked'; } ?>
									  ><label for="R<?php echo $id ?>"><?php echo $regionName ?></label>
								</dd>
							<?php endforeach ?>
						</dl>
						<div class="mobile" style="text-align:center">
							<input type="submit" value="<?php echo TEXT[7] ?>" class="button-filter">
						</div>
					</form>
				</div>
			</section>
		</section>
		<section class="column-main">
			<div class="banner">
				<div class="banner-text">
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
					<?php foreach ($companies as $permalink => $company): ?>
						<a class="card" href="/<?php echo $permalink ?>">
							<div class="logo-main margin-r16">
								<img src="<?php echo $company->logo ?>" alt="<?php echo $company->name ?> logo">
							</div>
							<div class="company-card-wrapper">
								<div class="company-card-info">
									<h3><?php echo $company->name ?></h3>
									<ul class="tag-area">
										<li><?php echo implode('</li><li>', $company->tags) ?></li>
									</ul>
									<div class="button-icon-small margin-t-auto">
										<img src="/static/icon/tiny/map.svg" alt="">
										<?php echo $locations[$company->region] ?>
									</div>
								</div>
								<div class="company-card-badge-wrapper"></div>
							</div>
						</a>
						<?php if (--$counter > 0) { echo '<hr>'; } ?>
					<?php endforeach ?>
				</div>
			</section>
			<a class="button-icon center" href="?show=all">
				<img src="/static/icon/plus.svg" alt="">
				<?php echo TEXT[6] ?>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>