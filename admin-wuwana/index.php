<?php
/**
 * Controller for the admin page.
 * @link http://wuwana.com/admin-wuwana
 */

spl_autoload_register(function($className) {
	require '../Model/' . str_replace('\\', '/', $className) . '.php';
});

$message = '';

if (WebApp\Config::ADMIN_PASSWORD === filter_input(INPUT_POST, 'Pass'))
{
	$db = new DataAccess\DataAccess(WebApp\WebApp::getDatabase());

	if (!empty($_FILES['Cat']['tmp_name'])
		&& is_uploaded_file($_FILES['Cat']['tmp_name'])
		&& filesize($_FILES['Cat']['tmp_name']) > 2)
	{
		$db->recreateTableCategory();
		$db->insertData($_FILES['Cat']['tmp_name'], DataAccess\Category::TABLE_NAME, DataAccess\Category::COLUMNS);
		$message .= 'Category file imported (' . $_FILES['Cat']['name'] . ').<br>';
	}

	if (!empty($_FILES['Loc']['tmp_name'])
		&& is_uploaded_file($_FILES['Loc']['tmp_name'])
		&& filesize($_FILES['Loc']['tmp_name']) > 2)
	{
		$db->recreateTableLocation();
		$db->insertData($_FILES['Loc']['tmp_name'], DataAccess\Location::TABLE_NAME, DataAccess\Location::COLUMNS);
		$message .= 'Location file imported (' . $_FILES['Loc']['name'] . ').<br>';
	}

	if (!empty($_FILES['Comp']['tmp_name'])
		&& is_uploaded_file($_FILES['Comp']['tmp_name'])
		&& filesize($_FILES['Comp']['tmp_name']) > 2)
	{
		$db->recreateTableCompany();
		$db->insertData($_FILES['Comp']['tmp_name'], DataAccess\Company::TABLE_NAME, DataAccess\Company::COLUMNS);
		$message .= 'Company file imported (' . $_FILES['Comp']['name'] . ').<br>';
	}
}

require 'view.php';