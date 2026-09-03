<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/pastdue.controller.php";
require_once "../../../models/pastdue.model.php";
require_once('tcpdf_include.php');
$reportID= (new Connection)->connect()->query("SELECT * from report_logs ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
if(empty($reportID)){
$id = 0;
}else{
$id = $reportID['id'];
}

$last_id = $id + 1;

$print_id = "PR" . str_repeat("0",5-strlen($last_id)).$last_id;     
$report_type = "SUMMARY OF BAD ACCOUNTS";
global $print_id;


$pastdue = new ControllerPastdue();
$pastdue->ctrAddReportSequence($print_id, $report_type);

class MYPDF extends TCPDF { 
    public function Footer() {
        date_default_timezone_set('Asia/Manila');
        $currentTimestamp = time();
        $formattedDateTime = date("Y-m-d H:i:s", $currentTimestamp);
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Add a full line
        $this->SetTextColor(128, 128, 128); // Grey color
        $this->Line($this->getMargins()['left'], $this->GetY(), $this->getPageWidth() - $this->getMargins()['right'], $this->GetY());
        // System generated report text
        $this->Cell(0, 2, 'This is a system generated report.', 0, false, 'L', 0, '', 1, false, 'T', 'M');
        // Move to the next line
        $this->Ln();
        // Transaction Number text
        $this->Cell(0, 2, 'Transaction #: '.$GLOBALS['print_id'], 0, false, 'L', 0, '', 1, false, 'T', 'M');
        $this->Ln();
        // Current date and time
        $this->Cell(0, 2, $formattedDateTime, 0, false, 'L', 0, '', 1, false, 'T', 'M');
        // Move to the left side
        $this->SetX($this->getMargins()['left']);
    }
    
}





//SELECT SUM(balance) AS total_balance FROM past_due WHERE branch_name = "EMB MAIN BRANCH" AND balance != 0 AND type ="S" AND class = "D";
class printClientList{

    public $ref_id; 
    public function getClientsPrinting(){

        $preparedBy = $_GET['preparedBy'];
        $checkedBy = $_GET['checkedBy'];
        $notedBy = $_GET['notedBy']; 

        $f1 = $_GET['f1'];
        $amount1 = $_GET['amount1'];
        $f2 = $_GET['f2'];
        $amount2 = $_GET['amount2'];
        $f3 = $_GET['f3'];
        $amount3 = $_GET['amount3'];
        $f4 = $_GET['f4'];
        $amount4 = $_GET['amount4'];
        $f5 = $_GET['f5'];
        $amount5 = $_GET['amount5'];
        $f6 = $_GET['f6'];
        $amount6 = $_GET['amount6'];
        $f7 = $_GET['f7'];
        $amount7 = $_GET['amount7'];
        $ftotal = $_GET['ftotal'];
        $totalamount = $_GET['totalamount'];
        $ftitle = $_GET['ftitle'];
       
    

        $dateFrom = $_GET['dateFrom']; 
        $dateFromMonth = date('Y-m-t', strtotime($dateFrom));
        $dateStarts = date('Y-m', strtotime($dateFrom));
        $dateStart = $dateStarts.'-01';
       
        $branch_name_input = $_GET['branch_name_input']; 

        if ($branch_name_input === 'FCHN') {
          $data = (new ControllerPastdue)->ctrPastDueSummaryFCHNegros($branch_name_input,$dateFromMonth,$dateStart);
      } elseif ($branch_name_input === 'FCHM') {
          $data = (new ControllerPastdue)->ctrPastDueSummaryFCHManila($branch_name_input, $dateFromMonth,$dateStart );
        } elseif ($branch_name_input === 'FCHA') {
          $data = (new ControllerPastdue)->ctrPastDueSummaryFCHAntipolo($branch_name_input, $dateFromMonth,$dateStart );
      } else{
        $data = (new ControllerPastdue)->ctrBadAccounts($branch_name_input,$dateFromMonth,$dateStart);
      } 


      if($branch_name_input === "EMB"){
        $tilteHead = "EMB CAPITAL LENDING CORPORATION";
      }elseif($branch_name_input === "FCHN"){
        $tilteHead = "FCH FINANCE CORPORATION - NEGROS";
      }elseif($branch_name_input === "FCHM"){
        $tilteHead = "FCH FINANCE CORPORATION - MANILA";
      }elseif($branch_name_input === "FCHA"){
        $tilteHead = "FCH FINANCE CORPORATION - ANTIPOLO";
      }elseif($branch_name_input === "RLC"){
        $tilteHead = "RAMSGATE LENDING CORPORATION";
      }elseif($branch_name_input === "ELC"){
        $tilteHead = "EVERYDAY LENDING CORPORATION";
      }

    $dateObject = new DateTime($dateFrom);
    $month = $dateObject->format('F'); 
    $month2 = strtoupper($month);
    $year = $dateObject->format('Y');

   // $branch_name_input = $_REQUEST['branch_name_input'];

    $connection = new connection;
    $connection->connect();

  require_once('tcpdf_include.php');


  $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetMargins(3,3);
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



$header = <<<EOF
<style>
table, tr,td{
    font-size:8rem;
}

</style>


<table>

 <tr>
    <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">$tilteHead</td>
 </tr>

 
 <tr>
    <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">SUMMARY OF BAD ACCOUNTS</td>
 </tr>

 <tr>
 <td colspan="17" style="text-align:center;font-weight:bold;font-size:9rem;">AS OF $month2 $year</td>
</tr>

<tr>
<td colspan="17"></td>
</tr>

<tr>
<td colspan="17"></td>
</tr>


<tr>
<td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="width:72px;"></td>
    <td style="border:1px solid black;width:100px;text-align:center;">TOTAL</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="width:27px;"></td>
    <td style="border:1px solid blakc;width:92px;text-align:center;">TOTAL POLICE</td>
    <td></td>
    <td style="width:28px;"></td>
    <td style="width:1px;"></td>
    <td style="border:1px solid black;width:105px;text-align:center;">TOTAL</td>
</tr>

<tr>
    <td style="border:1px solid black;width:100px;text-align:center;">PARTICULAR</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:95px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E.</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:100px;text-align:center;">DECEASED</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E</td>
    <td style="border:1px solid black;width:90px;text-align:center;">Amount</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:92px;text-align:center;">ACTION</td>
    <td style="border:1px solid black;width:30px;text-align:center;">S</td>
    <td style="border:1px solid black;width:30px;text-align:center;">E</td>
    <td style="border:1px solid black;width:30px;text-align:center;">No.</td>
    <td style="border:1px solid black;width:105px;text-align:center;">PAST DUE</td>
</tr>

</table>

EOF;
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

      //$total_S_Decease = $item1['total_S_type'];
     

      //$total_E_Decease = $item1['total_E_type'];
     
      //total of e and s for deceased for each branch
      
      //Grand total of e and s deceased for all the branches 
      $grandtotalNumberES_Deceased += $totalOf_E_S_Deceased;


     
      
      $info2 = (new ControllerPastdue)->ctrTotalOfAmountDecease_S($branch_name_inputs,$dateFromMonth,$dateStart);
      $total_amount =  $info2[0];
      $total_Decease_S = $info2[1];
      $grandtotal_S_Deceased += $total_Decease_S;

      //$grandtotal_S_Deceased += $total_Decease_S;

      //final total amount of s for deceased
      $finalTotalAmountOfS_Deceased += $total_amount;
      $formatted_finalTotalAmountOfS_Deceased = number_format($finalTotalAmountOfS_Deceased, 2, '.', ',');
      $total_amount_formatted2 = number_format($total_amount, 2, '.',',');


      $info3 = (new ControllerPastdue)->ctrTotalOfAmountDecease_E($branch_name_inputs,$dateFromMonth,$dateStart);
      $total_amount3 =  $info3[0];
      $total_Decease_E = $info3[1];
      $grandtotal_E_Deceased += $total_Decease_E;

      //final total amount of e for deceased 
      $finalTotalAmountOfE_Deceased += $total_amount3;
      $formatted_finalTotalAmountOfE_Deceased = number_format($finalTotalAmountOfE_Deceased, 2, '.',',');
      $total_amount_formatted3 = number_format($total_amount3, 2, '.',',');

      //total amount of deceased
      $grandTotalDeceasedAmountNotformatted = $total_amount + $total_amount3;
      $grandTotalDeceasedAmount = number_format($total_amount + $total_amount3, 2, '.', ',');

      $totalOf_E_S_Deceased = $total_Decease_S + $total_Decease_E;
     
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

      $header .= <<<EOF

      <table>
      <tr>
      <td style="border:1px solid black;width:100px;text-align:left;">$branch_name_inputs</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_Decease_S</td>
      <td style="border:1px solid black;width:95px;text-align:center;">$total_amount_formatted2</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_Decease_E</td>
      <td style="border:1px solid black;width:90px;text-align:center;">$total_amount_formatted3</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$totalOf_E_S_Deceased</td>
      <td style="border:1px solid black;width:100px;text-align:center;">$grandTotalDeceasedAmount</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_S_Police</td>
      <td style="border:1px solid black;width:90px;text-align:center;">$formatted_Police_Amount</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_E_Police</td>
      <td style="border:1px solid black;width:90px;text-align:center;">$formatted_Police_AmountTypeE</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_ES_Police</td>
      <td style="border:1px solid black;width:92px;text-align:center;">$totalAmountPolice_ES</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_S_OfDP</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$total_E_OfDP</td>
      <td style="border:1px solid black;width:30px;text-align:center;">$FinalTotal_ES_DP</td>
      <td style="border:1px solid black;width:105px;text-align:center;">$FinalTotalDeceased_Police</td>
      </tr>
      
      
      
      </table>
      
      
      
      EOF; 

      
    
  }






 

$ES = $grandtotal_S_Deceased + $grandtotal_E_Deceased;

$header .= <<<EOF


<table>
<tr>

<td style="border:1px solid black;width:100px;text-align:center;font-weight:bold;">Total</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$grandtotal_S_Deceased</td>
<td style="border:1px solid black;width:95px;text-align:center;font-weight:bold;">$formatted_finalTotalAmountOfS_Deceased</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$grandtotal_E_Deceased</td>
<td style="border:1px solid black;width:90px;text-align:center;font-weight:bold;">$formatted_finalTotalAmountOfE_Deceased</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$ES</td>
<td style="border:1px solid black;width:100px;text-align:center;font-weight:bold;">$finalTotal_ES_Deceased</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$FinalTotal_S_Police</td>
<td style="border:1px solid black;width:90px;text-align:center;font-weight:bold;">$formatted_FinalTotalAmount_S_Police</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$finalTotal_E_Police</td>
<td style="border:1px solid black;width:90px;text-align:center;font-weight:bold;">$formatted_FinalTotalAmount_E_Police</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$grandTotal_ES_Police</td>
<td style="border:1px solid black;width:92px;text-align:center;font-weight:bold;">$formatted_TotalAmount_ES_Police</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$TotalOF_S</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$TotalOF_E</td>
<td style="border:1px solid black;width:30px;text-align:center;font-weight:bold;">$grandTotalES_PD</td>
<td style="border:1px solid black;width:105px;text-align:center;font-weight:bold;">$formatted_FinalTotal_PastDue</td>




</tr>


<tr>
<td colspan="17"></td>
</tr>

<tr>
<td colspan="17"></td>
</tr>







<tr>
<td colspan="11" style="font-weight:bold;">Note: Classified as S-17 months below and E-17 months above collected before endorse to PDR</td>
<td colspan="1"></td>

EOF;


if ($f1 != "" || $amount1 != "" || $f2 != "" || $amount2 != "" || $f3 != "" || $amount3 != "" || $f4 != "" || $amount4 != "" || $f5 != "" || $amount5 != "" || $f6 != "" || $amount6 != "" || $f7 != "" || $amount7 != "" || $totalamount != "") {
    $header .= '<td colspan="5" rowspan="15"><br>
    <span style="font-size:8.5rem;line-height:1.5;"><span style="font-weight:bold;">'.$ftitle.'</span><br>'.$f1.' <span style="color:white;">12345678912345</span>  '.$amount1.'<br>'.$f2.' <span style="color:white;">12345678912345</span> '.$amount2.'<br>'.$f3.' <span style="color:white;">12345678912345</span> '.$amount3.'<br>'.$f4.' <span style="color:white;">12345678912345</span> '.$amount4.'<br>'.$f5.' <span style="color:white;">12345678912345</span> '.$amount5.'<br>'.$f6.'<span style="color:white;">12345678912345d</span>'.$amount6.'<br>'.$f7.' <span style="color:white;">12345678912345</span> '.$amount7.'<hr style="width:61%;"><span style="font-weight:bold;">'.$ftotal.'<span style="color:white;">123456789123</span>'.$totalamount.'</span> </span>
    </td>';
}


$header .= <<<EOF

</tr>

<tr>
<td colspan="17"></td>
</tr>

<tr>
<td colspan="17"></td>

</tr>


<tr>
EOF;


if ($preparedBy != "") {
    $header .= '<td colspan="3">Prepared by:</td>';
}
if ($checkedBy != "") {
    $header .= '<td colspan="4">Checked by:</td>';
}
if ($notedBy != "") {
    $header .= '<td colspan="3">Noted by: </td>';
}
$header .= <<<EOF
</tr>


<tr>
<td colspan="17"></td>
</tr>


<tr>
EOF;

if ($preparedBy != "") {
    $header .= '<td colspan="3" style="font-weight:bold;">'.$preparedBy.'</td>';
}
if ($checkedBy != "") {
    $header .= '<td colspan="4" style="font-weight:bold;">'.$checkedBy.'</td>';
}
if ($notedBy != "") {
    $header .= '<td colspan="3" style="font-weight:bold;">'.$notedBy.'<br><span style="font-weight:none;">Comptroller</span></td>';
}
$header .= <<<EOF
</tr>


<tr>
<td colspan="17"></td>
</tr>

<tr>
<td colspan="17"> </td>
</tr>

</table>

EOF;
    

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports.pdf', 'I');
    }
}

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>






