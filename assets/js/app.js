/**
 * Hospital Management System (HMS) - Global Application Helpers
 */

const HMSApp = (function () {
  // Ensure toast container exists
  function getToastContainer() {
    let container = document.querySelector('.hms-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'hms-toast-container';
      document.body.appendChild(container);
    }
    return container;
  }

  function showToast(message, type = 'success', duration = 3500) {
    const container = getToastContainer();
    const toast = document.createElement('div');
    toast.className = `hms-toast border-start border-4 border-${type}`;

    let icon = 'bi-check-circle-fill text-success';
    if (type === 'danger') icon = 'bi-exclamation-octagon-fill text-danger';
    if (type === 'warning') icon = 'bi-exclamation-triangle-fill text-warning';
    if (type === 'info') icon = 'bi-info-circle-fill text-info';

    toast.innerHTML = `
      <i class="bi ${icon} fs-5"></i>
      <div class="flex-grow-1 text-dark" style="font-size: 0.88rem; font-weight: 500;">
        ${message}
      </div>
      <button type="button" class="btn-close ms-2" style="font-size: 0.75rem;" aria-label="Close"></button>
    `;

    toast.querySelector('.btn-close').onclick = () => {
      toast.remove();
    };

    container.appendChild(toast);

    setTimeout(() => {
      if (toast.parentElement) {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => toast.remove(), 300);
      }
    }, duration);
  }

  function formatCurrency(amount) {
    const num = Number(amount) || 0;
    return '$' + num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  }

  function formatDate(dateStr) {
    if (!dateStr || dateStr === '--') return '--';
    try {
      const d = new Date(dateStr);
      if (isNaN(d.getTime())) return dateStr;
      return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    } catch (e) {
      return dateStr;
    }
  }

  function renderStatusBadge(status) {
    if (!status) return '';
    const clean = status.toLowerCase().replace(/[\s_]+/g, '-');
    return `<span class="badge-status badge-status-${clean}">${status}</span>`;
  }

  function bindSearch(inputSelector, rowSelector, matchSelector) {
    const input = document.querySelector(inputSelector);
    if (!input) return;

    input.addEventListener('input', function (e) {
      const query = e.target.value.toLowerCase().trim();
      const rows = document.querySelectorAll(rowSelector);
      rows.forEach(row => {
        const text = matchSelector ? (row.querySelector(matchSelector)?.innerText || '') : row.innerText;
        if (text.toLowerCase().includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  }

  return {
    showToast,
    formatCurrency,
    formatDate,
    renderStatusBadge,
    bindSearch
  };
})();

if (typeof window !== 'undefined') {
  window.HMSApp = HMSApp;
}
