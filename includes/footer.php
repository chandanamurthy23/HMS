<?php
/**
 * Hospital Management System (HMS) - Site Footer Component
 */
?>
  <!-- MAIN FOOTER -->
  <footer class="hms-main-footer">
    <div class="container-xl">
      <div class="row g-4">
        
        <!-- Column 1: Brand Info -->
        <div class="col-12 col-md-4 col-lg-3">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="hms-brand-icon" style="width: 38px; height: 38px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
                <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
              </svg>
            </div>
            <div>
              <div class="hms-footer-brand-title">HMS</div>
              <div style="font-size: 0.75rem; color: #94a3b8;">Hospital &amp; Medical Centre</div>
            </div>
          </div>
          <div class="hms-footer-tagline">
            <?= SITE_TAGLINE ?>.
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="col-6 col-md-2 col-lg-2">
          <div class="hms-footer-heading">Quick Links</div>
          <ul class="hms-footer-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#departments">Departments</a></li>
            <li><a href="index.php#doctors">Doctors</a></li>
            <li><a href="index.php#packages">Health Packages</a></li>
            <li><a href="gallery.php">Facilities</a></li>
          </ul>
        </div>

        <!-- Column 3: More Links -->
        <div class="col-6 col-md-2 col-lg-2">
          <div class="hms-footer-heading">Company</div>
          <ul class="hms-footer-links">
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="reviews.php">Patient Reviews</a></li>
            <li><a href="privacy.php">Privacy Policy</a></li>
            <li><a href="refund.php">Refund Policy</a></li>
            <li><a href="admin/login.php">Staff Portal</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact Us -->
        <div class="col-12 col-md-4 col-lg-3">
          <div class="hms-footer-heading">Contact Us</div>
          <div class="hms-contact-item">
            <i class="bi bi-telephone-fill"></i>
            <div><?= SITE_PHONE ?></div>
          </div>
          <div class="hms-contact-item">
            <i class="bi bi-envelope-fill"></i>
            <div><?= SITE_EMAIL ?></div>
          </div>
          <div class="hms-contact-item">
            <i class="bi bi-geo-alt-fill"></i>
            <div><?= SITE_ADDRESS ?></div>
          </div>
        </div>

        <!-- Column 5: Follow Us -->
        <div class="col-12 col-lg-2">
          <div class="hms-footer-heading">Follow Us</div>
          <div class="d-flex align-items-center mb-3">
            <a href="javascript:void(0)" class="hms-social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
          </div>
          <a href="book.php" class="btn hms-btn-primary-pill btn-sm w-100 py-2">
            <i class="bi bi-calendar-event me-1"></i> Book Visit
          </a>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between hms-footer-bottom gap-2">
        <div>
          &copy; <?= date('Y') ?> HMS Hospital &amp; Medical Centre. All rights reserved.
        </div>
        <div>
          <a href="privacy.php" class="text-secondary text-decoration-none me-3">Privacy Policy</a>
          <span>|</span>
          <a href="refund.php" class="text-secondary text-decoration-none ms-3">Terms &amp; Refund Policy</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- SEARCH MODAL -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header border-bottom-0 pb-0">
          <h5 class="modal-title fw-bold" id="searchModalLabel">
            <i class="bi bi-search text-primary me-2"></i> Search Doctors &amp; Specialties
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="input-group mb-3">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control bg-light border-start-0 py-2" id="globalSearchInput" placeholder="Type doctor name, specialty, or condition..." autofocus>
          </div>
          <div class="small fw-semibold text-muted mb-2">QUICK SUGGESTIONS:</div>
          <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="index.php#departments" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Cardiology</a>
            <a href="index.php#departments" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Neurology</a>
            <a href="book.php?doctor=1" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Dr. Ananya Sharma</a>
            <a href="book.php?doctor=4" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Dr. Arjun Nair</a>
            <a href="index.php#packages" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Full Body Checkup</a>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn hms-btn-primary-pill px-4" onclick="handleSearchRedirect()">Search</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Header shadow on scroll
    window.addEventListener('scroll', () => {
      const header = document.getElementById('mainHeader');
      if (header) {
        if (window.scrollY > 30) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
      }
    });

    // Search redirect handler
    function handleSearchRedirect() {
      const query = document.getElementById('globalSearchInput').value.trim();
      if (query) {
        window.location.href = `index.php#doctors`;
      }
    }

    document.getElementById('globalSearchInput')?.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        handleSearchRedirect();
      }
    });
  </script>
</body>
</html>
