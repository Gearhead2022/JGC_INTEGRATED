<?php

if (isset($_GET['branch_name']) && isset($_GET['new_date'])) {

    $branch_name = $_GET['branch_name'];
    $new_date = $_GET['new_date'];

    $date_now = date('F j, Y', strtotime($new_date));
    $month = date('F', strtotime($new_date));
    $year = date('Y', strtotime($new_date));

    $cn_branch_name = strlen($branch_name) + 1 + strlen($year) + 1 + strlen($month) + 1;

    $folder = '../views/files/Backup/' . $branch_name . '/' . $year . '/' . $month . '/' . $date_now . '';

    // Check if the directory exists
    if (!is_dir($folder)) {
        echo "Directory does not exist: $folder";
        exit;
    }

    // Create a new zip archive
    $zip = new ZipArchive();
    $zipname = $branch_name . ' ' . $date_now . '.zip';

    // Open the archive and add files to it
    if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {

        // Iterate over files in the directory
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, 45 + $cn_branch_name);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        // Set the appropriate headers for file download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipname) . '"');

        // Check if the zip file exists before sending it
        if (file_exists($zipname)) {
            header('Content-Length: ' . filesize($zipname));

            // Read the zip file and output to the browser
            readfile(__DIR__ . '/' . $zipname);

            // Delete the zip file after sending
            unlink(__DIR__ . '/' . $zipname);
        } else {
            echo 'Error: Zip archive not found';
        }

    } else {
        echo 'Error creating zip archive';
    }

} else {
    echo "ERROR: Missing branch_name or new_date parameter.";
}

?>
