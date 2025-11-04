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
     
.table.student-info,
    .table.student-info td {
        border: none !important;
        font-size: 13px;
        color: #000;
        line-height: 1.6;
        margin-bottom: 30px;
        text-align: left;
        width: 90%;
    }

    
     
   
    
    
    </style>
</head>
<body>

<?php if (isset($student, $semester, $transactions, $all_semesters)): ?>

        <div class="logo" style="align-items: center; text-align: center; margin-bottom: 20px;">
                <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 60px; display: block; margin: 0 auto;" alt="University Logo">
        <h3><strong>Jagannath University</strong></h3>
            <p>Department of Computer Science and Engineering</p>
            <p>M.Sc in CSE (Professional) Program</p>
            <p><strong>Deposite Statement</strong></p>
        </div>

<hr style="border: 0.5px dotted #444;  margin: 10px auto;">




    <!-- Student Info -->
    <table class="table student-info">
        <tr>
            <td><strong>Student ID:</strong>&nbsp;&nbsp; <?= $student->std_id ?></td>
            <td><strong>Student Name: </strong>&nbsp;&nbsp;<?= $student->name?></td>
        </tr>
        <tr>
            <td><strong>Batch:</strong> &nbsp;&nbsp;<?= $batch->batch_name ?></td>
            <td><strong>Session: </strong>&nbsp;&nbsp;<?= $batch->session?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong> &nbsp;&nbsp;<?= $student->email ?></td>
            <td><strong>Phone: </strong>&nbsp;&nbsp;<?= $student->phone?></td>
        </tr>

    </table>
     


  

    <!-- Transactions -->
    <h4>Transactions up to <?= htmlspecialchars($semester->semester_id) . ordinal_suffix($semester->semester_id) ?> Semester</h4>

    <?php if (!empty($transactions)): ?>
        <?php
            $total_jnu = 0;
            $total_misc = 0;
            $total_seminar = 0;
            $total_waiver =0;
        ?>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Semester</th>
                    <th>JnU Fund</th>
                    <th>Misc Fund</th>
                    <th>Seminar Fund</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($transactions as $idx => $tx):
                    $total_jnu += $tx->JnU_Amount;
                    $total_misc += $tx->miscellaneous_amount;
                    $total_seminar += $tx->Seminar_amount;
                    $total_waiver += $tx->waiver;
                ?>
                
                <tr>
                    <td><?= $idx + 1 ?></td>
                    <td><?= htmlspecialchars($tx->semester_id) . ordinal_suffix($tx->semester_id) ?></td>
                    <td><?= number_format($tx->JnU_Amount, 2) ?></td>
                    <td><?= number_format($tx->miscellaneous_amount, 2) ?></td>
                    <td><?= number_format($tx->Seminar_amount, 2) ?></td>    
                    <td><?= date('d-m-Y', strtotime($tx->transaction_date)) ?></td>
                </tr>

                
                    

          

                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-end">Total Paid</th>
                    <th><?= number_format($total_jnu) ?></th>
                    <th><?= number_format($total_misc) ?></th>
                    <th><?= number_format($total_seminar) ?></th>
                   
                    <th><strong><?= number_format($total_jnu + $total_misc + $total_seminar) ?> TK</strong></th>
                </tr>
            </tfoot>
        </table>

        <!-- Fee Summary -->
        <h4>Semester-wise Fee and Due Summary</h4>

        <?php $cumulative_fee = 0; ?>
        <table>
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>JnU Fee </th>
                    <th>Misc Fee </th>
                    <th>Seminar Fee </th>
                    <th>Total Fee </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_semesters as $sem):
                    $fee_jnu = $sem->jnu_amount ?? 0;
                    $fee_misc = $sem->miscellaneous_amount ?? 0;
                    $fee_seminar = $sem->seminar_amount ?? 0;
                    $fee_total = $fee_jnu + $fee_misc + $fee_seminar;
                    $cumulative_fee += $fee_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($sem->semester_id) . ordinal_suffix($sem->semester_id) ?> Semester</td>
                    <td><?= number_format($fee_jnu) ?></td>
                    <td><?= number_format($fee_misc) ?></td>
                    <td><?= number_format($fee_seminar) ?></td>
                    <td><?= number_format($fee_total) ?></td>
                </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="4" class="text-end"><strong>Total Semester Fee</strong></td>
                    <td><strong><?= number_format($cumulative_fee) ?> TK</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Paid Semester Fee</strong></td>
                    <td><strong><?= number_format($total_jnu + $total_misc + $total_seminar) ?> TK</strong></td>
                </tr>
                <?php if ($total_waiver): ?>
                    <tr>
                    <td colspan="4" class="text-end"><strong>Total Waiver/Adjusted</strong> </td>
                    <td><strong><?= number_format($total_waiver) ?> TK</strong></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Due</strong></td>
                    <td><strong><?= number_format(max($cumulative_fee - ($total_jnu + $total_misc + $total_seminar+ $total_waiver), 0)) ?> TK</strong></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p><strong>No transactions found for the selected semester range.</strong></p>
    <?php endif; ?>

<?php endif; ?>

<?php
// Helper function
function ordinal_suffix($num) {
    if (!is_numeric($num)) return '';
    $num = intval($num);
    if (in_array(($num % 100), [11, 12, 13])) return 'th';
    switch ($num % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}
?>

</body>
</html>
