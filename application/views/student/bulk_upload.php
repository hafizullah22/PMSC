<h2>Bulk Upload Students (CSV)</h2>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<form action="<?= site_url('admin/bulk_upload_students') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Select Batch <span class="text-danger">*</span></label>
        <select name="batch_id" class="form-control" required>
            <option value="">-- Select Batch --</option>
            <?php foreach ($batches as $batch): ?>
                <option value="<?= $batch->batch_id ?>"><?= htmlspecialchars($batch->batch_name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Upload CSV File <span class="text-danger">*</span></label>
        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
</form>

<hr>

<h5>CSV Format:</h5>
<pre>std_id,name,phone,email</pre>

<h6>Example:</h6>
<pre>
1001,John Doe,01700000000,john@example.com
1002,Jane Smith,01800000000,jane@example.com
</pre>
