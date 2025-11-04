<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h4 class="card-title mb-3">🎓 Registration Report</h4>

    <form method="get" action="<?= site_url('admitcard/registration_report') ?>" target="_blank" class="row g-3">

      <!-- Batch Selection -->
      <div class="col-md-6">
        <label for="batch_id" class="form-label"><strong>Batch</strong></label>
        <select name="batch_id" id="batch_id" class="form-select" required>
          <option value="">-- Select Batch --</option>
          <?php foreach ($batches as $batch): ?>
            <option value="<?= $batch->batch_id ?>"><?= $batch->batch_name ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Session Selection -->
      <div class="col-md-6">
        <label for="session_id" class="form-label"><strong>Session</strong></label>
        <select name="session_id" id="session_id" class="form-select" required>
          <option value="">-- Select Session --</option>
          <?php 
            $currentYear = date("Y");
            for ($year = $currentYear; $year >= $currentYear - 3; $year--):
          ?>
            <option value="Summer-<?= $year ?>">Summer - <?= $year ?></option>
            <option value="Winter-<?= $year ?>">Winter - <?= $year ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <!-- Semester Selection -->
      <div class="col-md-6">
        <label for="semester_id" class="form-label"><strong>Semester</strong></label>
        <select name="semester_id" id="semester_id" class="form-select" required>
          <option value="">-- Select Semester --</option>
          <option value="1">1st Semester</option>
          <option value="2">2nd Semester</option>
          <option value="3">3rd Semester</option>
        </select>
      </div>

      <!-- Exam Year -->
      <div class="col-md-6">
        <label for="exam_year" class="form-label"><strong>Exam Year</strong></label>
        <select name="exam_year" id="exam_year" class="form-select" required>
          <option value="">-- Select Exam Year --</option>
          <?php 
            for ($year = $currentYear; $year >= $currentYear - 5; $year--):
          ?>
            <option value="<?= $year ?>"><?= $year ?></option>
          <?php endfor; ?>
        </select>
      </div>

       <!-- Exam Type -->
      <div class="col-md-6">
        <label for="exam_type" class="form-label fw-semibold">Exam Type</label>
        <select name="exam_type" id="exam_type" class="form-select" required>
          <option value="">-- Select Exam Type --</option>
          <option value="0">Mid</option>
          <option value="1">Final</option>
        </select>
      </div>

      <!-- Submit Button -->
      <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">📥 Submit</button>
      </div>
    </form>
  </div>
</div>
