<form autocomplete="off" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 border">
            <label<?= $this->labelFloat('Name', $client) ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" maxlength="40" value="<?= $this->showValue('Name', $client) ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 padding">
            <label<?= $this->labelFloat('Email', $client) ?>><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40" value="<?= $this->showValue('Email', $client) ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 border">
            <label<?= $this->labelFloat('PhoneNumber', $client) ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" maxlength="15"
                   value="<?= $this->showValue('PhoneNumber', $client) ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 padding">
            <label<?= $this->labelFloat('Address', $client) ?>><?= $text_label_Address ?></label>
            <input required type="text" name="Address" value="<?= $this->showValue('Address', $client) ?>">
        </div>
        <input class="btn-success btn" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>