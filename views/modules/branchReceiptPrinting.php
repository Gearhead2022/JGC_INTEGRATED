
<style>
  .modal-content {
    width: 1000px;
   
} 

</style>

<?php
// Enable error reporting and logging
// error_reporting(E_ALL);
// ini_set('log_errors', 'On');
// ini_set('error_log', 'log.txt');

// // Set the maximum file size for the error log
// ini_set('log_errors_max_size', '10M');

// // Set the error log file permissions
// chmod('views/modules/log.txt', 0644);

// Your PHP code here



?>

<!-- Filtering List of collection with description in every collection date directly from the SQL database.. -->
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">RECEIPT PRINTING</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row"> 
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='branchCollectionReceipt'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>

            </div>    
            <div class="row mt-3 ml-2">
              <div class="col-1.2">
                    <label for="inputIdNo" class="col-form-label">COLLECTION DATE :</label>
              </div>
              <div class="col-2">
                  <input type="date" class="form-control collDate" id="collDate"  placeholder="Enter Date"  name="collDate" autocomplete="nope" required>
              </div>
                <div class="col-sm-2 form-group">  
                  <button type="button" name="generateReceiptList" class="btn btn-light btn-round waves-effect waves-light m-1 generateReceiptList"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                </div>
                <div class="col-sm-2 form-group">  
                </div>

                <div class="col-sm-2 form-group">  
                  <button type="button"  class="btn btn-info btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#batchPrint"><i class="fa fa-print"></i> <span>&nbsp;BATCH PRINT</span> </button>
                </div>
            </div>        
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped receiptPrinting">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>DATE PROCESSED</th>
                  <th>NAME</th>
                  <th>COLLECTED</th>
                  <th>NET OF VAT</th>
                  <th>VAT</th>
                  <th>COLLECTION DATE</th>
                  <th>TTIME</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->

        <!-- EDIT PRINT RECEIPT MODAL -->
      <div class="modal fade" id="printReceipts"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="background-color: 	#696969;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">PRINT INDIVIDUAL RECEIPTS</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
              
               
               
              </div>
              <div class="modal-footer">
                   <!-- For ELC OR FORMAT-->
              <?php

                    $allowedBranches = [ "FCH SILAY", "FCH BAGO" , "FCH BINALBAGAN", "FCH HINIGARAN", "FCH PARANAQUE", "FCH MUNTINLUPA"];
          
                    if ($_SESSION['type']=="backup_user" && $_SESSION['branch_name']=="ELC BULACAN" ) { ?>

                    <button type="button" name="printELCORFormat" id="printELCORFormat" class="btn btn-info printELCORFormat">PRINT</button>
                    <button type="button" name="printELCORFormat2" id="printELCORFormat2" class="btn btn-success printELCORFormat2">PRINT NEW FORMAT</button>

                    <!-- For M2 AND SAN CARLOS OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB MAIN BRANCH") {?>

                      <button type="button" name="printM2ORFormat" id="printM2ORFormat" class="btn btn-success printM2ORFormat">PRINT 1</button>
                      <button type="button" name="printM2SecORFormat" id="printM2SecORFormat" class="btn btn-success printM2SecORFormat">PRINT 2</button>
                      
                       <!-- For EMB LA CARLOTA OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB LA CARLOTA") {?>

                    <button type="button" name="printLACORFormat" id="printLACORFormat" class="btn btn-danger printLACORFormat">PRINT</button>
                       <!-- For EMB SAN CARLOS OR FORMAT-->
                       
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB SAN CARLOS") {?>

                    <button type="button" name="printSCAORFormat" id="printSCAORFormat" class="btn btn-danger printSCAORFormat">PRINT</button>
                  
                    <!-- For EMB MAMBUSAO OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB MAMBUSAO") {?>

                    <button type="button" name="printMAMORFormat" id="printMAMORFormat" class="btn btn-info printMAMORFormat">PRINT</button>
                
                    <!-- For FCH OR FORMAT-->
                   <?php } elseif ($_SESSION['type'] == "backup_user" && in_array($_SESSION['branch_name'], $allowedBranches)) {?>

                   <button type="button" name="printFCHORFormat" id="printFCHORFormat" class="btn btn-success printFCHORFormat">PRINT</button>

                   <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="FCH BACOLOD") {?>

                      <button type="button" name="printFCHORBACFormat" id="printFCHORBACFormat" class="btn btn-success printFCHORBACFormat">PRINT</button>

                     <!-- For EMB TOLEDO OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB TOLEDO") {?>

                      <button type="button" name="printTOLORFormat" id="printTOLORFormat" class="btn btn-info printTOLORFormat">PRINT</button>
                      
                    <!-- For FCH MURCIA OR FORMAT-->
                  <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="FCH MURCIA") {?>

                  <button type="button" name="printFCHMURCIAORFormat" id="printFCHMURCIAORFormat" class="btn btn-info printFCHMURCIAORFormat">PRINT</button>
                  
                    <!-- For ALL OR FORMAT-->
                    <?php } else{ ?>

                      <button type="button" name="printOROldFormat" id="printOROldFormat" class="btn btn-warning printOROldFormat">PRINT OLD FORMAT</button>
                      <button type="button" name="printOR" id="printOR" class="btn btn-primary printOR">PRINT</button>

                <?php }?>
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </form>

           </div>
        </div>
      </div>
     <!-- END PRINT RECEIPT MODAL -->

            <!-- BATCH PRINT MODAL -->
      <div class="modal fade" id="batchPrint"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content" style="background-color: 	#696969;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">BATCH PRINTING</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body mb-0" style="background-color: gray;">
                  <div class="card">
                  <div class="card-header">
                    <div class="row mt-3 ml-2">
                      <div class="col-1.2">
                            <label for="inputIdNo" class="col-form-label">SELECT COLLECTION DATE :</label>
                      </div>
                      <div class="col-6">
                          <input type="date" class="form-control" id="batch_coll_date" name="batch_coll_date"  placeholder="Enter Date" autocomplete="nope" required>
                      </div>
                      <div class="col-3">
                          <input type="hidden" class="form-control" name="batch_branch_name" id="batch_branch_name"  placeholder="Enter Date" value="<?php echo $_SESSION['branch_name'] ?>" autocomplete="nope" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                    <!-- For ELC BATCH OR FORMAT-->
                    <?php
                    if ($_SESSION['type']=="backup_user" && $_SESSION['branch_name']=="ELC BULACAN" ) {?>

                    <button type="button" name="printBatchELCORFormat" id="printBatchELCORFormat" class="btn btn-info printBatchELCORFormat">PRINT</button>
                    <button type="button" name="printBatchELCORFormat2" id="printBatchELCORFormat2" class="btn btn-success printBatchELCORFormat2">PRINT NEW FORMAT</button>

                    <!-- For M2 AND SAN CARLOS BATCH OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name'] == "EMB MAIN BRANCH") {?>

                   <button type="button" name="printBatchM2ORFormat" id="printBatchM2ORFormat" class="btn btn-success printBatchM2ORFormat">PRINT 1</button>
                    <button type="button" name="printBatchM2SecORFormat" id="printBatchM2SecORFormat" class="btn btn-success printBatchM2SecORFormat">PRINT 2</button>
                    
                      <!-- For M2 AND SAN CARLOS BATCH OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB LA CARLOTA") {?>

                    <button type="button" name="printBatchLACORFormat" id="printBatchLACORFormat" class="btn btn-danger printBatchLACORFormat">PRINT</button>
                    
                     <!-- For M2 AND SAN CARLOS BATCH OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB SAN CARLOS") {?>

                    <button type="button" name="printBatchsCAORFormat" id="printBatchsCAORFormat" class="btn btn-danger printBatchsCAORFormat">PRINT</button>
                    
                     <!-- For MAMBUSAO BATCH OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB MAMBUSAO") {?>

                    <button type="button" name="printBatchMAMORFormat" id="printBatchMAMORFormat" class="btn btn-info printBatchMAMORFormat">PRINT</button>
                    
                         <!-- For FCH OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && in_array($_SESSION['branch_name'], $allowedBranches)) {?>

                     <button type="button" name="printBatchFCHORFormat" id="printBatchFCHORFormat" class="btn btn-success printBatchFCHORFormat">PRINT</button>

                     <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="FCH BACOLOD") {?>

                      <button type="button" name="printBatchFCHORBACFormat" id="printBatchFCHORBACFormat" class="btn btn-success printBatchFCHORBACFormat">PRINT</button>
                     
                          <!-- For TOLEDO BATCH OR FORMAT-->
                     <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="EMB TOLEDO") {?>

                      <button type="button" name="printBatchTOLORFormat" id="printBatchTOLORFormat" class="btn btn-info printBatchTOLORFormat">PRINT</button>
                      
                        <!-- For FCH MURCIA OR FORMAT-->
                    <?php } elseif ($_SESSION['type'] == "backup_user" && $_SESSION['branch_name']=="FCH MURCIA") {?>

                      <button type="button" name="printBatchFCHMURCIAORFormat" id="printBatchFCHMURCIAORFormat" class="btn btn-info printBatchFCHMURCIAORFormat">PRINT</button>


                    <!-- For ALL BATCH OR FORMAT-->
                    <?php }else{?>
                      
                    <button type="button" name="batchPrintOROldFormat" id="batchPrintOROldFormat" class="btn btn-warning batchPrintOROldFormat">PRINT OLD FORMAT</button>
                    <button type="button" name="batchPrintOR" id="batchPrintOR" class="btn btn-primary batchPrintOR">PRINT</button>

                    <?php }
                ?>
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </form>
           </div>
        </div>
      </div>
     <!-- END BATCH PRINT MODAL -->

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $delete_pin = new ControllerORPrinting();
  $delete_pin  -> ctrDeleteBIRRECRecord();
  
?>




  
