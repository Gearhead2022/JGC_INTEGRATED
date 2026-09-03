<style>
#addItemModal h5#exampleModalLongTitle,
 #editItemModal h5#exampleModalLongTitle ,
 #confirmDeleteModal  h5,
 #batchPrintModal  h5,
 #addUnregisteredModal  h5,
 .modalLayout  h5,
 #historyModal  h5{
    color: black;
}
#addItemModal .modal-content,
 #editItemModal .modal-content,
  #confirmDeleteModal .modal-content, 
  #batchPrintModal .modal-content,
  #addUnregisteredModal .modal-content,
  #auditScanModal  .modal-content,
  .modalLayout  .modal-content,
  #historyModal .modal-content{
    background-color: #C9E0DC;
}
#scanItemModal .modal-content {
    background-color: #C9E0DC;
}

#addItemModal .modal-body .form-control ,
 #editItemModal .modal-body .form-control , 
 #addUnregisteredModal .modal-body .form-control , 
 #auditScanModal .modal-body .form-control , 
 .modalLayout .modal-body .form-control , 
 #confirmDeleteModal .modal-body .form-control {
    border: solid 1px #6e6e6e;
    color: black !important;
}
#addItemModal .modal-body label,
 #editItemModal .modal-body label, 
 #batchPrintModal .modal-body label ,
 #addUnregisteredModal .modal-body label ,
 #auditScanModal .modal-body label ,
 .modalLayout .modal-body label ,
 #historyModal .modal-body label { 
    color: black !important;
}
#addItemModal .modal-header ,
#addUnregisteredModal .modal-header ,
#auditScanModal .modal-header ,
.modalLayout .modal-header ,
 #editItemModal .modal-header { 
    border-bottom: solid 1px white;
}

#addItemModal .modal-footer,
#addUnregisteredModal .modal-footer,
#auditScanModal .modal-footer,
#auditScanModal .modal-footer,
.modalLayout .modal-footer {
    border-top: 1px solid white;
}

#addItemModal .modal-content, 
#addUnregisteredModal .modal-content, 
#auditScanModal .modal-content, 
.modalLayout .modal-content, 
#editItemModal .modal-content {
    background: #C9E0DC;
}

#addItemModal .modal-body .form-control::placeholder ,
 #editItemModal .modal-body .form-control::placeholder , 
 #addUnregisteredModal .modal-body .form-control::placeholder , 
 #auditScanModal .modal-body .form-control::placeholder , 
 .modalLayout .modal-body .form-control::placeholder , 
 #confirmDeleteModal .modal-body .form-control::placeholder {
    color: #547861 !important; /* Change this to the desired placeholder color */
}
#addItemModal .modal-body select option,
 #editItemModal .modal-body select option, 
 #addUnregisteredModal .modal-body select option, 
 #auditScanModal .modal-body select option, 
 .modalLayout .modal-body select option, 
 #batchPrintModal .modal-body select option{
    background-color: #f0f0f0 !important; /* Change to desired option background color */
    color: black !important; /* Change to desired option text color */
}

#addItemModal .modal-body .form-control:read-only , 
#addUnregisteredModal .modal-body .form-control:read-only , 
#auditScanModal .modal-body .form-control:read-only , 
.modalLayout .modal-body .form-control:read-only , 
#editItemModal .modal-body .form-control:read-only {
    background-color: #a5dab33d; /* Change to desired background color */
  
}
#item_name, #serial_no, #item_description, #supplier {  
    text-transform: uppercase;
}
.btnGroup i{
    font-size: 1.4em;
}
#confirmDeleteModal p {
    color: black;
}
.batchContent{
    background-color: #F0FAF9;
    border: 1px solid #074D47;
    margin: 9px 4px;
    height: 21em;
    overflow-y: auto;
}
#batchPrintModal{
    color: black;
}
#batchPrintModal .modal-body .form-control::placeholder{
    color: #547861 !important; /* Change this to the desired placeholder color */
}
#batchPrintModal .modal-body select option{
    background-color: #f0f0f0 !important; /* Change to desired option background color */
    color: black !important; /* Change to desired option text color */
}
#batchPrintModal .modal-body .form-control{
    border: solid 1px #6e6e6e;
    color: black !important;
    }
    .batchContent h5{
            margin-top: 0.8em;
            color: black;
            text-align: center;
    }
    .checkDesign {
    display: flex;
    border: 1px solid black;
    width: 7em;
    height: 2.4em;
    justify-content: space-evenly;
    align-items: center;
    color: black;
}
.checkContent {
    display: flex;
    gap: 1em;
}

