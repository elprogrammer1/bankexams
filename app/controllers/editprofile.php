<?php

namespace PHPMVC\Controllers;

use function GuzzleHttp\Promise\queue;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\AddresModel;

class Editprofile extends AbstractController
{
    use Validate;

    public function defaultAction()
    {
        $this->isUser(3);
        $this->_data['title'] = "setting";
        $currentuser = UserModel::getByPK($this->session->u->USER_ID);

        if (isset($_POST['submit'])) {
            // <!-- ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER-->

            $item = UserModel::get( "SELECT * FROM ".UserModel::$tableName." WHERE USER_NAME ='".
                $_POST['USER_NAME'] ."' and USER_ID != ".$this->session->u->USER_ID );
            if ($item != false ) {
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
                    $this->session->u = $currentuser;
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