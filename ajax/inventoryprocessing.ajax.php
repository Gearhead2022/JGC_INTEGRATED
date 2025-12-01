<?php
require_once "../controllers/qrcode.controller.php";
require_once "../models/qrcode.model.php";
require_once "../views/modules/session.php";
require __DIR__ . '/../vendor/autoload.php';// Autoload Composer dependencies
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
$type = $_GET['type'];
$conInv= new inventoryProcessing();
if($type == "get_sticker"){
    $conInv -> showCompanySticker();
}else if($type == "delete"){
    $conInv -> deleteSticker();
}
else if($type == "batchprint"){
    $conInv -> displayTicket();
}
else if($type == "history"){
    $conInv -> displayHistory();
}
else if($type == "itemcode"){
    $conInv -> displayItemCode();
}else if($type == "getbranch"){
    $conInv -> displayBranches();
}else if($type == "generate_sticker"){
    $conInv -> generateQRCode();
}else if($type == "displayAudit"){
    $conInv -> displayAudit();
}else if($type == "auditScanQR"){
    $conInv -> auditQRScan();
}
else if($type == "auditList"){
    $conInv -> auditListToScan();
}
else if($type == "getClassCategory"){
    $conInv -> displayClassCategory();
}
else if($type == "getClassList"){
    $conInv -> displayClassList();
}else if($type == "showItemSet"){
    $conInv -> displayItemSet();
}else if($type == "displayAdditional"){
    $conInv -> displayAdditional();
}
else if($type == "saveAdditionalItem"){
    $conInv -> saveAdditionalItem();
}
else if($type == "dltItemSet"){
    $conInv -> deleteItemSet();
}



class inventoryProcessing {
    
   public function showCompanySticker() {
    $branch = $_GET['branch'];
  // Check if the branch contains "MAIN HOLDING"
if (stripos($branch, 'MAIN HOLDING') !== false) {
    // Your code here
    $branch = "MAIN HOLDING";
    $data = (new ControllerQRCode)->ctrGetLastStickerMain($branch);
} else {
    // Handle cases where "MAIN HOLDING" is not found in the branch
    $data = (new ControllerQRCode)->ctrGetLastSticker($branch);
}

    // If data exists, update the last_sticker
    if (!empty($data)) {
        $lastSticker = (int)$data[0]['last_sticker'] + 1;
    }else{
        $lastSticker = 1;
    }

    // Initialize the response array
    $response = [
        'last_sticker' => $lastSticker
    ];

   echo json_encode([$response]);

   }
   public function displayBranches() {
    $company = $_GET['company'];

    // Function to generate options HTML from an array of branches
    function generateBranchOptions(array $branches) {
        $options = '';
        foreach ($branches as $branch) {
            $options .= '<option value="' . htmlspecialchars($branch, ENT_QUOTES) . '">' . htmlspecialchars($branch, ENT_QUOTES) . '</option>';
        }
        return $options;
    }

    // Determine the branches based on the company
    switch ($company) {
        case "EMB":
            $branches = [
                "EMB MAIN BRANCH",
                "EMB CADIZ",
                "EMB LA CARLOTA",
                "EMB KABANKALAN",
                "EMB ILOILO",
                "EMB DUMAGUETE",
                "EMB SAN CARLOS",
                "EMB TAGBILARAN",
                "EMB MANDAUE",
                "EMB ROXAS",
                "EMB SAGAY",
                "EMB VICTORIAS",
                "EMB BAYAWAN",
                "EMB BAIS",
                "EMB LA CASTELLANA",
                "EMB PASSI",
                "EMB SARA",
                "EMB SIPALAY",
                "EMB CEBU",
                "EMB TALISAY",
                "EMB TOLEDO",
                "EMB MAMBUSAO",
                "EMB MIAG AO",
                "EMB DANAO",
                "EMB TUBIGON",
                "EMB SIQUIJOR",
                "MAIN HOLDING / C&C",
                "MAIN HOLDING / MIS",
                "MAIN HOLDING / HROM",
                "MAIN HOLDING / OPR",
                "MAIN HOLDING / ACCT",
                "MAIN HOLDING / FIN ACCT",
                "MAIN HOLDING / GRCD",
                "MAIN HOLDING / AUDIT",
                "BRANCH TEST",
            ];
            break;

        case "FCH":
            $branches = [
                "FCH BACOLOD",
                "FCH SILAY",
                "FCH BAGO",
                "FCH MURCIA",
                "FCH BINALBAGAN",
                "FCH HINIGARAN",
                "FCH LAPU LAPU",
                "FCH PARANAQUE",
                "FCH MUNTINLUPA",
                "FCH ANTIPOLO",
                "FCH SIQUIJOR"
            ];
            break;

            case "RFC":
                $branches = [
                    "RFC BURGOS",
                    "RFC KALIBO",
                    "RFC SINGCANG",
                    "RFC ANTIQUE",
                    "RFC CULASI",
                ];
                break;
            case "ELC":
                $branches = [
                    "ELC BULACAN",
                ];
                break;
            case "PSPMI":
                $branches = [
                    "SERVIAMUS",
                    "HPC",
                    "SAINT TERESA",
                    "DV COMPOUND",
                    "NAH",
                    "13TH STREET",
                    "SGI",
                    "PSPMI HOLDING",
                    "IC BUILDING",
                ];
                break;
            case "UBUNTU":
                $branches = [
                    "UBUNTU",
                ];
                break;

        default:
            $branches = [];
            break;
    }

    // Generate options HTML
    $response['card'] = generateBranchOptions($branches);

    // Return the response as JSON
    echo json_encode([$response]);
}

public function deleteSticker() {
    // Validate and sanitize input
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    $item_code = isset($_GET['item_code']) ? htmlspecialchars($_GET['item_code']) : null;
    $table = "inventory";

    // Check if required parameters are provided
    if ($id === null || $item_code === null) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
        return;
    }

