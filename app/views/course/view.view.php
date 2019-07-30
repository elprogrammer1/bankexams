<div class="container">

    <button class="btn btn-info  float-left mt-2" data-toggle="collapse" data-target="#demo"> add Question To
        <?= $course->COURSE_NAME ?></button>

    <button class="btn btn-info   float-right mt-2" data-toggle="collapse" data-target="#demochapter"> add chapter To
        <?= $course->COURSE_NAME ?></button>

    <div class="clearfix"></div>
    <br>
    <div class="clearfix"></div>
    <div id="demochapter" class="collapse border-1">
        <form method="post" action="/Course/addchapter" class="form-inline ajaxform">
            <label for="email"> name :</label>
            <input type="text" name="CHAPTER_NAME" placeholder="CHAPTER NAME " class="form-control name"
            >
            <input type="hidden" name="COURSE_ID" value="<?= $course->COURSE_ID ?>" class="form-control">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
    <div id="demo" class="collapse border-1">
        <form id="addquestion" method="post" action="/Course/addQuestion/<?= $course->COURSE_ID ?>">
            <div class="form-group">
                <label for="DESCREPTION">Question </label>
                <textarea  name="DESCREPTION" class="form-control editoer" id="DESCREPTION" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="ANSWER">ANSWER </label>
                <textarea name="ANSWER" class="form-control" id="ANSWER" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label for="TIME"> TIME </label>
                <input type="number" class="form-control" value="2" step="0.5" min="1" name="TIME" id="TIME"
                       placeholder="1.5">
            </div>

            <div class="form-group">
                <label for="DIFFICULTY"> DIFFICULTY </label>
                <input type="number" class="form-control" step="1" value="50" name="DIFFICULTY" min="1" id="DIFFICULTY"
                       placeholder="50">
            </div>
            <div class="form-group">
                <label for="SCORE"> score </label>
                <input type="number" class="form-control" step="0.5" value="3" name="SCORE" min="0.5" id="SCORE"
                       placeholder="50">
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1"> select Chapter </label>
                <select name="CHAPTER_ID" class="form-control">
                    <?php if (false != $chapters): $i = 1;
                        foreach ($chapters as $chapter): ?>
                            <option value="<?= $chapter->CHAPTER_ID ?>"> <?= $i . ' -  ' . $chapter->CHAPTER_NAME ?></option>
                        <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1"> select Type </label>
                <select name="TYPE_ID" class="form-control">
                    <?php if (false !== $types): foreach ($types as $type): ?>
                        <option value="<?= $type->TYPE_ID ?>"> <?= $type->DECS ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>


            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <div id="accordion">

        <?php if (false !== $chapters): $chnum = 1;
            foreach ($chapters as $chapter): ?>

                <div class="card chapter">
                    <div class="card-header" id="heading<?= $chapter->COURSE_ID ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link float-left" data-toggle="collapse" data-target="#collapse<?=
                            $chapter->CHAPTER_ID ?>" aria-expanded="false"
                                    aria-controls="collapse<?= $chapter->CHAPTER_ID ?>">
                                Chapter <?= '(' . $chnum++ . ')    ' . $chapter->CHAPTER_NAME ?>
                            </button>

                            <a href="/Course/deletechapter/<?= $chapter->CHAPTER_ID ?>" onclick="if(!confirm('you' +
                                 '  want to delete this chapter and has qurstion')) return false;" class="btn btn-danger
                            float-right ml-3">
                                Delete </a>
                            <a href="/Course/editchapter/<?= $chapter->CHAPTER_ID ?>"  class="btn btn-dark
                            float-right ml-3">
                            Edit </a>

                        </h5>

                    </div>

                    <div id="collapse<?= $chapter->CHAPTER_ID ?>" class="collapse "
                         aria-labelledby="heading<?= $chapter->CHAPTER_ID ?>" data-parent="#accordion">
                        <div class="card-body pt-0">

                            <table class="table table-hover text-left">
                                <?php if (false !== $chapter->getQuestion()): $i = 1;
                                    foreach ($chapter->getQuestion() as
                                             $question): ?>
                                        <tr class="question-row row">
                                            <td class="col-1"><?= $i++ ?></td>
                                            <td class="col-4"><?= substr($question->DESCREPTION, 0, 100) . '....'
                                                ?></td>
                                            <td class="col-2"><?= $question->TIME ?> Min</td>
                                            <td class="col-1"><?= $question->DIFFICULTY ?></td>
                                            <td class="col-1"><?= $question->SCORE ?></td>
                                            <td class="col-3">
                                                <a href="/question/edit/<?= $question->QUESTION_ID ?>"
                                                   class="btn btn-info"> edit </a>
                                                <a  data-id="<?= $question->QUESTION_ID ?>"
                                                   onclick="if(!confirm('you' +
                                 ' want to delete this question ? ')) return false;"
                                                   class="btn  btn-danger
                                        delete-question" >
                                                    delete </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                            </table>


                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
    </div>


<div class="well card mt-4 card-body">
    <h3 align="center " class="font-weight-bold">Import Excel file with questions</h3><br />
    <form class="showload" method="post" action="/course/import/<?= $course->COURSE_ID ?>" enctype="multipart/form-data">
        <strong class="" > colums in file must by like this order <br>
            type_id	Question	Answer	time	diff	score <br> </strong>

        <div class="form-group">
            <input required type="file" class="form-control-file border" name="excel">
        </div>

        <input type="submit" name="import" class="btn btn-info" value="Import" />
    </form>
</div>

    <script>
    CKEDITOR.replace("DESCREPTION");

        $('form.showload').submit(function (event) {
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
        });
        $('form.ajaxform').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting via the browser
            showmyloader();
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function (data) {
                console.log(data);
                if (data == 1) {

                    form.trigger("reset");
                } else {

                }

            }).fail(function (data) {
                console.log("error in connection ")
                // Optionally alert the user of an error here...
            });
            setTimeout(function () {
                $("#loadMe").modal("hide");
            }, 500);;
        });

        $('form.removechapter').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting via the browser
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function (data) {
                console.log(data);
                if (data == 1) {

                    form.trigger("reset");
                } else {

                }
                //console.log(data);
                //form.reset();
            }).fail(function (data) {
                console.log("error in connection ")
                // Optionally alert the user of an error here...
            });
            setTimeout(function () {
                $("#loadMe").modal("hide");
            }, 500);
        });

        $(".delete-question").click(function () {
            id = $(this).attr('data-id');
            showmyloader();
            node = $(this);
            if (id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/question/delete/' + id + '/2',
                }).done(function (data) {
                    console.log(data);
                    if (data == 1) {
                       // form.trigger("reset");
                        node.parent().parent().remove();

                    } else {

                    }
                    console.log(data);
                    //form.reset();
                }).fail(function (data) {
                    console.log("error in connection ")
                    // Optionally alert the user of an error here...
                });
            }
            setTimeout(function () {
                $("#loadMe").modal("hide");
            }, 500);
        });





        // CKEDITOR.replace('DESCREPTION', );




    </script>









