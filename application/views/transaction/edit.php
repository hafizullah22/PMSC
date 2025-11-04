<h2>&#128221; Edit Transaction</h2> <!-- 📝 -->

<form method="post" class="border p-4 rounded shadow-sm">
    <div class="row mb-3">
        <div class="col-md-6">
            <label><strong>Student ID</strong></label>
            <input type="text" name="student_id" class="form-control" value="<?= $transaction->student_id ?>" required />
        </div>
        <div class="col-md-6">
            <label><strong>Semester ID</strong></label>
            <input type="text" name="semester_id" class="form-control" value="<?= $transaction->semester_id ?>" required />
        </div>
    </div>

    <div class="mb-3">
        <label><strong>JnU Amount & Receipt No</strong></label>
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="receipt_no_jnu" class="form-control" placeholder="Receipt No" value="<?= $transaction->receipt_no_jnu ?>">
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">&#2547;</span>
                    <input type="number" name="JnU_Amount" step="0.01" class="form-control" placeholder="Amount" value="<?= $transaction->JnU_Amount ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Miscellaneous Amount & Receipt No</strong></label>
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="receipt_no_misc" class="form-control" placeholder="Receipt No" value="<?= $transaction->receipt_no_misc ?>">
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">&#2547;</span>
                    <input type="number" name="miscellaneous_amount" step="0.01" class="form-control" placeholder="Amount" value="<?= $transaction->miscellaneous_amount ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Seminar Amount & Receipt No</strong></label>
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="receipt_no_seminar" class="form-control" placeholder="Receipt No" value="<?= $transaction->receipt_no_seminar ?>">
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">&#2547;</span>
                    <input type="number" name="Seminar_amount" step="0.01" class="form-control" placeholder="Amount" value="<?= $transaction->Seminar_amount ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Waiver / Adjust</strong></label>
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="waiver" class="form-control" placeholder="Waiver amount" value="<?= $transaction->waiver ?>">
            </div>
            
        </div>
    </div>

    <div class="row align-items-end">
        <div class="col-md-6 mb-3">
            <label><strong>Transaction Date</strong></label>
            <input type="date" name="transaction_date" class="form-control form-control-sm" value="<?= $transaction->transaction_date ?>" required />
        </div>
        <div class="col-md-6 text-left mb-3">
            <button type="submit" class="btn btn-success">&#128190; Update Transaction</button> <!-- 💾 -->
        </div>
    </div>
</form>
