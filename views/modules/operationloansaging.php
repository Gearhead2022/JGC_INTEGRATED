<?php 
$full_name = $_SESSION['branch_name'];
$currentDate = date("Y-m-d");
$previousDate = date("Y-m-d", strtotime("-1 day"));
$dayRep = strtoupper(date("F d", strtotime($currentDate)));
$Operation = new ControllerOperation();


  $branch_list = new ControllerOperation();
 $branch = $branch_list->ctrShowBranches1();

?> 
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
          <h4 class="page-title">LOANS RECEIVABLE AGING</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin" || $_SESSION['type']=="operation_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addDataModal"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATA</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#opMonthlyBreakModal"><i class="fa fa-print"></i> <span>&nbsp;MONTHLY REPORT</span> </button>
                <?php  }?>
                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
            <hr />
               <h4 class="page-title ml-2">RECEIVABLE AGING</h4>
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped agingTable">
                <thead>
                <tr> 
                  <th>Branch Name</th>
                  <th>Date</th>
                  <th>TOTAL SPP</th>
                  <th>TOTAL SL</th>
                  <th>TOTAL LR</th>
                  <th>ACTION</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      </div> 

  

   

  <!-- START modal for add beginning balance-->
      <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post"  enctype="multipart/form-data">
                <div class="row">
                <div class="col-sm-6 form-group">
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
                <div class="col-sm-6 form-group">
                      <label for="input-6">SELECT DATE</label>
                      <input type="month" class="form-control" id="date" required placeholder="Enter Folder Name" name="date">
                </div>
                    <div class="col-sm-12 mt-2">
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" required placeholder="Enter Folder Name" name="file" value="Import">
                    </div>
                          
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addAging" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                    $Operation -> ctrAddLoansAging();
                    ?>
           </div>
        </div>
    


           <!-- START MONTHLY BREAKDOWN REPORT MODAl-->
           <div class="modal fade" id="opMonthlyBreakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">GENERATE MONTHLY BREAKDOWN REPORT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
         
                <div class="row">
                <div class="col-sm-4 form-group">
                      <label for="input-6">SELECT MONTH</label>
                      <input type="month" class="form-control mntTo" id="mntTo" placeholder="Enter Folder Name" name="date">
                </div>
               <div div class="col-sm-4 form-group">
                      <label for="input-6">PREPARED BY: </label>
                      <input type="text" class="form-control preBy" id="preBy" placeholder="Enter Prepared By" name="date">
                </div>  
                <div class="col-sm-4 form-group mt-4">
                  <button type="button"  class="btn btn-primary opLoansAging">GENERATE</button>
                </div> 
           
                </div>
                <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
           </div>
        </div>
         <!-- END MONTHLY BREAKDOWN REPORT MODAl-->



    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 

  $Operation  -> ctrDeleteLoanAging();
  
?>


  
