<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/operation.controller.php";
require_once "../../../models/operation.model.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    
  require_once('tcpdf_include.php');


//   $pdf = new TCPDF('L', PDF_UN IT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false);  /*remove line on top of the page*/

  // set document information


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(4,4);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('Times');
$pdf->AddPage();

    // set JPEG quality
$pdf->setJPEGQuality(75);
// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('');

       // The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);



//rlwh//
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
// $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



$Operation = new ControllerOperation();


$to = $_GET['to'];
$preBy = strtoupper($_GET['preBy']);

$month = date("n", strtotime($to));
$monthName = strtoupper(date("F Y", strtotime($to)));

function formatNumber($number) {
    if ($number != 0) {
        return number_format(abs($number), 2, '.', ',');
    } else {
        return "-";
    }
}
$reportName = "Loans Receivable Aging for ".$monthName.".pdf";
$date = $_GET['to'];
  
$header = <<<EOF

        <table>
            <tr>
                <th  style="border: none; text-align:left;font-weight:bold; font-size: 8.5rem;">EMB CAPITAL LENDING CORPORATION</th>
            </tr>
            <tr>
                <th  style="border: none; text-align:left;font-weight:bold; font-size: 8.5rem;">LOANS RECEIVABLE AGING</th>
            </tr>
            <tr>
                <th  style="border: none; background-color:yellow; width: 230px; text-align:left;font-weight:bold; font-size: 8.5rem;">FOR THE MONTH OF $monthName</th>
            </tr>
            <tr>
            <th  style="border: none; text-align:left;font-weight:bold;"></th>
        </tr>
        </table>

        <style>
             tr,th{
            border:1px solid black;
            font-size:7.0rem;
            text-align:center;
        }
             tr, td{
            border:1px solid black;
            font-size:7.0rem;
            text-align:center;
        }
        </style>
        <table>
            <thead>
            <tr style="font-weight: bold;">
                <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">EMB BRANCHES</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">FULLY PAID WITH SL</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">4 MONTH & BELOW</th>
                <th colspan="3"  style="width:180px; font-size:7.0rem;">5 TO 6 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">7 TO 8 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">9 TO 10 MONTHS</th>
            </tr>
          
            <tr>
                <th style="width:30px; font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
            </tr>
        </thead>
        <tbody>
        EOF;
    $getEMB = $Operation ->ctrGetAllEMBBranches();
    // SSP TOTAL
    $grand_totalSSP_withSL = 0;
    $grand_total_ssp_4m = 0;
    $grand_total_ssp_5and6 = 0;
    $grand_total_ssp_7and8 = 0;
    $grand_total_ssp_9and10 = 0;
    $grand_total_ssp_11 = 0;
    $grand_total_ssp_12 = 0;
    // CHANGE TOTAL
    $grand_total_chng_withSL = 0;
    $grand_total_chng_4m = 0;
    $grand_total_chng_5and6 = 0;
    $grand_total_chng_7and8 = 0;
    $grand_total_chng_9and10 = 0;
    $grand_total_chng_11 = 0;
    $grand_total_chng_12 = 0;
    // Ntotal TOTAL
    $grand_total_ntotal_withSL1 = 0;
    $grand_total_ntotal_4m1 = 0;
    $grand_total_ntotal_5and61 = 0;
    $grand_total_ntotal_7and81 = 0;
    $grand_total_ntotal_9and101 = 0;
    $grand_total_ntotal_111 = 0;
    $grand_total_ntotal_121 = 0;

    $grand_total_ssp = 0;
    $grand_total_sl = 0;
    $grand_total_lr = 0;


    foreach ($getEMB as $emb) { 
        $branch_name = $emb['full_name'];
        $new_branch_name = str_replace("EMB", "", $branch_name);
        $get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
    foreach($get_SPP_withSL as $SSP_withSL1){
        $SSP_withSL = $SSP_withSL1['total_ssp_sl'];
        $ssp_4m = $SSP_withSL1['total_ssp_4m'];
        $ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
        $ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
        $ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
        $ssp_11 = $SSP_withSL1['total_ssp_11'];
        $ssp_12 = $SSP_withSL1['total_ssp_12'];
    }

    $grand_totalSSP_withSL += $SSP_withSL;
    $grand_total_ssp_4m += $ssp_4m;
    $grand_total_ssp_5and6 += $ssp_5and6;
    $grand_total_ssp_7and8 += $ssp_7and8;
    $grand_total_ssp_9and10 += $ssp_9and10;
    $grand_total_ssp_11 += $ssp_11;
    $grand_total_ssp_12 += $ssp_12;

    $get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
    foreach($get_loans_change as $change){
        $chng_withSL = $change['total_chng_sl'];
        $chng_4m = $change['total_chng_4m'];
        $chng_5and6 = $change['total_chng_5and6'];
        $chng_7and8 = $change['total_chng_7and8'];
        $chng_9and10 = $change['total_chng_9and10'];
        $chng_11 = $change['total_chng_11'];
        $chng_12 = $change['total_chng_12'];
    }

    $chng_withSL_format = formatNumber($chng_withSL);
    $chng_4m_format = formatNumber($chng_4m);
    $chng_5and6_format = formatNumber($chng_5and6);
    $chng_7and8_format = formatNumber($chng_7and8);
    $chng_9and10_format = formatNumber($chng_9and10);
    $chng_11_format = formatNumber($chng_11);
    $chng_12_format = formatNumber($chng_12);
    // Get total Change
    $grand_total_chng_withSL += $chng_withSL;
    $grand_total_chng_4m += $chng_4m;
    $grand_total_chng_5and6 += $chng_5and6;
    $grand_total_chng_7and8 += $chng_7and8;
    $grand_total_chng_9and10 += $chng_9and10;
    $grand_total_chng_11 += $chng_11;
    $grand_total_chng_12 += $chng_12;

    $grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
    $grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
    $grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
    $grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
    $grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
    $grand_total_chng_111 = formatNumber($grand_total_chng_11);
    $grand_total_chng_121 = formatNumber($grand_total_chng_12);

    $get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
    foreach($get_loans_ntotal as $ntotal){
        $ntotal_withSL = $ntotal['total_ntotal_sl'];
        $ntotal_4m = $ntotal['total_ntotal_4m'];
        $ntotal_5and6 = $ntotal['total_ntotal_5and6'];
        $ntotal_7and8 = $ntotal['total_ntotal_7and8'];
        $ntotal_9and10 = $ntotal['total_ntotal_9and10'];
        $ntotal_11 = $ntotal['total_ntotal_11'];
        $ntotal_12 = $ntotal['total_ntotal_12'];
    }


    $ntotal_withSL_format = formatNumber($ntotal_withSL);
    $ntotal_4m_format = formatNumber($ntotal_4m);
    $ntotal_5and6_format = formatNumber($ntotal_5and6);
    $ntotal_7and8_format = formatNumber($ntotal_7and8);
    $ntotal_9and10_format = formatNumber($ntotal_9and10);
    $ntotal_11_format = formatNumber($ntotal_11);
    $ntotal_12_format = formatNumber($ntotal_12);
     // Get total Ntotal
     $grand_total_ntotal_withSL1 += $ntotal_withSL;
     $grand_total_ntotal_4m1 += $ntotal_4m;
     $grand_total_ntotal_5and61 += $ntotal_5and6;
     $grand_total_ntotal_7and81 += $ntotal_7and8;
     $grand_total_ntotal_9and101 += $ntotal_9and10;
     $grand_total_ntotal_111 += $ntotal_11;
     $grand_total_ntotal_121 += $ntotal_12;

    $grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
    $grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
    $grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
    $grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
    $grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
    $grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
    $grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);
      
     $total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
     $total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
     $total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
     if($total_change != 0){
        $total_change1 = number_format((float)abs($total_change), 2, '.', ',');
     }else{
       $total_change1 = "-"; 
     }

     if($total_ntotal != 0){
        $total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
     }else{
       $total_ntotal1 = "-"; 
     }
   

     $grand_total_ssp += $total_ssp;
     $grand_total_sl +=$total_change;
     $grand_total_lr += $total_ntotal;

    $grand_total_sl1 = formatNumber($grand_total_sl);
    $grand_total_lr1 = formatNumber($grand_total_lr);
       
        $header .= <<<EOF
            <tr>
            <td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
            <td style="width:30px;">$SSP_withSL</td>
            <td style="width:75px;">($chng_withSL_format)</td>
            <td style="width:75px;">$ntotal_withSL_format</td>
            <td style="width:30px;">$ssp_4m</td>
            <td style="width:75px;">($chng_4m_format)</td>
            <td style="width:75px;">$ntotal_4m_format</td>
            <td style="width:30px;">$ssp_5and6</td>
            <td style="width:75px;">($chng_5and6_format)</td>
            <td style="width:75px;">$ntotal_5and6_format</td>
            <td style="width:30px;">$ssp_7and8</td>
            <td style="width:75px;">($chng_7and8_format)</td>
            <td style="width:75px;">$ntotal_7and8_format</td>
            <td style="width:30px;">$ssp_9and10</td>
            <td style="width:75px;">($chng_9and10_format)</td>
            <td style="width:75px;">$ntotal_9and10_format</td>
        </tr>
        EOF;
    
}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
        <td>$grand_totalSSP_withSL</td>
        <td>($grand_total_chng_withSL1)</td>
        <td>$grand_total_ntotal_withSL</td>
        <td>$grand_total_ssp_4m</td>
        <td>($grand_total_chng_4m1)</td>
        <td>$grand_total_ntotal_4m</td>
        <td>$grand_total_ssp_5and6</td>
        <td>($grand_total_chng_5and61)</td>
        <td>$grand_total_ntotal_5and6</td>
        <td>$grand_total_ssp_7and8</td>
        <td>($grand_total_chng_7and81)</td>
        <td>$grand_total_ntotal_7and8</td>
        <td>$grand_total_ssp_9and10</td>
        <td>($grand_total_chng_9and101)</td>
        <td>$grand_total_ntotal_9and10</td>
    </tr>
