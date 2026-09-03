<?php
  class ControllerInsurance{

    static public function ctrShowInsurance(){
        $answer = (new ModelInsurance)->mdlShowInsurance();
		return $answer;
    }
    static public function ctrShowBranches(){
        $answer = (new ModelInsurance)->mdlShowBranches();
		return $answer;
    }
    static public function ctrShowFilterInsurance($date){
        $answer = (new ModelInsurance)->mdlShowFilterInsurance($date);
		return $answer;
    }
    static public function ctrShowFilterInsuranceByBranch($date, $branch){
        $answer = (new ModelInsurance)->mdlShowFilterInsuranceByBranch($date, $branch);
		return $answer;
    }

    static public function ctrShowFilterInsuranceBranch($date, $branch_name){
        $answer = (new ModelInsurance)->mdlShowFilterInsuranceBranch($date, $branch_name);
		return $answer;
    }
    static public function ctrShowInsuranceID($id){
        $answer = (new ModelInsurance)->mdlShowInsuranceID($id);
		return $answer;
    }

    static public function ctrCountInsurance($branch_name, $date, $type){
        $answer = (new ModelInsurance)->mdlCountInsurance($branch_name, $date, $type);
		return $answer;
    }
    static public function ctrAddInsurance(){
        if(isset($_POST['addInsurance'])){
     
            $chk = "";
            $table = "insurance";
            $branch_name = $_POST['branch_name'];
            $ins_type = $_POST['ins_type'];
            $date = $_POST['date'];
            $file = $_FILES['file']['tmp_name'];
            $originalFileName = $_FILES['file']['name'];
            // Open the DBF file
            if($ins_type == "CBI"){
                if($originalFileName != "CBI.DBF"){
                    echo'<script>
                swal({
                      type: "warning",
                      title: "Please check the insurance type and the uploaded file; they do not match!",
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
            }

            if($ins_type == "OONA"){
                if($originalFileName != "MAP.DBF"){
                    echo'<script>
                swal({
                      type: "warning",
                      title: "Please check the insurance type and the uploaded file; they do not match!",
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
            }

            if($ins_type == "PHIL"){
                if($originalFileName != "PINS.DBF"){
                    echo'<script>
                swal({
                      type: "warning",
                      title: "Please check the insurance type and the uploaded file; they do not match!",
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
            }


            $dbf = dbase_open($file, 0);
            if ($dbf === false) {
                echo'<script>
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
 
    // Insert the records into the database
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record($dbf, $i);
       
            if ($record !== false) {
                $account_id = $record[0];
                $name = rtrim(str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record[1])));
                $avail_date = date("Y-m-d", strtotime($record[2]));
                $amount =$record[3];
                $expire_date1 = $record[4];
                $avail_date1 = $record[2];
                $birth_date = date("Y-m-d", strtotime($record[8]));
                $age = date_diff(date_create($birth_date), date_create('today'))->y;
                $expire_date = date("Y-m-d", strtotime($expire_date1));
            if($date == $avail_date){
                //  GET THE TERMS
                if(!ctype_space($expire_date1)){
                  if($ins_type == "CBI"){  
                        $terms = (new ControllerInsurance)->cbi_age_validator($birth_date, $avail_date1, $expire_date1);
                       
                    $getRate = (new ModelInsurance)->mdlget_cbi_Rate($terms);
                        foreach($getRate as $rate){
                            $ins_rate = $rate['amount'];
                        }
                        $days = (new ControllerInsurance)->ctrGetCBIDays($birth_date, $avail_date1, $expire_date1);
                        
            } elseif($ins_type == "OONA"){
                    $terms = (new ControllerInsurance)->age_validator($birth_date, $avail_date, $expire_date1);
                    $getRate = (new ModelInsurance)->mdlgetRate($age, $terms);
                    if(!empty($getRate)){
                        foreach($getRate as $rate){
                            $ins_rate = $rate['amount'];
                         }
                    }else{
                        $ins_rate="";
                    }
                    $days="";
                }elseif($ins_type == "PHIL"){
                    $terms = (new ControllerInsurance)->age_validator($birth_date, $avail_date, $expire_date1);
                    $getRate = (new ModelInsurance)->mdlgetPhilRate($age, $terms);
                    if(!empty($getRate)){
                        foreach($getRate as $rate){
                            $ins_rate = $rate['amount'];
                         }
                    }else{
                        $ins_rate="";
                    }
                    $days="";
                }
                }else{
                    $days="";
                    $terms="";
                    $ins_rate="";
                    $expire_date="";
                }

                $checker = (new ModelInsurance)->mdlCheckInsurance($branch_name, $avail_date, $account_id, $name);

                if($checker == "ok"){
                    // if($age >= 66 && $age <= 70){
                    //     $ins_rate = "";
                    // }
                // CHECK THE USER INPUT DATE AND AVAILDATE
                    $data=array("account_id"=>$account_id,
                        "name"=>$name,
                        "branch_name"=>$branch_name,
                        "avail_date"=>$avail_date,
                        "age"=>$age,
                        "terms"=>$terms,
                        "amount"=>$amount,
                        "expire_date"=>$expire_date,
                        "birth_date"=>$birth_date,
                        "ins_rate"=>$ins_rate,
                        "ins_type"=>$ins_type,
                        "days"=>$days);
                        $answer = (new ModelInsurance)->mdlAddInsurance($table, $data);
                        if($answer == "ok"){
                            $chk = "ok";
                        }else{
                            $chk = "error1";
                        }
            }
        }
                // END CHECK THE USER INPUT DATE AND AVAILDATE
                        
            }else{
                $chk = "error";
            }
    }

    if($chk == "ok"){
                    
        echo'<script>

        swal({  
            type: "success",
            title: "Records have been successfully added!",
            showConfirmButton: true,
            confirmButtonText: "Ok"
            }).then(function(result){
                        if (result.value) {
                        window.location = "insurance";
                        }
                    })
        </script>';
    }else if($chk == "error"){
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

    }else if($chk == "error1"){
        echo'<script>

        swal({
            type: "warning",
            title: "Wala nag sulod sa database",
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

    static public function ctrCreateEditInsurance(){

		if(isset($_POST["editInsurance"])){
                $table = "insurance";
                $full_name = $_POST["name"];
                $middle_name = $_POST["middle_name"];
                $lastLetter = substr($full_name, -1);
                if($lastLetter == "."){
                    $lastThreeLetter = substr($full_name, -3);
                    if($lastThreeLetter == "JR." || $lastThreeLetter == "SR."){
                        $name = $full_name ." " . $middle_name.".";
                    }else{
                        $name = $full_name;
                    }
                }elseif($lastLetter !="." && $middle_name !=""){
                    $name = $full_name ." " . $middle_name.".";
                }else{
                    $name = $full_name;
                } 

                $data = array("id"=>$_POST["id"],
                "name"=>strtoupper($name),
                "occupation"=>$_POST["occupation"],
                "civil_status"=>$_POST["civil_status"],
                "gender"=>$_POST["gender"],
                "terms"=>$_POST["terms"],
                "birth_date"=>$_POST["birth_date"],
                "age"=>$_POST["age"],
                "amount_loan"=>$_POST["amount_loan"],
                "ins_rate"=>$_POST["ins_rate"],
                "expire_date"=>$_POST["expire_date"],
                "cbi_illness"=>$_POST["cbi_illness"],
                "dchs"=>$_POST["dchs"],
                "days"=>$_POST["days"]);
				$answer = (new ModelInsurance)->mdlEditInsurance($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Insurance Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "insurance";
									}
								})
					</script>';
				}elseif($answer == "error"){
					echo'<script>

					swal({
						type: "warning",
						title: "Theres an error occur!",
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

    static public function ctrDeleteInsurance(){
		if(isset($_GET['idClient'])){
			$table = "insurance";
			$data = $_GET["idClient"];
			$answer = (new ModelInsurance)->mdlDelete($table, $data);
			if($answer == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "Insurance has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "insurance";
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

    static public function  age_validator($birth_date, $avail_date, $expire_date1) {
        $age = date_diff(date_create($birth_date), date_create("$expire_date1 +1 month"))->y;
        $date1 = new DateTime($avail_date);
        $date2 = new DateTime($expire_date1);
        $interval = $date1->diff($date2);
        $terms = $interval->y * 12 + $interval->m;
    
            $xdate_day = date_create($expire_date1)->format('d');
            $avail_day = date_create($avail_date)->format('d');
            if ($xdate_day != $avail_day) {
                // Do something when xdate day is greater than or equal to avail day
              $total_terms =   $terms + 1;
            }else{
                $total_terms = $terms;
            }

        return $total_terms;
    }

    static public function ctrGetAllEMBBranches(){
        $answer = (new ModelInsurance)->mdlShowEMBBranches();
        return $answer;
    }
    static public function ctrGetAllFCHBranches(){
        $answer = (new ModelInsurance)->mdlShowFCHBranches();
        return $answer;
    }
    static public function ctrGetAllRLCBranches(){
        $answer = (new ModelInsurance)->mdlShowRLCBranches();
        return $answer;
    }
    static public function ctrGetAllELCBranches(){
        $answer = (new ModelInsurance)->mdlShowELCBranches();
        return $answer;
    }


    static public function ctrGetTotalAmount($branch_name, $date, $type){
        $answer = (new ModelInsurance)->mdlGetTotalAmount($branch_name, $date, $type);
		return $answer;
    }

    static public function ctrGetInsuranceChecker($avail_date){
        $answer = (new ModelInsurance)->mdlGetInsuranceChecker($avail_date);
		return $answer;
    }

    static public function cbi_age_validator($birth_date, $avail_date1, $expire_date1) {
        // Convert dates from YYYYMMDD to m/d/Y format
        $avail_date1 = DateTime::createFromFormat('Ymd', $avail_date1)->format('m/d/Y');
        $expire_date1 = DateTime::createFromFormat('Ymd', $expire_date1)->format('m/d/Y');
        // Create DateTime objects
        $avail_date_obj = DateTime::createFromFormat('m/d/Y', $avail_date1);
        $expiry_date_obj = DateTime::createFromFormat('m/d/Y', $expire_date1);
        // Check if date objects were created successfully
        if (!$avail_date_obj || !$expiry_date_obj) {
            // Output JavaScript to log to the browser console
            echo "<script>console.error('Invalid date format. Avail date: $avail_date1, Expiry date: $expire_date1');</script>";
            return null; // Return null if date conversion fails
        }
        // Calculate the difference
        $interval = $avail_date_obj->diff($expiry_date_obj);
        $days = $interval->days;

        // Get the term for the number of days
        $term = self::getTermForDays($days);
        // Output JavaScript to log to the browser console
        // echo "<script>console.log('Days between avail date and expiry date: $days');</script>";
        // echo "<script>console.log('Calculated term: $term');</script>";
        return $term;
    }

    static private function getTermForDays($days) {
        // Define the ranges and corresponding terms
        $ranges = [
            [1, 30, 1],
            [31, 60, 2],
            [61, 90, 3],
            [91, 120, 4],
            [121, 150, 5],
            [151, 180, 6],
            [181, 210, 7],
            [211, 240, 8],
            [241, 270, 9],
            [271, 300, 10],
            [301, 330, 11],
            [331, 360, 12],
            [361, 390, 13],
            [391, 420, 14],
            [421, 450, 15],
            [451, 480, 16],
            [481, 510, 17],
            [511, 540, 18],
            [541, 570, 19],
            [571, 600, 20],
            [601, 630, 21],
            [631, 660, 22],
            [661, 690, 23],
            [691, 720, 24],
            [721, 750, 25],
            [751, 780, 26],
            [781, 810, 27],
            [811, 840, 28],
            [841, 870, 29],
            [871, 900, 30],
            [901, 930, 31],
            [931, 960, 32],
            [961, 990, 33],
            [991, 1020, 34],
            [1021, 1050, 35],
            [1051, 1080, 36],
            [1081, 1110, 37],
            [1111, 1140, 38],
            [1141, 1170, 39],
            [1171, 1200, 40],
            [1201, 1230, 41],
            [1231, 1260, 42],
            [1261, 1290, 43],
            [1290, 1320, 44],
            [1321, 1350, 45],
            [1351, 1380, 46],
            [1381, 1410, 47],
            [1411, 1440, 48],
            [1441, PHP_INT_MAX, 60] // Assuming 60 is the term for anything above 1800 days
        ];

        // Iterate over the ranges and find the term
        foreach ($ranges as $range) {
            list($start, $end, $term) = $range;
            if ($days >= $start && $days <= $end) {
                return $term;
            }
        }

        // Return a default value if no range matches
        return null;
    }


    static public function ctrShowFilterCBIInsurance($date){
        $answer = (new ModelInsurance)->mdlShowFilterCBIInsurance($date);
		return $answer;
    }

    static public function ctrShowFilterCBIInsuranceByBranch($date, $branch){
        $answer = (new ModelInsurance)->mdlShowFilterCBIInsuranceByBranch($date, $branch);
		return $answer;
    }

    
    static public function ctrShowFilterCBIInsuranceBranch($date, $branch_name){
        $answer = (new ModelInsurance)->mdlShowFilterCBIInsuranceBranch($date, $branch_name);
		return $answer;
    }

    static public function ctrGetCBIDays($birth_date, $avail_date1, $expire_date1) {
        // Convert dates from YYYYMMDD to m/d/Y format
        $avail_date1 = DateTime::createFromFormat('Ymd', $avail_date1)->format('m/d/Y');
        $expire_date1 = DateTime::createFromFormat('Ymd', $expire_date1)->format('m/d/Y');
        // Create DateTime objects
        $avail_date_obj = DateTime::createFromFormat('m/d/Y', $avail_date1);
        $expiry_date_obj = DateTime::createFromFormat('m/d/Y', $expire_date1);
        // Check if date objects were created successfully
        if (!$avail_date_obj || !$expiry_date_obj) {
            // Output JavaScript to log to the browser console
            echo "<script>console.error('Invalid date format. Avail date: $avail_date1, Expiry date: $expire_date1');</script>";
            return null; // Return null if date conversion fails
        }
        // Calculate the difference
        $interval = $avail_date_obj->diff($expiry_date_obj);
        $days = $interval->days;
        // Output JavaScript to log to the browser console
        // echo "<script>console.log('Days between avail date and expiry date: $days');</script>";
        // echo "<script>console.log('Calculated term: $term');</script>";
        return $days;
    }

    static public function ctrShowFilterPhilInsurance($date){
        $answer = (new ModelInsurance)->mdlShowFilterPhilInsurance($date);
		return $answer;
    }


    static public function ctrShowFilterPhilInsuranceByBranch($date, $branch){
        $answer = (new ModelInsurance)->mdlShowFilterPhilInsuranceByBranch($date, $branch);
		return $answer;
    }

    static public function ctrShowFilterPhilInsuranceBranch($date, $branch_name){
        $answer = (new ModelInsurance)->mdlShowFilterPhilInsuranceBranch($date, $branch_name);
		return $answer;
    }
    
}
        
  
        
    
  