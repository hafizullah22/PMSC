<style>
    thead.thead-dark th {
        background-color: #1c26b3ff;
        color: white;
    }
</style>

<a href="<?= site_url('admin/retake_entry') ?>" class="btn btn-primary mb-3">+ Add New Retake</a>
<h2>Retake List For Retake</h2>

<!-- Flash messages -->
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

<!-- Retake table -->
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>#</th>
      <th>Course Name</th>
      <th>Student List</th>
      <th>Exam Year</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($retakes)): ?>
      <?php $i = 1; foreach ($retakes as $b): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= $b->course_name ?></td>
        <td><?= $b->student_list ?></td>
        <td><?= $b->exam_year ?></td>
        <td class="text-nowrap">
    <a href="<?= site_url('admin/edit_retake/'.$b->id) ?>" 
       class="btn btn-sm btn-warning me-1">
        Edit
    </a>
    <a href="<?= site_url('admin/delete_retake/'.$b->id) ?>" 
       class="btn btn-sm btn-danger"
       onclick="return confirm('Are you sure you want to delete this retake?')">
        Delete
    </a>
</td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="5" class="text-center">No retakes found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
