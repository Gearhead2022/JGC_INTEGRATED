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
$report_type = "PAST DUE ACCOUNT SUMMARY";
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

class printClientList{

    
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');

    $dateFrom = $_GET['dateFrom']; /*start from entered date*/
    $formated_date_selected = date('F d, Y', strtotime($dateFrom));

    $preparedBy = $_GET['preparedBy'];
    $checkedBy = $_GET['checkedBy'];
    $notedBy = $_GET['notedBy'];
    $branch_name = $_GET['branch_name'];

    if ($branch_name === 'EMB') {
        $branch_name_report = 'EMB CAPITAL LENDING CORPORATION';
    } elseif($branch_name === 'FCHN') {
        $branch_name_report = 'FCH FINANCE CORPORATION - NEGROS';
    } elseif($branch_name === 'FCHM') {
        $branch_name_report = 'FCH FINANCE CORPORATION - MANILA';
    } elseif($branch_name === 'FCHA') {
        $branch_name_report = 'FCH FINANCE CORPORATION - ANTIPOLO';
    } elseif($branch_name === 'RLC') {
        $branch_name_report = 'RAMSGATE LENDING CORPORATION';
    } elseif($branch_name === 'ELC') {
        $branch_name_report = 'EVERYDAY LENDING CORPORATION';
    }
        
    

    $selectedYear = date('Y', strtotime($dateFrom));

    $selectedYear1 = $selectedYear - 1;
    $selectedYear2 = $selectedYear - 2;
    $selectedYear3 = $selectedYear - 3;
    $selectedYear4 = $selectedYear - 4;
    $selectedYear5 = $selectedYear - 5;
    $selectedYear6 = $selectedYear - 6;
    $selectedYear7 = $selectedYear - 7;
    $selectedYear8 = $selectedYear - 8;
    $selectedYear9 = $selectedYear - 9;



  require_once('tcpdf_include.php');


    $pdf = new MYPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetMargins(12,2 );
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 2);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->SetFont('Times');
    $pdf->AddPage();

        // set JPEG quality
    $pdf->setJPEGQuality(75);
    // Example of Image from data stream ('PHP rules')
    $imgdata = base64_decode('');

    // Set the top position to -20 to adjust the content up by 20 units

        // The '@' character is used to indicate that follows an image data stream and not an image file name
    $pdf->Image('@'.$imgdata);



    //rlwh//
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // Image example with resizing
    // $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



$header = <<<EOF

    
    <table style="width: 100%;">

<tr>
    <td style="width: 27%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p style="font-size: 12px;"><strong>$branch_name_report</strong></p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
    
</tr>
<tr>
    <td style="width: 27%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p style="font-size: 12px;"><strong>PAST DUE ACCOUNT SUMMARY</strong></p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->

</tr>
<tr>
    <td style="width: 27%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p style="font-size: 12px;">As of $formated_date_selected</p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
</tr>

<tr>
    <td style="width: 27%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p style="font-size: 2px;"></p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
</tr>


</table>

     <table style="margin-top: 5px;">    
         <tr style="border-style: solid;">
              
                <td style="width:100px;text-align:center;font-size:11px;color:black;border: 1px solid black;">BRANCH</td>

                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear</strong></td>
                                                                    
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear1</strong></td>

                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear2</strong></td>
         
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear3</strong></td>
                                                                    
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear4</strong></td>
        
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear5</strong></td>

                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear6</strong></td>
         
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear7</strong></td>
                                                                    
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear8</strong></td>
        
                <td style="width:75px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>$selectedYear9</strong></td>

                <td style="width:80px;text-align:center;font-size:11px;color:black;border: 1px solid black;"><strong>TOTAL</strong></td>
                </tr>                 
                </table>
