<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";
$pastdue = new pastdueTable();
$pastdue -> showPastDueTable();

class pastdueTable{
	public function showPastDueTable(){
        $branch_name = $_SESSION['branch_name'];
		$check = (new ControllerPDRColl)->ctrShowPastDue($branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
                    $fullname = $check[$i]["last_name"].", ".$check[$i]["first_name"]." ".$check[$i]["middle_name"];
					
					
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-transparent border-1 border-info text-info waves-effect waves-light btnViewPastDue' account_no='".$check[$i]["account_no"]."' branch_name='".$check[$i]["branch_name"]."' >VIEW</button></div>";
					$jsonData .='[	
                        "'.$buttons.'",
                        "'.$check[$i]["account_no"].'",
                        "'.$fullname.'",
                        "'.$check[$i]["type"].'",
						"'.$check[$i]["class"].'",
                        "'.$check[$i]["bank"].'",
                        "'.$check[$i]["refdate"].'",
                        "'.$check[$i]["branch_name"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
	
}

