<?php
/**
 * Hospital Management System (HMS) - Admin Dashboard
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$db = getDB();
$currentPage = 'index.php';

// Fetch Metrics
$metrics = [
    'total_appointments' => 0,
    'today_appointments' => 0,
    'total_doctors'      => 0,
    'unread_messages'    => 0,
    'total_reviews'      => 0,
    'total_revenue'      => 0.0
];

try {
    $metrics['total_appointments'] = $db->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
    $today = date('Y-m-d');
    $metrics['today_appointments'] = $db->query("SELECT COUNT(*) FROM appointments WHERE appointment_date = '$today'")->fetchColumn();
    $metrics['total_doctors']      = $db->query("SELECT COUNT(*) FROM doctors WHERE status = 1")->fetchColumn();
    $metrics['unread_messages']    = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
    $metrics['total_reviews']      = $db->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
    $metrics['total_revenue']      = $db->query("SELECT SUM(amount) FROM payments WHERE status = 'Success'")->fetchColumn() ?: 0.0;
} catch (Exception $e) {}

// Fetch Recent Appointments
$recentAppointments = [];
try {
    $stmt = $db->query("SELECT a.*, d.name AS doctor_name, dept.name AS department_name 
                        FROM appointments a 
                        LEFT JOIN doctors d ON a.doctor_id = d.id 
                        LEFT JOIN departments dept ON a.department_id = dept.id 
                        ORDER BY a.id DESC LIMIT 8");
    $recentAppointments = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch Recent Inquiries
$recentMessages = [];
try {
    $mStmt = $db->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5");
    $recentMessages = $mStmt->fetchAll();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - HMS Medical Centre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
    }
    .admin-navbar {
      background-color: #0a355c;
    }
    .admin-nav-link {
      color: rgba(255, 255, 255, 0.75);
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .admin-nav-link:hover, .admin-nav-link.active {
      color: #ffffff;
      background-color: rgba(255, 255, 255, 0.12);
    }
    .metric-card {
      background: #ffffff;
      border-radius: 1rem;
      padding: 1.5rem;
      border: 1px solid #e2e8f0;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>

  <!-- ADMIN NAVBAR -->
  <nav class="admin-navbar navbar navbar-expand-lg navbar-dark py-2 sticky-top shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <div class="bg-white p-1 rounded-3 d-inline-flex">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
            <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#0a355c"/>
          </svg>
        </div>
        <span class="fw-bold fs-5 tracking-tight" style="font-family: 'Outfit', sans-serif;">HMS <span class="fw-normal text-white-50">Admin</span></span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="adminNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
          <li class="nav-item">
            <a class="admin-nav-link active" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="appointments.php"><i class="bi bi-calendar-check me-1"></i> Appointments</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="doctors.php"><i class="bi bi-people me-1"></i> Doctors</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="messages.php">
              <i class="bi bi-chat-dots me-1"></i> Messages
              <?php if ($metrics['unread_messages'] > 0): ?>
                <span class="badge bg-danger rounded-pill ms-1"><?= $metrics['unread_messages'] ?></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="reviews.php"><i class="bi bi-star me-1"></i> Reviews</a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Live Site
          </a>
          <div class="dropdown">
            <button class="btn btn-link text-white text-decoration-none dropdown-toggle p-0 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
              <img src="../assets/images/avatars/admin.jpg" alt="Admin" class="rounded-circle border" style="width: 36px; height: 36px; object-fit: cover;">
              <span class="d-none d-md-inline small fw-semibold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2 mt-2">
              <li><h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['user_email'] ?? 'admin@hms.com') ?></h6></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- DASHBOARD CONTENT -->
  <main class="container-fluid px-4 py-4">
    
    <!-- Flash Messages -->
    <?php if ($flash = getFlash()): ?>
      <div class="alert alert-<?= ($flash['type'] === 'success') ? 'success' : 'danger' ?> alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $flash['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Welcome & Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h2 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Hospital Administration Portal</h2>
        <p class="text-muted small mb-0">Overview of patient appointments, clinical staff, and real-time operations.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="appointments.php" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
          <i class="bi bi-calendar-plus me-1"></i> View Appointments
        </a>
        <a href="doctors.php" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold">
          <i class="bi bi-person-plus me-1"></i> Manage Doctors
        </a>
      </div>
    </div>

    <!-- METRICS GRID -->
    <div class="row g-4 mb-4">
      <!-- Appointments -->
      <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="text-muted small fw-bold text-uppercase">Total Appointments</span>
            <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2">
              <i class="bi bi-calendar2-check fs-5"></i>
            </div>
          </div>
          <div class="h3 fw-bold mb-1"><?= number_format($metrics['total_appointments']) ?></div>
          <small class="text-success"><i class="bi bi-arrow-up-short"></i> <?= (int)$metrics['today_appointments'] ?> booked for today</small>
        </div>
      </div>

      <!-- Doctors -->
      <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="text-muted small fw-bold text-uppercase">Active Doctors</span>
            <div class="rounded-3 bg-info bg-opacity-10 text-info p-2">
              <i class="bi bi-hospital fs-5"></i>
            </div>
          </div>
          <div class="h3 fw-bold mb-1"><?= number_format($metrics['total_doctors']) ?></div>
          <small class="text-muted">Across 8 Medical Departments</small>
        </div>
      </div>

      <!-- Inquiries -->
      <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="text-muted small fw-bold text-uppercase">Inquiries &amp; Messages</span>
            <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-2">
              <i class="bi bi-envelope-open fs-5"></i>
            </div>
          </div>
          <div class="h3 fw-bold mb-1"><?= number_format($metrics['unread_messages']) ?></div>
          <small class="text-danger fw-semibold">Requires frontdesk attention</small>
        </div>
      </div>

      <!-- Revenue -->
      <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="text-muted small fw-bold text-uppercase">Total Consultations Value</span>
            <div class="rounded-3 bg-success bg-opacity-10 text-success p-2">
              <i class="bi bi-cash-coin fs-5"></i>
            </div>
          </div>
          <div class="h3 fw-bold mb-1">₹<?= number_format($metrics['total_revenue'], 0) ?></div>
          <small class="text-success"><i class="bi bi-shield-check"></i> Confirmed &amp; Paid</small>
        </div>
      </div>
    </div>

    <!-- RECENT APPOINTMENTS TABLE -->
    <div class="row g-4">
      <div class="col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0" style="color: #0a355c;">Recent Appointments</h5>
            <a href="appointments.php" class="btn btn-sm btn-link text-decoration-none fw-semibold">View All &rarr;</a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light small text-uppercase">
                <tr>
                  <th>Ref #</th>
                  <th>Patient</th>
                  <th>Doctor &amp; Dept</th>
                  <th>Date &amp; Time</th>
                  <th>Status</th>
                  <th>Payment</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($recentAppointments)): ?>
                  <?php foreach ($recentAppointments as $row): ?>
                  <tr>
                    <td><span class="font-monospace small fw-bold text-primary"><?= htmlspecialchars($row['appointment_no']) ?></span></td>
                    <td>
                      <div class="fw-semibold text-dark"><?= htmlspecialchars($row['patient_name']) ?></div>
                      <small class="text-muted"><?= htmlspecialchars($row['patient_phone']) ?></small>
                    </td>
                    <td>
                      <div class="small fw-semibold"><?= htmlspecialchars($row['doctor_name'] ?: 'General Physician') ?></div>
                      <small class="text-muted"><?= htmlspecialchars($row['department_name'] ?: 'General') ?></small>
                    </td>
                    <td>
                      <div class="small fw-medium"><?= date('M d, Y', strtotime($row['appointment_date'])) ?></div>
                      <small class="text-muted"><?= htmlspecialchars($row['appointment_time']) ?></small>
                    </td>
                    <td>
                      <?php 
                        $statusBadge = match($row['status']) {
                            'Confirmed'  => 'bg-success-subtle text-success',
                            'Completed'  => 'bg-primary-subtle text-primary',
                            'Checked In' => 'bg-info-subtle text-info',
                            'Cancelled'  => 'bg-danger-subtle text-danger',
                            default      => 'bg-warning-subtle text-warning'
                        };
                      ?>
                      <span class="badge <?= $statusBadge ?> rounded-pill px-2 py-1 small"><?= htmlspecialchars($row['status']) ?></span>
                    </td>
                    <td>
                      <span class="badge <?= ($row['payment_status'] === 'Paid') ? 'bg-success text-white' : 'bg-secondary text-white' ?> rounded-pill px-2 py-1 small">
                        <?= htmlspecialchars($row['payment_status']) ?>
                      </span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No appointments recorded yet.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- RECENT MESSAGES / INQUIRIES -->
      <div class="col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0" style="color: #0a355c;">New Inquiries</h5>
            <a href="messages.php" class="btn btn-sm btn-link text-decoration-none fw-semibold">Inbox &rarr;</a>
          </div>

          <?php if (!empty($recentMessages)): ?>
            <div class="d-flex flex-column gap-3">
              <?php foreach ($recentMessages as $msg): ?>
              <div class="p-3 bg-light rounded-3 border-start border-3 <?= ($msg['status'] === 'unread') ? 'border-primary' : 'border-secondary' ?>">
                <div class="d-flex justify-content-between align-items-start mb-1">
                  <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($msg['name']) ?></h6>
                  <span class="badge <?= ($msg['status'] === 'unread') ? 'bg-danger' : 'bg-secondary' ?> rounded-pill small"><?= htmlspecialchars($msg['status']) ?></span>
                </div>
                <div class="text-primary small fw-semibold mb-1"><?= htmlspecialchars($msg['subject']) ?></div>
                <p class="text-muted small mb-1 text-truncate"><?= htmlspecialchars($msg['message']) ?></p>
                <small class="text-muted" style="font-size: 0.75rem;"><?= date('M d, H:i', strtotime($msg['created_at'])) ?> &bull; <?= htmlspecialchars($msg['email']) ?></small>
              </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted small text-center py-4 mb-0">No contact messages received yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
