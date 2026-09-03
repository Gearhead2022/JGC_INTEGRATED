<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";
$filterSummary= new reportTable();
$filterSummary -> showDataFromSelectedID();

class reportTable{
	public function showDataFromSelectedID(){

        if (isset($_GET['account_no'])) {

            $account_no = trim($_GET['account_no']);
            $branch_name = trim($_GET['branch_name']);
        
            $dates = (new ControllerPDRColl)->ctrGetPDRAccountInfoById($account_no,$branch_name);
        
            $data = array();
        
            if (!empty($dates)) {
                foreach ($dates as $key => $item) {

                    // if ($item["prev_bal"] != 0) {
                    //     $prev_bal = $item["prev_bal"];
                    // } else {
                    //     $prev_bal = $item["balance"];
                    // }
                    
                    $data['due_id'] = $item["due_id"];
                    $data['account_no'] = $item["account_no"];
                    $data['first_name'] = $item["first_name"];
                    $data['last_name'] = $item["last_name"];
                    $data['middle_name'] = $item["middle_name"];
                    $data['status'] = trim($item["class"]);
                    $data['edate'] = trim($item["refdate"]);
                    // $data['tdate'] = $item["date"];
                    $data['ref'] = "";
                   $data['prev_bal'] = floatval(str_replace(',', '', $item["prev_bal"]));
                    // $data['amt_paid'] = floatval(str_replace(',', '', $item['amt_paid']));
                    // $data['end_bal'] = floatval(str_replace(',', '', $item['end_bal']));
                    $data['branch_name'] = $item["branch_name"];

                }
            } else {
                
                    $data['due_id'] = '';
                    $data['account_no'] = '';
                    $data['first_name'] = '';
                    $data['last_name'] = '';
                    $data['middle_name'] = '';
                    $data['status'] = '';
                    $data['edate'] = '';
                    $data['tdate'] = '';
                    $data['ref'] = '';
                    $data['prev_bal'] = '';
                    // $data['amt_paid'] = '';
                    // $data['end_bal'] = '';
                    // $data['branch_name'] = '';
            }
        
            echo json_encode($data);
        }

	}
	
}