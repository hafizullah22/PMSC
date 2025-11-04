<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Transaction Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .text-end {
            text-align: right;
        }
      
    
    
    </style>
</head>
<body>
 
<?php
if($selected_semester==1)
{
    $selected_semester="1st Semester";
}
else if($selected_semester==2)
{
    $selected_semester="Up to 2nd Semester";
}
else{
    $selected_semester = "Up to 3rd Semester";
}
?>
<div class="logo" style="align-items: center; text-align: center; margin-bottom: 20px;">
        <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 60px; display: block; margin: 0 auto;" alt="University Logo">
   <h3><strong>Jagannath University</strong></h3>
    <p>Department of Computer Science and Engineering</p>
    <p>M.Sc in CSE (Professional) Program</p>
    <p> <strong>Deposite Statement</strong></p>
    <p><strong>Batch:</strong> <?=$batch_name->batch_name?></p>
<p><strong>Semester:</strong>&nbsp;&nbsp;<?=$selected_semester?></p>


    </div>


<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Phone</th>
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
                <td><?= htmlspecialchars($t->phone) ?></td>
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
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>