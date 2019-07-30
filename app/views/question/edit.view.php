<div class="container">
    <a href="/question" class="btn btn-info"><i class="fa fa-plus"></i> all question </a>

    <form id="addquestion" method="post" action="/question/edit/<?= $question->QUESTION_ID ?>">
        <div class="form-group">
            <label for="DESCREPTION">Question </label>
            <textarea name="DESCREPTION" class="form-control editor" id="DESCREPTION" rows="5"> <?=
                $question->DESCREPTION ?></textarea>
        </div>
        <div class="form-group">
            <label for="ANSWER">ANSWER </label>
            <textarea name="ANSWER" class="form-control" id="ANSWER" rows="5"> <?= $question->ANSWER ?></textarea>
        </div>

        <div class="form-group">
            <label for="TIME"> TIME </label>
            <input type="number" class="form-control" value="<?= $question->TIME ?>" step="0.5" min="1" name="TIME"
                   id="TIME"
                   placeholder="1.5">
        </div>

        <div class="form-group">
            <label for="DIFFICULTY"> DIFFICULTY  </label>
            <input type="number" class="form-control" step="1" value="<?= $question->DIFFICULTY ?>" name="DIFFICULTY" min="1" id="DIFFICULTY"
                   placeholder="50">
        </div>

        <div class="form-group">
            <label for="SCORE"> score </label>
            <input type="number" class="form-control" step="1" value="<?= $question->SCORE ?>" name="SCORE" min="1"
                   id="SCORE"
                   placeholder="50">
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1"> select Chapter </label>
            <select name="CHAPTER_ID" class="form-control" >
                <?php if(false != $chapters): $i = 1; foreach ($chapters as $chapter): ?>
                    <option <?= $this->selectedIf( 'CHAPTER_ID' , $chapter->CHAPTER_ID , $question) ?> value="<?= $chapter->CHAPTER_ID  ?>"> <?= $i . ' -  '.
                        $chapter->CHAPTER_NAME
                        ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1"> select Type  </label>
            <select name="TYPE_ID" class="form-control" >
                <?php if(false !== $types): foreach ($types as $type): ?>
                    <option <?= $this->selectedIf( 'TYPE_ID' , $chapter->TYPE_ID , $question) ?> value="<?= $type->TYPE_ID  ?>"> <?= $type->DECS	  ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>


        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>

<script>
    $("textarea").ckeditor();
</script>