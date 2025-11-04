<h2>Add Student</h2>

<form action="<?= site_url('admin/add_student') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Student ID (std_id)</label>
        <input type="text" name="std_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Batch</label>
        <select name="batch_id" class="form-control" required>
            <option value="">--Select Batch--</option>
            <?php foreach ($batches as $batch): ?>
                <option value="<?= $batch->batch_id ?>"><?= htmlspecialchars($batch->batch_name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Student Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= set_value('phone') ?>">
    </div>
    <div class="mb-3">
        <label>Student Email</label>
        <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
    </div>
    <!-- <div class="mb-3">
        <label>Image (optional)</label>
        <input type="file" name="image" class="form-control">
    </div> -->
    <button type="submit" class="btn btn-success">Add Student</button>
</form>
