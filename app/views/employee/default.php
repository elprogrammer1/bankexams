<a href='/employee/add'><?= $text_add_employee ?></a>
<?php
if (isset($_SESSION['massage'])) {
    echo "<div class='alert alert-danger'><strong> " . $_SESSION['massage'] . " !</strong> </div>";
    unset($_SESSION['massage']);
}
?>
<table class="table  table-striped">
    <tr>
        <th><?= $text_table_employee_name ?></th>
        <th><?= $text_table_employee_age ?></th>
        <th><?= $text_table_employee_address ?></th>
        <th><?= $text_table_employee_tax ?></th>
        <th><?= $text_table_employee_salary ?></th>
        <th><?= $text_table_employee_controler ?></th>
    </tr>
    <?php
    if ($employees != false) {
        foreach ($employees as $e) {
            ?>
            <tr>
                <td><?= $e->name ?></td>
                <td><?= $e->age ?></td>
                <td><?= $e->address ?></td>
                <td><?= $e->salary ?></td>
                <td><?= $e->tax ?></td>
                <td>
                    <a href='/employee/edit/<?= $e->id ?>'><?= $text_edit ?></a>
                    <a href='/employee/delete/<?= $e->id ?>'
                       onclick="if(!confirm('<?= $text_delete_confirm ?> ')) return false;"><?= $text_delet ?></a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="6">NO Employee in table</td>
        </tr>
    <?php } ?>
</table>