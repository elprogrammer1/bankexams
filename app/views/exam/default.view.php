<div class="container">
    <a href="/exam/add" class="btn btn-info float-right"><i class="fa fa-plus"></i> add exam </a>
    <table class="data col-12">
        <thead>
        <tr>
            <td> Course Name</td>
            <td> TIME</td>
            <td>DIFFICULTY</td>
			<td>points</td>		
			<td>score</td>
            <td>create at </td>
            <td> Action</td>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $exams): foreach ($exams as $exam): ?>
            <tr>
                <td><?= $exam->courseName() ?></td>
                <td><?= $exam->TIME ?></td>
                <td><?= $exam->DIFFICULTY ?></td>
				<td><?= $exam->points ?></td>
				<td><?= $exam->score ?></td>
                <td><?= $exam->create_at ?></td>
                <td>
                    <a href="/exam/view/<?= $exam->EXAM_ID ?>" class="btn btn-info"> view </a>
                    <?php if ($exam->isonline) { ?>
                        <a href="/exam/editonline/<?= $exam->EXAM_ID ?>" class="btn  btn-danger"> edit Setting  </a>
                        <a href="/exam/result/<?= $exam->EXAM_ID ?>" class="btn  btn-danger"> show Result </a>
                        <?php }else{ ?>
                        <a href="/exam/editonline/<?= $exam->EXAM_ID ?>/make" class="btn btn-dark"> Make online  </a>
                    <?php } ?>

                    <a href="/exam/delete/<?= $exam->EXAM_ID ?>" class="btn btn-danger" onclick="if(!confirm('you' +
                                 '  want to delete this Exam')) return false;"> delete </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>