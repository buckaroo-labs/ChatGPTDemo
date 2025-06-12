<?php
require_once '../db.php';
header('Content-Type: application/json');

$logs = $db->query("
    SELECT p.name AS project_name, l.start_time, l.end_time
    FROM time_logs l
    JOIN projects p ON l.project_id = p.id
    ORDER BY l.start_time DESC
")->fetchAll(PDO::FETCH_ASSOC);

foreach ($logs as &$log) {
    if ($log['end_time']) {
        $duration = strtotime($log['end_time']) - strtotime($log['start_time']);
        $log['duration'] = gmdate('H:i:s', $duration);
    } else {
        $log['duration'] = 'In Progress';
    }
}

echo json_encode($logs);
