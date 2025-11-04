<div class="container mt-1">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Course and Set Exam Date</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/edit_course/' . $course->course_id) ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="batch_id" class="form-label"> <strong>Batch</strong> <span class="text-danger">*</span></label>
                        <select name="batch_id" class="form-select" required>
                            <option value="">Select Batch</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?= $batch->batch_id ?>" <?= ($batch->batch_id == $course->batch_id) ? 'selected' : '' ?>>
                                    <?= $batch->batch_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="semester_id" class="form-label"><strong>Semester</strong><span class="text-danger">*</span></label>
                        <select name="semester_id" class="form-select" required>
                            <option value="">Select Semester</option>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <option value="<?= $i ?>" <?= ($course->semester_id == $i) ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="exam_year" class="form-label"><strong> Exam Year </strong><span class="text-danger">*</span></label>
                        <input type="text" name="exam_year" class="form-control" value="<?= set_value('exam_year', $course->exam_year) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="course_name" class="form-label"><strong>Course Name and Code</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="course_name" class="form-control" value="<?= set_value('course_name', $course->course_name) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="mid_exam_date" class="form-label"><strong>Mid Exam Date</strong></label>
                        <input type="date" name="mid_exam_date" class="form-control"
                            value="<?= set_value('mid_exam_date', !empty($course->mid_exam_date) ? date('Y-m-d', strtotime($course->mid_exam_date)) : '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="final_exam_date" class="form-label"><strong>Final Exam Date</strong></label>
                        <input type="date" name="final_exam_date" class="form-control"
                            value="<?= set_value('final_exam_date', !empty($course->final_exam_date) ? date('Y-m-d', strtotime($course->final_exam_date)) : '') ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-left mt-4">
                    <button type="submit" class="btn btn-success me-2">Update Course</button>
                    <a href="<?= site_url('course') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
