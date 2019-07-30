<?php
namespace PHPMVC\Models;

use PHPMVC\Models\AbstractModel;



class ExamModel extends AbstractModel
{

    public $COURSE_ID ;
    public $TIME        ;
    public $DIFFICULTY ;
    public $DESCREPTION ;
    public $start        ;
    public $end          ;
    public $ANSWER       ;
    public $USER_ID      ;
    public $isonline = 0;
    public $issaved = 0;


    public $questions = [];
    public $time = 0;
    public $dif = 0;
    public $points;
    public $count;
    public $bits = "";
    public $sdiff = 0;
    public $stime = 0;
    public $score =0;
    public static $alpha = .5;
    public static $avg ;
    public static $wdiff ;
    public static $wtime ;
    public static $wscor ;
    public static $shuffleString ="" ;

    public static $tableName = 'exams';
    protected static $tableSchema = array(
        'EXAM_ID' => self::DATA_TYPE_INT,
        'COURSE_ID' => self::DATA_TYPE_INT,
        'DIFFICULTY' => self::DATA_TYPE_DECIMAL,
        'DESCREPTION' => self::DATA_TYPE_STR,
        'start' => self::DATA_TYPE_STR,
        'end' => self::DATA_TYPE_STR,
        'ANSWER' => self::DATA_TYPE_STR,
        'header' => self::DATA_TYPE_STR,
        'TIME' => self::DATA_TYPE_INT,
        'isonline' => self::DATA_TYPE_INT,
        'score' => self::DATA_TYPE_DECIMAL,
//        'score2' => self::DATA_TYPE_DECIMAL,
        'issaved' => self::DATA_TYPE_INT,
        'USER_ID' => self::DATA_TYPE_INT,// points
        'points' => self::DATA_TYPE_INT
    );

    protected static $primaryKey = 'EXAM_ID';

    public function courseName()
    {
        if (!isset($this->courseName)) {
            $this->courseName = CourseModel::getByPK($this->COURSE_ID)->COURSE_NAME;
        }

        return $this->courseName;

    }



    public function __construct( $questions = [] , $numOfPoints = 0 , $diff = 0, $time = 0 , $score )
    {
        if ($time != 0 && $diff != 0){
            $test="";
            self::$wdiff = $diff;
            self::$wtime = $time;
            self::$wscor  = $score;
            $this->points = $numOfPoints;
            $this->questions = $questions;
            $count = 0;
            $this->bits = "";
            $last = sizeof($questions);
            $state = 1;
            $this->bits = str_shuffle(self::$shuffleString );
           /// echo $this->bits;


            $this->bits  =  str_shuffle(self::$shuffleString) ;
            $this->time = 0;
            $this->dif  = 0;
            $this->score  = 0;
            $a = str_split($this->bits);

            foreach($a as $k => $c){
                if($c == '1'){
                    $this->time += $this->questions[$k]->TIME;
                    $this->dif += $this->questions[$k]->DIFFICULTY;
                    $this->score += $this->questions[$k]->SCORE;
                    $this->questions[$k]->isTaken = "1";
                }else{
                    $this->questions[$k]->isTaken = "0";
                }
            }
            $this->count = $this->getnumtaken();

            $this->balanced();
            $this->count =  $this->points ;
            if( $this->points  > 0 )
                $this->sdiff  = $diff -  ($this->dif / $this->count);
            $this->stime = $time - $this->time;
        }

    }





    public function reconstruct(Array $questions, $numOfPoints, $diff, $time )
    {
        $this->getnumtaken();
        if (sizeof($questions) < $numOfPoints)
            return false;
        $this->points = $numOfPoints;
        $this->questions = $questions;
        $this->time = 0;
        $this->score = 0;
        $this->bits = "";
        $this->dif = 0;
        $count = 0;
        $last = sizeof($questions);
        $this->bits = str_shuffle(self::$shuffleString);
        $this->getnumtaken();
        return ;
        for ($i = 0; $i < $last; $i++) {

            if ($count == $this->points) {
                $this->questions[$i]->isTaken = 0;
                $this->bits .= "0";
                continue;
            }
            if ($this->questions[$i]->isTaken == 1) {
                $this->time += $this->questions[$i]->TIME;
                $this->dif  += $this->questions[$i]->DIFFICULTY;
                $this->score += $this->questions[$i]->SCORE;
                $count++;
                $this->bits .= "1";
            } else {
                $this->bits .= "0";
                $this->questions[$i]->isTaken = 0;
            }

        }
 // sdiff stime count
        $this->balanced();
        $this->count = $count;
        $this->sdiff = $diff ;
        if ($this->count != 0)
        $this->sdiff = $diff - ($this->dif / $this->count );
        $this->stime = $time - $this->time;
        $this->sscore = self::$wscor- $this->score;

    }



