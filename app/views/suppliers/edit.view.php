<form autocomplete="off" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper col-xs-12 col-sm-6">
            <label<?= $this->labelFloat('Name', $supplier) ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" maxlength="40" value="<?= $this->showValue('Name', $supplier) ?>">
        </div>
        <div class="input_wrapper col-xs-12 col-sm-6">
            <label<?= $this->labelFloat('Email', $supplier) ?>><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40"
                   value="<?= $this->showValue('Email', $supplier) ?>">
        </div>
        <div class="input_wrapper col-xs-12 col-sm-6">
            <label<?= $this->labelFloat('PhoneNumber', $supplier) ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" maxlength="15"
                   value="<?= $this->showValue('PhoneNumber', $supplier) ?>">
        </div>
        <div class="input_wrapper col-xs-12 col-sm-6">
            <label<?= $this->labelFloat('Address', $supplier) ?>><?= $text_label_Address ?></label>
            <input required type="text" name="Address" value="<?= $this->showValue('Address', $supplier) ?>">
        </div>
        <input class="btn btn-success" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>