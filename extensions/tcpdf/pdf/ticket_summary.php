<?php
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/ticket.controller.php";
require_once "../../../models/ticket.model.php";
$sType = $_GET['sType'];
class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    
  require_once('tcpdf_include.php');

//   $pdf = new TCPDF('L', PDF_UN IT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//   $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false);  /*remove line on top of the page*/

$pdf->setPrintFooter(false);  /*remove line on top of the page*/


  // set document information


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(7,7);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 0); // Remove the bottom margin


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

$dateTo = $_GET['dateTo'];
$sType = $_GET['sType'];
$sPreby = strtoupper($_GET['sPreby']);

$formatDate = date("F d, Y", strtotime($dateTo));
$yearFormat = date("Y", strtotime($dateTo));
$fDate = date("Y-m", strtotime($dateTo))."-01";
$fDateStart = date("Y-", strtotime($dateTo))."08-01";
$prev = date("Y-m-d", strtotime("-1 day", strtotime($dateTo)));

// $formatted_to = date("m/d/Y", strtotime($to));

$reportName = "Existing Accounts Ticket Daily Summary for " .$formatDate.  ".pdf";

// $formatted_prev = date("m/d/Y", strtotime($prev));
$combDate = date("M d", strtotime($prev));

$header = <<<EOF
    <style>
        tr,th{
            border:1px solid black;
            font-size:7.1rem;
            text-align:center;
        }
        tr, td{
            border:1px solid black;
            font-size:7.1rem;
            text-align:center;
        }
    </style>
    <h5>GRAND PAMASKO PROMO $yearFormat <br>DAILY MONITORING <br><span>$formatDate </span></h5>
    <table>
                <tr>
                    <th rowspan = "2" style="width: 120px;"><span style="color: white;">dawd</span><br>BRANCH NAME</th>
                    <th colspan = "13" style="width: 754px;">EXISTING ACCOUNTS</th>
                    <th rowspan = "2"><span style="color: white;">dawd</span><br>TOTAL</th>
                    <th rowspan = "2">GRAND TOTAL</th>
                </tr>
                <tr>
                    <td style="width: 58px;">as of $combDate</td>
                    <td style="width: 58px;">1 MO. RENEW</td>
                    <td style="width: 58px;">2 MOS.</td>
                    <td style="width: 58px;">3 MOS.</td>
                    <td style="width: 58px;">4 MOS.</td>
                    <td style="width: 58px;">5 MOS.</td>
                    <td style="width: 58px;">6 MOS.</td>
                    <td style="width: 58px;">7 MOS.</td>
                    <td style="width: 58px;">8 MOS.</td>
                    <td style="width: 58px;">9 MOS.</td>
                    <td style="width: 58px;">10 MOS.</td>
                    <td style="width: 58px;">11 MOS.</td>
                    <td style="width: 58px;">12 MOS.</td>
                </tr>
EOF;
        $total_oneMonth = 0;
        $total_twoMonth = 0;
        $total_threeMonth = 0;
        $total_fourMonth = 0;
        $total_fiveMonth = 0;
        $total_sixMonth = 0;
        $total_sevenMonth = 0;
        $total_eightMonth = 0;
        $total_shamMonth = 0;
        $total_tenMonth = 0;
        $total_elevenMonth = 0;
        $total_twelveMonth = 0;
        $total_total = 0;
        $total_totalCumi = 0;


        $cumiTotal_one_monthCumi = 0;
        $cumiTotal_two_monthCumi = 0;
        $cumiTotal_three_monthCumi = 0;
        $cumiTotal_four_monthCumi = 0;
        $cumiTotal_five_monthCumi = 0;
        $cumiTotal_six_monthCumi = 0;
        $cumiTotal_seven_monthCumi = 0;
        $cumiTotal_eight_monthCumi = 0;
        $cumiTotal_sham_monthCumi = 0;
        $cumiTotal_ten_monthCumi = 0;
        $cumiTotal_eleven_monthCumi = 0;
        $cumiTotal_twelve_monthCumi = 0;


        $grandTotalCumi = 0;
        $grandFinalTotal = 0;
        
        $EMBBranches = $Ticket->ctrGetAllEMBBranches();
        foreach($EMBBranches as $getEmb){
            $branch_name = $getEmb['full_name'];
            $getRenew = $Ticket->ctrGetRenew($dateTo, $branch_name);
            
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

            $total_oneMonth +=$one_month;
            $total_twoMonth +=$two_month;
            $total_threeMonth +=$three_month;
            $total_fourMonth +=$four_month;
            $total_fiveMonth +=$five_month;
            $total_sixMonth +=$six_month;
            $total_sevenMonth +=$seven_month;
            $total_eightMonth +=$eight_month;
            $total_shamMonth +=$sham_month;
            $total_tenMonth +=$ten_month;
            $total_elevenMonth +=$eleven_month;
            $total_twelveMonth +=$twelve_month;
            $total_total+=$total;
           
            $getTicketCumi = $Ticket->ctrGetTicketCumi($fDateStart, $prev, $branch_name);
            foreach($getTicketCumi as $renewCumi){
                $one_monthCumi = $renewCumi['total_one_month'];
                $two_monthCumi = $renewCumi['total_two_month'];
                $three_monthCumi = $renewCumi['total_three_month'];
                $four_monthCumi = $renewCumi['total_four_month'];
                $five_monthCumi = $renewCumi['total_five_month'];
                $six_monthCumi = $renewCumi['total_six_month'];
                $seven_monthCumi = $renewCumi['total_seven_month'];
                $eight_monthCumi = $renewCumi['total_eight_month'];
                $sham_monthCumi = $renewCumi['total_sham_month'];
                $ten_monthCumi = $renewCumi['total_ten_month'];
                $eleven_monthCumi = $renewCumi['total_eleven_month'];
                $twelve_monthCumi = $renewCumi['total_twelve_month'];
            }

            $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
            + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi + $twelve_monthCumi;

            // Get the GrandTotal
            $grand_total = $total + $total_cumi;
            $total_totalCumi+=$total_cumi;
            $final_total = $total_totalCumi + $total_total;

            $getTicketRenew = $Ticket->ctrGetTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
            $cumiTotal_twelve_monthCumi += $twelve_monthCumi1;
          
        $header .=<<<EOF
            <tr>
                <td style="text-align:left;"> $branch_name</td>
                <td>$total_cumi</td>
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
                <td>$grand_total</td>
        </tr>
EOF;
    }

      
        
                $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
                $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
                $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
                $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
                $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
                $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
                $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
                $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
                $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
                $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
                $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
                $final_CumiTwelvemonth = $cumiTotal_twelve_monthCumi + $total_twelveMonth;

                $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
                + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth
                + $final_CumiTwelvemonth;


                $grandTotalCumi += $total_totalCumi;
                $grandFinalTotal += $final_CumiTotal;
                

        $header .=<<<EOF
            <tr style="font-weight:bold;">
                <td style="text-align:left;"> TOTAL</td>
                <td>$total_totalCumi</td>
                <td>$total_oneMonth</td>
                <td>$total_twoMonth</td>
                <td>$total_threeMonth</td>
                <td>$total_fourMonth</td>
                <td>$total_fiveMonth</td>
                <td>$total_sixMonth</td>
                <td>$total_sevenMonth</td>
                <td>$total_eightMonth</td>
                <td>$total_shamMonth</td>
                <td>$total_tenMonth</td>
                <td>$total_elevenMonth</td>
                <td>$total_twelveMonth</td>
                <td>$total_total</td>
                <td>$final_total</td>
            </tr>
            

        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL SUMMARY</td>
                <td> - </td>
                <td>$final_CumiOnemonth</td>
                <td>$final_CumiTwomonth</td>
                <td>$final_CumiThreemonth</td>
                <td>$final_CumiFourmonth</td>
                <td>$final_CumiFivemonth</td>
                <td>$final_CumiSixmonth</td>
                <td>$final_CumiSevenmonth</td>
                <td>$final_CumiEightmonth</td>
                <td>$final_CumiShammonth</td>
                <td>$final_CumiTenmonth</td>
                <td>$final_CumiElevenmonth</td>
                <td>$final_CumiTwelvemonth</td>
                <td> - </td>
                <td>$final_CumiTotal</td>
            </tr>
            <tr>
                <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> FCH BRANCHES</td>
            </tr>
