<?php
/**
 * Hospital Management System (HMS) - Appointments API Endpoint
 * Output: JSON
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET: Lookup appointment
if ($method === 'GET') {
    $appointmentNo = sanitize($_GET['appointment_no'] ?? '');

    if (empty($appointmentNo)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'appointment_no parameter is required.'
        ]);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT a.*, d.name AS doctor_name, d.specialty, d.fee, dept.name AS department_name 
                              FROM appointments a 
                              LEFT JOIN doctors d ON a.doctor_id = d.id 
                              LEFT JOIN departments dept ON a.department_id = dept.id 
                              WHERE a.appointment_no = ?");
        $stmt->execute([$appointmentNo]);
        $appt = $stmt->fetch();

        if ($appt) {
            echo json_encode([
                'success' => true,
                'data'    => $appt
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Appointment not found.'
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle POST: Create appointment
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

    $patientName   = sanitize($input['patient_name'] ?? '');
    $patientEmail  = sanitize($input['patient_email'] ?? '');
    $patientPhone  = sanitize($input['patient_phone'] ?? '');
    $patientGender = sanitize($input['patient_gender'] ?? 'Male');
    $patientAge    = intval($input['patient_age'] ?? 0);
    $doctorId      = !empty($input['doctor_id']) ? intval($input['doctor_id']) : null;
    $departmentId  = !empty($input['department_id']) ? intval($input['department_id']) : null;
    $apptDate      = sanitize($input['appointment_date'] ?? '');
    $apptTime      = sanitize($input['appointment_time'] ?? '');
    $reason        = sanitize($input['reason'] ?? '');

    if (empty($patientName) || empty($patientPhone) || empty($apptDate) || empty($apptTime)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields (patient_name, patient_phone, appointment_date, appointment_time).'
        ]);
        exit;
    }

    try {
        $appointmentNo = generateAppointmentNo();

        // If doctor provided but no department, find doctor's department
        if (empty($departmentId) && !empty($doctorId)) {
            $docStmt = $db->prepare("SELECT department_id FROM doctors WHERE id = ?");
            $docStmt->execute([$doctorId]);
            $departmentId = $docStmt->fetchColumn() ?: null;
        }

        $stmt = $db->prepare("INSERT INTO appointments 
            (appointment_no, patient_name, patient_email, patient_phone, patient_gender, patient_age, doctor_id, department_id, appointment_date, appointment_time, reason, status, payment_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed', 'Paid')");

        $stmt->execute([
            $appointmentNo,
            $patientName,
            $patientEmail,
            $patientPhone,
            $patientGender,
            $patientAge,
            $doctorId,
            $departmentId,
            $apptDate,
            $apptTime,
            $reason
        ]);

        echo json_encode([
            'success'        => true,
            'message'        => 'Appointment booked successfully.',
            'appointment_no' => $appointmentNo,
            'status'         => 'Confirmed'
        ], JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Booking error: ' . $e->getMessage()
        ]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
