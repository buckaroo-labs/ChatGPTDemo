<?php
require 'db.php';

$project_id = $_POST['project_id'];
$now = date('Y-m-d H:i:s');

// Check if there's already a running timer
$stmt = $db->prepare("SELECT * FROM time_logs WHERE project_id = ? AND end_time IS NULL");
$stmt->execute([$project_id]);
if (!$stmt->fetch()) {
    $stmt = $db->prepare("INSERT INTO time_logs (project_id, start_time) VALUES (?, ?)");
    $stmt->execute([$project_id, $now]);
}

header('Location: index.php');
exit;
