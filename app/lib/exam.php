<?php



class Exam
{

    public $questions = [];
    public $time = 0;
    public $dif = 0;
    public $points;
    public $count;
    public $bits = "";
    public $sdiff = 0;
    public $stime = 0;
    public static $alpha = .5;
    public static $avg ;
     public static $shuffleString ="" ;
    public function __construct(Array $questions, $numOfPoints, $diff, $time )
    {

        $test="";
        $this->points = $numOfPoints;
        $this->questions = $questions;
        $count = 0;
        $this->bits = "";
        $last = sizeof($questions);
        $state = 1;
        if(Exam::$shuffleString == "" ){
            for ($i = 0; $i < $last; $i++) {
                if($i < $this->points){
                    Exam::$shuffleString .="1";
                }else{
                    Exam::$shuffleString .="0";
                }
           }
        }

        $this->bits  =  str_shuffle(Exam::$shuffleString) ;
        $this->time = 0;
        $this->dif  = 0;
        $a = str_split($this->bits);

        foreach($a as $k => $c){
            if($c == '1'){
                $this->time += $this->questions[$k]->TIME;
                $this->dif += $this->questions[$k]->DIFFICULTY;
                $this->questions[$k]->isTaken = "1";
            }else{
                $this->questions[$k]->isTaken = "0";
            }
        }
//        echo $this->dif .' : ' . $this->dif/$this->points . " --  $this->time   ----- $this->bits"  . "<br>";

        $this->count =  $this->points ;

        if( $this->points  > 0 )
            $this->sdiff  = $diff -  ($this->dif /$this->count);
        $this->stime = $time - $this->time;

  //      $this->show();
    }





    public function reconstruct(Array $questions, $numOfPoints, $diff, $time )
    {
        if (sizeof($questions) < $numOfPoints)
            return false;
        $this->points = $numOfPoints;
        $this->questions = $questions;
        $this->time = 0;
        $this->bits = "";
        $this->dif = 0;
        $count = 0;
        $last = sizeof($questions);
        for ($i = 0; $i < $last; $i++) {

            if ($count == $this->points) {
                $this->questions[$i]->isTaken = 0;
                $this->bits .= "0";
                continue;
            }
            if ($this->questions[$i]->isTaken == 1) {
                $this->time += $this->questions[$i]->TIME;
                $this->dif  += $this->questions[$i]->DIFFICULTY;
                $count++;
                $this->bits .= "1";
            } else {
                $this->bits .= "0";
                $this->questions[$i]->isTaken = 0;
            }

        }

        $this->balanced();
        $this->count = $count;
        $this->sdiff = $diff - ($this->dif / $this->count);
        $this->stime = $time - $this->time;

    }



    public function gettime()
    {
        // $last = sizeof($this->questions);
        // $time = 0 ;
        // $dif  = 0;
        // $count = 0;
        // for ($i = 0; $i < $last; $i++) {

        //     if ($this->questions[$i]->isTaken == 1) {
        //         $time += $this->questions[$i]->TIME;
        //         $dif  += $this->questions[$i]->DIFFICULTY;
        //         $count++;
        //     }

        // }

        // $this->dif = $dif ;
        // $this->time = $time;
        // $this->count = $count;

    }


    public function getnumtaken()
    {

        $count = 0;
        foreach ($this->questions as $que) {
            $count += $que->isTaken;
        }
        return $count;
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

        $this->count = $this->getnumtaken();
        if ($this->count == $this->points)
            return;
        $last = sizeof($this->questions);
        if ($this->count > $this->points) {

            for ($i = 0; $i < $last; $i++) {
                if ($this->count == $this->points) {
                    if (rand(0, 2) == 1) {
                        $this->questions[$i]->isTaken = 1;
                    }else{
                        $this->questions[$i]->isTaken = 0;
                    }
                    continue;
                }
                if (rand(0, 2) == 1) {
                    $this->questions[$i]->isTaken = 0;
                    $this->time -= $this->questions[$i]->TIME;
                    $this->dif -= $this->questions[$i]->DIFFICULTY;
                    $this->count--;
                }


            }


        } else if ($this->count < $this->points) {
            for ($i = 0; $i < $last; $i++) {
                if ($this->questions[$i]->isTaken)
                    continue;

                if (rand(0, 1)) {
                    $this->questions[$i]->isTaken = 1;
                    $this->time += $this->questions[$i]->TIME;
                    $this->dif += $this->questions[$i]->DIFFICULTY;
                    $this->count++;
                }
                if ($this->count == $this->points) {
                    break;
                }

            }
        }
        if ($this->count != $this->points) {
            $this->balanced();
        }

    }


    public static function getBest(Array $exames)
    {
        $best = [];
        usort($exames, ["Exam", "withobj"]);
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

    /*
Exam::$alpha
Exam::$avg
    */

    public function obj()
    {
        return ($this->dif*Exam::$alpha + (1-Exam::$alpha)*$this->time) ;
    }
    public static function withobj(Exam $a, Exam $b)
    {
        return abs($b->obj()) - abs($a->obj());
    }

    public static function cmp(Exam $a, Exam $b)
    {
        return abs($a->dif) - abs($b->dif);
    }
    public static function cmpTime(Exam $a, Exam $b)
    {
        return abs($a->stime) - abs($b->stime);
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
            $parents[0]->reconstruct($childrenq,$numOfPoints, $diff, $time);

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
        $child->balanced();
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

            $child = Exam::crossover([$exames[$in], $exames[$i]], $numOfPoints, $diff, $time);
            $children[] = Exam::point_mutation($child, $sign, $numOfPoints);


        }
        return $children;
    }


}




