<?php

namespace PHPMVC\Controllers;

use PHPMVC\Lib\Validate;
use PHPMVC\Models\CourseModel;
use PHPMVC\Models\UserModel;
use PHPMVC\Models\QuestionModel;
use PHPMVC\Models\QtypeModel;
use PHPMVC\Models\ExamModel;
use PHPMVC\Models\ExamstudentModel;
use PHPMVC\Lib\FPDF;



class Exam extends AbstractController
{
    use Validate;

    public function defaultAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "exams";
        $this->_data['exams'] = ExamModel::getBy([ 'USER_ID' => $this->session->u->USER_ID , 'issaved' => 1 ]);

//        var_dump($this->_data['exams']);

        $this->_view();
    }


    public function addAction()
    {
        $this->_data['title'] = "exams";

        $this->_data['courses'] = CourseModel::getCoursesForExam( $this->session->u->USER_ID );



        $this->_view();

    }

    public function viewAction()
    {

        $this->_data['title'] = "exams";
        $this->isUser(2);
        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            $this->redirect('/exam');
        $this->_data['exam'] = ExamModel::getByPK( $this->_param[0]);

        if ($this->_data['exam'] == false || empty($this->_data['exam']) )
            $this->redirect('/exam');

       // $this->_data['exam'] = $this->_data['exam'][0];
        $question = [];
        $array = json_decode($this->_data['exam']->DESCREPTION);
        foreach ($array as $pk)
            $question[] = QuestionModel::getByPK($pk);

        $this->_data['id'] = $this->_data['exam']->COURSE_ID;
        $this->_data['question'] = $question;




        $this->_data['qtypes'] = QtypeModel::getAll();


        $this->_view();

    }


    public function deleteAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "Exam";
        if (!isset($this->_param[0]))
            $this->redirect("/Exam");

        $item = ExamModel::getByPK($this->_param[0]);

        if ($this->session->u->USER_ID != $item->USER_ID)
            $this->redirect('/exam');

        $item->issaved = 0;

        $item->save();
        $this->redirect('/exam');

    }

    public function getexamAction()
    {

        $this->_data['title'] = "exams";
        $this->isUser(2);
        if (!isset($_POST['courseid']))
            $this->redirect('/exam');

        $courseid = $this->filterInt($_POST['courseid']);
        $points = $this->filterInt($_POST['points']);
        $diff   = $this->filterFloat($_POST['diff']);
        $time   = $this->filterFloat($_POST['time']);
        $score   = $this->filterFloat($_POST['score']);
        $header   = $_POST['header'];


        $course = CourseModel::getByPK($courseid);
        if ($course == false || $course->USER_ID != $this->session->u->USER_ID)
            $this->redirect('exam');

		
        $exames = [];

        if(isset($_POST['alpha']))
            ExamModel::$alpha = $_GET['alpha']/100;
        ExamModel::$avg =($diff + $time )/2;
        $limpoint =$points;
        $questions = QuestionModel::gettoexam($courseid , $limpoint  , $diff , $time , $score , $_POST['chapters'] );

        if (sizeof($questions) <= ($points * 1.5) ){
            $this->redirect('/exam');
        }
        $str = "";
        for ($i= 0 ; sizeof($questions) > $i ; $i++){
            if ($i >= $points)
                $str .="1";
            else
                $str .="0";
        }

        ExamModel::$shuffleString = $str;
        

//        for ($i = 0; $i < strlen($str) ; $i++){
//            $str[$i] = 2;
//            echo $str[$i];
//        }
        for ($i = 0; $i < 15 ; $i++){
            $exames[] = new ExamModel($questions, $points, $diff, $time , $score);
//            echo $exames[$i]->bits ."<br>";
        }

        $best = ExamModel::getBest($exames);

        $d= $best->sdiff;
        $s=$best->bits;
        $t =$best->stime;

        $bests = [];
        $bests[] = $best;

        for ($i = 1; $i < $points ; $i++) {

            if (abs($best->stime) == 0 && abs($best->sdiff) == 0) {
                break;
            }

            $selected = [];
            for ($j = 0; $j < count($exames) - 1; $j++) {
                $selected[] = ExamModel::SelectParents($exames);
            }
            $children = ExamModel::reproduce($selected, $points, $diff, $time);
            $child = ExamModel::getBest($children);
//            var_dump($i." children " );

//            var_dump( $children);

//            var_dump($i."chiled " .$child->bits .'------'. $child->diff);
            $best = ExamModel::getBest([$child , $best]);
//            var_dump($i." best ". $best->bits);

        }
//        exit;
//        var_dump($best->bits);


        $a = str_split($best->bits);
        $i = 0 ;
        $fd = 0;
        $td = 0;
        $qu =[];
        $ans = [];
        $finalscore = 0;
        $myquestion = [];
        $ids = [];
        for ($i = 0; $i < strlen($best->bits) ; $i++){
            if ($best->bits[$i] == 1){
                $myquestion[] = $questions[$i];
                $ids[] = $questions[$i]->QUESTION_ID;
            }

        }
        $best->COURSE_ID =  $course->COURSE_ID ;
        $best->TIME  = $time;
        $best->DIFFICULTY =  $diff;
        $best->DESCREPTION = json_encode($ids);
        $best->start = NULL;
        $best->end = NULL;
        $best->ANSWER = json_encode($ans);
        $best->USER_ID = $this->session->u->USER_ID; // points
        $best->points = $points;
        $best->score = $score;
        $best->header = $header;

        $best->save();
        $best->getnumtaken();
        $this->_data['points'] = $points;
        $this->_data['time'] = $time;
        $this->_data['diff'] = $diff;
        $this->_data['best'] = $best;
        $this->_data['myquestion'] = $myquestion;
        $this->_data['a'] = $a;
        $this->_data['fd'] = $fd;
        $this->_data['finaldiff'] = $fd/$points;
        $this->_data['final time '] = $td;
        $this->_data['finalscore'] =$finalscore;



//        var_dump($best);
//        var_dump($best->diff);
//        var_dump($best->sdiff);
//        var_dump($best->sdiff / $points);
//        var_dump($best->time);
//        var_dump($best->stime);
//        var_dump($best->bits);
//        var_dump($best->show());

//        var_dump($_POST);
        //var_dump($this->_data);
        $this->_view();

    }


    public function saveAction()
    {
        $this->_data['title'] = "exams";

        $this->isUser(2);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            $this->redirect('exam');
        $exam = ExamModel::getBy(['USER_ID' => $this->session->u->USER_ID , 'EXAM_ID' =>
            $this->_param[0]]);

        if($exam == false || empty($exam))
            $this->redirect('exam');
        $exam[0]->issaved = 1;
        if ($exam[0]->save())
            ;
        else
            ;

        $this->redirect('/exam/view/'.$this->_param[0]);

    }

    public function editonlineAction()
    {
        $this->_data['title'] = "exams";

        $this->_data['title'] = "exams";
        $this->isUser(2);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]) )
            $this->redirect('/exam');
        $this->_data['exam'] = ExamModel::getByPK($this->_param[0]);

        if ($this->_data['exam'] == false || empty($this->_data['exam']) || $this->_data['exam']->USER_ID !=
            $this->session->u->USER_ID  )
            $this->redirect('/exam');


        if (isset($_POST['submit'])){


            $this->_data['exam']->start = $_POST['start'];
            $this->_data['exam']->end = $_POST['end'];
            $this->_data['exam']->isonline = 1;
            $this->_data['exam']->issaved = 1;

            $this->_data['exam']->save();

            $regict = "";
            $emails = explode(',' , $_POST['emails']);
            foreach ($emails as $email ){
                $user = UserModel::getOne("SELECT * FROM `users` WHERE `EMAIL` = '$email'");
                if ($user != false){
                    $std = new ExamstudentModel();
                    $std->userid = $user->USER_ID;
                    $std->answer = json_encode([]);
                    $std->examid = $this->_param[0];
                    $std->save();
                }else{
                    $regict .=$email."<br>";
                }

            }

            if ($regict != "" ){

            }
            $this->redirect('/exam');
        }

        $this->_view();


    }

    public function viewonlineAction()
    {
        $this->_data['title'] = "exams";

        $this->isUser(2);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]) )
            $this->redirect('/exam');

        $this->_data['title'] = ExamstudentModel::getBy(['examid' => $this->_param[0] ]);


    }

    public function downloadAction()
    {
        $this->_data['title'] = "exams";
        $this->isUser(2);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]) )
            $this->redirect('/exam');
        $this->_data['exam'] = ExamModel::getByPK($this->_param[0]);

        if ($this->_data['exam'] == false || empty($this->_data['exam']) )
            $this->redirect('/exam');

        $array = json_decode($this->_data['exam']->DESCREPTION);

        $list = [];
        foreach ($array as $pk) {
            $list[] = QuestionModel::getByPK($pk);
        }

        $list = QuestionModel::sortbytype($list);

        $qtypes = QtypeModel::getAll();


        $pdf=new PDF_HTML();
        $pdf->AddPage('P' , 'A4' , 0);
        $pdf->SetTitle('ahmed');
        $pdf->PageNo();
        $pdf->SetFont('Arial','B',12);
        $pdf->WriteHTML(str_replace('&nbsp;',' ',  $this->_data['exam']->header));
        $pdf->ln();

        $pdf->WriteHTML("<center>----------------------------------------------------------------------------------------------------------------------</center>");
        $pdf->ln();
        $pdf->SetFont('Arial','',12);
        $i = 1;
        $type = $qtypes[$list[0]->TYPE_ID-1]->TYPE_ID;
        $bool = false;
        $qnum = 1;

        foreach ($qtypes as $item){

            $boo = false;
            foreach ($list as $q ){
                if ($q->TYPE_ID == $item->TYPE_ID ) {
                    $boo = true;
                }
            }
            if ($boo) {
                $pdf->ln();
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->WriteHTML($qnum . ')  ' . str_replace('&nbsp;', ' ', $item->DECS));
                $pdf->ln();
                $pdf->ln();
                $qqnum = 1;
                $pdf->SetFont('Arial', '', 12);


                foreach ($list as $q) {
                    if ($q->TYPE_ID == $item->TYPE_ID) {
                        $buff = $q->DESCREPTION;
                        $pdf->WriteHTML($qqnum . ')  ' . str_replace('&nbsp;', ' ', $buff));
                        $pdf->ln();
                        $pdf->WriteHTML("<center>----------------------------------------------------------------------------------------------------------------------</center>");
                        $pdf->ln();
                        $qqnum++;
                    }
                }
                $qnum++;
            }
        }
        $pdf->ln();
        $pdf->WriteHTML("                                                                  GOOD LUCK  " );
        $pdf->ln();



        //$pdf->SetFont('Arial','',12);
        $pdf->output('' , 'Exam code ' .$this->_data['exam']->EXAM_ID , true);


    }

    public function downloadmodelAnswerAction()
    {
        $this->_data['title'] = "exams";
        $this->isUser(2);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]) )
            $this->redirect('/exam');
        $this->_data['exam'] = ExamModel::getByPK($this->_param[0]);

        if ($this->_data['exam'] == false || empty($this->_data['exam']) )
            $this->redirect('/exam');

        $array = json_decode($this->_data['exam']->DESCREPTION);

        $list = [];
        foreach ($array as $pk) {
            $list[] = QuestionModel::getByPK($pk);
        }


        $list = QuestionModel::sortbytype($list);

        $qtypes = QtypeModel::getAll();


        $pdf=new PDF_HTML();
        $pdf->AddPage('P' , 'A4' , 0);
        $pdf->SetTitle('ahmed');
        $pdf->PageNo();
        $pdf->SetFont('Arial','B',12);
        $pdf->WriteHTML(str_replace('&nbsp;',' ',  $this->_data['exam']->header));
        $pdf->ln();

        $pdf->WriteHTML("<center>----------------------------------------------------------------------------------------------------------------------</center>");
        $pdf->ln();
        $pdf->SetFont('Arial','',12);
        $i = 1;
        $type = $qtypes[$list[0]->TYPE_ID-1]->TYPE_ID;
        $bool = false;
        $qnum = 1;
        foreach ($qtypes as $item){

            $boo = false;
            foreach ($list as $q ){
                if ($q->TYPE_ID == $item->TYPE_ID ) {
                  $boo = true;
                }
            }
            if ($boo) {
                $pdf->ln();
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->WriteHTML($qnum . ')  ' . str_replace('&nbsp;', ' ', $item->DECS));
                $pdf->ln();
                $pdf->ln();
                $qqnum = 1;
                $pdf->SetFont('Arial', '', 12);


                foreach ($list as $q) {
                    if ($q->TYPE_ID == $item->TYPE_ID) {
                        $buff = $q->DESCREPTION;
                        $pdf->WriteHTML($qqnum . ')  ' . str_replace('&nbsp;', ' ', $buff));
                        $pdf->ln();
                        $buff = $q->ANSWER;
                        $pdf->WriteHTML(' Answer : ' . str_replace('&nbsp;', ' ', $buff));
                        $pdf->ln();
                        $pdf->ln();
                        $pdf->WriteHTML("<center>----------------------------------------------------------------------------------------------------------------------</center>");
                        $pdf->ln();
                        $qqnum++;
                    }
                }

                $qnum++;
            }


        }



        //$pdf->SetFont('Arial','',12);
        $pdf->output('' , 'Exam code ' .$this->_data['exam']->EXAM_ID , true);


    }


    public function takeexamAction()
    {
        $this->_data['title'] = "take exams";

        $this->isUser(3);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            $this->redirect('/exam');
        $exam = ExamModel::getByPK( $this->_param[0]);

        if($exam == false || empty($exam))
            $this->redirect('/exam/student');

//        var_dump($exam->start > date( "Y-m-d h:i:s" ));
//        var_dump(date( "Y-m-d h:i:s" ) > $exam->end);
//        exit();
        if ($exam->start > date( "Y-m-d h:i:s" ) && date( "Y-m-d h:i:s" ) > $exam->end  ){
            // exam is end
            $this->redirect('/exam/student');
        }

        $hasexam = ExamstudentModel::getBy(['examid' => $this->_param[0] , "userid" => $this->session->u->USER_ID ]);
        if ($hasexam == false || empty($hasexam) ){
            echo  "u dont have any exam ";

        }else{
            $hasexam = $hasexam[0];
        }


        if ($hasexam->complated == 0 && $hasexam->start == 0 && $hasexam->end == 0 ){

            $hasexam->start = time();
            $hasexam->end = time() + ($exam->TIME * 60);
            $hasexam->answer = json_encode([]);
            $hasexam->save();

        }

        if ($hasexam->complated == 1){
            echo  "u exam is finshed ";
            echo time();
            $this->redirect('/exam/student');
        }else if ($hasexam->complated == 0 && $hasexam->start > 0 && $hasexam->end <= time() ){

            $hasexam->complated = 1;
            $hasexam->save();
            echo "the exame is end ";
            $this->redirect('/exam/student');
        }
        if ($hasexam->complated == 0 && $hasexam->start > 0 && $hasexam->end > time() ){
            $question = [];
            $array = json_decode($exam->DESCREPTION);
            foreach ($array as $pk)
                $question[] = QuestionModel::getByPK($pk);

            $stiltime = $hasexam->end - time();
            $stiltime = $stiltime - 5;
            $this->_data['exam'] = $exam;
            $this->_data['questions'] = $question;
            $this->_data['answers'] = json_decode($hasexam->answer , true);
            $this->_data['stiltime'] = $stiltime - 5;
            $this->_data['minits'] = (int) ($stiltime / 60) ;
            $this->_data['sec']  =  $stiltime % 60 ;

        }else{

            exit();
        }





        $this->_view();


    }


    public function setanswerAction()
    {
        $this->_data['title'] = "take exams";

        $this->isUser(3);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            exit();
        if (!isset($this->_param[1]) || ! is_numeric($this->_param[1]))
            exit();
        if (!isset($this->_param[2]) )
            exit();
        $exam = ExamModel::getByPK( $this->_param[0]);

        if($exam == false || empty($exam))
            exit(0 );

        $hasexam = ExamstudentModel::getBy( ['examid' => $this->_param[0] , "userid" => $this->session->u->USER_ID ]);
        if ($hasexam == false || empty($hasexam) ){
            exit(0);
        }else{
            $hasexam = $hasexam[0];
        }
        if ($hasexam->complated == 0  && $hasexam->start > 0 && $hasexam->end > time() ){
            $question = [];

            $array = json_decode($exam->DESCREPTION);
            if (!in_array($this->_param[1] ,$array)  )
                exit(1);

            $answer = json_decode($hasexam->answer , true);
            $q = QuestionModel::getByPK($this->_param[1]);

            $answer[$this->_param[1]] = $this->_param[2];
            $hasexam->answer  = json_encode($answer);
            $hasexam->save();
            //var_dump($hasexam->answer);
            echo 1;

        }else{

            echo  0;
        }


      //  var_dump($hasexam);

    }


    public function resultAction()
    {
        $this->_data['title'] = "result";
        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            $this->redirect('/exam');
        $exam = ExamModel::getByPK( $this->_param[0]);

        if($exam == false || empty($exam))
            $this->redirect('/exam');


        $hasexams = ExamstudentModel::get("SELECT exam_student.* , users.EMAIL FROM `exam_student` , users  WHERE  exam_student.`userid` = users.USER_ID AND `examid` = ".$this->_param[0] );


        if ($hasexams == false)
            $hasexams = [];

        $this->_data['hasexams'] = $hasexams;

        $this->_view();


    }

    public function complateAction()
    {
        $this->_data['title'] = "complate exams";
        $this->isUser(3);

        if (!isset($this->_param[0]) || ! is_numeric($this->_param[0]))
            $this->redirect('/exam');
        $exam = ExamModel::getByPK( $this->_param[0]);

        if($exam == false || empty($exam))
            $this->redirect('/exam');


        $hasexam = ExamstudentModel::getBy(['examid' => $this->_param[0] , "userid" => $this->session->u->USER_ID ]);
        if ($hasexam == false || empty($hasexam) ){
            $this->redirect('/exam');

        }
        $hasexam = $hasexam[0];
        $hasexam->complated == 1;
        if ($hasexam->complated == 0 ||  $hasexam->grade == 0 ){
            $questions =  json_decode($exam->DESCREPTION , true);
            $hasanswer =  json_decode($hasexam->answer , true);
            $total = 0;
            $hasscor = 0;
            foreach ($questions as $question){
                $q = QuestionModel::getByPK($question);
                $total += $q->SCORE  ;

                if ( key_exists($question , $hasanswer) ){
                    if (strtolower($q->ANSWER) == strtolower($hasanswer[$question]) ){
                        $hasscor += $q->SCORE;
                    }
                }

            }


            if ($hasscor != 0){
                $hasexam->grade = $exam->score * ($hasscor / $total )  ;
                $hasexam->complated = 1;

            }else{
                $hasexam->grade = 0  ;
                $hasexam->complated = 1;

            }

            $hasexam->save();
        }

        $this->_data['hasexam'] = $hasexam;
        $this->_data['exam'] = $exam;
        $this->_view();
    }


    public function studentAction()
    {
        if (!isset($this->session->u->TYPE_ID) || $this->session->u->TYPE_ID != 3  )
            $this->redirect('/auth');
        $this->_data['title'] = "student";



        $this->_data['exams'] = ExamstudentModel::get("SELECT exam_student.* ,  exams.start as 'startdate' , exams.end as 'enddate'  , course.COURSE_NAME FROM `exam_student` , course ,exams WHERE course.COURSE_ID = exams
.COURSE_ID AND exam_student.examid = exams.EXAM_ID AND exam_student.userid = ".$this->session->u->USER_ID);

        $this->_view();
    }



}


