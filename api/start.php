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

// Prevent duplicate running logs
$stmt = $db->prepare("SELECT * FROM time_logs WHERE project_id = ? AND end_time IS NULL");
$stmt->execute([$project_id]);
if ($stmt->fetch()) {
    echo json_encode(['message' => 'Timer already running']);
    exit;
}

$now = date('Y-m-d H:i:s');
$stmt = $db->prepare("INSERT INTO time_logs (project_id, start_time) VALUES (?, ?)");
$stmt->execute([$project_id, $now]);

echo json_encode(['success' => true]);
