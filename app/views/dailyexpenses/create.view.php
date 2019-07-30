<form autocomplete="off" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>

        <div class="  input_wrapper col-xs-12">
            <select name="DExpenses" class="col-xs-12">
                <?php if ($Expenses !== false): foreach ($Expenses as $Expense): ?>
                    <option value="<?= $Expense->ExpenseId ?>"><?= $Expense->ExpenseName ?> </option>
                <?php endforeach; endif; ?>
            </select>
        </div>

        <input class="btn-success btn" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>