<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/ticket.controller.php";
require_once "../../../models/ticket.model.php";

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
$pdf->SetMargins(8,8);
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


$Ticket = new ControllerTicket();

$tFrom = $_GET['tFrom'];
$tTo = $_GET['tTo'];
$tPreby = $_GET['tPreby'];
$branch_name = $_GET['branch_name'];
$tPreby = strtoupper($tPreby);



$startDate = new DateTime($tFrom);
$endDate = new DateTime($tTo);

$currentDate = clone $startDate;
$formatDate = date("F d, Y", strtotime($tTo));
$yearFormat = date("Y", strtotime($tTo));
$date = date('Y-m', strtotime($tFrom));
$month = date('F', strtotime($tFrom));
$dateRange = array();

$startFormatted = $startDate->format('F j');
$endFormatted = $endDate->format('j, Y');
$combinedDates1 = $startFormatted . '-' . $endFormatted;
while ($currentDate <= $endDate) {
    $dateRange[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
 }

$reportName = "".$branch_name. " Existing Accounts Ticket Monitoring for " .$formatDate.  ".pdf";
// $formatted_to = date("m/d/Y", strtotime($to));

// $prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));

// $formatted_prev = date("m/d/Y", strtotime($prev));
// $combDate =  strtoupper(date("F d", strtotime($from)) . " - " . date("d", strtotime($to)));

$header = <<<EOF
    <style>
        tr,th{
            border:1px solid black;
            font-size:8.5rem;
            text-align:center;
        }
        tr, td{
            border:1px solid black;
            font-size:8.5rem;
            text-align:center;
        }
    </style>
    <h4>GRAND PAMASKO PROMO $yearFormat <br>MONITORING</h4>
    <table>
                <tr>
                    <th rowspan = "2" style="width: 120px;"><span style="color: white;">dawd</span><br>BRANCH NAME</th>
                    <th rowspan = "2"><span style="color: white;">dawd</span><br>DATE</th>
                    <th colspan = "12" style="width: 720px;">EXISTING ACCOUNTS</th>
                    <th rowspan = "2"><span style="color: white;">dawd</span><br>TOTAL</th>
                </tr>
                <tr>
                    <td style="width: 60px;">1 MO. RENEW</td>
                    <td style="width: 60px;">2 MOS.</td>
                    <td style="width: 60px;">3 MOS.</td>
                    <td style="width: 60px;">4 MOS.</td>
                    <td style="width: 60px;">5 MOS.</td>
                    <td style="width: 60px;">6 MOS.</td>
                    <td style="width: 60px;">7 MOS.</td>
                    <td style="width: 60px;">8 MOS.</td>
                    <td style="width: 60px;">9 MOS.</td>
                    <td style="width: 60px;">10 MOS.</td>
                    <td style="width: 60px;">11 MOS.</td>
                    <td style="width: 60px;">12 MOS.</td>
                </tr>
EOF;
        for ($i=0; $i < count($dateRange); $i++) { 
            $rDate = $dateRange[$i];
            $fDate = date('m-d-Y', strtotime($rDate));
            $getRenew = $Ticket->ctrGetRenew($rDate, $branch_name);
            $newBranch_name = str_replace('EMB', '', $branch_name);
            foreach($getRenew as $renew){
                $one_month = $renew['total_one_month'];
                $two_month = $renew['total_two_month'];
                $three_month = $renew['total_three_month'];
                $four_month = $renew['total_four_month'];
                $five_month = $renew['total_five_month'];
                $six_month = $renew['total_six_month'];
                $seven_month = $renew['total_seven_month'];
                $eight_month = $renew['total_eight_month'];
                $sham_month = $renew['total_sham_month'];
                $ten_month = $renew['total_ten_month'];
                $eleven_month = $renew['total_eleven_month'];
                $twelve_month = $renew['total_twelve_month'];
            }
          
            $total = $one_month + $two_month + $three_month + $four_month + $five_month 
            + $six_month + $seven_month + $eight_month + $sham_month + $ten_month + $eleven_month + $twelve_month;
            # code...
            if($total == 0){
                $total = "";
            }
          
    $header .= <<<EOF
        <tr>
                <td style="text-align:left;"> $newBranch_name</td>
                <td>$fDate</td>
                <td>$one_month</td>
                <td>$two_month</td>
                <td>$three_month</td>
                <td>$four_month</td>
                <td>$five_month</td>
                <td>$six_month</td>
                <td>$seven_month</td>
                <td>$eight_month</td>
                <td>$sham_month</td>
                <td>$ten_month</td>
                <td>$eleven_month</td>
                <td>$twelve_month</td>
                <td>$total</td>
        </tr>
EOF;
        }
    $header .=<<<EOF
                  <tr>
                    <th style="text-align: left; border:none;"></th>
                </tr>
                <tr>
                    <th style="text-align: left; border:none;">Prepared By:</th>
                </tr>
                <tr>
                     <td style="text-align: left; border:none;">$tPreby</td>
                 </tr>
            </table>
EOF;

$pdf->writeHTML($header, false, false, false, false, '');
$pdf->Output($reportName, 'I');
}



