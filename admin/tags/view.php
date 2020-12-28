<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include '../../Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>
<body>
	<?php include '../../Templates/page header.php' ?>
	<div class="container">
		<?php include '../../Templates/admin menu.php' ?>
		<div class="column-main">
			<section>
				<h2>Base tags</h2>
				<div class="box">
					<table>
						<thead>
							<tr>
								<th style="width:50px">ID</th>
								<th style="width:99px">Tag names (english;spanish)</th>
								<th>Keywords (<a href="https://regex101.com" target="_blank">regular expression</a>)</th>
								<th style="width:50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($baseTags as $id => $tag)
								{
									echo '<tr>';
									echo   '<td><input type="text" value="', $id, '" disabled></td>';
									echo   '<td><input type="text" value="', $tag->names, '"></td>';
									echo   '<td><input type="text" value="', $tag->keywords, '"></td>';
									echo   '<td><input type="button" value="Update" disabled></td>';
									echo '</tr>';
								}
							?>
							<tr>
								<form method="post">
									<td><input type="text" name="TagID"></td>
									<td><input type="text" name="TagNames"></td>
									<td><input type="text" name="Keywords"></td>
									<td><input type="submit" value="Add"></td>
								</form>
							</tr>
						</tbody>
					</table>
				</div>
			</section>
			<section>
				<h2>Combined tags</h2>
				<div class="box">
					<table>
						<thead>
							<tr>
								<th style="width:99px">ID</th>
								<th>Tag names (english;spanish)</th>
								<th style="width:50px"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($combinedTags as $id => $tag)
								{
									echo '<tr>';
									echo   '<td><input type="text" value="', $id, '" disabled></td>';
									echo   '<td><input type="text" value="', $tag->names, '"></td>';
									echo   '<td><input type="button" value="Update" disabled></td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
	<?php include '../../Templates/page footer.php' ?>
</body>
</html>