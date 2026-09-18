<?php
/**
 * Hospital Management System (HMS) - Database Migration & RBAC Seeder
 * Compatible with both MySQL and SQLite drivers.
 */

require_once __DIR__ . '/../config/db.php';

function runRBACMigration(): array {
    $db = getDB();
    $driver = Database::getDriver();
    $logs = [];

    $isSqlite = ($driver === 'sqlite');

    // 1. Create ROLES Table
    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS roles (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            description TEXT,
            is_system INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) NOT NULL UNIQUE,
            description TEXT,
            is_system TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $logs[] = "Table 'roles' checked/created.";

    // 2. Create PERMISSIONS Table
    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS permissions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code TEXT NOT NULL UNIQUE,
            name TEXT NOT NULL,
            module TEXT NOT NULL,
            description TEXT
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(100) NOT NULL UNIQUE,
            name VARCHAR(150) NOT NULL,
            module VARCHAR(100) NOT NULL,
            description TEXT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $logs[] = "Table 'permissions' checked/created.";

    // 3. Create ROLE_PERMISSIONS Table
    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS role_permissions (
            role_id INTEGER NOT NULL,
            permission_id INTEGER NOT NULL,
            PRIMARY KEY (role_id, permission_id)
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS role_permissions (
            role_id INT NOT NULL,
            permission_id INT NOT NULL,
            PRIMARY KEY (role_id, permission_id),
            FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
            FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $logs[] = "Table 'role_permissions' checked/created.";

    // 4. Create BILLABLE_ITEMS Table (Prices)
    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS billable_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            item_type TEXT NOT NULL,
            category TEXT NOT NULL,
            code TEXT NOT NULL UNIQUE,
            name TEXT NOT NULL,
            unit_price REAL NOT NULL,
            department_id INTEGER DEFAULT NULL,
            status INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS billable_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            item_type ENUM('service', 'test', 'medicine', 'other') DEFAULT 'service',
            category VARCHAR(100) NOT NULL,
            code VARCHAR(50) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            unit_price DECIMAL(10,2) NOT NULL,
            department_id INT DEFAULT NULL,
            status TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $logs[] = "Table 'billable_items' checked/created.";

    // 5. Create REVENUE_TRANSACTIONS Table
    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS revenue_transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            bill_no TEXT NOT NULL,
            patient_name TEXT NOT NULL,
            department TEXT NOT NULL,
            medical_department TEXT,
            item_name TEXT NOT NULL,
            amount REAL NOT NULL,
            payment_method TEXT DEFAULT 'Cash / Card',
            status TEXT DEFAULT 'Completed',
            transaction_date DATE NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS revenue_transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            bill_no VARCHAR(50) NOT NULL,
            patient_name VARCHAR(100) NOT NULL,
            department VARCHAR(100) NOT NULL,
            medical_department VARCHAR(100),
            item_name VARCHAR(255) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            payment_method VARCHAR(50) DEFAULT 'Cash / Card',
            status VARCHAR(30) DEFAULT 'Completed',
            transaction_date DATE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    $logs[] = "Table 'revenue_transactions' checked/created.";

    // 6. Ensure USERS Table has status, role_id, department_id, last_login
    $userCols = [];
    if ($isSqlite) {
        $colStmt = $db->query("PRAGMA table_info(users)");
        while ($row = $colStmt->fetch()) {
            $userCols[] = strtolower($row['name']);
        }
        if (!in_array('status', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN status TEXT DEFAULT 'active'");
            $logs[] = "Added 'status' to users table.";
        }
        if (!in_array('role_id', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN role_id INTEGER DEFAULT NULL");
            $logs[] = "Added 'role_id' to users table.";
        }
        if (!in_array('department_id', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN department_id INTEGER DEFAULT NULL");
            $logs[] = "Added 'department_id' to users table.";
        }
        if (!in_array('last_login', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN last_login DATETIME DEFAULT NULL");
            $logs[] = "Added 'last_login' to users table.";
        }
    } else {
        $colStmt = $db->query("SHOW COLUMNS FROM users");
        while ($row = $colStmt->fetch()) {
            $userCols[] = strtolower($row['Field']);
        }
        if (!in_array('status', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT 'active'");
            $logs[] = "Added 'status' to users table.";
        }
        if (!in_array('role_id', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN role_id INT DEFAULT NULL");
            $logs[] = "Added 'role_id' to users table.";
        }
        if (!in_array('department_id', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN department_id INT DEFAULT NULL");
            $logs[] = "Added 'department_id' to users table.";
        }
        if (!in_array('last_login', $userCols)) {
            $db->exec("ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL DEFAULT NULL");
            $logs[] = "Added 'last_login' to users table.";
        }
        try {
            $db->exec("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'patient'");
        } catch (Exception $ign) {}
    }

    // 7. Seed ROLES
    $coreRoles = [
        ['name' => 'Super Admin',    'slug' => 'super_admin',   'description' => 'Full administrative control across all hospital departments and configurations', 'is_system' => 1],
        ['name' => 'Admin',          'slug' => 'admin',         'description' => 'Hospital operations management and departmental coordination',                    'is_system' => 1],
        ['name' => 'Receptionist',   'slug' => 'receptionist',  'description' => 'Front desk patient registration, appointment scheduling, and OPD/IPD desk',    'is_system' => 1],
        ['name' => 'Doctor',         'slug' => 'doctor',        'description' => 'Clinical consultations, diagnoses, prescription authoring, and patient history',  'is_system' => 1],
        ['name' => 'Lab',            'slug' => 'lab',           'description' => 'Diagnostic test management, specimen processing, reports, and lab billing',       'is_system' => 1],
        ['name' => 'Investigation',  'slug' => 'investigation', 'description' => 'Radiology, ECG, ultrasound, scans, and diagnostic imaging suite',                 'is_system' => 1],
        ['name' => 'Pharmacy',       'slug' => 'pharmacy',      'description' => 'Prescription dispensing, medication stock management, and pharmacy billing',     'is_system' => 1],
        ['name' => 'Store',          'slug' => 'store',         'description' => 'Biomedical assets, equipment maintenance, stock purchase, and inventory requisitions', 'is_system' => 1],
        ['name' => 'Patient',        'slug' => 'patient',       'description' => 'Personal patient health portal, visit history, prescription downloads, and bills', 'is_system' => 1],
    ];

    $roleIdMap = [];
    $stmtFindRole = $db->prepare("SELECT id FROM roles WHERE slug = ?");
    $stmtInsRole  = $db->prepare("INSERT INTO roles (name, slug, description, is_system) VALUES (?, ?, ?, ?)");

    foreach ($coreRoles as $r) {
        $stmtFindRole->execute([$r['slug']]);
        $existing = $stmtFindRole->fetch();
        if ($existing) {
            $roleIdMap[$r['slug']] = (int)$existing['id'];
        } else {
            $stmtInsRole->execute([$r['name'], $r['slug'], $r['description'], $r['is_system']]);
            $roleIdMap[$r['slug']] = (int)$db->lastInsertId();
        }
    }
    $logs[] = "Seeded " . count($coreRoles) . " core roles.";

    // 8. Seed GRANULAR PERMISSIONS
    $allPermissions = [
        // Patient Care Module
        ['code' => 'patient.view',              'name' => 'View Patients',               'module' => 'Patient Care',      'description' => 'View patient directory and profiles'],
        ['code' => 'patient.create',            'name' => 'Register Patient',            'module' => 'Patient Care',      'description' => 'Create new patient registration'],
        ['code' => 'patient.edit',              'name' => 'Edit Patient Details',        'module' => 'Patient Care',      'description' => 'Update patient contact and medical demographics'],
        ['code' => 'patient.delete',            'name' => 'Delete Patient Record',       'module' => 'Patient Care',      'description' => 'Archive or remove patient record'],
        
        // Appointment Module
        ['code' => 'appointment.view',          'name' => 'View Appointments',          'module' => 'Appointments',      'description' => 'View appointment rosters and calendar'],
        ['code' => 'appointment.book',          'name' => 'Book Appointment',            'module' => 'Appointments',      'description' => 'Schedule new patient appointment'],
        ['code' => 'appointment.manage',        'name' => 'Manage & Reschedule',         'module' => 'Appointments',      'description' => 'Reschedule, cancel, or modify appointment status'],
        
        // Clinical / OPD / IPD
        ['code' => 'opd.reception',             'name' => 'OPD Reception Desk',          'module' => 'Clinical & OPD',    'description' => 'Manage outpatient queue and tokens'],
        ['code' => 'ipd.reception',             'name' => 'IPD Reception & Admission',   'module' => 'Clinical & OPD',    'description' => 'Manage inpatient beds, admissions and discharges'],
        ['code' => 'consultation.manage',       'name' => 'Clinical Consultation',       'module' => 'Clinical & OPD',    'description' => 'Record patient diagnosis, clinical notes and symptoms'],
        ['code' => 'prescriptions.manage',      'name' => 'Author Prescriptions',        'module' => 'Clinical & OPD',    'description' => 'Issue Rx medication orders'],
        ['code' => 'discharge.manage',          'name' => 'Discharge Summaries',         'module' => 'Clinical & OPD',    'description' => 'Generate and finalize inpatient discharge summaries'],
        ['code' => 'health_checkup.manage',     'name' => 'Health Checkup Packages',     'module' => 'Clinical & OPD',    'description' => 'Administer preventive health packages'],
        
        // Billing & Invoicing
        ['code' => 'billing.view',              'name' => 'View Invoices',               'module' => 'Billing',           'description' => 'View patient invoices and payment statuses'],
        ['code' => 'billing.create',            'name' => 'Generate Bills',              'module' => 'Billing',           'description' => 'Create new bills and invoices'],
        ['code' => 'billing.edit',              'name' => 'Update & Settle Bills',       'module' => 'Billing',           'description' => 'Mark payments as received, apply adjustments'],
        
        // Laboratory Module
        ['code' => 'lab.view',                  'name' => 'View Lab Patients & Queue',   'module' => 'Laboratory',        'description' => 'Access laboratory dashboard and queue'],
        ['code' => 'lab.test.manage',           'name' => 'Test Catalog Management',     'module' => 'Laboratory',        'description' => 'Manage test directory, specimens and parameters'],
        ['code' => 'lab.report.manage',         'name' => 'Generate & Verify Reports',   'module' => 'Laboratory',        'description' => 'Input test results and verify lab reports'],
        ['code' => 'lab.billing',               'name' => 'Laboratory Billing',          'module' => 'Laboratory',        'description' => 'Process diagnostic charges and receipts'],
        
        // Investigation Module (Radiology, Scans, ECG)
        ['code' => 'investigation.view',        'name' => 'View Investigation Requests', 'module' => 'Investigation',     'description' => 'Access diagnostic imaging & scans portal'],
        ['code' => 'investigation.manage',      'name' => 'Manage Scans & Imaging',      'module' => 'Investigation',     'description' => 'Schedule scans, upload imaging reports and results'],
        
        // Pharmacy Module
        ['code' => 'pharmacy.view',             'name' => 'View Pharmacy Dashboard',     'module' => 'Pharmacy',          'description' => 'Access pharmacy portal and dispensing queue'],
        ['code' => 'pharmacy.medicine.manage',  'name' => 'Manage Medicine Directory',   'module' => 'Pharmacy',          'description' => 'Catalog medicines, dosages and pricing'],
        ['code' => 'pharmacy.stock.manage',     'name' => 'Manage Pharmacy Stock',       'module' => 'Pharmacy',          'description' => 'Track stock levels, expiry dates and batches'],
        ['code' => 'pharmacy.billing.manage',   'name' => 'Pharmacy POS Billing',        'module' => 'Pharmacy',          'description' => 'Dispense medicines and process sales receipts'],
        
        // Store & Inventory
        ['code' => 'inventory.view',            'name' => 'View Hospital Inventory',     'module' => 'Store & Inventory', 'description' => 'Inspect biomedical assets and inventory'],
        ['code' => 'inventory.purchase.manage', 'name' => 'Purchase Orders',             'module' => 'Store & Inventory', 'description' => 'Create and track procurement orders'],
        ['code' => 'inventory.stock.manage',    'name' => 'Stock Management & Assets',   'module' => 'Store & Inventory', 'description' => 'Manage asset maintenance logs and stock allocation'],
        
        // Revenue & Finance
        ['code' => 'revenue.view',              'name' => 'View Revenue Dashboard',      'module' => 'Revenue & Finance', 'description' => 'Access financial summaries, departmental revenue charts'],
        ['code' => 'revenue.export',            'name' => 'Export Financial Reports',    'module' => 'Revenue & Finance', 'description' => 'Download revenue ledgers and spreadsheets'],
        
        // Price Management
        ['code' => 'price.view',                'name' => 'View Price Directory',        'module' => 'Price Management',  'description' => 'View billable price lists across services and tests'],
        ['code' => 'price.manage',              'name' => 'Manage Prices & Tariffs',     'module' => 'Price Management',  'description' => 'Add, update, activate/deactivate prices and fees'],
        
        // Administration & RBAC
        ['code' => 'users.manage',              'name' => 'Manage Users & Staff',        'module' => 'Administration',    'description' => 'Create staff, edit profiles, toggle status, reset passwords'],
        ['code' => 'roles.manage',              'name' => 'Manage Roles & Permissions',  'module' => 'Administration',    'description' => 'Create roles and configure departmental permission matrices'],
        ['code' => 'departments.manage',        'name' => 'Manage Hospital Departments', 'module' => 'Administration',    'description' => 'Add and configure clinical divisions and rooms'],
        ['code' => 'settings.manage',           'name' => 'System Settings',             'module' => 'Administration',    'description' => 'Update hospital settings and system configuration'],
        
        // Patient Self-Service Portal
        ['code' => 'patient.portal',            'name' => 'Patient Portal Access',       'module' => 'Patient Portal',    'description' => 'View personal health summaries, bills and appointments'],
    ];

    $permIdMap = [];
    $stmtFindPerm = $db->prepare("SELECT id FROM permissions WHERE code = ?");
    $stmtInsPerm  = $db->prepare("INSERT INTO permissions (code, name, module, description) VALUES (?, ?, ?, ?)");

    foreach ($allPermissions as $p) {
        $stmtFindPerm->execute([$p['code']]);
        $existing = $stmtFindPerm->fetch();
        if ($existing) {
            $permIdMap[$p['code']] = (int)$existing['id'];
        } else {
            $stmtInsPerm->execute([$p['code'], $p['name'], $p['module'], $p['description']]);
            $permIdMap[$p['code']] = (int)$db->lastInsertId();
        }
    }
    $logs[] = "Seeded " . count($allPermissions) . " granular permissions.";

    // 9. Assign Permissions to Core Roles
    $rolePermMapping = [
        'super_admin' => array_keys($permIdMap), // Super Admin receives ALL permissions
        
        'admin' => [
            'patient.view', 'patient.create', 'patient.edit',
            'appointment.view', 'appointment.book', 'appointment.manage',
            'opd.reception', 'ipd.reception', 'consultation.manage', 'prescriptions.manage', 'discharge.manage', 'health_checkup.manage',
            'billing.view', 'billing.create', 'billing.edit',
            'lab.view', 'lab.test.manage', 'lab.report.manage', 'lab.billing',
            'investigation.view', 'investigation.manage',
            'pharmacy.view', 'pharmacy.medicine.manage', 'pharmacy.stock.manage', 'pharmacy.billing.manage',
            'inventory.view', 'inventory.purchase.manage', 'inventory.stock.manage',
            'revenue.view', 'price.view', 'departments.manage', 'settings.manage'
        ],

        'receptionist' => [
            'patient.view', 'patient.create', 'patient.edit',
            'appointment.view', 'appointment.book', 'appointment.manage',
            'opd.reception', 'ipd.reception',
            'billing.view', 'billing.create',
            'discharge.manage'
        ],

        'doctor' => [
            'patient.view',
            'appointment.view',
            'consultation.manage',
            'prescriptions.manage',
            'discharge.manage',
            'health_checkup.manage',
            'lab.report.manage',
            'investigation.view'
        ],

        'lab' => [
            'patient.view',
            'lab.view',
            'lab.test.manage',
            'lab.report.manage',
            'lab.billing'
        ],

        'investigation' => [
            'patient.view',
            'investigation.view',
            'investigation.manage'
        ],

        'pharmacy' => [
            'patient.view',
            'prescriptions.manage',
            'pharmacy.view',
            'pharmacy.medicine.manage',
            'pharmacy.stock.manage',
            'pharmacy.billing.manage'
        ],

        'store' => [
            'inventory.view',
            'inventory.purchase.manage',
            'inventory.stock.manage'
        ],

        'patient' => [
            'patient.portal',
            'appointment.book',
            'billing.view'
        ]
    ];

    $stmtClearRolePerms = $db->prepare("DELETE FROM role_permissions WHERE role_id = ?");
    $ignoreSql          = $isSqlite 
        ? "INSERT OR IGNORE INTO role_permissions (role_id, permission_id) VALUES (?, ?)" 
        : "INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (?, ?)";
    $stmtAssignPerm     = $db->prepare($ignoreSql);

    foreach ($rolePermMapping as $roleSlug => $permCodes) {
        if (!isset($roleIdMap[$roleSlug])) continue;
        $rId = $roleIdMap[$roleSlug];
        $stmtClearRolePerms->execute([$rId]);
        foreach ($permCodes as $code) {
            if (isset($permIdMap[$code])) {
                $stmtAssignPerm->execute([$rId, $permIdMap[$code]]);
            }
        }
    }
    $logs[] = "Mapped role permissions for all 9 core roles.";

    // 10. Seed Staff & User Accounts with Secure Password Hashing
    $defaultHash = password_hash('admin123', PASSWORD_BCRYPT);
    $patientHash = password_hash('password123', PASSWORD_BCRYPT);

    $usersToSeed = [
        ['name' => 'Hospital Super Admin', 'email' => 'superadmin@hms.com', 'pwd' => $defaultHash, 'role' => 'super_admin', 'phone' => '+91 98765 00000', 'dept_id' => 1],
        ['name' => 'Hospital Administrator', 'email' => 'admin@hms.com',     'pwd' => $defaultHash, 'role' => 'admin',       'phone' => '+91 98765 43210', 'dept_id' => 1],
        ['name' => 'Frontdesk Reception',  'email' => 'reception@hms.com', 'pwd' => $defaultHash, 'role' => 'receptionist',  'phone' => '+91 98765 43212', 'dept_id' => 8],
        ['name' => 'Dr. Ananya Sharma',    'email' => 'ananya@hms.com',    'pwd' => $defaultHash, 'role' => 'doctor',        'phone' => '+91 98765 43211', 'dept_id' => 1],
        ['name' => 'Dr. Rohan Mehta',      'email' => 'rohan@hms.com',     'pwd' => $defaultHash, 'role' => 'doctor',        'phone' => '+91 98765 43213', 'dept_id' => 2],
        ['name' => 'Central Lab Incharge', 'email' => 'lab@hms.com',       'pwd' => $defaultHash, 'role' => 'lab',           'phone' => '+91 98765 43214', 'dept_id' => 1],
        ['name' => 'Radiology & Imaging',  'email' => 'investigation@hms.com','pwd'=>$defaultHash, 'role' => 'investigation', 'phone' => '+91 98765 43215', 'dept_id' => 2],
        ['name' => 'Chief Pharmacist',     'email' => 'pharmacy@hms.com',  'pwd' => $defaultHash, 'role' => 'pharmacy',      'phone' => '+91 98765 43216', 'dept_id' => 8],
        ['name' => 'Central Store Manager','email' => 'store@hms.com',     'pwd' => $defaultHash, 'role' => 'store',         'phone' => '+91 98765 43217', 'dept_id' => 8],
        ['name' => 'Robert Harrison',      'email' => 'patient@example.com','pwd'=> $patientHash, 'role' => 'patient',       'phone' => '+91 98765 43218', 'dept_id' => null],
    ];

    $stmtFindUser = $db->prepare("SELECT id FROM users WHERE LOWER(email) = LOWER(?)");
    $stmtInsUser  = $db->prepare("INSERT INTO users (name, email, password, role, role_id, phone, status, department_id, avatar) VALUES (?, ?, ?, ?, ?, ?, 'active', ?, ?)");
    $stmtUpdUser  = $db->prepare("UPDATE users SET role = ?, role_id = ?, status = 'active' WHERE id = ?");

    foreach ($usersToSeed as $u) {
        $rId = $roleIdMap[$u['role']] ?? null;
        $stmtFindUser->execute([$u['email']]);
        $existingUser = $stmtFindUser->fetch();
        if ($existingUser) {
            $stmtUpdUser->execute([$u['role'], $rId, $existingUser['id']]);
        } else {
            $avatar = ($u['role'] === 'doctor') ? 'assets/images/doctors/dr-ananya.jpg' : 'assets/images/avatars/admin.jpg';
            $stmtInsUser->execute([$u['name'], $u['email'], $u['pwd'], $u['role'], $rId, $u['phone'], $u['dept_id'], $avatar]);
        }
    }
    $logs[] = "Seeded/synchronized user accounts with assigned role_ids.";

    // 11. Seed Master BILLABLE_ITEMS (Services, Tests, Medicines, Room Tariffs)
    $billableItems = [
        // Services
        ['item_type' => 'service', 'category' => 'Consultations', 'code' => 'CONS-GEN',  'name' => 'General Physician OPD Consultation', 'unit_price' => 500.00, 'department_id' => 8],
        ['item_type' => 'service', 'category' => 'Consultations', 'code' => 'CONS-SPEC', 'name' => 'Super Specialist Consultation (Cardio/Neuro)', 'unit_price' => 1000.00, 'department_id' => 1],
        ['item_type' => 'service', 'category' => 'Room & Bed',    'code' => 'BED-GEN',   'name' => 'General Ward Bed (Per Day)',          'unit_price' => 1200.00, 'department_id' => 8],
        ['item_type' => 'service', 'category' => 'Room & Bed',    'code' => 'BED-ICU',   'name' => 'Intensive Care Unit (ICU Per Day)',   'unit_price' => 6500.00, 'department_id' => 1],
        ['item_type' => 'service', 'category' => 'Procedures',    'code' => 'PROC-DRES', 'name' => 'Surgical Dressing & Wound Care',      'unit_price' => 350.00,  'department_id' => 3],
        ['item_type' => 'service', 'category' => 'Procedures',    'code' => 'PROC-NEB',  'name' => 'Nebulization Session',                 'unit_price' => 200.00,  'department_id' => 8],

        // Tests (Laboratory & Diagnostics)
        ['item_type' => 'test',    'category' => 'Pathology',     'code' => 'LAB-CBC',   'name' => 'Complete Blood Count (CBC)',           'unit_price' => 350.00,  'department_id' => 1],
        ['item_type' => 'test',    'category' => 'Pathology',     'code' => 'LAB-LFT',   'name' => 'Liver Function Test (LFT)',            'unit_price' => 850.00,  'department_id' => 7],
        ['item_type' => 'test',    'category' => 'Pathology',     'code' => 'LAB-KFT',   'name' => 'Kidney Function Test (KFT / RFT)',     'unit_price' => 750.00,  'department_id' => 8],
        ['item_type' => 'test',    'category' => 'Pathology',     'code' => 'LAB-LIPID', 'name' => 'Lipid Profile Comprehensive',          'unit_price' => 600.00,  'department_id' => 1],
        ['item_type' => 'test',    'category' => 'Pathology',     'code' => 'LAB-THY',   'name' => 'Thyroid Profile (T3, T4, TSH)',        'unit_price' => 550.00,  'department_id' => 8],
        ['item_type' => 'test',    'category' => 'Radiology',     'code' => 'RAD-XRAY',  'name' => 'Chest Digital X-Ray (PA View)',        'unit_price' => 600.00,  'department_id' => 2],
        ['item_type' => 'test',    'category' => 'Radiology',     'code' => 'RAD-ECG',   'name' => '12-Lead Electrocardiogram (ECG)',      'unit_price' => 450.00,  'department_id' => 1],
        ['item_type' => 'test',    'category' => 'Radiology',     'code' => 'RAD-USG',   'name' => 'Ultrasound Whole Abdomen (USG)',       'unit_price' => 1800.00, 'department_id' => 2],

        // Medicines
        ['item_type' => 'medicine','category' => 'Analgesics',    'code' => 'MED-PCM',   'name' => 'Paracetamol 650mg (Strip of 15)',     'unit_price' => 45.00,   'department_id' => 8],
        ['item_type' => 'medicine','category' => 'Antibiotics',   'code' => 'MED-AMOX',  'name' => 'Amoxicillin 500mg (Strip of 10)',     'unit_price' => 110.00,  'department_id' => 8],
        ['item_type' => 'medicine','category' => 'Cardiovascular','code' => 'MED-ATRV',  'name' => 'Atorvastatin 20mg (Strip of 10)',     'unit_price' => 165.00,  'department_id' => 1],
        ['item_type' => 'medicine','category' => 'Antidiabetic',  'code' => 'MED-METF',  'name' => 'Metformin 500mg SR (Strip of 15)',    'unit_price' => 68.00,   'department_id' => 8],
        ['item_type' => 'medicine','category' => 'Vitamins',      'code' => 'MED-VITD',  'name' => 'Vitamin D3 60,000 IU (Strip of 4)',    'unit_price' => 120.00,  'department_id' => 8],
        ['item_type' => 'medicine','category' => 'Antacid',       'code' => 'MED-PAN',   'name' => 'Pantoprazole 40mg (Strip of 10)',     'unit_price' => 95.00,   'department_id' => 7],
    ];

    $stmtFindItem = $db->prepare("SELECT id FROM billable_items WHERE code = ?");
    $stmtInsItem  = $db->prepare("INSERT INTO billable_items (item_type, category, code, name, unit_price, department_id, status) VALUES (?, ?, ?, ?, ?, ?, 1)");

    foreach ($billableItems as $b) {
        $stmtFindItem->execute([$b['code']]);
        if (!$stmtFindItem->fetch()) {
            $stmtInsItem->execute([$b['item_type'], $b['category'], $b['code'], $b['name'], $b['unit_price'], $b['department_id']]);
        }
    }
    $logs[] = "Seeded " . count($billableItems) . " master billable items and tariffs.";

    // 12. Seed REVENUE_TRANSACTIONS (Realistic historical & recent transactions across all departments)
    $txCount = (int)$db->query("SELECT COUNT(*) FROM revenue_transactions")->fetchColumn();
    if ($txCount === 0) {
        $txData = [
            ['bill_no' => 'INV-2026-0901', 'patient' => 'Vikram Singh',   'dept' => 'OPD',           'med_dept' => 'Cardiology',       'item' => 'Specialist Consultation + ECG', 'amount' => 1450.00, 'method' => 'UPI / GPay',   'date' => date('Y-m-d')],
            ['bill_no' => 'INV-2026-0902', 'patient' => 'Meera Nair',     'dept' => 'Laboratory',    'med_dept' => 'Neurology',        'item' => 'Comprehensive Lipid & LFT Panel','amount' => 1450.00, 'method' => 'Debit Card',   'date' => date('Y-m-d')],
            ['bill_no' => 'INV-2026-0903', 'patient' => 'Aarav Patel',    'dept' => 'Pharmacy',      'med_dept' => 'Pediatrics',       'item' => 'Prescription Antibiotics & Drops','amount' => 640.00, 'method' => 'Cash',         'date' => date('Y-m-d')],
            ['bill_no' => 'INV-2026-0904', 'patient' => 'Sneha R',        'dept' => 'Investigation', 'med_dept' => 'Cardiology',       'item' => 'Chest Digital X-Ray + ECG',      'amount' => 1050.00, 'method' => 'Credit Card', 'date' => date('Y-m-d')],
            ['bill_no' => 'INV-2026-0905', 'patient' => 'Rahul K',        'dept' => 'IPD',           'med_dept' => 'Orthopedics',      'item' => 'General Ward Bed + Dressing',   'amount' => 3850.00, 'method' => 'Insurance',   'date' => date('Y-m-d')],
            ['bill_no' => 'INV-2026-0895', 'patient' => 'David Chen',     'dept' => 'OPD',           'med_dept' => 'General Medicine', 'item' => 'OPD Consultation Fee',          'amount' => 500.00,  'method' => 'UPI',          'date' => date('Y-m-d', strtotime('-1 day'))],
            ['bill_no' => 'INV-2026-0896', 'patient' => 'Sophia Martinez','dept' => 'Laboratory',    'med_dept' => 'Gastroenterology', 'item' => 'CBC + Blood Sugar (FBS/PPBS)', 'amount' => 700.00,  'method' => 'Credit Card', 'date' => date('Y-m-d', strtotime('-1 day'))],
            ['bill_no' => 'INV-2026-0897', 'patient' => 'Emma Watson',    'dept' => 'Pharmacy',      'med_dept' => 'Neurology',        'item' => 'Migraine Specialty Medication', 'amount' => 820.00,  'method' => 'Cash',         'date' => date('Y-m-d', strtotime('-2 days'))],
            ['bill_no' => 'INV-2026-0898', 'patient' => 'James Wilson',   'dept' => 'Investigation', 'med_dept' => 'Orthopedics',      'item' => 'Ultrasound & Joint Scan',       'amount' => 2200.00, 'method' => 'Debit Card',   'date' => date('Y-m-d', strtotime('-3 days'))],
            ['bill_no' => 'INV-2026-0899', 'patient' => 'Ananya P',       'dept' => 'IPD',           'med_dept' => 'Cardiology',       'item' => 'Cardio Care Unit (CCU 2 Days)', 'amount' => 12500.00,'method' => 'Insurance',   'date' => date('Y-m-d', strtotime('-4 days'))],
            ['bill_no' => 'INV-2026-0880', 'patient' => 'Kavya S',        'dept' => 'Other Services','med_dept' => 'General Medicine', 'item' => 'Executive Wellness Checkup',   'amount' => 4999.00, 'method' => 'Online',      'date' => date('Y-m-d', strtotime('-5 days'))],
            ['bill_no' => 'INV-2026-0881', 'patient' => 'Sunita Patel',   'dept' => 'Pharmacy',      'med_dept' => 'General Medicine', 'item' => 'Monthly Chronic Care Medicines','amount' => 1850.00, 'method' => 'UPI',          'date' => date('Y-m-d', strtotime('-6 days'))],
            ['bill_no' => 'INV-2026-0882', 'patient' => 'Ramesh Gupta',   'dept' => 'Laboratory',    'med_dept' => 'Cardiology',       'item' => 'Cardiac Enzyme Biomarkers',     'amount' => 2400.00, 'method' => 'Credit Card', 'date' => date('Y-m-d', strtotime('-7 days'))],
        ];

        $insTx = $db->prepare("INSERT INTO revenue_transactions (bill_no, patient_name, department, medical_department, item_name, amount, payment_method, status, transaction_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($txData as $t) {
            $insTx->execute([$t['bill_no'], $t['patient'], $t['dept'], $t['med_dept'], $t['item'], $t['amount'], $t['method'], 'Completed', $t['date']]);
        }
        $logs[] = "Seeded " . count($txData) . " sample revenue transactions.";
    }

    return [
        'success' => true,
        'driver'  => $driver,
        'logs'    => $logs
    ];
}

// If run directly from CLI
if (php_sapi_name() === 'cli' || isset($_GET['run'])) {
    $res = runRBACMigration();
    echo "RBAC Migration Finished using driver: " . $res['driver'] . "\n";
    foreach ($res['logs'] as $log) {
        echo "  - $log\n";
    }
}
