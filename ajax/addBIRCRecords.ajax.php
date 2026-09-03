<?php
require_once "../controllers/orprinting.controller.php";
require_once "../models/orprinting.model.php";
require_once "../views/modules/session.php";

$filterBackup = new reportTable();
$filterBackup->saveORData();

class reportTable {
    public function saveORData() {
       
            // Get the data from the POST request
            $rdate = $_GET['rdate'];
            $name = $_GET['name'];
            $amtwrd = $_GET['amtwrd'];
            $amount = $_GET['amount'];
            $birsales = $_GET['birsales'];
            $biramt = $_GET['biramt'];
            $birdue = $_GET['birdue'];
            $tdate = $_GET['tdate'];
            $ttime = $_GET['ttime'];
            $desc = $_GET['desc'];
            $account_id = $_GET['account_id'];
            $month = $_GET['month'];
            $day = $_GET['day'];
            $yr = $_GET['yr'];
            $branch_name = $_GET['branch_name'];

            // Prepare the data array
            $data = array(
                "rdate" => $rdate,
                "name" => $name,
                "amtwrd" => $amtwrd,
                "amount" => $amount,
                "birsales" => $birsales,
                "biramt" => $biramt,
                "birdue" => $birdue,
                "tdate" => $tdate,
                "ttime" => $ttime,
                "desc" => $desc,
                "account_id" => $account_id,
                "month" => $month,
                "day" => $day,
                "yr" => $yr,
                "branch_name" => $branch_name
            );

            // Call the model method to add the record
            $response = (new ControllerORPrinting)->ctrAddBIRRECRecord($data);

            // Return response based on the result
            if ($response === 'ok') {
                echo 'ok'; // Return 'ok' if the record is added successfully
            } else if ($response === 'no_records') {
                echo 'no_records'; // Return 'no_records' if there are no records
            } else {
                echo 'error'; // Return 'error' for other cases
            }
       
    }
}
?>
