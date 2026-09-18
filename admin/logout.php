<?php
/**
 * Hospital Management System (HMS) - Admin Logout Handler
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

logoutUser();
setFlash('success', 'You have been successfully logged out.');
redirect(SITE_URL . '/admin/login.php');
