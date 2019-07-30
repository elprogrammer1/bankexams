<?php

namespace PHPMVC\Models;

use PHPMVC\Models\QuestionModel;

class ChapterModel extends AbstractModel
{
    public $CHAPTER_ID;
    public $CHAPTER_NAME;
    public $COURSE_ID;
    public $isdeleted = 0;

// CHAPTER_ID CHAPTER_NAME


    public static $tableName = 'chapters';
    protected static $tableSchema = array(
        'CHAPTER_ID' => self::DATA_TYPE_INT,
        'CHAPTER_NAME' => self::DATA_TYPE_STR,
        'COURSE_ID' => self::DATA_TYPE_INT,
        'isdeleted' => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'CHAPTER_ID';

    public function getQuestion()
    {
        if (!isset($this->questions) || empty($this->questions))
            $this->questions = QuestionModel::getBy(['CHAPTER_ID' => $this->CHAPTER_ID, 'is_deleted' => 0]);
        return $this->questions;

    }


}
