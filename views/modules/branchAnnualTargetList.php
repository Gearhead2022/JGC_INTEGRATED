
<?php 

 
  $branch_list = new ControllerOperation();
 $branch = $branch_list->ctrShowBranches1();

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
          <h4 class="page-title">MONTH SALES PERFORMANCE</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">   
            <div class="row">
                
                <button type="button" class="btn btn-light btn-round waves-effect waves-light ml-1" onClick="window.location.href='operationSP'"><i class="fa fa-arrow-left"></i> <span>&nbsp;Back</span></button>
                
                <?php if($_SESSION['type']=="operation_admin" ){?>
                
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addPensionerAccounts"><i class="fa fa-plus"></i> <span>&nbsp;ADD ANNUAL TARGET</span> </button>
                  <?php } ?>     
                </div>    
    
<!-- 
                generateSalesPerformanceReport -->
                
           
           
            <div class="card-body">
             <div class="table-responsive" >
              <table class="table table-bordered table-hover table-striped showTableBranchAnnualTargetlist">
              <thead>
           
                <tr>
                  <th>Branch Name</th>
                  <th>Annual Target</th>
                  <th>Year Encoded</th>
                  <th>Actions</th>
                </tr>
                </thead>
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
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD ANNUAL TARGET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                    <div class="row">
                         <div class="col-sm-10 form-group">
                            <label   label for="input-6">SELECT BRANCH</label>
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
                        </div.
                     <div class="row">
                      <div class="col-sm-6 form-group">
                      <label for="year">Select a Year:</label>
                      <select name="year" id="year" class="form-control">
                          <?php
                              // Get the current year
                              date_default_timezone_set('Asia/Manila');
                              $currentYear = date("Y", time());

                              // Define a range of years (e.g., from current year - 10 to current year + 10)
                              $startYear = $currentYear - 10;
                              $endYear = $currentYear + 10;

                              // Loop through the range of years
                              for ($year = $startYear; $year <= $endYear; $year++) {
                                  // Check if the current year matches the loop year and set selected attribute
                                  $selected = ($year == $currentYear) ? "selected" : "";
                                  echo "<option value='$year' $selected>$year</option>";
                              }
                          ?>
                      </select>
                  </div>
                  <div class="col-sm-6 form-group">
                          <label for="input-6">TARGET</label>
                          <input type="text" class="form-control" name="target" id="target" placeholder="">
                      </div>  
                  </div>
                  <div class="modal-footer">
                          <button type="submit" name ="addAnnualTarget" class="btn btn-primary">Submit</button>
                          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </div>
              </form>
              <?php
                     $add_target = new ControllerPensioner();
                     $add_target -> ctrAddBranchAnnualTarget();
                    ?>
           </div>
        </div>
     <!-- SALES MODAL -->

              <!-- SALES MODAL -->

              <div class="modal fade" id="editAnnualTarget" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT ANNUAL TARGET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body" id="editPensionerAccounts">
              
               
               
              </div>
              </form>
              <?php
                     $edit_annual = new ControllerPensioner();
                     $edit_annual -> ctrEditBranchAnnualTarget();
                    ?>
            
           </div>
        </div>
     <!-- SALES MODAL -->

</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
<?php
  $delete_target = new ControllerPensioner();
  $delete_target -> ctrDeleteBranchAnnualTarget();
 ?>



  
