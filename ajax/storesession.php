<?php
require_once "../views/modules/session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['status'] = "true";
    $_SESSION['mode'] = "light";
    // Return a success response
    echo json_encode(['success' => true]);
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
