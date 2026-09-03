<?php
require_once "models/connection.php";

$connection = new Connection();
$pdo = $connection->connect();
?>

<div class="clearfix"></div>
<div class="content-wrapper">
<div class="container-fluid">

<div class="row pt-2">
        <div class="col-sm-12">
          <h4 class="page-title">TICKET ARCHIVE</h4>
        </div>
     </div>

     <div class="row">
        <div class="col-12">

            <div class="card">
            <div class="card-header float-sm-right">


            <div class="row">

                <?php if($_SESSION['type'] =="backup_user"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='ticket'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#ticketModal"><i class="fa fa-book"></i> <span>&nbsp;LIST</span> </button> -->
              <?php  }?>
              
              </div> 

              <div class="card-body" >
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped ticketArchiveTable">
                <thead>
                <tr>
                  
              <!-- #region -->
                  <th>ACCOUNT ID</th>
                  <th>NAME</th>
                  <th>TICKET</th>
                  <th>DATE</th>
                  <th>ACTION</th>
              
             
                </tr>
                </thead>
              </table>
            </div>
            </div>
                </div>

            </div>

        </div>
     </div>
     
     <!-- Print Password MODAL -->
       <div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md"  role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ENTER CREDENTIALS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12 form-group">
                              <label for="input-6">PASSWORD</label>
                              <input type="password" class="form-control" autocomplete="new-password" id="arc_password" placeholder="Enter Password" name="arc_password">
                          </div>   
                      </div>
                  </div>             
                  <div class="modal-footer">
                      <button type="button"  id="btnArchive" class="btn btn-primary" data-dismiss="modal">Submit</button>
                      <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
             </div>
          </div>
        </div>
     <!-- END Print Password MODAL -->

     

</div>  <!--container container-fluid --> 
</div>     <!--content wrapper --> 
