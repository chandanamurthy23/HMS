<?php
/**
 * Hospital Management System (HMS) - Common Helper Functions
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Sanitize user inputs
function sanitize($input): string {
    if (is_array($input)) {
        return '';
    }
    return htmlspecialchars(trim((string)$input), ENT_QUOTES, 'UTF-8');
}

// Redirect helper
function redirect(string $url): void {
    header("Location: " . $url);
    exit;
}

// Flash messaging
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function displayFlash(): void {
    $flash = getFlash();
    if ($flash) {
        $alertClass = match($flash['type']) {
            'error', 'danger' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
            default => 'alert-success',
        };
        echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show mb-4 rounded-3 shadow-sm small" role="alert">
            ' . htmlspecialchars($flash['message']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

// Generate unique appointment number (e.g. HMS-2025-4821)
function generateAppointmentNo(): string {
    return 'HMS-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
}

// Currency formatter
function formatINR($amount): string {
    return '₹ ' . number_format((float)$amount, 0);
}

// Check if user is logged in
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Check if current user is admin
function isAdmin(): bool {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Require admin authentication
function requireAdmin(): void {
    if (!isAdmin()) {
        setFlash('error', 'Please log in to access the management portal.');
        redirect(SITE_URL . '/admin/login.php');
    }
}
