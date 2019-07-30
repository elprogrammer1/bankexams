

<div class="container">
    <a href="/Course/" class="btn btn-primary" style="margin-left:40px;"><i class="fa fa-plus"></i> go to my
        Courses</a>
    <h1 class="bg-white display-4"> Courses   </h1>
    <table class="data col-12">
        <thead>
        <tr>
            <td> #Course ID</td>
            <td>Course Instructor</td>
            <td>Name</td>
            <td>Exam numbrer</td>
        </tr>
        </thead>
        <tbody>
        <?php if (false !== $courses): foreach ($courses as $course ): ?>

            <tr>
                <td> <?= $course->COURSE_ID  ?> </td>
                <td><?= $course->USER_NAME  ?>  </td>
                <td><?= $course->COURSE_NAME  ?> </td>
                <td><?= $course->numexams()  ?> </td>

            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
