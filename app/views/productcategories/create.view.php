<form autocomplete="off" class="appForm text-center" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label<?= $this->labelFloat('Name') ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" id="Name" maxlength="20" value="<?= $this->showValue('Name') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label class="floated"><?= $text_label_Image ?></label>
            <input type="file" name="image" accept="image/*">
        </div>

        <input class="btn-success btn" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>