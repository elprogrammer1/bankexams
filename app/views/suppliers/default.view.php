<div class="container">
    <a href="/suppliers/create" class="btn btn-info "><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr class="row">
            <th class="col-xs-3"><?= $text_table_name ?></th>
            <th class="col-xs-3 more"> الرصيد</th>
            <th class="col-xs-3"><?= $text_table_phone_number ?></th>
            <th class="col-xs-3"><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $suppliers): foreach ($suppliers as $supplier): ?>
            <tr class="row">
                <td class="col-xs-3"><?= $supplier->Name ?></td>
                <td class="col-xs-3 more"><?= $supplier->balance ?></td>
                <td class="col-xs-3"><?= $supplier->PhoneNumber ?></td>
                <td class="col-xs-3">
                    <a href="/suppliers/edit/<?= $supplier->SupplierId ?>"><i class="fa fa-edit"></i></a>

                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>