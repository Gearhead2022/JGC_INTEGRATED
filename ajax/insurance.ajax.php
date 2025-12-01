<?php
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";
$record = new accountTable();
$record -> showInsuranceTable();


 
class accountTable{
	public function showInsuranceTable(){
		$account = (new ControllerInsurance)->ctrShowInsurance();
		if(count($account) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($account); $i++){
				$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' idClient='".$account[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$account[$i]["id"]."' account_id='".$account[$i]["account_id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$account[$i]["account_id"].'",
						"'.$account[$i]["name"].'",
                        "'.$account[$i]["branch_name"].'",
                        "'.$account[$i]["avail_date"].'",
                        "'.$account[$i]["expire_date"].'",
                        "'.$account[$i]["amount"].'",
                        "'.$account[$i]["ins_type"].'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

