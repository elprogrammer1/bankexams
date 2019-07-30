<?php

namespace PHPMVC\Models;

class UsertypeModel extends AbstractModel
{
    public $TYPE_ID;
    public $DECS;


    public static $tableName = 'user_type';
    protected static $tableSchema = array(
        'TYPE_ID' => self::DATA_TYPE_INT,
        'DECS' => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'TYPE_ID';

    function __construct()
    {
    }


}
