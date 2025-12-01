<?php
require_once '../controllers/permit.controller.php';
require_once '../models/permit.model.php';
require_once "../views/modules/session.php";

$type = $_SESSION['type'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_permits') {
    $permits = (new ControllerPermits)->ctrShowNotifcation($type);
    header('Content-Type: application/json');
    $response = [
        'type' => $type,
        'permits' => $permits
    ];
    echo json_encode($response);
    exit;
}
