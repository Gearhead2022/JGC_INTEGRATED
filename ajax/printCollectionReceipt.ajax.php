<?php
require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";
require_once "../controllers/orprinting.controller.php";
require_once "../models/orprinting.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new editPinModal();
$editAccntModal->showEditPinModal();    

class editPinModal {
    public function showEditPinModal() {

        if (isset($_GET['account_id'])) {
          
            $account_id = $_GET['account_id'];
        } else {
            $account_id = '';
        }
 
        if (isset($_GET['tdate'])) {
          
            $tdate = $_GET["tdate"];
    
        } else {
            $tdate = '';

        }

        $branch_name = $_SESSION['branch_name'];

        $data = (new ControllerORPrinting)->ctrGetCollectionReceiptInfo($account_id, $tdate, $branch_name);

        foreach ($data as &$item) {
            $account_id = $item['account_id'];
            $name = $item['name'];
            $amount = $item['amount'];
            $birsales = $item['birsales'];
            $biramt = $item['biramt'];
            $tdate = $item['tdate'];
            $rdate = $item['rdate'];
            $ttime = $item['ttime'];
            $desc = $item['desc'];
            $branch_name = $item['branch_name'];

        }

        $item['card'] ='
     
        <div class="card">
            <div class="card-header">
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="inputIdNo" class="col-form-label">ID NO :</label>
                    </div>
                    <div class="col-2">
                        <input type="text" id="account_id" name="account_id" readonly class="form-control" value="'.$account_id.'" placeholder="select ID">
                        <input type="hidden" id="branch_name" name="branch_name" readonly class="form-control" value="'.$branch_name.'" placeholder="select ID">
                    </div>
              
                   
                </div>
            </div>
    
            <div class="card-body">
            
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="inputName" class="col-form-label">NAME :</label>
                    </div>
                    <div class="col-10">
                        <input type="text" id="name" name="name" readonly class="form-control" value="'.$name.'" placeholder="Enter Name">
                    </div>
                 
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="inputBank" class="col-form-label">COLLECTED :</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="amount" name="amount" readonly class="form-control"  value="'.$amount.'" placeholder="Enter Bank">
                    </div>
                    <div class="col-2 ml-5">
                        <label for="inputBank" class="col-form-label">NET of VAT :</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="birsales" name="birsales" readonly class="form-control"  value="'.$birsales.'" placeholder="Enter Bank">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="inputBank" class="col-form-label">VAT :</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="biramt" name="biramt" readonly class="form-control"  value="'.$biramt.'" placeholder="Enter Bank">
                    </div>
                    <div class="col-2 ml-5">
                        <label for="inputBank" class="col-form-label">COLL. DATE :</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="tdate" name="tdate" readonly class="form-control"  value="'.$tdate.'" placeholder="Enter Bank">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="inputBank" class="col-form-label">PROCESSED :</label>
                    </div>
                    <div class="col-5">
                        <h7 class="form-control" readonly>'.$rdate.' - '.$ttime.'<h7>
                    </div>
                </div>
                <div class="row mb-3">
                <div class="col-2">
                    <label for="inputBank" class="col-form-label">DESCRIPTION:</label>
                </div>
                <div class="col-10">
                    <textarea name="desc" id="desc" readonly class="form-control">'.$desc.'</textarea>
                </div>
               
            </div>
            
        
                </div>         
        </div><!--card-->

';

    echo json_encode($data);

    }
}
