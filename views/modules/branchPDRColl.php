
<style>
    textarea#wp_req_for {
    height: 100px;
}
[type="checkbox"] {
/* Style the color of the message that says 'No file chosen' */
  background: green;
  height: 19px !important;
  width: 19px !important;
}
</style>
<?php 

    $permit = (new Connection)->connect()->query("SELECT * from past_due ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
    if(empty($permit)){
        $id = 0;
    }else{
        $id = $permit['id'];
    }
    $last_id = $id + 1;
    $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;     

    date_default_timezone_set('Asia/Manila');
        $date_now =date("F d Y"); 

    // $user_id = $_SESSION['user_id'];
    $branch_name = $_SESSION['branch_name'];
?>   
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">PDR COLLECTION RECORDS</h4>
     </div>
   </div> 
    <div class="row">
    
      <div class="col-lg-12">
        <form method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-header ml-4">
                <div class="row">
                <?php 
                  if($_SESSION['type']=="backup_user" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                            
                      <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#pdrcollfileUpdate"><i class="fa fa-upload"></i> <span>&nbsp;UPLOAD FILE</span> </button>

                      <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#searchidpdrcoltrans"><i class="fa fa-search"></i> <span>&nbsp;SEARCH BY ID</span> </button>

                      <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#addpdrcoltrans"><i class="fa fa-plus"></i> <span>&nbsp;ADD NEW PDR ACCOUNT</span> </button>

                      <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" onclick="window.location.href='branchPDRLedger';">
                          <i class="fa fa-book"></i> <span>&nbsp;PDR LEDGER</span>
                      </button>

                      <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" onclick="window.location.href='branchPDRCollArchive';">
                          <i class="fa fa-archive"></i> <span>&nbsp;REPORT ARCHIVE</span>
                      </button>

               <?php  }?>
            </div>  
                  </div>   
            <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped pdrCollDateTable">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>ID</th>
                  <th>SSP / GSP</th>
                  <th>STATUS</th>
                  <th>DATE ENDORSED</th>
                  <th>DATE OF PAYMENT</th>
                  <th>REF</th>
                  <th>PREVIOUS BALANCE</th>
                  <th>AMOUNT CREDIT</th>
                  <th>AMOUNT DEBIT</th>
                  <th>ENDING BALANCE</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <!-- <button type="submit" name="submit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button> -->
                   <!--<button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                            -->
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerFullypaid();
                    $createClient -> addRecords();
                    ?>
      </div>
    </div><!--End Row-->

        <!-- UPDATE FILE MODAL -->
        <div class="modal fade" id="pdrcollfileUpdate"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content" style="background-color: 	#696969;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">UPDATE RECORDS</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
                  <div class="card">
                  <div class="card-header">
                    <div class="row mt-3 ml-2">
                    <div class="col-12">
                            <label for="or_file">Transaction date:</label>
                            <input type="date" class="form-control" id="trans_date" name="trans_date" placeholder="Enter Date" autocomplete="nope" required>
                             <!-- <medium class="text-white">Local path: <i class="fas fa-file"></i> C:/receipt/</medium> -->
                        </div>
                      <div class="col-12 mt-4">
                            <label for="or_file">Upload your file:</label>
                            <input type="file" class="form-control" id="pdr_file" name="pdr_file" placeholder="Enter Date" autocomplete="nope" required>
                             <!-- <medium class="text-white">Local path: <i class="fas fa-file"></i> C:/receipt/</medium> -->
                        </div>
                      <div class="col-3">
                          <input type="hidden" class="form-control" name="pdr_branch_name" id="pdr_branch_name"  placeholder="Enter Date" value="<?php echo $_SESSION['branch_name'] ?>" autocomplete="nope" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" name="updatePDRFileRecords" id="updatePDRFileRecords" class="btn btn-primary">SUBMIT</button>
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </form>
              <?php
                      $updateRecord = new ControllerPDRColl();
                      $updateRecord -> ctrUpdatePDRFileRecords();
                ?>
             
           </div>
        </div>
      </div>
     <!-- END UPDATE FILE MODAL -->

         <!-- CREATE NEW ACCOUNT OR TRANSACTION MODAL2 -->
        <div class="modal fade" id="addpdrcoltrans"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content" style="background-color: 	#696969;">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD PDR ACCOUNT</h5>
                        <button type="button" class="close resetpdrButton" aria-label="Close">
                                <span aria-hidden="true" id="resetpdrButton">&times;</span>
                        </button>
                </div>
                <form method="post" id="pdrNewForm" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
                    <div class="card">
                        <div class="card-header">
                        <div class="row">
                                <div class="col-2 mt-1">
                                    <label for="inputIdNo" class="col-form-label">ID NO :</label>
                                </div>
                                <div class="col-2 mt-1">
                                    <input type="text" id="new_account_no" name="new_account_no" class="form-control" placeholder="Enter ID">
                                       
                                    <input type="text" id="new_due_id" name="new_due_id" value="<?php echo $id_holder; ?>" hidden class="form-control" placeholder="Enter ID">
                                    <input type="text" id="new_branch_name" name="new_branch_name" value="<?php echo $branch_name; ?>" hidden class="form-control" placeholder="Enter ID">
                                </div>
                                <div class="col-1 mt-3" style="margin-left: -20px;">
                                        <medium class="text-danger" hidden id="message1"><i class="fa fa-exclamation-circle"></i></medium>
                                        <medium class="text-info" hidden id="message2"><i class="fa fa-check-circle"></i></medium>
                                </div>
                                <div class="col-1.2">
                                   <input type="checkbox" class="form-control mt-3" name="auto_fill_id" id="auto_fill_id">
                                </div>
                                <div class="col-2">
                                    <label for="inputIdNo" class="col-form-label mt-2">OLR ID</label>
                                </div>
                                <div class="col-1.2"></div>
                                <span class="col-4" id="date_mod">
                                    <i class="fs text-success bg-transparent">Date Added:</i>
                                    <p><?php echo date('M-d-Y h:i A',time());?></p>
                                </span>
                               
                            </div>
                        </div>
                
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputAccountNo" class="col-form-label">FIRST NAME :</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="new_first_name" required name="new_first_name" class="form-control" placeholder="Enter First Name">
                                </div> 
                                <div class="col-2">
                                    <label for="inputAccountNo" class="col-form-label">LAST NAME :</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="new_last_name" required name="new_last_name" class="form-control" placeholder="Enter Last Name">
                                </div> 
                                <div class="col-1">
                                    <label for="inputAccountNo" class="col-form-label">M.I:</label>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" id="new_middle_name" required name="new_middle_name" class="form-control" placeholder="M.I">
                                </div> 
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputName" class="col-form-label">AGE :</label>
                                </div>
                                <div class="col-2">
                                    <input type="number" id="new_age" required name="new_age" class="form-control" placeholder="Enter Age">
                                </div>
                                <div class="col-1"></div>
                                <div class="col-2">
                                <label for="inputName" class="col-form-label">BANK :</label>
                                </div>
                                <div class="col-3">
                                    <input type="text" id="new_bank" required name="new_bank" class="form-control" placeholder="Enter Bank">
                                </div>
                            
                            </div>

                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputName" class="col-form-label">ADDRESS :</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="new_address" name="new_address" class="form-control" required placeholder="Enter Address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputBank" class="col-form-label">CLASS :</label>
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="new_status" id="new_status" required>
                                        <option value=""  selected disabled><- - CLASS - -></option>
                                        <option value="D">D - DECEASED</option>
                                        <option value="F">F - FULLY PAID</option>
                                        <option value="P">P - POLICE ACTION</option>
                                        <option value="W">W - WRITE OFF</option>
                                        <option value="L">L - LITIGATION</option>
                                    </select>
                                </div>

                                <div class="col-2">
                                    <label for="inputBank" class="col-form-label">TYPE :</label>
                                </div>
                                <div class="col-4">
                                    <select class="form-control" name="new_type" id="new_type" required>
                                        <option value=""  selected disabled><- - - TYPE - - -></option>
                                        <option value="E">E - 17 Months Above</option>
                                        <option value="S">S - 17 Months Below</option>
                                    </select>
                                </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="inputName" class="col-form-label">ENDORSED DATE :</label>
                            </div>
                            <div class="col-3">
                                <input type="date" id="new_edate" required name="new_edate" class="form-control" placeholder="Enter Endoresed Date">
                            </div>
                           
                          
                        </div>
            
                    </div>        
                    </div><!--card-->
                    </div>
                        <div class="modal-footer" style="background-color: 	#696969;">
                        <button type="submit" name="addNewPDRCollRecord" disabled id="addNewPDRCollRecord" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary resetpdrButton" id="resetpdrButton">Close</button>
                        </div>
            
                </div>
            </form>
                <?php
                     $addPinRecords = new ControllerPDRColl();
                     $addPinRecords -> ctrAddNewPDRCollectionRecord();
                ?>
           </div>
        </div>
     <!-- END  CREATE NEW ACCOUNT OR TRANSACTION MODAL1 -->


       <!-- PROCCESS MODAL -->
       <div class="modal fade" id="processpdrcoltrans"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content" style="background-color: 	#696969;">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">PROCCESS PDR COLLECTION</h5>
                        <button type="button" class="close resetpdrButton" aria-label="Close">
                                <span aria-hidden="true" id="resetpdrButton">&times;</span>
                        </button>
                </div>
                <form method="post" id="pinForm" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
             
                </div>
                <div class="modal-footer" style="background-color: 	#696969;">
                <button type="submit" name="addPDRCollRecord" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary resetpdrButton" id="resetpdrButton">Close</button>
                </div>
              </div>
            </form>
                <?php
                     $addProcessedPDRColl = new ControllerPDRColl();
                     $addProcessedPDRColl -> ctrAddPDRCollectionRecord();
                ?>
           </div>
        </div>
     <!-- END PROCESS MODAL1 -->

       <!-- SEARCH PDR ACCOUNT BY ID MODAL2 -->
       <div class="modal fade" id="searchidpdrcoltrans"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content" style="background-color: 	#696969;">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">SEARCH PDR COLLECTION</h5>
                        <button type="button" class="close resetpdrButton" aria-label="Close">
                                <span aria-hidden="true" id="resetpdrButton">&times;</span>
                        </button>
                </div>
                <form method="post" id="pdrForm" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputIdNo" class="col-form-label">ID NO :</label>
                                </div>
                                <div class="col-2">
                                    <input type="text" id="pdr_coll_account_no" name="pdr_coll_account_no" class="form-control" placeholder="select ID">
                                    <input type="text" id="due_id" name="due_id" hidden class="form-control" placeholder="select ID">
                                    <input type="text" id="pdr_coll_branch" hidden name="pdr_coll_branch" value="<?php echo $_SESSION['branch_name'];?>" class="form-control" placeholder="select ID">
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-info waves-effect waves-light showPDRDetails">
                                        <i class="fa fa-eye"></i> <span>SHOW DETAILS</span>
                                    </button>
                                </div>
                                <div class="col-4">
                                    <i>Date Modified:</i>
                                    <p class="text-success  bg-transparent"><?php echo date('M-d-Y h:i:s A',time());?></p>
                                </div>
                              
                            </div>
                        </div>
                
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                        <label for="inputAccountNo" class="col-form-label">FIRST NAME :</label>
                                </div>
                                <div class="col-sm-3">
                                    
                                    <input type="text" id="search_first_name" name="search_first_name" class="form-control" placeholder="Enter First Name">
                                
                                </div> 
                                <div class="col-2">
                                        <label for="inputAccountNo" class="col-form-label">LAST NAME :</label>
                                </div>
                                <div class="col-sm-3">
                                    
                                    <input type="text" id="search_last_name" name="search_last_name" class="form-control" placeholder="Enter Last Name">
                                
                                </div> 
                                <div class="col-1.2">
                                        <label for="inputAccountNo" class="col-form-label">M.I:</label>
                                </div>
                                <div class="col-sm-1">
                                    
                                    <input type="text" id="search_middle_name" name="search_middle_name" class="form-control" placeholder="M.I">
                                
                                </div> 
                                </div>
                                <div class="row mb-3">
                                
                                <div class="col-2">
                                    <label for="inputBank" class="col-form-label">CLASS :</label>
                                </div>
                                <div class="col-3">
                                  <select class="form-control" name="search_status" id="search_status" required>
                                    <option value=""  selected disabled><- - CLASS - -></option>
                                    <option value="D">D - DECEASED</option>
                                    <option value="F">F - FULLY PAID</option>
                                    <option value="P">P - POLICE ACTION</option>
                                    <option value="W">W - WRITE OFF</option>
                                    <option value="L">L - LITIGATION</option>
                                  </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="inputName" class="col-form-label">ENDORSED SDATE :</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" readonly id="search_edate" name="search_edate" class="form-control" placeholder="Enter Endoresed Date">
                                </div>
                                <div class="col-2">
                                    <label for="inputName" class="col-form-label">TRANSACTION DATE :</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" id="search_tdate" name="search_tdate" class="form-control" required placeholder="Enter transaction date">
                                </div>
                            </div>
                            <div class="row mb-3">
                            <div class="col-2">
                                    <label for="inputBank" class="col-form-label">REF :</label>
                                </div>
                                <div class="col-3">
                                    <input type="text" id="search_ref" name="search_ref" class="form-control" required placeholder="Enter Reference">
                                </div>
                                <div class="col-2">
                                    <label for="inputAccountNo" class="col-form-label">PREVIOUS BAL:</label>
                                </div>
                                <div class="col-3">
                                    <input type="number"  step="any" id="search_prev_bal" name="search_prev_bal" class="form-control calculateEndBal prev_bal" readonly  value="" placeholder="Enter Previous Balance">
                                </div>
                            </div>

                            <div class="row mb-3">
                            <div class="col-2">
                                    <label for="inputBank" class="col-form-label">DEBIT:</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="any" id="debit" name="debit" class="form-control calculateEndBal debit"  value="" placeholder="Enter Amount">
                                </div>
                                <div class="col-2">
                                    <label for="inputAccountNo" class="col-form-label">CREDIT :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" step="any" id="credit" name="credit" class="form-control calculateEndBal credit"  value="" placeholder="Enter Amount">
                                </div>
                            </div>
                            <div class="row mb-3">
                            <div class="col-2">
                                    <label for="inputAccountNo" class="col-form-label">ENDING BAL :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="end_bal" name="end_bal" readonly class="form-control end_bal"  value="" placeholder="Auto Ending Balance">
                                </div>
                            </div>
                           
                        </div>         
                    </div><!--card-->
                    </div>
                        <div class="modal-footer" style="background-color: 	#696969;">
                        <button type="submit" name="addPDRCollRecordById" id="addPDRCollRecordById" disabled class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary resetpdrButton" id="resetpdrButton">Close</button>
                        </div>
            
                </div>
            </form>
                <?php
                     $addPinRecords = new ControllerPDRColl();
                     $addPinRecords -> ctrAddPDRCollectionRecordById();
                ?>
           </div>
        </div>
     <!-- END  SEARCH PDR ACCOUNT BY ID MODAL1 -->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

<?php

    $deletePDRCollection = new ControllerPDRColl();
    $deletePDRCollection->ctrDeletePDRCollection();
?>