<?php
namespace DataAccess;
use PDO;
use PDOStatement;

/**
 * Data access layer for stored companies.
 * @license https://mozilla.org/MPL/2.0 This Source Code is subject to the terms of the Mozilla Public License v2.0
 */
class Company extends DataAccess
{
	const VALUES_DELIMITER = ';';

	static function getTableSchema()
	{
		return 'create table Company (
			PermaLink varchar(250) primary key,
			ID int not null,
			Name varchar(250) not null,
			LogoURL varchar(255) not null,
			Description varchar(255) not null,
			Website varchar(255) not null,
			Email varchar(255) not null,
			PhonePrefix tinyint not null,
			PhoneNumber int not null,
			Address varchar(255) not null,
			ProvinceID varchar(6) not null,
			FirstTagID varchar(250) not null,
			SecondTagID varchar(250) not null,
			OtherTags varchar(255) not null,
			LastUpdate int not null,
			PostalCode varchar(2),
			foreign key(ProvinceID) references Province(ProvinceID))';
	}

	public function insertData($filePath)
	{
		parent::importData($filePath, 'Company', [
			'PermaLink'   => PDO::PARAM_STR,
			'ID'          => PDO::PARAM_INT,
			'Name'        => PDO::PARAM_STR,
			'LogoURL'     => PDO::PARAM_STR,
			'Description' => PDO::PARAM_STR,
			'Website'     => PDO::PARAM_STR,
			'Email'       => PDO::PARAM_STR,
			'PhonePrefix' => PDO::PARAM_INT,
			'PhoneNumber' => PDO::PARAM_INT,
			'Address'     => PDO::PARAM_STR,
			'ProvinceID'  => PDO::PARAM_STR,
			'FirstTagID'  => PDO::PARAM_STR,
			'SecondTagID' => PDO::PARAM_STR,
			'OtherTags'   => PDO::PARAM_STR,
			'LastUpdate'  => PDO::PARAM_INT,
            'PostalCode'  => PDO::PARAM_STR
		]);
	}

	public function exportData()
	{
		parent::exportTable('Company');
	}

	/**
	 * Get a company by its permanent link.
	 * @param string $permalink
	 * @return \DataAccess\Company
	 */
	public function selectPermalink($permalink, $tagsLanguage)
	{
		$tagsLanguage = strtoupper($tagsLanguage);
		$query = $this->tryQuery("select
			Company.Name as CompanyName,
			Company.LogoURL as CompanyLogoURL,
			Company.Description as CompanyDescription,
			Company.Website as CompanyWebsite,
			Company.Email as CompanyEmail,
			Company.Address as CompanyAddress,
			Province.$tagsLanguage as LocationProvince,
			Company.PhonePrefix as CompanyPhonePrefix,
			Company.PhoneNumber as CompanyPhoneNumber,
			Company.PostalCode as CompanyPostalCode,
			T1.Names as TagName1,
			T2.Names as TagName2,
			SocialMedia.URL as SocialMediaURL,
			SocialMedia.ProfileName as SocialMediaProfileName,
			SocialMedia.Biography as SocialMediaBiography,
			SocialMedia.ExternalLink as SocialMediaExternalLink,
			SocialMedia.Counter1 as SocialMediaCounter1,
			SocialMedia.Counter2 as SocialMediaCounter2,
			SocialMedia.Counter3 as SocialMediaCounter3,
			Image.URL as ImageURL,
			Company.LastUpdate as CompanyLastUpdate
			from Company
			left join Province on Company.ProvinceID=Province.ProvinceID
			inner join SocialMedia on Company.ID=SocialMedia.CompanyID
			left join Image on SocialMedia.CompanyID=Image.CompanyID and SocialMedia.ID=Image.SocialMediaID
			left join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID
			where Company.PermaLink=?", true);

		$query->bindValue(1, $permalink, PDO::PARAM_STR);
		$query->execute();
		$company = null;

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			if ($company == null)
			{
				$company = new CompanyData();
				$company->name = $row['CompanyName'];
				$company->logo = $row['CompanyLogoURL'];
				$company->description = $row['CompanyDescription'];
				$company->website = $row['CompanyWebsite'];
				$company->email = $row['CompanyEmail'];
				$company->address = $row['CompanyAddress'];
				$company->region = $row['LocationProvince'];
				$company->lastUpdate = $row['CompanyLastUpdate'];
				$company->postalCode = $row['CompanyPostalCode'];

				if ($row['TagName1'] != '')
				{
					$company->tags[] =
						explode(parent::VALUES_DELIMITER, $row['TagName1'])[Tag::getLanguageIndex($tagsLanguage)];
				}

				if ($row['TagName2'] != '')
				{
					$company->tags[] =
						explode(parent::VALUES_DELIMITER, $row['TagName2'])[Tag::getLanguageIndex($tagsLanguage)];
				}

				if ($row['CompanyPhonePrefix'] != 0 && $row['CompanyPhoneNumber'] != 0)
				{
					$company->phone =
						$row['CompanyPhonePrefix'] . str_pad($row['CompanyPhoneNumber'], 9, '0', STR_PAD_LEFT);
				}
			}

			$socialMedia = new SocialMediaData($row);

			switch ($socialMedia->getWebsite())
			{
				case 'instagram.com':
					if (empty($company->instagram))
					{ $company->instagram = $socialMedia; }
					$company->instagram->pictures[] = $row['ImageURL'];
					break;

				case 'facebook.com':
					if (empty($company->facebook))
					{ $company->facebook = $socialMedia; }
					$company->facebook->pictures[] = $row['ImageURL'];
					break;
			}
		}

		return $company;
	}

	public function selectAll($tagsLanguage = null)
	{
		$query = $this->pdo->query('select
			Company.PermaLink as CompanyPermaLink,
			Company.Name as CompanyName,
			Company.Description as CompanyDescription,
			Company.LastUpdate as CompanyLastUpdate,
			Province.EN as LocationProvince,
			Company.FirstTagID as CompanyFirstTagID,
			Company.SecondTagID as CompanySecondTagID,
			Company.OtherTags as CompanyOtherTags,
			Company.PostalCode as CompanyPostalCode,
			T1.Names as TagName1,
			T2.Names as TagName2
			from Company
			left join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID
			inner join Province on Company.ProvinceID=Province.ProvinceID
			order by Company.LastUpdate desc');

		$companies = [];

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$company = new CompanyData();
			$company->permalink = $row['CompanyPermaLink'];
			$company->name = $row['CompanyName'];
			$company->description = $row['CompanyDescription'];
			$company->region = $row['LocationProvince'];
			$company->lastUpdate = $row['CompanyLastUpdate'];
			$company->otherTags = $row['CompanyOtherTags'];

			$company->postalCode = $row['CompanyPostalCode'];

			if ($row['TagName1'] != '')
			{
				$company->visibleTags[] = $tagsLanguage == null
					? $row['CompanyFirstTagID']
					: explode(parent::VALUES_DELIMITER, $row['TagName1'])[Tag::getLanguageIndex($tagsLanguage)];
			}

			if ($row['TagName2'] != '')
			{
				$company->visibleTags[] = $tagsLanguage == null
					? $row['CompanySecondTagID']
					: explode(parent::VALUES_DELIMITER, $row['TagName2'])[Tag::getLanguageIndex($tagsLanguage)];
			}

			$companies[] = $company;
		}

		return $companies;
	}

	/**
	 * Return companies in the selected region.
	 * @param string $tagsLanguage
	 * @param array $regions
	 * @param int $limit
	 * @return array
	 */
	public function selectRegions($tagsLanguage, $regions = [], $limit = 0)
	{
		$companies = [];
		$sql = 'select
			Company.PermaLink as CompanyPermaLink,
			Company.Name as CompanyName,
			Company.LogoURL as CompanyLogoURL,
			Province.' . strtoupper($tagsLanguage->code) . ' as ProvinceName,
			Company.PostalCode as CompanyPostalCode,
			T1.Names as TagName1,
			T2.Names as TagName2
			from Company
			left join Province on Company.ProvinceID=Province.ProvinceID
			left join Tag as T1 on Company.FirstTagID=T1.ID
			left join Tag as T2 on Company.SecondTagID=T2.ID';

		if (!empty($regions))
		{ $sql .= ' where Province.RegionID in ("' . implode('","', $regions) . '")'; }

		$query = $this->tryQuery($sql . ' order by Company.LastUpdate desc');

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$company = new CompanyData();
			$company->permalink = $row['CompanyPermaLink'];
			$company->name = $row['CompanyName'];
			$company->logo = $row['CompanyLogoURL'];
			//$company->description = $row['Description'];
			//$company->website = $row['Website'];
			//$company->phone = $row['PhonePrefix'] . str_pad($row['PhoneNumber'], 9, '0', STR_PAD_LEFT);
			//$company->email = $row['Email'];

            $company->postalCode = $row['CompanyPostalCode'];

			$company->region = $row['ProvinceName'];

			if ($row['TagName1'] != '')
			{
				$company->tags[] =
					explode(parent::VALUES_DELIMITER, $row['TagName1'])[Tag::getLanguageIndex($tagsLanguage)];
			}

			if ($row['TagName2'] != '')
			{
				$company->tags[] =
					explode(parent::VALUES_DELIMITER, $row['TagName2'])[Tag::getLanguageIndex($tagsLanguage)];
			}

			$companies[$row['CompanyPermaLink']] = $company;

			if (--$limit == 0)
			{ break; }
		}

		return $companies;
	}

	/**
	 * Get the oldest Instagram profile available.
	 * @param int $minInterval seconds since last update
	 * @return string Page URL or empty everything is up to date
	 */
	public function selectOldestInstagramURL($minInterval)
	{
		$query = $this->pdo->query('select
			SocialMedia.URL as SocialMediaURL,
			Company.LastUpdate as CompanyLastUpdate
			from Company inner join SocialMedia on Company.ID=SocialMedia.CompanyID
			where SocialMedia.URL like "instagram%"
			order by Company.LastUpdate');

		$row = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (empty($row['CompanyLastUpdate']) || time() - $row['CompanyLastUpdate'] < $minInterval)
		{ return ''; }

		return 'https://' . $row['SocialMediaURL'];
	}

	public function update(CompanyData $company, $id)
	{
		$otherTags = implode(self::VALUES_DELIMITER, $company->otherTags);
		$i = count($company->otherTags);

        if (empty($company->postalCode)){
            $company->region = $this->fetchProvinceID(null);
        }else{
            $company->region = $this->fetchProvinceID(substr($company->postalCode,0,2));
        }

		while(strlen($otherTags) > 255)
		{ $otherTags = implode(self::VALUES_DELIMITER, array_slice($company->otherTags, 0, --$i)); }

		$query = $this->pdo->prepare('update Company
			set Name=?,Description=?,LogoURL=?,Website=?,PhonePrefix=?,PhoneNumber=?,
				Email=?,Address=?,ProvinceID=?,FirstTagID=?,SecondTagID=?,OtherTags=?,LastUpdate=?,PostalCode=?
			where ID=?');

		$query->bindValue(1, $company->name, PDO::PARAM_STR);
		$query->bindValue(2, $company->description, PDO::PARAM_STR);
		$query->bindValue(3, $company->logo, PDO::PARAM_STR);
		$query->bindValue(4, $company->website, PDO::PARAM_STR);
		$query->bindValue(5, (int)substr($company->phone, 0, -9), PDO::PARAM_INT);
		$query->bindValue(6, (int)substr($company->phone, -9), PDO::PARAM_INT);
		$query->bindValue(7, $company->email, PDO::PARAM_STR);
		$query->bindValue(8, $company->address, PDO::PARAM_STR);
		$query->bindValue(9, $company->region, PDO::PARAM_STR);
		$query->bindValue(10, isset($company->visibleTags[0]) ? $company->visibleTags[0] : '', PDO::PARAM_STR);
		$query->bindValue(11, isset($company->visibleTags[1]) ? $company->visibleTags[1] : '', PDO::PARAM_STR);
		$query->bindValue(12, $otherTags, PDO::PARAM_STR);
		$query->bindValue(13, time(), PDO::PARAM_INT);

		$query->bindValue(14,$company->postalCode, PDO::PARAM_STR);

		$query->bindValue(15, $id, PDO::PARAM_INT);
		$query->execute();

		$socialMedia = new SocialMedia($this->pdo);
		$socialMedia->update($company->instagram, $id);
	}

    public function fetchProvinceID($postalCode)
	{
		$query = $this->tryQuery('select Province.ProvinceID from Province
			inner join PostalCode on PostalCode.ProvinceID = Province.ProvinceID
			where PostalCode.Code = ?', true);

		$query->bindValue(1, $postalCode, PDO::PARAM_STR);
		$values = $query->fetchAll(PDO::FETCH_COLUMN, 0);

		if (isset($values[0]))
		{ return $values[0]; }

		return '';
    }

	public function insert(CompanyData $company)
	{
		$otherTags = implode(self::VALUES_DELIMITER, $company->otherTags);
		$i = count($company->otherTags);

		if (empty($company->postalCode)){
		    $company->region = $this->fetchProvinceID(null);
        }else{
		    $company->region = $this->fetchProvinceID(substr($company->postalCode,0,2));
        }

		while(strlen($otherTags) > 255)
		{ $otherTags = implode(self::VALUES_DELIMITER, array_slice($company->otherTags, 0, --$i)); }

		$query = $this->pdo->query('select coalesce(max(ID)+1,' . self::INT_MIN . ') from Company');
		$query->execute();
		$id = $query->fetchAll(PDO::FETCH_COLUMN,0)[0];

		$permalink = $company->getDefaultPermalink();
		$i = 0;

		do
		{
			$query = $this->pdo->prepare('insert into Company
				(PermaLink,ID,Name,Description,LogoURL,Website,PhonePrefix,PhoneNumber,
					Email,Address,ProvinceID,FirstTagID,SecondTagID,OtherTags,LastUpdate,PostalCode)
				values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

			$query->bindValue(1, ++$i > 1 ? $permalink . $i : $permalink, PDO::PARAM_STR);
			$query->bindValue(2, $id, PDO::PARAM_INT);
			$query->bindValue(3, $company->name, PDO::PARAM_STR);
			$query->bindValue(4, $company->description, PDO::PARAM_STR);
			$query->bindValue(5, $company->logo, PDO::PARAM_STR);
			$query->bindValue(6, $company->website, PDO::PARAM_STR);
			$query->bindValue(7, (int)substr($company->phone, 0, -9), PDO::PARAM_INT);
			$query->bindValue(8, (int)substr($company->phone, -9), PDO::PARAM_INT);
			$query->bindValue(9, $company->email, PDO::PARAM_STR);
			$query->bindValue(10, $company->address, PDO::PARAM_STR);
			$query->bindValue(11, $company->region, PDO::PARAM_STR);
			$query->bindValue(12, isset($company->visibleTags[0]) ? $company->visibleTags[0] : '', PDO::PARAM_STR);
			$query->bindValue(13, isset($company->visibleTags[1]) ? $company->visibleTags[1] : '', PDO::PARAM_STR);
			$query->bindValue(14, $otherTags, PDO::PARAM_STR);
			$query->bindValue(15, time(), PDO::PARAM_INT);

			$query->bindValue(16,$company->postalCode,PDO::PARAM_STR);
		}
		while ($query->execute() == false);

		$socialMedia = new SocialMedia($this->pdo);
		$socialMedia->insert($company->instagram, $id);
	}
}