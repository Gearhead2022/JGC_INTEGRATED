<?php

require_once "../../models/dtr.model.php";
// Enable CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {

        // Example file name: "username_selected_date_exported_file.encrypted"
        $fileName = $_FILES["file"]["name"];

        // Explode the file name using the underscore as the delimiter
        $fileParts = explode("_", $fileName);

        // $fileParts is now an array containing the parts of the file name
        // For example, if the file name is "username_selected_date_exported_file.encrypted"
        // $fileParts will be array("username", "selected", "date", "exported", "file.encrypted")

        // Access individual parts as needed
        $entry_date = $fileParts[1];
        $branch_name = $fileParts[2];
        // $branch_name = $fileParts[2];

        $fileBranchParts = explode(".", $branch_name);

        $branchFolder = strtoupper(str_replace("-"," ",$fileBranchParts[0]));

        $monthFolder = date('Y-M-d', strtotime($entry_date));

        // $new_branch = 'EMB MAIN BRANCH';
   
        $format_entry_date = date('Y-m-d', strtotime($entry_date));
        // Create a directory for storing uploaded files
        // $uploadDir = "../files/branchdtr/$new_branch/$monthFolder/";

        $uploadDir = "../files/branchdtr/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the specified directory
        $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {

            $table = "branch_dtr_upload";

            $data = array(
                "branch_name" =>  $branchFolder,
                "entry_file" => $fileName, // Store the file path in the database
                "entry_date" => $format_entry_date
            );

            $answer = (new ModelDTR)->mdlAddBranchDailyDTRUploadAPI($table, $data);

            if($answer == "ok"){
                echo json_encode(['success' => true, 'message' => 'File received successfully and saved to database']);
            } else {
                echo json_encode(['success' => true, 'message' => 'File received successfully but not saved in database']);
            }
      
        } else {
            // Handle file upload error
            echo json_encode(['success' => false, 'message' => 'Error moving uploaded file']);
        }
    } else {
        // No file uploaded
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    }
} else {
    // Unsupported request method
    echo json_encode(['success' => false, 'message' => 'Unsupported request method']);
}
?>