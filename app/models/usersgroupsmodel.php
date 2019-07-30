<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 24/04/2018
 * Time: 05:47 م
 */

namespace PHPMVC\Models;


class UsersGroupsModel extends AbstractModel
{

    public $GroupId;
    public $GroupName;
    public static $primaryKey = 'GroupId';
    protected static $tableName = 'app_users_groups';
    protected static $tableSchema = array(
        'GroupId' => self::DATA_TYPE_INT,
        'GroupName' => self::DATA_TYPE_STR,

    );


}