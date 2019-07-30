<div class="container">
    <h2>Edit Employee <?= $employee->name ?></h2>
    <form role="form" method="post">
        <div class="form-group">
            <label for="email">name:</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="name"
                   value="<?= $employee->name ?>">
        </div>
        <div class="form-group">
            <label for="email">age:</label>
            <input type="number" name="age" class="form-control" id="age" placeholder="age"
                   value="<?= $employee->age ?>">
        </div>
        <div class="form-group">
            <label for="email">salary:</label>
            <input type="number" name="salary" class="form-control" id="salary" placeholder="salary"
                   value="<?= $employee->salary ?>">
        </div>
        <div class="form-group">
            <label for="email">address:</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="address"
                   value="<?= $employee->address ?>">
        </div>
        <div class="form-group">
            <label for="email">tax:</label>
            <input type="number" name="tax" step="0.1" max="5" min="1" class="form-control" id="tax" placeholder="tax"
                   value="<?= $employee->tax ?>">
        </div>

        <input type="submit" name="edit" class="btn btn-default"/>
    </form>
</div>