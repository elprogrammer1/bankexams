<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\userModel;
use PHPMVC\Models\UsersGroupsModel;

class Chapter extends AbstractController
{

    public function defaultAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');

        $this->_view();
    }





}