<?php

class ControllerDTR{

	static public function ctrShowBranchDailyDTRUpload($branch_name){
        $answer = (new ModelDTR)->mdlShowBranchDailyDTRUpload($branch_name);
		return $answer;
    }
    
    static public function ctrAddBranchDailyDTRUpload(){
        if(isset($_POST["adddtr"])){
            $table = "branch_dtr_upload";
    
            // Check if a file was uploaded
            if(isset($_FILES["entry_file"]) && $_FILES["entry_file"]["error"] == 0){
                $branch = $_POST["branch_name"];
                $monthFolder = date('Y-M-d', strtotime($_POST['entry_date']));
                $uploadDir = "views/files/branchdtr/$branch/$monthFolder/";

                $dateSelected = $_POST['entry_date'];

                $Exist = (new ModelDTR)->mdlCheckDailyDTRExist($branch, $dateSelected);

                if($Exist == "no"){
                        // Check if the directory exists, create it if not
                    if(!is_dir($uploadDir)){
                        mkdir($uploadDir, 0777, true);
                    }
    
                    $uploadFile = $uploadDir . basename($_FILES["entry_file"]["name"]);
                    $uploadFileName = basename($_FILES["entry_file"]["name"]);
        
                    // Check if the file already exists
                    if(file_exists($uploadFile)){
                        echo '<script>
                                swal({
                                    type: "warning",
                                    title: "File already exists!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                });
                            </script>';
                    } else {
                        // Move the uploaded file to the specified directory
                        if(move_uploaded_file($_FILES["entry_file"]["tmp_name"], $uploadFile)){
                            // File uploaded successfully
        
                            $data = array(
                                "branch_name" => $_POST["branch_name"],
                                "dtr_id" => $_POST["dtr_id"],
                                "entry_subj" => $_POST["entry_subj"],
                                "entry_file" => $uploadFileName, // Store the file path in the database
                                "entry_date" => $_POST["entry_date"]
                            );
        
                            $answer = (new ModelDTR)->mdlAddBranchDailyDTRUpload($table, $data);
        
                            if($answer == "ok"){
                                echo '<script>
                                        swal({
                                            type: "success",
                                            title: "File Successfully Uploaded!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "branchDTRUpload";
                                            }
                                        });
                                    </script>';
                            } elseif($answer == "error"){
                                echo '<script>
                                        swal({
                                            type: "warning",
                                            title: "There\'s an error occurred!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "";
                                            }
                                        });
                                    </script>';
                            }
                        } else {
                            // Error in moving the uploaded file
                            echo '<script>
                                    swal({
                                        type: "error",
                                        title: "Error in uploading file!",
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    });
                                </script>';
                        }
                    }

                }else{
                    echo '<script>
                    swal({
                        type: "warning",
                        title: "Selected date is already exist!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    });
                  </script>';

                }
    
                
            } else {
                // No file uploaded
                echo '<script>
                        swal({
                            type: "warning",
                            title: "Please select a file to upload!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                      </script>';
            }
        }
    }

    static public function ctrDeleteBranchDailyDTRUpload(){
        if(isset($_GET['id']) && isset($_GET['branch_name']) && isset($_GET['entry_date'])){
    
            $table = "branch_dtr_upload";
            $id = $_GET["id"];
            $entry_date = $_GET["entry_date"];
            $branch_name = $_GET["branch_name"];

            $monthFolder = date('Y-M-d', strtotime($_GET['entry_date']));
    
            // Get the file path from the database
            $fileInfo = (new ModelDTR)->getFileInformation($table, $id, $entry_date, $branch_name);
    
            if($fileInfo){
                $filePath = 'views/files/branchdtr/'.$branch_name.'/'.$monthFolder.'/'.$fileInfo['entry_file'];
    
                // Delete the record from the database
                $answer = (new ModelDTR)->mdlDeleteBranchDailyDTRUpload($table, $id, $entry_date, $branch_name);
    
                if($answer == "ok"){
                    // Delete the file from the server
                    if(file_exists($filePath)){
                        unlink($filePath);
                          // SET Directory to be deleted  
                        $branchDir = 'views/files/branchdtr/' . $branch_name . '/' . $monthFolder;
                        rmdir($branchDir);
                    }
    
                    echo '<script>
                            swal({
                                type: "success",
                                title: "Record has been successfully deleted!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "branchDTRUpload";
                                }
                            });
                          </script>';
                } else if($answer == "error"){
                    echo '<script>
                            swal({
                                type: "warning",
                                title: "There\'s an error occurred!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    // Handle error as needed
                                }
                            });
                          </script>';
                }
            } else {
                // Handle case where file information is not found
                echo '<script>
                        swal({
                            type: "error",
                            title: "File information not found!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                      </script>';
            }
        }
    }

    static public function ctrGetHRDailyDTRDownload($id, $branch_name){
        $answer = (new ModelDTR)->mdlGetHRDailyDTRDownload($id, $branch_name);
		return $answer;
    }

    static public function ctrEditBranchDailyDTRUpload(){

        ob_start(); // Start output buffering

        if(isset($_POST["editdtr"])){
            $table = "branch_dtr_upload";
            $result = '';

              // Function to handle the upload response
            $handleUploadResponse = function ($result) {
                self::handleUploadResponse($result);
            };

            $id = $_POST["id"];
            $branch = $_POST["branch_name"];
            $entry_date = $_POST["entry_date"];

            // Check if a file was uploaded
            if(isset($_FILES["entry_file"]) && $_FILES["entry_file"]["error"] == 0){
                $branch = $_POST["branch_name"];
                $monthFolder = date('Y-M-d', strtotime($entry_date));
                $uploadDir = 'views/files/branchdtr/'.$branch.'/'.$monthFolder.'/'; // set new directory
                $uploadFile = $uploadDir . basename($_FILES["entry_file"]["name"]); // set new directory with file
                $uploadFileName = basename($_FILES["entry_file"]["name"]); // uploaded file name

                $data = (new ModelDTR)->mdlGetHRDailyDTRDownload($id, $branch);
                
                // Set headers for file download
                $entry_file_edit = $data[0]["entry_file"]; // filename
                $entry_date_edit = $data[0]["entry_date"]; // Original folder from the database 

                $entry_date_edit_old = date('Y-M-d', strtotime($entry_date_edit));
                $source_path = 'views/files/branchdtr/' . $branch . '/' . $entry_date_edit_old . '/' . $entry_file_edit;
    
                // Check if the directory exists, create it if not
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Move the uploaded file to the specified directory
                if(move_uploaded_file($_FILES["entry_file"]["tmp_name"], $uploadFile)){
                    
                    // SET Directory to be deleted  
                    $branchDir = 'views/files/branchdtr/' . $branch . '/' . $entry_date_edit_old;

                    if (unlink($source_path)) {
                        rmdir($branchDir);
                    } 
                    $data = array(
                        "branch_name" => $_POST["branch_name"],
                        "id" => $_POST["id"],
                        "entry_subj" => $_POST["entry_subj"],
                        "entry_file" => $uploadFileName, // Store the file path in the database
                        "entry_date" => $_POST["entry_date"]
                    );

                    $answer = (new ModelDTR)->mdlEditBranchDailyDTRUpload($table, $data);
                
                    $result = ($answer == "ok") ? "ok_file_date" : "error_file_date";
                    $handleUploadResponse($result);
                } 

            } else { //else file is not set
     
                $data = (new ModelDTR)->mdlGetHRDailyDTRDownload($id, $branch);
                
                // Set headers for file download
                $entry_file_edit = $data[0]["entry_file"]; // filename
                $entry_date_edit = $data[0]["entry_date"]; // Original folder from the database

                if ($entry_date_edit === $entry_date) {
                    $table = "branch_dtr_upload";
                    $data = array(
                        "id" => $id,
                        "branch_name" => $branch,
                        "entry_subj" => $_POST["entry_subj"],
                        "entry_file" => $entry_file_edit, // Store the file path in the database
                        "entry_date" => $_POST["entry_date"]
                    );
        
                    $answer = (new ModelDTR)->mdlEditBranchDailyDTRUpload($table, $data);
                      
                    $result = ($answer == "ok") ? "ok_info" : "error_info";
                    $handleUploadResponse($result);
        
                } else {
                    $entry_date_edit_old = date('Y-M-d', strtotime($entry_date_edit));
            
                    $source_path = 'views/files/branchdtr/' . $branch . '/' . $entry_date_edit_old . '/' . $entry_file_edit; // old path with file name
                
                    if (file_exists($source_path)) {
                        header('Content-Type: image/jpeg');
                        header('Content-Disposition: attachment; filename="' . basename($source_path) . '"');
                        header('Content-Length: ' . filesize($source_path));
                
                        // Read and output the file contents
                        ob_end_clean();
                        // readfile($source_path);
                
                        $monthFolder = date('Y-M-d', strtotime($entry_date));
                
                        $newuploadDir = 'views/files/branchdtr/' . $branch . '/' . $monthFolder . '/'; // new destination path
                
                        // Check if the directory exists, create it if not
                        if (!is_dir($newuploadDir)) {
                            mkdir($newuploadDir, 0777, true);
                        }
                
                        $uploadFile = $newuploadDir . $entry_file_edit; // new destination path with filename
                        $uploadFileName = $entry_file_edit;
                
                        // Check if the destination file exists
                        if (file_exists($uploadFile)) {
                            // Remove the destination file before copying
                            unlink($uploadFile);
                        }
                
                        // Attempt to copy the file
                        if (copy($source_path, $uploadFile)) {
    
                            $branchDir = 'views/files/branchdtr/' . $branch . '/' . $entry_date_edit_old;
    
                            if (unlink($source_path)) {
                                rmdir($branchDir);
                            } 
    
                            rmdir($source_path);
    
                            $table = "branch_dtr_upload";
                            $data = array(
                                "id" => $id,
                                "branch_name" => $branch,
                                "entry_subj" => $_POST["entry_subj"],
                                "entry_file" => $uploadFileName, // Store the file path in the database
                                "entry_date" => $_POST["entry_date"]
                            );
                
                            $answer = (new ModelDTR)->mdlEditBranchDailyDTRUpload($table, $data);

                            $result = ($answer == "ok") ? "ok_date" : "error_date";
                            $handleUploadResponse($result);
                
                        } else {
                            // Error in copying the file
                            $result = "error_date";
                            $handleUploadResponse($result);
                        }
                    }
                }

            }
        }
    }

    static public function handleUploadResponse($result)
{
    if($result == "ok_file_date"){
        echo '<script>
                swal({
                    type: "success",
                    title: "File Successfully Updated!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "branchDTRUpload";
                    }
                });
                </script>';
    } elseif($result == "error_file_date"){
        echo '<script>
                swal({
                    type: "warning",
                    title: "There\'s an error occurred updating!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "";
                    }
                });
                </script>';
    } elseif ($result == "ok_info") {
        echo '<script>
                swal({
                    type: "success",
                    title: "Info Successfully Updated!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "branchDTRUpload";
                    }
                });
            </script>';
    } elseif ($result == "error_info") {
        echo '<script>
                swal({
                    type: "warning",
                    title: "There\'s an error occurred updating info!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "";
                    }
                });
            </script>';
    } elseif ($result == "ok_date") {
        echo '<script>
                swal({
                    type: "success",
                    title: "Date Successfully Updated!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "branchDTRUpload";
                    }
                });
            </script>';
    } elseif ($result == "error_date") {
        echo '<script>
                swal({
                    type: "warning",
                    title: "There\'s an error occurred updating date!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "";
                    }
                });
            </script>';
    
    }
}

    // HR functions // 

    static public function ctrShowHRDailyDTRDownload(){
        $answer = (new ModelDTR)->mdlShowHRDailyDTRDownload();
		return $answer;
    }

    static public function ctrDownloadAndMoveFile(){
        ob_start(); // Start output buffering
    
        if(isset($_GET["id"]) && isset($_GET["entry_file"]) && isset($_GET["entry_date"]) && isset($_GET["branch_name"])){
            
            // No output or whitespace before this point
    
            $id = $_GET["id"];
            $entry_date = date('Y-M-d', strtotime($_GET['entry_date']));
            $branch_name = $_GET["branch_name"];
            $entry_file = $_GET["entry_file"];
            $source_path = 'views/files/branchdtr/'.$branch_name.'/'.$entry_date.'/'.$entry_file; // Set the source path to the file
    
            // Set headers for file download
            if(file_exists($source_path)){

                echo '<script>
                    swal({
                        title: "Generating",
                        text: "Please wait...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    </script>';
    
                header('Content-Type: image/jpeg');
                header('Content-Disposition: attachment; filename="'.basename($source_path).'"');
                header('Content-Length: ' . filesize($source_path));
    
        	    // Read and output the file contents
                ob_end_clean();
                // readfile($source_path);

                // Move or copy the file to a different folder
                $destination_path = 'C:/branch_dtr/' .$branch_name. '/' .$entry_date. '/';
    
                // Check if the directory exists, create it if not
                if(!is_dir($destination_path)){
                    mkdir($destination_path, 0777, true);
                }
    
                $folder_and_file = $destination_path . $entry_file;
    
                if(file_exists($folder_and_file)){
                    echo '<script>
                    swal.close();
                        swal({
                            type: "error",
                            title: "File already exists",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "hrDTRDownload";
                            }
                        });
                    </script>';
                } else {
                    // Use either copy or rename based on your needs
                    copy($source_path, $folder_and_file);
                     // or
                    // rename($source_path, $destination_path);

                    $table = "branch_dtr_upload";
 
                    $entry_date_format = date('Y-m-d', strtotime($entry_date));

                    $data = array(
                        "id" => $id,
                        "branch_name" => $branch_name,
                        "entry_date" => $entry_date_format
                        
                    );

                    $answer = (new ModelDTR)->mdlUpdateDTRStatus($table, $data);

                    if ($answer === 'ok') {
                        echo '<script>
                        swal.close();
                            swal({
                                type: "success",
                                title: "Record has been successfully downloaded!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "hrDTRDownload";
                                }
                            });
                        </script>';
                    } else {
                        echo '<script>
                        swal.close();
                            swal({
                                type: "success",
                                title: "Record has been successfully downloaded but error to update!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "hrDTRDownload";
                                }
                            });
                        </script>';
                    }
                    
                }
            } else {
                echo '<script>
                swal.close();
                    swal({
                        type: "error",
                        title: "File information not found!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "hrDTRDownload";
                        }
                    });
                </script>';
            }
    
            ob_end_flush(); // Flush the output buffer
            exit(); // Exit to prevent further HTML output
        }
    }

    static public function ctrDownloadAllAndMoveFile() {
        ob_start(); // Start output buffering
    
        if (isset($_GET["entry_date"]) && isset($_GET["downloadAll"])) {
            $entry_date = $_GET['entry_date'];
            $has_data = (new ModelDTR)->mdlGetBranchDailyDTRUploadList($entry_date);
    
            if ($has_data === 'yes') {
                $zip = new ZipArchive();
                $zipFileName = 'downloaded_files.zip';
    
                if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
                    $branchFolders = 
                    array(
                        'EMB MAIN BRANCH',
                        'EMB CADIZ',
                        'EMB LA CARLOTA',
                        'EMB KABANKALAN',
                        'EMB ILOILO',
                        'EMB DUMAGUETE',
                        'EMB SAN CARLOS',
                        'EMB TAGBILARAN',
                        'EMB MANDAUE',
                        'EMB ROXAS',
                        'EMB SAGAY',
                        'EMB VICTORIAS',
                        'EMB BAYAWAN',
                        'EMB BAIS',
                        'EMB LA CASTELLANA',
                        'EMB PASSI',
                        'EMB SARA',
                        'EMB SIPALAY',
                        'EMB CEBU',
                        'EMB TALISAY',
                        'EMB TOLEDO',
                        'EMB MIAG AO',
                        'EMB TUBIGON',
                        'EMB MAMBUSAO',
                        'EMB DANAO',
                        'FCH BACOLOD',
                        'FCH SILAY',
                        'FCH BAGO',
                        'FCH MURCIA',
                        'FCH BINALBAGAN',
                        'FCH HINIGARAN',
                        'FCH PARANAQUE',
                        'FCH MUNTINLUPA',
                        'RLC KALIBO',
                        'RLC BURGOS',
                        'RLC ANTIQUE',
                        'RLC SINGCANG',
                        'ELC BULACAN',
                    );
    
                    for ($i = 0; $i < count($branchFolders); $i++) {
                        $entry_date_format_folder = date('Y-M-d', strtotime($_GET['entry_date']));
                        $branch_name = $branchFolders[$i];
                        $file_info = (new ModelDTR)->mdlGetFileInfo($branch_name, $entry_date);
    
                        $entry_file = $file_info[0]["entry_file"];
                        $source_path = 'views/files/branchdtr/' . $branch_name . '/' . $entry_date_format_folder . '/' . $entry_file;
    
                        if (file_exists($source_path)) {
                            // Add the file to the ZIP archive
                            $zip->addFile($source_path, $branch_name . '/' . $entry_date_format_folder . '/' . $entry_file);
    
                            // Update the database, if needed
                            $table = "branch_dtr_upload";
                            $entry_date_format = date('Y-m-d', strtotime($entry_date));
                            $data = array(
                                "id" => $file_info[0]["id"],
                                "branch_name" => $branch_name,
                                "entry_date" => $entry_date_format
                            );
                            (new ModelDTR)->mdlUpdateDTRStatus($table, $data);
                        }
                    }
    
                    $zip->close();
    
                    // Set headers for file download
                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
                    header('Content-Length: ' . filesize($zipFileName));
    
                    // Read and output the file contents
                    readfile($zipFileName);
                    unlink($zipFileName); // Delete the temporary ZIP file
                    ob_end_flush();

                    // echo '<script>
    
                    //     swal.close();
                    //         swal({
                    //             type: "success",
                    //             title: "All record has been successfully downloaded!",
                    //             showConfirmButton: true,
                    //             confirmButtonText: "Ok"
                    //         }).then(function(result){
                    //             if (result.value) {
                    //                 window.location = "hrDTRDownload";
                    //             }
                    //         });
                    //     </script>';
                    exit();
                }
            } else {
                echo '<script>
                    swal.close();
                    swal({
                        type: "info",
                        title: "No records have been found in the specified date!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "hrDTRDownload";
                        }
                    });
                </script>';
            }
    
            ob_end_flush();
            exit();
        }
    }
    
    
    

    // static public function ctrDownloadAllAndMoveFile(){
    //     ob_start(); // Start output buffering

    //     if(isset($_GET["entry_date"]) && isset($_GET["downloadAll"])){

    //         $entry_date = $_GET['entry_date'];

    //         $has_data = (new ModelDTR)->mdlGetBranchDailyDTRUploadList($entry_date);

    //         if ($has_data === 'yes') {
    //             $branchFolders = array(
    //                 'EMB MAIN BRANCH',
    //                 'EMB CADIZ',
    //                 'EMB LA CARLOTA',
    //                 'EMB KABANKALAN',
    //                 'EMB ILOILO',
    //                 'EMB DUMAGUETE',
    //                 'EMB SAN CARLOS',
    //                 'EMB TAGBILARAN',
    //                 'EMB MANDAUE',
    //                 'EMB ROXAS',
    //                 'EMB SAGAY',
    //                 'EMB VICTORIAS',
    //                 'EMB BAYAWAN',
    //                 'EMB BAIS',
    //                 'EMB LA CASTELLANA',
    //                 'EMB PASSI',
    //                 'EMB SARA',
    //                 'EMB SIPALAY',
    //                 'EMB CEBU',
    //                 'EMB TALISAY',
    //                 'EMB TOLEDO',
    //                 'EMB MIAG AO',
    //                 'EMB TUBIGON',
    //                 'EMB MAMBUSAO',
    //                 'EMB DANAO',
    //                 'FCH BACOLOD',
    //                 'FCH SILAY',
    //                 'FCH BAGO',
    //                 'FCH MURCIA',
    //                 'FCH BINALBAGAN',
    //                 'FCH HINIGARAN',
    //                 'FCH PARANAQUE',
    //                 'FCH MUNTINLUPA',
    //                 'RLC KALIBO',
    //                 'RLC BURGOS',
    //                 'RLC ANTIQUE',
    //                 'RLC SINGCANG',
    //                 'ELC BULACAN',
    //             );
                
    //             for ($i = 0; $i < count($branchFolders); $i++) {
    
    //                 $entry_date_format_folder = date('Y-M-d', strtotime($_GET['entry_date']));
    //                 $branch_name = $branchFolders[$i];
    
    //                 $file_info = (new ModelDTR)->mdlGetFileInfo($branch_name, $entry_date);
    
    //                 // Set headers for file download
    //                 $entry_file = $file_info[0]["entry_file"]; // filename
    //                 $id = $file_info[0]["id"]; // data id
    
    //                 $source_path = 'views/files/branchdtr/'.$branch_name.'/'.$entry_date_format_folder.'/'.$entry_file; // Set the source path to the file
    
    //                 // Set headers for file download
    //                 if(file_exists($source_path)){

    //                     echo '<script>
    //                         swal({
    //                             title: "Generating",
    //                             text: "Please wait...",
    //                             allowOutsideClick: false,
    //                             allowEscapeKey: false,
    //                             onOpen: () => {
    //                                 swal.showLoading();
    //                             }
    //                         </script>';
            
    //                     header('Content-Type: image/jpeg');
    //                     header('Content-Disposition: attachment; filename="'.basename($source_path).'"');
    //                     header('Content-Length: ' . filesize($source_path));
            
    //                     // Read and output the file contents
    //                     ob_end_clean();
    //                     // readfile($source_path);
        
    //                     // Move or copy the file to a different folder
    //                     $destination_path = 'C:/branch_dtr/' .$branch_name. '/' .$entry_date_format_folder. '/';
            
    //                     // Check if the directory exists, create it if not
    //                     if(!is_dir($destination_path)){
    //                         mkdir($destination_path, 0777, true);
    //                     }
            
    //                     $folder_and_file = $destination_path . $entry_file;
            
    //                     if(file_exists($folder_and_file)){
                        
    //                         continue;
                            
    //                     } else {
    //                         // Use either copy or rename based on your needs
    //                         copy($source_path, $folder_and_file);
    //                             // or
    //                         // rename($source_path, $destination_path);
        
    //                         $table = "branch_dtr_upload";
            
    //                         $entry_date_format = date('Y-m-d', strtotime($entry_date));
        
    //                         $data = array(
    //                             "id" => $id,
    //                             "branch_name" => $branch_name,
    //                             "entry_date" => $entry_date_format
                                
    //                         );
        
    //                         $answer = (new ModelDTR)->mdlUpdateDTRStatus($table, $data);
        
    //                     }
    //                 } else {

    //                     continue;

    //                 }
                    
    //             }
    
    //             echo '<script>
    
    //                 swal.close();
    //                     swal({
    //                         type: "success",
    //                         title: "All record has been successfully downloaded!",
    //                         showConfirmButton: true,
    //                         confirmButtonText: "Ok"
    //                     }).then(function(result){
    //                         if (result.value) {
    //                             window.location = "hrDTRDownload";
    //                         }
    //                     });
    //                 </script>';
            
    //         } else {
    //             echo '<script>
    
    //             swal.close();
    //                 swal({
    //                     type: "info",
    //                     title: "No records has been found in specified date!",
    //                     showConfirmButton: true,
    //                     confirmButtonText: "Ok"
    //                 }).then(function(result){
    //                     if (result.value) {
    //                         window.location = "hrDTRDownload";
    //                     }
    //                 });
    //             </script>';
    //         }

    //         ob_end_flush(); // Flush the output buffer
    //         exit(); // Exit to prevent further HTML output
    //     }
    // }
    
    static public function ctrGetBranchDailyDTRUploadList($branch_name, $check_entry_date){

        $file_info = (new ModelDTR)->mdlCheckDailyDTRExist($branch_name, $check_entry_date);

        return $file_info;
    
    }

    // // Branch Time in DTR UPLOAD

    static public function ctrShowBranchDailyTimeInDTRUpload($branch_name){
        $answer = (new ModelDTR)->mdlShowBranchDailyTimeInDTRUpload($branch_name);
		return $answer;
    }

    static public function ctrAddBranchDailyTimeInDTRUpload(){
        if(isset($_POST["addtimeindtr"])){
            $table = "branch_time_in_dtr_upload";
    
            // Check if a file was uploaded
            if(isset($_FILES["entry_file"]) && $_FILES["entry_file"]["error"] == 0){
                $branch = $_POST["branch_name"];
                $monthFolder = date('Y-M-d', strtotime($_POST['entry_date']));
                $uploadDir = "views/files/branchtimeindtr/$branch/$monthFolder/";

                $dateSelected = $_POST['entry_date'];

                $Exist = (new ModelDTR)->mdlCheckDailyTimeInDTRExist($branch, $dateSelected);

                if($Exist == "no"){
                        // Check if the directory exists, create it if not
                    if(!is_dir($uploadDir)){
                        mkdir($uploadDir, 0777, true);
                    }
    
                    $uploadFile = $uploadDir . basename($_FILES["entry_file"]["name"]);
                    $uploadFileName = basename($_FILES["entry_file"]["name"]);
        
                    // Check if the file already exists
                    if(file_exists($uploadFile)){
                        echo '<script>
                                swal({
                                    type: "warning",
                                    title: "File already exists!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                });
                            </script>';
                    } else {
                        // Move the uploaded file to the specified directory
                        if(move_uploaded_file($_FILES["entry_file"]["tmp_name"], $uploadFile)){
                            // File uploaded successfully
        
                            $data = array(
                                "branch_name" => $_POST["branch_name"],
                                "dtr_id" => $_POST["dtr_id"],
                                "entry_subj" => $_POST["entry_subj"],
                                "entry_file" => $uploadFileName, // Store the file path in the database
                                "entry_date" => $_POST["entry_date"]
                            );
        
                            $answer = (new ModelDTR)->mdlAddBranchDailyTimeInDTRUpload($table, $data);
        
                            if($answer == "ok"){
                                echo '<script>
                                        swal({
                                            type: "success",
                                            title: "File Successfully Uploaded!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "branchTimeInDTRUpload";
                                            }
                                        });
                                    </script>';
                            } elseif($answer == "error"){
                                echo '<script>
                                        swal({
                                            type: "warning",
                                            title: "There\'s an error occurred!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "";
                                            }
                                        });
                                    </script>';
                            }
                        } else {
                            // Error in moving the uploaded file
                            echo '<script>
                                    swal({
                                        type: "error",
                                        title: "Error in uploading file!",
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    });
                                </script>';
                        }
                    }

                }else{
                    echo '<script>
                    swal({
                        type: "warning",
                        title: "Selected date is already exist!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    });
                  </script>';

                }
    
                
            } else {
                // No file uploaded
                echo '<script>
                        swal({
                            type: "warning",
                            title: "Please select a file to upload!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                      </script>';
            }
        }
    }

    static public function ctrGetHRDailyTimeInDTRDownload($id, $branch_name){
        $answer = (new ModelDTR)->mdlGetHRDailyTimeInDTRDownload($id, $branch_name);
		return $answer;
    }

    static public function ctrEditBranchDailyTimeInDTRUpload(){

        ob_start(); // Start output buffering

        if(isset($_POST["edittimeindtr"])){
            $table = "branch_time_in_dtr_upload";
            $result = '';

              // Function to handle the upload response
            $handleUploadResponseTimein = function ($result) {
                self::handleUploadResponseTimein($result);
            };

            $id = $_POST["id"];
            $branch = $_POST["branch_name"];
            $entry_date = $_POST["entry_date"];

            // Check if a file was uploaded
            if(isset($_FILES["entry_file"]) && $_FILES["entry_file"]["error"] == 0){
                $branch = $_POST["branch_name"];
                $monthFolder = date('Y-M-d', strtotime($entry_date));
                $uploadDir = 'views/files/branchtimeindtr/'.$branch.'/'.$monthFolder.'/'; // set new directory
                $uploadFile = $uploadDir . basename($_FILES["entry_file"]["name"]); // set new directory with file
                $uploadFileName = basename($_FILES["entry_file"]["name"]); // uploaded file name

                $data = (new ModelDTR)->mdlGetHRDailyTimeInDTRDownload($id, $branch);
                
                // Set headers for file download
                $entry_file_edit = $data[0]["entry_file"]; // filename
                $entry_date_edit = $data[0]["entry_date"]; // Original folder from the database 

                $entry_date_edit_old = date('Y-M-d', strtotime($entry_date_edit));
                $source_path = 'views/files/branchtimeindtr/' . $branch . '/' . $entry_date_edit_old . '/' . $entry_file_edit;
    
                // Check if the directory exists, create it if not
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Move the uploaded file to the specified directory
                if(move_uploaded_file($_FILES["entry_file"]["tmp_name"], $uploadFile)){
                    
                    // SET Directory to be deleted  
                    $branchDir = 'views/files/branchtimeindtr/' . $branch . '/' . $entry_date_edit_old;

                    if (unlink($source_path)) {
                        rmdir($branchDir);
                    } 
                    $data = array(
                        "branch_name" => $_POST["branch_name"],
                        "id" => $_POST["id"],
                        "entry_subj" => $_POST["entry_subj"],
                        "entry_file" => $uploadFileName, // Store the file path in the database
                        "entry_date" => $_POST["entry_date"]
                    );

                    $answer = (new ModelDTR)->mdlEditBranchDailyTimeInDTRUpload($table, $data);
                
                    $result = ($answer == "ok") ? "ok_file_date" : "error_file_date";
                    $handleUploadResponseTimein($result);
                } 

            } else { //else file is not set
     
                $data = (new ModelDTR)->mdlGetHRDailyTimeInDTRDownload($id, $branch);
                
                // Set headers for file download
                $entry_file_edit = $data[0]["entry_file"]; // filename
                $entry_date_edit = $data[0]["entry_date"]; // Original folder from the database

                if ($entry_date_edit === $entry_date) {
                    $table = "branch_time_in_dtr_upload";
                    $data = array(
                        "id" => $id,
                        "branch_name" => $branch,
                        "entry_subj" => $_POST["entry_subj"],
                        "entry_file" => $entry_file_edit, // Store the file path in the database
                        "entry_date" => $_POST["entry_date"]
                    );
        
                    $answer = (new ModelDTR)->mdlEditBranchDailyTimeInDTRUpload($table, $data);
                      
                    $result = ($answer == "ok") ? "ok_info" : "error_info";
                    $handleUploadResponseTimein($result);
        
                } else {
                    $entry_date_edit_old = date('Y-M-d', strtotime($entry_date_edit));
            
                    $source_path = 'views/files/branchtimeindtr/' . $branch . '/' . $entry_date_edit_old . '/' . $entry_file_edit; // old path with file name
                
                    if (file_exists($source_path)) {
                        header('Content-Type: image/jpeg');
                        header('Content-Disposition: attachment; filename="' . basename($source_path) . '"');
                        header('Content-Length: ' . filesize($source_path));
                
                        // Read and output the file contents
                        ob_end_clean();
                        // readfile($source_path);
                
                        $monthFolder = date('Y-M-d', strtotime($entry_date));
                
                        $newuploadDir = 'views/files/branchtimeindtr/' . $branch . '/' . $monthFolder . '/'; // new destination path
                
                        // Check if the directory exists, create it if not
                        if (!is_dir($newuploadDir)) {
                            mkdir($newuploadDir, 0777, true);
                        }
                
                        $uploadFile = $newuploadDir . $entry_file_edit; // new destination path with filename
                        $uploadFileName = $entry_file_edit;
                
                        // Check if the destination file exists
                        if (file_exists($uploadFile)) {
                            // Remove the destination file before copying
                            unlink($uploadFile);
                        }
                
                        // Attempt to copy the file
                        if (copy($source_path, $uploadFile)) {
    
                            $branchDir = 'views/files/branchtimeindtr/' . $branch . '/' . $entry_date_edit_old;
    
                            if (unlink($source_path)) {
                                rmdir($branchDir);
                            } 
    
                            rmdir($source_path);
    
                            $table = "branch_time_in_dtr_upload";
                            $data = array(
                                "id" => $id,
                                "branch_name" => $branch,
                                "entry_subj" => $_POST["entry_subj"],
                                "entry_file" => $uploadFileName, // Store the file path in the database
                                "entry_date" => $_POST["entry_date"]
                            );
                
                            $answer = (new ModelDTR)->mdlEditBranchDailyTimeInDTRUpload($table, $data);

                            $result = ($answer == "ok") ? "ok_date" : "error_date";
                            $handleUploadResponseTimein($result);
                
                        } else {
                            // Error in copying the file
                            $result = "error_date";
                            $handleUploadResponseTimein($result);
                        }
                    }
                }

            }
        }
    }

    static public function handleUploadResponseTimein($result)
    {
        if($result == "ok_file_date"){
            echo '<script>
                    swal({
                        type: "success",
                        title: "File Successfully Updated!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "branchTimeInDTRUpload";
                        }
                    });
                    </script>';
        } elseif($result == "error_file_date"){
            echo '<script>
                    swal({
                        type: "warning",
                        title: "There\'s an error occurred updating!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    });
                    </script>';
        } elseif ($result == "ok_info") {
            echo '<script>
                    swal({
                        type: "success",
                        title: "Info Successfully Updated!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "branchTimeInDTRUpload";
                        }
                    });
                </script>';
        } elseif ($result == "error_info") {
            echo '<script>
                    swal({
                        type: "warning",
                        title: "There\'s an error occurred updating info!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    });
                </script>';
        } elseif ($result == "ok_date") {
            echo '<script>
                    swal({
                        type: "success",
                        title: "Date Successfully Updated!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "branchTimeInDTRUpload";
                        }
                    });
                </script>';
        } elseif ($result == "error_date") {
            echo '<script>
                    swal({
                        type: "warning",
                        title: "There\'s an error occurred updating date!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    });
                </script>';
        
        }
    }

    static public function ctrDeleteBranchDailyTimeInDTRUpload(){
        if(isset($_GET['id']) && isset($_GET['branch_name']) && isset($_GET['entry_date'])){
    
            $table = "branch_time_in_dtr_upload";
            $id = $_GET["id"];
            $entry_date = $_GET["entry_date"];
            $branch_name = $_GET["branch_name"];

            $monthFolder = date('Y-M-d', strtotime($_GET['entry_date']));
    
            // Get the file path from the database
            $fileInfo = (new ModelDTR)->getFileInformation($table, $id, $entry_date, $branch_name);
    
            if($fileInfo){
                $filePath = 'views/files/branchtimeindtr/'.$branch_name.'/'.$monthFolder.'/'.$fileInfo['entry_file'];
    
                // Delete the record from the database
                $answer = (new ModelDTR)->mdlDeleteBranchDailyTimeInDTRUpload($table, $id, $entry_date, $branch_name);
    
                if($answer == "ok"){
                    // Delete the file from the server
                    if(file_exists($filePath)){
                        unlink($filePath);
                          // SET Directory to be deleted  
                        $branchDir = 'views/files/branchtimeindtr/' . $branch_name . '/' . $monthFolder;
                        rmdir($branchDir);
                    }
    
                    echo '<script>
                            swal({
                                type: "success",
                                title: "Record has been successfully deleted!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "branchTimeInDTRUpload";
                                }
                            });
                          </script>';
                } else if($answer == "error"){
                    echo '<script>
                            swal({
                                type: "warning",
                                title: "There\'s an error occurred!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    // Handle error as needed
                                }
                            });
                          </script>';
                }
            } else {
                // Handle case where file information is not found
                echo '<script>
                        swal({
                            type: "error",
                            title: "File information not found!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                      </script>';
            }
        }
    }

    // HR TIME-IN DTR DOWNLOAD

    static public function ctrShowHRDailyTimeInDTRDownload(){
        $answer = (new ModelDTR)->mdlShowHRDailyTimeInDTRDownload();
		return $answer;
    }

    static public function ctrUpdateBranchTimeInDTR($id, $entry_date, $branch_name){
        $answer = (new ModelDTR)->mdlUpdateBranchTimeInDTR($id, $entry_date, $branch_name);
		return $answer;
    }

    static public function ctrGetBranchDailyTimeInDTRUploadList($branch_name, $check_entry_date){

        $file_info = (new ModelDTR)->mdlCheckDailyTimeInDTRExist($branch_name, $check_entry_date);

        return $file_info;
    
    }


    static public function ctrDownloadAllDTRTimeInAndMoveFile(){
        ob_start(); // Start output buffering

        if(isset($_GET["entry_date"]) && isset($_GET["download_all_DTR_time_in"])){

            $entry_date = $_GET['entry_date'];

            $has_data = (new ModelDTR)->mdlGetBranchDailyTimeInDTRUploadList($entry_date);

            if ($has_data === 'yes') {
                $branchFolders = array(
                    'EMB MAIN BRANCH',
                    'EMB CADIZ',
                    'EMB LA CARLOTA',
                    'EMB KABANKALAN',
                    'EMB ILOILO',
                    'EMB DUMAGUETE',
                    'EMB SAN CARLOS',
                    'EMB TAGBILARAN',
                    'EMB MANDAUE',
                    'EMB ROXAS',
                    'EMB SAGAY',
                    'EMB VICTORIAS',
                    'EMB BAYAWAN',
                    'EMB BAIS',
                    'EMB LA CASTELLANA',
                    'EMB PASSI',
                    'EMB SARA',
                    'EMB SIPALAY',
                    'EMB CEBU',
                    'EMB TALISAY',
                    'EMB TOLEDO',
                    'EMB MIAG AO',
                    'EMB TUBIGON',
                    'EMB MAMBUSAO',
                    'EMB DANAO',
                    'FCH BACOLOD',
                    'FCH SILAY',
                    'FCH BAGO',
                    'FCH MURCIA',
                    'FCH BINALBAGAN',
                    'FCH HINIGARAN',
                    'FCH PARANAQUE',
                    'FCH MUNTINLUPA',
                    'RLC KALIBO',
                    'RLC BURGOS',
                    'RLC ANTIQUE',
                    'RLC SINGCANG',
                    'ELC BULACAN',
                );
                
                for ($i = 0; $i < count($branchFolders); $i++) {
    
                    $entry_date_format_folder = date('Y-M-d', strtotime($_GET['entry_date']));
                    $branch_name = $branchFolders[$i];
    
                    $file_info = (new ModelDTR)->mdlGetDailyTimeInDTRExist($branch_name, $entry_date);
    
                    // Set headers for file download
                    $entry_file = $file_info[0]["entry_file"]; // filename
                    $id = $file_info[0]["id"]; // data id
    
                    $source_path = 'views/files/branchtimeindtr/'.$branch_name.'/'.$entry_date_format_folder.'/'.$entry_file; // Set the source path to the file
    
                    // Set headers for file download
                    if(file_exists($source_path)){

                        echo '<script>
                            swal({
                                title: "Generating",
                                text: "Please wait...",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            </script>';
            
                        header('Content-Type: image/jpeg');
                        header('Content-Disposition: attachment; filename="'.basename($source_path).'"');
                        header('Content-Length: ' . filesize($source_path));
            
                        // Read and output the file contents
                        ob_end_clean();
                        // readfile($source_path);
        
                        // Move or copy the file to a different folder
                        $destination_path = 'C:/branchtimeindtr/' .$branch_name. '/' .$entry_date_format_folder. '/';
            
                        // Check if the directory exists, create it if not
                        if(!is_dir($destination_path)){
                            mkdir($destination_path, 0777, true);
                        }
            
                        $folder_and_file = $destination_path . $entry_file;
            
                        if(file_exists($folder_and_file)){
                        
                            continue;
                            
                        } else {
                            // Use either copy or rename based on your needs
                            copy($source_path, $folder_and_file);
                                // or
                            // rename($source_path, $destination_path);
        
                            $table = "branch_time_in_dtr_upload";
            
                            $entry_date_format = date('Y-m-d', strtotime($entry_date));
        
                            // $data = array(
                            //     "id" => $id,
                            //     "branch_name" => $branch_name,
                            //     "entry_date" => $entry_date_format
                                
                            // );
        
                            // $answer = (new ModelDTR)->mdlUpdateDTRStatus($table, $data);

                            $updateStatus = (new ControllerDtr)->ctrUpdateBranchTimeInDTR($id, $entry_date_format, $branch_name);
        
                        }
                    } else {

                        continue;

                    }
                    
                }
    
                echo '<script>
    
                    swal.close();
                        swal({
                            type: "success",
                            title: "All record has been successfully downloaded!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "hrTimeInDTRDownload";
                            }
                        });
                    </script>';
            
            } else {
                echo '<script>
    
                swal.close();
                    swal({
                        type: "info",
                        title: "No records has been found in specified date!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "hrTimeInDTRDownload";
                        }
                    });
                </script>';
            }

            ob_end_flush(); // Flush the output buffer
            exit(); // Exit to prevent further HTML output
        }
    }

    
    static public function ctrGetHRDailyDTRTimeInDownload($id, $branch_name){
        $answer = (new ModelDTR)->mdlGetHRDailyDTRTimeInDownload($id, $branch_name);
		return $answer;
    }


    
    
}


