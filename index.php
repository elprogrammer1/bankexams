<?php

namespace PHPMVC;

use PHPMVC\LIB\Authentication;
use PHPMVC\LIB\FrontController;
use PHPMVC\LIB\Language;
use PHPMVC\lib\Messenger;
use PHPMVC\Lib\Registry;
use PHPMVC\LIB\SessionManager;
use PHPMVC\LIB\Template;

///*  */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once 'app' . DS . 'config' . DS . 'config.php';
require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';
$session = new SessionManager();
$session->start();
if (!isset($session->lang)) {
    $session->lang = APP_LANGUAGE;
}
$template_parts = require_once 'app' . DS . 'config' . DS . 'templateconfig.php';

$template = new Template($template_parts);
$language = new Language();
$messenger = Messenger::getInstance($session);
$authentication = Authentication::getInstance($session);
$registry = Registry::getInstance();

$registry->_language = $language;
$registry->session = $session;
$registry->messenger = $messenger;
$frontcontroller = new FrontController($template, $registry, $authentication);
$frontcontroller->dispatch();
