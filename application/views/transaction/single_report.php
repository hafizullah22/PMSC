<div class="container mt-4">
    <h3 class="mb-3">&#128202; Transaction Report for Single Student</h3>

    <!-- Search Form -->
    <form method="post" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label">Student ID</label>
            <input type="text" name="std_id" class="form-control" placeholder="e.g. M230201012"
                value="<?= htmlspecialchars($this->input->post('std_id') ?? '') ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Semester</label>
            <select name="semester_id" class="form-select" required>
                <option value="">Select Semester</option>
                <option value="1" <?= ($this->input->post('semester_id') ?? '') == 1 ? 'selected' : '' ?>>1st Semester</option>
                <option value="2" <?= ($this->input->post('semester_id') ?? '') == 2 ? 'selected' : '' ?>>2nd Semester</option>
                <option value="3" <?= ($this->input->post('semester_id') ?? '') == 3 ? 'selected' : '' ?>>3rd Semester</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Show Report</button>
        
        </div>
    </form>
</div>

<?php if (isset($student) && isset($semester)): ?>
    <div class="mb-3 text-end">
        <a href="<?= site_url('transaction/single_report_pdf') . '?std_id=' . urlencode($student->std_id) . '&semester_id=' . urlencode($semester->id) ?>" 
           class="btn btn-danger" target="_blank">
            Download PDF Report
        </a>
    </div>
 

<div class="container mt-4">
    <h3 class="text-center mb-4">Student Transaction Report</h3>

    <!-- Student Info -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Student Info</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Student ID</th>
                    <td><?= htmlspecialchars($student->std_id) ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?= htmlspecialchars($student->name) ?></td>
                </tr>
                <tr>
                    <th>Batch</th>
                    <td><?= htmlspecialchars($batch->batch_name ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($student->email ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?= htmlspecialchars($student->phone ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Selected Semester</th>
                    <td><?= htmlspecialchars($semester->semester_id) ?><?= ordinal_suffix($semester->semester_id) ?? '' ?> Semester</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Transactions up to <?= htmlspecialchars($semester->semester_id) ?><?= ordinal_suffix($semester->semester_id) ?> Semester</h5>

            <?php if (!empty($transactions)): ?>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Semester</th>
                            <th>JnU Fund (৳)</th>
                            <th>Misc Fund (৳)</th>
                            <th>Seminar Fund (৳)</th>                
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_jnu = 0;
                            $total_misc = 0;
                            $total_seminar = 0;
                            $total_waiver =0;
                            $total_waiver=0;
                            foreach ($transactions as $idx => $tx):
                                $total_jnu += $tx->JnU_Amount;
                                $total_misc += $tx->miscellaneous_amount;
                                $total_seminar += $tx->Seminar_amount;
                                $total_waiver += $tx->waiver;
                        ?>
                        
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><?= htmlspecialchars($tx->semester_id) ?><?= ordinal_suffix($tx->semester_id) ?></td>
                            <td><?= number_format($tx->JnU_Amount) ?></td>
                            <td><?= number_format($tx->miscellaneous_amount) ?></td>
                            <td><?= number_format($tx->Seminar_amount) ?></td>  
                            <td><?= date('d-m-Y', strtotime($tx->transaction_date)) ?></td>
                            <td>
                        <a href="<?= site_url('transaction/edit/' . $tx->transaction_id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('transaction/delete/' . $tx->transaction_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</a>
                        </td>
                    </tr>
                   
                      <!-- <?php if ($tx->waiver): ?>
                    <tr>
                         <td>Waiver</td>
                                <td><?= number_format($total_waiver) ?></td>
                                <?php else: ?>
                                    <td></td>
                            
                    </tr>
                    <?php endif; ?>
                        <tr> -->
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                       
                            <th colspan="2" class="text-end">Total Paid</th>
                            <th><?= number_format($total_jnu) ?></th>
                            <th><?= number_format($total_misc) ?></th>
                            <th><?= number_format($total_seminar) ?></th>
                            <th><?= number_format($total_jnu + $total_misc + $total_seminar) ?> ৳</th>
                        </tr>
                    </tfoot>
                </table>

                <!-- Semester-wise fee & due summary -->
                <h5 class="mt-4">Semester-wise Fee and Due Summary</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Semester</th>
                            <th>JnU Fee (৳)</th>
                            <th>Misc Fee (৳)</th>
                            <th>Seminar Fee (৳)</th>
                            <th>Total Fee (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cumulative_fee = 0;
                            foreach ($all_semesters as $sem):
                                $fee_jnu = $sem->jnu_amount ?? 0;
                                $fee_misc = $sem->miscellaneous_amount ?? 0;
                                $fee_seminar = $sem->seminar_amount ?? 0;
                                $fee_total = $fee_jnu + $fee_misc + $fee_seminar;
                                $cumulative_fee += $fee_total;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($sem->semester_id) ?><?= ordinal_suffix($sem->semester_id) ?> Semester</td>
                            <td><?= number_format($fee_jnu) ?></td>
                            <td><?= number_format($fee_misc) ?></td>
                            <td><?= number_format($fee_seminar) ?></td>
                            <td><?= number_format($fee_total) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-primary fw-bold">
                            <td colspan="4" class="text-end">Cumulative Fee Up To Selected Semester</td>
                            <td><?= number_format($cumulative_fee) ?> ৳</td>
                        </tr>
                        
                        <tr class="table-success fw-bold">
                            <td colspan="4" class="text-end">Total Paid Semester Fee</td>
                            <td><?= number_format($total_jnu + $total_misc + $total_seminar) ?> ৳</td>
                        </tr>
                        <?php if ($total_waiver): ?>
                        <tr class="table-success fw-bold">
                            <td colspan="4" class="text-end">Total Waiver/Adjusted </td>
                            <td><?= number_format($total_waiver) ?> ৳</td>
                        </tr>
                        <?php endif; ?>
                        
                        <tr class="table-danger fw-bold">
                            <td colspan="4" class="text-end">Total Due</td>
                            <td><?= number_format(max($cumulative_fee - ($total_jnu + $total_misc + $total_seminar+$total_waiver), 0)) ?> ৳</td>
                        </tr>
                    </tbody>
                </table>

            <?php else: ?>
                <div class="alert alert-warning">No transactions found for the selected semester range.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
// Helper function for ordinal suffix for semester numbers
function ordinal_suffix($num) {
    if (!is_numeric($num)) return '';
    $num = intval($num);
    if (in_array(($num % 100), [11,12,13])) {
        return 'th';
    }
    switch ($num % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}
?>
