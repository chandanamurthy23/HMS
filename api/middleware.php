<?php
/**
 * Hospital Management System (HMS) - RBAC & Authentication Middleware
 * Validates user sessions and enforces granular permissions on all protected APIs.
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Uniform JSON Response Helper
function jsonResponse(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    echo json_encode($data);
    exit;
}

// Fetch Currently Authenticated User with Role and Granular Permissions
function getAuthenticatedUser(): ?array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        return null;
    }

    $db = getDB();

    try {
        $stmt = $db->prepare("SELECT u.id, u.name, u.email, u.phone, u.role, u.role_id, u.status, u.department_id, u.avatar, u.created_at, u.last_login 
                              FROM users u 
                              WHERE u.id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        // Deactivated users must be blocked immediately
        if (isset($user['status']) && strtolower($user['status']) !== 'active') {
            $_SESSION = [];
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
            return null;
        }

        // Determine Role ID and Slug
        $roleSlug = strtolower(trim((string)$user['role']));
        $roleId = $user['role_id'];

        if (!$roleId) {
            $rStmt = $db->prepare("SELECT id, slug, name FROM roles WHERE slug = ? OR LOWER(name) = ? LIMIT 1");
            $rStmt->execute([$roleSlug, $roleSlug]);
            $rRow = $rStmt->fetch(PDO::FETCH_ASSOC);
            if ($rRow) {
                $roleId = (int)$rRow['id'];
                $roleSlug = $rRow['slug'];
                // Backfill role_id
                $up = $db->prepare("UPDATE users SET role_id = ? WHERE id = ?");
                $up->execute([$roleId, $user['id']]);
            }
        }

        $user['role_slug'] = $roleSlug;
        $user['is_super_admin'] = in_array($roleSlug, ['super_admin', 'super admin', 'superadmin']);

        // Load permissions assigned to role
        $permissions = [];
        if ($user['is_super_admin']) {
            // Super Admin has all system permissions
            $allPerms = $db->query("SELECT code FROM permissions")->fetchAll(PDO::FETCH_COLUMN);
            $permissions = $allPerms ?: [];
        } elseif ($roleId) {
            $pStmt = $db->prepare("SELECT p.code 
                                   FROM role_permissions rp 
                                   JOIN permissions p ON rp.permission_id = p.id 
                                   WHERE rp.role_id = ?");
            $pStmt->execute([$roleId]);
            $permissions = $pStmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
        }

        $user['permissions'] = $permissions;
        return $user;
    } catch (Exception $e) {
        error_log("RBAC getAuthenticatedUser error: " . $e->getMessage());
        return null;
    }
}

// Enforce Login Required
function requireAuth(): array {
    $user = getAuthenticatedUser();
    if (!$user) {
        jsonResponse([
            'success' => false,
            'message' => 'Authentication required. Your session may have expired or your account has been deactivated.',
            'code'    => 'UNAUTHENTICATED'
        ], 401);
    }
    return $user;
}

// Enforce Granular Permission Check
function requirePermission(string ...$requiredPermissions): array {
    $user = requireAuth();

    // Super Admin bypasses all checks
    if (!empty($user['is_super_admin'])) {
        return $user;
    }

    $userPerms = $user['permissions'] ?? [];

    // Check if user has at least one of the required permissions
    $hasPermission = false;
    foreach ($requiredPermissions as $perm) {
        if (in_array($perm, $userPerms, true)) {
            $hasPermission = true;
            break;
        }
    }

    if (!$hasPermission) {
        jsonResponse([
            'success'  => false,
            'message'  => 'Access Denied: You do not possess the required permission (' . implode(', ', $requiredPermissions) . ') for this operation.',
            'required' => $requiredPermissions,
            'code'     => 'FORBIDDEN'
        ], 403);
    }

    return $user;
}

// Enforce Specific Role Check
function requireRole(string ...$allowedRoles): array {
    $user = requireAuth();

    if (!empty($user['is_super_admin'])) {
        return $user;
    }

    $slug = $user['role_slug'] ?? '';
    if (!in_array($slug, $allowedRoles, true)) {
        jsonResponse([
            'success' => false,
            'message' => 'Access Denied: This resource is restricted to roles: ' . implode(', ', $allowedRoles),
            'code'    => 'ROLE_RESTRICTED'
        ], 403);
    }

    return $user;
}
