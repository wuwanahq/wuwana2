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
		<section class="column-left">
			<?php include 'Templates/navbar.php' ?>
		</section>
		<main>
			<?php if(!$user->isAdmin()): ?>
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
			<section id="section-table">
				<h2>Categories</h2>
				<div class="box-table">
					<div class="scroll-h">
						<table>
							<thead>
								<tr>
									<th>Category</th>
									<th style="min-width: 200px;">Tags combination</th>
									<th id="entry-button"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" value="Coffee Shop"></td>
									<td><input type="text" value="CoffeeShop + SpecialtyCoffee"></td>
									<td><input type="button" value="Update" disabled></td>
								</tr>
								<tr>
									<td><input type="text" value="Roaster"></td>
									<td><input type="text" value="Roaster + SpecialtyCoffee"></td>
									<td><input type="button" value="Update" disabled></td>
								</tr>
								<tr>
									<td><input type="text" value="Importer"></td>
									<td><input type="text" value="Importer + SpecialtyCoffee"></td>
									<td><input type="button" value="Update" disabled></td>
								</tr>
								<tr>
									<td><input type="text"></td>
									<td><input type="text"></td>
									<td><input type="button" value="Add"></td>
								</tr>
							</tbody>
						</table>
						<div></div>
					</div>
				</div>
			</section>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>