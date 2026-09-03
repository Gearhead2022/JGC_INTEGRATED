<?php


class ControllerORPrinting{
    
    static public function ctrGetCollectionRecords($collDate, $branch_name) {

        $folderPaths = "../views/files/branchor/$branch_name/UPDTOR";
           
        $file = $folderPaths . '.DBF';
    
        // Open the DBF file
        $checker = (new ModelORPrinting)->mdlCheckCollectionDuplication($collDate, $branch_name);
    
        if (empty($checker)) {
            
            $dbf = dbase_open($file, 0);
    
            if ($dbf === false) {
                echo '<script>
                        swal({
                            type: "warning",
                            title: "Only DBF Files!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "";
                            }
                        })
                    </script>';
                exit;
            }
    
            // Get the number of records in the file
            $num_records = dbase_numrecords($dbf);
    
            // Initialize the array to store collection records
            $collectionList = [];

            for ($i = 1; $i <= $num_records; $i++) {
                $record = dbase_get_record_with_names($dbf, $i);
            
                if ($record !== false) {
                    $date = date('Y-m-d', strtotime($record['CDATE']));
                    $normal_date = $record['CDATE'];
            
                    // Check if the record's date matches the selected date
                    if ($date === $collDate && trim($normal_date) !== "") {
                        
                        $cdate = date('Y-m-d', strtotime($record['CDATE']));
                        $account_id = $record['ID'];
                        $batch = $record['BATCH'];
                        $mntheff = $record['MNTHEFF'];
                        $amount = $record['AMOUNT'];
                        $posted = (strtoupper($record['POSTED']) === 'TRUE') ? 'TRUE' : 'FALSE';
                        $collstat = preg_replace('/[^a-zA-Z0-9\s]/', '', $record['COLLSTAT']);
                        $bankno = $record['BANKNO'];
                        $balterm = $record['BALTERM'];
                        $atmbal = $record['ATMBAL'];
            
                        $data = array(
                            "cdate" => $cdate,
                            "account_id" => $account_id,
                            "batch" => $batch,
                            "mntheff" => $mntheff,
                            "amount" => $amount,
                            "posted" => $posted,
                            "collstat" => $collstat,
                            "bankno" => $bankno,
                            "balterm" => $balterm,
                            "atmbal" => $atmbal,
                            "branch_name" => $branch_name
                        );
            
                        $uploadData = (new ModelORPrinting)->mdlAddCollectionRecords($data);
                       
                    }
                }else{

                    echo '<script>
                    swal({
                        type: "info",
                        title: "No Records Found!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "";
                        }
                    })
                </script>';

                }
            }
            
            $collectionList = (new ModelORPrinting)->mdlGetCollectionRecords($collDate, $branch_name);
            return $collectionList;
        } else {
            $collectionList = (new ModelORPrinting)->mdlGetCollectionRecords($collDate, $branch_name);
            return $collectionList;

        }
    }
    

    public static function ctrGetEffectivityDate($branch_name) {
        $folderPaths = "../views/files/branchor/$branch_name/UPDTOR";
           
        $file = $folderPaths . '.DBF';

        $dbf = dbase_open($file, 0);
    
        if ($dbf === false) {
           
            echo '<script>
                swal({
                    type: "warning",
                    title: "<p style=\'font-size: 14px;\'>There\'s no records found </p>",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                    }
                })
                </script>';
        }
    
        $num_records = dbase_numrecords($dbf);
        $effectiveDates = null; // Store all effective dates in an array
    
        for ($i = 1; $i <= $num_records; $i++) {
            $record = dbase_get_record_with_names($dbf, $i);
    
            if ($record !== false) {
                // Instead of assigning to $effective, store each effective date in the array
                $effectiveDates = date('Y-m-d', strtotime($record['PERIOD']));
            }
        }
    
        // Close the DBF file after use
        dbase_close($dbf);
    
        // Return the array of effective dates
        return $effectiveDates;
    }
    
    

    public static function ctrGetCollectionInfo($account_id, $collDate, $branch_name) {

        $folderPaths = "../views/files/branchor/$branch_name/UPDTOR";
           
        $file = $folderPaths . '.DBF';

    $dbf = dbase_open($file, 0);
    
    if ($dbf === false) {
        echo '<script>
            swal({
                type: "warning",
                title: "<p style=\'font-size: 14px;\'>There\'s no records found </p>",
                showConfirmButton: true,
                confirmButtonText: "Ok"
            }).then(function(result){
                if (result.value) {
                }
            })
            </script>';
    }
   
    $num_records = dbase_numrecords($dbf);
    $data = array();
    
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record_with_names($dbf, $i);
        
        if ($record !== false) {
            $id = $record['ID'];
            $name_identity = $record['NAME'];
        
            if ($id == $account_id && $name_identity != "") {
                // Use a different variable for the loop iteration
                $accountid = $record['ID'];
                $name = rtrim(str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record['NAME'])));
                $bank = $record['BANK'];
                $target = $record['COLLAMT'];
                $normal = $record['PENSION'];
                $actpnsn = $record['ACTPNSN'];
                $bankno = $record['BANKNO'];

                $effective = self::ctrGetEffectivityDate($branch_name);

                // $effective = '2024-01-02';

                $clct = (new ModelORPrinting)->mdlGetCLCTRecords($account_id, $collDate, $branch_name);

                foreach ($clct as &$clctRecords) {
                    $collstat = $clctRecords['collstat'];
                    $bankno = $clctRecords['bankno'];
                    $amount = $clctRecords['amount'];
                    $atmbal = $clctRecords['atmbal'];
                    $cdate = $clctRecords['cdate'];
                }

                $data[] = array(
                    "accountid" => $accountid,
                    "name" => $name,
                    "bank" => $bank,
                    "target" => $target,
                    "normal" => $normal,
                    "actpnsn" => $actpnsn,
                    "amount" => $amount,
                    "bankno" => $bankno,
                    "collstat" => $collstat,
                    "atmbal" => $atmbal,
                    "cdate" => $cdate,
                    "effective" => $effective
                );
        
                // Exit the loop after finding the first match
                break;
            }
        }
    }
    
    // Return the data as JSON
    return $data;
}

