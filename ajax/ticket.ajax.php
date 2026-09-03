<?php
require_once "../controllers/ticket.controller.php";
require_once "../models/ticket.model.php";
require_once "../views/modules/session.php";

	$ticket = new ticketTable();
    $ticket -> ShowTicketTable();
 
class ticketTable{
	




	public function showTicketTable(){
		// $account_no = $_GET['$account_no'];
		$type = $_SESSION['type'];
		$ticketData = (new ControllerTicket)->ctrShowTicket();
        if (empty($ticketData)) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
		
			
		$jsonData = '{"data":[';
			for ($i = 0; $i < count($ticketData); $i++) { 
				if($type == "admin"){
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='View'  class='btn btn-sm btn-success waves-effect waves-light btnViewTicket' index_id='".$ticketData[$i]["index_id"]."' id='".$ticketData[$i]["id"]."' branch_name='".$ticketData[$i]["branch_name"]."'name='".$ticketData[$i]["name"]."'terms='".$ticketData[$i]["total_terms"]."'  area_code='".$ticketData[$i]["area_code"]."' tdate='".$ticketData[$i]["tdate"]."'>VIEW</button><button data-toggle='tooltip' data-placement='top' title='Delete'  class='btn btn-sm btn-danger waves-effect waves-light btnDeleteClient' idClient='".$ticketData[$i]["index_id"]."'><i style='font-size: 15px;'  class='fa fa-trash'></i></button></div>";
				}else{
					$buttons =  "<div class='btn-group group-round m-1'><button data-toggle='tooltip' data-placement='top' title='View'  class='btn btn-sm btn-success waves-effect waves-light btnViewTicket' index_id='".$ticketData[$i]["index_id"]."' id='".$ticketData[$i]["id"]."' branch_name='".$ticketData[$i]["branch_name"]."'name='".$ticketData[$i]["name"]."'terms='".$ticketData[$i]["total_terms"]."'  area_code='".$ticketData[$i]["area_code"]."' tdate='".$ticketData[$i]["tdate"]."'>VIEW</button></div>";
				}
			
				$jsonData .= '[
					"'.$ticketData[$i]["id"].'",    
					"'.$ticketData[$i]["name"].'", 
					"'.$ticketData[$i]["branch_name"].'",                     
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