
<style>
    textarea#wp_req_for {
    height: 100px;
}

.text-danger-1 {
    color: red; /* Adjust the color as desired */
}

.modal-content, .modal-footer{
    background-color: #C9E0DC;
}
.modal-title{
    color: black;
}

.modal-body{
    background-color: #F0FAF9;
}
.modal-form-header{
    background-color: #F0FAF9;"
}

.btn-soa{
    background-color: #08655D;
    color: white;
}
.form-control[readonly]{
    background-color: #efebf5;
    border: solid black 1px;
    color: black;
}

.form-control:focus{
    background-color: #efebf5 !important;
    border: solid black 1px;
    color: black;
}


input::placeholder{
   
    color: green;
}
.form-control{
    background-color: white;
    border: solid black 1px;
}

.col-form-label {
    color:#074D47;
}

/* CSS for input file */
[type="file"] {
/* Style the color of the message that says 'No file chosen' */
  color: green;
}
[type="file"]::-webkit-file-upload-button {
  background: green;
  border-radius: 4px;
  color: #fff;
  cursor: pointer;
  font-size: 12px;
  outline: none;
  padding: 10px 25px;
  text-transform: uppercase;
  transition: all 1s ease;
}

[type="file"]::-webkit-file-upload-button:hover {
  background: #fff;
  border: 2px solid black;
  color: #000;
  
}

/* Style the placeholder text for input elements with the class 'form-control' */
.form-control::placeholder {
  color: green !important;
  /* font-style: italic !important; */
}


input#arcDate {
    color: black !important;
}

h5.acrTitle {
    color: #08655D;
    font-weight: bold;
    font-size: 1.3em;
}
.arcBtn{
    color: #9efff6;
    background-color: #08655D;
}

#arcID::placeholder {
    color: black !important;
}
.arcBody {
    height: 329px;
    background-color: #EDFAF8;
    border: 1px solid #a3c3c0;
    border-radius: 7px;
}

#arcTR td {
    border: 1px solid black;
    font-size: 0.8em;
    height: 30px;
}
span#arxX:hover {
    font-size: 1.1em;
    color: red;
}
span#arxX {
    color: #08655d;
}
.arcBtn:hover {
    background-color: #4f8e89;
}
tr#arcTR:hover {
    background-color: #99d4c9;
}

tr#arcTR {
    cursor: pointer;
}
.modal-header.arcHead {
    border-bottom: 1px solid #9EAFAD;
}
.modal-footer.arcFooter {
    border-top: 1px solid #9EAFAD;
}
section#arcInfo {
    color: #053631;
    font-weight: bold;
}
section#arcBody111{
  margin: 5px 29px;
    background: #edfaf8;
    border: 1px solid #92a8a6;
    border-radius: 15px;
    color: #000000;
    font-weight: bold;
    font-size: 0.8em;
}
.arcNote {
    background-color: #F0FAF9;
    border: 1px solid #92a8a6;
    margin: 0px 55px 10px 55px;
    min-height: 100px;
    border-radius: 8px;
}
.noteContent {
  margin: 4px 40px;
}
.noteFooter {
  margin: 7px 0px 10px 52px;
    font-size: 10px;
}
.arcHeader {
    margin: 0px 17px;
}

