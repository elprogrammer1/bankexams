<form autocomplete="on" class="appForm text-center" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="FirstName" <?= $this->labelFloat('FirstName') ?>><?= $text_label_FirstName ?></label>
            <input required type="text" id="FirstName" name="FirstName" maxlength="10"
                   value="<?= $this->showValue('FirstName') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="LastName" <?= $this->labelFloat('LastName') ?>><?= $text_label_LastName ?></label>
            <input required type="text" id="LastName" name="LastName" maxlength="10"
                   value="<?= $this->showValue('LastName') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="Username" <?= $this->labelFloat('Username') ?>><?= $text_label_Username ?></label>
            <input required type="text" id="Username" name="Username" maxlength="30"
                   value="<?= $this->showValue('Username') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="Password" <?= $this->labelFloat('Password') ?>><?= $text_label_Password ?></label>
            <input required type="password" id="Password" name="Password" value="<?= $this->showValue('Password') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="CPassword" <?= $this->labelFloat('CPassword') ?>><?= $text_label_CPassword ?></label>
            <input required type="password" id="CPassword" name="CPassword"
                   value="<?= $this->showValue('CPassword') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="Email" <?= $this->labelFloat('Email') ?>><?= $text_label_Email ?></label>
            <input required type="email" id="Email" name="Email" maxlength="40"
                   value="<?= $this->showValue('Email') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="CEmail" <?= $this->labelFloat('CEmail') ?>><?= $text_label_CEmail ?></label>
            <input required type="email" id="CEmail" name="CEmail" maxlength="40"
                   value="<?= $this->showValue('CEmail') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6 ">
            <label for="PhoneNumber" <?= $this->labelFloat('PhoneNumber') ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" id="PhoneNumber" name="PhoneNumber"
                   value="<?= $this->showValue('PhoneNumber') ?>">
        </div>
        <div class="  input_wrapper col-xs-12 col-sm-6_other  select">
            <select required name="GroupId">
                <option value=""><?= $text_user_GroupId ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->GroupId ?>"><?= $group->GroupName ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>
        <input class="btn btn-success" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>