EOF;

    // FOR FCH BRANCHES
    $total_oneMonth = 0;
    $total_twoMonth = 0;
    $total_threeMonth = 0;
    $total_fourMonth = 0;
    $total_fiveMonth = 0;
    $total_sixMonth = 0;
    $total_sevenMonth = 0;
    $total_eightMonth = 0;
    $total_shamMonth = 0;
    $total_tenMonth = 0;
    $total_elevenMonth = 0;
    $total_twelveMonth = 0;
    $total_total = 0;
    $total_totalCumi = 0;

    $cumiTotal_one_monthCumi = 0;
    $cumiTotal_two_monthCumi = 0;
    $cumiTotal_three_monthCumi = 0;
    $cumiTotal_four_monthCumi = 0;
    $cumiTotal_five_monthCumi = 0;
    $cumiTotal_six_monthCumi = 0;
    $cumiTotal_seven_monthCumi = 0;
    $cumiTotal_eight_monthCumi = 0;
    $cumiTotal_sham_monthCumi = 0;
    $cumiTotal_ten_monthCumi = 0;
    $cumiTotal_eleven_monthCumi = 0;
    $cumiTotal_twelve_monthCumi = 0;

    $FCHBBranches = $Ticket->ctrGetAllFCHBranches();
    foreach($FCHBBranches as $getFch){
        $branch_name = $getFch['full_name'];
        $getRenew = $Ticket->ctrGetRenew($dateTo, $branch_name);
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

        $total_oneMonth +=$one_month;
        $total_twoMonth +=$two_month;
        $total_threeMonth +=$three_month;
        $total_fourMonth +=$four_month;
        $total_fiveMonth +=$five_month;
        $total_sixMonth +=$six_month;
        $total_sevenMonth +=$seven_month;
        $total_eightMonth +=$eight_month;
        $total_shamMonth +=$sham_month;
        $total_tenMonth +=$ten_month;
        $total_elevenMonth +=$eleven_month;
        $total_twelveMonth +=$twelve_month;
        $total_total+=$total;

        $getTicketCumi = $Ticket->ctrGetTicketCumi($fDateStart, $prev, $branch_name);
        foreach($getTicketCumi as $renewCumi){
            $one_monthCumi = $renewCumi['total_one_month'];
            $two_monthCumi = $renewCumi['total_two_month'];
            $three_monthCumi = $renewCumi['total_three_month'];
            $four_monthCumi = $renewCumi['total_four_month'];
            $five_monthCumi = $renewCumi['total_five_month'];
            $six_monthCumi = $renewCumi['total_six_month'];
            $seven_monthCumi = $renewCumi['total_seven_month'];
            $eight_monthCumi = $renewCumi['total_eight_month'];
            $sham_monthCumi = $renewCumi['total_sham_month'];
            $ten_monthCumi = $renewCumi['total_ten_month'];
            $eleven_monthCumi = $renewCumi['total_eleven_month'];
            $twelve_monthCumi = $renewCumi['total_twelve_month'];
        }

        $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
        + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi + $twelve_monthCumi;

        // Get the GrandTotal
        $grand_total = $total + $total_cumi;
        $total_totalCumi+=$total_cumi;
        $final_total = $total_totalCumi + $total_total;

        $getTicketRenew = $Ticket->ctrGetTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
            $cumiTotal_twelve_monthCumi += $twelve_monthCumi1;
      
    $header .=<<<EOF
        <tr>
            <td style="text-align:left;"> $branch_name</td>
            <td>$total_cumi</td>
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
            <td>$grand_total</td>
      </tr>
EOF;
    }

    $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
    $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
    $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
    $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
    $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
    $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
    $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
    $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
    $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
    $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
    $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    $final_CumiTwelvemonth = $cumiTotal_twelve_monthCumi + $total_twelveMonth;

    $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
    + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth
    + $final_CumiTwelvemonth;

    $grandTotalCumi += $total_totalCumi;
    $grandFinalTotal += $final_CumiTotal;

    $header .=<<<EOF
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL</td>
            <td>$total_totalCumi</td>
            <td>$total_oneMonth</td>
            <td>$total_twoMonth</td>
            <td>$total_threeMonth</td>
            <td>$total_fourMonth</td>
            <td>$total_fiveMonth</td>
            <td>$total_sixMonth</td>
            <td>$total_sevenMonth</td>
            <td>$total_eightMonth</td>
            <td>$total_shamMonth</td>
            <td>$total_tenMonth</td>
            <td>$total_elevenMonth</td>
            <td>$total_twelveMonth</td>
            <td>$total_total</td>
            <td>$final_total</td>
        </tr>
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL SUMMARY</td>
                <td> - </td>
                <td>$final_CumiOnemonth</td>
                <td>$final_CumiTwomonth</td>
                <td>$final_CumiThreemonth</td>
                <td>$final_CumiFourmonth</td>
                <td>$final_CumiFivemonth</td>
                <td>$final_CumiSixmonth</td>
                <td>$final_CumiSevenmonth</td>
                <td>$final_CumiEightmonth</td>
                <td>$final_CumiShammonth</td>
                <td>$final_CumiTenmonth</td>
                <td>$final_CumiElevenmonth</td>
                <td>$final_CumiTwelvemonth</td>
                <td> - </td>
                <td>$final_CumiTotal</td>
            </tr>
    <tr>
    <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> RFC BRANCHES</td>
    </tr>
