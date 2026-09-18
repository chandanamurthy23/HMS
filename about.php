<?php
/**
 * Hospital Management System (HMS) - About Us Page
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'About Us';

// Fetch doctor count and department count for dynamic stats
$stats = [
    'doctors' => 150,
    'departments' => 12,
    'patients' => '50,000+',
    'experience' => '25+'
];

try {
    $docCount = $db->query("SELECT COUNT(*) FROM doctors WHERE status = 1")->fetchColumn();
    if ($docCount > 0) $stats['doctors'] = $docCount . '+ Active';
    $deptCount = $db->query("SELECT COUNT(*) FROM departments WHERE status = 1")->fetchColumn();
    if ($deptCount > 0) $stats['departments'] = $deptCount;
} catch (Exception $e) {
    // Graceful fallback
}

// Fetch featured doctors
$doctors = [];
try {
    $stmt = $db->query("SELECT d.*, dept.name AS department_name 
                        FROM doctors d 
                        LEFT JOIN departments dept ON d.department_id = dept.id 
                        WHERE d.status = 1 
                        ORDER BY d.rating DESC LIMIT 4");
    $doctors = $stmt->fetchAll();
} catch (Exception $e) {
    $doctors = [];
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- ABOUT HERO BANNER -->
<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-2 text-white-50 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">About Us</li>
          </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-3">Pioneering World-Class Healthcare Since 1999</h1>
        <p class="lead text-white-50 mb-0">At HMS Hospital &amp; Medical Centre, our mission is to combine pioneering clinical excellence, advanced medical technology, and deep compassionate care to deliver exceptional health outcomes for every patient.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <a href="book.php" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow">
          <i class="bi bi-calendar-check me-2"></i> Book Appointment
        </a>
      </div>
    </div>
  </div>
</section>

<!-- HIGHLIGHT STATS BAR -->
<section class="bg-white border-bottom shadow-sm">
  <div class="container-xl py-4">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-4 bg-light">
          <div class="h2 fw-bold text-primary mb-1"><?= htmlspecialchars($stats['experience']) ?></div>
          <div class="text-muted small fw-semibold text-uppercase tracking-wider">Years of Dedication</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-4 bg-light">
          <div class="h2 fw-bold text-success mb-1"><?= htmlspecialchars($stats['patients']) ?></div>
          <div class="text-muted small fw-semibold text-uppercase tracking-wider">Happy Patients</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-4 bg-light">
          <div class="h2 fw-bold text-info mb-1"><?= htmlspecialchars($stats['doctors']) ?></div>
          <div class="text-muted small fw-semibold text-uppercase tracking-wider">Specialist Doctors</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-4 bg-light">
          <div class="h2 fw-bold text-warning mb-1">24/7</div>
          <div class="text-muted small fw-semibold text-uppercase tracking-wider">Emergency &amp; Trauma</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAIN HOSPITAL STORY & OVERVIEW -->
<section class="py-5 bg-light">
  <div class="container-xl py-3">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6">
        <div class="position-relative">
          <img src="assets/images/hms-building.jpg" alt="HMS Hospital Building" class="img-fluid rounded-4 shadow-lg w-100" style="min-height: 380px; object-fit: cover;">
          <div class="position-absolute bottom-0 end-0 bg-white p-3 p-md-4 rounded-4 shadow-lg m-3 border-start border-4 border-primary">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                <i class="bi bi-shield-check fs-2"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-0">NABH &amp; JCI Standards</h5>
                <small class="text-muted">International Grade Healthcare</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-2">Who We Are</span>
        <h2 class="display-6 fw-bold mb-4" style="color: var(--hms-navy-primary);">Compassionate Care Powered by Modern Medical Science</h2>
        <p class="text-secondary leading-relaxed">
          Founded in 1999, HMS Hospital &amp; Medical Centre has established itself as one of the country's most respected multi-specialty healthcare networks. We bring together distinguished clinicians, advanced robotic and laser surgical technologies, and empathetic nursing staff to create an ecosystem of complete healing.
        </p>
        <p class="text-secondary leading-relaxed">
          From complex cardiothoracic surgeries and minimally invasive joint replacements to pediatric intensive care and holistic chronic disease management, our integrated clinical teams collaborate round the clock to ensure high success rates and compassionate patient experiences.
        </p>

        <div class="row g-3 mt-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <div>
                <strong class="d-block text-dark">Patient-First Ethics</strong>
                <small class="text-muted">Zero compromise on medical transparency.</small>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <div>
                <strong class="d-block text-dark">Ultramodern Modular OTs</strong>
                <small class="text-muted">Cleanroom HEPA class 100 laminar airflow.</small>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <div>
                <strong class="d-block text-dark">Fast-Track Emergency</strong>
                <small class="text-muted">Average triage response under 4 minutes.</small>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-start gap-2">
              <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <div>
                <strong class="d-block text-dark">Digital Health Records</strong>
                <small class="text-muted">Instant online access to test reports &amp; history.</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MISSION, VISION, VALUES -->
<section class="py-5 bg-white">
  <div class="container-xl py-3">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="badge bg-info-subtle text-info-emphasis fw-bold px-3 py-2 rounded-pill mb-2">Our Foundation</span>
      <h2 class="fw-bold display-6" style="color: var(--hms-navy-primary);">Our Purpose &amp; Guiding Principles</h2>
      <p class="text-muted">Every procedure, consultation, and technological upgrade is driven by our core commitment to human life.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-lift transition">
          <div class="mx-auto mb-4 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
            <i class="bi bi-bullseye text-primary fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Our Mission</h4>
          <p class="text-muted mb-0">To deliver compassionate, comprehensive, and patient-centered healthcare of the highest caliber, accessible and affordable to people from all walks of life.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-lift transition">
          <div class="mx-auto mb-4 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
            <i class="bi bi-eye-fill text-success fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Our Vision</h4>
          <p class="text-muted mb-0">To be the most trusted healthcare institution globally, recognized for breakthrough clinical research, ethical medicine, and relentless focus on patient safety.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-lift transition">
          <div class="mx-auto mb-4 rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
            <i class="bi bi-heart-pulse-fill text-warning fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Our Values</h4>
          <p class="text-muted mb-0">Empathy in action, integrity in decision-making, clinical excellence in outcomes, and teamwork across every department to save and enhance lives.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DOCTORS LEADERSHIP -->
<?php if (!empty($doctors)): ?>
<section class="py-5 bg-light">
  <div class="container-xl py-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
      <div>
        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-2">Clinical Leadership</span>
        <h2 class="fw-bold display-6 mb-0" style="color: var(--hms-navy-primary);">Meet Our Renowned Specialists</h2>
      </div>
      <a href="book.php" class="btn btn-outline-primary fw-bold rounded-pill mt-3 mt-md-0">Book a Consultation &rarr;</a>
    </div>

    <div class="row g-4">
      <?php foreach ($doctors as $doc): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
          <img src="<?= htmlspecialchars($doc['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($doc['name']) ?>" style="height: 240px; object-fit: cover;">
          <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-1" style="color: var(--hms-navy-primary);"><?= htmlspecialchars($doc['name']) ?></h5>
            <p class="text-primary small fw-semibold mb-2"><?= htmlspecialchars($doc['specialty']) ?></p>
            <p class="text-muted small mb-3"><?= htmlspecialchars($doc['qualification']) ?> &bull; <?= htmlspecialchars($doc['experience']) ?></p>
            <a href="book.php?doctor=<?= $doc['id'] ?>" class="btn btn-sm btn-primary w-100 rounded-pill py-2">Consult Doctor</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ACCREDITATIONS & CERTIFICATIONS -->
<section class="py-5 bg-white border-top">
  <div class="container-xl py-3 text-center">
    <h3 class="fw-bold mb-4" style="color: var(--hms-navy-primary);">Recognized by National &amp; Global Healthcare Bodies</h3>
    <div class="row g-4 justify-content-center align-items-center">
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 bg-light">
          <i class="bi bi-award fs-1 text-primary mb-2 d-block"></i>
          <span class="fw-bold d-block">NABH Accredited</span>
          <small class="text-muted">National Accreditation Board</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 bg-light">
          <i class="bi bi-patch-check fs-1 text-success mb-2 d-block"></i>
          <span class="fw-bold d-block">NABL Certified</span>
          <small class="text-muted">Diagnostic Laboratories</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 bg-light">
          <i class="bi bi-shield-lock fs-1 text-warning mb-2 d-block"></i>
          <span class="fw-bold d-block">ISO 9001:2015</span>
          <small class="text-muted">Quality Management</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 border rounded-3 bg-light">
          <i class="bi bi-globe-americas fs-1 text-info mb-2 d-block"></i>
          <span class="fw-bold d-block">JCI Guidelines</span>
          <small class="text-muted">International Patient Safety</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, #0369a1 100%);">
  <div class="container-xl text-center py-4">
    <h2 class="display-6 fw-bold mb-3">Ready to Consult with Our Eminent Doctors?</h2>
    <p class="lead text-white-50 max-w-700 mx-auto mb-4">Book in-person appointments, explore full-body preventive health checkups, or contact our 24/7 helpdesk.</p>
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="book.php" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow">Book an Appointment</a>
      <a href="contact.php" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-pill">Contact Helpdesk</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
