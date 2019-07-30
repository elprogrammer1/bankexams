<div class="container">
<div class="mb-3 clearfix"></div>
    <div style="position: fixed;top: 100px;right: 14%;"> <?= "<h1><span id='min'>$minits</span> :  <span id='sec'>$sec</span></h1>"?></div>

    <div class="row">

    <div class='well exam col-12 ' style="    border-radius: 27px;">
        <ul class="list-group">
            <?php $i = 0;
            foreach ($questions as $q) {
                    $i++;
                    ?>
                    <li class="list-group-item d-inline-block"><span class="label label-primary"> <?= $i .')' ?></span>
                        <?= $q->DESCREPTION  ?>
                        <input type="text" data-id="<?= $q->QUESTION_ID  ?>" placeholder="answer " class="answer
                        d-block border bg-light p-1 w-100"  value="<?= isset($answers[$q->QUESTION_ID] )? $answers[$q->QUESTION_ID] : '' ?>" />
                    </li>
                    <?php } ?>
        </ul>
    </div>

        <a class="w-100 btn btn-dark" href="/exam/complate/<?= $exam->EXAM_ID ?>" onclick="if(!confirm('you' +
                                 ' want to Finsh Exam ? ')) return false;"> Finsh Exam </a>
</div>
</div>
<script type="text/javascript">




    var mini = <?= $minits  ?>;
    var sec  = <?= $sec ?>;
    setInterval(function () {
        sec --;
        if (sec == 0 && mini == 0){
            $(".well").css({"padding": "10%" ,"margin" : "10%" , "width" : "80%"});
            $(".well").text("Time is out click to reuslt");
            $(".well").hide(3000);

            $("#min").hide();
            $("#sec").hide();
        }
        if (sec == 0 && mini > 0){
            sec = 59;
            mini--;
            $("#min").html(mini);
        }
        $("#sec").html(sec);
    },1000);

    $(".answer").blur(function () {
        value = $(this).val();
        key   = $(this).attr('data-id');
         //console.log("/exam/setanswer/" + <?= $exam->EXAM_ID ?> + "/" + key + "/" + value);

        $.ajax({
            type: 'GET',
            url: '/exam/setanswer/' + <?= $exam->EXAM_ID ?> + '/' + key +'/' + value ,
        }).done(function (data) {
            console.log(data);

            if (data == 0 ){
                $(".well").css({"padding": "10%" ,"margin" : "10%" , "width" : "80%"});
                $(".well").html(" <h2> Error in send exam </h2> ");
                $(".well").hide(3000);
            }

        }).fail(function (data) {
            // console.log("error in connection ");
            $(".well").css({"padding": "10%" ,"margin" : "10%" , "width" : "80%"});
            $(".well").html(" <h3> failed  connection </h3> ");
            $(".well").hide(3000);
            // Optionally alert the user of an error here...
        });


    });
</script>