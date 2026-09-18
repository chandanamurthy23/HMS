<?php
/**
 * Hospital Management System (HMS) - Reviews API Endpoint
 * Output: JSON
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $stmt = $db->query("SELECT r.*, d.name AS doctor_name 
                            FROM reviews r 
                            LEFT JOIN doctors d ON r.doctor_id = d.id 
                            WHERE r.status = 'approved' 
                            ORDER BY r.created_at DESC");
        $reviews = $stmt->fetchAll();

        echo json_encode([
            'success' => true,
            'count'   => count($reviews),
            'data'    => $reviews
        ], JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

    $patientName = sanitize($input['patient_name'] ?? '');
    $rating      = floatval($input['rating'] ?? 5.0);
    $comment     = sanitize($input['comment'] ?? '');
    $doctorId    = !empty($input['doctor_id']) ? intval($input['doctor_id']) : null;

    if (empty($patientName) || empty($comment)) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'patient_name and comment are required.']);
        exit;
    }

    try {
        $stmt = $db->prepare("INSERT INTO reviews (patient_name, rating, comment, doctor_id, status) VALUES (?, ?, ?, ?, 'approved')");
        $stmt->execute([$patientName, $rating, $comment, $doctorId]);

        echo json_encode([
            'success' => true,
            'message' => 'Review submitted successfully.'
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
