<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/pensioner.controller.php";
require_once "../../../models/pensioner.model.php";

class printClientList{

public function getClientsPrinting(){
    $monthlyAgent = new ControllerPensioner();

    $correspondents = $_GET['preparedBy'];
    // Get the selected month from the user (you can retrieve it from your date picker)
    $selectedMonth = isset($_GET['mdate']) ? $_GET['mdate'] : date('Y-m');
    $selectedYear = date('Y', strtotime($_GET['mdate']));

    // Convert the selected month to the date format
    $startDate = $selectedYear. "-01-01";
    $endDate = $selectedYear. "-12-31";

    $value = 0;
    $asOflastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );

    $OVERALLGRANDTOTALOFAGENTS = 0;
    $OVERALLGRANDTOTALOFSALES = 0;
    $OVERALLGRANDTOTALMONTHLYAGENT = 0;
    $OVERALLGRANDTOTALMONTHLYSALES = 0;

    $header = '';

    $month = date('m', strtotime($_GET['mdate']));

    // into words
    $monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    if (isset($monthNames[(int)$month - 1])) {
        $selectedMonthName = $monthNames[(int)$month - 1];
    } else {
        $selectedMonthName = 'Invalid Month';
    }

    $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    
    if ($month >= 1 && $month <= 12) {
        $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
        $value_span = $month * 2 + 2;
        $value = $month;
    }

 
    $x = 0;
    $begbalwidth2 = 0;
    $begbalwidth = 0;
    $EMB_branch_width = 0;
    $monthWidth = 0;
    $total_agents_sales_width = 0;
    $fontSize = 0;

    if($value >= 7){
        $x = 64;
        $begbalwidth2 = 32;
        $begbalwidth = 43;
        $EMB_branch_width = 64;
    }

    if($value == 12){
        $monthWidth = 870;
        $total_agents_sales_width = 51;
        $fontSize = 4;
    }
    if($value == 11){
        $monthWidth = 808;
        $total_agents_sales_width = 52;
        $fontSize = 4.2; 
    }
    if($value == 10){
        $monthWidth = 814;
        $total_agents_sales_width = 52;
        $fontSize = 4.2; 
        $begbalwidth2 = 35.5;
        $begbalwidth = 45;
        $EMB_branch_width = 67;
        $x = 67;
    }

    if($value == 9){
        $monthWidth = 820;
        $total_agents_sales_width = 58.9;
        $fontSize = 4.2; 
        $begbalwidth2 = 39;
        $begbalwidth = 45;
        $EMB_branch_width = 74;
        $x = 74;
    }
    if($value == 8){
        $monthWidth = 840;
        $total_agents_sales_width = 60;
        $fontSize = 4.4; 
        $begbalwidth2 = 45;
        $begbalwidth = 47;
        $EMB_branch_width = 77;
        $x = 77;
    }
    if($value == 7){
        $monthWidth = 830;
        $total_agents_sales_width = 65;
        $fontSize = 4.4; 
        $begbalwidth2 = 50;
        $begbalwidth = 52;
        $EMB_branch_width = 77;
        $x = 77;
    }
    if($value == 6){
        $monthWidth = 824;
        $total_agents_sales_width = 70;
        $fontSize = 4.8; 
        $begbalwidth2 = 57;
        $begbalwidth = 58;
        $EMB_branch_width = 77;
        $x = 77;
    }
    if($value == 5){
        $monthWidth = 760;
        $total_agents_sales_width = 80;
        $fontSize = 4.8; 
        $begbalwidth2 = 60;
        $begbalwidth = 63;
        $EMB_branch_width = 85;
        $x = 85;
    }
    if($value == 4){
        $monthWidth = 742;
        $total_agents_sales_width = 83;
        $fontSize = 4.8; 
        $begbalwidth2 = 72;
        $begbalwidth = 68;
        $EMB_branch_width = 88;
        $x = 88;
    }
    if($value == 3){
        $monthWidth = 672;
        $total_agents_sales_width = 93;
        $fontSize = 4.8; 
        $begbalwidth2 = 81;
        $begbalwidth = 80;
        $EMB_branch_width = 95;
        $x = 95;
    }
    if($value == 2){
        $monthWidth = 582;
        $total_agents_sales_width = 107;
        $fontSize = 4.8; 
        $begbalwidth2 = 92;
        $begbalwidth = 98;
        $EMB_branch_width = 105;
        $x = 105;
    }
    if($value == 1){
        $monthWidth = 454;
        $total_agents_sales_width = 120;
        $fontSize = 4.8; 
        $begbalwidth2 = 107;
        $begbalwidth = 105;
        $EMB_branch_width = 110;
        $x = 110;
    }
    
    
    
    


  require_once('tcpdf_include.php');


  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false); 

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$margin = 5;
// if($value == 11){
//     $margin = 6;
// }
// if($value <= 10 ){
//     $margin = 5;
// }
// if($value <=5){
//     $margin = 4;
// }
$pdf->SetMargins($margin,$margin);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(false, 0); // Remove the bottom margin

//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('Times');
$pdf->AddPage();

$pdf->setJPEGQuality(75);

$imgdata = base64_decode('');

$pdf->Image('@'.$imgdata);


$reportName = "Monthly.pdf";


$header .= '<style>
tr,th{
    font-size:5.6rem;
    border:1px solid black;
}
</style>';

$header .= '
<table>
<tr>
<th style="border:none;font-size:6.8rem;">EMB CAPITAL LENDING CORPORATION</th>
</tr>

<tr>
<th style="border:none;font-size:6.8rem;">MONTHLY AGENTS AND RUNNERS PRODUCTION</th>
</tr>

<tr>
<th style="border:none;font-size:6.8rem;">FOR THE MONTH OF '.strtoupper($selectedMonthName).' '.$selectedYear.'</th>
</tr>
</table>
';

$header .= '<table>';
$header .= '<thead>';
$header .= '<tr>';
$header .= '<th rowspan="4" style="width:'.$EMB_branch_width.'rem;text-align:center;font-size:7rem;"><span style="color:white;">s</span><br>EMB BRANCHES</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL NUMBER OF AGENTS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL CUMULATIVE OF SALES<br><span style="color:white;">s</span></th>';
$header .= '<th colspan="'. $value_span.'" rowspan="2" style="text-align:center; width:'.$monthWidth.'px;font-weight:bold;">MONTHLY NUMBER OF AGENTS AND SALES</th>';
$header .= '</tr>';
$header .= '<tr><th style="border:none;"></th>';


$header .= '
</tr>
';
$header .= '<tr>';

foreach ($monthsToDisplay as $month) {
    $header .= '<th colspan="2" style="text-align:center;font-weight:bold;color:red;width:'.($begbalwidth2 * 2).'rem;">' . strtoupper($month) . '</th>';
}

$header .= '<th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;">TOTAL AGENTS</th> <th rowspan="2" style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">TOTAL CUMULATIVE SALES</th></tr>';

$header .= '<tr><th colspan="2" style="text-align:center;width:'.($begbalwidth * 2).'rem;">AS OF DECEMBER ' . $asOflastYear . '</th>';



for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;width:'.$begbalwidth2.'rem;">AGENTS</th><th style="text-align:center;width:'.$begbalwidth2.'rem;">SALES</th>';
}
$header .= '</tr>';


//$header .= '<tr><th style="text-align:center;">Total Agents</th></tr>';
$header .= '</thead>';

$header .= '<tbody>';

$getEMB = $monthlyAgent->ctrGetAllEMB();

$grandTotalAgentJan = 0; 
$grandTotalSalesJan = 0;

$grandTotalAgentFeb = 0;
$grandTotalSalesFeb = 0;

$grandTotalAgentMar = 0;
$grandTotalSalesMar = 0;

$grandTotalAgentApr = 0;
$grandTotalSalesApr = 0;

$grandTotalAgentMay = 0;
$grandTotalSalesMay = 0;

$grandTotalAgentJun = 0;
$grandTotalSalesJun = 0;

$grandTotalAgentJul = 0;
$grandTotalSalesJul = 0;

$grandTotalAgentAug = 0;
$grandTotalSalesAug = 0;

$grandTotalAgentSep = 0;
$grandTotalSalesSep = 0;

$grandTotalAgentOct = 0;
$grandTotalSalesOct = 0;

$grandTotalAgentNov = 0;
$grandTotalSalesNov = 0;

$grandTotalAgentDec = 0;
$grandTotalSalesDec = 0;

$grandtotalofTotalAgentsMonthlyEMB = 0;
$grandtotalofTotalSalesMonthlyEMB = 0;

$totalAgentBegBalEMB = 0;
$totalSalesBegBalEMB = 0;
$totalSalesMonthly = 0;



