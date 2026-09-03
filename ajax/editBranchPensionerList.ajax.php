<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$editAccntModal= new operationAjaxModal();
$editAccntModal->showEditModal();    



class operationAjaxModal{
	
    public function showEditModal(){
        $id = $_GET['id'];   

        $branch_name_session = $_SESSION['branch_name'];

        $data = (new ControllerPensioner)->ctrShowPensionerAccntTarget($branch_name_session, $id);

        foreach ($data as &$item) {
          
            $accnt_id = $item['id'];
            $branch_name = $item['branch_name'];
            $penIn = $item['penIn'];
            $penOut = $item['penOut']; 
            $pen_ins_com = $item['pen_ins_com']; 
            $penDate = $item['penDate']; 


            $item['card'] = '
                <div class="row">
                    <div class="col-sm-7 form-group">
                        <input type="text" class="form-control" readonly value="' . $branch_name . '" id="branch_name"  placeholder="Enter Number"  name="branch_name" autocomplete="nope" required>
                        <input type="text" class="form-control" readonly hidden value="' . $accnt_id . '" name="pen_id" autocomplete="nope" required>
                    </div>
                    <div class="col-sm-7 form-group">
                        <label for="input-6">PENSION TYPE</label>
                        <select class="form-control" name="penInsurance" id="penInsurance" required>
                            <option value="'.$pen_ins_com.'" selected>'.$pen_ins_com.'</option>
                            <option value="GSIS">GSIS</option>
                            <option value="SSS">SSS</option>';
            if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'ELC BULACAN') {
                $item['card'] .= '
                            <option value="PACERS">PACERS</option>
                            <option value="PVAO">PVAO</option>';
            } elseif ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC BURGOS') {
                $item['card'] .= '
                            <option value="PVAO">PVAO</option>
                            <option value="PNP">PNP</option>
                            <option value="OLR">OLR</option>
                            <option value="OLR-REAL ESTATE">OLR-REAL ESTATE</option>
                            <option value="OLR-HOUSE LOAN">OLR-HOUSE LOAN</option>';
            } elseif ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC KALIBO') {
                $item['card'] .= '
                            <option value="PVAO">PVAO</option>
                            <option value="PNP">PNP</option>';
            } elseif ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC SINGCANG') {
                $item['card'] .= '
                            <option value="PVAO">PVAO</option>
                            <option value="OLR">OLR</option>
                            <option value="OLR-REAL ESTATE">OLR-REAL ESTATE</option>
                            <option value="OLR-HOUSE LOAN">OLR-HOUSE LOAN</option>
                            <option value="OLR-CHATTEL">OLR-CHATTEL</option>';
            } elseif ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC ANTIQUE') {
                $item['card'] .= '
                            <option value="OLR-REAL ESTATE">OLR-REAL ESTATE</option>
                            <option value="PNP">PNP</option>';
            }
            $item['card'] .= '
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="input-6">IN</label>
                                <input type="number" class="form-control" id="penIn"  placeholder="Enter IN" value="'.$penIn.'"  name="penIn" autocomplete="nope" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="input-6">OUT</label>
                                <input type="number" class="form-control" id="penOut"  placeholder="Enter OUT" value="'.$penOut.'"  name="penOut" autocomplete="nope" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 form-group">
                        <label for="input-6">DATE</label>
                        <input type="date" class="form-control dateFrom" id="penDate" readonly  placeholder="Enter Date" value="'.$penDate.'"  name="penDate" autocomplete="nope" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editPensioner" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>';
           
        }
            
        echo json_encode($data);
    }




}