<div class="container">
    <a href="/question/create" class="btn btn-info float-right"><i class="fa fa-plus"></i> add question </a>
    <table class="data col-12">
        <thead>
        <tr>
            <td> Id</td>
            <td> DESCREPTION</td>
            <td> TIME</td>
            <td>DIFFICULTY</td>
            <td>course</td>
            <td> Action</td>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $questions): foreach ($questions as $question): ?>
            <tr>
                <td><?= $question->QUESTION_ID ?></td>
                <td><?= substr($question->DESCREPTION, 0, 80) . '....' ?></td>
                <td><?= $question->TIME ?></td>
                <td><?= $question->DIFFICULTY ?></td>
                <td><?= $question->courseName() ?></td>
                <td>
                    <a href="/question/edit/<?= $question->QUESTION_ID ?>" class="btn btn-info"> edit </a>
                    <a href="/question/delete/<?= $question->QUESTION_ID ?>" class="btn  btn-danger"> delete </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>