<?php
/**
 * Hospital Management System (HMS) - Consultation Fee Payment & Checkout
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'Secure Payment & Consultation Confirmation';

$appointmentNo = sanitize($_GET['appointment_no'] ?? $_POST['appointment_no'] ?? '');

if (empty($appointmentNo)) {
    setFlash('error', 'No appointment reference specified. Please book an appointment first.');
    redirect('book.php');
}

// Fetch appointment details
$stmt = $db->prepare("SELECT a.*, d.name AS doctor_name, d.fee AS doctor_fee, d.specialty, dept.name AS department_name 
                      FROM appointments a 
                      LEFT JOIN doctors d ON a.doctor_id = d.id 
                      LEFT JOIN departments dept ON a.department_id = dept.id 
                      WHERE a.appointment_no = ?");
$stmt->execute([$appointmentNo]);
$appointment = $stmt->fetch();

if (!$appointment) {
    setFlash('error', 'Appointment not found. Please verify your reference number.');
    redirect('book.php');
}

// If already paid, redirect to success page
if ($appointment['payment_status'] === 'Paid') {
    redirect("payment-success.php?appointment_no=" . urlencode($appointmentNo));
}

// Fee calculations
$baseFee = !empty($appointment['doctor_fee']) ? floatval($appointment['doctor_fee']) : 800.00;
$regFee  = 50.00; // Registration / Hospital Token Fee
$totalAmount = $baseFee + $regFee;

// Handle Payment Processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_payment'])) {
    $paymentMethod = sanitize($_POST['payment_method'] ?? 'Credit / Debit Card');
    $txnNo = 'TXN-' . strtoupper(bin2hex(random_bytes(4))) . '-' . rand(1000, 9999);

    try {
        // 1. Insert into payments table
        $payStmt = $db->prepare("INSERT INTO payments (appointment_id, transaction_no, amount, payment_method, status) VALUES (?, ?, ?, ?, 'Success')");
        $payStmt->execute([$appointment['id'], $txnNo, $totalAmount, $paymentMethod]);

        // 2. Update appointment payment status
        $upStmt = $db->prepare("UPDATE appointments SET payment_status = 'Paid', status = 'Confirmed' WHERE id = ?");
        $upStmt->execute([$appointment['id']]);

        // Redirect to success confirmation
        redirect("payment-success.php?appointment_no=" . urlencode($appointmentNo) . "&txn=" . urlencode($txnNo));
    } catch (Exception $e) {
        setFlash('error', 'Payment processing failed: ' . $e->getMessage());
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- PAYMENT HERO -->
<section class="py-4" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-1 text-white-50 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="book.php" class="text-white text-decoration-none">Appointment</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Checkout</li>
          </ol>
        </nav>
        <h2 class="h3 fw-bold mb-0">Complete Your Appointment Confirmation</h2>
      </div>
      <div class="text-end">
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
          <i class="bi bi-shield-lock-fill me-1"></i> 256-Bit SSL Encrypted
        </span>
      </div>
    </div>
  </div>
</section>

<!-- PAYMENT MAIN SECTION -->
<section class="py-5 bg-light">
  <div class="container-xl py-2">
    
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
      
      <!-- Left: Appointment Details & Cost Summary -->
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
          <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
            <span class="text-muted small fw-bold text-uppercase">Booking Ref</span>
            <span class="badge bg-primary text-white px-3 py-2 rounded-pill font-monospace fw-bold"><?= htmlspecialchars($appointment['appointment_no']) ?></span>
          </div>

          <h5 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Patient &amp; Doctor Details</h5>

          <div class="mb-3">
            <small class="text-muted d-block">Patient Name</small>
            <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($appointment['patient_name']) ?> (<?= htmlspecialchars($appointment['patient_gender']) ?>, <?= (int)$appointment['patient_age'] ?> yrs)</div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block">Consulting Specialist</small>
            <div class="fw-bold text-primary fs-6"><?= htmlspecialchars($appointment['doctor_name'] ?: 'General Physician') ?></div>
            <small class="text-muted"><?= htmlspecialchars($appointment['specialty'] ?: ($appointment['department_name'] ?: 'General Medicine')) ?></small>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <small class="text-muted d-block">Date</small>
              <div class="fw-semibold text-dark"><i class="bi bi-calendar3 me-1 text-primary"></i> <?= date('M d, Y', strtotime($appointment['appointment_date'])) ?></div>
            </div>
            <div class="col-6">
              <small class="text-muted d-block">Time Slot</small>
              <div class="fw-semibold text-dark"><i class="bi bi-clock me-1 text-primary"></i> <?= htmlspecialchars($appointment['appointment_time']) ?></div>
            </div>
          </div>

          <hr>

          <!-- Price Breakdown -->
          <h6 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Fee Summary</h6>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Doctor Consultation Fee</span>
            <span class="fw-semibold">₹<?= number_format($baseFee, 2) ?></span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Digital Registration &amp; Token</span>
            <span class="fw-semibold">₹<?= number_format($regFee, 2) ?></span>
          </div>
          <div class="d-flex justify-content-between border-top pt-3 mt-2">
            <span class="h5 fw-bold mb-0" style="color: var(--hms-navy-primary);">Total Payable</span>
            <span class="h5 fw-bold text-primary mb-0">₹<?= number_format($totalAmount, 2) ?></span>
          </div>
        </div>

        <div class="alert alert-info border-0 rounded-4 shadow-sm p-3 small d-flex align-items-start gap-2">
          <i class="bi bi-info-circle-fill fs-5 text-primary flex-shrink-0"></i>
          <div>
            <strong>Instant Token Generation:</strong> Upon confirmation, you will receive an official digital appointment slip with barcoded token number to show at the reception.
          </div>
        </div>
      </div>

      <!-- Right: Payment Methods -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
          <h4 class="fw-bold mb-3" style="color: var(--hms-navy-primary);">Select Payment Option</h4>
          <p class="text-muted small mb-4">Choose your preferred payment method to confirm this slot instantly.</p>

          <form action="payment.php" method="POST" id="checkoutForm">
            <input type="hidden" name="appointment_no" value="<?= htmlspecialchars($appointmentNo) ?>">
            <input type="hidden" name="process_payment" value="1">

            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-fill mb-4 gap-2" id="paymentTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-bold border" id="card-tab" data-bs-toggle="pill" data-bs-target="#card-pane" type="button" role="tab">
                  <i class="bi bi-credit-card me-1"></i> Card
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-bold border" id="upi-tab" data-bs-toggle="pill" data-bs-target="#upi-pane" type="button" role="tab">
                  <i class="bi bi-qr-code-scan me-1"></i> UPI / QR
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-bold border" id="counter-tab" data-bs-toggle="pill" data-bs-target="#counter-pane" type="button" role="tab">
                  <i class="bi bi-cash-stack me-1"></i> Pay at Desk
                </button>
              </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="paymentTabsContent">
              
              <!-- Card Tab -->
              <div class="tab-pane fade show active" id="card-pane" role="tabpanel">
                <input type="hidden" name="payment_method" value="Credit / Debit Card" id="paymentMethodInput">
                
                <div class="mb-3">
                  <label class="form-label fw-semibold small">Cardholder Name</label>
                  <input type="text" class="form-control bg-light py-2" placeholder="<?= htmlspecialchars($appointment['patient_name']) ?>" value="<?= htmlspecialchars($appointment['patient_name']) ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold small">Card Number</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-credit-card-2-front"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 py-2" placeholder="4111 2222 3333 4444" maxlength="19" value="4111 2222 3333 4444">
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-6">
                    <label class="form-label fw-semibold small">Expiry (MM/YY)</label>
                    <input type="text" class="form-control bg-light py-2" placeholder="12/28" value="12/28">
                  </div>
                  <div class="col-6">
                    <label class="form-label fw-semibold small">CVV</label>
                    <input type="password" class="form-control bg-light py-2" placeholder="•••" maxlength="4" value="123">
                  </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-pill shadow">
                  <i class="bi bi-lock-fill me-2"></i> Pay ₹<?= number_format($totalAmount, 2) ?> &amp; Confirm
                </button>
              </div>

              <!-- UPI Tab -->
              <div class="tab-pane fade text-center" id="upi-pane" role="tabpanel">
                <div class="p-4 bg-light rounded-4 mb-3 d-inline-block">
                  <div class="bg-white p-3 rounded-3 shadow-sm border d-inline-block">
                    <!-- SVG QR Code -->
                    <svg width="150" height="150" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="100" height="100" fill="white"/>
                      <path d="M10 10h30v30H10V10zm5 5v20h20V15H15zm45-5h30v30H60V10zm5 5v20h20V15H65zM10 60h30v30H10V60zm5 5v20h20V65H15zm45 10h10v10H60V75zm15-15h10v10H75V60zm10 15h10v15H85V75zm-10 15h10v10H75V90zm-15-5h10v15H60V85zm-15-50h10v10H45V35zm0 15h10v10H45V50zm15-15h10v10H60V35zm-25 0h10v10H35V35zm0 15h10v10H35V50zm15 15h10v10H50V65z" fill="#0a355c"/>
                    </svg>
                  </div>
                  <div class="mt-3">
                    <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">UPI ID: hms.billing@upi</span>
                  </div>
                  <p class="text-muted small mt-2 mb-0">Scan with Google Pay, PhonePe, or Paytm.</p>
                </div>

                <div class="mb-3 text-start">
                  <label class="form-label fw-semibold small">Or Enter Your VPA / UPI ID</label>
                  <input type="text" class="form-control bg-light py-2" placeholder="username@okhdfcbank" value="patient@okhdfcbank">
                </div>

                <button type="submit" onclick="document.getElementById('paymentMethodInput').value = 'UPI / QR Code';" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-pill shadow">
                  <i class="bi bi-shield-check me-2"></i> Verify UPI &amp; Pay ₹<?= number_format($totalAmount, 2) ?>
                </button>
              </div>

              <!-- Counter Tab -->
              <div class="tab-pane fade" id="counter-pane" role="tabpanel">
                <div class="p-4 bg-light rounded-4 mb-4">
                  <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-20 text-warning p-3">
                      <i class="bi bi-building fs-3"></i>
                    </div>
                    <div>
                      <h5 class="fw-bold mb-1">Pay at Reception Counter</h5>
                      <p class="text-muted small mb-0">You can pay ₹<?= number_format($totalAmount, 2) ?> in Cash, Card, or UPI directly at the hospital reception counter on the day of consultation.</p>
                    </div>
                  </div>
                </div>

                <button type="submit" onclick="document.getElementById('paymentMethodInput').value = 'Pay at Reception Counter';" class="btn btn-outline-primary btn-lg w-100 py-3 fw-bold rounded-pill">
                  <i class="bi bi-check-circle-fill me-2"></i> Confirm Slot &amp; Pay at Hospital
                </button>
              </div>

            </div>
          </form>

          <div class="d-flex align-items-center justify-content-center gap-3 text-muted small mt-4 pt-3 border-top">
            <span><i class="bi bi-lock-fill text-success"></i> PCI-DSS Compliant</span>
            <span>&bull;</span>
            <span><i class="bi bi-shield-check text-primary"></i> 100% Refund Guarantee</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
