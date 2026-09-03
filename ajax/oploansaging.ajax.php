<?php
require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";
require_once "../views/modules/session.php";
$operation = new operationTable();
$operation -> showOperationTable();

class operationTable{
	public function showOperationTable(){
        $branch_name = $_SESSION['branch_name'];
		$check = (new ControllerOperation)->ctrShowTotalLoanAging($branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		} 
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    $date = $check[$i]["date"];
                    $total_sl = $check[$i]["total_sl"];
                    $total_lr = $check[$i]["total_lr"];
                    $total_slFormat = number_format((float)abs($total_sl), 2, '.', ',');
                    $total_lrFormat = number_format((float)$total_lr, 2, '.', ',');
                    $dateFormat = date("F Y", strtotime($date));

					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' date='".$check[$i]["date"]."' branch_name='".$check[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["branch_name"].'",
						"'.$dateFormat.'",
						"'.$check[$i]["total_ssp"].'",
						"'.$total_slFormat.'",
						"'.$total_lrFormat.'",
						"'.$buttons.'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

