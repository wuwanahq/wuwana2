<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/dhtml/404.css">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<aside>
			<?php include 'Templates/navbar homepage.php' ?>
		</aside>
		<main>
			<h1>404</h1>
			<?php include 'Templates/search.php' ?>
			<section>
				<h2>What is 404?</h2>
				<div class="box error">
					<img src="/static/image/schemekle.jpg" alt="a picture of Schemekle, Wuwana's mascot, looking goofy">
					<p><?php echo TEXT[1] ?></p>
				</div>
			</section>
			<?php if (count($companies) > 0): ?>
			<section>
				<h2><?php echo TEXT[2] ?></h2>
				<div class="box">
					<?php WebApp\ViewComponent::printCompanyCards($companies) ?>
				</div>
			</section>
			<?php endif ?>
			<a class="button-main-new icon-button" href="/">
				<img class="icon" src="/static/icon/home.svg" alt=""><?php echo TEXT[3] ?>
			</a>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>