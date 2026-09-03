<?php
require_once "../controllers/operation.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new operationAjaxModal();
$editAccntModal->showEditModal();    



class operationAjaxModal{
	
    public function showEditModal(){
        $id = $_GET['id'];   

        $data = (new ControllerPensioner)->ctrShowAccntTarget($id);

        foreach ($data as &$item) {
          
            $accnt_id = $item['id'];
            $branch_name = $item['branch_name'];
            $accnt_in_data = $item['accnt_in'];
            $accnt_out_data = $item['accnt_out']; 
            $date_encode_data = $item['date']; 

          
            $item['card'] ='
         
                    
            <div class="row">

                <div class="col-sm-6 form-group">
                <label   label for="input-6">BRANCH NAME</label>
                    <input type="text" class="form-control" value="'.$branch_name.'" id="branch_name" placeholder="Enter Folder Name" name="branch_name">
                </div>  

                <input type="text" class="form-control" hidden value="'.$accnt_id.'" placeholder="Enter Account Number" name="accnt_id" autocomplete="nope" required>
           
            </div> 
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="input-6">ACCOUNTS IN</label>
                    <input type="number" class="form-control" name="accnt_in" id="accnt_in" value="'.$accnt_in_data.'" placeholder="Enter First Name">
                </div>   
                <div class="col-sm-6 form-group">
                    <label for="input-6">ACCOUNTS OUT</label>
                    <input type="number" class="form-control" name="accnt_out" id="accnt_out" value="'.$accnt_out_data.'" placeholder="Enter Last Name">
                </div>  
            </div> 
            <div class="col-sm-6 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" name="date_encode" id="date_encode" value="'.$date_encode_data.'" placeholder="Enter Last Name">
            </div>  

            <div class="modal-footer">
                <button type="submit" name ="editAccntPensioner" class="btn btn-primary">Submit</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
 
            ';
        }
        echo json_encode($data);
    }




}