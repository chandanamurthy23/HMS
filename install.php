<?php
/**
 * Hospital Management System (HMS) - Database Installer & Seeder
 */
require_once __DIR__ . '/config/config.php';

$message = '';
$status = 'info';

if ((isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') || php_sapi_name() === 'cli' || isset($_GET['auto'])) {
    try {
        $adminHash = password_hash('admin123', PASSWORD_BCRYPT);
        // Try MySQL first
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `" . DB_NAME . "`");

            $sql = file_get_contents(__DIR__ . '/database.sql');
            // Split SQL by semicolon and execute statement by statement
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $stmt) {
                if (!empty($stmt)) {
                    $pdo->exec($stmt);
                }
            }
            $message = "MySQL Database (`" . DB_NAME . "`) successfully initialized with all tables and seed data!";
            $status = 'success';
        } catch (Exception $myEx) {
            $mysqlErrorMsg = $myEx->getMessage();
            // MySQL error or offline, fallback to SQLite
            $sqlitePath = SQLITE_DB_PATH;
            $sqlitePdo = new PDO("sqlite:" . $sqlitePath, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            // Create SQLite tables
            $sqlitePdo->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    role TEXT DEFAULT 'patient',
                    phone TEXT,
                    avatar TEXT DEFAULT 'assets/images/avatars/admin.jpg',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS departments (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    slug TEXT NOT NULL UNIQUE,
                    icon TEXT NOT NULL,
                    color TEXT DEFAULT '#0284c7',
                    bg_color TEXT DEFAULT '#e0f2fe',
                    subtitle TEXT NOT NULL,
                    description TEXT,
                    status INTEGER DEFAULT 1
                );

                CREATE TABLE IF NOT EXISTS doctors (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    department_id INTEGER,
                    specialty TEXT NOT NULL,
                    qualification TEXT DEFAULT 'MBBS, MD',
                    experience TEXT DEFAULT '10+ years',
                    rating REAL DEFAULT 4.9,
                    reviews_count INTEGER DEFAULT 120,
                    fee REAL DEFAULT 800.00,
                    image TEXT NOT NULL,
                    email TEXT,
                    phone TEXT,
                    available_days TEXT DEFAULT 'Mon - Sat',
                    available_time TEXT DEFAULT '09:00 AM - 05:00 PM',
                    bio TEXT,
                    status INTEGER DEFAULT 1
                );

                CREATE TABLE IF NOT EXISTS health_packages (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    slug TEXT NOT NULL,
                    price REAL NOT NULL,
                    icon TEXT NOT NULL,
                    color TEXT DEFAULT '#0284c7',
                    bg_color TEXT DEFAULT '#e0f2fe',
                    tests_count INTEGER DEFAULT 15,
                    features TEXT,
                    status INTEGER DEFAULT 1
                );

                CREATE TABLE IF NOT EXISTS appointments (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    appointment_no TEXT NOT NULL UNIQUE,
                    patient_name TEXT NOT NULL,
                    patient_email TEXT NOT NULL,
                    patient_phone TEXT NOT NULL,
                    patient_gender TEXT DEFAULT 'Male',
                    patient_age INTEGER,
                    doctor_id INTEGER,
                    department_id INTEGER,
                    appointment_date DATE NOT NULL,
                    appointment_time TEXT NOT NULL,
                    reason TEXT,
                    status TEXT DEFAULT 'Confirmed',
                    payment_status TEXT DEFAULT 'Paid',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS facilities (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    image TEXT NOT NULL,
                    description TEXT,
                    status INTEGER DEFAULT 1
                );

                CREATE TABLE IF NOT EXISTS reviews (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    patient_name TEXT NOT NULL,
                    rating REAL DEFAULT 5.0,
                    comment TEXT NOT NULL,
                    avatar TEXT DEFAULT 'assets/images/avatars/patient.jpg',
                    doctor_id INTEGER,
                    status TEXT DEFAULT 'approved',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS contact_messages (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT NOT NULL,
                    phone TEXT,
                    subject TEXT NOT NULL,
                    message TEXT NOT NULL,
                    status TEXT DEFAULT 'unread',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS payments (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    appointment_id INTEGER,
                    transaction_no TEXT NOT NULL UNIQUE,
                    amount REAL NOT NULL,
                    payment_method TEXT DEFAULT 'Online / Card',
                    status TEXT DEFAULT 'Success',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );
            ");

            // Seed SQLite
            $sqlitePdo->exec("
                INSERT OR IGNORE INTO users (id, name, email, password, role, phone) VALUES
                (1, 'Hospital Administrator', 'admin@hms.com', '" . $adminHash . "', 'admin', '+91 98765 43210');

                INSERT OR IGNORE INTO departments (id, name, slug, icon, color, bg_color, subtitle, description) VALUES
                (1, 'Cardiology', 'cardiology', 'bi-heart-pulse-fill', '#ef4444', '#fee2e2', 'Heart Care & Treatment', 'Comprehensive cardiovascular diagnostics, interventions, and rehabilitation services.'),
                (2, 'Neurology', 'neurology', 'bi-cpu-fill', '#0284c7', '#e0f2fe', 'Brain & Nerve Care', 'Advanced neurological diagnosis, neuro-rehab, and specialized neurosurgical solutions.'),
                (3, 'Orthopedics', 'orthopedics', 'bi-bandaid-fill', '#16a34a', '#dcfce7', 'Bone & Joint Care', 'Specialized arthroscopy, joint replacements, trauma orthopedic surgery, and sports medicine.'),
                (4, 'Pediatrics', 'pediatrics', 'bi-emoji-smile-fill', '#9333ea', '#f3e8ff', 'Child Health & Wellness', 'Dedicated pediatric care from newborn intensive care to adolescent wellness programs.'),
                (5, 'Gynecology', 'gynecology', 'bi-gender-female', '#e11d48', '#ffe4e6', 'Women''s Health', 'Complete maternal care, fertility counseling, gynecologic wellness, and minimally invasive surgery.'),
                (6, 'Dermatology', 'dermatology', 'bi-shield-plus', '#ea580c', '#ffedd5', 'Skin & Hair Care', 'Evidence-based dermatology, clinical laser solutions, and dermatological surgery.'),
                (7, 'Gastroenterology', 'gastroenterology', 'bi-capsule', '#0891b2', '#cffafe', 'Digestive Health', 'Advanced endoscopic procedures, liver wellness clinics, and gastrointestinal therapeutics.'),
                (8, 'General Medicine', 'general-medicine', 'bi-heart-pulse', '#4338ca', '#e0e7ff', 'Overall Wellness', 'Holistic preventive healthcare, internal medicine diagnosis, and chronic condition management.');

                INSERT OR IGNORE INTO doctors (id, name, department_id, specialty, qualification, experience, rating, reviews_count, fee, image, email, available_days, available_time, bio) VALUES
                (1, 'Dr. Ananya Sharma', 1, 'Cardiologist', 'MBBS, MD (Cardiology)', '15+ years experience', 4.9, 120, 1000.00, 'assets/images/doctors/dr-ananya.jpg', 'ananya.sharma@hmshospital.com', 'Mon - Fri', '09:00 AM - 03:00 PM', 'Senior Consultant Cardiologist specializing in preventive cardiology and interventions.'),
                (2, 'Dr. Rohan Mehta', 2, 'Neurologist', 'MBBS, DM (Neurology)', '12+ years experience', 4.7, 98, 900.00, 'assets/images/doctors/dr-rohan.jpg', 'rohan.mehta@hmshospital.com', 'Mon - Sat', '10:00 AM - 04:00 PM', 'Specialist in stroke intervention, epilepsy management, and neurological diagnosis.'),
                (3, 'Dr. Sneha Iyer', 4, 'Pediatrician', 'MBBS, MD (Pediatrics)', '10+ years experience', 4.9, 142, 750.00, 'assets/images/doctors/dr-sneha.jpg', 'sneha.iyer@hmshospital.com', 'Mon - Sat', '08:30 AM - 02:30 PM', 'Pediatrician with deep clinical focus on child wellness and preventive care.'),
                (4, 'Dr. Arjun Nair', 3, 'Orthopedic Surgeon', 'MBBS, MS (Ortho)', '14+ years experience', 4.8, 110, 950.00, 'assets/images/doctors/dr-arjun.jpg', 'arjun.nair@hmshospital.com', 'Tue - Sun', '10:00 AM - 05:00 PM', 'Expert orthopedic surgeon specializing in joint replacements and sports medicine.');

                INSERT OR IGNORE INTO health_packages (id, title, slug, price, icon, color, bg_color, tests_count, features) VALUES
                (1, 'Basic Checkup', 'basic-checkup', 2499.00, 'bi-clipboard2-check', '#16a34a', '#dcfce7', 18, 'CBC, Fasting Blood Sugar, Lipid Profile, Liver Test, ECG, Doctor Consultation'),
                (2, 'Executive Checkup', 'executive-checkup', 4999.00, 'bi-file-earmark-medical', '#0284c7', '#e0f2fe', 36, 'All Basic Tests, Thyroid Profile, Kidney Test, Chest X-Ray, Ultrasound, Specialist Consultation'),
                (3, 'Master Checkup', 'master-checkup', 7999.00, 'bi-shield-check', '#9333ea', '#f3e8ff', 58, 'All Executive Tests, 2D Echo, Vitamin D & B12, Bone Density, Nutrition Consultation');

                INSERT OR IGNORE INTO facilities (id, name, image, description) VALUES
                (1, 'ICU & Critical Care', 'assets/images/facilities/icu.jpg', '24/7 high-dependency intensive care equipped with digital monitoring and ventilators.'),
                (2, 'Operation Theatres', 'assets/images/facilities/ot.jpg', 'Laminar air flow sterile surgical suites with laparoscopic imaging.'),
                (3, 'Diagnostic Labs', 'assets/images/facilities/lab.jpg', 'Automated diagnostic pathology and rapid turnaround times.'),
                (4, 'Pharmacy', 'assets/images/facilities/pharmacy.jpg', 'Fully stocked 24/7 in-house pharmacy.');

                INSERT OR IGNORE INTO reviews (id, patient_name, rating, comment, avatar, doctor_id, status) VALUES
                (1, 'Sneha R.', 5.0, 'The doctors and staff are very supportive. I felt well taken care of throughout my treatment.', 'assets/images/avatars/testimonial-sneha.jpg', 1, 'approved'),
                (2, 'Rahul K.', 4.8, 'Excellent service and modern facilities. Highly recommended!', 'assets/images/avatars/testimonial-rahul.jpg', 2, 'approved'),
                (3, 'Priya S.', 4.9, 'Very professional and caring team. Grateful for the amazing care I received.', 'assets/images/avatars/testimonial-priya.jpg', 4, 'approved');

                INSERT OR IGNORE INTO appointments (id, appointment_no, patient_name, patient_email, patient_phone, doctor_id, department_id, appointment_date, appointment_time, reason, status) VALUES
                (1, 'HMS-2025-0101', 'Vikram Singh', 'vikram.s@gmail.com', '+91 98450 11223', 1, 1, DATE('now'), '10:00 AM', 'Routine cardiac health follow-up', 'Confirmed');
            ");

            // Execute RBAC Schema & Roles Seeder
            require_once __DIR__ . '/migrations/schema_rbac.php';
            runRBACMigration();

            $message = "Database successfully initialized with SQLite fallback & full RBAC architecture!";
            $status = 'success';
        }
    } catch (Exception $e) {
        $message = "Database Setup Error: " . $e->getMessage();
        $status = 'danger';
    }

    if (php_sapi_name() === 'cli') {
        echo $message . (isset($mysqlErrorMsg) ? " (MySQL Info: $mysqlErrorMsg)" : "") . PHP_EOL;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HMS Database Installer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f1f5f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .install-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 2.5rem;
      max-width: 540px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
      border: 1px solid #e2e8f0;
    }
    .brand-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: #e0f2fe;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0284c7;
      margin: 0 auto 1.25rem;
    }
  </style>
</head>
<body>
  <div class="install-card text-center">
    <div class="brand-icon">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#0284c7"/>
        <path d="M11 7h2v3h3v2h-3v3h-2v-3H8v-2h3V7z" fill="#ffffff"/>
      </svg>
    </div>
    <h3 class="fw-bold text-dark mb-1">HMS Database Setup</h3>
    <p class="text-muted small mb-4">Initialize tables, departments, reference doctors, and admin portal account.</p>

    <?php if ($message): ?>
      <div class="alert alert-<?= $status ?> text-start small mb-4 rounded-3 shadow-sm">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill mb-3" style="background-color: #0a355c; border-color: #0a355c;">
        <i class="bi bi-database-check me-2"></i> Run Setup &amp; Seed Database
      </button>
    </form>

    <div class="d-flex justify-content-center gap-3 mt-3">
      <a href="index.php" class="small text-decoration-none text-primary fw-semibold">&larr; Go to Homepage</a>
      <span class="text-muted small">&bull;</span>
      <a href="admin/login.php" class="small text-decoration-none text-secondary fw-semibold">Admin Login &rarr;</a>
    </div>

    <div class="bg-light p-3 rounded-3 mt-4 text-start small text-muted">
      <strong>Default Admin Credentials:</strong><br>
      Email: <code>admin@hms.com</code><br>
      Password: <code>admin123</code>
    </div>
  </div>
</body>
</html>
