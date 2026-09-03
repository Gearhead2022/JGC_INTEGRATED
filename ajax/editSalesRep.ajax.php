<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";

$editAccntModal= new operationAjaxModal();
$editAccntModal->showEditModal();    




class operationAjaxModal{
	
    public function showEditModal(){
        $id = $_GET['id'];   

        $data2 = (new ControllerPensioner)->ctrShowSRAccntTarget($id);

        
        $branch_list = new ControllerPastdue();
        $branch = $branch_list->ctrShowBranches();

        foreach ($data2 as &$item) {
          
            $rep_id = $item['id'];
            $branch_name = $item['branch_name'];
            $rep_fname = $item['rep_fname'];
            $rep_lname = $item['rep_lname']; 
          
            $item['card'] ='

            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="branch_name">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                        <option value="' . $branch_name . '" selected>' . $branch_name . '</option>';

            // Loop through branches to populate the dropdown options
            foreach ($branch as $key => $row) {
                $full_name = $row['full_name'];
                $item['card'] .= '<option value="' . $full_name . '">' . $full_name . '</option>';
            }

            // Continue building the HTML card
            $item['card'] .= '
                    </select>
                </div>
            </div> 
            <div>

                <input type="text" class="form-control" hidden value="'.$rep_id.'" placeholder="rep_id" id="" name="rep_id" autocomplete="nope" required>
           
            </div> 
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="input-6">FIRST NAME</label>
                    <input type="text" class="form-control" name="rep_fname" id="rep_fname" value="'.$rep_fname.'" placeholder="Enter First Name">
                </div>   
                <div class="col-sm-6 form-group">
                    <label for="input-6">LAST NAME</label>
                    <input type="text" class="form-control" name="rep_lname" id="rep_lname" value="'.$rep_lname.'" placeholder="Enter Last Name">
                </div>  
            </div> 
        

            <div class="modal-footer">
                <button type="submit" name ="editSalesRep" class="btn btn-primary">Submit</button>
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
 
            ';
        }
        echo json_encode($data2);
    }




}