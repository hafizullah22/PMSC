<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }

    /* লম্বা student list এর জন্য td */
    td.student-list-cell {
        max-height: 100px;          
        overflow-y: auto;
        white-space: normal;        
        word-wrap: break-word;      
    }

    /* টেবিল responsive এবং spacing */
    .table-responsive {
        margin-top: 15px;
    }

    table.table {
        table-layout: fixed;       
        width: 100%;
    }

    table.table th, table.table td {
        vertical-align: middle;
    }

    /* বাটনের spacing */
    .btn-sm {
        padding: 4px 8px;
    }
</style>


<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="row mb-4">
    

    <div class="col-md-8">
        <form method="get" action="<?= site_url('admin/makeup_mid') ?>" class="d-flex align-items-center">
            <label for="batch_id" class="mr-2 mb-0"> <strong>Select Batch For Makeup Mid</strong></label>
    &nbsp;&nbsp; &nbsp; &nbsp; 
            <!-- 🔽 Reduced width dropdown -->
            <div style="width: 500px;" class="mr-2">
                <select name="batch_id" id="batch_id" class="form-control" required>
                    <option value="">--Select Batch--</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?= $batch->batch_id ?>"><?= $batch->batch_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
              &nbsp;&nbsp; &nbsp; &nbsp;   
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


<hr>


<!-- Filter Section (যেমন আছে তেমন রেখে দেয়া যাবে) -->

<!-- Courses Table -->
<?php if (!empty($course_by_batch_id) && is_array($course_by_batch_id)): ?>
    <h4 class="mt-4 mb-3 text-primary">Courses List of : <?= $batch_name ?? 'N/A' ?></h4>
    <?php foreach ($course_by_batch_id as $semester_id => $courses): ?>
        <?php
            $semester_label = 'N/A';
            if ($semester_id == 1) {
                $semester_label = "1st Semester";
            } elseif ($semester_id == 2) {
                $semester_label = "2nd Semester";
            } elseif ($semester_id == 3) {
                $semester_label = "3rd Semester";
            }
        ?>
        <h5 class="mt-4"><?= htmlspecialchars($semester_label) ?></h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th style="width:10%;">Course ID</th>
                        <th style="width:30%;">Course Name and Code</th>
                        <th style="width:10%;">Exam Year</th>
                        <th style="width:40%;">Student List</th>
                        <th style="width:10%; text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c->course_id) ?></td>
                            <td><?= htmlspecialchars($c->course_name) ?></td>
                            <td><?= htmlspecialchars($c->exam_year) ?></td>
                            <td class="student-list-cell"><?= nl2br(htmlspecialchars($c->mid_student_list)) ?></td>
                            <td style="text-align:center;">
                                <a href="<?= site_url('admin/set_makeup_mid/' . $c->course_id) ?>" class="btn btn-warning btn-sm">Makeup Mid Set</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h4 class="mt-4 mb-3 text-primary">Make Up Mid Student List</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="width:10%;">Course ID</th>
                    <th style="width:10%;">Batch</th>
                    <th style="width:30%;">Course Name and Code</th>
                    <th style="width:10%;">Semester</th>
                    <th style="width:10%;">Exam Year</th>
                    <th style="width:30%;">Student List</th>
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
                                $semester_labels = [
                                    1 => '1st Semester',
                                    2 => '2nd Semester',
                                    3 => '3rd Semester'
                                ];
                                echo htmlspecialchars($semester_labels[$c->semester_id] ?? 'N/A');
                            ?>
                        </td>
                        <td><?= htmlspecialchars($c->exam_year) ?></td>
                        <td class="student-list-cell"><?= nl2br(htmlspecialchars($c->mid_student_list)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
