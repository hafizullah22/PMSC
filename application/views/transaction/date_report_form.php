<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h4 class="card-title mb-4 text-center">📅 Date Wise Transaction Report</h4>

    <form action="<?= site_url('transaction/date_report') ?>" method="get" target="_blank">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label for="start_date" class="form-label"><strong>Start Date</strong></label>
          <input type="date" id="start_date" name="start_date" class="form-control"
                 value="<?= htmlspecialchars($start_date ?? '') ?>" required>
        </div>

        <div class="col-md-4">
          <label for="end_date" class="form-label"><strong>End Date</strong></label>
          <input type="date" id="end_date" name="end_date" class="form-control"
                 value="<?= htmlspecialchars($end_date ?? '') ?>" required>
        </div>

        <div class="col-md-4">
          <button type="submit" class="btn btn-primary w-100">
            🔍 Search
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