static public function ctrAddBIRRECRecord($data){
    $table = "birrec";
    $answer = (new ModelORPrinting)->mdlAddBIRRECRecord($table, $data);
    return $answer; 
}

// Convertion of numeric number to words //

static public function convertAmountToWords($amount) {
    $number = number_format($amount, 2, '.', '');
    $numArr = explode('.', $number);

    $wholeNumber = $numArr[0];
    $decimalPart = isset($numArr[1]) ? $numArr[1] : '00';

    $words = [];
    $words[] = self::convertToWords($wholeNumber) . " PESOS";

    if ($decimalPart !== '00') {
        $words[] = self::convertToWords($decimalPart) . " CENTS";
    } else {
        $words[] = "ZERO CENTS";
    }

    return implode(" and ", $words);
}

private static function convertToWords($number) {
    $number = intval($number);
    $words = "";
    $units = ["", "THOUSAND", "MILLION", "BILLION", "TRILLION", "QUADRILLION"];

    $numLength = strlen($number);
    $groups = floor(($numLength - 1) / 3) + 1;
    $number = str_pad($number, $groups * 3, "0", STR_PAD_LEFT);

    for ($i = 0; $i < $groups; $i++) {
        $chunk = substr($number, $i * 3, 3);
        $chunk = ltrim($chunk, "0");

        if ($chunk !== "000") {
            if ($words !== "") {
                $words .= " ";
            }
            $words .= self::convertThreeDigitNumberToWords($chunk) . " " . $units[$groups - $i - 1];
        }
    }

    return ($words !== "") ? $words : "ZERO";
}

