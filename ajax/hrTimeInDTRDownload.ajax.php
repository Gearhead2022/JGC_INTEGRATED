<?php
require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";

$operationAPH = new HRDailyTimeInDTR();
$operationAPH -> showHRDailyTimeInDTRDownloadTable();

class HRDailyTimeInDTR{
	public function showHRDailyTimeInDTRDownloadTable(){

		$aph = (new ControllerDtr)->ctrShowHRDailyTimeInDTRDownload();
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
						$status  ="<p class='badge badge-primary' style='font-size: 12px;'>CHECKED</p>";
					}

					$format_date = date("M d, Y", strtotime($aph[$i]["entry_date"]));

					$received_date = $aph[$i]["date_received"];
                    
					$buttons =  "<div  class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Check' class='btn btn-sm btn-success waves-effect waves-light btnDecryptBranchDTR' id='".$aph[$i]["id"]."' entry_date='".$aph[$i]["entry_date"]."' entry_file='".$aph[$i]["entry_file"]."' branch_name='".$aph[$i]["branch_name"]."' >CHECK</i></button></div>";
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