EOF;

    // FOR RLC BRANCHES
    $total_oneMonth = 0;
    $total_twoMonth = 0;
    $total_threeMonth = 0;
    $total_fourMonth = 0;
    $total_fiveMonth = 0;
    $total_sixMonth = 0;
    $total_sevenMonth = 0;
    $total_eightMonth = 0;
    $total_shamMonth = 0;
    $total_tenMonth = 0;
    $total_elevenMonth = 0;
    $total_twelveMonth = 0;
    $total_total = 0;
    $total_totalCumi = 0;

    $cumiTotal_one_monthCumi = 0;
    $cumiTotal_two_monthCumi = 0;
    $cumiTotal_three_monthCumi = 0;
    $cumiTotal_four_monthCumi = 0;
    $cumiTotal_five_monthCumi = 0;
    $cumiTotal_six_monthCumi = 0;
    $cumiTotal_seven_monthCumi = 0;
    $cumiTotal_eight_monthCumi = 0;
    $cumiTotal_sham_monthCumi = 0;
    $cumiTotal_ten_monthCumi = 0;
    $cumiTotal_eleven_monthCumi = 0;
    $cumiTotal_twelve_monthCumi = 0;

    $RLCBranches = $Ticket->ctrGetAllRLCBranches();
    foreach($RLCBranches as $getRlc){
        $branch_name = $getRlc['full_name'];
        $getRenew = $Ticket->ctrGetRenew($dateTo, $branch_name);
        $newBranch_name = str_replace('RLC', 'RFC', $branch_name);
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

        $total_oneMonth +=$one_month;
        $total_twoMonth +=$two_month;
        $total_threeMonth +=$three_month;
        $total_fourMonth +=$four_month;
        $total_fiveMonth +=$five_month;
        $total_sixMonth +=$six_month;
        $total_sevenMonth +=$seven_month;
        $total_eightMonth +=$eight_month;
        $total_shamMonth +=$sham_month;
        $total_tenMonth +=$ten_month;
        $total_elevenMonth +=$eleven_month;
        $total_twelveMonth +=$twelve_month;
        $total_total+=$total;
        
        $getTicketCumi = $Ticket->ctrGetTicketCumi($fDateStart, $prev, $branch_name);
        foreach($getTicketCumi as $renewCumi){
            $one_monthCumi = $renewCumi['total_one_month'];
            $two_monthCumi = $renewCumi['total_two_month'];
            $three_monthCumi = $renewCumi['total_three_month'];
            $four_monthCumi = $renewCumi['total_four_month'];
            $five_monthCumi = $renewCumi['total_five_month'];
            $six_monthCumi = $renewCumi['total_six_month'];
            $seven_monthCumi = $renewCumi['total_seven_month'];
            $eight_monthCumi = $renewCumi['total_eight_month'];
            $sham_monthCumi = $renewCumi['total_sham_month'];
            $ten_monthCumi = $renewCumi['total_ten_month'];
            $eleven_monthCumi = $renewCumi['total_eleven_month'];
            $twelve_monthCumi = $renewCumi['total_twelve_month'];
        }

        $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
        + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi + $twelve_monthCumi;

        // Get the GrandTotal
        $grand_total = $total + $total_cumi;
        $total_totalCumi+=$total_cumi;
        $final_total = $total_totalCumi + $total_total;

        $getTicketRenew = $Ticket->ctrGetTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
            $cumiTotal_twelve_monthCumi += $twelve_monthCumi1;

    $header .=<<<EOF
        <tr>
            <td style="text-align:left;"> $newBranch_name</td>
            <td>$total_cumi</td>
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
            <td>$grand_total</td>
    </tr>
EOF;
    }

    $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
    $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
    $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
    $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
    $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
    $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
    $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
    $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
    $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
    $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
    $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    $final_CumiTwelvemonth = $cumiTotal_twelve_monthCumi + $total_twelveMonth;

    $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
    + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth
    + $final_CumiTwelvemonth;

    $grandTotalCumi += $total_totalCumi;
    $grandFinalTotal += $final_CumiTotal;

    $header .=<<<EOF
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL</td>
            <td>$total_totalCumi</td>
            <td>$total_oneMonth</td>
            <td>$total_twoMonth</td>
            <td>$total_threeMonth</td>
            <td>$total_fourMonth</td>
            <td>$total_fiveMonth</td>
            <td>$total_sixMonth</td>
            <td>$total_sevenMonth</td>
            <td>$total_eightMonth</td>
            <td>$total_shamMonth</td>
            <td>$total_tenMonth</td>
            <td>$total_elevenMonth</td>
            <td>$total_twelveMonth</td>
            <td>$total_total</td>
            <td>$final_total</td>
        </tr>
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL SUMMARY</td>
                <td> - </td>
                <td>$final_CumiOnemonth</td>
                <td>$final_CumiTwomonth</td>
                <td>$final_CumiThreemonth</td>
                <td>$final_CumiFourmonth</td>
                <td>$final_CumiFivemonth</td>
                <td>$final_CumiSixmonth</td>
                <td>$final_CumiSevenmonth</td>
                <td>$final_CumiEightmonth</td>
                <td>$final_CumiShammonth</td>
                <td>$final_CumiTenmonth</td>
                <td>$final_CumiElevenmonth</td>
                <td>$final_CumiTwelvemonth</td>
                <td> - </td>
                <td>$final_CumiTotal</td>
            </tr>
        <tr>
        <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> ELC BRANCHES</td>
        </tr>
