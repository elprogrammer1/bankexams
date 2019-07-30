<div class="container">
    <a class="btn btn-info float-right" href="/exam/download/<?= $exam->EXAM_ID ?>"> Download as PDF  </a>
    <a class="btn btn-info float-left" href="/exam/downloadmodelAnswer/<?= $exam->EXAM_ID ?>"> Download Answer as PDF  </a>
<div class="mb-3 clearfix"></div>
    <div class="row">

    <div class='well exam col-12 ' style="    border-radius: 27px;">
        <ul class="list-group">
            <?php $i = 0;
            foreach ($question as $q) {
                    $i++;
                    ?>
                    <li class="list-group-item"><span class="label label-primary"> <?= $i .')' ?></span>
                        <?= $q->DESCREPTION  ?>
                    </li>
                    <?php } ?>
        </ul>
    </div>

</div>
</div>