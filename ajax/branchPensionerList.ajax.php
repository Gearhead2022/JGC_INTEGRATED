<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../models/connection.php";
$filterSummary= new reportTable();
$filterSummary -> showAllBranchPensionerList();

class reportTable{
	public function showAllBranchPensionerList(){
        $branch_session = $_SESSION['branch_name'];
        $check = (new ControllerPensioner)->ctrShowAllBranchPensionerList($branch_session);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm btn-info waves-effect waves-light btnEditPenAccnts' id='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeletePenAccnts' id='".$check[$i]["id"]."' branch_name='".$check[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["branch_name"].'",
                        "'.$check[$i]["penIn"].'",
						"'.$check[$i]["penOut"].'",
                        "'.$check[$i]["pen_ins_com"].'",
                        "'.$check[$i]["penDate"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}