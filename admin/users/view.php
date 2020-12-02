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
				<h2>Users</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Email</th>
								<th>Name</th>
								<th>Company</th>
								<th>Access code</th>
								<th>Last login</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>j…@wuwana.com</td>
								<td>Jonathan</td>
								<td>ADMIN</td>
								<td>12345</td>
								<td>2 days ago</td>
								<td><input type="button" value="Delete"></td>
							</tr>
							<tr>
								<td>v…@gmail.com</td>
								<td>Vince</td>
								<td>Example Company n°1</td>
								<td>74537</td>
								<td>1 week ago</td>
								<td><input type="button" value="Delete"></td>
							</tr>
							<tr>
								<td>x…@hotmail.com</td>
								<td>x…@hotmail.com</td>
								<td>Example Company n°2</td>
								<td>00000</td>
								<td></td>
								<td><input type="button" value="Delete"></td>
							</tr>
							<tr>
								<td>y…@outlook.com</td>
								<td>y…@outlook.com</td>
								<td></td>
								<td>00000</td>
								<td></td>
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