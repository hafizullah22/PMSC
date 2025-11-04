<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }
</style>


<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-md-4">
        <a href="<?= site_url('admin/add_course') ?>" class="btn btn-primary">+ Add Course</a>
    </div>

    <div class="col-md-8">
        <form method="get" action="<?= site_url('admin/courses') ?>" class="d-flex align-items-center">
            <label for="batch_id" class="mr-2 mb-0"> <strong>Filter by Batch:</strong></label>
    &nbsp;&nbsp; &nbsp; &nbsp; 
            <!-- 🔽 Reduced width dropdown -->
            <div style="width: 400px;" class="mr-2">
                <select name="batch_id" id="batch_id" class="form-control" required>
                    <option value="">--Select Batch--</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?= $batch->batch_id ?>"><?= $batch->batch_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
              &nbsp;&nbsp; &nbsp; &nbsp;   
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
</div>



<!-- 🔸 Grouped by Semester -->
<?php if (!empty($course_by_batch_id) && is_array($course_by_batch_id)): ?>
    <h4 class="mt-4 mb-3 text-primary">Courses List of : <?= $batch_name ?? 'N/A' ?></h4>
    <?php foreach ($course_by_batch_id as $semester_id => $courses): ?>
         <?php
        if($semester_id==1)
        {
          $semester_id ="1st Semester";  
        }
        else if($semester_id==2)
        {
            $semester_id="2nd Semester";
        }
        else
        {
            $semester_id="3rd Semester";
        }
        ?>
        <h5 class="mt-4"> <?= htmlspecialchars($semester_id) ?></h5>
       
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name and Code</th>
                        <th>Exam Year</th>
                        <th>Mid Exam Date</th>
                        <th>Final Exam Date</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c->course_id) ?></td>
                            <td><?= htmlspecialchars($c->course_name) ?></td>
                            <td><?= htmlspecialchars($c->exam_year) ?></td>
                            <td>
                            <?= !empty($c->mid_exam_date) && $c->mid_exam_date != "0000-00-00"
                                ? htmlspecialchars(date('d-m-Y', strtotime($c->mid_exam_date)))
                                : '00-00-0000' ?>
                                </td>

                                <td>
                                <?= !empty($c->final_exam_date) && $c->final_exam_date != "0000-00-00"
                                    ? htmlspecialchars(date('d-m-Y', strtotime($c->final_exam_date)))
                                    : '00-00-0000' ?>
                                </td>


                            <td style="text-align:center;">
                                <a href="<?= site_url('admin/edit_course/' . $c->course_id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= site_url('admin/delete_course/' . $c->course_id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this course?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
<?php else: ?>

    <h4 class="mt-4 mb-3 text-primary">All Courses List</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Course ID</th>
                    <th>Batch</th>
                    <th>Course Name and Code</th>
                    <th>Semester</th>
                    <th>Exam Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c->course_id) ?></td>
                        <td><?= htmlspecialchars($c->batch_name) ?></td>
                        <td><?= htmlspecialchars($c->course_name) ?></td>
                        <td>
                            <?php
                                // Convert semester ID to human-readable format
                                $semester_labels = [
                                    1 => '1st Semester',
                                    2 => '2nd Semester',
                                    3 => '3rd Semester'
                                ];
                                echo htmlspecialchars($semester_labels[$c->semester_id] ?? 'N/A');
                            ?>
                        </td>
                        <td><?= htmlspecialchars($c->exam_year) ?></td>
                        <td>
                            <a href="<?= site_url('admin/edit_course/' . $c->course_id) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= site_url('admin/delete_course/' . $c->course_id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this course?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>



