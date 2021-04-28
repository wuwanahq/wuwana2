<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/dhtml/main.css">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/admin.css">
	<script src="/static/dhtml/main.js" defer></script>
	<script src="/static/dhtml/admin.js"></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<nav>
			<?php include 'Templates/navbar admin.php' ?>
		</nav>
		<main>
			<?php if(!$user->isAdmin()): ?>
				<div class="box info-error-box">
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
				<h1>Admin | Dashboard</h1>
				<?php include 'Templates/search.php' ?>
				<section>
					<h2>Webapp General</h2>
					<div class="box box-text">
						<p>Version 2.2</p>
						<?php if ($user->isAdmin() && $commit != ''): ?>
							Last commit: <?php echo $commit ?>
						<?php endif ?>
						<p>Database revision <?php echo $settings['DatabaseRevision'] ?></p>
					</div>
				</section>
				<div class="information-error-box" style="display:none" id="MsgBox">
					<div class="information-error-vertical"></div>
					<a href=""><h2 id="MsgTxt"></h2></a>
				</div>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
	<script>scrapeInstagramForAutoUpdate("<?php echo $oldestInstagram ?>")</script>
</body>
</html>