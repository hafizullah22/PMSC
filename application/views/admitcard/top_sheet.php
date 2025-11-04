<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course-wise Top Sheet</title>
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
            <p><strong>Top Sheet</strong></p>
            

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
        <h3>Enrolled Students ID For this course:</h3>
        <table class="attendance-table table table-bordered">
                
            <tr>
                <td>
                    <?= implode(', ', array_column($students, 'std_id')) ?>
                </td>
            </tr>
        </table>

        <div class="exam_info">
        <p>Total number of students: <?= count($students) ?></p>
        <p>Number of reported students and their ID:</p>
        <p>Number of absent students and their ID:</p>
        <p>Number of present students:</p>
        </div>
        <div class="footer">
        <p>______________________________________</p>
        <p><strong>Invigilator’s Signature and Date</strong></p>
            
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
