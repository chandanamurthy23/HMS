<?php
/**
 * Hospital Management System (HMS) - Patient Reviews & Feedback Page
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'Patient Reviews & Testimonials';

// Handle Review Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName = sanitize($_POST['patient_name'] ?? '');
    $rating      = floatval($_POST['rating'] ?? 5.0);
    $comment     = sanitize($_POST['comment'] ?? '');
    $doctorId    = !empty($_POST['doctor_id']) ? intval($_POST['doctor_id']) : null;

    if (empty($patientName) || empty($comment)) {
        setFlash('error', 'Please provide your name and your review comment.');
    } else {
        try {
            // Assign a default avatar
            $avatar = 'assets/images/avatars/testimonial-sneha.jpg';
            
            $stmt = $db->prepare("INSERT INTO reviews (patient_name, rating, comment, avatar, doctor_id, status) VALUES (?, ?, ?, ?, ?, 'approved')");
            $stmt->execute([$patientName, $rating, $comment, $avatar, $doctorId]);
            setFlash('success', 'Thank you for your valuable feedback! Your review has been published.');
            redirect('reviews.php');
        } catch (Exception $e) {
            setFlash('error', 'Error submitting review: ' . $e->getMessage());
        }
    }
}

// Fetch Doctors for the review dropdown
$doctors = [];
try {
    $docStmt = $db->query("SELECT id, name FROM doctors WHERE status = 1 ORDER BY name ASC");
    $doctors = $docStmt->fetchAll();
} catch (Exception $e) {}

// Fetch approved reviews
$reviews = [];
try {
    $stmt = $db->query("SELECT r.*, d.name AS doctor_name 
                        FROM reviews r 
                        LEFT JOIN doctors d ON r.doctor_id = d.id 
                        WHERE r.status = 'approved' 
                        ORDER BY r.created_at DESC");
    $reviews = $stmt->fetchAll();
} catch (Exception $e) {}

// Calculate average rating
$totalReviews = count($reviews);
$avgRating = 4.9;
if ($totalReviews > 0) {
    $sum = array_sum(array_column($reviews, 'rating'));
    $avgRating = round($sum / $totalReviews, 1);
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- REVIEWS HERO -->
<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-2 text-white-50 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Reviews</li>
          </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-3">Stories of Healing &amp; Trust</h1>
        <p class="lead text-white-50 mb-0">Read genuine feedback from patients and families who experienced the clinical care and human compassion of HMS Hospital.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <button type="button" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#writeReviewModal">
          <i class="bi bi-pencil-square me-2"></i> Write a Review
        </button>
      </div>
    </div>
  </div>
</section>

<!-- RATING SUMMARY STATS -->
<section class="bg-white border-bottom shadow-sm">
  <div class="container-xl py-4">
    <div class="row g-4 align-items-center">
      <div class="col-md-4 text-center border-end-md">
        <div class="display-4 fw-bold text-primary mb-0"><?= number_format($avgRating, 1) ?></div>
        <div class="text-warning fs-5 my-1">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-half"></i>
        </div>
        <div class="text-muted small fw-semibold">Overall Patient Satisfaction (<?= $totalReviews ?> reviews)</div>
      </div>
      <div class="col-md-8">
        <div class="row g-3 text-center">
          <div class="col-sm-4">
            <div class="p-3 bg-light rounded-4">
              <div class="h3 fw-bold text-success mb-1">98.4%</div>
              <small class="text-muted">Recommendation Rate</small>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="p-3 bg-light rounded-4">
              <div class="h3 fw-bold text-info mb-1">&lt; 15 min</div>
              <small class="text-muted">Avg OPD Wait Time</small>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="p-3 bg-light rounded-4">
              <div class="h3 fw-bold text-primary mb-1">24/7</div>
              <small class="text-muted">Nursing Attention</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAIN REVIEWS GRID -->
<section class="py-5 bg-light">
  <div class="container-xl py-3">

    <!-- Flash Messages -->
    <?php if ($flash = getFlash()): ?>
      <div class="alert alert-<?= ($flash['type'] === 'success') ? 'success' : 'danger' ?> alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-<?= ($flash['type'] === 'success') ? 'check-circle-fill fs-5' : 'exclamation-triangle-fill fs-5' ?>"></i>
          <div><?= $flash['message'] ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="row g-4">
      <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $rev): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column justify-content-between hover-lift transition">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="text-warning fs-6">
                  <?php 
                    $fullStars = floor($rev['rating']);
                    $halfStar = ($rev['rating'] - $fullStars) >= 0.5;
                    for ($i = 0; $i < $fullStars; $i++) echo '<i class="bi bi-star-fill"></i> ';
                    if ($halfStar) echo '<i class="bi bi-star-half"></i> ';
                  ?>
                </div>
                <span class="badge bg-success-subtle text-success small rounded-pill px-2 py-1"><i class="bi bi-patch-check-fill me-1"></i> Verified Patient</span>
              </div>
              <p class="text-secondary leading-relaxed mb-4">"<?= nl2br(htmlspecialchars($rev['comment'])) ?>"</p>
            </div>
            
            <div class="pt-3 border-top d-flex align-items-center gap-3">
              <img src="<?= htmlspecialchars($rev['avatar'] ?: 'assets/images/avatars/testimonial-rahul.jpg') ?>" alt="<?= htmlspecialchars($rev['patient_name']) ?>" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
              <div>
                <h6 class="fw-bold mb-0" style="color: var(--hms-navy-primary);"><?= htmlspecialchars($rev['patient_name']) ?></h6>
                <?php if (!empty($rev['doctor_name'])): ?>
                  <small class="text-primary fw-medium">Treated by <?= htmlspecialchars($rev['doctor_name']) ?></small>
                <?php else: ?>
                  <small class="text-muted"><?= date('M d, Y', strtotime($rev['created_at'])) ?></small>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center py-5">
          <p class="text-muted">No reviews yet. Be the first to share your experience!</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- WRITE REVIEW MODAL -->
<div class="modal fade" id="writeReviewModal" tabindex="-1" aria-labelledby="writeReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-bottom-0 pb-0">
        <div>
          <h5 class="modal-title fw-bold" id="writeReviewModalLabel" style="color: var(--hms-navy-primary);">Share Your Experience</h5>
          <small class="text-muted">Your feedback helps us continuously elevate patient care.</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3 pb-4">
        <form action="reviews.php" method="POST">
          <div class="mb-3">
            <label for="rev_patient_name" class="form-label fw-semibold small">Your Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control bg-light py-2" id="rev_patient_name" name="patient_name" placeholder="e.g. Ramesh Kumar" required>
          </div>

          <div class="mb-3">
            <label for="rev_doctor_id" class="form-label fw-semibold small">Consulted Doctor (Optional)</label>
            <select class="form-select bg-light py-2" id="rev_doctor_id" name="doctor_id">
              <option value="">General Hospital Experience</option>
              <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="rev_rating" class="form-label fw-semibold small">Rating <span class="text-danger">*</span></label>
            <select class="form-select bg-light py-2" id="rev_rating" name="rating" required>
              <option value="5.0" selected>⭐⭐⭐⭐⭐ (5.0 - Excellent)</option>
              <option value="4.5">⭐⭐⭐⭐½ (4.5 - Very Good)</option>
              <option value="4.0">⭐⭐⭐⭐ (4.0 - Good)</option>
              <option value="3.0">⭐⭐⭐ (3.0 - Average)</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="rev_comment" class="form-label fw-semibold small">Your Review <span class="text-danger">*</span></label>
            <textarea class="form-control bg-light py-2" id="rev_comment" name="comment" rows="4" placeholder="Tell us about the doctor, nurses, facilities, or treatment outcome..." required></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
            <i class="bi bi-send-fill me-2"></i> Submit Feedback
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