foreach ($getEMB as $emb) {
    
    $branch_names1 = $emb['full_name'];
    $branch_names2 = rtrim($branch_names1);
    $branch_names3 = substr($branch_names2, 3);

    $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names2);
    $monthf = date('Y-m', strtotime($_GET['mdate']));

 
    $beg_agents = 0;
    $beg_sales = 0;


 

    for ($i = 0; $i >= -11; $i--) {
        $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
        $startDatemonth = $currentMonth . "-01";
        $endDatemonth = $currentMonth . "-31";

       
        $getdate = $monthlyAgent->ctrGetDates($branch_names2, $startDatemonth, $endDatemonth);

        $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
        $startYear = $lastYear . "-01-01";
        $endYear = $lastYear . "-12-31";
      
        $startYearbeg = $lastYear . "-01-01";
        $endYearsbeg = $lastYear . "-12-31";
        
        $getYear = $monthlyAgent->ctrGetDates($branch_names2, $startYear, $endYear);
        $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names2, $startYearbeg, $endYearsbeg);

        if($selectedYear > '2023'){
            if (!empty($begYear)) {
                foreach ($begYear as $yearbeg) {
                    $beg_agents = $yearbeg['total_beg_agents'];
                    $beg_sales = $yearbeg['total_beg_sales'];   
                } 
            } else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }
            
        }
        else{

            if (!empty($getYear)) {
                foreach ($getYear as $year) {
                    $beg_agents = $year['agent_beg_bal'];
                    $beg_sales = $year['sales_beg_bal'];   
                } 
            } 
            else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }

        
        }

    
     

}




$startDateJan = $selectedYear. "-01-01";
$endDateJan = date("Y-m-t", strtotime($startDateJan));
$getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJan,$endDateJan);

$startDateFeb = $selectedYear. "-02-01";
$endDateFeb = date("Y-m-t", strtotime($startDateFeb));
$getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateFeb,$endDateFeb);

$startDateMar = $selectedYear. "-03-01";
$endDateMar = date("Y-m-t", strtotime($startDateMar));
$getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMar,$endDateMar);

$startDateApr = $selectedYear. "-04-01";
$endDateApr = date("Y-m-t", strtotime($startDateApr));
$getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateApr,$endDateApr);

$startDateMay = $selectedYear. "-05-01";
$endDateMay = date("Y-m-t", strtotime($startDateMay));
$getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMay,$endDateMay);


$startDateJun = $selectedYear. "-06-01";
$endDateJun = date("Y-m-t", strtotime($startDateJun));
$getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJun,$endDateJun);

$startDateJul = $selectedYear. "-07-01";
$endDateJul = date("Y-m-t", strtotime($startDateJul));
$getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJul,$endDateJul);

$startDateAug = $selectedYear. "-08-01";
$endDateAug = date("Y-m-t", strtotime($startDateAug));
$getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateAug,$endDateAug);

$startDateSep = $selectedYear. "-09-01";
$endDateSep = date("Y-m-t", strtotime($startDateSep));
$getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateSep,$endDateSep);

$startDateOct = $selectedYear. "-10-01";
$endDateOct = date("Y-m-t", strtotime($startDateOct));
$getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateOct,$endDateOct);

$startDateNov = $selectedYear. "-11-01";
$endDateNov = date("Y-m-t", strtotime($startDateNov));
$getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateNov,$endDateNov);

$startDateDec = $selectedYear. "-12-01";
$endDateDec = date("Y-m-t", strtotime($startDateDec));
$getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateDec,$endDateDec);


$totalAgentJan = $getjan[0]['total_agents']; 
$totalSalesJan = $getjan[0]['total_sales'];
$grandTotalAgentJan += $totalAgentJan;
$grandTotalSalesJan += $totalSalesJan;  


$totalAgentFeb = $getfeb[0]['total_agents']; 
$totalSalesFeb = $getfeb[0]['total_sales']; 
$grandTotalAgentFeb += $totalAgentFeb;
$grandTotalSalesFeb += $totalSalesFeb; 

$totalAgentMar = $getMar[0]['total_agents']; 
$totalSalesMar = $getMar[0]['total_sales']; 
$grandTotalAgentMar += $totalAgentMar;
$grandTotalSalesMar += $totalSalesMar; 

$totalAgentApr = $getApr[0]['total_agents']; 
$totalSalesApr = $getApr[0]['total_sales']; 
$grandTotalAgentApr += $totalAgentApr;
$grandTotalSalesApr += $totalSalesApr;

$totalAgentMay = $getMay[0]['total_agents']; 
$totalSalesMay = $getMay[0]['total_sales']; 
$grandTotalAgentMay += $totalAgentMay;
$grandTotalSalesMay += $totalSalesMay;

$totalAgentJun = $getJun[0]['total_agents']; 
$totalSalesJun = $getJun[0]['total_sales']; 
$grandTotalAgentJun += $totalAgentJun;
$grandTotalSalesJun += $totalSalesJun;

$totalAgentJul = $getJul[0]['total_agents']; 
$totalSalesJul = $getJul[0]['total_sales'];
$grandTotalAgentJul += $totalAgentJul;
$grandTotalSalesJul += $totalSalesJul; 

$totalAgentAug = $getAug[0]['total_agents']; 
$totalSalesAug = $getAug[0]['total_sales'];
$grandTotalAgentAug += $totalAgentAug;
$grandTotalSalesAug += $totalSalesAug;  

$totalAgentSep = $getsep[0]['total_agents']; 
$totalSalesSep = $getsep[0]['total_sales']; 
$grandTotalAgentSep += $totalAgentSep;
$grandTotalSalesSep += $totalSalesSep; 

$totalAgentOct = $getoct[0]['total_agents']; 
$totalSalesOct = $getoct[0]['total_sales']; 
$grandTotalAgentOct += $totalAgentOct;
$grandTotalSalesOct += $totalSalesOct; 

$totalAgentNov = $getnov[0]['total_agents']; 
$totalSalesNov = $getnov[0]['total_sales']; 
$grandTotalAgentNov += $totalAgentNov;
$grandTotalSalesNov += $totalSalesNov; 

$totalAgentDec = $getdec[0]['total_agents']; 
$totalSalesDec = $getdec[0]['total_sales'];
$grandTotalAgentDec += $totalAgentDec;
$grandTotalSalesDec += $totalSalesDec; 


$eachMonthTotalAgent = [$totalAgentJan , $totalAgentFeb, $totalAgentMar, $totalAgentApr,  $totalAgentMay, $totalAgentJun, $totalAgentJul,  $totalAgentAug, $totalAgentSep, $totalAgentOct, $totalAgentNov, $totalAgentDec];

$eachMonthTotalSales = [$totalSalesJan, $totalSalesFeb, $totalSalesMar,$totalSalesApr,$totalSalesMay, $totalSalesJun, $totalSalesJul, $totalSalesAug,$totalSalesSep, $totalSalesOct, $totalSalesNov, $totalSalesDec];

$OverallTotalAgents = [$grandTotalAgentJan, $grandTotalAgentFeb,$grandTotalAgentMar,$grandTotalAgentApr, $grandTotalAgentMay,$grandTotalAgentJun, $grandTotalAgentJul,$grandTotalAgentAug, $grandTotalAgentSep, $grandTotalAgentOct,$grandTotalAgentNov,$grandTotalAgentDec];
$OverallTotalSales = [$grandTotalSalesJan, $grandTotalSalesFeb, $grandTotalSalesMar,$grandTotalSalesApr,$grandTotalSalesMay, $grandTotalSalesJun, $grandTotalAgentJul,$grandTotalAgentAug,$grandTotalSalesSep,$grandTotalSalesOct,$grandTotalSalesNov,$grandTotalSalesDec];
// display branch name

$header .= '<tr>';
$header .= '<th style="width:'.$x.'rem;">' . $branch_names3 . '</th>';


$totalAgentsMonthlyEMB = 0;
$totalSalesMonthlyEMB = 0;
for ($i = 0; $i < 1; $i++) {
    $header .= '<th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_agents . '</th> <th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_sales . '</th>';

    $totalAgentBegBalEMB += $beg_agents;
    $totalSalesBegBalEMB += $beg_sales;
    
        for($j = 0; $j < $value; $j++){
            $header .= '<th style="width:'.$begbalwidth2.'rem;text-align:center;">' . $eachMonthTotalAgent[$j] . '</th> <th style="width:'.$begbalwidth2.'rem;text-align:center;">'.$eachMonthTotalSales[$j].'</th>';

            $totalAgentsMonthlyEMB +=  $eachMonthTotalAgent[$j];  
            $totalSalesMonthlyEMB += $eachMonthTotalSales[$j];
         
        }
    
        $grandtotalofTotalAgentsMonthlyEMB +=  $totalAgentsMonthlyEMB;
        $grandtotalofTotalSalesMonthlyEMB += $totalSalesMonthlyEMB;
   }


   $header .= '<th style="text-align:center;width:'.$total_agents_sales_width.'rem;">' . $totalAgentsMonthlyEMB . '</th>';
   $header .= '<th style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">' . $totalSalesMonthlyEMB . '</th>';
   $header .= '</tr>';

}





// Display the total row
$header .= '<tr>';
$header .= '<th style="font-weight:bold;">TOTAL</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalAgentBegBalEMB . '</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalSalesBegBalEMB . '</th>';

for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;font-weight:bold;">' . $OverallTotalAgents[$i] . '</th>';
    $header .= '<th style="background-color:#EEBD38;color:black;text-align:center;font-weight:bold;">' . $OverallTotalSales[$i] . '</th>';
}

