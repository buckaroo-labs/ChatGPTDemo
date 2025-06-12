<?php
$request = $_SERVER['REQUEST_URI'];

switch (true) {
    case preg_match('/\/api\/projects$/', $request):
        require 'projects.php';
        break;
    case preg_match('/\/api\/start$/', $request):
        require 'start.php';
        break;
    case preg_match('/\/api\/stop$/', $request):
        require 'stop.php';
        break;
    case preg_match('/\/api\/logs$/', $request):
        require 'logs.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
}
