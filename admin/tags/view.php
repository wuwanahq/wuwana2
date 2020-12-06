<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include '../../Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>
<body>
	<?php include '../../Templates/page header.php' ?>
	<div class="Container">
		<?php include '../../Templates/admin menu.php' ?>
		<div class="ColumnMain">
			<section>
				<h2>Tags</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Visible?</th>
								<th>Tag name</th>
								<th>Keywords</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" checked></td>
								<td><input type="text" value="Roaster"></td>
								<td><input type="text" value="roaster;tostador (roaster|tostador|etc)"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox" checked></td>
								<td><input type="text" value="CoffeeShop"></td>
								<td><input type="text" value="coffee shop;cafetería;café"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox" checked></td>
								<td><input type="text" value="Importer"></td>
								<td><input type="text" value="importer;importador;importateur"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox" checked></td>
								<td><input type="text" value="Restaurant"></td>
								<td><input type="text" value="restaurant;restaurante"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><input type="text" value="SpecialtyCoffee"></td>
								<td><input type="text" value="specialty coffee;café de especialidad"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><input type="text" value="Coffee"></td>
								<td><input type="text" value="coffee;café"></td>
								<td><input type="button" value="Update" disabled></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><input type="text"></td>
								<td><input type="text"></td>
								<td><input type="button" value="Add"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
	<?php include '../../Templates/page footer.php' ?>
</body>
</html>