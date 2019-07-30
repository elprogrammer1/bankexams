<div class="container">
    <a href="/Course/view/<?= $course->COURSE_ID ?>" class="btn btn-info"><i class="fa fa-plus"></i>  <?=
        $course->COURSE_NAME ?> </a>


    <form method="post" action="/Course/editchapter/<?= $item->CHAPTER_ID ?>">

        <div class="form-group">
            <label for=" CHAPTER_NAME"></label>
            <input type="text" class="form-control" name="CHAPTER_NAME" value="<?= $item->CHAPTER_NAME
            ?>"  id="CHAPTER_NAME" required placeholder="" >
        </div>


        <div class="form-group text-center">
            <input class="btn btn-success" onclick="if(!confirm('you' +
                                 '  want to delete this coures and has qurstion')) return false;" type="submit"
                   name="submit"
                   value="save" >
        </div>

    </form>


</div>