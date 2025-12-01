
<style>
  .modal-content {
    width: 1000px;
   
} .addBox {
    border-color: white;

    border-style: groove;
}
#per{
    font-size: 10px;
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">FILTER DAILY AVAILMENTS</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
            <div class="row">
                <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT DATE</label>
                      <input type="date" class="form-control monthEnd" id="avl_date"  placeholder="Enter Date"  name="avl_date" autocomplete="nope" required>
              </div>
                <div class="col-sm-2 form-group mt-4">
                  <button type="button" name="generateDailyAvailments" class="btn btn-light btn-round waves-effect waves-light m-1 generateBranchDailyAvailments"><i class="fa fa-repeat"></i> <span>&nbsp;GENERATE</span> </button>
                </div>
              </div>           
            <div class="card-body">   
                <div class="row">  
                <hr />
                <div class="float-right">
                    <button type="button" id="branchDailyAvailmentsReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1 branchDailyAvailmentsReport"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                </div>
                    <div id="operationDailyAvailmentsTable" class="table-responsive" >
                        <table class="table table-bordered table-hover table-striped operationDailyAvailmentsTable">
                
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div> 
    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 
//   $Operation  -> ctrDeleteLoanAging();
  
?>


  