$header .= '<th style="text-align:center;font-weight:bold;">' . $grandtotalofTotalAgentsMonthlyEMB . '</th>';
$header .= '<th style="text-align:center;color:red;font-weight:bold;">' . $grandtotalofTotalSalesMonthlyEMB . '</th>';
$header .= '</tr>';

$header .= '</tbody>';
$header .= '</table>';





























// FCH NEGROS


$header .= '<table>';
$header .= '<thead>';
$header .= '<tr><th style="color:white;border:none;">s</th></tr>';
$header .= '<tr>';
$header .= '<th rowspan="4" style="width:'.$EMB_branch_width.'rem;text-align:center;font-size:7rem;font-weight:bold;"><span style="color:white;">s</span><br>FCH NEGROS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL NUMBER OF AGENTS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL CUMULATIVE OF SALES<br><span style="color:white;">s</span></th>';
$header .= '<th colspan="'. $value_span.'" rowspan="2" style="text-align:center; width:'.$monthWidth.'px;font-weight:bold;">MONTHLY NUMBER OF AGENTS AND SALES</th>';
$header .= '</tr>';
$header .= '<tr><th style="border:none;"></th>';


$header .= '
</tr>
';
$header .= '<tr>';

foreach ($monthsToDisplay as $month) {
    $header .= '<th colspan="2" style="text-align:center;color:red;font-weight:bold;width:'.($begbalwidth2 * 2).'rem;">' . strtoupper($month) . '</th>';
}

$header .= '<th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;">TOTAL AGENTS</th> <th rowspan="2" style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">TOTAL CUMULATIVE SALES</th></tr>';

$header .= '<tr><th colspan="2" style="text-align:center;width:'.($begbalwidth * 2).'rem;">AS OF DECEMBER ' . $asOflastYear . '</th>';



for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;width:'.$begbalwidth2.'rem;">AGENTS</th><th style="text-align:center;width:'.$begbalwidth2.'rem;">SALES</th>';
}
$header .= '</tr>';


//$header .= '<tr><th style="text-align:center;">Total Agents</th></tr>';
$header .= '</thead>';

$header .= '<tbody>';

$getEMB = $monthlyAgent->ctrGetAllFCHNegros();

$grandTotalAgentJan = 0; 
$grandTotalSalesJan = 0;

$grandTotalAgentFeb = 0;
$grandTotalSalesFeb = 0;

$grandTotalAgentMar = 0;
$grandTotalSalesMar = 0;

$grandTotalAgentApr = 0;
$grandTotalSalesApr = 0;

$grandTotalAgentMay = 0;
$grandTotalSalesMay = 0;

$grandTotalAgentJun = 0;
$grandTotalSalesJun = 0;

$grandTotalAgentJul = 0;
$grandTotalSalesJul = 0;

$grandTotalAgentAug = 0;
$grandTotalSalesAug = 0;

$grandTotalAgentSep = 0;
$grandTotalSalesSep = 0;

$grandTotalAgentOct = 0;
$grandTotalSalesOct = 0;

$grandTotalAgentNov = 0;
$grandTotalSalesNov = 0;

$grandTotalAgentDec = 0;
$grandTotalSalesDec = 0;

$grandtotalofTotalAgentsMonthlyFCHN = 0;
$grandtotalofTotalSalesMonthlyFCHN = 0;

// $totalAgentBegBalEMB = 0;
// $totalSalesBegBalEMB = 0;
$totalSalesMonthly = 0;

$totalAgentBegBalFCHN = 0;
$totalSalesBegBalFCHN = 0;

foreach ($getEMB as $emb) {
    
    $branch_names1 = $emb['full_name'];
    $branch_names2 = rtrim($branch_names1);
    $branch_names3 = substr($branch_names2, 3);

    $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names2);
    $monthf = date('Y-m', strtotime($_GET['mdate']));

 
    $beg_agents = 0;
    $beg_sales = 0;

 

    for ($i = 0; $i >= -11; $i--) {
        $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
        $startDatemonth = $currentMonth . "-01";
        $endDatemonth = $currentMonth . "-31";

       
        $getdate = $monthlyAgent->ctrGetDates($branch_names2, $startDatemonth, $endDatemonth);

        $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
        $startYear = $lastYear . "-01-01";
        $endYear = $lastYear . "-12-31";
      
        
        $startYearbeg = $lastYear . "-01-01";
        $endYearsbeg = $lastYear . "-12-31";
        
        $getYear = $monthlyAgent->ctrGetDates($branch_names2, $startYear, $endYear);
        $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names2, $startYearbeg, $endYearsbeg);

        if($selectedYear > '2023'){
            if (!empty($begYear)) {
                foreach ($begYear as $yearbeg) {
                    $beg_agents = $yearbeg['total_beg_agents'];
                    $beg_sales = $yearbeg['total_beg_sales'];   
                } 
            } else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }
            
        }

       else{

           if (!empty($getYear)) {
                foreach ($getYear as $year) {
                    $beg_agents = $year['agent_beg_bal'];
                    $beg_sales = $year['sales_beg_bal'];   
                } 
            } 
            else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }

        
        }

    
     

}




$startDateJan = $selectedYear. "-01-01";
$endDateJan = date("Y-m-t", strtotime($startDateJan));
$getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJan,$endDateJan);

$startDateFeb = $selectedYear. "-02-01";
$endDateFeb = date("Y-m-t", strtotime($startDateFeb));
$getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateFeb,$endDateFeb);

$startDateMar = $selectedYear. "-03-01";
$endDateMar = date("Y-m-t", strtotime($startDateMar));
$getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMar,$endDateMar);

$startDateApr = $selectedYear. "-04-01";
$endDateApr = date("Y-m-t", strtotime($startDateApr));
$getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateApr,$endDateApr);

$startDateMay = $selectedYear. "-05-01";
$endDateMay = date("Y-m-t", strtotime($startDateMay));
$getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMay,$endDateMay);


$startDateJun = $selectedYear. "-06-01";
$endDateJun = date("Y-m-t", strtotime($startDateJun));
$getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJun,$endDateJun);

$startDateJul = $selectedYear. "-07-01";
$endDateJul = date("Y-m-t", strtotime($startDateJul));
$getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJul,$endDateJul);

$startDateAug = $selectedYear. "-08-01";
$endDateAug = date("Y-m-t", strtotime($startDateAug));
$getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateAug,$endDateAug);

$startDateSep = $selectedYear. "-09-01";
$endDateSep = date("Y-m-t", strtotime($startDateSep));
$getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateSep,$endDateSep);

$startDateOct = $selectedYear. "-10-01";
$endDateOct = date("Y-m-t", strtotime($startDateOct));
$getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateOct,$endDateOct);

$startDateNov = $selectedYear. "-11-01";
$endDateNov = date("Y-m-t", strtotime($startDateNov));
$getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateNov,$endDateNov);

$startDateDec = $selectedYear. "-11-01";
$endDateDec = date("Y-m-t", strtotime($startDateDec));
$getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateDec,$endDateDec);


$totalAgentJan = $getjan[0]['total_agents']; 
$totalSalesJan = $getjan[0]['total_sales'];
$grandTotalAgentJan += $totalAgentJan;
$grandTotalSalesJan += $totalSalesJan;  


$totalAgentFeb = $getfeb[0]['total_agents']; 
$totalSalesFeb = $getfeb[0]['total_sales']; 
$grandTotalAgentFeb += $totalAgentFeb;
$grandTotalSalesFeb += $totalSalesFeb; 

$totalAgentMar = $getMar[0]['total_agents']; 
$totalSalesMar = $getMar[0]['total_sales']; 
$grandTotalAgentMar += $totalAgentMar;
$grandTotalSalesMar += $totalSalesMar; 

$totalAgentApr = $getApr[0]['total_agents']; 
$totalSalesApr = $getApr[0]['total_sales']; 
$grandTotalAgentApr += $totalAgentApr;
$grandTotalSalesApr += $totalSalesApr;

$totalAgentMay = $getMay[0]['total_agents']; 
$totalSalesMay = $getMay[0]['total_sales']; 
$grandTotalAgentMay += $totalAgentMay;
$grandTotalSalesMay += $totalSalesMay;

$totalAgentJun = $getJun[0]['total_agents']; 
$totalSalesJun = $getJun[0]['total_sales']; 
$grandTotalAgentJun += $totalAgentJun;
$grandTotalSalesJun += $totalSalesJun;

$totalAgentJul = $getJul[0]['total_agents']; 
$totalSalesJul = $getJul[0]['total_sales'];
$grandTotalAgentJul += $totalAgentJul;
$grandTotalSalesJul += $totalSalesJul; 

$totalAgentAug = $getAug[0]['total_agents']; 
$totalSalesAug = $getAug[0]['total_sales'];
$grandTotalAgentAug += $totalAgentAug;
$grandTotalSalesAug += $totalSalesAug;  

$totalAgentSep = $getsep[0]['total_agents']; 
$totalSalesSep = $getsep[0]['total_sales']; 
$grandTotalAgentSep += $totalAgentSep;
$grandTotalSalesSep += $totalSalesSep; 

$totalAgentOct = $getoct[0]['total_agents']; 
$totalSalesOct = $getoct[0]['total_sales']; 
$grandTotalAgentOct += $totalAgentOct;
$grandTotalSalesOct += $totalSalesOct; 

