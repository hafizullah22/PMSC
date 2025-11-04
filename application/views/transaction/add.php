<h3 class="text-left mb-4">&#2547; Add New Transaction</h3> <!-- 📝 -->

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<div class="border p-4 rounded shadow-sm bg-light">
    <form method="post">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="student_id"><strong>Student ID</strong></label>
                <input type="text" name="student_id" class="form-control" placeholder="e.g. M230201012" required />
            </div>
            <div class="col-md-6">
                <label for="semester_id"><strong>Semester</strong></label>
                <select name="semester_id" class="form-control" required>
                    <option value="">--Select Semester--</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                    <option value="3">3rd Semester</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label><strong>JnU Amount & Receipt No</strong></label>
            <div class="input-group">
                <input type="text" name="receipt_no_jnu" class="form-control" placeholder="Receipt No">
                <input type="number" name="JnU_Amount" step="0.01" class="form-control" placeholder="Amount">
            </div>
        </div>

        <div class="mb-3">
            <label><strong>Miscellaneous Amount & Receipt No</strong></label>
            <div class="input-group">
                <input type="text" name="receipt_no_misc" class="form-control" placeholder="Receipt No">
                <input type="number" name="miscellaneous_amount" step="0.01" class="form-control" placeholder="Amount">
            </div>
        </div>

        <div class="mb-3">
            <label><strong>Seminar Amount & Receipt No</strong></label>
            <div class="input-group">
                <input type="text" name="receipt_no_seminar" class="form-control" placeholder="Receipt No">
                <input type="number" name="Seminar_amount" step="0.01" class="form-control" placeholder="Amount">
            </div>
        </div>

        <div class="row align-items-end mb-3">
            <div class="col-md-6 col-lg-4">
                <label><strong>Deposit Date</strong></label>
                <input type="date" name="transaction_date" class="form-control" value="<?= date('Y-m-d') ?>" required />
            </div>
            <div class="col-md-6 col-lg-4 text-left">
                <button type="submit" class="btn btn-success mt-2">
                    &#128190; Save Transaction <!-- 💾 -->
                </button>
            </div>
        </div>
    </form>
</div>
