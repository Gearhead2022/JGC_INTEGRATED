<?php
require_once "../controllers/soa.controller.php";
require_once "../models/soa.model.php";
require_once "../views/modules/session.php";
$filterSummary= new reportTable();
$filterSummary -> showDataFromSelectedID();

class reportTable{
	public function showDataFromSelectedID(){

        if (isset($_GET['account_no'])) {

            date_default_timezone_set('Asia/Manila');

            $account_no = trim($_GET['account_no']);
            $branch_name = trim($_GET['branch_name']);
            $toDatemonth = date('n', time());
            $toDateyear = date('Y', time());

            $check_soa = (new ModelSOA)->mdlCheckIExist($account_no, $branch_name, $toDatemonth, $toDateyear);

            if ($check_soa === "exist") {
                $dataList = array();
            } else {
                $dataList = (new ControllerSOA)->ctrGetSOARecordsById($account_no, $branch_name);
            }
        
            $data = array();
        
            if (!empty($dataList)) {
                foreach ($dataList as $key => $item) {

                    $data['account_no'] = $item["account_no"];
                    $data['name'] = $item["name"];
                    $data['address'] = $item["address"];
                    $data['bank'] = $item["bank"];
                    $data['pension'] = $item["pension"];
                    $data['principal'] = $item["principal"];
                    $data['change'] = $item["change"];   
                }
                
            } else {
                
                    $data['account_no'] = '';
                    $data['name'] = '';
                    $data['address'] = '';
                    $data['bank'] = '';
                    $data['pension'] = '';
                    $data['principal'] = '';
                    $data['change'] = '';
            }
        
            echo json_encode($data);
        }

	}
	
}