$totalAgentNov = $getnov[0]['total_agents']; 
$totalSalesNov = $getnov[0]['total_sales']; 
$grandTotalAgentNov += $totalAgentNov;
$grandTotalSalesNov += $totalSalesNov; 

$totalAgentDec = $getdec[0]['total_agents']; 
$totalSalesDec = $getdec[0]['total_sales'];
$grandTotalAgentDec += $totalAgentDec;
$grandTotalSalesDec += $totalSalesDec; 


$eachMonthTotalAgent = [$totalAgentJan , $totalAgentFeb, $totalAgentMar, $totalAgentApr,  $totalAgentMay, $totalAgentJun, $totalAgentJul,  $totalAgentAug, $totalAgentSep, $totalAgentOct, $totalAgentNov, $totalAgentDec];

$eachMonthTotalSales = [$totalSalesJan, $totalSalesFeb, $totalSalesMar,$totalSalesApr,$totalSalesMay, $totalSalesJun, $totalSalesJul, $totalSalesAug,$totalSalesSep, $totalSalesOct, $totalSalesNov, $totalSalesDec];

$OverallTotalAgents = [$grandTotalAgentJan, $grandTotalAgentFeb,$grandTotalAgentMar,$grandTotalAgentApr, $grandTotalAgentMay,$grandTotalAgentJun, $grandTotalAgentJul,$grandTotalAgentAug, $grandTotalAgentSep, $grandTotalAgentOct,$grandTotalAgentNov,$grandTotalAgentDec];
$OverallTotalSales = [$grandTotalSalesJan, $grandTotalSalesFeb, $grandTotalSalesMar,$grandTotalSalesApr,$grandTotalSalesMay, $grandTotalSalesJun, $grandTotalAgentJul,$grandTotalAgentAug,$grandTotalSalesSep,$grandTotalSalesOct,$grandTotalSalesNov,$grandTotalSalesDec];
// display branch name

$header .= '<tr>';
$header .= '<th style="width:'.$x.'rem;">' . $branch_names3 . '</th>';


$totalAgentsMonthlyFCHN = 0;
$totalSalesMonthlyFCHN = 0;
for ($i = 0; $i < 1; $i++) {
    $header .= '<th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_agents . '</th> <th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_sales . '</th>';

    $totalAgentBegBalFCHN += $beg_agents;
    $totalSalesBegBalFCHN += $beg_sales;
    
        for($j = 0; $j < $value; $j++){
            $header .= '<th style="width:'.$begbalwidth2.'rem;text-align:center;">' . $eachMonthTotalAgent[$j] . '</th> <th style="width:'.$begbalwidth2.'rem;text-align:center;">'.$eachMonthTotalSales[$j].'</th>';

            $totalAgentsMonthlyFCHN +=  $eachMonthTotalAgent[$j];  
            $totalSalesMonthlyFCHN += $eachMonthTotalSales[$j];
         
        }
    
        $grandtotalofTotalAgentsMonthlyFCHN +=  $totalAgentsMonthlyFCHN;
        $grandtotalofTotalSalesMonthlyFCHN += $totalSalesMonthlyFCHN;
   }


   $header .= '<th style="text-align:center;width:'.$total_agents_sales_width.'rem;">' . $totalAgentsMonthlyFCHN . '</th>';
   $header .= '<th style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">' . $totalSalesMonthlyFCHN . '</th>';
   $header .= '</tr>';

}





// Display the total row
$header .= '<tr>';
$header .= '<th style="font-weight:bold;">TOTAL</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalAgentBegBalFCHN . '</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalSalesBegBalFCHN . '</th>';

for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;font-weight:bold;">' . $OverallTotalAgents[$i] . '</th>';
    $header .= '<th style="background-color:#EEBD38;color:black;text-align:center;font-weight:bold;">' . $OverallTotalSales[$i] . '</th>';
}

$header .= '<th style="text-align:center;font-weight:bold;">' . $grandtotalofTotalAgentsMonthlyFCHN . '</th>';
$header .= '<th style="text-align:center;color:red;font-weight:bold;">' . $grandtotalofTotalSalesMonthlyFCHN . '</th>';
$header .= '</tr>';

$header .= '</tbody>';
$header .= '</table>';
























// FCH MANILA

$header .= '<table>';
$header .= '<thead>';
$header .= '<tr><th style="color:white;border:none;">s</th></tr>';
$header .= '<tr>';
$header .= '<th rowspan="4" style="width:'.$EMB_branch_width.'rem;text-align:center;font-size:7rem;font-weight:bold;"><span style="color:white;">s</span><br>FCH MANILA</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL NUMBER OF AGENTS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL CUMULATIVE OF SALES<br><span style="color:white;">s</span></th>';
$header .= '<th colspan="'. $value_span.'" rowspan="2" style="text-align:center; width:'.$monthWidth.'px;font-weight:bold;">MONTHLY NUMBER OF AGENTS AND SALES</th>';
$header .= '</tr>';
$header .= '<tr><th style="border:none;"></th>';


$header .= '
</tr>
';
$header .= '<tr>';

foreach ($monthsToDisplay as $month) {
    $header .= '<th colspan="2" style="text-align:center;font-weight:bold;color:red;width:'.($begbalwidth2 * 2).'rem;">' . strtoupper($month) . '</th>';
}

$header .= '<th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;">TOTAL AGENTS</th> <th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;color:red;">TOTAL CUMULATIVE SALES</th></tr>';

$header .= '<tr><th colspan="2" style="text-align:center;width:'.($begbalwidth * 2).'rem;">AS OF DECEMBER ' . $asOflastYear . '</th>';



for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;width:'.$begbalwidth2.'rem;">AGENTS</th><th style="text-align:center;width:'.$begbalwidth2.'rem;">SALES</th>';
}
$header .= '</tr>';


//$header .= '<tr><th style="text-align:center;">Total Agents</th></tr>';
$header .= '</thead>';

$header .= '<tbody>';

$getEMB = $monthlyAgent->ctrGetAllFCHManila();

$grandTotalAgentJan = 0; 
$grandTotalSalesJan = 0;

$grandTotalAgentFeb = 0;
$grandTotalSalesFeb = 0;

$grandTotalAgentMar = 0;
$grandTotalSalesMar = 0;

$grandTotalAgentApr = 0;
$grandTotalSalesApr = 0;

$grandTotalAgentMay = 0;
$grandTotalSalesMay = 0;

$grandTotalAgentJun = 0;
$grandTotalSalesJun = 0;

$grandTotalAgentJul = 0;
$grandTotalSalesJul = 0;

$grandTotalAgentAug = 0;
$grandTotalSalesAug = 0;

$grandTotalAgentSep = 0;
$grandTotalSalesSep = 0;

$grandTotalAgentOct = 0;
$grandTotalSalesOct = 0;

$grandTotalAgentNov = 0;
$grandTotalSalesNov = 0;

$grandTotalAgentDec = 0;
$grandTotalSalesDec = 0;

$grandtotalofTotalAgentsMonthlyFCHM = 0;
$grandtotalofTotalSalesMonthlyFCHM = 0;

// $totalAgentBegBalEMB = 0;
// $totalSalesBegBalEMB = 0;
$totalSalesMonthly = 0;

$totalAgentBegBalFCHM = 0;
$totalSalesBegBalFCHM = 0;



foreach ($getEMB as $emb) {
    
    $branch_names1 = $emb['full_name'];
    $branch_names2 = rtrim($branch_names1);
    $branch_names3 = substr($branch_names2, 3);

    $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names2);
    $monthf = date('Y-m', strtotime($_GET['mdate']));

 
    $beg_agents = 0;
    $beg_sales = 0;

 

    for ($i = 0; $i >= -11; $i--) {
        $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
        $startDatemonth = $currentMonth . "-01";
        $endDatemonth = $currentMonth . "-31";

       
        $getdate = $monthlyAgent->ctrGetDates($branch_names2, $startDatemonth, $endDatemonth);

        $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
        $startYear = $lastYear . "-01-01";
        $endYear = $lastYear . "-12-31";
      
        
        
        $startYearbeg = $lastYear . "-01-01";
        $endYearsbeg = $lastYear . "-12-31";
        
        $getYear = $monthlyAgent->ctrGetDates($branch_names2, $startYear, $endYear);
        $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names2, $startYearbeg, $endYearsbeg);

        if($selectedYear > '2023'){
            if (!empty($begYear)) {
                foreach ($begYear as $yearbeg) {
                    $beg_agents = $yearbeg['total_beg_agents'];
                    $beg_sales = $yearbeg['total_beg_sales'];   
                } 
            } else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }
            
        }

       else{

           if (!empty($getYear)) {
                foreach ($getYear as $year) {
                    $beg_agents = $year['agent_beg_bal'];
                    $beg_sales = $year['sales_beg_bal'];   
                } 
            } 
            else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }

        
        }

    
     

}




$startDateJan = $selectedYear. "-01-01";
$endDateJan = date("Y-m-t", strtotime($startDateJan));
$getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJan,$endDateJan);

$startDateFeb = $selectedYear. "-02-01";
$endDateFeb = date("Y-m-t", strtotime($startDateFeb));
$getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateFeb,$endDateFeb);

