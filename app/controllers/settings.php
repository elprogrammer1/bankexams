<?php

namespace PHPMVC\Controllers;

use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\AddresModel;


class Settings extends AbstractController
{
    use Validate;

    public function defaultAction()
    {

        $this->isUser(3);
        $currentuser = UserModel::getByPK($this->session->u->USER_ID);

        if (isset($_POST['submit'])) {
            // <!-- ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER-->

            $item = UserModel::getBy(['USER_NAME' => $_POST['USER_NAME ']]);
            if (sizeof($item) >= 2) {
                $this->messenger->add(" this username is used . ", Messenger::APP_MESSAGE_ERROR);
            } else {
                // // CITY COUNTRY REGION STREET
                $add = AddresModel::getByPK($this->session->u->ADDRESS_ID);
                $add->CITY = $_POST['CITY'];
                $add->COUNTRY = $_POST['COUNTRY'];
                $add->REGION = $_POST['REGION'];
                $add->STREET = $_POST['STREET'];
                $add->save();

                $currentuser->USER_NAME = $_POST['USER_NAME'];
                $currentuser->FULL_NAME = $_POST['FULL_NAME'];
                $currentuser->EMAIL = $_POST['EMAIL'];
                $currentuser->BIRTHDAY = $_POST['BIRTHDAY'];
                $currentuser->PHONE_NUMBER = $_POST['PHONE_NUMBER'];
                if ($currentuser->save()){
                    $this->messenger->add(" changes are saved  ", Messenger::APP_MESSAGE_SUCCESS);

                }else{
                    $this->messenger->add(" changes not saved . ", Messenger::APP_MESSAGE_ERROR);

                }
                $this->redirect("/editprofile");

            }


        }

        $user  = UserModel::getByPK($this->session->u->USER_ID);
        $user->ADDRESS = AddresModel::getByPK($this->session->u->ADDRESS_ID);
        $this->_data['user'] = $user;
        $this->_view();
    }
}
// purchases_invoices