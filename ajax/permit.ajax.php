<?php
header('Content-Type: application/json');
require_once "../controllers/permit.controller.php";
require_once "../models/permit.model.php";
require_once "../views/modules/session.php";

// Always start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$type = $_SESSION['type'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$filter = $_GET['filterDate'] ?? null;
$filterType = $_GET['filterType'] ?? null;

$rows = [];


if ($type === "wp_user") {
    $rows = (new ControllerPermits)->ctrShowPermit($user_id, $filterType);
} elseif (in_array($type, [
    "admin", 
    "wp_admin",
    "wp_approve",
    "wp_accounting",
    "wp_operation", 
    "wp_hrom",
    "wp_financial",
    "wp_audit",
    "wp_credit",
    "wp_grcd",
    "wp_pspmi",
    "wp_pspmi_admin",
    "wp_mis"])) {
    $rows = (new ControllerPermits)->ctrShowPermitAdmin($type, $filter, $filterType);
}

// Process rows into DataTables format
$data = [];

foreach ($rows as $row) {
    $app = $row["app"];
    $app1 = $row["app1"];
    $chkby = $row["chk"];
    $status = $row["status"];
    $wp_chk_by = $row["wp_chk_by"];
    $permit_type = $row["type"];

    $chk = $chkby !== "Pending" ? "<span class='badge badge-success'>Approved</span>" : "<span class='badge badge-danger'>Pending</span>";

    if($chkby === "Pending"){
        $chk = "<span class='badge badge-danger'>Pending</span>";
    } elseif ($chkby === "Rejected") {
        $chk = "<span class='badge badge-warning'>Rejected</span>";
    } elseif ($chkby === "Approved") {
        $chk = "<span class='badge badge-success'>Approved</span>";
    } 
    $egg = $app1 > 0 ? "<span class='badge badge-success'>Approved</span>" : "<span class='badge badge-danger'>Pending</span>";
    $cgn = $app > 0 ? "<span class='badge badge-success'>Approved</span>" : "<span class='badge badge-danger'>Pending</span>";

	if ($status === "Pending") {
		$statusDisplay = "<span class='badge badge-danger'>Pending</span>";
	} elseif ($status === "P-Approved" || $status === "Inprogress") {
		$statusDisplay = "<span class='badge badge-info'>Inprogress</span>";
	} elseif ($status === "Done") {
		$statusDisplay = "<span class='badge badge-success'>Done</span>";
	}elseif ($status === "Rejected") {
		$statusDisplay = "<span class='badge badge-warning'>Rejected</span>";
	} else {
		// Fallback for unexpected status values
		$statusDisplay = "<span class='badge badge-secondary'>{$status}</span>";
	}
    $levelName = "";   
    if($row["request_level"] === 1) {
        $levelName = "LEVEL 1";
    } elseif($row["request_level"] === 2) {
        $levelName = "LEVEL 2";
    }

    $buttons = "<div class='btn-group'>";
    if ($status === "Pending" && $type === "wp_user") {
        $buttons .= "<button class='btn btn-sm btn-success btnEditShowClient' idClient='{$row["id"]}'>VIEW</button>";
        $buttons .= "<button class='btn btn-sm btn-info btnEditClient1' idClient='{$row["id"]}'>EDIT</button>";
    }elseif($type === "wp_accounting" 
        || $type === "wp_operation"
        || $type === "wp_hrom" 
        || $type === "wp_financial"
        || $type === "wp_audit"
        || $type === "wp_credit"
        || $type === "wp_grcd"
        || $type === "wp_pspmi"
        || ($user_id === "UI00098" && $permit_type === "PSPMI")
        ) {
        $buttons .= "<button class='btn btn-sm btn-info btnEditClient' idClient='{$row["id"]}'>VERIFY</button>";
    }
    else {
        $buttons .= "<button class='btn btn-sm btn-success btnShowRequest' idClient='{$row["id"]}'>VIEW</button>";
    }
    $buttons .= "</div>";

    $wp_req_by = explode("<br />", $row["wp_req_by"])[0];

    $data[] = [
        $buttons,
        $row["ref_id"],
        $wp_req_by,
        $row["branch"],
        $levelName,
        $wp_chk_by,
        $chk,
        $egg,
        $cgn,
		$statusDisplay,
        $row["wp_date"],
        $row["date_done"]
    ];
}

echo json_encode(["data" => $data]);
exit;