$startDateMar = $selectedYear. "-03-01";
$endDateMar = date("Y-m-t", strtotime($startDateMar));
$getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMar,$endDateMar);

$startDateApr = $selectedYear. "-04-01";
$endDateApr = date("Y-m-t", strtotime($startDateApr));
$getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateApr,$endDateApr);

$startDateMay = $selectedYear. "-05-01";
$endDateMay = date("Y-m-t", strtotime($startDateMay));
$getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMay,$endDateMay);


$startDateJun = $selectedYear. "-06-01";
$endDateJun = date("Y-m-t", strtotime($startDateJun));
$getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJun,$endDateJun);

$startDateJul = $selectedYear. "-07-01";
$endDateJul = date("Y-m-t", strtotime($startDateJul));
$getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJul,$endDateJul);

$startDateAug = $selectedYear. "-08-01";
$endDateAug = date("Y-m-t", strtotime($startDateAug));
$getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateAug,$endDateAug);

$startDateSep = $selectedYear. "-09-01";
$endDateSep = date("Y-m-t", strtotime($startDateSep));
$getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateSep,$endDateSep);

$startDateOct = $selectedYear. "-10-01";
$endDateOct = date("Y-m-t", strtotime($startDateOct));
$getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateOct,$endDateOct);

$startDateNov = $selectedYear. "-11-01";
$endDateNov = date("Y-m-t", strtotime($startDateNov));
$getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateNov,$endDateNov);

$startDateDec = $selectedYear. "-11-01";
$endDateDec = date("Y-m-t", strtotime($startDateDec));
$getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateDec,$endDateDec);


$totalAgentJan = $getjan[0]['total_agents']; 
$totalSalesJan = $getjan[0]['total_sales'];
$grandTotalAgentJan += $totalAgentJan;
$grandTotalSalesJan += $totalSalesJan;  


$totalAgentFeb = $getfeb[0]['total_agents']; 
$totalSalesFeb = $getfeb[0]['total_sales']; 
$grandTotalAgentFeb += $totalAgentFeb;
$grandTotalSalesFeb += $totalSalesFeb; 

$totalAgentMar = $getMar[0]['total_agents']; 
$totalSalesMar = $getMar[0]['total_sales']; 
$grandTotalAgentMar += $totalAgentMar;
$grandTotalSalesMar += $totalSalesMar; 

$totalAgentApr = $getApr[0]['total_agents']; 
$totalSalesApr = $getApr[0]['total_sales']; 
$grandTotalAgentApr += $totalAgentApr;
$grandTotalSalesApr += $totalSalesApr;

$totalAgentMay = $getMay[0]['total_agents']; 
$totalSalesMay = $getMay[0]['total_sales']; 
$grandTotalAgentMay += $totalAgentMay;
$grandTotalSalesMay += $totalSalesMay;

$totalAgentJun = $getJun[0]['total_agents']; 
$totalSalesJun = $getJun[0]['total_sales']; 
$grandTotalAgentJun += $totalAgentJun;
$grandTotalSalesJun += $totalSalesJun;

$totalAgentJul = $getJul[0]['total_agents']; 
$totalSalesJul = $getJul[0]['total_sales'];
$grandTotalAgentJul += $totalAgentJul;
$grandTotalSalesJul += $totalSalesJul; 

$totalAgentAug = $getAug[0]['total_agents']; 
$totalSalesAug = $getAug[0]['total_sales'];
$grandTotalAgentAug += $totalAgentAug;
$grandTotalSalesAug += $totalSalesAug;  

$totalAgentSep = $getsep[0]['total_agents']; 
$totalSalesSep = $getsep[0]['total_sales']; 
$grandTotalAgentSep += $totalAgentSep;
$grandTotalSalesSep += $totalSalesSep; 

$totalAgentOct = $getoct[0]['total_agents']; 
$totalSalesOct = $getoct[0]['total_sales']; 
$grandTotalAgentOct += $totalAgentOct;
$grandTotalSalesOct += $totalSalesOct; 

$totalAgentNov = $getnov[0]['total_agents']; 
$totalSalesNov = $getnov[0]['total_sales']; 
$grandTotalAgentNov += $totalAgentNov;
$grandTotalSalesNov += $totalSalesNov; 

$totalAgentDec = $getdec[0]['total_agents']; 
$totalSalesDec = $getdec[0]['total_sales'];
$grandTotalAgentDec += $totalAgentDec;
$grandTotalSalesDec += $totalSalesDec; 


$eachMonthTotalAgent = [$totalAgentJan , $totalAgentFeb, $totalAgentMar, $totalAgentApr,  $totalAgentMay, $totalAgentJun, $totalAgentJul,  $totalAgentAug, $totalAgentSep, $totalAgentOct, $totalAgentNov, $totalAgentDec];

$eachMonthTotalSales = [$totalSalesJan, $totalSalesFeb, $totalSalesMar,$totalSalesApr,$totalSalesMay, $totalSalesJun, $totalSalesJul, $totalSalesAug,$totalSalesSep, $totalSalesOct, $totalSalesNov, $totalSalesDec];

$OverallTotalAgents = [$grandTotalAgentJan, $grandTotalAgentFeb,$grandTotalAgentMar,$grandTotalAgentApr, $grandTotalAgentMay,$grandTotalAgentJun, $grandTotalAgentJul,$grandTotalAgentAug, $grandTotalAgentSep, $grandTotalAgentOct,$grandTotalAgentNov,$grandTotalAgentDec];
$OverallTotalSales = [$grandTotalSalesJan, $grandTotalSalesFeb, $grandTotalSalesMar,$grandTotalSalesApr,$grandTotalSalesMay, $grandTotalSalesJun, $grandTotalAgentJul,$grandTotalAgentAug,$grandTotalSalesSep,$grandTotalSalesOct,$grandTotalSalesNov,$grandTotalSalesDec];
// display branch name

$header .= '<tr>';
$header .= '<th style="width:'.$x.'rem;">' . $branch_names3 . '</th>';


$totalAgentsMonthlyFCHM = 0;
$totalSalesMonthlyFCHM = 0;
for ($i = 0; $i < 1; $i++) {
    $header .= '<th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_agents . '</th> <th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_sales . '</th>';

    $totalAgentBegBalFCHM += $beg_agents;
    $totalSalesBegBalFCHM += $beg_sales;
    
        for($j = 0; $j < $value; $j++){
            $header .= '<th style="width:'.$begbalwidth2.'rem;text-align:center;">' . $eachMonthTotalAgent[$j] . '</th> <th style="width:'.$begbalwidth2.'rem;text-align:center;">'.$eachMonthTotalSales[$j].'</th>';

            $totalAgentsMonthlyFCHM +=  $eachMonthTotalAgent[$j];  
            $totalSalesMonthlyFCHM += $eachMonthTotalSales[$j];
         
        }
    
        $grandtotalofTotalAgentsMonthlyFCHM +=  $totalAgentsMonthlyFCHM;
        $grandtotalofTotalSalesMonthlyFCHM += $totalSalesMonthlyFCHM;
   }


   $header .= '<th style="text-align:center;width:'.$total_agents_sales_width.'rem;">' . $totalAgentsMonthlyFCHM . '</th>';
   $header .= '<th style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">' . $totalSalesMonthlyFCHM . '</th>';
   $header .= '</tr>';

}





// Display the total row
$header .= '<tr>';
$header .= '<th style="font-weight:bold;">TOTAL</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalAgentBegBalFCHM . '</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalSalesBegBalFCHM . '</th>';

for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;font-weight:bold;">' . $OverallTotalAgents[$i] . '</th>';
    $header .= '<th style="background-color:#EEBD38;color:black;text-align:center;font-weight:bold;">' . $OverallTotalSales[$i] . '</th>';
}

$header .= '<th style="text-align:center;font-weight:bold;">' . $grandtotalofTotalAgentsMonthlyFCHM . '</th>';
$header .= '<th style="text-align:center;color:red;font-weight:bold;">' . $grandtotalofTotalSalesMonthlyFCHM . '</th>';
$header .= '</tr>';

$header .= '</tbody>';
$header .= '</table>';






















// RLC BRANCH


$header .= '<table>';
$header .= '<thead>';
$header .= '<tr><th style="color:white;border:none;">s</th></tr>';
$header .= '<tr>';
$header .= '<th rowspan="4" style="width:'.$EMB_branch_width.'rem;text-align:center;font-size:7rem;font-weight:bold;"><span style="color:white;">s</span><br>RLC BRANCHES</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL NUMBER OF AGENTS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL CUMULATIVE OF SALES<br><span style="color:white;">s</span></th>';
$header .= '<th colspan="'. $value_span.'" rowspan="2" style="text-align:center; width:'.$monthWidth.'px;font-weight:bold;">MONTHLY NUMBER OF AGENTS AND SALES</th>';
$header .= '</tr>';
$header .= '<tr><th style="border:none;"></th>';


$header .= '
</tr>
';
$header .= '<tr>';

foreach ($monthsToDisplay as $month) {
    $header .= '<th colspan="2" style="text-align:center;color:red;font-weight:bold;width:'.($begbalwidth2 * 2).'rem;">' . strtoupper($month) . '</th>';
}

