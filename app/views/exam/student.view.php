<div class="container">

<div class="clearfix"></div>

    <div id="accordion">
        <table class="table table-light ">
        <thead>
        <tr>
            <td> exam ID</td>
            <td>Course Instructor</td>
            <td>complated </td>
            <td>grade</td>
            <td>Action</td>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $exams): foreach ($exams as $ex ): ?>

            <tr>
                <td> <?= $ex->examid?> </td>
                <td><?= $ex->COURSE_NAME  ?>  </td>
                <td><?= $ex->complated == 1 ? 'done' : 'not '    ?> </td>
                <td><?= $ex->complated == 1  ? $ex->grade : '' ?> </td>
                <td><?php
                    if (  ( $ex->startdate < date( "Y-m-d h:i:s" ) || date( "Y-m-d h:i:s" ) < $ex->enddate ) &&
                    $ex->complated == 0  ){ ?>
                        <a class="btn btn-dark " href="/exam/takeexam/<?= $ex->examid?>">Enter</a>
                   <?php }  ?> </td>

            </tr>
        <?php endforeach; endif; ?>
        </tbody>
        </table>
         </div>

</div>

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









