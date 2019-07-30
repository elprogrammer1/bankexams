<div class="container">
    <a href="/expensescategories/create" class="btn btn-info"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_name ?></th>
            <th><?= $text_table_cost ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $ExpensesCategories): foreach ($ExpensesCategories as $Categorie): ?>
            <tr>
                <td><?= $Categorie->ExpenseName ?></td>
                <td><?= $Categorie->FixedPayment ?></td>
                <td>
                    <a href="/expensescategories/edit/<?= $Categorie->ExpenseId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/expensescategories/delete/<?= $Categorie->ExpenseId ?>" onclick="if(!confirm('<?=
                    $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>