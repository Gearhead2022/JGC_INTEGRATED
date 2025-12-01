
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

#default-datatable tr th{
  text-align:center;
  vertical-align: middle;
}
/* Change the color of the date input icon in WebKit browsers */
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(95%); /* Change the color to your desired color */
}

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">    
        <div class="col-sm-12">
          <h4 class="page-title">PENSIONER ACCOUNTS LIST</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
       
          <div class="card">
            <div class="card-header float-sm-right">   
            <div class="row">
           
           <button type="button" id="" style="height:50px;"  class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#pensionerAddModal"><i class="fa fa-plus"></i> <span>&nbsp;ADD PENSIONER</span> </button>
    </div>
   
           
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printSalesPerformanceReport"  class="btn btn-light btn-round waves-effect waves-light m-1 printSalesPerformanceReport" hidden ><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>

             <div id="" class="table-responsive" >
             <table id="default-datatable" class="table table-bordered table-hover table-striped branchPensionerListTable">
                <thead>
                <tr>
                    <th>BRANCH NAME</th>
                    <th>IN</th>
                    <th>OUT<E/th>
                    <th>TYPE<E/th>
                    <th>DATE ENCODED<E/th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>        
      </div>    <!-- row -->

      <!-- ADD PENSIONER -->

      <div class="modal" id="pensionerAddModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data"  autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">ADD PENSIONER</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div class="col-sm-7 form-group">

                    <input type="text" class="form-control" readonly value="<?php echo $_SESSION['branch_name'];?>" id="branch_name"  placeholder="Enter Number"  name="branch_name" autocomplete="nope" required>
                    
                </div>
                <div class="col-sm-7 form-group">
                <label for="input-6">PENSION TYPE</label>
                <select  class="form-control" name="penInsurance" id="penInsurance" required>
                    <option value="" selected disabled>SELECT TYPE</option>
                    <option value="GSIS" >GSIS</option>
                    <option value="SSS" >SSS</option>
                    <?php
                    if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'ELC BULACAN') {?>

                        <option value="PACERS">PACERS</option>
                        <option value="PVAO">PVAO</option>

                    <?php } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC BURGOS'){?>

                        <option value="PVAO">PVAO</option>
                        <option value="PNP">PNP</option>
                        <option value="OLR">OLR</option>
                        <option value="OLR-REAL ESTATE">OLR-REAL <Em></Em>STATE</option>
                        <option value="OLR-HOUSE LOAN">OLR-HOUSE LOAN</option>

                    <?php } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC KALIBO'){?>

                        <option value="PVAO">PVAO</option>
                        <option value="PNP">PNP</option>

                    <?php } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC SINGCANG'){?>

                        <option value="PVAO">PVAO</option>
                        <option value="OLR">OLR</option>
                        <option value="OLR-REAL ESTATE">OLR-REAL ESTATE</option>
                        <option value="OLR-HOUSE LOAN">OLR-HOUSE LOAN</option>
                        <option value="OLR-CHATTEL">OLR-CHATTEL</option>

                    <?php } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC ANTIQUE'){?>

                        <option value="OLR-REAL ESTATE">OLR-REAL ESTATE</option>
                        <option value="PNP">PNP</option>

                    <?php }?>
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

      

      
         <!-- SALES MODAL -->

         <div class="modal fade" id="editBranchPensionerAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT PENSIONER ACCOUNTS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body" id="editPensionerAccounts">

                </div>
                </form>
                <?php
                        $edit_rep = new ControllerPensioner();
                        $edit_rep -> ctrEditPensionerListAccnt();
                        ?>
                
            </div>
            </div>
           <!-- SALES MODAL -->


    </div>

        <div class="overlay toggle-menu"></div>


    </div>        <!-- container-fluid -->
    </div>    
        <!-- content-wrapper -->
    <?php
    $deletePensioner = new ControllerPensioner();
    $deletePensioner -> ctrDeletePensionerListAccnt();
    ?>



  
