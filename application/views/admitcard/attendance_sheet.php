<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course-wise Attendance Sheet</title>
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
        hr{border:0.5px solid #000;}
    </style>
</head>
<body>

<?php
function getOrdinalSuffix($n) {
    if (!in_array(($n % 100), [11, 12, 13])) {
        switch ($n % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}
?>

<?php
// Filter courses based on semester (if applicable)
$filtered_courses = isset($courses[0]->semester_id)
    ? array_values(array_filter($courses, function($course) use ($semester_id) {
        return $course->semester_id == $semester_id;
    }))
    : $courses;
 
?>

<?php foreach ($filtered_courses as $course): ?>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 80px;" alt="Logo">
            <h2>Jagannath University</h2>
            <p>M.Sc. in CSE (Professional) Program</p>
            <p><strong>Attendance Sheet</strong></p>


    <table class="attendance-table" style="width: 100%; border-collapse: collapse;  font-size: 14px;">
     <tr>
        <td><strong>Batch:</strong> <?= $batch->batch_name ?></td>
        <td><strong>Session:</strong> <?= $batch->session ?></td>
    </tr>
          <tr>
        <td colspan="2">
            <strong>
                <?= $semester_id . getOrdinalSuffix($semester_id) ?> Semester <?= $exam_type ?> Examination - <?= $exam_year ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>Course Name and Code:</strong> <?= htmlspecialchars($course->course_name) ?>
        </td>
    </tr>
   
    <tr>
        <td colspan="2">
            <strong>Exam Date:</strong>
            <?php
                $exam_date = $exam_type == 0 ? $course->mid_exam_date : $course->final_exam_date;
                echo $exam_date ? date('d-m-Y', strtotime($exam_date)) : 'Not Available';
            ?>
        </td>
    </tr>
</table>


        </div>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th >SL</th>
                     <th style="text-align:center; width: 50px;height:20px;">Picture</th>
                    <th style="text-align: left;">Student ID</th>
                    <th style="text-align: left;">Student Name</th>
                    <th>Signature & Date</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl = 1; foreach ($students as $student): ?>
                   
                    <tr>
                        <td style="text-align: center;"><?= $sl++ ?></td>
                        <td style="text-align: center;">
                            <?php if (!empty($student->image)): ?>
                                <img src="<?= base_url('uploads/students/' . $student->image) ?>" alt="Student Image" class="photo">
                            <?php else: ?>
                                --
                            <?php endif; ?>
                        </td>
                        <td style="text-align: left;"><?= htmlspecialchars($student->std_id) ?></td>
                        <td style="text-align: left;"><?= htmlspecialchars($student->name) ?></td>
                        <td class="signature-box"></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="footer">
            <p>______________________________________</p>
            <p><strong>Invigilator’s Signature and Date</strong></p>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
