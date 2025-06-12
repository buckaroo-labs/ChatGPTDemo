<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Time Tracker</title>
</head>
<body>
    <h1>Project Time Tracker</h1>

    <form action="index.php" method="POST">
        <input type="text" name="project_name" placeholder="New Project Name" required>
        <button type="submit" name="add_project">Add Project</button>
    </form>

    <h2>Projects</h2>
    <ul>
    <?php
    if (isset($_POST['add_project'])) {
        $stmt = $db->prepare("INSERT INTO projects (name) VALUES (?)");
        $stmt->execute([$_POST['project_name']]);
    }

    $projects = $db->query("SELECT * FROM projects");
    foreach ($projects as $project):
    ?>
        <li>
            <?= htmlspecialchars($project['name']) ?>
            <form action="start.php" method="POST" style="display:inline;">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <button type="submit">Start</button>
            </form>
            <form action="stop.php" method="POST" style="display:inline;">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <button type="submit">Stop</button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>

    <a href="view.php">View Time Logs</a>
</body>
</html>
