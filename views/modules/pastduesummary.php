<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();


  $user_id = $_SESSION['user_id'];
  $branch_name = $_SESSION['branch_name'];
?> 


<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">PASTDUE PERFORMANCE SUMMARY</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <div class="col-sm-2 form-group">
                        <label for="input-6">SELECT MONTH</label>
                        <input type="month" class="form-control dateFrom" id="slcMonth"  placeholder="Enter PRR Date"  name="slcMonth" autocomplete="nope" >
                </div>
                <div class="col-sm-2 form-group mt-4">
                <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 summaryReport"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                </div>
                  
            </div>
            </div>          
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printWeeklyCollection" hidden class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addPreparedBy"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
              <div id="pastDueSummaryTable" class="table-responsive">
              <table class="table table-bordered table-hover table-striped pastDueSummaryReport">
                
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      
</div>


 <!-- ADD REPORT CORRESPONDENTs MODAL -->

 <div class="modal fade" id="addPreparedBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD CORRESPONDENT</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                    <div class="col-sm-12 form-group">
                          <label for="input-6">PREPARED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="preparedBy" placeholder="Provide Name"  name="preparedBy" autocomplete="nope">Jason R. Estrellanes</textarea>
                  </div>
                  <div class="col-sm-12 form-group">
                          <label for="input-6">CHECKED BY:</label>
                          <textarea type="text" class="form-control " style="white-space: pre-wrap;" id="checkedBy" placeholder="Provide Name"  name="checkedBy" autocomplete="nope">Irish T. Cañete</textarea>
                  </div>
                  <div class="col-sm-8 form-group">
                    <label for="input-6">NOTED BY:</label>
                    <textarea type="text" class="form-control " id="notedBy" placeholder="Provide Name"  name="notedBy" autocomplete="nope">Christine G. Nepomuceno</textarea>
                  </div>
                  <div class="col-sm-4 form-group">
                    <label for="input-6">POSITION:</label>
                    <textarea type="text" class="form-control " id="position" placeholder="Provide Name"  name="position" autocomplete="nope">Comptroller</textarea>
                  </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                            <button type="button" name="saves" class="btn btn-primary printSummary1">PRINT</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
              
              
            </div>
            </div>

            <!-- END ADD REPORT CORRESPONDENTs MODAL -->

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->