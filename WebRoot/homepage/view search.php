<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Wuwana</title>
	<meta property="og:title" content="Wuwana">
	<meta property="og:image" content="/static/logo/thumbnail.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1264">
	<meta property="og:image:height" content="640">
	<meta name="twitter:title" content="Wuwana">
	<meta name="twitter:image" content="https://wuwana.com/static/logo/thumbnail.png">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/homepage.css">
</head>
<body>
	<main class="homepage-search">
		<picture>
			<source media="(max-width: 400px)" srcset="/static/logo/website.svg" alt="wuwana logo">
			<source media="(min-width: 400px)" srcset="/static/logo/website-large.svg" alt="wuwana logo">
			<img src="/static/logo/website.svg" alt="wuwana logo">
		</picture>
		<?php include 'Templates/search.php' ?>
		<p><?php echo TEXT[9] ?></p>
		<section class="ind">
			<h2><?php echo TEXT[11] ?></h2>
			<div class="box">
				<div class="row">
					<div class="suggestion">
						<a href="<?php echo '/?search=' . TEXT[17] ?>">
							<h3><?php echo TEXT[17] ?></h3>
							<div class="text-background"></div>
							<img src="/static/image/specialty-coffee.jpg">
						</a>
					</div>
					<div class="suggestion">
						<a href="<?php echo '/?search=' . TEXT[18] ?>">
							<h3><?php echo TEXT[18] ?></h3>
							<div class="text-background"></div>
							<img src="/static/image/beer.jpg">
						</a>
					</div>
				</div>
				<div class="row">
					<div class="suggestion">
						<a href="<?php echo '/?search=' . TEXT[19] ?>">
							<h3><?php echo TEXT[19] ?></h3>
							<div class="text-background"></div>
							<img src="/static/image/roaster.jpg">
						</a>
					</div>
					<div class="suggestion">
						<a href="<?php echo '/?search=' . TEXT[20] ?>">
							<h3><?php echo TEXT[20] ?></h3>
							<div class="text-background"></div>
							<img src="/static/image/coffee-shop.jpg">
						</a>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>