EOF;

$header .= <<<EOF
        <tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
        </tbody>
    </table>
EOF;
$header .= <<<EOF
            <table>
                        <thead>
                        <tr style="font-weight: bold;">
                            <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">FCH BRANCHES</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">FULLY PAID WITH SL</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">4 MONTH & BELOW</th>
                            <th colspan="3"  style="width:180px; font-size:7.0rem;">5 TO 6 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">7 TO 8 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">9 TO 10 MONTHS</th>
                        </tr>
                    
                        <tr>
                        <th style="width:30px; font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                    </tr>
                    </thead>
                    <tbody>
        EOF;
    $getFCH = $Operation ->ctrgetallFCHBranches();
    // SSP TOTAL
    $grand_totalSSP_withSL = 0;
    $grand_total_ssp_4m = 0;
    $grand_total_ssp_5and6 = 0;
    $grand_total_ssp_7and8 = 0;
    $grand_total_ssp_9and10 = 0;
    $grand_total_ssp_11 = 0;
    $grand_total_ssp_12 = 0;
    // CHANGE TOTAL
    $grand_total_chng_withSL = 0;
    $grand_total_chng_4m = 0;
    $grand_total_chng_5and6 = 0;
    $grand_total_chng_7and8 = 0;
    $grand_total_chng_9and10 = 0;
    $grand_total_chng_11 = 0;
    $grand_total_chng_12 = 0;
    // Ntotal TOTAL
    $grand_total_ntotal_withSL1 = 0;
    $grand_total_ntotal_4m1 = 0;
    $grand_total_ntotal_5and61 = 0;
    $grand_total_ntotal_7and81 = 0;
    $grand_total_ntotal_9and101 = 0;
    $grand_total_ntotal_111 = 0;
    $grand_total_ntotal_121 = 0;

    $grand_total_ssp = 0;
    $grand_total_sl = 0;
    $grand_total_lr = 0;


    foreach ($getFCH as $fch) { 
        $branch_name = $fch['full_name'];
        $new_branch_name = str_replace("FCH", "", $branch_name);
    $get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
    foreach($get_SPP_withSL as $SSP_withSL1){
        $SSP_withSL = $SSP_withSL1['total_ssp_sl'];
        $ssp_4m = $SSP_withSL1['total_ssp_4m'];
        $ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
        $ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
        $ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
        $ssp_11 = $SSP_withSL1['total_ssp_11'];
        $ssp_12 = $SSP_withSL1['total_ssp_12'];
    }

    $grand_totalSSP_withSL += $SSP_withSL;
    $grand_total_ssp_4m += $ssp_4m;
    $grand_total_ssp_5and6 += $ssp_5and6;
    $grand_total_ssp_7and8 += $ssp_7and8;
    $grand_total_ssp_9and10 += $ssp_9and10;
    $grand_total_ssp_11 += $ssp_11;
    $grand_total_ssp_12 += $ssp_12;

    $get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
    foreach($get_loans_change as $change){
        $chng_withSL = $change['total_chng_sl'];
        $chng_4m = $change['total_chng_4m'];
        $chng_5and6 = $change['total_chng_5and6'];
        $chng_7and8 = $change['total_chng_7and8'];
        $chng_9and10 = $change['total_chng_9and10'];
        $chng_11 = $change['total_chng_11'];
        $chng_12 = $change['total_chng_12'];
    }
    $chng_withSL_format = formatNumber($chng_withSL);
    $chng_4m_format = formatNumber($chng_4m);
    $chng_5and6_format = formatNumber($chng_5and6);
    $chng_7and8_format = formatNumber($chng_7and8);
    $chng_9and10_format = formatNumber($chng_9and10);
    $chng_11_format = formatNumber($chng_11);
    $chng_12_format = formatNumber($chng_12);

    // Get total Change
    $grand_total_chng_withSL += $chng_withSL;
    $grand_total_chng_4m += $chng_4m;
    $grand_total_chng_5and6 += $chng_5and6;
    $grand_total_chng_7and8 += $chng_7and8;
    $grand_total_chng_9and10 += $chng_9and10;
    $grand_total_chng_11 += $chng_11;
    $grand_total_chng_12 += $chng_12;

    $grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
    $grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
    $grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
    $grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
    $grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
    $grand_total_chng_111 = formatNumber($grand_total_chng_11);
    $grand_total_chng_121 = formatNumber($grand_total_chng_12);

    $get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
    foreach($get_loans_ntotal as $ntotal){
        $ntotal_withSL = $ntotal['total_ntotal_sl'];
        $ntotal_4m = $ntotal['total_ntotal_4m'];
        $ntotal_5and6 = $ntotal['total_ntotal_5and6'];
        $ntotal_7and8 = $ntotal['total_ntotal_7and8'];
        $ntotal_9and10 = $ntotal['total_ntotal_9and10'];
        $ntotal_11 = $ntotal['total_ntotal_11'];
        $ntotal_12 = $ntotal['total_ntotal_12'];
    }

    $ntotal_withSL_format = formatNumber($ntotal_withSL);
    $ntotal_4m_format = formatNumber($ntotal_4m);
    $ntotal_5and6_format = formatNumber($ntotal_5and6);
    $ntotal_7and8_format = formatNumber($ntotal_7and8);
    $ntotal_9and10_format = formatNumber($ntotal_9and10);
    $ntotal_11_format = formatNumber($ntotal_11);
    $ntotal_12_format = formatNumber($ntotal_12);

     // Get total Ntotal
     $grand_total_ntotal_withSL1 += $ntotal_withSL;
     $grand_total_ntotal_4m1 += $ntotal_4m;
     $grand_total_ntotal_5and61 += $ntotal_5and6;
     $grand_total_ntotal_7and81 += $ntotal_7and8;
     $grand_total_ntotal_9and101 += $ntotal_9and10;
     $grand_total_ntotal_111 += $ntotal_11;
     $grand_total_ntotal_121 += $ntotal_12;

    


     $grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
     $grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
     $grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
     $grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
     $grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
     $grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
     $grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);

     $total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
     $total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
     $total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
     if($total_change != 0){
        $total_change1 = number_format((float)abs($total_change), 2, '.', ',');
     }else{
       $total_change1 = "-"; 
     }

     if($total_ntotal != 0){
        $total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
     }else{
       $total_ntotal1 = "-"; 
     }
   

     $grand_total_ssp += $total_ssp;
     $grand_total_sl +=$total_change;
     $grand_total_lr += $total_ntotal;

     $grand_total_sl1 = formatNumber($grand_total_sl);
     $grand_total_lr1 = formatNumber($grand_total_lr);
       
       
        $header .= <<<EOF
            <tr>
                <td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
                <td style="width:30px;">$SSP_withSL</td>
                <td style="width:75px;">($chng_withSL_format)</td>
                <td style="width:75px;">$ntotal_withSL_format</td>
                <td style="width:30px;">$ssp_4m</td>
                <td style="width:75px;">($chng_4m_format)</td>
                <td style="width:75px;">$ntotal_4m_format</td>
                <td style="width:30px;">$ssp_5and6</td>
                <td style="width:75px;">($chng_5and6_format)</td>
                <td style="width:75px;">$ntotal_5and6_format</td>
                <td style="width:30px;">$ssp_7and8</td>
                <td style="width:75px;">($chng_7and8_format)</td>
                <td style="width:75px;">$ntotal_7and8_format</td>
                <td style="width:30px;">$ssp_9and10</td>
                <td style="width:75px;">($chng_9and10_format)</td>
                <td style="width:75px;">$ntotal_9and10_format</td>
            </tr>
        EOF;
    
}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
        <td>$grand_totalSSP_withSL</td>
        <td>($grand_total_chng_withSL1)</td>
        <td>$grand_total_ntotal_withSL</td>
        <td>$grand_total_ssp_4m</td>
        <td>($grand_total_chng_4m1)</td>
        <td>$grand_total_ntotal_4m</td>
        <td>$grand_total_ssp_5and6</td>
        <td>($grand_total_chng_5and61)</td>
        <td>$grand_total_ntotal_5and6</td>
        <td>$grand_total_ssp_7and8</td>
        <td>($grand_total_chng_7and81)</td>
        <td>$grand_total_ntotal_7and8</td>
        <td>$grand_total_ssp_9and10</td>
        <td>($grand_total_chng_9and101)</td>
        <td>$grand_total_ntotal_9and10</td>
    </tr>
