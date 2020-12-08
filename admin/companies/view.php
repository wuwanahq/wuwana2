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
				<h2>New company</h2>
				<div class="Box">
					<form method="post">
						<label for="instagram">Instagram profile URL:</label>
						<input id="instagram" name="instagram" type="text" size="80">
						<br>
						<label for="website">Website URL:</label>
						<input id="website" name="website" type="text" size="89">
						<br>
						<label for="email">Email address:</label>
						<input id="email" name="email" type="text" size="81">
						<input type="submit" value="Add">
					</form>
				</div>
			</section>
			<section>
				<h2>Companies</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Location</th>
								<th>Tags</th>
								<th>Last update</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($companies as $company)
								{
									echo '<tr>';
									echo  '<td><a href="http://', WebApp\WebApp::getHostname(), '/', $company->permalink, '">';
									echo   $company->name;
									echo  '</a></td>';
									echo  '<td>', substr($company->description, 0, 30), '...</td>';
									echo  '<td>', $company->region, '</td>';
									echo  '<td>', implode(' ', $company->tags), '</td>';
									echo  '<td>', date('Y-m-d H:i', $company->lastUpdate), '</td>';
									echo  '<td><input type="button" value="Delete" disabled></td>';
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