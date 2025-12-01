<?php   
    class ControllerSOA{

        static public function ctrUpdateSOAFileRecords(){

            if(isset($_POST["addsoa"])){

                // Check if a file was uploaded
                if(isset($_FILES["soa_file"]) && $_FILES["soa_file"]["error"] == 0){

                    $branch = $_POST["branch_name"];
                    $uploadDir = "views/files/branchsoa/$branch/";

                    // Check if the directory exists, create it if not
                    if(!is_dir($uploadDir)){
                        mkdir($uploadDir, 0777, true);
                    }

                    $uploadFile = $uploadDir . basename($_FILES["soa_file"]["name"]);
                    $uploadFileName = basename($_FILES["soa_file"]["name"]);
        
                    // Move the uploaded file to the specified directory
                    if(move_uploaded_file($_FILES["soa_file"]["tmp_name"], $uploadFile)){

                        echo '<script>
                                swal({
                                    type: "success",
                                    title: "File Successfully Uploaded!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                }).then(function(result){
                                    if (result.value) {
                                        window.location = "";
                                    }
                                });
                            </script>';
                        
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

          
static public function ctrGetSOARecordsById($soa_account_no, $soa_branch_name){

            date_default_timezone_set('Asia/Manila');
        
            $file_path = "../views/files/branchsoa/$soa_branch_name/UNDER122.DBF";
        
            if (file_exists($file_path)) {
        
                $date_now = date('Y-m-d h:i A', time()); 
                $dbf = dbase_open($file_path, 0);
        
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
                $dataList = [];
        
                for ($i = 1; $i <= $num_records; $i++) {
                    $record = dbase_get_record_with_names($dbf, $i);
        
                    if ($record !== false) {
        
                        $id = trim($record['ID']);  
                        $record_date = intval($record['SYXLNMO']) + 1;   
                        $cur_month = date("m", time());
        
                        $address = $record['ADD1'] . ' ' .$record['ADD2'];
                    
                        // Check if the record's date matches the selected date
                        if ($id == $soa_account_no) {
                            $account_no = trim($record['ID']);    
                            $name = trim(str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record['NAME'])));
                            $address = str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $address));
                            $bank = $record['BANK'];
                            $pension = $record['PENSION'];
                            $principal = $record['NTOTAL'];
                            $change = $record['CHANGE'];
        
                            $data = array(
                                "account_no" => $account_no,
                                "name" => $name,
                                "address" => $address,
                                "bank" => $bank,
                                "pension" => $pension,
                                "principal" => $principal,
                                "change" => $change
                            );
        
                            // Append data to the dataList array
                            $dataList[] = $data;
                        }
                    }
                }
        
                // Close the DBF file
                dbase_close($dbf);
        
                // Check if any data was found
                if (empty($dataList)) {
                    echo '<script>
                        swal({
                            type: "info",
                            title: "No Records Found",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "";
                            }
                        })
                    </script>';
                }
        
                return $dataList;
                
            } else {
                echo '<script>
                    swal({
                        type: "info",
                        title: "No Records Found",
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

          static public function ctrAddSOARecordById($dataSet){

            date_default_timezone_set('Asia/Manila');
    
            $table = "soa";

            $branch_name = $dataSet['branch_name'];

            $soa_info = (new ModelSOA)->mdlGetBranchEmpRecords($branch_name);

            if (!empty($soa_info)) {

                foreach ($soa_info as &$soa_info_list) {
                    $soa_fa = $soa_info_list['fa'];
                    $soa_boh = $soa_info_list['boh'];
                    $soa_branch_address = $soa_info_list['address'];
                }
                
                $soa_tdate = date('Y-m-d', time());
                $soa_ttime = date('h:m:s A', time());
                $soa_fmonth = date('F', strtotime($dataSet['from']));
                $soa_fyr = date('Y', strtotime($dataSet['from']));
                $soa_tmonth = date('F', strtotime($dataSet['to']));
                $soa_tyr = date('Y', strtotime($dataSet['to']));
    
                $account_no = $dataSet["account_no"];
                $name = $dataSet["name"];
                $address = $dataSet["address"];
                $bank = $dataSet["bank"];
                $pension = number_format(floatval(str_replace(',', '', $dataSet["pension"])), 2, '.', '');
                $principal = number_format(floatval(str_replace(',', '', $dataSet["lr"])), 2, '.', '');
                $change = number_format(floatval(str_replace(',', '', $dataSet["sl"])), 2, '.', '');
                $interest = number_format(floatval(str_replace(',', '', $dataSet["interest"])), 2, '.', '');
                $from =  date('Y-m-d', strtotime($dataSet['from']));
                $to =  date('Y-m-d', strtotime($dataSet['to']));
                $fa =  $soa_fa;
                $boh =  $soa_boh;
                $tdate = $soa_tdate;
                $ttime = $soa_ttime;
                $others = number_format(floatval(str_replace(',', '', $dataSet["others"])), 2, '.', '');
                $fmonth = $soa_fmonth;
                $fyr = $soa_fyr;
                $tmonth = $soa_tmonth;
                $tyr = $soa_tyr;
                $branch = $soa_branch_address;
                $baltot = number_format(floatval(str_replace(',', '', $dataSet["baltot"])), 2, '.', '');
                $bcode = $dataSet['branch_name'];
                $note = $dataSet['note'];
                
                $data = array(
                    "account_no"=>$account_no,
                    "name"=>$name,
                    "address"=>$address,
                    "bank"=>$bank,
                    "pension"=>$pension,
                    "principal"=>$principal,
                    "change"=>$change,
                    "interest"=>$interest,
                    "from"=>$from,
                    "to"=>$to,
                    "fa"=>$fa,
                    "boh"=>$boh,
                    "tdate"=>$tdate,
                    "ttime"=>$ttime,
                    "others"=>$others,
                    "fmonth"=>$fmonth,
                    "fyr"=>$fyr,
                    "tmonth"=>$tmonth,
                    "tyr"=>$tyr,
                    "branch"=>$branch,
                    "baltot"=>$baltot,
                    "bcode"=>$bcode,
                    "note"=>$note,
                );
    
                $uploadData = (new ModelSOA)->mdlAddSOARecordById($table, $data);
    
                if ($uploadData == 'ok') {
                    return 'ok';
                } else {
                    return 'error';
                }

            }else{

               return 'no_records';
            }
            
        }

        static public function ctrGetBranchEmpRecords($branch_name){
            $answer = (new ModelSOA)->mdlGetBranchEmpRecords($branch_name);
            return $answer;
        }

        static public function ctrAddSOABranchInfo(){

            date_default_timezone_set('Asia/Manila');
    
            if(isset($_POST["add_soa_info"])){
                $table = "soa_info";
                
                $soa_info_id = $_POST["soa_info_id"];
                $soa_branch_name = $_POST["soa_branch_name"];
                $soa_fa = $_POST["soa_branch_fa"];
                $soa_boh = $_POST["soa_branch_boh"];
                $soa_address = $_POST["soa_branch_address"];
                $soa_tel = $_POST["soa_branch_tel"];

                if ($soa_info_id != '') {
                    $action = 'update';
                } else {
                    $action = 'insert';
                }
                
                $date_time_now = date('M-d-Y H:i:s A',time());
              
                $data = array(
                    "id"=>$soa_info_id,
                    "fa"=>$soa_fa,
                    "boh"=>$soa_boh,
                    "address"=>$soa_address,
                    "tel"=>$soa_tel,
                    "branch_name"=>$soa_branch_name,
                    "date"=>$date_time_now
                    
                );

                $uploadData = (new ModelSOA)->mdlAddSOABranchInfo($table, $data, $action);
    
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

        static public function ctrShowAllSOA($id, $date){
            // Get the first day of the month
            $fdate = date("Y-m-01", strtotime($date));
            // Get the last day of the month
            $ldate = date("Y-m-t", strtotime($date));
            $answer = (new ModelSOA)->mdlShowAllSOA($id, $fdate, $ldate);
            return $answer;
        }
        
        static public function  ctrShowSOAInfo(){
            $answer = (new ModelSOA)->mdlShowSOAInfo();
            return $answer;
        }
        
static public function ctrReprintSOA($id){
		date_default_timezone_set('Asia/Manila');
		$time = date('Y-m-d H:i:s');
        $answer = (new ModelSOA)->mdlReprintSOA($id, $time);
		return $answer;
    }

	static public function ctrDeleteSOA($id){
		date_default_timezone_set('Asia/Manila');
		$time = date('Y-m-d H:i:s');
        $answer = (new ModelSOA)->mdlDeleteSOA($id, $time);
		return $answer;
    }
    static public function ctrShowAllLogs(){
        $answer = (new ModelSOA)->mdlShowAllLogs();
		return $answer;
    }
	
	 

    }