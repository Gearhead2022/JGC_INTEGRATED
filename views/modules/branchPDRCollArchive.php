
<style>
    textarea#wp_req_for {
    height: 100px;
}
</style>
<?php 

    date_default_timezone_set('Asia/Manila');

    $branch_name = $_SESSION['branch_name'];
?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">PDR COLLECTION ARCHIVE RECORDS</h4>
     </div>
   </div> 
   
    <div class="row">    
      <div class="col-lg-12">
        <form method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-header ml-4">
                <div class="row">
                    <div class="col-sm-1.5 form-group ">
                        <button type="button" class="btn btn-transparent border border-white text-white btn-round waves-effect waves-light m-1" onClick="location.href='branchPDRColl'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-2.5 mt-3">
                        <label for="or_file">Transaction date:</label>
                    </div>
              
                    <div class="col-2.5 mt-3 ml-5">
                        <label for="or_file">FROM:</label>
                    </div>
                    <div class="col-2 mt-1">
                        <input type="date" id="seltfromdate" name="seltfromdate" class="form-control" placeholder="Enter transaction date">
                    </div>
                    <div class="col-2.5 mt-3">
                        <label for="or_file">TO:</label>
                    </div>

                    <div class="col-2 mt-1">
                    
                        <input type="date" id="selttodate" name="selttodate" class="form-control" placeholder="Enter transaction date">
                    </div>

                    <div class="col-3">
                    <button type="button" class="btn btn-transparent boder btn-round border-3 border-warning text-warning waves-effect btn-md waves-light m-1 filterPDRArchiveList">
                          <i class="fa fa-filter"></i> <span>&nbsp;FILTER</span>
                      </button>
                    </div>
                </div>
               </div>   
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printPDRCollection" hidden class="btn btn-transparent border-3 text-info border-info btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addCorrespondentModal"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped pdrCollArchiveDateTable">
                <thead>
                <tr>
                  <th>ACTION</th>
                  <th>ID</th>
                  <th>SSP / GSP</th>
                  <th>STATUS</th>
                  <th>DATE ENDORSED</th>
                  <th>DATE OF PAYMENT</th>
                  <th>REF</th>
                  <th>PREVIOUS BALANCE</th>
                  <th>AMOUNT PAID</th>
                  <th>AMOUNT LOAN</th>
                  <th>ENDING BALANCE</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
           
                                                        
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

      </div>
    </div><!--End Row-->
  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->

  <?php
        $addProcessedPDRColl = new ControllerPDRColl();
        $addProcessedPDRColl -> ctrDeletePDRCollectionArchive();
  ?>