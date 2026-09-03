<?php
class ControllerPensioner{
	static public function ctrGetFCHANDEMBBranches(){
		$answer = (new ModelPensioner)->mdlGetFCHANDEMBBranches();
		return $answer;
		
	} 


	static public function ctrAddMonthlyAgent(){

		if(isset($_POST["addMonthlyRecords"])){
			$table = "monthly_agent";
			$branch_name = $_SESSION['branch_name'];


				$data = array("mdate"=>$_POST["mdate"],
								"agents"=>$_POST["agents"],
								"sales"=>$_POST["sales"],
								"branch_name"=>$branch_name
							);


				$answer = (new ModelPensioner)->mdlAddMonthlyAgent($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Checklist Succesfully Created!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "monthlyagent";
									}
								})
					</script>';
				}
				elseif($answer == "error"){
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








	static public function ctrAddMonthlyAgentBeg(){

		if(isset($_POST["addMonthlyRecordsBeginning"])){
			$table = "monthly_beginning_bal";
			$branch_name = $_SESSION['branch_name'];


				$data1 = array("agent_beg_bal"=>$_POST["agent_beg_bal"],
								"sales_beg_bal"=>$_POST["sales_beg_bal"],
								"bdate"=>$_POST["bdate"],
								"branch_name"=>$branch_name
							);


				$answer = (new ModelPensioner)->mdlAddMonthlyAgentBeg($table, $data1);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Checklist Succesfully Created!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "monthlyagent";
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

	static public function ctrMonthlyAgentAjax($branch_name){
        $answer = (new ModelPensioner)->mdlshowTableMA($branch_name);
		return $answer;  
    }

	// beg
	// static public function ctrMonthlyAgentBegAjax(){
    //     $answer = (new ModelPensioner)->mdlshowTableBegMA();
	// 	return $answer;  
    // }

	static public function ctrGetAllEMB(){
        $answer = (new ModelPensioner)->mdlGetAllEMB();
		return $answer;  
    }

	
	static public function ctrGetDataFromBranch($branch_names3){
        $answer = (new ModelPensioner)->mdlGetDataFromBranch($branch_names3);
		return $answer;  
    }

	static public function ctrGetDates($branch_names,$startdate,$enddate){
        $answer = (new ModelPensioner)->mdlGetDates($branch_names,$startdate,$enddate);
		return $answer;  
    }

	static public function ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg){
        $answer = (new ModelPensioner)->mdlGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);
		return $answer;  
    }

	// get data every month
	static public function ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan){
        $answer = (new ModelPensioner)->mdlGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);
		return $answer;  
    }

	static public function ctrGetAllFCHNegros(){
        $answer = (new ModelPensioner)->mdlGetAllFCHNegros();
		return $answer;  
    }

	static public function ctrGetAllFCHManila(){
        $answer = (new ModelPensioner)->mdlGetAllFCHManila();
		return $answer;  
    }

	static public function ctrGetAllRLC(){
        $answer = (new ModelPensioner)->mdlGetAllRLC();
		return $answer;  
    }

	static public function ctrGetAllELC(){
        $answer = (new ModelPensioner)->mdlGetAllELC();
		return $answer;  
    }





	static public function ctrDeleteMonthlyAgent(){
		if(isset($_GET['id'])) {
			$table = 'monthly_agent';	
			$id = $_GET["id"];
		
			$answer = (new ModelPensioner)->mdlDeleteMonthlyAgent($table, $id);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "monthlyagent";
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





	// edit


	static public function ctrEditMonthlyAgent(){

		if(isset($_POST["editMonthlydata"])){
			$table = "monthly_agent";
						$data = array("id"=>$_POST["id"],
									"mdate"=>$_POST["mdate"],
									"agents"=>$_POST["agents"],
									"sales"=>$_POST["sales"]);
                

				$answer = (new ModelPensioner)->mdlEditMonthlyAgent($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Record Update Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "monthlyagent";
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
									window.location = "monthlyagent";
									}
								})
					</script>';
				}

		}
	}



	static public function ctrshowMonthlyAgentEdit($id){
		$answer = (new ModelPensioner)->mdlshowMonthlyAgentEdit($id);
		return $answer;
	}


	// new added by john

	static public function ctrAddPensioner(){

		if(isset($_POST["addPensioner"])){
			   $table = "pensioner";

				$data = array("penIn"=>$_POST["penIn"],
								"penOut"=>$_POST["penOut"],
								"penDate"=>$_POST["penDate"],
                                "branch_name"=>$_POST["branch_name"],	
                                "penInsurance"=>$_POST["penInsurance"],
                        );
				$answer = (new ModelPensioner)->mdlAddPensioner($table, $data);

				if($answer == "ok"){
					echo'<script>

					swal({
						type: "success",
						title: "Pensioners Added Succesfully!",
						showConfirmButton: true,
						confirmButtonText: "Ok"
						}).then(function(result){
									if (result.value) {
									window.location = "branchPensionerList";
									}
								})
					</script>';
				}elseif($answer == "error"){
					echo'<script>

					swal({
						type: "warning",
						title: "Something Went Wrong",
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

    static public function ctrShowDailyPensioner($branch_name, $day, $type){
        $answer = (new ModelPensioner)->mdlShowDailyPensioner($branch_name, $day, $type);
		return $answer;  
    }

	static public function ctrShowBegBalPensioner($branch_name, $day1, $day2, $type){
        $answer = (new ModelPensioner)->mdlShowBegBalPensioner($branch_name, $day1, $day2, $type);
		return $answer;  
    }

	static public function ctrGetBranchesNames($branch_name){
		$answer = (new ModelPensioner)->mdlGetBranchesNames($branch_name);
		return $answer;
		
	} 

	static public function ctrGetBeginningBalance($branch_name, $type, $day1, $day2){
		$answer = (new ModelPensioner)->mdlGetBeginningBalance($branch_name, $type, $day1, $day2);
		return $answer;
		
	} 

	static public function ctrShowDailyPensionerInRange($branch_name, $batchStartDate, $batchEndDate, $SSS){
		$answer = (new ModelPensioner)->mdlShowDailyPensionerInRange($branch_name, $batchStartDate, $batchEndDate, $SSS);
		return $answer;
		
	} 
	static public function ctrGetFCHANDEMBBranches1(){
		$answer = (new ModelPensioner)->mdlGetFCHANDEMBBranches1();
		return $answer;
		
	}
	static public function ctrGetFCHANDEMBBranches2(){
		$answer = (new ModelPensioner)->mdlGetFCHANDEMBBranches2();
		return $answer;
		
	}

	static public function ctrBatchTicketGet($area_code){
		$answer = (new ModelPensioner)->mdlBatchTicketGet($area_code);
		return $answer;
		
	}

	static public function ctrShowAllBranchPensionerList($branch_session){
		$answer = (new ModelPensioner)->mdlShowAllBranchPensionerList($branch_session);
		return $answer;
	}

	static public function ctrShowPensionerAccntTarget($branch_name, $id){
		$answer = (new ModelPensioner)->mdlShowPensionerAccntTarget($branch_name, $id);
		return $answer;
	}

	static public function ctrEditPensionerListAccnt(){

		if(isset($_POST["editPensioner"])){
			$table = "pensioner";

			$data = array(
				"branch_name"=>$_POST["branch_name"],
				"penIn"=>$_POST["penIn"],
				"penOut"=>$_POST["penOut"],
				"penInsurance"=>$_POST["penInsurance"],
				"penDate"=>$_POST["penDate"],
				"pen_id"=>$_POST["pen_id"]
			);

				$answer = (new ModelPensioner)->mdlEditPensionerListAccnt($table, $data);

				if($answer == "ok"){

					echo"<script>
				swal({
					type: 'success',
					title: 'Record Successfully Updated!',
					showConfirmButton: true,
					confirmButtonText: 'Close'
					}).then(function(result){
								if (result.value) {
									window.location = 'branchPensionerList';
								}
							})
				</script>";

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

	



		// new added john

		static public function ctrPastOperationFCHManila(){
			$answer = (new ModelPensioner)->mdlOperationFCHManila();
			return $answer;
		}
		static public function ctrOperationFCHNegros(){
			$answer = (new ModelPensioner)->mdlOperationFCHNegros();
			return $answer;
		}
		static public function ctrOperationEMB(){
			$answer = (new ModelPensioner)->mdlOperationEMB();
			return $answer;
		}
		static public function ctrOperationELC(){
			$answer = (new ModelPensioner)->mdlOperationELC();
			return $answer;
		}
		static public function ctrOperationRLC(){
			$answer = (new ModelPensioner)->mdlOperationRLC();
			return $answer;
		}
		static public function ctrAddSalesRepresentative(){
	
			if(isset($_POST["addSalesRep"])){
				$table = "sales_representative";
			
					$data = array("branch_name"=>$_POST["branch_name"],
								  "rep_fname"=>$_POST["rep_fname"],
								  "rep_lname"=>$_POST["rep_lname"]
								);
	
					$answer = (new ModelPensioner)->mdlAddSalesRepresentative($table, $data);
	
					if($answer == "ok"){
	
						echo"<script>
					swal({
						  type: 'success',
						  title: 'Record Successfully Updated!',
						  showConfirmButton: true,
						  confirmButtonText: 'Close'
						  }).then(function(result){
									if (result.value) {
										window.location = 'operationSPList';
									}
								})
					</script>";
	
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
	
		static public function ctrGetSalesRep($branch_name_abrv){
			$answer = (new ModelPensioner)->mdlGetSalesRep($branch_name_abrv);
			return $answer;
		}
		static public function ctrGetMonthlyGrossIn($branch_name, $startMonth, $endMonth){
			$answer = (new ModelPensioner)->mdlGetMonthlyGrossIn($branch_name, $startMonth, $endMonth);
			return $answer;
		}
	
		static public function ctrGetMonthlyAgent($branch_name, $startMonth, $endMonth){
			$answer = (new ModelPensioner)->mdlGetMonthlyAgent($branch_name, $startMonth, $endMonth);
			return $answer;
		}
	
		
		static public function ctrEditAccountpensioners(){
	
			if(isset($_POST["editAccntPensioner"])){
				$table = "pen_accounts";
	
				$data = array("branch_name"=>$_POST["branch_name"],
					"accnt_in"=>$_POST["accnt_in"],
					"accnt_out"=>$_POST["accnt_out"],
					"date"=>$_POST["date_encode"],
					"accnt_id"=>$_POST["accnt_id"]
				);
	
					$answer = (new ModelPensioner)->mdlEditAccountpensioners($table, $data);
	
					if($answer == "ok"){
	
						echo"<script>
					swal({
						type: 'success',
						title: 'Record Successfully Updated!',
						showConfirmButton: true,
						confirmButtonText: 'Close'
						}).then(function(result){
									if (result.value) {
										window.location = 'branchSP';
									}
								})
					</script>";
	
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
		
	
		static public function ctrAddAccountpensioners(){
	
			if(isset($_POST["addAccntPensioner"])){
				$table = "pen_accounts";
			
				$data = array("branch_name"=>$_POST["branch_name"],
					"accnt_in"=>$_POST["accnt_in"],
					"accnt_out"=>$_POST["accnt_out"],
					"date"=>$_POST["date_encode"]
				);
	
					$answer = (new ModelPensioner)->mdlAddAccountpensioners($table, $data);
	
					if($answer == "ok"){
	
						echo"<script>
					swal({
						type: 'success',
						title: 'Record Successfully Updated!',
						showConfirmButton: true,
						confirmButtonText: 'Close'
						}).then(function(result){
									if (result.value) {
										window.location = 'branchSP';
									}
								})
					</script>";
	
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
		
		static public function ctrGetBegBal($branch_name, $startMonth, $endMonth){
			$answer = (new ModelPensioner)->mdlGetBegBal($branch_name, $startMonth, $endMonth);
			return $answer;
		}
		static public function ctrGetNewBegBal($branch_name,$monthEnd){
			$answer = (new ModelPensioner)->mdlGetNewBegBal($branch_name,$monthEnd);
			return $answer;
		}
		static public function ctrGetBranchAnnualTarget($branch_name, $year){
			$answer = (new ModelPensioner)->mdlGetBranchAnnualTarget($branch_name, $year);
			return $answer;
		}
	
		static public function ctrSalesPerformanceByBranch($branch_name,$monthEn){
			$answer = (new ModelPensioner)->mdlSalesPerformanceByBranch($branch_name,$monthEn);
			return $answer;
		}
	
		static public function ctrShowAccntTarget($id){
			$answer = (new ModelPensioner)->mdlShowAccntTarget($id);
			return $answer;
		}
	
		static public function ctrShowSRAccntTarget($id){
			$answer = (new ModelPensioner)->mdlShowSRAccntTarget($id);
			return $answer;
		}
	
		static public function ctrShowAllSalesRepresentative(){
			$answer = (new ModelPensioner)->mdlShowAllSalesRepresentative();
			return $answer;
		}
	
		static public function ctrEditSalesrepresentative(){
	
			if(isset($_POST["editSalesRep"])){
				$table = "sales_representative";
	
				$data = array("branch_name"=>$_POST["branch_name"],
					"rep_fname"=>$_POST["rep_fname"],
					"rep_lname"=>$_POST["rep_lname"],
					"rep_id"=>$_POST["rep_id"]
				);
	
					$answer = (new ModelPensioner)->mdlEditSalesrepresentative($table, $data);
	
					if($answer == "ok"){
	
						echo"<script>
					swal({
						type: 'success',
						title: 'Record Successfully Updated!',
						showConfirmButton: true,
						confirmButtonText: 'Close'
						}).then(function(result){
									if (result.value) {
										window.location = 'operationSPList';
									}
								})
					</script>";
	
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
	
	
	static public function ctrDeleteRep(){
		if(isset($_GET['id'])){
			$table = "sales_representative";
			$rep_id = $_GET["id"];
			
	
			$answer = (new ModelPensioner)->mdlDeleteTargetSR($table, $rep_id);
			if($answer == "ok"){
				
				echo'<script>
	
				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "operationSPList";
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
	
	static public function ctrDeletePenAccounts(){
		if(isset($_GET['id'])){
			$table = "pen_accounts";
			$rep_accnt_id = $_GET["id"];
			
	
			$answer = (new ModelPensioner)->mdlDeletePenAccountsTarget($table, $rep_accnt_id);
			if($answer == "ok"){
				
				echo'<script>
	
				swal({
					  type: "success",
					  title: "Record has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "branchSP";
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
	
		static public function ctrAddSPReportCorrespondent(){
			if (isset($_POST['saves'])) {
	
				$preparedBy = isset($_POST['preparedSPBy']) ? nl2br($_POST['preparedSPBy']) : "";
				$checkedBy = isset($_POST['checkedSPBy']) ? nl2br($_POST['checkedSPBy']) : "";
				$notedBy = isset($_POST['notedSPBy']) ? nl2br($_POST['notedSPBy']) : "";
		
	
				$table = "correspondentsspreport";
				$data = array(
						"monthEnd"=>$_POST["dateFrom_clone"],
						"preparedBy"=>$preparedBy,
						"checkedBy"=>$checkedBy,
						"notedBy"=>$notedBy
						);
			
				$answer = (new ModelPensioner)->mdlAddSPCorrespondent($table, $data);
				if($answer == "ok"){
		
					echo'<script>
				swal({
					  type: "info",
					  title: "Press OK to continue to PDF format",
					  showConfirmButton: true,
					  showCancelButton: true,
					  confirmButtonText: "OK",
					}).then(function(result){
						if (result.value) {
							var url = "extensions/tcpdf/pdf/print_adminSalesPerformanceReport.php";
							url += "?monthEnd=" + encodeURIComponent("' . $data['monthEnd'] . '");
							url += "&preparedBy=' . rawurlencode($data['preparedBy']) . '";
							url += "&notedBy=' . rawurlencode($data['notedBy']) . '";
							url += "&checkedBy=' . rawurlencode($data['checkedBy']) . '";
							window.open(url, "_blank");
						}
					})
				</script>';
	
		
				}elseif($answer == "error"){
					echo'<script>
		
					swal({
						type: "warning",
						title: "Something went wrong",
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

		//added

		// static public function ctrSalesPerformanceByBranch($branch_name, $monthEnd){
		// 	$answer = (new ModelPensioner)->mdlSalesPerformanceByBranch($branch_name, $monthEnd);
		// 	return $answer;
		// }
		
		static public function ctrShowBranchAnnualTarget(){
			$answer = (new ModelPensioner)->mdlShowBranchAnnualTarget();
			return $answer;
		}

		static public function ctrShowEditBranchAnnualTarget($id){
			$answer = (new ModelPensioner)->mdlShowEditBranchAnnualTarget($id);
			return $answer;
		}

		static public function ctrEditBranchAnnualTarget(){

			if(isset($_POST["editAnnualTarget"])){
				$table = "branch_annual_taget";
	
				$data = array(
					"branch_name"=>$_POST["branch_name"],
					"year"=>$_POST["year"],
					"target"=>$_POST["target"],
					"accnt_id"=>$_POST["accnt_id"]
				);
	
					$answer = (new ModelPensioner)->mdlEditBranchAnnualTarget($table, $data);
	
					if($answer == "ok"){
	
						echo"<script>
					swal({
						type: 'success',
						title: 'Record Successfully Updated!',
						showConfirmButton: true,
						confirmButtonText: 'Close'
						}).then(function(result){
									if (result.value) {
										window.location = 'branchAnnualTargetList';
									}
								})
					</script>";
	
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

		static public function ctrDeleteBranchAnnualTarget(){
			if(isset($_GET['id'])){
				$table = "branch_annual_taget";
				$id = $_GET["id"];
				$branch_name = $_GET["branch_name"];
		
				$answer = (new ModelPensioner)->mdlDeletePensionerListAccnt($table, $id, $branch_name);
				if($answer == "ok"){
					
					echo'<script>
		
					swal({
						  type: "success",
						  title: "Record has been successfully deleted!",
						  showConfirmButton: true,
						  confirmButtonText: "Ok"
						  }).then(function(result){
									if (result.value) {
									window.location = "branchAnnualTargetList";
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

			static public function ctrAddBranchAnnualTarget(){

				if(isset($_POST["addAnnualTarget"])){
					   $table = "branch_annual_taget";
		
						$data = array("branch_name"=>$_POST["branch_name"],
										"annual_target"=>$_POST["target"],
										"year_encoded"=>$_POST["year"]
								);
						$answer = (new ModelPensioner)->mdlAddBranchAnnualTarget($table, $data);
		
						if($answer == "ok"){
							echo'<script>
		
							swal({
								type: "success",
								title: "Target Added Succesfully!",
								showConfirmButton: true,
								confirmButtonText: "Ok"
								}).then(function(result){
											if (result.value) {
											window.location = "branchAnnualTargetList";
											}
										})
							</script>';
						}elseif($answer == "error"){
							echo'<script>
		
							swal({
								type: "warning",
								title: "Something Went Wrong",
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

			static public function ctrDeletePensionerListAccnt(){
				if(isset($_GET['id'])){
					$table = "pensioner";
					$pen_id = $_GET["id"];
					$branch_name = $_GET["branch_name"];
					
			
					$answer = (new ModelPensioner)->mdlDeletePensionerListAccnt($table, $pen_id, $branch_name);
					if($answer == "ok"){
						
						echo'<script>
			
						swal({
							  type: "success",
							  title: "Record has been successfully deleted!",
							  showConfirmButton: true,
							  confirmButtonText: "Ok"
							  }).then(function(result){
										if (result.value) {
										window.location = "branchPensionerList";
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

				static public function ctrAddPStatReportCorrespondent(){
					if (isset($_POST['adminPenPrint'])) {
			
						$preparedBy = isset($_POST['preparedSPBy']) ? nl2br($_POST['preparedSPBy']) : "";
						$checkedBy = isset($_POST['checkedSPBy']) ? nl2br($_POST['checkedSPBy']) : "";
						$notedBy = isset($_POST['notedSPBy']) ? nl2br($_POST['notedSPBy']) : "";
				
			
						$table = "correspondentsspreport";
						$data = array(
								"penDateFrom"=>$_POST["penDateFrom_clone"],
								"penDateTo"=>$_POST["penDateTo_clone"],
								"branchName"=>$_POST["branchName_clone"],
								"preparedBy"=>$preparedBy,
								"checkedBy"=>$checkedBy,
								"notedBy"=>$notedBy
								);
					
						$answer = (new ModelPensioner)->mdlAddSPCorrespondent($table, $data);
						if($answer == "ok"){
				
							echo'<script>
						swal({
							  type: "info",
							  title: "Press OK to continue to PDF format",
							  showConfirmButton: true,
							  showCancelButton: true,
							  confirmButtonText: "OK",
							}).then(function(result){
								if (result.value) {
									var url = "extensions/tcpdf/pdf/adminPensionerReport.php";
									url += "?penDateFrom=" + encodeURIComponent("' . $data['penDateFrom'] . '");
									url += "&penDateTo=" + encodeURIComponent("' . $data['penDateTo'] . '");
									url += "&branchName=" + encodeURIComponent("' . $data['branchName'] . '");
									url += "&preparedBy=' . rawurlencode($data['preparedBy']) . '";
									url += "&notedBy=' . rawurlencode($data['notedBy']) . '";
									url += "&checkedBy=' . rawurlencode($data['checkedBy']) . '";
									window.open(url, "_blank");
								}
							})
						</script>';
			
				
						}elseif($answer == "error"){
							echo'<script>
				
							swal({
								type: "warning",
								title: "Something went wrong",
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


			



			// monthlyagents



		static public function ctrAddMAReportCorrespondent(){
			if (isset($_POST['saves'])) {
	
				$preparedBy = isset($_POST['preparedMABy']) ? nl2br($_POST['preparedMABy']) : "";
			
				$table = "correspondentsspreport";
				$data = array(
						"mdate"=>$_POST["mdate_clone"],
						"preparedBy"=>$preparedBy
						
						);
			
				$answer = (new ModelPensioner)->mdlAddSPCorrespondent($table, $data);
				if($answer == "ok"){
		
					echo'<script>
				swal({
					  type: "info",
					  title: "Press OK to continue to PDF format",
					  showConfirmButton: true,
					  showCancelButton: true,
					  confirmButtonText: "OK",
					}).then(function(result){
						if (result.value) {
							var url = "extensions/tcpdf/pdf/print_monthly_agent_prod.php";
							url += "?mdate=" + encodeURIComponent("' . $data['mdate'] . '");
							url += "&preparedBy=' . rawurlencode($data['preparedBy']) . '";
							window.open(url, "_blank");
						}
					})
				</script>';
	
		
				}elseif($answer == "error"){
					echo'<script>
		
					swal({
						type: "warning",
						title: "Something went wrong",
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
		
		// added 10-11-23//

			static public function ctrShowOperationDailyAvailments($branch_name){
				$answer = (new ModelPensioner)->mdlShowOperationDailyAvailments($branch_name);
				return $answer;
			}

			static public function ctrGetHourlyData($branch_name, $current_date, $hour_from, $hour_to){
				$answer = (new ModelPensioner)->mdlGetHourlyData($branch_name, $current_date, $hour_from, $hour_to);
				return $answer;
			}

		static public function ctrAddBranchDailyAvailments(){

			if (isset($_POST['addAvl'])) {
				$table = "op_hourly_availments";
				$file = $_FILES['file']['tmp_name'];
				$branch_name = $_POST['branch_name'];
				$selected_date = date('Y-m-d', strtotime($_POST['date']));
		
				// Open the DBF file
				$checker = (new ModelPensioner)->mdlCheckDuplication($selected_date, $branch_name);
		
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
		
					$x = 1;
					// Insert the records into the database
					$copy = 0;
					for ($i = 1; $i <= $num_records; $i++) {
						$record = dbase_get_record($dbf, $i);
		
						if ($record !== false) {
							$date = date('Y-m-d', strtotime($record[5]));
		
							// Check if the record's date matches the selected date
							if ($date == $selected_date) {
								$pen_ctr = $record[0];
								$pen_id = $record[1];
								$pen_name = str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $record[2]));
								$loan_type = $record[3];
								$time = date('g:i:s', strtotime($record[4]));
		
								$data = array(
									"pen_ctr" => $pen_ctr,
									"pen_id" => $pen_id,
									"branch_name" => $branch_name,
									"pen_name" => $pen_name,
									"loan_type" => $loan_type,
									"time" => $time,
									"date" => $date,
									"selected_date" => $selected_date
								);
		
								$answer = (new ModelPensioner)->mdlAddBranchDailyAvailments($table, $data);
							}else {
					            $answer = "error2";
				            }
						}
					}
				} else {
					$answer = "error1";
				}
		
				if ($answer == "ok") {
					echo '<script>
						swal({
							type: "success",
							title: "Records have been successfully added!",
							showConfirmButton: true,
							confirmButtonText: "Ok"
						}).then(function(result){
							if (result.value) {
								window.location = "branchAPH";
							}
						})
					</script>';
				} elseif ($answer == "error") {
					echo '<script>
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
				} elseif ($answer == "error1") {
					echo '<script>
						swal({
							type: "warning",
							title: "<p style=\'font-size: 14px;\'>There\'s already data added to ' . $branch_name . ' in ' . $selected_date . '</p>",
							showConfirmButton: true,
							confirmButtonText: "Ok"
						}).then(function(result){
							if (result.value) {
							}
						})
					</script>';
				} elseif ($answer == "error2") {
					echo '<script>
						swal({
							type: "warning",
							title: "<p style=\'font-size: 14px;\'>You provided undefined date ' . $selected_date . ' in ' . $branch_name . '</p>",
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
		

		static public function ctrDeleteAPH(){
			if( isset($_GET['id']) && isset($_GET['branch_name']) && isset($_GET['uploaded_date'])){

			 $table = "op_hourly_availments";
			 $uploaded_date = $_GET["uploaded_date"];
			 $branch_name = $_GET["branch_name"];
			 
				$answer = (new ModelPensioner)->mdlDeleteAPH($table, $uploaded_date, $branch_name);
				if($answer == "ok"){
					echo'<script>
	
					swal({
						  type: "success",
						  title: "Record has been successfully deleted!",
						  showConfirmButton: true,
						  confirmButtonText: "Ok"
						  }).then(function(result){
									if (result.value) {
									window.location = "branchAPH";
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

		static public function ctrGetBranches($branch_abrv){
			$answer = (new ModelPensioner)->mdlGetBranches($branch_abrv);
			return $answer;
		}

			// added 10-20-23 //
		
		static public function ctrShowSelectedYear($selectedYear){
			$answer = (new ModelPensioner)->mdlShowSelectedYear($selectedYear);
			return $answer;
		}

		static public function ctrCountAllAvail($branch_name, $dateFrom, $dateTo){
			$answer = (new ModelPensioner)->mdlCountAllAvail($branch_name, $dateFrom, $dateTo);
			return $answer;
		}

		static public function ctrCountAllAvailTotal($dateFrom, $dateTo){
			$answer = (new ModelPensioner)->mdlCountAllAvailTotal($dateFrom, $dateTo);
			return $answer;
		}

		//added 10-23-23

		static public function ctrCheckToUpdate($year, $data){
			$answer = (new ModelPensioner)->mdlCheckToUpdate($year, $data);
			return $answer;
		}

		
		static public function ctrCountAllAvailPerbranch($branch_name_abv, $dateFrom, $dateTo){
			$answer = (new ModelPensioner)->mdlCountAllAvailPerbranch($branch_name_abv, $dateFrom, $dateTo);
			return $answer;
		}

		
		
		
		

	
}