input.me-2.item-checkbox {
    width: 17px;
    height: 19px;
}
.historyContent{
    background-color: #F0FAF9;
    border: 1px solid #a1cfcb;
    margin: 9px 4px;
    height: 21em;
    overflow-y: auto;
}
.historyContent thead{
    background-color: #5F9C97;
    color: black;
    height: 2.3em;
}
.historyContent tbody{
    color: black;
}
.historyContent  tbody tr:nth-child(odd) {
    background-color: #B6D2D0; /* Color for odd rows */
    height: 2.4em;
}

.historyContent  tbody tr:nth-child(even) {
    background-color: #D2E6E5; /* Color for even rows */
    height: 2.4em;
}
.row.auditTable {
    display: flex;
    flex-direction: column;
}
.row.auditTable {
    background-color: #F0FAF9;
    color: black;
}
.headerTable h6{
    color: black !important;
}
.tableBody table {
    width: 97%;
    margin-left: 7px;
}
.tableBody thead{
    background-color: #08655D;
    color: white;
}
.tableHead {
    position: sticky;
    top: 0;
    background-color: #f2f2f2;
    z-index: 1;
}
.tableBody{
    height: 150px;
    overflow-y: auto;
}

h6.auditInfo {
    cursor: pointer;
    padding-left: 7px;
    padding-top: 5px;
}
h6.auditInfo:hover {
    font-size: 1.1em;
}

#auditList .modal-content{
    background: #b6dac7;
    color: black;
}

#auditList th, #auditList td {
    border: 1px solid black;
}
#auditList table{
    text-align: center;
    width: 100%;
    

}
button.btnRequest.ml-4 {
    border-radius: 10%;
    background-color: #9febd9;
    height: 2rem;
    width: 6rem;
}
button.btnRequest:hover {
    background-color: #83dec8;
}
.select2-selection--multiple .select2-selection__choice{
    color: black;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    opacity: 0;
}
.select2-container {
    border: 1px solid black;
}

.computer_set {
    display: none; /* Initially hide the div */
    opacity: 0; /* Set initial opacity to 0 for transition effect */
    transition: opacity 0.5s ease-in-out; /* Smooth transition for opacity */
}

.computer_set.show {
    display: block;
    opacity: 1;
}

.computer_set.hide {
    opacity: 0;
    display: none;
}


.cctv_set {
    display: none; /* Initially hide the div */
    opacity: 0; /* Set initial opacity to 0 for transition effect */
    transition: opacity 0.5s ease-in-out; /* Smooth transition for opacity */
}

.cctv_set.show {
    display: block;
    opacity: 1;
    display: flex;
}

.cctv_set.hide {
    opacity: 0;
    display: none;
}

.row.setTitle {
    display: flex;
    flex-direction: column;
    padding: 0rem 0rem 0rem 1rem;
}
.row.setAddRow {
    display: flex;
    justify-content: space-between;
}
.setMainBody {
    display: flex;
    flex-direction: column;
    background-color: #F0FAF9;
    color: black;
    height: 28rem;
    border-radius: 8px;
}
.primarySet, .additionalItem {
    border: 1px solid #4c9e97;
    height: 12rem;
    margin: 1rem;
    border-radius: 8px;
    
}

.primarySet table, .additionalItem table{
  width: 100%;
    
}
.itemContent {
    padding: 1rem;
    overflow-y: auto;
    height: 11.6rem;
}
.row.setAddRow {
    padding: 0rem 1rem 1rem;
}

.itemContent table thead {
    position: sticky;
    top: -15px;
    background-color: #c9e0dc; /* Optional: Ensure the header has a background color */
    z-index: 1; /* Make sure it stays on top when scrolling */
}
.optionSelect.form-group {
    display: flex;
    width: 50%;
    margin: 0rem 1rem;
}
#displayBox {
    margin-top: 20px; 
    padding: 10px;
    border: 1px solid #2d7733;
    color: black;
    border-radius: 7px;
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
    align-items: stretch;
    justify-items: start;
    align-content: space-evenly;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Adjust as needed */
}



