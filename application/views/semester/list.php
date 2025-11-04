
<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }
</style>


<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-md-4">
        <a href="<?= site_url('admin/add_semester') ?>" class="btn btn-primary">+ Add Semester</a>
    </div>

    <div class="col-md-8">
        <form method="get" action="<?= site_url('admin/semesters') ?>" class="d-flex align-items-center">
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

  

<?php if (!empty($semester_by_batch_id) && is_array($semester_by_batch_id)): ?>
   <h3 class="mt-4 mb-3 text-primary">Semester List of : <?= $batch_name ?? 'N/A' ?></h3>
<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            
         
            <th>Semester</th>
            <th>JnU Amount</th>
            <th>Miscellaneous Amount</th>
            <th>Seminar Amount</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
 
    <?php foreach ($semester_by_batch_id as $s): ?>
        
        <?php
            $total_amount = $s->jnu_amount + $s->miscellaneous_amount + $s->seminar_amount;
             if($s->semester_id==1)
                    {
                        $s->semester_id="1st Semester";
                    }
                    else if($s->semester_id==2)
                    {
                        $s->semester_id="2nd Semester";
                    }
                    else { $s->semester_id="3rd Semester";}
        ?>
    
        <tr>
           
            <td><?= htmlspecialchars($s->semester_id) ?></td>
            <td><?= number_format($s->jnu_amount, 2) ?></td>
            <td><?= number_format($s->miscellaneous_amount, 2) ?></td>
            <td><?= number_format($s->seminar_amount, 2) ?></td>
            <td><?= number_format($total_amount, 2) ?></td>
            <td>
                <a href="<?= site_url('admin/edit_semester/' . $s->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= site_url('admin/delete_semester/' . $s->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this semester?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <h3 class="mt-4 mb-3 text-primary"> All Semester List </h3>
    <table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            
            <th>Batch</th>
            <th>Semester</th>
            <th>JnU Amount</th>
            <th>Miscellaneous Amount</th>
            <th>Seminar Amount</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
 
    <?php foreach ($semesters as $s): ?>
        
        <?php
            $total_amount = $s->jnu_amount + $s->miscellaneous_amount + $s->seminar_amount;
             if($s->semester_id==1)
                    {
                        $s->semester_id="1st Semester";
                    }
                    else if($s->semester_id==2)
                    {
                        $s->semester_id="2nd Semester";
                    }
                    else { $s->semester_id="3rd Semester";}
        ?>
    
        <tr>
           <td><?= htmlspecialchars($s->batch_name) ?></td>
            <td><?= htmlspecialchars($s->semester_id) ?></td>
            <td><?= number_format($s->jnu_amount, 2) ?></td>
            <td><?= number_format($s->miscellaneous_amount, 2) ?></td>
            <td><?= number_format($s->seminar_amount, 2) ?></td>
            <td><?= number_format($total_amount, 2) ?></td>
            <td>
                <a href="<?= site_url('admin/edit_semester/' . $s->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= site_url('admin/delete_semester/' . $s->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this semester?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>