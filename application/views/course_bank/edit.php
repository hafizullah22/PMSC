<h2>Edit Course</h2>

<form action="<?= site_url('admin/edit_course_bank/'.$course->course_id) ?>" method="post">
  <div class="mb-3">
    <label for="course_name" class="form-label">Course Name</label>
    <input type="text" name="course_name" id="course_name" class="form-control" value="<?= htmlspecialchars($course->course_name) ?>" required>
  </div>
  
 <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1" <?= $course->status == '1' ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $course->status == '0' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
  
  <button type="submit" class="btn btn-primary">Update Course</button>
  <a href="<?= site_url('admin/course_bank') ?>" class="btn btn-secondary">Cancel</a>
</form>