    public function gettime()
    {

    }


    public function getnumtaken()
    {

        // // sdiff stime count
        $a = str_split($this->bits);
        $i = 0 ;
        $fd = 0;
        $td = 0;
        $finalscore = 0;
        foreach($a as $key => $c){
            if($c == 1 && isset($this->questions[$key])) {
                $fd += $this->questions[$key]->DIFFICULTY;
                $td += $this->questions[$key]->TIME;
                $finalscore += $this->questions[$key]->SCORE;
                $i++;
            }
        }

        $this->time = $td;
        $this->stime = $td - ExamModel::$wtime;

        $this->dif = $fd;

        $this->sdiff = $fd - ExamModel::$wtime;

        $this->SCORE = $finalscore;
        $this->count = $i;

    }



    public function show()
    {
        //$this->gettime();
        echo "diff : " . ($this->dif / $this->count ) . "%   time : " . $this->time . "   mi count  " . $this->count . " point    <br/>";
        echo $this->bits. "<br/>";

    }

    public function getdiff()
    {
        return $this->dif / $this->count;

    }

    public function showbits()
    {
        $bits = "";
        foreach ($this->questions as $que)
            $bits .= $que->isTaken;

        return $bits;
    }

    public function quenum()
    {
        $this->count = 0;
        foreach ($this->questions as $que)
            if ($que->isTaken == 1)
                $this->count += 1;

        return $this->count;
    }

    public function balanced()
    {
        $this->getnumtaken();

       // var_dump($this);exit();
        if ($this->count == $this->points)
            return;

        // $last = sizeof($this->questions);


//        echo $this->bits . "<br>";
  //      echo  $this->count ;

        if ($this->count > $this->points) {

    //       echo "less";
            exit();
            $i = rand(0 ,strlen($this->bits) / 2 );
            for ( ; $i < strlen($this->bits) ; $i++){
                if ($this->count == $this->points) {
                    break;
                }

                if ($this->bits[$i] == 1) {
                    $this->bits[$i] = 0;
                    $this->time -= $this->questions[$i]->TIME;
                    $this->dif -= $this->questions[$i]->DIFFICULTY;
                    $this->count--;
                }
            }


        } else if ($this->count < $this->points) {

            $i = rand(0 ,strlen($this->bits) / 2 );
//            var_dump($i);
//            var_dump($this->bits);
            for ( ; $i < strlen($this->bits) ; $i++){
//                var_dump($this->count == $this->points);
                if ($this->count == $this->points) {
                    break;
                }
                if ($this->bits[$i] == 0) {
//                    var_dump('start ' . $this->bits[$i]);
                    $this->bits[$i] = 1;

//                    var_dump('+');
                    $this->time += $this->questions[$i]->TIME;
                    $this->dif += $this->questions[$i]->DIFFICULTY;
                    $this->count++;
                }
            }
//            var_dump($this->bits);
//            echo "more less";


        }
//        var_dump($this->count != $this->points);

        if ($this->count != $this->points) {
            $this->balanced();
        }

    }


    public static function getBest(Array $exames)
    {
        $best = [];
        usort($exames, [ __CLASS__, "cmper"]);
        return $exames[0];

        /*
        // for normal sort
        $best = [];
        usort($exames, ["Exam", "cmp"]);

        $best[] = $exames[0];
        $best[] = $exames[1];
        $best[] = $exames[2];
        usort($best, ["Exam", "cmpTime"]);

        return $exames[0];
        */

    }

    public static function orderBests(Array $exames)
    {
        $bests = [];
        usort($exames, [__CLASS__, "withobjFunction"]);

        return  $exames[0];


    }

        /*
    self::$alpha
    self::$avg
        */

    public function objFunction()
    {
        return ($this->dif*self::$alpha + (1-self::$alpha)*$this->time) ;
    }
    public static function withobjFunction(ExamModel $a, ExamModel $b)
    {
        return abs($b->objFunction()) - abs($a->objFunction());
    }

    public static function cmp(ExamModel $a, ExamModel $b)
    {
        return abs($a->dif ) - abs($b->dif);
    }
    public static function cmpTime(ExamModel $a, ExamModel $b)
    {
        return abs($a->stime) - abs($b->stime);
    }


