<?php
/**
 * Hospital Management System (HMS) - Cancellation & Refund Policy
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Cancellation & Refund Policy';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<section class="py-5" style="background: linear-gradient(135deg, var(--hms-navy-primary) 0%, var(--hms-navy-dark) 100%); color: #ffffff;">
  <div class="container-xl py-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2 text-white-50 small">
        <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Refund Policy</li>
      </ol>
    </nav>
    <h1 class="display-5 fw-bold mb-2">Appointment Cancellation &amp; Refund Policy</h1>
    <p class="lead text-white-50 mb-0">Transparent terms regarding consultation rescheduling, package cancellations, and electronic fee refunds.</p>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container-xl py-3">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mx-auto" style="max-width: 900px;">
      
      <div class="mb-4">
        <small class="text-muted fw-bold text-uppercase">Hospital Billing Terms &bull; Effective September 2026</small>
      </div>

      <div class="content text-secondary leading-relaxed">
        <h4 class="fw-bold text-dark mb-3">1. Doctor Consultation Fee Cancellation</h4>
        <p>We understand that unforeseen health emergencies or personal obligations may require you to cancel or reschedule your medical appointment. Our refund parameters are straightforward:</p>
        <ul>
          <li><strong>Cancellation > 4 Hours in Advance:</strong> 100% full refund of the doctor consultation fee with zero cancellation deduction.</li>
          <li><strong>Cancellation < 4 Hours in Advance:</strong> Full fee will be credited as a Hospital Medical Credit voucher or free rescheduling to another date with the same specialist.</li>
          <li><strong>Doctor Emergency Unavailability:</strong> If a scheduled doctor is called for emergency surgery or is indisposed, you are entitled to either an immediate 100% refund or consultation with an alternative senior specialist without additional fee.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4 mb-3">2. Health Packages &amp; Diagnostic Tests</h4>
        <p>For prepaid comprehensive health packages, MRI/CT scans, and pathology blood tests:</p>
        <ul>
          <li>Cancellations made prior to sample collection or scan preparation are entitled to a 100% refund.</li>
          <li>Once blood/fluid samples have been drawn and processed in the automated diagnostic analyzers, refunds cannot be processed.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4 mb-3">3. Refund Processing Timeline</h4>
        <p>Approved refunds are processed through our payment gateway directly to the originating payment instrument:</p>
        <ul>
          <li><strong>UPI / Google Pay / PhonePe:</strong> Credited within 24 to 48 banking hours.</li>
          <li><strong>Credit / Debit Cards:</strong> Credited within 3 to 5 business days, subject to your card-issuing bank.</li>
          <li><strong>Cash / Counter Payments:</strong> Immediate cash refund at the Central Billing Counter on Floor 1 upon presentation of the physical receipt and valid ID proof.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4 mb-3">4. How to Initiate a Refund</h4>
        <p>To request a refund or appointment reschedule, you can:</p>
        <ol>
          <li>Call our 24/7 Billing &amp; Helpdesk helpline at <strong>+91 98765 43210</strong> with your Appointment Ref Number.</li>
          <li>Send an email to <a href="mailto:billing@hms.com" class="text-primary fw-semibold">billing@hms.com</a> with your Booking Reference and Transaction ID.</li>
          <li>Visit the Hospital Frontdesk Reception in person.</li>
        </ol>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
