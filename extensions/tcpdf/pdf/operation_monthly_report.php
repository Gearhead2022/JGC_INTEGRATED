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
  $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false);  /*remove line on top of the page*/

  // set document information


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// Remove footer line and page number
$pdf->setFooterData(array(0,0,0), array(0,0,0));

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10,10);
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

$reportName = "PDR Performance Summary.pdf";

$Operation = new ControllerOperation();


$month = $_GET['month'];

$slcMonth =  strtoupper(date("F Y", strtotime($month)));
$slcYear =  strtoupper(date("Y", strtotime($month)));
// $formatted_to = date("m/d/Y", strtotime($to));

$firstDay = $month . "-01";
$lastDay = date("Y-m-t", strtotime($month));


// $formatted_prev = date("m/d/Y", strtotime($prev));
// $combDate =  strtoupper(date("F d", strtotime($from)) . " - " . date("d", strtotime($to)));

  
$header = <<<EOF

        <style>
             tr,th{
            border:1px solid black;
            font-size:8rem;
            text-align:center;
        }
             tr, td{
            border:1px solid black;
            font-size:9.0rem;
            text-align:center;
        }
        </style>
        <h4> GROSS IN AND OUT <br> FOR THE MONTH OF $slcMonth</h4>
        <table>
            <thead>
            <tr>
                <th  style= "text-align: center; vertical-align: middle; font-size:9.2rem; margin-top: 20px; width: 105px;font-weight:bold;" rowspan="2"><span style="color:white;">d</span>EMB BRANCH</th>
                <th colspan="3" style="font-size:8.2rem; width: 240px; ">$slcYear</th>
            </tr>
            <tr style="background-color:#A4ACB1;">
                <th style="width: 80px;font-size:7.9rem;"> GROSS IN</th>
                <th style="width: 80px;">GROSS OUT</th>
                <th style="width: 80px;">NET</th>
            </tr>
        </thead>
        <tbody>
        EOF;
        $grand_totalGrossin = 0;
        $grand_totalGrossout = 0;
        $grand_totalNet = 0;
        $grand_grand_totalGrossin = 0;
        $grand_grand_totalGrossout = 0;
        $grand_grand_totalNet = 0;
    $getEMB = $Operation ->ctrGetAllEMBBranches();
    foreach ($getEMB as $emb) { 
        $branch_name = $emb['full_name'];
        $type = "grossin";
        $getGrossinData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
        if(!empty($getGrossinData)){
            foreach($getGrossinData as $grossin){
                $grossin_total = $grossin['total_cumi']; 
            }
        }else{
        $grossin_total = 0;
        }

        $getGrossoutData = $Operation->ctrGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay);
        if(!empty($getGrossoutData)){
            foreach($getGrossoutData as $grossout){
                $grossout_total = $grossout['total_cumi']; 
            }
        }else{
            $grossout_total = 0;
        }
        $total_net = $grossin_total - $grossout_total;

        if($total_net < 0){
            $new_net = abs($total_net);
            $new_net = "($new_net)";
            $color = "color:#6e7375;";
        }else{
            $new_net = $total_net;
            $color = "";
        }

        $grand_totalGrossin += $grossin_total;
        $grand_totalGrossout += $grossout_total;
        $grand_totalNet += $total_net;
        $new_branch_name = str_replace("EMB", "", $branch_name);
        $header .= <<<EOF
            <tr>
                <td style="width: 105px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
                <td style="width: 80px;">$grossin_total</td>
                <td style="width: 80px;">$grossout_total</td>
                <td style="width: 80px; $color">$new_net</td>
            </tr>
        EOF;
}       
        if($grand_totalNet <0){
            $fina_totalNet = abs($grand_totalNet);
            $fina_totalNet = "($fina_totalNet)";
            $color1 = "color:#6e7375;";
        }else{
            $fina_totalNet =$grand_totalNet;
            $color1 = "";
        }
        $grand_grand_totalGrossin += $grand_totalGrossin;
        $grand_grand_totalGrossout += $grand_totalGrossout;
        $grand_grand_totalNet += $grand_totalNet;
      
