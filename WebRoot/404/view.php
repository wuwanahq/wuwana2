<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/dhtml/404.css">
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="error-page-wrapper">
		<div class="error-image">
			<img src="/static/image/schemekle.jpg" alt="a picture of Schemekle, Wuwana's mascot, looking goofy">
		</div>
		<h1><?php echo TEXT[0] ?></h1>
		<p><?php echo TEXT[1] ?></p>
		<?php if (count($companies) > 0): ?>
			<section class="error-companies">
				<h2><?php echo TEXT[2] ?></h2>
				<div class="box center">
					<?php WebApp\ViewComponent::printCompanyCards($companies) ?>
				</div>
			</section>
		<?php endif ?>
	</div>
	<a class="button-icon Center" href="/">
		<img src="/static/icon/home.svg" alt=""><?php echo TEXT[3] ?>
	</a>
</body>
</html>