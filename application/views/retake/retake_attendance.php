<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retake Attendance Sheet</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            margin: 0 auto;
            padding: 15px;
            page-break-after: always;
        }

        .header {
            text-align: center;
            
            padding-bottom: 10px;
        }
       

        .header h2, .header p {
            margin: 3px 0;
        }

        table.attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }

        table.attendance-table th,
        table.attendance-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 13px;
        }

        table.attendance-table th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .footer {
            margin-top: 100px;
            text-align: right;
        }

        .photo {
            width: 50px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #000;
        }

        .signature-box {
            height: 40px;
            width:200px;
        }
        .exam_info{
            margin-top:20px;
            font-size:16px;
        }
    </style>
</head>
<body>



<?php foreach ($courses as $course): ?>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 80px;" alt="Logo">
            <h2>Jagannath University</h2>
            <p>M.Sc. in CSE (Professional) Program</p>
            <p><strong>Retake Attendance Sheet</strong></p>
            <p><strong>Exam Year:</strong> <?= htmlspecialchars($exam_year) ?></p>

            <table class="attendance-table" style="width: 100%; border-collapse: collapse;  font-size: 14px;">
                
                <tr>
                    <td colspan="2">
                        <strong>Course Name and Code:</strong> <?= htmlspecialchars($course->course_name) ?>
                    </td>
                        
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Exam Date:</strong> 
                    </td>
                </tr>
                
            </table>
      <table class="attendance-table" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <td><strong>SL</strong></td>
        <td><strong>Student ID</strong></td>
        <td><strong>Signature</strong></td>
        <td><strong>Remarks</strong></td>
    </tr>

    <?php 
    // Convert comma-separated student IDs into an array
    $student_ids = explode(',', $course->student_list);
    $i = 1;

    foreach ($student_ids as $student_id): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars(trim($student_id)) ?></td>
            <td></td>
            <td></td>
        </tr>
    <?php endforeach; ?>
</table>


</div>
       
        <div class="footer">
        <p>______________________________________</p>
        <p><strong>Invigilator’s Signature and Date</strong></p>
            
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
