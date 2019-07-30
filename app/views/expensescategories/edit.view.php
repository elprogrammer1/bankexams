<form autocomplete="off" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 border">
            <label<?= $this->labelFloat('ExpenseName', $Expense) ?>><?= $text_label_Name ?></label>
            <input required type="text" name="ExpenseName" maxlength="40"
                   value="<?= $this->showValue('ExpenseName', $Expense) ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 n50 padding">
            <label<?= $this->labelFloat('FixedPayment', $Expense) ?>><?= $text_label_cost ?></label>
            <input required type="number" name="FixedPayment" value="<?= $this->showValue('FixedPayment',
                $Expense) ?>">
        </div>
        <input class="btn-success btn" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>