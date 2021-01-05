<?php
/**
 * Controller for the admin page to import/export data.
 * @link https://wuwana.com/admin/database
 */

if (filter_has_var(INPUT_GET, 'export'))
{
	$table = filter_input(INPUT_GET, 'export');

	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="' . $table . '.tsv"');
	header('Content-Type: text/csv');

	switch ($table)
	{
		case 'UserAccount': WebApp\Data::getUser()->exportData(); exit;
		case 'Company': WebApp\Data::getCompany()->exportData(); exit;
		case 'SocialMedia': WebApp\Data::getSocialMedia()->exportData(); exit;
		case 'Image': WebApp\Data::getImage()->exportData(); exit;
		case 'Tag': WebApp\Data::getTag()->exportData(); exit;
		case 'schema':
			echo "-- Wuwana database\n",
				"\n", DataAccess\User::getTableSchema(),
				"\n", DataAccess\Tag::getTableSchema(),
				"\n", DataAccess\Company::getTableSchema(),
				"\n", DataAccess\SocialMedia::getTableSchema(),
				"\n", DataAccess\Image::getTableSchema();
	}
}