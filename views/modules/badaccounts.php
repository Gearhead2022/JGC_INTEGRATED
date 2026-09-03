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

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">    
        <div class="col-sm-12">
          <h4 class="page-title">SUMMARY OF BAD ACCOUNTS</h4>
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
                          <label for="input-6">Date</label>
                          <input type="month" class="form-control dateFrom" id="dateFrom"  placeholder="Enter PRR Date"  name="dateFrom" autocomplete="nope" >
                  </div>
                  <div class="col-sm-2 form-group">
                          <label for="input-6">BRANCH</label>
                          <select class="form-control branch_name_input" name="branch_name_input" id="branch_name_input">
                          <option selected value=""><- -SELECT BRANCH- -></option>
                            <option value="EMB">EMB</option>
                            <option value="FCHN">FCH VISAYAS</option>
                            <option value="FCHM">FCH MANILA</option>
                            <option value="FCHA">FCH ANTIPOLO</option>
                            <option value="ELC">ELC</option>
                            <option value="RLC">RFC</option>
<!--                             
                            <option value="EMB">EMB</option>    
                            <option value="FCH">FCH</option>
                            <option value="ELC">ELC</option>
                            <option value="RLC">RLC</option> -->

                            </select>
                  </div>
                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="summaryOfBadAccounts" class="btn btn-light btn-round waves-effect waves-light m-1 summaryOfBadAccounts"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
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
                  <th>PARTICULAR</th>
                  <th>S</th>
                  <th>Amount</th>
                  <th>E</th>
                  <th>Amount</th>
                  <th>No.</th>
                  <th>DECEASED</th>
                  <th>S</th>
                  <th>Amount</th>
                  <th>E</th>
                  <th>Amount</th>
                  <th>No.</th>
                  <th>POLICE ACTION</th>
                  <th>S</th>
                  <th>E</th>
                  <th>No.</th>
                  <th>PAST DUE</th>
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


<!-- written off text box -->
     




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
                          <label for="input-6">PREPARED BY:</label>
                          <input type="text" class="form-control" id="preparedBy" value="Jason R. Estrellanes"  placeholder="Provide Name"  name="preparedBy" autocomplete="nope" >
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">NOTED BY:</label>
                          <input type="text" class="form-control" id="notedBy" value="Christine G. Nepomuceno" placeholder="Provide Name"  name="notedBy" autocomplete="nope" >
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">CHECKED BY</label>
                          <input type="text" class="form-control" id="checkedBy" value="Irish T. Canete" placeholder="Provide Name"  name="checkedBy" autocomplete="nope" >
                  </div>


                  <div class="col-sm-12 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="ftitle" name="ftitle" autocomplete="nope" value="PDR WRITTEN OFF:">
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6">YEAR</label>
                          <input type="text" class="form-control" id="f1" name="f1" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6">AMOUNT</label>
                          <input type="text" class="form-control" id="amount1" name="amount1" autocomplete="nope" >
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f2" name="f2" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount2" name="amount2" autocomplete="nope" >
                  </div>
                  
                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f3" name="f3" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount3" name="amount3" autocomplete="nope" >
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f4" name="f4" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount4" name="amount4" autocomplete="nope" >
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f5" name="f5" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount5" name="amount5" autocomplete="nope" >
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f6" name="f6" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount6" name="amount6" autocomplete="nope">
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="f7" name="f7" autocomplete="nope">
                  </div>
                      

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="amount7" name="amount7" autocomplete="nope">
                  </div>

                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="ftotal" name="ftotal" value="TOTAL" autocomplete="nope">
                  </div>
                  
                  <script>
                    // Get the input element by its ID
                    const inputField = document.getElementById('ftitle');

                    // Add an event listener to the input field
                    inputField.addEventListener('input', function() {
                      // Check if the input field is empty
                      if (inputField.value.trim() === '') {
                        // If it's empty, remove the value attribute
                        inputField.removeAttribute('value');
                      } else {
                        // If it's not empty, set the value attribute with the input's value
                        inputField.setAttribute('value', inputField.value);
                      }
                    });
                  </script>


                  <div class="col-sm-6 form-group">
                          <label for="input-6"></label>
                          <input type="text" class="form-control" id="totalamount" name="totalamount" autocomplete="nope">
                  </div>
                  
                 

                  </div>



                    </div>
                    <div class="modal-footer">
                            <button type="submit"  class="btn btn-primary summaryOfBadAccounts2"><i class="fa fa-print"></i>PRINT</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                       
                        ?>
            </div>
            </div>

            <!-- END ADD REPORT CORRESPONDENTs MODAL -->

       
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deletePastDue = new ControllerPastdue();
  $deletePastDue  -> ctrDeletePastdue();
  
?>