<style>
    thead.thead-dark th {
        background-color: #2f3adaff;
        color: white;
    }
</style>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>


<div class="row mb-6">
    <div class="col-md-6">
        <a href="<?= site_url('admin/add_student') ?>" class="btn btn-primary mb-3">+ Add Student</a>
        <a href="<?= site_url('admin/bulk_upload_students') ?>" class="btn btn-secondary mb-3">Bulk Upload Student</a>
        <a href="<?= site_url('admin/image_upload_form') ?>" class="btn btn-info mb-3">Bulk Upload Images</a>
    </div>

    <div class="col-md-6">
        <form method="get" action="<?= site_url('admin/students') ?>" class="d-flex align-items-center">
            <label for="batch_id" class="mr-2 mb-0"> <strong>Filter by Batch:</strong></label>
    &nbsp;&nbsp; &nbsp; &nbsp; 
            <!-- 🔽 Reduced width dropdown -->
            <div style="width: 300px;" class="mr-2">
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
<?php if (!empty($student_by_batch_id) && is_array($student_by_batch_id)): ?>
   
       <h4 class="mt-4 mb-3 text-primary">Student List of : <?= $batch_name ?? 'N/A' ?></h4>  
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Student ID</th>
                        <th>Studnet Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;?>
                    <?php foreach ($student_by_batch_id as $s): ?>
                       
                            <tr>
                                <td><?=$i++;?></td>
                                <td><?= htmlspecialchars($s->std_id) ?></td>
                                <td><?= htmlspecialchars($s->name) ?></td>
                                <td>
                                <a href="https://wa.me/+88<?= htmlspecialchars($s->phone) ?>?text=<?= urlencode("Dear {$s->name},\n\nI hope this message finds you well.\n\nI am Md. Monirul Islam, Assistant Registrar, Department of Computer Science and Engineering, Jagannath University.\n\nKindly review the transaction report against your deposited slip and confirm whether all details are accurate. If you notice any discrepancies, please inform us at your earliest convenience.\n\nThank you for your cooperation.") ?>" 
                                target="_blank">
                                    <?= htmlspecialchars($s->phone) ?>
                                </a>
                                </td>
                                <td><?= htmlspecialchars($s->email) ?></td>
                                <td>
                                    <?php if ($s->image): ?>
                                        <img src="<?= base_url('uploads/students/'.$s->image) ?>" alt="img" style="width:50px;height:50px;">
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center;">
                                    <a href="<?= site_url('admin/edit_student/' . $s->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= site_url('admin/delete_student/' . $s->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this course?')">Delete</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
   

<?php else: ?>
    <h4 class=" mt-4 mb-3 text-primary"> All Students List</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>SL</th>
                <th>Std ID</th>
                <th>Name</th>
                <th>Batch</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s->id ?></td>
                <td><?= htmlspecialchars($s->std_id) ?></td>
                <td><?= htmlspecialchars($s->name) ?></td>
                <td><?= htmlspecialchars($s->batch_name) ?></td>
                <td><?= htmlspecialchars($s->phone) ?></td>
                <td><?= htmlspecialchars($s->email) ?></td>
                <td>
                    <?php if ($s->image): ?>
                        <img src="<?= base_url('uploads/students/'.$s->image) ?>" alt="img" style="width:50px;height:50px;">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= site_url('admin/edit_student/'.$s->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= site_url('admin/delete_student/'.$s->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>