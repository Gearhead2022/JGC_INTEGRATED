<?php
require_once "../controllers/account.controller.php";
require_once "../models/account.model.php";
require_once "../views/modules/session.php";
$checklist = new ChecklistTable();
$checklist->showChecklistTable();
class ChecklistTable {
    public function showChecklistTable() {
        $requests = (new ControllerAccounts)->ctrShowIDLedger();
        if (empty($requests)) {
            echo json_encode(["data" => []]);
            return;
        }
        // Process data correctly
        $data = [];
        foreach ($requests as $request) {
            if(  $request["is_approved"] == 1){
                $is_approved = '<span class="badge badge-success success">APPROVED</span>';
            } else {
                $is_approved = '<span class="badge badge-danger success">REJECTED</span>';
            }
            $request_date = new DateTime($request["request_time"]);
            $request_time = $request_date->format("F d, Y \a\\t h:i:s A");

            $time_change = new DateTime($request["time_change"]);
            $approve_time = $time_change->format("F d, Y \a\\t h:i:s A");
            $data[] = [
                $request["id"],
                $request["username"],
                $request["full_name"],
                $request_time,
                $is_approved,
                $approve_time,
                $request["coordinator"],
            ];
        }
        // Encode data properly as JSON
        echo json_encode(["data" => $data]);
    }
}
?>
