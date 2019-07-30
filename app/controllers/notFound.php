<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 23/06/2018
 * Time: 12:02 ص
 */

namespace PHPMVC\Controllers;

use PHPMVC\lib\Messenger;
use PHPMVC\Models\userModel;

class NotFound extends AbstractController
{
    public function defaultAction()
    {
        echo "not found ";

        // $this->_view();
    }

    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect('/auth/login');
    }
}