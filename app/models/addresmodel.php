<?php

namespace PHPMVC\Models;

class AddresModel extends AbstractModel
{
    public $ADDRESS_ID;
    public $CITY;
    public $COUNTRY;
    public $REGION;
    public $STREET;


    public static $tableName = 'address';
    protected static $tableSchema = array(
        'ADDRESS_ID' => self::DATA_TYPE_INT,
        'CITY' => self::DATA_TYPE_INT,
        'COUNTRY' => self::DATA_TYPE_STR,
        'REGION' => self::DATA_TYPE_STR,
        'STREET' => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'ADDRESS_ID';

    function __construct()
    {
    }


}