    // Call the delete method
    $itemLogChecker = (new ControllerQRCode)->ctrCheckItemLog($item_code); 
    if (empty($itemLogChecker)) {
        $getData = (new ControllerQRCode)->ctrGetDataByID($id);
        if (empty($getData)) {
            echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
            return;
        }

        foreach ($getData as $data) {
            $class_list = $data['class_list'];
            $class_code = $data['class_code'];
        }
        $checkDataSet = (new ControllerQRCode)->ctrCheckDatSet($class_code);
        foreach($checkDataSet as $chk){
            $chkId = $chk['id'];
        }
      
        try {
            if($chkId == $id){
                if ($class_list == "COMPUTER SET" || $class_list == "CCTV SET") {
                    $result = (new ControllerQRCode)->ctrDeleteData($id, $table);
                    if ($result == "ok") {  
                        $result = (new ControllerQRCode)->ctrDeleteSet($class_code, $table);
                    }
                } else {
                    $result = (new ControllerQRCode)->ctrDeleteData($id, $table);
                }
            }else{
                $result = (new ControllerQRCode)->ctrDeleteData($id, $table);
                if($result == "ok"){
                    $result = (new ControllerQRCode)->ctrDeleteDataByItemCode($item_code, "inventory_itemset ");
                }

            }
        } catch (Exception $e) {
            // Log the exception message
            error_log($e->getMessage());
            $result = "error"; // Indicate an error occurred
        }
    } else {
        $result = "error"; // Cannot delete because data is in logs
    }

    // Create an associative array to return
    $response = [
        'status' => $result === "ok" ? 'success' : 'error',
        'message' => $result === "ok" ? 'Item deleted successfully.' : 'Cannot delete this sticker number; data is saved in the logs.'
    ];

    // Set content type to JSON
    header('Content-Type: application/json');
    
