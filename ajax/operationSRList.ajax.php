<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$filterSummary= new reportTable();
$filterSummary -> showAllSalesRepresentative();

class reportTable{
	public function showAllSalesRepresentative(){


        $check = (new ControllerPensioner)->ctrShowAllSalesRepresentative();
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit' class='btn btn-sm btn-info waves-effect waves-light btnEditSalesRep' id='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteSalesRep' id='".$check[$i]["id"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["branch_name"].'",
                        "'.$check[$i]["rep_fname"].'",
						"'.$check[$i]["rep_lname"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}