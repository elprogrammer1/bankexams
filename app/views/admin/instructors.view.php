<div class="container">
    <h1 class="bg-white display-4"> instructors   </h1>
    <table class="data col-12">
        <thead>
        <tr>
            <td> Id </td>
            <td> name  </td>
            <td> courses  </td>
            <td> Action</td>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $items): foreach ($items as $item): ?>
            <tr>
                <td><?= $item->USER_ID ?></td>
                <td><?= $item->USER_NAME ?></td>
                <td><?= $item->coursesNum ?></td>
                <td>
                    <a href="/admin/edituser/<?= $item->USER_ID ?>" class="btn btn-info"> edit </a>
                    <a data-id="<?= $item->USER_ID?>" href="#" class="btn
                    <?= $item->active == 1 ? 'btn-danger' : 'btn-success' ?>  unactive-user"> <?= $item->active ==
                        1 ? 'Unactive' : 'active' ?> </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<script>




</script>