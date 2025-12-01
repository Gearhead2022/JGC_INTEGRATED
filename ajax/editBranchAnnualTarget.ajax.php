<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new operationAjaxModal();
$editAccntModal->showEditModal();    



class operationAjaxModal{
	
    public function showEditModal(){
        $id = $_GET['id'];   

        $data = (new ControllerPensioner)->ctrShowEditBranchAnnualTarget($id);

        foreach ($data as &$item) {
            $accnt_id = $item['id'];
            $branch_name = $item['branch_name'];
            $year_encoded = $item['year_encoded'];
            $annual_target = $item['annual_target'];
        
            $item['card'] = '
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="input-6">BRANCH</label>
                        <input type="text" class="form-control" readonly name="branch_name" id="branch_name" value="'.$branch_name.'" placeholder="">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input type="text" class="form-control" hidden readonly name="accnt_id" id="accnt_id" value="'.$accnt_id.'" placeholder="">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="year">Select a Year:</label>
                        <select name="year" id="year" class="form-control">';
        
                    $currentYear = $year_encoded;
                
                    // Define a range of years (e.g., from current year - 10 to current year + 10)
                    $startYear = $currentYear - 10;
                    $endYear = $currentYear + 10;
                
                    // Loop through the range of years
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        // Check if the current year matches the loop year and set selected attribute
                        $selected = ($year == $currentYear) ? "selected" : "";
                
                        $item['card'] .= '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
                    }
                
                    $item['card'] .= '</select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="input-6">TARGET</label>
                                <input type="text" class="form-control" name="target" id="target" value="'.$annual_target.'" placeholder="">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="editAnnualTarget" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>';
                }
                        
                    
                echo json_encode($data);
            }




}