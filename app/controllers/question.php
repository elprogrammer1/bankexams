<?php

namespace PHPMVC\Controllers;

use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\ChapterModel;
use PHPMVC\Models\CourseModel;
use PHPMVC\Models\userModel;
use PHPMVC\Models\UsersGroupsModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\Controllers\Course;
use PHPMVC\Controllers\Chapter;
use PHPMVC\Models\QtypeModel;

class Question extends AbstractController
{

    use Inputfilter;
    use Validate;

    public function defaultAction()
    {
        $this->isUser(2);
        $this->_language->load('template.commen');
        $this->_language->load('question.default');

        $this->_data['questions'] = QuestionModel::getBy(['USER_ID' => $this->session->u->USER_ID, 'is_deleted' => 0]);

        $this->_view();
    }


    public function deleteAction()
    {
        $this->isUser(2);
        if (!isset($this->_param[0]))
            $this->redirect("/question");
        $id = $this->filterInt($this->_param[0]);
        $item = QuestionModel::getByPK($id);
        if ($item == false)
            $this->redirect("/question");
        if ($this->session->u->USER_ID != $item->USER_ID)
            $this->redirect("/question");
        $item->is_deleted = 1;
        if ($item->save())
            echo 1;
            //$this->messenger->add(" chapter deleted success ", Messenger::APP_MESSAGE_SUCCESS);

        if (isset($this->_param[1]) && $this->_param[1] == 2) {
          //  $this->redirect("/Course/view/" . ChapterModel::getByPK($item->CHAPTER_ID)->COURSE_ID);
        }
        //$this->redirect("/question");
    }

    public function addAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "add question ";
        $this->redirect("/question");

        $this->_language->load('template.commen');
        $this->_language->load('question.default');
        // $this->_data['chaoters'] = cha
        // TIME DIFFICULTY ANSWER DESCREPTION CHAPTER_ID TYPE_ID

        if (isset($_POST['submit'])) {
            $item = new QuestionModel();
            $item->setvalue($_POST);
            if ($item->save()) {

            } else {

            }

        }


        $this->_view();
    }

    public function editAction()
    {


        $this->isUser(2);
        $this->_data['title'] = "edit question ";

        if (!isset($this->_param[0]))
            $this->redirect("/question");
        $id = $this->filterInt($this->_param[0]);
        $item = QuestionModel::getByPK($id);

        if ($item == false || $item->is_deleted == 1)
            $this->redirect("/question");

        $chapter = ChapterModel::getByPK($item->CHAPTER_ID);
        $course = CourseModel::getByPK($chapter->COURSE_ID);

        if ($item->USER_ID != $this->session->u->USER_ID)
            $this->redirect("/question");

        if (isset($_POST['submit'])) {
            $item->setvalue($_POST);
            if ($item->save()) {
                $this->messenger->add(" Questions is saved . ", Messenger::APP_MESSAGE_SUCCESS);
                $this->redirect("/question");
            } else {
                $this->messenger->add(" Error in  save  . ", Messenger::APP_MESSAGE_ERROR);

            }

        }
        $chapters = ChapterModel::getBy(['COURSE_ID' => $course->COURSE_ID]);
        $this->_data['question'] = $item;
        $this->_data['course'] = $course;
        $this->_data['chapters'] = $chapters;
        $this->_data['types'] = QtypeModel::getAll();


        $this->_view();


    }

    public function courseAction()
    {

        $this->isUser(2);

        $this->_language->load('template.commen');
        $this->_language->load('question.default');

        $this->_data['questions'] = QuestionModel::getBy(['USER_ID' => 1]);

        $this->_view();

    }


    public function uploadFile()
    {

        if(isset($_FILES['upload']['name']))
        {
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = rand() . '.' . $extension;
            chmod('upload', 0777);
            $allowed_extension = array("jpg", "gif", "png");
            if(in_array($extension, $allowed_extension))
            {
                move_uploaded_file($file, IMAGES_UPLOAD_STORAGE .DS . $new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $url = "/public/uploads/images" . $new_image_name;
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
            }
        }





        
    }


}