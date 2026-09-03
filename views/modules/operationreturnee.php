<?php 
 
      $user_id = $_SESSION['user_id'];
      $branch_name = $_SESSION['branch_name'];
?> 
<style>
</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">FULLY PAID & RETURNEE RATE REPORT</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
              <!-- <div class="col-sm-2 form-group">
                        <label for="input-6">SELECT MONTH</label>
                        <input type="month" class="form-control dateFrom" id="date"  placeholder="Enter PRR Date"  name="date" autocomplete="nope" >
                </div> -->
                <div class="col-sm-2 form-group">
                        <label for="input-6">SELECT MONTH</label>
                        <input type="month" class="form-control month" id="month"  placeholder="Enter PRR Date"  name="month" autocomplete="nope" >
                </div>
                <div class="col-sm-3 form-group">
                 <label   label for="input-6">TYPE</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value=""><  - - SELECT TYPE - - ></option>
                        <option value="returnee">RETURNEE RATE</option>
                        <option value="fullypaid">FULLY PAID RATE</option>
                        <option value="fprt">FULLY PAID & RETURNEE RATE</option>
                    </select>
                 </div>  
                <div class="col-sm-4 form-group">
                      <label for="input-6">PREPARED BY: </label>
                      <input type="text" class="form-control preBy" id="preBy" placeholder="Enter Prepared By" name="date">
                </div> 
                <div class="col-sm-2 form-group mt-4">
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 btnReturneeReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>

                </div>
                  
            </div>  
            </div>          
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printOperationLsorReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printOperationLsorReport "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>


              <div id="operationTable" class="table-responsive">
              <table class="table table-bordered table-hover table-striped operationLsorReport">
                
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