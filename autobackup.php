<?php
require_once "views/modules/session.php";
require_once "models/connection.php";

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '1024M');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$backup_user = $_SESSION['branch_name'] ?? 'SYSTEM';

// $secretKey = 'ABACADA';
// if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
//     http_response_code(403);
//     exit('Unauthorized access');
// }

$host = 'localhost';
$user = 'django_user';
$pass = 'djangodbpass';

$databases = ['emb_appform2', 'dtr_fr_db', 'jgc_dtr_db', 'nah_db', 'sgi_db', 'fleet_management'];

date_default_timezone_set('Asia/Manila');
$year = date("Y");
$month = date("M");
$day = date("d");
$backupDir = __DIR__ . "/data_backups/{$year}/{$month}/{$day}";

if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

foreach ($databases as $dbname) {
    $mysqlConn = new mysqli($host, $user, $pass, $dbname);
    if ($mysqlConn->connect_error) {
        error_log("Failed to connect to $dbname: " . $conn->connect_error);
        continue;
    }

    $tables = [];
    $result = $mysqlConn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $outsql = '';
    foreach ($tables as $table) {
        $res = $mysqlConn->query("SHOW CREATE TABLE `$table`");
        $row = $res->fetch_row();
        $outsql .= "\n\n" . $row[1] . ";\n\n";

        $res = $mysqlConn->query("SELECT * FROM `$table`");
        while ($data = $res->fetch_assoc()) {
            $vals = array_map(function ($val) use ($mysqlConn) {
    		return isset($val) ? "'" . $mysqlConn->real_escape_string($val) . "'" : "NULL";}, array_values($data));

            $vals = array_map(function ($val) {
                return isset($val) ? "'$val'" : "NULL";
            }, $vals);
            $outsql .= "INSERT INTO `$table` VALUES(" . implode(',', $vals) . ");\n";
        }
        $outsql .= "\n";
    }

    $filename = "{$dbname}_backup.sql";
    $filePath = "{$backupDir}";
    $fullFilePath = "{$filePath}/{$filename}";
    file_put_contents("{$filePath}/{$filename}", $outsql);

    $backup_at = date('Y-m-d');
    $time_at = date('h:i:s');

	$conn = (new Connection)->connect();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT data_id FROM data_backup_log WHERE backup_at = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$backup_at]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && isset($row['data_id'])) {
        $data_id = $row['data_id'];
        $db_name_now = $dbname;

        $sql2 = "SELECT * FROM data_backup_log WHERE data_id = '$data_id' AND database_name = '$db_name_now' ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql2);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

         if ($row && isset($row['data_id'])) {
            $pathToDelete = "{$row['file_path']}/{$row['database_name']}";
            $sql3 = "DELETE FROM data_backup_log WHERE data_id = '$data_id' AND database_name = '$db_name_now'";
            $stmt = $conn->prepare($sql3);
            $stmt->execute();

            if (file_exists($pathToDelete)) {
                unlink($pathToDelete);
            }
        } 
    } else {
        $sql4 = "SELECT data_id FROM data_backup_log ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql4);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['data_id'])) {
            $lastNumeric = (int)substr($row['data_id'], 4);
            $newNumeric = $lastNumeric + 1;
        } else {
            $newNumeric = 1;
        }
        $data_id = 'DATA' . str_pad($newNumeric, 5, '0', STR_PAD_LEFT);
    }

    // file_put_contents($fullFilePath, $outsql);

    try {
        $stmt = $conn->prepare("INSERT INTO data_backup_log 
            (data_id, database_name, file_name, file_path, created_by, backup_at, time_at, download_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
        $stmt->execute([
            $data_id,
            $dbname,
            $filename,
            $filePath,
            $backup_user,
            $backup_at,
            $time_at,
            null
        ]);
    
        echo "✅ Log inserted: [$data_id, $dbname]<br><br>";
    } catch (PDOException $e) {
        echo "❌ Failed to insert log for $dbname: " . $e->getMessage() . "<br><br>";
    }
    

}

exit;
