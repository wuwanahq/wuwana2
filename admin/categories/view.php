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
				<h2>Categories</h2>
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
		</div>
	</div>
	<?php include '../../Templates/page footer.php' ?>
</body>
</html>