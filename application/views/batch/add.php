<div class="card shadow-sm p-4">
    <h3 class="mb-4 text-primary">
        &#128218; <!-- 📚 Unicode book icon -->
        Add New Batch
    </h3>

    <form action="<?= site_url('admin/add_batch') ?>" method="post" novalidate>
        <div class="mb-3">
            <label for="batch_name" class="form-label">Batch Name <span class="text-danger">*</span></label>
            <input type="text" name="batch_name" id="batch_name" class="form-control" placeholder="1st Batch" required>
        </div>

        <div class="mb-3">
            <label for="session" class="form-label">Session <span class="text-danger">*</span></label>
            <input type="text" name="session" id="session" class="form-control" placeholder="Summer-2023" required>
        </div>

        <div class="d-flex gap-2 justify-content-left">
            <a href="<?= site_url('admin/batches') ?>" class="btn btn-secondary">
                &#x2B05;&#xFE0F; <!-- ⬅️ Unicode left arrow -->
                Back
            </a>
            <button type="submit" class="btn btn-success">
                &#x2795; <!-- ➕ Unicode plus sign -->
                Add Batch
            </button>
        </div>
    </form>
</div>
