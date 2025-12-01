<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$monthlyAgent = new monthlyAgentTable();
$monthlyAgent -> showTableMonthlyAgent();
//$monthlyAgent -> showTableMonthlyBegAgent();



 
class monthlyAgentTable{
	public function showTableMonthlyAgent(){
		$branch_name = $_SESSION['branch_name'];
		$check = (new ControllerPensioner)->ctrMonthlyAgentAjax($branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
					$mdate = $check[$i]['mdate'];
					$id = $check[$i]['id'];

					$buttons =  "<div class='btn-group group-round m-1 text-center'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' id='".$check[$i]["id"]."' id='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' id='".$check[$i]["id"]."' id='".$check[$i]["id"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["mdate"].'",
						"'.$check[$i]["agents"].'",
                        "'.$check[$i]["sales"].'",
						"'.$buttons.'"		        			
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}








	
	
}

