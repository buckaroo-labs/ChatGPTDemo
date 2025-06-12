<?php
require 'db.php';

$logs = $db->query("
    SELECT p.name as project_name, l.start_time, l.end_time
    FROM time_logs l
    JOIN projects p ON p.id = l.project_id
    ORDER BY l.start_time DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Time Logs</title>
</head>
<body>
    <h1>Time Logs</h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>Project</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Duration</th>
        </tr>
        <?php foreach ($logs as $log): 
            $duration = '';
            if ($log['end_time']) {
                $start = strtotime($log['start_time']);
                $end = strtotime($log['end_time']);
                $seconds = $end - $start;
                $duration = gmdate("H:i:s", $seconds);
            } else {
                $duration = 'In Progress';
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($log['project_name']) ?></td>
            <td><?= $log['start_time'] ?></td>
            <td><?= $log['end_time'] ?? '...' ?></td>
            <td><?= $duration ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">? Back</a>
</body>
</html>
