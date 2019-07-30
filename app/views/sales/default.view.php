<div class="container">
    <a href="/sales/create" class="btn btn-info"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_number ?></th>
            <th><?= $text_table_supplier ?></th>
            <th><?= $text_table_date ?></th>
            <th><?= $text_table_user ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $SalesInvoices): foreach ($SalesInvoices as $SalesInvoice): ?>
            <tr>
                <td><?= $SalesInvoice->InvoiceId ?></td>
                <td><?= $SalesInvoice->Name ?></td>
                <td><?= $SalesInvoice->Created ?></td>
                <td><?= $SalesInvoice->Username ?></td>
                <td>
                    <a href="/sales/show/<?= $SalesInvoice->InvoiceId ?>"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>