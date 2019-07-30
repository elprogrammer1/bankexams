<form autocomplete="off" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label><?= $text_label_privilege_title ?></label>
            <input required type="text" name="PrivilegeTitle" id="PrivilegeTitle" maxlength="30">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label><?= $text_label_privilege_url ?></label>
            <input required type="text" name="Privilege" id="Privilege" maxlength="30">
        </div>
        <input class="btn btn-success" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>