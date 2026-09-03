<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../models/connection.php";
$connection = new connection;
$connection->connect();

$filterPensioner= new pensionerTable();

$user_session = substr($_SESSION['branch_name'], 0 , 3);

if ($_SESSION['type'] == 'backup_user' && $user_session == 'EMB' || $_SESSION['type'] == 'backup_user' && $user_session == 'FCH') {
    
    $filterPensioner -> showPensionerFilterEMB_FCH();
    
} else if ($_SESSION['type'] == 'backup_user' && $user_session == 'ELC') {

    $filterPensioner -> showPensionerFilterELC();

} else if ($_SESSION['type'] == 'backup_user' && $user_session == 'RLC') {

    if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC BURGOS') {

        $filterPensioner -> showPensionerFilterRLCBURGOS();

    } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC KALIBO'){

        $filterPensioner -> showPensionerFilterRLCKALIBO();

    } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC SINGCANG') {

        $filterPensioner -> showPensionerFilterRLCSINGCANG();

    } else if ($_SESSION['type'] == 'backup_user' && $_SESSION['branch_name'] == 'RLC ANTIQUE') {

        $filterPensioner -> showPensionerFilterRLCANTIQUE();

    }
}

class pensionerTable{
	public function showPensionerFilterEMB_FCH(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        
        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        $SSS  = 'SSS';
        $GSIS = 'GSIS';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        $newBegBalValueSSS = 0;
        $newBegBalValueGSIS = 0;

        $firstDayOfYear = $lastYearDate . '-01-01';
        $lastDayOfYear = $lastYearDate . '-12-31';

        $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
        
        $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

        // get last transaction

        $firstDayOfTrans = '1990-01-01';
        $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));

        $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
        
        $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);

  
        if ($sss1[0] === 0) {
            
            $penDateDataNewSSS = $lastTransactionDataSSS; 
            
        } else {
            $penDateDataNewSSS = $sss1[0];
        }

        $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
        $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
        $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
        $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
        $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;


        if ($gsis1[0] === 0) {
            
            $penDateDataNewGSIS = $lastTransactionDataGSIS;
     
        } else {
            $penDateDataNewGSIS = $gsis1[0];
        }
        
        
        $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
        $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
        $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
        $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
        $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;


        $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
        $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

        $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
        $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

        $item1 = array();
        $item1['card'] = ''; 
     


        $item1['card'] .='<tr>
        <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem;">'.$_SESSION['branch_name'].'</th>
        <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
        <th class="table-border">'.$newBegBalValueSSS[0].'</th>
        <th class="table-border">'.$lastTransactionDataSSS.'</th>';

        if ($day1_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$sss1[1].'</th>
            <th class="table-border">'.$sss1[2].'</th>
            <th class="table-border">'.$sss11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= '<th class="table-border">'.$sss2[1].'</th>
            <th class="table-border">'.$sss2[2].'</th>
            <th class="table-border">'.$sss22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$sss3[1].'</th>
            <th class="table-border">'.$sss3[2].'</th>
            <th class="table-border">'.$sss33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$sss4[1].'</th>
            <th class="table-border">'.$sss4[2].'</th>
            <th class="table-border">'.$sss44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$sss5[1].'</th>
            <th class="table-border">'.$sss5[2].'</th>
            <th class="table-border">'.$sss55.'</th>';
        }
        $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item1['card'] .=
            '        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>         
                </tr> ';

                
            $item1['card'] .=

                '<tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>';

        if ($day1_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$gsis1[1].'</th>
            <th class="table-border">'.$gsis1[2].'</th>
            <th class="table-border">'.$gsis11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$gsis2[1].'</th>
            <th class="table-border">'.$gsis2[2].'</th>
            <th class="table-border">'.$gsis22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$gsis3[1].'</th>
            <th class="table-border">'.$gsis3[2].'</th>
            <th class="table-border">'.$gsis33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$gsis4[1].'</th>
            <th class="table-border">'.$gsis4[2].'</th>
            <th class="table-border">'.$gsis44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= 
            '<th class="table-border">'.$gsis5[1].'</th>
            <th class="table-border">'.$gsis5[2].'</th>
            <th class="table-border">'.$gsis55.'</th>';
        }
        $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

        $item1['card'] .=
        ' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
        
        </tr>';  

        $totalBeginningBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0];
        $totalLastTransactionBalSSSGSIS = $lastTransactionDataSSS + $lastTransactionDataGSIS;
        
        $item1['card'] .= '<tr>
            <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
            <th class="table-border">' . $totalBeginningBalSSSGSIS . '</th>
            <th class="table-border">' . $totalLastTransactionBalSSSGSIS . '</th>';
        
        if ($day1_param > 0) {
            $totalDay1SSSGSIS = $sss1[1] + $gsis1[1];
            $totalDay2SSSGSIS = $sss1[2] + $gsis1[2];
            $totalDay3SSSGSIS = $sss11 + $gsis11;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSIS . '</th>
            <th class="table-border">' . $totalDay2SSSGSIS . '</th>
            <th class="table-border">' . $totalDay3SSSGSIS . '</th>';
        }
        
        if ($day2_param > 0) {
            $totalDay1SSSGSIS = $sss2[1] + $gsis2[1];
            $totalDay2SSSGSIS = $sss2[2] + $gsis2[2];
            $totalDay3SSSGSIS = $sss22 + $gsis22;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSIS . '</th>
            <th class="table-border">' . $totalDay2SSSGSIS . '</th>
            <th class="table-border">' . $totalDay3SSSGSIS . '</th>';
        }
        
        if ($day3_param > 0) {
            $totalDay1SSSGSIS = $sss3[1] + $gsis3[1];
            $totalDay2SSSGSIS = $sss3[2] + $gsis3[2];
            $totalDay3SSSGSIS = $sss33 + $gsis33;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSIS . '</th>
            <th class="table-border">' . $totalDay2SSSGSIS . '</th>
            <th class="table-border">' . $totalDay3SSSGSIS . '</th>';
        }
        
        if ($day4_param > 0) {
            $totalDay1SSSGSIS = $sss4[1] + $gsis4[1];
            $totalDay2SSSGSIS = $sss4[2] + $gsis4[2];
            $totalDay3SSSGSIS = $sss44 + $gsis44;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSIS . '</th>
            <th class="table-border">' . $totalDay2SSSGSIS . '</th>
            <th class="table-border">' . $totalDay3SSSGSIS . '</th>';
        }
        
        if ($day5_param > 0) {
            $totalDay1SSSGSIS = $sss5[1] + $gsis5[1];
            $totalDay2SSSGSIS = $sss5[2] + $gsis5[2];
            $totalDay3SSSGSIS = $sss55 + $gsis55;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSIS . '</th>
            <th class="table-border">' . $totalDay2SSSGSIS . '</th>
            <th class="table-border">' . $totalDay3SSSGSIS . '</th>';
        }
        
        $netTotalInGSIS_SSS = $totalInGSIS + $totalInSSS;
        $netTotalOutGSIS_SSS = $totalOutGSIS + $totalOutSSS;
        $netTotalGSIS_SSS = $netTotalInGSIS_SSS - $netTotalOutGSIS_SSS;
        $netSSSGSIS55 = $sss55 + $gsis55;
        
        $item1['card'] .= '
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalInGSIS_SSS . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalOutGSIS_SSS . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalGSIS_SSS . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netSSSGSIS55 . '</th>
        </tr>

        <tr><td colspan="25" class="invisible">ddfd</td></tr>';
            
        echo json_encode($item1);
    
    }


	public function showPensionerFilterELC(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];

        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        $SSS  = 'SSS';
        $GSIS = 'GSIS';
        $PACERS = 'PACERS';
        $PVAO  = 'PVAO';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        $pacers1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PACERS);
        $pacers2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PACERS);
        $pacers3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PACERS);
        $pacers4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PACERS);
        $pacers5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PACERS);

        $pvao1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PVAO);
        $pvao2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PVAO);
        $pvao3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PVAO);
        $pvao4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PVAO);
        $pvao5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PVAO);
        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        $firstDayOfYear = $lastYearDate . '-01-01';
        $lastDayOfYear = $lastYearDate . '-12-31';

        $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
        
        $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

        $newBegBalValuePACERS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PACERS);

        $newBegBalValuePVAO = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PVAO);

        // get last transaction

        $firstDayOfTrans = '1990-01-01';
        $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));

        $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
        
        $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);

        $lastTransactionDataPACERS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PACERS, $firstDayOfTrans, $lastDayOfTrans);

        $lastTransactionDataPVAO = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PVAO, $firstDayOfTrans, $lastDayOfTrans);
 
        if ($sss1[0] === 0) {
           
            $penDateDataNewSSS = $lastTransactionDataSSS;
             
        } else {
            $penDateDataNewSSS = $sss1[0];
        }

        $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
        $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
        $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
        $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
        $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;

        if ($gsis1[0] === 0) {
           
            $penDateDataNewGSIS =  $lastTransactionDataGSIS;
                  
        } else {
            $penDateDataNewGSIS = $gsis1[0];
        }
        
        $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
        $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
        $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
        $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
        $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;

     
        if ($pacers1[0] === 0) {          
          
            $penDateDataNewPACERS = $lastTransactionDataPACERS;
                      
        } else {
            $penDateDataNewPACERS = $pacers1[0];
        }

        $pacers11 = ($pacers1[0] != 0) ? $pacers1[0] : $penDateDataNewPACERS;
        $pacers22 = ($pacers2[0] != 0) ? $pacers2[0] : $pacers11;
        $pacers33 = ($pacers3[0] != 0) ? $pacers3[0] : $pacers22;
        $pacers44 = ($pacers4[0] != 0) ? $pacers4[0] : $pacers33;
        $pacers55 = ($pacers5[0] != 0) ? $pacers5[0] : $pacers44;

        if ($pvao1[0] === 0) {          
          
            $penDateDataNewPVAO = $lastTransactionDataPVAO;
    
        } else {
            $penDateDataNewPVAO = $pvao1[0];
        }

        $pvao11 = ($pvao1[0] != 0) ? $pvao1[0] : $penDateDataNewPVAO;
        $pvao22 = ($pvao2[0] != 0) ? $pvao2[0] : $pvao11;
        $pvao33 = ($pvao3[0] != 0) ? $pvao3[0] : $pvao22;
        $pvao44 = ($pvao4[0] != 0) ? $pvao4[0] : $pvao33;
        $pvao55 = ($pvao5[0] != 0) ? $pvao5[0] : $pvao44;


        $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
        $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

        $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
        $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

        $totalInPACERS = $pacers1[1]+$pacers2[1]+$pacers3[1]+$pacers4[1]+$pacers5[1];
        $totalOutPACERS = $pacers1[2]+$pacers2[2]+$pacers3[2]+$pacers4[2]+$pacers5[2];

        $totalInPVAO = $pvao1[1]+$pvao2[1]+$pvao3[1]+$pvao4[1]+$pvao5[1];
        $totalOutPVAO = $pvao1[2]+$pvao2[2]+$pvao3[2]+$pvao4[2]+$pvao5[2];


        $item1['card'] ='
            <tr>
                <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem;">'.$_SESSION['branch_name'].'</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                <th class="table-border">'.$lastTransactionDataSSS.'</th>';

                if ($day1_param > 0) {
                    $item1['card'] .= '<th class="table-border">'.$sss1[1].'</th>
                    <th class="table-border">'.$sss1[2].'</th>
                    <th class="table-border">'.$sss11.'</th>';
                }
                if ($day2_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                    <th class="table-border">'.$sss2[2].'</th>
                    <th class="table-border">'.$sss22.'</th>';
                }
                if ($day3_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$sss3[1].'</th>
                    <th class="table-border">'.$sss3[2].'</th>
                    <th class="table-border">'.$sss33.'</th>';
                }
                if ($day4_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$sss4[1].'</th>
                    <th class="table-border">'.$sss4[2].'</th>
                    <th class="table-border">'.$sss44.'</th>';
                }
                if ($day5_param > 0) {
                    $item1['card'] .= '   <th class="table-border">'.$sss5[1].'</th>
                    <th class="table-border">'.$sss5[2].'</th>
                    <th class="table-border">'.$sss55.'</th>';
                }
                $sub_totalSSS = $totalInSSS - $totalOutSSS;

        $item1['card'] .='
  
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
               
            </tr>   

            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
            <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
            <th class="table-border">'.$lastTransactionDataGSIS.'</th>
        ';

        if ($day1_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
            <th class="table-border">'.$gsis1[2].'</th>
            <th class="table-border">'.$gsis11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
            <th class="table-border">'.$gsis2[2].'</th>
            <th class="table-border">'.$gsis22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
            <th class="table-border">'.$gsis3[2].'</th>
            <th class="table-border">'.$gsis33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$gsis4[1].'</th>
            <th class="table-border">'.$gsis4[2].'</th>
            <th class="table-border">'.$gsis44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
            <th class="table-border">'.$gsis5[2].'</th>
            <th class="table-border">'.$gsis55.'</th>';
        }

        $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

        $item1['card'] .='
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
         
            </tr>  
            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PACERS</th>
            <th class="table-border">'.$newBegBalValuePACERS[0].'</th>
            <th class="table-border">'.$lastTransactionDataPACERS.'</th>
        ';

        if ($day1_param > 0) {
            $item1['card'] .= ' <th class="table-border">'.$pacers1[1].'</th>
            <th class="table-border">'.$pacers1[2].'</th>
            <th class="table-border">'.$pacers11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$pacers2[1].'</th>
            <th class="table-border">'.$pacers2[2].'</th>
            <th class="table-border">'.$pacers22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$pacers3[1].'</th>
            <th class="table-border">'.$pacers3[2].'</th>
            <th class="table-border">'.$pacers33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= '    <th class="table-border">'.$pacers4[1].'</th>
            <th class="table-border">'.$pacers4[2].'</th>
            <th class="table-border">'.$pacers44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= '    <th class="table-border">'.$pacers5[1].'</th>
            <th class="table-border">'.$pacers5[2].'</th>
            <th class="table-border">'.$pacers55.'</th>';
        }
        $sub_totalPACERS = $totalInPACERS - $totalOutPACERS;

        $item1['card'] .= '

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPACERS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPACERS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPACERS.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pacers55.'</th>
     
            </tr>  
            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
            <th class="table-border">'.$lastTransactionDataPVAO.'</th>

        ';

        if ($day1_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
            <th class="table-border">'.$pvao1[2].'</th>
            <th class="table-border">'.$pvao11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$pvao2[1].'</th>
            <th class="table-border">'.$pvao2[2].'</th>
            <th class="table-border">'.$pvao22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$pvao3[1].'</th>
            <th class="table-border">'.$pvao3[2].'</th>
            <th class="table-border">'.$pvao33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$pvao4[1].'</th>
            <th class="table-border">'.$pvao4[2].'</th>
            <th class="table-border">'.$pvao44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= '
            <th class="table-border">'.$pvao5[1].'</th>
            <th class="table-border">'.$pvao5[2].'</th>
            <th class="table-border">'.$pvao55.'</th>';
        }
        $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

        $item1['card'] .='
          
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
        
        </tr> ';

        $totalBeginningBalSSSGSISPACERSPVAO = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePACERS[0] + $newBegBalValuePVAO[0];
        $totalLastTransactionBalSSSGSISPACERSPVAO = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPACERS + $lastTransactionDataPVAO;

        $item1['card'] .='<tr>
            <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
            <th class="table-border">' . $totalBeginningBalSSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalLastTransactionBalSSSGSISPACERSPVAO . '</th>';

        if ($day1_param > 0) {
            $totalDay1SSSGSISPACERSPVAO = $sss1[1] + $gsis1[1] + $pacers1[1] + $pvao1[1];
            $totalDay2SSSGSISPACERSPVAO = $sss1[2] + $gsis1[2] + $pacers1[2] + $pvao1[2];
            $totalDay3SSSGSISPACERSPVAO = $sss11 + $gsis11 + $pacers11 + $pvao11;

            $item1['card'] .='
            <th class="table-border">' . $totalDay1SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPACERSPVAO . '</th>';
        }

        if ($day2_param > 0) {
            $totalDay1SSSGSISPACERSPVAO = $sss2[1] + $gsis2[1] + $pacers1[1] + $pvao1[1];
            $totalDay2SSSGSISPACERSPVAO = $sss2[2] + $gsis2[2] + $pacers1[2] + $pvao1[2];
            $totalDay3SSSGSISPACERSPVAO = $sss22 + $gsis22 + $pacers22 + $pvao22;

            $item1['card'] .='
            <th class="table-border">' . $totalDay1SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPACERSPVAO . '</th>';
        }

        if ($day3_param > 0) {
            $totalDay1SSSGSISPACERSPVAO = $sss3[1] + $gsis3[1] + $pacers1[1] + $pvao1[1];
            $totalDay2SSSGSISPACERSPVAO = $sss3[2] + $gsis3[2] + $pacers1[2] + $pvao1[2];
            $totalDay3SSSGSISPACERSPVAO = $sss33 + $gsis33 + $pacers33 + $pvao33;

            $item1['card'] .='
            <th class="table-border">' . $totalDay1SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPACERSPVAO . '</th>';
        }

        if ($day4_param > 0) {
            $totalDay1SSSGSISPACERSPVAO = $sss4[1] + $gsis4[1] + $pacers1[1] + $pvao1[1];
            $totalDay2SSSGSISPACERSPVAO = $sss4[2] + $gsis4[2] + $pacers1[2] + $pvao1[2];
            $totalDay3SSSGSISPACERSPVAO = $sss44 + $gsis44 + $pacers44 + $pvao44;

            $item1['card'] .='
            <th class="table-border">' . $totalDay1SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPACERSPVAO . '</th>';
        }

        if ($day5_param > 0) {
            $totalDay1SSSGSISPACERSPVAO = $sss5[1] + $gsis5[1] + $pacers1[1] + $pvao1[1];
            $totalDay2SSSGSISPACERSPVAO = $sss5[2] + $gsis5[2] + $pacers1[2] + $pvao1[2];
            $totalDay3SSSGSISPACERSPVAO = $sss55 + $gsis55 + $pacers55 + $pvao55;

            $item1['card'] .='
            <th class="table-border">' . $totalDay1SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPACERSPVAO . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPACERSPVAO . '</th>';
        }

        $netTotalInGSIS_SSS_PACERS_PVAO = $totalInGSIS + $totalInSSS + $totalInPACERS + $totalInPVAO;
        $netTotalOutGSIS_SSS_PACERS_PVAO = $totalOutGSIS + $totalOutSSS + $totalOutPACERS + $totalOutPVAO;
        $netTotalGSIS_SSS_PACERS_PVAO = $netTotalInGSIS_SSS_PACERS_PVAO - $netTotalOutGSIS_SSS_PACERS_PVAO;
        $netSSSGSISPACERSPVAO55 = $sss55 + $gsis55 + $pacers55 + $pvao55;

        $item1['card'] .='
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalInGSIS_SSS_PACERS_PVAO . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalOutGSIS_SSS_PACERS_PVAO . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalGSIS_SSS_PACERS_PVAO . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netSSSGSISPACERSPVAO55 . '</th>
        </tr>

        <tr><td colspan="25" class="invisible">ddfd</td></tr>';

       
        echo json_encode($item1);

    }

    
	public function showPensionerFilterRLCBURGOS(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];

        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;


        $SSS  = 'SSS';
        $GSIS = 'GSIS';
        // $PACERS = 'PACERS';
        $PVAO  = 'PVAO';
        $PNP  = 'PNP';
        $OLR  = 'OLR';
        $OLR_R_E  = 'OLR-REAL ESTATE';
        $OLR_H_L  = 'OLR-HOUSING LOAN';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        // $pacers1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PACERS);
        // $pacers2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PACERS);
        // $pacers3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PACERS);
        // $pacers4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PACERS);
        // $pacers5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PACERS);

        $pvao1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PVAO);
        $pvao2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PVAO);
        $pvao3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PVAO);
        $pvao4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PVAO);
        $pvao5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PVAO);

        $pnp1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PNP);
        $pnp2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PNP);
        $pnp3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PNP);
        $pnp4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PNP);
        $pnp5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PNP);

        $olr1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR);
        $olr2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR);
        $olr3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR);
        $olr4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR);
        $olr5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR);

        $olr_r_e1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_R_E);
        $olr_r_e2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_R_E);
        $olr_r_e3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_R_E);
        $olr_r_e4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_R_E);
        $olr_r_e5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_R_E);

        $olr_h_l1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_H_L);
        $olr_h_l2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_H_L);
        $olr_h_l3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_H_L);
        $olr_h_l4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_H_L);
        $olr_h_l5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_H_L);

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        $firstDayOfYear = $lastYearDate . '-01-01';
            $lastDayOfYear = $lastYearDate . '-12-31';
    
            $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
            
            $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

            $newBegBalValuePVAO = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PVAO);

            $newBegBalValueOLR = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR);

            $newBegBalValueOLR_R_E = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_R_E);

            $newBegBalValueOLR_H_L = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_H_L);

            $newBegBalValuePNP = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PNP);

            // get last transaction

            $firstDayOfTrans = '1990-01-01';
            $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));
              
            $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataPVAO = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PVAO, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataPNP = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PNP, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataOLR = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataOLR_R_E = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_R_E, $firstDayOfTrans, $lastDayOfTrans);
            $lastTransactionDataOLR_H_L = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_H_L, $firstDayOfTrans, $lastDayOfTrans);
      
           // get curent balance
                if ($sss1[0] === 0) {
                   
                    $penDateDataNewSSS = $lastTransactionDataSSS;
                           
                } else {
                    $penDateDataNewSSS = $sss1[0];
                }
                
                $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
                $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
                $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
                $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
                $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;

                if ($gsis1[0] === 0) {          
                   
                    $penDateDataNewGSIS = $lastTransactionDataGSIS;
                  
                } else {
                    $penDateDataNewGSIS = $gsis1[0];
                }

                $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
                $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
                $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
                $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
                $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;

                if ($pvao1[0] === 0) {          
                  
                    $penDateDataNewPVAO = $lastTransactionDataPVAO;
             
                } else {
                    $penDateDataNewPVAO = $pvao1[0];
                }

                $pvao11 = ($pvao1[0] != 0) ? $pvao1[0] : $penDateDataNewPVAO;
                $pvao22 = ($pvao2[0] != 0) ? $pvao2[0] : $pvao11;
                $pvao33 = ($pvao3[0] != 0) ? $pvao3[0] : $pvao22;
                $pvao44 = ($pvao4[0] != 0) ? $pvao4[0] : $pvao33;
                $pvao55 = ($pvao5[0] != 0) ? $pvao5[0] : $pvao44;

                if ($olr1[0] === 0) {          
                   
                    $penDateDataNewOLR = $lastTransactionDataOLR;
                            
                } else {
                    $penDateDataNewOLR = $olr1[0];
                }

                $olr11 = ($olr1[0] != 0) ? $olr1[0] : $penDateDataNewOLR;
                $olr22 = ($olr2[0] != 0) ? $olr2[0] : $olr11;
                $olr33 = ($olr3[0] != 0) ? $olr3[0] : $olr22;
                $olr44 = ($olr4[0] != 0) ? $olr4[0] : $olr33;
                $olr55 = ($olr5[0] != 0) ? $olr5[0] : $olr44;

                if ($olr_r_e1[0] === 0) {          
                   
                    $penDateDataNewOLR_R_E = $lastTransactionDataOLR_R_E;
                     
                } else {
                    $penDateDataNewOLR_R_E = $olr_r_e1[0];
                }

                $olr_r_e11 = ($olr_r_e1[0] != 0) ? $olr_r_e1[0] : $penDateDataNewOLR_R_E;
                $olr_r_e22 = ($olr_r_e2[0] != 0) ? $olr_r_e2[0] : $olr_r_e11;
                $olr_r_e33 = ($olr_r_e3[0] != 0) ? $olr_r_e3[0] : $olr_r_e22;
                $olr_r_e44 = ($olr_r_e4[0] != 0) ? $olr_r_e4[0] : $olr_r_e33;
                $olr_r_e55 = ($olr_r_e5[0] != 0) ? $olr_r_e5[0] : $olr_r_e44;

                if ($olr_h_l1[0] === 0) {          
                   
                    $penDateDataNewOLR_H_L =  $lastTransactionDataOLR_H_L;
                       
                } else {
                    $penDateDataNewOLR_H_L = $olr_h_l1[0];
                }

                $olr_h_l11 = ($olr_h_l1[0] != 0) ? $olr_h_l1[0] : $penDateDataNewOLR_H_L;
                $olr_h_l22 = ($olr_h_l2[0] != 0) ? $olr_h_l2[0] : $olr_h_l11;
                $olr_h_l33 = ($olr_h_l3[0] != 0) ? $olr_h_l3[0] : $olr_h_l22;
                $olr_h_l44 = ($olr_h_l4[0] != 0) ? $olr_h_l4[0] : $olr_h_l33;
                $olr_h_l55 = ($olr_h_l5[0] != 0) ? $olr_h_l5[0] : $olr_h_l44;


                if ($pnp1[0] === 0) {          
                  
                    $penDateDataNewPNP = $lastTransactionDataPNP;
                    
                } else {
                    $penDateDataNewPNP = $pnp1[0];
                }

                $pnp11 = ($pnp1[0] != 0) ? $pnp1[0] : $penDateDataNewPNP;
                $pnp22 = ($pnp2[0] != 0) ? $pnp2[0] : $pnp11;
                $pnp33 = ($pnp3[0] != 0) ? $pnp3[0] : $pnp22;
                $pnp44 = ($pnp4[0] != 0) ? $pnp4[0] : $pnp33;
                $pnp55 = ($pnp5[0] != 0) ? $pnp5[0] : $pnp44;

            $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
            $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

            $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
            $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

            $totalInPVAO = $pvao1[1]+$pvao2[1]+$pvao3[1]+$pvao4[1]+$pvao5[1];
            $totalOutPVAO = $pvao1[2]+$pvao2[2]+$pvao3[2]+$pvao4[2]+$pvao5[2];

            $totalInPNP = $pnp1[1]+$pnp2[1]+$pnp3[1]+$pnp4[1]+$pnp5[1];
            $totalOutPNP = $pnp1[2]+$pnp2[2]+$pnp3[2]+$pnp4[2]+$pnp5[2];

            $totalInOLR = $olr1[1]+$olr2[1]+$olr3[1]+$olr4[1]+$olr5[1];
            $totalOutOLR = $olr1[2]+$olr2[2]+$olr3[2]+$olr4[2]+$olr5[2];

            $totalInOLR_R_E = $olr_r_e1[1]+$olr_r_e2[1]+$olr_r_e3[1]+$olr_r_e4[1]+$olr_r_e5[1];
            $totalOutOLR_R_E = $olr_r_e1[2]+$olr_r_e2[2]+$olr_r_e3[2]+$olr_r_e4[2]+$olr_r_e5[2];

            $totalInOLR_H_L = $olr_h_l1[1]+$olr_h_l2[1]+$olr_h_l3[1]+$olr_h_l4[1]+$olr_h_l5[1];
            $totalOutOLR_H_L = $olr_h_l1[2]+$olr_h_l2[2]+$olr_h_l3[2]+$olr_h_l4[2]+$olr_h_l5[2];


        $item1['card'] ='
        <tr>
            <th colspan="2" rowspan="8" style="text-align:center;padding:15rem 1rem;">'.$_SESSION['branch_name'].'</th>
            <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
            <th class="table-border">'.$newBegBalValueSSS[0].'</th>
            <th class="table-border">'.$lastTransactionDataSSS.'</th>';

            if ($day1_param > 0) {
                $item1['card'] .= '<th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }

            $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item1['card'] .='

                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                
                </tr>   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }

            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item1['card'] .='
            <th style=" text-align: center;"><span style="paddin <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
                </tr>  

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
            <th class="table-border">'.$lastTransactionDataPVAO.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                <th class="table-border">'.$pvao1[2].'</th>
                <th class="table-border">'.$pvao11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao2[1].'</th>
                <th class="table-border">'.$pvao2[2].'</th>
                <th class="table-border">'.$pvao22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$pvao3[1].'</th>
                <th class="table-border">'.$pvao3[2].'</th>
                <th class="table-border">'.$pvao33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao4[1].'</th>
                <th class="table-border">'.$pvao4[2].'</th>
                <th class="table-border">'.$pvao44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pvao5[1].'</th>
                <th class="table-border">'.$pvao5[2].'</th>
                <th class="table-border">'.$pvao55.'</th>';
            }

            $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;
            $item1['card'] .='
         
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
        
        </tr>  
        <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PNP</th>
            <th class="table-border">'.$newBegBalValuePNP[0].'</th>
            <th class="table-border">'.$lastTransactionDataPNP.'</th>

            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                <th class="table-border">'.$pnp1[2].'</th>
                <th class="table-border">'.$pnp11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                <th class="table-border">'.$pnp2[2].'</th>
                <th class="table-border">'.$pnp22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pnp3[1].'</th>
                <th class="table-border">'.$pnp3[2].'</th>
                <th class="table-border">'.$pnp33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$pnp4[1].'</th>
                <th class="table-border">'.$pnp4[2].'</th>
                <th class="table-border">'.$pnp44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                <th class="table-border">'.$pnp5[2].'</th>
                <th class="table-border">'.$pnp55.'</th>';
            }
            $sub_totalPNP = $totalInPNP - $totalOutPNP;
            $item1['card'] .= '
          
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>
 
        </tr>  
        <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR</th>
            <th class="table-border">'.$newBegBalValueOLR[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR.'</th>
            ';
            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr1[1].'</th>
                <th class="table-border">'.$olr1[2].'</th>
                <th class="table-border">'.$olr11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= ' <th class="table-border">'.$olr2[1].'</th>
                <th class="table-border">'.$olr2[2].'</th>
                <th class="table-border">'.$olr22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$olr3[1].'</th>
                <th class="table-border">'.$olr3[2].'</th>
                <th class="table-border">'.$olr33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr4[1].'</th>
                <th class="table-border">'.$olr4[2].'</th>
                <th class="table-border">'.$olr44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$olr5[1].'</th>
                <th class="table-border">'.$olr5[2].'</th>
                <th class="table-border">'.$olr55.'</th>';
            }

            $sub_totalOLR = $totalInOLR - $totalOutOLR;
            $item1['card'] .='
           
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr55.'</th>

        </tr>  
        <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-REAL ESTATE</th>
            <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                <th class="table-border">'.$olr_r_e1[2].'</th>
                <th class="table-border">'.$olr_r_e11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                <th class="table-border">'.$olr_r_e2[2].'</th>
                <th class="table-border">'.$olr_r_e22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr_r_e3[1].'</th>
                <th class="table-border">'.$olr_r_e3[2].'</th>
                <th class="table-border">'.$olr_r_e33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '       <th class="table-border">'.$olr_r_e4[1].'</th>
                <th class="table-border">'.$olr_r_e4[2].'</th>
                <th class="table-border">'.$olr_r_e44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                <th class="table-border">'.$olr_r_e5[2].'</th>
                <th class="table-border">'.$olr_r_e55.'</th>';
            }

            $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

            $item1['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>

        </tr>  
        <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-HOUSING LOAN</th>
            <th class="table-border">'.$newBegBalValueOLR_H_L[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR_H_L.'</th>
        ';

        if ($day1_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$olr_h_l1[1].'</th>
            <th class="table-border">'.$olr_h_l1[2].'</th>
            <th class="table-border">'.$olr_h_l11.'</th>';
        }
        if ($day2_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$olr_h_l2[1].'</th>
            <th class="table-border">'.$olr_h_l2[2].'</th>
            <th class="table-border">'.$olr_h_l22.'</th>';
        }
        if ($day3_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$olr_h_l3[1].'</th>
            <th class="table-border">'.$olr_h_l3[2].'</th>
            <th class="table-border">'.$olr_h_l33.'</th>';
        }
        if ($day4_param > 0) {
            $item1['card'] .= '   <th class="table-border">'.$olr_h_l4[1].'</th>
            <th class="table-border">'.$olr_h_l4[2].'</th>
            <th class="table-border">'.$olr_h_l44.'</th>';
        }
        if ($day5_param > 0) {
            $item1['card'] .= '  <th class="table-border">'.$olr_h_l5[1].'</th>
            <th class="table-border">'.$olr_h_l5[2].'</th>
            <th class="table-border">'.$olr_h_l55.'</th>';
        }
        $sub_totalOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

        $item1['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_H_L.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_H_L.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_H_L.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_h_l55.'</th>

         </tr> ';
         $totalBeginningBalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
         $totalLastTransactionBalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
         
         $item1['card'] .='<tr>
             <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
             <th class="table-border">' . $totalBeginningBalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalLastTransactionBalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         
         if ($day1_param > 0) {
             $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
             $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
             $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss11 + $gsis11 + $pvao11 + $pnp11 + $olr11 + $olr_r_e11 + $olr_h_l11;
         
             $item1['card'] .='
             <th class="table-border">' . $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         }
         
         if ($day2_param > 0) {
             $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
             $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
             $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss22 + $gsis22 + $pvao22 + $pnp22 + $olr22 + $olr_r_e22 + $olr_h_l22;
         
             $item1['card'] .='
             <th class="table-border">' . $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         }
         
         if ($day3_param > 0) {
             $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
             $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
             $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss33 + $gsis33 + $pvao33 + $pnp33 + $olr33 + $olr_r_e33 + $olr_h_l33;
         
             $item1['card'] .='
             <th class="table-border">' . $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         }
         
         if ($day4_param > 0) {
             $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
             $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss4[2] + $gsis4[2] + $pvao4[1] + $pnp4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
             $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss44 + $gsis44 + $pvao44 + $pnp44 + $olr44 + $olr_r_e44 + $olr_h_l44;
         
             $item1['card'] .='
             <th class="table-border">' . $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         }
         
         if ($day5_param > 0) {
             $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
             $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss5[2] + $gsis5[2] + $pvao5[1] + $pnp5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
             $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $sss55 + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
         
             $item1['card'] .='
             <th class="table-border">' . $totalDay1SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay2SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
             <th class="table-border">' . $totalDay3SSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>';
         }
         
         $totalInSSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
         $totalOutSSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;
         $netTotalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L = $totalInSSSGSISPVAOPNPOLROLR_R_EOLR_H_L - $totalOutSSSGSISPVAOPNPOLROLR_R_EOLR_H_L;
         $sssGSISPVAOPNPOLROLR_R_EOLR_H_L55 = $sss55 + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
         
         $item1['card'] .='
         <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
         <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalInSSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
         <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOutSSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
         <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalSSSGSISPVAOPNPOLROLR_R_EOLR_H_L . '</th>
         <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $sssGSISPVAOPNPOLROLR_R_EOLR_H_L55 . '</th>
         </tr>
         
         <tr><td colspan="25" class="invisible">ddfd</td></tr>';
         
       
    
        echo json_encode($item1);

        
    }

    public function showPensionerFilterRLCKALIBO(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];

        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;
            
            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        $SSS  = 'SSS';
        $GSIS = 'GSIS';
        // $PACERS = 'PACERS';
        $PVAO  = 'PVAO';
        $PNP  = 'PNP';
        $OLR  = 'OLR';
        $OLR_R_E  = 'OLR-REAL ESTATE';
        $OLR_H_L  = 'OLR-HOUSING LOAN';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        // $pacers1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PACERS);
        // $pacers2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PACERS);
        // $pacers3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PACERS);
        // $pacers4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PACERS);
        // $pacers5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PACERS);

        $pvao1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PVAO);
        $pvao2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PVAO);
        $pvao3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PVAO);
        $pvao4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PVAO);
        $pvao5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PVAO);

        $pnp1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PNP);
        $pnp2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PNP);
        $pnp3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PNP);
        $pnp4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PNP);
        $pnp5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PNP);

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        $firstDayOfYear = $lastYearDate . '-01-01';
        $lastDayOfYear = $lastYearDate . '-12-31';

        $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
        
        $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

        $newBegBalValuePVAO = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PVAO);

        $newBegBalValuePNP = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PNP);


        // get last transaction

        $firstDayOfTrans = '1990-01-01';
        $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));
          
        $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataPVAO = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PVAO, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataPNP = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PNP, $firstDayOfTrans, $lastDayOfTrans);
        
       // get curent balance
            if ($sss1[0] === 0) {
               
                $penDateDataNewSSS = $lastTransactionDataSSS;
                       
            } else {
                $penDateDataNewSSS = $sss1[0];
            }
            
            $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
            $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
            $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
            $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
            $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;

            if ($gsis1[0] === 0) {          
               
                $penDateDataNewGSIS = $lastTransactionDataGSIS;
              
            } else {
                $penDateDataNewGSIS = $gsis1[0];
            }

            $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
            $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
            $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
            $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
            $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;

            if ($pvao1[0] === 0) {          
              
                $penDateDataNewPVAO = $lastTransactionDataPVAO;
         
            } else {
                $penDateDataNewPVAO = $pvao1[0];
            }

            $pvao11 = ($pvao1[0] != 0) ? $pvao1[0] : $penDateDataNewPVAO;
            $pvao22 = ($pvao2[0] != 0) ? $pvao2[0] : $pvao11;
            $pvao33 = ($pvao3[0] != 0) ? $pvao3[0] : $pvao22;
            $pvao44 = ($pvao4[0] != 0) ? $pvao4[0] : $pvao33;
            $pvao55 = ($pvao5[0] != 0) ? $pvao5[0] : $pvao44;

            if ($pnp1[0] === 0) {          
              
                $penDateDataNewPNP = $lastTransactionDataPNP;
                
            } else {
                $penDateDataNewPNP = $pnp1[0];
            }

            $pnp11 = ($pnp1[0] != 0) ? $pnp1[0] : $penDateDataNewPNP;
            $pnp22 = ($pnp2[0] != 0) ? $pnp2[0] : $pnp11;
            $pnp33 = ($pnp3[0] != 0) ? $pnp3[0] : $pnp22;
            $pnp44 = ($pnp4[0] != 0) ? $pnp4[0] : $pnp33;
            $pnp55 = ($pnp5[0] != 0) ? $pnp5[0] : $pnp44;

        $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
        $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

        $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
        $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

        $totalInPVAO = $pvao1[1]+$pvao2[1]+$pvao3[1]+$pvao4[1]+$pvao5[1];
        $totalOutPVAO = $pvao1[2]+$pvao2[2]+$pvao3[2]+$pvao4[2]+$pvao5[2];

        $totalInPNP = $pnp1[1]+$pnp2[1]+$pnp3[1]+$pnp4[1]+$pnp5[1];
        $totalOutPNP = $pnp1[2]+$pnp2[2]+$pnp3[2]+$pnp4[2]+$pnp5[2];

        $item1['card'] ='
        <tr>
            <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem;">'.$_SESSION['branch_name'].'</th>
            <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
            <th class="table-border">'.$newBegBalValueSSS[0].'</th>
            <th class="table-border">'.$lastTransactionDataSSS.'</th>';

            if ($day1_param > 0) {
                $item1['card'] .= '<th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }
            $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item1['card'] .='

                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                
                </tr>   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }

            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item1['card'] .='
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
                </tr>  

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
            <th class="table-border">'.$lastTransactionDataPVAO.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                <th class="table-border">'.$pvao1[2].'</th>
                <th class="table-border">'.$pvao11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao2[1].'</th>
                <th class="table-border">'.$pvao2[2].'</th>
                <th class="table-border">'.$pvao22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$pvao3[1].'</th>
                <th class="table-border">'.$pvao3[2].'</th>
                <th class="table-border">'.$pvao33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao4[1].'</th>
                <th class="table-border">'.$pvao4[2].'</th>
                <th class="table-border">'.$pvao44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pvao5[1].'</th>
                <th class="table-border">'.$pvao5[2].'</th>
                <th class="table-border">'.$pvao55.'</th>';
            }

            $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;
            $item1['card'] .='

             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
        
        </tr>  
        <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PNP</th>
            <th class="table-border">'.$newBegBalValuePNP[0].'</th>
            <th class="table-border">'.$lastTransactionDataPNP.'</th>

            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                <th class="table-border">'.$pnp1[2].'</th>
                <th class="table-border">'.$pnp11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                <th class="table-border">'.$pnp2[2].'</th>
                <th class="table-border">'.$pnp22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pnp3[1].'</th>
                <th class="table-border">'.$pnp3[2].'</th>
                <th class="table-border">'.$pnp33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$pnp4[1].'</th>
                <th class="table-border">'.$pnp4[2].'</th>
                <th class="table-border">'.$pnp44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                <th class="table-border">'.$pnp5[2].'</th>
                <th class="table-border">'.$pnp55.'</th>';
            }

            $sub_totalPNP = $totalInPNP - $totalOutPNP;

            $item1['card'] .= '
          
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>
 
        </tr> ';

        $totalBeginningBalSSSGSISPVAOPNP = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0];
        $totalLastTransactionBalSSSGSISPVAOPNP = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP;
        
        $item1['card'] .= '<tr>
            <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
            <th class="table-border">' . $totalBeginningBalSSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalLastTransactionBalSSSGSISPVAOPNP . '</th>';
        
        if ($day1_param > 0) {
            $totalDay1SSSGSISPVAOPNP = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1];
            $totalDay2SSSGSISPVAOPNP = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2];
            $totalDay3SSSGSISPVAOPNP = $sss11 + $gsis11 + $pvao11 + $pnp11;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOPNP . '</th>';
        }
        
        if ($day2_param > 0) {
            $totalDay1SSSGSISPVAOPNP = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1];
            $totalDay2SSSGSISPVAOPNP = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2];
            $totalDay3SSSGSISPVAOPNP = $sss22 + $gsis22 + $pvao22 + $pnp22;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOPNP . '</th>';
        }
        
        if ($day3_param > 0) {
            $totalDay1SSSGSISPVAOPNP = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1];
            $totalDay2SSSGSISPVAOPNP = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2];
            $totalDay3SSSGSISPVAOPNP = $sss33 + $gsis33 + $pvao33 + $pnp33;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOPNP . '</th>';
        }
        
        if ($day4_param > 0) {
            $totalDay1SSSGSISPVAOPNP = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1];
            $totalDay2SSSGSISPVAOPNP = $sss4[2] + $gsis4[2] + $pvao4[1] + $pnp4[1];
            $totalDay3SSSGSISPVAOPNP = $sss44 + $gsis44 + $pvao44 + $pnp44;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOPNP . '</th>';
        }
        
        if ($day5_param > 0) {
            $totalDay1SSSGSISPVAOPNP = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1];
            $totalDay2SSSGSISPVAOPNP = $sss5[2] + $gsis5[2] + $pvao5[1] + $pnp5[1];
            $totalDay3SSSGSISPVAOPNP = $sss55 + $gsis55 + $pvao55 + $pnp55;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOPNP . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOPNP . '</th>';
        }
        
        $totalInSSSGSISPVAOPNP = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP;
        $totalOutSSSGSISPVAOPNP = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP;
        $netTotalSSSGSISPVAOPNP = $totalInSSSGSISPVAOPNP - $totalOutSSSGSISPVAOPNP;
        $sssGSISPVAOPNP55 = $sss55 + $gsis55 + $pvao55 + $pnp55;
        
        $item1['card'] .= '
        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalInSSSGSISPVAOPNP . '</th>
        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOutSSSGSISPVAOPNP . '</th>
        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotalSSSGSISPVAOPNP . '</th>
        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $sssGSISPVAOPNP55 . '</th>
        </tr>
        
        <tr><td colspan="25" class="invisible">ddfd</td></tr>';
        
        echo json_encode($item1);

        
    }

    public function showPensionerFilterRLCSINGCANG(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];

        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        $SSS  = 'SSS';
        $GSIS = 'GSIS';
        // $PACERS = 'PACERS';
        $PVAO  = 'PVAO';
        $PNP  = 'PNP';
        $OLR  = 'OLR';
        $OLR_R_E  = 'OLR-REAL ESTATE'; 
        $OLR_H_L  = 'OLR-HOUSING LOAN';
        $OLR_C  = 'OLR-CHATTEL';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        $pvao1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PVAO);
        $pvao2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PVAO);
        $pvao3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PVAO);
        $pvao4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PVAO);
        $pvao5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PVAO);

        $olr1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR);
        $olr2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR);
        $olr3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR);
        $olr4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR);
        $olr5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR);

        $olr_r_e1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_R_E);
        $olr_r_e2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_R_E);
        $olr_r_e3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_R_E);
        $olr_r_e4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_R_E);
        $olr_r_e5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_R_E);

        $olr_h_l1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_H_L);
        $olr_h_l2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_H_L);
        $olr_h_l3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_H_L);
        $olr_h_l4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_H_L);
        $olr_h_l5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_H_L);

        $olr_c1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_C);
        $olr_c2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_C);
        $olr_c3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_C);
        $olr_c4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_C);
        $olr_c5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_C);

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        $firstDayOfYear = $lastYearDate . '-01-01';
        $lastDayOfYear = $lastYearDate . '-12-31';

        $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
        
        $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

        $newBegBalValuePVAO = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PVAO);

        $newBegBalValueOLR = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR);

        $newBegBalValueOLR_R_E = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_R_E);

        $newBegBalValueOLR_H_L = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_H_L);

        $newBegBalValueOLR_C = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_C);

        // get last transaction

        $firstDayOfTrans = '1990-01-01';
        $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));
          
        $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataPVAO = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PVAO, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataOLR = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataOLR_R_E = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_R_E, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataOLR_H_L = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_H_L, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataOLR_C = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_C, $firstDayOfTrans, $lastDayOfTrans);
       
               
       // get curent balance
            if ($sss1[0] === 0) {
               
                $penDateDataNewSSS = $lastTransactionDataSSS;
                       
            } else {
                $penDateDataNewSSS = $sss1[0];
            }
            
            $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
            $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
            $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
            $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
            $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;

            if ($gsis1[0] === 0) {          
               
                $penDateDataNewGSIS = $lastTransactionDataGSIS;
              
            } else {
                $penDateDataNewGSIS = $gsis1[0];
            }

            $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
            $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
            $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
            $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
            $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;

            if ($pvao1[0] === 0) {          
              
                $penDateDataNewPVAO = $lastTransactionDataPVAO;
         
            } else {
                $penDateDataNewPVAO = $pvao1[0];
            }

            $pvao11 = ($pvao1[0] != 0) ? $pvao1[0] : $penDateDataNewPVAO;
            $pvao22 = ($pvao2[0] != 0) ? $pvao2[0] : $pvao11;
            $pvao33 = ($pvao3[0] != 0) ? $pvao3[0] : $pvao22;
            $pvao44 = ($pvao4[0] != 0) ? $pvao4[0] : $pvao33;
            $pvao55 = ($pvao5[0] != 0) ? $pvao5[0] : $pvao44;

            if ($olr1[0] === 0) {          
               
                $penDateDataNewOLR = $lastTransactionDataOLR;
                        
            } else {
                $penDateDataNewOLR = $olr1[0];
            }

            $olr11 = ($olr1[0] != 0) ? $olr1[0] : $penDateDataNewOLR;
            $olr22 = ($olr2[0] != 0) ? $olr2[0] : $olr11;
            $olr33 = ($olr3[0] != 0) ? $olr3[0] : $olr22;
            $olr44 = ($olr4[0] != 0) ? $olr4[0] : $olr33;
            $olr55 = ($olr5[0] != 0) ? $olr5[0] : $olr44;

            if ($olr_r_e1[0] === 0) {          
               
                $penDateDataNewOLR_R_E = $lastTransactionDataOLR_R_E;
                 
            } else {
                $penDateDataNewOLR_R_E = $olr_r_e1[0];
            }

            $olr_r_e11 = ($olr_r_e1[0] != 0) ? $olr_r_e1[0] : $penDateDataNewOLR_R_E;
            $olr_r_e22 = ($olr_r_e2[0] != 0) ? $olr_r_e2[0] : $olr_r_e11;
            $olr_r_e33 = ($olr_r_e3[0] != 0) ? $olr_r_e3[0] : $olr_r_e22;
            $olr_r_e44 = ($olr_r_e4[0] != 0) ? $olr_r_e4[0] : $olr_r_e33;
            $olr_r_e55 = ($olr_r_e5[0] != 0) ? $olr_r_e5[0] : $olr_r_e44;

            if ($olr_h_l1[0] === 0) {          
               
                $penDateDataNewOLR_H_L =  $lastTransactionDataOLR_H_L;
                   
            } else {
                $penDateDataNewOLR_H_L = $olr_h_l1[0];
            }

            $olr_h_l11 = ($olr_h_l1[0] != 0) ? $olr_h_l1[0] : $penDateDataNewOLR_H_L;
            $olr_h_l22 = ($olr_h_l2[0] != 0) ? $olr_h_l2[0] : $olr_h_l11;
            $olr_h_l33 = ($olr_h_l3[0] != 0) ? $olr_h_l3[0] : $olr_h_l22;
            $olr_h_l44 = ($olr_h_l4[0] != 0) ? $olr_h_l4[0] : $olr_h_l33;
            $olr_h_l55 = ($olr_h_l5[0] != 0) ? $olr_h_l5[0] : $olr_h_l44;

            if ($olr_c1[0] === 0) {          
              
                $penDateDataNewOLR_C = $lastTransactionDataOLR_C;
                       
            } else {
                $penDateDataNewOLR_C = $olr_c1[0];
            }

            $olr_c11 = ($olr_c1[0] != 0) ? $olr_c1[0] : $penDateDataNewOLR_C;
            $olr_c22 = ($olr_c2[0] != 0) ? $olr_c2[0] : $olr_c11;
            $olr_c33 = ($olr_c3[0] != 0) ? $olr_c3[0] : $olr_c22;
            $olr_c44 = ($olr_c4[0] != 0) ? $olr_c4[0] : $olr_c33;
            $olr_c55 = ($olr_c5[0] != 0) ? $olr_c5[0] : $olr_c44;

            $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
            $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

            $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
            $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

            $totalInPVAO = $pvao1[1]+$pvao2[1]+$pvao3[1]+$pvao4[1]+$pvao5[1];
            $totalOutPVAO = $pvao1[2]+$pvao2[2]+$pvao3[2]+$pvao4[2]+$pvao5[2];

            $totalInOLR = $olr1[1]+$olr2[1]+$olr3[1]+$olr4[1]+$olr5[1];
            $totalOutOLR = $olr1[2]+$olr2[2]+$olr3[2]+$olr4[2]+$olr5[2];

            $totalInOLR_R_E = $olr_r_e1[1]+$olr_r_e2[1]+$olr_r_e3[1]+$olr_r_e4[1]+$olr_r_e5[1];
            $totalOutOLR_R_E = $olr_r_e1[2]+$olr_r_e2[2]+$olr_r_e3[2]+$olr_r_e4[2]+$olr_r_e5[2];

            $totalInOLR_H_L = $olr_h_l1[1]+$olr_h_l2[1]+$olr_h_l3[1]+$olr_h_l4[1]+$olr_h_l5[1];
            $totalOutOLR_H_L = $olr_h_l1[2]+$olr_h_l2[2]+$olr_h_l3[2]+$olr_h_l4[2]+$olr_h_l5[2];

            $totalInOLR_C = $olr_c1[1]+$olr_c2[1]+$olr_c3[1]+$olr_c4[1]+$olr_c5[1];
            $totalOutOLR_C = $olr_c1[2]+$olr_c2[2]+$olr_c3[2]+$olr_c4[2]+$olr_c5[2];

        $item1['card'] ='
        <tr>
            <th colspan="2" rowspan="8" style="text-align:center;padding:10rem 1rem;">'.$_SESSION['branch_name'].'</th>
            <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
            <th class="table-border">'.$newBegBalValueSSS[0].'</th>
            <th class="table-border">'.$lastTransactionDataSSS.'</th>';

            if ($day1_param > 0) {
                $item1['card'] .= '<th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }

            $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item1['card'] .='

                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                
                </tr>   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }

            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item1['card'] .='
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
                </tr>  

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
            <th class="table-border">'.$lastTransactionDataPVAO.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                <th class="table-border">'.$pvao1[2].'</th>
                <th class="table-border">'.$pvao11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao2[1].'</th>
                <th class="table-border">'.$pvao2[2].'</th>
                <th class="table-border">'.$pvao22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$pvao3[1].'</th>
                <th class="table-border">'.$pvao3[2].'</th>
                <th class="table-border">'.$pvao33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$pvao4[1].'</th>
                <th class="table-border">'.$pvao4[2].'</th>
                <th class="table-border">'.$pvao44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pvao5[1].'</th>
                <th class="table-border">'.$pvao5[2].'</th>
                <th class="table-border">'.$pvao55.'</th>';
            }
            $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

            $item1['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
        
        </tr>  
 
        <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR</th>
            <th class="table-border">'.$newBegBalValueOLR[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR.'</th>
            ';
            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr1[1].'</th>
                <th class="table-border">'.$olr1[2].'</th>
                <th class="table-border">'.$olr11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= ' <th class="table-border">'.$olr2[1].'</th>
                <th class="table-border">'.$olr2[2].'</th>
                <th class="table-border">'.$olr22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '     <th class="table-border">'.$olr3[1].'</th>
                <th class="table-border">'.$olr3[2].'</th>
                <th class="table-border">'.$olr33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr4[1].'</th>
                <th class="table-border">'.$olr4[2].'</th>
                <th class="table-border">'.$olr44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$olr5[1].'</th>
                <th class="table-border">'.$olr5[2].'</th>
                <th class="table-border">'.$olr55.'</th>';
            }

            $sub_totalOLR = $totalInOLR - $totalOutOLR;
            $item1['card'] .='
           
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR .'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr55.'</th>

        </tr>  
        <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-REAL ESTATE</th>
            <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                <th class="table-border">'.$olr_r_e1[2].'</th>
                <th class="table-border">'.$olr_r_e11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                <th class="table-border">'.$olr_r_e2[2].'</th>
                <th class="table-border">'.$olr_r_e22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr_r_e3[1].'</th>
                <th class="table-border">'.$olr_r_e3[2].'</th>
                <th class="table-border">'.$olr_r_e33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '       <th class="table-border">'.$olr_r_e4[1].'</th>
                <th class="table-border">'.$olr_r_e4[2].'</th>
                <th class="table-border">'.$olr_r_e44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                <th class="table-border">'.$olr_r_e5[2].'</th>
                <th class="table-border">'.$olr_r_e55.'</th>';
            }

            $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

            $item1['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>

            </tr>  
            <tr>
                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-HOUSING LOAN</th>
                <th class="table-border">'.$newBegBalValueOLR_H_L[0].'</th>
                <th class="table-border">'.$lastTransactionDataOLR_H_L.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_h_l1[1].'</th>
                <th class="table-border">'.$olr_h_l1[2].'</th>
                <th class="table-border">'.$olr_h_l11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_h_l2[1].'</th>
                <th class="table-border">'.$olr_h_l2[2].'</th>
                <th class="table-border">'.$olr_h_l22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr_h_l3[1].'</th>
                <th class="table-border">'.$olr_h_l3[2].'</th>
                <th class="table-border">'.$olr_h_l33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr_h_l4[1].'</th>
                <th class="table-border">'.$olr_h_l4[2].'</th>
                <th class="table-border">'.$olr_h_l44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_h_l5[1].'</th>
                <th class="table-border">'.$olr_h_l5[2].'</th>
                <th class="table-border">'.$olr_h_l55.'</th>';
            }

            $sub_totalOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

            $item1['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_H_L.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_H_L.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_H_L.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_h_l55.'</th>

            </tr> 
            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR_C</th>
            <th class="table-border">'.$newBegBalValueOLR_C[0].'</th>
            <th class="table-border">'.$lastTransactionDataOLR_C.'</th>

            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_c1[1].'</th>
                <th class="table-border">'.$olr_c1[2].'</th>
                <th class="table-border">'.$olr_c11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_c2[1].'</th>
                <th class="table-border">'.$olr_c2[2].'</th>
                <th class="table-border">'.$olr_c22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$olr_c3[1].'</th>
                <th class="table-border">'.$olr_c3[2].'</th>
                <th class="table-border">'.$olr_c33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$olr_c4[1].'</th>
                <th class="table-border">'.$olr_c4[2].'</th>
                <th class="table-border">'.$olr_c44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$olr_c5[1].'</th>
                <th class="table-border">'.$olr_c5[2].'</th>
                <th class="table-border">'.$olr_c55.'</th>';
            }

            $sub_totalOLR_C = $totalInOLR_C - $totalOutOLR_C;

            $item1['card'] .= '
        
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_C.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_C.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_C.'</th>
             <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_c55.'</th>

        </tr>';

        $totalBeginningBalSSSGSISPVAOOLR = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValueOLR_C[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
        $totalLastTransactionBalSSSGSISPVAOOLR = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataOLR_C + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
        
        $item1['card'] .= '<tr>
            <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
            <th class="table-border">' . $totalBeginningBalSSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalLastTransactionBalSSSGSISPVAOOLR . '</th>';
        
        if ($day1_param > 0) {
            $totalDay1SSSGSISPVAOOLR = $sss1[1] + $gsis1[1] + $pvao1[1] + $olr_c1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
            $totalDay2SSSGSISPVAOOLR = $sss1[2] + $gsis1[2] + $pvao1[2] + $olr_c1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
            $totalDay3SSSGSISPVAOOLR = $sss11 + $gsis11 + $pvao11 + $olr_c11 + $olr11 + $olr_r_e11 + $olr_h_l11;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOOLR . '</th>';
        }
        
        if ($day2_param > 0) {
            $totalDay1SSSGSISPVAOOLR = $sss2[1] + $gsis2[1] + $pvao2[1] + $olr_c2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
            $totalDay2SSSGSISPVAOOLR = $sss2[2] + $gsis2[2] + $pvao2[2] + $olr_c2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
            $totalDay3SSSGSISPVAOOLR = $sss22 + $gsis22 + $pvao22 + $olr_c22 + $olr22 + $olr_r_e22 + $olr_h_l22;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOOLR . '</th>';
        }
        
        if ($day3_param > 0) {
            $totalDay1SSSGSISPVAOOLR = $sss3[1] + $gsis3[1] + $pvao3[1] + $olr_c3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
            $totalDay2SSSGSISPVAOOLR = $sss3[2] + $gsis3[2] + $pvao3[2] + $olr_c3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
            $totalDay3SSSGSISPVAOOLR = $sss33 + $gsis33 + $pvao33 + $olr_c33 + $olr33 + $olr_r_e33 + $olr_h_l33;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOOLR . '</th>';
        }
        
        if ($day4_param > 0) {
            $totalDay1SSSGSISPVAOOLR = $sss4[1] + $gsis4[1] + $pvao4[1] + $olr_c4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
            $totalDay2SSSGSISPVAOOLR = $sss4[2] + $gsis4[2] + $pvao4[1] + $olr_c4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
            $totalDay3SSSGSISPVAOOLR = $sss44 + $gsis44 + $pvao44 + $olr_c44 + $olr44 + $olr_r_e44 + $olr_h_l44;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOOLR . '</th>';
        }
        
        if ($day5_param > 0) {
            $totalDay1SSSGSISPVAOOLR = $sss5[1] + $gsis5[1] + $pvao5[1] + $olr_c5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
            $totalDay2SSSGSISPVAOOLR = $sss5[2] + $gsis5[2] + $pvao5[1] + $olr_c5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
            $totalDay3SSSGSISPVAOOLR = $sss55 + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
        
            $item1['card'] .= '
            <th class="table-border">' . $totalDay1SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay2SSSGSISPVAOOLR . '</th>
            <th class="table-border">' . $totalDay3SSSGSISPVAOOLR . '</th>';
        }
        
        $totalInSSSGSISPVAOOLR = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInOLR_C + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
        $totalOutSSSGSISPVAOOLR = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutOLR_C + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;
        $totalBalanceSSSGSISPVAOOLR = $totalInSSSGSISPVAOOLR - $totalOutSSSGSISPVAOOLR;
        $totalSSSGSISPVAOOLR = $sss55 + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
        
        $item1['card'] .= '
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalInSSSGSISPVAOOLR . '</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOutSSSGSISPVAOOLR . '</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalBalanceSSSGSISPVAOOLR . '</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalSSSGSISPVAOOLR . '</th>
        </tr>
        
        <tr><td colspan="25" class="invisible">ddfd</td></tr>';
        
          
        echo json_encode($item1);
  
    }

    public function showPensionerFilterRLCANTIQUE(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branch_name = $_SESSION['branch_name'];

        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;
    
            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        $SSS  = 'SSS';
        $GSIS = 'GSIS';
        $PVAO  = 'PVAO';
        $PNP  = 'PNP';
        $OLR  = 'OLR';
        $OLR_R_E  = 'OLR-REAL ESTATE';
        $OLR_H_L  = 'OLR-HOUSING LOAN';
        $OLR_C  = 'OLR-CHATTEL';

        $sss1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $SSS);
        $sss2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $SSS);
        $sss3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $SSS);
        $sss4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $SSS);
        $sss5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $SSS);

        $gsis1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $GSIS);
        $gsis2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $GSIS);
        $gsis3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $GSIS);
        $gsis4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $GSIS);
        $gsis5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $GSIS);

        $olr_r_e1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $OLR_R_E);
        $olr_r_e2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $OLR_R_E);
        $olr_r_e3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $OLR_R_E);
        $olr_r_e4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $OLR_R_E);
        $olr_r_e5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $OLR_R_E);

        $pnp1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PNP);
        $pnp2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PNP);
        $pnp3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PNP);
        $pnp4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PNP);
        $pnp5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PNP);

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year

        $firstDayOfYear = $lastYearDate . '-01-01';
        $lastDayOfYear = $lastYearDate . '-12-31';

        $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
        
        $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);

        $newBegBalValueOLR_R_E = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_R_E);

        $newBegBalValuePNP = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PNP);


        // get last transaction

        $firstDayOfTrans = '1990-01-01';
        $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));
          
        $lastTransactionDataSSS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $SSS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataGSIS = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $GSIS, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataPNP = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $PNP, $firstDayOfTrans, $lastDayOfTrans);
        $lastTransactionDataOLR_R_E = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name, $OLR_R_E, $firstDayOfTrans, $lastDayOfTrans);

       // get curent balance
            if ($sss1[0] === 0) {
               
                $penDateDataNewSSS = $lastTransactionDataSSS;
                       
            } else {
                $penDateDataNewSSS = $sss1[0];
            }
            
            $sss11 = ($sss1[0] != 0) ? $sss1[0] : $penDateDataNewSSS;
            $sss22 = ($sss2[0] != 0) ? $sss2[0] : $sss11;
            $sss33 = ($sss3[0] != 0) ? $sss3[0] : $sss22;
            $sss44 = ($sss4[0] != 0) ? $sss4[0] : $sss33;
            $sss55 = ($sss5[0] != 0) ? $sss5[0] : $sss44;

            if ($gsis1[0] === 0) {          
               
                $penDateDataNewGSIS = $lastTransactionDataGSIS;
              
            } else {
                $penDateDataNewGSIS = $gsis1[0];
            }

            $gsis11 = ($gsis1[0] != 0) ? $gsis1[0] : $penDateDataNewGSIS;
            $gsis22 = ($gsis2[0] != 0) ? $gsis2[0] : $gsis11;
            $gsis33 = ($gsis3[0] != 0) ? $gsis3[0] : $gsis22;
            $gsis44 = ($gsis4[0] != 0) ? $gsis4[0] : $gsis33;
            $gsis55 = ($gsis5[0] != 0) ? $gsis5[0] : $gsis44;

            if ($olr_r_e1[0] === 0) {          
               
                $penDateDataNewOLR_R_E = $lastTransactionDataOLR_R_E;
                 
            } else {
                $penDateDataNewOLR_R_E = $olr_r_e1[0];
            }

            $olr_r_e11 = ($olr_r_e1[0] != 0) ? $olr_r_e1[0] : $penDateDataNewOLR_R_E;
            $olr_r_e22 = ($olr_r_e2[0] != 0) ? $olr_r_e2[0] : $olr_r_e11;
            $olr_r_e33 = ($olr_r_e3[0] != 0) ? $olr_r_e3[0] : $olr_r_e22;
            $olr_r_e44 = ($olr_r_e4[0] != 0) ? $olr_r_e4[0] : $olr_r_e33;
            $olr_r_e55 = ($olr_r_e5[0] != 0) ? $olr_r_e5[0] : $olr_r_e44;

            if ($pnp1[0] === 0) {          
              
                $penDateDataNewPNP = $lastTransactionDataPNP;
                
            } else {
                $penDateDataNewPNP = $pnp1[0];
            }

            $pnp11 = ($pnp1[0] != 0) ? $pnp1[0] : $penDateDataNewPNP;
            $pnp22 = ($pnp2[0] != 0) ? $pnp2[0] : $pnp11;
            $pnp33 = ($pnp3[0] != 0) ? $pnp3[0] : $pnp22;
            $pnp44 = ($pnp4[0] != 0) ? $pnp4[0] : $pnp33;
            $pnp55 = ($pnp5[0] != 0) ? $pnp5[0] : $pnp44;

        $totalInGSIS = $gsis1[1]+$gsis2[1]+$gsis3[1]+$gsis4[1]+$gsis5[1];
        $totalOutGSIS = $gsis1[2]+$gsis2[2]+$gsis3[2]+$gsis4[2]+$gsis5[2];

        $totalInSSS = $sss1[1]+$sss2[1]+$sss3[1]+$sss4[1]+$sss5[1];
        $totalOutSSS = $sss1[2]+$sss2[2]+$sss3[2]+$sss4[2]+$sss5[2];

        $totalInPNP = $pnp1[1]+$pnp2[1]+$pnp3[1]+$pnp4[1]+$pnp5[1];
        $totalOutPNP = $pnp1[2]+$pnp2[2]+$pnp3[2]+$pnp4[2]+$pnp5[2];

        $totalInOLR_R_E = $olr_r_e1[1]+$olr_r_e2[1]+$olr_r_e3[1]+$olr_r_e4[1]+$olr_r_e5[1];
        $totalOutOLR_R_E = $olr_r_e1[2]+$olr_r_e2[2]+$olr_r_e3[2]+$olr_r_e4[2]+$olr_r_e5[2];

        $item1['card'] ='
        <tr>
            <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem;">'.$_SESSION['branch_name'].'</th>
            <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
            <th class="table-border">'.$newBegBalValueSSS[0].'</th>
            <th class="table-border">'.$lastTransactionDataSSS.'</th>';

            if ($day1_param > 0) {
                $item1['card'] .= '<th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }
            
            $sub_totalSSS = $totalInSSS - $totalOutSSS;
            $item1['card'] .='

                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS .'</th>
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                
                </tr>   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }

            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item1['card'] .='
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
            </tr>
            <tr>
                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-REAL ESTATE</th>
                <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
                <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
                ';

                if ($day1_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                    <th class="table-border">'.$olr_r_e1[2].'</th>
                    <th class="table-border">'.$olr_r_e11.'</th>';
                }
                if ($day2_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                    <th class="table-border">'.$olr_r_e2[2].'</th>
                    <th class="table-border">'.$olr_r_e22.'</th>';
                }
                if ($day3_param > 0) {
                    $item1['card'] .= '   <th class="table-border">'.$olr_r_e3[1].'</th>
                    <th class="table-border">'.$olr_r_e3[2].'</th>
                    <th class="table-border">'.$olr_r_e33.'</th>';
                }
                if ($day4_param > 0) {
                    $item1['card'] .= '   <th class="table-border">'.$olr_r_e4[1].'</th>
                    <th class="table-border">'.$olr_r_e4[2].'</th>
                    <th class="table-border">'.$olr_r_e44.'</th>';
                }
                if ($day5_param > 0) {
                    $item1['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                    <th class="table-border">'.$olr_r_e5[2].'</th>
                    <th class="table-border">'.$olr_r_e55.'</th>';
                }

            $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

            $item1['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>

            </tr>  
            <tr>
            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">OLR-REAL ESTATE</th>
            <th class="table-border">'.$newBegBalValuePNP[0].'</th>
            <th class="table-border">'.$lastTransactionDataPNP.'</th>
            ';

            if ($day1_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                <th class="table-border">'.$pnp1[2].'</th>
                <th class="table-border">'.$pnp11.'</th>';
            }
            if ($day2_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                <th class="table-border">'.$pnp2[2].'</th>
                <th class="table-border">'.$pnp22.'</th>';
            }
            if ($day3_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pnp3[1].'</th>
                <th class="table-border">'.$pnp3[2].'</th>
                <th class="table-border">'.$pnp33.'</th>';
            }
            if ($day4_param > 0) {
                $item1['card'] .= '   <th class="table-border">'.$pnp4[1].'</th>
                <th class="table-border">'.$pnp4[2].'</th>
                <th class="table-border">'.$pnp44.'</th>';
            }
            if ($day5_param > 0) {
                $item1['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                <th class="table-border">'.$pnp5[2].'</th>
                <th class="table-border">'.$pnp55.'</th>';
            }

            $sub_totalPNP = $totalInPNP - $totalOutPNP;
            $item1['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>   </th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>

            </tr> ';

            $totalBeginningBalSSSGSISOLRR_EPNP = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValuePNP[0];
            $totalLastTransactionBalSSSGSISOLRR_EPNP = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataOLR_R_E + $lastTransactionDataPNP;

            $item1['card'] .='<tr>
                <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                <th class="table-border">' . $totalBeginningBalSSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalLastTransactionBalSSSGSISOLRR_EPNP . '</th>';

            if ($day1_param > 0) {
                $totalDay1SSSGSISOLRR_EPNP = $sss1[1] + $gsis1[1] + $olr_r_e1[1] + $pnp1[1];
                $totalDay2SSSGSISOLRR_EPNP = $sss1[2] + $gsis1[2] + $olr_r_e1[2] + $pnp1[2];
                $totalDay3SSSGSISOLRR_EPNP = $sss11 + $gsis11 + $olr_r_e11 + $pnp11;

                $item1['card'] .='
                <th class="table-border">' . $totalDay1SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay2SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay3SSSGSISOLRR_EPNP . '</th>';
            }

            if ($day2_param > 0) {
                $totalDay1SSSGSISOLRR_EPNP = $sss2[1] + $gsis2[1] + $olr_r_e2[1] + $pnp2[1];
                $totalDay2SSSGSISOLRR_EPNP = $sss2[2] + $gsis2[2] + $olr_r_e2[2] + $pnp2[2];
                $totalDay3SSSGSISOLRR_EPNP = $sss22 + $gsis22 + $olr_r_e22 + $pnp22;

                $item1['card'] .='
                <th class="table-border">' . $totalDay1SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay2SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay3SSSGSISOLRR_EPNP . '</th>';
            }

            if ($day3_param > 0) {
                $totalDay1SSSGSISOLRR_EPNP = $sss3[1] + $gsis3[1] + $olr_r_e3[1] + $pnp3[1];
                $totalDay2SSSGSISOLRR_EPNP = $sss3[2] + $gsis3[2] + $olr_r_e3[2] + $pnp3[2];
                $totalDay3SSSGSISOLRR_EPNP = $sss33 + $gsis33 + $olr_r_e33 + $pnp33;

                $item1['card'] .='
                <th class="table-border">' . $totalDay1SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay2SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay3SSSGSISOLRR_EPNP . '</th>';
            }

            if ($day4_param > 0) {
                $totalDay1SSSGSISOLRR_EPNP = $sss4[1] + $gsis4[1] + $olr_r_e4[1] + $pnp4[1];
                $totalDay2SSSGSISOLRR_EPNP = $sss4[2] + $gsis4[2] + $olr_r_e4[1] + $pnp4[1];
                $totalDay3SSSGSISOLRR_EPNP = $sss44 + $gsis44 + $olr_r_e44 + $pnp44;

                $item1['card'] .='
                <th class="table-border">' . $totalDay1SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay2SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay3SSSGSISOLRR_EPNP . '</th>';
            }

            if ($day5_param > 0) {
                $totalDay1SSSGSISOLRR_EPNP = $sss5[1] + $gsis5[1] + $olr_r_e5[1] + $pnp5[1];
                $totalDay2SSSGSISOLRR_EPNP = $sss5[2] + $gsis5[2] + $olr_r_e5[1] + $pnp5[1];
                $totalDay3SSSGSISOLRR_EPNP = $sss55 + $gsis55 + $olr_r_e55 + $pnp55;

                $item1['card'] .='
                <th class="table-border">' . $totalDay1SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay2SSSGSISOLRR_EPNP . '</th>
                <th class="table-border">' . $totalDay3SSSGSISOLRR_EPNP . '</th>';
            }

            $totalInSSSGSISOLRR_EPNP = $totalInGSIS + $totalInSSS + $totalInOLR_R_E + $totalInPNP;
            $totalOutSSSGSISOLRR_EPNP = $totalOutGSIS + $totalOutSSS + $totalOutOLR_R_E + $totalOutPNP;
            $totalBalanceSSSGSISOLRR_EPNP = $totalInSSSGSISOLRR_EPNP - $totalOutSSSGSISOLRR_EPNP;
            $totalSSSGSISOLRR_EPNP = $sss55 + $gsis55 + $olr_r_e55 + $pnp55;

            $item1['card'] .='
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalInSSSGSISOLRR_EPNP . '</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOutSSSGSISOLRR_EPNP . '</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalBalanceSSSGSISOLRR_EPNP . '</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalSSSGSISOLRR_EPNP . '</th>
            </tr>

            <tr><td colspan="25" class="invisible">ddfd</td></tr>';

       
    
        echo json_encode($item1);

        
    }

}

    
   
