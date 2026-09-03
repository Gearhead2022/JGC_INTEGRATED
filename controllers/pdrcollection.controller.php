<?php   
    class ControllerPDRColl{

        static public function ctrUpdatePDRFileRecords(){

            date_default_timezone_set('Asia/Manila');

            // Trigger when button has been clicked
            if (isset($_POST["updatePDRFileRecords"])) {

                 // Check if file is ready and not null
                if (isset($_FILES["pdr_file"]) && $_FILES["pdr_file"]["error"] == 0) {
                    $branch = $_POST["pdr_branch_name"];
                    $trans_date = $_POST["trans_date"];
                    $file = $_FILES['pdr_file']['tmp_name'];
                    $date_now = date('Y-m-d h:i A', time()); 
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
                            $tdate = date('Y-m-d', strtotime($record['TDATE']));
                            $id = $record['ID'];    
                            
                            $acc_id = (new ModelPDRCollection)->mdlCheckIDExist($id, $tdate, $branch);
                    
                            // Check if the record's date matches the selected date
                            if ($tdate == $trans_date && $acc_id == 'not exist' ) {
                                $account_no = $record['ID'];    
                                $name = rtrim(str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record['NAME'])));
                                $status = $record['STATUS'];
                                $edate = date('Y-m-d', strtotime($record['EDATE']));
                                $tdate = date('Y-m-d', strtotime($record['TDATE'])); 
                                $ref = trim($record['REF']);
                                $prev_bal = $record['PREVBAL'];
                                $amt_credit = $record['AMTPAID'];
                                $amt_debit = '';
                                $end_bal = $record['ENDBAL'];

                                $parts = explode(',', $name);

                                // Trim each part to remove possible white spaces
                                $last_name = trim($parts[0]);
                                $first_name = trim($parts[1]);
                                $middle_name = "";
                    
                                $data = array(
                                    "account_no" => $account_no,
                                    "first_name" => $first_name,
                                    "middle_name" => $middle_name,
                                    "last_name" => $last_name,
                                    "status" => $status,
                                    "edate" => $edate,
                                    "tdate" => $tdate,
                                    "ref" => $ref,
                                    "prev_bal" => $prev_bal,
                                    "amt_credit" => $amt_credit,
                                    "amt_debit" => $amt_debit,
                                    "end_bal" => $end_bal,
                                    "branch_name" => $branch,
                                    "date_uploaded" => $date_now
                                );
                                $uploadData = (new ModelPDRCollection)->mdlUpdatePDRRecords($data);

                                if ($uploadData == 'ok') {
                                    echo '<script>
                                        swal({
                                            type: "success",
                                            title: "Records has been succesfully uploaded",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "";
                                            }
                                        })
                                    </script>';
                                } else {
                                    echo '<script>
                                        swal({
                                            type: "warning",
                                            title: "Oopps! The list are already exist!",
                                            showConfirmButton: true,
                                            confirmButtonText: "Ok"
                                        }).then(function(result){
                                            if (result.value) {
                                                window.location = "";
                                            }
                                        })
                                    </script>';
                                }
                            }else{
                                echo '<script>
                                swal({
                                    type: "success",
                                    title: "Records has been succesfully uploaded",
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "";
                                    }
                                })
                            </script>';
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

        static public function ctrShowAllPDRList($branch_name){

            $answer = (new ModelPDRCollection)->mdlShowAllPDRList($branch_name);
            return $answer;

        }

        static public function ctrGetPDRAccountInfo($account_no, $tdate, $branch_name){

            $answer = (new ModelPDRCollection)->mdlGetPDRAccountInfo($account_no, $tdate, $branch_name);
            return $answer;

        }

        static public function ctrAddPDRCollectionRecord(){

            date_default_timezone_set('Asia/Manila');

            if(isset($_POST["addPDRCollRecord"])){
                $table = "past_due";
                $table2 = "past_due_ledger";
                $table3 = "pdr_coll";
                $table4 = "tmp_pdr_coll";

                $id = $_POST["id"];
                $due_id = $_POST["due_id"];
                $account_no = $_POST["account_no"];
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $middle_name = $_POST["middle_name"];
                $status = $_POST["status"];
                $edate = $_POST["edate"];
                // $date_change = $_POST["date_change"];
                $tdate = $_POST["tdate"];
                $ref = $_POST["ref"];
                $prev_bal = $_POST['prev_bal'];

                if ($_POST['credit'] == 0 || $_POST['credit'] == '0') {
                    $credit = '';
                } else {
                    $credit = floatVal($_POST['credit']);
                }

                if ($_POST['debit'] == 0 || $_POST['debit'] == '0') {
                    $debit = '';
                } else {
                    $debit = floatVal($_POST['debit']);
                }

                if (isset($_POST['date_change'])) {
                    $date_change = $_POST["date_change"];
                } else {
                    $date_change = '';
                }
                
                
                $end_bal = $_POST['end_bal'];
                $branch_name = $_POST["branch_name"];
                $date_now = date('Y-m-d h:i A', time());

              
                $data = array("id"=>$id,
                    "due_id"=>$due_id,       
                    "account_no"=>$account_no,
                    "first_name"=>$first_name,
                    "last_name"=>$last_name,
                    "middle_name"=>$middle_name,
                    "status"=>$status,
                    "edate"=>$edate,
                    "date_change"=>$date_change,
                    "tdate"=>$tdate,
                    "ref"=>$ref,
                    "prev_bal"=>$prev_bal,
                    "credit"=>$credit,
                    "debit"=>$debit,
                    "end_bal"=>$end_bal,
                    "branch_name"=>$branch_name,
                    "date_procceeed"=>$date_now);

                $upload_past_due = (new ModelPDRCollection)->mdlAddPastDueAccounts($table, $data);
                
                $upload_ledger = (new ModelPDRCollection)->mdlAddLedger($table2, $data);

                $upload_to_archieve = (new ModelPDRCollection)->mdlAddPDRColletionToArchieve($table3, $data);
        
                if($upload_past_due == "ok"){
                    if ($upload_ledger == 'ok') {
                        if ($upload_to_archieve == 'ok') {

                            $answer = (new ModelPDRCollection)->mdlDeletePDRCollection($table4, $data);

                            echo'<script>
        
                            swal({
                                type: "success",
                                title: "Records Update Succesfully!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "branchPDRColl";
                                    }
                                })
                            </script>';
                        }elseif($upload_to_archieve == "error"){
                            echo'<script>
            
                            swal({
                                type: "warning",
                                title: "Theres an error occur on saving to archieve!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "branchPDRColl";
                                    }
                                })
                            </script>';
                        }

                    }elseif($upload_ledger == "error"){
                        echo'<script>
        
                        swal({
                            type: "warning",
                            title: "Theres an error occur on saving to ledger!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                            }).then(function(result){
                                if (result.value) {
                                    window.location = "branchPDRColl";
                                }
                            })
                        </script>';
                    }
                      
                    
                }elseif($upload_past_due == "error"){
                    echo'<script>
        
                    swal({
                        type: "warning",
                        title: "Theres an error occur on saving to pastdue!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "branchPDRColl";
                            }
                        })
                    </script>';
                }
            }
        }

        // static public function ctrShowAllArchivePDRList($branch_name){

        //     $answer = (new ModelPDRCollection)->mdlShowAllArchivePDRList($branch_name);
        //     return $answer;

        // }

        static public function ctrShowAllFilterArchivePDRList($branch_name, $fromdate, $todate, $report){

            $answer = (new ModelPDRCollection)->mdlShowAllFilterArchivePDRList($branch_name, $fromdate, $todate, $report);
            return $answer;

        }

        static public function ctrGetPDRAccountInfoById($account_no, $branch_name){

            $answer = (new ModelPDRCollection)->mdlGetPDRAccountInfoById($account_no, $branch_name);
            return $answer;

        }

        
        // static public function ctrGetPDRAccountInfoByIds($branch_name, $account_no, $dateFrom, $dateTo){

        //     $answer = (new ModelPDRCollection)->mdlShowGetPrevBalance($branch_name, $account_no, $dateFrom, $dateTo);
        //     return $answer;

        // }

        // add records pdr coll using sql data..

        static public function ctrAddPDRCollectionRecordById(){

            date_default_timezone_set('Asia/Manila');
    
            if(isset($_POST["addPDRCollRecordById"])){
                $table = "past_due";
                $table2 = "past_due_ledger";
                $table3 = "pdr_coll";
    
                $due_id = $_POST["due_id"];
                $account_no = $_POST["pdr_coll_account_no"];
                $first_name = trim($_POST["search_first_name"]);
                $last_name = trim($_POST["search_last_name"]);
                $middle_name = trim($_POST["search_middle_name"]);
                $status = $_POST["search_status"];
                $edate = $_POST["search_edate"];
                $tdate = $_POST["search_tdate"];
                $ref = trim($_POST["search_ref"]);
                $prev_bal = $_POST['search_prev_bal'];
                $credit = floatVal($_POST['credit']);
                $debit = floatVal($_POST['debit']) * -1;
                $end_bal = $_POST['end_bal'];
                $branch_name = $_POST["pdr_coll_branch"];
                $date_now = date('Y-m-d h:i A', time());
    
                $data = array("due_id"=>$due_id,
                    "account_no"=>$account_no,
                    "first_name"=>$first_name,
                    "last_name"=>$last_name,
                    "middle_name"=>$middle_name,
                    "status"=>$status,
                    "edate"=>$edate,
                    "tdate"=>$tdate,
                    "ref"=>$ref,
                    "prev_bal"=>$prev_bal,
                    "amt_credit"=>$credit,
                    "amt_debit"=>$debit,
                    "end_bal"=>$end_bal,
                    "branch_name"=>$branch_name,
                    "date_uploaded"=>$date_now);

                $uploadData = (new ModelPDRCollection)->mdlUpdatePDRRecords($data);

                if ($uploadData == 'ok') {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "Records has been succesfully uploaded",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "";
                            }
                        })
                    </script>';
                } else {
                    echo '<script>
                        swal({
                            type: "warning",
                            title: "Oopps! The list are already exist!",
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
        }

        /// ADD NEW TRANSACTION OR NEW ENDORSED PASTDUE

       /// ADD NEW TRANSACTION OR NEW ENDORSED PASTDUE

        static public function ctrAddNewPDRCollectionRecord(){

            date_default_timezone_set('Asia/Manila');
    
            if(isset($_POST["addNewPDRCollRecord"])){
                $table = "past_due";
    
                $due_id = $_POST["new_due_id"];
                $account_no = $_POST["new_account_no"];
                $first_name = $_POST["new_first_name"];
                $last_name = $_POST["new_last_name"];
                $middle_name = $_POST["new_middle_name"];
                $age = $_POST["new_age"];
                $bank = $_POST["new_bank"];
                $address = $_POST["new_address"];
                $type = $_POST["new_type"];
                $status = $_POST["new_status"];
                $edate = $_POST["new_edate"];
                $prev_bal = '0';
                $branch_name = $_POST["new_branch_name"];
                $date_now = date('Y-m-d h:i A', time());
    
                $data = array(
                    "due_id"=>$due_id,
                    "account_no"=>$account_no,
                    "first_name"=>$first_name,
                    "last_name"=>$last_name,
                    "middle_name"=>$middle_name,
                    "age"=>$age,
                    "bank"=>$bank,
                    "address"=>$address,
                    "type"=>$type,
                    "status"=>$status,
                    "edate"=>$edate,
                    "prev_bal"=>$prev_bal,
                    "branch_name"=>$branch_name,
                    "date_uploaded"=>$date_now);

                $uploadData = (new ModelPDRCollection)->mdlUpdatePDRRecordsNew($table, $data);
                
                if ($uploadData == 'ok') {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "Records has been succesfully uploaded",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "";
                            }
                        })
                    </script>';
                } else {
                    echo '<script>
                        swal({
                            type: "warning",
                            title: "Oopps! The list are already exist!",
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
        }

        static public function ctrDeletePDRCollection(){
            if(isset($_GET['account_no']) && isset($_GET['tdate']) && isset($_GET['branch_name'])){

                $account_no = $_GET["account_no"];
                $tdate = $_GET["tdate"];
                $branch_name = $_GET["branch_name"];
                $id = $_GET["id"];

                $table = "tmp_pdr_coll";
      
                $data = array(
                    "account_no"=>$account_no,
                    "tdate"=>$tdate,
                    "branch_name"=>$branch_name,
                    "id"=>$id
                );

                $answer = (new ModelPDRCollection)->mdlDeletePDRCollection($table, $data);
                if($answer == "ok"){
                    echo'<script>
    
                    swal({
                          type: "success",
                          title: "Record has been successfully deleted!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "branchPDRColl";
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
                                    
                                    }
                                })
                    </script>';
    
                }	
    
    
            }
    
        }


        static public function ctrDeletePDRCollectionArchive(){
            if(isset($_GET['account_no']) && isset($_GET['tdate']) && isset($_GET['branch_name']) ){

                $account_no = $_GET["account_no"];
                $tdate = $_GET["tdate"];
    
                $branch_name = $_GET["branch_name"];

                $table = "pdr_coll";
                $table1 = "past_due_ledger";
      
                $data = array(
                    "account_no"=>$account_no,
                    "tdate"=>$tdate,
                    
                    "branch_name"=>$branch_name
                );

                $deleteOnPDR_COLL = (new ModelPDRCollection)->mdlDeletePDRCollectionArchive($table, $data);
                
                $deleteOnLedger = (new ModelPDRCollection)->mdlDeletePDRLedger($table1, $data);

                if($deleteOnPDR_COLL == "ok"){

                    if ($deleteOnLedger == "ok") {
                        echo'<script>
    
                        swal({
                              type: "success",
                              title: "Record has been successfully deleted!",
                              showConfirmButton: true,
                              confirmButtonText: "Ok"
                              }).then(function(result){
                                        if (result.value) {
                                        window.location = "branchPDRCollArchive";
                                        }
                                    })
                        </script>';
                    }else if($deleteOnPDR_COLL == "error"){
                        echo'<script>
        
                        swal({
                              type: "warning",
                              title: "Theres an error occur on deleting to PDR Collection!",
                              showConfirmButton: true,
                              confirmButtonText: "Ok"
                              }).then(function(result){
                                        if (result.value) {
                                        
                                        }
                                    })
                        </script>';
        
                    }	
                    
                }else if($deleteOnPDR_COLL == "error"){
                    echo'<script>
    
                    swal({
                          type: "warning",
                          title: "Theres an error occur on deleting to PDR Ledger!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    
                                    }
                                })
                    </script>';
    
                }	
    
    
            }
    
        }

        static public function ctrShowPastDue($branch_name){
            $answer = (new ModelPDRCollection)->mdlShowPastDue($branch_name);
            return $answer;
        }

        static public function ctrShowPastDueLedger($account_no, $branch_name){
            $answer = (new ModelPDRCollection)->mdlShowPastDueLedger($account_no, $branch_name);
            return $answer;
        }
        
        static public function ctrUpdatePrintStatus($branch_name, $from_date, $to_date){
            $answer = (new ModelPDRCollection)->mdlUpdatePrintStatus($branch_name, $from_date, $to_date);
            return $answer;
        }



        
    }

   