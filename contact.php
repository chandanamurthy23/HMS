<?php
/**
 * Hospital Management System (HMS) - Contact Us Page
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$db = getDB();
$pageTitle = 'Contact Us';

// Handle Contact Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $phone   = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? 'General Inquiry');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        setFlash('error', 'Please fill in all required fields (Name, Email, and Message).');
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, status) VALUES (?, ?, ?, ?, ?, 'unread')");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            setFlash('success', 'Thank you, ' . htmlspecialchars($name) . '! Your message has been received. Our clinical support team will respond within 24 hours.');
            redirect('contact.php');
        } catch (Exception $e) {
            setFlash('error', 'An error occurred while sending your message. Please call our hotline directly: ' . $e->getMessage());
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- CONTACT HERO -->
<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-2 text-white-50 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Contact Us</li>
          </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-3">Get in Touch with Our Medical Team</h1>
        <p class="lead text-white-50 mb-0">Have an inquiry about medical services, specialist appointments, or insurance cashless claims? We are here round the clock to support you.</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
        <div class="bg-danger text-white p-3 rounded-4 shadow text-center d-inline-block">
          <div class="small fw-bold text-uppercase tracking-wider">24/7 Emergency &amp; Ambulance</div>
          <a href="tel:108" class="h3 fw-bold text-white text-decoration-none d-block my-1"><i class="bi bi-telephone-fill me-2"></i> 108 / +91 98765 43210</a>
          <small class="text-white-50">Immediate Dispatch Available</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAIN CONTACT CONTENT -->
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

    <div class="row g-5">
      <!-- Contact Info Cards -->
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
          <h4 class="fw-bold mb-4" style="color: var(--hms-navy-primary);">Hospital Information</h4>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 flex-shrink-0">
              <i class="bi bi-geo-alt-fill fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Campus Address</h6>
              <p class="text-muted small mb-0">HMS Hospital Complex, 12 Healthcare Boulevard, Medical Enclave, Central City - 560001</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 flex-shrink-0">
              <i class="bi bi-telephone-fill fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Helpline &amp; Appointments</h6>
              <p class="text-muted small mb-1"><a href="tel:+919876543210" class="text-decoration-none text-dark fw-semibold">+91 98765 43210</a></p>
              <p class="text-muted small mb-0"><a href="tel:+919876543211" class="text-decoration-none text-dark fw-semibold">+91 98765 43211</a> (OPD Desk)</p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3 mb-4">
            <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 flex-shrink-0">
              <i class="bi bi-envelope-fill fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Email Contacts</h6>
              <p class="text-muted small mb-1"><a href="mailto:support@hms.com" class="text-decoration-none text-dark">support@hms.com</a></p>
              <p class="text-muted small mb-0"><a href="mailto:appointments@hms.com" class="text-decoration-none text-dark">appointments@hms.com</a></p>
            </div>
          </div>

          <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 flex-shrink-0">
              <i class="bi bi-clock-fill fs-4"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-1">Operating Hours</h6>
              <p class="text-muted small mb-1"><strong>Emergency &amp; Trauma:</strong> 24 Hours / 7 Days</p>
              <p class="text-muted small mb-0"><strong>OPD Consultations:</strong> Mon - Sat: 8:00 AM - 8:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Cashless Claim Banner -->
        <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
          <div class="d-flex align-items-center gap-3">
            <i class="bi bi-shield-check display-5"></i>
            <div>
              <h5 class="fw-bold mb-1">Cashless Mediclaim Desk</h5>
              <p class="small text-white-50 mb-0">We support all major TPA &amp; private insurance partners. Visit Floor 1 TPA counter for instant pre-authorization.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Inquiry Form -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
          <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill align-self-start mb-2">Send an Inquiry</span>
          <h3 class="fw-bold mb-2" style="color: var(--hms-navy-primary);">How Can We Help You Today?</h3>
          <p class="text-muted small mb-4">Please fill out this form. For medical emergencies or urgent bed requirements, please call <strong>+91 98765 43210</strong> immediately.</p>

          <form action="contact.php" method="POST" class="needs-validation">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                  <input type="text" class="form-control bg-light border-start-0 py-2" id="name" name="name" placeholder="John Doe" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                  <input type="email" class="form-control bg-light border-start-0 py-2" id="email" name="email" placeholder="john@example.com" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="bi bi-phone text-muted"></i></span>
                  <input type="tel" class="form-control bg-light border-start-0 py-2" id="phone" name="phone" placeholder="+91 98765 43210">
                </div>
              </div>

              <div class="col-md-6">
                <label for="subject" class="form-label fw-semibold small">Subject / Purpose</label>
                <select class="form-select bg-light py-2" id="subject" name="subject">
                  <option value="General Inquiry">General Inquiry</option>
                  <option value="Doctor Consultation">Doctor Consultation</option>
                  <option value="Health Package / Checkup">Health Package / Checkup</option>
                  <option value="Insurance / Cashless Claim">Insurance / Cashless Claim</option>
                  <option value="Feedback / Compliment">Feedback / Compliment</option>
                </select>
              </div>

              <div class="col-12">
                <label for="message" class="form-label fw-semibold small">Your Message <span class="text-danger">*</span></label>
                <textarea class="form-control bg-light py-2" id="message" name="message" rows="5" placeholder="Please describe how we can assist you..." required></textarea>
              </div>

              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                  <i class="bi bi-send-fill me-2"></i> Send Message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- FAQ ACCORDION -->
    <div class="mt-5 pt-3">
      <div class="text-center max-w-700 mx-auto mb-4">
        <h4 class="fw-bold" style="color: var(--hms-navy-primary);">Frequently Asked Questions</h4>
        <p class="text-muted small">Quick answers to common questions about hospital visits and policies.</p>
      </div>

      <div class="accordion accordion-flush bg-white rounded-4 shadow-sm p-3" id="faqAccordion">
        <div class="accordion-item border-bottom">
          <h2 class="accordion-header" id="faqHeadingOne">
            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="false" aria-controls="faqCollapseOne">
              What are the patient visiting hours?
            </button>
          </h2>
          <div id="faqCollapseOne" class="accordion-collapse collapse" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-muted small">
              General wards: 04:00 PM – 07:00 PM daily. ICU / CCU: 05:00 PM – 06:00 PM (strictly one attendant at a time for infection control).
            </div>
          </div>
        </div>

        <div class="accordion-item border-bottom">
          <h2 class="accordion-header" id="faqHeadingTwo">
            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
              How do I get my diagnostic and lab test reports online?
            </button>
          </h2>
          <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-muted small">
              Reports are uploaded directly to our system within 2 to 6 hours of sample collection. You will receive an SMS and email notification with your download link, or you can contact our diagnostic desk with your appointment number.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingThree">
            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
              Do I need prior appointments for health checkup packages?
            </button>
          </h2>
          <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-muted small">
              Yes, advance booking is recommended to avoid fasting wait times. Most comprehensive checkups require 10–12 hours of overnight fasting. You can book directly through our <a href="book.php">online booking portal</a>.
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
