<?php
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";
$checkInsurance= new insuranceModal();
 $checkInsurance->showCheckerModal();    


class insuranceModal{
	public function showCheckerModal(){
        $avail_date = $_GET['avail_date'];
        $data = (new ControllerInsurance)->ctrGetInsuranceChecker($avail_date);
        $i = 1;
        foreach ($data as &$item) {
            $branch_name = $item['branch_name'];
         
            $item['card'] ='
            <tr>
              <td>'.$i.'</td>
              <td>'.$branch_name.'</td>
            </tr>
            ';
            $i++;
        }
        echo json_encode($data);
    }

}