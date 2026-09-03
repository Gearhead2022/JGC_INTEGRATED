
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
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE FROM</label>
                        <input type="date" class="form-control penDateFrom" id="penDateFrom"  placeholder="Enter Date"  name="penDateFrom" autocomplete="nope" required>
                </div>
                <div class="col-sm-2 form-group">
                        <label for="input-6">DATE TO</label>
                        <input type="date" class="form-control penDateTo" id="penDateTo"  placeholder="Enter Date"  name="penDateTo" autocomplete="nope" required>
                </div>
<!--                 
                <div class="col-sm-2 form-group">
                        <label for="input-6">BEGINNING BALANCE</label>
                        <input type="month" class="form-control penBegBal" id="penBegBal"  placeholder="Enter Date"  name="penBegBal" autocomplete="nope" required>
                </div> -->

                <div class="col-sm-2 form-group">
                <label for="input-6">BRANCH</label>
                <select  class="form-control" name="branchName" id="branchName" required>
                    <option value="" selected disabled>SELECT BRANCH</option>
                    <option value="EMB" >EMB</option>
                    <option value="FCH" >FCH</option>
                    <option value="ELC" >ELC</option>
                    <option value="RLC" >RLC</option>
                </select>
                </div>
                  
                
                      <div class="col-sm-2 form-group mt-4">
                          
                      <button type="button" name="adminGeneratePensionerReport" class="btn btn-light btn-round waves-effect waves-light m-1 adminGeneratePensionerReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                      </div>
                
                    
                </div>   
           
              
                <div class="card-body">
              <div class="float-right">
                  <button type="button" id="printAdminPensionerReport" hidden class="btn btn-light btn-round waves-effect waves-light m-1"  data-toggle="modal" data-target="#addCorrespondentForSPModal"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                </div>
            
              <div id="adminReportPensionerTable" class="table-responsive" >
              <table class="table table-bordered table-hover table-striped adminReportPensionerTable">
             
                    </table>
                </div>
         

  

      

</div>

</div>
<div class="modal" id="pensionerAddModal" tabindex="-1" role="dialog">
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
   <!-- End Add Pensioner -->

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
                          <input type="text" class="form-control penDateFrom_clone"  id="penDateFrom_clone" name="penDateFrom_clone"  autocomplete="nope" >
                    </div>
                    <div class="col-sm-12 form-group">
                          <input type="text" class="form-control penDateTo_clone"  id="penDateTo_clone" name="penDateTo_clone"  autocomplete="nope" >
                    </div>
                    <div class="col-sm-12 form-group">
                          <input type="text" class="form-control branchName_clone"  id="branchName_clone" name="branchName_clone"  autocomplete="nope" >
                    </div>
                   
                   
                    <div class="col-sm-12 form-group">
                          <label for="input-6">PREPARED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="preparedSPBy" autocomplete="nope">Janine Liezel M. Ubal</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">CHECKED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="checkedSPBy" autocomplete="nope">Rhea Mae G. Osano/Agieh V. Esgana
                          SOM/s</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">NOTED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="wp_req_for" placeholder="Provide Name"  name="notedSPBy" autocomplete="nope">Donald M. Jamero
                          C.O.O</textarea>
                  </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                            <button type="submit" name="adminPenPrint" class="btn btn-primary">PRINT</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>
                <?php
                  
                      $addSPCorrespondents = new ControllerPensioner();
                      $addSPCorrespondents->ctrAddPStatReportCorrespondent();
    
                  ?>
            </div>
            </div>

            <!-- END ADD REPORT CORRESPONDENTs MODAL -->
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