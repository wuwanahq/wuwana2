<?php


namespace DataAccess;


use PDO;

class Region extends DataAccess
{

    static function getTableSchema()
    {
        return 'create table Region (
            RegionID varchar(6),
            EN varchar(100),
            ES varchar(100),
            FR varchar(100),
            ZH varchar(100),
            primary key(RegionID))';
    }

    public function insertData($filePath)
    {
        parent::importData($filePath, 'Region', [
            'RegionID' => PDO::PARAM_STR,
            'EN' => PDO::PARAM_STR,
            'ES'  => PDO::PARAM_STR,
            'FR'  => PDO::PARAM_STR,
            'ZH'  => PDO::PARAM_STR
        ]);
    }
}