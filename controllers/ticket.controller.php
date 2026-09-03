<?php 


class ControllerTicket{

    static public function ctrAddTicket($data){
		$answer = (new ModelTicket)->mdlAddTicket($data);
		return $answer;
    }

    static public function ctrShowTicket(){
		$answer = (new ModelTicket)->modelShowTicket();
		return $answer;
    }
    static public function ctrShowAcrhiveTicket(){
		$answer = (new ModelTicket)->modelShowAcrhiveTicket();
		return $answer;
    }

    static public function ctrGetID($id){
		$answer = (new ModelTicket)->modelGetId($id);
		return $answer;
    }

    static public function ctrSavePrintTicket($data){
		$answer = (new ModelTicket)->mdlSavePrintTicket($data);
		return $answer;
    }


    
    // static public function ctrGetNames(){
	// 	$answer = (new ModelTicket)->mdlGetNames();
	// 	return $answer;
    // }
    // 
    static public function showTicketRecordsForAjax() {
        $tickets = (new ModelTicket)->modelShowTicketB();

        $response = [];
        foreach ($tickets as $ticket) {
    
            $ticketWithAreaCode = [
                "id" => $ticket["id"],
                "name" => $ticket["name"],
                "terms" => $ticket["terms"],
                "tdate" => $ticket["tdate"],
                "amount" =>$ticket['amount'],
                "branch_name" => $ticket['branch_name']
            ];
            $response[] = $ticketWithAreaCode;
        }

        return $response;
    }






