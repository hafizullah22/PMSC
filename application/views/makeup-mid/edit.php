<div class="container mt-1">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Course and Set Exam Date</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/set_makeup_mid/' . $course->course_id) ?>" method="post">
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

                   <div class="col-md-12">
                        <label for="mid_student_list" class="form-label"><strong>Student List</strong> <span class="text-danger">*</span></label>
                        <textarea name="mid_student_list" id="mid_student_list" class="form-control" rows="5"><?= set_value('mid_student_list', $course->mid_student_list) ?></textarea>
                    </div>      

                </div>

                <div class="d-flex justify-content-left mt-4">
                    <button type="submit" class="btn btn-success me-2">Update Student List For Makeup Mid</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
