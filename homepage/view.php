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
	<link rel="stylesheet" type="text/css" href="/static/dhtml/homepage.css">
	<script src="/static/dhtml/homepage.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<section class="navbar-box" id="navbar">
				<img class="panel-ribbon" src="/static/logo/ribbon.svg" alt="wuwana logo ribbon">
				<section>
					<h2><?php echo TEXT[13] ?></h2>
					<p><?php echo TEXT[9] ?></p>
				</section>
				<hr>
				<section>
					<h3><?php echo TEXT[11] ?></h3>
					<ul>
						<li>
							<a class="icon-label-h" href="mailto:jonathan@wuwana.com">
								<img src="/static/icon/gray/email.svg" alt="">
								Email
							</a>
						</li>
					</ul>
				</section>
			</section>
			<div id="navbar-background" onclick="showNavbar()"></div>
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
				<div style="display: flex; justify-content:space-between; align-items:center; margin-bottom: 8px">
					<h2 style="margin:0"><?php echo TEXT[5] ?></h2>
					<div class="dropdown-caret mobile" onclick="showFilter()">
						Filter
						<img src="/static/icon/gray/chevron-down.svg" alt="">
					</div>
				</div>
				<div id="companies-list" class="box">
					<?php foreach ($companies as $permalink => $company): ?>
						<a class="card" href="/<?php echo $permalink ?>">
							<div class="logo-main margin-r16">
								<img src="<?php echo $company->logo ?>">
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
            <input type="hidden" id="page-count" value="<?=$pageCount?>"/>
			<a id="view-more-button" class="button-icon center" onclick="isPossibleToViewMore(<?=$allCompaniesCount?>)">
				<img src="/static/icon/plus.svg" alt="">
				<?php echo TEXT[6] ?>
			</a>
		</section>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>