    // ADD RECORD TICKET
    static public function addTicketRecords(){
        if(isset($_POST['addTicketRecords'])){
            $table = "ticket_list";
            $file = $_FILES['file']['tmp_name'];
            // Open the DBF file
       
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
    // $id1 =  $_POST['id'];
 
    // Insert the records into the database
    for ($i = 1; $i <= $num_records; $i++) {
        $record = dbase_get_record($dbf, $i);

       
        if ($record !== false) {
            $ctr_no = trim($record[0]);
            $id = trim($record[1]);
            $name =  trim(str_replace('¥', 'Ñ',  iconv('ISO-8859-1', 'UTF-8',$record[2])));
            $terms1 = $record[11];
            $terms = $record[45];
            $tdate = date('Y-m-d', trim(strtotime($record[8])));
            $branch_name = $_SESSION['branch_name'];

           // $branch_name1 = $record[5];
           // $branch_name = rtrim($branch_name1);

			if ($branch_name == "EMB CADIZ" || $branch_name == "EMB SAN CARLOS" || $branch_name == "EMB SAGAY" ||
             $branch_name == "EMB VICTORIAS" || $branch_name == "EMB TALISAY" || $branch_name == "FCH SILAY" || 
             $branch_name == "FCH BACOLOD" || $branch_name == "RLC SINGCANG" || $branch_name == "RLC BURGOS" ||
             $branch_name == "FCH MURCIA" ) {
				$area_code = "NORTH_NEG";
			} 
			elseif($branch_name == "FCH BAGO" || $branch_name == "EMB LA CARLOTA" || $branch_name == "EMB LA CASTELLANA" || 
            $branch_name == "EMB KABANKALAN" || $branch_name == "FCH BINALBAGAN" || $branch_name == "FCH HINIGARAN" 
            || $branch_name == "EMB SIPALAY"){
				$area_code = "SOUTH_NEG";
			}
			else if($branch_name == "EMB MIAG AO" || $branch_name == "EMB ROXAS" || $branch_name == "EMB PASSI" ||
            $branch_name == "EMB SARA" || $branch_name == "EMB ILOILO" || $branch_name == "EMB MAMBUSAO" ||
            $branch_name == "RLC ANTIQUE" || $branch_name == "RLC KALIBO"){
				$area_code = "PANAY";
			}
            else if($branch_name == "EMB CEBU" || $branch_name == "EMB TOLEDO" || $branch_name == "EMB DANAO" ||
            $branch_name == "EMB TUBIGON" || $branch_name == "EMB TAGBILARAN" || $branch_name == "EMB MANDAUE" ||
            $branch_name == "EMB DUMAGUETE" || $branch_name == "EMB BAYAWAN" || $branch_name == "EMB BAIS"){
				$area_code = "CENT_VIS";
			}
            else if($branch_name == "FCH PARANAQUE" || $branch_name == "FCH MUNTINLUPA" || $branch_name == "ELC BULACAN"){
				$area_code = "NCR";
			}
            else if($branch_name == "EMB MAIN BRANCH"){
				$area_code = "MAIN";
			}
            
            else{
                 $area_code = "UNKNOWN";
            }

            $data = array("id" => $id,
                 "ctr_no" => $ctr_no,
                "name" => $name,
                "terms" => $terms,
                "tdate" => $tdate,    
                "branch_name" => $branch_name,
                 "area_code" => $area_code          
            );

            if($terms != 0){
                $isDuplicate = (new ModelTicket)->modelcheckDuplicate($id, $name, $tdate, $branch_name, $ctr_no);
                if ($isDuplicate) {
                    $chk = "ok"; // Duplicate found

                    
                } else {
                    $answer = (new ModelTicket)->mdlAddTicket($data);
                    if($answer == "ok"){
                        $chk = "ok";
                    }else{
                        $chk = "error";
                    }
                }
            }
            

            // $branch_name1 = $record[5];
            // $branch_name = rtrim($branch_name1);

				// if ($branch_name == "EMB CADIZ") {
				// 	$area_code = "EMCZ";
				// } 
				// elseif($branch_name == "EMB CEBU"){
				// 	$area_code = "EMCU";
				// }
				// else if($branch_name == "EMB MAIN BRANCH"){
				// 	$area_code = "EMB";
				// }
        

          

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
                        window.location = "ticket";
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

    }
    

        
        }

    }

    static public function ctrMakeTicket(){
        if(isset($_GET['type'])){
            $id = $_GET['id'];
            $branch_name = $_GET['branch_name'];
            $terms = $_GET['terms'];
            $index_id = $_GET['index_id'];
            $name = $_GET['name'];
            $area_code = $_GET['area_code'];
            $tdate = $_GET['tdate'];
          
            $branch_ticket_mapping = [
                'EMB MAIN BRANCH' => 'M2',
                'EMB CADIZ' => 'CAD',
                'EMB LA CARLOTA' => 'LAC',
                'EMB KABANKALAN' => 'KAB',
                'EMB ILOILO' => 'ILO',
                'EMB DUMAGUETE' => 'DMGT',
                'EMB SAN CARLOS' => 'SC',
                'EMB TAGBILARAN' => 'TAG',
                'EMB MANDAUE' => 'MAN',
                'EMB ROXAS' => 'ROX',
                'EMB SAGAY' => 'SAG',
                'EMB VICTORIAS' => 'VIC',
                'EMB BAYAWAN' => 'BAY',
                'EMB BAIS' => 'BAIS',
                'EMB LA CASTELLANA' => 'LACAS',
                'EMB PASSI' => 'PASSI',
                'EMB SARA' => 'SARA',
                'EMB SIPALAY' => 'SIP',
                'EMB CEBU' => 'CEBU',
                'EMB TALISAY' => 'TAL',
                'EMB TOLEDO' => 'TOL',
                'EMB MAMBUSAO' => 'MAM',
                'EMB MIAG AO' => 'MIAG',
                'EMB DANAO' => 'DANAO',
                'EMB TUBIGON' => 'TUB',
                'EMB SIQUIJOR' => 'SIQ',
                'FCH BACOLOD' => 'FCH',
                'FCH SILAY' => 'FCHSC',
                'FCH BAGO' => 'FCHBG',
                'FCH MURCIA' => 'FCHMUR',
                'FCH BINALBAGAN' => 'FCHBIN',
                'FCH PARANAQUE' => 'FCHPAR',
                'FCH MUNTINLUPA' => 'FCHMUN',
                'FCH HINIGARAN' => 'FCHHIN',
                'RLC KALIBO' => 'RFCKL',
                'RLC BURGOS' => 'RFCBC',
                'RLC SINGCANG' => 'RFCSC',
                'RLC ANTIQUE' => 'RFCAN',
                'ELC BULACAN' => 'ELC',
                'FCH LAPU LAPU' => 'FCHLAP',
                'RLC CULASI' => 'RFCCUL',
            ];
            // Default value when no match is found
            $default_ticket = '';
            $branch_code = $branch_ticket_mapping[$branch_name] ?? $default_ticket;

                # code...
            $data= array(
                "id" => $id,
                "index_id" => $index_id,
                "branch_code" => $branch_code,
                "terms" => $terms,
                "name" => $name,
                "area_code" => $area_code,
                "tdate" => $tdate,
                "branch_name" => $branch_name
            );
            $answer = (new ModelTicket)->mdlMakeTiket($data);
            if($answer == "ok"){
                echo"<script>
					swal({
						  type: 'success',
						  title: 'Ticket has been successfully added!',
						  showConfirmButton: true,
						  confirmButtonText: 'Close'
						  }).then(function(result){
									if (result.value) {
										window.open('extensions/tcpdf/pdf/ticket.php?id=$id&branch_name=$branch_name&name=$name&terms=$terms&tdate=$tdate');
                                        window.location = 'ticket';
									}
								})
					</script>";

            }
          
        }
	
    }
    static public function ctrGetTickets($data){
		$answer = (new ModelTicket)->mdlGetTickets($data);
		return $answer;
    }


    static public function ctrBatchTicketGet($area_code, $branch_name){
		$answer = (new ModelTicket)->mdlBatchTicketGet($area_code, $branch_name);
		return $answer;
		
	}

    static public function ctrSingleTicket(){
        if(isset($_POST['addTickets'])){
            $table = "ticket_list";
            $branch_name = $_POST['branch_name'];
			if ($branch_name == "EMB CADIZ" || $branch_name == "EMB SAN CARLOS" || $branch_name == "EMB SAGAY" ||
            $branch_name == "EMB VICTORIAS" || $branch_name == "EMB TALISAY" || $branch_name == "EMB SILAY" || 
            $branch_name == "FCH BACOLOD" || $branch_name == "RLC SINGCANG" || $branch_name == "RLC BURGOS" ||
            $branch_name == "FCH MURCIA" ) {
               $area_code = "NORTH_NEG";
           } 
           elseif($branch_name == "FCH BAGO" || $branch_name == "EMB LA CARLOTA" || $branch_name == "EMB LA CASTELLANA" || 
           $branch_name == "EMB KABANKALAN" || $branch_name == "FCH BINALBAGAN" || $branch_name == "FCH HINIGARAN" 
           || $branch_name == "EMB SIPALAY"){
               $area_code = "SOUTH_NEG";
           }
           else if($branch_name == "EMB MIAG AO" || $branch_name == "EMB ROXAS" || $branch_name == "EMB PASSI" ||
           $branch_name == "EMB SARA" || $branch_name == "EMB ILOILO" || $branch_name == "EMB MAMBUSAO" ||
           $branch_name == "RLC ANTIQUE" || $branch_name == "RLC KALIBO" || $branch_name == "RLC CULASI"){
               $area_code = "PANAY";
           }
           else if($branch_name == "EMB CEBU" || $branch_name == "EMB TOLEDO" || $branch_name == "EMB DANAO" ||
           $branch_name == "EMB TUBIGON" || $branch_name == "EMB TAGBILARAN" || $branch_name == "EMB MANDAUE" ||
           $branch_name == "EMB DUMAGUETE" || $branch_name == "EMB BAYAWAN" || $branch_name == "EMB BAIS" || $branch_name == "FCH LAPU LAPU"){
               $area_code = "CENT_VIS";
           }
           else if($branch_name == "FCH PARANAQUE " || $branch_name == "FCH MUNTINLUPA" || $branch_name == "ELC BULACAN"){
               $area_code = "NCR";
           }
           else if($branch_name == "EMB MAIN BRANCH"){
               $area_code = "MAIN";
           }
           else{
                $area_code = "UNKNOWN";
           }

                  # code...
                  $data= array(
                    "id" => $_POST['id'],
                    "branch_name" => $branch_name,
                    "name" => $_POST['name'],
                    "tdate" => $_POST['tdate'],
                    "terms" => $_POST['terms'],
                    "ctr_no" => $_POST['ctr_no'],
                    "area_code" => $area_code
                );

                $answer = (new ModelTicket)->mdlAddSingleTicket($table,$data);

                if($answer == "ok"){
				
                    echo'<script>
            
                    swal({  
                          type: "success",
                          title: "Records have been successfully added!",
                          showConfirmButton: true,
                          confirmButtonText: "Ok"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "ticket";
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


    static public function ctrDeleteTicket(){
		if(isset($_GET['idClient'])){
			$table = "ticket_list";
			$data = $_GET["idClient"];
		
			$answer = (new ModelTicket)->mdlDelete($table, $data);
			if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Ticket has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "ticket";
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
	
	 static public function ctrShowBranches(){
		$answer = (new ModelTicket)->mdlShowBranches();
		return $answer;
	}
	
	  static public function ctrGetRenew($rDate, $branch_name){
		$answer = (new ModelTicket)->mdlGetRenew($rDate, $branch_name);
		return $answer;
    }
    
     static public function ctrGetNewRenew($rDate, $branch_name){
		$answer = (new ModelTicket)->mdlGetNewRenew($rDate, $branch_name);
		return $answer;
    }
    
    static public function ctrGetAllEMBBranches(){
        $answer = (new ModelTicket)->mdlShowEMBBranches();
        return $answer;
    }

    static public function ctrGetAllFCHBranches(){
        $answer = (new ModelTicket)->mdlGetAllFCHBranches();
        return $answer;
    }

    static public function ctrGetAllRLCBranches(){
        $answer = (new ModelTicket)->mdlGetAllRLCBranches();
        return $answer;
    }

    static public function ctrGetAllELCBranches(){
        $answer = (new ModelTicket)->mdlGetAllELCBranches();
        return $answer;
    }

    static public function ctrGetTicketCumi($fDate, $prev, $branch_name){
		$answer = (new ModelTicket)->mdlGetTicketCumi($fDate, $prev, $branch_name);
		return $answer;
    }

    static public function ctrGetNewTicketCumi($fDate, $prev, $branch_name){
		$answer = (new ModelTicket)->mdlGetNewTicketCumi($fDate, $prev, $branch_name);
		return $answer;
    }
    
     static public function ctrGetTicketRenewCumi($prev, $branch_name){
		$answer = (new ModelTicket)->mdlGetTicketRenewCumi($prev, $branch_name);
		return $answer;
    }

    static public function ctrGetNewTicketRenewCumi($prev, $branch_name){
		$answer = (new ModelTicket)->mdlGetNewRenewTicketCumi($prev, $branch_name);
		return $answer;
    }


}