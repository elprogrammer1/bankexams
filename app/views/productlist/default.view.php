<div class="container">
    <a href="/productlist/create" class="btn btn-info"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th>كود المنتج</th>
            <th><?= $text_table_name ?></th>
            <th><?= $text_table_buy_price ?></th>
            <th><?= $text_table_sell_price ?></th>
            <th><?= $text_table_quantity ?></th>

        </tr>
        </thead>
        <tbody>
        <?php if (false !== $products): foreach ($products as $product): ?>
            <tr>
                <td><?= $product->ProductId ?></td>
                <td><?= $product->Name ?></td>
                <td><?= $product->BuyPrice ?></td>
                <td><?= $product->SellPrice ?></td>
                <td><?= $product->Quantity ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>