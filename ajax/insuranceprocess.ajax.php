<?php
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

$editInurance= new insuranceModal();
$editInurance -> showInsuranceEditModal();

class insuranceModal{
	public function showInsuranceEditModal(){
        $age = $_GET['age'];
        $avail_date = $_GET['avail_date'];
        $birth_date = $_GET['birth_date'];
        $expire_date = $_GET['expire_date'];
        $ins_type = $_GET['ins_type'];
      
        if($ins_type == "OONA"){
            $terms = (new insuranceModal)->age_validator($birth_date, $avail_date, $expire_date);
            $data = (new ModelInsurance)->mdlgetRate($age, $terms);
        }elseif($ins_type == "CBI"){
            // Create DateTime objects from the input dates
            $avail_date_obj = new DateTime($avail_date);
            $expire_date_obj = new DateTime($expire_date);

            // Format the dates to 'Ymd'
            $avail_date1 = $avail_date_obj->format('Ymd');
            $expire_date1 = $expire_date_obj->format('Ymd');

            $terms = (new ControllerInsurance)->cbi_age_validator($birth_date, $avail_date1, $expire_date1);
            $data = (new ModelInsurance)->mdlget_cbi_Rate($terms);
        }else if($ins_type == "PHIL"){
            $terms = (new insuranceModal)->age_validator($birth_date, $avail_date, $expire_date);
            $data = (new ModelInsurance)->mdlgetPhilRate($age, $terms);
        }
      
        echo json_encode($data);
    }


    public function  age_validator($birth_date, $avail_date, $expire_date) {
        $age = date_diff(date_create($birth_date), date_create("$expire_date +1 month"))->y;
        $date1 = new DateTime($avail_date);
        $date2 = new DateTime($expire_date);
        $interval = $date1->diff($date2);
        $terms = $interval->y * 12 + $interval->m;
    
            $xdate_day = date_create($expire_date)->format('d');
            $avail_day = date_create($avail_date)->format('d');
            if ($avail_day != $xdate_day) { 
                // Do something when xdate day is greater than or equal to avail day
              $total_terms =   $terms + 1;
            }
            else{
                $total_terms = $terms;
            
        }
        return $total_terms;
    }
}