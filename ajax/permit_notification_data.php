<?php
header('Content-Type: application/json');
require_once "../controllers/permit.controller.php";
require_once "../models/permit.model.php";

// Start session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['action']) || $input['action'] !== 'fetch_permit_notifications') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$type = $_SESSION['type'] ?? 'HSE'; // or adjust this dynamically
$notifications = ControllerPermits::ctrGetNotification($type);
echo json_encode([
    'status' => 'success',
    'notifications' => $notifications
]);
exit;
