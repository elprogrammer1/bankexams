<?php

namespace PHPMVC\Controllers;

use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\ChapterModel;
use PHPMVC\Models\userModel;
use PHPMVC\Models\UsersGroupsModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\Models\QtypeModel;
use PHPMVC\Models\CourseModel;


class Course extends AbstractController
{

    public function defaultAction()
    {
        $this->_data['title'] = "courses";
        $this->isUser(2);

        // //  COURSE_NAME COURSE_DATE USER_ID
        if (isset($_POST['submit'])) {
            $item = new CourseModel();
            $item->setvalue($_POST);
            $item->USER_ID = $this->session->u->USER_ID;

            if ($item->save()) {

            } else {

            }
        }
        $this->_data['courses'] = CourseModel::getBy(['USER_ID' => $this->session->u->USER_ID , 'isdeleted' => 0]);

        $this->_view();
    }

    public function addchapterAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (isset($_POST['CHAPTER_NAME']) && $_POST['CHAPTER_NAME'] != "" &&
            isset($_POST['COURSE_ID']) && $_POST['COURSE_ID'] != ""
        ) {
            $name = $this->filterString($_POST['CHAPTER_NAME']);
            $id = $this->filterInt($_POST['COURSE_ID']);
            $course = CourseModel::getByPK($id);
            if ($course == false)
                die("course 0");
            $chapter = new ChapterModel();
            $chapter->CHAPTER_NAME = $name;
            $chapter->COURSE_ID = $id;
            if ($chapter->save())
                echo 1;
            else
                echo 0;

        } else {
            echo "comnu";
        }
    }
