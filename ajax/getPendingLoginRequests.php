<?php

require_once "../controllers/account.controller.php";
require_once "../models/account.model.php";
require_once "../views/modules/session.php";

// Set the content type to application/json
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch pending login requests from the database
    $requests = (new ControllerAccounts)->ctrGetPendingLoginRequests();
    $type = $_SESSION['type'];

    // Initialize coordinator and branch names
    $coordinator = $_SESSION['branch_name'];
 
    
    // // Initialize the branch map for specific coordinators
    // if ($coordinator === "DAN SHIELA") {
    //     $branchMap = [
    //         "EMB DUMAGUETE",
    //         "EMB TAGBILARAN",
    //         "EMB BAYAWAN",
    //         "EMB MANDAUE",
    //         "EMB TOLEDO",
    //         ];
    // } elseif ($coordinator === "SHANDEE") {
    //     $branchMap = [
    //         "FCH BACOLOD",
    //         "FCH PARANAQUE",
    //         "FCH MUNTINLUPA",
    //         "FCH BAGO",
    //         "FCH BINALBAGAN",
    //     ];
    // } elseif ($coordinator === "REECHEL") {
    //     $branchMap = [
    //         "FCH SILAY",
    //         "FCH HINIGARAN",
    //         "FCH MURCIA",
    //         "M2",
    //         "EMB DANAO",
    //     ];
    // }elseif ($coordinator === "JAY ANN") {
    //     $branchMap = [
    //         "RLC BURGOS",
    //         "RLC KALIBO",
    //         "RLC SINGCANG",
    //         "RLC ANTIQUE",
    //         "RLC CULASI",
    //         "ELC BULACAN",
    //     ];
    // }elseif ($coordinator === "REGIE") {
    //     $branchMap = [
    //         "EMB TUBIGON",
    //         "EMB KABANKALAN",
    //         "EMB LA CARLOTA",
    //         "EMB LA CASTELLAN",
    //         "EMB SAGAY",
    //     ];
    // }elseif ($coordinator === "ROSE ANN") {
    //     $branchMap = [
    //         "EMB CEBU",
    //         "EMB SIPALAY",
    //         "EMB ROXAS",
    //         "EMB TALISAY",
    //         "EMB PASSI",
    //     ];
    // }elseif ($coordinator === "ROLEANNE") {
    //     $branchMap = [
    //         "EMB VICTORIAS",
    //         "EMB SARA",
    //         "EMB CADIZ",
    //         "EMB MAMBUSAO",
    //         "EMB BAIS",
    //     ];
    // }


    // // Filter requests based on coordinator
    // if ($type === "login_user" ) {
    //     // Filter requests to only include those with branch names in the branchMap
    //     $requests = array_filter($requests, function($request) use ($branchMap) {
    //         return in_array($request['full_name'], $branchMap); // Check against the correct key
    //     });
    // }
    // // else if ($type === "admin"){
    // //     echo json_encode(array_values($requests)); // Use array_values to reset keys and provide a clean array
    // // }

    // Ensure that the response is always an array
    if (!is_array($requests)) {
        $requests = []; // Set to empty array if it's not an array
    }

    // Return the requests as JSON
    echo json_encode(array_values($requests)); // Use array_values to reset keys and provide a clean array
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