    // Return JSON encoded response
    echo json_encode($response);
}

    public function displayTicket(){ 
        $company = $_GET['company'];
        $data = (new ControllerQRCode)->ctrGetStickerByCompany($company);
        foreach ($data as &$item) {
            $id = $item['id'];
            $sticker_no = $item['sticker_no'];
            $item['card'] ='
                <div class="col-sm-2 mt-3">
                    <div class="checkDesign">
                        <input type="checkbox" value="'.$id.'" name="stickers[]" class="me-2 item-checkbox">
                        <span>'.$sticker_no.'</span>
                    </div>
                </div>
        ';
        }
        echo json_encode($data);
    }

    public function displayHistory(){
        $id = $_GET['id'];
        $data = (new ControllerQRCode)->ctrGetItmebyID($id);
        foreach ($data as &$item) {
            $item_code = $item['item_code'];
            $item_description = $item['item_description'];
            $sticker_no = $item['sticker_no'];
             $log = (new ControllerQRCode)->ctrGetItemLogs($item_code);
            $item['card'] ='
                  <div class="row" style="justify-content: space-between;">
                        <h5 style="padding-left: 1.1em;">'.$item_description.'</h5> 
                        <h5 style="padding-right: 1em;">'.$sticker_no.'</h5>
                    </div>
                    <div class="row historyContent">
                        <div class="col-sm-12">
                            <table class="table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 20em; position:sticky;">&nbsp;&nbsp;BRANCH</th>
                                        <th style="width: 17em;">MOVEMENT</th>
                                        <th style="width: 15em;">DATE</th>
                                    </tr>
                                </thead>
                                <tbody>';
                            foreach($log as $logs ){

                         $item['card'] .='
                                    <tr>
                                        <td>&nbsp;&nbsp;'.$logs['branch_name'].'</td>
                                        <td>'.$logs['status'].'</td>
                                        <td>'.$logs['date'].'</td>
                                    </tr>
                                    ';
                            }
                            $item['card'] .='
                                </tbody>
                            </table>
                        </div>
                    </div>
        ';
        }
        echo json_encode($data);
    }

    public function generateQRCode() {
        // Get the initial item code from the GET request
        $id_holder = $_GET['item_code'];
    
        // Extract the numeric part of the item code
        $prefix = substr($id_holder, 0, 2);  // 'IC'
        $numericPart = substr($id_holder, 2); // '00002'
    
   
        // Step 1: Check if the item code already exists in the database
        $uniqueCodeFound = false;
        while (!$uniqueCodeFound) {
            $chkItemCode = (new ControllerQRCode)->ctrCheckItemCode($id_holder);
            // If the item code exists, increment the numeric part and check again
            if (!empty($chkItemCode)) {
                // Increment the numeric part
                $numericPart = str_pad((int)$numericPart + 1, 5, '0', STR_PAD_LEFT);
                $id_holder = $prefix . $numericPart;
            } else {
                // If the item code does not exist, we can use it
                $uniqueCodeFound = true;
            }
           
        }
    
        // Step 2: Generate the QR code using the unique item code
        $options = new QROptions([
            'eccLevel' => QRCode::ECC_H,       // High error correction level for better resilience
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'imageBase64' => false,
            'scale' => 10,                     // Adjust scale for desired QR code size
        ]);
    
        $qrcode = new QRCode($options);
        $qrImage = $qrcode->render($id_holder);
    
        $qrImageResource = imagecreatefromstring($qrImage);
        $logo = imagecreatefrompng('../views/img/JGC.png'); // Update with the correct path to your logo
    
        $qrWidth = imagesx($qrImageResource);
        $qrHeight = imagesy($qrImageResource);
        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
    
        $clearAreaSize = min($qrWidth, $qrHeight) * 0.2;
        $clearAreaX = ($qrWidth - $clearAreaSize) / 2;
        $clearAreaY = ($qrHeight - $clearAreaSize) / 2;
    
        $backgroundColor = imagecolorallocate($qrImageResource, 255, 255, 255);
        imagefilledrectangle($qrImageResource, $clearAreaX, $clearAreaY, $clearAreaX + $clearAreaSize, $clearAreaY + $clearAreaSize, $backgroundColor);
    
        $maxLogoSize = $clearAreaSize * 0.8;
        if ($logoWidth > $maxLogoSize || $logoHeight > $maxLogoSize) {
            $scale = min($maxLogoSize / $logoWidth, $maxLogoSize / $logoHeight);
            $newLogoWidth = $logoWidth * $scale;
            $newLogoHeight = $logoHeight * $scale;
    
            $scaledLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
            imagealphablending($scaledLogo, false);
            imagesavealpha($scaledLogo, true);
            imagecopyresampled($scaledLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
    
            $logoX = $clearAreaX + ($clearAreaSize - $newLogoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $newLogoHeight) / 2;
    
            imagecopy($qrImageResource, $scaledLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);
            imagedestroy($scaledLogo);
        } else {
            $logoX = $clearAreaX + ($clearAreaSize - $logoWidth) / 2;
            $logoY = $clearAreaY + ($clearAreaSize - $logoHeight) / 2;
            imagecopy($qrImageResource, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);
        }
    
        $filename = '../views/files/qrcodes/' . $id_holder . '.png';
        imagepng($qrImageResource, $filename);
    
        imagedestroy($qrImageResource);
        imagedestroy($logo);
    
        // Check if the QR code image was successfully created
        if (file_exists($filename)) {
            $data = "QR code generated successfully with item code: " . $id_holder;
        } else {
            $data = "Failed to generate QR code";
        }
    
        echo json_encode(['status' => $data]);
    
      
      
    }
    
    public function displayAudit(){
        $branch = $_GET['branch'];
        $date = $_GET['date'];
        $data = (new ControllerQRCode)->ctrGetItmebyBranch($branch);
        foreach ($data as &$item) {
            $total_item = $item['total_item'];
            if($total_item<10){
                $total_item = "0".$total_item;
            }
            $getAuditScan =(new ControllerQRCode)->ctrGetAuditScanQR($branch, $date);
            $total_scan = count($getAuditScan);
            if($total_scan<10){
                $total_scan = "0".$total_scan;
            }
            $item['card'] ='
                  <div class="headerTable">
                        <h6 class="auditInfo">ITEM: '.$total_scan.'/'.$total_item.' <span><i class="fa fa-question-circle"></i></span></h6>
                    </div>
                    <div class="tableBody">
                        <table>
                            <thead class="tableHead">
                                <tr>
                                    <td>No.</td>
                                    <td>Sticker No.</td>
                                    <td>Item Description</td>
                                </tr>
                            </thead>
                            <tbody class="scanBody">';
                            $i = 1;
                            foreach($getAuditScan as $audit){

                            
                         $item['card'] .='
                                <tr>
                                    <td>'.$i.'</td>
                                    <td>'.$audit['sticker_no'].'</td>
                                    <td>'.$audit['item_description'].'</td>
                                </tr>
                                ';
                                $i++;
                            }
                              }
                                $item['card'] .='
                            </tbody>
                        </table>
                    </div>
        ';
        
        echo json_encode($data);
    }

    public function auditQRScan() {
        // Ensure that 'branch' and 'result' parameters are set
        if (isset($_GET['branch']) && isset($_GET['result']) && $_GET['date'] != "") {
            $branch = htmlspecialchars($_GET['branch']); // Sanitizing inputs
            $item_code = htmlspecialchars($_GET['result']);
            $date = htmlspecialchars($_GET['date']);
            
            // Fetch the data using your controller method
            $data = (new ControllerQRCode)->ctrGetItembyItemCode($branch, $item_code);
    
            if (!empty($data)) {
                foreach($data as $row){
                    $item_code = $row['item_code'];
                    $item_description = $row['item_description'];
                    $sticker_no = $row['sticker_no'];
                }
                $checker = (new ControllerQRCode)->ctrCheckAuditlogs($item_code, $date);
                if(!empty($checker)){
                    $data = ['error' => 'The item is already scanned!!'];
                }else{
                    $data1=array("item_code"=>$item_code,
                    "sticker_no"=>$sticker_no,
                    "branch_name"=>$branch,
                    "item_description"=>$item_description,
                     "date_scan"=>$date);
                    $saveQRCode = (new ModelQRCode)->mdlAddAuditLog($data1);
                    $data = ['success' => 'Item successfully scanned and logged.'];
                }
            } else {
                // If no data is found, send a custom error response
                $data = ['error' => 'No matching item found for the provided code.'];
            }
            
            // Send the response as JSON
            echo json_encode($data);
        } else {
            // If required parameters are missing, send an error response
            echo json_encode(['error' => 'Missing required parameters.']);
        }
    }
    
    public function auditListToScan() {
        // Ensure that 'branch' parameter is set
        if (isset($_GET['branch'])) {
            $branch = htmlspecialchars($_GET['branch']); // Sanitizing input
            $date = htmlspecialchars($_GET['date']); // Sanitizing input
    
            // Fetch the data using your controller method
            $data = (new ControllerQRCode)->ctrAuditListToScan($branch,  $date);
    
            // Modify each item in the data array
            $i = 1;
            foreach($data as &$item) {
                $sticker_no = $item['sticker_no'];
                $item_name = $item['item_description'];
                $status = $item['status'];
                $current_location = $item['current_location'];
                $item['card'] = '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$sticker_no.'</td>
                        <td>'.$item_name.'</td>
                        <td>'.$status.'</td>
                        <td>'.$current_location.'</td>
                    </tr>';
                    $i++;
            }
    
            // Return the modified data as JSON
            echo json_encode($data);
        } else {
            // Handle the case where 'branch' is not provided
            echo json_encode(['error' => 'Branch parameter is missing']);
        }
    }
    
    
    public function displayClassCategory() {
        $class_type = $_GET['class_type'];
    
        // Function to generate options HTML from an array of branches
        function generateBranchOptions(array $class_category) {
            $options = '';
            foreach ($class_category as $branch) {
                $options .= '<option value="' . htmlspecialchars($branch, ENT_QUOTES) . '">' . htmlspecialchars($branch, ENT_QUOTES) . '</option>';
            }
            return $options;
        }
    
        // Determine the branches based on the company
        switch ($class_type) {
            case "FURNITURE":
                $class_category = [
                    "TABLES",
                    "CHAIRS",
                    "CABINETS",
                ];
                break;
    
            case "FIXTURES":
                $class_category = [
                    "IMAGES / STATUES",
                    "DECORATIONS",
                    "PAINTINGS",
                    "HOUSEHOLD EFFECTS",
                    "APPLIANCES",
                ];
                break;
    
                case "EQUIPMENT":
                    $class_category = [
                        "COMPUTERS",
                        "PRINTERS / COPIERS",
                        "PERIPHERALS / ACCESSORIES",
                        "CCTV EQUIPMENTS",
                        "SOUNDS AND MIXERS",
                        "GADGETS / COMMUNICATION / CONNECTIVITY",
                        "MOTOR VEHICLE",
                        "OTHER FFE",
                    ];
                    break;
             
    
            default:
                $class_category = [];
                break;
        }
    
        // Generate options HTML
        $response['card'] = generateBranchOptions($class_category);
    
        // Return the response as JSON
        echo json_encode([$response]);
    }

    public function displayClassList() {
        $class_categ = $_GET['class_categ'];
    
        // All class lists categorized by class_categ
        $categories = [
            "TABLES" => [
                "OFFICE TABLE",
                "CONFERENCE TABLE",
                "FOYERS",
                "CONSOLES",
                "SIDE TABLES",
            ],
            "CHAIRS" => [
                "COMPUTER CHAIRS",
                "SWIVEL CHAIRS",
                "CONFERENCE CHAIR",
                "VISITORS CHAIR",
                "SOFA",
                "GANG CHAIRS",
                "STOOL, BENCHES",
                "MONOBLOCK CHAIR",
            ],
            "CABINETS" => [
                "STEEL CABINETS WITH VAULTS",
                "STEEL CABINETS",
                "VAULTS",
                "FILING CABINET (MOVABLES)",
                "OROCANS / CLOTHES CABINET / ARMOIREE",
            ],
            "IMAGES / STATUES" => [
                "IMAGE OF SAINTS",
                "STATUES",
            ],
            "DECORATIONS" => [
                "VASES",
                "FRAMES",
                "OTHER DECORATIONS (CHRISTMAS DECORS)",
            ],
            "PAINTINGS" => [
                "ALL PAINTINGS",
                "PICTURES",
            ],
            "HOUSEHOLD EFFECTS" => [
                "BED SHEETS, LINENS, PILLOWS",
                "ALL KITCHEN, DINNER WARES OTHER THAN APPLIANCES",
                "CURTAINS",
                "BLINDS",
                "TRASHCANS, CONTAINERS, PAIL ETC",
            ],
            "APPLIANCES" => [
                "TV",
                "RICE COOKER",
                "FLAT IRON",
                "ELECTRIC FAN",
                "REFRIGERATOR",
                "HUMIDIFIERS",
                "AIRCONS",
                "EMERGENCY LIGHT",
            ],
            "COMPUTERS" => [
                "COMPUTER SET",
                "LAPTOP",
                "MONITOR",
                "AVR",
                "UPS",
                "ADDITIONAL HARD DRIVE, MOTHER BOARD",
                "IPAD",
                "TABLETS",
            ],
            "PRINTERS / COPIERS" => [
                "ALL PRINTERS",
                "PHOTOCOPIERS",
                "SCANNERS",
            ],
            "PERIPHERALS / ACCESSORIES" => [
                "MOUSE",
                "CAMERA",
                "EXTERNAL DRIVE",
                "KEYBOARDS / NUMERIC PADS",
                "PROJECTORS (LCD)",
                "SCREEN",
            ],
            "CCTV EQUIPMENTS" => [
                "CCTV SET",
                "CCTV CAMERA",
                "DVR",
                "POWER SUPPLY",
            ],
            "SOUNDS AND MIXERS" => [
                "MIC, WIRELESS, LAPEL",
                "MIXER",
                "SPEAKERS",
                "PLAYERS",
                "CONSOLE",
                "AMPLIFIER",
            ],
            "GADGETS / COMMUNICATION / CONNECTIVITY" => [
                "CELLPHONE",
                "TELEPHONES",
                "WIRELESS WIFI",
            ],
            "MOTOR VEHICLE" => [
                "CARS, SEDAN, SUV, PICK UP, VANS",
                "MOTORCYCLE",
            ],
            "OTHER FFE" => [
                "COLLECTORS BAG",
                "HELMET",
                "RAINCOATS, BOATS",
            ],
        ];
    
        // Generate options HTML from the selected category or an empty array
        $class_list = $categories[$class_categ] ?? [];
    
        // Function to generate options HTML from an array of branches
        function generateBranchOptions(array $class_list) {
            $options = '';
            foreach ($class_list as $branch) {
                $options .= '<option value="' . htmlspecialchars($branch, ENT_QUOTES) . '">' . htmlspecialchars($branch, ENT_QUOTES) . '</option>';
            }
            return $options;
        }
        // Map class categories to their corresponding codes
        $categoryCodes = [
            "TABLES" => "FRT",
            "CHAIRS" => "FRCS",
            "CABINETS" => "FRCB",
            "IMAGES / STATUES" => "FXI",
            "DECORATIONS" => "FXD",
            "PAINTINGS" => "FXP",
            "HOUSEHOLD EFFECTS" => "FXH",
            "APPLIANCES" => "FXA",
            "COMPUTERS" => "EQC",
            "PRINTERS / COPIERS" => "EQPC",
            "PERIPHERALS / ACCESSORIES" => "EQPA",
            "CCTV EQUIPMENTS" => "EQCV",
            "SOUNDS AND MIXERS" => "EQSM",
            "GADGETS / COMMUNICATION / CONNECTIVITY" => "EQGC",
            "MOTOR VEHICLE" => "EQMV",
            "OTHER FFE" => "OFFE",
        ];
        // Use a ternary operator to handle unknown categories
        $code = $categoryCodes[$class_categ] ?? null;
        $getLastCountCategory = (new ControllerQRCode)->ctrgetLastCountCategory($class_categ);
        $total = $getLastCountCategory[0]['total'] ;
        $item_code="";
       if($total != 0){
        $item_code = $code . sprintf('%05d', $total + 1);
       }else{
        $item_code = $code . "00001";
       }
       
        // Generate options HTML
        $response = [
            'card' => generateBranchOptions($class_list),  // Existing options HTML
            'item_code' => $item_code, // Adding current timestamp
        ];

        // Return the response as JSON
        echo json_encode([$response]);
    }
    
    public function displayItemSet(){
        $id = $_GET['id'];
        $class_code = $_GET['class_code'];
        $data = (new ControllerQRCode)->ctrGetItmebyID($id);
        foreach ($data as &$item) {
            $item_code = $item['item_code'];
            $item_description = $item['item_description'];
            $date_purchased = $item['date_purchased'];
            $sticker_no = $item['sticker_no'];
            $item_location = $item['item_location'];
            $class_list = $item['class_list'];
             $getPrimItemSet = (new ControllerQRCode)->ctrGetItemSetPrim($class_code);
             $getAddItemSet = (new ControllerQRCode)->ctrGetItemSetAdd($class_code);
            $item['card'] ='
                   <div class="row setTitle">
                            <h5>NAME : '.$item_description.' </h5>
                            <h5>DATE PURCHASED: '.$date_purchased.'</h5>
                        </div>
                        <div class="row setAddRow">
                              <h5>STICKER NO. : '.$sticker_no.'</h5>
                              <button type="button" class="btn btn-success btnSetAdd" item_location ="'.$item_location.'">ADD</button>
                              <input type="text" hidden id="setClass_Code" value="'.$class_code.'">
                              <input type="text" hidden id="setClass_List" value="'.$class_list.'">
                        </div>
                        <div class="setMainBody">
                            <div class="primarySet">
                                <div class="itemContent">
                                    <h5>PRIMARY SET</h5>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>STICKER NO</th>
                                                <th>ITEM DESCRIPTION</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        foreach($getPrimItemSet as $set){
                                            $setSticker = $set['sticker_no'];
                                            $setItem_description = $set['item_description'];
                                            $setStatus = $set['status'];
                                        $item['card'] .='  
                                            <tr>
                                                <td>'.$setSticker.'</td>
                                                <td>'.$setItem_description.'</td>
                                                <td>'.$setStatus.'</td>
                                            </tr>';
                                        }
                        $item['card'] .=' 
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="additionalItem">
                                <div class="itemContent">
                                <h5>ADDITIONAL ITEMS</h5>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>STICKER NO</th>
                                                <th>ITEM DESCRIPTION</th>
                                                <th>STATUS</th>
                                                <th>DATE ADDED</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                               
                                        foreach($getAddItemSet as $add){
                                            $setSticker = $add['sticker_no'];
                                            $id = $add['id'];
                                            $setItem_description = $add['item_description'];
                                            $setStatus = $add['status'];
                                            $setAdded = date('Y-m-d', strtotime($add['date_added']));
                                 $item['card'] .=' 
                                            <tr>
                                               <td>'.$setSticker.'</td>
                                                <td>'.$setItem_description.'</td>
                                                <td>'.$setStatus.'</td>
                                                <td>'.$setAdded.'</td>
                                                <td itemId='.$id.' id="removeSet">Remove</td>
                                            </tr>';
                                        }
                                      $item['card'] .='         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        ';
        }
        echo json_encode($data);
    }


    public function displayAdditional(){
        $item_location = $_GET['item_location'];
        $additionalData = (new ControllerQRCode)->ctrGetAdditionalItem($item_location);
        $data = array(
            array("date" => 'wdad')
        );
        foreach ($data as &$item) {
         
            $item['card'] ='
                      <div class="row">
                            <div class="optionSelect form-group">
                                <label for="myDatalist" class="mr-1">Select Item (one at a time):</label>
                                <input list="options" id="myDatalist" class="form-control">
                                <datalist id="options">';
                                foreach($additionalData as $set){
                                    $item_code = $set['item_code'];
                                    $item_description = $set['item_description'];
                                    $item['card'] .='  
                                                <option value="'.$item_code.'">'.$item_description.'</option>
                                                ';
                                            }
                                    $item['card'] .='  
                                </datalist>
                            </div>
                        </div>
                        <div class="displaySelected">
                            <div id="displayBox">
                                Selected items will be displayed here.
                            </div>
                        </div>
        ';
        }
        echo json_encode($data);
    }

    public function saveAdditionalItem(){
        $class_code = $_GET['class_code'];
        $localSaves = $_GET['localSaves'];
        $class_list = $_GET['class_list'];
        
        $answer = null;  // Initialize $answer variable
        
        foreach ($localSaves as $item_code) {
            $getData = (new ControllerQRCode)->ctrGetDataByItemCode($item_code);
            
            if ($getData) {
                foreach ($getData as $data) {
                    $item_description = $data['item_description'];
                    $item_location = $data['item_location'];
                    
                    $data1 = array(
                        "class_code" => $class_code,
                        "item_code" => $item_code,  // Use the same unique item code
                        "item_description" => $item_description,
                        "set_type" => $class_list,
                        "item_location" => strtoupper($item_location),
                        "set_categ" => "ADDITIONAL",
                    );
                    
                    // Save the data
                    $answer = (new ModelQRCode)->mdlAddItemSet($data1);
                    
                    // If the answer is not ok, break out of the loop
                    if ($answer != "ok") {
                        echo json_encode(array("status" => "error", "message" => "Failed to save item: " . $item_code));
                        return;
                    }
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "No data found for item code: " . $item_code));
                return;
            }
        }
        
        // Check if all the saves were successful
        if ($answer == "ok") {
            echo json_encode(array("status" => "success", "message" => "All items saved successfully"));
        } else {
            echo json_encode(array("status" => "error", "message" => "An unknown error occurred"));
        }
    }
    
    public function deleteItemSet() {
        $id = $_GET['id'];
        $table = "inventory_itemset";
        // Call the delete method

        $result = (new ControllerQRCode)->ctrDeleteData($id, $table);
      
        // Create an associative array to return
        $response = [
            'status' => $result === "ok" ? 'success' : 'error',
            'message' => $result === "ok" ? 'Item deleted successfully.' : 'Cannot delete this item'
        ];
        // Set content type to JSON
        header('Content-Type: application/json');
        
        // Return JSON encoded response
        echo json_encode($response);
    }
 
    
}
