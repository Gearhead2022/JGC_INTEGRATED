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

		// $List = (new ControllerORPrinting)->ctrGetCollectionRecords('2023-11-06', $folderPaths);

		$List = (new ControllerORPrinting)->ctrGetCollectionRecords($collDate, $branch_name);
		if(empty($List)){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($List); $i++){

					$account_id = $List[$i]["account_id"];
					$cdate = $List[$i]["cdate"];
					$branch_name = $List[$i]["branch_name"];

					$checker = (new ModelORPrinting)->mdlCheckIfRecordExist($account_id, $cdate, $branch_name);
        
            		if($checker == "insert"){

						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Edit'  class='btn btn-sm btn-info waves-effect waves-light btnEditColl' data-account-id='" . $List[$i]["account_id"] . "' account_id='".$List[$i]["account_id"]."' cdate='".date("Ymd", strtotime($List[$i]["cdate"]))."'>Edit</button></div>";
					}else{
						$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Re-Edit'  class='btn btn-sm btn-danger waves-effect waves-light btnEditColl' account_id='".$List[$i]["account_id"]."' cdate='".date("Ymd", strtotime($List[$i]["cdate"]))."'>Re-Edit</button></div>";
					}

					$jsonData .='[
						"'.$buttons.'",
                        "'.$List[$i]["cdate"].'",
                        "'.$List[$i]["account_id"].'",
						"-------",
						"'.$List[$i]["mntheff"].'",
						"'.number_format($List[$i]["amount"], 2, '.', '').'",
						"'.$List[$i]["posted"].'",
						"'.$List[$i]["collstat"].'",
						"'.$List[$i]["bankno"].'",
                        "'.$List[$i]["balterm"].'",
						"'.number_format($List[$i]["atmbal"], 2, '.', '').'"
						
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

