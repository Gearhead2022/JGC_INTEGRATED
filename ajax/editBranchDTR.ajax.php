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
      
        $data = (new ControllerDTR)->ctrGetHRDailyDTRDownload($id, $branch_name);

            foreach ($data as &$item) {
                $entry_date_edit = $item["entry_date"];
                $branch_name_edit = $item["branch_name"];
                $entry_file_edit = $item["entry_file"];
                $entry_subj_edit = $item["entry_subj"];
            }
        
        $item['card'] ='
         
        <input type="hidden" class="form-control" id="id" name="id" readonly value="'.$id.'" required placeholder="Enter Folder Name">
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-6">BRANCH NAME</label>
                <input type="text" class="form-control" id="branch_name" name="branch_name" readonly value="'.$branch_name_edit.'" required placeholder="Enter Folder Name">
            </div>
            <div class="col-sm-6 form-group">
                <label for="input-6">SELECT DATE</label>
                <input type="date" class="form-control" id="entry_date" name="entry_date" value="'.$entry_date_edit.'" required placeholder="Enter Folder Name">
            </div>
            <div class="col-sm-12 mt-2">
                <label for="input-6">DATABASE FILE</label>
                <input type="file" class="form-control" id="entry_file" accept=".sql" name="entry_file" placeholder="Enter Folder Name" >
            </div>
            <div class="col-sm-12 mt-2">
                <label for="input-6">SUBJECT NAME</label>
                <textarea type="text" class="form-control" id="entry_subj"  name="entry_subj" >'.$entry_subj_edit.'</textarea>
            </div>                 
        </div> 

    ';

        echo json_encode($data);

    }
}