$header .= '<th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;">TOTAL AGENTS</th> <th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;color:red;">TOTAL CUMULATIVE SALES</th></tr>';

$header .= '<tr><th colspan="2" style="text-align:center;width:'.($begbalwidth * 2).'rem;">AS OF DECEMBER ' . $asOflastYear . '</th>';



for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;width:'.$begbalwidth2.'rem;">AGENTS</th><th style="text-align:center;width:'.$begbalwidth2.'rem;">SALES</th>';
}
$header .= '</tr>';


//$header .= '<tr><th style="text-align:center;">Total Agents</th></tr>';
$header .= '</thead>';

$header .= '<tbody>';

$getEMB = $monthlyAgent->ctrGetAllRLC();

$grandTotalAgentJan = 0; 
$grandTotalSalesJan = 0;

$grandTotalAgentFeb = 0;
$grandTotalSalesFeb = 0;

$grandTotalAgentMar = 0;
$grandTotalSalesMar = 0;

$grandTotalAgentApr = 0;
$grandTotalSalesApr = 0;

$grandTotalAgentMay = 0;
$grandTotalSalesMay = 0;

$grandTotalAgentJun = 0;
$grandTotalSalesJun = 0;

$grandTotalAgentJul = 0;
$grandTotalSalesJul = 0;

$grandTotalAgentAug = 0;
$grandTotalSalesAug = 0;

$grandTotalAgentSep = 0;
$grandTotalSalesSep = 0;

$grandTotalAgentOct = 0;
$grandTotalSalesOct = 0;

$grandTotalAgentNov = 0;
$grandTotalSalesNov = 0;

$grandTotalAgentDec = 0;
$grandTotalSalesDec = 0;

$grandtotalofTotalAgentsMonthlyRLC = 0;
$grandtotalofTotalSalesMonthlyRLC = 0;

// $totalAgentBegBalEMB = 0;
// $totalSalesBegBalEMB = 0;
$totalSalesMonthly = 0;

$totalAgentBegBalRLC = 0;
$totalSalesBegBalRLC = 0;


foreach ($getEMB as $emb) {
    
    $branch_names1 = $emb['full_name'];
    $branch_names2 = rtrim($branch_names1);
    $branch_names3 = substr($branch_names2, 3);

    $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names2);
    $monthf = date('Y-m', strtotime($_GET['mdate']));

 
    $beg_agents = 0;
    $beg_sales = 0;

 

    for ($i = 0; $i >= -11; $i--) {
        $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
        $startDatemonth = $currentMonth . "-01";
        $endDatemonth = $currentMonth . "-31";

       
        $getdate = $monthlyAgent->ctrGetDates($branch_names2, $startDatemonth, $endDatemonth);

        $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
        $startYear = $lastYear . "-01-01";
        $endYear = $lastYear . "-12-31";
      
        
        
        $startYearbeg = $lastYear . "-01-01";
                $endYearsbeg = $lastYear . "-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names2, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names2, $startYearbeg, $endYearsbeg);

                if($selectedYear > '2023'){
                    if (!empty($begYear)) {
                        foreach ($begYear as $yearbeg) {
                            $beg_agents = $yearbeg['total_beg_agents'];
                            $beg_sales = $yearbeg['total_beg_sales'];   
                        } 
                    } else{
                        $beg_agents = 0;
                        $beg_sales = 0; 
                    }
                    
                }

               else{

                   if (!empty($getYear)) {
                        foreach ($getYear as $year) {
                            $beg_agents = $year['agent_beg_bal'];
                            $beg_sales = $year['sales_beg_bal'];   
                        } 
                    } 
                    else{
                        $beg_agents = 0;
                        $beg_sales = 0; 
                    }

                
                }

    
     

}




$startDateJan = $selectedYear. "-01-01";
$endDateJan = date("Y-m-t", strtotime($startDateJan));
$getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJan,$endDateJan);

$startDateFeb = $selectedYear. "-02-01";
$endDateFeb = date("Y-m-t", strtotime($startDateFeb));
$getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateFeb,$endDateFeb);

$startDateMar = $selectedYear. "-03-01";
$endDateMar = date("Y-m-t", strtotime($startDateMar));
$getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMar,$endDateMar);

$startDateApr = $selectedYear. "-04-01";
$endDateApr = date("Y-m-t", strtotime($startDateApr));
$getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateApr,$endDateApr);

$startDateMay = $selectedYear. "-05-01";
$endDateMay = date("Y-m-t", strtotime($startDateMay));
$getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMay,$endDateMay);


$startDateJun = $selectedYear. "-06-01";
$endDateJun = date("Y-m-t", strtotime($startDateJun));
$getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJun,$endDateJun);

$startDateJul = $selectedYear. "-07-01";
$endDateJul = date("Y-m-t", strtotime($startDateJul));
$getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJul,$endDateJul);

$startDateAug = $selectedYear. "-08-01";
$endDateAug = date("Y-m-t", strtotime($startDateAug));
$getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateAug,$endDateAug);

$startDateSep = $selectedYear. "-09-01";
$endDateSep = date("Y-m-t", strtotime($startDateSep));
$getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateSep,$endDateSep);

$startDateOct = $selectedYear. "-10-01";
$endDateOct = date("Y-m-t", strtotime($startDateOct));
$getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateOct,$endDateOct);

$startDateNov = $selectedYear. "-11-01";
$endDateNov = date("Y-m-t", strtotime($startDateNov));
$getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateNov,$endDateNov);

$startDateDec = $selectedYear. "-11-01";
$endDateDec = date("Y-m-t", strtotime($startDateDec));
$getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateDec,$endDateDec);


$totalAgentJan = $getjan[0]['total_agents']; 
$totalSalesJan = $getjan[0]['total_sales'];
$grandTotalAgentJan += $totalAgentJan;
$grandTotalSalesJan += $totalSalesJan;  


$totalAgentFeb = $getfeb[0]['total_agents']; 
$totalSalesFeb = $getfeb[0]['total_sales']; 
$grandTotalAgentFeb += $totalAgentFeb;
$grandTotalSalesFeb += $totalSalesFeb; 

$totalAgentMar = $getMar[0]['total_agents']; 
$totalSalesMar = $getMar[0]['total_sales']; 
$grandTotalAgentMar += $totalAgentMar;
$grandTotalSalesMar += $totalSalesMar; 

$totalAgentApr = $getApr[0]['total_agents']; 
$totalSalesApr = $getApr[0]['total_sales']; 
$grandTotalAgentApr += $totalAgentApr;
$grandTotalSalesApr += $totalSalesApr;

$totalAgentMay = $getMay[0]['total_agents']; 
$totalSalesMay = $getMay[0]['total_sales']; 
$grandTotalAgentMay += $totalAgentMay;
$grandTotalSalesMay += $totalSalesMay;

$totalAgentJun = $getJun[0]['total_agents']; 
$totalSalesJun = $getJun[0]['total_sales']; 
$grandTotalAgentJun += $totalAgentJun;
$grandTotalSalesJun += $totalSalesJun;

$totalAgentJul = $getJul[0]['total_agents']; 
$totalSalesJul = $getJul[0]['total_sales'];
$grandTotalAgentJul += $totalAgentJul;
$grandTotalSalesJul += $totalSalesJul; 

$totalAgentAug = $getAug[0]['total_agents']; 
$totalSalesAug = $getAug[0]['total_sales'];
$grandTotalAgentAug += $totalAgentAug;
$grandTotalSalesAug += $totalSalesAug;  

$totalAgentSep = $getsep[0]['total_agents']; 
$totalSalesSep = $getsep[0]['total_sales']; 
$grandTotalAgentSep += $totalAgentSep;
$grandTotalSalesSep += $totalSalesSep; 

$totalAgentOct = $getoct[0]['total_agents']; 
$totalSalesOct = $getoct[0]['total_sales']; 
$grandTotalAgentOct += $totalAgentOct;
$grandTotalSalesOct += $totalSalesOct; 

$totalAgentNov = $getnov[0]['total_agents']; 
$totalSalesNov = $getnov[0]['total_sales']; 
$grandTotalAgentNov += $totalAgentNov;
$grandTotalSalesNov += $totalSalesNov; 

$totalAgentDec = $getdec[0]['total_agents']; 
$totalSalesDec = $getdec[0]['total_sales'];
$grandTotalAgentDec += $totalAgentDec;
$grandTotalSalesDec += $totalSalesDec; 


$eachMonthTotalAgent = [$totalAgentJan , $totalAgentFeb, $totalAgentMar, $totalAgentApr,  $totalAgentMay, $totalAgentJun, $totalAgentJul,  $totalAgentAug, $totalAgentSep, $totalAgentOct, $totalAgentNov, $totalAgentDec];

$eachMonthTotalSales = [$totalSalesJan, $totalSalesFeb, $totalSalesMar,$totalSalesApr,$totalSalesMay, $totalSalesJun, $totalSalesJul, $totalSalesAug,$totalSalesSep, $totalSalesOct, $totalSalesNov, $totalSalesDec];

