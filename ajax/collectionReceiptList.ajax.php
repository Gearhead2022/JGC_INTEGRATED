<?php
require_once "../controllers/orprinting.controller.php";
require_once "../models/orprinting.model.php";
require_once "../views/modules/session.php";

	$activateClients = new pinRecords();
	$activateClients -> showPinDataList();

class pinRecords{
	public function showPinDataList(){

        if (isset($_GET['collDate'])) {
			$collDate = date('Y-m-d', strtotime($_GET['collDate']));
		} else {
			$collDate = '';
		}

		if ($_SESSION['branch_name'] != "") {
          
            $branch_name = $_SESSION['branch_name'];

        } else {
            $branch_name = 'admin';

        }

		$List = (new ControllerORPrinting)->ctrGetAllCollectionReceiptList($collDate, $branch_name);
		if(empty($List)){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($List); $i++){
					
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditReceipt' tdate='".date("Ymd", strtotime($List[$i]["tdate"]))."' account_id='".$List[$i]["account_id"]."' >Print</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteReceipt' tdate='".date("Ymd", strtotime($List[$i]["tdate"]))."' account_id='".$List[$i]["account_id"]."'  id='".$List[$i]["id"]."'  ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";

					$jsonData .='[
						"'.$buttons.'",
                        "'.$List[$i]["rdate"].'",
                        "'.$List[$i]["name"].'",
						"'.number_format($List[$i]["amount"], 2, '.', '').'",
						"",
						"'.number_format($List[$i]["biramt"], 2, '.', '').'",
						"'.$List[$i]["tdate"].'",
						"'.$List[$i]["ttime"].'"

					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

