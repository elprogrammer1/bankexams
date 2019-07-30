<?php

namespace PHPMVC\Controllers;

class AccessDenied extends AbstractController
{
    public function defaultAction()
    {
        $this->language->load('template.common');
        $this->_view();
    }
}