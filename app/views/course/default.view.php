<div class="container">

    <button type="button" class="btn btn-primary float-left m-2 pl-2" data-toggle="modal" data-target="#myModal">
        add course
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"> add course </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body  //  COURSE_NAME COURSE_DATE USER_ID -->
                <div class="modal-body">


                    <form method="post" action="/Course">
                        <div class="form-group">
                            <label for="COURSE_NAME"> COURSE NAME </label>
                            <input type="text" name="COURSE_NAME" class="form-control" id="COURSE_NAME"
                                   placeholder="COURSE_NAME" required>
                        </div>
                        <div class="form-group">
                            <label for="COURSE_NAME"> COURSE NAME </label>
                            <input type="date" class="form-control" name="COURSE_DATE" id="COURSE_DATE "
                                   placeholder="COURSE_DATE" required>
                        </div>
                        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
<div class="clearfix"></div>

    <div id="accordion">

        <?php if (false !== $courses): foreach ($courses as $course): ?>

            <div class="card">
                <div class="card-header" id="heading<?= $course->COURSE_ID ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link float-left" data-toggle="collapse" data-target="#collapse<?=
                        $course->COURSE_ID ?>" aria-expanded="false" aria-controls="collapse<?= $course->COURSE_ID ?>">
                            <?= $course->COURSE_NAME ?>   <?= $course->COURSE_DATE ?>
                        </button>

                        <a class="-align-right float-right btn btn-danger ml-3"
                           onclick="if(!confirm('you' +
                                 '  want to delete this coures ')) return false;"
                           href="/Course/delete/<?=
                        $course->COURSE_ID ?>"> delete </a>
                        <a class="-align-right float-right btn btn-dark ml-3" onclick="if(!confirm('you' +
                                 '  want to edit this coures ')) return false;"
                           href="/Course/edit/<?=
                           $course->COURSE_ID ?>"> edit </a>
                        <a class="-align-right float-right btn btn-info ml-3" href="/Course/view/<?=
                        $course->COURSE_ID ?>"> show </a>
                    </h5>
                </div>

                <div id="collapse<?= $course->COURSE_ID ?>" class="collapse "
                     aria-labelledby="heading<?= $course->COURSE_ID ?>" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group chapters ">
                            <?php if (false !== $course->chapters()): foreach ($course->chapters() as $chapter): ?>
                                <li class="list-group-item float-left">  <?= $chapter->CHAPTER_NAME ?>  </li>
                            <?php endforeach; endif; ?>
                        </ul>
                        <ul class="list-group text-left">
                            <li class="list-group-item ">
                                <form method="post" action="/Course/addchapter" class="form-inline addchaoter">
                                    <label for="email"> name :</label>
                                    <input type="text" name="CHAPTER_NAME" placeholder="CHAPTER NAME "
                                           class="form-control name"
                                    >
                                    <input type="hidden" name="COURSE_ID" value="<?= $course->COURSE_ID ?>"
                                           class="form-control">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>


        <?php endforeach; endif; ?>
    </div>



    <script>
        $('form.addchaoter').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting via the browser
            showmyloader();
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function (data) {
                //console.log(data);
                node = form.children("input.form-control.name");
                div = form.parent().parent().prev("ul");
                console.log(div)
                $(div).append("<li class='list-group-item'> " + $(node).val() + " </li>")
                $(node).val('');
                hidemyloader();
            }).fail(function (data) {
                console.log("error in connection ")
                // Optionally alert the user of an error here...
            });

        });
    </script>









