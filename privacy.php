<?php
/**
 * Hospital Management System (HMS) - Privacy Policy
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Privacy Policy';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2 text-white-50 small">
        <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Privacy Policy</li>
      </ol>
    </nav>
    <h1 class="display-5 fw-bold mb-2">Hospital Privacy &amp; Data Protection Policy</h1>
    <p class="lead text-white-50 mb-0">Our solemn commitment to safeguarding patient medical records, diagnostic privacy, and personal health information.</p>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container-xl py-3">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mx-auto" style="max-width: 900px;">
      
      <div class="mb-4">
        <small class="text-muted fw-bold text-uppercase">Effective Date: January 1, 2026 &bull; Last Revised: September 2026</small>
      </div>

      <div class="content text-secondary leading-relaxed">
        <h4 class="fw-bold text-dark mb-3">1. Commitment to Clinical Confidentiality</h4>
        <p>At HMS Hospital &amp; Medical Centre, we hold doctor-patient confidentiality as the sacred cornerstone of ethical medical practice. All medical histories, diagnostic imaging reports, pathology test results, and consultation discussions are treated with the highest degree of security, strictly adhering to medical ethics and data protection standards.</p>

        <h4 class="fw-bold text-dark mt-4 mb-3">2. Information We Collect</h4>
        <p>When you book appointments, undergo lab tests, or seek emergency clinical admission at HMS Hospital, we collect necessary personal and health data:</p>
        <ul>
          <li><strong>Demographic Information:</strong> Full name, age, date of birth, biological sex, contact address, phone number, and emergency contact details.</li>
          <li><strong>Clinical Data:</strong> Past medical diagnoses, ongoing medications, drug allergies, surgical history, and lab test results.</li>
          <li><strong>Payment &amp; Insurance:</strong> TPA insurance policy numbers, billing references, and transaction identifiers.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4 mb-3">3. How Your Medical Information Is Used</h4>
        <p>Your health data is utilized strictly for direct therapeutic purposes:</p>
        <ul>
          <li>Enabling attending physicians, consultants, and surgeons to formulate accurate clinical diagnosis and treatment plans.</li>
          <li>Dispatching prescription alerts, appointment reminders, and digital laboratory test reports.</li>
          <li>Processing cashless insurance pre-authorizations and insurance reimbursement documentation.</li>
          <li>Statutory reporting required by public health authorities in the interest of disease epidemiology (as mandated by law).</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4 mb-3">4. Security of Electronic Health Records (EHR)</h4>
        <p>Our Hospital Information Management System is secured with end-to-end 256-bit encryption, role-based clinician access logs, and strict audit trails. Medical staff only have access to patient records on a need-to-know basis pertinent to active care delivery.</p>

        <h4 class="fw-bold text-dark mt-4 mb-3">5. Patient Rights &amp; Access</h4>
        <p>You have the absolute legal and ethical right to request copies of your diagnostic lab reports, clinical discharge summaries, and radiology scans at any time by contacting our Medical Records Department (MRD).</p>

        <h4 class="fw-bold text-dark mt-4 mb-3">6. Contact Our Data Protection Officer</h4>
        <p class="mb-0">If you have any questions regarding how your healthcare data is managed, please contact our Hospital Information Governance Office at <a href="mailto:privacy@hms.com" class="text-primary fw-semibold">privacy@hms.com</a> or write to:</p>
        <div class="p-3 bg-light rounded-3 mt-3">
          <strong>Hospital Grievance &amp; Privacy Officer</strong><br>
          HMS Hospital &amp; Medical Centre<br>
          12 Healthcare Boulevard, Medical Enclave, Central City - 560001
        </div>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
