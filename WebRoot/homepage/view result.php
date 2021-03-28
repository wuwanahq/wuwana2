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
	<link rel="stylesheet" type="text/css" href="/static/dhtml/searchpage.css">
	<script src="/static/dhtml/homepage.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<?php include 'Templates/navbar.php' ?>
			<section class="sticky" id="filter">
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
							<input type="submit"
								class="button-filter" 
								value="<?php echo TEXT[7] ?>" >
						</div>
					</form>
				</div>
			</section>
		</section>
		<main>
			<div class="information-error-box">
				<div class="information-error-vertical"></div>
				<h2><?php echo TEXT[12] ?></h2>
			</div>
			<div class="search-result-box">
				<p><?php echo TEXT[15] . $companies['Counter'] . TEXT[16] ?></p>
				<h2><?php echo $search ?></h2>
			</div>
			<?php if ($companies['Counter'] > 0): ?>
				<section>
					<div class="search-title">
						<h2 style="margin:0"><?php echo TEXT[5] ?></h2>
						<div class="dropdown-caret mobile" onclick="showFilter()">
							<?php echo TEXT[14] ?>
							<img src="/static/icon/gray/chevron-down.svg" alt="">
						</div>
					</div>
					<div id="companies-list" class="box">
						<?php WebApp\ViewComponent::printCompanyCards($companies) ?>
					</div>
				</section>
				<input type="hidden" id="page-count" value="<?php echo $pageCount ?>"/>
				<a id="view-more-button" class="button-icon center" onclick="isPossibleToViewMore(<?php echo $jsParam ?>)">
					<img src="/static/icon/plus.svg" alt="">
					<?php echo TEXT[6] ?>
				</a>
			<?php else: ?>
			<!-- TO DO: if 0 results, show suggestions similar to the 404 page -->
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>