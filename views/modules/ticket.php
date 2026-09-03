<?php
require_once "models/connection.php";
$branch_name = $_SESSION['branch_name'];

$connection = new Connection();
$pdo = $connection->connect();

$branch_list = new ControllerTicket();
$branch = $branch_list->ctrShowBranches();
?>

<div class="clearfix"></div>
<div class="content-wrapper">
<div class="container-fluid">

<div class="row pt-2">
        <div class="col-sm-12">
          <h4 class="page-title">GENERATE TICKET</h4>
        </div>
     </div>

     <div class="row">
        <div class="col-12">

            <div class="card">
            <div class="card-header float-sm-right">


            <div class="row">

                <?php if($_SESSION['type'] =="backup_user"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#ticketModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATABASE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addTicketModal"><i class="fa fa-plus"></i> <span>&nbsp;ADD Ticket</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='ticketarchive'"><i class="fa fa-archive"></i> <span>&nbsp;ARCHIVE</span> </button>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#ticketModal"><i class="fa fa-book"></i> <span>&nbsp;LIST</span> </button> -->
              <?php  }?>
                 <?php if($_SESSION['type'] =="admin" || $_SESSION['type'] =="operation_admin" ){?> 
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#monitoringModal"><i class="fa fa-print"></i> <span>&nbsp;MONITORING</span> </button>
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#dailySummaryModal"><i class="fa fa-print"></i> <span>&nbsp;DAILY SUMMARY</span> </button>

                    <?php }?>
              
              </div> 
              <div class="card-body" >
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped ticketTable">
                <thead>
                <tr>
                  
              <!-- #region -->
                  <th>ACCOUNT ID</th>
                  <th>NAME</th>
                  <th>BRANCH</th>
                  <th>TICKET</th>
                  <th>DATE</th>
                  <th>ACTION</th>
              
             
                </tr>
                </thead>
              </table>
            </div>
            </div>



        <!-- modal -->
        <div class="modal fade" id="ticketModalCenter" tabindex="-1" role="dialog" aria-labelledby="ticketModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATABASE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
            
                
                <div class="row">
                    <div class="col-sm-12 form-group">
                
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addTicketRecords" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addTicket = new ControllerTicket();
                     $addTicket -> addTicketRecords();
                  ?>
           </div>
        </div>
                   <!-- end of modal -->



      <!-- TICKET MODAL -->
     <div class="modal fade" id="addTicketModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD TICKET</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-sm-2 form-group">
                                    <label for="input-6">CTR No.</label>
                                    <input type="text" class="form-control" id="ctr_no" required placeholder="Enter CTR No." name="ctr_no">
                                </div>   
                                <div class="col-sm-2 form-group">
                                    <label for="input-6">ID</label>
                                    <input type="text" class="form-control" id="id" required placeholder="Enter ID" name="id">
                                    <input type="text" class="form-control" hidden id="branch_name" value="<?php echo $branch_name; ?>" name="branch_name">
                                </div>   
                                <div class="col-sm-4 form-group">
                                    <label for="input-6">NAME</label>
                                    <input type="text" class="form-control" id="name" required placeholder="Enter Name" name="name">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="input-6">Avail Date</label>
                                    <input type="date" class="form-control" required id="tdate"  name="tdate">
                                </div> 
                                <div class="col-sm-1 form-group">
                                    <label for="input-6">TICKET</label>
                                    <input type="text" class="form-control" required id="terms" placeholder="Enter Terms" name="terms">
                                </div>   
                            </div>
                        </div>             
                        <div class="modal-footer">
                            <button type="submit" name ="addTickets" class="btn btn-primary">Submit</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
              <!-- </form> -->
              <?php
                     $addLedger = new ControllerTicket();
                     $addLedger -> ctrSingleTicket();
                    ?>
           </div>
        </div>
     <!-- END TICKET MODAL -->
     
      <!-- MONITORING MODAL -->
       <div class="modal fade" id="monitoringModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">MONITORING REPORT</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                
                        <div class="modal-body">
                            <div class="row">
                               <div class="col-sm-3 form-group">
                                    <label for="input-6">FROM</label>
                                    <input type="date" class="form-control" id="tFrom" placeholder="Enter CTR No." name="tFrom">
                                </div>   
                                <div class="col-sm-3 form-group">
                                    <label for="input-6">TO</label>
                                    <input type="date" class="form-control" id="tTo" placeholder="Enter ID" name="tTo">
                                </div>   
                                <div class="col-sm-6 form-group">
                                  <label   label for="input-6">BRANCH NAME</label>
                                  <select class="form-control" name="tBranch_name" id="tBranch_name" required>
                                        <option value=""><  - - SELECT BRANCHES - - ></option>
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
                              <div class="row mt-2">
                                <div class="col-sm-4 form-group">
                                  <label   label for="input-6">TYPE OF REPORT</label>
                                  <select class="form-control" name="tType" id="tType" required>
                                      <option value=""><  - - SELECT TYPE - - ></option>
                                      <option value="E">EXISTING ACCOUNT</option>
                                      <option value="N">NEW ACCOUNT</option>
                                </select>
                               </div> 
                               <div class="col-sm-8 form-group">
                                    <label for="input-6">PREPARED BY</label>
                                    <input type="text" class="form-control" id="tPreby" placeholder="Enter Prepared By" name="tPreby">
                                </div>  
                            </div>
                        </div>             
                        <div class="modal-footer">
                            <button type="button" id ="ticketMonitoring" class="btn btn-primary">GENERATE</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
           </div>
        </div>
     <!-- END MONITORING MODAL -->
     
        <!-- DAILY SUMMARY MODAL -->
        <div class="modal fade" id="dailySummaryModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">DAILY SUMMARY REPORT</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="input-6">SELECT DATE</label>
                                    <input type="date" class="form-control" id="dateTo" placeholder="Enter ID" name="dateTo">
                                </div>   
                                <div class="col-sm-4 form-group">
                                  <label   label for="input-6">TYPE OF REPORT</label>
                                  <select class="form-control" name="sType" id="sType" required>
                                      <option value=""><  - - SELECT TYPE - - ></option>
                                      <option value="E">EXISTING ACCOUNT</option>
                                      <option value="N">NEW ACCOUNT</option>
                                </select>
                               </div> 
                               <div class="col-sm-5 form-group">
                                    <label for="input-6">PREPARED BY</label>
                                    <input type="text" class="form-control" id="sPreby" placeholder="Enter Prepared By" name="sPreby">
                                </div>  
                           
                        </div>             
                        <div class="modal-footer">
                            <button type="button" id ="dailySummaryReport" class="btn btn-primary">GENERATE</button>
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
           </div>
        </div>
        </div>
     <!-- END DAILY SUMMARY  MODAL -->


<!-- result modal -->

</div>



       
                </div>

            </div>

        </div>
     </div>

     

</div>  <!--container container-fluid --> 
</div>     <!--content wrapper --> 



<?php
  $deleteTicket = new ControllerTicket();
  $deleteTicket  -> ctrDeleteTicket();
 
?>