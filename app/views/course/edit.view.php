<div class="container">
    <a href="/Course" class="btn btn-info"><i class="fa fa-plus"></i> all Courses </a>


    <form method="post" action="/Course/edit/<?= $item->COURSE_ID ?>">

        <div class="form-group">
            <label for=" COURSE_NAME"></label>
            <input type="text" class="form-control" name="COURSE_NAME" value="<?= $item->COURSE_NAME
            ?>"  id="COURSE_NAME" required placeholder="" >
        </div>

        <div class="form-group">
            <label for="COURSE_DATE">Email address</label>
            <input type="date" required class="form-control" id="COURSE_DATE" name="COURSE_DATE" value="<?=
            $item->COURSE_DATE
            ?>"
        </div>

        <div class="form-group text-center">
            <input class="btn btn-success" onclick="if(!confirm('you' +
                                 '  want to delete this coures and has qurstion')) return false;" type="submit"
                   name="submit"
                   value="save" >
        </div>

    </form>


</div>