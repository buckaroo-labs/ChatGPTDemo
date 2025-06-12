<?php
require 'db.php';

$project_id = $_POST['project_id'];
$now = date('Y-m-d H:i:s');

$stmt = $db->prepare("UPDATE time_logs SET end_time = ? WHERE project_id = ? AND end_time IS NULL");
$stmt->execute([$now, $project_id]);

header('Location: index.php');
exit;
