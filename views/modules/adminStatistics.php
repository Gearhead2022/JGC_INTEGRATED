
<style>
  .modal-content {
    width: 1000px;
    margin-left: -221px;
}
.table-border{
    border:1px solid white;
    padding:.4rem;
}
table, tr ,th{
  text-align:center
}
table, tr, td{
  text-align:center;
}
</style>

<?php

require_once "models/connection.php";
$connection = new connection;
$connection->connect();
?>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">ADMIN STATISTICS</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-header float-sm-right">
         
            <div class="row">
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE FROM</label>
                        <input type="date" class="form-control penDateFrom" id="penDateFrom"  placeholder="Enter Date"  name="penDateFrom" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE TO</label>
                        <input type="date" class="form-control penDateTo" id="penDateTo"  placeholder="Enter Date"  name="penDateTo" autocomplete="nope" required>
                </div>
                
                <div class="col-sm-2 form-group">
                        <label for="input-6">BEGINNING BALANCE</label>
                        <input type="month" class="form-control penBegBal" id="penBegBal"  placeholder="Enter Date"  name="penBegBal" autocomplete="nope" required>
                </div>
                  
                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="adminGeneratePensionerReport" class="btn btn-light btn-round waves-effect waves-light m-1 adminGeneratePensionerReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                    
                </div>   
           
              
                <div class="card-body">
              <div class="float-right">
                  <button type="button" id="printAdminPensionerReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1 printAdminPensionerReport"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                </div>
            
              <div id="adminShowTablePensionReport" class="table-responsive" hidden>
              <table class="table table-bordered table-hover table-striped ">
              <thead>          
              <tr>         
                        <th colspan="2"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="table-border" id="header-date-1" colspan="3"></th>
                        <th class="table-border" id="header-date-2" colspan="3"></th>
                        <th class="table-border" id="header-date-3" colspan="3"></th>
                        <th class="table-border" id="header-date-4" colspan="3"></th>
                        <th class="table-border" id="header-date-5" colspan="3"></th>
                        <th></th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center;">TOTAL</th>
                        
                    </tr>   

                    <tr>
                        <th colspan="2"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="table-border" colspan="3">Monday</th>
                        <th class="table-border" colspan="3">Tuesday</th>
                        <th class="table-border" colspan="3">Wednesday</th>
                        <th class="table-border" colspan="3">Thursday</th>
                        <th class="table-border" colspan="3">Friday</th>
                        <th></th>
                        <!-- <th class="table-border" colspan="4"></th> -->
                        
                    </tr>   

                    <tr>
                        <th colspan="2" class="table-border" style="text-align:center;">BRANCH</th>
                        <th style="visibility:hidden;">sdf</th>
                        <th class="table-border" id="header-date-6"></th>
                        <th class="table-border">BEG</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">End. bal</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">End. bal</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">bal</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">End. bal.</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">End. bal</th>
                        <th style="visibility:hidden;">DFD</th>
                        <th class="table-border">In</th>
                        <th class="table-border">Out</th>
                        <th class="table-border">Net</th>
                        <th class="table-border">BALANCE</th>
                    </tr>   

                    <tr>
                        <td colspan="26" style="visibility:hidden;border:none;">sdfsdf</td>
                    </tr>
                    </thead>
                    <tbody class="adminReportPensionerTable">
                        
                    </tbody>
                    </table>
                </div>

  

      

</div>

</div>
<div class="modal" id="pensionerAddModal" style="background color:" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data"  autocomplete="off">
          <div class="modal-header">
            <h4 class="modal-title">ADD PENSIONER</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <div class="modal-body">
        <div class="col-sm-7 form-group">

        <input type="text" class="form-control" value="<?php echo $_SESSION['branch_name'];?>" id="branch_name"  placeholder="Enter Number"  name="branch_name" autocomplete="nope" required>
               
        </div>
        <div class="col-sm-7 form-group">
        <label for="input-6">INSURANCE TYPE</label>
        <select  class="form-control" name="penInsurance" id="penInsurance" required>
            <option value="" selected disabled>SELECT TYPE</option>
            <option value="GSIS" >GSIS</option>
            <option value="SSS" >SSS</option>
        </select>
        </div>
        <div class="row p-3">
            <div class="col-4">
                <div class="form-group">
                    <label for="input-6">IN</label>
                    <input type="number" class="form-control" id="penIn"  placeholder="Enter IN"  name="penIn" autocomplete="nope" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="input-6">OUT</label>
                    <input type="number" class="form-control" id="penOut"  placeholder="Enter OUT"  name="penOut" autocomplete="nope" required>
                </div>
            </div>

        </div>
        <div class="col-sm-7 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control dateFrom" id="penDate"  placeholder="Enter Date"  name="penDate" autocomplete="nope" required>
        </div>
                  
        </div>
        <div class="modal-footer">
                <button type="submit" name="addPensioner" class="btn btn-primary">Submit</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
      <?php
            $addPensioner = new ControllerPensioner();
            $addPensioner -> ctrAddPensioner();
        ?>
      </div>
   </div>
</div>
</div>

      
    </div>    <!-- row -->
</div>


    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
//   $deleteAccount = new ControllerAccounts();
//   $deleteAccount  -> ctrDeleteAccount();
 
?>