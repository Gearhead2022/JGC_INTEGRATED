<?php
require_once "../controllers/account.controller.php";
require_once "../models/account.model.php";
require_once "../views/modules/session.php";
$type = $_GET['type'];
$login= new loginModal();
if($type == "showTable"){
    $login->showLoginTable();    
}
class loginModal{
	public function showLoginTable(){
        $data = (new ControllerAccounts)->ctrShowIDLedger();
        
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}