<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= isset($title) ? $title : 'Admin Dashboard' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    #sidebar {
      width: 250px;
      min-height: 100vh;
      background-color: #2e3136ff;
    }
    #sidebar .nav-link {
      color: #cbd5e1;
      padding: 10px 15px;
      border-radius: 0.375rem;
      margin-bottom: 5px;
      transition: all 0.2s ease-in-out;
    }
    #sidebar .nav-link:hover {
      background-color: #2563eb;
      color: #fff;
    }
    #sidebar .nav-link.active {
      background-color: #2563eb;
      color: #fff;
    }
    #content {
      flex-grow: 1;
      padding: 30px;
      background-color: #f9fafb;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div>
      <a class="navbar-brand mb-0 h1" href="<?= site_url('admin/dashboard') ?>">PMSC Dashboard</a>
    </div>
    <div class="text-white medium"><strong>M.Sc in CSE (Professional) Program</strong></div>
    <div class="d-flex align-items-center">
      <span class="navbar-text text-white me-3">
        Welcome, <?= htmlspecialchars($this->session->userdata('admin_name')) ?>
      </span>
      <a href="<?= site_url('admin/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="d-flex">
  <!-- Sidebar -->
  <nav id="sidebar" class="d-flex flex-column p-3 shadow-sm">
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
          Dashboard
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/batches') ?>" class="nav-link <?= ($this->uri->segment(2) == 'batches') ? 'active' : '' ?>">
          Batches
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/semesters') ?>" class="nav-link <?= ($this->uri->segment(2) == 'semesters') ? 'active' : '' ?>">
          Semesters
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/students') ?>" class="nav-link <?= in_array($this->uri->segment(2), ['students', 'add_student', 'bulk_upload_students', 'image_upload_form']) ? 'active' : '' ?>">
          Students
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/courses') ?>" class="nav-link <?= ($this->uri->segment(2) == 'courses') ? 'active' : '' ?>">
          Courses
        </a>
      </li>
      <li>
        <a href="<?= site_url('admitcard/form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'form') ? 'active' : '' ?>">
          Admit Card
        </a>
      </li>
      <li>
        <a href="<?= site_url('/transaction') ?>" class="nav-link <?= ($this->uri->segment(2) == 'transaction') ? 'active' : '' ?>">
          Transactions
        </a>
      </li>
      <li>
        <a href="<?= site_url('transaction/report') ?>" class="nav-link <?= ($this->uri->segment(2) == 'report') ? 'active' : '' ?>">
          Report by Batch
        </a>
      </li>
      <li>
        <a href="<?= site_url('transaction/date_report_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'date_report') ? 'active' : '' ?>">
          Report by Date
        </a>
      </li>
      <li>
        <a href="<?= site_url('admitcard/attendance_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'attendance_form') ? 'active' : '' ?>">
          Attendance Sheet
        </a>
      </li>
      <li>
        <a href="<?= site_url('admitcard/seat_plan_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'seat_plan_form') ? 'active' : '' ?>">
          Seat Plan
        </a>
      </li>
      <li>
        <a href="<?= site_url('admitcard/top_sheet_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'top_sheet_form') ? 'active' : '' ?>">
          Top Sheet
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/course_bank') ?>" class="nav-link <?= ($this->uri->segment(2) == 'course_bank') ? 'active' : '' ?>">
          Course Bank (Retake)
        </a>
      </li>
      <li>
        <a href="<?= site_url('admin/retake_entry') ?>" class="nav-link <?= ($this->uri->segment(2) == 'retake_entry') ? 'active' : '' ?>">
          Retake Student Entry
        </a>
      </li>
       <li>
        <a href="<?= site_url('admitcard/retake_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'retake_form') ? 'active' : '' ?>">
          Retake Sheet
        </a>
      </li>

      <li>
        <a href="<?= site_url('admin/makeup_mid') ?>" class="nav-link <?= ($this->uri->segment(2) == 'makeup_mid') ? 'active' : '' ?>">
         Makeup Mid
        </a>
      </li>
      <li>
          <a href="<?= site_url('admitcard/makeup_mid_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'makeup_mid_form') ? 'active' : '' ?>">
          Makeup Mid Sheet
        </a>
      </li>
      <li>
          <a href="<?= site_url('admitcard/course_registration_form') ?>" class="nav-link <?= ($this->uri->segment(2) == 'course_registration_form') ? 'active' : '' ?>">
         Course Registration
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Content -->
  <main id="content" class="w-100">
    <?php if (isset($content)) $this->load->view($content); ?>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
