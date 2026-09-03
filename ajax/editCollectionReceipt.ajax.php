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
          
            $account_id = trim($_GET['account_id']);
        } else {
            $account_id = '';
        }
 
        if (isset($_GET['cdate'])) {
          
            $collDate = date("Y-m-d", strtotime($_GET['cdate']));
        } else {
            $collDate = '';
        }

        if ($_SESSION['branch_name'] != "") {
          
            $branch_name = $_SESSION['branch_name'];

        } else {
            $branch_name = 'admin';

        }

        $data = (new ControllerORPrinting)->ctrGetCollectionInfo($account_id, $collDate, $branch_name);

            foreach ($data as &$item) {
                $accountid = $item['accountid'];
                $name = $item['name'];
                $bank = $item['bank'];
                $target = number_format($item['target'], 2, '.', '');
                $normal = number_format($item['normal'], 2, '.', '');
                $actpnsn = number_format($item['actpnsn'], 2, '.', '');
                $amount = number_format($item['amount'], 2, '.', '');
                $bankno = $item['bankno'];
                $collstat = $item['collstat'];
                $atmbal = number_format($item['atmbal'], 2, '.', '');
                $cdate = $item['cdate'];
                $effectiveYear = date("Y", strtotime($item['effective']));
                $effectiveMonth = date("m", strtotime($item['effective']));
            }

            $last = (new ControllerORPrinting)->ctrGetLastSavedId($collDate, $branch_name);

            if ($last) {
                $last_id = $last['account_id'];
                
            } else {
                $last_id = '';
            }

            $prev_desc = (new ControllerORPrinting)->ctrGetIdDescription($accountid, $collDate, $branch_name);

            if ($prev_desc) {
                $value = $prev_desc['desc'];
                $last_desc = $prev_desc['desc'];
            
            } else {
                $value = '';
                $last_desc = '<- - SELECT DESCRIPTION - ->';
            }

            //<option disabled selected value=""><- - SELECT DESCRIPTION - -></option>

            $item['card'] ='
         
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                    <input type="text" id="branch_name" hidden name="branch_name" readonly class="form-control" value="'.$branch_name.'" placeholder="select ID">
                        <div class="col-2">
                            <label for="inputIdNo" class="col-form-label">ID NO :</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="account_id" name="account_id" readonly class="form-control" value="'.$accountid.'" placeholder="select ID">
                        </div>
                        <div class="col-3">
                            <label for="inputIdNo" class="col-form-label"></label>
                        </div>
                    
                        <div class="col-3.5">
                            <label for="inputIdNo" class="col-form-label">Last Saved id :</label>
                        </div>
                        <div class="col-3">
                            <input type="text" id="last_id" name="last_id" readonly class="form-control" value="'.$last_id.'" placeholder="select ID">
                         </div>
                         <div class="col-3">
                            <input type="hidden" id="cdate" name="cdate" readonly class="form-control" value="'.$cdate.'" placeholder="select ID">
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
                            <label for="inputBank" class="col-form-label">BANK :</label>
                        </div>
                        <div class="col-3">
                            <input type="text" id="bank" name="bank" readonly class="form-control"  value="'.$bank.'" placeholder="Enter Bank">
                        </div>
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">BANK. NO. :</label>
                        </div>
                        <div class="col-5">
                            <input type="text" id="bankno" readonly name="bankno" class="form-control" value="'.$bankno.'" placeholder="Enter Account Number">
                        </div>
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label">REF# :</label>
                        </div>
                        <div class="col-3">
                            <input type="number" id="effective" name="effective" readonly class="form-control"   placeholder="Ref. No.">
                        </div>
                        <div class="col-2">
                            <label for="inputAccountNo" class="col-form-label">EFFECTIVE:</label>
                        </div>
                        <div class="col-2">
                            <input type="text" id="" name="" class="form-control" readonly value="'.$effectiveMonth.'" placeholder="Month">
                        </div>
                        <div class="col-3">
                        <input type="text" id="" name="" class="form-control" value="'.$effectiveYear.'" readonly  placeholder="Year">
                        </div>
                    </div>

                    <div class="row mb-3">
               
                        <div class="col-2">
                            <label for="inputBank" class="col-form-label"></label>
                        </div>
                        <div class="col-3">
                            <input type="hidden" id="Batch" name="Batch" readonly class="form-control"  placeholder="OR No.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 form-group">
                
                        <label for="input-6">TARGET</label>
                            <input type="TEXT" class="form-control" id="target" readonly placeholder="Target" value="'.$target.'" name="target">
                            </div>   
                        <div class="col-sm-4 form-group">
                        
                            <label for="input-6">NORMAL</label>
                            <input type="TEXT" class="form-control" id="normal" readonly placeholder="Normal" value="'.$normal.'" name="normal">
                        </div>   
                        <div class="col-sm-4 form-group">
                        
                            <label for="input-6">PENSION</label>
                            <input type="TEXT" class="form-control" id="actpnsn" readonly placeholder="Pension" value="'.$actpnsn.'" name="actpnsn" >
                        </div>   
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 form-group">
                
                        <label for="input-6">AMOUNT</label>
                            <input type="TEXT" class="form-control" id="amount" readonly placeholder="Amount" value="'.$amount.'" name="amount">
                            </div>   
                        <div class="col-sm-4 form-group">
                        
                            <label for="input-6">PROBLEM CODE</label>
                            <input type="TEXT" class="form-control" id="collstat" readonly placeholder="Status" value="'.$collstat .'" name="collstat">
                        </div>   
                        <div class="col-sm-4 form-group">
                        
                            <label for="input-6">ATM BALANCE</label>
                            <input type="TEXT" class="form-control" id="atmbal" readonly placeholder="ATM Balance" value="'.$atmbal.'" name="atmbal">
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                        <label   label for="input-6">DESCRIPTION</label>
                            <select class="form-control" name="desc" id="desc" required>     
                            <option disabled selected value="'.$value.'">'.$last_desc.'</option>        
                            <option value="PARTIAL PAYMENT of LOAN">PARTIAL PAYMENT of LOAN</option>
                            <option value="PARTIAL PAYMENT of LOAN & PARTIAL PAYMENT OF SUPPLEMENTAL LOAN">PARTIAL PAYMENT of LOAN & PARTIAL PAYMENT OF SUPPLEMENTAL LOAN</option>
                            <option value="PARTIAL PAYMENT OF SUPPLEMENTAL LOAN">PARTIAL PAYMENT OF SUPPLEMENTAL LOAN</option>
                            <option value="GSIS LOAN PROCEEDS">GSIS LOAN PROCEEDS</option>
                            <option value="ALLOTMENT">ALLOTMENT</option>
                            <option value="FULL PAYMENT OF ACCOUNT">FULL PAYMENT OF ACCOUNT</option>
                            <option value="LUMPSUM">LUMPSUM</option>
                            <option value="PENSION ADJUSTMENT">PENSION ADJUSTMENT</option>
                            <option value="MONTHLY CHANGE">MONTHLY CHANGE</option>
                        
                            </select>
                    
                        </div>   
                   
                    </div>         
            </div><!--card-->

    ';

        echo json_encode($data);

    }
}
