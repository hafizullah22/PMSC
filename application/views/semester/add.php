<div class="card shadow-sm p-4">
    <h3 class="mb-4 text-primary">
        &#128221; Add Semester <!-- 📝 -->
    </h3>

    <form action="<?= site_url('admin/add_semester') ?>" method="post" novalidate>

     <div class="mb-3">
            <label for="batch_id" class="form-label"><strong>&#128101; Batch</strong></label> <!-- 👥 -->
            <select name="batch_id" id="batch_id" class="form-control" required>
                <option value="">-- Select Batch --</option>
                <?php foreach ($batches as $batch): ?>
                    <option value="<?= $batch->batch_id ?>"><?= htmlspecialchars($batch->batch_name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="semester_id" class="form-label"><strong>&#128218; Semester</strong></label> <!-- 📚 -->
            <select name="semester_id" id="semester_id" class="form-control" required>
                <option value="">-- Select Semester --</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
                <option value="3">3rd Semester</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="jnu_amount" class="form-label"><strong>&#128176; JnU Amount</strong></label> <!-- 💰 -->
            <input type="number" step="0.01" name="JnU_Amount" id="jnu_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="miscellaneous_amount" class="form-label"><strong>&#128184; Miscellaneous Amount</strong></label> <!-- 💸 -->
            <input type="number" step="0.01" name="miscellaneous_amount" id="miscellaneous_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="seminar_amount" class="form-label"><strong>&#127891; Seminar Amount</strong></label> <!-- 🎓 -->
            <input type="number" step="0.01" name="Seminar_amount" id="seminar_amount" class="form-control" required>
        </div>

        <div class="d-flex gap-2 justify-content-left">
            <a href="<?= site_url('admin/semesters') ?>" class="btn btn-secondary">
                &#11013; Back
            </a>
            <button type="submit" class="btn btn-success">
                &#x2795; Add Semester
            </button>
        </div>
    </form>
</div>
