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
		<section class="column-left">
			<?php include 'Templates/navbar admin.php' ?>
		</section>
		<main>
			<?php if(!$user->isAdmin()): ?>
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php endif ?>
			<div class="information-error-box" style="display:none" id="MsgBox">
				<div class="information-error-vertical"></div>
				<a href=""><h2 id="MsgTxt"></h2></a>
			</div>
			<section>
				<h2>Admin section</h2>
				<div class="box pad-16">
					Wuwana version 2.2<br>
					<?php if ($user->isAdmin() && $commit != ''): ?>
						Last commit: <?php echo $commit ?><br>
					<?php endif ?>
					<br>
					Database revision <?php echo $settings['DatabaseRevision'] ?>
				</div>
			</section>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
	<script>scrapeInstagramForAutoUpdate("<?php echo $oldestInstagram ?>")</script>
</body>
</html>