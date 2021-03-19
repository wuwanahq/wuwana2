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
	<div class="container-homepage">
		<picture>
			<source media="(max-width: 400px)" srcset="/static/logo/website.svg" alt="wuwana logo">
			<source media="(min-width: 400px)" srcset="/static/logo/website-large.svg" alt="wuwana logo">
			<img src="/static/logo/website.svg" alt="wuwana logo">
		</picture>
		<?php include 'Templates/search.php' ?>
		<p>
		Try searching for the product you need, the industry you want or the name of a company.
		</p>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>