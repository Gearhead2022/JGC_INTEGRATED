<?php
require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";

$operationAPH = new operationDailyAvailmentsTable();
$operationAPH -> showOperationDailyAvailmentsTable();

class operationDailyAvailmentsTable{
	public function showoperationDailyAvailmentsTable(){

		$aph = (new ControllerDtr)->ctrShowHRDailyDTRDownload();
		if(count($aph) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		} 
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($aph); $i++){

					$chk_status = $aph[$i]["status"];

					if($chk_status == "pending"){
						$status  ="<p class='badge badge-success' style='font-size: 12px;'>PENDING</p>";
					}else{	
						$status  ="<p class='badge badge-primary' style='font-size: 12px;'>RECEIVED</p>";
					}

					$format_date = date("M d, Y", strtotime($aph[$i]["entry_date"]));

					$received_date = $aph[$i]["date_received"];
					// $timezone = new DateTimeZone("Asia/Manila");

					// $datetime = DateTime::createFromFormat("Y-m-d h:i:s A", $received_date, $timezone);

					// if ($datetime === false) {
					// 	$format_date_received = '';
					// } else {
					// 	$format_date_received = $datetime->format("M d, Y");
					// }
                    
					$buttons =  "<div  class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Download'  class='btn btn-sm btn-danger waves-effect waves-light btnDownloadBranchDTR' id='".$aph[$i]["id"]."' entry_date='".$aph[$i]["entry_date"]."' entry_file='".$aph[$i]["entry_file"]."' branch_name='".$aph[$i]["branch_name"]."' >DOWNLOAD</i></button></div>";
						$jsonData .='[
							"'.$buttons.'",
					    "'.$aph[$i]["branch_name"].'",
						"'.$aph[$i]["entry_subj"].'",
						"'.$aph[$i]["entry_file"].'",
						"'.$format_date.'",
                        "'.$status.'",
						"'.$received_date.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

}

