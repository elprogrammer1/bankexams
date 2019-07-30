<div class="container">
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
                <td class="d-block">
                    <a href="/question/edit/<?= $question->QUESTION_ID ?>" class="btn btn-info"> edit </a>
                    <a href="/question/delete/<?= $question->QUESTION_ID ?>" onclick="if(!confirm('you' +
                                 ' want to delete this Question ? ')) return false;"  class="btn  btn-danger"> delete
                    </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>