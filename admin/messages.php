<?php
/**
 * Hospital Management System (HMS) - Admin Contact Messages Inbox
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$db = getDB();

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msgId = intval($_POST['message_id'] ?? 0);
    $action = sanitize($_POST['action'] ?? '');

    if ($action === 'status' && !empty($msgId)) {
        $status = sanitize($_POST['status'] ?? 'read');
        try {
            $stmt = $db->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
            $stmt->execute([$status, $msgId]);
            setFlash('success', 'Message marked as ' . htmlspecialchars($status) . '.');
            redirect('messages.php');
        } catch (Exception $e) {
            setFlash('error', 'Error: ' . $e->getMessage());
        }
    }

    if ($action === 'delete' && !empty($msgId)) {
        try {
            $stmt = $db->prepare("DELETE FROM contact_messages WHERE id = ?");
            $stmt->execute([$msgId]);
            setFlash('success', 'Message deleted successfully.');
            redirect('messages.php');
        } catch (Exception $e) {
            setFlash('error', 'Error: ' . $e->getMessage());
        }
    }
}

// Filter
$statusFilter = sanitize($_GET['status'] ?? '');
$query = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];

if (!empty($statusFilter)) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY created_at DESC, id DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Messages - HMS Admin</title>
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
            <a class="admin-nav-link active" href="messages.php"><i class="bi bi-chat-dots me-1"></i> Messages</a>
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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">Helpdesk &amp; Contact Inquiries</h3>
        <p class="text-muted small mb-0">Total <?= count($messages) ?> inquiries received.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="messages.php" class="btn btn-sm <?= empty($statusFilter) ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3">All</a>
        <a href="messages.php?status=unread" class="btn btn-sm <?= ($statusFilter === 'unread') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3">Unread</a>
        <a href="messages.php?status=read" class="btn btn-sm <?= ($statusFilter === 'read') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3">Read</a>
        <a href="messages.php?status=replied" class="btn btn-sm <?= ($statusFilter === 'replied') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3">Replied</a>
      </div>
    </div>

    <!-- MESSAGES TABLE -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-uppercase">
            <tr>
              <th class="ps-4">Sender</th>
              <th>Subject</th>
              <th>Message Excerpt</th>
              <th>Date Received</th>
              <th>Status</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($messages)): ?>
              <?php foreach ($messages as $m): ?>
              <tr>
                <td class="ps-4">
                  <div class="fw-bold text-dark"><?= htmlspecialchars($m['name']) ?></div>
                  <div class="small text-muted"><?= htmlspecialchars($m['email']) ?></div>
                  <?php if (!empty($m['phone'])): ?>
                    <div class="small text-muted"><i class="bi bi-phone me-1"></i> <?= htmlspecialchars($m['phone']) ?></div>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1"><?= htmlspecialchars($m['subject']) ?></span>
                </td>
                <td style="max-width: 320px;">
                  <p class="small text-secondary mb-0 text-truncate" title="<?= htmlspecialchars($m['message']) ?>">
                    <?= htmlspecialchars($m['message']) ?>
                  </p>
                </td>
                <td>
                  <div class="small fw-medium text-dark"><?= date('M d, Y', strtotime($m['created_at'])) ?></div>
                  <small class="text-muted"><?= date('h:i A', strtotime($m['created_at'])) ?></small>
                </td>
                <td>
                  <?php 
                    $badgeClass = match($m['status']) {
                        'unread'  => 'bg-danger',
                        'read'    => 'bg-secondary',
                        'replied' => 'bg-success',
                        default   => 'bg-light text-dark'
                    };
                  ?>
                  <span class="badge <?= $badgeClass ?> rounded-pill px-2 py-1 small"><?= htmlspecialchars($m['status']) ?></span>
                </td>
                <td class="text-end pe-4">
                  <div class="d-flex justify-content-end gap-1">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2" data-bs-toggle="modal" data-bs-target="#viewModal<?= $m['id'] ?>">
                      <i class="bi bi-eye"></i> View
                    </button>
                    
                    <form action="messages.php" method="POST" class="d-inline">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Are you sure you want to delete this message?');">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>

                  <!-- VIEW MODAL -->
                  <div class="modal fade text-start" id="viewModal<?= $m['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header">
                          <h5 class="modal-title fw-bold">Message from <?= htmlspecialchars($m['name']) ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <small class="text-muted d-block">Subject</small>
                            <h6 class="fw-bold text-primary"><?= htmlspecialchars($m['subject']) ?></h6>
                          </div>
                          <div class="row g-2 mb-3">
                            <div class="col-6">
                              <small class="text-muted d-block">Email</small>
                              <div class="small fw-semibold"><?= htmlspecialchars($m['email']) ?></div>
                            </div>
                            <div class="col-6">
                              <small class="text-muted d-block">Phone</small>
                              <div class="small fw-semibold"><?= htmlspecialchars($m['phone'] ?: 'N/A') ?></div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <small class="text-muted d-block mb-1">Message</small>
                            <div class="p-3 bg-light rounded-3 small text-secondary leading-relaxed">
                              <?= nl2br(htmlspecialchars($m['message'])) ?>
                            </div>
                          </div>
                          <div class="d-flex gap-2">
                            <form action="messages.php" method="POST" class="flex-grow-1">
                              <input type="hidden" name="action" value="status">
                              <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                              <input type="hidden" name="status" value="read">
                              <button type="submit" class="btn btn-sm btn-outline-secondary w-100 rounded-pill">Mark as Read</button>
                            </form>
                            <form action="messages.php" method="POST" class="flex-grow-1">
                              <input type="hidden" name="action" value="status">
                              <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                              <input type="hidden" name="status" value="replied">
                              <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill">Mark as Replied</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">No messages found in this category.</td>
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
