<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../models/connection.php";
require_once "../views/modules/session.php";

$branch_name = $_REQUEST['branch_name'];

$OLRID = (new ModelPDRCollection)->mdlGetOLRIDSeries($branch_name);

if($OLRID === '0'){
    $id = '0001';
}else{
    $id = $OLRID;
}
$last_id = $id + 1;
$id_holder = str_repeat("0",4-strlen($last_id)).$last_id;  
echo $id_holder;