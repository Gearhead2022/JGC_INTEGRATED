<?php
require_once "../controllers/ticket.controller.php";
require_once "../models/ticket.model.php";
require_once "../views/modules/session.php";

	$ticket = new ticketTable();
    $ticket -> ShowTicketTable();
 
class ticketTable{
	public function showTicketTable(){
		// $account_no = $_GET['$account_no'];
		$ticketData = (new ControllerTicket)->ctrShowAcrhiveTicket();
        if (empty($ticketData)) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
			
		$jsonData = '{"data":[';
			for ($i = 0; $i < count($ticketData); $i++) { 
				$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='Print'  class='btn btn-sm btn-success waves-effect waves-light btnPrintTicket' index_id='".$ticketData[$i]["index_id"]."' id='".$ticketData[$i]["id"]."' branch_name='".$ticketData[$i]["branch_name"]."'name='".$ticketData[$i]["name"]."'terms='".$ticketData[$i]["total_terms"]."'  area_code='".$ticketData[$i]["area_code"]."' tdate='".$ticketData[$i]["tdate"]."'>PRINT</button></div>";
				$jsonData .= '[
					"'.$ticketData[$i]["id"].'",    
					"'.$ticketData[$i]["name"].'",                    
					"'.$ticketData[$i]["total_terms"].'",
					"'.$ticketData[$i]["tdate"].'",
					"'.$buttons.'"
				],';
			}
			$jsonData = substr($jsonData, 0, -1);
			$jsonData .= ']}';
			
		
		echo $jsonData;

	}
	
}









	// $check = (new ControllerTicket)->ctrShowTicket();
		// if(count($check) == 0){
		// 	$jsonData = '{"data":[]}';		
		// 	echo $jsonData;
		// 	return;
		// }

		// $jsonData = '{
		// 	"data":[';
		// 		for($i=0; $i < count($check); $i++){
                			
		// 			$jsonData .='[	
        //                 "'.$check[$i]["account_no"].'",                    
        //                 "'.$check[$i]["name"].'",
		// 				"'.$check[$i]["ticket"].'",
        //                 "'.$check[$i]["status"].'",	
		// 				"'.$check[$i]["branch_name"].'"				
		// 			],';
		// 		}
		// 		$jsonData = substr($jsonData, 0, -1);
		// 		$jsonData .= '] 
		// 	}';