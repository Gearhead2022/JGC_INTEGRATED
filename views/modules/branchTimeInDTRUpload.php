
<?php
$branch_DTR = new ControllerDTR();

$dtr = (new Connection)->connect()->query("SELECT * from branch_time_in_dtr_upload ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
    if(empty($dtr)){
        $id = 0;
    }else{
        $id = $dtr['id'];
    }
        $last_id = $id + 1;
        
        $id_holder = "DTRT" . str_repeat("0",5-strlen($last_id)).$last_id;     

        date_default_timezone_set('Asia/Manila');
        $date_now =date('Y-m-d'); 

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

/* Style for the date input arrow icon */
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1); /* Invert the color of the calendar icon */
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">TIME IN DTR FILE UPLOAD</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
            <div class="row">
                <div class="col-sm-2 form-group mt-4 ml-3">
                    <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='branchDTRUpload'"><i class="fa fa-arrow-left"></i> <span>&nbsp;BACK</span> </button>
                </div>    
                <div class="col-sm-2 form-group mt-4 ml-3">
                  <button type="button" name="" class="btn btn-primary btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#uploadTimeInModal"><i class="fa fa-upload"></i> <span>&nbsp;UPLOAD DTR FILE</span> </button>
                </div>
              </div>           
            <div class="card-body">   
                <div class="row">  
                <hr />
                    <div id="" class="table-responsive" >
                    <table id="default-datatable" class="table table-bordered table-hover table-striped branchDailyTimeInDTRUploadTable">
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


        <!--Upload DTR Modal -->
        <div class="modal fade" id="uploadTimeInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">UPLOAD TIME-IN DTR FILE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  method="post"  enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="dtr_id" name="dtr_id" readonly value="<?php echo $id_holder;?>" required placeholder="Enter Folder Name">
                 <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">BRANCH NAME</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name" readonly value="<?php echo $_SESSION['branch_name'];?>" required placeholder="Enter Folder Name">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="input-6">SELECT DATE</label>
                        <input type="date" class="form-control" id="entry_date" name="entry_date" required placeholder="Enter Folder Name">
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label for="input-6">DATABASE FILE</label>
                        <input type="file" class="form-control" id="entry_file" name="entry_file" accept=".encrypted" required placeholder="Enter Folder Name">
                    </div>

                    <div class="col-sm-12 mt-2">
                        <label for="input-6">SUBJECT NAME</label>
                        <textarea type="text" class="form-control" id="entry_subj"  name="entry_subj"></textarea>
                    </div>                 
                 </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" name ="addtimeindtr" class="btn btn-primary">Submit</button>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
              <?php
                    $branch_DTR -> ctrAddBranchDailyTimeInDTRUpload();
                ?>
        </div>
        </div>
        <!--END Upload Modal -->

        <!-- EDIT DTR MODAL -->
        <div class="modal fade" id="editTimeinDTR" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">EDIT TIME-IN DTR FILE</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form  method="post"  enctype="multipart/form-data">
              <div class="modal-body" >
    
              </div>
              <div class="modal-footer">
                  <button type="submit" name ="edittimeindtr" class="btn btn-primary">Submit</button>
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              </form>
              <?php
                    $branch_DTR -> ctrEditBranchDailyTimeInDTRUpload();
                ?>
              </div> 
          </div>
        </div>
        <!-- END EDIT DTR MODAL -->  

          <!-- VIEW DTR MODAL -->
          <div class="modal fade" id="viewDTRTimeIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">VIEW DTR TIME-IN FILE INFO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
    
              <div class="modal-body" >
    
              </div>
              <div class="modal-footer">
                  
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              </form>
             
              </div> 
          </div>
        </div>
        <!-- END VIEW DTR MODAL -->  
    </div>

<div class="overlay toggle-menu"></div>


</div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 
  $branch_DTR  -> ctrDeleteBranchDailyTimeInDTRUpload();
  
?>


  
