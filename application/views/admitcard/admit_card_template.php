<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admit Card</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 700px;
            margin: 0 auto;
            padding: 15px;
            margin-bottom: 30px;
            page-break-after: always;
        }
        .logo-header {
            text-align: center;
        }
        .logo-header h2, .logo-header p {
            margin: 0;
            padding: 3px 0;
        }
        .photo-box {
            width: 120px;
            height: 150px;
            border: 1px solid #000;
            text-align: center;
            line-height: 150px;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
        }
        .admit-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .courses-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .courses-table td {
            padding: 5px;
        }
        .note {
            margin-top: 15px;
            font-style: italic;
        }
        .signature {
            text-align: right;
            margin-top: 60px;
        }
        .instructions {
            margin-top: 20px;
            font-size: 12px;
        }
        .instructions h4 {
            text-decoration: underline;
            font-weight: bold;
            text-align:left;
        }
        .instructions ul {
            margin: 0;
            padding-left: 0px;
            list-style: none;
        }
        .instructions ul li::before {
            content: "* ";
            color: black;
            font-weight: bold;
        }
        .instructions ul li::after{
            margin-right: 1px;
        }

          .footer {
            margin-top: 40px;
        }
        .signatue p {
            margin: 10px;
            line-height: 0.7;
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

<?php foreach ($students as $student): ?>
    <div class="container">
        <!-- Header with Logo and Photo -->
        <table class="info-table">
            <tr>
                <td width="20%" style="text-align: center;">
                    <?php
                        $photo_url = base_url('uploads/students/' . $student->image);
                        if (!file_exists(FCPATH . 'uploads/students/' . $student->image) || empty($student->image)) {
                            $photo_url = base_url('uploads/students/default.jpg');
                        }
                    ?>
                    <img src="<?= $photo_url ?>" alt="Student Photo" width="120" height="150" style="border: 1px solid #000;" />
                </td>

                <td width="48%" class="logo-header">
                    <img src="<?= base_url('assets/logo/jagannath-university-logo-vector.png') ?>" style="height: 60px;" alt="University Logo">
                    <h2>Jagannath University</h2>
                    <p>M.Sc. in CSE (Professional) Program</p>
                    <p><?= $semester_id . getOrdinalSuffix($semester_id) ?> Semester <?=$exam_type?> Examination - <?= $exam_year ?></p>
                </td>

                <td width="32%">
                    <p><strong>Student ID:</strong> <?= htmlspecialchars($student->std_id) ?></p>
                    <p><strong>Session:</strong> <?= htmlspecialchars($session_id) ?></p>
                    <p><strong>Batch:&nbsp;</strong><?= $batch->batch_name?></p>
                </td>
                
            </tr>
        </table>

        <!-- Title -->
        <div class="admit-title">Admit Card</div>

        <!-- Student Name -->
        <p><strong>Student's Full Name:</strong> <strong><?= strtoupper(htmlspecialchars($student->name)) ?></strong></p>

        <!-- Subjects -->
        <h3 style="text-decoration: underline; text-align: center; margin-top: 20px;">List of Subjects (With Code)</h3>
        <!-- Course Table -->
            <?php
// Filter only if 'semester_id' exists in $courses
$filtered_courses = isset($courses[0]->semester_id) 
    ? array_values(array_filter($courses, function($course) use ($semester_id) {
        return $course->semester_id == $semester_id;
    }))
    : $courses; // if no semester_id exists, use all
?>

<?php if (!empty($filtered_courses)): ?>
    <table class="courses-table table table-bordered">
        <tbody>
            <?php 
            for ($i = 0; $i < count($filtered_courses); $i += 2): 
                $course1 = $filtered_courses[$i];
                $course2 = $filtered_courses[$i + 1] ?? null;
            ?>
            <tr>
                <td>
                    <strong><?= sprintf('%02d.', $i + 1) ?></strong> <?= htmlspecialchars($course1->course_name) ?>
                </td>
                <td>
                    <?php if ($course2): ?>
                        <strong><?= sprintf('%02d.', $i + 2) ?></strong> <?= htmlspecialchars($course2->course_name) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No courses found for this semester.</p>
<?php endif; ?>



        <!-- Note -->
        <p class="note">
            <strong>N.B:</strong> <?= strtoupper(htmlspecialchars($student->name)) ?> (<?= $student->std_id ?>) has paid 
            <?php if ($semester_id == 3): ?>
                all semester fees.
            <?php elseif ($semester_id == 1): ?>
                1st semester fees.
            <?php elseif ($semester_id == 2): ?>
                2nd semester fees.
            <?php endif; ?>
            No pending dues.
        </p>


        <!-- Signature -->
        <div class="signature">
            <p>___________________________________</p>
            <p><strong>Director</strong><br>
            [M.Sc. in CSE (P)] <br>
            Dept. of Computer Science and Engineering<br>
            <strong>Jagannath University</strong></p>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <h4>Instructions for Examinee:</h4>
            <ul>
                <li>Examinee is not allowed to carry books, cellular phone, answer notes, laptop, tab, any written  
documents in the examination hall other than Admit Card & Examination Kits.</li>
                <li>No candidate will be allowed to enter into the examination hall without admit card.</li>
                <li>No candidate will be allowed to enter into the examination hall after 30 minutes of the starting time of the examination.</li>
                <li>Unfair means in the examination as mentioned in the Admit Card and misbehavior with invigilators 
and hall staffs will be liable to punishment according to the university rules and regulations which  
may extend from cancellation of the concerned course/semester to expulsion from the university.</li>
<li>Disciplinary actions will be taken against the students violating above instructions.</li>
            </ul>
        </div>
    </div>

<?php endforeach; ?>

</body>
</html>
