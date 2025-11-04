<div class="card shadow-sm p-4">
    <h3 class="mb-4 text-primary">Add New Course</h3>

    <form action="<?= site_url('admin/add_course') ?>" method="post">
        <div class="row g-3">
            <!-- Batch -->
            <div class="col-md-4">
                <label for="batch_id" class="form-label">Batch <span class="text-danger">*</span></label>
                <select name="batch_id" id="batch_id" class="form-select" required>
                    <option value="">-- Select Batch --</option>
                    <?php foreach ($batches as $batch): ?>
                        <option value="<?= $batch->batch_id ?>"><?= htmlspecialchars($batch->batch_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Semester -->
            <div class="col-md-4">
                <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                <select name="semester_id" id="semester_id" class="form-select" required>
                    <option value="">-- Select Semester --</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                    <option value="3">3rd Semester</option>
                </select>
            </div>

            <!-- Exam Year -->
            <div class="col-md-4">
                <label for="exam_year" class="form-label">Exam Year <span class="text-danger">*</span></label>
                <select name="exam_year" id="exam_year" class="form-select" required>
                    <option value="">-- Select Year --</option>
                    <?php 
                        $currentYear = date("Y");
                        for ($year = $currentYear; $year >= $currentYear - 5; $year--): 
                    ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Course Name & Button -->
            <div class="col-md-9">
                <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter course name" required>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-plus-circle me-1"></i>+ Add Course
                </button>
            </div>
        </div>
    </form>
</div>
