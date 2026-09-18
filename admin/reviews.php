<?php
/**
 * Hospital Management System (HMS) - Admin Reviews Moderation
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$db = getDB();

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = intval($_POST['review_id'] ?? 0);
    $action   = sanitize($_POST['action'] ?? '');

    if ($action === 'status' && !empty($reviewId)) {
        $status = sanitize($_POST['status'] ?? 'approved');
        try {
            $stmt = $db->prepare("UPDATE reviews SET status = ? WHERE id = ?");
            $stmt->execute([$status, $reviewId]);
            setFlash('success', 'Review marked as ' . htmlspecialchars($status) . '.');
            redirect('reviews.php');
        } catch (Exception $e) {
            setFlash('error', 'Error updating review: ' . $e->getMessage());
        }
    }

    if ($action === 'delete' && !empty($reviewId)) {
        try {
            $stmt = $db->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->execute([$reviewId]);
            setFlash('success', 'Review deleted successfully.');
            redirect('reviews.php');
        } catch (Exception $e) {
            setFlash('error', 'Error deleting review: ' . $e->getMessage());
        }
    }
}

// Fetch all reviews
$reviews = [];
try {
    $stmt = $db->query("SELECT r.*, d.name AS doctor_name 
                        FROM reviews r 
                        LEFT JOIN doctors d ON r.doctor_id = d.id 
                        ORDER BY r.created_at DESC, r.id DESC");
    $reviews = $stmt->fetchAll();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Reviews - HMS Admin</title>
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
            <a class="admin-nav-link" href="appointments.php"><i class="bi bi-calendar-check me-1"></i> Appointments</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="doctors.php"><i class="bi bi-people me-1"></i> Doctors</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link" href="messages.php"><i class="bi bi-chat-dots me-1"></i> Messages</a>
          </li>
          <li class="nav-item">
            <a class="admin-nav-link active" href="reviews.php"><i class="bi bi-star me-1"></i> Reviews</a>
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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Patient Reviews &amp; Testimonials</h3>
        <p class="text-muted small mb-0">Total <?= count($reviews) ?> reviews across all specialists.</p>
      </div>
    </div>

    <!-- REVIEWS TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-uppercase">
            <tr>
              <th class="ps-4">Patient</th>
              <th>Rating</th>
              <th>Doctor / Service</th>
              <th>Review Comment</th>
              <th>Submitted</th>
              <th>Status</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($reviews)): ?>
              <?php foreach ($reviews as $rev): ?>
              <tr>
                <td class="ps-4">
                  <div class="fw-bold text-dark"><?= htmlspecialchars($rev['patient_name']) ?></div>
                </td>
                <td>
                  <span class="badge bg-warning text-dark font-monospace fw-bold">
                    ★ <?= number_format($rev['rating'], 1) ?>
                  </span>
                </td>
                <td>
                  <span class="small fw-semibold text-primary"><?= htmlspecialchars($rev['doctor_name'] ?: 'General Hospital') ?></span>
                </td>
                <td style="max-width: 320px;">
                  <p class="small text-secondary mb-0 text-truncate" title="<?= htmlspecialchars($rev['comment']) ?>">
                    "<?= htmlspecialchars($rev['comment']) ?>"
                  </p>
                </td>
                <td>
                  <small class="text-muted"><?= date('M d, Y', strtotime($rev['created_at'])) ?></small>
                </td>
                <td>
                  <?php 
                    $statusClass = match($rev['status']) {
                        'approved' => 'bg-success-subtle text-success',
                        'rejected' => 'bg-danger-subtle text-danger',
                        default    => 'bg-warning-subtle text-warning'
                    };
                  ?>
                  <span class="badge <?= $statusClass ?> rounded-pill px-2 py-1 small"><?= htmlspecialchars($rev['status']) ?></span>
                </td>
                <td class="text-end pe-4">
                  <div class="d-flex justify-content-end gap-1">
                    <?php if ($rev['status'] !== 'approved'): ?>
                      <form action="reviews.php" method="POST" class="d-inline">
                        <input type="hidden" name="action" value="status">
                        <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2" title="Approve">
                          <i class="bi bi-check-lg"></i> Approve
                        </button>
                      </form>
                    <?php endif; ?>

                    <?php if ($rev['status'] !== 'rejected'): ?>
                      <form action="reviews.php" method="POST" class="d-inline">
                        <input type="hidden" name="action" value="status">
                        <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-2" title="Reject">
                          <i class="bi bi-x-lg"></i> Reject
                        </button>
                      </form>
                    <?php endif; ?>

                    <form action="reviews.php" method="POST" class="d-inline">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Delete this review?');" title="Delete">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">No reviews found.</td>
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
