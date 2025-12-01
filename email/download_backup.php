<?php
require_once "../controllers/databackup.controller.php";
require_once "../models/databackup.model.php";
require_once "../models/connection.php";

$data_backup_list = new ControllerDataBackup();
$conn = (new Connection)->connect();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_backup = $data_backup_list->ctrGetDataBackup($data_id);
    $backup_at = $data_backup[0]['backup_at'] ?? 'UnSpecified';
    $time_at = date('H-i', strtotime($data_backup[0]['time_at'])) ?? '05-30_PM';
    $datetime_now = date('Y-m-d_H-i-s');
    $date_now = date("Y-m-d");
    $zipname = "backup_{$backup_at}_{$time_at}_PM.zip";
    $zipPath = __DIR__ . '/' . $zipname;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($data_backup as $data) {
            $folder = $data['file_path'];
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folder) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
        $zip->close();

        // Output ZIP to browser
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipname . '"');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);

        // Delete ZIP after sending
        unlink($zipPath);

        // Update database
        $stmt = $conn->prepare("UPDATE data_backup_log SET download_at = ? WHERE data_id = ?");
        $stmt->execute([$date_now, $data_id]);

        exit;
    } else {
        echo 'Error creating zip archive';
    }
} else {
    echo "Invalid request.";
}
