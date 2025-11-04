<div class="container mt-1">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Semester</h5>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/edit_semester/' . $semester->id) ?>" method="post">

                <?php
                function getSemesterName($id) {
                    $names = [
                        1 => "1st Semester",
                        2 => "2nd Semester",
                        3 => "3rd Semester"
                    ];
                    return $names[$id] ?? "Semester $id";
                }
                ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Semester</strong><span class="text-danger">*</span></label>
                        <select name="semester_id" class="form-select" required>
                            <?php if (!empty($semester->semester_id)): ?>
                                <option value="<?= htmlspecialchars($semester->semester_id) ?>">
                                    <?= getSemesterName($semester->semester_id) ?>
                                </option>
                            <?php else: ?>
                                <option value="">-- Select Semester --</option>
                            <?php endif; ?>

                            <?php foreach ([1, 2, 3] as $sem_id): ?>
                                <?php if ($sem_id != $semester->semester_id): ?>
                                    <option value="<?= $sem_id ?>"><?= getSemesterName($sem_id) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Batch</strong><span class="text-danger">*</span></label>
                        <select name="batch_id" class="form-select" required>
                            <option value="">Select Batch</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?= $batch->batch_id ?>" <?= ($semester->batch_id == $batch->batch_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($batch->batch_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>JnU Amount</strong><span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="jnu_amount" class="form-control" value="<?= $semester->jnu_amount ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Miscellaneous Amount</strong> <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="miscellaneous_amount" class="form-control" value="<?= $semester->miscellaneous_amount ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong> Seminar Amount </strong><span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="seminar_amount" class="form-control" value="<?= $semester->seminar_amount ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-left">
                    <button type="submit" class="btn btn-success me-2">Update Semester</button>
                    <a href="<?= site_url('admin/semesters') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
