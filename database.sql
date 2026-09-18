-- =========================================================
-- Hospital Management System (HMS) - Database Schema
-- Database: hms_db
-- =========================================================

CREATE DATABASE IF NOT EXISTS `hms_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hms_db`;

-- 1. Users Table (Admin, Doctors, Staff, Patients)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'patient',
  `phone` VARCHAR(20) DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT 'assets/images/avatars/admin.jpg',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Departments Table
CREATE TABLE IF NOT EXISTS `departments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `icon` VARCHAR(50) NOT NULL,
  `color` VARCHAR(20) DEFAULT '#0284c7',
  `bg_color` VARCHAR(20) DEFAULT '#e0f2fe',
  `subtitle` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `status` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Doctors Table
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `department_id` INT DEFAULT NULL,
  `specialty` VARCHAR(100) NOT NULL,
  `qualification` VARCHAR(100) DEFAULT 'MBBS, MD',
  `experience` VARCHAR(50) NOT NULL DEFAULT '10+ years',
  `rating` DECIMAL(2,1) DEFAULT 4.9,
  `reviews_count` INT DEFAULT 120,
  `fee` DECIMAL(10,2) DEFAULT 800.00,
  `image` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `available_days` VARCHAR(100) DEFAULT 'Mon - Sat',
  `available_time` VARCHAR(100) DEFAULT '09:00 AM - 05:00 PM',
  `bio` TEXT,
  `status` TINYINT(1) DEFAULT 1,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Health Packages Table
CREATE TABLE IF NOT EXISTS `health_packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `icon` VARCHAR(50) NOT NULL,
  `color` VARCHAR(20) DEFAULT '#0284c7',
  `bg_color` VARCHAR(20) DEFAULT '#e0f2fe',
  `tests_count` INT DEFAULT 15,
  `features` TEXT,
  `status` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Appointments Table
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `appointment_no` VARCHAR(30) NOT NULL UNIQUE,
  `patient_name` VARCHAR(100) NOT NULL,
  `patient_email` VARCHAR(100) NOT NULL,
  `patient_phone` VARCHAR(20) NOT NULL,
  `patient_gender` ENUM('Male', 'Female', 'Other') DEFAULT 'Male',
  `patient_age` INT DEFAULT NULL,
  `doctor_id` INT DEFAULT NULL,
  `department_id` INT DEFAULT NULL,
  `appointment_date` DATE NOT NULL,
  `appointment_time` VARCHAR(20) NOT NULL,
  `reason` TEXT,
  `status` ENUM('Pending', 'Confirmed', 'Checked In', 'Completed', 'Cancelled') DEFAULT 'Confirmed',
  `payment_status` ENUM('Unpaid', 'Paid', 'Refunded') DEFAULT 'Paid',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Facilities Table
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `status` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Reviews & Testimonials Table
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `patient_name` VARCHAR(100) NOT NULL,
  `rating` DECIMAL(2,1) DEFAULT 5.0,
  `comment` TEXT NOT NULL,
  `avatar` VARCHAR(255) DEFAULT 'assets/images/avatars/patient.jpg',
  `doctor_id` INT DEFAULT NULL,
  `status` ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Contact Inquiries Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `subject` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read', 'replied') DEFAULT 'unread',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Payments / Transactions Table
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `appointment_id` INT DEFAULT NULL,
  `transaction_no` VARCHAR(50) NOT NULL UNIQUE,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(50) DEFAULT 'Online / Card',
  `status` ENUM('Success', 'Pending', 'Failed') DEFAULT 'Success',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`appointment_id`) REFERENCES `appointments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- SEED DATA
-- =========================================================

-- Insert Admin User (Password: admin123)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `phone`) VALUES
('Hospital Administrator', 'admin@hms.com', '$2y$10$wN9iQO8rUf8qT9d8G4t/yOaY6sS/h5k0X0N1wX7G4t/yOaY6sS/h5', 'admin', '+91 98765 43210'),
('Dr. Ananya Sharma', 'ananya@hms.com', '$2y$10$wN9iQO8rUf8qT9d8G4t/yOaY6sS/h5k0X0N1wX7G4t/yOaY6sS/h5', 'doctor', '+91 98765 43211'),
('Frontdesk Reception', 'reception@hms.com', '$2y$10$wN9iQO8rUf8qT9d8G4t/yOaY6sS/h5k0X0N1wX7G4t/yOaY6sS/h5', 'receptionist', '+91 98765 43212')
ON DUPLICATE KEY UPDATE `email`=`email`;

-- Insert 8 Core Departments
INSERT INTO `departments` (`id`, `name`, `slug`, `icon`, `color`, `bg_color`, `subtitle`, `description`) VALUES
(1, 'Cardiology', 'cardiology', 'bi-heart-pulse-fill', '#ef4444', '#fee2e2', 'Heart Care & Treatment', 'Comprehensive cardiovascular diagnostics, interventions, and rehabilitation services.'),
(2, 'Neurology', 'neurology', 'bi-cpu-fill', '#0284c7', '#e0f2fe', 'Brain & Nerve Care', 'Advanced neurological diagnosis, neuro-rehab, and specialized neurosurgical solutions.'),
(3, 'Orthopedics', 'orthopedics', 'bi-bandaid-fill', '#16a34a', '#dcfce7', 'Bone & Joint Care', 'Specialized arthroscopy, joint replacements, trauma orthopedic surgery, and sports medicine.'),
(4, 'Pediatrics', 'pediatrics', 'bi-emoji-smile-fill', '#9333ea', '#f3e8ff', 'Child Health & Wellness', 'Dedicated pediatric care from newborn intensive care to adolescent wellness programs.'),
(5, 'Gynecology', 'gynecology', 'bi-gender-female', '#e11d48', '#ffe4e6', 'Women\'s Health', 'Complete maternal care, fertility counseling, gynecologic wellness, and minimally invasive surgery.'),
(6, 'Dermatology', 'dermatology', 'bi-shield-plus', '#ea580c', '#ffedd5', 'Skin & Hair Care', 'Evidence-based dermatology, clinical laser solutions, and dermatological surgery.'),
(7, 'Gastroenterology', 'gastroenterology', 'bi-capsule', '#0891b2', '#cffafe', 'Digestive Health', 'Advanced endoscopic procedures, liver wellness clinics, and gastrointestinal therapeutics.'),
(8, 'General Medicine', 'general-medicine', 'bi-heart-pulse', '#4338ca', '#e0e7ff', 'Overall Wellness', 'Holistic preventive healthcare, internal medicine diagnosis, and chronic condition management.')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert 4 Main Reference Doctors
INSERT INTO `doctors` (`id`, `name`, `department_id`, `specialty`, `qualification`, `experience`, `rating`, `reviews_count`, `fee`, `image`, `email`, `available_days`, `available_time`, `bio`) VALUES
(1, 'Dr. Ananya Sharma', 1, 'Cardiologist', 'MBBS, MD (Cardiology), FACC', '15+ years experience', 4.9, 120, 1000.00, 'assets/images/doctors/dr-ananya.jpg', 'ananya.sharma@hmshospital.com', 'Mon - Fri', '09:00 AM - 03:00 PM', 'Senior Consultant Cardiologist specializing in preventive cardiology, coronary interventions, and heart failure management.'),
(2, 'Dr. Rohan Mehta', 2, 'Neurologist', 'MBBS, DM (Neurology)', '12+ years experience', 4.7, 98, 900.00, 'assets/images/doctors/dr-rohan.jpg', 'rohan.mehta@hmshospital.com', 'Mon - Sat', '10:00 AM - 04:00 PM', 'Specialist in stroke intervention, epilepsy management, movement disorders, and neuro-critical diagnostics.'),
(3, 'Dr. Sneha Iyer', 4, 'Pediatrician', 'MBBS, DCH, MD (Pediatrics)', '10+ years experience', 4.9, 142, 750.00, 'assets/images/doctors/dr-sneha.jpg', 'sneha.iyer@hmshospital.com', 'Mon - Sat', '08:30 AM - 02:30 PM', 'Passionate pediatrician with deep clinical focus on pediatric growth development, vaccinations, and preventive child care.'),
(4, 'Dr. Arjun Nair', 3, 'Orthopedic Surgeon', 'MBBS, MS (Ortho), MCh (Joint Replacements)', '14+ years experience', 4.8, 110, 950.00, 'assets/images/doctors/dr-arjun.jpg', 'arjun.nair@hmshospital.com', 'Tue - Sun', '10:00 AM - 05:00 PM', 'Expert orthopedic surgeon specializing in robotic joint replacements, sports injury reconstructions, and arthroscopy.')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Health Packages
INSERT INTO `health_packages` (`id`, `title`, `slug`, `price`, `icon`, `color`, `bg_color`, `tests_count`, `features`) VALUES
(1, 'Basic Checkup', 'basic-checkup', 2499.00, 'bi-clipboard2-check', '#16a34a', '#dcfce7', 18, 'Complete Blood Count (CBC)\nFasting Blood Sugar\nLipid Profile\nLiver Function Test\nECG\nPhysician Consultation'),
(2, 'Executive Checkup', 'executive-checkup', 4999.00, 'bi-file-earmark-medical', '#0284c7', '#e0f2fe', 36, 'All Basic Checkup Tests\nThyroid Profile (T3, T4, TSH)\nKidney Function Test (KFT)\nChest X-Ray\nUltrasound Abdomen\nCardiologist Consultation'),
(3, 'Master Checkup', 'master-checkup', 7999.00, 'bi-shield-check', '#9333ea', '#f3e8ff', 58, 'All Executive Checkup Tests\n2D Echo / TMT\nVitamin D & B12\nCancer Markers (PSA/Pap Smear)\nBone Mineral Density\nDiet & Nutrition Consultation')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Facilities
INSERT INTO `facilities` (`name`, `image`, `description`) VALUES
('ICU & Critical Care', 'assets/images/facilities/icu.jpg', '24/7 high-dependency intensive care equipped with multi-parameter digital monitoring and advanced ventilators.'),
('Operation Theatres', 'assets/images/facilities/ot.jpg', 'Laminar air flow sterile surgical suites with HD laparoscopic imaging and cutting-edge surgical consoles.'),
('Diagnostic Labs', 'assets/images/facilities/lab.jpg', 'NABL accredited automated diagnostic robotics ensuring precision pathology and rapid turnaround times.'),
('Pharmacy', 'assets/images/facilities/pharmacy.jpg', 'Fully stocked 24/7 in-house pharmacy providing authentic prescription medicines and clinical supplies.')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Insert Verified Patient Reviews
INSERT INTO `reviews` (`patient_name`, `rating`, `comment`, `avatar`, `doctor_id`, `status`) VALUES
('Sneha R.', 5.0, 'The doctors and staff are very supportive. I felt well taken care of throughout my treatment.', 'assets/images/avatars/testimonial-sneha.jpg', 1, 'approved'),
('Rahul K.', 4.8, 'Excellent service and modern facilities. Highly recommended!', 'assets/images/avatars/testimonial-rahul.jpg', 2, 'approved'),
('Priya S.', 4.9, 'Very professional and caring team. Grateful for the amazing care I received.', 'assets/images/avatars/testimonial-priya.jpg', 4, 'approved')
ON DUPLICATE KEY UPDATE `patient_name`=`patient_name`;

-- Insert Initial Sample Appointments
INSERT INTO `appointments` (`appointment_no`, `patient_name`, `patient_email`, `patient_phone`, `doctor_id`, `department_id`, `appointment_date`, `appointment_time`, `reason`, `status`) VALUES
('HMS-2025-0101', 'Vikram Singh', 'vikram.s@gmail.com', '+91 98450 11223', 1, 1, CURDATE(), '10:00 AM', 'Routine cardiac health follow-up', 'Confirmed'),
('HMS-2025-0102', 'Meera Nair', 'meera.n@gmail.com', '+91 99160 44556', 2, 2, CURDATE(), '11:30 AM', 'Persistent migraine headaches', 'Pending'),
('HMS-2025-0103', 'Aarav Patel', 'sunita.patel@gmail.com', '+91 97310 88990', 3, 4, CURDATE(), '02:00 PM', 'Child wellness and vaccination checkup', 'Checked In')
ON DUPLICATE KEY UPDATE `appointment_no`=`appointment_no`;
