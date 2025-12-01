<?php
require_once "../controllers/soa.controller.php";
require_once "../models/soa.model.php";
require_once "../views/modules/session.php";

$filterBackup= new reportTable();
$filterBackup -> saveSOAData();

class reportTable{
	public function saveSOAData(){
 
        $account_no = $_GET['account_no'];
        $name = $_GET['name'];
        $address = $_GET['address'];
        $bank = $_GET['bank'];
        $pension = $_GET['pension'];
        $principal = $_GET['principal'];
        $change = $_GET['change'];
        $interest = $_GET['interest'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $others = $_GET['others'];
        $baltot = $_GET['baltot'];
        $bcode = $_GET['bcode'];
        $note = $_GET['note'];

        $data = array(
            'account_no' => $account_no,
            'name' => $name,
            'address' => $address,
            'bank' => $bank,
            'pension' => $pension,
            'lr' => $principal,
            'sl' => $change,
            'interest' => $interest,
            'from' => $from,
            'to' => $to,
            'others' => $others,
            'baltot' => $baltot,
            'branch_name' => $bcode,
            'note' => $note
        );
      
        $response = (new ControllerSOA)->ctrAddSOARecordById($data);
        
        if ($response === 'ok') {
            // Return 'ok' if the record is added successfully
            echo 'ok';
        } else if ($response === 'no_records') {
            // Return 'error' if there is an issue adding the record
            echo 'no_records';
        } else {
            echo 'error';
        }

    }
   
}