<h2>Bulk Upload Student Images by Batch</h2>

<form action="<?= site_url('admin/upload_student_images') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Select Batch</label>
        <select name="batch_id" class="form-control" required>
            <option value="">-- Select Batch --</option>
            <?php foreach ($batches as $batch): ?>
                <option value="<?= $batch->batch_id ?>">Batch <?= htmlspecialchars($batch->batch_name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Select Multiple Images (filename = std_id)</label>
        <input type="file" name="images[]" class="form-control" multiple required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Images</button>
</form>
