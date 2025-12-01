<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../models/connection.php";
require_once "../views/modules/session.php";

$account_no = $_REQUEST['account_no'];
$branch_name = $_SESSION['branch_name'];

$checkAccntModal= (new ModelPDRCollection)->mdlAccountIDChecker($account_no, $branch_name);

if ($checkAccntModal == 'yes') {
    echo 'used';
} else {
    echo 'unsused';
}
