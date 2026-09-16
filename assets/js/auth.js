/**
 * Hospital Management System (HMS) - Authentication & Role Management
 */

const HMSAuth = (function () {
  const USER_KEY = 'MEDPULSE_HMS_USER';

  const DEFAULT_PROFILES = {
    Admin: {
      role: 'Admin',
      name: 'Dr. Arthur Pendelton',
      title: 'Medical Director & Chief Admin',
      email: 'admin@medpulse.com',
      avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=256',
      badgeClass: 'bg-primary'
    },
    Doctor: {
      role: 'Doctor',
      id: 'DOC-101',
      name: 'Dr. Sarah Jenkins',
      title: 'Senior Cardiologist, MD',
      email: 'dr.jenkins@medpulse-hms.com',
      avatar: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=256',
      badgeClass: 'bg-info text-dark'
    },
    Receptionist: {
      role: 'Receptionist',
      name: 'Karen Williams',
      title: 'Front Desk Lead Coordinator',
      email: 'reception@medpulse.com',
      avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=256',
      badgeClass: 'bg-warning text-dark'
    },
    Patient: {
      role: 'Patient',
      id: 'PAT-2026-001',
      name: 'Robert Harrison',
      title: 'Patient (ID: PAT-2026-001)',
      email: 'robert.harrison@example.com',
      avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=256',
      badgeClass: 'bg-success'
    }
  };

  function getCurrentUser() {
    try {
      const stored = localStorage.getItem(USER_KEY);
      if (stored) {
        return JSON.parse(stored);
      }
    } catch (e) {
      console.error('Error parsing stored user:', e);
    }
    // Default fallback to Admin
    const defaultUser = DEFAULT_PROFILES['Admin'];
    setCurrentUser(defaultUser);
    return defaultUser;
  }

  function setCurrentUser(user) {
    localStorage.setItem(USER_KEY, JSON.stringify(user));
    window.dispatchEvent(new CustomEvent('hms:user-changed', { detail: user }));
  }

  function login(role, email, password) {
    const profile = DEFAULT_PROFILES[role] || DEFAULT_PROFILES['Admin'];
    const user = {
      ...profile,
      email: email || profile.email
    };
    setCurrentUser(user);
    return user;
  }

  function switchRole(role) {
    if (DEFAULT_PROFILES[role]) {
      const user = DEFAULT_PROFILES[role];
      setCurrentUser(user);
      return user;
    }
    return getCurrentUser();
  }

  function logout() {
    localStorage.removeItem(USER_KEY);
    // Find relative path to root login.html
    const isInsidePages = window.location.pathname.includes('/pages/');
    const isSubRole = window.location.pathname.includes('/pages/admin/') ||
                      window.location.pathname.includes('/pages/doctor/') ||
                      window.location.pathname.includes('/pages/receptionist/') ||
                      window.location.pathname.includes('/pages/patient/');
    
    let target = 'login.html';
    if (isSubRole) target = '../../login.html';
    else if (isInsidePages) target = '../login.html';

    window.location.href = target;
  }

  function getDashboardPath(role) {
    const r = role.toLowerCase();
    const isInsidePages = window.location.pathname.includes('/pages/');
    const isSubRole = window.location.pathname.includes('/pages/admin/') ||
                      window.location.pathname.includes('/pages/doctor/') ||
                      window.location.pathname.includes('/pages/receptionist/') ||
                      window.location.pathname.includes('/pages/patient/');
    
    let prefix = 'pages/';
    if (isSubRole) prefix = '../';
    else if (isInsidePages) prefix = '';

    return `${prefix}${r}/dashboard.html`;
  }

  return {
    getCurrentUser,
    setCurrentUser,
    login,
    switchRole,
    logout,
    getDashboardPath,
    DEFAULT_PROFILES
  };
})();

if (typeof window !== 'undefined') {
  window.HMSAuth = HMSAuth;
}
