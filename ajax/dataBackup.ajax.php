<?php
require_once "../controllers/databackup.controller.php";
require_once "../models/databackup.model.php";
require_once "../views/modules/session.php";
$backupList= new dataBackupTable();
$backupList -> showDataBackupTable();

class dataBackupTable{
	
	public function showDataBackupTable(){
		$backup = (new ControllerDataBackup)->ctrShowDataBackup();
		if(count($backup) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($backup); $i++){
					$date_downloaded = $backup[$i]["download_at"];
					
					if (isset($date_downloaded) && $date_downloaded != '' && $date_downloaded != '0000-00-00') {
						$status  = "<p class='badge badge-success' style='font-size: 10px;'>DOWNLOADED</p>";
						$formatted_download_date = date('Y-M-d', strtotime($date_downloaded));
					} else {    
						$status  = "<p class='badge badge-info' style='font-size: 10px;'>UNLOADED</p>";
						$formatted_download_date = '';
					}

					$backupAt = isset($backup[$i]["backup_at"]) ? date('Y-m-d', strtotime($backup[$i]["backup_at"])) : 'N/A';
					$timeAt = isset($backup[$i]["time_at"]) ? date('H:i', strtotime($backup[$i]["time_at"])) : 'N/A';

					$buttons = "<div class='btn-group group-round m-1'><button type='button' data-toggle='tooltip' data-placement='top' title='download' class='btn btn-sm btn-info waves-effect waves-light downloadFile' data_id='".$backup[$i]["data_id"]."'><i class='fa fa-download'></i></button><button type='button' data-toggle='tooltip' data-placement='top' title='download' class='btn btn-sm btn-danger waves-effect waves-light deleteFile' data_id='".$backup[$i]["data_id"]."'><i class='fa fa-trash'></i></button></div>";
				
					$jsonData .='[   
						"'.$backup[$i]["data_id"].'",
						"'.$backup[$i]["total_backups"].'",
						"'.$backup[$i]["backup_by"].'",
                        "'.$backupAt.' | '.$timeAt.' PM'.'",
						"'.$formatted_download_date.'",
						"'.$status.'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

