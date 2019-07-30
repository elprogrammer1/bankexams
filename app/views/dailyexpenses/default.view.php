<div class="container">
    <div class="btn-group btn-group-justified">
        <a href="dailyexpenses/create" class="btn btn-info"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
        <a id="showtoday" class="btn btn-info"><i class="fa fa-money"></i> <?= $text_new_today ?></a>
        <a id="showalldays" class="btn btn-info"><?= $text_new_today ?> all</a>
        <a class="btn btn-info"><input type="date" id="chosedate" style="width:  100%;"></a>
    </div>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_name ?></th>
            <th><?= $text_table_Payment ?></th>
            <th><?= $text_table_Created ?></th>
            <th><?= $text_table_Username ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $Dailyexpenses): foreach ($Dailyexpenses as $Dailyexpense): ?>
            <tr>
                <td><?= $Dailyexpense->ExpenseName ?></td>
                <td><?= $Dailyexpense->Payment ?></td>
                <td><?= $Dailyexpense->Created ?></td>
                <td><?= $Dailyexpense->Username ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<script>
    $(function () {
        var day = (new Date()).toLocaleDateString();
        var table = $('.data').DataTable();
        table.columns(2).search('').draw();
        p1 = day.search('/');
        day = day.replace('/', '-');
        m = day.substr(0, p1);
        // console.log('pos 1 :' + p1);
        p2 = day.search('/');
        day = day.replace('/', '-');
        // console.log('pos 2 : ' + p2);
        d = day.substr(p1 + 1, p2 - p1 - 1);
        //console.log(d2);
        y = day.substr(p2 + 1);
        if (m.length == 1) {
            var toDay = y + '-0' + m + '-' + d;
        } else {
            var toDay = y + '-' + m + '-' + d;
        }
        $('#showalldays').click(function () {
            table.columns(2).search('').draw();
        });
        $('#showtoday').click(function () {
            console.log(toDay);
            table.columns(2).search(toDay).draw();
        });


        $('#chosedate').change(function () {
            console.log(this.value);
            $('#DataTables_Table_0_filter input').val(this.value);
            table.columns(2).search(this.value).draw();
        });
    })
</script>