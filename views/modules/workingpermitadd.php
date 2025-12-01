<style>
    textarea#wp_req_for {
    height: 100px;
}

.auditCheckBox{
  display: flex;
  justify-content: start;
  align-content: center;
  gap: 1rem;
  cursor: pointer;
  background-color: #388e87;
  width: 12rem;
  padding: .5rem;
}
.auditCheckBox:hover{
  background-color:rgb(5, 67, 61);
}

</style>
<?php 
  $type = $_GET['type'] ?? null;
  $username = $_SESSION['username'];
  $permit = (new Connection)->connect()->query("SELECT * from working_permit ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);

  if($type === null || $type === 'MIS'){
    $wp_to_name = 'MIS DEPARTMENT';
  }else{
    $wp_to_name = 'PSPMI DEPARTMENT';
  }
  
  if(empty($permit)){
    $id = 0;
  }else{
    $id = $permit['id'];
  }
    $last_id = $id + 1;
    $id_holder =  $type === null || $type === 'MIS' ? 'WP'  . str_repeat("0",5-strlen($last_id)).$last_id : 'PR'  . str_repeat("0",5-strlen($last_id)).$last_id;
    date_default_timezone_set('Asia/Manila');
    $date_now =date("F d Y"); 
    $user_id = $_SESSION['user_id'];
    $department = (new Connection)->connect()->query("SELECT * FROM departments ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
    $branches = (new Connection)->connect()->query("SELECT * FROM permit_branches ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

?>  
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title"> <?php  echo ($type === null || $type === 'MIS')  ? ' WORKING PERMIT FORM' :  'PSPMI WORKING PERMIT FORM'  ?></h4>
     </div>
   </div> 
    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-body">
             <div class="row"> 
                <div class="col-sm-2 form-group">
                <label for="input-1">Reference No. </label>
                    <input type="text" readonly  value="<?php echo $id_holder; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                    <input type="text" hidden  value="<?php echo $user_id; ?>" class="form-control" id="user_id" placeholder="Enter To" name="user_id" autocomplete="nope" >
                 
                </div>
                <div class="col-sm-3 form-group">
                        <label for="input-1">TO </label>
                        <!-- <input type="text" class="form-control" readonly id="wp_to" value="<?php echo $wp_to_name ?>" placeholder="Enter To" name="wp_to" autocomplete="nope" required> -->
                          <select  id="wp_to"  class="form-control"   name="wp_to" required>
                          <option value="">< - - - SELECT REQUEST TO - - - ></option>
                              <option value="MIS DEPARTMENT">MIS DEPARTMENT</option>
                              <option value="PSPMI DEPARTMENT">PSPMI DEPARTMENT</option>
                          </select >
                      </div> 
                    <div class="col-sm-3 form-group">
                      <label for="wp_from">FROM</label>
                      <select id="wp_from" name="wp_from" class="form-control" required>
                        <option value="">< - - - SELECT USER - - - ></option>
                          <?php
                              foreach ($department as $key => $row) {
                                # code...
                                $name = $row['department_name'];
                                $id = $row['id'];
                            ?>
                            <option value="<?php echo $id;?>"><?php echo $name;?></option>

                          <?php } ?>

                      </select>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="request_level">Request Level</label>
                        <select name="request_level" id="request_level" class="form-control"  required>
                          <option value="">< - - SELECT LEVEL - - ></option>
                          <option value="1">LEVEL 1</option>
                          <option value="2">LEVEL 2</option>
                        </select>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="input-6">Date</label>
                        <input type="text" class="form-control" id="wp_date" readonly placeholder="Enter Pag-ibig Number" name="wp_date" value="<?php echo $date_now; ?>" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Request for </label>
                        <textarea class="form-control"  style="white-space: pre-wrap;" id="wp_req_for" placeholder="Enter Request For" name="wp_req_for" autocomplete="nope" required></textarea>
                    </div>   
                 
            </div>   
            <!-- <div class="row">
                <div class="col-sm-12">
                  <div class="auditCheckBox">
                     <span>ADD AUDIT TOOLS</span>  <input type="checkbox" name="" class="" id="">
                  </div>
                </div>  
            </div> 
              <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATABASE</span> </button>
             -->
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Branch / Department </label>
                    <!-- <input type="text" class="form-control" id="branch" placeholder="Enter Branch / Department" name="branch" autocomplete="off" required> -->
                    <input list="departments" class="form-control" id="branch" placeholder="Enter Branch / Department" name="branch" autocomplete="off" required>
                    <datalist id="departments">
                      <?php 
                        foreach($branches as $key => $branch ){
                            $branchList = $branch['branch_name'];
                      
                      ?>   
                      <option value="<?php echo $branchList; ?>">        
                      <?php  } ?>
                  
                      </datalist>            
                                
                
                  </div>   
                <div class="col-sm-4 form-group">
                    <label for="input-1">Requested by </label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_req_by" placeholder="Enter Requested By" name="wp_req_by" autocomplete="nope" ></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by</label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_chk_by" placeholder="Enter Checked By" name="wp_chk_by" autocomplete="nope" ></textarea>
                </div>   
            </div>   
            <div class="row">
                  <div class="col-sm-4">
                    <label for="input-6">Attachment</label>
                    <input type="file" class="form-control" name="image[]" id="attachment" multiple>
                  </div>
                 <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <input type="text" class="form-control" readonly id="wp_app_by" value="Christine G. Nepomuceno" placeholder="Enter Approved By" name="wp_app_by" autocomplete="nope" required>
                </div>
                <div class="col-sm-4 form-group">
                        <label for="input-6">Approved By</label>
                        <input type="text" class="form-control" readonly id="wp_app_by1" value="Edgardo G. Guerrero Jr." placeholder="Enter Approved By" name="wp_app_by1" autocomplete="nope" required>
                </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <button type="submit" name="add_permit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>

            <!-- CHECKER MODAL1 -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">CHECK LEDGER RECORDS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <form  method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                                      <h1>Table</h1>
                    </div>         
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </form>
                
              </div>
            </div>
     <!-- END CHECKER MODAL1 -->

        <?php
                    $createClient = new ControllerPermits();
                    $createClient -> ctrCreatePermit();
                    ?>
      </div>
    </div><!--End Row-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->