<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HMS - Hospital &amp; Medical Centre</title>
  <!-- Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts: Plus Jakarta Sans, Outfit, DM Serif Display, Caveat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=DM+Serif+Display:ital@0;1&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --hms-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --hms-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
      --hms-font-serif: 'DM Serif Display', Georgia, serif;
      --hms-font-script: 'Caveat', cursive;

      --hms-navy-primary: #0a355c;
      --hms-navy-hover: #072540;
      --hms-navy-dark: #071728;
      --hms-teal-accent: #0284c7;
      --hms-teal-light: #e0f2fe;
      --hms-text-dark: #0f172a;
      --hms-text-muted: #64748b;
      --hms-bg-light: #f8fafc;
      --hms-bg-hero: #f4f8fc;
      --hms-card-border: #edf2f7;
      --hms-star-color: #f59e0b;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--hms-font-sans);
      color: var(--hms-text-dark);
      background-color: #ffffff;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Headings */
    h1, h2, h3, h4, h5, h6 {
      font-family: var(--hms-font-heading);
      letter-spacing: -0.02em;
    }

    /* SECTION EYEBROW TAGS */
    .hms-eyebrow {
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--hms-teal-accent);
      margin-bottom: 0.75rem;
      display: inline-block;
    }

    /* BUTTONS */
    .hms-btn-primary-pill {
      background-color: var(--hms-navy-primary);
      color: #ffffff;
      font-weight: 600;
      font-size: 0.88rem;
      padding: 0.6rem 1.45rem;
      border-radius: 9999px;
      border: 1px solid var(--hms-navy-primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      transition: all 0.25s ease;
      box-shadow: 0 4px 12px rgba(10, 53, 92, 0.2);
    }
    .hms-btn-primary-pill:hover,
    .hms-btn-primary-pill:focus {
      background-color: var(--hms-navy-hover);
      border-color: var(--hms-navy-hover);
      color: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(10, 53, 92, 0.3);
    }

    .hms-btn-outline-pill {
      background-color: transparent;
      color: var(--hms-text-dark);
      font-weight: 600;
      font-size: 0.88rem;
      padding: 0.55rem 1.35rem;
      border-radius: 9999px;
      border: 1px solid #cbd5e1;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.25s ease;
    }
    .hms-btn-outline-pill:hover {
      background-color: #f1f5f9;
      color: var(--hms-navy-primary);
      border-color: #94a3b8;
    }

    .hms-btn-light-pill {
      background-color: #ffffff;
      color: #1e293b;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.65rem 1.6rem;
      border-radius: 9999px;
      border: 1px solid #d1d5db;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }
    .hms-btn-light-pill:hover {
      background-color: #f8fafc;
      border-color: #94a3b8;
      color: var(--hms-navy-primary);
    }

    /* =========================================================
       1. HEADER / NAVBAR
       ========================================================= */
    .hms-site-header {
      background-color: #ffffff;
      border-bottom: 1px solid #f1f5f9;
      transition: all 0.3s ease;
      z-index: 1040;
    }
    .hms-site-header.scrolled {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .hms-brand-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--hms-teal-accent);
      flex-shrink: 0;
    }
    .hms-brand-name {
      font-family: var(--hms-font-heading);
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--hms-navy-primary);
      line-height: 1.05;
      letter-spacing: -0.5px;
    }
    .hms-brand-sub {
      font-size: 0.72rem;
      font-weight: 500;
      color: var(--hms-text-muted);
      letter-spacing: 0.2px;
    }

    .hms-nav-link {
      font-size: 0.92rem;
      font-weight: 500;
      color: #334155;
      text-decoration: none;
      padding: 0.5rem 0.25rem;
      position: relative;
      transition: color 0.2s ease;
    }
    .hms-nav-link:hover {
      color: var(--hms-teal-accent);
    }
    .hms-nav-link.active {
      color: var(--hms-navy-primary);
      font-weight: 700;
    }
    .hms-nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      right: 0;
      height: 2.5px;
      background-color: var(--hms-teal-accent);
      border-radius: 2px;
    }

    .hms-search-trigger {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #475569;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .hms-search-trigger:hover {
      background-color: #f1f5f9;
      color: var(--hms-navy-primary);
    }

    /* =========================================================
       2. HERO SECTION
       ========================================================= */
    .hms-hero-section {
      background: linear-gradient(180deg, #edf5fc 0%, #f6faff 60%, #ffffff 100%);
      padding: 3.5rem 0 4rem;
      position: relative;
      overflow: hidden;
    }
    .hms-hero-heading {
      font-family: var(--hms-font-serif);
      font-size: 3.4rem;
      line-height: 1.15;
      color: var(--hms-navy-primary);
      margin-bottom: 1.25rem;
      letter-spacing: -0.5px;
    }
    .hms-hero-heading .text-teal-accent {
      color: var(--hms-teal-accent);
    }
    .hms-hero-text {
      font-size: 1.05rem;
      color: #475569;
      line-height: 1.65;
      max-width: 520px;
      margin-bottom: 2.2rem;
    }

    .hms-hero-badges-row {
      margin-top: 1.5rem;
    }
    .hms-badge-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .hms-badge-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      color: var(--hms-teal-accent);
      flex-shrink: 0;
    }
    .hms-badge-title {
      font-size: 0.88rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      line-height: 1.2;
    }
    .hms-badge-sub {
      font-size: 0.75rem;
      color: #64748b;
      line-height: 1.25;
      margin-top: 2px;
    }

    /* Doctor Visual in Hero */
    .hms-hero-img-wrap {
      position: relative;
      display: inline-block;
      max-width: 100%;
    }
    .hms-hero-doctor-img {
      border-radius: 24px;
      max-height: 520px;
      width: 100%;
      object-fit: cover;
      object-position: center top;
      box-shadow: 0 16px 40px rgba(10, 53, 92, 0.09);
    }

    /* =========================================================
       3. OUR DEPARTMENTS SECTION
       ========================================================= */
    .hms-departments-section {
      padding: 5rem 0;
      background-color: #ffffff;
    }
    .hms-section-title {
      font-size: 2.25rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      line-height: 1.25;
      margin-bottom: 1rem;
    }
    .hms-section-desc {
      font-size: 0.96rem;
      color: #64748b;
      line-height: 1.65;
      margin-bottom: 2rem;
    }

    .dept-card {
      background: #ffffff;
      border: 1px solid #f1f5f9;
      border-radius: 16px;
      padding: 1.35rem 1.2rem;
      box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
      transition: all 0.25s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
      text-decoration: none;
      position: relative;
    }
    .dept-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(10, 53, 92, 0.08);
      border-color: #dbeafe;
    }
    .dept-icon-circle {
      width: 46px;
      height: 46px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      margin-bottom: 0.9rem;
    }
    .dept-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      margin-bottom: 0.25rem;
    }
    .dept-sub {
      font-size: 0.78rem;
      color: #64748b;
      line-height: 1.35;
      margin-bottom: 0.75rem;
    }
    .dept-arrow {
      margin-top: auto;
      font-size: 0.95rem;
      color: var(--hms-teal-accent);
      transition: transform 0.2s ease;
    }
    .dept-card:hover .dept-arrow {
      transform: translateX(4px);
    }

    /* =========================================================
       4. OUR SPECIALISTS SECTION
       ========================================================= */
    .hms-specialists-section {
      padding: 5rem 0;
      background-color: #fcfdfe;
      border-top: 1px solid #f8fafc;
    }
    .doctor-card {
      background: #ffffff;
      border: 1px solid #edf2f7;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
      transition: all 0.25s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .doctor-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 14px 28px rgba(10, 53, 92, 0.1);
      border-color: #cbd5e1;
    }
    .doctor-img-box {
      width: 100%;
      height: 200px;
      overflow: hidden;
      position: relative;
      background-color: #f1f5f9;
    }
    .doctor-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top center;
      transition: transform 0.3s ease;
    }
    .doctor-card:hover .doctor-img-box img {
      transform: scale(1.04);
    }
    .doctor-content {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .doctor-name-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
      margin-bottom: 0.25rem;
    }
    .doctor-name {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      text-decoration: none;
    }
    .doctor-card-arrow {
      font-size: 0.95rem;
      color: var(--hms-teal-accent);
      transition: transform 0.2s ease;
    }
    .doctor-card:hover .doctor-card-arrow {
      transform: translateX(3px);
    }
    .doctor-specialty {
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--hms-teal-accent);
      margin-bottom: 0.3rem;
    }
    .doctor-experience {
      font-size: 0.78rem;
      color: #64748b;
      margin-bottom: 0.75rem;
    }
    .doctor-rating {
      font-size: 0.8rem;
      font-weight: 700;
      color: #1e293b;
      display: flex;
      align-items: center;
      gap: 0.35rem;
      margin-top: auto;
    }
    .doctor-rating i {
      color: var(--hms-star-color);
    }
    .doctor-rating .review-count {
      font-weight: 400;
      color: #64748b;
      font-size: 0.75rem;
    }

    /* =========================================================
       5. HEALTH PACKAGES SECTION
       ========================================================= */
    .hms-packages-section {
      padding: 5rem 0;
      background-color: #ffffff;
    }
    .package-hero-img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(10, 53, 92, 0.08);
    }
    .package-card {
      background: #ffffff;
      border: 1px solid #edf2f7;
      border-radius: 18px;
      padding: 1.6rem 1.4rem;
      box-shadow: 0 3px 14px rgba(15, 23, 42, 0.04);
      transition: all 0.25s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .package-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(10, 53, 92, 0.09);
      border-color: #cbd5e1;
    }
    .package-icon-box {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      margin-bottom: 1.1rem;
    }
    .package-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      margin-bottom: 0.5rem;
    }
    .package-price {
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--hms-navy-primary);
      margin-bottom: 1.25rem;
      font-family: var(--hms-font-heading);
    }
    .package-link {
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--hms-teal-accent);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      margin-top: auto;
      transition: gap 0.2s ease;
    }
    .package-card:hover .package-link {
      gap: 0.6rem;
    }

    /* =========================================================
       6. WHY CHOOSE US SECTION
       ========================================================= */
    .hms-why-section {
      padding: 5rem 0;
      background-color: #fbfcfe;
    }
    .why-feature-box {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      background: #ffffff;
      border: 1px solid #edf2f7;
      border-radius: 14px;
      padding: 1rem 1.15rem;
      box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
      height: 100%;
    }
    .why-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background-color: #e0f2fe;
      color: var(--hms-teal-accent);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }
    .why-title {
      font-size: 0.88rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      line-height: 1.2;
    }
    .why-sub {
      font-size: 0.76rem;
      color: #64748b;
      margin-top: 2px;
    }
    .hospital-building-img {
      width: 100%;
      height: 320px;
      object-fit: cover;
      border-radius: 22px;
      box-shadow: 0 12px 32px rgba(10, 53, 92, 0.1);
    }

    /* =========================================================
       7. OUR FACILITIES SECTION (Interactive Slider)
       ========================================================= */
    .hms-facilities-section {
      padding: 5rem 0;
      background-color: #ffffff;
    }
    .slider-nav-btn {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 1px solid #d1d5db;
      background: #ffffff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #334155;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .slider-nav-btn:hover {
      background: var(--hms-navy-primary);
      color: #ffffff;
      border-color: var(--hms-navy-primary);
    }
    .facility-card {
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #edf2f7;
      box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
      transition: all 0.25s ease;
      height: 100%;
    }
    .facility-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(10, 53, 92, 0.1);
    }
    .facility-img-wrap {
      width: 100%;
      height: 160px;
      overflow: hidden;
    }
    .facility-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.35s ease;
    }
    .facility-card:hover .facility-img-wrap img {
      transform: scale(1.06);
    }
    .facility-title {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
      padding: 0.9rem 1rem;
      text-align: center;
    }

    /* =========================================================
       8. PATIENT TESTIMONIALS SECTION
       ========================================================= */
    .hms-testimonials-section {
      padding: 5rem 0;
      background-color: #f8fafc;
    }
    .testimonial-card {
      background: #ffffff;
      border: 1px solid #edf2f7;
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.25s ease;
    }
    .testimonial-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 24px rgba(10, 53, 92, 0.08);
      border-color: #cbd5e1;
    }
    .testimonial-quote {
      font-size: 0.88rem;
      color: #334155;
      line-height: 1.6;
      font-style: italic;
      margin-bottom: 1.25rem;
    }
    .testimonial-author-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
      padding-top: 0.75rem;
      border-top: 1px solid #f1f5f9;
    }
    .testimonial-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ffffff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .testimonial-name {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--hms-navy-primary);
    }
    .testimonial-rating {
      font-size: 0.82rem;
      font-weight: 700;
      color: #1e293b;
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }
    .testimonial-rating i {
      color: var(--hms-star-color);
    }

    /* =========================================================
       9. CALL TO ACTION BANNER (Book Your Appointment Today)
       ========================================================= */
    .hms-cta-section {
      padding: 4.5rem 0;
      background: linear-gradient(135deg, #f5f9fc 0%, #edf4fa 100%);
      position: relative;
      overflow: hidden;
      border-top: 1px solid #e2e8f0;
      border-bottom: 1px solid #e2e8f0;
    }
    .hms-cta-script {
      font-family: var(--hms-font-script);
      font-size: 2.1rem;
      color: var(--hms-teal-accent);
      margin-bottom: 0.35rem;
      line-height: 1;
    }
    .hms-cta-heading {
      font-size: 2.4rem;
      font-weight: 800;
      color: var(--hms-navy-primary);
      margin-bottom: 0.75rem;
      letter-spacing: -0.5px;
    }
    .hms-cta-desc {
      font-size: 1rem;
      color: #475569;
      max-width: 540px;
    }

    /* =========================================================
       10. FOOTER
       ========================================================= */
    .hms-main-footer {
      background-color: var(--hms-navy-dark);
      color: #94a3b8;
      padding: 4.5rem 0 2rem;
      font-size: 0.88rem;
    }
    .hms-footer-brand-title {
      font-family: var(--hms-font-heading);
      font-size: 1.45rem;
      font-weight: 800;
      color: #ffffff;
      line-height: 1.1;
    }
    .hms-footer-tagline {
      font-size: 0.85rem;
      color: #94a3b8;
      margin-top: 0.6rem;
      line-height: 1.5;
    }
    .hms-footer-heading {
      font-family: var(--hms-font-heading);
      color: #ffffff;
      font-size: 1rem;
      font-weight: 700;
      margin-bottom: 1.25rem;
    }
    .hms-footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .hms-footer-links li {
      margin-bottom: 0.65rem;
    }
    .hms-footer-links a {
      color: #cbd5e1;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .hms-footer-links a:hover {
      color: #ffffff;
      text-decoration: underline;
    }
    .hms-contact-item {
      display: flex;
      align-items: flex-start;
      gap: 0.65rem;
      color: #cbd5e1;
      margin-bottom: 0.75rem;
    }
    .hms-contact-item i {
      color: var(--hms-teal-accent);
      font-size: 1.1rem;
      margin-top: 2px;
    }
    .hms-social-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.08);
      color: #cbd5e1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      margin-right: 0.5rem;
      transition: all 0.2s ease;
    }
    .hms-social-icon:hover {
      background-color: var(--hms-teal-accent);
      color: #ffffff;
      transform: translateY(-2px);
    }
    .hms-footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding-top: 1.5rem;
      margin-top: 3.5rem;
      font-size: 0.82rem;
      color: #64748b;
    }

    /* Hero CTA Group */
    .hms-hero-cta-group {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }
    .hms-hero-btn {
      padding: 0.75rem 1.8rem;
      font-size: 0.95rem;
    }

    /* Responsive tweaks */
    @media (max-width: 991.98px) {
      .hms-hero-heading {
        font-size: 2.5rem;
      }
      .hms-hero-doctor-img {
        max-height: 380px;
        object-position: center top;
      }
      .hms-cta-heading {
        font-size: 1.85rem;
      }
      .hms-section-title {
        font-size: 1.9rem;
      }
    }

    @media (max-width: 575.98px) {
      body {
        font-size: 0.92rem;
      }
      .container-xl, .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }
      /* Header on mobile */
      .hms-site-header {
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
      }
      .hms-brand-icon {
        width: 34px;
        height: 34px;
      }
      .hms-brand-name {
        font-size: 1.25rem;
      }
      .hms-search-trigger {
        width: 32px;
        height: 32px;
        font-size: 0.95rem;
      }
      .hms-btn-outline-pill {
        padding: 0.38rem 0.85rem;
        font-size: 0.82rem;
      }
      /* Hero section on mobile */
      .hms-hero-section {
        padding: 2rem 0 2.5rem;
      }
      .hms-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
      }
      .hms-hero-heading {
        font-size: 1.95rem;
        line-height: 1.2;
      }
      .hms-hero-text {
        font-size: 0.92rem;
        line-height: 1.55;
        margin-bottom: 1.5rem;
      }
      .hms-hero-cta-group {
        flex-direction: column;
        width: 100%;
        gap: 0.65rem;
        margin-bottom: 1.75rem;
      }
      .hms-hero-btn {
        width: 100% !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 0.72rem 1.25rem !important;
        font-size: 0.92rem !important;
      }
      .hms-hero-doctor-img {
        max-height: 290px;
        border-radius: 18px;
        object-position: center top;
        margin-top: 1rem;
      }
      .hms-badge-item {
        padding: 0.75rem 0.9rem;
      }
      .hms-badge-icon {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
      }
      .hms-badge-title {
        font-size: 0.84rem;
      }
      .hms-badge-sub {
        font-size: 0.72rem;
      }
      /* Departments on mobile */
      .hms-departments-section {
        padding: 3rem 0;
      }
      .hms-section-title {
        font-size: 1.75rem;
        line-height: 1.25;
      }
      .hms-section-desc {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
      }
      .dept-card {
        padding: 0.95rem 0.8rem;
        border-radius: 14px;
      }
      .dept-icon-circle {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        margin-bottom: 0.6rem;
      }
      .dept-title {
        font-size: 0.92rem;
      }
      .dept-sub {
        font-size: 0.72rem;
        margin-bottom: 0.4rem;
      }
      /* Specialists on mobile */
      .hms-specialists-section {
        padding: 3rem 0;
      }
      .doctor-img-box {
        height: 220px;
      }
      /* Health Packages on mobile */
      .hms-packages-section {
        padding: 3rem 0;
      }
      .package-hero-img {
        height: 190px;
        margin-bottom: 0.75rem;
      }
      .package-card {
        padding: 1.25rem 1.1rem;
      }
      /* Why Choose Us on mobile */
      .hms-why-section {
        padding: 3rem 0;
      }
      .why-feature-box {
        padding: 0.85rem 1rem;
      }
      .hospital-building-img {
        height: 220px;
        margin-top: 1.5rem;
      }
      /* Facilities on mobile */
      .hms-facilities-section {
        padding: 3rem 0;
      }
      .facility-img-wrap {
        height: 125px;
      }
      .facility-title {
        font-size: 0.84rem;
        padding: 0.65rem 0.4rem;
      }
      /* Testimonials on mobile */
      .hms-testimonials-section {
        padding: 3rem 0;
      }
      .testimonial-card {
        padding: 1.2rem 1rem;
      }
      /* CTA Banner on mobile */
      .hms-cta-section {
        padding: 2.75rem 0;
      }
      .hms-cta-script {
        font-size: 1.7rem;
      }
      .hms-cta-heading {
        font-size: 1.75rem;
      }
      .hms-cta-section .btn {
        width: 100% !important;
        justify-content: center;
        text-align: center;
        margin-top: 1rem;
      }
      /* Footer on mobile */
      .hms-main-footer {
        padding: 3rem 0 1.5rem;
      }
      .hms-footer-bottom {
        margin-top: 2rem;
      }
    }
  </style>
