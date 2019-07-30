<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\userModel;
use PHPMVC\Models\UsersGroupsModel;

class Index extends AbstractController
{

    public function defaultAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');
        $this->_view();
    }
    public function aboutAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');
        $this->_view();
    }
    public function contactAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');
        $this->_view();
    }


}