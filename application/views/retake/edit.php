<h2>Edit Retake</h2>

<form action="<?= site_url('admin/edit_retake/'.$retake->id) ?>" method="post" novalidate>

    <!-- Course Name -->
    <div class="mb-3">
        <label for="course_id" class="form-label">Course ID <span class="text-danger">*</span></label>
        <input type="text" name="course_id" id="course_id" 
               class="form-control" 
               value="<?= htmlspecialchars($retake->course_id) ?>" required>
               <?= htmlspecialchars($retake->course_name) ?>
    </div>

    <!-- Student List -->
    <div class="mb-3">
        <label for="student_list" class="form-label">Student List <span class="text-danger">*</span></label>
        <textarea name="student_list" id="student_list" class="form-control" required><?= htmlspecialchars($retake->student_list) ?></textarea>
    </div>

    <!-- Exam Year -->
    <div class="col-md-3 mb-3">
        <label for="exam_year" class="form-label fw-semibold">Exam Year</label>
        <select name="exam_year" id="exam_year" class="form-select" required>
            <option value="">-- Select Exam Year --</option>
            <?php 
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= $currentYear-1 ; $year--): 
                    $julyVal = "July-$year";
                    $decVal = "December-$year";
            ?>
                <option value="<?= $julyVal ?>" <?= ($retake->exam_year == $julyVal) ? 'selected' : '' ?>>
                    July-<?= $year ?>
                </option>
                <option value="<?= $decVal ?>" <?= ($retake->exam_year == $decVal) ? 'selected' : '' ?>>
                    December-<?= $year ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2 justify-content-left">
        <a href="<?= site_url('admin/retake_list') ?>" class="btn btn-secondary">
            &#x2B05;&#xFE0F; Back
        </a>
        <button type="submit" class="btn btn-success"> Update Retake</button>
    </div>
</form>
