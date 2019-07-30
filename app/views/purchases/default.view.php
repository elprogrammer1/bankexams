<div class="container">
    <a href="/purchases/create" class="btn btn-info"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>

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
        <?php if (false !== $PurchasesInvoices): foreach ($PurchasesInvoices as $PurchasesInvoice): ?>
            <tr>
                <td><?= $PurchasesInvoice->InvoiceId ?></td>
                <td><?= $PurchasesInvoice->Name ?></td>
                <td><?= $PurchasesInvoice->Created ?></td>
                <td><?= $PurchasesInvoice->Username ?></td>
                <td>
                    <a href="/purchases/show/<?= $PurchasesInvoice->InvoiceId ?>"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>