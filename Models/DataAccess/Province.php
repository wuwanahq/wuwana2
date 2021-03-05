<?php
namespace DataAccess;
use PDO;

class Province extends DataAccess
{
    static function getTableSchema(){
        return 'create table Province (
            ProvinceID varchar(6),
            EN varchar(100),
            ES varchar(100),
            FR varchar(100),
            ZH varchar(100),
            RegionID varchar(6),
            primary key(ProvinceID),
            foreign key(RegionID) references Region(RegionID))';
    }

    public function insertData($filePath)
    {
        parent::importData($filePath, 'Province', [
            'ProvinceID' => PDO::PARAM_STR,
            'EN' => PDO::PARAM_STR,
            'ES'  => PDO::PARAM_STR,
            'FR'  => PDO::PARAM_STR,
            'ZH'  => PDO::PARAM_STR,
            'RegionID'  => PDO::PARAM_STR,
        ]);
    }
}