<?php


namespace DataAccess;


use PDO;

class PostalCode extends DataAccess
{

    static function getTableSchema()
    {
        // TODO: Implement getTableSchema() method.
        return 'create table PostalCode(
            Code varchar(2) not null primary key,
            ProvinceID varchar(6),
            foreign key(ProvinceID) references Province(ProvinceID))';
    }

    /**
     * @param $filePath
     */
    public function insertData($filePath)
    {
        // TODO: Implement insertData() method.
        parent::importData($filePath, 'PostalCode', [
            'Code'          => PDO::PARAM_STR,
            'ProvinceID' => PDO::PARAM_STR
        ]);
    }
}