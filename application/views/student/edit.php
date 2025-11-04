<div class="container mt-1">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Student</h4>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/edit_student/' . $student->id) ?>" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Student ID (std_id) <span class="text-danger">*</span></label>
                        <input type="text" name="std_id" class="form-control" value="<?= set_value('std_id', $student->std_id) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= set_value('name', $student->name) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Batch <span class="text-danger">*</span></label>
                        <select name="batch_id" class="form-select" required>
                            <option value="">Select Batch</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?= $batch->batch_id ?>" <?= set_select('batch_id', $batch->batch_id, $batch->batch_id == $student->batch_id) ?>>
                                    <?= htmlspecialchars($batch->batch_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= set_value('phone', $student->phone) ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= set_value('email', $student->email) ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-left">
                    <button type="submit" class="btn btn-success me-2">Update Student</button>
                    <a href="<?= site_url('admin/students') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
