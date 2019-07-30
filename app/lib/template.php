<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 30/05/2018
 * Time: 01:29 ص
 */

namespace PHPMVC\LIB;


class Template
{
    use Templaehelper;
    private $_templateparts;
    private $_action_view;
    private $_data;
    private $_registry;

    public function __construct($templateparts)
    {
        $this->_templateparts = $templateparts;
    }

    public function swapTemplate($template)
    {
        $this->_templateparts['template'] = $template;
    }

    public function setActionView($action_view)
    {
        $this->_action_view = $action_view;
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function setregistry($registry)
    {
        $this->_registry = $registry;
    }

    public function __get($key)
    {
        return $this->_registry->$key;
    }

    public function randerTemplateHeaderStart()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH . 'templatehaderstart.php';
    }


    public function randerTemplateHeaderend()
    {
        require_once TEMPLATE_PATH . 'templatehaderend.php';
    }

    public function randerTemplatefooter()
    {
        extract($this->_data);
        require_once TEMPLATE_PATH . 'templatefooter.php';
    }

    public function randerTemplateBlock()
    {
        if (!array_key_exists('template', $this->_templateparts)) {
            trigger_error('Sorry you have to define template blocks');
        } else {

            $parts = $this->_templateparts['template'];
            if (!empty($parts)) {
                extract($this->_data);
                foreach ($parts as $partKey => $file) {
                    if ($partKey == ':view') {
                        require_once $this->_action_view;
                    } else {
                        require_once $file;
                    }
                }
            }
        }
    }

    public function randerHeaderResource()
    {
        $output = '';
        if (!array_key_exists('header_resources', $this->_templateparts)) {
            trigger_error('Sorry you have to define header resources blocks');
        } else {
            $resources = $this->_templateparts['header_resources'];
            $css = $resources['css'];
            if (!empty($css)) {
                foreach ($css as $resourceKey => $path) {
                    $output .= '<link media="all" rel="stylesheet" type="text/css" href="' . $path . ' " >';
                }
            }
            $js = $resources['js'];
            if (!empty($js)) {
                foreach ($js as $resourceKey => $path) {
                    $output .= '<script type="text/javascript" src="' . $path . '"></script>';
                }
            }
        }
        echo $output;
    }

    public function randerFooterResource()
    {
        $output = '';
        if (!array_key_exists('footer_resources', $this->_templateparts)) {
            trigger_error('Sorry you have to define footer resources blocks');
        } else {
            $js = $this->_templateparts['footer_resources'];
            if (!empty($js)) {
                foreach ($js as $resourceKey => $path) {
                    $output .= '<script type="text/javascript" src="' . $path . '"></script>';
                }
            }
        }
        echo $output;
    }

    public function randerApp()
    {

        $this->randerTemplateHeaderStart();
        $this->randerHeaderResource();
        $this->randerTemplateHeaderend();
        $this->randerTemplateBlock();
        $this->randerFooterResource();
        $this->randerTemplatefooter();

    }

    public function randerAppajax()
    {

        if (!array_key_exists('template', $this->_templateparts)) {
            trigger_error('Sorry you have to define template blocks');
        } else {

            $parts = $this->_templateparts['template'];
            if (!empty($parts)) {
                extract($this->_data);
                foreach ($parts as $partKey => $file) {
                    if ($partKey == ':view') {
                        require_once $this->_action_view;
                    }
                }
            }

        }
    }
}
