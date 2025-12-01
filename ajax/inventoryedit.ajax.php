<?php
require_once "../controllers/qrcode.controller.php";
require_once "../models/qrcode.model.php";
require_once "../views/modules/session.php";

$editItem= new inventoryModal();
$editItem -> showInventoryEditModal();

class inventoryModal{ 
	public function showInventoryEditModal(){
        $id = $_GET['idClient'];
        $type = $_SESSION['type'];
        if($type == "admin"){
            $read = "";
            $disable = "";
        }else{
            $read = "readonly";
            $disable = "disabled";
        }
        if($type == "inventory_mis"){
            $visible = "";
        }else{
            $visible = "hidden";
        }
        $data = (new ControllerQRCode)->ctrGetItmebyID($id);
        foreach ($data as &$item) {
            $item_code = $item['item_code'];
            $sticker_no = $item['sticker_no'];
            $date_purchased = $item['date_purchased'];
            $item_location = $item['item_location'];
            $serial_no = $item['serial_no'];
            $item_description = $item['item_description'];
            $supplier = $item['supplier'];
            $company = $item['company'];
            $price = $item['price'];
            $status = $item['status'];
            $class_type = $item['class_type'];
            $class_category = $item['class_category'];
            $class_list = $item['class_list'];
            $class_code = $item['class_code'];

            $selectedCompany = $company; // Assuming $company contains the currently selected company
             $companies = ["ELC", "EMB", "FCH", "RLC", "HPC", "PSPMI"];
            $item['card'] ='
                  <div class="row">
                    <div class="col-sm-9 form-group">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="input-1">ITEM CODE</label>
                                <input type="text"  class="form-control" id="item_code" readonly value="'.$item_code.'" name="item_code">
                                <input type="text"  hidden  class="form-control" id="item_id" readonly value="'.$id.'" name="item_id">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="input-1">COMPANY</label>
                                <select class="form-control company"  required name="company">
                                    <option value="'.$company.'">'.$company.'</option>
                                    <option  disabled value=""><- Select Company -></option>';
                             
                                  foreach ($companies as $company) {
                                    if ($company === $selectedCompany) {
                                           $item['card'].='
                                            <option value="'.$company.'" disabled>'.$company.'</option>';
                                    } else {
                                          $item['card'].='
                                                <option disabled value="'.$company.'" '.$disable.'>'.$company.'</option>';
                                    }
                                }
                         $item['card'].='
                                </select>
                            </div>
                              <div class="col-sm-4 form-group">
                                <label for="input-1">Location</label>
                                <input type="text" placeholder="Enter item name" readonly value="'.$item_location.'" '.$read.' required class="form-control" id="item_name"  name="item_location">
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="input-1">STICKER NO.</label>
                                <input type="text"  value="'.$sticker_no.'" '.$read.' readonly class="form-control" id="editSticker_no"  pattern="\d*" title="Only numbers are allowed"  name="sticker_no">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="input-1">Classification Type</label>
                                <input type="text"  class="form-control" '.$read.' readonly  placeholder="Enter item description" value="'.$class_type.'" >
                            </div>
                             <div class="col-sm-4 form-group">
                                <label for="input-1">Classification Category</label>
                                <input type="text"  placeholder="Enter price" '.$read.' readonly class="form-control" value="'.$class_category.'" pattern="\d*" title="Only numbers are allowed"  >
                            </div>
                              <div class="col-sm-5 form-group">
                                <label for="input-1">Classification List</label>
                                <input type="text"  class="form-control" '.$read.' readonly value="'.$class_list.'"  >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="input-1">ITEM DESCRIPTION</label>
                                <input type="text" required class="form-control" '.$read.' id="item_description" placeholder="Enter item description" value="'.$item_description.'"  name="item_description">
                            </div>
                             <div class="col-sm-2 form-group">
                                <label for="input-1">PRICE</label>
                                <input type="text" required placeholder="Enter price" '.$read.' class="form-control" value="'.$price.'" id="price" pattern="\d*" title="Only numbers are allowed"  name="price">
                            </div>
                              <div class="col-sm-3 form-group">
                                <label for="input-1">DATE PURCHASED</label>
                                <input type="date" required class="form-control" '.$read.' value="'.$date_purchased.'" id="date_acquired"  name="date_purchased">
                            </div>
                        </div>
                        <div class="row">
                              <div class="col-sm-3 form-group">
                                <label for="input-1">SERIAL NO.</label>
                                <input type="text"  placeholder="Enter serial number" value="'.$serial_no.'" '.$read.'  class="form-control" id="serial_no"  name="serial_no">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="input-1">SUPPLIER</label>
                                 <input type="text"  placeholder="Enter supplier" value="'.$supplier.'" '.$read.'  class="form-control" id="supplier"  name="supplier">
                            </div>
                        </div>
                        
                    
                        <div class="row" '.$visible.'>
                                <div class="col-sm-3 form-group">
                                <label for="input-1">STATUS</label>
                                <select class="form-control editStatus" name="status">
                                    <option     value="'.$status.'">'.$status.'</option>
                                    <option   disabled value=""><- Select Status -></option>
                                    <option value="WORKING">WORKING</option>
                                    <option value="DEFECTIVE">DEFECTIVE</option>
                                    <option value="DISPOSED">DISPOSED</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <div class="row mt-4">
                            <div class="col-sm-12 text-center">
                            <img src="views/files/qrcodes/'.$item_code.'.png" style="width:200px;border: solid 1px black;" alt="" srcset="">
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-sm-10 mt-2 ml-4">
                              <input type="text"  readonly class="form-control" value="'.$class_code.'" id="class_code">
                            </div>
                        </div>

                            
                    </div>
               </div> 
        ';
        }
        echo json_encode($data);
    }
}