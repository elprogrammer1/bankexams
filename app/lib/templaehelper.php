<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 07/06/2018
 * Time: 04:13 ص
 */

namespace PHPMVC\LIB;


trait Templaehelper
{
    public function matchurl($url)
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $url;
    }

    public function labelFloat($fieldName, $object = null)
    {
        return ((isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) || (null !== $object && $object->$fieldName !== null)) ? ' class="floated"' : '';
    }

    public function showValue($fieldName, $object = null)
    {
        return isset($_POST[$fieldName]) ? $_POST[$fieldName] : (is_null($object) ? '' : $object->$fieldName);
    }

    public function selectedIf($fieldName, $value, $object = null)
    {
        return ((isset($_POST[$fieldName]) && $_POST[$fieldName] == $value) || (!is_null($object) && $object->$fieldName == $value)) ? 'selected' : '';
    }

    public function getprotractclass($payed, $date)
    {
        if ($payed == 1)
            return 'success';
        if (date('Y-m-d') > $date)
            return 'danger';
    }


}