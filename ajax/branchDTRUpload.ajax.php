<?php
require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";

$operationAPH = new operationDailyAvailmentsTable();
$operationAPH -> showOperationDailyAvailmentsTable();

class operationDailyAvailmentsTable{
	public function showoperationDailyAvailmentsTable(){

        $branch_name = $_SESSION['branch_name'];
		$aph = (new ControllerDtr)->ctrShowBranchDailyDTRUpload($branch_name);
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
						$buttons =  "<div  class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditBranchDTR' id='".$aph[$i]["id"]."' entry_date='".$aph[$i]["entry_date"]."'  branch_name='".$aph[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-pencil'></i></button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteBranchDTR' id='".$aph[$i]["id"]."' entry_date='".$aph[$i]["entry_date"]."'  branch_name='".$aph[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					}else{	
						$status  ="<p class='badge badge-primary' style='font-size: 12px;'>RECEIVED</p>";
						$buttons =  "<div  class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='View'  class='btn btn-sm btn-success waves-effect waves-light btnViewBranchDTR' id='".$aph[$i]["id"]."' entry_date='".$aph[$i]["entry_date"]."'  branch_name='".$aph[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-eye'></i></button></div>";
					}

					$format_date = date("M d, Y", strtotime($aph[$i]["entry_date"]));

					$format_date_received = $aph[$i]["date_received"];

						$jsonData .='[
							"'.$buttons.'",
					    "'.$aph[$i]["branch_name"].'",
						"'.$aph[$i]["entry_subj"].'",
						"'.$aph[$i]["entry_file"].'",
						"'.$format_date.'",
                        "'.$status.'",
						"'.$format_date_received.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

}

