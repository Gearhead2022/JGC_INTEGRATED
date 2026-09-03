<?php

// $pdo = (new Connection())->connect();
// $sql = "SELECT * FROM accounts"; // Replace your_table_name with your actual table name
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Define the structure of your DBF file
// $def = [
//     ["full_name", "C", 20], // Column name, type (Character), length
//     ["username", "C", 20], // Column name, type (Character), length
    
// ];

// // Create the DBF file
// $dbfPath = __DIR__ . "/../files/pdr_coll/file.dbf"; // Specify the path to save the DBF file
// if (!dbase_create($dbfPath, $def)) {
//     die("Error, can't create the DBF file.");
// }

// // Open the newly created DBF file
// $dbf = dbase_open($dbfPath, 2); // 2 means read/write mode
// if ($dbf === false) {
//     die("Error, can't open the DBF file.");
// }

// // Iterate over your SQL data and add it to the DBF file
// foreach ($rows as $row) {
//     $record = []; // Initialize an empty array for the DBF record
//     foreach ($def as $fieldDef) {
//         $fieldName = $fieldDef[0];
//         $record[] = $row[$fieldName] ?? null; // Add the SQL data to the DBF record, ensuring to match the field order in $def
//     }
//     dbase_add_record($dbf, $record); // Add the record to the DBF file
// }

// // Close the DBF file
// dbase_close($dbf);

// // Set the appropriate headers for a download
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename="' . basename($dbfPath) . '"');
// header('Content-Length: ' . filesize($dbfPath));

// Read the file and output its content
// readfile($dbfPath);


// require_once "../models/connection.php";
// require_once "../models/pdrcollection.model.php";
// require_once "../views/modules/session.php";

// $branch_name = $_SESSION['branch_name'];

// $rows = (new ModelPDRCollection)->mdlGetAllRecordsToAppendInDBF($branch_name);

$branch_name = 'EMB MAIN BRANCH';

$pdo = (new Connection())->connect();
$sql = "SELECT * FROM birrec WHERE branch_name = '$branch_name'"; // Replace your_table_name with your actual table name
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define the structure of your DBF file
$def = [
    ["name", "C", 20], // Column name, type (Character), length
    ["desc", "C", 50], // Column name, type (Character), length
    
];

// Create the DBF file
$dbfPath = __DIR__ . "/../files/pdr_coll/$branch_name/PDRCOLL.dbf"; // Specify the path to save the DBF file

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

// Iterate over your SQL data and add it to the DBF file
foreach ($rows as $row) {
    $record = []; // Initialize an empty array for the DBF record
    foreach ($def as $fieldDef) {
        $fieldName = $fieldDef[0];
        $record[] = $row[$fieldName] ?? null; // Add the SQL data to the DBF record, ensuring to match the field order in $def
    }
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


// Assuming $dbfPath contains the path to your DBF file
$dbfPath = __DIR__ . "/../files/pdr_coll/$branch_name/PDRCOLL.dbf";
$dbfFilename = basename($dbfPath);

// Check if the file exists
if (file_exists($dbfPath)) {
    // Set headers to indicate a file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($dbfFilename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($dbfFilename));
    ob_clean();
    flush();
    readfile($dbfFilename);
    exec('rm ' . $dbfFilename);

    // Clear output buffer
    ob_clean();
    flush();
    
    // Read the file and output its content
    readfile($dbfPath);
    exit;
} else {
    echo "Error: File not found.";
}

?>



?>