EOF;

    // FOR ELC BRANCHES
    $total_oneMonth = 0;
    $total_twoMonth = 0;
    $total_threeMonth = 0;
    $total_fourMonth = 0;
    $total_fiveMonth = 0;
    $total_sixMonth = 0;
    $total_sevenMonth = 0;
    $total_eightMonth = 0;
    $total_shamMonth = 0;
    $total_tenMonth = 0;
    $total_elevenMonth = 0;
    $total_twelveMonth = 0;
    $total_total = 0;
    $total_totalCumi = 0;

    $cumiTotal_one_monthCumi = 0;
    $cumiTotal_two_monthCumi = 0;
    $cumiTotal_three_monthCumi = 0;
    $cumiTotal_four_monthCumi = 0;
    $cumiTotal_five_monthCumi = 0;
    $cumiTotal_six_monthCumi = 0;
    $cumiTotal_seven_monthCumi = 0;
    $cumiTotal_eight_monthCumi = 0;
    $cumiTotal_sham_monthCumi = 0;
    $cumiTotal_ten_monthCumi = 0;
    $cumiTotal_eleven_monthCumi = 0;
    $cumiTotal_twelve_monthCumi = 0;


    $ELCBranches = $Ticket->ctrGetAllELCBranches();
    foreach($ELCBranches as $getElc){
        $branch_name = $getElc['full_name'];
        $getRenew = $Ticket->ctrGetRenew($dateTo, $branch_name);
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

        $total_oneMonth +=$one_month;
        $total_twoMonth +=$two_month;
        $total_threeMonth +=$three_month;
        $total_fourMonth +=$four_month;
        $total_fiveMonth +=$five_month;
        $total_sixMonth +=$six_month;
        $total_sevenMonth +=$seven_month;
        $total_eightMonth +=$eight_month;
        $total_shamMonth +=$sham_month;
        $total_tenMonth +=$ten_month;
        $total_elevenMonth +=$eleven_month;
        $total_twelveMonth +=$twelve_month;
        $total_total+=$total;
      
        $getTicketCumi = $Ticket->ctrGetTicketCumi($fDateStart, $prev, $branch_name);
        foreach($getTicketCumi as $renewCumi){
            $one_monthCumi = $renewCumi['total_one_month'];
            $two_monthCumi = $renewCumi['total_two_month'];
            $three_monthCumi = $renewCumi['total_three_month'];
            $four_monthCumi = $renewCumi['total_four_month'];
            $five_monthCumi = $renewCumi['total_five_month'];
            $six_monthCumi = $renewCumi['total_six_month'];
            $seven_monthCumi = $renewCumi['total_seven_month'];
            $eight_monthCumi = $renewCumi['total_eight_month'];
            $sham_monthCumi = $renewCumi['total_sham_month'];
            $ten_monthCumi = $renewCumi['total_ten_month'];
            $eleven_monthCumi = $renewCumi['total_eleven_month'];
            $twelve_monthCumi = $renewCumi['total_twelve_month'];
        }

        $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
        + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi + $twelve_monthCumi;

        // Get the GrandTotal
        $grand_total = $total + $total_cumi;
        $total_totalCumi+=$total_cumi;
        $final_total = $total_totalCumi + $total_total;

        $getTicketRenew = $Ticket->ctrGetTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
            $cumiTotal_twelve_monthCumi += $twelve_monthCumi1;

    $header .=<<<EOF
        <tr>
            <td style="text-align:left;"> $branch_name</td>
            <td>$total_cumi</td>
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
            <td>$grand_total</td>
    </tr>
EOF;
    }

    $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
    $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
    $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
    $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
    $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
    $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
    $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
    $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
    $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
    $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
    $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    $final_CumiTwelvemonth = $cumiTotal_twelve_monthCumi + $total_twelveMonth;

    $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
    + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth
    + $final_CumiTwelvemonth;


    $grandTotalCumi += $total_totalCumi;
    $grandFinalTotal += $final_CumiTotal;


    $header .=<<<EOF
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL</td>
            <td>$total_totalCumi</td>
            <td>$total_oneMonth</td>
            <td>$total_twoMonth</td>
            <td>$total_threeMonth</td>
            <td>$total_fourMonth</td>
            <td>$total_fiveMonth</td>
            <td>$total_sixMonth</td>
            <td>$total_sevenMonth</td>
            <td>$total_eightMonth</td>
            <td>$total_shamMonth</td>
            <td>$total_tenMonth</td>
            <td>$total_elevenMonth</td>
            <td>$total_twelveMonth</td>
            <td>$total_total</td>
            <td>$final_total</td>
        </tr>
        <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL SUMMARY</td>
                <td> - </td>
                <td>$final_CumiOnemonth</td>
                <td>$final_CumiTwomonth</td>
                <td>$final_CumiThreemonth</td>
                <td>$final_CumiFourmonth</td>
                <td>$final_CumiFivemonth</td>
                <td>$final_CumiSixmonth</td>
                <td>$final_CumiSevenmonth</td>
                <td>$final_CumiEightmonth</td>
                <td>$final_CumiShammonth</td>
                <td>$final_CumiTenmonth</td>
                <td>$final_CumiElevenmonth</td>
                <td>$final_CumiTwelvemonth</td>
                <td> - </td>
                <td>$final_CumiTotal</td>
            </tr>
            <tr style="font-weight:bold;">
               <td style="text-align:left;border:none;">GRAND TOTAL</td>
                <td style="border:none;">$grandTotalCumi </td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;">$grandFinalTotal</td>
            </tr>
EOF;
      
    $header .=<<<EOF
                <tr>
                    <th style="text-align: left; border:none;  font-size:8.5rem;">PREPARED BY:</th>
                </tr>
                <tr>
                <td style="border:none;"></td>
            </tr>
                <tr>
                     <td style="text-align: left; border:none; width:150px; font-size:9.0rem;">$sPreby</td>
                 </tr>
            </table>
EOF;

$pdf->writeHTML($header, false, false, false, false, '');
$pdf->Output($reportName, 'I');
}

// FOR NEW ACCOUNTS

