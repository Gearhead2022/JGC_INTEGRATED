<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";
$pastdue = new ledgerTable();
$pastdue -> showLedgerTable();

class ledgerTable{
	public function showLedgerTable(){

        $account_no = $_GET['account_no'];
        $branch_name = $_SESSION['branch_name'];
	
		$check = (new ControllerPDRColl)->ctrShowPastDueLedger($account_no, $branch_name);
		if(count($check) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($check); $i++){
                    
						// $buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditClient' ='".$check[$i]["id"]."'>EDIT</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$idClient."'  id='".$check[$i]["id"]."' account_no='".$check[$i]["account_no"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
					$jsonData .='[	
                        "'.$check[$i]["account_no"].'",
                        "'.$check[$i]["last_name"].', '.$check[$i]["first_name"].'",
                        "'.$check[$i]["date"].'",
                        "'.$check[$i]["refno"].'",
                        "'.$check[$i]["debit"].'",
						"'.$check[$i]["credit"].'"
						
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}	
	
}

