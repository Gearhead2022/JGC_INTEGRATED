<?php
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../models/connection.php";
require_once "../views/modules/session.php";


$editAccntModal= new operationAjaxModal();
$editAccntModal->showEditModal();    


class operationAjaxModal{
	
    public function showEditModal(){

        $permit = (new Connection)->connect()->query("SELECT * from past_due ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
        if(empty($permit)){
            $id = 0;
        }else{
            $id = $permit['id'];
        }
        $last_id = $id + 1;
        $due_id = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
   
        $account_no = $_GET['account_no'];   
        $tdate = $_GET['tdate']; 
        $branch_name = $_GET['branch_name']; 

        $data2 = (new ControllerPDRColl)->ctrGetPDRAccountInfo($account_no, $tdate, $branch_name);
        date_default_timezone_set('Asia/Manila');

        $date = date('M-d-y h:i:s A',time());

        // $full_id1= (new ModelPDRCollection)->get_id($due_id);
        
         $full_id1 = (new ModelPDRCollection)->mdlShowPastDueLedger($account_no, $branch_name);
        // $full_id1= (new ModelPDRCollection)->get_id($due_id);

        // Assuming $full_id1 is an array of associative arrays
        if (!empty($full_id1)) {
            $orig_class = $full_id1[0]['class']; // Replace 'propertyName' with the actual key name
        }

        foreach ($data2 as &$item) {
          
            $id = $item['id'];
            $account_no = $item['account_no'];
            $branch_name = $item['branch_name'];
            $first_name = $item['first_name'];
            $last_name = $item['last_name'];
            $middle_name = $item['middle_name'];
            $status = trim($item['status']);
            $edate = $item['edate']; 
            $tdate = $item['tdate'];
            $ref = $item['ref'];
            $prev_bal = floatval(str_replace(',', '', $item['prev_bal']));
            $amt_credit = floatval(str_replace(',', '', $item['amt_credit']));
            $amt_debit = floatval(str_replace(',', '', $item['amt_debit']));
            $end_bal = floatval(str_replace(',', '', $item['end_bal']));
           
            if ($status == 'D') {
                $word_status = 'DECEASED';
            } else if ($status == 'F') {
                $word_status = 'FULLY PAID';
            } else if ($status == 'P') {
                $word_status = 'POLICE ACTION';
            } else if ($status == 'W') {
                $word_status = 'WRITE OFF';
            }else if ($status == 'L') {
                $word_status = 'LITIGATION';
            }else{
                $word_status = '';
            }
            
             if ($status != $orig_class) {
                $date_change = date('Y-m-d', time());
            } else {
                $date_change = '';
            }
            
            $item['card'] ='
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputIdNo" class="col-form-label">ID NO :</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="id" name="id" readonly hidden value="'.$id.'" class="form-control" placeholder="select ID">
                            <input type="text" id="account_no" name="account_no" readonly value="'.$account_no.'" class="form-control" placeholder="select ID">
                            <input type="text" id="due_id" name="due_id" hidden value="'.$due_id.'" class="form-control" placeholder="select ID">
                            <input type="text" id="branch_name" name="branch_name" hidden value="'.$branch_name.'" class="form-control" placeholder="select ID">
                        </div>
                        <div class="col-1">
                            <!-- <button type="button" class="btn btn-info waves-effect waves-light showDetails">
                                <i class="fa fa-eye"></i> <span>SHOW DETAILS</span>
                            </button> -->
                        </div>
                        <div class="col-3">
                            <i>Date Modified:</i>
                        </div>
                        <div class="col-4 text-success" id="date_mod">
                            '.$date.'
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">FIRST NAME :</label>
                        </div>
                        <div class="col-sm-3">
                            
                            <input type="text" id="first_name" name="first_name"  value="'.$first_name.'" class="form-control" placeholder="Enter Name">
                       
                        </div>  
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">LAST NAME :</label>
                        </div>
                        <div class="col-sm-3">
                            
                            <input type="text" id="last_name" name="last_name"  value="'.$last_name.'" class="form-control" placeholder="Enter Name">
                      
                        </div>  
                        <div class="col-2.">
                            <label for="inputAccountNo" class="col-form-label">M.I :</label>
                        </div>
                        <div class="col-sm-1">
                            
                            <input type="text" id="middle_name" name="middle_name"  value="'.$middle_name.'" class="form-control" placeholder="M.I">
                       
                        </div> 
                    </div>
                    <div class="row mb-3"> 
                        
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">CLASS :</label>
                        </div>
                        <div class="col-3">
                        <select class="form-control" name="status" id="status" required>';

                                if ($status != "") {
                                    $item['card'] .='<option value="'.$status.'" selected>'.$status.' - '.$word_status.'</option>';
                                } else {
                                    $item['card'] .='<option value="" selected disabled><- CLASS -></option>';
                                }
                                $item['card'] .='
                                <option value="D">D - DECEASED</option>
                                <option value="F">F - FULLY PAID</option>
                                <option value="P">P - POLICE ACTION</option>
                                <option value="W">W - WRITE OFF</option>
                                <option value="L">L - LITIGATION</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">DATE CHANGE:</label>
                        </div>
                        <div class="col-3">
                            <input type="date" id="date_change" value="'.$date_change.'" disabled name="date_change" class="form-control" placeholder="Enter Endoresed Date">
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputName" class="col-form-label">ENDORSED DATE :</label>
                        </div>
                        <div class="col-3">
                            <input type="date" id="edate" name="edate" value="'.$edate.'" class="form-control" placeholder="Enter Endoresed Date">
                        </div>
                        <div class="col-2">
                            <label for="inputName" class="col-form-label">TRANSACTION DATE :</label>
                        </div>
                        <div class="col-3">
                            <input type="date" id="tdate" name="tdate" readonly  value="'.$tdate.'" class="form-control" placeholder="Enter transaction date">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">REF :</label>
                        </div>
                        <div class="col-3">
                            <input type="text" id="ref" name="ref"  value="'.$ref.'" class="form-control" placeholder="Enter Reference">
                        </div>
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">PREVIOUS BAL:</label>
                        </div>
                        <div class="col-3">
                            <input type="number" step="any" id="prev_bal" name="prev_bal" value="'.$prev_bal.'" class="form-control calculateEndBal prev_bal" placeholder="Enter Previous Balance">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">DEBIT:</label>
                        </div>
                        <div class="col-3">
                            <input type="number" step="any" id="debit" name="debit"  value="'.$amt_debit.'" class="form-control calculateEndBal debit" placeholder="Enter Amount">
                        </div>
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">CREDIT:</label>
                        </div>
                        <div class="col-3">
                            <input type="number" step="any" id="credit" name="credit" value="'.$amt_credit.'" class="form-control calculateEndBal credit" placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">ENDING BAL :</label>
                        </div>
                        <div class="col-3">
                            <input type="number" step="any" id="end_bal" readonly name="end_bal" value="'.$end_bal.'" class="form-control end_bal" placeholder="Enter Ending Balance">
                        </div>
                    </div>
                </div>
            </div>

            ';
        }
        echo json_encode($data2);
    }




}