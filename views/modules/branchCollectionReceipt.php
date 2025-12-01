
<style>
  .modal-content {
    width: 1000px;
   
} 

</style>

<!-- Filtering List of collection in every collection date directly from the DBF file.. -->
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">PREPARE RECORDS</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
             
              <div class="row mt-2 ml-2">
          
                <div class="col-2.1">
                    <label for="inputIdNo" class="col-form-label">SPECIFY ENCODED DATE :</label>
                </div>
                <div class="col-2">
                <input type="date" class="form-control collDate" id="collDate"  placeholder="Enter Date"  name="collDate" autocomplete="nope" required>
                </div>
                       
                <div class="col-sm-2 form-group">  
                  <button type="button" name="generateList" class="btn btn-light btn-round waves-effect waves-light m-1 generateList"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                </div>

                <div class="col-sm-2 form-group">  
                  <button type="button" onClick="location.href='branchReceiptPrinting'" class="btn btn-light btn-round waves-effect waves-light m-1"><i class="fa fa-print"></i> <span>&nbsp;RECEIPT PRINTING</span> </button>
                </div>

                <div class="col-sm-4 form-group">  
                  <button type="button" class="btn btn-warning btn-round waves-effect btn-md waves-light m-1" data-toggle="modal" data-target="#fileUpdate"><i class="fa fa-refresh"></i> <span>&nbsp;UPDATE</span> </button>
                </div>
 
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped collectionDataList">
                <thead>
                <tr>
                  <th>ACTIOn</th>
                  <th>COLL DATE</th>
                  <th>ID</th>
                  <th>BATCH / REF.</th>
                  <th>MONTH EFF.</th>
                  <th>AMOUNT</th>
                  <th>POSTED</th>
                  <th>PROBLEM CODE</th>
                  <th>BANK NO:</th>
                  <th>BAL. TERM</th>
                  <th>ATM BAL.</th>
                  
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->   

            <!-- ADD BIRREC RECORD MODAL -->
        <div class="modal fade" id="editReceiptPrinting"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content" style="background-color: 	#696969;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">RECEIPT PRINTING INDIVIDUAL FORM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                  <form  method="post" enctype="multipart/form-data" id="yourFormId">
                  <div class="modal-body mb-0" style="background-color: gray;">
    
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addBIRRECRecords" class="btn btn-primary addBIRRECRecords">Submit</button>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </form>
                
            </div>
          </div>
        </div>
          <!-- END ADD BIRREC RECORD MODAL -->  

              <!-- UPDATE FILE MODAL -->
      <div class="modal fade" id="fileUpdate"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                      <!-- <div class="col-1.2">
                            <label for="inputIdNo" class="col-form-label">SELECT COLLECTION DATE :</label>
                      </div> -->
                     <div class="col-12">
                            <label for="or_file">Upload your file:</label>
                            <input type="file" class="form-control" id="or_file" name="or_file" placeholder="Enter Date" autocomplete="nope" required>
                             <!--<medium class="text-white">Local path: <i class="fas fa-file"></i> C:/receipt/</medium>-->
                        </div>
                      <div class="col-3">
                          <input type="hidden" class="form-control" name="or_branch_name" id="or_branch_name"  placeholder="Enter Date" value="<?php echo $_SESSION['branch_name'] ?>" autocomplete="nope" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" name="updateRecord" id="updateRecord" class="btn btn-primary batchPrintOR">SUBMIT</button>
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </form>
              <?php
                      $updateRecord = new ControllerORPrinting();
                      $updateRecord -> ctrUpdateFileRecords();
                ?>
           </div>
        </div>
      </div>
     <!-- END UPDATE FILE MODAL -->
      

      <div class="overlay toggle-menu"></div>
  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
