<?php
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

$editInurance= new insuranceModal();
$editInurance -> showInsuranceEditModal();

class insuranceModal{ 
	public function showInsuranceEditModal(){
        $id = $_GET['idClient'];
        $data = (new ControllerInsurance)->ctrShowInsuranceID($id);
        foreach ($data as &$item) {
            $id = $item['id'];
            $account_id = $item['account_id'];
            $name = $item['name'];
            $birth_date = $item['birth_date'];
            $branch_name = $item['branch_name'];
            $avail_date = $item['avail_date'];
            $expire_date = $item['expire_date'];
            $amount = $item['amount'];
            $age = $item['age'];
            $ins_type = $item['ins_type'];
            $terms = $item['terms'];
            $ins_rate = $item['ins_rate'];
            $occupation = $item['occupation'];
            $civil_status = $item['civil_status'];
            $gender = $item['gender'];
            $amount_loan = $item['amount_loan'];
            $cbi_illness = $item['cbi_illness'];
            $dchs = $item['dchs'];
            $days = $item['days'];


            $lastLetter = substr($name, -1);
            if($lastLetter == "."){
                $lastThreeLetter = substr($name, -3);
                if($lastThreeLetter == "JR." || $lastThreeLetter == "SR."){
                    $middle_name = "";
                    $full_name = $name;
                }else{
                    $middle_name = substr($name, -2, 1);
                    $full_name = substr($name, 0, -2);
                }
            }else{
                $middle_name = "";
                $full_name = $name;
            }

            if($ins_type == "CBI"){
                $illness = "";
            }else{
                $illness = "hidden";
            }

            // //  GET THE TERMS
            // $date1 = new DateTime($avail_date);
            // $date2 = new DateTime($expire_date);
            // $interval = $date1->diff($date2);
            // $terms = $interval->y * 12 + $interval->m;

            // $age = date_diff(date_create($birth_date), date_create('today'))->y;

            if($ins_type == "OONA" || $ins_type == "PHIL" ){

    
            $item['card'] ='
        <div class="row">
            <div class="col-sm-2 form-group">
                <label for="input-6">ACCOUNT ID</label>
                <input type="text" class="form-control" readonly id="account_id" value="'.$account_id.'" name="account_id" autocomplete="nope" required>
                <input type="text" hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
             
            </div>   
        <div class="col-sm-4 form-group">
            <label for="input-6">NAME</label>
            <input type="text" class="form-control"  id="name" value="'.$full_name.'" name="name" autocomplete="nope" required>
        </div>  
        <div class="col-sm-2 form-group">
            <label for="input-6">MIDDLE INITIAL</label>
            <input type="text" class="form-control"  id="account_id" style="text-transform: uppercase;" maxlength="1" value="'.$middle_name.'" placeholder="Enter Middle Name" name="middle_name" autocomplete="nope">
        </div> 
        <div class="col-sm-2 form-group">
            <label for="input-6">BIRHTDATE</label>
            <input type="date" class="form-control"  id="birth_date" value="'.$birth_date.'" name="birth_date" autocomplete="nope" required>
        </div> 
        <div class="col-sm-2 form-group">
        <label for="input-6">AGE</label>
        <input type="text" class="form-control"  id="age" value="'.$age.'" name="age" autocomplete="nope" required>
    </div>
       
         </div> 
    <div class="row">
        <div class="col-sm-3 form-group">
            <label for="input-6">BRANCH</label>
            <input type="text" class="form-control" readonly id="account_id" value="'.$branch_name.'" name="account_id" autocomplete="nope" required>
        </div>
        <div class="col-sm-3 form-group">
            <label for="input-6">OCCUPATION</label>
            <input type="text" class="form-control" style="text-transform: uppercase;" id="account_id" value="'.$occupation.'" name="occupation" autocomplete="nope" required>
       </div>
       <div class="col-sm-3 form-group">
            <label for="input-6">CIVIL STATUS</label>
            <select class="form-control" name="civil_status" id="civil_status" required>
            ';
            if($civil_status!=""){
                 
        $item['card'] .='
                <option value="'.$civil_status.'">'.$civil_status.'</option>';
            }
    $item['card'] .='
                <option value=""><  - - SELECT STATUS - - ></option>
                <option value="MARRIED">MARRIED</option>
                <option value="WIDOWED">WIDOWED</option>
                <option value="SINGLE">SINGLE</option>
                <option value="DIVORCED">DIVORCED</option>
                <option value="LEGALLY SEPARATED">LEGALLY SEPARATED</option>
            </select>
       </div>
       <div class="col-sm-3 form-group">
            <label for="input-6">GENDER</label>
            <select class="form-control" name="gender" required>
            ';
            if($gender!=""){
                 
        $item['card'] .='
                <option value="'.$gender.'">'.$gender.'</option>';
            }
    $item['card'] .='
                 <option value=""><  - - SELECT GENDER - - ></option>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
            </select>
       </div>
    </div> 
    <div class="row">
    <div class="col-sm-2 form-group">
        <label for="input-6">TERMS</label>
        <input type="text" class="form-control" readonly id="terms" value="'.$terms.'" name="terms" autocomplete="nope" required>
    </div>
        <div class="col-sm-2 form-group">
            <label for="input-6">AVAIL DATE</label>
            <input type="date" class="form-control" readonly id="avail_date" value="'.$avail_date.'" name="account_id" autocomplete="nope" required>
        </div>
        <div class="col-sm-2 form-group">
            <label for="input-6">AMOUNT LOAN</label>
            <input type="text" class="form-control amount_loan"  id="amount_loan" value="'.$amount_loan.'" name="amount_loan" autocomplete="nope" required> 
         </div>
        <div class="col-sm-2 form-group">
            <label for="input-6">EXPIRE DATE</label>
            <input type="date" class="form-control expire_date"  id="expire_date" value="'.$expire_date.'" name="expire_date" autocomplete="nope" required>
        </div>
        <div class="col-sm-2 form-group">
            <label for="input-6">INSURANCE RATE</label>
            <input type="text" class="form-control"  readonly id="ins_rate" value="'.$ins_rate.'" name="ins_rate" autocomplete="nope" required>
         </div>
        <div class="col-sm-2 form-group">
            <label for="input-6">Insurance Premium</label>
            <input type="text" class="form-control" readonly id="amount" value="'.$amount.'" name="amount" autocomplete="nope" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 form-group">
            <label for="input-6">Insurance Type</label>
            <input type="text" readonly class="form-control" id="ins_type1"  name="ins_type" value="'.$ins_type.'" autocomplete="nope">
        </div>
    </div>

            ';
        }
        
        else{
            $item['card'] ='
            <div class="row">
                <div class="col-sm-2 form-group">
                    <label for="input-6">ACCOUNT ID</label>
                    <input type="text" class="form-control" readonly id="account_id" value="'.$account_id.'" name="account_id" autocomplete="nope" required>
                    <input type="text" hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
                 
                </div>   
            <div class="col-sm-4 form-group">
                <label for="input-6">NAME</label>
                <input type="text" class="form-control"  id="name" value="'.$full_name.'" name="name" autocomplete="nope" required>
            </div>  
            <div class="col-sm-2 form-group">
                <label for="input-6">MIDDLE INITIAL</label>
                <input type="text" class="form-control"  id="account_id" style="text-transform: uppercase;" maxlength="1" value="'.$middle_name.'" placeholder="Enter Middle Name" name="middle_name" autocomplete="nope">
            </div> 
            <div class="col-sm-2 form-group">
                <label for="input-6">BIRHTDATE</label>
                <input type="date" class="form-control"  id="birth_date" value="'.$birth_date.'" name="birth_date" autocomplete="nope" required>
            </div> 
            <div class="col-sm-2 form-group">
            <label for="input-6">AGE</label>
            <input type="text" class="form-control"  id="age" value="'.$age.'" name="age" autocomplete="nope" required>
        </div>
           
             </div> 
        <div class="row">
            <div class="col-sm-3 form-group">
                <label for="input-6">BRANCH</label>
                <input type="text" class="form-control" readonly id="account_id" value="'.$branch_name.'" name="account_id" autocomplete="nope" required>
            </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">OCCUPATION</label>
                <input type="text" class="form-control" style="text-transform: uppercase;" id="account_id" value="'.$occupation.'" name="occupation" autocomplete="nope" required>
           </div>
           <div class="col-sm-3 form-group">
                <label for="input-6">CIVIL STATUS</label>
                <select class="form-control" name="civil_status" id="civil_status" required>
                ';
                if($civil_status!=""){
                     
            $item['card'] .='
                    <option value="'.$civil_status.'">'.$civil_status.'</option>';
                }
        $item['card'] .='
                    <option value=""><  - - SELECT STATUS - - ></option>
                    <option value="MARRIED">MARRIED</option>
                    <option value="WIDOWED">WIDOWED</option>
                    <option value="SINGLE">SINGLE</option>
                    <option value="DIVORCED">DIVORCED</option>
                    <option value="LEGALLY SEPARATED">LEGALLY SEPARATED</option>
                </select>
           </div>
           <div class="col-sm-2 form-group">
                <label for="input-6">GENDER</label>
                <select class="form-control" name="gender" required>
                ';
                if($gender!=""){
                     
            $item['card'] .='
                    <option value="'.$gender.'">'.$gender.'</option>';
                }
        $item['card'] .='
                     <option value=""><  - - SELECT GENDER - - ></option>
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>
                </select>
           </div>
           <div class="col-sm-2 form-group" '.$illness.'>
           <label for="input-6">CBI Illness</label>
           <input type="text" style="text-transform: uppercase;"   class="form-control cbi_illness1" id="cbi_illness1"  name="cbi_illness" value="'.$cbi_illness.'" autocomplete="nope">
       </div>
        </div> 
        <div class="row">
        <div class="col-sm-2 form-group">
            <label for="input-6">TERMS</label>
            <input type="text" class="form-control" readonly id="terms" value="'.$terms.'" name="terms" autocomplete="nope" required>
        </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">AVAIL DATE</label>
                <input type="date" class="form-control" readonly id="avail_date" value="'.$avail_date.'" name="account_id" autocomplete="nope" required>
            </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">AMOUNT LOAN</label>
                <input type="text" class="form-control amount_loan"  id="amount_loan" value="'.$amount_loan.'" name="amount_loan" autocomplete="nope" required> 
             </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">EXPIRE DATE</label>
                <input type="date" class="form-control expire_date"  id="expire_date" value="'.$expire_date.'" name="expire_date" autocomplete="nope" required>
            </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">INSURANCE RATE</label>
                <input type="text" class="form-control"  readonly id="ins_rate" value="'.$ins_rate.'" name="ins_rate" autocomplete="nope" required>
             </div>
            <div class="col-sm-2 form-group">
                <label for="input-6">Insurance Premium</label>
                <input type="text" class="form-control" readonly id="amount" value="'.$amount.'" name="amount" autocomplete="nope" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 form-group">
                <label for="input-6">Insurance Type</label>
                <input type="text" readonly class="form-control" id="ins_type1"  name="ins_type" value="'.$ins_type.'" autocomplete="nope">
            </div>
        <div class="col-sm-3 form-group" '.$illness.'>
            <label for="input-6">DCHS #</label>
            <input type="text"  class="form-control" id="dchs"  name="dchs" value="'.$dchs.'" autocomplete="nope">
        </div>
        <div class="col-sm-2 form-group" '.$illness.'>
            <label for="input-6">DAYS</label>
            <input type="text"  readonly class="form-control days1" id="days1"  name="days" value="'.$days.'" autocomplete="nope">
        </div>
        </div>
    
                ';
        }
        }
        echo json_encode($data);
    }
}