</head>
<body>

  <!-- =========================================================
       1. MAIN HEADER / NAVIGATION BAR
       ========================================================= -->
  <header class="hms-site-header sticky-top" id="mainHeader">
    <div class="container-xl d-flex align-items-center justify-content-between py-3">
      
      <!-- Brand Logo -->
      <a href="index.html" class="d-flex align-items-center gap-2 text-decoration-none">
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
        <a href="index.html" class="hms-nav-link active">Home</a>
        <div class="dropdown">
          <a href="javascript:void(0)" class="hms-nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Departments
          </a>
          <ul class="dropdown-menu border-0 shadow-lg rounded-3 py-2">
            <li><a class="dropdown-item py-2" href="pages/departments.html#cardiology"><i class="bi bi-heart-pulse-fill text-danger me-2"></i> Cardiology</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#neurology"><i class="bi bi-cpu-fill text-primary me-2"></i> Neurology</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#orthopedics"><i class="bi bi-bandaid-fill text-success me-2"></i> Orthopedics</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#pediatrics"><i class="bi bi-emoji-smile-fill text-info me-2"></i> Pediatrics</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#gynecology"><i class="bi bi-gender-female text-danger me-2"></i> Gynecology</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#dermatology"><i class="bi bi-shield-plus text-warning me-2"></i> Dermatology</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#gastroenterology"><i class="bi bi-capsule text-info me-2"></i> Gastroenterology</a></li>
            <li><a class="dropdown-item py-2" href="pages/departments.html#general"><i class="bi bi-heart-fill text-primary me-2"></i> General Medicine</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item py-2 text-primary fw-semibold" href="pages/departments.html">View All Departments &rarr;</a></li>
          </ul>
        </div>
        <a href="pages/doctors.html" class="hms-nav-link">Doctors</a>
        <a href="pages/health-checkup.html" class="hms-nav-link">Health Packages</a>
        <a href="#aboutHospitalModal" data-bs-toggle="modal" class="hms-nav-link">About Us</a>
        <a href="#contactModal" data-bs-toggle="modal" class="hms-nav-link">Contact</a>
      </nav>

      <!-- Search & Auth Actions -->
      <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- Quick Search Modal Trigger -->
        <button type="button" class="btn btn-link hms-search-trigger" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search doctors & treatments">
          <i class="bi bi-search fs-5"></i>
        </button>

        <!-- Login Button -->
        <a href="login.html" class="btn hms-btn-outline-pill">Login</a>

        <!-- Book Appointment Button -->
        <a href="pages/appointments.html" class="btn hms-btn-primary-pill d-none d-sm-inline-flex">Book Appointment</a>

        <!-- Mobile Drawer Toggle -->
        <button class="btn btn-light border d-lg-none p-2 rounded-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-label="Toggle Navigation">
          <i class="bi bi-list fs-5"></i>
        </button>
      </div>

    </div>
  </header>

  <!-- =========================================================
       MOBILE OFFCANVAS DRAWER
       ========================================================= -->
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
        <a href="index.html" class="list-group-item list-group-item-action py-3 border-0 rounded-3 active fw-semibold">
          <i class="bi bi-house-door me-2"></i> Home
        </a>
        <a href="pages/departments.html" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
          <i class="bi bi-grid me-2"></i> Departments
        </a>
        <a href="pages/doctors.html" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
          <i class="bi bi-person-badge me-2"></i> Doctors
        </a>
        <a href="pages/health-checkup.html" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
          <i class="bi bi-heart-pulse me-2"></i> Health Packages
        </a>
        <a href="#aboutHospitalModal" data-bs-toggle="modal" data-bs-dismiss="offcanvas" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
          <i class="bi bi-info-circle me-2"></i> About Us
        </a>
        <a href="#contactModal" data-bs-toggle="modal" data-bs-dismiss="offcanvas" class="list-group-item list-group-item-action py-3 border-0 rounded-3">
          <i class="bi bi-telephone me-2"></i> Contact
        </a>
      </div>
      <div class="pt-3 border-top">
        <a href="pages/appointments.html" class="btn hms-btn-primary-pill w-100 py-2 mb-2">
          <i class="bi bi-calendar-check me-1"></i> Book Appointment
        </a>
        <a href="login.html" class="btn hms-btn-outline-pill w-100 py-2 mb-3">
          <i class="bi bi-person me-1"></i> Portal Login
        </a>
        <div class="p-2 bg-light rounded-3 text-center small text-muted">
          <i class="bi bi-telephone-fill text-danger me-1"></i> 24/7 Helpline: <strong>+91 98765 43210</strong>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================
       2. HERO SECTION
       ========================================================= -->
  <section class="hms-hero-section">
    <div class="container-xl">
      <div class="row align-items-center g-4 g-lg-5">
        
        <!-- Left Content -->
        <div class="col-lg-7">
          <div class="hms-eyebrow">YOUR HEALTH &middot; OUR PRIORITY</div>
          <h1 class="hms-hero-heading">
            Compassionate Care,<br>
            <span class="text-teal-accent">Advanced Healthcare.</span>
          </h1>
          <p class="hms-hero-text">
            At HMS, we believe in providing quality medical care with expert doctors, modern facilities and a patient-first approach.
          </p>
          
          <!-- CTA Action Buttons -->
          <div class="hms-hero-cta-group">
            <a href="pages/appointments.html" class="btn hms-btn-primary-pill hms-hero-btn">
              Book Appointment <i class="bi bi-arrow-right"></i>
            </a>
            <a href="pages/doctors.html" class="btn hms-btn-light-pill hms-hero-btn">
              Find a Doctor
            </a>
          </div>

          <!-- 3 Quick Highlight Badges -->
          <div class="row g-2 g-md-3 hms-hero-badges-row">
            <div class="col-12 col-md-4">
              <div class="hms-badge-item">
                <div class="hms-badge-icon">
                  <i class="bi bi-hospital"></i>
                </div>
                <div>
                  <div class="hms-badge-title">24/7 Emergency Care</div>
                  <div class="hms-badge-sub">Always here when you need us</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="hms-badge-item">
                <div class="hms-badge-icon">
                  <i class="bi bi-person-badge"></i>
                </div>
                <div>
                  <div class="hms-badge-title">Expert Doctors</div>
                  <div class="hms-badge-sub">Experienced &amp; trusted specialists</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="hms-badge-item">
                <div class="hms-badge-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <div>
                  <div class="hms-badge-title">Modern Facilities</div>
                  <div class="hms-badge-sub">Advanced technology &amp; care</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Visual: Doctor Image -->
        <div class="col-lg-5 text-center position-relative">
          <div class="hms-hero-img-wrap">
            <img src="assets/images/hero-doctor.jpg" alt="Doctor HMS Healthcare" class="img-fluid hms-hero-doctor-img" loading="eager">
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
       3. OUR DEPARTMENTS SECTION
       ========================================================= -->
  <section class="hms-departments-section" id="departments">
    <div class="container-xl">
      <div class="row g-4 g-lg-5 align-items-start">
        
        <!-- Left Summary Column -->
        <div class="col-lg-4">
          <div class="hms-eyebrow">OUR DEPARTMENTS</div>
          <h2 class="hms-section-title">Comprehensive Care Across Multiple Specialties</h2>
          <p class="hms-section-desc">
            From preventive care to advanced treatments, our departments are equipped to handle all your healthcare needs.
          </p>
          <a href="pages/departments.html" class="btn hms-btn-primary-pill">
            Explore All Departments <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <!-- Right 8-Card Grid (4 cols x 2 rows) -->
        <div class="col-lg-8">
          <div class="row g-3">
            
            <!-- 1. Cardiology -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#cardiology" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #fee2e2; color: #ef4444;">
                  <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div class="dept-title">Cardiology</div>
                <div class="dept-sub">Heart Care &amp; Treatment</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 2. Neurology -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#neurology" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #e0f2fe; color: #0284c7;">
                  <i class="bi bi-cpu-fill"></i>
                </div>
                <div class="dept-title">Neurology</div>
                <div class="dept-sub">Brain &amp; Nerve Care</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 3. Orthopedics -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#orthopedics" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #dcfce7; color: #16a34a;">
                  <i class="bi bi-bandaid-fill"></i>
                </div>
                <div class="dept-title">Orthopedics</div>
                <div class="dept-sub">Bone &amp; Joint Care</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 4. Pediatrics -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#pediatrics" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #f3e8ff; color: #9333ea;">
                  <i class="bi bi-emoji-smile-fill"></i>
                </div>
                <div class="dept-title">Pediatrics</div>
                <div class="dept-sub">Child Health &amp; Wellness</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 5. Gynecology -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#gynecology" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #ffe4e6; color: #e11d48;">
                  <i class="bi bi-gender-female"></i>
                </div>
                <div class="dept-title">Gynecology</div>
                <div class="dept-sub">Women's Health</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 6. Dermatology -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#dermatology" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #ffedd5; color: #ea580c;">
                  <i class="bi bi-shield-plus"></i>
                </div>
                <div class="dept-title">Dermatology</div>
                <div class="dept-sub">Skin &amp; Hair Care</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 7. Gastroenterology -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#gastroenterology" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #cffafe; color: #0891b2;">
                  <i class="bi bi-capsule"></i>
                </div>
                <div class="dept-title">Gastroenterology</div>
                <div class="dept-sub">Digestive Health</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

            <!-- 8. General Medicine -->
            <div class="col-6 col-md-3">
              <a href="pages/departments.html#general" class="dept-card">
                <div class="dept-icon-circle" style="background-color: #e0e7ff; color: #4338ca;">
                  <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="dept-title">General Medicine</div>
                <div class="dept-sub">Overall Wellness</div>
                <div class="dept-arrow"><i class="bi bi-arrow-right"></i></div>
              </a>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
       4. OUR SPECIALISTS SECTION
       ========================================================= -->
  <section class="hms-specialists-section" id="doctors">
    <div class="container-xl">
      <div class="row g-4 g-lg-5 align-items-start">
        
        <!-- Left Summary Column -->
        <div class="col-lg-3">
          <div class="hms-eyebrow">OUR SPECIALISTS</div>
          <h2 class="hms-section-title">Meet Our Expert Doctors</h2>
          <p class="hms-section-desc">
            Our team of experienced doctors is dedicated to providing personalized and compassionate care.
          </p>
          <a href="pages/doctors.html" class="btn hms-btn-primary-pill">
            View All Doctors <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <!-- Right 4 Doctor Cards in a row -->
        <div class="col-lg-9">
          <div class="row g-3">
            
            <!-- Doctor 1: Dr. Ananya Sharma -->
            <div class="col-12 col-sm-6 col-xl-3">
              <div class="doctor-card">
                <div class="doctor-img-box">
                  <img src="assets/images/doctors/dr-ananya.jpg" alt="Dr. Ananya Sharma" loading="lazy">
                </div>
                <div class="doctor-content">
                  <div class="doctor-name-row">
                    <a href="pages/appointments.html?doctor=Dr.%20Ananya%20Sharma" class="doctor-name">Dr. Ananya Sharma</a>
                    <a href="pages/appointments.html?doctor=Dr.%20Ananya%20Sharma" class="doctor-card-arrow" title="Book Appointment"><i class="bi bi-arrow-right"></i></a>
                  </div>
                  <div class="doctor-specialty">Cardiologist</div>
                  <div class="doctor-experience">15+ years experience</div>
                  <div class="doctor-rating">
                    <i class="bi bi-star-fill"></i> 4.9 <span class="review-count">(120 reviews)</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Doctor 2: Dr. Rohan Mehta -->
            <div class="col-12 col-sm-6 col-xl-3">
              <div class="doctor-card">
                <div class="doctor-img-box">
                  <img src="assets/images/doctors/dr-rohan.jpg" alt="Dr. Rohan Mehta" loading="lazy">
                </div>
                <div class="doctor-content">
                  <div class="doctor-name-row">
                    <a href="pages/appointments.html?doctor=Dr.%20Rohan%20Mehta" class="doctor-name">Dr. Rohan Mehta</a>
                    <a href="pages/appointments.html?doctor=Dr.%20Rohan%20Mehta" class="doctor-card-arrow" title="Book Appointment"><i class="bi bi-arrow-right"></i></a>
                  </div>
                  <div class="doctor-specialty">Neurologist</div>
                  <div class="doctor-experience">12+ years experience</div>
                  <div class="doctor-rating">
                    <i class="bi bi-star-fill"></i> 4.7 <span class="review-count">(98 reviews)</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Doctor 3: Dr. Sneha Iyer -->
            <div class="col-12 col-sm-6 col-xl-3">
              <div class="doctor-card">
                <div class="doctor-img-box">
                  <img src="assets/images/doctors/dr-sneha.jpg" alt="Dr. Sneha Iyer" loading="lazy">
                </div>
                <div class="doctor-content">
                  <div class="doctor-name-row">
                    <a href="pages/appointments.html?doctor=Dr.%20Sneha%20Iyer" class="doctor-name">Dr. Sneha Iyer</a>
                    <a href="pages/appointments.html?doctor=Dr.%20Sneha%20Iyer" class="doctor-card-arrow" title="Book Appointment"><i class="bi bi-arrow-right"></i></a>
                  </div>
                  <div class="doctor-specialty">Pediatrician</div>
                  <div class="doctor-experience">10+ years experience</div>
                  <div class="doctor-rating">
                    <i class="bi bi-star-fill"></i> 4.9 <span class="review-count">(142 reviews)</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Doctor 4: Dr. Arjun Nair -->
            <div class="col-12 col-sm-6 col-xl-3">
              <div class="doctor-card">
                <div class="doctor-img-box">
                  <img src="assets/images/doctors/dr-arjun.jpg" alt="Dr. Arjun Nair" loading="lazy">
                </div>
                <div class="doctor-content">
                  <div class="doctor-name-row">
                    <a href="pages/appointments.html?doctor=Dr.%20Arjun%20Nair" class="doctor-name">Dr. Arjun Nair</a>
                    <a href="pages/appointments.html?doctor=Dr.%20Arjun%20Nair" class="doctor-card-arrow" title="Book Appointment"><i class="bi bi-arrow-right"></i></a>
                  </div>
                  <div class="doctor-specialty">Orthopedic Surgeon</div>
                  <div class="doctor-experience">14+ years experience</div>
                  <div class="doctor-rating">
                    <i class="bi bi-star-fill"></i> 4.8 <span class="review-count">(110 reviews)</span>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
       5. HEALTH PACKAGES SECTION
       ========================================================= -->
  <section class="hms-packages-section" id="packages">
    <div class="container-xl">
      <div class="row g-4 g-lg-5 align-items-center">
        
        <!-- Left: Image + Text Overview -->
        <div class="col-lg-6">
          <div class="row g-3 align-items-center">
            <div class="col-12 col-sm-5">
              <img src="assets/images/stethoscope-heart.jpg" alt="Health Packages" class="package-hero-img" loading="lazy">
            </div>
            <div class="col-12 col-sm-7">
              <div class="hms-eyebrow">HEALTH PACKAGES</div>
              <h2 class="hms-section-title" style="font-size: 1.85rem;">Complete Health Checkup Packages</h2>
              <p class="hms-section-desc mb-3">
                Stay ahead of health concerns with our specially curated health packages for you and your family.
              </p>
              <a href="pages/health-checkup.html" class="btn hms-btn-primary-pill">
                Explore Packages <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Right: 3 Tiered Packages -->
        <div class="col-lg-6">
          <div class="row g-3">
            
            <!-- Basic Checkup -->
            <div class="col-12 col-sm-4">
              <div class="package-card">
                <div class="package-icon-box" style="background-color: #dcfce7; color: #16a34a;">
                  <i class="bi bi-clipboard2-check"></i>
                </div>
                <div class="package-title">Basic Checkup</div>
                <div class="package-price">&#8377; 2,499</div>
                <a href="pages/health-checkup.html" class="package-link">
                  View Details <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>

            <!-- Executive Checkup -->
            <div class="col-12 col-sm-4">
              <div class="package-card">
                <div class="package-icon-box" style="background-color: #e0f2fe; color: #0284c7;">
                  <i class="bi bi-file-earmark-medical"></i>
                </div>
                <div class="package-title">Executive Checkup</div>
                <div class="package-price">&#8377; 4,999</div>
                <a href="pages/health-checkup.html" class="package-link">
                  View Details <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>

            <!-- Master Checkup -->
            <div class="col-12 col-sm-4">
              <div class="package-card">
                <div class="package-icon-box" style="background-color: #f3e8ff; color: #9333ea;">
                  <i class="bi bi-shield-check"></i>
                </div>
                <div class="package-title">Master Checkup</div>
                <div class="package-price">&#8377; 7,999</div>
                <a href="pages/health-checkup.html" class="package-link">
                  View Details <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
       6. WHY CHOOSE US SECTION
       ========================================================= -->
  <section class="hms-why-section">
    <div class="container-xl">
      <div class="row g-4 g-lg-5 align-items-center">
        
        <!-- Left Content & 4 Features -->
        <div class="col-lg-6">
          <div class="hms-eyebrow">WHY CHOOSE US</div>
          <h2 class="hms-section-title">Trusted Care, Always</h2>
          <p class="hms-section-desc">
            We are committed to delivering exceptional healthcare with integrity, compassion and excellence.
          </p>

          <div class="row g-3">
            
            <div class="col-12 col-sm-6">
              <div class="why-feature-box">
                <div class="why-icon">
                  <i class="bi bi-building"></i>
                </div>
                <div>
                  <div class="why-title">Modern Infrastructure</div>
                  <div class="why-sub">World-Class facilities</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="why-feature-box">
                <div class="why-icon">
                  <i class="bi bi-people-fill"></i>
                </div>
                <div>
                  <div class="why-title">Skilled &amp; Experienced</div>
                  <div class="why-sub">Expert care, always</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="why-feature-box">
                <div class="why-icon">
                  <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                  <div class="why-title">Affordable &amp; Transparent</div>
                  <div class="why-sub">No hidden charges</div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="why-feature-box">
                <div class="why-icon">
                  <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div>
                  <div class="why-title">Patient-Centric Approach</div>
                  <div class="why-sub">Your health, our priority</div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Right: Modern Hospital Building Photo -->
        <div class="col-lg-6">
          <img src="assets/images/hms-building.jpg" alt="HMS Hospital &amp; Medical Centre Building" class="hospital-building-img img-fluid" loading="lazy">
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
       7. OUR FACILITIES SECTION (Carousel Slider)
       ========================================================= -->
  <section class="hms-facilities-section" id="facilities">
    <div class="container-xl">
      
      <!-- Section Header with Controls -->
      <div class="row align-items-end mb-4">
        <div class="col-md-8">
          <div class="hms-eyebrow">OUR FACILITIES</div>
          <h2 class="hms-section-title mb-2">World-Class Medical Facilities</h2>
          <p class="hms-section-desc mb-0">
            Equipped with the latest technology and modern infrastructure to ensure the best care for you and your loved ones.
          </p>
        </div>
        <div class="col-md-4 d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">
          <a href="pages/departments.html" class="btn hms-btn-primary-pill me-2">
            Explore Facilities <i class="bi bi-arrow-right"></i>
          </a>
          <button type="button" class="slider-nav-btn" id="facilitiesPrevBtn" title="Previous Facility">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button type="button" class="slider-nav-btn" id="facilitiesNextBtn" title="Next Facility">
            <i class="bi bi-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Facility Cards Carousel Container -->
      <div class="row g-3" id="facilitiesRow">
        
        <!-- Facility 1: ICU & Critical Care -->
        <div class="col-6 col-md-3">
          <div class="facility-card">
            <div class="facility-img-wrap">
              <img src="assets/images/facilities/icu.jpg" alt="ICU &amp; Critical Care" loading="lazy">
            </div>
            <div class="facility-title">ICU &amp; Critical Care</div>
          </div>
        </div>

        <!-- Facility 2: Operation Theatres -->
        <div class="col-6 col-md-3">
          <div class="facility-card">
            <div class="facility-img-wrap">
              <img src="assets/images/facilities/ot.jpg" alt="Operation Theatres" loading="lazy">
            </div>
            <div class="facility-title">Operation Theatres</div>
          </div>
        </div>

        <!-- Facility 3: Diagnostic Labs -->
        <div class="col-6 col-md-3">
          <div class="facility-card">
            <div class="facility-img-wrap">
              <img src="assets/images/facilities/lab.jpg" alt="Diagnostic Labs" loading="lazy">
            </div>
            <div class="facility-title">Diagnostic Labs</div>
          </div>
        </div>

        <!-- Facility 4: Pharmacy -->
        <div class="col-6 col-md-3">
          <div class="facility-card">
            <div class="facility-img-wrap">
              <img src="assets/images/facilities/pharmacy.jpg" alt="Pharmacy" loading="lazy">
            </div>
            <div class="facility-title">Pharmacy</div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================
       8. PATIENT TESTIMONIALS SECTION
       ========================================================= -->
  <section class="hms-testimonials-section" id="testimonials">
    <div class="container-xl">
      
      <!-- Section Header with Controls -->
      <div class="row align-items-end mb-4">
        <div class="col-md-8">
          <div class="hms-eyebrow">PATIENT TESTIMONIALS</div>
          <h2 class="hms-section-title mb-2">What Our Patients Say</h2>
          <p class="hms-section-desc mb-0">
            Real stories. Genuine care. Hear from our patients about their experiences with HMS.
          </p>
        </div>
        <div class="col-md-4 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
          <button type="button" class="slider-nav-btn" id="testimonialsPrevBtn" title="Previous Testimonial">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button type="button" class="slider-nav-btn" id="testimonialsNextBtn" title="Next Testimonial">
            <i class="bi bi-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Testimonial Cards -->
      <div class="row g-3" id="testimonialsRow">
        
        <!-- Review 1: Sneha R. -->
        <div class="col-12 col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-quote">
              "The doctors and staff are very supportive. I felt well taken care of throughout my treatment."
            </div>
            <div class="testimonial-author-row">
              <div class="d-flex align-items-center gap-2">
                <img src="assets/images/avatars/testimonial-sneha.jpg" alt="Sneha R." class="testimonial-avatar" loading="lazy">
                <div class="testimonial-name">- Sneha R.</div>
              </div>
              <div class="testimonial-rating">
                <i class="bi bi-star-fill"></i> 5.0
              </div>
            </div>
          </div>
        </div>

        <!-- Review 2: Rahul K. -->
        <div class="col-12 col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-quote">
              "Excellent service and modern facilities. Highly recommended!"
            </div>
            <div class="testimonial-author-row">
              <div class="d-flex align-items-center gap-2">
                <img src="assets/images/avatars/testimonial-rahul.jpg" alt="Rahul K." class="testimonial-avatar" loading="lazy">
                <div class="testimonial-name">- Rahul K.</div>
              </div>
              <div class="testimonial-rating">
                <i class="bi bi-star-fill"></i> 4.8
              </div>
            </div>
          </div>
        </div>

        <!-- Review 3: Priya S. -->
        <div class="col-12 col-md-4">
          <div class="testimonial-card">
            <div class="testimonial-quote">
              "Very professional and caring team. Grateful for the amazing care I received."
            </div>
            <div class="testimonial-author-row">
              <div class="d-flex align-items-center gap-2">
                <img src="assets/images/avatars/testimonial-priya.jpg" alt="Priya S." class="testimonial-avatar" loading="lazy">
                <div class="testimonial-name">- Priya S.</div>
              </div>
              <div class="testimonial-rating">
                <i class="bi bi-star-fill"></i> 4.9
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================
       9. CALL TO ACTION BANNER (Book Your Appointment Today)
       ========================================================= -->
  <section class="hms-cta-section">
    <div class="container-xl">
      <div class="row align-items-center justify-content-between g-4">
        <div class="col-lg-8">
          <div class="hms-cta-script">Your Health Matters</div>
          <h2 class="hms-cta-heading">Book Your Appointment Today</h2>
          <p class="hms-cta-desc mb-0">
            Take the first step towards a healthier tomorrow. Our team is here to help you.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="pages/appointments.html" class="btn hms-btn-primary-pill" style="font-size: 1rem; padding: 0.85rem 2.2rem;">
            Book Appointment <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
       10. MAIN FOOTER
       ========================================================= -->
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
            Compassionate Care, Advanced Healthcare.
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="col-6 col-md-2 col-lg-2">
          <div class="hms-footer-heading">Quick Links</div>
          <ul class="hms-footer-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="pages/departments.html">Departments</a></li>
            <li><a href="pages/doctors.html">Doctors</a></li>
            <li><a href="pages/health-checkup.html">Health Packages</a></li>
          </ul>
        </div>

        <!-- Column 3: More Links -->
        <div class="col-6 col-md-2 col-lg-2">
          <div class="hms-footer-heading" style="opacity: 0;">More</div>
          <ul class="hms-footer-links">
            <li><a href="#aboutHospitalModal" data-bs-toggle="modal">About Us</a></li>
            <li><a href="#contactModal" data-bs-toggle="modal">Contact</a></li>
            <li><a href="login.html">Staff Portal</a></li>
            <li><a href="pages/appointments.html">Appointments</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact Us -->
        <div class="col-12 col-md-4 col-lg-3">
          <div class="hms-footer-heading">Contact Us</div>
          <div class="hms-contact-item">
            <i class="bi bi-telephone-fill"></i>
            <div>+91 98765 43210</div>
          </div>
          <div class="hms-contact-item">
            <i class="bi bi-envelope-fill"></i>
            <div>info@hmshospital.com</div>
          </div>
          <div class="hms-contact-item">
            <i class="bi bi-geo-alt-fill"></i>
            <div>742 Healthcare Ave, Medical District, Bangalore - 560001</div>
          </div>
        </div>

        <!-- Column 5: Follow Us -->
        <div class="col-12 col-lg-2">
          <div class="hms-footer-heading">Follow Us</div>
          <div class="d-flex align-items-center">
            <a href="javascript:void(0)" class="hms-social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="javascript:void(0)" class="hms-social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between hms-footer-bottom gap-2">
        <div>
          &copy; 2025 HMS Hospital &amp; Medical Centre. All rights reserved.
        </div>
        <div>
          <a href="javascript:void(0)" class="text-secondary text-decoration-none me-3">Privacy Policy</a>
          <span>|</span>
          <a href="javascript:void(0)" class="text-secondary text-decoration-none ms-3">Terms &amp; Conditions</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- =========================================================
       MODALS: SEARCH, ABOUT US, CONTACT US
       ========================================================= -->

  <!-- 1. SEARCH MODAL -->
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
            <a href="pages/doctors.html?search=Cardiology" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Cardiology</a>
            <a href="pages/doctors.html?search=Neurology" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Neurology</a>
            <a href="pages/doctors.html?search=Dr.%20Ananya" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Dr. Ananya Sharma</a>
            <a href="pages/doctors.html?search=Dr.%20Arjun" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Dr. Arjun Nair</a>
            <a href="pages/health-checkup.html" class="badge bg-light text-dark text-decoration-none border px-2 py-1">Full Body Checkup</a>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn hms-btn-primary-pill px-4" onclick="handleSearchRedirect()">Search</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. ABOUT US MODAL -->
  <div class="modal fade" id="aboutHospitalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-hospital text-primary me-2"></i> About HMS Hospital &amp; Medical Centre
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body small p-4">
          <p class="text-secondary mb-3">
            HMS Hospital &amp; Medical Centre is a state-of-the-art multi-specialty clinical facility dedicated to delivering compassionate, evidence-based healthcare. Our center houses 500+ patient beds, 12 advanced modular operation theaters, and 24/7 Level 1 emergency trauma care.
          </p>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
            <li><i class="bi bi-check-circle-fill text-success me-2"></i> JCI and NABH Accredited Healthcare Facility</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Modern Diagnostic Laboratory &amp; Advanced 3T MRI Imaging</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i> 24/7 Level 1 Trauma Care &amp; Intensive Care Units</li>
            <li><i class="bi bi-check-circle-fill text-success me-2"></i> 50+ Specialized Doctors across 15 Departments</li>
          </ul>
        </div>
        <div class="modal-footer border-top-0">
          <button type="button" class="btn hms-btn-primary-pill btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. CONTACT US MODAL -->
  <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-telephone-inbound text-primary me-2"></i> Contact Hospital Helpdesk
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body small p-4">
          <div class="mb-3">
            <strong>Address:</strong> 742 Healthcare Ave, Medical District, Bangalore - 560001
          </div>
          <div class="mb-3">
            <strong>Emergency Hotline:</strong> <span class="text-danger fw-bold">+91 98765 43210</span> (24/7 Toll-Free)
          </div>
          <div class="mb-3">
            <strong>Appointments Desk:</strong> +91 (80) 4567-8900 (Mon - Sat: 08:00 AM - 08:00 PM)
          </div>
          <div class="mb-0">
            <strong>Official Email:</strong> info@hmshospital.com
          </div>
        </div>
        <div class="modal-footer border-top-0">
          <button type="button" class="btn hms-btn-primary-pill btn-sm" data-bs-dismiss="modal">Understood</button>
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
      if (window.scrollY > 30) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

    // Search redirect handler
    function handleSearchRedirect() {
      const query = document.getElementById('globalSearchInput').value.trim();
      if (query) {
        window.location.href = `pages/doctors.html?search=${encodeURIComponent(query)}`;
      }
    }

    document.getElementById('globalSearchInput')?.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        handleSearchRedirect();
      }
    });

    // Facilities Slider controls (Simple interactive slide shift)
    const facilitiesRow = document.getElementById('facilitiesRow');
    const facilitiesPrevBtn = document.getElementById('facilitiesPrevBtn');
    const facilitiesNextBtn = document.getElementById('facilitiesNextBtn');

    if (facilitiesNextBtn && facilitiesPrevBtn && facilitiesRow) {
      facilitiesNextBtn.addEventListener('click', () => {
        // Rotate cards smoothly
        const firstChild = facilitiesRow.children[0];
        facilitiesRow.appendChild(firstChild);
      });
      facilitiesPrevBtn.addEventListener('click', () => {
        const lastChild = facilitiesRow.children[facilitiesRow.children.length - 1];
        facilitiesRow.insertBefore(lastChild, facilitiesRow.children[0]);
      });
    }

    // Testimonials Slider controls
    const testimonialsRow = document.getElementById('testimonialsRow');
    const testimonialsPrevBtn = document.getElementById('testimonialsPrevBtn');
    const testimonialsNextBtn = document.getElementById('testimonialsNextBtn');

    if (testimonialsNextBtn && testimonialsPrevBtn && testimonialsRow) {
      testimonialsNextBtn.addEventListener('click', () => {
        const firstChild = testimonialsRow.children[0];
        testimonialsRow.appendChild(firstChild);
      });
      testimonialsPrevBtn.addEventListener('click', () => {
        const lastChild = testimonialsRow.children[testimonialsRow.children.length - 1];
        testimonialsRow.insertBefore(lastChild, testimonialsRow.children[0]);
      });
    }
  </script>
</body>
</html>
