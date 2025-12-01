
<?php
// require_once "../controllers/operation.controller.php";
// require_once "../models/operation.model.php";

require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new editPinModal();
$editAccntModal->showEditDTRModal();    

class editPinModal {
    public function showEditDTRModal() {

        $id = $_GET['id'];
        $branch_name = $_GET['branch_name'];
      
        $data = (new ControllerDTR)->ctrGetHRDailyDTRTimeInDownload($id, $branch_name);

            foreach ($data as &$item) {
                $dtr_id = $item["dtr_id"];
                $entry_date_edit = $item["entry_date"];
                $branch_name_edit = $item["branch_name"];
                $entry_file_edit = $item["entry_file"];
                $entry_subj_edit = $item["entry_subj"];
                $date_uploaded = $item["date_uploaded"];
                $date_received = $item["date_received"];

                $format_date = date("M d, Y", strtotime($entry_date_edit));
            }
        
        $item['card'] ='
         
        <input type="hidden" class="form-control" id="id" name="id" readonly value="'.$id.'" required placeholder="Enter Folder Name">
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-6">DATA ID</label>
                <input type="text" class="form-control" readonly id="entry_subj" name="entry_subj" value="'.$dtr_id.'" placeholder="NO SUBJECT NAME PROVIDED">
            </div> 
            <div class="col-sm-6 form-group">
                <label for="input-6">BRANCH NAME</label>
                <input type="text" class="form-control" id="branch_name" name="branch_name" readonly value="'.$branch_name_edit.'" required placeholder="NO BRANCH NAME">
            </div>
            <div class="col-sm-6 form-group">
                <label for="input-6">DATE SELECTED</label>
                <input type="text" class="form-control text-warning" readonly id="entry_date" name="entry_date" value="'.$format_date.'" required placeholder="NO DATE SELECTED">
            </div>
            <div class="col-sm-12 mt-1">
                <label for="input-6">DATABASE FILE NAME</label>
                <input type="text" class="form-control" readonly id="entry_file" name="entry_file" value="'.$entry_file_edit.'" placeholder="NO FILE SELECTED" value="Import">
            </div>
            <div class="col-sm-12 mt-1">
                <label for="input-6">SUBJECT NAME</label>
                <input type="text" class="form-control" readonly id="entry_subj" name="entry_subj" value="'.$entry_subj_edit.'" placeholder="NO SUBJECT NAME PROVIDED">
            </div>   
            <div class="col-sm-12 mt-1">
                <label for="input-6">DATE UPLOADED</label>
                <i><input type="text" class="form-control text-success" readonly id="entry_subj" name="entry_subj" value="'.$date_uploaded.'" placeholder="NO SUBJECT NAME PROVIDED"></i>
            </div>       
            <div class="col-sm-12 mt-1">
                <label for="input-6">DATE RECEIVED</label>
                <input type="text" class="form-control text-info" readonly id="entry_subj" name="entry_subj" value="'.$date_received.'" placeholder="NO SUBJECT NAME PROVIDED">
            </div>             
        </div> 

    ';

        echo json_encode($data);

    }
}
