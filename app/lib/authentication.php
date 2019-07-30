<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 23/06/2018
 * Time: 12:49 ص
 */

namespace PHPMVC\LIB;


class Authentication
{
    public static $_instance;
    private $_session;
    // default Routes for any one
    private $_execludedRoutes = [
        'index/default',
        'auth/logout',
        'users/profile',
        'users/changepassword',
        'users/settings',
        'language/default',
        'accessdenied/default',
        'notfound/notfound',
        'test/default'
    ];

    private function __construct($session)
    {
        $this->_session = $session;
    }

    private function __clone()
    {
    }

    public static function getInstance($session)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($session);
        }
        return self::$_instance;
    }

    public function isAutherized()
    {
        return isset($this->_session->u);
    }

    public function hasAccess($controller, $action)
    {
        $url = strtolower($controller . '/' . $action);
        if (in_array($url, $this->_execludedRoutes) || in_array($url, $this->_session->u->privileges)) {
            return true;
        }
        return false;
    }


}