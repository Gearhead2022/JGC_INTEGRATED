
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
          <h4 class="page-title">WEEKLY PENSIONER</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
      
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onclick="window.location.href='branchPensionerList';"><i class="fa fa-plus"></i> <span>&nbsp;PENSIONER ACCOUNTS LIST</span> </button>
              </div>
         
            <div class="row">
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE FROM</label>
                        <input type="date" class="form-control penDateFrom" id="penDateFrom"  placeholder="Enter Date"  name="penDateFrom" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE TO</label>
                        <input type="date" class="form-control penDateTo" id="penDateTo"  placeholder="Enter Date"  name="penDateTo" autocomplete="nope" required>
                </div>
                
                <!-- <div class="col-sm-2 form-group">
                        <label for="input-6">BEGINNING BALANCE</label>
                        <input type="month" class="form-control penBegBal" id="penBegBal"  placeholder="Enter Date"  name="penBegBal" autocomplete="nope" required>
                </div> -->
                  
                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="generatePensionerReport" class="btn btn-light btn-round waves-effect waves-light m-1 generatePensionerReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                      
                </div>   
           
              
              <div class="row">  
         
           
              <div id="showTablePensionReport" class="table-responsive" hidden>
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
                        <th class="table-border " id="day_one" colspan="3">Monday</th>
                        <th class="table-border " id="day_two" colspan="3">Tuesday</th>
                        <th class="table-border " id="day_three" colspan="3">Wednesday</th>
                        <th class="table-border " id="day_four" colspan="3">Thursday</th>
                        <th class="table-border " id="day_five" colspan="3">Friday</th>
                        <th></th>
                        <!-- <th class="table-border" colspan="4"></th> -->
                        
                    </tr>   

                    <tr>
                        <th colspan="2" class="table-border" style="text-align:center;">BRANCH</th>
                        <th style="visibility:hidden;">sdf</th>
                        <th class="table-border" id="header-date-6"></th>
                        <th class="table-border">BEG</th>
                        <th class="table-border" id="d_i1" >In</th>
                        <th class="table-border" id="d_i2" >Out</th>
                        <th class="table-border" id="d_i3" >End. bal</th>
                        <th class="table-border" id="d_i4" >In</th>
                        <th class="table-border" id="d_i5" >Out</th>
                        <th class="table-border" id="d_i6" >End. bal</th>
                        <th class="table-border" id="d_i7" >In</th>
                        <th class="table-border" id="d_i8" >Out</th>
                        <th class="table-border" id="d_i9" >End. bal</th>
                        <th class="table-border" id="d_i10" >In</th>
                        <th class="table-border" id="d_i11" >Out</th>
                        <th class="table-border" id="d_i12" >End. bal.</th>
                        <th class="table-border" id="d_i13" >In</th>
                        <th class="table-border" id="d_i14" >Out</th>
                        <th class="table-border" id="d_i15" >End. bal</th>
                        <th style="visibility:hidden;">DFD</th>
                        <th class="table-border">In</th>
                        <th class="table-border" >Out</th>
                        <th class="table-border" >Net</th>
                        <th class="table-border" >BALANCE</th>
                    </tr>   

                    <tr>
                        <td colspan="26" style="visibility:hidden;border:none;">sdfsdf</td>
                    </tr>
                    </thead>
                    <tbody class="reportPensionerTable">
                        
                    </tbody>
                    </table>
                </div> 
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