EOF;

$header .= <<<EOF
      

        <tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
        </tbody>
    </table>
EOF;
$header .= <<<EOF
            <table>
                        <thead>
                        <tr style="font-weight: bold;">
                            <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">RLC BRANCHES</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">FULLY PAID WITH SL</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">4 MONTH & BELOW</th>
                            <th colspan="3"  style="width:180px; font-size:7.0rem;">5 TO 6 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">7 TO 8 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">9 TO 10 MONTHS</th>
                        </tr>
                    
                        <tr>
                <th style="width:30px; font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
            </tr>
                    </thead>
                    <tbody>
        EOF;
    $getRLC = $Operation ->ctrGetAllRLCBranches();
    // SSP TOTAL
    $grand_totalSSP_withSL = 0;
    $grand_total_ssp_4m = 0;
    $grand_total_ssp_5and6 = 0;
    $grand_total_ssp_7and8 = 0;
    $grand_total_ssp_9and10 = 0;
    $grand_total_ssp_11 = 0;
    $grand_total_ssp_12 = 0;
    // CHANGE TOTAL
    $grand_total_chng_withSL = 0;
    $grand_total_chng_4m = 0;
    $grand_total_chng_5and6 = 0;
    $grand_total_chng_7and8 = 0;
    $grand_total_chng_9and10 = 0;
    $grand_total_chng_11 = 0;
    $grand_total_chng_12 = 0;
    // Ntotal TOTAL
    $grand_total_ntotal_withSL1 = 0;
    $grand_total_ntotal_4m1 = 0;
    $grand_total_ntotal_5and61 = 0;
    $grand_total_ntotal_7and81 = 0;
    $grand_total_ntotal_9and101 = 0;
    $grand_total_ntotal_111 = 0;
    $grand_total_ntotal_121 = 0;

    $grand_total_ssp = 0;
    $grand_total_sl = 0;
    $grand_total_lr = 0;


    foreach ($getRLC as $rlc) { 
        $branch_name = $rlc['full_name'];
        $new_branch_name = str_replace("RLC", "", $branch_name);
    $get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
    foreach($get_SPP_withSL as $SSP_withSL1){
        $SSP_withSL = $SSP_withSL1['total_ssp_sl'];
        $ssp_4m = $SSP_withSL1['total_ssp_4m'];
        $ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
        $ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
        $ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
        $ssp_11 = $SSP_withSL1['total_ssp_11'];
        $ssp_12 = $SSP_withSL1['total_ssp_12'];
    }

    $grand_totalSSP_withSL += $SSP_withSL;
    $grand_total_ssp_4m += $ssp_4m;
    $grand_total_ssp_5and6 += $ssp_5and6;
    $grand_total_ssp_7and8 += $ssp_7and8;
    $grand_total_ssp_9and10 += $ssp_9and10;
    $grand_total_ssp_11 += $ssp_11;
    $grand_total_ssp_12 += $ssp_12;

    $get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
    foreach($get_loans_change as $change){
        $chng_withSL = $change['total_chng_sl'];
        $chng_4m = $change['total_chng_4m'];
        $chng_5and6 = $change['total_chng_5and6'];
        $chng_7and8 = $change['total_chng_7and8'];
        $chng_9and10 = $change['total_chng_9and10'];
        $chng_11 = $change['total_chng_11'];
        $chng_12 = $change['total_chng_12'];
    }
    $chng_withSL_format = formatNumber($chng_withSL);
    $chng_4m_format = formatNumber($chng_4m);
    $chng_5and6_format = formatNumber($chng_5and6);
    $chng_7and8_format = formatNumber($chng_7and8);
    $chng_9and10_format = formatNumber($chng_9and10);
    $chng_11_format = formatNumber($chng_11);
    $chng_12_format = formatNumber($chng_12);
    // Get total Change
    $grand_total_chng_withSL += $chng_withSL;
    $grand_total_chng_4m += $chng_4m;
    $grand_total_chng_5and6 += $chng_5and6;
    $grand_total_chng_7and8 += $chng_7and8;
    $grand_total_chng_9and10 += $chng_9and10;
    $grand_total_chng_11 += $chng_11;
    $grand_total_chng_12 += $chng_12;

    $grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
    $grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
    $grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
    $grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
    $grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
    $grand_total_chng_111 = formatNumber($grand_total_chng_11);
    $grand_total_chng_121 = formatNumber($grand_total_chng_12);

    $get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
    foreach($get_loans_ntotal as $ntotal){
        $ntotal_withSL = $ntotal['total_ntotal_sl'];
        $ntotal_4m = $ntotal['total_ntotal_4m'];
        $ntotal_5and6 = $ntotal['total_ntotal_5and6'];
        $ntotal_7and8 = $ntotal['total_ntotal_7and8'];
        $ntotal_9and10 = $ntotal['total_ntotal_9and10'];
        $ntotal_11 = $ntotal['total_ntotal_11'];
        $ntotal_12 = $ntotal['total_ntotal_12'];
    }


    $ntotal_withSL_format = formatNumber($ntotal_withSL);
    $ntotal_4m_format = formatNumber($ntotal_4m);
    $ntotal_5and6_format = formatNumber($ntotal_5and6);
    $ntotal_7and8_format = formatNumber($ntotal_7and8);
    $ntotal_9and10_format = formatNumber($ntotal_9and10);
    $ntotal_11_format = formatNumber($ntotal_11);
    $ntotal_12_format = formatNumber($ntotal_12);
     // Get total Ntotal
     $grand_total_ntotal_withSL1 += $ntotal_withSL;
     $grand_total_ntotal_4m1 += $ntotal_4m;
     $grand_total_ntotal_5and61 += $ntotal_5and6;
     $grand_total_ntotal_7and81 += $ntotal_7and8;
     $grand_total_ntotal_9and101 += $ntotal_9and10;
     $grand_total_ntotal_111 += $ntotal_11;
     $grand_total_ntotal_121 += $ntotal_12;

    $grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
    $grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
    $grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
    $grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
    $grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
    $grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
    $grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);
      
     $total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
     $total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
     $total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
     if($total_change != 0){
        $total_change1 = number_format((float)abs($total_change), 2, '.', ',');
     }else{
       $total_change1 = "-"; 
     }

     if($total_ntotal != 0){
        $total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
     }else{
       $total_ntotal1 = "-"; 
     }
   

     $grand_total_ssp += $total_ssp;
     $grand_total_sl +=$total_change;
     $grand_total_lr += $total_ntotal;

    $grand_total_sl1 = formatNumber($grand_total_sl);
    $grand_total_lr1 = formatNumber($grand_total_lr);
       
       
        $header .= <<<EOF
            <tr>
               <td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
                <td style="width:30px;">$SSP_withSL</td>
                <td style="width:75px;">($chng_withSL_format)</td>
                <td style="width:75px;">$ntotal_withSL_format</td>
                <td style="width:30px;">$ssp_4m</td>
                <td style="width:75px;">($chng_4m_format)</td>
                <td style="width:75px;">$ntotal_4m_format</td>
                <td style="width:30px;">$ssp_5and6</td>
                <td style="width:75px;">($chng_5and6_format)</td>
                <td style="width:75px;">$ntotal_5and6_format</td>
                <td style="width:30px;">$ssp_7and8</td>
                <td style="width:75px;">($chng_7and8_format)</td>
                <td style="width:75px;">$ntotal_7and8_format</td>
                <td style="width:30px;">$ssp_9and10</td>
                <td style="width:75px;">($chng_9and10_format)</td>
                <td style="width:75px;">$ntotal_9and10_format</td>
            </tr>
        EOF;
    
}

