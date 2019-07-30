<form autocomplete="off" class="appForm text-center" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="col-xs-12 col-sm-6 ">
            <legend><?= $text_legend ?></legend>
            <div class="  input_wrapper col-xs-12 ">
                <label<?= $this->labelFloat('Name', $category) ?>><?= $text_label_Name ?></label>
                <input required type="text" name="Name" id="Name" maxlength="20"
                       value="<?= $this->showValue('Name', $category) ?>">
            </div>
            <div class="  input_wrapper col-xs-12 ">
                <label class="floated"><?= $text_label_Image ?></label>
                <input type="file" name="image" accept="image/*">
            </div>
            <input class="btn-success btn" type="submit" name="submit" value="<?= $text_label_save ?>">
        </div>
        <div class="col-xs-12 col-sm-6 ">
            <?php if ($category->Image !== ''): ?>
                <div class="  input_wrapper col-xs-12 col-sm-6  n100">
                    <img src="/public/uploads/images/<?= $category->Image ?>" width="100%">
                </div>
            <?php endif; ?>
        </div>
    </fieldset>
</form>