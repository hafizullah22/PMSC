<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Enrollment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        button {
            display: block;
            margin: 0 auto;
            padding: 8px 20px;
            font-size: 14px;
            background: #0073e6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #005bb5;
        }
        label {
            display: block;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

<h2>Course Enrollment Form</h2>


<form method="post" action="<?= site_url('admitcard/Course_Registration?' . http_build_query($_GET)) ?>">
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Courses</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($student->std_id) ?>
                        <input type="hidden" name="student_ids[]" value="<?= $student->std_id ?>">
                    </td>
                    <td>
                        <?= htmlspecialchars($student->name) ?>
                        <input type="hidden" name="student_names[]" value="<?= $student->name ?>">
                    </td>
                    <td>
                        <?php foreach ($courses as $course): ?>
                            <label>
                                <input type="checkbox"
                                       name="enrollments[<?= $student->std_id ?>][]"
                                       value="<?= $course->course_id ?>">
                                <?= $course->course_id ?> - <?= htmlspecialchars($course->course_name) ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit">Course Enrollment</button>
</form>


</body>
</html>