public function getNewAccount(){

    
    require_once('tcpdf_include.php');
  
    $pdf = new TCPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
    $pdf->startPageGroup();
    $pdf->setPrintHeader(false);  /*remove line on top of the page*/
  
  $pdf->setPrintFooter(false);  /*remove line on top of the page*/
  
  
    // set document information
  
  
  // set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);
  
  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  
  // set margins
  $pdf->SetMargins(7,7);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  
  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  
  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  
  $pdf->SetFooterMargin(0);
  
  // set auto page breaks
  $pdf->SetAutoPageBreak(true, 0); // Remove the bottom margin
  
  
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
  
  $dateTo = $_GET['dateTo'];
  $sType = $_GET['sType'];
  $sPreby = strtoupper($_GET['sPreby']);
  $formatDate = date("F d, Y", strtotime($dateTo));
  $fDate = date("Y-m", strtotime($dateTo))."-01";
  $fDateStart = date("Y-", strtotime($dateTo))."08-01";
  $prev = date("Y-m-d", strtotime("-1 day", strtotime($dateTo)));
  
  // $formatted_to = date("m/d/Y", strtotime($to));
  
  
  
  // $formatted_prev = date("m/d/Y", strtotime($prev));
  $combDate = date("M d", strtotime($fDate)) . "-" . date("d", strtotime($prev));
  $reportName = "New Accounts Ticket Daily Summary for " .$formatDate.  ".pdf";

  $header = <<<EOF
      <style>
          tr,th{
              border:1px solid black;
              font-size:7.1rem;
              text-align:center;
          }
          tr, td{
              border:1px solid black;
              font-size:7.1rem;
              text-align:center;
          }
      </style>
      <h5>GRAND PAMASKO PROMO 2023 <br>DAILY MONITORING <br><span>$formatDate</span></h5>
      <table>
                  <tr>
                      <th rowspan = "2" style="width: 120px;"><span style="color: white;">dawd</span><br>BRANCH NAME</th>
                      <th colspan = "12" style="width: 720px;">NEW ACCOUNTS</th>
                      <th rowspan = "2"><span style="color: white;">dawd</span><br>TOTAL</th>
                      <th rowspan = "2"><span style="color: white;">dawd</span><br>GRAND TOTAL</th>
                  </tr>
                  <tr>
                     <td style="width: 60px;">as of $combDate</td>
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
          $total_oneMonth = 0;
          $total_twoMonth = 0;
          $total_threeMonth = 0;
          $total_fourMonth = 0;
          $total_fiveMonth = 0;
          $total_sixMonth = 0;
          $total_sevenMonth = 0;
          $total_eightMonth = 0;
          $total_shamMonth = 0;
          $total_tenMonth = 0;
          $total_elevenMonth = 0;
          $total_twelveMonth = 0;
          $total_total = 0;
          $total_totalCumi = 0;
          
          $cumiTotal_one_monthCumi = 0;
          $cumiTotal_two_monthCumi = 0;
          $cumiTotal_three_monthCumi = 0;
          $cumiTotal_four_monthCumi = 0;
          $cumiTotal_five_monthCumi = 0;
          $cumiTotal_six_monthCumi = 0;
          $cumiTotal_seven_monthCumi = 0;
          $cumiTotal_eight_monthCumi = 0;
          $cumiTotal_sham_monthCumi = 0;
          $cumiTotal_ten_monthCumi = 0;
          $cumiTotal_eleven_monthCumi = 0;
          $cumiTotal_twelve_monthCumi = 0;

          $grandTotalCumi = 0;
          $grandFinalTotal = 0;

  
          $EMBBranches = $Ticket->ctrGetAllEMBBranches();
          foreach($EMBBranches as $getEmb){
              $branch_name = $getEmb['full_name'];
              $getRenew = $Ticket->ctrGetNewRenew($dateTo, $branch_name);
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
  
              $total_oneMonth +=$one_month;
              $total_twoMonth +=$two_month;
              $total_threeMonth +=$three_month;
              $total_fourMonth +=$four_month;
              $total_fiveMonth +=$five_month;
              $total_sixMonth +=$six_month;
              $total_sevenMonth +=$seven_month;
              $total_eightMonth +=$eight_month;
              $total_shamMonth +=$sham_month;
              $total_tenMonth +=$ten_month;
              $total_elevenMonth +=$eleven_month;
              $total_total+=$total;
            
              $getTicketCumi = $Ticket->ctrGetNewTicketCumi($fDateStart, $prev, $branch_name);
              foreach($getTicketCumi as $renewCumi){
                  $one_monthCumi = $renewCumi['total_one_month'];
                  $two_monthCumi = $renewCumi['total_two_month'];
                  $three_monthCumi = $renewCumi['total_three_month'];
                  $four_monthCumi = $renewCumi['total_four_month'];
                  $five_monthCumi = $renewCumi['total_five_month'];
                  $six_monthCumi = $renewCumi['total_six_month'];
                  $seven_monthCumi = $renewCumi['total_seven_month'];
                  $eight_monthCumi = $renewCumi['total_eight_month'];
                  $sham_monthCumi = $renewCumi['total_sham_month'];
                  $ten_monthCumi = $renewCumi['total_ten_month'];
                  $eleven_monthCumi = $renewCumi['total_eleven_month'];
              }
  
              $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
              + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi;
  
              // Get the GrandTotal
              $grand_total = $total + $total_cumi;
              $total_totalCumi+=$total_cumi;
              $final_total = $total_totalCumi + $total_total;

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

            $getTicketRenew = $Ticket->ctrGetNewTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
           
  
          $header .=<<<EOF
              <tr>
                  <td style="text-align:left;"> $branch_name</td>
                  <td>$total_cumi</td>
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
                  <td>$grand_total</td>
          </tr>
EOF;
          }

          $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
          $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
          $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
          $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
          $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
          $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
          $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
          $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
          $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
          $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
          $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
        
      
          $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
          + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth;
  
          $grandTotalCumi += $total_totalCumi;
          $grandFinalTotal += $final_CumiTotal;


          $header .=<<<EOF
              <tr style="font-weight:bold;">
                  <td style="text-align:left;"> TOTAL</td>
                  <td>$total_totalCumi</td>
                  <td>$total_oneMonth</td>
                  <td>$total_twoMonth</td>
                  <td>$total_threeMonth</td>
                  <td>$total_fourMonth</td>
                  <td>$total_fiveMonth</td>
                  <td>$total_sixMonth</td>
                  <td>$total_sevenMonth</td>
                  <td>$total_eightMonth</td>
                  <td>$total_shamMonth</td>
                  <td>$total_tenMonth</td>
                  <td>$total_elevenMonth</td>
                  <td>$total_total</td>
                  <td>$final_total</td>
              </tr>
              <tr style="font-weight:bold;">
            <td style="text-align:left;"> TOTAL SUMMARY</td>
                <td> - </td>
                <td>$final_CumiOnemonth</td>
                <td>$final_CumiTwomonth</td>
                <td>$final_CumiThreemonth</td>
                <td>$final_CumiFourmonth</td>
                <td>$final_CumiFivemonth</td>
                <td>$final_CumiSixmonth</td>
                <td>$final_CumiSevenmonth</td>
                <td>$final_CumiEightmonth</td>
                <td>$final_CumiShammonth</td>
                <td>$final_CumiTenmonth</td>
                <td>$final_CumiElevenmonth</td>
                <td> - </td>
                <td>$final_CumiTotal</td>
            </tr>
              <tr>
                  <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> FCH BRANCHES</td>
              </tr>
EOF;
  
      // FOR FCH BRANCHES
      $total_oneMonth = 0;
      $total_twoMonth = 0;
      $total_threeMonth = 0;
      $total_fourMonth = 0;
      $total_fiveMonth = 0;
      $total_sixMonth = 0;
      $total_sevenMonth = 0;
      $total_eightMonth = 0;
      $total_shamMonth = 0;
      $total_tenMonth = 0;
      $total_elevenMonth = 0;
      $total_twelveMonth = 0;
      $total_total = 0;
      $total_totalCumi = 0;

      $cumiTotal_one_monthCumi = 0;
      $cumiTotal_two_monthCumi = 0;
      $cumiTotal_three_monthCumi = 0;
      $cumiTotal_four_monthCumi = 0;
      $cumiTotal_five_monthCumi = 0;
      $cumiTotal_six_monthCumi = 0;
      $cumiTotal_seven_monthCumi = 0;
      $cumiTotal_eight_monthCumi = 0;
      $cumiTotal_sham_monthCumi = 0;
      $cumiTotal_ten_monthCumi = 0;
      $cumiTotal_eleven_monthCumi = 0;
      $cumiTotal_twelve_monthCumi = 0;


      $FCHBBranches = $Ticket->ctrGetAllFCHBranches();
      foreach($FCHBBranches as $getFch){
          $branch_name = $getFch['full_name'];
          $getRenew = $Ticket->ctrGetNewRenew($dateTo, $branch_name);
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
  
          $total_oneMonth +=$one_month;
          $total_twoMonth +=$two_month;
          $total_threeMonth +=$three_month;
          $total_fourMonth +=$four_month;
          $total_fiveMonth +=$five_month;
          $total_sixMonth +=$six_month;
          $total_sevenMonth +=$seven_month;
          $total_eightMonth +=$eight_month;
          $total_shamMonth +=$sham_month;
          $total_tenMonth +=$ten_month;
          $total_elevenMonth +=$eleven_month;
          $total_total+=$total;
          
          $getTicketCumi = $Ticket->ctrGetNewTicketCumi($fDateStart, $prev, $branch_name);
          foreach($getTicketCumi as $renewCumi){
              $one_monthCumi = $renewCumi['total_one_month'];
              $two_monthCumi = $renewCumi['total_two_month'];
              $three_monthCumi = $renewCumi['total_three_month'];
              $four_monthCumi = $renewCumi['total_four_month'];
              $five_monthCumi = $renewCumi['total_five_month'];
              $six_monthCumi = $renewCumi['total_six_month'];
              $seven_monthCumi = $renewCumi['total_seven_month'];
              $eight_monthCumi = $renewCumi['total_eight_month'];
              $sham_monthCumi = $renewCumi['total_sham_month'];
              $ten_monthCumi = $renewCumi['total_ten_month'];
              $eleven_monthCumi = $renewCumi['total_eleven_month'];
          }

          $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
          + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi;

          // Get the GrandTotal
          $grand_total = $total + $total_cumi;
          $total_totalCumi+=$total_cumi;
          $final_total = $total_totalCumi + $total_total;

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


        $getTicketRenew = $Ticket->ctrGetNewTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
  
      $header .=<<<EOF
          <tr>
              <td style="text-align:left;"> $branch_name</td>
              <td>$total_cumi</td>
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
              <td>$grand_total</td>
      </tr>
EOF;
      }
      $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
      $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
      $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
      $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
      $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
      $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
      $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
      $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
      $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
      $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
      $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    
  
      $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
      + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth;
  
      $grandTotalCumi += $total_totalCumi;
      $grandFinalTotal += $final_CumiTotal;

      $header .=<<<EOF
          <tr style="font-weight:bold;">
              <td style="text-align:left;"> TOTAL</td>
              <td>$total_totalCumi</td>
              <td>$total_oneMonth</td>
              <td>$total_twoMonth</td>
              <td>$total_threeMonth</td>
              <td>$total_fourMonth</td>
              <td>$total_fiveMonth</td>
              <td>$total_sixMonth</td>
              <td>$total_sevenMonth</td>
              <td>$total_eightMonth</td>
              <td>$total_shamMonth</td>
              <td>$total_tenMonth</td>
              <td>$total_elevenMonth</td>
              <td>$total_total</td>
              <td>$final_total</td>
          </tr>

          <tr style="font-weight:bold;">
          <td style="text-align:left;"> TOTAL SUMMARY</td>
              <td> - </td>
              <td>$final_CumiOnemonth</td>
              <td>$final_CumiTwomonth</td>
              <td>$final_CumiThreemonth</td>
              <td>$final_CumiFourmonth</td>
              <td>$final_CumiFivemonth</td>
              <td>$final_CumiSixmonth</td>
              <td>$final_CumiSevenmonth</td>
              <td>$final_CumiEightmonth</td>
              <td>$final_CumiShammonth</td>
              <td>$final_CumiTenmonth</td>
              <td>$final_CumiElevenmonth</td>
              <td> - </td>
              <td>$final_CumiTotal</td>
          </tr>
      <tr>
      <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> RFC BRANCHES</td>
      </tr>
EOF;
  
      // FOR RLC BRANCHES
      $total_oneMonth = 0;
      $total_twoMonth = 0;
      $total_threeMonth = 0;
      $total_fourMonth = 0;
      $total_fiveMonth = 0;
      $total_sixMonth = 0;
      $total_sevenMonth = 0;
      $total_eightMonth = 0;
      $total_shamMonth = 0;
      $total_tenMonth = 0;
      $total_elevenMonth = 0;
      $total_twelveMonth = 0;
      $total_total = 0;
      $total_totalCumi = 0;

      $cumiTotal_one_monthCumi = 0;
      $cumiTotal_two_monthCumi = 0;
      $cumiTotal_three_monthCumi = 0;
      $cumiTotal_four_monthCumi = 0;
      $cumiTotal_five_monthCumi = 0;
      $cumiTotal_six_monthCumi = 0;
      $cumiTotal_seven_monthCumi = 0;
      $cumiTotal_eight_monthCumi = 0;
      $cumiTotal_sham_monthCumi = 0;
      $cumiTotal_ten_monthCumi = 0;
      $cumiTotal_eleven_monthCumi = 0;
      $cumiTotal_twelve_monthCumi = 0;

      $RLCBranches = $Ticket->ctrGetAllRLCBranches();
      foreach($RLCBranches as $getRlc){
          $branch_name = $getRlc['full_name'];
          $getRenew = $Ticket->ctrGetNewRenew($dateTo, $branch_name);
          $newBranch_name = str_replace('RLC', 'RFC', $branch_name);
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
  
          $total_oneMonth +=$one_month;
          $total_twoMonth +=$two_month;
          $total_threeMonth +=$three_month;
          $total_fourMonth +=$four_month;
          $total_fiveMonth +=$five_month;
          $total_sixMonth +=$six_month;
          $total_sevenMonth +=$seven_month;
          $total_eightMonth +=$eight_month;
          $total_shamMonth +=$sham_month;
          $total_tenMonth +=$ten_month;
          $total_elevenMonth +=$eleven_month;
          $total_total+=$total;
        
          $getTicketCumi = $Ticket->ctrGetNewTicketCumi($fDateStart, $prev, $branch_name);
          foreach($getTicketCumi as $renewCumi){
              $one_monthCumi = $renewCumi['total_one_month'];
              $two_monthCumi = $renewCumi['total_two_month'];
              $three_monthCumi = $renewCumi['total_three_month'];
              $four_monthCumi = $renewCumi['total_four_month'];
              $five_monthCumi = $renewCumi['total_five_month'];
              $six_monthCumi = $renewCumi['total_six_month'];
              $seven_monthCumi = $renewCumi['total_seven_month'];
              $eight_monthCumi = $renewCumi['total_eight_month'];
              $sham_monthCumi = $renewCumi['total_sham_month'];
              $ten_monthCumi = $renewCumi['total_ten_month'];
              $eleven_monthCumi = $renewCumi['total_eleven_month'];
          }

          $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
          + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi;

          // Get the GrandTotal
          $grand_total = $total + $total_cumi;
          $total_totalCumi+=$total_cumi;
          $final_total = $total_totalCumi + $total_total;

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

        $getTicketRenew = $Ticket->ctrGetNewTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
  
      $header .=<<<EOF
          <tr>
              <td style="text-align:left;"> $newBranch_name</td>
              <td>$total_cumi</td>
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
              <td>$grand_total</td>

      </tr>
EOF;
      }

      $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
      $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
      $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
      $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
      $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
      $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
      $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
      $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
      $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
      $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
      $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    
  
      $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
      + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth;
  
      $grandTotalCumi += $total_totalCumi;
      $grandFinalTotal += $final_CumiTotal;

      $header .=<<<EOF
          <tr style="font-weight:bold;">
              <td style="text-align:left;"> TOTAL</td>
              <td>$total_totalCumi</td>
                <td>$total_oneMonth</td>
                <td>$total_twoMonth</td>
                <td>$total_threeMonth</td>
                <td>$total_fourMonth</td>
                <td>$total_fiveMonth</td>
                <td>$total_sixMonth</td>
                <td>$total_sevenMonth</td>
                <td>$total_eightMonth</td>
                <td>$total_shamMonth</td>
                <td>$total_tenMonth</td>
                <td>$total_elevenMonth</td>
                <td>$total_total</td>
                <td>$final_total</td>
          </tr>
          <tr style="font-weight:bold;">
          <td style="text-align:left;"> TOTAL SUMMARY</td>
              <td> - </td>
              <td>$final_CumiOnemonth</td>
              <td>$final_CumiTwomonth</td>
              <td>$final_CumiThreemonth</td>
              <td>$final_CumiFourmonth</td>
              <td>$final_CumiFivemonth</td>
              <td>$final_CumiSixmonth</td>
              <td>$final_CumiSevenmonth</td>
              <td>$final_CumiEightmonth</td>
              <td>$final_CumiShammonth</td>
              <td>$final_CumiTenmonth</td>
              <td>$final_CumiElevenmonth</td>
              <td> - </td>
              <td>$final_CumiTotal</td>
          </tr>
          <tr>
          <td style="text-align:left; font-weight:bold; background-color: #b4b5b8;" colspan="16"> ELC BRANCHES</td>
          </tr>
EOF;
  
      // FOR ELC BRANCHES
      // FOR RLC BRANCHES
      $total_oneMonth = 0;
      $total_twoMonth = 0;
      $total_threeMonth = 0;
      $total_fourMonth = 0;
      $total_fiveMonth = 0;
      $total_sixMonth = 0;
      $total_sevenMonth = 0;
      $total_eightMonth = 0;
      $total_shamMonth = 0;
      $total_tenMonth = 0;
      $total_elevenMonth = 0;
      $total_twelveMonth = 0;
      $total_total = 0;
      $total_totalCumi = 0;

      $cumiTotal_one_monthCumi = 0;
      $cumiTotal_two_monthCumi = 0;
      $cumiTotal_three_monthCumi = 0;
      $cumiTotal_four_monthCumi = 0;
      $cumiTotal_five_monthCumi = 0;
      $cumiTotal_six_monthCumi = 0;
      $cumiTotal_seven_monthCumi = 0;
      $cumiTotal_eight_monthCumi = 0;
      $cumiTotal_sham_monthCumi = 0;
      $cumiTotal_ten_monthCumi = 0;
      $cumiTotal_eleven_monthCumi = 0;
      $cumiTotal_twelve_monthCumi = 0;


      $ELCBranches = $Ticket->ctrGetAllELCBranches();
      foreach($ELCBranches as $getElc){
          $branch_name = $getElc['full_name'];
          $getRenew = $Ticket->ctrGetNewRenew($dateTo, $branch_name);
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
  
          $total_oneMonth +=$one_month;
          $total_twoMonth +=$two_month;
          $total_threeMonth +=$three_month;
          $total_fourMonth +=$four_month;
          $total_fiveMonth +=$five_month;
          $total_sixMonth +=$six_month;
          $total_sevenMonth +=$seven_month;
          $total_eightMonth +=$eight_month;
          $total_shamMonth +=$sham_month;
          $total_tenMonth +=$ten_month;
          $total_elevenMonth +=$eleven_month;
          $total_total+=$total;
         
          $getTicketCumi = $Ticket->ctrGetNewTicketCumi($fDateStart, $prev, $branch_name);
          foreach($getTicketCumi as $renewCumi){
              $one_monthCumi = $renewCumi['total_one_month'];
              $two_monthCumi = $renewCumi['total_two_month'];
              $three_monthCumi = $renewCumi['total_three_month'];
              $four_monthCumi = $renewCumi['total_four_month'];
              $five_monthCumi = $renewCumi['total_five_month'];
              $six_monthCumi = $renewCumi['total_six_month'];
              $seven_monthCumi = $renewCumi['total_seven_month'];
              $eight_monthCumi = $renewCumi['total_eight_month'];
              $sham_monthCumi = $renewCumi['total_sham_month'];
              $ten_monthCumi = $renewCumi['total_ten_month'];
              $eleven_monthCumi = $renewCumi['total_eleven_month'];
          }

          $total_cumi = $one_monthCumi + $two_monthCumi + $three_monthCumi + $four_monthCumi + $five_monthCumi 
          + $six_monthCumi + $seven_monthCumi + $eight_monthCumi + $sham_monthCumi + $ten_monthCumi + $eleven_monthCumi;

          // Get the GrandTotal
          $grand_total = $total + $total_cumi;
          $total_totalCumi+=$total_cumi;
          $final_total = $total_totalCumi + $total_total;

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

        $getTicketRenew = $Ticket->ctrGetNewTicketRenewCumi($prev, $branch_name);
            foreach($getTicketRenew as $renewCumi2){
                $one_monthCumi1 = $renewCumi2['total_one_month'];
                $two_monthCumi1 = $renewCumi2['total_two_month'];
                $three_monthCumi1 = $renewCumi2['total_three_month'];
                $four_monthCumi1 = $renewCumi2['total_four_month'];
                $five_monthCumi1 = $renewCumi2['total_five_month'];
                $six_monthCumi1 = $renewCumi2['total_six_month'];
                $seven_monthCumi1 = $renewCumi2['total_seven_month'];
                $eight_monthCumi1 = $renewCumi2['total_eight_month'];
                $sham_monthCumi1 = $renewCumi2['total_sham_month'];
                $ten_monthCumi1 = $renewCumi2['total_ten_month'];
                $eleven_monthCumi1 = $renewCumi2['total_eleven_month'];
                $twelve_monthCumi1 = $renewCumi2['total_twelve_month'];
            }
            $cumiTotal_one_monthCumi += $one_monthCumi1;
            $cumiTotal_two_monthCumi += $two_monthCumi1;
            $cumiTotal_three_monthCumi += $three_monthCumi1;
            $cumiTotal_four_monthCumi += $four_monthCumi1;
            $cumiTotal_five_monthCumi += $five_monthCumi1;
            $cumiTotal_six_monthCumi += $six_monthCumi1;
            $cumiTotal_seven_monthCumi += $seven_monthCumi1;
            $cumiTotal_eight_monthCumi += $eight_monthCumi1;
            $cumiTotal_sham_monthCumi += $sham_monthCumi1;
            $cumiTotal_ten_monthCumi += $ten_monthCumi1;
            $cumiTotal_eleven_monthCumi += $eleven_monthCumi1;
  
      $header .=<<<EOF
          <tr>
              <td style="text-align:left;"> $branch_name</td>
              <td>$total_cumi</td>
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
              <td>$grand_total</td>
      </tr>
EOF;
      }

      $final_CumiOnemonth = $cumiTotal_one_monthCumi + $total_oneMonth;
      $final_CumiTwomonth = $cumiTotal_two_monthCumi + $total_twoMonth;
      $final_CumiThreemonth = $cumiTotal_three_monthCumi + $total_threeMonth;
      $final_CumiFourmonth = $cumiTotal_four_monthCumi + $total_fourMonth;
      $final_CumiFivemonth = $cumiTotal_five_monthCumi + $total_fiveMonth;
      $final_CumiSixmonth = $cumiTotal_six_monthCumi + $total_sixMonth;
      $final_CumiSevenmonth = $cumiTotal_seven_monthCumi + $total_sevenMonth;
      $final_CumiEightmonth = $cumiTotal_eight_monthCumi + $total_eightMonth;
      $final_CumiShammonth = $cumiTotal_sham_monthCumi + $total_shamMonth;
      $final_CumiTenmonth = $cumiTotal_ten_monthCumi + $total_tenMonth;
      $final_CumiElevenmonth = $cumiTotal_eleven_monthCumi + $total_elevenMonth;
    
  
      $final_CumiTotal = $final_CumiOnemonth + $final_CumiTwomonth + $final_CumiThreemonth + $final_CumiFourmonth + $final_CumiFivemonth
      + $final_CumiSixmonth + $final_CumiSevenmonth + $final_CumiEightmonth + $final_CumiShammonth + $final_CumiTenmonth + $final_CumiElevenmonth;

      $grandTotalCumi += $total_totalCumi;
      $grandFinalTotal += $final_CumiTotal;

      $header .=<<<EOF
          <tr style="font-weight:bold;">
              <td style="text-align:left;"> TOTAL</td>
              <td>$total_totalCumi</td>
              <td>$total_oneMonth</td>
              <td>$total_twoMonth</td>
              <td>$total_threeMonth</td>
              <td>$total_fourMonth</td>
              <td>$total_fiveMonth</td>
              <td>$total_sixMonth</td>
              <td>$total_sevenMonth</td>
              <td>$total_eightMonth</td>
              <td>$total_shamMonth</td>
              <td>$total_tenMonth</td>
              <td>$total_elevenMonth</td>
              <td>$total_total</td>
              <td>$final_total</td>
          </tr>
          <tr style="font-weight:bold;">
          <td style="text-align:left;"> TOTAL SUMMARY</td>
              <td> - </td>
              <td>$final_CumiOnemonth</td>
              <td>$final_CumiTwomonth</td>
              <td>$final_CumiThreemonth</td>
              <td>$final_CumiFourmonth</td>
              <td>$final_CumiFivemonth</td>
              <td>$final_CumiSixmonth</td>
              <td>$final_CumiSevenmonth</td>
              <td>$final_CumiEightmonth</td>
              <td>$final_CumiShammonth</td>
              <td>$final_CumiTenmonth</td>
              <td>$final_CumiElevenmonth</td>
              <td> - </td>
              <td>$final_CumiTotal</td>
          </tr>
            <tr style="font-weight:bold;">
               <td style="text-align:left;border:none;">GRAND TOTAL</td>
                <td style="border:none;">$grandTotalCumi </td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                 <td style="border:none;"></td>
                 <td style="border:none;"></td>
                <td style="border:none;"></td>
                 <td style="border:none;"></td>
                <td style="border:none;">$grandFinalTotal</td>
            </tr>
EOF;
        
      $header .=<<<EOF
                  <tr>
                      <th style="text-align: left; border:none;  font-size:8.5rem;">PREPARED BY:</th>
                  </tr>
                  <tr>
                  <td style="border:none;"></td>
              </tr>
                  <tr>
                       <td style="text-align: left; border:none; width:150px; font-size:9.0rem;">$sPreby</td>
                   </tr>
              </table>
EOF;
  
  $pdf->writeHTML($header, false, false, false, false, '');
  $pdf->Output($reportName, 'I');
  }
  

}

$clientsFormRequest = new printClientList();
    if($sType == "E"){
        $clientsFormRequest -> getClientsPrinting();
    }elseif($sType == "N"){
        $clientsFormRequest -> getNewAccount();
    }
  


?>
 