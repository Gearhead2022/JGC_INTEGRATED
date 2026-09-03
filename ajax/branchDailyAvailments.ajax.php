<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";

$operationAPH = new operationDailyAvailmentsTable();
$operationAPH -> showOperationDailyAvailmentsTable();

class operationDailyAvailmentsTable{
	public function showoperationDailyAvailmentsTable(){

        $branch_name = $_SESSION['branch_name'];
		$aph = (new ControllerPensioner)->ctrShowOperationDailyAvailments($branch_name);
		if(count($aph) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		} 
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($aph); $i++){
				
					$buttons =  "<div  class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteAPH' id='".$aph[$i]["id"]."' uploaded_date='".$aph[$i]["uploaded_date"]."'  branch_name='".$aph[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
						$jsonData .='[
					    "'.$aph[$i]["branch_name"].'",
						"'.$aph[$i]["entry_data"].'",
						"'.$aph[$i]["date"].'",
						"'.$aph[$i]["uploaded_date"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}

}

