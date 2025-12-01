<?php
require_once "../models/connection.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";

$branch_name = $_SESSION['branch_name'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$report = "YES";
$pdr = (new ModelPDRCollection)->mdlShowAllFilterArchivePDRList($branch_name, $from_date, $to_date, $report);
if(!empty($pdr)){

// foreach($pdr as $pdrcoll){
//     $account_no = $pdrcoll["account_no"];
//     $name = $pdrcoll["last_name"].' ,'.$pdrcoll["first_name"];
//     $status = $pdrcoll["status"];
//     $edate = $pdrcoll["edate"];
//     $tdate = date("m.d.y", strtotime($pdrcoll["tdate"]));
//     $ref = $pdrcoll["ref"];
//     $prev_bal = $pdrcoll["prev_bal"]; // Convert string to float
//     $amt_paid = $pdrcoll["credit"];
//     $end_bal = $pdrcoll["end_bal"]; // Convert string to float
// }
}

// $branch_name = 'EMB MAIN BRANCH';

// $pdo = (new Connection())->connect();
// $sql = "SELECT * FROM birrec WHERE branch_name = '$branch_name'"; // Replace your_table_name with your actual table name
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define the structure of your DBF file
$def = [
    ["ID", "N", 7, 0], 
    ["NAME", "C", 50], 
    ["BALANCE", "N", 50, 2], 
    
];

// Create the DBF file
$dbfPath = __DIR__ . "/../views/files/pdr_coll/$branch_name/PASTDUE.dbf"; // Specify the path to save the DBF file

$directory = dirname($dbfPath);

// Ensure the directory exists and is writable
if (!file_exists($directory) && !mkdir($directory, 0777, true)) {
    die("Error: Unable to create the directory $directory. Check permissions.");
}

if (!dbase_create($dbfPath, $def)) {
    die("Error, can't create the DBF file.");
}

// Open the newly created DBF file
$dbf = dbase_open($dbfPath, 2); // 2 means read/write mode
if ($dbf === false) {
    die("Error, can't open the DBF file.");
}

// Determine the number of indices in the array
// $numIndices = count($allData);

// Iterate over your SQL data and add it to the DBF file

foreach($pdr as $pdrcoll){

    // Initialize an empty array for the DBF record
    $record = [
        intval($pdrcoll['account_no']) ?? null, 
        $pdrcoll['last_name'].', '.$pdrcoll['first_name'].' '.$pdrcoll['middle_name'] ?? null,
        $pdrcoll['end_bal'] ?? null,
        // Add other fields as needed
    ];

    dbase_add_record($dbf, $record); // Add the record to the DBF file
}

// Close the DBF file
dbase_close($dbf);

// Set the appropriate headers for a download
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename="' . basename($dbfPath) . '"');
// header('Content-Length: ' . filesize($dbfPath));

// Read the file and output its content
// readfile($dbfPath);

if (!file_exists($dbfPath)) {
    die("Error: The DBF file does not exist at $dbfPath.");
}

if (!is_readable($dbfPath)) {
    die("Error: The DBF file is not readable. Check file permissions.");
}

if (ob_get_length()) ob_end_clean(); // Clears any existing output buffer
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($dbfPath));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($dbfPath));

readfile($dbfPath);
exit;

// Debug: Print headers
var_dump(headers_list());

// Add this after file-related operations
if ($error = error_get_last()) {
    die("Error: {$error['message']}");
}



?>
