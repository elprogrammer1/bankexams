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
use PHPMVC\Models\AddresModel;



class Auth extends AbstractController
{
    function checkauth()
    {
        if (isset($this->session->u->USER_ID) && is_numeric($this->session->u->USER_ID)){
            if ($this->session->u->TYPE_ID == 3)
				$this->redirect('/exam/student');
			$this->redirect('/Course');
		}
		
    }

    public function defaultAction()
    {
        //echo crypt("123", APP_SALT);

        $this->checkauth();
        $this->_language->load('auth.login');

        $this->_data['title'] = "login";

        if (isset($_POST['login'])) {
            $isAuthorized = UserModel::authenticate($_POST['ucname'], $_POST['ucpwd'], $this->session);
            if ($isAuthorized == 2) {
                $this->messenger->add(" this user is not active . call admin ! ", Messenger::APP_MESSAGE_ERROR);
            } elseif ($isAuthorized == 1) {
                if ($this->session->u->TYPE_ID == 3){

                    $this->redirect('/exam/student');
                }

                $this->redirect('/Course');

            } elseif ($isAuthorized === false) {
                $this->_registry->messenger->add(" username or password is wrong ", Messenger::APP_MESSAGE_ERROR);
            }
        }

        $this->_view();
    }

    public function registerAction()
    {

        $this->_data['title'] = "register";
        if (isset($_POST['submit'])) {
            // <!-- ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER-->
            $item = UserModel::getBy(['USER_NAME' => $_POST['USER_NAME ']]);
            if ( $item !=  false) {
                $this->messenger->add(" this username is used . ", Messenger::APP_MESSAGE_ERROR);
            } else {
                // // CITY COUNTRY REGION STREET
                $add = new AddresModel();
                $add->CITY = $_POST['CITY'];
                $add->COUNTRY = $_POST['COUNTRY'];
                $add->REGION = $_POST['REGION'];
                $add->STREET = $_POST['STREET'];
                $add->save();

                $currentuser = new userModel();
                $currentuser->USER_NAME = $_POST['USER_NAME'];
                $q = userModel::getBy(['USER_NAME' => $currentuser->USER_NAME ]);
                if ($q != false){
                    $this->messenger->add(" username is used ", Messenger::APP_MESSAGE_ERROR);
                    $this->redirect('/auth/register');
                }
                $currentuser->ADDRESS_ID = $add->ADDRESS_ID;
                $currentuser->FULL_NAME = $_POST['FULL_NAME'];
                $currentuser->EMAIL = $_POST['EMAIL'];
                $q = userModel::getBy(['EMAIL' => $currentuser->EMAIL ]);
                if ($q != false){
                    $this->messenger->add(" email  is used ", Messenger::APP_MESSAGE_ERROR);
                    $this->redirect('/auth/register');
                }
                $currentuser->BIRTHDAY = $_POST['BIRTHDAY'];
                $currentuser->PHONE_NUMBER = $_POST['PHONE_NUMBER'];
                $currentuser->cryptPassword($_POST['PASSWORD']);
                if ($_POST['TYPE'] == 1 ){
                    $currentuser->TYPE_ID = 2;
                    $currentuser->active = 0;
                }else{
                    $currentuser->TYPE_ID = 3;
                    $currentuser->active = 1;
                }
                if ($currentuser->save()){
                    if ($_POST['TYPE'] == 1)
                        $this->messenger->add(" Register succues you . wait Admin accept . ",
                            Messenger::APP_MESSAGE_SUCCESS);
                    else
                        $this->messenger->add(" Register succues you can login ", Messenger::APP_MESSAGE_SUCCESS);
                    $this->redirect("/auth/");
                }else{
                    $this->messenger->add(" Register filled . ", Messenger::APP_MESSAGE_ERROR);

                }
                //$this->redirect("/auth/register");

            }


        }


        $this->_view();
    }
    public function loginAction()
    {

        $this->checkauth();
        $this->_language->load('auth.login');

        $this->_data['title'] = "login";

        if (isset($_POST['login'])) {
            $isAuthorized = UserModel::authenticate($_POST['ucname'], $_POST['ucpwd'], $this->session);
            if ($isAuthorized == 2) {
                $this->messenger->add(" this user is not active . call admin ! ", Messenger::APP_MESSAGE_ERROR);
            } elseif ($isAuthorized == 1) {
                if ($this->session->u->TYPE_ID == 3){
                    $this->redirect('/exam/student');
                }
                $this->redirect('/Course/');
            } elseif ($isAuthorized === false) {
                $this->_registry->messenger->add(" username or password is wrong ", Messenger::APP_MESSAGE_ERROR);
            }
        }

        $this->_view();

    }

    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect('/auth/login');
    }
}
/*
 *
 * 10 - 11 - 12 - 13 - 15
 *
 * */