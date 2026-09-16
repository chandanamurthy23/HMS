/**
 * Hospital Management System (HMS) - Dynamic Navigation & Layout Generator
 * Generates unified Header and Sidebar across all HMS pages with role awareness.
 */

const HMSNav = (function () {
  function getPathContext() {
    const path = window.location.pathname.replace(/\\/g, '/');
    const isSubRole = path.includes('/pages/admin/') ||
                      path.includes('/pages/doctor/') ||
                      path.includes('/pages/receptionist/') ||
                      path.includes('/pages/patient/');
    const isInsidePages = path.includes('/pages/');

    return {
      rootPrefix: isSubRole ? '../../' : (isInsidePages ? '../' : './'),
      pagesPrefix: isSubRole ? '../' : (isInsidePages ? '' : 'pages/'),
      currentPath: path
    };
  }

  function renderSidebar(activeKey = '') {
    const sidebarEl = document.getElementById('hms-sidebar');
    if (!sidebarEl) return;

    const ctx = getPathContext();
    const currentUser = HMSAuth.getCurrentUser();
    const role = currentUser.role || 'Admin';

    // Target dashboard based on current role
    let dashboardLink = `${ctx.pagesPrefix}admin/dashboard.html`;
    if (role === 'Doctor') dashboardLink = `${ctx.pagesPrefix}doctor/dashboard.html`;
    if (role === 'Receptionist') dashboardLink = `${ctx.pagesPrefix}receptionist/dashboard.html`;
    if (role === 'Patient') dashboardLink = `${ctx.pagesPrefix}patient/dashboard.html`;

    const navItems = [
      { section: 'Main Overview' },
      { key: 'dashboard', label: 'Dashboard', icon: 'bi-grid-1x2-fill', href: dashboardLink, roles: ['Admin', 'Doctor', 'Receptionist', 'Patient'] },
      { key: 'patients', label: 'Patients', icon: 'bi-people-fill', href: `${ctx.pagesPrefix}patients.html`, roles: ['Admin', 'Doctor', 'Receptionist'] },
      { key: 'appointments', label: 'Appointments', icon: 'bi-calendar-check-fill', href: `${ctx.pagesPrefix}appointments.html`, roles: ['Admin', 'Doctor', 'Receptionist', 'Patient'] },
      { key: 'doctors', label: 'Doctors & Schedule', icon: 'bi-person-badge-fill', href: `${ctx.pagesPrefix}doctors.html`, roles: ['Admin', 'Receptionist', 'Doctor'] },
      
      { section: 'Clinical & OPD' },
      { key: 'departments', label: 'Departments', icon: 'bi-grid-fill', href: `${ctx.pagesPrefix}departments.html`, roles: ['Admin', 'Doctor', 'Receptionist', 'Patient'] },
      { key: 'consultation', label: 'Consultation', icon: 'bi-clipboard2-pulse-fill', href: `${ctx.pagesPrefix}consultation.html`, roles: ['Admin', 'Doctor'] },
      { key: 'prescriptions', label: 'Prescriptions', icon: 'bi-capsule', href: `${ctx.pagesPrefix}prescriptions.html`, roles: ['Admin', 'Doctor', 'Patient', 'Receptionist'] },
      { key: 'health-checkup', label: 'Health Checkup', icon: 'bi-heart-pulse-fill', href: `${ctx.pagesPrefix}health-checkup.html`, roles: ['Admin', 'Doctor', 'Patient'] },
      { key: 'discharge-summary', label: 'Discharge Summary', icon: 'bi-file-earmark-medical-fill', href: `${ctx.pagesPrefix}discharge-summary.html`, roles: ['Admin', 'Doctor', 'Receptionist'] },

      { section: 'Hospital Operations' },
      { key: 'billing', label: 'Billing & Invoicing', icon: 'bi-receipt-cutoff', href: `${ctx.pagesPrefix}billing.html`, roles: ['Admin', 'Receptionist', 'Patient'] },
      { key: 'waiting-time', label: 'Waiting Time Tracker', icon: 'bi-clock-history', href: `${ctx.pagesPrefix}waiting-time.html`, roles: ['Admin', 'Doctor', 'Receptionist'] },
      { key: 'documents', label: 'Document Records', icon: 'bi-folder2-open', href: `${ctx.pagesPrefix}documents.html`, roles: ['Admin', 'Doctor', 'Receptionist', 'Patient'] },
      { key: 'assets', label: 'Hospital Assets', icon: 'bi-box-seam-fill', href: `${ctx.pagesPrefix}assets.html`, roles: ['Admin'] },

      { section: 'Feedback & System' },
      { key: 'ratings', label: 'Ratings & Reviews', icon: 'bi-star-fill', href: `${ctx.pagesPrefix}ratings.html`, roles: ['Admin', 'Doctor', 'Patient'] },
      { key: 'settings', label: 'System Settings', icon: 'bi-gear-fill', href: `${ctx.pagesPrefix}settings.html`, roles: ['Admin', 'Doctor', 'Receptionist', 'Patient'] }
    ];

    let navHtml = '';
    navItems.forEach(item => {
      if (item.section) {
        navHtml += `<div class="hms-nav-group-label">${item.section}</div>`;
      } else {
        // Only show if role matches
        const isVisible = item.roles.includes(role);
        if (isVisible) {
          const isActive = activeKey === item.key ? 'active' : '';
          navHtml += `
            <a href="${item.href}" class="hms-nav-item ${isActive}">
              <i class="bi ${item.icon}"></i>
              <span>${item.label}</span>
            </a>
          `;
        }
      }
    });

    sidebarEl.innerHTML = `
      <div class="hms-sidebar-brand d-flex align-items-center justify-content-between">
        <a href="${dashboardLink}" class="d-flex align-items-center gap-2 text-decoration-none">
          <div class="logo-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50%; background: #0d6efd; color: #fff; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(13,110,253,0.4);">HMS</div>
          <span class="fw-bold fs-5 text-white tracking-tight">HMS</span>
        </a>
        <button class="hms-sidebar-close-btn d-lg-none" onclick="HMSNav.toggleMobileSidebar()" title="Close Sidebar" aria-label="Close menu">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="hms-sidebar-nav">
        ${navHtml}
      </div>

      <div class="hms-sidebar-footer">
        <div class="d-flex align-items-center gap-2">
          <img src="${currentUser.avatar}" alt="Avatar" class="rounded-circle border" width="38" height="38" style="object-fit: cover;">
          <div class="flex-grow-1 overflow-hidden">
            <div class="text-truncate fw-semibold text-white user-profile-name" style="font-size: 0.85rem;" title="${currentUser.name}">${currentUser.name}</div>
            <span class="badge ${currentUser.badgeClass || 'bg-primary'}" style="font-size: 0.65rem; padding: 2px 6px;">${currentUser.role}</span>
          </div>
          <button class="btn btn-sm btn-outline-danger p-1" title="Log Out" onclick="HMSAuth.logout()">
            <i class="bi bi-box-arrow-right fs-6"></i>
          </button>
        </div>
      </div>
    `;

    // Close mobile sidebar when clicking any navigation link
    sidebarEl.querySelectorAll('.hms-nav-item').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth < 992) {
          toggleMobileSidebar();
        }
      });
    });

    // Ensure mobile backdrop
    let backdrop = document.querySelector('.hms-sidebar-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'hms-sidebar-backdrop';
      backdrop.onclick = toggleMobileSidebar;
      document.body.appendChild(backdrop);
    }
  }

  function toggleMobileSidebar() {
    const sidebar = document.getElementById('hms-sidebar');
    const backdrop = document.querySelector('.hms-sidebar-backdrop');
    if (sidebar) sidebar.classList.toggle('show');
    if (backdrop) backdrop.classList.toggle('show');
  }

  function renderHeader(pageTitle = 'Dashboard', breadcrumbs = ['Home']) {
    const headerEl = document.getElementById('hms-header');
    if (!headerEl) return;

    const ctx = getPathContext();
    const currentUser = HMSAuth.getCurrentUser();

    const breadcrumbHtml = breadcrumbs.map((b, idx) => {
      const isLast = idx === breadcrumbs.length - 1;
      return `<li class="breadcrumb-item ${isLast ? 'active text-primary fw-medium' : ''}">${b}</li>`;
    }).join('');

    headerEl.innerHTML = `
      <div class="d-flex align-items-center gap-2 gap-md-3 min-w-0 overflow-hidden">
        <button class="btn btn-light d-lg-none p-2 border flex-shrink-0" onclick="HMSNav.toggleMobileSidebar()" aria-label="Toggle navigation">
          <i class="bi bi-list fs-5"></i>
        </button>
        <div class="overflow-hidden">
          <h1 class="hms-header-title h5 mb-0 fw-bold text-dark text-truncate" title="${pageTitle}">${pageTitle}</h1>
          <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0" style="font-size: 0.75rem;">
              ${breadcrumbHtml}
            </ol>
          </nav>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2 gap-md-3 flex-shrink-0">
        <!-- SEARCH BAR -->
        <div class="position-relative d-none d-lg-block" style="width: 240px;">
          <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
          <input type="text" class="form-control form-control-sm ps-5 bg-light rounded-pill border-0 shadow-none" placeholder="Search here..." id="globalSearchInput">
        </div>

        <!-- QUICK ROLE SWITCHER FOR DEMO EVALUATION -->
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-primary dropdown-toggle d-flex align-items-center gap-1 shadow-sm role-switcher-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Switch user role for testing">
            <i class="bi bi-person-gear"></i>
            <span class="role-label d-none d-sm-inline">Role:</span> <strong>${currentUser.role}</strong>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><h6 class="dropdown-header text-uppercase" style="font-size: 0.7rem;">Simulate Role View</h6></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2 ${currentUser.role === 'Admin' ? 'active' : ''}" href="javascript:void(0)" onclick="HMSNav.switchAndRefresh('Admin')"><i class="bi bi-shield-check text-primary"></i> Admin</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2 ${currentUser.role === 'Doctor' ? 'active' : ''}" href="javascript:void(0)" onclick="HMSNav.switchAndRefresh('Doctor')"><i class="bi bi-heart-pulse text-info"></i> Doctor (Dr. Jenkins)</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2 ${currentUser.role === 'Receptionist' ? 'active' : ''}" href="javascript:void(0)" onclick="HMSNav.switchAndRefresh('Receptionist')"><i class="bi bi-person-workspace text-warning"></i> Receptionist (Karen)</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2 ${currentUser.role === 'Patient' ? 'active' : ''}" href="javascript:void(0)" onclick="HMSNav.switchAndRefresh('Patient')"><i class="bi bi-person-heart text-success"></i> Patient (Robert Harrison)</a></li>
          </ul>
        </div>

        <!-- NOTIFICATIONS -->
        <div class="dropdown">
          <button class="btn btn-sm btn-light border position-relative p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell fs-6 text-secondary"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
              <span class="visually-hidden">New alerts</span>
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0 border-0" style="width: 320px; font-size: 0.85rem;">
            <li class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
              <span class="fw-bold">Recent Notifications</span>
              <span class="badge bg-primary rounded-pill">3 New</span>
            </li>
            <li>
              <a class="dropdown-item p-3 border-bottom d-flex gap-2 align-items-start" href="${ctx.pagesPrefix}waiting-time.html">
                <i class="bi bi-person-check-fill text-success fs-5"></i>
                <div>
                  <div class="fw-semibold text-dark">Patient Checked In</div>
                  <div class="text-muted" style="font-size: 0.78rem;">Robert Harrison arrived for Cardiology OPD</div>
                  <div class="text-primary mt-1" style="font-size: 0.7rem;">5 mins ago</div>
                </div>
              </a>
            </li>
            <li>
              <a class="dropdown-item p-3 border-bottom d-flex gap-2 align-items-start" href="${ctx.pagesPrefix}documents.html">
                <i class="bi bi-file-earmark-medical text-info fs-5"></i>
                <div>
                  <div class="fw-semibold text-dark">Lab Report Uploaded</div>
                  <div class="text-muted" style="font-size: 0.78rem;">Blood Panel Report verified for David Chen</div>
                  <div class="text-primary mt-1" style="font-size: 0.7rem;">25 mins ago</div>
                </div>
              </a>
            </li>
            <li>
              <a class="dropdown-item p-3 d-flex gap-2 align-items-start" href="${ctx.pagesPrefix}assets.html">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                <div>
                  <div class="fw-semibold text-dark">Asset Maintenance Due</div>
                  <div class="text-muted" style="font-size: 0.78rem;">OT 3 Laparoscopy Tower scheduled for inspection</div>
                  <div class="text-primary mt-1" style="font-size: 0.7rem;">1 hour ago</div>
                </div>
              </a>
            </li>
          </ul>
        </div>

        <!-- USER PROFILE MENU -->
        <div class="dropdown">
          <button class="btn btn-sm p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="${currentUser.avatar}" alt="Avatar" class="rounded-circle border" width="38" height="38" style="object-fit: cover;">
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li class="px-3 py-2 border-bottom">
              <div class="fw-bold text-dark">${currentUser.name}</div>
              <div class="text-muted small">${currentUser.email}</div>
            </li>
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="${ctx.pagesPrefix}settings.html"><i class="bi bi-person"></i> Account Settings</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="${ctx.pagesPrefix}settings.html"><i class="bi bi-shield-lock"></i> Security & Roles</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="javascript:void(0)" onclick="HMSAuth.logout()"><i class="bi bi-box-arrow-right"></i> Log Out</a></li>
          </ul>
        </div>
      </div>
    `;
  }

  function switchAndRefresh(role) {
    HMSAuth.switchRole(role);
    const ctx = getPathContext();
    // If on a role dashboard, go to the new role's dashboard; else reload current page with updated permissions
    const path = window.location.pathname.toLowerCase();
    if (path.includes('dashboard')) {
      const ext = path.includes('.html') ? '.html' : '';
      window.location.href = `${ctx.pagesPrefix}${role.toLowerCase()}/dashboard${ext}`;
    } else {
      window.location.reload();
    }
  }

  function init(activeKey = 'dashboard', pageTitle = 'Dashboard', breadcrumbs = ['Home', 'Dashboard']) {
    renderSidebar(activeKey);
    renderHeader(pageTitle, breadcrumbs);
  }

  return {
    init,
    renderSidebar,
    renderHeader,
    toggleMobileSidebar,
    switchAndRefresh
  };
})();

if (typeof window !== 'undefined') {
  window.HMSNav = HMSNav;
}
