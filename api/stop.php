<?php
require_once '../db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$project_id = $data['project_id'] ?? null;

if (!$project_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Project ID required']);
    exit;
}

$now = date('Y-m-d H:i:s');
$stmt = $db->prepare("UPDATE time_logs SET end_time = ? WHERE project_id = ? AND end_time IS NULL");
$stmt->execute([$now, $project_id]);

echo json_encode(['success' => true]);