// delete
    public function deletechapterAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/course");
        $id = $this->filterInt($this->_param[0]);
        $item = ChapterModel::getByPK($id);

        $course = CourseModel::getByPK($item->COURSE_ID);
        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");
        if (!empty($item->getQuestion())) {
            //$this->messenger->add(" chapter has Questions  , can't delete . ", Messenger::APP_MESSAGE_ERROR);
            foreach ($item->getQuestion() as  $q){
                $q->is_deleted = 1 ;
                $q->save();
            }
        }
        $item->isdeleted = 1;

        if ($item->save())
            $this->messenger->add(" chapter deleted success ", Messenger::APP_MESSAGE_SUCCESS);
        else
            $this->messenger->add(" fail to delete chapter ", Messenger::APP_MESSAGE_ERROR);


        $this->redirect("/Course/view/" . $item->COURSE_ID);


    }

    public function editAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/course");

        $course = CourseModel::getByPK($this->_param[0] );

        $this->_data['item'] = $course;
        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");

        if (isset($_POST['submit'])){

            $course->COURSE_NAME = $_POST['COURSE_NAME'];
            $course->COURSE_DATE = $_POST['COURSE_DATE'];

            if ($course->save()){
                $this->messenger->add(" course edit  success ", Messenger::APP_MESSAGE_SUCCESS);
                $this->redirect('/Course');
            }
            else
                $this->messenger->add(" fail to edit  success ", Messenger::APP_MESSAGE_ERROR);

        }
        $this->_view();
    }


    public function editchapterAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/course");
        $id = $this->filterInt($this->_param[0]);
        $item = ChapterModel::getByPK($id);

        $course = CourseModel::getByPK($item->COURSE_ID);
        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");


        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");

        if (isset($_POST['submit'])){

            $item->CHAPTER_NAME = $_POST['CHAPTER_NAME'];

            if ($item->save()){
                $this->messenger->add(" Chapter edit  success ", Messenger::APP_MESSAGE_SUCCESS);
                $this->redirect('/Course/view/'.$item->COURSE_ID);
            }
            else
                $this->messenger->add(" fail to Chapter  success ", Messenger::APP_MESSAGE_ERROR);


        }
        $this->_data['item'] = $item;
        $this->_data['course'] = $course;
        $this->_view();
    }

    public function deleteAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/course");

        $course = CourseModel::getByPK($this->_param[0] );

        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");



        foreach ($course->chapters() as  $c){
            $c->isdeleted = 1 ;
            $c->save();
            if ($c->getQuestion() != false)
            foreach ($c->getQuestion() as $q){
                $q->is_deleted = 1 ;
                $q->save();
            }
        }


        $course->isdeleted = 1;

        if ($course->save())
            $this->messenger->add(" course deleted success ", Messenger::APP_MESSAGE_SUCCESS);
        else
            $this->messenger->add(" fail to delete course ", Messenger::APP_MESSAGE_ERROR);


        $this->redirect("/Course");


    }


    public function addQuestionAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        //print_r($_POST);exit();
        $this->_param[0];
        if (isset($_POST['DESCREPTION'])) {
            $item = new QuestionModel();
            $item->setvalue($_POST);
            $item->USER_ID = $this->session->u->USER_ID;
            //print_r($item);
            //var_dump($_POST);
            if ($item->save())
                $this->messenger->add(" Question has been added successfully", Messenger::APP_MESSAGE_SUCCESS);
            else
                $this->messenger->add(" Questions has not been added ", Messenger::APP_MESSAGE_ERROR);

            $this->redirect('/Course/view/'.$this->_param[0]);

        } else {
            $this->redirect('/Course/view/'.$this->_param[0]);
        }
    }

    public function viewAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/Course");
        $id = $this->filterInt($this->_param[0]);
        $course = CourseModel::getByPK($id);
        if ($course == false)
            $this->redirect("/Course");

        $chapters = ChapterModel::getBy(['COURSE_ID' => $course->COURSE_ID , 'isdeleted' => 0]);

        $this->_data['course'] = $course;
        $this->_data['chapters'] = $chapters;
        $this->_data['types'] = QtypeModel::getAll();
        //

        $this->_view();

    }



    public function importAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";

        if (!isset($this->_param[0]))
            $this->redirect("/Course");

        $id = $this->filterInt($this->_param[0]);
        $course = CourseModel::getByPK($id);

        if ($course == false)
            $this->redirect("/Course");
        $chnum = 1 ;

        include  __DIR__.DS.'..'.DS.'PHPExcel'.DS.'PHPExcel.php';
        if(isset($_POST["import"])) {
            $output = "";
            $extension = explode(".", $_FILES["excel"]["name"]) ;
            $extension = $extension[sizeof($extension)-1];

            $allowed_extension = array("xls", "xlsx", "csv");
            if (in_array($extension, $allowed_extension))
            {
                $file = $_FILES["excel"]["tmp_name"];

                $objPHPExcel = \PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

                $chapter =new ChapterModel();
                $chapter->CHAPTER_NAME = $_FILES["excel"]["name"];
                $chapter->COURSE_ID = $id;
                $chapter->save();


                $m ="";
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();

                    for ($row = 2; $row <= $highestRow; $row++) {
                        //$idchapter = $worksheet->getCellByColumnAndRow(2, $row)->getValue();


                        $q = new QuestionModel();
                        $q->USER_ID = $this->session->u->USER_ID;
                        $q->ANSWER = $worksheet->getCellByColumnAndRow(2, $row)->getValue() ;
                        $q->TYPE_ID = $worksheet->getCellByColumnAndRow(0, $row)->getValue() ;
                        $q->CHAPTER_ID =  $chapter->CHAPTER_ID;

                        $q->DESCREPTION = $worksheet->getCellByColumnAndRow(1, $row)->getValue() ;
                        $q->DESCREPTION = str_replace("\n" , '<br> ' ,$q->DESCREPTION  );
                        $q->DESCREPTION = str_replace('"' , " \" " ,$q->DESCREPTION  );
                        $q->DESCREPTION = str_replace("'" , " \' " ,$q->DESCREPTION  );

                        if ($q->DESCREPTION == "" ){
                            $m .=  " row number $row  is empty ";
                            continue;
                        }
                        $bool = false;

                        $bool = QuestionModel::get("SELECT * FROM `questions` WHERE `CHAPTER_ID` = $chapter->CHAPTER_ID AND `DESCREPTION` = '$q->DESCREPTION' " );
                        if ($bool != false){
                            $m .=  " row number $row  is inserted before ";
                            continue;
                        }
                        $q->DIFFICULTY= $worksheet->getCellByColumnAndRow(4, $row)->getValue() ;
                        $q->SCORE = $worksheet->getCellByColumnAndRow(5, $row)->getValue() ;
                        $q->TIME = $worksheet->getCellByColumnAndRow(3, $row)->getValue() ;

                        $q->save();
                    }

                }

                if ($m != ""){
                    $this->messenger->add($m , Messenger::APP_MESSAGE_ERROR);
                }

            }

        }

        $this->redirect('/course/view/'.$id);


    }

    // getchapters
    public function getchaptersAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            exit(0);

        $course = CourseModel::getByPK($this->_param[0] );

        $this->_data['item'] = $course;
        if ($this->session->u->USER_ID != $course->USER_ID){
            exit(0);
        }
        foreach ($course->chapters() as $chapter){
            echo "<div class='mr-2 float-left d-inline-block col-12 text-left'> <input type='checkbox' class='form-check-input' 
name='chapters[]' 
value='"
                .$chapter->CHAPTER_ID
                ."'> 
".$chapter->CHAPTER_NAME."</div>"  ;
        }
        //echo json_decode($course->chapters());


    }
}