$header .= <<<EOF
    <tr style=" font-weight: bold;">
        <td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
        <td>$grand_totalSSP_withSL</td>
        <td>($grand_total_chng_withSL1)</td>
        <td>$grand_total_ntotal_withSL</td>
        <td>$grand_total_ssp_4m</td>
        <td>($grand_total_chng_4m1)</td>
        <td>$grand_total_ntotal_4m</td>
        <td>$grand_total_ssp_5and6</td>
        <td>($grand_total_chng_5and61)</td>
        <td>$grand_total_ntotal_5and6</td>
        <td>$grand_total_ssp_7and8</td>
        <td>($grand_total_chng_7and81)</td>
        <td>$grand_total_ntotal_7and8</td>
        <td>$grand_total_ssp_9and10</td>
        <td>($grand_total_chng_9and101)</td>
        <td>$grand_total_ntotal_9and10</td>
    </tr>
EOF;

$header .= <<<EOF
      

        <tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
        </tbody>
    </table>
EOF;

$header .= <<<EOF
            <table>
                        <thead>
                        <tr style="font-weight: bold;">
                            <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">ELC BRANCHES</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">FULLY PAID WITH SL</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">4 MONTH & BELOW</th>
                            <th colspan="3"  style="width:180px; font-size:7.0rem;">5 TO 6 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">7 TO 8 MONTHS</th>
                            <th colspan="3" style="width:180px; font-size:7.0rem;">9 TO 10 MONTHS</th>
                        </tr>
                    
                        <tr>
                        <th style="width:30px; font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                        <th style="width:30px;font-size:7.0rem;">SSP</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                        <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                    </tr>
                    </thead>
                    <tbody>
        EOF;
    $getELC = $Operation ->ctrGetAllELCBranches();
    // SSP TOTAL
    $grand_totalSSP_withSL = 0;
    $grand_total_ssp_4m = 0;
    $grand_total_ssp_5and6 = 0;
    $grand_total_ssp_7and8 = 0;
    $grand_total_ssp_9and10 = 0;
    $grand_total_ssp_11 = 0;
    $grand_total_ssp_12 = 0;
    // CHANGE TOTAL
    $grand_total_chng_withSL = 0;
    $grand_total_chng_4m = 0;
    $grand_total_chng_5and6 = 0;
    $grand_total_chng_7and8 = 0;
    $grand_total_chng_9and10 = 0;
    $grand_total_chng_11 = 0;
    $grand_total_chng_12 = 0;
    // Ntotal TOTAL
    $grand_total_ntotal_withSL1 = 0;
    $grand_total_ntotal_4m1 = 0;
    $grand_total_ntotal_5and61 = 0;
    $grand_total_ntotal_7and81 = 0;
    $grand_total_ntotal_9and101 = 0;
    $grand_total_ntotal_111 = 0;
    $grand_total_ntotal_121 = 0;

    $grand_total_ssp = 0;
    $grand_total_sl = 0;
    $grand_total_lr = 0;



    foreach ($getELC as $elc) { 
        $branch_name = $elc['full_name'];
        $new_branch_name = str_replace("EMB", "", $branch_name);
    $get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
    foreach($get_SPP_withSL as $SSP_withSL1){
        $SSP_withSL = $SSP_withSL1['total_ssp_sl'];
        $ssp_4m = $SSP_withSL1['total_ssp_4m'];
        $ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
        $ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
        $ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
        $ssp_11 = $SSP_withSL1['total_ssp_11'];
        $ssp_12 = $SSP_withSL1['total_ssp_12'];
    }

    $grand_totalSSP_withSL += $SSP_withSL;
    $grand_total_ssp_4m += $ssp_4m;
    $grand_total_ssp_5and6 += $ssp_5and6;
    $grand_total_ssp_7and8 += $ssp_7and8;
    $grand_total_ssp_9and10 += $ssp_9and10;
    $grand_total_ssp_11 += $ssp_11;
    $grand_total_ssp_12 += $ssp_12;

    $get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
    foreach($get_loans_change as $change){
        $chng_withSL = $change['total_chng_sl'];
        $chng_4m = $change['total_chng_4m'];
        $chng_5and6 = $change['total_chng_5and6'];
        $chng_7and8 = $change['total_chng_7and8'];
        $chng_9and10 = $change['total_chng_9and10'];
        $chng_11 = $change['total_chng_11'];
        $chng_12 = $change['total_chng_12'];
    }
    $chng_withSL_format = formatNumber($chng_withSL);
    $chng_4m_format = formatNumber($chng_4m);
    $chng_5and6_format = formatNumber($chng_5and6);
    $chng_7and8_format = formatNumber($chng_7and8);
    $chng_9and10_format = formatNumber($chng_9and10);
    $chng_11_format = formatNumber($chng_11);
    $chng_12_format = formatNumber($chng_12);
    // Get total Change
    $grand_total_chng_withSL += $chng_withSL;
    $grand_total_chng_4m += $chng_4m;
    $grand_total_chng_5and6 += $chng_5and6;
    $grand_total_chng_7and8 += $chng_7and8;
    $grand_total_chng_9and10 += $chng_9and10;
    $grand_total_chng_11 += $chng_11;
    $grand_total_chng_12 += $chng_12;

    $grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
    $grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
    $grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
    $grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
    $grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
    $grand_total_chng_111 = formatNumber($grand_total_chng_11);
    $grand_total_chng_121 = formatNumber($grand_total_chng_12);

    $get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
    foreach($get_loans_ntotal as $ntotal){
        $ntotal_withSL = $ntotal['total_ntotal_sl'];
        $ntotal_4m = $ntotal['total_ntotal_4m'];
        $ntotal_5and6 = $ntotal['total_ntotal_5and6'];
        $ntotal_7and8 = $ntotal['total_ntotal_7and8'];
        $ntotal_9and10 = $ntotal['total_ntotal_9and10'];
        $ntotal_11 = $ntotal['total_ntotal_11'];
        $ntotal_12 = $ntotal['total_ntotal_12'];
    }


    $ntotal_withSL_format = formatNumber($ntotal_withSL);
    $ntotal_4m_format = formatNumber($ntotal_4m);
    $ntotal_5and6_format = formatNumber($ntotal_5and6);
    $ntotal_7and8_format = formatNumber($ntotal_7and8);
    $ntotal_9and10_format = formatNumber($ntotal_9and10);
    $ntotal_11_format = formatNumber($ntotal_11);
    $ntotal_12_format = formatNumber($ntotal_12);
     // Get total Ntotal
     $grand_total_ntotal_withSL1 += $ntotal_withSL;
     $grand_total_ntotal_4m1 += $ntotal_4m;
     $grand_total_ntotal_5and61 += $ntotal_5and6;
     $grand_total_ntotal_7and81 += $ntotal_7and8;
     $grand_total_ntotal_9and101 += $ntotal_9and10;
     $grand_total_ntotal_111 += $ntotal_11;
     $grand_total_ntotal_121 += $ntotal_12;

    $grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
    $grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
    $grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
    $grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
    $grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
    $grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
    $grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);
      
     $total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
     $total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
     $total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
     if($total_change != 0){
        $total_change1 = number_format((float)abs($total_change), 2, '.', ',');
     }else{
       $total_change1 = "-"; 
     }

     if($total_ntotal != 0){
        $total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
     }else{
       $total_ntotal1 = "-"; 
     }
   

     $grand_total_ssp += $total_ssp;
     $grand_total_sl +=$total_change;
     $grand_total_lr += $total_ntotal;

    $grand_total_sl1 = formatNumber($grand_total_sl);
    $grand_total_lr1 = formatNumber($grand_total_lr);
       
       
        $header .= <<<EOF
            <tr>
                <td style="width: 80px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
                <td style="width:30px;">$SSP_withSL</td>
                <td style="width:75px;">($chng_withSL_format)</td>
                <td style="width:75px;">$ntotal_withSL_format</td>
                <td style="width:30px;">$ssp_4m</td>
                <td style="width:75px;">($chng_4m_format)</td>
                <td style="width:75px;">$ntotal_4m_format</td>
                <td style="width:30px;">$ssp_5and6</td>
                <td style="width:75px;">($chng_5and6_format)</td>
                <td style="width:75px;">$ntotal_5and6_format</td>
                <td style="width:30px;">$ssp_7and8</td>
                <td style="width:75px;">($chng_7and8_format)</td>
                <td style="width:75px;">$ntotal_7and8_format</td>
                <td style="width:30px;">$ssp_9and10</td>
                <td style="width:75px;">($chng_9and10_format)</td>
                <td style="width:75px;">$ntotal_9and10_format</td>
            </tr>
        EOF;
    
}
$header .= <<<EOF
                  </tbody>
            </table>
            <br>
            <br>
            <br>
            <table>
            <tr>
                <th  style="border: none; text-align:left;font-weight:bold; font-size: 8.5rem;">EMB CAPITAL LENDING CORPORATION</th>
            </tr>
            <tr>
                <th  style="border: none; text-align:left;font-weight:bold; font-size: 8.5rem;">LOANS RECEIVABLE AGING</th>
            </tr>
            <tr>
                <th  style="border: none; background-color:yellow; width: 230px; text-align:left;font-weight:bold; font-size: 8.5rem;">FOR THE MONTH OF $monthName</th>
            </tr>
        <tr>
        <th  style="border: none; text-align:left;font-weight:bold;"></th>
    </tr>
    </table>
    <style>
    tr,th{
   border:1px solid black;
   font-size:6.7rem;
   text-align:center;
}
    tr, td{
   border:1px solid black;
   font-size:6.7rem;
   text-align:center;
}
</style>

    <table>
    <thead>
        <tr style="font-weight: bold;">
            <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">EMB BRANCHES</th>
            <th colspan="3" style="width:180px; font-size:7.0rem;">11 MONTHS</th>
            <th colspan="3" style="width:180px; font-size:7.0rem;">12 MONTHS</th>
            <th colspan="3" style="width:180px; font-size:7.0rem;">GRAND TOTAL</th>
        </tr>
            <tr>
            <th style="width:30px; font-size:7.0rem;">SSP</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
            <th style="width:30px;font-size:7.0rem;">SSP</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
            <th style="width:30px;font-size:7.0rem;">SSP</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
            <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
        </tr>
    </thead>
    <tbody>
