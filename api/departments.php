<?php
/**
 * Hospital Management System (HMS) - Departments API Endpoint
 * Output: JSON
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    $db = getDB();
    $stmt = $db->query("SELECT d.*, COUNT(doc.id) AS total_doctors 
                        FROM departments d 
                        LEFT JOIN doctors doc ON d.id = doc.department_id AND doc.status = 1 
                        WHERE d.status = 1 
                        GROUP BY d.id 
                        ORDER BY d.id ASC");
    $departments = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'count'   => count($departments),
        'data'    => $departments
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error: ' . $e->getMessage()
    ]);
}
