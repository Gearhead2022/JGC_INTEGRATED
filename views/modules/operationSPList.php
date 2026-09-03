
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
          <h4 class="page-title">MONTH SALES PERFORMANCE</h4>
        </div>
     </div>
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">   
            <div class="row">

            <a href="operationSP" class="btn btn-light btn-round waves-effect waves-light mt-2 ml-4 mr-2" style="position:relative;bottom:.2rem;"><i class="fa fa-arrow-left"></i> <span>&nbsp;Back</span></a>
            
           <?php if($_SESSION['type']=="operation_admin" ){?>
                 <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addSalesRepresentative"><i class="fa fa-plus"></i> <span>&nbsp;ADD SALES REPRESENTATIVE</span> </button>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addPensionerAccounts"><i class="fa fa-plus"></i> <span>&nbsp;ADD PENSIONER ACCOUNTS</span> </button> -->
                  <?php } ?>  
                        
                </div>    

                
          
           
           
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printSalesPerformanceReport"  class="btn btn-light btn-round waves-effect waves-light m-1 printSalesPerformanceReport" hidden ><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>

             <div id="" class="table-responsive" >
             <table id="default-datatable" class="table table-bordered table-hover table-striped salesRepresentativeTable">
                <thead>
                <tr>
                    <th>BRANCH NAME</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME<E/th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->

      <div class="modal fade" id="addSalesRepresentative" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD SALES REPRESENTATIVE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <option value="EMB ISABELA">EMB ISABELA</option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">FIRST NAME</label>
                        <input type="text" class="form-control" name="rep_fname" id="rep_fname" placeholder="Enter First Name">
                    </div>   
                    <div class="col-sm-6 form-group">
                        <label for="input-6">LAST NAME</label>
                        <input type="text" class="form-control" name="rep_lname" id="rep_lname" placeholder="Enter Last Name">
                    </div>  
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addSalesRep" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $add_rep = new ControllerPensioner();
                     $add_rep -> ctrAddSalesRepresentative();
                    ?>
           </div>
        </div>
     <!-- SALES MODAL -->

         <!-- SALES MODAL -->

         <div class="modal fade" id="editPensionerAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT SALES REPRESENTATIVE</h5>
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
                     $edit_rep -> ctrEditSalesrepresentative();
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
  $deleteClient = new ControllerPensioner();
  $deleteClient -> ctrDeleteRep();
?>



  
