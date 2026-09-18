<?php
/**
 * Hospital Management System (HMS) - Appointment Booking Page
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'Book Appointment';

// Handle Appointment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName   = sanitize($_POST['patient_name'] ?? '');
    $patientEmail  = sanitize($_POST['patient_email'] ?? '');
    $patientPhone  = sanitize($_POST['patient_phone'] ?? '');
    $patientGender = sanitize($_POST['patient_gender'] ?? 'Male');
    $patientAge    = (int)($_POST['patient_age'] ?? 0);
    $doctorId      = (int)($_POST['doctor_id'] ?? 0);
    $departmentId  = (int)($_POST['department_id'] ?? 0);
    $apptDate      = sanitize($_POST['appointment_date'] ?? '');
    $apptTime      = sanitize($_POST['appointment_time'] ?? '');
    $reason        = sanitize($_POST['reason'] ?? '');

    if (empty($patientName) || empty($patientPhone) || empty($apptDate) || empty($apptTime)) {
        setFlash('error', 'Please fill in all required fields (Name, Phone, Date, and Time slot).');
    } else {
        try {
            $appointmentNo = generateAppointmentNo();

            // If department is not set but doctor is, lookup department
            if (empty($departmentId) && !empty($doctorId)) {
                $docQuery = $db->prepare("SELECT department_id FROM doctors WHERE id = ?");
                $docQuery->execute([$doctorId]);
                $departmentId = $docQuery->fetchColumn() ?: null;
            }

            $stmt = $db->prepare("INSERT INTO appointments 
                (appointment_no, patient_name, patient_email, patient_phone, patient_gender, patient_age, doctor_id, department_id, appointment_date, appointment_time, reason, status, payment_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed', 'Paid')");
            
            $stmt->execute([
                $appointmentNo,
                $patientName,
                $patientEmail,
                $patientPhone,
                $patientGender,
                $patientAge,
                $doctorId ?: null,
                $departmentId ?: null,
                $apptDate,
                $apptTime,
                $reason
            ]);

            $apptId = $db->lastInsertId();
            redirect(SITE_URL . "/payment.php?appointment_no=" . urlencode($appointmentNo));
        } catch (Exception $e) {
            setFlash('error', 'Error scheduling appointment: ' . $e->getMessage());
        }
    }
}

// Pre-fill query parameters
$selectedDoctor = (int)($_GET['doctor'] ?? 0);
$selectedDept   = (int)($_GET['dept'] ?? 0);

// Fetch doctors and departments
$doctorsList = $db->query("SELECT id, name, specialty, fee FROM doctors WHERE status = 1 ORDER BY name ASC")->fetchAll();
$deptList = $db->query("SELECT id, name FROM departments WHERE status = 1 ORDER BY name ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

  <!-- INNER BANNER -->
  <div class="inner-page-banner text-center">
    <div class="container-xl">
      <div class="hms-eyebrow">PATIENT APPOINTMENT</div>
      <h1 class="hms-section-title mb-2">Book Your Clinical Appointment</h1>
      <p class="text-muted small mb-0">Select your preferred specialist and choose a convenient date and time slot.</p>
    </div>
  </div>

  <div class="container-xl py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <?php displayFlash(); ?>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="border: 1px solid #e2e8f0 !important;">
          <form method="POST" action="book.php">
            
            <!-- STEP 1: DOCTOR & SPECIALTY -->
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-primary rounded-circle" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">1</span>
              Specialist &amp; Department
            </h5>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Select Specialist / Doctor</label>
                <select name="doctor_id" class="form-select rounded-3 py-2" id="doctorSelect">
                  <option value="">-- Choose Doctor (Optional) --</option>
                  <?php foreach ($doctorsList as $doc): ?>
                    <option value="<?= $doc['id'] ?>" <?= ($selectedDoctor === (int)$doc['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($doc['name']) ?> (<?= htmlspecialchars($doc['specialty']) ?> - <?= formatINR($doc['fee']) ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Hospital Department</label>
                <select name="department_id" class="form-select rounded-3 py-2">
                  <option value="">-- Choose Department --</option>
                  <?php foreach ($deptList as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= ($selectedDept === (int)$dept['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($dept['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- STEP 2: DATE & TIME -->
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-primary rounded-circle" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">2</span>
              Preferred Date &amp; Slot
            </h5>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Appointment Date <span class="text-danger">*</span></label>
                <input type="date" name="appointment_date" class="form-control rounded-3 py-2" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Available Time Slot <span class="text-danger">*</span></label>
                <select name="appointment_time" class="form-select rounded-3 py-2" required>
                  <option value="09:00 AM">09:00 AM - 09:30 AM</option>
                  <option value="10:00 AM">10:00 AM - 10:30 AM</option>
                  <option value="11:30 AM">11:30 AM - 12:00 PM</option>
                  <option value="02:00 PM">02:00 PM - 02:30 PM</option>
                  <option value="03:30 PM">03:30 PM - 04:00 PM</option>
                  <option value="04:30 PM">04:30 PM - 05:00 PM</option>
                </select>
              </div>
            </div>

            <!-- STEP 3: PATIENT DETAILS -->
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
              <span class="badge bg-primary rounded-circle" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">3</span>
              Patient Information
            </h5>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="patient_name" class="form-control rounded-3 py-2" placeholder="e.g. Ramesh Kumar" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" name="patient_phone" class="form-control rounded-3 py-2" placeholder="+91 98765 43210" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Email Address</label>
                <input type="email" name="patient_email" class="form-control rounded-3 py-2" placeholder="patient@example.com">
              </div>

              <div class="col-md-3">
                <label class="form-label small fw-semibold">Gender</label>
                <select name="patient_gender" class="form-select rounded-3 py-2">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label small fw-semibold">Age</label>
                <input type="number" name="patient_age" class="form-control rounded-3 py-2" min="1" max="120" placeholder="32">
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Reason for Visit / Symptoms</label>
                <textarea name="reason" rows="3" class="form-control rounded-3" placeholder="Briefly describe your symptoms or past medical history..."></textarea>
              </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn hms-btn-primary-pill py-3 fw-bold fs-6">
                Confirm &amp; Proceed to Consultation Slip <i class="bi bi-arrow-right ms-2"></i>
              </button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
