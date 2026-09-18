<?php
/**
 * Hospital Management System (HMS) - Admin Doctors Management
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$db = getDB();

// Handle Add Doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $name          = sanitize($_POST['name'] ?? '');
    $departmentId  = intval($_POST['department_id'] ?? 1);
    $specialty     = sanitize($_POST['specialty'] ?? '');
    $qualification = sanitize($_POST['qualification'] ?? 'MBBS, MD');
    $experience    = sanitize($_POST['experience'] ?? '5+ years');
    $fee           = floatval($_POST['fee'] ?? 800.00);
    $days          = sanitize($_POST['available_days'] ?? 'Mon - Sat');
    $time          = sanitize($_POST['available_time'] ?? '09:00 AM - 05:00 PM');
    $image         = sanitize($_POST['image'] ?? 'assets/images/doctors/dr-ananya-sharma.jpg');

    if (!empty($name) && !empty($specialty)) {
        try {
            $stmt = $db->prepare("INSERT INTO doctors (name, department_id, specialty, qualification, experience, fee, available_days, available_time, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
            $stmt->execute([$name, $departmentId, $specialty, $qualification, $experience, $fee, $days, $time, $image]);
            setFlash('success', 'Doctor added successfully to the registry.');
            redirect('doctors.php');
        } catch (Exception $e) {
            setFlash('error', 'Error adding doctor: ' . $e->getMessage());
        }
    } else {
        setFlash('error', 'Doctor name and specialty are required.');
    }
}

// Handle Status Toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_status'])) {
    $docId = intval($_POST['doctor_id'] ?? 0);
    $currentStatus = intval($_POST['current_status'] ?? 1);
    $newStatus = ($currentStatus === 1) ? 0 : 1;

    try {
        $stmt = $db->prepare("UPDATE doctors SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $docId]);
        setFlash('success', 'Doctor active status toggled successfully.');
        redirect('doctors.php');
    } catch (Exception $e) {
        setFlash('error', 'Error updating status: ' . $e->getMessage());
    }
}

// Fetch departments for dropdown
$departments = [];
try {
    $departments = $db->query("SELECT id, name FROM departments WHERE status = 1 ORDER BY name ASC")->fetchAll();
} catch (Exception $e) {}

// Fetch all doctors
$doctors = [];
try {
    $stmt = $db->query("SELECT d.*, dept.name AS department_name 
                        FROM doctors d 
                        LEFT JOIN departments dept ON d.department_id = dept.id 
                        ORDER BY d.status DESC, d.rating DESC");
    $doctors = $stmt->fetchAll();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Doctors - HMS Admin</title>
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
    .doctor-thumb {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
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
            <a class="admin-nav-link" href="appointments.php"><i class="bi bi-calendar-check me-1"></i> Appointments</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link active" href="doctors.php"><i class="bi bi-people me-1"></i> Doctors</a>
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

    <!-- Title & Action -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Medical Faculty &amp; Specialists</h3>
        <p class="text-muted small mb-0">Total <?= count($doctors) ?> doctors registered across departments.</p>
      </div>
      <div>
        <button class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
          <i class="bi bi-person-plus me-1"></i> Add Specialist Doctor
        </button>
      </div>
    </div>

    <!-- DOCTORS TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-uppercase">
            <tr>
              <th class="ps-4">Doctor</th>
              <th>Department</th>
              <th>Qualification &amp; Experience</th>
              <th>Consultation Fee</th>
              <th>Timings</th>
              <th>Rating</th>
              <th>Status</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($doctors)): ?>
              <?php foreach ($doctors as $doc): ?>
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center gap-3">
                    <img src="../<?= htmlspecialchars($doc['image']) ?>" alt="<?= htmlspecialchars($doc['name']) ?>" class="doctor-thumb border">
                    <div>
                      <div class="fw-bold text-dark"><?= htmlspecialchars($doc['name']) ?></div>
                      <small class="text-primary fw-semibold"><?= htmlspecialchars($doc['specialty']) ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-light text-dark border px-2 py-1"><?= htmlspecialchars($doc['department_name'] ?: 'General') ?></span>
                </td>
                <td>
                  <div class="small fw-semibold text-dark"><?= htmlspecialchars($doc['qualification']) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($doc['experience']) ?></small>
                </td>
                <td>
                  <div class="fw-bold text-dark">₹<?= number_format($doc['fee'], 0) ?></div>
                </td>
                <td>
                  <div class="small fw-medium text-dark"><?= htmlspecialchars($doc['available_days']) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($doc['available_time']) ?></small>
                </td>
                <td>
                  <div class="small text-warning fw-bold">
                    <i class="bi bi-star-fill"></i> <?= number_format($doc['rating'], 1) ?>
                    <span class="text-muted fw-normal">(<?= (int)$doc['reviews_count'] ?>)</span>
                  </div>
                </td>
                <td>
                  <?php if ($doc['status'] == 1): ?>
                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1">Active</span>
                  <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1">Inactive</span>
                  <?php endif; ?>
                </td>
                <td class="text-end pe-4">
                  <form action="doctors.php" method="POST" class="d-inline">
                    <input type="hidden" name="toggle_status" value="1">
                    <input type="hidden" name="doctor_id" value="<?= $doc['id'] ?>">
                    <input type="hidden" name="current_status" value="<?= $doc['status'] ?>">
                    <button type="submit" class="btn btn-sm <?= ($doc['status'] == 1) ? 'btn-outline-warning' : 'btn-outline-success' ?> rounded-pill px-3">
                      <?= ($doc['status'] == 1) ? 'Deactivate' : 'Activate' ?>
                    </button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">No doctors found in database.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <!-- ADD DOCTOR MODAL -->
  <div class="modal fade" id="addDoctorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow">
        <form action="doctors.php" method="POST">
          <input type="hidden" name="add_doctor" value="1">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Add New Specialist Doctor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label small fw-semibold">Doctor Full Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Vikram Reddy" required>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Department <span class="text-danger">*</span></label>
              <select name="department_id" class="form-select" required>
                <?php foreach ($departments as $dept): ?>
                  <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Specialty Title <span class="text-danger">*</span></label>
              <input type="text" name="specialty" class="form-control" placeholder="e.g. Senior Interventional Cardiologist" required>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small fw-semibold">Qualification</label>
                <input type="text" name="qualification" class="form-control" placeholder="MBBS, MD, DM" value="MBBS, MD">
              </div>
              <div class="col-6">
                <label class="form-label small fw-semibold">Experience</label>
                <input type="text" name="experience" class="form-control" placeholder="10+ years" value="10+ years">
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small fw-semibold">Consultation Fee (₹)</label>
                <input type="number" name="fee" class="form-control" placeholder="800" value="800">
              </div>
              <div class="col-6">
                <label class="form-label small fw-semibold">Available Days</label>
                <input type="text" name="available_days" class="form-control" placeholder="Mon - Sat" value="Mon - Sat">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Available Hours</label>
              <input type="text" name="available_time" class="form-control" placeholder="09:00 AM - 05:00 PM" value="09:00 AM - 05:00 PM">
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Photo Asset Path</label>
              <input type="text" name="image" class="form-control" placeholder="assets/images/doctors/dr-ananya-sharma.jpg" value="assets/images/doctors/dr-ananya-sharma.jpg">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Add Doctor</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
