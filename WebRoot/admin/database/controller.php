<?php
/**
 * Controller for the admin page to import/export data.
 * @link https://wuwana.com/admin/database
 */

if (!$user->isAdmin())
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

	if (!empty($_FILES['UserAccount'])
		&& !empty($_FILES['Company'])
		&& !empty($_FILES['SocialMedia'])
		&& !empty($_FILES['Image'])
		&& !empty($_FILES['Tag']))
	{
		$debug = $_FILES;

		//TODO: $x = new DataAccess\User();
	}
}