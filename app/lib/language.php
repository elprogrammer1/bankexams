<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 02/06/2018
 * Time: 10:09 م
 */

namespace PHPMVC\LIB;


class Language
{
    private $dictionary = [];

    public function load($path)
    {
        $path = explode('.', $path);
        $defaultlanguage = APP_LANGUAGE;
        if (isset($_SESSION['lang'])) {
            $defaultlanguage = $_SESSION['lang'];
        }
        $languageFileToLoad = LANGUAGE_PATH . $defaultlanguage . DS . $path[0] . DS . $path[1] . '.lang.php';
        if (file_exists($languageFileToLoad)) {
            require_once $languageFileToLoad;
            if (is_array($_) && !empty($_)) {
                $this->dictionary = array_merge($_, $this->dictionary);
            }
        } else {
            trigger_error('sorry language file' . $languageFileToLoad . 'dont exists ', E_USER_WARNING);
        }
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->dictionary)) {
            return $this->dictionary[$key];
        }
    }

    public function set($key, $value)
    {
        $this->dictionary[$key] = $value;
    }

    public function feedKey($key, $data)
    {
        if (array_key_exists($key, $this->dictionary)) {
            array_unshift($data, $this->dictionary[$key]);
            return call_user_func_array('sprintf', $data);
        }
    }

    public function getdictionary()
    {
        return $this->dictionary;
    }

}