$OverallTotalAgents = [$grandTotalAgentJan, $grandTotalAgentFeb,$grandTotalAgentMar,$grandTotalAgentApr, $grandTotalAgentMay,$grandTotalAgentJun, $grandTotalAgentJul,$grandTotalAgentAug, $grandTotalAgentSep, $grandTotalAgentOct,$grandTotalAgentNov,$grandTotalAgentDec];
$OverallTotalSales = [$grandTotalSalesJan, $grandTotalSalesFeb, $grandTotalSalesMar,$grandTotalSalesApr,$grandTotalSalesMay, $grandTotalSalesJun, $grandTotalAgentJul,$grandTotalAgentAug,$grandTotalSalesSep,$grandTotalSalesOct,$grandTotalSalesNov,$grandTotalSalesDec];
// display branch name

$header .= '<tr>';
$header .= '<th style="width:'.$x.'rem;">' . $branch_names3 . '</th>';


$totalAgentsMonthlyRLC = 0;
$totalSalesMonthlyRLC = 0;
for ($i = 0; $i < 1; $i++) {
    $header .= '<th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_agents . '</th> <th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_sales . '</th>';

    $totalAgentBegBalRLC += $beg_agents;
    $totalSalesBegBalRLC += $beg_sales;
    
        for($j = 0; $j < $value; $j++){
            $header .= '<th style="width:'.$begbalwidth2.'rem;text-align:center;">' . $eachMonthTotalAgent[$j] . '</th> <th style="width:'.$begbalwidth2.'rem;text-align:center;">'.$eachMonthTotalSales[$j].'</th>';

            $totalAgentsMonthlyRLC +=  $eachMonthTotalAgent[$j];  
            $totalSalesMonthlyRLC += $eachMonthTotalSales[$j];
         
        }
    
        $grandtotalofTotalAgentsMonthlyRLC +=  $totalAgentsMonthlyRLC;
        $grandtotalofTotalSalesMonthlyRLC += $totalSalesMonthlyRLC;
   }


   $header .= '<th style="text-align:center;width:'.$total_agents_sales_width.'rem;">' . $totalAgentsMonthlyRLC . '</th>';
   $header .= '<th style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">' . $totalSalesMonthlyRLC . '</th>';
   $header .= '</tr>';

}





// Display the total row
$header .= '<tr>';
$header .= '<th style="font-weight:bold;">TOTAL</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalAgentBegBalRLC . '</th>';
$header .= '<th style="text-align:center;font-weight:bold;">' . $totalSalesBegBalRLC . '</th>';

for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;font-weight:bold;">' . $OverallTotalAgents[$i] . '</th>';
    $header .= '<th style="background-color:#EEBD38;color:black;text-align:center;font-weight:bold;">' . $OverallTotalSales[$i] . '</th>';
}

$header .= '<th style="text-align:center;font-weight:bold;">' . $grandtotalofTotalAgentsMonthlyRLC . '</th>';
$header .= '<th style="text-align:center;color:red;font-weight:bold;">' . $grandtotalofTotalSalesMonthlyRLC . '</th>';
$header .= '</tr>';

$header .= '</tbody>';
$header .= '</table>';
























// ELC BRANCH

$header .= '<table>';
$header .= '<thead>';
$header .= '<tr><th style="color:white;border:none;">s</th></tr>';
$header .= '<tr>';
$header .= '<th rowspan="4" style="width:'.$EMB_branch_width.'rem;text-align:center;font-size:7rem;font-weight:bold;"><span style="color:white;">s</span><br>ELC BRANCHES</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL NUMBER OF AGENTS</th>';
$header .= '<th rowspan="3" style="text-align:center;width:'.$begbalwidth.'rem;font-size:'.$fontSize.'rem;font-weight:bold;"><span style="color:white;">s</span><br>TOTAL CUMULATIVE OF SALES<br><span style="color:white;">s</span></th>';
$header .= '<th colspan="'. $value_span.'" rowspan="2" style="text-align:center; width:'.$monthWidth.'px;font-weight:bold;">MONTHLY NUMBER OF AGENTS AND SALES</th>';
$header .= '</tr>';
$header .= '<tr><th style="border:none;"></th>';


$header .= '
</tr>
';
$header .= '<tr>';

foreach ($monthsToDisplay as $month) {
    $header .= '<th colspan="2" style="text-align:center;color:red;font-weight:bold;width:'.($begbalwidth2 * 2).'rem;">' . strtoupper($month) . '</th>';
}

$header .= '<th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;">TOTAL AGENTS</th> <th rowspan="2" style="text-align:center;width:'.$total_agents_sales_width.'rem;color:red;">TOTAL CUMULATIVE SALES</th></tr>';

$header .= '<tr><th colspan="2" style="text-align:center;width:'.($begbalwidth * 2).'rem;">AS OF DECEMBER ' . $asOflastYear . '</th>';



for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="text-align:center;width:'.$begbalwidth2.'rem;">AGENTS</th><th style="text-align:center;width:'.$begbalwidth2.'rem;">SALES</th>';
}
$header .= '</tr>';


//$header .= '<tr><th style="text-align:center;">Total Agents</th></tr>';
$header .= '</thead>';

$header .= '<tbody>';

$getEMB = $monthlyAgent->ctrGetAllELC();

$grandTotalAgentJan = 0; 
$grandTotalSalesJan = 0;

$grandTotalAgentFeb = 0;
$grandTotalSalesFeb = 0;

$grandTotalAgentMar = 0;
$grandTotalSalesMar = 0;

$grandTotalAgentApr = 0;
$grandTotalSalesApr = 0;

$grandTotalAgentMay = 0;
$grandTotalSalesMay = 0;

$grandTotalAgentJun = 0;
$grandTotalSalesJun = 0;

$grandTotalAgentJul = 0;
$grandTotalSalesJul = 0;

$grandTotalAgentAug = 0;
$grandTotalSalesAug = 0;

$grandTotalAgentSep = 0;
$grandTotalSalesSep = 0;

$grandTotalAgentOct = 0;
$grandTotalSalesOct = 0;

$grandTotalAgentNov = 0;
$grandTotalSalesNov = 0;

$grandTotalAgentDec = 0;
$grandTotalSalesDec = 0;

// $grandtotalofTotalAgentsMonthlyEMB = 0;
// $grandtotalofTotalSalesMonthlyEMB = 0;

// $totalAgentBegBalEMB = 0;
// $totalSalesBegBalEMB = 0;
$totalSalesMonthly = 0;

$totalAgentBegBalELC = 0;
$totalSalesBegBalELC = 0;

$grandtotalofTotalAgentsMonthlyELC = 0;
$grandtotalofTotalSalesMonthlyELC = 0;
foreach ($getEMB as $emb) {
    
    $branch_names1 = $emb['full_name'];
    $branch_names2 = rtrim($branch_names1);
    $branch_names3 = substr($branch_names2, 3);

    $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names2);
    $monthf = date('Y-m', strtotime($_GET['mdate']));

 
    $beg_agents = 0;
    $beg_sales = 0;

 

    for ($i = 0; $i >= -11; $i--) {
        $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
        $startDatemonth = $currentMonth . "-01";
        $endDatemonth = $currentMonth . "-31";

       
        $getdate = $monthlyAgent->ctrGetDates($branch_names2, $startDatemonth, $endDatemonth);

        $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
        $startYear = $lastYear . "-01-01";
        $endYear = $lastYear . "-12-31";
      
        
        
        $startYearbeg = $lastYear . "-01-01";
        $endYearsbeg = $lastYear . "-12-31";
        
        $getYear = $monthlyAgent->ctrGetDates($branch_names2, $startYear, $endYear);
        $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names2, $startYearbeg, $endYearsbeg);

        if($selectedYear > '2023'){
            if (!empty($begYear)) {
                foreach ($begYear as $yearbeg) {
                    $beg_agents = $yearbeg['total_beg_agents'];
                    $beg_sales = $yearbeg['total_beg_sales'];   
                } 
            } else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }
            
        }

       else{

           if (!empty($getYear)) {
                foreach ($getYear as $year) {
                    $beg_agents = $year['agent_beg_bal'];
                    $beg_sales = $year['sales_beg_bal'];   
                } 
            } 
            else{
                $beg_agents = 0;
                $beg_sales = 0; 
            }

        
        }

    
     

}




$startDateJan = $selectedYear. "-01-01";
$endDateJan = date("Y-m-t", strtotime($startDateJan));
$getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJan,$endDateJan);

$startDateFeb = $selectedYear. "-02-01";
$endDateFeb = date("Y-m-t", strtotime($startDateFeb));
$getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateFeb,$endDateFeb);

$startDateMar = $selectedYear. "-03-01";
$endDateMar = date("Y-m-t", strtotime($startDateMar));
$getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMar,$endDateMar);

$startDateApr = $selectedYear. "-04-01";
$endDateApr = date("Y-m-t", strtotime($startDateApr));
$getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateApr,$endDateApr);

$startDateMay = $selectedYear. "-05-01";
$endDateMay = date("Y-m-t", strtotime($startDateMay));
$getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateMay,$endDateMay);


$startDateJun = $selectedYear. "-06-01";
$endDateJun = date("Y-m-t", strtotime($startDateJun));
$getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJun,$endDateJun);

