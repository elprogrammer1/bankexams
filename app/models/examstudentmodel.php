<?php

namespace PHPMVC\Models;

use PHPMVC\Models\ChapterModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\Models\CourseModel;

class ExamstudentModel extends AbstractModel
{
    public $id;
    public $userid;
    public $answer;
    public $examid;
    public $start = 0;
    public $USER_ID;
    public $end = 0;
    public $complated = 0;
    public $grade = 0;



    public static $tableName = 'exam_student';
    protected static $tableSchema = array(
        'userid' => self::DATA_TYPE_INT,
        'answer' => self::DATA_TYPE_STR,
        'examid' => self::DATA_TYPE_INT,
        'start' => self::DATA_TYPE_INT,
        'end' => self::DATA_TYPE_INT,
        'complated' => self::DATA_TYPE_INT,
        'grade' => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'id';


    public function course()
    {
        if (!isset($this->course)){
            $id = $this->examid ;
            $this->course =  CourseModel::getOne("SELECT course.* FROM course WHERE course.COURSE_ID = ( SELECT exams.COURSE_ID FROM exams WHERE exams.EXAM_ID = $id  )");
        }
        return $this->course;
    }


}
