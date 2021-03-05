<?php
/**
 * Controller for the admin page to import/export data.
 * @link https://wuwana.com/admin/database
 */

if (filter_has_var(INPUT_GET, 'export'))
{
	$table = filter_input(INPUT_GET, 'export');
	header('Content-Description: File Transfer');

	switch ($table)
	{
		case 'UserAccount':
			header('Content-Disposition: attachment; filename="UserAccount' . date('Y-m-d') . '.tsv"');
			header('Content-Type: text/tab-separated-values');
			WebApp\Data::getUser()->exportData();
			exit;

		case 'Company':
			header('Content-Disposition: attachment; filename="Company' . date('Y-m-d') . '.tsv"');
			header('Content-Type: text/tab-separated-values');
			WebApp\Data::getCompany()->exportData();
			exit;

		case 'SocialMedia':
			header('Content-Disposition: attachment; filename="SocialMedia' . date('Y-m-d') . '.tsv"');
			header('Content-Type: text/tab-separated-values');
			WebApp\Data::getSocialMedia()->exportData();
			exit;

		case 'Image':
			header('Content-Disposition: attachment; filename="Image' . date('Y-m-d') . '.tsv"');
			header('Content-Type: text/tab-separated-values');
			WebApp\Data::getImage()->exportData();
			exit;

		case 'Tag':
			header('Content-Disposition: attachment; filename="Tag' . date('Y-m-d') . '.tsv"');
			header('Content-Type: text/tab-separated-values');
			WebApp\Data::getTag()->exportData();
			exit;

		case 'schema':
			header('Content-Disposition: attachment; filename="Schema' . date('Y-m-d') . '.sql"');
			header('Content-Type: application/sql');
			echo "-- Wuwana database",
				"\n\n", DataAccess\User::getTableSchema(), ";",
				"\n\n", DataAccess\Tag::getTableSchema(), ";",
				"\n\n", DataAccess\Company::getTableSchema(), ";",
				"\n\n", DataAccess\SocialMedia::getTableSchema(), ";",
				"\n\n", DataAccess\Image::getTableSchema(), ";";
			exit;
	}
}