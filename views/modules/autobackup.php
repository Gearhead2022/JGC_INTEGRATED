<?php

// Secure and silent start
ob_start();
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '512M');

$secretKey = 'ABACADA';
if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    http_response_code(403);
    exit('Unauthorized access');
}

// DB Config
$host = 'localhost';
$user = 'django_user';
$pass = 'djangodbpass';
$dbname = 'laravel_db';

// Filename
date_default_timezone_set('Asia/Manila');
$timestamp = date("Y-m-d_H-i-s_A");
$filename = "{$dbname}_{$timestamp}_backup.sql";
$tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

// Dump Command (safest, fastest way)
$command = "mysqldump -h {$host} -u {$user} -p'{$pass}' {$dbname} > \"{$tempFile}\"";

// Execute MySQL dump directly
exec($command, $output, $returnVar);

// Handle error
if (!file_exists($tempFile) || $returnVar !== 0) {
    http_response_code(500);
    exit("Backup failed or mysqldump not available.");
}

// Clean output
if (ob_get_level()) {
    ob_end_clean();
}

// Send file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($tempFile) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($tempFile));

flush();
readfile($tempFile);
unlink($tempFile);
exit;
