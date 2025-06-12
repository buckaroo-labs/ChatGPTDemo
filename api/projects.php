<?php
require_once '../db.php';
header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $projects = $db->query("SELECT * FROM projects")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($projects);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Project name required']);
            exit;
        }

        $stmt = $db->prepare("INSERT INTO projects (name) VALUES (?)");
        $stmt->execute([$data['name']]);
        echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
