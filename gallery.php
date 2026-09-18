<?php
/**
 * Hospital Management System (HMS) - Facilities & Gallery Page
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'World-Class Facilities';

// Fetch facilities from database
$facilities = [];
try {
    $stmt = $db->query("SELECT * FROM facilities WHERE status = 1 ORDER BY id ASC");
    $facilities = $stmt->fetchAll();
} catch (Exception $e) {
    // Fallback if table error
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- GALLERY HERO -->
<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-2 text-white-50 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Facilities</li>
          </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-3">World-Class Infrastructure &amp; Medical Facilities</h1>
        <p class="lead text-white-50 mb-0">Engineered with international clinical benchmarks, laminar cleanrooms, and robotic surgical suites to provide the safest therapeutic environment for our patients.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="book.php" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow">
          <i class="bi bi-calendar-check me-2"></i> Book Appointment
        </a>
      </div>
    </div>
  </div>
</section>

<!-- FACILITIES SHOWCASE -->
<section class="py-5 bg-light">
  <div class="container-xl py-3">
    
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-2">Hospital Tour</span>
      <h2 class="fw-bold display-6" style="color: var(--hms-navy-primary);">Advanced Technology for Precision Healing</h2>
      <p class="text-muted">Take a virtual look inside our specialized clinical units, surgical suites, and round-the-clock emergency support centres.</p>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4">
      <?php if (!empty($facilities)): ?>
        <?php foreach ($facilities as $fac): ?>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift transition">
            <div class="position-relative overflow-hidden" style="height: 220px;">
              <img src="<?= htmlspecialchars($fac['image']) ?>" alt="<?= htmlspecialchars($fac['name']) ?>" class="w-100 h-100 object-fit-cover" loading="lazy">
              <div class="position-absolute top-0 end-0 m-3">
                <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small">
                  <i class="bi bi-shield-check text-warning me-1"></i> Certified
                </span>
              </div>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
              <div>
                <h5 class="fw-bold mb-2" style="color: var(--hms-navy-primary);"><?= htmlspecialchars($fac['name']) ?></h5>
                <p class="text-muted small mb-3"><?= htmlspecialchars($fac['description']) ?></p>
              </div>
              <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="badge bg-light text-primary border px-2 py-1 small fw-semibold">24/7 Available</span>
                <a href="book.php" class="text-primary fw-bold small text-decoration-none">Consult &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Default Fallback if DB empty -->
        <div class="col-12 text-center py-5">
          <p class="text-muted">Facilities are being loaded...</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- INFRASTRUCTURE HIGHLIGHTS -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mt-5 bg-white">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">Standards of Safety</span>
          <h3 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Sterilization, Clean Air &amp; Emergency Power</h3>
          <p class="text-muted mb-4">Our hospital architecture is designed with negative pressure isolation rooms, dual uninterruptible medical power generators, and medical gas pipeline systems conforming to international hospital engineering codes.</p>
          
          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
            <li class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2">
                <i class="bi bi-check-lg fs-5"></i>
              </div>
              <div><strong>HEPA-filtered Cleanrooms</strong> for zero airborne surgical site infections.</div>
            </li>
            <li class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2">
                <i class="bi bi-check-lg fs-5"></i>
              </div>
              <div><strong>3T Silent MRI &amp; 128-Slice Dual-Source CT</strong> for razor-sharp diagnoses.</div>
            </li>
            <li class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2">
                <i class="bi bi-check-lg fs-5"></i>
              </div>
              <div><strong>Dedicated Cardiac Cath Lab</strong> with 24-minute door-to-balloon time.</div>
            </li>
          </ul>
        </div>
        <div class="col-lg-6">
          <div class="p-2 border rounded-4 bg-light shadow-sm">
            <img src="assets/images/hms-building.jpg" alt="HMS Infrastructure" class="img-fluid rounded-4 w-100" style="max-height: 340px; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, #0369a1 100%);">
  <div class="container-xl text-center py-4">
    <h2 class="display-6 fw-bold mb-3">Experience World-Class Healthcare First-Hand</h2>
    <p class="lead text-white-50 max-w-700 mx-auto mb-4">Book your specialist appointment online or speak with our hospital admissions team.</p>
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="book.php" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow">Book an Appointment</a>
      <a href="contact.php" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-pill">Contact Admissions</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
