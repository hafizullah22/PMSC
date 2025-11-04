<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Date Wise Transaction Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #080101ff;
            margin: 10px;
        }
    

        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
            font-weight: 600;
        }
        p {
            text-align: center;
            margin: 2px 0;
        }
        hr {
            border: none;
            border-top: 1px solid #aaa;
            margin: 10px 0 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            
        }
        table, th, td {
            border: 1px solid #444;
            font-size: 12px;
        }
        th {
            background-color: #f1ededff;
            font-weight: 600;
            padding: 6px;
            text-align: center;
        }
        td {
            padding: 5px 6px;
            vertical-align: middle;
            text-align: center;
        }
        tfoot tr {
            /* font-weight: 700; */
            background-color: #e0e0e0;
        }
        .right-align {
            text-align: right;
            padding-right: 10px;
        }
    </style>
</head>
<body>
    <div class="logo" style="align-items: center; text-align: center; margin-bottom: 20px;">
        <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 80px; display: block; margin: 0 auto;" alt="University Logo">
    </div>


    <p><strong>Jagannath University</strong></p>
    <p>Department of Computer Science and Engineering</p>
    <p>M.Sc in CSE (Professional) Program</p>
    <p><strong>Deposite Statement</strong></p>

        <?php
        if (!empty($transactions)) {
            $dates = array_map(function($t) {
                return $t->transaction_date;
            }, $transactions);

            $from = min($dates);
            $to = max($dates);
            ?>

            <p style="margin-top:10px;"><strong>From:</strong> <?= date('d-m-Y', strtotime($from)) ?>
            &nbsp; <strong>To:</strong> <?= date('d-m-Y', strtotime($to)) ?></p>

        <?php } ?>

    

    <?php if (!empty($transactions)): ?>
    <table style="font-size: 12px;">
        <thead>
            <tr>
                <th>SL</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Batch</th>
                <th>Semester</th>
                <th>JnU Amount</th>
                <th>JnU Receipt</th>
                <th>Deposite Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $S = 1; ?>
        <?php foreach ($transactions as $t): ?>

            <tr>
                <td><?= $S++ ?></td>

                <td><?= htmlspecialchars($t->student_id) ?></td>
                <td><?= htmlspecialchars($t->student_name) ?></td>
                <td>
                    <!-- <?php if ($t->batch_id == 1): ?>
                        <?= htmlspecialchars($t->batch_id) ?><sup>st</sup> Batch
                    <?php elseif ($t->batch_id == 2): ?>
                        <?= htmlspecialchars($t->batch_id) ?><sup>nd</sup> Batch
                    <?php elseif ($t->batch_id == 3): ?>
                        <?= htmlspecialchars($t->batch_id) ?><sup>rd</sup> Batch
                    <?php elseif ($t->batch_id >= 4): ?>
                        <?= htmlspecialchars($t->batch_id) ?><sup>th</sup> Batch
                    <?php endif; ?> -->

                    <?= htmlspecialchars($t->batch_name) ?>
                </td>
                <td>
                    <?php if($t->semester_id == 1): ?> 1st Semester
                    <?php elseif($t->semester_id == 2): ?> 2nd Semester
                    <?php elseif($t->semester_id == 3): ?> 3rd Semester
            
                    <?php endif; ?>
                </td>
                <td><?= number_format($t->JnU_Amount) ?></td>
                <td><?= htmlspecialchars($t->receipt_no_jnu) ?></td>
                <td><?= date('d-m-Y', strtotime($t->transaction_date)) ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right-align"><strong>Total Deposite:</strong></td>
                <td><strong><?= number_format(array_sum(array_column($transactions, 'JnU_Amount'))) ?> TK</strong></td>
                <td colspan="2"></td>
            </tr>
            <tr>

                <td colspan="8" style="text-align:right;"><strong>In Words:&nbsp;</strong> <?= number_to_words(array_sum(array_column($transactions, 'JnU_Amount'))) ?> Taka Only &nbsp;&nbsp;</td>
                       
            </tr>
            
        </tfoot>
    </table>
    <?php else: ?>
        <p style="text-align:right; font-style: italic; color: #777;">No transactions found for selected date range.</p>
    <?php endif; ?>



    <div class="footer" style="margin-top: 90px;">
        <p style="text-align:right;">________________________________</p>
        <p style="text-align:right; margin-right:100px; font-weight: bold;">Director</p>
        <p style="text-align:right;">M.Sc. in CSE (Professional) Program</p>
        <p style="text-align:right;">Dept. of Computer Science and Engineering</p>
        <p style="text-align:right;margin-right:70px;">Jagannath University</p>
    </div>
    

</body>
</html>