$header .= <<<EOF
            <tr>
                <td style="width: 105px; text-align: left;font-weight:bold;">&nbsp;&nbsp;TOTAL</td>
                <td style="width: 80px; font-weight:bold;">$grand_totalGrossin</td>
                <td style="width: 80px; font-weight:bold;">$grand_totalGrossout</td>
                <td style="width: 80px; font-weight:bold; $color1">$fina_totalNet</td>
            </tr>
            <tr>
                <td style="text-align: left; border:none; font-size:9.2rem;font-weight:bold;" colspan="3" ><span style="color: white;">p</span><br>FCH BRANCHES</td>
            </tr>
EOF;
            $grand_totalGrossin = 0;
            $grand_totalGrossout = 0;
            $grand_totalNet = 0;
            $getFCH = $Operation ->ctrGetAllFCHBranches();
            foreach ($getFCH as $fch) { 
            $branch_name = $fch['full_name'];
            $type = "grossin";
            $getGrossinData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossinData)){
                foreach($getGrossinData as $grossin){
                    $grossin_total = $grossin['total_cumi']; 
                }
            }else{
            $grossin_total = 0;
            }

            $getGrossoutData = $Operation->ctrGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossoutData)){
                foreach($getGrossoutData as $grossout){
                    $grossout_total = $grossout['total_cumi']; 
                }
            }else{
                $grossout_total = 0;
            }
            $total_net = $grossin_total - $grossout_total;

            if($total_net < 0){
                $new_net = abs($total_net);
                $new_net = "($new_net)";
                $color = "color:#6e7375;";
            }else{
                $new_net = $total_net;
                $color = "";
            }

            $grand_totalGrossin += $grossin_total;
            $grand_totalGrossout += $grossout_total;
            $grand_totalNet += $total_net;
            $new_branch_name = str_replace("FCH", "", $branch_name);
            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
                    <td style="width: 80px;">$grossin_total</td>
                    <td style="width: 80px;">$grossout_total</td>
                    <td style="width: 80px;$color">$new_net</td>
                </tr>
            EOF;
            }       
            if($grand_totalNet <0){
                $fina_totalNet = abs($grand_totalNet);
                $fina_totalNet = "($fina_totalNet)";
                $color1 = "color:#6e7375;";
            }else{
                $fina_totalNet =$grand_totalNet;
                $color1 = "";
            }
            $grand_grand_totalGrossin += $grand_totalGrossin;
            $grand_grand_totalGrossout += $grand_totalGrossout;
            $grand_grand_totalNet += $grand_totalNet;

            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;font-weight:bold;">&nbsp;&nbsp;TOTAL</td>
                    <td style="width: 80px; font-weight:bold;">$grand_totalGrossin</td>
                    <td style="width: 80px; font-weight:bold;">$grand_totalGrossout</td>
                    <td style="width: 80px; font-weight:bold; $color1">$fina_totalNet</td>
                </tr>
                <tr>
                    <td style="text-align: left; border:none;font-size:9.2rem;font-weight:bold;" colspan="3" ><span style="color: white;">p</span><br>RLC BRANCHES</td>
                </tr>
            EOF;

            $grand_totalGrossin = 0;
            $grand_totalGrossout = 0;
            $grand_totalNet = 0;
            $getRLC = $Operation ->ctrGetAllRLCBranches();
            foreach ($getRLC as $rlc) { 
            $branch_name = $rlc['full_name'];
            $type = "grossin";
            $getGrossinData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossinData)){
                foreach($getGrossinData as $grossin){
                    $grossin_total = $grossin['total_cumi']; 
                }
            }else{
            $grossin_total = 0;
            }

            $getGrossoutData = $Operation->ctrGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossoutData)){
                foreach($getGrossoutData as $grossout){
                    $grossout_total = $grossout['total_cumi']; 
                }
            }else{
                $grossout_total = 0;
            }
            $total_net = $grossin_total - $grossout_total;

            if($total_net < 0){
                $new_net = abs($total_net);
                $new_net = "($new_net)";
                $color = "color:#6e7375;";
            }else{
                $new_net = $total_net;
                $color = "";
            }

            $grand_totalGrossin += $grossin_total;
            $grand_totalGrossout += $grossout_total;
            $grand_totalNet += $total_net;
            $new_branch_name = str_replace("RLC", "", $branch_name);
            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
                    <td style="width: 80px;">$grossin_total</td>
                    <td style="width: 80px;">$grossout_total</td>
                    <td style="width: 80px; $color">$new_net</td>
                </tr>
            EOF;
            }       
            if($grand_totalNet <0){
                $fina_totalNet = abs($grand_totalNet);
                $fina_totalNet = "($fina_totalNet)";
                $color1 = "color:#6e7375;";
            }else{
                $fina_totalNet =$grand_totalNet;
                $color1 = "";
            }
            $grand_grand_totalGrossin += $grand_totalGrossin;
            $grand_grand_totalGrossout += $grand_totalGrossout;
            $grand_grand_totalNet += $grand_totalNet;

            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;font-weight:bold;">&nbsp;&nbsp;TOTAL</td>
                    <td style="width: 80px; font-weight:bold;">$grand_totalGrossin</td>
                    <td style="width: 80px; font-weight:bold;">$grand_totalGrossout</td>
                    <td style="width: 80px; font-weight:bold; $color1">$fina_totalNet</td>
                </tr>
                <tr>
                    <td style="text-align: left; border:none;font-size:9.2rem;font-weight:bold;" colspan="3" ><span style="color: white;">p</span><br>ELC</td>
                </tr>
            EOF;
            $grand_totalGrossin = 0;
            $grand_totalGrossout = 0;
            $grand_totalNet = 0;
            $getELC= $Operation ->ctrGetAllELCBranches();
            foreach ($getELC as $elc) { 
            $branch_name = $elc['full_name'];
            $type = "grossin";
            $getGrossinData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossinData)){
                foreach($getGrossinData as $grossin){
                    $grossin_total = $grossin['total_cumi']; 
                }
            }else{
            $grossin_total = 0;
            }

            $getGrossoutData = $Operation->ctrGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay);
            if(!empty($getGrossoutData)){
                foreach($getGrossoutData as $grossout){
                    $grossout_total = $grossout['total_cumi']; 
                }
            }else{
                $grossout_total = 0;
            }
            $total_net = $grossin_total - $grossout_total;

            if($total_net < 0){
                $new_net = abs($total_net);
                $new_net = "($new_net)";
                $color = "color:#6e7375;";
            }else{
                $new_net = $total_net;
                $color = "";
            }

            $grand_totalGrossin += $grossin_total;
            $grand_totalGrossout += $grossout_total;
            $grand_totalNet += $total_net;
            $new_branch_name = str_replace("EMB", "", $branch_name);
            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;">&nbsp;&nbsp;$new_branch_name</td>
                    <td style="width: 80px;">$grossin_total</td>
                    <td style="width: 80px;">$grossout_total</td>
                    <td style="width: 80px; $color">$new_net</td>
                </tr>
            EOF;
            } 
            
            
            if($grand_totalNet <0){
                $fina_totalNet = abs($grand_totalNet);
                $fina_totalNet = "($fina_totalNet)";
          
            }else{
                $fina_totalNet =$grand_totalNet;
            }
            $grand_grand_totalGrossin += $grand_totalGrossin;
            $grand_grand_totalGrossout += $grand_totalGrossout;
            $grand_grand_totalNet += $grand_totalNet;
            if($grand_grand_totalNet < 0 ){
                $final_grandTotal_net = abs($grand_grand_totalNet);
                $final_grandTotal_net = "($final_grandTotal_net)";
                $color2 = "color:#6e7375;";
            }else{
                $final_grandTotal_net = $grand_grand_totalNet;
                $color2="";
            }

            $header .= <<<EOF
                <tr>
                    <td style="width: 105px; text-align: left;font-weight:bold;">&nbsp;&nbsp;GRAND TOTAL</td>
                    <td style="width: 80px; font-weight:bold;">$grand_grand_totalGrossin</td>
                    <td style="width: 80px; font-weight:bold;">$grand_grand_totalGrossout</td>
                    <td style="width: 80px; font-weight:bold; $color2">$final_grandTotal_net</td>
                </tr>
            </tbody>
            </table>
            EOF;

            
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output($reportName, 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
