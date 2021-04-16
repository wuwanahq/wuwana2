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
		<aside>
			<?php include 'Templates/navbar admin.php' ?>
		</aside>
		<main class="page-admin-database">
			<?php if(!$user->isAdmin()): ?>
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
			<h1>Admin | Database</h1>
			<?php include 'Templates/search.php' ?>
			<section>
				<h2>Export Tables</h2>
				<div class="box box-text">
					<a href="?export=UserAccount">Download UserAccount.tsv</a>
					<a href="?export=Company">Download Company.tsv</a>
					<a href="?export=SocialMedia">Download SocialMedia.tsv</a>
					<a href="?export=Image">Download Image.tsv</a>
					<a href="?export=Tag">Download Tag.tsv</a>
				</div>
			</section>
			<section>
				<h2>Import Tables</h2>
				<div class="box box-text">
					<div class="box box-text alert">
						<img src="/static/icon/alert.svg" alt="">
						<p>Attention! This action will OVERWRITE the current tables and it cannot be undone.</p>
					</div>
					<form class="input-file" method="post" enctype="multipart/form-data">
						<label for="f2">
							Upload Company.tsv <span>(required)</span>
							<input id="f2" type="file" name="Company">
						</label>
						<label for="f3">
							Upload SocialMedia.tsv <span>(required)</span>
							<input id="f3" type="file" name="SocialMedia">
						</label>
						<label for="f4">
							Upload Image.tsv <span>(required)</span>
							<input id="f4" type="file" name="Image">
						</label>
						<label for="f5">
							Upload Tag.tsv <span>(required)</span>
							<input id="f5" type="file" name="Tag">
						</label>
						<hr><br>
						<label for="f1">
							Upload UserAccount.tsv <span>(optional)</span>
							<input id="f1" type="file" name="UserAccount">
						</label>
						
						<input class="button-main-new" type="submit" value="Upload TSV files">
					</form>
				</div>
			</section>
			<section>
				<h2>Database Schema</h2>
				<div class="box box-text">
					<a href="?export=schema">Download SQL script</a>
				</div>
			</section>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>