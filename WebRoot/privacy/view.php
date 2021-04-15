<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<meta property="og:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta property="og:image" content="/static/logo/thumbnail.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="1264">
	<meta property="og:image:height" content="640">
	<meta name="twitter:title" content="<?php echo TEXT[0] ?> | Wuwana">
	<meta name="twitter:image" content="https://wuwana.com/static/logo/thumbnail.png">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/privacy.css">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<aside>
			<?php include 'Templates/navbar homepage.php' ?>
		</aside>
		<main>
			<h1><?php echo TEXT[0] ?></h1>
			<span><?php echo TEXT[1] . TEXT[23] ?></span>
			<?php include 'Templates/search.php' ?>
			<div class="box">
				<section>
					<!-- <h2><?php echo TEXT[25] ?></h2> -->
					<p><?php echo TEXT[2] ?></p>
					<p><?php echo TEXT[3] ?></p>
					<p><?php echo TEXT[4] ?></p>
				</section>
				<section>
					<h2><?php echo TEXT[5] ?></h2>
					<p><?php echo TEXT[6] ?></p>
					<p><?php echo TEXT[7] ?></p>
					<p><?php echo TEXT[8] ?></p>
				</section>
				<section>
					<h2><?php echo TEXT[9] ?></h2>
					<h3><?php echo TEXT[10] ?></h3>
					<p><?php echo TEXT[11] ?></p>
					<h3><?php echo TEXT[12] ?></h3>
					<p><?php echo TEXT[13] ?></p>
					<h3><?php echo TEXT[14] ?></h3>
					<p><?php echo TEXT[15] ?></p>
					<p><?php echo TEXT[16] ?></p>
				</section>
				<section>
					<h3><?php echo TEXT[17] ?></h3>
					<p><?php echo TEXT[18] ?></p>
					<h3><?php echo TEXT[19] ?></h3>
					<p><?php echo TEXT[20] ?></p>
					<h3><?php echo TEXT[21] ?></h3>
					<p><?php echo TEXT[22] ?></p>
					<ul><li><?php echo TEXT[23] ?></li></ul>
				</section>
			</div>
			<div class="button-main-new icon-button" onclick="goBack()">
				<img class="icon" src="/static/icon/arrow-circle-left.svg" alt="">
				<?php echo TEXT[24] ?>
			</div>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>