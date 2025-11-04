<h2>Edit Batch</h2>

<form action="<?= site_url('admin/edit_batch/'.$batch->batch_id) ?>" method="post">
  <div class="mb-3">
    <label for="batch_name" class="form-label">Batch Name</label>
    <input type="text" name="batch_name" id="batch_name" class="form-control" value="<?= htmlspecialchars($batch->batch_name) ?>" required>
  </div>
  
  <div class="mb-3">
    <label for="session" class="form-label">Session</label>
    <input type="text" name="session" id="session" class="form-control" value="<?= htmlspecialchars($batch->session) ?>" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Update Batch</button>
  <a href="<?= site_url('admin/batches') ?>" class="btn btn-secondary">Cancel</a>
</form>
