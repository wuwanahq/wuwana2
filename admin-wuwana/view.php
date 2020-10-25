<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Wuwana administration page</title>
</head>
<body>
	<h1>Overwrite tables in the database</h1>
	<i>Notes:</i>
	<ul>
		<li>All files need to be in the TSV format (Tab-Separated Values)</li>
		<li>The first line (header) is always ignored</li>
		<li>Columns in the file needs to respect the order between parentheses</li>
		<li>Column with multiple values (like CategoriesID) need to be surrounded by a semi-colon</li>
		<li>You can update one, two or all tables</li>
	</ul>
	<form method="post" enctype="multipart/form-data">
		<p>
			<b>Categories</b> (<?php echo implode(',', array_keys(DataAccess\Category::COLUMNS)) ?>):
			<input type="file" name="Cat"/><br>
			<b>Locations</b> (<?php echo implode(',', array_keys(DataAccess\Location::COLUMNS)) ?>):
			<input type="file" name="Loc"/><br>
			<b>Companies</b> (<?php echo implode(',', array_keys(DataAccess\Company::COLUMNS)) ?>):
			<input type="file" name="Comp"/><br>
		</p>
		<p>
			Password: <input type="password" name="Pass">
			<input type="submit" value="Upload tables">
		</p>
	</form>
	<b><?php echo $message ?></b>
</body>
</html>