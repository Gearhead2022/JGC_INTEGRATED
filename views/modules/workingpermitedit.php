<?php

$user_id = $_SESSION['user_id'] ?? null;
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM working_permit WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $wp_to = $clients['wp_to'];
 $wp_from = $clients['wp_from'];
 $wp_date = $clients['wp_date']; 
 $ref_id = $clients['ref_id']; 
 $wp_req_for = $clients['wp_req_for'];
 $branch = $clients['branch'];
 $wp_req_by1 = $clients['wp_req_by'];
 $wp_chk_by1 = $clients['wp_chk_by'];
 $wp_app_by = $clients['wp_app_by'];
 $wp_app_by1 = $clients['wp_app_by1'];
 $request_level = $clients['request_level'];
 $permit_type = $clients['type'];
 $table ="permit_files"; 
 $chk = $clients['chk'];
 $app1 = $clients['app1'];
 $type = $clients['type'];
 $wp_req_for1 =str_replace("<br />", '',  $wp_req_for);
 $wp_req_by =str_replace("<br />", '',  $wp_req_by1);
 $wp_chk_by =str_replace("<br />", '',  $wp_chk_by1);
 date_default_timezone_set('Asia/Manila');
  $date_now =date("F d Y");
  $attch = (new ControllerPermits)->ctrShowImg($table, $ref_id);

  $disableApprove = $chk === "Pending" ? "" : "disabled";
  $disableApprove1 = $app1 === 0 ? "" : "disabled";

  $department = (new Connection)->connect()->query("SELECT * FROM departments ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
  $departmentName = "";
  if($wp_from == 1){
    $departmentName = "ACCOUNTING DEPARTMENT";
  }elseif($wp_from == 2){
    $departmentName = "OPERATION DEPARTMENT";
  }elseif($wp_from == 3){
    $departmentName = "HROM DEPARTMENT";
  }elseif($wp_from == 4){
    $departmentName = "FINANCIAL DEPARTMENT"; 
  }elseif($wp_from == 5){
    $departmentName = "AUDIT DEPARTMENT"; 
  }elseif($wp_from == 6){
    $departmentName = "CREDIT AND COLL DEPARTMENT"; 
  }elseif($wp_from == 7){
    $departmentName = "GRCD DEPARTMENT"; 
  }elseif($wp_from == 8){
    $departmentName = "PSPMI"; 
  }elseif($wp_from == 9){
    $departmentName = "MIS DEPARTMENT"; 
  }

  if($request_level == 1){
    $levelName = "LEVEL 1";
  }elseif($request_level == 2){
    $levelName = "LEVEL 2";
  }
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<style>
  .bus_image {
		position: relative;
	}
  .dlt_img{
		position: absolute;	
		color: black;
    margin-left: -16px;
	}.dlt_img:hover{
	color: red;
	font-size: 18px;
}
textarea#wp_req_for {
    height: 100px;
}
</style>


