<?php
/**
 * Hospital Management System (HMS) - Doctors API Endpoint
 * Output: JSON
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    $db = getDB();
    
    $deptId = isset($_GET['department_id']) ? intval($_GET['department_id']) : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    $query = "SELECT d.*, dept.name AS department_name, dept.slug AS department_slug 
              FROM doctors d 
              LEFT JOIN departments dept ON d.department_id = dept.id 
              WHERE d.status = 1";
    $params = [];

    if (!empty($deptId)) {
        $query .= " AND d.department_id = ?";
        $params[] = $deptId;
    }

    if (!empty($search)) {
        $query .= " AND (d.name LIKE ? OR d.specialty LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $query .= " ORDER BY d.rating DESC, d.name ASC";

    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $doctors = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'count'   => count($doctors),
        'data'    => $doctors
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error: ' . $e->getMessage()
    ]);
}
