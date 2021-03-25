<?php
/**
 * Controller for the admin page to import/export data.
 * @link https://wuwana.com/admin/database
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */

if ($user->isAdmin())
{
	if (filter_has_var(INPUT_GET, 'export'))
	{
		$table = filter_input(INPUT_GET, 'export');
		header('Content-Description: File Transfer');

		switch ($table)
		{
			case 'UserAccount':
			case 'Company':
			case 'SocialMedia':
			case 'Image':
			case 'Tag':
				header('Content-Disposition: attachment; filename="' . $table . date('Y-m-d') . '.tsv"');
				header('Content-Type: text/tab-separated-values');
				break;

			case 'schema':
				header('Content-Disposition: attachment; filename="Schema' . date('Y-m-d') . '.sql"');
				header('Content-Type: application/sql');
				break;
		}

		switch ($table)
		{
			case 'UserAccount': (new DataAccess\User())->exportData(); exit;
			case 'Company':     (new DataAccess\Company())->exportData(); exit;
			case 'SocialMedia': (new DataAccess\SocialMedia())->exportData(); exit;
			case 'Image':       (new DataAccess\Image())->exportData(); exit;
			case 'Tag':         (new DataAccess\Tag())->exportData(); exit;
			case 'schema':
				echo "-- Wuwana database",
					"\n\n", DataAccess\User::getTableSchema(), ";",
					"\n\n", DataAccess\Tag::getTableSchema(), ";",
					"\n\n", DataAccess\Company::getTableSchema(), ";",
					"\n\n", DataAccess\SocialMedia::getTableSchema(), ";",
					"\n\n", DataAccess\Image::getTableSchema(), ";";
				exit;
		}
	}

	if (!empty($_FILES['UserAccount']) && is_uploaded_file($_FILES['UserAccount']['tmp_name'])
		&& !empty($_FILES['Company']) && is_uploaded_file($_FILES['Company']['tmp_name'])
		&& !empty($_FILES['SocialMedia']) && is_uploaded_file($_FILES['SocialMedia']['tmp_name'])
		&& !empty($_FILES['Image']) && is_uploaded_file($_FILES['Image']['tmp_name'])
		&& !empty($_FILES['Tag']) && is_uploaded_file($_FILES['Tag']['tmp_name']))
	{
		$dao = new DataAccess\User();
		$dao->deleteAll();
		$dao->insertData($_FILES['UserAccount']['tmp_name']);

		$dao = new DataAccess\Company();
		$dao->deleteAll();
		$dao->insertData($_FILES['Company']['tmp_name']);

		$dao = new DataAccess\SocialMedia();
		$dao->deleteAll();
		$dao->insertData($_FILES['SocialMedia']['tmp_name']);

		$dao = new DataAccess\Image();
		$dao->deleteAll();
		$dao->insertData($_FILES['Image']['tmp_name']);

		$dao = new DataAccess\Tag();
		$dao->deleteAll();
		$dao->insertData($_FILES['Tag']['tmp_name']);
	}
}

require 'admin/database/view.php';