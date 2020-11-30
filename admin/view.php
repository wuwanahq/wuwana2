<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Wuwana admin page</title>
	<link rel="stylesheet" type="text/css" href="/static/style.css">
	<script src="/static/es5.js" defer></script>
	<style>
		.ColumnMain table {
			width: 100%}

		.ColumnMain table input {
			width: 98%}

		.ColumnMain table th,
		.ColumnMain table td {
			text-align: center}

		.ColumnMain table th:first-child,
		.ColumnMain table td:first-child,
		.ColumnMain table th:last-child,
		.ColumnMain table td:last-child {
			width: 99px}
	</style>
</head>
<body>
	<header class="HeaderBar">
		<div class="HeaderContainer">
			<div class="HeaderLogo"><a href="/"><img src="/static/logo/wuwana.svg"></a></div>
		</div>
	</header>
	<div class="Container">
		<div class="ColumnLeft Company">
			<div class="Box Profile">
				<section class="CompanyAbout">
					<div class="Logo">
						<img src="/static/favicon/96.png">
					</div>
					<h1>Website stats</h1>
					0 users registered<br>
					0 real users<br>
				</section>
			</div>
		</div>
		<div class="ColumnMain">
			<section>
				<h2>Scraper options</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Tag</th>
								<th>Keywords</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="text" value="Roaster"></td>
								<td><input type="text" value="roaster;tostador (roaster|tostador|etc)"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="text" value="CoffeeShop"></td>
								<td><input type="text" value="coffee shop;cafetería;café"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="text" value="Importer"></td>
								<td><input type="text" value="importer;importador;importateur"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="text" value="Restaurant"></td>
								<td><input type="text" value="restaurant;restaurante"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="text" value="SpecialtyCoffee"></td>
								<td><input type="text" value="specialty coffee;café de especialidad"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="text"></td>
								<td><input type="text"></td>
								<td><input type="button" value="Add"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>
			<section>
				<h2>Category options</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Category</th>
								<th>Tags combination</th>
								<th></th>
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
				</div>
			</section>
			<a class="Center" href="/">
				<div class="Button Center"><img src="/static/icon/home.svg"> Volver a la pagina principal</div>
			</a>
		</div>
	</div>
	<?php include '../Templates/footer.php' ?>
</body>
</html>