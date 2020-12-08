<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include '../../Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
</head>
<body>
	<?php include '../../Templates/page header.php' ?>
	<div class="Container">
		<?php include '../../Templates/admin menu.php' ?>
		<div class="ColumnMain">
			<section>
				<h2>Import database</h2>
				<div class="Box">
					<form>
						<label for="f1">User table:</label><input id="f1" name="f1" type="file"><br>
						<label for="f2">Company table:</label><input id="f2" name="f2" type="file"><br>
						<label for="f3">SocialMedia table:</label><input id="f3" name="f3" type="file"><br>
						<label for="f4">Image table:</label><input id="f4" name="f4" type="file"><br>
						<label for="f5">Tag table:</label><input id="f5" name="f5" type="file"><br>
						<label for="f6">Category table:</label><input id="f6" name="f6" type="file"><br>
						<input type="submit">
					</form>
				</div>
			</section>
			<section>
				<h2>Export database</h2>
				<div class="Box">
					<a href="#">Download table User</a><br>
					<a href="#">Download table Company</a><br>
					<a href="#">Download table SocialMedia</a><br>
					<a href="#">Download table Image</a><br>
					<a href="#">Download table ...</a><br>
				</div>
			</section>
		</div>
	</div>
	<?php include '../../Templates/page footer.php' ?>
</body>
</html>