<?php
/**
 * Hospital Management System (HMS) - Site Navigation Bar Component
 */
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- MAIN HEADER / NAVIGATION BAR -->
<header class="hms-site-header sticky-top" id="mainHeader">
  <div class="container-xl d-flex align-items-center justify-content-between py-3">
    
    <!-- Brand Logo -->
    <a href="index.php" class="d-flex align-items-center gap-2 text-decoration-none">
      <div class="hms-brand-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
          <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
        </svg>
      </div>
      <div>
        <div class="hms-brand-name">HMS</div>
        <div class="hms-brand-sub d-none d-sm-block">Hospital &amp; Medical Centre</div>
      </div>
    </a>

    <!-- Desktop Navigation Menu -->
    <nav class="d-none d-lg-flex align-items-center gap-4">
      <a href="index.php" class="hms-nav-link <?= ($currentPage === 'index.php') ? 'active' : '' ?>">Home</a>
      
      <div class="dropdown">
        <a href="javascript:void(0)" class="hms-nav-link dropdown-toggle <?= in_array($currentPage, ['departments.php']) ? 'active' : '' ?>" data-bs-toggle="dropdown" aria-expanded="false">
          Departments
        </a>
        <ul class="dropdown-menu border-0 shadow-lg rounded-3 py-2">
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-heart-pulse-fill text-danger me-2"></i> Cardiology</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-cpu-fill text-primary me-2"></i> Neurology</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-bandaid-fill text-success me-2"></i> Orthopedics</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-emoji-smile-fill text-info me-2"></i> Pediatrics</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-gender-female text-danger me-2"></i> Gynecology</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-shield-plus text-warning me-2"></i> Dermatology</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-capsule text-info me-2"></i> Gastroenterology</a></li>
          <li><a class="dropdown-item py-2" href="index.php#departments"><i class="bi bi-heart-fill text-primary me-2"></i> General Medicine</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item py-2 text-primary fw-semibold" href="gallery.php">View Facilities &amp; Equipment &rarr;</a></li>
        </ul>
      </div>

      <a href="index.php#doctors" class="hms-nav-link">Doctors</a>
      <a href="index.php#packages" class="hms-nav-link">Health Packages</a>
      <a href="gallery.php" class="hms-nav-link <?= ($currentPage === 'gallery.php') ? 'active' : '' ?>">Facilities</a>
      <a href="about.php" class="hms-nav-link <?= ($currentPage === 'about.php') ? 'active' : '' ?>">About Us</a>
      <a href="reviews.php" class="hms-nav-link <?= ($currentPage === 'reviews.php') ? 'active' : '' ?>">Reviews</a>
      <a href="contact.php" class="hms-nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>">Contact</a>
    </nav>

    <!-- Search & Auth Actions -->
    <div class="d-flex align-items-center gap-2 gap-sm-3">
      <!-- Quick Search Modal Trigger -->
      <button type="button" class="btn btn-link hms-search-trigger" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search doctors & treatments">
        <i class="bi bi-search fs-5"></i>
      </button>

      <?php if (isAdmin()): ?>
        <a href="admin/index.php" class="btn hms-btn-outline-pill">
          <i class="bi bi-speedometer2 me-1"></i> Admin Panel
        </a>
      <?php else: ?>
        <a href="admin/login.php" class="btn hms-btn-outline-pill">Login</a>
      <?php endif; ?>

      <!-- Book Appointment Button -->
      <a href="book.php" class="btn hms-btn-primary-pill d-none d-sm-inline-flex">Book Appointment</a>

      <!-- Mobile Drawer Toggle -->
      <button class="btn btn-light border d-lg-none p-2 rounded-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-label="Toggle Navigation">
        <i class="bi bi-list fs-5"></i>
      </button>
    </div>

  </div>
</header>

<!-- MOBILE OFFCANVAS DRAWER -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavDrawer" style="max-width: 310px;">
  <div class="offcanvas-header border-bottom bg-light">
    <div class="d-flex align-items-center gap-2">
      <div class="hms-brand-icon" style="width: 34px; height: 34px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
          <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
        </svg>
      </div>
      <div>
        <div class="hms-brand-name" style="font-size: 1.15rem;">HMS</div>
        <div class="hms-brand-sub" style="font-size: 0.68rem;">Hospital &amp; Medical Centre</div>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
    <div class="list-group list-group-flush border-0">
      <a href="index.php" class="list-group-item list-group-item-action py-3 border-0 rounded-3 <?= ($currentPage === 'index.php') ? 'active fw-semibold' : '' ?>">
        <i class="bi bi-house-door me-2"></i> Home
      </a>
      <a href="index.php#departments" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
        <i class="bi bi-grid me-2"></i> Departments
      </a>
      <a href="index.php#doctors" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
        <i class="bi bi-person-badge me-2"></i> Doctors
      </a>
      <a href="index.php#packages" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
        <i class="bi bi-heart-pulse me-2"></i> Health Packages
      </a>
      <a href="gallery.php" class="list-group-item list-group-item-action py-3 border-0 rounded-3 <?= ($currentPage === 'gallery.php') ? 'active fw-semibold' : '' ?>">
        <i class="bi bi-images me-2"></i> Facilities Gallery
      </a>
      <a href="about.php" class="list-group-item list-group-item-action py-3 border-0 rounded-3 <?= ($currentPage === 'about.php') ? 'active fw-semibold' : '' ?>">
        <i class="bi bi-info-circle me-2"></i> About Us
      </a>
      <a href="reviews.php" class="list-group-item list-group-item-action py-3 border-0 rounded-3 <?= ($currentPage === 'reviews.php') ? 'active fw-semibold' : '' ?>">
        <i class="bi bi-star me-2"></i> Patient Reviews
      </a>
      <a href="contact.php" class="list-group-item list-group-item-action py-3 border-0 rounded-3 <?= ($currentPage === 'contact.php') ? 'active fw-semibold' : '' ?>">
        <i class="bi bi-telephone me-2"></i> Contact Us
      </a>
    </div>
    <div class="pt-3 border-top">
      <a href="book.php" class="btn hms-btn-primary-pill w-100 py-2 mb-2">
        <i class="bi bi-calendar-check me-1"></i> Book Appointment
      </a>
      <a href="admin/login.php" class="btn hms-btn-outline-pill w-100 py-2 mb-3">
        <i class="bi bi-person me-1"></i> Portal Login
      </a>
      <div class="p-2 bg-light rounded-3 text-center small text-muted">
        <i class="bi bi-telephone-fill text-danger me-1"></i> 24/7 Helpline: <strong><?= SITE_PHONE ?></strong>
      </div>
    </div>
  </div>
</div>
