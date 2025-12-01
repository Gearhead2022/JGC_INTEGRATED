<?php
require_once "connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class ModelDataBackup {

    static public function mdlGetBackupSummaries() {
        $stmt = (new Connection)->connect()->prepare("
            SELECT 
                DATE(backup_at) AS backup_at,
                MAX(time_at) AS time_at,
                created_by AS backup_by,
                COUNT(*) AS total_backups,
                COUNT(DISTINCT database_name) AS distinct_databases,
                MAX(DATE(download_at)) AS download_at,
                MIN(data_id) AS data_id
            FROM data_backup_log
            GROUP BY DATE(backup_at), created_by
            ORDER BY created_by DESC, backup_at
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlShowDataBAckup($data_id) {
        $stmt = (new Connection)->connect()->prepare("
            SELECT * 
            FROM data_backup_log 
            WHERE data_id = :data_id
        ");

        $stmt->bindParam(':data_id', $data_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    static public function mdlHandleUpdateDataFiles($backup_at, $dbname) {
        $conn = (new Connection)->connect();

        $sql = "SELECT data_id FROM data_backup_log WHERE backup_at = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$backup_at]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['data_id'])) {
            $data_id = $row['data_id'];
            $db_name_now = $dbname;

            $sql = "SELECT * FROM data_backup_log WHERE data_id = ? AND database_name = ? ORDER BY id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$data_id, $db_name_now]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && isset($row['data_id'])) {
                $pathToDelete = "{$row['file_path']}/{$row['file_name']}";
                $sql = "DELETE FROM data_backup_log WHERE data_id = ? AND database_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$data_id, $db_name_now]);

                if (file_exists($pathToDelete)) {
                    unlink($pathToDelete);
                }
            }

            return $data_id;
        } else {
            // Generate new data_id
            $sql = "SELECT data_id FROM data_backup_log ORDER BY id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $newNumeric = isset($row['data_id'])
                ? ((int)substr($row['data_id'], 4)) + 1
                : 1;

            $data_id = 'DATA' . str_pad($newNumeric, 5, '0', STR_PAD_LEFT);
            return $data_id;
        }
    }


     static public function mdlHandleUpdateDatabase($data_id,
        $dbname,
        $filename,
        $filePath,
        $backup_user,
        $backup_at,
        $time_at) {

        $stmt = (new Connection)->connect()->prepare("INSERT INTO data_backup_log (data_id, database_name, file_name, file_path, created_by, backup_at, time_at)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data_id,
                $dbname,
                $filename,
                $filePath,
                $backup_user,
                $backup_at,
                $time_at
            ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
}
