<?php
/**
 * Hospital Management System (HMS) - Payment Success & Appointment Receipt
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'Appointment Confirmed';

$appointmentNo = sanitize($_GET['appointment_no'] ?? '');

if (empty($appointmentNo)) {
    setFlash('error', 'No appointment specified.');
    redirect('index.php');
}

// Fetch appointment details
$stmt = $db->prepare("SELECT a.*, d.name AS doctor_name, d.specialty, d.fee, dept.name AS department_name 
                      FROM appointments a 
                      LEFT JOIN doctors d ON a.doctor_id = d.id 
                      LEFT JOIN departments dept ON a.department_id = dept.id 
                      WHERE a.appointment_no = ?");
$stmt->execute([$appointmentNo]);
$appointment = $stmt->fetch();

if (!$appointment) {
    setFlash('error', 'Appointment not found.');
    redirect('index.php');
}

// Fetch payment transaction if exists
$txnStmt = $db->prepare("SELECT * FROM payments WHERE appointment_id = ? ORDER BY id DESC LIMIT 1");
$txnStmt->execute([$appointment['id']]);
$payment = $txnStmt->fetch();

$txnNo = $payment['transaction_no'] ?? ($_GET['txn'] ?? 'TXN-COUNTER-' . rand(1000, 9999));
$paidAmount = $payment['amount'] ?? (($appointment['fee'] ?? 800) + 50);
$payMethod = $payment['payment_method'] ?? 'Online Payment';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printableSlip, #printableSlip * {
    visibility: visible;
  }
  #printableSlip {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    margin: 0;
    padding: 20px;
  }
  .no-print {
    display: none !important;
  }
}
</style>

<!-- CONFIRMATION HERO -->
<section class="py-5 text-center bg-light">
  <div class="container-xl py-2">
    <div class="mx-auto mb-3 rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
      <i class="bi bi-check-circle-fill display-4"></i>
    </div>
    <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">Slot Confirmed</span>
    <h1 class="display-6 fw-bold mb-2" style="color: var(--hms-navy-primary);">Your Appointment is Scheduled!</h1>
    <p class="text-muted max-w-700 mx-auto mb-4">A confirmation SMS and email have been dispatched to your registered contact. Please save or print the receipt below.</p>
    
    <div class="d-flex justify-content-center gap-3 no-print mb-4">
      <button onclick="window.print()" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
        <i class="bi bi-printer-fill me-2"></i> Print Appointment Slip
      </button>
      <a href="book.php" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-bold">
        Book Another
      </a>
      <a href="index.php" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-bold">
        Home
      </a>
    </div>

    <!-- PRINTABLE SLIP / APPOINTMENT PASS -->
    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 text-start bg-white mx-auto" id="printableSlip" style="max-width: 800px;">
      
      <!-- Hospital Header -->
      <div class="d-flex align-items-center justify-content-between border-bottom pb-4 mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="hms-brand-icon" style="width: 48px; height: 48px; font-size: 24px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
              <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
            </svg>
          </div>
          <div>
            <h4 class="fw-bold mb-0" style="color: var(--hms-navy-primary);">HMS Hospital &amp; Medical Centre</h4>
            <small class="text-muted">NABH &amp; JCI Accredited Multi-Speciality Hospital</small>
          </div>
        </div>
        <div class="text-end">
          <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace">TOKEN: #<?= substr($appointmentNo, -4) ?></span>
          <div class="small text-muted mt-1">Ref: <strong><?= htmlspecialchars($appointment['appointment_no']) ?></strong></div>
        </div>
      </div>

      <!-- Slip Details Grid -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6">
          <h6 class="text-uppercase text-muted small fw-bold mb-2">Patient Details</h6>
          <div class="fw-bold fs-5 text-dark"><?= htmlspecialchars($appointment['patient_name']) ?></div>
          <div class="text-muted small">Phone: <?= htmlspecialchars($appointment['patient_phone']) ?></div>
          <?php if (!empty($appointment['patient_email'])): ?>
            <div class="text-muted small">Email: <?= htmlspecialchars($appointment['patient_email']) ?></div>
          <?php endif; ?>
          <div class="text-muted small">Gender: <?= htmlspecialchars($appointment['patient_gender']) ?> &bull; Age: <?= (int)$appointment['patient_age'] ?> yrs</div>
        </div>

        <div class="col-sm-6">
          <h6 class="text-uppercase text-muted small fw-bold mb-2">Consultation Slot</h6>
          <div class="fw-bold fs-5 text-primary"><?= htmlspecialchars($appointment['doctor_name'] ?: 'General Physician') ?></div>
          <div class="text-muted small">Dept: <?= htmlspecialchars($appointment['department_name'] ?: ($appointment['specialty'] ?: 'General OPD')) ?></div>
          <div class="fw-semibold text-dark mt-1">
            <i class="bi bi-calendar-event text-primary me-1"></i> <?= date('l, d F Y', strtotime($appointment['appointment_date'])) ?>
          </div>
          <div class="fw-semibold text-dark">
            <i class="bi bi-clock text-primary me-1"></i> <?= htmlspecialchars($appointment['appointment_time']) ?> (Room: OPD-<?= rand(101, 305) ?>)
          </div>
        </div>
      </div>

      <!-- Payment & Transaction Banner -->
      <div class="p-3 bg-light rounded-3 border mb-4">
        <div class="row g-2 align-items-center">
          <div class="col-6 col-md-3">
            <small class="text-muted d-block">Transaction ID</small>
            <strong class="font-monospace small"><?= htmlspecialchars($txnNo) ?></strong>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-muted d-block">Payment Mode</small>
            <strong class="small"><?= htmlspecialchars($payMethod) ?></strong>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-muted d-block">Amount</small>
            <strong class="text-success small">₹<?= number_format($paidAmount, 2) ?> (Paid)</strong>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-muted d-block">Booking Status</small>
            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill">Confirmed</span>
          </div>
        </div>
      </div>

      <!-- Instructions for the patient -->
      <div class="border-top pt-3">
        <h6 class="fw-bold small text-dark mb-2"><i class="bi bi-info-circle text-primary me-1"></i> Patient Instructions for Consultation Day:</h6>
        <ul class="text-muted small mb-0 ps-3">
          <li>Please arrive 15 minutes before your scheduled appointment time to complete registration formalities.</li>
          <li>Carry this appointment slip (digital or printed) and a valid photo identification card.</li>
          <li>Bring all previous medical reports, prescriptions, and imaging films for the doctor's review.</li>
          <li>In case of emergency rescheduling, contact our helpline at <strong>+91 98765 43210</strong>.</li>
        </ul>
      </div>

      <!-- Barcode representation -->
      <div class="mt-4 pt-3 border-top text-center">
        <div class="font-monospace text-muted small letter-spacing-2">||| | |||| | ||||| || |||||| | ||| |||| | |||||||| | |||</div>
        <small class="text-muted">Digital HMS Verification Barcode &bull; Validated by Hospital Information System</small>
      </div>

    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
