<?php   
require __DIR__ . '/../vendor/autoload.php';// Autoload Composer dependencies
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
class ControllerQRCode{

    static public function ctrScanQRCode(){

            if (isset($_POST['scanQR'])) {
                $branch_name = $_SESSION['branch_name'];
                // Check if "RLC" is in the branch name and replace it with "RFC"
                if (strpos($branch_name, "RLC") !== false) {
                    $branch_name = str_replace("RLC", "RFC", $branch_name);
                }
                $item_code = $_POST['qr_data'];
                $status = "ITEM IN";
                // Process the QR data as needed
                // For example, you can save it to a database, log it, etc.
                $time_scan = date('Y-m-d H:i:s');
                // Example: Logging the QR data
                file_put_contents('qr_log.txt', date('Y-m-d H:i:s') . " - QR Code: " . $item_code . PHP_EOL, FILE_APPEND);
                $table = "inventory_log";
                $data=array("item_code"=>$item_code,
				"branch_name"=>$branch_name,
				"status"=>$status,
				"time_scan"=>$time_scan);
                $answer="";
                $message="";
                // Check the validity of the QR code to see if it's registered in the system.
                $checkerInv = (new ModelQRCode)->mdlGetItems($data);
                if(!empty($checkerInv)){
                    $checkerLog = (new ModelQRCode)->mdlGetItemLog($table, $data);
                    foreach($checkerInv as $row){
                            $item_description = $row['item_description'];
                            $sticker_no = $row['sticker_no'];
                            $item_status =  $row['status'];
                            $repair =  $row['repair'];
                            $date =  $row['last_repaired'];
                        }
                    if($item_status == "WORKING" || $item_status =="PENDING" || $item_status == "REPAIRED"){
                    if(empty($checkerLog)){
                        $message = "The item $item_description with sticker number $sticker_no has been successfully checked in.";
                        $data["item_description"] = $item_description;
                        $answer = (new ModelQRCode)->mdlAddItemLog($table, $data);
                    }else{
                        foreach($checkerLog as $log){
                            $log_branch_name = $log['branch_name'];
                            $log_status = $log['status'];
                        }
                    if($log_status == "ITEM IN" && $branch_name == $log_branch_name){
                        $data["status"] = "ITEM OUT";
                        $data["item_description"] = $item_description;
                        $answer = (new ModelQRCode)->mdlAddItemLog($table, $data);
                        if($_SESSION['type']=="inventory_mis"){
                            $date = date('Y-m-d H:i:s'); // Get the current date and time
                            $repair +=1;
                            $edit_status = "REPAIRED";
                            $answer1 = (new ModelQRCode)->mdlEditRepair($item_code, $date, $repair, $edit_status); // Call the method to update the item
                            if ($answer1 != "ok") {
                                $errorMessage = htmlspecialchars($answer1); // Convert the error message to a safe format for HTML output
                                echo '<script>
                                    swal({
                                        type: "error",
                                        title: "An error has occurred!",
                                        text: "' . $errorMessage . '",
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    }).then(function(result){
                                        if (result.value) {
                                            window.location = "inventory";
                                        }
                                    });
                                </script>';
                            }
                        }
                        $message = "The item $item_description with sticker number $sticker_no has been successfully checked out.";
                        $answer = "ok";
                    }else  if($log_status == "ITEM IN" && $branch_name != $log_branch_name){
                        $message = "The $item_description with sticker number $sticker_no is not recorded as checked out in the system. Its last known location is $log_branch_name.";
                        $answer = "error3";
                    }else if($log_status == "ITEM OUT" && $branch_name != $log_branch_name){    
                        $data["item_description"] = $item_description;
                        if($_SESSION['type']=="inventory_mis"){
                          $edit_status = "PENDING";
                           $answer1 =  (new ModelQRCode)->mdlEditRepair($item_code, $date, $repair, $edit_status);
                           if ($answer1 != "ok") {
                            $errorMessage = htmlspecialchars($answer1); // Convert the error message to a safe format for HTML output
                            echo '<script>
                                swal({
                                    type: "error",
                                    title: "An error has occurred!",
                                    text: "' . $errorMessage . '",
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "inventory";
                                    }
                                });
                            </script>';
                        }
                        }
                        $message = "The item $item_description with sticker number $sticker_no has been successfully checked in.";
                        $answer = (new ModelQRCode)->mdlAddItemLog($table, $data);
                        $answer = "ok";
                    }else if($log_status == "ITEM OUT" && $branch_name == $log_branch_name){
                        $message = "The item $item_description with sticker number $sticker_no has already been checked out.";
                        $answer = "error3";
                    }
                        // $answer = "error1";
                    }
                }else{
                    $message= "$item_status items cannot be checked in or out of the system!";
                    $answer = "error3";
                }
                
            }else{
                    $message= "The scanned QR code is not registered in the system!";
                    $answer = "error3";
                }
				if($answer == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "'.$message.'",
						  showConfirmButton: true,
						  confirmButtonText: "Ok"
						  }).then(function(result){
									if (result.value) {
									window.location = "inventory";
									}
								})
					</script>';

				}elseif($answer == "error3"){
                    echo'<script>
                    swal({
                          type: "error",
                          title: "'.$message.'",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "inventory";
                                    }
                                })
                    </script>';
                }
            }
    }
    static public function ctrCreateItemQRCode($id_holder) {
        // Set QR code options
        $options = new QROptions([
            'eccLevel' => QRCode::ECC_H,       // High error correction level for better resilience
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'imageBase64' => false,
            'scale' => 10,                     // Adjust scale for desired QR code size
        ]);
    
        // Generate QR code
        $qrcode = new QRCode($options);
        $qrImage = $qrcode->render($id_holder);
    
        // Create an image resource from the generated QR code
        $qrImageResource = imagecreatefromstring($qrImage);
    
        // Load the logo image
        $logo = imagecreatefrompng('views/img/JGC.png'); // Update with the correct path to your logo
    
        // Get dimensions of the QR code and the logo
        $qrWidth = imagesx($qrImageResource);
        $qrHeight = imagesy($qrImageResource);
        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
    
        // Calculate the size and position of the clear area in the center of the QR code
        $clearAreaSize = min($qrWidth, $qrHeight) * 0.2; // Clear area is 20% of the QR code size
        $clearAreaX = ($qrWidth - $clearAreaSize) / 2;
        $clearAreaY = ($qrHeight - $clearAreaSize) / 2;
    
        // Draw a white rectangle in the center to create a clear area for the logo
        $backgroundColor = imagecolorallocate($qrImageResource, 255, 255, 255); // White background
        imagefilledrectangle($qrImageResource, $clearAreaX, $clearAreaY, $clearAreaX + $clearAreaSize, $clearAreaY + $clearAreaSize, $backgroundColor);
    
        // Scale the logo to fit within the clear area, maintaining aspect ratio
        $maxLogoSize = $clearAreaSize * 0.8; // Logo should occupy 80% of the clear area
        if ($logoWidth > $maxLogoSize || $logoHeight > $maxLogoSize) {
            // Calculate new logo dimensions while maintaining aspect ratio
            $scale = min($maxLogoSize / $logoWidth, $maxLogoSize / $logoHeight);
            $newLogoWidth = $logoWidth * $scale;
            $newLogoHeight = $logoHeight * $scale;
    
            // Create a new image resource for the scaled logo
            $scaledLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
            imagealphablending($scaledLogo, false);
            imagesavealpha($scaledLogo, true);
            imagecopyresampled($scaledLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
    
            // Position the scaled logo in the center of the clear area
            $logoX = $clearAreaX + ($clearAreaSize - $newLogoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $newLogoHeight) / 2;
    
            // Merge the scaled logo onto the QR code
            imagecopy($qrImageResource, $scaledLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);
    
            // Clean up the scaled logo resource
            imagedestroy($scaledLogo);
        } else {
            // Position the original logo in the center of the clear area
            $logoX = $clearAreaX + ($clearAreaSize - $logoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $logoHeight) / 2;
    
            // Merge the original logo onto the QR code
            imagecopy($qrImageResource, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);
        }
    
        // Save the QR code with the logo to a file
        $filename = 'views/files/qrcodes/' . $id_holder . '.png';
        imagepng($qrImageResource, $filename);
    
        // Clean up memory
        imagedestroy($qrImageResource);
        imagedestroy($logo);
    }
    static public function ctrAddItem(){
        // Check if the form was submitted with either type
        if (isset($_POST['addItem']) || isset($_POST['addUnregisterItem'])) {
            $table = "inventory";
            // Determine the type based on which button was clicked
            if (isset($_POST['addItem'])) {
                $type = "REGISTERED";
            } else if (isset($_POST['addUnregisterItem'])) {
                $type = "UNREGISTERED";
            }
            // Get the initial item code from the POST request
            $qty = $_POST['qty'];
            $id_holder = $_POST['item_code'];
            $sticker_no = $_POST['sticker_no'];
            $first_unique = "";
            $stickerTemp = $_POST['sticker_no'];
            $branch = $_POST['item_location'];
            $class_code = $_POST['class_code'];
            if(isset($_POST['computer_set'])){
                $computer_set = $_POST['computer_set'];
            }
            if(isset($_POST['cctv_set'])){
                $cctv_set = $_POST['cctv_set'];
            }
            $camera_count = $_POST['camera_count'];
            $answer = "";
            $counter = 0;
            for($y = 0; $y<$qty; $y++){
                $checkSticker =  (new ControllerQRCode)->ctrCheckSticker($stickerTemp, $branch);
                if(!empty($checkSticker) || is_null($checkSticker)){
                    $checker = "duplicate";
                    break;
                }else{
                    $checker = "ok";
                }
                $stickerTemp++;

            }

            if($checker == "ok"){
            // Step 1: Check if the item code already exists in the database
            for($i = 0; $i<$qty; $i++){
            $uniqueCodeFound = false;

            while (!$uniqueCodeFound) {
                $chkItemCode = (new ControllerQRCode)->ctrCheckItemCode($id_holder);
                // If the item code exists, increment the numeric part and check again
                if (!empty($chkItemCode)) {
                    // Increment the numeric part
                        // Extract the numeric part of the item code
                    $prefix = substr($id_holder, 0, 2);  // 'IC'
                    $numericPart = substr($id_holder, 2); // '00002'
                    $numericPart = str_pad((int)$numericPart + 1, 5, '0', STR_PAD_LEFT);
                    $id_holder = $prefix . $numericPart;
                } else {
                    // If the item code does not exist, we can use it
                    $uniqueCodeFound = true;
                    if ($i == 0) {
                        $first_unique = $id_holder;
                    }
                }
            }
            $uniqueClassCodeFound = false;

            while (!$uniqueClassCodeFound) {
                $chkClassCode = (new ControllerQRCode)->ctrCheckClassCode($class_code);
            
                // If the class code exists, increment the numeric part and check again
                if (!empty($chkClassCode)) {
                    // Extract the prefix (non-numeric part)
                    preg_match('/^([A-Za-z]+)(\d+)$/', $class_code, $matches);
                    if ($matches) {
                        $prefix = $matches[1];  // Extract the prefix (e.g., 'FRT', 'FRCS')
                        $numericPart = (int)$matches[2]; // Extract the numeric part as an integer
            
                        // Increment the numeric part and use sprintf for formatting with leading zeros
                        $class_code = $prefix . sprintf('%05d', $numericPart + 1);
                    }
                } else {
                    // If the class code does not exist, we can use it
                    $uniqueClassCodeFound = true;
                }
            }
            




               // Generate the QR code with the unique item code
               (new ControllerQRCode)->ctrCreateItemQRCode($id_holder);
            // Collect the form data
            $data = array(
                "company" => $_POST['company'],
                "item_code" => $id_holder,
                "sticker_no" => $sticker_no ,
                "date_purchased" => $_POST['date_purchased'],
                "item_location" => strtoupper($_POST['item_location']),
                "price" => $_POST['price'],
                "serial_no" => strtoupper($_POST['serial_no']),
                "item_description" => strtoupper($_POST['item_description']),
                "supplier" => $_POST['supplier'],
                "type" => $type,
                "qty_code" => $first_unique,
                "class_type" => $_POST['class_type'],
                "class_category" => $_POST['class_category'],
                "class_list" => $_POST['class_list'],
                "class_code" => $class_code,
            );
    
            // Add the item to the database
            $answer = (new ModelQRCode)->mdlAddItem($table, $data);
            $sticker_no++;
            if($answer != "ok"){
                $counter++;
            }
        }

        if($counter == 0 && !empty($computer_set)) {
            $y = 1;
            $newStick = $sticker_no -1;
            $origSticker = $sticker_no;
            foreach($computer_set as $list) {
                // Generate the unique item code
                $uniqueItemCode = (new ControllerQRCode)->ctrGenerateUniqueItemCode($id_holder);
                // Update the sticker number based on the loop iteration
                if($list == "MOUSE" || $list == "KEYBOARD"){
                    $newSticker = $newStick .'.'. $y;
                    $addedSticker = $newSticker;
                    $y++;
                }else{
                    $addedSticker = $origSticker;
                    $origSticker++;
                }
                $data3 = array(
                    "company" => $_POST['company'],
                    "item_code" => $uniqueItemCode,  // Use the generated unique item code
                    "sticker_no" => $addedSticker,
                    "date_purchased" => $_POST['date_purchased'],
                    "item_location" => strtoupper($_POST['item_location']),
                    "price" => $_POST['price'],
                    "serial_no" => strtoupper($_POST['serial_no']),
                    "item_description" => strtoupper($list),
                    "supplier" => $_POST['supplier'],
                    "type" => $type,
                    "qty_code" => $first_unique,
                    "class_type" => $_POST['class_type'],
                    "class_category" => $_POST['class_category'],
                    "class_list" => $_POST['class_list'],
                    "class_code" => $class_code,
                );
                $answer = (new ModelQRCode)->mdlAddItem($table, $data3);
                 // Generate the QR code with the unique item code
               (new ControllerQRCode)->ctrCreateItemQRCode($uniqueItemCode);
                $data1 = array(
                    "class_code" => $class_code,
                    "item_code" => $uniqueItemCode,  // Use the same unique item code
                    "item_description" => $list,
                    "set_type" => "COMPUTER SET",
                    "item_location" => strtoupper($_POST['item_location']),
                    "set_categ" => "PRIMARY",
                );
                $addset = (new ModelQRCode)->mdlAddItemSet($data1);
                // Update $id_holder to reflect the last unique item code
                $id_holder = $uniqueItemCode;
            }
        }
        
        if($counter == 0 && !empty($cctv_set)) {
            $y = 1;
            $newSticker = $sticker_no;
            
            foreach($cctv_set as $cctv) {
                // Check if the item is "CAMERA" and if the count is more than 1
                if($cctv == "CAMERA" && $camera_count > 1) {
                    // Loop based on the camera count
                    for($z = 1; $z <= $camera_count; $z++) {
                        // Generate the unique item code
                        $uniqueItemCode = (new ControllerQRCode)->ctrGenerateUniqueItemCode($id_holder);
        
                        // Prepare the data for the database insertion
                        $data3 = array(
                            "company" => $_POST['company'],
                            "item_code" => $uniqueItemCode,  // Use the generated unique item code
                            "sticker_no" => $newSticker,
                            "date_purchased" => $_POST['date_purchased'],
                            "item_location" => strtoupper($_POST['item_location']),
                            "price" => $_POST['price'],
                            "serial_no" => strtoupper($_POST['serial_no']),
                            "item_description" => strtoupper($cctv),
                            "supplier" => $_POST['supplier'],
                            "type" => $type,
                            "qty_code" => $first_unique,
                            "class_type" => $_POST['class_type'],
                            "class_category" => $_POST['class_category'],
                            "class_list" => $_POST['class_list'],
                            "class_code" => $class_code,
                        );
        
                        // Insert into the database
                        $answer = (new ModelQRCode)->mdlAddItem($table, $data3);
        
                        // Generate the QR code with the unique item code
                        (new ControllerQRCode)->ctrCreateItemQRCode($uniqueItemCode);
        
                        // Add to the item set
                        $data1 = array(
                            "class_code" => $class_code,
                            "item_code" => $uniqueItemCode,  // Use the same unique item code
                            "item_description" => $cctv,
                            "set_type" => "CCTV SET",
                            "item_location" => strtoupper($_POST['item_location']),
                            "set_categ" => "PRIMARY",
                        );
        
                        $addset = (new ModelQRCode)->mdlAddItemSet($data1);
        
                        // Increment the sticker number
                        $newSticker++;
        
                        // Update $id_holder to reflect the last unique item code
                        $id_holder = $uniqueItemCode;
                    }
                } else {
                    // Normal adding for other items or single CAMERA
                    $uniqueItemCode = (new ControllerQRCode)->ctrGenerateUniqueItemCode($id_holder);
        
                    $data3 = array(
                        "company" => $_POST['company'],
                        "item_code" => $uniqueItemCode,
                        "sticker_no" => $newSticker,
                        "date_purchased" => $_POST['date_purchased'],
                        "item_location" => strtoupper($_POST['item_location']),
                        "price" => $_POST['price'],
                        "serial_no" => strtoupper($_POST['serial_no']),
                        "item_description" => strtoupper($cctv),
                        "supplier" => $_POST['supplier'],
                        "type" => $type,
                        "qty_code" => $first_unique,
                        "class_type" => $_POST['class_type'],
                        "class_category" => $_POST['class_category'],
                        "class_list" => $_POST['class_list'],
                        "class_code" => $class_code,
                    );
        
                    // Insert into the database
                    $answer = (new ModelQRCode)->mdlAddItem($table, $data3);
        
                    // Generate the QR code with the unique item code
                    (new ControllerQRCode)->ctrCreateItemQRCode($uniqueItemCode);
        
                    // Add to the item set
                    $data1 = array(
                        "class_code" => $class_code,
                        "item_code" => $uniqueItemCode,
                        "item_description" => $cctv,
                        "set_type" => "CCTV SET",
                        "item_location" => strtoupper($_POST['item_location']),
                        "set_categ" => "PRIMARY",
                    );
        
                    $addset = (new ModelQRCode)->mdlAddItemSet($data1);
        
                    // Increment the sticker number
                    $newSticker++;
        
                    // Update $id_holder to reflect the last unique item code
                    $id_holder = $uniqueItemCode;
                }
            }
        }
        
    }else{
        echo '<script>
                    swal({
                        type: "error",
                        title: "Duplicate sticker number detected. Please ensure each item has a unique sticker number.",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "inventory";
                        }
                    });
                </script>';
    }
            // Display success or error message
            if ($answer == "ok") {
                // echo '<script>
                //     swal({
                //         type: "success",
                //         title: "Records have been successfully added!",
                //         showConfirmButton: true,
                //         confirmButtonText: "Ok"
                //     }).then(function(result) {
                //         if (result.value) {
                //             window.location = "inventory";
                //         }
                //     });
                // </script>';
            }else if($answer == "error"){
                $errorMessage = htmlspecialchars($answer);
                echo '<script>
                    swal({
                        type: "error",
                        title: "An error has occurred",
                        text: "' . $errorMessage . '",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            // Optionally, you can redirect or perform another action here
                        }
                    });
                </script>';
            }
        }
    }
    
        static public function ctrEditItem() {
            if (isset($_POST['editItem'])) {
                $table = "inventory";
                if($_POST['status'] == "DISPOSED"){
                    
                    $date_dispose = date('Y-m-d H:i:s');
                }else{
                    $date_dispose = "";
                }
                if($_POST['status'] == "DEFECTIVE"){
                    
                    $date_defective = date('Y-m-d H:i:s');
                }else{
                    $date_defective = "";
                }

                $data = [
                    "item_id" => $_POST['item_id'],
                    "sticker_no" => $_POST['sticker_no'],
                    "date_purchased" => $_POST['date_purchased'],
                    "item_location" => $_POST['item_location'],
                    "serial_no" => $_POST['serial_no'],
                    "item_description" => $_POST['item_description'],
                    "company" => $_POST['company'],
                    "price" => $_POST['price'],
                    "supplier" => $_POST['supplier'],
                    "status" => $_POST['status'],
                    "date_dispose" => $date_dispose,
                    "date_defective" => $date_defective,
                ];
                $sticker_no = $_POST['sticker_no'];
                $company = $_POST['company'];
                $modelQRCode = new ModelQRCode();
                $chkSticker = $modelQRCode->mdlCheckDuplication($company, $sticker_no);
                // if (empty($chkSticker) || $chkSticker[0]['id'] == $_POST['item_id']) {
                    $answer = $modelQRCode->mdlEditInventory($table, $data);
                    $messageType = $answer == "ok" ? "success" : "error";
                    $message = $answer == "ok" ? "" : "An error has occurred!";
                    $location = $answer == "ok"?"inventory" : "";
                // } else {
                //     $messageType = "error";
                //     $message = "The sticker number $sticker_no in $company is already in use!";
                //     $location = "";
                // }
        
                (new ControllerQRCode())->alertMessage($messageType, $location, $message);
            }
        }

        static public function ctrShowInventoryTable($type){
            $answer = (new ModelQRCode)->mdlShowInventoryTable($type);
            return $answer;
        }

        static public function ctrGetItmebyID($id){
            $answer = (new ModelQRCode)->mdlGetItmebyID($id);
            return $answer;
        }
    
        static public function ctrGetLastSticker($branch){
            $answer = (new ModelQRCode)->mdlGetLastSticker($branch);
            return $answer;
        }

        static public function ctrGetLastStickerMain($branch){
            $answer = (new ModelQRCode)->mdlGetLastStickerMain($branch);
            return $answer;
        }


        public function alertMessage($answer, $location, $message) {
            $type = $answer == "success" ? "success" : "error";
            $title = $answer == "success" ? "Records have been successfully updated!" : $message;
            $redirectScript = $location ? 'window.location = "'.$location.'";' : '';
            
            echo '<script>
                swal({
                    type: "'.$type.'",
                    title: "'.$title.'",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        '.$redirectScript.'
                    }
                });
            </script>';
        }


        static public function ctrDeleteData($id, $table){
            $answer = (new ModelQRCode)->mdlDeleteData($id, $table);
            return $answer;
        }
        
    
            
        static public function ctrGetStickerByCompany($company){
            $answer = (new ModelQRCode)->mdlGetStickerByCompany($company);
            return $answer;
        }

        static public function ctrGetItemLogs($item_code){
            $answer = (new ModelQRCode)->mdlGetItemLogs($item_code);
            return $answer;
        }
        static public function ctrGetItemCode(){
            $answer = (new ModelQRCode)->mdlGetItemCode();

            if (!empty($answer)) { // Assuming 'item_code' is the column name
                // Extract the item code from the array
                $itemCode = $answer[0]['item_code'];
                // Extract the prefix (e.g., "UI") and the numeric part (e.g., "00010")
                $prefix = substr($itemCode, 0, 2); // Adjust if the prefix length varies
                $numericPart = substr($itemCode, 2); // Extract the numeric part
                
                // Convert the numeric part to an integer and increment it
                $newNumericPart = (int)$numericPart + 1;
                
                // Format the new numeric part w th leading zeros (e.g., "00011")
                $newNumericPartFormatted = str_pad($newNumericPart, strlen($numericPart), '0', STR_PAD_LEFT);
                
                // Combine the prefix and the new numeric part
                $newItemCode = $prefix . $newNumericPartFormatted;
            } else {
                // If no item code is found, start from the first one
                $newItemCode = 'UI00001'; // Replace 'UI' and '00001' with your desired starting format
            }
            
              // Set QR code options
        $options = new QROptions([
            'eccLevel' => QRCode::ECC_H, // Higher error correction level
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'imageBase64' => false,
            'scale' => 10, // Adjust scale as needed
        ]);
    
        // Generate QR code
        $qrcode = new QRCode($options);
        $qrImage = $qrcode->render($newItemCode);
    
        // Create an image resource from the QR code
        $qrImageResource = imagecreatefromstring($qrImage);
    
        // Load the logo image
        $logo = imagecreatefrompng('../views/img/JGC.png'); // Replace with your logo path
    
        // Get dimensions of QR code and logo
        $qrWidth = imagesx($qrImageResource);
        $qrHeight = imagesy($qrImageResource);
        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
    
        // Calculate the size and position of the clear area in the center
        $clearAreaSize = min($qrWidth, $qrHeight) * 0.2; // Clear area size
        $clearAreaX = ($qrWidth - $clearAreaSize) / 2;
        $clearAreaY = ($qrHeight - $clearAreaSize) / 2;
    
        // Draw a white rectangle in the center to create a clear area
        $backgroundColor = imagecolorallocate($qrImageResource, 255, 255, 255); // White color
        imagefilledrectangle($qrImageResource, $clearAreaX, $clearAreaY, $clearAreaX + $clearAreaSize, $clearAreaY + $clearAreaSize, $backgroundColor);
    
        // Scale the logo to fit within the clear area
        $maxLogoSize = $clearAreaSize * 0.8; // 80% of the clear area size
        if ($logoWidth > $maxLogoSize || $logoHeight > $maxLogoSize) {
            // Calculate new logo dimensions
            $scale = min($maxLogoSize / $logoWidth, $maxLogoSize / $logoHeight);
            $newLogoWidth = $logoWidth * $scale;
            $newLogoHeight = $logoHeight * $scale;
    
            // Create a new image resource for the scaled logo
            $scaledLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
            imagealphablending($scaledLogo, false);
            imagesavealpha($scaledLogo, true);
            imagecopyresampled($scaledLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
    
            // Position the logo in the center of the clear area
            $logoX = $clearAreaX + ($clearAreaSize - $newLogoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $newLogoHeight) / 2;
    
            // Merge the scaled logo onto the QR code
            imagecopy($qrImageResource, $scaledLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);
    
            // Clean up the scaled logo resource
            imagedestroy($scaledLogo);
        } else {
            // Position the logo in the center of the clear area
            $logoX = $clearAreaX + ($clearAreaSize - $logoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $logoHeight) / 2;
    
            // Merge the original logo onto the QR code
            imagecopy($qrImageResource, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);
        }
    
        // Save the QR code with the logo to a file
        $filename = '../views/files/qrcodes/' . $newItemCode . '.png';
        imagepng($qrImageResource, $filename);
    
        // Clean up memory
        imagedestroy($qrImageResource);
        imagedestroy($logo);
                return $newItemCode;
        }


        static public function ctrCheckItemCode($id_holder){
            $answer = (new ModelQRCode)->mdlCheckItemCode($id_holder);
            return $answer;
        }

        static public function ctrGetAllDataByBranch($branch, $status){
            $answer = (new ModelQRCode)->mdlGetAllDataByBranch($branch, $status);
            return $answer;
        }

        static public function ctrGetAllPendingItem($branch){
            $answer = (new ModelQRCode)->mdlGetAllPendingItem($branch);
            return $answer;
        }

        static public function ctrGetAllRepairItem($branch){
            $answer = (new ModelQRCode)->mdlGetAllRepairItem($branch);
            return $answer;
        }


        
        static public function ctrGetItmebyBranch($branch){
            $answer = (new ModelQRCode)->mdlGetItmebyBranch($branch);
            return $answer;
        }

        static public function ctrGetItembyItemCode($branch, $item_code){
            $answer = (new ModelQRCode)->mdlGetItmebyItemCode($branch, $item_code);
            return $answer;
        }

        static public function ctrGetAuditScanQR($branch, $date){
            $answer = (new ModelQRCode)->mdlGetAuditScanQR($branch, $date);
            return $answer;
        }
        static public function ctrCheckAuditlogs($item_code, $date){
            $answer = (new ModelQRCode)->mdlCheckAuditlogs($item_code, $date);
            return $answer;
        }

        
        static public function ctrAuditListToScan($branch, $date){
            $answer = (new ModelQRCode)->mdlAuditListToScan($branch,  $date);
            return $answer;
        }


        static public function ctrCreateFFEItemQRCode($id_holder) {
            // Set QR code options
            $options = new QROptions([
                'eccLevel' => QRCode::ECC_H,       // High error correction level for better resilience
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'imageBase64' => false,
                'scale' => 10,                     // Adjust scale for desired QR code size
            ]);
        
            // Generate QR code
            $qrcode = new QRCode($options);
            $qrImage = $qrcode->render($id_holder);
        
            // Create an image resource from the generated QR code
            $qrImageResource = imagecreatefromstring($qrImage);
        
            // Load the logo image
            $logo = imagecreatefrompng('../views/img/JGC.png'); // Update with the correct path to your logo
        
            // Get dimensions of the QR code and the logo
            $qrWidth = imagesx($qrImageResource);
            $qrHeight = imagesy($qrImageResource);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);
        
            // Calculate the size and position of the clear area in the center of the QR code
            $clearAreaSize = min($qrWidth, $qrHeight) * 0.2; // Clear area is 20% of the QR code size
            $clearAreaX = ($qrWidth - $clearAreaSize) / 2;
            $clearAreaY = ($qrHeight - $clearAreaSize) / 2;
        
            // Draw a white rectangle in the center to create a clear area for the logo
            $backgroundColor = imagecolorallocate($qrImageResource, 255, 255, 255); // White background
            imagefilledrectangle($qrImageResource, $clearAreaX, $clearAreaY, $clearAreaX + $clearAreaSize, $clearAreaY + $clearAreaSize, $backgroundColor);
        
            // Scale the logo to fit within the clear area, maintaining aspect ratio
            $maxLogoSize = $clearAreaSize * 0.8; // Logo should occupy 80% of the clear area
            if ($logoWidth > $maxLogoSize || $logoHeight > $maxLogoSize) {
                // Calculate new logo dimensions while maintaining aspect ratio
                $scale = min($maxLogoSize / $logoWidth, $maxLogoSize / $logoHeight);
                $newLogoWidth = $logoWidth * $scale;
                $newLogoHeight = $logoHeight * $scale;
        
                // Create a new image resource for the scaled logo
                $scaledLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
                imagealphablending($scaledLogo, false);
                imagesavealpha($scaledLogo, true);
                imagecopyresampled($scaledLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
        
                // Position the scaled logo in the center of the clear area
                $logoX = $clearAreaX + ($clearAreaSize - $newLogoWidth) / 2;
                $logoY = $clearAreaY + ($clearAreaSize - $newLogoHeight) / 2;
        
                // Merge the scaled logo onto the QR code
                imagecopy($qrImageResource, $scaledLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);
        
                // Clean up the scaled logo resource
                imagedestroy($scaledLogo);
            } else {
                // Position the original logo in the center of the clear area
                $logoX = $clearAreaX + ($clearAreaSize - $logoWidth) / 2;
                $logoY = $clearAreaY + ($clearAreaSize - $logoHeight) / 2;
        
                // Merge the original logo onto the QR code
                imagecopy($qrImageResource, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);
            }
        
            // Save the QR code with the logo to a file
            $filename = '../views/files/qrcodes/' . $id_holder . '.png';
            imagepng($qrImageResource, $filename);
        
            // Clean up memory
            imagedestroy($qrImageResource);
            imagedestroy($logo);
        }


        static public function ctrAddUnregister(){
            // Check if the form was submitted with either type
            if (isset($_POST['addUnregistered'])) {
                $table = "inventory_unregistered";
                $data = array(
                    "branch_name" => strtoupper($_POST['un_branch_name']),
                    "sticker_no" => $_POST['un_sticker_no'],
                    "item_description" => strtoupper($_POST['un_item_description']),
                    "serial_no" => strtoupper($_POST['un_serial_no']),
                    "date_purchased" => $_POST['un_date_purchased'],
                );
                // Add the item to the database
                $answer = (new ModelQRCode)->mdlAddUnregister($table, $data);
                // Display success or error message
                if ($answer == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "Records have been successfully added!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "inventory";
                            }
                        });
                    </script>';
                } else {
                    $errorMessage = htmlspecialchars($answer);
                    echo '<script>
                        swal({
                            type: "error",
                            title: "An error has occurred!",
                            text: "' . $errorMessage . '",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                // Optionally, you can redirect or perform another action here
                            }
                        });
                    </script>';
                }
            }
        }


        static public function ctrGetAllRequest($date){
            $answer = (new ModelQRCode)->mdlGetAllRequest($date);
            return $answer;
        }

        static public function ctrCheckSticker($sticker_no, $branch){
            $answer = (new ModelQRCode)->mdlCheckSticker($sticker_no, $branch);
            return $answer;
        }


        static public function ctrCheckItemLog($item_code){
            $answer = (new ModelQRCode)->mdlCheckItemLog($item_code);
            return $answer;
        }


        static public function ctrgetLastCountCategory($class_categ){
            $answer = (new ModelQRCode)->mdlgetLastCountCategory($class_categ);
            return $answer;
        }
        
        
        static public function ctrCheckClassCode($class_code){
            $answer = (new ModelQRCode)->mdlCheckClassCode($class_code);
            return $answer;
        }
        static public function ctrGenerateUniqueItemCode($id_holder) {
            $uniqueCodeFound = false;
            while (!$uniqueCodeFound) {
                // Check if the item code exists
                $chkItemCode = (new ControllerQRCode)->ctrCheckItemCode($id_holder);
        
                if (!empty($chkItemCode)) {
                    // Increment the numeric part of the code if it exists
                    $prefix = substr($id_holder, 0, 2);  // e.g., 'IC'
                    $numericPart = substr($id_holder, 2); // e.g., '00002'
                    $numericPart = str_pad((int)$numericPart + 1, 5, '0', STR_PAD_LEFT);
                    $id_holder = $prefix . $numericPart; // e.g., 'IC00003'
                } else {
                    // If the item code does not exist, mark the code as unique
                    $uniqueCodeFound = true;
                }
            }
        
            // Return the unique item code
            return $id_holder;
        }

        static public function ctrGetItemSetPrim($class_code){
            $answer = (new ModelQRCode)->mdlGetItemSetPrim($class_code);
            return $answer;
        }
        static public function ctrGetItemSetAdd($class_code){
            $answer = (new ModelQRCode)->mdlGetItemSetAdd($class_code);
            return $answer;
        }

        static public function ctrGetAdditionalItem($item_location){
            $answer = (new ModelQRCode)->mdlGetAdditionalItem($item_location);
            return $answer;
        }

        static public function ctrGetDataByItemCode($item_code){
            $answer = (new ModelQRCode)->mdlGetDataByItemCode($item_code);
            return $answer;
        }
        
        
        static public function ctrGetItmebyBranchAudit($branch, $date){
            $answer = (new ModelQRCode)->mdlGetItmebyBranchAudit($branch, $date);
            return $answer;
        }

        static public function ctrGetFurnitureByBranch($branch){
            $answer = (new ModelQRCode)->mdlGetFurnitureByBranch($branch);
            return $answer;
        }

        static public function ctrGetFixtureByBranch($branch){
            $answer = (new ModelQRCode)->mdlGetFixtureByBranch($branch);
            return $answer;
        }
        
        static public function ctrGetEquipmentByBranch($branch){
            $answer = (new ModelQRCode)->mdlGetEquipmentByBranch($branch);
            return $answer;
        }


        static public function ctrGetFixtureByBranch1($branch, $class_type){
            $answer = (new ModelQRCode)->mdlGetFixtureByBranch1($branch, $class_type);
            return $answer;
        }

        static public function ctrGetUndeliveredItem(){
            $answer = (new ModelQRCode)->mdlGetUndeliveredItem();
            return $answer;
        }
    

        static public function ctrGetDataByID($id){
            $answer = (new ModelQRCode)->mdlGetDataByID($id);
            return $answer;
        }

        static public function ctrDeleteSet($class_code, $table){
            $answer = (new ModelQRCode)->mdlDeleteSet($class_code, $table);
            return $answer;
        }

        static public function ctrCheckDatSet($class_code){
            $answer = (new ModelQRCode)->mdlCheckDatSet($class_code);
            return $answer;
        }

        static public function ctrDeleteDataByItemCode($item_code, $table){
            $answer = (new ModelQRCode)->mdlDeleteDataByItemCode($item_code, $table);
            return $answer;
        }
        
    
    }