$startDateJul = $selectedYear. "-07-01";
$endDateJul = date("Y-m-t", strtotime($startDateJul));
$getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateJul,$endDateJul);

$startDateAug = $selectedYear. "-08-01";
$endDateAug = date("Y-m-t", strtotime($startDateAug));
$getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateAug,$endDateAug);

$startDateSep = $selectedYear. "-09-01";
$endDateSep = date("Y-m-t", strtotime($startDateSep));
$getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateSep,$endDateSep);

$startDateOct = $selectedYear. "-10-01";
$endDateOct = date("Y-m-t", strtotime($startDateOct));
$getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateOct,$endDateOct);

$startDateNov = $selectedYear. "-11-01";
$endDateNov = date("Y-m-t", strtotime($startDateNov));
$getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateNov,$endDateNov);

$startDateDec = $selectedYear. "-11-01";
$endDateDec = date("Y-m-t", strtotime($startDateDec));
$getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names2,$startDateDec,$endDateDec);


$totalAgentJan = $getjan[0]['total_agents']; 
$totalSalesJan = $getjan[0]['total_sales'];
$grandTotalAgentJan += $totalAgentJan;
$grandTotalSalesJan += $totalSalesJan;  


$totalAgentFeb = $getfeb[0]['total_agents']; 
$totalSalesFeb = $getfeb[0]['total_sales']; 
$grandTotalAgentFeb += $totalAgentFeb;
$grandTotalSalesFeb += $totalSalesFeb; 

$totalAgentMar = $getMar[0]['total_agents']; 
$totalSalesMar = $getMar[0]['total_sales']; 
$grandTotalAgentMar += $totalAgentMar;
$grandTotalSalesMar += $totalSalesMar; 

$totalAgentApr = $getApr[0]['total_agents']; 
$totalSalesApr = $getApr[0]['total_sales']; 
$grandTotalAgentApr += $totalAgentApr;
$grandTotalSalesApr += $totalSalesApr;

$totalAgentMay = $getMay[0]['total_agents']; 
$totalSalesMay = $getMay[0]['total_sales']; 
$grandTotalAgentMay += $totalAgentMay;
$grandTotalSalesMay += $totalSalesMay;

$totalAgentJun = $getJun[0]['total_agents']; 
$totalSalesJun = $getJun[0]['total_sales']; 
$grandTotalAgentJun += $totalAgentJun;
$grandTotalSalesJun += $totalSalesJun;

$totalAgentJul = $getJul[0]['total_agents']; 
$totalSalesJul = $getJul[0]['total_sales'];
$grandTotalAgentJul += $totalAgentJul;
$grandTotalSalesJul += $totalSalesJul; 

$totalAgentAug = $getAug[0]['total_agents']; 
$totalSalesAug = $getAug[0]['total_sales'];
$grandTotalAgentAug += $totalAgentAug;
$grandTotalSalesAug += $totalSalesAug;  

$totalAgentSep = $getsep[0]['total_agents']; 
$totalSalesSep = $getsep[0]['total_sales']; 
$grandTotalAgentSep += $totalAgentSep;
$grandTotalSalesSep += $totalSalesSep; 

$totalAgentOct = $getoct[0]['total_agents']; 
$totalSalesOct = $getoct[0]['total_sales']; 
$grandTotalAgentOct += $totalAgentOct;
$grandTotalSalesOct += $totalSalesOct; 

$totalAgentNov = $getnov[0]['total_agents']; 
$totalSalesNov = $getnov[0]['total_sales']; 
$grandTotalAgentNov += $totalAgentNov;
$grandTotalSalesNov += $totalSalesNov; 

$totalAgentDec = $getdec[0]['total_agents']; 
$totalSalesDec = $getdec[0]['total_sales'];
$grandTotalAgentDec += $totalAgentDec;
$grandTotalSalesDec += $totalSalesDec; 


$eachMonthTotalAgent = [$totalAgentJan , $totalAgentFeb, $totalAgentMar, $totalAgentApr,  $totalAgentMay, $totalAgentJun, $totalAgentJul,  $totalAgentAug, $totalAgentSep, $totalAgentOct, $totalAgentNov, $totalAgentDec];

$eachMonthTotalSales = [$totalSalesJan, $totalSalesFeb, $totalSalesMar,$totalSalesApr,$totalSalesMay, $totalSalesJun, $totalSalesJul, $totalSalesAug,$totalSalesSep, $totalSalesOct, $totalSalesNov, $totalSalesDec];

$OverallTotalAgents = [$grandTotalAgentJan, $grandTotalAgentFeb,$grandTotalAgentMar,$grandTotalAgentApr, $grandTotalAgentMay,$grandTotalAgentJun, $grandTotalAgentJul,$grandTotalAgentAug, $grandTotalAgentSep, $grandTotalAgentOct,$grandTotalAgentNov,$grandTotalAgentDec];
$OverallTotalSales = [$grandTotalSalesJan, $grandTotalSalesFeb, $grandTotalSalesMar,$grandTotalSalesApr,$grandTotalSalesMay, $grandTotalSalesJun, $grandTotalAgentJul,$grandTotalAgentAug,$grandTotalSalesSep,$grandTotalSalesOct,$grandTotalSalesNov,$grandTotalSalesDec];
// display branch name

$header .= '<tr>';
$header .= '<th style="width:'.$x.'rem;">' . $branch_names3 . '</th>';



$totalAgentsMonthlyELC = 0;
$totalSalesMonthlyELC = 0;
for ($i = 0; $i < 1; $i++) {
    $header .= '<th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_agents . '</th> <th style="width:'.$begbalwidth.'px;text-align:center;">' . $beg_sales . '</th>';

    $totalAgentBegBalELC += $beg_agents;
    $totalSalesBegBalELC += $beg_sales;
    
        for($j = 0; $j < $value; $j++){
            $header .= '<th style="width:'.$begbalwidth2.'rem;text-align:center;">' . $eachMonthTotalAgent[$j] . '</th> <th style="width:'.$begbalwidth2.'rem;text-align:center;">'.$eachMonthTotalSales[$j].'</th>';

            $totalAgentsMonthlyELC +=  $eachMonthTotalAgent[$j];  
            $totalSalesMonthlyELC += $eachMonthTotalSales[$j];
         
        }
    
        $grandtotalofTotalAgentsMonthlyELC +=  $totalAgentsMonthlyELC;
        $grandtotalofTotalSalesMonthlyELC += $totalSalesMonthlyELC;
   }


   $header .= '<th style="text-align:center;width:'.$total_agents_sales_width.'rem;">' . $totalAgentsMonthlyELC . '</th>';
   $header .= '<th style="text-align:center;color:red;width:'.$total_agents_sales_width.'rem;">' . $totalSalesMonthlyELC . '</th>';
   $header .= '</tr>';

}

$OVERALLGRANDTOTALOFAGENTS = $totalAgentBegBalELC + $totalAgentBegBalRLC + $totalAgentBegBalFCHM + $totalAgentBegBalFCHN + $totalAgentBegBalEMB;
$OVERALLGRANDTOTALOFSALES = $totalSalesBegBalELC + $totalSalesBegBalRLC + $totalSalesBegBalFCHM + $totalSalesBegBalFCHN + $totalSalesBegBalEMB;
$OVERALLGRANDTOTALMONTHLYAGENT = $grandtotalofTotalAgentsMonthlyELC + $grandtotalofTotalAgentsMonthlyRLC + $grandtotalofTotalAgentsMonthlyFCHM + $grandtotalofTotalAgentsMonthlyFCHN + $grandtotalofTotalAgentsMonthlyEMB;
$OVERALLGRANDTOTALMONTHLYSALES = $grandtotalofTotalSalesMonthlyELC + $grandtotalofTotalSalesMonthlyRLC + $grandtotalofTotalSalesMonthlyFCHM + $grandtotalofTotalSalesMonthlyFCHN + $grandtotalofTotalSalesMonthlyEMB;


$header .= '<tr>';
$header .= '<th style="text-align:center;font-weight:bold;border:none;font-size:6.1rem;">GRAND TOTAL</th> <th style="text-align:center;font-weight:bold;border:none;font-size:6.1rem;">'.$OVERALLGRANDTOTALOFAGENTS.'</th> 
<th style="text-align:center;font-weight:bold;border:none;font-size:6.1rem;">'.$OVERALLGRANDTOTALOFSALES.'</th>';

for ($i = 0; $i < $value; $i++) {
    $header .= '<th style="border:none;"></th> <th style="border:none;"></th>';       
}
$header .= '<th style="text-align:center;font-weight:bold;border:none;font-size:6.1rem;">'.$OVERALLGRANDTOTALMONTHLYAGENT.'</th> <th style="font-size:6.1rem;text-align:center;font-weight:bold;border:none;">'.$OVERALLGRANDTOTALMONTHLYSALES.'</th>';
$header .= '</tr>';

$header .= '<tr><th style="border:none;"></th></tr>';
$header .= '<tr><th style="border:none;"></th></tr>';
$header .= '<tr><th style="font-weight:bold;border:none;">PREPARED BY:<br></th></tr>';
$header .= '<tr> <th style="border:none;" colspan="3">'.$correspondents.'</th> </tr>';
$header .= '</tbody>';
$header .= '</table>';




    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>


