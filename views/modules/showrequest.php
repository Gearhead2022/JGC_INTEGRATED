<?php 
 $idClient = $_GET['idClient'];

 $clients = (new Connection)->connect()->query("SELECT * FROM working_permit WHERE id = $idClient")->fetch(PDO::FETCH_ASSOC);
 $wp_to = $clients['wp_to'];
 $ref_id = $clients['ref_id'];
 $wp_from = $clients['wp_from'];
 $wp_date = $clients['wp_date']; 
 $status = $clients['status']; 
 $wp_req_for = $clients['wp_req_for'];
 $branch = $clients['branch'];
 $wp_req_by = $clients['wp_req_by'];
 $wp_chk_by = $clients['wp_chk_by'];
 $wp_app_by = $clients['wp_app_by'];
 $wp_app_by1 = $clients['wp_app_by1'];
 $app = $clients['app'];
 $app1 = $clients['app1'];
 $chk = $clients['chk'];
 $wp_remarks= $clients['wp_remarks'];
 $type= $clients['type'];
 $wp_date = date('F d Y h:i:sa', strtotime($wp_date));
$table = "permit_files";
 $attch = (new ControllerPermits)->ctrShowImg($table, $ref_id);
 $user = $_SESSION['type'];
 $full_name = $_SESSION['branch_name'];

 if($type === "PSPMI" && $wp_from !== 8){
        $disableApprove = $app === 0 ? "" : "disabled";
 }else{
        $disableApprove = $app1 === 0 ? "" : "disabled";
 }

 
 if($wp_from == 1){
        $department = "ACCOUNTING DEPARTMENT";
 }elseif($wp_from == 2){
        $department = "OPERATION DEPARTMENT";
 }elseif($wp_from == 3){
        $department = "HROM DEPARTMENT";
 }elseif($wp_from == 4){
        $department = "FINANCIAL DEPARTMENT";
 }elseif($wp_from == 5){
        $department = "AUDIT DEPARTMENT";
 }elseif($wp_from == 6){
        $department = "CREDIT AND COLL DEPARTMENT"; 
}elseif($wp_from == 7){
        $department = "GRCD DEPARTMENT"; 
}elseif($wp_from == 8){
        $department = "PSPMI"; 
}elseif($wp_from == 9){
        $department = "MIS DEPARTMENT"; 
}else{
        $department = "OTHER DEPARTMENT";
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
}    textarea#wp_remarks {
    height: 100px;
}.app {
    content: "\f00c";
    color: #14abef;
    font-size: 28px;
}

.mobile-row{
        min-width: 20rem;
        text-align: start;
}

.mobile-text{
        min-width: 10rem;
        width: 100%;
        font-weight: bold;
}

.mobile-text2{
        padding-inline: 5rem;
}

/* @media (max-width: 639px) {
  .mobile-row{
    display: flex;
  }
} */
</style>
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">WORKING PERMIT</h4>
     </div>
   </div> 

    <div class="row">
      <div class="col-lg-12">
        <form  method="POST" enctype="multipart/form-data" autocomplete="nope">
          <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                        <div class="div-sm-12">
                        <a href="extensions/tcpdf/pdf/print_permit.php?ref_id='<?php echo $clients['ref_id'];?>'" target="_blank"><button type="button" class="btn btn-light btn-round px-5"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button></a>
                        </div>
                </div>
                <div class="row mobile-row">
                    <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">REFERENCE NO.</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $ref_id ?></p>
                    </div>
                 </div>
                 <div class="row">
                  <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">TO</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_to ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">FROM</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $department ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">DATE</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_date ?></p>
                    </div>
                 </div>
                 <div class="row">
                        <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">REQUEST FOR</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_req_for ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">BRANCH</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $branch ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">REQUESTED BY</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_req_by ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">CHECKED BY</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_chk_by ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">APPROVED BY</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php if($app>0){ ?><i  class="fa fa-check app"></i> <?php }echo $wp_app_by ?></p><br>
                            <p><?php if($app1>0){ ?><i class="fa fa-check app"></i> <?php } echo $wp_app_by1 ?></p>
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-sm-3 form-group">
                        <div class="d-flex gap-2 ">
                                <p class="mobile-text">REMARKS</p>
                                <p class="mobile-text2">:</p>
                        </div>
                    </div>
                    <div class="col-sm-9 form-group">
                            <p><?php echo $wp_remarks ?></p>
                    </div>
                 </div>
                 <div class="row mt-3">
                    <div class="col-sm-12">
                    <label for="input-6">Attactments</label>
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
                    
                    </div>
                    <?php } ?>
                  </div>  
                </div>
            <div class="card-footer">
              <div class="row">
               
                <div class="col-lg-12">
                  <div class="float-sm-right d-flex gap-2">
                  <?php if($user == "wp_accounting" || ($type == "PSPMI" && $wp_from == 9 && $full_name == "EGG")){ ?>
                   <button type="button" name="check_records" id="check_records" idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;CHECK</button>
                   <?php } ?>
                  <?php if(($user == "wp_approve" && $full_name != "EGG" && $type == "PSPMI") || ($user == "wp_approve"  && $type == "MIS" )  ) { ?>
                   <button type="button" <?php echo $disableApprove ?> name="approve_records" id="approve_records" idClient="<?php echo $idClient; ?>" user="<?php echo $user; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Approve</button>
                   <?php } ?>
                <?php if(($user == "wp_mis" || $user == "admin" || ($user == "wp_pspmi_admin" && $type =="PSPMI") )     && $status == "Pending"){ ?>
                   <button type="button" name="receive_records" id="receive_records" idClient="<?php echo $idClient; ?>" user="<?php echo $full_name; ?>"  class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Receive</button>
                   <?php } ?>
                <?php if(($user == "wp_admin" || $user == "admin" || $user == "wp_mis" || ($user == "wp_pspmi_admin" && $type =="PSPMI") ) && ($status == "Inprogress" || $status == "P-Approved" || $status == "Done")  ){ ?>
                   <button type="button" name="records" id="records" data-toggle="modal" data-target="#exampleModalCenter" <?php if($status =="Done"){ echo "Disabled";} ?> class="btn btn-success btn-round px-5"><i class="fa fa-check"></i>&nbsp;&nbsp;Done</button>
                   <?php } ?>
                   <button type="button" class="btn btn-light btn-round px-5" onClick="location.href='workingpermit'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                           
                  </div>
                </div>
              </div>
            </div>  <!-- footer -->

          </div>  
          <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                       
                        <textarea class="form-control"  style="white-space: pre-wrap;" id="wp_remarks" placeholder="Enter Remarks" name="wp_remarks" autocomplete="nope" required></textarea>
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" name ="done_records" idClient="<?php echo $idClient; ?>" status="<?php echo $status;?>" id="done_records"  class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
           </div>
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
                    $createPermit = new ControllerPermits();
                    $createPermit -> ctrDone();
                    $createPermit -> ctrApprove();
                    $createPermit -> ctrCheck();
                    $createPermit -> ctrReject();
                    $createPermit -> ctrReceived();
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

