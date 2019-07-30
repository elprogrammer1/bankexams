<?php

namespace PHPMVC\Controllers;

use PHPMVC\Lib\Validate;
use PHPMVC\Models\UserModel;

class Test extends AbstractController
{
    use Validate;

    public function defaultAction()
    {

        echo "0";
    }
}
// purchases_invoices