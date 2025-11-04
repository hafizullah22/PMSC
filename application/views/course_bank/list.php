
<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }
</style>

<a href="<?= site_url('admin/add_course_bank') ?>" class="btn btn-primary mb-3">+ Add New Course in Course Bank For Retake</a>
<h2>Course List For Retake</h2>
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
      <th>Course ID</th>
      <th>Course Name</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    
    <?php foreach ($courses as $b): ?>
      <?php 
    if ($b->status==1) {
        $b->status = 'Active';
    } else {
        $b->status = 'Inactive';
    }
    ?>
    <tr>
      <td><?= $b->course_id ?></td>
      <td><?= $b->course_name ?></td>
      <td><?= $b->status ?></td>
      <td>
        <a href="<?= site_url('admin/edit_course_bank/'.$b->course_id) ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= site_url('admin/delete_course_bank/'.$b->course_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
