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
        $date_start = $_GET['date_start'];
        $date_end = $_GET['date_end'];
        $data = (new ControllerBackup)->ctrMonthBackup($date_start, $date_end);
        
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
                        "'.date('F Y', strtotime($date_start)).'",
                        "'.date('M j D', strtotime($date_start))." - ". date('M j D', strtotime($date_end)).'"
                    ],';
                }
                $jsonData = substr($jsonData, 0, -1);
                $jsonData .= '] 
            }';
        echo $jsonData;
	}

    public function deleteMonthlyBackupTable(){
        $date_start = $_GET['date_start'];
        $date_end = $_GET['date_end'];
        $data_delete = (new ControllerBackup)->ctrDeleteMonthBackupAll($date_start, $date_end);
        
        if ($data_delete) {
            echo 'ok';
        } else {
            echo 'error';
        }
    }
        
   
	
}