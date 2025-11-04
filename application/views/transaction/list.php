
<a href="<?= site_url('transaction/add') ?>" class="btn btn-primary mb-3">+ Add Transaction</a>
&nbsp; &nbsp;
<a href="<?= site_url('transaction/single_report') ?>" class="btn btn-success mb-3" target="_blank">Single Report</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
 <h2>Transaction List</h2>
<table class="table table-bordered">
    <thead>
        <tr>
           
            <th>Student ID</th>
            <th>Semester</th>
            <th>JnU Fund</th>
            <th>Misc Fund</th>
            <th>Seminar Fund</th>
            <th>Deposite Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($transactions as $t): ?>
        <?php
            if($t->semester_id == 1) {
                $semester_id = '1st Semester';
            } elseif($t->semester_id == 2) {
                $semester_id = '2nd Semester';
            } elseif($t->semester_id == 3) {
                $semester_id = '3rd Semester';
            } else {
                $semester_id = 'Unknown';
            }
            ?>
        <tr>
           
            <td><?= $t->student_id ?></td>
            
            <td><?= $semester_id ?></td>

            <td><?= $t->JnU_Amount ?> (<?= $t->receipt_no_jnu ?>)</td>
            <td><?= $t->miscellaneous_amount ?> (<?= $t->receipt_no_misc ?>)</td>
            <td><?= $t->Seminar_amount ?> (<?= $t->receipt_no_seminar ?>)</td>
            <td><?= $t->transaction_date ?></td>
            <td>
                <a href="<?= site_url('transaction/edit/' . $t->transaction_id) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('transaction/delete/' . $t->transaction_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
