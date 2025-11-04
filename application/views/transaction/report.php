<?php // View File: application/views/transaction/report.php ?>
<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h4 class="card-title mb-3 text-center">📊 Transaction Report (Batch & Semester Wise)</h4>

    <form method="get" action="<?= site_url('transaction/report') ?>" class="row g-3">
      <div class="col-md-4">
        <label for="batch_id" class="form-label"><strong>Batch</strong></label>
        <select name="batch_id" id="batch_id" class="form-select">
          <option value="">-- Select Batch --</option>
          <?php foreach ($batches as $batch): ?>
            <option value="<?= $batch->batch_id ?>" <?= $selected_batch == $batch->batch_id ? 'selected' : '' ?>>
              <?= $batch->batch_name ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label for="semester_id" class="form-label"><strong>Semester</strong></label>
        <select name="semester_id" id="semester_id" class="form-select">
          <option value="">-- Select Semester --</option>
          <option value="1" <?= $selected_semester == 1 ? 'selected' : '' ?>>1st Semester</option>
          <option value="2" <?= $selected_semester == 2 ? 'selected' : '' ?>>2nd Semester</option>
          <option value="3" <?= $selected_semester == 3 ? 'selected' : '' ?>>3rd Semester</option>
        </select>
      </div>

      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
      </div>
    </form>
  </div>
</div>



<?php if (!empty($error)): ?>
    
    <div class="alert alert-danger"><?= $error ?></div>

<?php elseif ($transactions): ?>

<?php if ($transactions): ?>
    <div class="mb-3 text-end">
        <a href="<?= site_url('transaction/pdf_report?batch_id=' . $selected_batch . '&semester_id=' . $selected_semester) ?>" 
           class="btn btn-danger" target="_blank">
            Download PDF Report
        </a>
    </div>
<?php endif; ?>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Paid JnU</th>
            <th>Paid Misc</th>
            <th>Paid Seminar</th>
            <th>Total Paid</th>
            
            <?php foreach ($semester_list as $sem): ?>
               
                <th>Due (<?= $sem->semester_id ?>)</th>
            <?php endforeach; ?>

           <?php if ($semester->semester_id != 1): ?>

                    <th>Total Due</th> 
            <?php endif; ?>

            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $t): ?>
            <?php
                $total_paid = $t->paid_jnu + $t->paid_misc + $t->paid_seminar+$t->waiver;
                $total_due = 0;
            ?>
            <tr>
                <td><?= $t->std_id ?></td>
                <td><?= htmlspecialchars($t->name) ?></td>
                <td><?= number_format($t->paid_jnu) ?></td>
                <td><?= number_format($t->paid_misc) ?></td>
                <td><?= number_format($t->paid_seminar) ?></td>
                <td><?= number_format($total_paid) ?></td>

                <?php foreach ($semester_list as $sem): ?>
                    <?php
                        $sem_due = $semester_due_map[$t->std_id][$sem->semester_id] ?? 0;
                        $total_due += $sem_due;
                    ?>
                    <td><?= number_format($sem_due) ?></td>
                <?php endforeach; ?>

                <?php if ($semester->semester_id != 1): ?>
                <td><?= number_format($total_due) ?></td>
                <?php endif; ?>

                <td><strong><?= $total_due > 0 ? 'Due' : 'Paid' ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-info">No transactions found.</div>
<?php endif; ?>

