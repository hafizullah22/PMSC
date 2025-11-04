<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h4 class="card-title mb-4 text-primary">🧑‍🎓 Generate Retake Report and Attendance Sheet</h4>

    <form method="get" action="<?= site_url('admitcard/retake_sheet') ?>" target="_blank" class="row g-4">

      <!-- Exam Year -->
      <div class="col-md-6">
        <label for="exam_year" class="form-label fw-semibold">Retake Exam Year</label>
        <select name="exam_year" id="exam_year" class="form-select" required>
          <option value="">-- Select Exam Year --</option>
          <?php 
            $currentYear = date('Y'); // Ensure current year is set
            for ($year = $currentYear; $year >= $currentYear-1 ; $year--): 
          ?>
            <option value="July-<?= $year ?>"> July-<?= $year ?></option>
            <option value="December-<?= $year ?>"> December-<?= $year ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <!-- Report Type -->
      <div class="col-md-6">
        <label for="report_type" class="form-label fw-semibold">Report Type</label>
        <select name="report_type" id="report_type" class="form-select" required>
          <option value="">-- Select Report Type --</option>
          <option value="0">Retake Report</option>
          <option value="1">Retake Attendance</option>
        </select>
      </div>

      <!-- Submit Button -->
      <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg w-100">
          📥 Generate Retake Sheet
        </button>
      </div>
    </form>
  </div>
</div>
