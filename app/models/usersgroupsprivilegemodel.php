<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 24/04/2018
 * Time: 05:47 م
 */

namespace PHPMVC\Models;


class UsersGroupsPrivilegeModel extends AbstractModel
{

    public $Id;
    public $GroupId;
    public $GroupName;
    public static $primaryKey = 'Id';
    protected static $tableName = 'app_users_groups_privileges';
    protected static $tableSchema = array(
        'Id' => self::DATA_TYPE_INT,
        'GroupId' => self::DATA_TYPE_INT,
        'PrivilegeId' => self::DATA_TYPE_STR,

    );

    public static function getGroupPrivileges(UsersGroupsModel $group)
    {
        $groupPrivileges = self::getBy(['GroupId' => $group->GroupId]);
        $extractedPrivilegesIds = [];
        if (false !== $groupPrivileges) {
            foreach ($groupPrivileges as $privilege) {
                $extractedPrivilegesIds[] = strtolower($privilege->PrivilegeId);
            }
        }
        return $extractedPrivilegesIds;
    }

    public static function getPrivilegesForGroup($groupId)
    {
        $sql = 'SELECT augp.*, aup.Privilege FROM ' . self::$tableName . ' augp';
        $sql .= ' INNER JOIN app_users_privileges aup ON aup.PrivilegeId = augp.PrivilegeId';
        $sql .= ' WHERE augp.GroupId = ' . $groupId;
        $privileges = self::get($sql);
        $extractedUrls = [];
        if (false !== $privileges) {
            foreach ($privileges as $privilege) {
                $extractedUrls[] = $privilege->Privilege;
            }
        }
        return $extractedUrls;

    }

}