<?php

require_once "../controllers/orprinting.controller.php";
require_once "../models/orprinting.model.php";
require_once "../views/modules/session.php";

class BatchBIRREC
{
    public function saveRecords()
    {
        if (empty($_POST['records'])) {
            echo "error";
            return;
        }

        $records = json_decode(
            $_POST['records'],
            true
        );

        if (!is_array($records)) {
            echo "error";
            return;
        }

        foreach ($records as $data) {

            $response = (new ControllerORPrinting)->ctrAddBIRRECRecord($data);

            if ($response !== "ok") {
                echo "error";
                return;
            }
        }

        echo "ok";
    }
}

$batch = new BatchBIRREC();
$batch->saveRecords();