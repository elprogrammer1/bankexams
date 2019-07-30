<div class="well">
    <legend class="text-center"><?= $text_legend ?></legend>
    <div id="error" style="display: none">
        <div class="alert alert-danger">
            <strong><?= $text_error ?> </strong> <?= $text_error_text ?>
        </div>
    </div>
    <div class="bill-info col-xs-12">
        <div class="  input_wrapper col-xs-12">
            <label ?><?= $text_legend ?></label>
            <input id="return-id" type="number" name="return-id" style="width:75%">
        </div>
    </div>

    <div class="clearfix  row bill">
        <div class="col-xs-4 col-sm-2">
            <input placeholder="<?= $text_code ?>" id="Productcode" class="Productcode">
            <ul id="Productscodes" class="list-group searchlist col-xs-12">
                <?php if (false !== $Products): foreach ($Products as $Product): ?>
                    <li class="list-group-item" onclick="setProduct(<?= $Product->ProductId ?>);">
                        <span><?= $Product->ProductId ?></span>
                    </li>
                <?php endforeach;endif; ?>
            </ul>
        </div>
        <div class="col-xs-4 col-sm-2">
            <input placeholder="<?= $text_name ?>" id="Productname">
            <ul id="Productsnames" class="list-group searchlist col-xs-12">
                <?php if (false !== $Products): foreach ($Products as $Product): ?>
                    <li class="list-group-item" onclick="setProduct(<?= $Product->ProductId ?>)">
                        <span><?= $Product->Name ?></span>
                    </li>
                <?php endforeach;endif; ?>
            </ul>
        </div>
        <div class="col-xs-4 col-sm-2"><input type="number" placeholder="<?= $text_priceone ?>" id="priceone_return">
        </div>
        <div class="col-xs-4 col-sm-2"><input class="sale" placeholder="<?= $text_quentity ?>" id="quentity"></div>
        <div class="col-xs-4 col-sm-2"><input type="number" placeholder="<?= $text_price ?>" id="price"
                                              class="price_return" readonly></div>
        <div class="col-xs-4 col-sm-2"><input class="btn-success" type="button" readonly id="addproduct"
                                              value="<?= $text_add ?>"></div>
    </div>

    <br><br><br>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th><?= $text_code ?></th>
            <th><?= $text_name ?></th>
            <th><?= $text_priceone ?></th>
            <th><?= $text_quentity ?></th>
            <th><?= $text_price ?></th>
        </tr>
        </thead>
        <tbody id="mytable">

        </tbody>
    </table>


    <br><br><br>

    <div class="clearfix"></div>
    <div class="row info">
        <div class="col-xs-3" style="float: right"><?= $text_old_babnce ?></div>
        <div class="col-xs-3" style="float: right" id="oldbalance"></div>
        <div class="col-xs-3" style="float: right"><?= $text_bill_price ?></div>
        <div class="col-xs-3" style="float: right" id="bill"></div>
        <!--    <div class="col-xs-2" style="float: right">--><? //=$text_total ?><!--</div>-->
        <!--    <div class="col-xs-2" style="float: right" id="total"></div>-->

        <div class="col-xs-2" style="float: right">
            <label for="forbalance"> <?= $text_payed ?> </label>
            <div>
                <input id="forbalance" type="checkbox">
            </div>
        </div>
        <div class="col-xs-3" style="float: right;padding: 0">

        </div>
        <div class="col-xs-2" style="float: right"><?= $text_new_balnce ?></div>
        <div class="col-xs-3" style="float: right" id="newbalance"></div>

        <button class="col-xs-2 btn btn-success" id="finsh-return" style="float: right;height: 35px;"><?= $text_finsh ?>
        </button>

    </div>

</div>
<div id="show-invoice">
</div>