private static function convertThreeDigitNumberToWords($number) {
    if ($number === '') {
        return ''; // or handle the case as needed
    }

    $words = "";
    $ones = ["", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE"];
    $teens = ["", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"];
    $tens = ["", "TEN", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY", "SEVENTY", "EIGHTY", "NINETY"];

    // Split the number into individual digits
    $digits = str_split(strrev($number));

    // Extract individual digits
    $unit = (int)($digits[0] ?? 0);
    $ten = (int)($digits[1] ?? 0);
    $hundred = (int)($digits[2] ?? 0);

    if ($hundred > 0) {
        $words .= $ones[$hundred] . " HUNDRED ";
    }

    if ($ten > 0) {
        if ($ten == 1) {
            $words .= $teens[$unit] ?? "";
        } else {
            $words .= $tens[$ten] . " " . $ones[$unit] . " ";
        }
    } else {
        $words .= $ones[$unit] . " ";
    }

    return trim($words);
}

// private static function convertToWords($number) {
//     $number = intval($number);
//     $words = "";
//     $units = ["", "THOUSAND", "MILLION", "BILLION", "TRILLION", "QUADRILLION"];

//     $numLength = strlen($number);
//     $groups = ceil($numLength / 3);
//     $number = str_pad($number, $groups * 3, "0", STR_PAD_LEFT);

//     for ($i = 0; $i < $groups; $i++) {
//         $chunk = substr($number, -$numLength + $i * 3, 3);
//         $chunk = ltrim($chunk, "0");

//         if ($chunk !== "000") {
//             if ($words !== "") {
//                 $words .= " ";
//             }
//             $words .= self::convertThreeDigitNumberToWords($chunk);
//             if ($units[$i] !== "") {
//                 $words .= " " . $units[$i];
//             }
//         }
//     }

//     return trim($words);
// }

// private static function convertToWords($number) {
//     $number = intval($number);
//     $words = "";
//     $units = ["", "THOUSAND", "MILLION", "BILLION", "TRILLION", "QUADRILLION"];

//     $numLength = strlen($number);
//     $groups = ceil($numLength / 3);
//     $number = str_pad($number, $groups * 3, "0", STR_PAD_LEFT);

//     for ($i = 0; $i < $groups; $i++) {
//         $chunk = substr($number, -$numLength + $i * 3, 3);
//         $chunk = ltrim($chunk, "0");

//         if ($chunk !== "000") {
//             $words .= self::convertThreeDigitNumberToWords($chunk);
//             if ($units[$i] !== "") {
//                 $words .= " " . $units[$i] . " ";
//             }
//         }
//     }

//     return trim($words);
// }

static public function ctrGetAllCollectionReceiptList($collDate, $branch_name){
    $answer = (new ModelORPrinting)->mdlGetAllCollectionReceiptList($collDate, $branch_name);
    return $answer; 

}
static public function ctrGetCollectionReceiptInfo($account_id, $tdate, $branch_name){
    $collDate = date("Y-m-d", strtotime($tdate));

    $answer = (new ModelORPrinting)->mdlGetCollectionReceiptInfo($account_id, $collDate, $branch_name);
    return $answer; 

}

static public function ctrGetLastSavedId($collDate, $branch_name){
    $answer = (new ModelORPrinting)->mdlGetLastSavedId($collDate, $branch_name);
    return $answer; 

}

static public function ctrGetIdDescription($account_id, $collDate, $branch_name){
    $answer = (new ModelORPrinting)->mdlGetIdDescription($account_id, $collDate, $branch_name);
    return $answer; 

}

 // added 11-22-23 //

static public function ctrDeleteBIRRECRecord(){
    if(isset($_GET['account_id'])){
        $table = "birrec";
        $data = array("account_id"=>$_GET["account_id"],
        "tdate"=>date("Y-m-d", strtotime($_GET["tdate"])));

        $answer = (new ModelORPrinting)->mdlDeleteBIRRECRecord($table, $data);
            if($answer == "ok"){
                
                echo'<script>
                swal({
                    type: "success",
                    title: "Record has been successfully deleted!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            $("#collDate").val("' . $data["tdate"] . '");
                            $(".generateReceiptList").trigger("click");
                        }
                    })
                </script>';
            }else if($answer == "error"){
                echo'<script>

                swal({
                    type: "warning",
                    title: "Theres an error occur!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            $("#collDate").val("' . $data["tdate"] . '");
                            $(".generateReceiptList").trigger("click");
                        }
                    })
                </script>';

            }	
        }
    }

    static public function ctrGetAllCollectionReceiptInfo($tdate, $branch_name){
        $collDate = date("Y-m-d", strtotime($tdate));
    
        $answer = (new ModelORPrinting)->mdlGetAllCollectionReceiptInfo($collDate, $branch_name);
        return $answer; 

    }

    static public function ctrUpdateFileRecords(){
        if(isset($_POST["updateRecord"])){
            // $table = "branch_dtr_upload";
    
            // Check if a file was uploaded
            if(isset($_FILES["or_file"]) && $_FILES["or_file"]["error"] == 0){
                $branch = $_POST["or_branch_name"];

                $uploadDir = "views/files/branchor/$branch/";

                // Check if the directory exists, create it if not
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }

                $uploadFile = $uploadDir . basename($_FILES["or_file"]["name"]);
       
                // Move the uploaded file to the specified directory
                if(move_uploaded_file($_FILES["or_file"]["tmp_name"], $uploadFile)){
                    // File uploaded successfully
                    echo '<script>
                        swal({
                            type: "success",
                            title: "File Successfully Updated!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "branchCollectionReceipt";
                            }
                        });
                    </script>';

                    // 
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

    	
}