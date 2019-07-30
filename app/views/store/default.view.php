<div class="container">
    <table class="data">
        <thead>
        <tr class="row">
            <th class="col-xs-3"><?= $text_table_code ?></th>
            <th class="col-xs-3"><?= $text_table_name ?></th>
            <th class="col-xs-3"><?= $text_table_quentity ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $products): foreach ($products as $product): ?>
            <tr class="row <?= $product->QuantityLimit >= $product->Quantity ? 'btn-warning' : '' ?> ">
                <td class="col-xs-2"><?= $product->ProductId ?></td>
                <td class="col-xs-5 more"><?= $product->Name ?></td>
                <td class="col-xs-5"><?= $product->Quantity . '  ' ?>
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

            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>