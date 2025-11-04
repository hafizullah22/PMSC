<div class="card shadow-sm p-4">
    <h3 class="mb-4 text-primary">
        &#128218; <!-- 📚 Unicode book icon -->
        Add New Course in Course Bank For Retake
    </h3>

    <form action="<?= site_url('admin/add_course_bank') ?>" method="post" novalidate>
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name (Course Code) <span class="text-danger">*</span></label>
            <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Course Title (Course Code)" required>
        </div>

        <div class="d-flex gap-2 justify-content-left">
            <a href="<?= site_url('admin/batches') ?>" class="btn btn-secondary">
                &#x2B05;&#xFE0F; <!-- ⬅️ Unicode left arrow -->
                Back
            </a>
            <button type="submit" class="btn btn-success">
                &#x2795; <!-- ➕ Unicode plus sign -->
                Add Course in Course Bank
            </button>
        </div>
    </form>
</div>
