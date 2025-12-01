
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
          <h4 class="page-title">MONTHLY SALES PERFORMANCE</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">   
            <div class="row">
                <?php if($_SESSION['type']=="backup_user" ){?>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addSalesRepresentative"><i class="fa fa-plus"></i> <span>&nbsp;ADD SALES REPRESENTATIVE</span> </button> -->
              
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addPensionerAccounts"><i class="fa fa-plus"></i> <span>&nbsp;ADD ANNUAL TARGET</span> </button> -->

                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onclick="window.location.href='branchAnnualTargetList';"><i class="fa fa-list"></i> <span>&nbsp;ANNUAL TARGET LIST</span> </button> -->
                  <?php } ?>         
                </div>    
              <div class="row">
                <div class="col-sm-2 form-group">
                          <label for="input-6">MONTH END</label>
                          <input type="month" class="form-control monthEnd" id="monthEnd"  placeholder="Enter PRR Date"  name="monthEnd" autocomplete="nope" required>
                  </div>

                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="generateSalesPerformanceReport" class="btn btn-light btn-round waves-effect waves-light m-1 generateBranchSalesPerformanceReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                      
                </div> 
<!-- 
                generateSalesPerformanceReport -->
                
           
           
            <div class="card-body">
             <div class="table-responsive" id="showTableBranchSalesPerformanceReport" hidden>
              <table class="table table-bordered table-hover table-striped">
              <thead>
           
                <tr>
                  <th >Branch Name</th>
                  <th >Sales Representative</th>
                  <th  id="header-date-6"></th>
                  <th  id="header-date-7"></th>
                  <th  id="header-date-8"></th>
                  <th >gross in</th>
                  <th >agents in</th>
                  <th id="header-date-9" style="text-align:center;"></th>
                  <th id="header-date-10" style="text-align:center;"></th>
                  <th id="header-date-11" style="text-align:center;"></th>
                  <th >% vs TARGET</th>
                  <th >ANNUAL <br> TARGET</th>
                </tr>
                </thead>
                <tbody class="reportableBranchSalesPerformance"></tbody>
              
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
