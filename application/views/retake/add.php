<div class="card shadow-sm p-4">
    <h3 class="mb-4 text-primary">
        &#128218; <!-- 📚 Unicode book icon -->
        Add Student for Retake Course
    </h3>
<h3 style="text-align: right; text-decoration: none"> <a href="<?= site_url('admin/retake_list') ?>">Retake Student List</a></h3>

    <form action="<?= site_url('admin/retake_entry') ?>" method="post" novalidate>
       
    <div class="mb-3">
    <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
    <select name="course_id" id="course_id" class="form-select" required>
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
            <option value="<?= $course->course_id ?>">
                <?= $course->course_name ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


        <div class="mb-3">
            <label for="session" class="form-label">Student List <span class="text-danger">*</span></label>
            <input type="text" name="student_list" id="student_list" class="form-control" placeholder="M230205012,M230205009" required>
        </div>

        
              <!-- Exam Year -->
      <div class="col-md-6">
        <label for="exam_year" class="form-label fw-semibold">Exam Year</label>
        <select name="exam_year" id="exam_year" class="form-select" required>
          <option value="">-- Select Exam Year --</option>
          <?php 
            $currentYear = date('Y'); // Ensure current year is set
            for ($year = $currentYear+1; $year >= $currentYear-1 ; $year--): 
          ?>
            <option value="July-<?= $year ?>"> July-<?= $year ?></option>
            <option value="December-<?= $year ?>"> December-<?= $year ?></option>
          <?php endfor; ?>
        </select>
      </div>
<br>
        <div class="d-flex gap-2 justify-content-left">
            <a href="<?= site_url('admin/batches') ?>" class="btn btn-secondary">
                &#x2B05;&#xFE0F; <!-- ⬅️ Unicode left arrow -->
                Back
            </a>
            <button type="submit" class="btn btn-success">
                &#x2795; <!-- ➕ Unicode plus sign -->
                Add Student
            </button>
        </div>
    </form>
</div>
