<?php
/**
 * Hospital Management System (HMS) - Site Header Component
 */
require_once __DIR__ . '/functions.php';

$pageTitle = isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <!-- Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts: Plus Jakarta Sans, Outfit, DM Serif Display, Caveat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=DM+Serif+Display:ital@0;1&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- HMS Full Stylesheet matching reference design -->
  <link rel="stylesheet" href="assets/css/style.css">

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

    html, body {
      overflow-x: hidden;
      max-width: 100vw;
      width: 100%;
    }

    body {
      font-family: var(--hms-font-sans);
      color: var(--hms-text-dark);
      background-color: #ffffff;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--hms-font-heading);
      letter-spacing: -0.02em;
    }

    .hms-eyebrow {
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--hms-teal-accent);
      margin-bottom: 0.75rem;
      display: inline-block;
    }

    /* Buttons */
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

    /* Header Component */
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

    /* Footer Component */
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

    /* Page Hero Banner for Inner Pages */
    .inner-page-banner {
      background: linear-gradient(180deg, #edf5fc 0%, #f6faff 60%, #ffffff 100%);
      padding: 3.5rem 0 2.5rem;
      border-bottom: 1px solid #f1f5f9;
    }

    /* Responsive adjustments */
    @media (max-width: 575.98px) {
      .hms-brand-icon {
        width: 34px;
        height: 34px;
      }
      .hms-brand-name {
        font-size: 1.25rem;
      }
      .hms-btn-outline-pill {
        padding: 0.38rem 0.85rem;
        font-size: 0.82rem;
      }
      .hms-search-trigger {
        width: 32px;
        height: 32px;
      }
    }
  </style>
</head>
<body>
