
<?php 
 $branch_list = new ControllerOperation();
 $branch = $branch_list->ctrShowBranches();

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
          <h4 class="page-title">MONTHLY SALES PERFORMANCE</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">   
            <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="operation_admin" && $_SESSION['username']=="OPERATION"){?>
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onclick="window.location.href='operationSPList';"><i class="fa fa-plus"></i> <span>&nbsp;SALES REPRESENTATIVE LIST</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onclick="window.location.href='branchAnnualTargetList';"><i class="fa fa-list"></i> <span>&nbsp;ANNUAL TARGET LIST</span> </button> </button>
                  <?php } ?>         
                </div>    
              <div class="row">
                <div class="col-sm-2 form-group">
                          <label for="input-6">MONTH END</label>
                          <input type="month" class="form-control monthEnd" id="monthEnd"  placeholder="Enter PRR Date"  name="monthEnd" autocomplete="nope" required>
                  </div>

                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="generateSalesPerformanceReport" class="btn btn-light btn-round waves-effect waves-light m-1 generateSalesPerformanceReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                      
                </div> 
<!-- 
                generateSalesPerformanceReport -->
                
           
           
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printSalesPerformanceReport"  class="btn btn-light btn-round waves-effect waves-light m-1 " data-toggle="modal" data-target="#addCorrespondentForSPModal" hidden ><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>

             <div id="showTableSalesPerformanceReport" class="table-responsive" >
              <table class="table table-bordered table-hover table-striped showTableSalesPerformanceReport">
              
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
   
     <div class="modal fade" id="addPensionerAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD PENSIONER ACCOUNTS</h5>
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
                      <option value="EMB ISABELA">EMB ISABELA</option>
                      
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
                    <div class="col-sm-6 form-group">
                        <label for="input-6">ACCOUNTS IN</label>
                        <input type="number" class="form-control" name="accnt_in" id="accnt_in" placeholder="Enter First Name">
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">ACCOUNTS OUT</label>
                        <input type="number" class="form-control" name="accnt_out" id="accnt_out" placeholder="Enter Last Name">
                    </div>  
            </div> 
            <div class="col-sm-6 form-group">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control" name="date_encode" id="date_encode" placeholder="Enter Last Name">
                    </div>  
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addAccntPensioner" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $add_rep = new ControllerPensioner();
                     $add_rep -> ctrAddAccountpensioners();
                    ?>
           </div>
        </div>
     <!-- SALES MODAL -->

            <!-- ADD REPORT CORRESPONDENTs MODAL -->

            <div class="modal fade" id="addCorrespondentForSPModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                          <label for="input-6">PREPARED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="preparedSPBy" autocomplete="nope">GLORY MAE D. JUNTADO</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">CHECKED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="checkedSPBy" autocomplete="nope">HERBIE G. ARAGON
                          SALES OPERATIONS MANAGER</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">NOTED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="notedSPBy" autocomplete="nope">DONALD M. JAMERO
                          C.O.O</textarea>
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
                  
                      $addSPCorrespondents = new ControllerPensioner();
                      $addSPCorrespondents->ctrAddSPReportCorrespondent();
    
                  ?>
            </div>
            </div>

            <!-- END ADD REPORT CORRESPONDENTs MODAL -->
      
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
