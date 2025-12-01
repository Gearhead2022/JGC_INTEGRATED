
<?php 
   $account_no = $_GET['account_no'];
   $branch_name = $_GET['branch_name'];

      
?> 
<style>
  .modal-content {
    width: 1000px; 
   
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">PAST DUE LEDGER</h4>
        </div>
     </div>
 
      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
            <div class="row">
                <div class="col-sm-1.5 ml-4 form-group">
                        <button type="button" class="btn btn-transparent border border-white text-white btn-round waves-effect waves-light m-1" onClick="location.href='branchPDRLedger'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>
                </div>
              <div class="row">
              </div> 
            </div>            
            <div class="card-body">
            <div class="float-right">
                <button type="button" id="printPDRLedger" class="btn btn-transparent border-3 text-info border-info btn-round waves-effect waves-light m-1" account_no="<?php echo $account_no;?>"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
              </div>
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped showLedgerTable" account_no="<?php echo $account_no;?>" >
                <thead>
                <tr>
                  <th>ACCOUNT NUMBER</th>
                  <th>NAME</th>
                  <th>DATE</th>
                  <th>REFFERENCE NUMBER</th>
                  <th>DEBIT</th>
                  <th>CREDIT</th>

                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>

          <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <!-- <button type="button" class="btn btn-light btn-round px-5" onclick="goBack()" ><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;BACK</button>  
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='pastdue'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                          -->
                  </div>
                </div>
              </div>
            </div>
        </div>
                 
      </div>    <!-- row -->
 
    <div class="overlay toggle-menu"></div>
  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->




  