public function getPrintNewAccount(){

    
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
  $pdf->SetMargins(8,8);
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
  
 
  
  $Ticket = new ControllerTicket();
  
  $tFrom = $_GET['tFrom'];
  $tTo = $_GET['tTo'];
  $tPreby = $_GET['tPreby'];
  $branch_name = $_GET['branch_name'];
  $tPreby = strtoupper($tPreby);
  
  
  
  $startDate = new DateTime($tFrom);
  $endDate = new DateTime($tTo);
  
  $currentDate = clone $startDate;
  
  $date = date('Y-m', strtotime($tFrom));
  $month = date('F', strtotime($tFrom));
  $dateRange = array();
  $formatDate = date("F d, Y", strtotime($tTo));
  $yearFormat = date("Y", strtotime($tTo));
  $startFormatted = $startDate->format('F j');
  $endFormatted = $endDate->format('j, Y');
  $combinedDates1 = $startFormatted . '-' . $endFormatted;
  while ($currentDate <= $endDate) {
      $dateRange[] = $currentDate->format('Y-m-d');
      $currentDate->modify('+1 day');
   }
  $reportName = "".$branch_name. " New Accounts Ticket Monitoring for " .$formatDate.  ".pdf";
  
  // $formatted_to = date("m/d/Y", strtotime($to));
  
  // $prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));
  
  // $formatted_prev = date("m/d/Y", strtotime($prev));
  // $combDate =  strtoupper(date("F d", strtotime($from)) . " - " . date("d", strtotime($to)));
  
  $header = <<<EOF
      <style>
          tr,th{
              border:1px solid black;
              font-size:8.5rem;
              text-align:center;
          }
          tr, td{
              border:1px solid black;
              font-size:8.5rem;
              text-align:center;
          }
      </style>
      <h4>GRAND PAMASKO PROMO $yearFormat  <br>MONITORING</h4>
      <table>
                  <tr>
                      <th rowspan = "2" style="width: 120px;"><span style="color: white;">dawd</span><br>BRANCH NAME</th>
                      <th rowspan = "2"><span style="color: white;">dawd</span><br>DATE</th>
                      <th colspan = "11" style="width: 660px;">NEW ACCOUNTS</th>
                      <th rowspan = "2"><span style="color: white;">dawd</span><br>TOTAL</th>
                  </tr>
                  <tr>
                      <td style="width: 60px;">6-12 MOS</td>
                      <td style="width: 60px;">12+1</td>
                      <td style="width: 60px;">12+2</td>
                      <td style="width: 60px;">12+3</td>
                      <td style="width: 60px;">12+4</td>
                      <td style="width: 60px;">12+5</td>
                      <td style="width: 60px;">12+6</td>
                      <td style="width: 60px;">12+7</td>
                      <td style="width: 60px;">12+8</td>
                      <td style="width: 60px;">12+9</td>
                      <td style="width: 60px;">12+10</td>
                  </tr>
EOF;
          for ($i=0; $i < count($dateRange); $i++) { 
              $rDate = $dateRange[$i];
              $fDate = date('m-d-Y', strtotime($rDate));
              $getRenew = $Ticket->ctrGetNewRenew($rDate, $branch_name);
              $newBranch_name = str_replace('EMB', '', $branch_name);
              foreach($getRenew as $renew){
                  $one_month = $renew['total_one_month'];
                  $two_month = $renew['total_two_month'];
                  $three_month = $renew['total_three_month'];
                  $four_month = $renew['total_four_month'];
                  $five_month = $renew['total_five_month'];
                  $six_month = $renew['total_six_month'];
                  $seven_month = $renew['total_seven_month'];
                  $eight_month = $renew['total_eight_month'];
                  $sham_month = $renew['total_sham_month'];
                  $ten_month = $renew['total_ten_month'];
                  $eleven_month = $renew['total_eleven_month'];
                 
              }
            
              $total = $one_month + $two_month + $three_month + $four_month + $five_month 
              + $six_month + $seven_month + $eight_month + $sham_month + $ten_month + $eleven_month;
              # code...
              if($total == 0){
                  $total = "";
              }

              if($one_month == 0 && $two_month == 0 && $three_month == 0 && $four_month == 0 && $five_month == 0 && $six_month == 0 && $seven_month == 0
              && $eight_month == 0 && $sham_month == 0 && $ten_month == 0 && $eleven_month == 0){
              $one_month = ($one_month == 0) ? "" : $one_month;
              $two_month = ($two_month == 0) ? "" : $two_month;
              $three_month = ($three_month == 0) ? "" : $three_month;
              $four_month = ($four_month == 0) ? "" : $four_month;
              $five_month = ($five_month == 0) ? "" : $five_month;
              $six_month = ($six_month == 0) ? "" : $six_month;
              $seven_month = ($seven_month == 0) ? "" : $seven_month;
              $eight_month = ($eight_month == 0) ? "" : $eight_month;
              $sham_month = ($sham_month == 0) ? "" : $sham_month;
              $ten_month = ($ten_month == 0) ? "" : $ten_month;
              $eleven_month = ($eleven_month == 0) ? "" : $eleven_month;
             
            }
      $header .= <<<EOF
          <tr>
                  <td style="text-align:left;"> $newBranch_name</td>
                  <td>$fDate</td>
                  <td>$one_month</td>
                  <td>$two_month</td>
                  <td>$three_month</td>
                  <td>$four_month</td>
                  <td>$five_month</td>
                  <td>$six_month</td>
                  <td>$seven_month</td>
                  <td>$eight_month</td>
                  <td>$sham_month</td>
                  <td>$ten_month</td>
                  <td>$eleven_month</td>
                  <td>$total</td>
          </tr>
EOF;
          }
      $header .=<<<EOF
                    <tr>
                      <th style="text-align: left; border:none;"></th>
                  </tr>
                  <tr>
                      <th style="text-align: left; border:none;">Prepared By:</th>
                  </tr>
                  <tr>
                       <td style="text-align: left; border:none;">$tPreby</td>
                   </tr>
              </table>
EOF;
  
  $pdf->writeHTML($header, false, false, false, false, '');
  $pdf->Output($reportName, 'I');
  }
  



}  

$tType = $_GET['tType'];

$clientsFormRequest = new printClientList();

if($tType == "E"){
    $clientsFormRequest -> getClientsPrinting();
}elseif($tType == "N"){
    $clientsFormRequest -> getPrintNewAccount();
}


?>