EOF;
$getEMB = $Operation ->ctrGetAllEMBBranches();
// SSP TOTAL
$grand_totalSSP_withSL = 0;
$grand_total_ssp_4m = 0;
$grand_total_ssp_5and6 = 0;
$grand_total_ssp_7and8 = 0;
$grand_total_ssp_9and10 = 0;
$grand_total_ssp_11 = 0;
$grand_total_ssp_12 = 0;
// CHANGE TOTAL
$grand_total_chng_withSL = 0;
$grand_total_chng_4m = 0;
$grand_total_chng_5and6 = 0;
$grand_total_chng_7and8 = 0;
$grand_total_chng_9and10 = 0;
$grand_total_chng_11 = 0;
$grand_total_chng_12 = 0;
// Ntotal TOTAL
$grand_total_ntotal_withSL1 = 0;
$grand_total_ntotal_4m1 = 0;
$grand_total_ntotal_5and61 = 0;
$grand_total_ntotal_7and81 = 0;
$grand_total_ntotal_9and101 = 0;
$grand_total_ntotal_111 = 0;
$grand_total_ntotal_121 = 0;

$grand_total_ssp = 0;
$grand_total_sl = 0;
$grand_total_lr = 0;


foreach ($getEMB as $emb) { 
$branch_name = $emb['full_name'];
$new_branch_name = str_replace("EMB", "", $branch_name);
$get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
foreach($get_SPP_withSL as $SSP_withSL1){
$SSP_withSL = $SSP_withSL1['total_ssp_sl'];
$ssp_4m = $SSP_withSL1['total_ssp_4m'];
$ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
$ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
$ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
$ssp_11 = $SSP_withSL1['total_ssp_11'];
$ssp_12 = $SSP_withSL1['total_ssp_12'];
}

$grand_totalSSP_withSL += $SSP_withSL;
$grand_total_ssp_4m += $ssp_4m;
$grand_total_ssp_5and6 += $ssp_5and6;
$grand_total_ssp_7and8 += $ssp_7and8;
$grand_total_ssp_9and10 += $ssp_9and10;
$grand_total_ssp_11 += $ssp_11;
$grand_total_ssp_12 += $ssp_12;

$get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
foreach($get_loans_change as $change){
$chng_withSL = $change['total_chng_sl'];
$chng_4m = $change['total_chng_4m'];
$chng_5and6 = $change['total_chng_5and6'];
$chng_7and8 = $change['total_chng_7and8'];
$chng_9and10 = $change['total_chng_9and10'];
$chng_11 = $change['total_chng_11'];
$chng_12 = $change['total_chng_12'];
}

$chng_withSL_format = formatNumber($chng_withSL);
$chng_4m_format = formatNumber($chng_4m);
$chng_5and6_format = formatNumber($chng_5and6);
$chng_7and8_format = formatNumber($chng_7and8);
$chng_9and10_format = formatNumber($chng_9and10);
$chng_11_format = formatNumber($chng_11);
$chng_12_format = formatNumber($chng_12);
// Get total Change
$grand_total_chng_withSL += $chng_withSL;
$grand_total_chng_4m += $chng_4m;
$grand_total_chng_5and6 += $chng_5and6;
$grand_total_chng_7and8 += $chng_7and8;
$grand_total_chng_9and10 += $chng_9and10;
$grand_total_chng_11 += $chng_11;
$grand_total_chng_12 += $chng_12;

$grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
$grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
$grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
$grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
$grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
$grand_total_chng_111 = formatNumber($grand_total_chng_11);
$grand_total_chng_121 = formatNumber($grand_total_chng_12);

$get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
foreach($get_loans_ntotal as $ntotal){
$ntotal_withSL = $ntotal['total_ntotal_sl'];
$ntotal_4m = $ntotal['total_ntotal_4m'];
$ntotal_5and6 = $ntotal['total_ntotal_5and6'];
$ntotal_7and8 = $ntotal['total_ntotal_7and8'];
$ntotal_9and10 = $ntotal['total_ntotal_9and10'];
$ntotal_11 = $ntotal['total_ntotal_11'];
$ntotal_12 = $ntotal['total_ntotal_12'];
}


$ntotal_withSL_format = formatNumber($ntotal_withSL);
$ntotal_4m_format = formatNumber($ntotal_4m);
$ntotal_5and6_format = formatNumber($ntotal_5and6);
$ntotal_7and8_format = formatNumber($ntotal_7and8);
$ntotal_9and10_format = formatNumber($ntotal_9and10);
$ntotal_11_format = formatNumber($ntotal_11);
$ntotal_12_format = formatNumber($ntotal_12);
// Get total Ntotal
$grand_total_ntotal_withSL1 += $ntotal_withSL;
$grand_total_ntotal_4m1 += $ntotal_4m;
$grand_total_ntotal_5and61 += $ntotal_5and6;
$grand_total_ntotal_7and81 += $ntotal_7and8;
$grand_total_ntotal_9and101 += $ntotal_9and10;
$grand_total_ntotal_111 += $ntotal_11;
$grand_total_ntotal_121 += $ntotal_12;

$grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
$grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
$grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
$grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
$grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
$grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
$grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);

$total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
$total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
$total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
if($total_change != 0){
$total_change1 = number_format((float)abs($total_change), 2, '.', ',');
}else{
$total_change1 = "-"; 
}

if($total_ntotal != 0){
$total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
}else{
$total_ntotal1 = "-"; 
}


$grand_total_ssp += $total_ssp;
$grand_total_sl +=$total_change;
$grand_total_lr += $total_ntotal;

$grand_total_sl1 = formatNumber($grand_total_sl);
$grand_total_lr1 = formatNumber($grand_total_lr);

