<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<meta property="og:title" content="Admin page | Wuwana">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/admin.css">
	<script src="/static/dhtml/admin.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<?php include 'Templates/navbar.php' ?>
		<div class="column-main">
			<?php if(!$user->isAdmin()): ?>
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php endif ?>
			<section>
				<h2>Export tables data</h2>
				<div class="box pad-16">
					<a href="?export=UserAccount">Download UserAccount.tsv</a><br>
					<a href="?export=Company">Download Company.tsv</a><br>
					<a href="?export=SocialMedia">Download SocialMedia.tsv</a><br>
					<a href="?export=Image">Download Image.tsv</a><br>
					<a href="?export=Tag">Download Tag.tsv</a>
				</div>
			</section>
			<section>
				<h2>Import tables data</h2>
				<div class="box pad-16">
					<form method="post" enctype="multipart/form-data">
						<label for="f1">UserAccount table:</label>
						<input id="f1" type="file" name="UserAccount"><br>
						<label for="f2">Company table:</label>
						<input id="f2" type="file" name="Company"><br>
						<label for="f3">SocialMedia table:</label>
						<input id="f3" type="file" name="SocialMedia"><br>
						<label for="f4">Image table:</label>
						<input id="f4" type="file" name="Image"><br>
						<label for="f5">Tag table:</label>
						<input id="f5" type="file" name="Tag"><br><br>
						<input type="submit" value="Upload files and OVERWRITE TABLES DATA">
					</form>
				</div>
			</section>
			<section>
				<h2>Get database schema</h2>
				<div class="box pad-16">
					<a href="?export=schema">Download SQL script</a>
				</div>
			</section>
		</div>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>