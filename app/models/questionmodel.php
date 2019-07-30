<?php

namespace PHPMVC\Models;

use PHPMVC\Models\CourseModel;
use PHPMVC\Models\ChapterModel;

class QuestionModel extends AbstractModel
{
    public $QUESTION_ID;
    public $TYPE_ID; //
    public $CHAPTER_ID; //
    public $DESCREPTION; //
    public $ANSWER; //
    public $TIME;
    public $DIFFICULTY; //
    public $isTaken = 0;
    public $USER_ID;
    public $is_deleted = 0;
    public $SCORE = 0;

// sitename descr about inst phone


    public static $tableName = 'questions';
    protected static $tableSchema = array(
        'TYPE_ID' => self::DATA_TYPE_INT,
        'DESCREPTION' => self::DATA_TYPE_STR,
        'QUESTION_ID' => self::DATA_TYPE_INT,
        'CHAPTER_ID' => self::DATA_TYPE_INT,
        'USER_ID' => self::DATA_TYPE_INT,
        'ANSWER' => self::DATA_TYPE_STR,
        'is_deleted' => self::DATA_TYPE_INT,
        'SCORE' => self::DATA_TYPE_DECIMAL  ,
        'TIME' => self::DATA_TYPE_DECIMAL,
        'DIFFICULTY' => self::DATA_TYPE_DECIMAL,
    );

    protected static $primaryKey = 'QUESTION_ID';

    public static function getAllForUser($user)
    {

        return self::getBy(['USER_ID' => $user]);
    }

    public function courseName()
    {
        if (!isset($this->courseName)) {
            $ch = ChapterModel::getByPK($this->CHAPTER_ID);
            $this->courseName = CourseModel::getByPK($ch->COURSE_ID)->COURSE_NAME;
            $this->chapterName = $ch->CHAPTER_NAME;
        }

        return $this->courseName;

    }

    public function chapterName()
    {
        if (!isset($this->chapterName)) {
            $ch = ChapterModel::getByPK($this->CHAPTER_ID);
            $this->courseName = CourseModel::getByPK($ch->COURSE_ID);
            $this->chapterName = $ch->CHAPTER_NAME;
        }
        return $this->chapterName;

    }


    public static function sortType($a, $b)
    {
        return $b->TYPE_ID < $a->TYPE_ID;
    }


    public static function sortbytype($list)
    {
         usort($list ,[ __CLASS__  , "sortType"] );
         return $list;

    }

    public static function gettoexam($id , $lim ,$diff , $time  , $score ,$ch)
    {



        $whereClause = [];
        foreach ($ch as $c){
            if (is_numeric($c))
                $whereClause[] =  ' questions.CHAPTER_ID = ' . $c  ;
        }
        $whereClause = ' AND ( '. implode(' OR ', $whereClause).' ) ';


        $chotercondition = " AND questions.TYPE_ID = 1";
        $q1 = self::get("SELECT questions.* , sqrt( power(abs(`DIFFICULTY`-$diff),2) + power(abs(`TIME`- $time),2) + power(abs(`SCORE`- $score),2) ) as 'diff' 
                FROM course , chapters , `questions` WHERE chapters.COURSE_ID = course.COURSE_ID 
                AND chapters.CHAPTER_ID = questions.CHAPTER_ID AND questions.is_deleted = 0 AND 
                chapters.isdeleted = 0 AND course.COURSE_ID = $id $whereClause  $chotercondition ORDER BY `diff` limit 
                $lim");

        $chotercondition = " AND questions.TYPE_ID = 2";
        $q2 = self::get("SELECT questions.* , sqrt( power(abs(`DIFFICULTY`-$diff),2) + power(abs(`TIME`- $time),2) + power(abs(`SCORE`- $score),2) ) as 'diff' 
                FROM course , chapters , `questions` WHERE chapters.COURSE_ID = course.COURSE_ID 
                AND chapters.CHAPTER_ID = questions.CHAPTER_ID AND questions.is_deleted = 0 AND 
                chapters.isdeleted = 0 AND course.COURSE_ID = $id $whereClause  $chotercondition ORDER BY `diff` limit 
                $lim");

        $chotercondition = " AND questions.TYPE_ID = 3";
        $q3 = self::get("SELECT questions.* , sqrt( power(abs(`DIFFICULTY`-$diff),2) + power(abs(`TIME`- $time),2) + power(abs(`SCORE`- $score),2) ) as 'diff' 
                FROM course , chapters , `questions` WHERE chapters.COURSE_ID = course.COURSE_ID 
                AND chapters.CHAPTER_ID = questions.CHAPTER_ID AND questions.is_deleted = 0 AND 
                chapters.isdeleted = 0 AND course.COURSE_ID = $id $whereClause  $chotercondition ORDER BY `diff` limit 
                $lim");


        if ($q1 == false )
            $q1 = [];
        if ($q2 == false )
            $q2 = [];
        if ($q3 == false )
            $q3 = [];


        foreach ($q2 as $q){
            $q1[] = $q;
        }
        foreach ($q3 as $q){
            $q1[] = $q;
        }
        $q1 =  iterator_to_array($q1);
        return $q1;

    }


}
