<?php

namespace PHPMVC\Models;

use PHPMVC\Models\ChapterModel;
use PHPMVC\Models\QuestionModel;

class CourseModel extends AbstractModel
{
    public $COURSE_ID;
    public $COURSE_NAME;
    public $COURSE_DATE;
    public $USER_ID;
    public $isdeleted = 0;


    public static $tableName = 'course';
    protected static $tableSchema = array(
        'COURSE_ID' => self::DATA_TYPE_INT,
        'COURSE_NAME' => self::DATA_TYPE_STR,
        'COURSE_DATE' => self::DATA_TYPE_DATE,
        'USER_ID' => self::DATA_TYPE_INT,
        'isdeleted' => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'COURSE_ID';


    public function chapters()
    {

        if (!isset($this->c))
            $this->c =  ChapterModel::getBy(['COURSE_ID	' => $this->COURSE_ID , 'isdeleted' => 0]);
        if ($this->c == false)
            $this->c = [];
        return $this->c;
    }

    public static function  getCoursesForExam($userid)
    {

        $courses =  self::get( "SELECT course.* , COUNT( questions.QUESTION_ID )  FROM `course` , `questions` , chapters WHERE course.COURSE_ID = 
chapters.COURSE_ID and questions.CHAPTER_ID = chapters.CHAPTER_ID AND course.isdeleted = 0 AND course.USER_ID = ".
            $userid ." GROUP BY course
.COURSE_ID" );
        if ($courses == false)
            $courses = [];
        return $courses;
    }

    public function numexams()
    {
        if (!isset($this->numexams))
            $this->numexams = self::get("SELECT COUNT(exams.EXAM_ID) as 'count' FROM `exams` WHERE `COURSE_ID` = "
                .$this->COURSE_ID." and issaved = 1")[0]->count;

        return  $this->numexams;
    }
}
