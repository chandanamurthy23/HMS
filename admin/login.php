<?php
/**
 * Hospital Management System (HMS) - Admin Login Page
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if (isAdmin()) {
    redirect(SITE_URL . '/admin/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Check password via password_verify or fallback default credentials for admin
        $authenticated = false;
        if ($user) {
            if (password_verify($password, $user['password']) || ($email === 'admin@hms.com' && $password === 'admin123')) {
                // Refresh password hash if needed
                if (!password_verify($password, $user['password'])) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $upStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $upStmt->execute([$newHash, $user['id']]);
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_avatar'] = $user['avatar'] ?? 'assets/images/avatars/admin.jpg';
                $authenticated = true;
            }
        }

        if ($authenticated) {
            setFlash('success', 'Welcome back, ' . htmlspecialchars($_SESSION['user_name']) . '!');
            redirect(SITE_URL . '/admin/index.php');
        } else {
            $error = 'Invalid email address or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - HMS Hospital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: radial-gradient(circle at top right, #0a355c 0%, #071728 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .login-card {
      background: #ffffff;
      border-radius: 1.5rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
      overflow: hidden;
      width: 100%;
      max-width: 440px;
    }
    .login-header {
      background: #f8fafc;
      border-bottom: 1px solid #edf2f7;
      padding: 2.5rem 2rem 2rem;
      text-align: center;
    }
    .brand-icon {
      width: 56px;
      height: 56px;
      background: #0a355c;
      border-radius: 1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-header">
      <div class="brand-icon shadow-sm">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
          <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
        </svg>
      </div>
      <h4 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif; color: #0a355c;">HMS Hospital Portal</h4>
      <p class="text-muted small mb-0">Management &amp; Clinical Administration</p>
    </div>

    <div class="p-4 p-md-5">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
          <div><?= htmlspecialchars($error) ?></div>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control bg-light border-start-0 py-2" id="email" name="email" value="admin@hms.com" required autocomplete="email">
          </div>
        </div>

        <div class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label fw-semibold small text-muted mb-0">Password</label>
            <span class="text-muted small">Default: <strong>admin123</strong></span>
          </div>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
            <input type="password" class="form-control bg-light border-start-0 py-2" id="password" name="password" value="admin123" required autocomplete="current-password">
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: #0a355c; border-color: #0a355c;">
          <i class="bi bi-box-arrow-in-right me-2"></i> Log In to Dashboard
        </button>
      </form>

      <div class="mt-4 pt-3 border-top text-center">
        <a href="../index.php" class="text-decoration-none text-muted small">
          <i class="bi bi-arrow-left me-1"></i> Return to Public Website
        </a>
      </div>
    </div>
  </div>

</body>
</html>
