<?php
require_once "../controllers/ticket.controller.php";
require_once "../models/ticket.model.php";
require_once "../views/modules/session.php";

$ticket = new ticketTable();
$ticket -> showTicketTable2();
$id = $_GET['id'];

class ticketTable{

	public function showTicketTable2(){
		$id = $_GET['id'];
		$ticketData = (new ControllerTicket)->ctrGetID($id);
        if (empty($ticketData)) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
			
		$jsonData = '{"data":[';
			for ($i = 0; $i < count($ticketData); $i++) { 
			
				
				$jsonData .= '[
					"'.$ticketData[$i]["id"].'",    
					"'.$ticketData[$i]["name"].'",                    
					"'.$ticketData[$i]["tdate"].'"
				],';
			}
			$jsonData = substr($jsonData, 0, -1);
			$jsonData .= ']}';
			
		
		echo $jsonData;

	}


}