    public static function cmper(ExamModel $a, ExamModel $b)
    {


        $aa = pow( $a->diff - self::$wdiff , 2 );
        $aa -= pow( $a->time - self::$wtime , 2 );
        $aa -= pow( $a->score - self::$wscor , 2 );

        $bb = pow( $b->diff - self::$wdiff , 2 );
        $bb -= pow( $b->time - self::$wtime , 2 );
        $bb -= pow( $b->score - self::$wscor , 2 );


        return $aa - $bb ;
    }


    public static function SelectParents($exames)
    {

        $size = sizeof($exames) - 1;
        $index1 = rand(0, $size);
        $index2 = rand(0, $size);
        while ($index2 != $index1) {
            $index2 = rand(0, $size);
        }
        $difference = abs($exames[$index1]->sdiff) - abs($exames[$index2]->sdiff);
        if (abs($difference) > .5) {
            if (abs($exames[$index2]->sdiff) > abs($exames[$index1]->sdiff))
                return $exames[$index1];
            else
                return $exames[$index2];
        } else {
            if (abs($exames[$index2]->stime) > abs($exames[$index1]->stime))
                return $exames[$index1];
            else
                return $exames[$index2];
        }


    }

    public static function crossover(Array $parents, $numOfPoints, $diff, $time)
    {
        $len = sizeof($parents[0]->questions);
        $rand = rand(0, 1);

        // diiff1 + diff2 * .5 < diff2
        // retuen 1
        if ((abs($parents[0]->sdiff) + abs($parents[1]->sdiff) * .5) < abs($parents[1]->sdiff)) {
            return $parents[0];

//        } elseif ((abs($parents[1]->sdiff) + abs($parents[0]->sdiff) * .5) < abs($parents[0]->sdiff)) {
//            return $parents[1];
        } else {
            $mid = rand(3, ($len - 2));
            $childrenq = [];
            $bits = "";
            for ($i = 0; $i < $len; $i++) {
                if ($i > $mid) {
                    //$bits .= str_pos($parents[0]->bits);
                    $childrenq [] = $parents[0]->questions[$i];
                } else {
                    $childrenq[] = $parents[1]->questions[$i];
                }
            }
            // reconstrect
            $parents[0]->reconstruct( $childrenq , $numOfPoints, $diff, $time);

            return $parents[0];
        }
    }

    public static function point_mutation($child, $sign, $numOfPoints)
    {







        $stop = count($child->questions) / 4;
        for ($i = 0; $i <= $stop; $i++) {
            $rand = rand(0, count($child->questions)-1);
            $ch = $child->questions[$rand]->isTaken;
            if ($sign == 2) {
                if ($ch == 1) {
                    $child->questions[$rand]->isTaken = 0;
                    $child->time -= $child->questions[$rand]->TIME;
                    $child->dif -= $child->questions[$rand]->DIFFICULTY;
                    $child->count -= 1;
                }
            } elseif ($sign == 1) {
                if ($ch == 0) {
                    $child->questions[$rand]->isTaken = 1;
                    $child->time += $child->questions[$rand]->TIME;
                    $child->dif += $child->questions[$rand]->DIFFICULTY;
                    $child->count += 1;
                }

            } elseif ($sign == 0) {
                if ($ch == 1) {
                    $child->questions[$rand]->isTaken = 0;
                    $child->time -= $child->questions[$rand]->TIME;
                    $child->dif -= $child->questions[$rand]->DIFFICULTY;
                    $child->count -= 1;
                } else {
                    $child->questions[$rand]->isTaken = 1;
                    $child->time += $child->questions[$rand]->TIME;
                    $child->dif += $child->questions[$rand]->DIFFICULTY;
                    $child->count += 1;
                }
            }
        }
        $child ->balanced();
        return $child;
    }

    public static function reproduce($exames, $numOfPoints, $diff, $time)
    {
        $children = [];
        $in;
        for ($i = 0; $i < count($exames)-1; $i++) {
            if ($i == (count($exames)-1))
                $in = 0;
            elseif ($i % 2 == 0)
                $in = $i + 1;
            else
                $in = $i - 1;
            $sign = -1;
            if ($exames[$in]->sdiff > 0 && $exames[$i]->sdiff > 0)
                $sign = 2;
            elseif ($exames[$in]->sdiff < 0 && $exames[$i]->sdiff < 0)
                $sign = 1;
            elseif (($exames[$in]->sdiff < 0 && $exames[$i]->sdiff > 0) || ($exames[$in]->sdiff > 0 && $exames[$i]->sdiff < 0))
                $sign = 0;

            $child = self::crossover([$exames[$in], $exames[$i]], $numOfPoints, $diff, $time);
            $children[] = self::point_mutation($child, $sign, $numOfPoints);


        }
        return $children;
    }


}




