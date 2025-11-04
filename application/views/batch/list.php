
<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }
</style>

<a href="<?= site_url('admin/add_batch') ?>" class="btn btn-primary mb-3">+ Add New Batch</a>
<h2>Batch List</h2>
<!-- Display flash messages -->
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

<!-- Display the list of batches -->
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>ID</th>
      <th>Batch Name</th>
      <th>Session</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($batches as $b): ?>
    <tr>
      <td><?= $b->batch_id ?></td>
      <td><?= $b->batch_name ?></td>
      <td><?= $b->session ?></td>
      <td>
        <a href="<?= site_url('admin/edit_batch/'.$b->batch_id) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/delete_batch/'.$b->batch_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this batch?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
