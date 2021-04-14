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
	<!-- <link rel="stylesheet" type="text/css" href="/static/dhtml/searchpage.css"> -->
	<link rel="stylesheet" type="text/css" href="/static/dhtml/homepage.css">
	<script src="/static/dhtml/homepage.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<?php include 'Templates/navbar homepage.php' ?>
			<?php if ($companies['Counter'] > 0): ?>
				<!-- <section class="sticky" id="filter">
					<h2><?php echo TEXT[8] ?></h2>
					<div class="box">
					<form method="get" action="/">
						<input type="hidden" name="search" value="<?php echo $search ?>">
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
						<input type="submit"
								class="button-filter mobile" 
								value="<?php echo TEXT[7] ?>" >
					</form>
					</div>
				</section> -->
			<?php endif ?>
		</section>
		<main>
			<h1>Search Results</h1>
			<?php include 'Templates/search.php' ?>
			<div class="information-error-box">
				<div class="information-error-vertical"></div>
				<h2><?php echo TEXT[12] ?></h2>
			</div>
			<?php if ($companies['Counter'] > 0): ?>
				<div class="box result-box">
					<p><?php printf(TEXT[13], $companies['Counter']) ?></p>
					<p><span><?php echo $search ?></span></p>
				</div>
				<section>
					<div class="search-title">
						<h2><?php echo TEXT[5] ?></h2>
						<div onclick="toggleFilter()">
							<?php echo TEXT[14] ?>
						</div>
					</div>
					<div id="companies-list" class="box">
						<?php WebApp\ViewComponent::printCompanyCards($companies) ?>
					</div>
				</section>
				<input type="hidden" id="page-count" value="<?php echo $pageCount ?>"/>
				<a id="view-more-button" class="button-main-new icon-button" onclick="isPossibleToViewMore(<?php echo $jsParam ?>)">
					<img class="icon" src="/static/icon/plus.svg" alt="">
					<?php echo TEXT[6] ?>
				</a>
				<section id="filter">
					<div class="h2-title">
						<h2><span><?php echo TEXT[14] ?></span></h2>
						<div class="h2-title-icon" onclick="toggleFilter()">
							<img class="icon" src="/static/icon/close.svg" alt="filter close icon">
						</div>
					</div>
					<section>
						<h2><?php echo TEXT[3] ?></h2>
						<div class="box">
							<form method="get" action="/">
								<input type="hidden" name="search" value="<?php echo $search ?>">
								<dl>
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
								<input type="submit" class="button-main-new" value="<?php echo TEXT[7] ?>" >
							</form>
						</div>
					</section>
				</section>
			<?php else: ?>
				<div class="information">
					<div class="information-emoji">
						😢
					</div>
					<p>
						<?php printf(TEXT[15], $search) ?>
					</p>
				</div>
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
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>