$header .= <<<EOF
<tr>
<td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
    <td style="width:30px;">$ssp_11</td>
    <td style="width:75px;">($chng_11_format)</td>
    <td style="width:75px;">$ntotal_11_format</td>
    <td style="width:30px;">$ssp_12</td>
    <td style="width:75px;">($chng_12_format)</td>
    <td style="width:75px;">$ntotal_12_format</td>
    <td style="width:30px;">$total_ssp</td>
    <td style="width:75px;">($total_change1)</td>
    <td style="width:75px;">$total_ntotal1</td>
</tr>
EOF;

}

$header .= <<<EOF
<tr style=" font-weight: bold;">
<td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
    <td>$grand_total_ssp_11</td>
    <td>($grand_total_chng_111)</td>
    <td>$grand_total_ntotal_11</td>
    <td>$grand_total_ssp_12</td>
    <td>($grand_total_chng_121)</td>
    <td>$grand_total_ntotal_12</td>
    <td>$grand_total_ssp</td>
    <td>($grand_total_sl1)</td>
    <td>$grand_total_lr1</td>
</tr>
EOF;

$header .= <<<EOF
<tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
</tbody>
</table>
EOF;
$header .= <<<EOF
<table>
            <thead>
            <tr style="font-weight: bold;">
                <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">FCH BRANCHES</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">11 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">12 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">GRAND TOTAL</th>
            </tr>
                <tr>
                <th style="width:30px; font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
            </tr>
        </thead>
        <tbody>
EOF;
$getFCH = $Operation ->ctrgetallFCHBranches();
// SSP TOTAL
$grand_totalSSP_withSL = 0;
$grand_total_ssp_4m = 0;
$grand_total_ssp_5and6 = 0;
$grand_total_ssp_7and8 = 0;
$grand_total_ssp_9and10 = 0;
$grand_total_ssp_11 = 0;
$grand_total_ssp_12 = 0;
// CHANGE TOTAL
$grand_total_chng_withSL = 0;
$grand_total_chng_4m = 0;
$grand_total_chng_5and6 = 0;
$grand_total_chng_7and8 = 0;
$grand_total_chng_9and10 = 0;
$grand_total_chng_11 = 0;
$grand_total_chng_12 = 0;
// Ntotal TOTAL
$grand_total_ntotal_withSL1 = 0;
$grand_total_ntotal_4m1 = 0;
$grand_total_ntotal_5and61 = 0;
$grand_total_ntotal_7and81 = 0;
$grand_total_ntotal_9and101 = 0;
$grand_total_ntotal_111 = 0;
$grand_total_ntotal_121 = 0;

$grand_total_ssp = 0;
$grand_total_sl = 0;
$grand_total_lr = 0;


foreach ($getFCH as $fch) { 
$branch_name = $fch['full_name'];
$new_branch_name = str_replace("FCH", "", $branch_name);
$get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
foreach($get_SPP_withSL as $SSP_withSL1){
$SSP_withSL = $SSP_withSL1['total_ssp_sl'];
$ssp_4m = $SSP_withSL1['total_ssp_4m'];
$ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
$ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
$ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
$ssp_11 = $SSP_withSL1['total_ssp_11'];
$ssp_12 = $SSP_withSL1['total_ssp_12'];
}

$grand_totalSSP_withSL += $SSP_withSL;
$grand_total_ssp_4m += $ssp_4m;
$grand_total_ssp_5and6 += $ssp_5and6;
$grand_total_ssp_7and8 += $ssp_7and8;
$grand_total_ssp_9and10 += $ssp_9and10;
$grand_total_ssp_11 += $ssp_11;
$grand_total_ssp_12 += $ssp_12;

$get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
foreach($get_loans_change as $change){
$chng_withSL = $change['total_chng_sl'];
$chng_4m = $change['total_chng_4m'];
$chng_5and6 = $change['total_chng_5and6'];
$chng_7and8 = $change['total_chng_7and8'];
$chng_9and10 = $change['total_chng_9and10'];
$chng_11 = $change['total_chng_11'];
$chng_12 = $change['total_chng_12'];
}
$chng_withSL_format = formatNumber($chng_withSL);
$chng_4m_format = formatNumber($chng_4m);
$chng_5and6_format = formatNumber($chng_5and6);
$chng_7and8_format = formatNumber($chng_7and8);
$chng_9and10_format = formatNumber($chng_9and10);
$chng_11_format = formatNumber($chng_11);
$chng_12_format = formatNumber($chng_12);

// Get total Change
$grand_total_chng_withSL += $chng_withSL;
$grand_total_chng_4m += $chng_4m;
$grand_total_chng_5and6 += $chng_5and6;
$grand_total_chng_7and8 += $chng_7and8;
$grand_total_chng_9and10 += $chng_9and10;
$grand_total_chng_11 += $chng_11;
$grand_total_chng_12 += $chng_12;

$grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
$grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
$grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
$grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
$grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
$grand_total_chng_111 = formatNumber($grand_total_chng_11);
$grand_total_chng_121 = formatNumber($grand_total_chng_12);

$get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
foreach($get_loans_ntotal as $ntotal){
$ntotal_withSL = $ntotal['total_ntotal_sl'];
$ntotal_4m = $ntotal['total_ntotal_4m'];
$ntotal_5and6 = $ntotal['total_ntotal_5and6'];
$ntotal_7and8 = $ntotal['total_ntotal_7and8'];
$ntotal_9and10 = $ntotal['total_ntotal_9and10'];
$ntotal_11 = $ntotal['total_ntotal_11'];
$ntotal_12 = $ntotal['total_ntotal_12'];
}

$ntotal_withSL_format = formatNumber($ntotal_withSL);
$ntotal_4m_format = formatNumber($ntotal_4m);
$ntotal_5and6_format = formatNumber($ntotal_5and6);
$ntotal_7and8_format = formatNumber($ntotal_7and8);
$ntotal_9and10_format = formatNumber($ntotal_9and10);
$ntotal_11_format = formatNumber($ntotal_11);
$ntotal_12_format = formatNumber($ntotal_12);

// Get total Ntotal
$grand_total_ntotal_withSL1 += $ntotal_withSL;
$grand_total_ntotal_4m1 += $ntotal_4m;
$grand_total_ntotal_5and61 += $ntotal_5and6;
$grand_total_ntotal_7and81 += $ntotal_7and8;
$grand_total_ntotal_9and101 += $ntotal_9and10;
$grand_total_ntotal_111 += $ntotal_11;
$grand_total_ntotal_121 += $ntotal_12;




$grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
$grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
$grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
$grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
$grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
$grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
$grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);

$total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
$total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
$total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
if($total_change != 0){
$total_change1 = number_format((float)abs($total_change), 2, '.', ',');
}else{
$total_change1 = "-"; 
}

if($total_ntotal != 0){
$total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
}else{
$total_ntotal1 = "-"; 
}


$grand_total_ssp += $total_ssp;
$grand_total_sl +=$total_change;
$grand_total_lr += $total_ntotal;

$grand_total_sl1 = formatNumber($grand_total_sl);
$grand_total_lr1 = formatNumber($grand_total_lr);


$header .= <<<EOF
<tr>
    <td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
        <td style="width:30px;">$ssp_11</td>
        <td style="width:75px;">($chng_11_format)</td>
        <td style="width:75px;">$ntotal_11_format</td>
        <td style="width:30px;">$ssp_12</td>
        <td style="width:75px;">($chng_12_format)</td>
        <td style="width:75px;">$ntotal_12_format</td>
        <td style="width:30px;">$total_ssp</td>
        <td style="width:75px;">($total_change1)</td>
        <td style="width:75px;">$total_ntotal1</td>
</tr>
EOF;

}

$header .= <<<EOF
<tr style=" font-weight: bold;">
<td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
<td>$grand_total_ssp_11</td>
<td>($grand_total_chng_111)</td>
<td>$grand_total_ntotal_11</td>
<td>$grand_total_ssp_12</td>
<td>($grand_total_chng_121)</td>
<td>$grand_total_ntotal_12</td>
<td>$grand_total_ssp</td>
<td>($grand_total_sl1)</td>
<td>$grand_total_lr1</td>
</tr>
EOF;

$header .= <<<EOF


<tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
</tbody>
</table>
EOF;
$header .= <<<EOF
<table>
            <thead>
            <tr style="font-weight: bold;">
                <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">RLC BRANCHES</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">11 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">12 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">GRAND TOTAL</th>
            </tr>
                <tr>
                <th style="width:30px; font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
             </tr>
        </thead>
        <tbody>
