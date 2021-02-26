<?php


namespace DataAccess;


use PDO;

class PostalCode extends DataAccess
{

    static function getTableSchema()
    {
        // TODO: Implement getTableSchema() method.
        return 'create table PostalCode(
            Code int not null primary key,
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
            'Code'          => PDO::PARAM_INT,
            'ProvinceID' => PDO::PARAM_STR
        ]);
    }
}