input#arcInPass::placeholder {
    color: #4e4a4a !important;
}
input#arcInPass {
    color: black !important;
}
input#arcDelPass {
    color: black !important;
}
</style>
<?php 

    $permit = (new Connection)->connect()->query("SELECT * from soa ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
    if(empty($permit)){
        $id = 0;
    }else{
        $id = $permit['id'];
    }
    $last_id = $id + 1;
    $id_holder = "SOA" . str_repeat("0",6-strlen($last_id)).$last_id;     

    date_default_timezone_set('Asia/Manila');
    $date_now =date("F d Y"); 

    $branch_name = $_SESSION['branch_name'];

    $listSOAInfo = (new ControllerSOA)->ctrGetBranchEmpRecords($branch_name);

    if (!empty($listSOAInfo)) {
        foreach ($listSOAInfo as $key => $item) {
            $fa = $item['fa'];
            $boh = $item['boh'];
            $address = $item['address'];
            $tel = $item['tel'];
            $soa_info_id = $item['id'];
        }
        
    } else {
        $soa_info_id = '';
        $fa = '';
        $boh = '';
        $address = '';
        $tel = '';
    }
    
        $first_three_characters = substr($branch_name, 0, 3);

    if ($first_three_characters == 'RLC') {
       
        $new_branch_name = 'RFC' . substr($branch_name, 3);
    } else {
        $new_branch_name = $branch_name;
    }

?>   
<div class="clearfix"></div>
	
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">STATEMENT OF ACCOUNT</h4>
     </div>
   </div> 
    <div class="row">
    
      <div class="col-lg-12">
        <form method="POST" enctype="multipart/form-data" >   
          <div class="card">
            <div class="card-header ml-4">
                <div class="row">
                    <?php 
                    if($_SESSION['type']=="backup_user" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                                
                        <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#soafileUpdate">
                            <img src="views/img/upload_file.png" alt="Image" class="img-fluid" style="width: 200px; height: 150px;">
                            <h5>UPLOAD FILE</h5>
                         </button>

                        <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#searchidsoatrans">
                            <img src="views/img/select_data1.png" alt="Image" class="img-fluid" style="width: 200px; height: 150px;">        
                            <h5>PREPARE RECORD</h5>
                        </button>

                        <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#arcModal">
                            <img src="views/img/archeive_data.png" alt="Image" class="img-fluid" style="width: 200px; height: 150px;">
                            <h5>RECORD ARCHIVE</h5>
                        </button>

                        <button type="button" class="btn btn-transparent border border-3 border-white btn btn-round waves-effect text-white btn-md waves-light m-1" data-toggle="modal" data-target="#soaUpdateInfo">
                            <img src="views/img/update_info1.png" alt="Image" class="img-fluid" style="width: 200px; height: 150px;">
                            <h5>UPDATE INFO</h5>
                        </button>

                <?php  }?>
                </div>  
            </div>   
            <div class="card-body">
            </div>                                     
            <div class="card-footer">
              
            </div>  <!-- footer -->

          </div>    <!-- card -->
        </form>
      </div>
    </div><!--End Row-->

        <!-- UPDATE FILE MODAL -->
        <div class="modal fade" id="soafileUpdate"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLongTitle"><strong>UPDATE SOA RECORDS</strong></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body mb-0">
                  <div class="card">
                  <div class="card-header modal-form-header">
                    <div class="row mt-3 ml-2">
                        <div class="col-12 mb-3">
                            <input type="hidden" class="form-control text-success" readonly id="branch_name" value="<?php echo $_SESSION['branch_name'];?>" name="branch_name" placeholder="Enter Date" autocomplete="nope" required>
                            <input type="text" class="form-control text-success" readonly value="<?php echo $new_branch_name;?>" placeholder="Enter Date" autocomplete="nope">
                        </div>
                        <div class="col-12">
                            <input type="file" class="border border-dark col-12" id="soa_file" name="soa_file"/>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" name="addsoa" id="addsoa" class="btn-soa btn">SUBMIT</button>
                  <button type="button"  class="btn btn-soa" data-dismiss="modal">Close</button>
                </div>
              </form>
              <?php
                      $updateRecord = new ControllerSOA();
                      $updateRecord -> ctrUpdateSOAFileRecords();
                ?>
             
           </div>
        </div>
      </div>
     <!-- END UPDATE FILE MODAL -->

    <!-- SEARCH PDR ACCOUNT BY ID MODAL2 -->
    <div class="modal fade" id="searchidsoatrans"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><strong>GENERATE STATEMENT OF ACCOUNT</strong></h5>
                    <button type="button" class="close resetSOAButton p-3" aria-label="Close">
                            <span aria-hidden="true" id="resetSOAButton" style="color: red;">&times;</span>
                    </button>
            </div>
            <form method="post" id="SOAForm" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="card">
                    <div class="card-header modal-form-header">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="inputIdNo" class="col-form-label">ID NO :</label>
                            </div>
                            <div class="col-2">
                                <input type="text" id="soa_account_no" name="soa_account_no" class="form-control border border-dark text-success" placeholder="Enter ID">
                                <input type="text" id="soa_id" name="soa_id" hidden value="<?php echo $id_holder?>"  class="form-control" placeholder="select ID">
                                <input type="text" id="soa_branch_name" hidden name="soa_branch_name" value="<?php echo $_SESSION['branch_name'];?>" class="form-control" placeholder="select ID">
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-soa waves-effect waves-lih showSOADetails">
                                    <i class="fa fa-eye"></i> <span>SHOW DETAILS</span>
                                </button>
                            </div>
                            <div class="col-4">
                                <i class="col-form-label">Date issued:</i>
                                <p class="text-success  bg-transparent"><?php echo date('M-d-y h:i:s A',time());?></p>
                            </div>
                            
                        </div>
                    </div>
            
                    <div class="card-body modal-form-header">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_name" class="col-form-label">NAME :</label>
                            </div>
                            <div class="col-10 d-inline-flex">
                                <input type="text" id="soa_name" readonly name="soa_name" class="form-control text-success" placeholder="Enter Name">
                            </div> 
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_address" class="col-form-label">ADDRESS :</label>
                            </div>
                            <div class="col-10 d-inline-flex">
                                <input type="text" id="soa_address" readonly name="soa_address" class="form-control text-success" placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_bank" class="col-form-label">BANK :</label>
                            </div>
                            <div class="col-4 d-inline-flex">
                                <input type="text" id="soa_bank" readonly name="soa_bank" class="form-control text-success" placeholder="Enter Bank">
                            </div>
                            <div class="col-2">
                                <label for="soa_pension" class="col-form-label">PENSION :</label>
                            </div>
                            <div class="col-4 d-inline-flex">
                                <input type="text" id="soa_pension" readonly name="soa_pension" class="form-control text-success" placeholder="Enter Pension">
                            </div>
                        </div>
                     
                    </div>      

                    <div class="card-body modal-form-header">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_lr" class="col-form-label">LR :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="text" readonly id="soa_lr" name="soa_lr" class="form-control text-success calculateEndTotal soa_lr" placeholder="0.00">
                            </div> 
                            <div class="col-1"></div>
                            <div class="col-1">
                                <label for="soa_sl" class="col-form-label">SL :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="text" readonly id="soa_sl" name="soa_sl" class="form-control calculateEndTotal soa_sl" placeholder="0.00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_interest" class="col-form-label">Interest :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="number" id="soa_interest" name="soa_interest" class="form-control text-success calculateEndTotal soa_interest" placeholder="0.00">
                            </div>
                            <div class="col-1"></div>

                            <div class="col-2.1">
                                <label for="soa_address" class="col-form-label">Others :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="number" id="soa_others" name="soa_others" class="form-control text-success calculateEndTotal soa_others" placeholder="0.00">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_from" class="col-form-label">From :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="date" id="soa_from" required name="soa_from" class="form-control text-success" placeholder="Enter Name">
                            </div>

                            <div class="col-1"></div>

                            <div class="col-3.1">
                                <label for="soa_balance_of" class="col-form-label ">Balance as of :</label>
                            </div>
                            <div class="col-4 d-inline-flex pt-2">
                                <h5 class="text-success"><?php echo date("m/d/Y", time()); ?></h5>
                  </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_to" class="col-form-label">To :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="date" id="soa_to" required name="soa_to" class="form-control text-success" placeholder="Enter Name">
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 d-inline-flex">
                                <input type="text" id="soa_balance_of" readonly name="soa_balance_of" class="form-control soa_balance_of text-success" placeholder="0.00">
                            </div>
                       
                        </div>
                     
                    </div>
                    
                    <div class="card-body modal-form-header">
                    <label for="soa_address" class="col-form-label">NOTE</label>
                    <div class="row mb-3">
                            <div class="col-2">
                                <label for="soa_note_date" class="col-form-label">Date :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="date" id="soa_note_date" required name="soa_note_date" class="form-control text-success" placeholder="Enter Name">
                            </div>
                            <div class="col-1">
                               
                            </div>
                            <div class="col-2">
                                <label for="soa_note_time" class="col-form-label">Time :</label>
                            </div>
                            <div class="col-3 d-inline-flex">
                                <input type="time" id="soa_note_time" required name="soa_note_time" class="form-control text-success soa_note_time" placeholder="Enter Name">
                            </div>
                       
                        </div>
            
                        <div class="row mb-3">
                            <div class="col-2">
                            </div>
                            <div class="col-10 d-inline-flex">
                                <textarea type="text" id="soa_note" readonly name="soa_note" class="form-control text-success" placeholder="Enter Note">SCHEDULE FOR THE GAWAD OF ACCOUNT AND RELEASING OF ATM IS ON (DATE) NOT LATER THAN (TIME)  </textarea>
                            </div>
                        </div>
                    </div> 
                </div><!--card-->
                </div>
                    <div class="modal-footer">
                    <button type="button" id="soa_print" hidden class="btn btn-soa"><i class="fa fa-print"></i> <span>&nbsp;PRINT</span> </button>
                    <button type="button" name="addSOARecordById" id="addSOARecordById" class="btn btn-soa"><i class="fa fa-save"></i><span>&nbsp;Save</span></button>
                    <button type="button" class="btn btn-soa resetSOAButton" id="resetSOAButton"><i class="fa fa-close"></i><span>&nbsp;Close</span></button>
                    </div>
        
            </div>
        </form>
            <?php
                    // $addSOARecords = new ControllerSOA();
                    // $addSOARecords -> ctrAddSOARecordById();
            ?>
        </div>
    </div>
    <!-- END  SEARCH PDR ACCOUNT BY ID MODAL1 -->

      <!-- UPDATE FILE MODAL -->
      <div class="modal fade" id="soaUpdateInfo"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong>UPDATE INFORMATION</strong></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body mb-0">
                  <div class="card">
                  <div class="card-header modal-form-header">
                    <div class="row">
                    
                        <input type="text" class="form-control" hidden id="soa_info_id" name="soa_info_id" value="<?php echo $soa_info_id;?>" placeholder="" autocomplete="nope">
                        <div class="col-12">
                                <label for="soa_branch_name" class="col-form-label">BRANCH NAME :</label>
                        </div>
                        <div class="col-12 mb-3">
                              <input type="text" class="form-control text-success" value="<?php echo $new_branch_name;?>">
                            <input type="hidden" class="form-control text-success" id="soa_branch_name" name="soa_branch_name" value="<?php echo $branch_name;?>" placeholder="Enter Branch Operations Head" autocomplete="nope" required>
                        </div>
                        <div class="col-12">
                                <label for="soa_address" class="col-form-label">Financial & Accounting :</label>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control text-success" id="soa_branch_fa" name="soa_branch_fa" value="<?php echo $fa;?>" placeholder="Enter Finacial Accountant" autocomplete="nope" required>
                        </div>
                        <div class="col-12 mt-3">
                                <label for="soa_address" class="col-form-label">Branch Operations Head :</label>
                            </div>
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control text-success" id="soa_branch_boh" name="soa_branch_boh" value="<?php echo $boh;?>" placeholder="Enter Branch Operations Head" autocomplete="nope" required>
                        </div>
                    </div>
                  </div>
                  <div class="card-header modal-form-header">
                     <div class="row">
                        <div class="col-12">
                                <label for="soa_address" class="col-form-label">Company Address :</label>
                            </div>
                        <div class="col-12">
                            <input type="text" class="form-control text-success" id="soa_branch_address" name="soa_branch_address" value="<?php echo $address;?>" placeholder="Enter Address" autocomplete="nope" required>
                        </div>
                        <div class="col-12 mt-3">
                                <label for="soa_address" class="col-form-label">Telephone Number :</label>
                            </div>
                        <div class="col-12">
                            <input type="text" class="form-control text-success" id="soa_branch_tel" name="soa_branch_tel" value="<?php echo $tel;?>" placeholder="Enter Telephone Number" autocomplete="nope" required>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" name="add_soa_info" id="add_soa_info" class="btn btn-soa">UPDATE</button>
                  <button type="button"  class="btn btn-soa" data-dismiss="modal">Close</button>
                </div>
              </form>
              <?php
                      $updateRecord = new ControllerSOA();
                      $updateRecord -> ctrAddSOABranchInfo();
                ?>
             
           </div>
        </div>
      </div>
     <!-- END UPDATE FILE MODAL -->


    <!-- START modal Archive -->
    <div class="modal fade" id="arcModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#edfaf8;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Access Archived Records</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6" style="color:black">SELECT DATE</label>
                        <input type="month" style="border: 1px solid #08655d;" class="form-control chkDate"  id="arcDate" placeholder="Enter Folder Name" name="date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"  id="arcBtn1" class="btn btn-light arcBtn">Submit</button>
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for Archive-->


    <!-- START modal Archive1 -->
    <div class="modal fade" id="arcModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title acrTitle" id="exampleModalLongTitle">SOA Archived</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="arxX">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2 form-group">
                        <input type="text" style="border: 1px solid #08655d;" class="form-control"  id="arcID" placeholder="Enter ID" name="date">
                    </div>
                    <div class="col-sm-2">
                      <button type="button" id="arcSearch" class="btn btn-light arcBtn">Search</button>
                    </div>
                  <div class="col-sm-8 text-right">
                      <button type="button" id="arcLogs" data-toggle="tooltip" title="Logs" class="btn btn-light arcBtn"><i class="fa fa-history"></i></button>
                    </div>
                </div>
                <div class="row ml-0" style="height: 300px; border: 1px solid #c3c3c3;">
                            <div class="col-lg-12" style="border: 1px solid black; overflow: auto; max-height: 300px;">
                                <table class="mt-2" style="min-width: 1000px;">
                                            <thead style="position: sticky; top: 0; background-color: #08655d; z-index: 1; ">
                                                <tr style="color: white; text-align:center;">
                                                    <th style="width:55px;  border:1px solid black;">Action</th>
                                                    <th style="width:55px;  border:1px solid black;">ID</th>
                                                    <th  style="width:210px; border:1px solid black;" >NAME</th>
                                                    <th  style="width:330px;  border:1px solid black;">ADDRESS</th>
                                                    <th  style="width:70px;  border:1px solid black;">BANK</th>
                                                    <th style="width:80px;  border:1px solid black;">LR</th>
                                                    <th  style="width:70px;  border:1px solid black;">SL</th>
                                                    <th  style="width:70px;  border:1px solid black;">BALANCE</th>
                                                </tr>
                                            </thead>
                                            <tbody style="color: black; text-align:center" id="soaTable">
                                             
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for Archive-->


   <!-- START modal Archive2 -->
   <div class="modal fade" id="arcModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header arcHead">
                <h5 class="modal-title acrTitle" id="exampleModalLongTitle">Pensioner SOA Archived</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="arxX">&times;</span>
                </button>
            </div>
            <div class="modal-body arcModalBody">
                
            </div>
            <div class="modal-footer arcFooter">
                <button type="button"  class="btn btn-light arcBtn" id="arcReprint" data-toggle="modal" data-target="#arcPassword">Reprint</button>
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for Archive-->

   <!-- START modal Password -->
   <div class="modal fade" id="arcPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header arcHead">
                <h5 class="modal-title acrTitle" id="exampleModalLongTitle">Reprint SOA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="arxX">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                          <input type="password" style="border: 1px solid #08655d;" class="form-control"  id="arcInPass" placeholder="Enter password" name="pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer arcFooter">
                <button type="button"  class="btn btn-light arcBtn" id="printArcSOA">Print</button>
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for Password-->
   <!-- START modal Delete -->
   <div class="modal fade" id="arcDelPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header arcHead">
                <h5 class="modal-title acrTitle" id="exampleModalLongTitle">DELETE SOA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="arxX">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                          <input type="password" style="border: 1px solid #08655d;" class="form-control"  id="arcDelPass" placeholder="Enter password" name="pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer arcFooter">
                <button type="button"  class="btn btn-light arcBtn" id="deleteArcSOA">Delete</button>
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for Delete-->

   <!-- START modal LOGS -->
   <div class="modal fade" id="arcModalLogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color:#C9E0DC;">
            <div class="modal-header">
                <h5 class="modal-title acrTitle" id="exampleModalLongTitle">SOA LOGS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="arxX">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row ml-0" style="height: 300px; border: 1px solid #c3c3c3;">
                        <div class="col-lg-12" style="border: 1px solid black; border: 1px solid black; overflow: auto; max-height: 300px;">
                            <table class="mt-2" style="min-width: 739px;">
                                        <thead style="position: sticky; top: 0; background-color: #08655d; ">
                                            <tr style="color: white; text-align:center;">
                                                <th style="width: 70px;border:1px solid black;">ID</th>
                                                <th  style="width: 280px;border:1px solid black;" >NAME</th>
                                                <th  style="width: 100px;border:1px solid black;">TYPE</th>
                                                <th  style="width: 140px;border:1px solid black;">TIME</th>
                                            </tr>
                                        </thead>
                                        <tbody style="color: black; text-align:center" id="soaLogsTable">
                                            
                                        </tbody> 
                                    </table>
                                </div>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light arcBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal for LOGS-->

  <div class="overlay toggle-menu"></div>
  </div>    <!-- container-fluid -->
</div>      <!-- content-wrapper -->