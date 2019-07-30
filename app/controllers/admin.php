<?php

namespace PHPMVC\Controllers;

use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\CourseModel;
use PHPMVC\Models\AddresModel;

class Admin extends AbstractController
{
    use Validate;

    public function defaultAction()
    {
        $this->isUser(1);

        $this->_data['title'] ="Admin";

        $this->_view();

    }
    public function coursesAction()
    {
        $this->isUser(1);
        $this->_data['title'] = "Admin-courses";
        $this->_data['title1'] ="courses";
        $this->_data['courses'] = CourseModel::get("SELECT `course`.* ,users.USER_NAME  FROM `course` , `users`  WHERE course.USER_ID = users.USER_ID ");

        $this->_view();

    }
    public function instructorsAction()
    {
        $this->isUser(1);

        $this->_data['title'] ="instructor";
        $this->_data['title1'] ="courses";
        $this->_data['items'] = UserModel::getBy(['TYPE_ID' => 2 ]);


        $this->_view();

    }
    public function studentsAction()
    {
        $this->isUser(1);

        $this->_data['title'] ="students";
        $this->_data['items'] = UserModel::getBy(['TYPE_ID' => 3 ]);

        $this->_view();

    }
    public function examsAction()
    {
        $this->isUser(1);

        $this->_data['title'] ="exams";


        $this->_view();

    }

    public function changeactiveuserAction()
    {
        $this->isUser(1);
        if (!isset($this->_param[0])  && is_numeric($this->_param[0]))
            $this->redirect('/admin');
        $user = userModel::getByPK($this->_param[0]);
        if ($user == false)
            $this->redirect('/admin');
        if ($user->active == 1)
            $user->active = 0;
        else
            $user->active = 1;
        if ($user->save()){
            echo $user->active;
        }else{
            echo -1;
        }


    }

    public function edituserAction()
    {
        $this->_data['title'] ="edit user ";

        $this->isUser(1);
        if (!isset($this->_param[0])  && is_numeric($this->_param[0]))
            $this->redirect('/admin');
        $user = userModel::getByPK($this->_param[0]);
        if ($user == false)
            $this->redirect('/admin');

        if (isset($_POST['submit'])) {
            // <!-- ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER-->

            $item = UserModel::get( "SELECT * FROM ".UserModel::$tableName." WHERE USER_NAME ='".
                $_POST['USER_NAME'] ."' and USER_ID != ".$this->_param[0]);
            if ($item != false ) {
                $this->messenger->add(" this username is used . ", Messenger::APP_MESSAGE_ERROR);
            } else {
                // // CITY COUNTRY REGION STREET
                $add = AddresModel::getByPK($user->ADDRESS_ID);
                $add->CITY = $_POST['CITY'];
                $add->COUNTRY = $_POST['COUNTRY'];
                $add->REGION = $_POST['REGION'];
                $add->STREET = $_POST['STREET'];
                $add->save();

                $user->USER_NAME = $_POST['USER_NAME'];
                $user->FULL_NAME = $_POST['FULL_NAME'];
                $user->EMAIL = $_POST['EMAIL'];
                $user->BIRTHDAY = $_POST['BIRTHDAY'];
                $user->PHONE_NUMBER = $_POST['PHONE_NUMBER'];
                $user->TYPE_ID = $_POST['TYPE'] ;
//                if ($_POST['TYPE'] == 1)
//                    $user->TYPE_ID = 2 ;
                if ($_POST["PASSWORD"] != "" )
                    $user->cryptPassword($_POST["PASSWORD"]);
                if ($user->save()){
                    $this->messenger->add(" changes are saved  ", Messenger::APP_MESSAGE_SUCCESS);

                    if ($user->TYPE_ID == 2 )
                        $this->redirect("/admin/instructors");
                    if ($user->TYPE_ID == 3)
                        $this->redirect("/admin/students");
                }else{
                    $this->messenger->add(" changes not saved . ", Messenger::APP_MESSAGE_ERROR);

                }

            }



        }


        



        $user->ADDRESS = AddresModel::getByPK($user->ADDRESS_ID);
        $this->_data['user'] = $user;

        $this->_view();
    }

}
// purchases_invoices