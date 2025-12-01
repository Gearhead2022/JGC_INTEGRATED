<?php 
  $type = $_SESSION['type'] ?? null;
?>


<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">WORKING PERMIT REQUEST</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                  <div class="col-sm-2">
                     <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1"  onClick="location.href='index.php?route=workingpermitadd&type=MIS'"><i class="fa fa-plus"></i> <span>&nbsp;ADD REQUEST</span> </button>
                  </div>
                  <div class="col-sm-3">
                     <input type="date" class="form-control filterDate" name="filterDate" id="filterDate">
              
                  </div>
                  <div class="col-sm-3">
                     <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 filterButton"><i class="fa fa-filter"></i> <span>&nbsp;Filter Data</span> </button>
                  </div>
                </div>
            </div>         
            <div class="row">
                <div class="col-sm-12 colCategory px-5 pt-2">
                  <div class="btnCategory<?php echo ($type === null || $type !== 'wp_pspmi' && $type !== 'wp_pspmi_admin') ? ' active-category' : '' ?>"    onclick="redirectWithType('MIS')">
                      <span class="BtnText" id="misBtnText">0</span>
                        MIS
                    </div>
                  <button 
                    class="btn btn-light btnCategory<?php echo ($type === 'wp_pspmi' || $type === 'wp_pspmi_admin') ? ' active-category' : '' ?>" 
                    onclick="redirectWithType('PSPMI')"
                    id="pspmiBtn">
                    <span class="BtnText" id="pspmiBtnText">0</span>
                    PSPMI
                  </button>
                </div>
            </div>     

            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped permitTable">
                <thead>
                <tr>
                 <th>Action</th>
                  <th>REFERENCE NO.</th>
                  <th>Requested by</th>
                  <th>Branch</th>
                  <th>Request Level</th>
                  <th>Checked By</th>
                  <th>Checked Status</th>
                  <th class="approveChange">Approved by EGG</th>
                  <th>Approved by CGN</th>
                  <th>Status</th>
                  <th>DATE / TIME REQUESTED</th>
                  <th>DATE / TIME Done</th>
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

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
  $deleteBlacklist = new ControllerPermits();
  $deleteBlacklist  -> ctrDeletePermit();
?>