<legend class="text-center">اضافة اقساط</legend>
<div id="error" style="display: none">
    <div class="alert alert-danger">
        <strong><?= $text_error ?> </strong> <?= $text_error_text ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="bill-info ">

    <div class="  input_wrapper col-xs-4 col-sm-3">
        اضافة اقساط
    </div>

    <div class="  input_wrapper col-xs-4 col-sm-3 ">  <?= date("Y-m-d") . " , " . date("h:i") ?> </div>
    <div class="input_wrapper col-xs-4 col-sm-3 ">
        <select style="width:100%" id="suppliertype">
            <option value="0" selected> موجود سابقا</option>
            <option value="1"> جديد</option>
        </select>
    </div>
</div>
<script>
    $('#suppliertype').change(function () {
        $(".existSupplier").toggle();
        $(".newSupplier").toggle();
        if ($("#suppliertype").val() == 0) {
            suplier = 0;
            $("#suppliername").val('');
        } else {
            $("#newSupplier").val('');
        }

    });
</script>


<div class="existSupplier  input_wrapper col-xs-12 col-sm-3 ">
    <label>اسم العميل </label>
    <input type="Name" id="suppliername" maxlength="50" style="width: 80%">
    <ul id="suplierslist" class="list-group searchlist col-xs-12 col-sm-4 ">
        <?php if (false !== $clients): foreach ($clients as $client): ?>
            <li class="list-group-item" onclick="setclient(<?= $client->ClientId ?>)">
                <span><?= $client->Name ?></span></li>
        <?php endforeach;endif; ?>
    </ul>
</div>
<div class="newSupplier  input_wrapper col-xs-12 col-sm-3 " style="display:none">
    <label><?= $text_client_Name ?></label>
    <input type="Name" id="newSupplier" maxlength="50" style="width: 80%">
</div>


<br>
<br>
<br>
<br>

<div class="form-group">
    <label for="price"> قيمه القسط</label>
    <input class="form-control" id="price" type="number">
</div>


<div class="form-group">
    <label for="times"> المده </label>
    <input class="form-control" id="times" type="number">
</div>

<div class="form-group">
    <label for="date"> تاريخ البداء </label>
    <input class="form-control" id="date" type="date">
</div>

<div class="form-group">
    <label for="times_payed">عدد الاقساط المدفوعة </label>
    <input class="form-control" id="times_payed" type="number">
</div>


<div class="form-group">
    <button id="addprotractfull" class="btn btn-success btn-block"> حفظ</button>

</div>


