<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";

	$activateClients = new pdrRecords();
	$activateClients -> showPDRDataList();

class pdrRecords{
	public function showPDRDataList(){

		if (isset($_SESSION['branch_name'])) {
			$branch_name = $_SESSION['branch_name'];
		} else {
			$branch_name = 'All';
		}

		$PDRColl = (new ControllerPDRColl)->ctrShowAllPDRList($branch_name);
		if(count($PDRColl) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($PDRColl); $i++){
					
					$buttons =  "<div class='btn-group group-round m-1'><button type='button' data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm border border-warning border-3 btn-transparent w-5 text-warning waves-effect waves-light btnProccessPDRCollection' account_no='".$PDRColl[$i]["account_no"]."' tdate='".$PDRColl[$i]['tdate']."'  branch_name='".$PDRColl[$i]["branch_name"]."' >PROCCESS</button><button type='button' data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-transparent border border-3 border-danger waves-effect waves-light btnDeletePDRCollection' account_no='".$PDRColl[$i]["account_no"]."' tdate='".$PDRColl[$i]['tdate']."' id='".$PDRColl[$i]["id"]."'   branch_name='".$PDRColl[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa text-danger fa-trash'></i></button></div>";

					// $buttons =  "<div class='btn-group group-round m-1'><button type='button' data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm border border-warning border-3 btn-transparent w-5 text-warning waves-effect waves-light btnProccessPDRCollection' account_no='".$PDRColl[$i]["account_no"]."' tdate='".$PDRColl[$i]['tdate']."'  branch_name='".$PDRColl[$i]["branch_name"]."' >PROCCESS</button><button type='button' data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm border border-info border-3 btn-transparent w-5 text-info waves-effect waves-light btnProccessPDRCollection' account_no='".$PDRColl[$i]["account_no"]."' tdate='".$PDRColl[$i]['tdate']."'  branch_name='".$PDRColl[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa text-info fa-pencil'></i></button><button type='button' data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-transparent border border-3 border-danger waves-effect waves-light btnDeletePDRCollection' account_no='".$PDRColl[$i]["account_no"]."' tdate='".$PDRColl[$i]['tdate']."'   branch_name='".$PDRColl[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa text-danger fa-trash'></i></button></div>";

					// $buttons =  "";
					$jsonData .='[
						"'.$buttons.'",
						"'.$PDRColl[$i]["account_no"].'",
                        "'.$PDRColl[$i]["last_name"].', '.$PDRColl[$i]["first_name"].'",
						"'.$PDRColl[$i]["status"].'",
						"'.$PDRColl[$i]["edate"].'",
						"'.$PDRColl[$i]["tdate"].'",
						"'.$PDRColl[$i]["ref"].'",
						"'.$PDRColl[$i]["prev_bal"].'",
						"'.$PDRColl[$i]["amt_credit"].'",
						"'.$PDRColl[$i]["amt_debit"].'",
						"'.$PDRColl[$i]["end_bal"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