<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">WORKING PERMIT FORM</h4>
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
                    <input type="text" readonly  value="<?php echo $ref_id; ?>" class="form-control" id="ref_id" placeholder="Enter To" name="ref_id" autocomplete="nope" >
                </div>
                <div class="col-sm-3 form-group">
                        <input type="text" hidden value="<?php echo $idClient; ?>" class="form-control" id="id" placeholder="Enter To" name="id" autocomplete="nope" >

                        <label for="input-1">TO: </label>
                        <!-- <input type="text" class="form-control" id="wp_to" value="<?php echo $wp_to; ?>" placeholder="Enter To" name="wp_to" autocomplete="nope" required> -->
                        <select  id="wp_to"  class="form-control"   name="wp_to" required>
                          <option value="">< - - - SELECT REQUEST TO - - - ></option>
                              <option value="MIS DEPARTMENT" <?php echo ($wp_to == "MIS DEPARTMENT") ? 'selected' : ''; ?>>MIS DEPARTMENT</option>
                              <option value="PSPMI DEPARTMENT" <?php echo ($wp_to == "PSPMI DEPARTMENT") ? 'selected' : ''; ?>>PSPMI DEPARTMENT</option>
                          </select >
                  
                      </div> 
                    <div class="col-sm-3 form-group">
                      <label for="wp_from">FROM</label>
                      <select id="wp_from" name="wp_from"  value="<?php echo $wp_from; ?>"  class="form-control" required>
                       <option value="<?php echo $wp_from;?>"><?php echo $departmentName;?></option>
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
                      <select name="request_level" id="request_level" class="form-control" required>
                          <option value=""><- - SELECT LEVEL - -> </option>
                          <option value="1" <?php echo ($request_level == "1") ? 'selected' : ''; ?>>LEVEL 1</option>
                          <option value="2" <?php echo ($request_level == "2") ? 'selected' : ''; ?>>LEVEL 2</option>
                      </select>
                  </div>

                    <div class="col-sm-2 form-group">
                        <label for="input-6">Date</label>
                        <input type="text" readonly class="form-control" id="wp_date" value="<?php echo $date_now; ?>" placeholder="Enter Pag-ibig Number" name="wp_date" autocomplete="nope" required>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="input-1">Request for </label>
                        <textarea class="form-control" id="wp_req_for" style="white-space: pre-wrap;"  placeholder="Enter Request For" name="wp_req_for" autocomplete="nope" required><?php echo $wp_req_for1; ?></textarea>
                    </div>   
                   
            </div>    
            <div class="row">
                <div class="col-sm-4 form-group">
                   <label for="input-1">Branch </label>
                    <input type="text" class="form-control" id="branch" value="<?php echo $branch; ?>" placeholder="Enter Branch" name="branch" autocomplete="nope" required>
                </div>   
                <div class="col-sm-4 form-group">
                        <label for="input-1">Requested by </label>
                        <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_req_by" placeholder="Enter Requested By" name="wp_req_by" autocomplete="nope" ><?php echo $wp_req_by; ?></textarea>
                </div> 
                <div class="col-sm-4 form-group">
                    <label for="input-1">Checked by</label>
                    <textarea class="form-control" style="white-space: pre-wrap;"  id="wp_chk_by" placeholder="Enter Checked By" name="wp_chk_by" autocomplete="nope" ><?php echo $wp_chk_by; ?></textarea>
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
            <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">Attachments</label>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <?php  foreach ($attch as $key => $value) { 
                       $attch_name = $value["file_name"]; 
                       $img_id = $value["id"];?>
                    <div class="col-sm-2 bus_image mt-2">
                    <a class="pop"> 
                      <img src="views/files/permit/<?php echo $attch_name; ?>"  style="width: 100%;height: 116px; background-color: white;">
                    </a>
                    <span class="dlt_img"
                     idClient = "<?php echo $idClient?>" img_name = "<?php echo $attch_name?>"><i class="fa fa-times"></i></span> 
                    </div>
                    <?php } ?>
                  </div>
                                                         
            <div class="card-footer">
              <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-9">
                  <div class="float-sm-right">
                   <?php if($user == "wp_accounting"
                             || $user == "wp_operation" 
                             || $user == "wp_hrom"
                             || $user == "wp_financial" 
                             || $user == "wp_audit" 
                             || $user == "wp_credit"
                             || $user == "wp_grcd"
                             || $user == "wp_pspmi" 
                             || ($user_id === "UI00098" && $permit_type === "PSPMI")
                             ){ 
                              
                              if($wp_from != 8 && $user == "wp_pspmi" && $type == "PSPMI"){ ?>
                                <button type="button" name="approve_records" id="approve_records" <?php echo $disableApprove1 ?> idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Approve</button>
                                 <button type="button" name="check_records" id="reject_records" <?php echo $disableApprove1 ?>  idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-danger btn-round px-5"><i class="fa fa-times"></i>&nbsp;&nbsp;Reject</button>
                                <?php
                              }else{?>
                                <button type="button" name="check_records" id="check_records"  <?php echo $disableApprove ?> idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Approve</button>
                                 <button type="button" name="check_records" id="reject_records" <?php echo $disableApprove ?> idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-danger btn-round px-5"><i class="fa fa-times"></i>&nbsp;&nbsp;Reject</button>
                             <?php  }
                              ?>
                        
                   <?php } ?>
                   <button type="submit" name="edit_permit" class="btn btn-light btn-round px-5" <?php echo $disableApprove ?> ><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>  
          <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" id="img_modal" style="width: 600px; background-color: white; margin-left: -34px;">              
                <div class="modal-body">
                  <button type="button" class="close" style="color: black; font-weight: bold; " id="x_modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <img src="" class="imagepreview" style="width: 100%; height: 450px;" >
                </div>
              </div>
            </div>
          </div>  <!-- card -->
        </form>

        <?php
                    $createClient = new ControllerPermits();
                    $createClient -> ctrEditPermit();
                    $deleteImg = new ControllerPermits();
                    $deleteImg  -> ctrDeleteImg($table);
                    ?>
      </div>
    </div><!--End Row-->
    <script>

$('.pop').click(function(){
   $('.imagepreview').attr('src', $(this).find('img').attr('src'));
   $('#imagemodal').modal('show');   
   })
   $('.close').click(function(){
   
   $('#imagemodal').modal('hide');   
   })
 </script>
  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->