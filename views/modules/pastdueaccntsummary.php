
<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();

//  $branch = $branch_list->ctrShowPastDueLedgers();



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

          $user_id = $_SESSION['user_id'];
          $branch_name = $_SESSION['branch_name'];
?> 
<style>
  .modal-content {
    width: 1000px;
   
}
  textarea#wp_req_for {
    height: 70px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">    
        <div class="col-sm-12">
          <h4 class="page-title">PAST DUE ACCOUNT SUMMARY</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
            </div> 
           
              <div class="row">
              
                <div class="col-sm-2 form-group">
                          <label for="input-6">YEAR</label>
                          <input type="date" class="form-control dateFrom" id="dateFrom"  placeholder="Enter PRR Date"  name="dateFrom" autocomplete="nope" required>
                  </div>
                  <div class="col-sm-3 form-group">
                          <label for="input-6">BRANCH</label>
                          <select class="form-control branch_name_input" name="branch_name_input" id="branch_name_input" >
                          <option value=""><  - - SELECT CLASS - - ></option>
                            <option value="EMB">EMB</option>
                            <option value="FCHN">FCH-VISAYAS</option>
                            <option value="FCHM">FCH-Manila</option>
                            <option value="ELC">ELC</option>
                            <option value="RLC">RFC</option>
                          </select>
                  </div>
                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="generatePastDueLedgerReport" class="btn btn-light btn-round waves-effect waves-light m-1 generatePastDueLedgerReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                      
                </div>   
           
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printPastDueSummaryReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addCorrespondentModal"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>

             <div id="showTableAccountReport" class="table-responsive" hidden>
              <table class="table table-bordered table-hover table-striped ">
                <thead>
                <tr>
                  <th>BRANCH</th>
                  <th id="header-year-1"></th>
                  <th id="header-year-2"></th>
                  <th id="header-year-3"></th>
                  <th id="header-year-4"></th>
                  <th id="header-year-5"></th>
                  <th id="header-year-6"></th>
                  <th id="header-year-7"></th>
                  <th id="header-year-8"></th>
                  <th id="header-year-9"></th>
                  <th id="header-year-10"></th>
                  <th>TOTAL</th>
                </tr>
                </thead>
                <tbody class="reportAccountSummaryTable">
                        
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATABASE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="id" id="id" value="<?php echo $id; ?>">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addPastDue" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addPastDue = new ControllerPastdue();
                     $addPastDue -> addPastDueRecords();
                    ?>
           </div>
        </div>
     <!-- LEDGER MODAL -->
     <div class="modal fade" id="ledgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD LEDGER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">LEDGER FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addLedger" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addLedger = new ControllerPastdue();
                     $addLedger -> addLedgerRecord();
                    ?>
           </div>
        </div>
     <!-- END LEDGER MODAL -->
     <!-- EDIT LEDGER MODAL -->

        <div class="modal fade" id="editLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD LEDGER</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form  method="post">
                    <div class="modal-body">
                    
                    </div>
                    <div class="modal-footer">
                            <button type="submit" name ="editLedgerAccount" class="btn btn-primary">Submit</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                        $addLedger = new ControllerPastdue();
                        $addLedger -> ctrEditLedger();
                        ?>
            </div>
            </div>

            <!-- END EDIT LEDGER MODAL -->
            <!-- ADD REPORT CORRESPONDENTs MODAL -->

        <div class="modal fade" id="addCorrespondentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD CORRESPONDENT</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form  method="post">
                    <div class="modal-body">
                    <div class="row">
                    <div class="col-sm-12 form-group">
                          
                          <input type="text" class="form-control dateFrom_clone" hidden id="dateFrom_clone" name="dateFrom_clone"  autocomplete="nope" >
                  </div>
                  <div class="col-sm-12 form-group">
                          
                          <input type="text" class="form-control branch_name_input_clone" hidden id="branch_name_input_clone"  name="branch_name_input_clone"  autocomplete="nope" >
                  </div>
                   
                    <div class="col-sm-12 form-group">
                          <label for="input-6">PREPARED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="preparedBy" autocomplete="nope">Jason R. Estrellanes</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">CHECKED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="checkedBy" autocomplete="nope">Irish T. Cañete</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">NOTED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="notedBy" autocomplete="nope">Christine G. Nepomuceno
                          Comptroller</textarea>
                  </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                            <button type="submit" name="saves" class="btn btn-primary">PRINT</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                  
                      $addCorrespondents = new ControllerPastdue();
                      $addCorrespondents->ctrAddCorrespondent();
                   
                  ?>
            </div>
            </div>

            <!-- END ADD REPORT CORRESPONDENTs MODAL -->


       
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
