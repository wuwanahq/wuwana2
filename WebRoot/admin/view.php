<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/dhtml/main.css">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/admin.css">
	<script src="/static/dhtml/main.js" defer></script>
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
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>