EOF;
$getRLC = $Operation ->ctrGetAllRLCBranches();
// SSP TOTAL
$grand_totalSSP_withSL = 0;
$grand_total_ssp_4m = 0;
$grand_total_ssp_5and6 = 0;
$grand_total_ssp_7and8 = 0;
$grand_total_ssp_9and10 = 0;
$grand_total_ssp_11 = 0;
$grand_total_ssp_12 = 0;
// CHANGE TOTAL
$grand_total_chng_withSL = 0;
$grand_total_chng_4m = 0;
$grand_total_chng_5and6 = 0;
$grand_total_chng_7and8 = 0;
$grand_total_chng_9and10 = 0;
$grand_total_chng_11 = 0;
$grand_total_chng_12 = 0;
// Ntotal TOTAL
$grand_total_ntotal_withSL1 = 0;
$grand_total_ntotal_4m1 = 0;
$grand_total_ntotal_5and61 = 0;
$grand_total_ntotal_7and81 = 0;
$grand_total_ntotal_9and101 = 0;
$grand_total_ntotal_111 = 0;
$grand_total_ntotal_121 = 0;

$grand_total_ssp = 0;
$grand_total_sl = 0;
$grand_total_lr = 0;


foreach ($getRLC as $rlc) { 
$branch_name = $rlc['full_name'];
$new_branch_name = str_replace("RLC", "", $branch_name);
$get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
foreach($get_SPP_withSL as $SSP_withSL1){
$SSP_withSL = $SSP_withSL1['total_ssp_sl'];
$ssp_4m = $SSP_withSL1['total_ssp_4m'];
$ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
$ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
$ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
$ssp_11 = $SSP_withSL1['total_ssp_11'];
$ssp_12 = $SSP_withSL1['total_ssp_12'];
}

$grand_totalSSP_withSL += $SSP_withSL;
$grand_total_ssp_4m += $ssp_4m;
$grand_total_ssp_5and6 += $ssp_5and6;
$grand_total_ssp_7and8 += $ssp_7and8;
$grand_total_ssp_9and10 += $ssp_9and10;
$grand_total_ssp_11 += $ssp_11;
$grand_total_ssp_12 += $ssp_12;

$get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
foreach($get_loans_change as $change){
$chng_withSL = $change['total_chng_sl'];
$chng_4m = $change['total_chng_4m'];
$chng_5and6 = $change['total_chng_5and6'];
$chng_7and8 = $change['total_chng_7and8'];
$chng_9and10 = $change['total_chng_9and10'];
$chng_11 = $change['total_chng_11'];
$chng_12 = $change['total_chng_12'];
}
$chng_withSL_format = formatNumber($chng_withSL);
$chng_4m_format = formatNumber($chng_4m);
$chng_5and6_format = formatNumber($chng_5and6);
$chng_7and8_format = formatNumber($chng_7and8);
$chng_9and10_format = formatNumber($chng_9and10);
$chng_11_format = formatNumber($chng_11);
$chng_12_format = formatNumber($chng_12);
// Get total Change
$grand_total_chng_withSL += $chng_withSL;
$grand_total_chng_4m += $chng_4m;
$grand_total_chng_5and6 += $chng_5and6;
$grand_total_chng_7and8 += $chng_7and8;
$grand_total_chng_9and10 += $chng_9and10;
$grand_total_chng_11 += $chng_11;
$grand_total_chng_12 += $chng_12;

$grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
$grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
$grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
$grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
$grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
$grand_total_chng_111 = formatNumber($grand_total_chng_11);
$grand_total_chng_121 = formatNumber($grand_total_chng_12);

$get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
foreach($get_loans_ntotal as $ntotal){
$ntotal_withSL = $ntotal['total_ntotal_sl'];
$ntotal_4m = $ntotal['total_ntotal_4m'];
$ntotal_5and6 = $ntotal['total_ntotal_5and6'];
$ntotal_7and8 = $ntotal['total_ntotal_7and8'];
$ntotal_9and10 = $ntotal['total_ntotal_9and10'];
$ntotal_11 = $ntotal['total_ntotal_11'];
$ntotal_12 = $ntotal['total_ntotal_12'];
}


$ntotal_withSL_format = formatNumber($ntotal_withSL);
$ntotal_4m_format = formatNumber($ntotal_4m);
$ntotal_5and6_format = formatNumber($ntotal_5and6);
$ntotal_7and8_format = formatNumber($ntotal_7and8);
$ntotal_9and10_format = formatNumber($ntotal_9and10);
$ntotal_11_format = formatNumber($ntotal_11);
$ntotal_12_format = formatNumber($ntotal_12);
// Get total Ntotal
$grand_total_ntotal_withSL1 += $ntotal_withSL;
$grand_total_ntotal_4m1 += $ntotal_4m;
$grand_total_ntotal_5and61 += $ntotal_5and6;
$grand_total_ntotal_7and81 += $ntotal_7and8;
$grand_total_ntotal_9and101 += $ntotal_9and10;
$grand_total_ntotal_111 += $ntotal_11;
$grand_total_ntotal_121 += $ntotal_12;

$grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
$grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
$grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
$grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
$grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
$grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
$grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);

$total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
$total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
$total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
if($total_change != 0){
$total_change1 = number_format((float)abs($total_change), 2, '.', ',');
}else{
$total_change1 = "-"; 
}

if($total_ntotal != 0){
$total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
}else{
$total_ntotal1 = "-"; 
}


$grand_total_ssp += $total_ssp;
$grand_total_sl +=$total_change;
$grand_total_lr += $total_ntotal;

$grand_total_sl1 = formatNumber($grand_total_sl);
$grand_total_lr1 = formatNumber($grand_total_lr);


$header .= <<<EOF
<tr>
<td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
    <td style="width:30px;">$ssp_11</td>
    <td style="width:75px;">($chng_11_format)</td>
    <td style="width:75px;">$ntotal_11_format</td>
    <td style="width:30px;">$ssp_12</td>
    <td style="width:75px;">($chng_12_format)</td>
    <td style="width:75px;">$ntotal_12_format</td>
    <td style="width:30px;">$total_ssp</td>
    <td style="width:75px;">($total_change1)</td>
    <td style="width:75px;">$total_ntotal1</td>
</tr>
EOF;

}

$header .= <<<EOF
<tr style=" font-weight: bold;">
<td style="text-align: left;">&nbsp;&nbsp; TOTAL</td>
<td>$grand_total_ssp_11</td>
<td>($grand_total_chng_111)</td>
<td>$grand_total_ntotal_11</td>
<td>$grand_total_ssp_12</td>
<td>($grand_total_chng_121)</td>
<td>$grand_total_ntotal_12</td>
<td>$grand_total_ssp</td>
<td>($grand_total_sl1)</td>
<td>$grand_total_lr1</td>
</tr>
EOF;

$header .= <<<EOF


<tr><td colspan="9" style="border:none;"></td></tr>
EOF;

$header .= <<<EOF
</tbody>
</table>
EOF;

$header .= <<<EOF
<table>
            <thead>
            <tr style="font-weight: bold;">
                <th style="text-align: center; width: 80px; vertical-align: middle;font-size:7.0rem;border:1px solid black;padding:5rem;font-weight:bold;" rowspan="2">ELC BRANCHES</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">11 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">12 MONTHS</th>
                <th colspan="3" style="width:180px; font-size:7.0rem;">GRAND TOTAL</th>
            </tr>
                <tr>
                <th style="width:30px; font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
                <th style="width:30px;font-size:7.0rem;">SSP</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL SL</th>
                <th style="width:75px;font-size:7.0rem;">TOTAL LR</th>
             </tr>
        </thead>
        <tbody>
EOF;
$getELC = $Operation ->ctrGetAllELCBranches();
// SSP TOTAL
$grand_totalSSP_withSL = 0;
$grand_total_ssp_4m = 0;
$grand_total_ssp_5and6 = 0;
$grand_total_ssp_7and8 = 0;
$grand_total_ssp_9and10 = 0;
$grand_total_ssp_11 = 0;
$grand_total_ssp_12 = 0;
// CHANGE TOTAL
$grand_total_chng_withSL = 0;
$grand_total_chng_4m = 0;
$grand_total_chng_5and6 = 0;
$grand_total_chng_7and8 = 0;
$grand_total_chng_9and10 = 0;
$grand_total_chng_11 = 0;
$grand_total_chng_12 = 0;
// Ntotal TOTAL
$grand_total_ntotal_withSL1 = 0;
$grand_total_ntotal_4m1 = 0;
$grand_total_ntotal_5and61 = 0;
$grand_total_ntotal_7and81 = 0;
$grand_total_ntotal_9and101 = 0;
$grand_total_ntotal_111 = 0;
$grand_total_ntotal_121 = 0;

