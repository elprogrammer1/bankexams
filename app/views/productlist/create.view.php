<form autocomplete="off" class="appForm text-center" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 border">
            <label<?= $this->labelFloat('Name') ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" id="Name" maxlength="50" value="<?= $this->showValue('Name') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n20 border padding">
            <label<?= $this->labelFloat('BuyPrice') ?>><?= $text_label_BuyPrice ?></label>
            <input required type="number" name="BuyPrice" id="BuyPrice" min="1" step="0.01"
                   value="<?= $this->showValue('BuyPrice') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n20 border padding">
            <label<?= $this->labelFloat('SellPrice') ?>><?= $text_label_SellPrice ?></label>
            <input required type="number" name="SellPrice" id="SellPrice" min="1" step="0.01"
                   value="<?= $this->showValue('SellPrice') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 padding n40 select">
            <select style="width: 100%" required name="Unit">
                <option value=""><?= $text_label_Unit ?></option>
                <option value="1" <?= $this->selectedIf('Unit', 1) ?>><?= $text_unit_1 ?></option>
                <option value="2" <?= $this->selectedIf('Unit', 2) ?>><?= $text_unit_2 ?></option>
                <option value="3" <?= $this->selectedIf('Unit', 3) ?>><?= $text_unit_3 ?></option>
                <option value="4" <?= $this->selectedIf('Unit', 4) ?>><?= $text_unit_4 ?></option>
            </select>
        </div>
        <input class="col-sm-offset-4 col-xs-4 btn btn-success" type="submit" name="submit"
               value="<?= $text_label_save ?>">

    </fieldset>
</form>