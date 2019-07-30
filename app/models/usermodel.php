<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 24/04/2018
 * Time: 05:47 م
 */

namespace PHPMVC\Models;


class userModel extends AbstractModel
{
    public $USER_ID;
    public $TYPE_ID;
    public $ADDRESS_ID;
    public $FULL_NAME;
    public $USER_NAME;
    public $EMAIL;
    public $PASSWORD;
    public $BIRTHDAY;
    public $PHONE_NUMBER;
    public $active = 0;
 // ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER

    public static $tableName = 'users';

    protected static $tableSchema = array(
        'TYPE_ID' => self::DATA_TYPE_INT,
        'FULL_NAME' => self::DATA_TYPE_STR,
        'USER_ID' => self::DATA_TYPE_INT,
        'ADDRESS_ID' => self::DATA_TYPE_INT,
        'USER_NAME' => self::DATA_TYPE_STR,
        'EMAIL' => self::DATA_TYPE_STR,
        'PASSWORD' => self::DATA_TYPE_STR,
        'BIRTHDAY' => self::DATA_TYPE_DATE,
        'active' => self::DATA_TYPE_INT,
        'PHONE_NUMBER' => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'USER_ID';

    public function cryptPassword($password)
    {
        $this->PASSWORD = crypt($password, APP_SALT);
    }

    // TODO:: FIX THE TABLE ALIASING
    public static function getUsers(UserModel $user)
    {
        return self::get(
            'SELECT au.*  FROM ' . self::$tableName . ' au  WHERE au.USER_ID != ' . $user->USER_ID
        );
    }

    public static function userExistsEmail($email)
    {
        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE Email = "' . $email . '" ');
    }

    public static function userExists($username)
    {
        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE Username = "' . $username . '" ');
    }

    public static function authenticate($username, $password, $session)
    {
        // where (  `USER_NAME` = '$username' or Email = '$username'  ) and PASSWORD = '$pass'
        $password = crypt($password, APP_SALT);
        $sql = 'SELECT *  FROM ' . self::$tableName . ' WHERE (  USER_NAME = "' . $username . '" OR Email = "' . $username . '" ) AND PASSWORD = "' . $password . '"';
        $foundUser = self::getOne($sql);
        if (false !== $foundUser) {
            if($foundUser->active == 1)
                $session->u = $foundUser;
            else
                return 2;
            return 1;
        }
        return false;
    }


}
