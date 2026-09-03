
<style>
  .modal-content {
    width: 1000px;
    margin-left: -221px;
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">BACKUP LIST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='backupadd'"><i class="fa fa-plus"></i> <span>&nbsp;ADD BACKUP</span> </button>
              <?php  }?>
              <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_admin"){?>

              <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='backupfilter'"><i class="fa fa-folder"></i> <span>&nbsp;ADMIN FOLDER</span> </button>
              <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#backupModal"><i class="fa fa-refresh"></i> <span>&nbsp;BACKUP CHECKER</span> </button>
              <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#downloadModal"><i class="fa fa-download"></i> <span>&nbsp;DOWNLOAD ALL</span> </button>
              <button type="button"  class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#receiveAllModal"><i class="fa fa-get-pocket"></i> <span>&nbsp;RECEIVE ALL</span> </button>

              <?php  }?>


                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped backupTable">
                <thead>
                <tr>
                  
                  <th>BRANCH NAME</th>
                  <th>Subject</th>
                  <th>DATE / TIME ENCODED</th>
                  <th>DATE / TIME RECEIVED</th>
                  <th>STATUS</th>
                  <th>Action</th>
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
</div>

<!--Backup Modal -->
<div class="modal fade" id="backupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">BACKUP CHECKER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
              <label for="input-1">Select Date</label>
              <input type="date" class="form-control checkBackup" id="checkBackup" placeholder="Enter First Name" name="first_name" autocomplete="nope" required>
            </div>
        </div>
        <div id="showTable" class="table-responsive" hidden>
            <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>BRANCH NAME</th>
                    </tr>
                    </thead>
                    <tbody class="reportTable">
                    </tbody>
            </table>
              
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--END Backup Modal -->

<!--Download Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">DOWNLOAD ALL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
              <label for="input-1">Select Date</label>
              <input type="date" class="form-control dateFrom" id='dateFrom' autocomplete="nope" required>
            </div>
            <div class="col-md-6 mt-4">
              <button type="button" class="btn btn-primary downloadAllFiles">Download Now</button>
            </div>
        </div> 
      </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--END Download Modal -->

<!--Download Modal -->
<div class="modal fade" id="receiveAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">RECEIVE ALL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
              <label for="input-1">Select Date</label>
              <input type="date" class="form-control dateFrom1" id='dateFrom1' autocomplete="nope" required>
            </div>
            <div class="col-md-6 mt-4">
              <button type="button" class="btn btn-primary receiveAllFiles">SUBMIT</button>
            </div>
        </div> 
      </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--END Download Modal -->

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $doneBackup = new ControllerBackup();
  $doneBackup  -> doneBackup();

  $deleteBackup = new ControllerBackup();
  $deleteBackup  -> ctrDeleteBackup();
  
  $deleteBackup  -> ctrReceiveAll();
  
?>