$grand_total_ssp = 0;
$grand_total_sl = 0;
$grand_total_lr = 0;



foreach ($getELC as $elc) { 
$branch_name = $elc['full_name'];
$new_branch_name = str_replace("EMB", "", $branch_name);
$get_SPP_withSL = $Operation->ctrGetSPPWithSL($branch_name, $month, $date);
foreach($get_SPP_withSL as $SSP_withSL1){
$SSP_withSL = $SSP_withSL1['total_ssp_sl'];
$ssp_4m = $SSP_withSL1['total_ssp_4m'];
$ssp_5and6 = $SSP_withSL1['total_ssp_5and6'];
$ssp_7and8 = $SSP_withSL1['total_ssp_7and8'];
$ssp_9and10 = $SSP_withSL1['total_ssp_9and10'];
$ssp_11 = $SSP_withSL1['total_ssp_11'];
$ssp_12 = $SSP_withSL1['total_ssp_12'];
}

$grand_totalSSP_withSL += $SSP_withSL;
$grand_total_ssp_4m += $ssp_4m;
$grand_total_ssp_5and6 += $ssp_5and6;
$grand_total_ssp_7and8 += $ssp_7and8;
$grand_total_ssp_9and10 += $ssp_9and10;
$grand_total_ssp_11 += $ssp_11;
$grand_total_ssp_12 += $ssp_12;

$get_loans_change = $Operation->ctrGetLoansChange($branch_name, $month, $date);
foreach($get_loans_change as $change){
$chng_withSL = $change['total_chng_sl'];
$chng_4m = $change['total_chng_4m'];
$chng_5and6 = $change['total_chng_5and6'];
$chng_7and8 = $change['total_chng_7and8'];
$chng_9and10 = $change['total_chng_9and10'];
$chng_11 = $change['total_chng_11'];
$chng_12 = $change['total_chng_12'];
}
$chng_withSL_format = formatNumber($chng_withSL);
$chng_4m_format = formatNumber($chng_4m);
$chng_5and6_format = formatNumber($chng_5and6);
$chng_7and8_format = formatNumber($chng_7and8);
$chng_9and10_format = formatNumber($chng_9and10);
$chng_11_format = formatNumber($chng_11);
$chng_12_format = formatNumber($chng_12);
// Get total Change
$grand_total_chng_withSL += $chng_withSL;
$grand_total_chng_4m += $chng_4m;
$grand_total_chng_5and6 += $chng_5and6;
$grand_total_chng_7and8 += $chng_7and8;
$grand_total_chng_9and10 += $chng_9and10;
$grand_total_chng_11 += $chng_11;
$grand_total_chng_12 += $chng_12;

$grand_total_chng_withSL1 = formatNumber($grand_total_chng_withSL);
$grand_total_chng_4m1 = formatNumber($grand_total_chng_4m);
$grand_total_chng_5and61 = formatNumber($grand_total_chng_5and6);
$grand_total_chng_7and81 = formatNumber($grand_total_chng_7and8);
$grand_total_chng_9and101 = formatNumber($grand_total_chng_9and10);
$grand_total_chng_111 = formatNumber($grand_total_chng_11);
$grand_total_chng_121 = formatNumber($grand_total_chng_12);

$get_loans_ntotal = $Operation->ctrGetLoansNtotal($branch_name, $month, $date);
foreach($get_loans_ntotal as $ntotal){
$ntotal_withSL = $ntotal['total_ntotal_sl'];
$ntotal_4m = $ntotal['total_ntotal_4m'];
$ntotal_5and6 = $ntotal['total_ntotal_5and6'];
$ntotal_7and8 = $ntotal['total_ntotal_7and8'];
$ntotal_9and10 = $ntotal['total_ntotal_9and10'];
$ntotal_11 = $ntotal['total_ntotal_11'];
$ntotal_12 = $ntotal['total_ntotal_12'];
}


$ntotal_withSL_format = formatNumber($ntotal_withSL);
$ntotal_4m_format = formatNumber($ntotal_4m);
$ntotal_5and6_format = formatNumber($ntotal_5and6);
$ntotal_7and8_format = formatNumber($ntotal_7and8);
$ntotal_9and10_format = formatNumber($ntotal_9and10);
$ntotal_11_format = formatNumber($ntotal_11);
$ntotal_12_format = formatNumber($ntotal_12);
// Get total Ntotal
$grand_total_ntotal_withSL1 += $ntotal_withSL;
$grand_total_ntotal_4m1 += $ntotal_4m;
$grand_total_ntotal_5and61 += $ntotal_5and6;
$grand_total_ntotal_7and81 += $ntotal_7and8;
$grand_total_ntotal_9and101 += $ntotal_9and10;
$grand_total_ntotal_111 += $ntotal_11;
$grand_total_ntotal_121 += $ntotal_12;

$grand_total_ntotal_withSL = formatNumber($grand_total_ntotal_withSL1);
$grand_total_ntotal_4m = formatNumber($grand_total_ntotal_4m1);
$grand_total_ntotal_5and6 = formatNumber($grand_total_ntotal_5and61);
$grand_total_ntotal_7and8 = formatNumber($grand_total_ntotal_7and81);
$grand_total_ntotal_9and10 = formatNumber($grand_total_ntotal_9and101);
$grand_total_ntotal_11 = formatNumber($grand_total_ntotal_111);
$grand_total_ntotal_12 = formatNumber($grand_total_ntotal_121);

$total_ssp = $SSP_withSL + $ssp_4m + $ssp_5and6 + $ssp_7and8 + $ssp_9and10 + $ssp_11 + $ssp_12;
$total_change = abs($chng_withSL) + abs($chng_4m) + abs($chng_5and6) + abs($chng_7and8) + abs($chng_9and10) + abs($chng_11)+ abs($chng_12);
$total_ntotal = $ntotal_withSL + $ntotal_4m + $ntotal_5and6 + $ntotal_7and8 + $ntotal_9and10 + $ntotal_11 + $ntotal_12;
if($total_change != 0){
$total_change1 = number_format((float)abs($total_change), 2, '.', ',');
}else{
$total_change1 = "-"; 
}

if($total_ntotal != 0){
$total_ntotal1 = number_format((float)abs($total_ntotal), 2, '.', ',');
}else{
$total_ntotal1 = "-"; 
}


$grand_total_ssp += $total_ssp;
$grand_total_sl +=$total_change;
$grand_total_lr += $total_ntotal;

$grand_total_sl1 = formatNumber($grand_total_sl);
$grand_total_lr1 = formatNumber($grand_total_lr);


$header .= <<<EOF
<tr>
<td style="width: 80px; text-align: left;">&nbsp;$new_branch_name</td>
    <td style="width:30px;">$ssp_11</td>
    <td style="width:75px;">($chng_11_format)</td>
    <td style="width:75px;">$ntotal_11_format</td>
    <td style="width:30px;">$ssp_12</td>
    <td style="width:75px;">($chng_12_format)</td>
    <td style="width:75px;">$ntotal_12_format</td>
    <td style="width:30px;">$total_ssp</td>
    <td style="width:75px;">($total_change1)</td>
    <td style="width:75px;">$total_ntotal1</td>
</tr>
EOF;

}
$header .= <<<EOF
</tbody>
</table>
    <table>
        <tr>
            <th style="border:none; text-align:left; width: 220px;">PREPARED BY:</th>
            <th style="border:none; text-align:left; width: 250px;"></th>
            <th style="border:none; text-align:left;">NOTED BY:</th>
        </tr>
        <tr style="font-weight: bold;">
            <td style="border:none; text-align:left;">$preBy</td>
            <td style="border:none; text-align:left;">JOEY DURAN</td>
            <td style="border:none; text-align:left;">DONALD M. JAMERO</td>
        </tr>
        <tr style="">
            <td style="border:none; text-align:left;"></td>
            <td style="border:none; text-align:left;">SALES OPERATIONS COORDINATOR HEAD</td>
            <td style="border:none; text-align:left;">COO</td>
          </tr>
    </table>
EOF;

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
