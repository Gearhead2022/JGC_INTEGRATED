<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";

	$activateClients = new pdrRecords();
	$activateClients -> showPDRDataList();

class pdrRecords{
	public function showPDRDataList(){

		if (isset($_SESSION['branch_name'])) {
			$branch_name = $_SESSION['branch_name'];
		} else {
			$branch_name = 'All';
		}

        if (isset($_GET['fromdate']) && $_GET['fromdate'] != "" && isset($_GET['todate']) && $_GET['todate'] != "") {
            $branch_name = $_SESSION['branch_name'];
            $fromdate = $_GET['fromdate'];
			$todate = $_GET['todate'];

			$report = "NO";

            $PDRColl = (new ControllerPDRColl)->ctrShowAllFilterArchivePDRList($branch_name, $fromdate, $todate, $report);

        } else {
            // $PDRColl = (new ControllerPDRColl)->ctrShowAllArchivePDRList($branch_name);
			$PDRColl = array();
        }
        
		if(count($PDRColl) == 0){
			$jsonData = '{"data":[]}';
			echo $jsonData;
			return;
		}
		$jsonData = '{
			"data":[';
				for($i=0; $i < count($PDRColl); $i++){
				    
				    if ($PDRColl[$i]["p_status"] == 'disabled') {
						$p_status = 'disabled';
					} else {
						$p_status = '';
					}
					
					$buttons =  "<div class='btn-group group-round m-1'><button type='button' $p_status data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-transparent border border-3 border-danger text-danger waves-effect waves-light btnDeletePDRCollectionArchive'  account_no='".$PDRColl[$i]["account_no"]."' ref='".$PDRColl[$i]["ref"]."' tdate='".$PDRColl[$i]["tdate"]."' branch_name='".$PDRColl[$i]["branch_name"]."' ><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";

					// $buttons =  "";
					$jsonData .='[
						"'.$buttons.'",
						"'.$PDRColl[$i]["account_no"].'",
                        "'.$PDRColl[$i]["last_name"].', '.$PDRColl[$i]["first_name"].'",
						"'.$PDRColl[$i]["status"].'",
						"'.$PDRColl[$i]["edate"].'",
						"'.$PDRColl[$i]["tdate"].'",
						"'.$PDRColl[$i]["ref"].'",
						"'.$PDRColl[$i]["prev_bal"].'",
						"'.$PDRColl[$i]["credit"].'",
						"'.$PDRColl[$i]["debit"].'",
						"'.$PDRColl[$i]["end_bal"].'"
					],';
				}
				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 
			}';
		echo $jsonData;
	}
	
}