EOF; 


    $dateFrom = $_GET['dateFrom']; /*start from entered date*/
    $branch_name_input = $_GET['branch_name']; /*branch name*/


    $dateFromYear = date('Y' , strtotime($dateFrom));

    // $statdateFromYear = date('Y' , strtotime($dateFrom));
    $dateStart = $dateFromYear.'-01-01';
    // $dateCurentSelected = date('y-m-d', strtotime($dateFrom));
    $endYear = $dateFromYear - 9;

    for ($year = $dateFromYear; $year >= $endYear; $year--) {
        $dataArray[] = $year;
    }
        $year1 = $dataArray[0];
        $year2 = $dataArray[1];
        $year3 = $dataArray[2];
        $year4 = $dataArray[3];
        $year5 = $dataArray[4];
        $year6 = $dataArray[5];
        $year7 = $dataArray[6];
        $year8 = $dataArray[7];
        $year9 = $dataArray[8];
        $year10 = $dataArray[9];

        $dateStart1 = $year1.'-01-01';
        $dateStart2 = $year2.'-01-01';
        $dateStart3 = $year3.'-01-01';
        $dateStart4 = $year4.'-01-01';
        $dateStart5 = $year5.'-01-01';
        $dateStart6 = $year6.'-01-01';
        $dateStart7 = $year7.'-01-01';
        $dateStart8 = $year8.'-01-01';
        $dateStart9 = $year9.'-01-01';
        $dateStart10 = '1990-01-01';

        $dateFrom1 = $dateFrom;
        $dateFrom2 = $year2.'-12-31';
        $dateFrom3 = $year3.'-12-31';
        $dateFrom4 = $year4.'-12-31';
        $dateFrom5 = $year5.'-12-31';
        $dateFrom6 = $year6.'-12-31';
        $dateFrom7 = $year7.'-12-31';
        $dateFrom8 = $year8.'-12-31';
        $dateFrom9 = $year9.'-12-31';
        $dateFrom10 = $year10.'-12-31';

        $payEnd1 = date('Y-m-t', strtotime($dateFrom));
        $payEnd2 = date('Y-m-t', strtotime($dateFrom));
        $payEnd3 = date('Y-m-t', strtotime($dateFrom));
        $payEnd4 = date('Y-m-t', strtotime($dateFrom));
        $payEnd5 = date('Y-m-t', strtotime($dateFrom));
        $payEnd6 = date('Y-m-t', strtotime($dateFrom));
        $payEnd7 = date('Y-m-t', strtotime($dateFrom));
        $payEnd8 = date('Y-m-t', strtotime($dateFrom));
        $payEnd9 = date('Y-m-t', strtotime($dateFrom));
        $payEnd10 = date('Y-m-t', strtotime($dateFrom));

        if ($branch_name_input === 'FCHN') {
            $data = (new ControllerPastdue)->ctrPastDueSummaryFCHNegross();
        } elseif ($branch_name_input === 'FCHM') {
            $data = (new ControllerPastdue)->ctrPastDueSummaryFCHManilas();
        } elseif ($branch_name_input === 'FCHA') {
            $data = (new ControllerPastdue)->ctrPastDueSummaryFCHAntipolos();
        } else{
            $data = (new ControllerPastdue)->ctrPastDueSummarys($branch_name_input);
        }


    $grand_total = 0;
    $formatted_preBal1 = 0;
    $formatted_preBal2 = 0;
    $formatted_preBal3 = 0;
    $formatted_preBal4 = 0;
    $formatted_preBal5 = 0;
    $formatted_preBal6 = 0;
    $formatted_preBal7 = 0;
    $formatted_preBal8 = 0;
    $formatted_preBal9 = 0;
    $formatted_preBal10 = 0;

    $total_balance_per_year1 = 0;
    $total_balance_per_year2 = 0;
    $total_balance_per_year3 = 0;
    $total_balance_per_year4 = 0;
    $total_balance_per_year5 = 0;
    $total_balance_per_year6 = 0;
    $total_balance_per_year7 = 0;
    $total_balance_per_year8 = 0;
    $total_balance_per_year9 = 0;
    $total_balance_per_year10 = 0;
    $grand_total_balance = 0;

    $total_count_accounts1 = 0;
    $total_count_accounts2 = 0;
    $total_count_accounts3 = 0;
    $total_count_accounts4 = 0;
    $total_count_accounts5 = 0;
    $total_count_accounts6 = 0;
    $total_count_accounts7 = 0;
    $total_count_accounts8 = 0;
    $total_count_accounts9 = 0;
    $total_count_accounts10 = 0;
    $grand_total_count = 0;


    foreach ($data as &$item1) {

        $branch_names = $item1['branch_name'];
        
        $dateResult1 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom, $dateStart, $payEnd1);
        $dateResult2 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom2, $dateStart2, $payEnd2);
        $dateResult3 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom3, $dateStart3, $payEnd3);
        $dateResult4 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom4, $dateStart4, $payEnd4);
        $dateResult5 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom5, $dateStart5, $payEnd5);
        $dateResult6 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom6, $dateStart6, $payEnd6);
        $dateResult7 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom7, $dateStart7, $payEnd7);
        $dateResult8 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom8, $dateStart8, $payEnd8);
        $dateResult9 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom9, $dateStart9, $payEnd9);
        $dateResult10 = (new ControllerPastdue)->ctrPastDueAccountsPerBranchs($branch_names, $dateFrom10, $dateStart10, $payEnd10);


        $total_balance1  = $dateResult1[0];   $count_accounts1  = $dateResult1[1];
        $total_balance2  = $dateResult2[0];   $count_accounts2  = $dateResult2[1];
        $total_balance3  = $dateResult3[0];   $count_accounts3  = $dateResult3[1];
        $total_balance4  = $dateResult4[0];   $count_accounts4  = $dateResult4[1];
        $total_balance5  = $dateResult5[0];   $count_accounts5  = $dateResult5[1];
        $total_balance6  = $dateResult6[0];   $count_accounts6  = $dateResult6[1];
        $total_balance7  = $dateResult7[0];   $count_accounts7  = $dateResult7[1];
        $total_balance8  = $dateResult8[0];   $count_accounts8  = $dateResult8[1];
        $total_balance9  = $dateResult9[0];   $count_accounts9  = $dateResult9[1];
        $total_balance10 = $dateResult10[0];  $count_accounts10 = $dateResult10[1];

        if ($total_balance1 != 0) {
            if ($total_balance1 < 0) {
                $formatted_preBal1 = number_format(round(abs($total_balance1), 2), 2, '.', ',');
            } else {
                $formatted_preBal1 = "(" . number_format(round(abs($total_balance1), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal1 = "-";
        }

        if ($total_balance2 != 0) {
            if ($total_balance2 < 0) {
                $formatted_preBal2 = number_format(round(abs($total_balance2), 2), 2, '.', ',');
            } else {
                $formatted_preBal2 = "(" . number_format(round(abs($total_balance2), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal2 = "-";
        }

        if ($total_balance3 != 0) {
            if ($total_balance3 < 0) {
                $formatted_preBal3 = number_format(round(abs($total_balance3), 2), 2, '.', ',');
            } else {
                $formatted_preBal3 = "(" . number_format(round(abs($total_balance3), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal3 = "-";
        }

        if ($total_balance4 != 0) {
            if ($total_balance4 < 0) {
                $formatted_preBal4 = number_format(round(abs($total_balance4), 2), 2, '.', ',');
            } else {
                $formatted_preBal4 = "(" . number_format(round(abs($total_balance4), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal4 = "-";
        }

        if ($total_balance5 != 0) {
            if ($total_balance5 < 0) {
                $formatted_preBal5 = number_format(round(abs($total_balance5), 2), 2, '.', ',');
            } else {
                $formatted_preBal5 = "(" . number_format(round(abs($total_balance5), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal5 = "-";
        }

        if ($total_balance5 != 0) {
            if ($total_balance5 < 0) {
                $formatted_preBal5 = number_format(round(abs($total_balance5), 2), 2, '.', ',');
            } else {
                $formatted_preBal1 = "(" . number_format(round(abs($total_balance5), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal5 = "-";
        }

        if ($total_balance6 != 0) {
            if ($total_balance6 < 0) {
                $formatted_preBal6 = number_format(round(abs($total_balance6), 2), 2, '.', ',');
            } else {
                $formatted_preBal6 = "(" . number_format(round(abs($total_balance6), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal6 = "-";
        }

        if ($total_balance7 != 0) {
            if ($total_balance7 < 0) {
                $formatted_preBal7 = number_format(round(abs($total_balance7), 2), 2, '.', ',');
            } else {
                $formatted_preBal7 = "(" . number_format(round(abs($total_balance7), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal7 = "-";
        }

        if ($total_balance8 != 0) {
            if ($total_balance8 < 0) {
                $formatted_preBal8 = number_format(round(abs($total_balance8), 2), 2, '.', ',');
            } else {
                $formatted_preBal8 = "(" . number_format(round(abs($total_balance8), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal8 = "-";
        }

        if ($total_balance9 != 0) {
            if ($total_balance9 < 0) {
                $formatted_preBal9 = number_format(round(abs($total_balance9), 2), 2, '.', ',');
            } else {
                $formatted_preBal9 = "(" . number_format(round(abs($total_balance9), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal9 = "-";
        }
        if ($total_balance10 != 0) {
            if ($total_balance10 < 0) {
                $formatted_preBal10 = number_format(round(abs($total_balance10), 2), 2, '.', ',');
            } else {
                $formatted_preBal10 = "(" . number_format(round(abs($total_balance10), 2), 2, '.', ',') . ")";
            }
        } else {
            $formatted_preBal10 = "-";
        }

        $formatted_count_accounts1 = ($count_accounts1 > 0) ? $count_accounts1 : '-';
        $formatted_count_accounts2 = ($count_accounts2 > 0) ? $count_accounts2 : '-';
        $formatted_count_accounts3 = ($count_accounts3 > 0) ? $count_accounts3 : '-';
        $formatted_count_accounts4 = ($count_accounts4 > 0) ? $count_accounts4 : '-';
        $formatted_count_accounts5 = ($count_accounts5 > 0) ? $count_accounts5 : '-';
        $formatted_count_accounts6 = ($count_accounts6 > 0) ? $count_accounts6 : '-';
        $formatted_count_accounts7 = ($count_accounts7 > 0) ? $count_accounts7 : '-';
        $formatted_count_accounts8 = ($count_accounts8 > 0) ? $count_accounts8 : '-';
        $formatted_count_accounts9 = ($count_accounts9 > 0) ? $count_accounts9 : '-';
        $formatted_count_accounts10 = ($count_accounts10 > 0) ? $count_accounts10 : '-';

        $grand_total = floatval($total_balance1) + floatval($total_balance2) + floatval($total_balance3)
        + floatval($total_balance4) + floatval($total_balance5) + floatval($total_balance6)
        + floatval($total_balance7) + floatval($total_balance8) + floatval($total_balance9) + floatval($total_balance10);

        $grand_total_accounts = intval($count_accounts1) + intval($count_accounts2) + intval($count_accounts3)
        + intval($count_accounts4) + intval($count_accounts5) + intval($count_accounts6)
        + intval($count_accounts7) + intval($count_accounts8) + intval($count_accounts9) + intval($count_accounts10);

        if ($grand_total_accounts != 0) {
            $grand_total_accounts1= $grand_total_accounts;
            $grand_total_accounts = $grand_total_accounts;
        } else {
            $grand_total_accounts1 = "-";
            $grand_total_accounts = 0;
        }

        if ($grand_total != 0) {
            if ($grand_total < 0) {
                $formatted_grand_total1 = number_format(round(abs($grand_total), 2), 2, '.', ',');
                $formatted_grand_total = $formatted_grand_total1;
            } else {
                $formatted_grand_total1 = "(" . number_format(round(abs($grand_total), 2), 2, '.', ',') . ")";
                $formatted_grand_total = $formatted_grand_total1;
            }
        } else {
            $formatted_grand_total1 = "-";
            $formatted_grand_total = 0;
        }
        

    $header .= <<<EOF
    <table style="border: none;margin-top: 5px;">  

        <tr  style="border: 1px solid #black;">

            <td style="width:100px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black;">$branch_names</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts1</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts2</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts3</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts4</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts5</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts6</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts7</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts8</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts9</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_count_accounts10</td>

            <td style="width:80px;text-align:left;font-size:8px; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; text-align: right;">$grand_total_accounts1</td>

        </tr>

        <tr  style="border: 1px solid #black;">

            <td style="width:100px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal1</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal2</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal3</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal4</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal5</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal6</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal7</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal8</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal9</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_preBal10</td>

            <td style="width:80px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;  text-align: right;">$formatted_grand_total1</td>

        </tr>
        
    </table>

    EOF;

        $total_balance_per_year1 =  $total_balance_per_year1 + $total_balance1;
        $total_balance_per_year2 =  $total_balance_per_year2 + $total_balance2;
        $total_balance_per_year3 =  $total_balance_per_year3 + $total_balance3;
        $total_balance_per_year4 =  $total_balance_per_year4 + $total_balance4;
        $total_balance_per_year5 =  $total_balance_per_year5 + $total_balance5;
        $total_balance_per_year6 =  $total_balance_per_year6 + $total_balance6;
        $total_balance_per_year7 =  $total_balance_per_year7 + $total_balance7;
        $total_balance_per_year8 =  $total_balance_per_year8 + $total_balance8;
        $total_balance_per_year9 =  $total_balance_per_year9 + $total_balance9;
        $total_balance_per_year10 = $total_balance_per_year10 + $total_balance10;
        $grand_total_balance = $grand_total_balance + $grand_total;

        $total_count_accounts1 =  $total_count_accounts1 + $count_accounts1;
        $total_count_accounts2 =  $total_count_accounts2 + $count_accounts2;
        $total_count_accounts3 =  $total_count_accounts3 + $count_accounts3;
        $total_count_accounts4 =  $total_count_accounts4 + $count_accounts4;
        $total_count_accounts5 =  $total_count_accounts5 + $count_accounts5;
        $total_count_accounts6 =  $total_count_accounts6 + $count_accounts6;
        $total_count_accounts7 =  $total_count_accounts7 + $count_accounts7;
        $total_count_accounts8 =  $total_count_accounts8 + $count_accounts8;
        $total_count_accounts9 =  $total_count_accounts9 + $count_accounts9;
        $total_count_accounts10 = $total_count_accounts10 + $count_accounts10;
        $grand_total_count = $grand_total_count + $grand_total_accounts;
    }

    $formatted_total_count_accounts1 = ($total_count_accounts1 > 0) ? $total_count_accounts1 : '-';
    $formatted_total_count_accounts2 = ($total_count_accounts2 > 0) ? $total_count_accounts2 : '-';
    $formatted_total_count_accounts3 = ($total_count_accounts3 > 0) ? $total_count_accounts3 : '-';
    $formatted_total_count_accounts4 = ($total_count_accounts4 > 0) ? $total_count_accounts4 : '-';
    $formatted_total_count_accounts5 = ($total_count_accounts5 > 0) ? $total_count_accounts5 : '-';
    $formatted_total_count_accounts6 = ($total_count_accounts6 > 0) ? $total_count_accounts6 : '-';
    $formatted_total_count_accounts7 = ($total_count_accounts7 > 0) ? $total_count_accounts7 : '-';
    $formatted_total_count_accounts8 = ($total_count_accounts8 > 0) ? $total_count_accounts8 : '-';
    $formatted_total_count_accounts9 = ($total_count_accounts9 > 0) ? $total_count_accounts9 : '-';
    $formatted_total_count_accounts10 = ($total_count_accounts10 > 0) ? $total_count_accounts10 : '-';
    $formatted_grand_total_count_accounts = ($grand_total_count > 0) ? $grand_total_count : '-';

        /* Format each values total balances per year into two decimal places and values equals to 0 replaced by "-". */

    if ($total_balance_per_year1 != 0) {
        if ($total_balance_per_year1 < 0) {
            $formatted_total_balance_per_year1 = number_format(round(abs($total_balance_per_year1), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year1 = "(" . number_format(round(abs($total_balance_per_year1), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year1 = "-";
    }
    if ($total_balance_per_year2 != 0) {
        if ($total_balance_per_year2 < 0) {
            $formatted_total_balance_per_year2 = number_format(round(abs($total_balance_per_year2), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year2 = "(" . number_format(round(abs($total_balance_per_year2), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year2 = "-";
    }
    if ($total_balance_per_year3 != 0) {
        if ($total_balance_per_year3 < 0) {
            $formatted_total_balance_per_year3 = number_format(round(abs($total_balance_per_year3), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year3 = "(" . number_format(round(abs($total_balance_per_year3), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year3 = "-";
    }
    if ($total_balance_per_year4 != 0) {
        if ($total_balance_per_year4 < 0) {
            $formatted_total_balance_per_year4 = number_format(round(abs($total_balance_per_year4), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year4 = "(" . number_format(round(abs($total_balance_per_year4), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year4 = "-";
    }
    if ($total_balance_per_year5 != 0) {
        if ($total_balance_per_year5 < 0) {
            $formatted_total_balance_per_year5 = number_format(round(abs($total_balance_per_year5), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year5 = "(" . number_format(round(abs($total_balance_per_year5), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year5 = "-";
    }
    if ($total_balance_per_year6 != 0) {
        if ($total_balance_per_year6 < 0) {
            $formatted_total_balance_per_year6 = number_format(round(abs($total_balance_per_year6), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year6 = "(" . number_format(round(abs($total_balance_per_year6), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year6 = "-";
    }
    if ($total_balance_per_year7 != 0) {
        if ($total_balance_per_year7 < 0) {
            $formatted_total_balance_per_year7 = number_format(round(abs($total_balance_per_year7), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year7 = "(" . number_format(round(abs($total_balance_per_year7), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year7 = "-";
    }
    if ($total_balance_per_year8 != 0) {
        if ($total_balance_per_year8 < 0) {
            $formatted_total_balance_per_year8 = number_format(round(abs($total_balance_per_year8), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year8 = "(" . number_format(round(abs($total_balance_per_year8), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year8 = "-";
    }
    if ($total_balance_per_year9 != 0) {
        if ($total_balance_per_year9 < 0) {
            $formatted_total_balance_per_year9 = number_format(round(abs($total_balance_per_year9), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year9 = "(" . number_format(round(abs($total_balance_per_year9), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year9 = "-";
    }
    if ($total_balance_per_year10 != 0) {
        if ($total_balance_per_year10 < 0) {
            $formatted_total_balance_per_year10 = number_format(round(abs($total_balance_per_year10), 2), 2, '.', ',');
        } else {
            $formatted_total_balance_per_year10 = "(" . number_format(round(abs($total_balance_per_year10), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_total_balance_per_year10 = "-";
    }
    if ($grand_total_balance != 0) {
        if ($grand_total_balance < 0) {
            $formatted_grand_total_balance = number_format(round(abs($grand_total_balance), 2), 2, '.', ',');
        } else {
            $formatted_grand_total_balance = "(" . number_format(round(abs($grand_total_balance), 2), 2, '.', ',') . ")";
        }
    } else {
        $formatted_grand_total_balance = "-";
    }
    

    $header .= <<<EOF
    <table style="border: none;margin-top: 5px;">  

        <tr  style="border: 1px solid #black;">

            <td style="width:100px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

            <td style="width:80px;text-align:left;font-size:8px; border: 1px solid black; text-align: right;"></td>

        </tr>

        <tr  style="border: 1px solid #black;">

            <td style="width:100px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black;"></td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts1</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts2</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts3</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts4</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts5</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts6</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts7</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts8</td>

            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts9</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_count_accounts10</td>

            <td style="width:80px;text-align:left;font-size:8px; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; text-align: right;">$formatted_grand_total_count_accounts</td>

        </tr>

        <tr  style="border: 1px solid #black;">

            <td style="width:100px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black;">GRAND TOTAL</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year1</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year2</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year3</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year4</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year5</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year6</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year7</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year8</td>

            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year9</td>
                                                                
            <td style="width:75px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; text-align: right;">$formatted_total_balance_per_year10</td>

            <td style="width:80px;text-align:left;font-size:8px; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; text-align: right;">$formatted_grand_total_balance</td>

        </tr>

        <tr  style="border: 1px solid #black;">

        <td style="width:100px;text-align:left;font-size:8px; "></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>
                                                            
        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>
                                                            
        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>
                                                            
        <td style="width:75px;text-align:left;font-size:8px;  text-align: right;"></td>

        <td style="width:80px;text-align:left;font-size:8px;  text-align: right;"></td>

    </tr>

   

    <tr>

    EOF;

    if ($preparedBy != "") {
        $header .= '<td style="width:300px;text-align:left;font-size:8px; color: black;">Prepared by:</td>';
    }
    if ($checkedBy != "") {
        $header .= '<td style="width:300px;text-align:left;font-size:8px; color: black;">Checked by:</td>';
    }
    if ($notedBy != "") {
        $header .= '<td style="width:300px;text-align:left;font-size:8px; color: black;">Noted by:</td>';
    }
    

    $header .= <<<EOF
    </tr>
        <tr>
EOF;
        if ($preparedBy != "") {
            $header .= ' <td style="width:300px;text-align:left;font-size:10px; color: black; font-weight: 50px;">'.$preparedBy.'</td>';
        }
        if ($checkedBy != "") {
            $header .= '<td style="width:300px;text-align:left;font-size:10px; color: black; font-weight: 50px;">'.$checkedBy.'</td>';
        }
        if ($notedBy != "") {
            $header .= '<td style="width:300px;text-align:left;font-size:10px; color: black; font-weight: 50px;">'.$notedBy.'</td>';
        }
        
    $header .= <<<EOF

        </tr>
        
    </table>
    EOF;

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>