class PDF_HTML extends FPDF
{
//variables of html parser
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;
    protected $fontList;
    protected $issetfont;
    protected $issetcolor;

    function __construct($orientation='P', $unit='mm', $format='A4')
    {
        //Call parent constructor
        parent::__construct($orientation,$unit,$format);
        //Initialization
        $this->B=0;
        $this->I=0;
        $this->U=0;
        $this->HREF='';
        $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
        $this->issetfont=false;
        $this->issetcolor=false;
    }

    function WriteHTML($html)
    {
        //HTML parser
        $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
        $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,stripslashes($this->txtentities($e)));
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract attributes
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $attr=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        //Opening tag
        switch($tag){
            case 'STRONG':
                $this->SetStyle('B',true);
                break;
            case 'EM':
                $this->SetStyle('I',true);
                break;
            case 'B':
            case 'I':
            case 'U':
                $this->SetStyle($tag,true);
                break;
            case 'A':
                $this->HREF=$attr['HREF'];
                break;
            case 'IMG':
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), $this->px2mm($attr['WIDTH']), $this->px2mm($attr['HEIGHT']));
                }
                break;
            case 'TR':
            case 'BLOCKQUOTE':
            case 'BR':
                $this->Ln(5);
                break;
            case 'P':
                $this->Ln(10);
                break;
            case 'FONT':
                if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                    $coul=$this->hex2dec($attr['COLOR']);
                    $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                    $this->issetcolor=true;
                }
                if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont=true;
                }
                break;
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='STRONG')
            $tag='B';
        if($tag=='EM')
            $tag='I';
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='FONT'){
            if ($this->issetcolor==true) {
                $this->SetTextColor(0);
            }
            if ($this->issetfont) {
                $this->SetFont('arial');
                $this->issetfont=false;
            }
        }
    }

    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
        {
            if($this->$s>0)
                $style.=$s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }



    function hex2dec($couleur = "#000000"){
        $R = substr($couleur, 1, 2);
        $rouge = hexdec($R);
        $V = substr($couleur, 3, 2);
        $vert = hexdec($V);
        $B = substr($couleur, 5, 2);
        $bleu = hexdec($B);
        $tbl_couleur = array();
        $tbl_couleur['R']=$rouge;
        $tbl_couleur['V']=$vert;
        $tbl_couleur['B']=$bleu;
        return $tbl_couleur;
    }

//conversion pixel -> millimeter at 72 dpi
    function px2mm($px){
        return $px*25.4/72;
    }

    function txtentities($html){
        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans = array_flip($trans);
        return strtr($html, $trans);
    }

}
