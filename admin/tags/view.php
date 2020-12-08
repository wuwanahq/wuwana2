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
							<?php
								foreach ($tags as $id => $tag)
								{
									echo '<tr>';
									echo  '<td><input type="checkbox" ', $tag->isVisible ? 'checked' : '', '></td>';
									echo  '<td><input type="text" value="', $tag->name, '"></td>';
									echo  '<td><input type="text" value="', $tag->keywords, '"></td>';
									echo  '<td><input type="button" value="Update" disabled></td>';
									echo '</tr>';
								}
							?>
							<tr>
								<form method="post">
									<td><input type="checkbox" name="Visible"></td>
									<td><input type="text" name="TagName"></td>
									<td><input type="text" name="Keywords"></td>
									<td><input type="submit" value="Add new tag"></td>
								</form>
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