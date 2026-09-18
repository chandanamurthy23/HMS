<?php
/**
 * Hospital Management System (HMS) - Admin Appointments Management
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$db = getDB();

// Handle Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $apptId        = intval($_POST['appointment_id'] ?? 0);
        $status        = sanitize($_POST['status'] ?? 'Confirmed');
        $paymentStatus = sanitize($_POST['payment_status'] ?? 'Paid');

        try {
            $stmt = $db->prepare("UPDATE appointments SET status = ?, payment_status = ? WHERE id = ?");
            $stmt->execute([$status, $paymentStatus, $apptId]);
            setFlash('success', 'Appointment status updated successfully.');
            redirect('appointments.php');
        } catch (Exception $e) {
            setFlash('error', 'Update error: ' . $e->getMessage());
        }
    }

    if (isset($_POST['delete_appointment'])) {
        $apptId = intval($_POST['appointment_id'] ?? 0);
        try {
            $stmt = $db->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->execute([$apptId]);
            setFlash('success', 'Appointment deleted successfully.');
            redirect('appointments.php');
        } catch (Exception $e) {
            setFlash('error', 'Delete error: ' . $e->getMessage());
        }
    }
}

// Filtering
$statusFilter = sanitize($_GET['status'] ?? '');
$search       = sanitize($_GET['search'] ?? '');

$query = "SELECT a.*, d.name AS doctor_name, dept.name AS department_name 
          FROM appointments a 
          LEFT JOIN doctors d ON a.doctor_id = d.id 
          LEFT JOIN departments dept ON a.department_id = dept.id 
          WHERE 1=1";
$params = [];

if (!empty($statusFilter)) {
    $query .= " AND a.status = ?";
    $params[] = $statusFilter;
}

if (!empty($search)) {
    $query .= " AND (a.patient_name LIKE ? OR a.patient_phone LIKE ? OR a.appointment_no LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY a.appointment_date DESC, a.id DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$appointments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Appointments - HMS Admin</title>
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
            <a class="admin-nav-link" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link active" href="appointments.php"><i class="bi bi-calendar-check me-1"></i> Appointments</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="doctors.php"><i class="bi bi-people me-1"></i> Doctors</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="messages.php"><i class="bi bi-chat-dots me-1"></i> Messages</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="reviews.php"><i class="bi bi-star me-1"></i> Reviews</a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3">
          <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3">Live Site</a>
          <a href="logout.php" class="btn btn-sm btn-outline-danger text-white rounded-pill px-3">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- CONTENT -->
  <main class="container-fluid px-4 py-4">
    
    <!-- Flash Messages -->
    <?php if ($flash = getFlash()): ?>
      <div class="alert alert-<?= ($flash['type'] === 'success') ? 'success' : 'danger' ?> alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $flash['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Title & Controls -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Appointments Registry</h3>
        <p class="text-muted small mb-0">Total <?= count($appointments) ?> appointments matching current criteria.</p>
      </div>
      <div>
        <a href="../book.php" target="_blank" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
          <i class="bi bi-plus-lg me-1"></i> Book New Appointment
        </a>
      </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
      <form action="appointments.php" method="GET" class="row g-3 align-items-center">
        <div class="col-md-5">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search patient name, phone, or Ref ID..." value="<?= htmlspecialchars($search) ?>">
          </div>
        </div>
        <div class="col-md-4">
          <select name="status" class="form-select bg-light" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Confirmed" <?= ($statusFilter === 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
            <option value="Checked In" <?= ($statusFilter === 'Checked In') ? 'selected' : '' ?>>Checked In</option>
            <option value="Completed" <?= ($statusFilter === 'Completed') ? 'selected' : '' ?>>Completed</option>
            <option value="Pending" <?= ($statusFilter === 'Pending') ? 'selected' : '' ?>>Pending</option>
            <option value="Cancelled" <?= ($statusFilter === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
          </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary rounded-pill px-3 w-100 fw-semibold">Filter</button>
          <a href="appointments.php" class="btn btn-light rounded-pill px-3 border">Reset</a>
        </div>
      </form>
    </div>

    <!-- APPOINTMENTS TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-uppercase">
            <tr>
              <th class="ps-4">Reference</th>
              <th>Patient Information</th>
              <th>Doctor &amp; Specialty</th>
              <th>Schedule Slot</th>
              <th>Clinical Reason</th>
              <th>Status</th>
              <th>Payment</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($appointments)): ?>
              <?php foreach ($appointments as $appt): ?>
              <tr>
                <td class="ps-4">
                  <span class="font-monospace fw-bold text-primary"><?= htmlspecialchars($appt['appointment_no']) ?></span>
                </td>
                <td>
                  <div class="fw-bold text-dark"><?= htmlspecialchars($appt['patient_name']) ?></div>
                  <div class="small text-muted"><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($appt['patient_phone']) ?></div>
                  <div class="small text-muted"><?= htmlspecialchars($appt['patient_gender']) ?>, <?= (int)$appt['patient_age'] ?> yrs</div>
                </td>
                <td>
                  <div class="fw-semibold text-primary"><?= htmlspecialchars($appt['doctor_name'] ?: 'General Physician') ?></div>
                  <small class="text-muted"><?= htmlspecialchars($appt['department_name'] ?: 'General OPD') ?></small>
                </td>
                <td>
                  <div class="fw-semibold text-dark"><i class="bi bi-calendar3 me-1 text-primary"></i> <?= date('M d, Y', strtotime($appt['appointment_date'])) ?></div>
                  <small class="text-muted"><i class="bi bi-clock me-1 text-primary"></i> <?= htmlspecialchars($appt['appointment_time']) ?></small>
                </td>
                <td>
                  <span class="d-inline-block text-truncate small text-muted" style="max-width: 140px;" title="<?= htmlspecialchars($appt['reason'] ?: 'Routine Consultation') ?>">
                    <?= htmlspecialchars($appt['reason'] ?: 'Routine consultation') ?>
                  </span>
                </td>
                <td>
                  <?php 
                    $badge = match($appt['status']) {
                        'Confirmed'  => 'bg-success-subtle text-success',
                        'Completed'  => 'bg-primary-subtle text-primary',
                        'Checked In' => 'bg-info-subtle text-info',
                        'Cancelled'  => 'bg-danger-subtle text-danger',
                        default      => 'bg-warning-subtle text-warning'
                    };
                  ?>
                  <span class="badge <?= $badge ?> rounded-pill px-2 py-1 small"><?= htmlspecialchars($appt['status']) ?></span>
                </td>
                <td>
                  <span class="badge <?= ($appt['payment_status'] === 'Paid') ? 'bg-success' : 'bg-secondary' ?> text-white rounded-pill px-2 py-1 small">
                    <?= htmlspecialchars($appt['payment_status']) ?>
                  </span>
                </td>
                <td class="text-end pe-4">
                  <div class="d-flex justify-content-end gap-1">
                    <!-- Update status trigger -->
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $appt['id'] ?>" title="Change Status">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <!-- Print Receipt Link -->
                    <a href="../payment-success.php?appointment_no=<?= urlencode($appt['appointment_no']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2" title="Print Slip">
                      <i class="bi bi-printer"></i>
                    </a>
                  </div>

                  <!-- Edit Modal -->
                  <div class="modal fade text-start" id="editModal<?= $appt['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content rounded-4 border-0 shadow">
                        <form action="appointments.php" method="POST">
                          <input type="hidden" name="update_status" value="1">
                          <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">

                          <div class="modal-header">
                            <h5 class="modal-title fw-bold">Update Appointment #<?= htmlspecialchars($appt['appointment_no']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <label class="form-label small fw-semibold">Patient Name</label>
                              <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($appt['patient_name']) ?>" readonly>
                            </div>

                            <div class="mb-3">
                              <label class="form-label small fw-semibold">Appointment Status</label>
                              <select name="status" class="form-select">
                                <option value="Pending" <?= ($appt['status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= ($appt['status'] === 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Checked In" <?= ($appt['status'] === 'Checked In') ? 'selected' : '' ?>>Checked In</option>
                                <option value="Completed" <?= ($appt['status'] === 'Completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= ($appt['status'] === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                              </select>
                            </div>

                            <div class="mb-3">
                              <label class="form-label small fw-semibold">Payment Status</label>
                              <select name="payment_status" class="form-select">
                                <option value="Paid" <?= ($appt['payment_status'] === 'Paid') ? 'selected' : '' ?>>Paid</option>
                                <option value="Unpaid" <?= ($appt['payment_status'] === 'Unpaid') ? 'selected' : '' ?>>Unpaid</option>
                                <option value="Refunded" <?= ($appt['payment_status'] === 'Refunded') ? 'selected' : '' ?>>Refunded</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">No appointments found matching your filter criteria.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
