<div class="container">
    <a href="/exams" class="btn btn-info"><i class="fa fa-plus"></i> all exams </a>

    <br/><br/>
    <form method="post" action="/exam/editonline/<?= $exam->EXAM_ID ?>" class="form col-xs-offset-1 col-xs-10"
          role="form">
        <div class="form-group col-xs-10">
            <label for="start">start date :</label>
            <input required type="datetime-local" name="start"  class="form-control" id="start">
        </div>


        <div class="form-group col-xs-10">
            <label for="end"> end :</label>
            <input required type="datetime-local" name="end"  class="form-control" id="end">
        </div>

        <div class="form-group">
            <label for="emails"> emails ( . ) </label>
            <textarea required name="emails" class="form-control " id="emails" rows="10">  </textarea>
        </div>


        <br>
        <div class="clearfix"></div>
        <button type="submit" name="submit" class="btn btn-success col-xs-offset-1 col-xs-8">Submit</button>
    </form>




</div>


<script>


    $("form").submit(function () {
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
    });




</script>