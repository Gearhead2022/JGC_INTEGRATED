<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";

$filterSummary= new reportTable();
$filterSummary -> showAccountFilter();

class reportTable{
	public function showAccountFilter(){

        $dateFrom = $_GET['dateFrom']; /*start from entered date*/ 
        $dateFromMonth = date('Y-m-t', strtotime($dateFrom));
        $dateStarts = date('Y-m', strtotime($dateFrom));
        $dateStart = $dateStarts.'-01';
        $branch_name_input = $_GET['branch_name_input']; 

        if ($branch_name_input === 'FCHN') {
          $data = (new ControllerPastdue)->ctrPastDueSummaryFCHNegros($branch_name_input,$dateFromMonth,$dateStart );
      } elseif ($branch_name_input === 'FCHM') {
          $data = (new ControllerPastdue)->ctrPastDueSummaryFCHManila($branch_name_input, $dateFromMonth,$dateStart );
      } else{
        $data = (new ControllerPastdue)->ctrBadAccounts($branch_name_input,$dateFromMonth,$dateStart);
      } 
        $grandtotal_S_Deceased = 0;
        $totalOf_E_S_Deceased = 0;
        $grandTotalDeceasedAmount = 0;
        $finalTotalAmountOfS_Deceased = 0;
        $grandtotal_E_Deceased = 0;
        $finalTotalAmountOfE_Deceased = 0;
        $grandtotalNumberES_Deceased = 0;
        $finalTotal_ES_Deceased = 0;
        $FinalTotal_S_Police = 0;
        $FinalTotalAmount_S_Police = 0;
        $finalTotal_E_Police = 0;
        $FinalTotalAmount_E_Police = 0;
        $grandTotal_ES_Police = 0;
        $TotalAmount_ES_Police = 0;
        $TotalOF_S = 0;
        $grandTotalES_PD = 0;
        $Grandtotal = 0;
        $FinalTotal_PastDue = 0;
        $formatted_finalTotalAmountOfS_Deceased = 0;
        $formatted_finalTotalAmountOfE_Deceased = 0;
        $formatted_FinalTotalAmount_S_Police = 0;
        $formatted_FinalTotalAmount_E_Police = 0;
        $formatted_TotalAmount_ES_Police = 0;
        $TotalOF_E = 0;
        $formatted_FinalTotal_PastDue = 0;
        foreach($data as &$item1){
          // total of e and s for deceased, e and s for deceased values
            $branch_name_inputs = $item1['branch_name'];

           // $total_S_Decease = $item1['total_S_type'];
           // $grandtotal_S_Deceased += $total_S_Decease;

           // $total_E_Decease = $item1['total_E_type'];
           // $grandtotal_E_Deceased += $total_E_Decease;
            //total of e and s for deceased for each branch

            //$totalOf_E_S_Deceased = $total_S_Decease + $total_E_Decease;
            //Grand total of e and s deceased for all the branches 
            $grandtotalNumberES_Deceased += $totalOf_E_S_Deceased;


           
            
            $info2 = (new ControllerPastdue)->ctrTotalOfAmountDecease_S($branch_name_inputs,$dateFromMonth,$dateStart);
            $total_amount =  $info2[0];
            $total_Decease_S = $info2[1];
            $grandtotal_S_Deceased += $total_Decease_S;
            
           // $totalOf_E_S_Deceased = $total_Decease_S + $total_E_Decease;


            //final total amount of s for deceased
            $finalTotalAmountOfS_Deceased += $total_amount;
            $formatted_finalTotalAmountOfS_Deceased = number_format($finalTotalAmountOfS_Deceased, 2, '.', ',');
            $total_amount_formatted2 = number_format($total_amount, 2, '.',',');


            $info3 = (new ControllerPastdue)->ctrTotalOfAmountDecease_E($branch_name_inputs,$dateFromMonth,$dateStart);
            $total_amount3 =  $info3[0];
            $total_Decease_E = $info3[1];

            $grandtotal_E_Deceased += $total_Decease_E;
            $totalOf_E_S_Deceased = $total_Decease_S + $total_Decease_E;

            //final total amount of e for deceased 
            $finalTotalAmountOfE_Deceased += $total_amount3;
            $formatted_finalTotalAmountOfE_Deceased = number_format($finalTotalAmountOfE_Deceased, 2, '.',',');
            $total_amount_formatted3 = number_format($total_amount3, 2, '.',',');

            //total amount of deceased
            $grandTotalDeceasedAmountNotformatted = $total_amount + $total_amount3;
            $grandTotalDeceasedAmount = number_format($total_amount + $total_amount3, 2, '.', ',');
           
            // police

            $info4 = (new ControllerPastdue)->ctrBadAccounts_TypeP($branch_name_inputs,$dateFromMonth,$dateStart);
            $total_S_Police =  $info4[0];
            $total_E_Police = $info4[1];
            $formatted_Police_Amount = $info4[2];
            $formatted_Police_AmountTypeE = $info4[3];
            $total_ES_Police = $info4[4];
            $totalAmountPolice_ES = $info4[5];  
            $totalAmountPolice_ES_Notformatted = $info4[6];
            $Police_Amount = $info4[7];
            $Police_AmountTypeE = $info4[8];
            //$FinalTotal_S_Police = $info4[7];
            
            //total of S for deceased and police
            $total_S_OfDP = $total_Decease_S + $total_S_Police;
            //total of E for deceased and police
            $total_E_OfDP = $total_Decease_E + $total_E_Police;
            // total of e s for police and deceased
            $FinalTotal_ES_DP = $total_S_OfDP + $total_E_OfDP;

            //grand total of E and S for police and deceased
            $grandTotalES_PD += $FinalTotal_ES_DP;
          
              // total amount of past due, deceased and police amount
            $FinalTotalDeceased_Police = number_format($grandTotalDeceasedAmountNotformatted + $totalAmountPolice_ES_Notformatted, 2, '.', ',');
            // grand total not formatted , bottom
            $Grandtotal = $grandTotalDeceasedAmountNotformatted + $totalAmountPolice_ES_Notformatted;
            $FinalTotal_PastDue += $Grandtotal;
            $formatted_FinalTotal_PastDue = number_format($FinalTotal_PastDue, 2, '.', ',');

            // total of e and s amount for deceased type , bottom row
            $finalTotal_ES_Deceased = number_format($finalTotalAmountOfS_Deceased + $finalTotalAmountOfE_Deceased, 2, '.', ',');

            // totals , bottom row total of s for police 
            $FinalTotal_S_Police += $info4[0];
            // total s police amount
            $FinalTotalAmount_S_Police += $info4[7];
            $formatted_FinalTotalAmount_S_Police = number_format($FinalTotalAmount_S_Police, 2,'.',',');

            //bottom row total e police
            $finalTotal_E_Police += $total_E_Police;
            // total of e and s for police number , bottom row
            $grandTotal_ES_Police = $finalTotal_E_Police + $FinalTotal_S_Police;
            
            $FinalTotalAmount_E_Police += $info4[8];
            $formatted_FinalTotalAmount_E_Police = number_format($FinalTotalAmount_E_Police, 2, '.', ',');

            // total of police action amount of E and S, police , bottom row 
            $TotalAmount_ES_Police = $FinalTotalAmount_E_Police + $FinalTotalAmount_S_Police;
            $formatted_TotalAmount_ES_Police = number_format($TotalAmount_ES_Police, 2, '.', ',');

            // grand total of s 
          
            $TotalOF_S = $grandtotal_S_Deceased + $FinalTotal_S_Police;
            $TotalOF_E = $grandtotal_E_Deceased + $finalTotal_E_Police;

             $branch_name_inputs = str_replace("RLC", "RFC", $branch_name_inputs);
            $item1['card'] = '
            <tr>
            <td>'.$branch_name_inputs.'</td>
            <td>'.$total_Decease_S.'</td>
            <td>'.$total_amount_formatted2.'</td>
            <td>'.$total_Decease_E.'</td>
            <td>'.$total_amount_formatted3.'</td>
            <td>'.$totalOf_E_S_Deceased.'</td>
            <td>'.$grandTotalDeceasedAmount.'</td>
            <td>'.$total_S_Police.'</td>
            <td>'.$formatted_Police_Amount.'</td>
            <td>'.$total_E_Police.'</td>
            <td>'.$formatted_Police_AmountTypeE.'</td>
            <td>'.$total_ES_Police.'</td>
            <td>'.$totalAmountPolice_ES.'</td>
            <td>'.$total_S_OfDP.'</td>
            <td>'.$total_E_OfDP.'</td>
            <td>'.$FinalTotal_ES_DP.'</td>
            <td>'.$FinalTotalDeceased_Police.'</td>
          </tr>
            ';
        }
        $item1['card'] .= '

        <tr>
        <td>Total</td>
        <td>'.$grandtotal_S_Deceased.'</td>
        <td>'.$formatted_finalTotalAmountOfS_Deceased.'</td>
        <td>'.$grandtotal_E_Deceased.'</td>
        <td>'.$formatted_finalTotalAmountOfE_Deceased.'</td>
        <td>'.($grandtotal_S_Deceased + $grandtotal_E_Deceased).'</td>
        <td>'.$finalTotal_ES_Deceased.'</td>
        <td>'.$FinalTotal_S_Police.'</td>
        <td>'.$formatted_FinalTotalAmount_S_Police.'</td>
        <td>'.$finalTotal_E_Police.'</td>
        <td>'.$formatted_FinalTotalAmount_E_Police.'</td>
        <td>'.$grandTotal_ES_Police.'</td>
        <td>'.$formatted_TotalAmount_ES_Police.'</td>
        <td>'.$TotalOF_S.'</td>
        <td>'.$TotalOF_E.'</td>
        <td>'.$grandTotalES_PD.'</td>
        <td>'.$formatted_FinalTotal_PastDue.'</td>
        </tr>

        ';

        echo json_encode($data);
        
    }
   
}


