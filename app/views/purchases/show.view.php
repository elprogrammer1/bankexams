<legend class="text-center"><?= $text_legend ?></legend>
<div class="  input_wrapper col-xs-6 col-sm-4"> <?= $text_bill ?> <span><?= $id ?></span>
</div>
<div class="  input_wrapper col-xs-6 col-sm-4 ">  <?= $invoic->Created ?> </div>
<div class="  input_wrapper col-xs-12 col-sm-4 "><?= $supplier->Name ?> </div>
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
    <tbody>
    <?php $sum = 0;
    if (false !== $products): foreach ($products as $product): ?>
        <tr>
            <td><?= $product->ProductId ?></td>
            <td><?= $product->Name ?></td>
            <td><?= $product->ProductPrice ?></td>
            <td><?= $product->Quantity ?>
                <?php
                switch ($product->Quantity) {
                    case 1 :
                        echo $text_unit_1;
                        break;
                    case 2:
                        echo $text_unit_2;
                        break;
                    case 3:
                        echo $text_unit_3;
                        break;
                    default:
                        echo $text_unit_4;
                }
                ?>
            </td>
            <td><?= $product->ProductPrice * $product->Quantity ?></td>
        </tr>
        <?php $sum += $product->ProductPrice * $product->Quantity; endforeach; endif; ?>
    <tr>
        <td style="height: 40px;" colspan="5"></td>
    </tr>
    <tr>
        <td><?= $text_bill_price ?></td>
        <td><?= $sum ?> </td>
        <td> <?= $text_old_babnce ?> </td>
        <td colspan="2"><?= $receipt == false ? 0 : $receipt->PaymentAmount ?></td>
    </tr>

    <tr>
        <td><?= $text_bill_price ?></td>
        <td><?= $sum ?> </td>
        <td><?= $text_old_babnce ?> </td>
        <td><?= $sum ?> </td>
    </tr>

    <tr>
        <td><?= $text_bill_price ?></td>
        <td><?= $sum ?> </td>
        <td><?= $text_total_payed ?></td>
        <td colspan="2"><?= $receipt == false ? 0 : $receipt->PaymentAmount ?></td>
    </tr>
    </tbody>
</table>


<br><br><br>
<?php
/*
<thead>
        <tr>
            <th class="col-xs-4"><?=$text_payed_date ?></th>
            <th class="col-xs-4"><?=$text_payed ?></th>
            <th class="col-xs-4"><?=$text_UserName ?></th>
        </tr>
    </thead>

    <?php //$sum =0; if(false !== $receipts):  foreach ($receipts as $receipt): ?>
<tr>
                <td><?=$receipt->Created  ?></td>
                <td><?=$receipt->PaymentAmount  ?></td>
                <td><?=$receipt->FirstName ?> <?=$receipt->LastName ?></td>
            </tr>
            <?php $sum +=$receipt->PaymentAmount;  endforeach; endif; ?>

*/


?>