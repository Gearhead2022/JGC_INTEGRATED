<?php

class ControllerOperation{

    static public function ctrShowOperation($branch_name){
		$answer = (new ModelOperation)->mdlShowOperation($branch_name);
		return $answer;
	}

    static public function ctrGetGrossinBal($branch_name, $type){
		$answer = (new ModelOperation)->mdlGetGrossinBal($branch_name, $type);
		return $answer;
	}

	static public function ctrAddBeginningBalance(){
      
    if(isset($_POST["addBeginning"])){
        $table = "op_beginning_bal";
        $data = array("type"=>$_POST["type"],
        "date"=>$_POST["date"],
        "branch_name"=>$_POST["branch_name"],
        "amount"=>$_POST["amount"]);

            $answer = (new ModelOperation)->mdlAddBeginningBalance($table, $data);
            if($answer == "ok"){
            echo'<script>

            swal({
            type: "success",
            title: "Beginning Balance Succesfully Added!",
            showConfirmButton: true,
            confirmButtonText: "Ok"
            }).then(function(result){
                        if (result.value) {
                        window.location = "operations";
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

    static public function ctrAddGrossin(){
        if(isset($_POST['addGrossin'])){
            $table = "op_grossin";


            $data = array("branch_name"=>$_POST["branch_name"],
            "type"=>$_POST["type"],
            "walkin"=>$_POST["walkin"],
            "sales_rep"=>$_POST["sales_rep"],
            "returnee"=>$_POST["returnee"],
            "runners_agent"=>$_POST["runners_agent"],
            "transfer"=>$_POST["gros_transfer"],
            "date"=>$_POST["date"]);
    
            $answer = (new ModelOperation)->mdlAddGrossin($table, $data);
            if($answer == "ok"){
            echo'<script>

            swal({
            type: "success",
            title: "Record Succesfully Added!",
            showConfirmButton: true,
            confirmButtonText: "Ok"
            }).then(function(result){
                        if (result.value) {
                        window.location = "operations";
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
        static public function ctrAddOutGoing(){
            if(isset($_POST['addOutgoing'])){
                $table = "op_outgoing";
    
           
                
                $data = array("branch_name"=>$_POST["branch_name"],
                "type"=>$_POST["type"],
                "fully_paid"=>$_POST["fully_paid"],
                "deceased"=>$_POST["deceased"],
                "transfer"=>$_POST["transfer"],
                "gawad"=>$_POST["gawad"],
                "bad_accounts"=>$_POST["bad_accounts"],
                "date"=>$_POST["date"]);
    
        
                $answer = (new ModelOperation)->mdlAddOutgoing($table, $data);
                if($answer == "ok"){
                echo'<script>
    
                swal({
                type: "success",
                title: "Record Succesfully Added!",
                showConfirmButton: true,
                confirmButtonText: "Ok"
                }).then(function(result){
                            if (result.value) {
                            window.location = "operations";
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

    static public function ctrGetGrossinCumi($previousDate, $full_name){
        $answer = (new ModelOperation)->mdlGetGrossinCumi($previousDate, $full_name);
		return $answer;
    }

    static public function ctrNewGetGrossinCumi($prev, $full_name){
        $answer = (new ModelOperation)->mdlNewGetGrossinCumi($prev, $full_name);
		return $answer;
    }
    static public function ctrGetOutgoingCumi($previousDate, $full_name){
        $answer = (new ModelOperation)->mdlGetOutgoingCumi($previousDate, $full_name);
		return $answer; 

    }

    static public function ctrShowGrossinIdOperation($id){
		$answer = (new ModelOperation)->mdlShowGrossinIdOperation($id);
		return $answer;
	}

    static public function ctrShowOutgoingIdOperation($id){
		$answer = (new ModelOperation)->mdlShowOutgoingIdOperation($id);
		return $answer;
	}

    static public function ctrEditGrossin(){

		if(isset($_POST["editGrossin"])){
			$table = "op_grossin";
						$data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
									"walkin"=>$_POST["walkin"],
								"sales_rep"=>$_POST["sales_rep"],
								"returnee"=>$_POST["returnee"],
								"transfer"=>$_POST["gros_transfer"],
								"runners_agent"=>$_POST["runners_agent"]);
                

				$answer = (new ModelOperation)->mdlEditGrossin($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "";
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
    static public function ctrEditOutGoing(){

		if(isset($_POST["editOutgoing"])){
			$table = "op_outgoing";
						$data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
									"fully_paid"=>$_POST["fully_paid"],
								"deceased"=>$_POST["deceased"],
								"transfer"=>$_POST["transfer"],
								"gawad"=>$_POST["gawad"],
								"bad_accounts"=>$_POST["bad_accounts"]);
                

				$answer = (new ModelOperation)->mdlEditOutGoing($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "";
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

    static public function ctrDeleteOperation(){
            if(isset($_GET['idClient'])){

                $table = "op_beginning_bal";
                $data = $_GET["idClient"];
                $answer = (new ModelOperation)->mdlDelete($table, $data);
                if($answer == "ok"){
                    echo'<script>
    
                    swal({
                          type: "success",
                          title: "Record has been successfully deleted!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "operations";
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
        static public function ctrGetAllEMBBranches(){
            $answer = (new ModelOperation)->mdlShowEMBBranches();
            return $answer;
        }


        static public function ctrGetGrossinData($branch_name, $from, $to){
            $answer = (new ModelOperation)->mdlGetGrossinData($branch_name, $from, $to);
            return $answer;
        }

        static public function ctrGetOutgoingData($branch_name, $from, $to){
            $answer = (new ModelOperation)->mdlGetOutgoingData($branch_name, $from, $to);
            return $answer;
        }

        static public function ctrGetAllFCHBranches(){
            $answer = (new ModelOperation)->mdlGetAllFCHBranches();
            return $answer;
        }
        static public function ctrGetAllRLCBranches(){
            $answer = (new ModelOperation)->mdlGetAllRLCBranches();
            return $answer;
        }

        static public function ctrGetAllELCBranches(){
            $answer = (new ModelOperation)->mdlGetAllELCBranches();
            return $answer;
        }
        static public function ctrAddLSORBeginningBalance(){
      
            if(isset($_POST["addLSORBeginning"])){
                $table = "op_lsor_begin";
                $data = array("dateto"=>$_POST["dateto"],
                "datefrom"=>$_POST["datefrom"],
                "branch_name"=>$_POST["branch_name"],
                "amount"=>$_POST["amount"]);
                    $answer = (new ModelOperation)->mdlAddLSORBeginningBalance($table, $data);
                    if($answer == "ok"){
                    echo'<script>
                    swal({
                    type: "success",
                    title: "Beginning Balance Succesfully Added!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                                if (result.value) {
                                window.location = "";
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
            static public function ctrEditLSORBeginningBalance(){
      
                if(isset($_POST["editLSORBeginning"])){
                    $table = "op_lsor_begin";
                    $data = array("id"=>$_POST["id"],
                                "dateto"=>$_POST["dateto"],
                                "datefrom"=>$_POST["datefrom"],
                                "amount"=>$_POST["amount"]);
                        $answer = (new ModelOperation)->mdlEditLSORBeginningBalance($table, $data);
                        if($answer == "ok"){
                        echo'<script>
                        swal({
                        type: "success",
                        title: "Record Succesfully Updated!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                        }).then(function(result){
                                    if (result.value) {
                                    window.location = "";
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

            static public function ctrAddLSOR(){
      
                if(isset($_POST["add_lsor"])){
                    $table = "op_lsor";
                    $data = array("branch_name"=>$_POST["branch_name"],
                                "date"=>$_POST["date"],
                                "fin_stable"=>$_POST["fin_stable"],
                                "app_wc"=>$_POST["app_wc"],
                                "low_cashout"=>$_POST["low_cashout"],
                                "existing_loan"=>$_POST["existing_loan"],
                                 "other_resched_gawad"=>$_POST["other_resched_gawad"],
                                 "other_sched_gawad"=>$_POST["other_sched_gawad"],
                                 "sched_applynow"=>$_POST["sched_applynow"],
                                "ssp_overage"=>$_POST["ssp_overage"],
                                "lack_requirements"=>$_POST["lack_requirements"],
                                 "undecided"=>$_POST["undecided"],
                                 "refuse_transfer"=>$_POST["refuse_transfer"],
                                "inquired_only"=>$_POST["inquired_only"],
                                "new_policy"=>$_POST["new_policy"],
                                "not_goodcondition"=>$_POST["not_goodcondition"],
                                "guardianship"=>$_POST["guardianship"],
                                "plp"=>$_POST["plp"],
                                "not_qualified"=>$_POST["not_qualified"],
                                "eighteen_mos_sssloan"=>$_POST["eighteen_mos_sssloan"],
                                "on_process"=>$_POST["on_process"]);
            
                        $answer = (new ModelOperation)->AddLSOR($table, $data);
                        if($answer == "ok"){
                        echo'<script>
            
                        swal({
                        type: "success",
                        title: "Record Succesfully Added!",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                        }).then(function(result){
                                    if (result.value) {
                                    window.location = "operationlsor";
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

                static public function ctrGetLSOR($branch_name, $currentDate){
                    $answer = (new ModelOperation)->mdlGetLSOR($branch_name, $currentDate);
                    return $answer;
                }

                static public function ctrGetBeginLSOR($branch_name){
                    $answer = (new ModelOperation)->mdlGetBeginLSOR($branch_name);
                    return $answer;
                }
                static public function ctrShowOperationLSOR($branch_name){
                    $table = "op_lsor";
                    $answer = (new ModelOperation)->mdlShowOperationLSOR($branch_name, $table);
                    return $answer;
                }

                static public function ctrGetBeginLSORReport($branch_name, $month){
                    $answer = (new ModelOperation)->mdlGetBeginLSORReport($branch_name, $month);
                    return $answer;
                }

                static public function ctrGetAllLSOR($branch_name, $firstDay, $lastDay){
                    $answer = (new ModelOperation)->mdlGetAllLSOR($branch_name, $firstDay, $lastDay);
                    return $answer;
                }


                static public function ctrEditLSOR(){
      
                    if(isset($_POST["edit_lsor"])){
                        $table = "op_lsor";
                        $data = array("id"=>$_POST["id"],
                                    "date"=>$_POST["date"],
                                    "fin_stable"=>$_POST["fin_stable"],
                                    "app_wc"=>$_POST["app_wc"],
                                    "low_cashout"=>$_POST["low_cashout"],
                                    "existing_loan"=>$_POST["existing_loan"],
                                     "other_resched_gawad"=>$_POST["other_resched_gawad"],
                                     "other_sched_gawad"=>$_POST["other_sched_gawad"],
                                     "sched_applynow"=>$_POST["sched_applynow"],
                                    "ssp_overage"=>$_POST["ssp_overage"],
                                    "lack_requirements"=>$_POST["lack_requirements"],
                                     "undecided"=>$_POST["undecided"],
                                     "refuse_transfer"=>$_POST["refuse_transfer"],
                                    "inquired_only"=>$_POST["inquired_only"],
                                    "new_policy"=>$_POST["new_policy"],
                                    "not_goodcondition"=>$_POST["not_goodcondition"],
                                    "guardianship"=>$_POST["guardianship"],
                                    "plp"=>$_POST["plp"],
                                    "not_qualified"=>$_POST["not_qualified"],
                                    "eighteen_mos_sssloan"=>$_POST["eighteen_mos_sssloan"],
                                    "on_process"=>$_POST["on_process"]);
                
                            $answer = (new ModelOperation)->mdlEditLSOR($table, $data);
                            if($answer == "ok"){
                            echo'<script>
                
                            swal({
                            type: "success",
                            title: "Record Succesfully Updated!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                            }).then(function(result){
                                        if (result.value) {
                                        window.location = "operationlsor";
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

                    static public function ctrDeleteLSOR(){
                        if(isset($_GET['idClient'])){
                         $table = "op_lsor";
                         $data = $_GET["idClient"];
                            $answer = (new ModelOperation)->mdlDelete($table, $data);
                            if($answer == "ok"){
                                echo'<script>
                
                                swal({
                                      type: "success",
                                      title: "Record has been successfully deleted!",
                                      showConfirmButton: true,
                                      confirmButtonText: "Ok"
                                      }).then(function(result){
                                                if (result.value) {
                                                window.location = "operationlsor";
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

                    static public function ctrGetLSOPCumi($branch_name, $preLastDay){
                        $answer = (new ModelOperation)->mdlGetLSOPCumi($branch_name, $preLastDay);
                        return $answer;
                    }


    static public function ctrAddData(){
        if(isset($_POST['addData'])){
            $table = "op_gross_out";
            $file = $_FILES['file']['tmp_name'];
            $branch_name = $_POST['branch_name'];
            $date1 = $_POST['date'];
            $date = $date1 . "-01";
            $type = $_POST['type'];

            $nameDate = date("F, Y", strtotime($date1));

            // Open the DBF file
        
            $dbf = dbase_open($file, 0);
            
            if ($dbf === false) {
                echo'<script>
                ctrAddLoansAging
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

    $x = 1;
    // Insert the records into the database
    for ($i = 1; $i <= $num_records; $i++) {
         $record = dbase_get_record_with_names($dbf, $i);
      
        
        if ($record !== false) {

            $account_id = $record["ID"];
            $name =  str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record["NAME"]));
            $birth_date =  date('Y-m-d', strtotime($record["BIRTH"]));
            $in_date = $record["IN_DATE"];
            $out_date = $record["OUT_DATE"];
            $reftype = $record["REFTYPE"];
            $status = $record["STATUS"];

            if(ctype_space($in_date)){
                $formattedin_date ="";
            }else{
                $formattedin_date = date('Y-m-d', strtotime($in_date));
            }

            if(ctype_space($out_date)){
                $formattedout_date ="";
            }else{
                $formattedout_date = date('Y-m-d', strtotime($out_date));
            }

            $data=array("account_id"=>$account_id,
                        "branch_name"=>$branch_name,
                        "name"=>$name,
                        "birth_date"=>$birth_date,
                        "type"=>$type,
                        "in_date"=>$formattedin_date,
                        "out_date"=>$formattedout_date,
                        "reftype"=>$reftype,
                        "status"=>$status
                        );

                        if($type == "grossin"){
                            if($status == "A" && $formattedin_date >= "$date"){
                                $x = 2;
                                $answer = (new ModelOperation)->mdlAddDataGrossin($table, $data);
                            }
                        }elseif($type == "outgoing"){
                            if($status != "A"  && $formattedout_date >= "$date"){
                                $x = 2;
                                $answer = (new ModelOperation)->mdlAddDataOutgoing($table, $data);
                            }
                        }
                    }
                }

                if($x == 1){
                    $answer = "error1";
                }

                if($answer == "ok"){
				
                    echo'<script>
            
                    swal({
                          type: "success",
                          title: "Records have been successfully added!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "operations";
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
            
                }else if($answer == "error1"){
                    echo'<script>
            
                    swal({
                          type: "warning",
                          title: "Theres no data to be added for '.$nameDate.'!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    
                                    }
                                })
                    </script>';
            
                }
                else if($answer == "error2"){
                    echo'<script>
            
                    swal({
                          type: "warning",
                          title: "Theres are duplicate data in '.$nameDate.'!",
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

    static public function ctrShowBeginBalance($branch_name){
		$answer = (new ModelOperation)->mdlShowBeginBalance($branch_name);
		return $answer;
	}

    
    static public function ctrShowById($id){
		$answer = (new ModelOperation)->mdlShowById($id);
		return $answer;
	}

    static public function ctrShowBranches(){
		$answer = (new ModelOperation)->mdlShowBranches();
		return $answer;
	}
	
	   static public function ctrShowBranches1(){
		$answer = (new ModelOperation)->mdlShowBranches1();
		return $answer;
	}

	
	

    static public function ctrEditBeginBal(){

		if(isset($_POST["editBeginBalance"])){
            $table = "op_beginning_bal";
            $data = array("id"=>$_POST["id"],
                    "type"=>$_POST["type"],
                    "date"=>$_POST["date"],
                    "branch_name"=>$_POST["branch_name"],
                    "amount"=>$_POST["amount"]);
                

				$answer = (new ModelOperation)->mdlEditBeginBal($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "";
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

    static public function ctrNewGetGrossinData($branch_name, $from, $to){
        $answer = (new ModelOperation)->mdlNewGetGrossinData($branch_name, $from, $to);
        return $answer;
    }

    static public function ctrNewGetOutgoingCumi($previousDate, $full_name){
        $answer = (new ModelOperation)->mdlNewGetOutgoingCumi($previousDate, $full_name);
		return $answer; 

    }

    static public function ctrNewGetOutgoingData($branch_name, $from, $to){
        $answer = (new ModelOperation)->mdlNewGetOutgoingData($branch_name, $from, $to);
        return $answer;
    }


    static public function ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay){
        $answer = (new ModelOperation)->mdlGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
        return $answer;
    }

    static public function ctrGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay){
        $answer = (new ModelOperation)->mdlGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay);
        return $answer;
    }

    static public function ctrGetNorthNegros(){
        $answer = (new ModelOperation)->mdlGetNorthNegros();
        return $answer;
    }

    static public function ctrGetSouthNegros(){
        $answer = (new ModelOperation)->mdlGetSouthNegros();
        return $answer;
    }

    static public function ctrGetPanay(){
        $answer = (new ModelOperation)->mdlGetPanay();
        return $answer;
    }
    static public function ctrGetCentralVisayas(){
        $answer = (new ModelOperation)->mdlGetCentralVisayas();
        return $answer;
    }
    
    static public function ctrGetManila(){
        $answer = (new ModelOperation)->mdlGetManila();
        return $answer;
    }

    static public function crtGetAllReturnee($branch_name, $firstDay, $lastDay){
        $answer = (new ModelOperation)->mdlGetAllReturnee($branch_name, $firstDay, $lastDay);
        return $answer;
    }
    static public function crtGetAllFullyPaid($branch_name, $firstDay, $lastDay){
        $answer = (new ModelOperation)->mdlGetAllFullyPaid($branch_name, $firstDay, $lastDay);
        return $answer;
    }


    static public function ctrAddLoansAging(){
        if(isset($_POST['addAging'])){
            $table = "op_loans_aging";
            $file = $_FILES['file']['tmp_name'];
            $branch_name = $_POST['branch_name'];
            $date1 = $_POST['date'];
            $date = $date1 . "-01";
            $nameDate = date("F, Y", strtotime($date1));

            // Open the DBF file
            $checker = (new ModelOperation)->mdlCheckDuplication($date1, $branch_name);

            if(empty($checker)){
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

    $x = 1;
    // Insert the records into the database
    $copy = 0;
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record($dbf, $i);
      
        
        if ($record !== false) {

            $account_id = $record[0];
            $name =  str_replace('¥', 'Ñ',iconv('ISO-8859-1', 'UTF-8',$record[1]));
            $birth_date =  date('Y-m-d', strtotime($record[9]));
            $lrterm = $record[20];
            $op_change = $record[8];
            $ntotal = $record[26];
            $syxlnmo = $record[23];

            if($syxlnmo != 0){
                $syxlnmo -= 1;
                $copy = $syxlnmo;
            }else{
                $syxlnmo = $copy;
            }

                    $data=array("account_id"=>$account_id,
                    "branch_name"=>$branch_name,
                    "name"=>$name,
                    "birth_date"=>$birth_date,
                    "lrterm"=>$lrterm,
                    "op_change"=>$op_change,
                    "ntotal"=>$ntotal,
                    "syxlnmo"=>$syxlnmo,
                    "date"=>$date1
                    );
                $answer = (new ModelOperation)->mdlAddLoansAging($table, $data);
                    }
                }

            }else{
                $answer = "error1";
            }

                if($answer == "ok"){
                    echo'<script>
                    swal({
                          type: "success",
                          title: "Records have been successfully added!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "operationloansaging";
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
            
                }else if($answer == "error1"){
                    echo'<script>
                    swal({
                          type: "warning",
                          title: "Theres already data added to '.$branch_name.' in '.$date1.'",
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

    static public function ctrShowTotalLoanAging($branch_name){
		$answer = (new ModelOperation)->mdlShowTotalLoanAging($branch_name);
		return $answer;
	}

    static public function ctrGetSPPWithSL($branch_name, $month, $date){
        $answer = (new ModelOperation)->mdlGetSPPWithSL($branch_name, $month, $date);
        return $answer;
    }

    static public function ctrGetLoansChange($branch_name, $month, $date){
        $answer = (new ModelOperation)->mdlGetLoansChange($branch_name, $month, $date);
        return $answer;
    }

    static public function ctrGetLoansNtotal($branch_name, $month, $date){
        $answer = (new ModelOperation)->mdlGetLoansNtotal($branch_name, $month, $date);
        return $answer;
    }


    static public function ctrDeleteLoanAging(){
        if( isset($_GET['date']) && isset($_GET['branch_name']) ){
         $table = "op_loans_aging";
         $date = $_GET["date"];
         $branch_name = $_GET["branch_name"];
            $answer = (new ModelOperation)->mdlDeleteLoansAging($table, $date, $branch_name);
            if($answer == "ok"){
                echo'<script>

                swal({
                      type: "success",
                      title: "Record has been successfully deleted!",
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                      }).then(function(result){
                                if (result.value) {
                                window.location = "operationloansaging";
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


}