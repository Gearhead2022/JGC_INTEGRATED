<?php 
    $branch_name = $_SESSION['branch_name'];

  $ins = (new ControllerInsurance);
  $branches = $ins->ctrShowBranches();

  if($_SESSION['type'] != "admin"  &&  $_SESSION['type'] != "insurance_admin"){
    $hidden = "hidden";
  }else{
    $hidden = "";
  }

?> 
<style>
  .modal-content {
    width: 1000px;
} 
#insuranceEditModal .modal-body .form-control {
    border: solid 1px #6e6e6e;
    color: black !important;
}
#insuranceEditModal .modal-body label { 
    color: black !important;
}
#insuranceEditModal .modal-header {
    border-bottom: solid 1px white;
}

#insuranceEditModal .modal-footer {
    border-top: 1px solid white;
}

#insuranceEditModal .modal-content {
    background: #C9E0DC;
}

#insuranceEditModal .modal-body .form-control::placeholder {
    color: #547861 !important; /* Change this to the desired placeholder color */
}
#insuranceEditModal .modal-body select option {
    background-color: #f0f0f0 !important; /* Change to desired option background color */
    color: black !important; /* Change to desired option text color */
}

#insuranceEditModal .modal-body .form-control:read-only {
    background-color: #a5dab33d; /* Change to desired background color */
  
}
</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">INSURANCE LIST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin" || $_SESSION['type']=="insurance_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD INSURANCE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#reportModal"><i class="fa fa-print"></i> <span>&nbsp;GENERATE SUMMARY</span> </button>
                  
              <?php  }if($_SESSION['type'] == "admin" || $_SESSION['type']=="insurance_admin"){?>
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#reportBranchModal"><i class="fa fa-print"></i> <span>&nbsp;BRANCH SUMMARY</span> </button>
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#dailyCheckListModal"><i class="fa fa-print"></i> <span>&nbsp;DAILY CHECKLIST</span> </button>
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#amountSummaryModal"><i class="fa fa-print"></i> <span>&nbsp;AMOUNT SUMMARY</span> </button>
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#insuranceCheckerModal"><i class="fa fa-print"></i> <span>&nbsp;CHECKER</span> </button>

               <?php }?>
               <input type="text" hidden class="form-control" id="user_type"  name="user_type" value="<?php echo $_SESSION['type']; ?>" autocomplete="nope">
              
                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped insuranceTable">
                <thead>
                <tr>
                   <th>ID</th>
                  <th>NAME</th>
                  <th>BRANCH<E/th>
                  <th>AVAIL DATE</th>
                  <th>EXPIRE DATE</th>
                  <th>AMOUNT</th>
                  <th>TYPE</th>
                  <th>ACTION</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>
          <!-- row -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD INSURANCE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6 form-group">
                    <label for="input-1">Date</label>
                        <input type="date" required class="form-control" id="date"  name="date">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label label for="input-6">SELECT INSURANCE TYPE</label>
                        <select class="form-control" name="ins_type" id="ins_type" required>
                            <option value=""><  - - SELECT TYPE - - ></option>
                            <option value="OONA">OONA</option>
                            <option value="CBI">CBI</option>
                            <option value="PHIL">PHILINSURE</option>
                      </select>
                    </div>
                 </div>
              <div class="row">   
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden class="form-control" id="branch_name"  name="branch_name" value="<?php echo $branch_name; ?>" autocomplete="nope">
                        <input type="file" class="form-control" required id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addInsurance" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $createChecklist = new ControllerInsurance();
                    $createChecklist -> ctrAddInsurance();
                    ?>
           </div>
        </div>

        <div class="modal fade" id="insuranceEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" style="color: black;" id="exampleModalLongTitle">EDIT INSURANCE</h5>
                        <button type="button" style="color: #b10000;" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                        <button type="submit" name ="editInsurance" class="btn btn-primary editInsurance">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $createChecklist = new ControllerInsurance();
                    $createChecklist -> ctrCreateEditInsurance();
                    ?>
           </div>
        </div>


          <!-- Generate Report Modal -->
      <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Generate Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-6 form-group">
                          <label label for="input-6">SELECT INSURANCE TYPE</label>
                          <select class="form-control" name="ins_type1" id="ins_type1" required>
                              <option value=""><  - - SELECT TYPE - - ></option>
                              <option value="OONA">OONA</option>
                              <option value="CBI">CBI</option>
                              <option value="PHIL">PHILINSURE</option>
                        </select>
                      </div>
                  </div>
                <div class="row">
                  <div class="col-sm-6 form-group" <?php echo $hidden; ?>>
                        <label label for="input-6">SELECT BRANCH</label>
                        <select class="form-control" name="branch" id="branch" required>
                            <option value="ALL"><  - - SELECT BRANCH - - ></option>
                            <option value="EMB">EMB</option>
                            <option value="FCH">FCH</option>
                            <option value="RLC">RLC</option>
                            <option value="ELC">ELC</option>
                      </select>
                    </div>
                    
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Date</label>
                        <input type="date" required class="form-control" id="rep_date"  name="date">
                    </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" id="insuranceReport" name ="insuranceReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
             
           </div>
        </div>

        <!-- Generate Daily Checklist Modal -->
      <div class="modal fade" id="dailyCheckListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Generate Daily Checklist Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Date</label>
                        <input type="date" required class="form-control" id="chk_date"  name="date">
                    </div>
                    <div class="col-sm-6 form-group">
                          <label label for="input-6">SELECT INSURANCE TYPE</label>
                          <select class="form-control" name="ins_type4" id="ins_type4" required>
                              <option value=""><  - - SELECT TYPE - - ></option>
                              <option value="OONA">OONA</option>
                              <option value="CBI">CBI</option>
                              <option value="PHIL">PHILINSURE</option>
                        </select>
                      </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" id="insuranceChecklistReport" name ="insuranceChecklistReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
             
           </div>
        </div>

          <!-- Generate Amount Summary Modal -->
      <div class="modal fade" id="amountSummaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">GENERATE AMOUNT SUMMARY REPORT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Date</label>
                        <input type="date" required class="form-control" id="amt_date"  name="amt_date">
                    </div>
                    <div class="col-sm-6 form-group">
                          <label label for="input-6">SELECT INSURANCE TYPE</label>
                          <select class="form-control" name="ins_type3" id="ins_type3" required>
                              <option value=""><  - - SELECT TYPE - - ></option>
                              <option value="OONA">OONA</option>
                              <option value="CBI">CBI</option>
                              <option value="PHIL">PHILINSURE</option>
                        </select>
                      </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" id="amountSummaryReport" name ="amountSummaryReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
             
           </div>
        </div>


             <!-- Generate Report By Branch Modal -->
      <div class="modal fade" id="reportBranchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Generate Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                  <div class="col-sm-6 form-group">
                          <label label for="input-6">SELECT INSURANCE TYPE</label>
                          <select class="form-control" name="ins_type2" id="ins_type2" required>
                              <option value=""><  - - SELECT TYPE - - ></option>
                              <option value="OONA">OONA</option>
                              <option value="CBI">CBI</option>
                              <option value="PHIL">PHILINSURE</option>
                        </select>
                      </div>
                  </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label   label for="input-6">BRANCH NAME</label>
                        <select class="form-control" name="branch_names" id="branch_names" required>
                            <option value=""><  - - SELECT BRANCHES - - ></option>
                            <?php
                              foreach ($branches as $key => $row) {
                                # code...
                                $branch_names = $row['branch_name'];
                            ?>
                            <option value="<?php echo $branch_names;?>"><?php echo $branch_names;?></option>
                          <?php } ?>
                      </select>
                    </div>  
                    <div class="col-sm-6 form-group">
                    <label for="input-1">Date</label>
                        <input type="date" required class="form-control" id="branch_date"  name="date">
                    </div>
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" id="insuranceBranchReport" name ="insuranceBranchReport" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
             
           </div>
        </div>

        
          <!-- Insurance Checker Modal -->
      <div class="modal fade" id="insuranceCheckerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">INSURANCE CHECKER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-1">Date</label>
                        <input type="date" required class="form-control insuranceCheckerReport" id="insuranceCheckerReport"  name="insuranceCheckerReport">
                    </div>
               </div> 
               <table id="default-datatable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>BRANCH NAME</th>
                            </tr>
                        </thead>
                        <tbody class="checkerBody1">
                          
                        </tbody>
                      
                    </table>
                </div>
                <div class="modal-footer">
                        <button type="button" id="" name ="" class="btn btn-primary">OK</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
             
           </div>
        </div>
        <!-- End Insurance Checker -->
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deleteChecklist = new ControllerInsurance();
  $deleteChecklist  -> ctrDeleteInsurance();
  
?>


  
