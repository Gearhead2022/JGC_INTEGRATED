
<?php
$branch_DTR = new ControllerDTR();

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
          <h4 class="page-title">HR ADMIN TIME-IN DTR</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">

              <div class="col-sm-2 form-group mt-4">
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='hrDTRDownload'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>
              </div>
            <div class="row ml-1">
            <div class="col-sm-2 form-group mt-3">
                <button type="button" name="" class="btn btn-info btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#checkTimeInDTRUploads"><i class="fa fa-check"></i> <span>&nbsp;UPLOAD CHECKER</span> </button>
                  </div>
                <div class="col-sm-2 form-group mt-3">
                  <button type="button" name="" class="btn btn-info btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#checkTimeInDTRData"><i class="fa fa-check"></i> <span>&nbsp;EMPLOYEE TIME-IN CHECKER</span> </button>
                </div> 
                <div class="col-sm-2 form-group mt-3">
                  <button type="button" name="" class="btn btn-danger btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#downloadAllBranchTimeIn"><i class="fa fa-download"></i> <span>&nbsp;DOWNLOAD ALL</span> </button>
                </div>
       
              </div>           
            <div class="card-body">   
                <div class="row">  
                <hr />
                    <div id="" class="table-responsive" >
                    <table id="default-datatable" class="table table-bordered table-hover table-striped hrDailyTimeInDTRDownloadTable">
                        <thead>
                        <tr>
                        <th>Actions</th>
                        <th>Branch Name</th>
                        <th>Subject name</th>
                        <th>DTR File</th>
                        <th>Entry Date</th>
                        <th>Status</th>
                        <th>Received Date</th>
                        </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div> 

      <!--Branch DTR Time In Modal -->
        <div class="modal fade" id="DTRTimeinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">BRANCH DTR TIME IN</h5>
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div id="showDTRTimeInTable" class="table-responsive" >
                    <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>NAME</th>
                                <th>BRANCH NAME</th>
                                <th>TIME IN</th>
                                <th>REMARKS</th>
                            </tr>
                            </thead>
                            <tbody class="BranchTimeIn">
                            </tbody>
                    </table>
              
                </div>
                </div>
            </div>

        </div>
        </div>
        <!--END Branch DTR Time In Modal -->

        <!--Upload DTR Modal -->
        <div class="modal fade" id="checkTimeInDTRData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">EMPLOYEE TIME-INS</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          <label for="input-6">SELECT DATE</label>
                          <input type="date" class="form-control" id="check_time_in_entry_date" required name="check_time_in_entry_date" required placeholder="Enter Folder Name">
                      </div>
                      <div class="col-sm-6 form-group mt-4">
                      <button type="submit" name="check_all_branch_dtr_time_in" id="check_all_branch_dtr_time_in" class="btn btn-danger">CHECK</button>
                      </div>
                  
                  </div> 
                  <div id="showAllTimeInDTRTable" class="table-responsive" hidden>
                      <table class="table table-bordered table-hover table-striped">
                              <thead>
                              <tr>
                                  <th>No.</th>
                                  <th>NAME</th>
                                  <th>BRANCH NAME</th>
                                  <th>TIME IN</th>
                                  <th>REMARKS</th>
                              </tr>
                              </thead>
                              <tbody class="BranchAllTimeInDTRUploadList">
                              </tbody>
                      </table>
                  </div>
                  </div>
              </div>
          </div>
        </div>
        <!--END Upload Modal -->

        <!--Upload DTR Modal -->
        <div class="modal fade" id="downloadAllBranchTimeIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">DOWNLOAD ALL</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          <label for="input-6">SELECT DATE</label>
                          <input type="date" class="form-control" id="entry_date" required name="entry_date" required placeholder="Enter Folder Name">
                      </div>
                      <div class="col-sm-6 form-group mt-4">
                      <button type="submit" name="download_all_DTR_time_in" id="download_all_DTR_time_in" class="btn btn-danger">DOWNLOAD</button>
                      </div>
                  
                  </div> 
                  </div>
                
              </div>
              
                <?php
                      $branch_DTR -> ctrDownloadAllDTRTimeInAndMoveFile();
                  ?>
          </div>
        </div>
        <!--END Upload Modal -->

        <!--Upload DTR Modal -->
        <div class="modal fade" id="checkTimeInDTRUploads" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">BRANCH DTR TIME-IN UPLOADS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-md-flex justify-content-end mr-5">
                  <div class="float-right">
                      <button type="button" id="printTimeInDTRReport" hidden class="btn btn-warning btn-round waves-effect waves-light m-1 printTimeInDTRReport "><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-8 form-group">
                        <label for="input-6">SELECT DATE</label>
                        <input type="date" class="form-control" id="check_entry_date" required name="check_entry_date" required placeholder="Enter Folder Name">
                    </div>
                    <div class="col-sm-4 form-group mt-4">
                    <button type="submit" name="check_all_DTR_Time_In" id="check_all_DTR_Time_In" class="btn btn-danger">CHECK</button>
                    </div>
                 
                 </div> 
                 <div id="showTimeInDTRTable" class="table-responsive" hidden>
                    <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>BRANCH NAME</th>
                                <th>UPLOAD STATUS</th>
                            </tr>
                            </thead>
                            <tbody class="BranchTimeInDTRUploadList">
                            </tbody>
                    </table>
              
                </div>
                </div>
            </div>

        </div>
        </div>
        <!--END Upload Modal -->
        



<div class="overlay toggle-menu"></div>


</div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
    $branch_DTR= new ControllerDTR();
    $branch_DTR -> ctrDownloadAndMoveFile();
?>


  