.selected-item {
    border: 1px solid #44b5a1;
    background-color: #a7e5d3;
    padding: 5px;
    border-radius: 5px;
}
button.remove-btn {
    background-color: #5e7969;
    border: none;
    border-radius: 18px;
    color: #c9e0dc;
}
button.remove-btn:hover {
    background-color: #925448;
}
td#removeSet:hover {
    font-size: 1.1em;
}
td#removeSet {
    color: red;
    cursor: pointer;
}
</style>
<?php
  require 'vendor/autoload.php'; // Autoload Composer dependencies

        $backup = (new Connection)->connect()->query("SELECT * from inventory ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
         if(empty($backup)){
           $id = 0;
         }else{
           $id = $backup['id'];
         }
        $last_id = $id + 1;
        
         $id_holder = "IC" . str_repeat("0",5-strlen($last_id)).$last_id;     

         date_default_timezone_set('Asia/Manila');
             $date_now =date('Y-m-d'); 

         $user_id = $_SESSION['user_id'];
         $branch_name = $_SESSION['branch_name'];
         $type = $_SESSION['type'];


         // Define an array with branch names
$branches = [
    "ALL",
    "EMB MAIN BRANCH",
    "EMB CADIZ",
    "EMB LA CARLOTA",
    "EMB KABANKALAN",
    "EMB ILOILO",
    "EMB DUMAGUETE",
    "EMB SAN CARLOS",
    "EMB TAGBILARAN",
    "EMB MANDAUE",
    "EMB ROXAS",
    "EMB SAGAY",
    "EMB VICTORIAS",
    "EMB BAYAWAN",
    "EMB BAIS",
    "EMB LA CASTELLANA",
    "EMB PASSI",
    "EMB SARA",
    "EMB SIPALAY",
    "EMB CEBU",
    "EMB TALISAY",
    "EMB TOLEDO",
    "EMB MAMBUSAO",
    "EMB MIAG AO",
    "EMB DANAO",
    "EMB TUBIGON",
    "EMB SIQUIJOR",
    "MAIN HOLDING / C&C",
    "MAIN HOLDING / MIS",
    "MAIN HOLDING / HROM",
    "MAIN HOLDING / OPR",
    "MAIN HOLDING / ACCT",
    "FCH BACOLOD",
    "FCH SILAY",
    "FCH BAGO",
    "FCH MURCIA",
    "FCH BINALBAGAN",
    "FCH HINIGARAN",
    "FCH LAPU LAPU",
    "FCH PARANAQUE",
    "FCH MUNTINLUPA",
    "RFC BURGOS",
    "RFC KALIBO",
    "RFC SINGCANG",
    "RFC ANTIQUE",
    "RFC CULASI",
    "ELC BULACAN"
];

?>  
<div class="content-wrapper">
  <div class="container-fluid">
   <div class="row pt-2 pb-2">
     <div class="col-sm-12">
  	    <h4 class="page-title">INVENTORY SYSTEM</h4>
     </div>
   </div> 
   <div class="row">
    
    <div class="col-lg-12">
        <div class="card">
          <div class="card-header ml-2">
             
              <div class="row">
                <?php 
                    if($type == "admin" || $type == "inventory_admin"){
                ?>
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id="addQRCode1"  data-toggle="modal" data-target="#addItemModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-plus"></i> <span>&nbsp;ADD ITEM</span> </button>
                </div>
              
                <!-- <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id=""  data-toggle="modal" data-target="#addItemModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-upload"></i> <span>&nbsp;IMPORT</span> </button>
                </div> -->
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name=""  data-toggle="modal" data-target="#batchPrintModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-print"></i> <span>&nbsp;BATCH PRINT</span> </button>
                </div>
                <?php } ?>
                <?php 
                    if($type == "inventory_mis" || $type == "backup_user" || $type == "inventory_user" ){
                ?>
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id="scanClick"  data-toggle="modal" data-target="#scanItemModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-qrcode"></i> <span>&nbsp;SCAN ITEM</span> </button>
                </div>
                <?php } ?>
                <?php 
                    if($type == "inventory_mis"){ ?>
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id="unregisteredModal"  data-toggle="modal" data-target="#addUnregisteredModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-plus"></i> <span>&nbsp;UNREGISTERED</span> </button>
                </div>
                <?php }?>
                <?php 
                    if($type == "inventory_audit"){ ?>
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id="auditScan"  data-toggle="modal" data-target="#auditScanModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-plus"></i> <span>&nbsp;SCAN ITEM</span> </button>
                </div>
               
                <?php }?>   
                <?php 
                    if($type == "backup_user" || $type == "inventory_user"){ ?> 
                <div class="col-sm-1.3 form-group">   
                    <button type="button" name=""  onclick="window.open('views/modules/excel.php', '_blank')" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-plus"></i> <span>&nbsp;ADD FFE</span> </button>
                </div>
                <?php }?>   
                <!-- <div class="col-sm-1.3 form-group">  
                    <button type="button" name="" id="scanClick"  data-toggle="modal" data-target="#historyModal" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-history"></i> <span>&nbsp;HISTORY</span> </button>
                </div> -->
                <div class="col-sm-1.3 form-group">  
                    <button type="button" name=""  data-toggle="modal" data-target="#inventoryReport" class="btn btn-transparent btn-round text-white border border-white waves-effect waves-light m-1  "><i class="fa fa-file-text"></i> <span>&nbsp;REPORT</span> </button>
                </div>
              </div>        
          </div>   
          <div class="card-body">
          <div class="table-responsive">
            <table id="default-datatable" class="table table-bordered table-hover table-striped inventoryTable">
              <thead>
              <tr>
                <th>Action</th>
                <th>STICKER NO.</th>
                <th>ITEM NAME</th>
                <th>BRANCH / DEPARMENT</th>
                <th>DATE PURCHASED</th>
                <th>STATUS</th>
                <th>CURRENT LOCATION</th>
                <th>MOVEMENT</th>
              </tr>
              </thead>
            </table>
            
          </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-lg-3">
              </div>
              <div class="col-lg-9">
                <div class="float-sm-right">
                 <!-- <button type="submit" name="submit" class="btn btn-light btn-round px-5"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button> -->
                 <!--<button type="button" class="btn btn-light btn-round px-5" onClick="location.href='fullypaid'"><i class="fa fa-list"></i>&nbsp;&nbsp;Listing</button>                            -->
                </div>
              </div>
            </div>
          </div>  <!-- footer -->
        </div>    <!-- card -->
    </div>
 <!-- Generate Daily Checklist Modal -->
 <!-- <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="addUnregisteredModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD UNREGISTERED ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9 form-group">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="input-1">ITEM CODE</label>
                                <input type="text"  class="form-control" id="unitem_code" readonly  name="item_code">
                                <input type="text"  class="form-control" id="branch_name" hidden value="<?php echo $branch_name; ?>" name="branch_name">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">COMPANY</label>
                                <select class="form-control "  name="company">
                                    <option  selected  value=""><- Select Company -></option>
                            
                                </select>
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">STICKER NO.</label>
                                <input type="text" readonly class="form-control"   name="sticker_no">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">DATE PURCHASED</label>
                                <input type="date"  class="form-control" id="date_acquired"  name="date_purchased">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="input-1">ITEM DESCRIPTION</label>
                                <input type="text" class="form-control" id="item_description" required placeholder="Enter item description" name="item_description">
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="input-1">PRICE</label>
                                <input type="text"  placeholder="Enter price" pattern="\d*" title="Only numbers are allowed" class="form-control" id="price"  name="price">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">SERIAL NO.</label>
                                <input type="text"  placeholder="Enter serial number" class="form-control" id="serial_no"  name="serial_no">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="input-1">Location</label>
                                <input type="text" placeholder="Enter item location"  class="form-control" id="item_name"  name="item_location">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="input-1">SUPPLIER</label>
                                <select class="form-control" name="supplier">
                                    <option  selected  value=""><- Select Supplier -></option>
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                            <img src="views/files/qrcodes/<?php echo $id_holder?>.png" id="qrCodeImage" style="width:200px;border: solid 1px black;" alt="" srcset="">
                            </div>
                        </div>
                            
                    </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" id="addUnregisterItem" name ="addItem" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
        </div>
        </form> -->

         <!-- Generate Daily Checklist Modal -->
 <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="addUnregisteredModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD UNREGISTERED ITEM</h5>
                   <button type="button" data-toggle="modal" data-target="#requestModal" class="btnRequest ml-4">REQUEST</button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-sm-4">
                            <label for="branch">Select a branch:</label>
                            <input list="branches" class="form-control " placeholder="Select branch" id="un_branch"  name="un_branch_name">
                            <datalist id="branches">
                                <?php foreach ($branches as $branch): ?>
                                    <option value="<?php echo htmlspecialchars($branch); ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="input-1">STICKER NO.</label>
                            <input type="text"  class="form-control"  id="un_sticker_no"   name="un_sticker_no">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="input-1">ITEM DESCRIPTION</label>
                            <input type="text" class="form-control" id="un_item_description" required placeholder="Enter item description" name="un_item_description">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <label for="input-1">SERIAL NO.</label>
                            <input type="text"  placeholder="Enter serial number" class="form-control" id="un_serial_no"  name="un_serial_no">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="input-1">DATE PURCHASED</label>
                            <input type="date" required class="form-control" id="un_date_acquired"  name="un_date_purchased">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addUnregistered" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
           </div>
        </div>
        </form>
        <?php 
               $addqrCode = new ControllerQRCode();
               $addqrCode -> ctrAddUnregister();
        ?>
        
       <!-- Generate Daily Checklist Modal -->
       <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9 form-group">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="input-1">ITEM CODE</label>
                                <input type="text"  class="form-control" id="item_code" readonly value="<?php echo $id_holder; ?>" name="item_code">
                                <input type="text"  class="form-control" id="branch_name" hidden value="<?php echo $branch_name; ?>" name="branch_name">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">COMPANY</label>
                                <select class="form-control company" required name="company">
                                    <option  selected disabled value=""><- Select Company -></option>
                                    <option value="ELC">ELC</option>
                                    <option value="EMB">EMB</option>
                                    <option value="FCH">FCH</option>
                                    <option value="RFC">RFC</option>
                                    <option value="PSPMI">PSPMI</option>
                                    <option value="UBUNTU">UBUNTU</option>
                                    <option value="NORNS">NORNS</option>
                                    <option value="LIKHAIN">LIKHAIN</option>
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="input-1">Location</label>
                                <select class="form-control item_name1" required id="item_name1"  name="item_location">
                                    <option  selected disabled value=""><- Select Location -></option>
                                </select>
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="input-1">STICKER NO.</label>
                                <input type="text" readonly class="form-control"  id="sticker_no" requiredPSPMI  name="sticker_no">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="input-1">Classification Type</label>
                                <select class="form-control class_type" required name="class_type">
                                    <option  selected disabled value=""><- Select Type -></option>
                                    <option value="FURNITURE">FURNITURE</option>
                                    <option value="FIXTURES">FIXTURES</option>
                                    <option value="EQUIPMENT">EQUIPMENT</option>
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                            <label for="input-1">Classification Category</label>
                                <select class="form-control class_categ" required id="class_categ"  name="class_category">
                                    <option  selected disabled value=""><- Select Category -></option>
                                </select>
                            </div>
                            <div class="col-sm-5 form-group">
                              <label for="input-1">Classification List</label>
                                <select class="form-control class_list"  id="class_list"  name="class_list">
                                    <option  selected disabled value=""><- Select List -></option>
                                </select>
                            </div>
                        </div>
                        <div class="row computer_set" >
                            <div class="col-sm-12 form-group">
                            <label for="input-1">Computer Set List</label>
                            <select class="js-example-basic-multiple form-control computer_list"  name="computer_set[]" multiple="multiple">
                                <option value="MONITOR">MONITOR</option>
                                <option value="MOUSE">MOUSE</option>
                                <option value="KEYBOARD">KEYBOARD</option>
                                <option value="AVR">AVR</option>
                            </select>
                            </div>
                        </div>
                        <div class="row cctv_set" >
                            <div class="col-sm-10 form-group">
                                <label for="input-1">CCTV SET LIST</label>
                                <select class="js-example-basic-multiple1 form-control cctv_list"  name="cctv_set[]" multiple="multiple">
                                    <option value="CAMERA">CAMERA</option>
                                    <option value="MONITOR">MONITOR</option>
                                    <option value="HARD DRIVE">HARD DRIVE</option>
                                    <option value="POWER SUPPLY">POWER SUPPLY</option>
                                </select>
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="input-1">CAMERA COUNT</label>
                                <input type="text"  class="form-control" id="camera_count" readonly value="1" name="camera_count">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="input-1">ITEM DESCRIPTION</label>
                                <input type="text" class="form-control" id="item_description" required placeholder="Enter item description" name="item_description">
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="input-1">PRICE</label>
                                <input type="text" required placeholder="ENTER PRICE" pattern="\d*" title="Only numbers are allowed" class="form-control" id="price"  name="price">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">DATE PURCHASED</label>
                                <input type="date" required class="form-control" id="date_acquired"  name="date_purchased">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="input-1">QUANTITY</label> 
                                <input type="text"   placeholder="Enter serial number"  pattern="\d*" title="Only numbers are allowed" value="1" class="form-control" id="qty"  name="qty">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">SERIAL NO.</label>
                                <input type="text"  placeholder="Enter serial number" class="form-control" id="serial_no"  name="serial_no">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="input-1">SUPPLIER</label>
                                <input type="text"  placeholder="ENTER SUPPLIER" class="form-control" id="supplier"  name="supplier">
                            </div>
                            <div class="col-sm-3 form-group last_stickerfields" hidden> 
                                <label for="input-1">Last Sticker No.</label>
                                <input type="text" pattern="\d*" title="Only numbers are allowed"  placeholder="ENTER STICKER NO."  class="form-control" id="last_sticker"  name="last_sticker">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 mt-1">
                                <div class="checkDesign">
                                    <input type="checkbox" class="me-2 chkExist">
                                    <span>EXISTING</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                            <img  id="displayQrcode" style="width:200px;border: solid 1px black;" alt="" srcset="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 mt-2 ml-4">
                              <input type="text"  readonly class="form-control " id="class_code" required name="class_code">
                            </div>
                        </div>
                            
                    </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" id="addItem" name ="addItem" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
        </div>
        </form>
        <?php 
        $addqrCode = new ControllerQRCode();
        $addqrCode -> ctrAddItem();
        ?>

           <!-- Camera Count Modal -->
    <div class="modal fade modalLayout" id="cameraCountModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >CAMERA COUNT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="color:black;">How many cameras should be included?</p>
                <input type="text" id="camerCount" class="form-control" placeholder="ENTER CAMERA COUNT">
            </div>
            <div class="modal-footer">
                <button type="button" id="subCamera" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </div>
        </div>


        <!-- Delete Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>To confirm deletion, please enter the item's sticker number:</p>
                <input type="text" id="itemSticker" class="form-control" placeholder="Enter Sticker Number">
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmDeleteBtn" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            </div>
        </div>
        </div>
      <!--Batch Printing Modal -->
       <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="batchPrintModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">BATCH PRINTING</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-sm-4 form-group">
                                <label for="input-1">COMPANY</label>
                                <select class="form-control batchCompany" required name="batchCompany">
                                    <option  selected disabled value=""><- Select Company -></option>
                                    <option value="ELC">ELC</option>
                                    <option value="EMB">EMB</option>
                                    <option value="FCH">FCH</option>
                                    <option value="RFC">RFC</option>
                                    <option value="PSPMI">PSPMI</option>
                                    <option value="UBUNTU">UBUNTU</option>
                                    <option value="NORNS">NORNS</option>
                                </select>
                        </div>
                             <div class="col-sm-4 form-group">
                                <label for="input-1">Location</label>
                                <select class="form-control item_name2" required id="item_name2"  name="item_location">
                                    <option  selected disabled value=""><- Select Location -></option>
                                </select>
                            </div>
                    </div>
                    <div class="row batchContent">
                     <div class="col-sm-12">
                        <h5 id="stickerTitle">STICKER LIST</h5> 
                        <div class="row dispayList mb-2">

                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="printBatch"  class="btn btn-primary">Print</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
        </div>
        </form>
           <!--History Modal -->
       <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ITEM HISTORY</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                        <button type="button" id="printBatch"  class="btn btn-primary">Print</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
        </div>
        </form>

           <!-- Edit Item Modal -->
       <form method="POST" enctype="multipart/form-data" > 
       <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">EDIT ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                        <button type="submit" id="editItem" name ="editItem" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
        </div>
        </form>
        <?php 
        $addqrCode = new ControllerQRCode();
        $addqrCode -> ctrEditItem();
        ?>

       <!-- Generate Daily Checklist Modal -->
       <div class="modal fade" id="scanItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
             <form method="POST" enctype="multipart/form-data" > 
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">SCAN ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                <video id="qr-video" style="width: 100%;"></video>
                <p id="qr-result">No QR code detected.</p>
                <form id="qr-form" action="" method="POST">
                    <input type="hidden" name="qr_data" id="qr_data">
                    <button type="submit" id="submit-btn" name="scanQR" style="display:none;">Submit</button>
                </form>
                <?php 
                    $qrCode = new ControllerQRCode();
                    $qrCode -> ctrScanQRCode();
                ?>


               </div> 
                </div>
                <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
           </form>
        </div>


        <!-- Inventory Report Modal -->
       <div class="modal fade modalLayout" id="inventoryReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
             
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Reports</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="input-1">Report</label>
                        <select class="form-control reportType" id="reportType" required name="reportType">
                            <option value="" selected disabled><- Select Report -></option>
                            <option value="Aging Report">Item Aging Report</option>
                            <option value="Pending Report">Pending Repair Report</option>
                            <option value="Repair Report">Repair Status Report</option>
                            <option value="Item Classification">Item Classification Summary Report</option>
                            <option value="Undelivered Items">Undelivered Items Report</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="branch">Select a branch:</label>
                        <input list="branches" class="form-control " id="branch"  name="branch">
                        <datalist id="branches">
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo htmlspecialchars($branch); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
               </div> 
               <div class="row">
                    <div class="col-sm-4 reportClass mt-2" hidden>
                        <label for="input-1">STATUS</label>
                        <select class="form-control reportStatus" id="reportStatus" required name="reportType">
                            <option value="" selected disabled><- Select STATUS -></option>
                            <option value="ALL">ALL</option>
                            <option value="WORKING">WORKING</option>
                            <option value="REPAIRED">REPAIRED</option>  
                            <option value="PENDING">PENDING</option>
                            <option value="DEFECTIVE">DEFECTIVE</option>
                            <option value="DISPOSED">DISPOSED</option>
                        </select>
                    </div>
               </div>
               <div class="row">
                    <div class="col-sm-4 mt-2 itemClass" hidden>
                        <label for="input-1">Classification</label>
                        <select class="form-control slctClass" id="slctClass" required name="slctClass">
                            <option value="" selected disabled><- Select Classification -></option>
                            <option value="FURNITURE">FURNITURE</option>
                            <option value="FIXTURES">FIXTURES</option>
                            <option value="EQUIPMENT">EQUIPMENT</option>
                        </select>
                    </div>
               </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="printInventoryReport" class="btn btn-primary">Print</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
         
        </div>
         <!-- Inventory Report fields Modal -->
       <!-- <div class="modal fade modalLayout" id="inventoryReportFields" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
             
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Reports</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="input-1">STATUS</label>
                        <select class="form-control reportStatus" id="reportStatus" required name="reportType">
                            <option value="" selected disabled><- Select STATUS -></option>
                            <option value="ALL">ALL</option>
                            <option value="WORKING">WORKING</option>
                            <option value="REPAIRED">REPAIRED</option>  
                            <option value="PENDING">PENDING</option>
                        </select>
                    </div>
               </div> 
                </div>
                <div class="modal-footer">
                        <button type="button" id="printInventoryReportFields" class="btn btn-primary">Print</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
         
        </div> -->

          <!-- Audit List Modal -->
       <div class="modal fade modalLayout" id="auditList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Item List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>STICEKR NO</th>
                                <th>ITEM</th>
                                <th>STATUS</th>
                                <th>CURRENT LOCATION</th>
                            </tr>
                        </thead>
                        <tbody class="auditBody">
                        
                        </tbody>
                    </table>       
                </div>
                <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            
           </div>
         
        </div>

         <!-- Requst Modal -->
        <div class="modal fade modalLayout" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Request Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="color:black;">Select Date</p>
                <input type="date" id="dateRequest" class="form-control" placeholder="Enter Sticker Number">
            </div>
            <div class="modal-footer">
                <button type="button" id="printRequest" class="btn btn-primary">Print</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            </div>
        </div>
        </div>

        <!-- Item Set Modal -->
        <div class="modal fade modalLayout" id="setModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title setModalTitle">COMPUTER SET</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        </div>
                </div>
            </div>
        </div>


            <!-- Add Set Modal -->
            <div class="modal fade modalLayout" id="addSetModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ADDITIONAL ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                     
                    </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSubmitSet" class="btn btn-primary">SUBMIT</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        </div>
                </div>
            </div>
        </div>

         <!-- Generate Daily Checklist Modal -->
       <div class="modal fade" id="auditScanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
             <form method="POST" enctype="multipart/form-data" > 
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">SCAN ITEM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="qr-form1" action="" method="POST">
                <div class="modal-body">
                    <div class="row auditHeader">
                        <div class="option3">
                            <label for="input-1">Date</label>
                            <input type="month" class="form-control auditDate" required id="auditDate"  name="auditDate">
                        </div>
                        <div class="option1">
                            <label   label for="input-1">COMPANY</label>
                            <select class="form-control auditCompany" required name="auditCompany">
                                <option  selected disabled value=""><- Select Company -></option>
                                <option value="ELC">ELC</option>
                                <option value="EMB">EMB</option>
                                <option value="FCH">FCH</option>
                                <option value="RFC">RFC</option>
                                <option value="PSPMI">PSPMI</option>
                            </select>
                        </div>
                        <div class="option2">
                            <label for="input-1">Location</label>
                            <select class="form-control item_name3" required id="item_name3"  name="item_name3">
                                <option  selected disabled value=""><- Select Location -></option>
                            </select>
                        </div>
                    </div>
                <div class="row">
                    <div class="vid">
                      <video id="qr-video1" style="width: 100%;"></video>
                    </div>
               </div> 
               <div class="row">
                    <p id="qr-result1">No QR code detected.</p>
                    <input type="hidden" name="qr_data1" id="qr_data1">
                    <button type="submit" id="submit-btn1" name="scanQR" style="display:none;">Submit</button>
                    </div>
               <div class="row auditTable">
                    
               </div>
                </div>
                <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
           </div>
           </form>
        </div>
  </div><!--End Row-->
    </div>
</div>
<script type="module">
    
    import QrScanner from './views/assets/js/qr-scanner.min.js';

    // Path for the QR scanner worker script
    QrScanner.WORKER_PATH = './views/assets/js/qr-scanner-worker.min.js';

    let isProcessing = false; // Flag to prevent multiple submissions
    let qrScanner; // Declare qrScanner globally for better control

    function initializeScanner(videoElement, qrResultElement, qrDataInputElement, submitBtnElement) {
        // Prevent reinitializing the scanner if it's already running
        if (qrScanner && qrScanner._active) return;

        // Initialize the QR scanner
        qrScanner = new QrScanner(videoElement, result => {
            if (result && !isProcessing) {
                isProcessing = true; // Block further scans
                // Immediately stop the scanner and prevent further detections
                qrScanner.stop();
                // Set the QR result
                qrResultElement.textContent = `QR Code: ${result}`;
                qrDataInputElement.value = result;

                // Delay to avoid any residual processing from triggering
                setTimeout(() => {
                    submitBtnElement.click(); // Automatically submit the form
                }, 100);
            }
        });

        qrScanner.start();
    }
 // Ensure event binding after document is ready
 $('#auditScanModal').on('hidden.bs.modal', function () {
        console.log('Modal is hidden'); // Debugging message
        if (qrScanner) {
            qrScanner.stop(); // Stop the QR scanner when the modal is hidden
        }
    });
    function adutInitializeScanner(videoElement, qrResultElement, qrDataInputElement, submitBtnElement) {
        // Prevent reinitializing the scanner if it's already running
        if (qrScanner && qrScanner._active) return;

        // Initialize the QR scanner
        qrScanner = new QrScanner(videoElement, result => {
            if (result && !isProcessing) {
                isProcessing = true; // Block further scans
                // Immediately stop the scanner and prevent further detections
                qrScanner.stop();
                // Set the QR result
                qrResultElement.textContent = `QR Code: ${result}`;
                qrDataInputElement.value = result;

                // Delay to avoid any residual processing from triggering
                setTimeout(() => {
                   let type = "auditScanQR";
                   let branch = $('.item_name3').val();
                   let auditDate = $('.auditDate').val();
                   $.ajax({
                        url: 'ajax/inventoryprocessing.ajax.php',
                        data: {
                            result: result,
                            type: type,
                            branch: branch,
                            date: auditDate
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                swal({
                      type: "success",
                      title: "SUCCESS",
                      text:  data.success,
                      showConfirmButton: true,
                      confirmButtonText: "Ok"
                  }).then(function(result) {
                      $(".item_name3").trigger("change");
                  });
                    } else if (data.error) {
                        swal({
                            type: "error",
                            title: "ERROR",
                            text:  data.error,
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result) {
                            $(".item_name3").trigger("change");
                        });
                    }
                },
                error: function() {
                    alert("error");
                },
                complete: function() {
                    // Delay before restarting the scanner
                    setTimeout(() => {
                        isProcessing = false;
                        qrScanner.start(); // Restart the scanner for the next scan
                    }, 2000); // 2-second delay before allowing another scan
                }
            });

        }, 100);
            }
        });

        qrScanner.start();
    }

    // Scan click event for the first scanner (scanClick)
    $("#scanClick").on("click", function() {
        const video = document.getElementById('qr-video');
        const qrResult = document.getElementById('qr-result');
        const qrDataInput = document.getElementById('qr_data');
        const submitBtn = document.getElementById('submit-btn');
        initializeScanner(video, qrResult, qrDataInput, submitBtn);
    });

    // Scan click event for the second scanner (auditScan)
    $("#auditScan").on("click", function() {
        const video = document.getElementById('qr-video1');
        const qrResult = document.getElementById('qr-result1');
        const qrDataInput = document.getElementById('qr_data1');
        const submitBtn = document.getElementById('submit-btn1');
        adutInitializeScanner(video, qrResult, qrDataInput, submitBtn);
    });

    // Stop the QR scanner and reset the flag when the first form is submitted
    document.getElementById('qr-form').addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent the default form submission if using AJAX
        if (qrScanner) qrScanner.stop(); // Ensure the scanner stops
        isProcessing = false; // Reset the flag after submission
        // Add your AJAX submission logic here
    });

    // Stop the QR scanner and reset the flag when the second form is submitted
    document.getElementById('qr-form1').addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent the default form submission if using AJAX
        if (qrScanner) qrScanner.stop(); // Ensure the scanner stops
        isProcessing = false; // Reset the flag after submission
        // Add your AJAX submission logic here
    });

    // Additional Debugging: Log when each scan button is clicked
    $("#scanClick").on("click", function() {
        console.log('Scan button clicked');
    });

    $("#auditScan").on("click", function() {
        console.log('Audit scan button clicked');
    });

    // Ensure the scanner is only initialized once
    if (qrScanner && qrScanner._active) {
        console.log('Scanner is already active');
    }



  
</script>

