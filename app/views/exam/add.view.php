<div class="container">
    <a href="/exams" class="btn btn-info"><i class="fa fa-plus"></i> all exams </a>

    <br/><br/>
    <form method="post" action="/exam/getexam" class="form col-xs-offset-1 col-xs-10" role="form">
        <div class="form-group"> courseid
            <label for="courseid"> select course </label>
            <select required class="form-control" name="courseid" id="courseid">
                <option value="0"> select course  </option>
                <?php foreach ($courses as $course){ ?>
                <option value="<?= $course->COURSE_ID ?>"><?= $course->COURSE_NAME ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-check">
            <label class="d-block">  select chapters  :</label>
            <br>
            <label class="form-check-label d-block" id="currentchapter">

            </label>
        </div>
        <div class="form-group col-xs-10">
            <label for="diff">Enter diff :</label>
            <input required type="number" step=".5" name="diff" class="form-control" id="diff">
        </div>
        <div class="form-group col-xs-10">
            <label for="time">Enter Time :</label>
            <input required type="number" step="1" name="time" class="form-control" id="time">
        </div>
        <div class="form-group col-xs-10">
            <label for="points">Enter Numbeer of points  :</label>
            <input required type="number" name="points" step="1" class="form-control" id="points">
        </div> score
        <div class="form-group col-xs-10">
            <label for="score">Enter score :</label>
            <input required type="number" name="score" step=".5" class="form-control" id="score">
        </div>
        <div class="form-group">
            <label for="DESCREPTION"> Header </label>
            <textarea required name="header" class="form-control editor" id="DESCREPTION" rows="10"> </textarea>
        </div>
        <br>
        <div class="clearfix"></div>
        <button type="submit" class="btn btn-success col-xs-offset-1 col-xs-8">Submit</button>
    </form>




</div>


<script>

    $("textarea.editor").ckeditor();

    $("form").submit(function () {
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
    });


    $('#courseid').change(function () {
        id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/course/getchapters/' + id ,
        }).done(function (data) {

            $("#currentchapter").html(data);
            if (data != 1) {

            } else {

            }
        }).fail(function (data) {
            console.log("error in connection ")
            // Optionally alert the user of an error here...
        });
    });


</script>