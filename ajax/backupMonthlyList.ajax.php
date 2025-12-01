<?php
require_once "../controllers/backup.controller.php";
require_once "../models/backup.model.php";
require_once "../views/modules/session.php";

$backupList= new backupTable();

if(isset($_GET['action']) && $_GET['action'] == "list_all"){
	$backupList -> showMonthlyBackupTable();
}elseif(isset($_GET['action']) && $_GET['action'] == "delete_all"){
	$backupList -> deleteMonthlyBackupTable();
}

class backupTable{
	
	public function showMonthlyBackupTable(){
        $backup_month = $_GET['backup_month'];
        $data = (new ControllerBackup)->ctrMonthBackup($backup_month);
        
    // print_r($BNKCHCK);
    if(empty($data)){
        $jsonData = '{"data":[]}';
        echo $jsonData;
        return;
        }
        $jsonData = '{
            "data":[';
                for($i=0; $i < count($data); $i++){

                    $jsonData .='[
                        
                        "'.$data[$i]["full_name"].'",
                        "'.$data[$i]["count"].'",
                        "'.date('F Y', strtotime($backup_month)).'"
                    ],';
                }
                $jsonData = substr($jsonData, 0, -1);
                $jsonData .= '] 
            }';
        echo $jsonData;
	}

    public function deleteMonthlyBackupTable(){
        $backup_month = $_GET['backup_month'];
        $data_delete = (new ControllerBackup)->ctrDeleteMonthBackupAll($backup_month);
        
        if ($data_delete) {
            echo 'ok';
        } else {
            echo 'error';
        }
    }
        
   
	
}