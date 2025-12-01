
<?php

$ins = (new ControllerInsurance);
$branches = $ins->ctrShowBranches();

?>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">FULLY PAID LIST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" ){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='fullypaidadd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD RECORDS</span> </button>
              <?php  }?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 btnPrintFullyPaid"><i class="fa fa-print"></i> <span>&nbsp;SUMMARY REPORT</span> </button>
                      <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='fullpaidreport'"><i class="fa fa-print"></i> <span>&nbsp;GENERATE REPORT</span> </button>
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="fullypaid_admin" ){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1"  data-toggle="modal" data-target="#generateFullyPaid"><i class="fa fa-print"></i> <span>&nbsp;FILTER REPORT</span> </button>
              <?php  }?>

                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
                    <!-- <div class="input-group">
                      <select class="form-control" id="clientCategory" name="clientCategory">
                        <option value="" selected hidden>&lt;Select Category&gt;</option>
                        <option value="Regular">Regular</option>
                        <option value="Walk-in">Walk-in</option>
                        <option value="VIP">VIP</option>
                      </select>
 
                      <div class="input-group-append">
                        <button class="btn btn-light" type="button" id="clrCategory"><i class="fa fa-undo"></i> </button>
                      </div>  
                    </div> -->
              </div>
            </div>            

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped fullpaidTable">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Branch Name</th>
                  <th>OUT DATE</th>
                  <th>BANK</th>
                  <th>STATUS</th>
                  <th>PRR No.</th>
                  <th>PRR Date</th>
                  <th>ATM STATUS</th>
                  <th>Date Claimed</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      
      </div>    <!-- row -->
      <div class="modal" id="empModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data"  autocomplete="off">
          <div class="modal-header">
            <h4 class="modal-title">Clients Profile</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <div class="modal-body">
                  
        </div>
      </div>
      </form>
      </div>
   </div>
             
 <!-- START modal for add beginning balance-->
<div class="modal fade" id="generateFullyPaid" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">GENERATE REPORT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form  method="post" enctype="multipart/form-data"> -->
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <label label for="input-6">SELECT BRANCH</label>
                        <select class="form-control" name="branch_name" id="branch_name" required>
                            <option value=""><  - - SELECT BRANCHES - - ></option>
                            <?php
                            foreach ($branches as $key => $row) {
                                # code...
                                $branch_name = $row['branch_name'];
                            ?>
                                <option value="<?php echo $branch_name; ?>"><?php echo $branch_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="input-6">FROM</label>
                        <input type="date" class="form-control" id="dateFrom" placeholder="Enter Folder Name" name="dateFrom" autocomplete="nope" required>
                    </div> 
                    <div class="col-sm-2">
                        <label for="input-6">TO</label>
                        <input type="date" class="form-control" id="dateTo" placeholder="Enter Folder Name" name="dateTo" autocomplete="nope" required>
                    </div>
                     <div class="col-sm-3">
                     <label for="input-6">Status</label>
                      <select class="form-control reportStatus" id="reportStatus" name="clientCategory">
                        <option value="" >&lt;Select Status&gt;</option>
                        <option value="Claimed">Claimed</option>
                        <option value="Unclaimed">Unclaimed</option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="filterFullyPaidReport" id="filterFullyPaidReport" class="btn btn-primary filterFullyPaidReport">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- </form> -->
    </div>
</div>
<!-- END modal for add beginning balance-->
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $deleteRecord = new ControllerFullypaid();
  $deleteRecord  -> ctrDeleteRecord();
 
?>