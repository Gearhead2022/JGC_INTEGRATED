
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">MANAGE BACKUP</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
              <div class="col-2.1">
                    <label for="inputIdNo" class="col-form-label">SEARCH BACKUP DATE :</label>
                </div>
                <div class="col-2">
                <input type="month" class="form-control" id="backup_month"  placeholder="Enter Date"  name="backup_month" autocomplete="nope" required>
                </div>
                       
                <div class="col-sm-2 form-group">  
                  <button type="button" name="" class="btn btn-light btn-round waves-effect waves-light m-1 generateBackupMonthlyList"><i class="fa fa-refresh"></i> <span>&nbsp;GENERATE</span> </button>
                </div>

                <div class="col-sm-2 form-group">  
                  <button type="button" name="" class="btn btn-danger btn-round waves-effect waves-light m-1 deleteBackupMonthlyList"><i class="fa fa-minus-square"></i> <span>&nbsp;DELETE ALL</span> </button>
                </div>
            </div>    
            </div>        

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped backupMonthlyDataList">
                <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>No. Backup</th>
                  <th>Date</th>
                  
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
      
      </div>    <!-- row -->

</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

