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
				<h2>Companies</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Permalink</th>
								<th>Name</th>
								<th>Location</th>
								<th>Tags</th>
								<th>Last update</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="/example-company1">wuwana.com/example-company1</a></td>
								<td>Example Company n°1</td>
								<td>Madrid</td>
								<td>CoffeeShop Roaster</td>
								<td>10min ago</td>
								<td><input type="button" value="Delete"></td>
							</tr>
							<tr>
								<td><a href="/example-company2">wuwana.com/example-company2</a></td>
								<td>Example Company n°2</td>
								<td>Valencia</td>
								<td>Importer Coffee</td>
								<td>20min ago</td>
								<td><input type="button" value="Delete"></td>
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