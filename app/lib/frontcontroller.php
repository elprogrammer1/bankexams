<?php

namespace PHPMVC\LIB;


class FrontController
{

    use Helper;
    const NOT_FOUND_ACTION = 'notFoundAction';
    const NOT_FOUND_CONTROLLER = 'PHPMVC\Controllers\NotFound';
    private $_controller = 'index';
    private $_action = 'default';
    private $_param = [];
    private $_template;
    private $_registry;
    private $_authentication;

    public function __construct(Template $template, Registry $registry, Authentication $authentication)
    {
        $this->_template = $template;
        $this->_registry = $registry;
        $this->_authentication = $authentication;
        $this->_parseUrl();
    }

    private function _parseUrl()
    {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);

        /*
        // in loclhost folder
        if (isset($url[1]) && $url[1] != '')
            $this->_controller=$url[1];
        if (isset($url[2]) && $url[2] != '')
            $this->_action=$url[2];
        if (isset($url[3]) && $url[3] != '')
            $this->_param = explode('/', $url[3]);
        */

        // host or domain
        if (isset($url[0]) && $url[0] != '')
            $this->_controller = $url[0];
        if (isset($url[1]) && $url[1] != '')
            $this->_action = $url[1];
        if (isset($url[2]) && $url[2] != '')
            $this->_param = explode('/', $url[2]);

    }

    public function dispatch()
    {

        $controllerName = 'PHPMVC\Controllers\\' . ucfirst($this->_controller);
        $actionName = $this->_action . 'Action';
        /*if (! $this->_authentication->isAutherized()){
             if($this->_controller != 'auth')
                 $this->redirect('/auth/login');
         }else{
             if($this->_controller == 'auth' && $this->_action == 'loginAction' )
                 isset($_SERVER['HTTP_REFERER']) ? $this->redirect($_SERVER['HTTP_REFERER']) : $this->redirect('/');
 //			if(! $this->_authentication->hasAccess($this->_controller,$this->_action) ){
 //			    $this->redirect('/accessdenied');
 //                }
         }
         */


        if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
            $controllerName = self::NOT_FOUND_CONTROLLER;
            $actionName = $this->action = 'defaultAction';
        }
        $controller = new $controllerName();
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setparam($this->_param);
        $controller->settemplate($this->_template);
        $controller->setregistry($this->_registry);
        $controller->$actionName();
    }
}
