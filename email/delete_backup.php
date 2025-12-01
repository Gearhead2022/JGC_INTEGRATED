<?php
require_once "../controllers/databackup.controller.php";
require_once "../models/databackup.model.php";
require_once "../models/connection.php";

error_reporting(E_ALL);
ini_set('log_errors', 'On');
ini_set('error_log', 'log.txt');
ini_set('log_errors_max_size', '10M');
// chmod('log.txt', 0644);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data_id'])) {
    $data_id = $_POST['data_id'];
    $conn = (new Connection)->connect();

    try {
        // Fetch backup details
        $stmt = $conn->prepare("SELECT file_path FROM data_backup_log WHERE data_id = ?");
        $stmt->execute([$data_id]);
        $backup = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($backup) {
            $folderPath = rtrim($backup['file_path'], '/\\');

            // Recursive deletion function
            function deleteFolder($folder) {
                if (!is_dir($folder)) return false;

                $files = array_diff(scandir($folder), ['.', '..']);
                foreach ($files as $file) {
                    $path = "$folder/$file";
                    if (is_dir($path)) {
                        deleteFolder($path);
                    } else {
                        unlink($path);
                    }
                }
                return rmdir($folder);
            }

            // Delete the folder
            if (file_exists($folderPath) && is_dir($folderPath)) {
                deleteFolder($folderPath);
            }

            // Delete from database
            $stmt = $conn->prepare("DELETE FROM data_backup_log WHERE data_id = ?");
            $stmt->execute([$data_id]);

            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Backup not found.']);
        }

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
