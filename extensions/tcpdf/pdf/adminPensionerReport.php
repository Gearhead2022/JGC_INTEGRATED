<?php


require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/pensioner.controller.php";
require_once "../../../models/pensioner.model.php";

$branchName = $_GET['branchName'];
$preparedBy = $_GET['preparedBy'];
$checkedBy = $_GET['checkedBy'];
$notedBy = $_GET['notedBy'];

$filterPensioner = new printPensioner();


if ($branchName == 'EMB') {
    $filterPensioner -> showPensionerFilterEMB_FCH();
} else if($branchName == 'FCH') {
    $filterPensioner -> showPensionerFilterEMB_FCH();
} else if($branchName == 'ELC') {
    $filterPensioner -> showPensionerFilterELC();
} else if($branchName == 'RLC') {
    $filterPensioner -> showPensionerFilterRLC();
}

class printPensioner{

public function showPensionerFilterEMB_FCH(){

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');

    $weekfrom = $_GET['penDateFrom'];
    $weekto = $_GET['penDateTo'];
    // $penBegBal = $_GET['penBegBal'];
    // $branch_name = $_SESSION['branch_name'];
    
    $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
    $startDate = new DateTime($weekfrom);
    $endDate = new DateTime($weekto);   
    $currentDate = clone $startDate;

    while ($currentDate <= $endDate) {
        $dateRange[] = $currentDate->format('Y-m-d');
        $currentDate->modify('+1 day');
     }
     $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
     $formattedDay1 = isset($dateRange[0]) ? date('j-M', strtotime($dateRange[0])) : null;
     
     $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
     $formattedDay2 = isset($dateRange[1]) ? date('j-M', strtotime($dateRange[1])) : null;
     
     $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
     $formattedDay3 = isset($dateRange[2]) ? date('j-M', strtotime($dateRange[2])) : null;
     
     $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
     $formattedDay4 = isset($dateRange[3]) ? date('j-M', strtotime($dateRange[3])) : null;
     
     $day5 = isset($dateRange[4]) ? $dateRange[4] : null;
     $formattedDay5 = isset($dateRange[4]) ? date('j-M', strtotime($dateRange[4])) : null;

     $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
     $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
     $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
     $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
     $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

     if (!empty($day1)) {
        if (!empty($day5)){
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day5));
        } else if(!empty($day4)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day4));
           
        } else if(!empty($day3)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day3));

        } else if(!empty($day2)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day2));
        }else{
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day1));

        }
          
     } 
     $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
     $begBalCovered = 'Dec ' . $lastYearDate;
     

     $dateReportCoverage = $coveredDateStart . $coveredDateEnd;

     

       

    require_once('tcpdf_include.php');


    $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetMargins(10,7);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(5);

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

// Initialize the header variable
$header = '';

$header1 = <<<EOF

    <style>
    tr, td{
        font-size:7rem;
       
    }
    tr, th{
        font-size:7rem;
        
    }
    </style>
            <table style="width: 100%;">

        <tr>
           
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px;"><strong>EMB CAPITAL LENDING and FCH</strong></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            
        </tr>
        <tr>
            
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px; color: gray;"><strong>BRANCH WEEKLY PENSIONER STATISTICS</strong></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->

        </tr>
        <tr>
          
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px; font-weight: 10;">PERIOD COVERED: $dateReportCoverage</p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        </tr>

        <tr>
           
            <td style="width: 45%; text-align: center;"><p style="font-size: 2px;"></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        </tr>


        </table>

            <table >          
                <tr>         
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
    EOF;

            $header .= $header1;

            $header_content = '';

            if ($day1_param > 0) {
                $header_content .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay1 . '</th>';
            }
            if ($day2_param > 0) {
                $header_content .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay2 . '</th>';
            }
            if ($day3_param > 0) {
                $header_content .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay3 . '</th>';
            }
            if ($day4_param > 0) {
                $header_content .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay4 . '</th>';
            }
            if ($day5_param > 0) {
                $header_content .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay5 . '</th>';
            }
            $header .= $header_content;

            $header_content2 = <<<EOF
                 
                    <th style="width: 10px;"></th>
                    <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; border: 1px solid black">TOTAL</th>
                    
                </tr>   

                <tr>
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>

            EOF;
            $header .= $header_content2;

            $header_content3 = '';

            if ($day1_param > 0) {
                $header_content3 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">MON</th>';
            }
            if ($day2_param > 0) {
                $header_content3 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">TUE</th>';
            }
            if ($day3_param > 0) {
                $header_content3 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">WED</th>';
            }
            if ($day4_param > 0) {
                $header_content3 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">THU</th>';
            }
            if ($day5_param > 0) {
                $header_content3 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">FRI</th>';
            }

            $header .= $header_content3;

            $header_content4 = <<<EOF
                
                    <th></th>
                    <!-- <th colspan="4"></th> -->
                    
                </tr>   

                <tr>
                <th style="border: 1px solid black; text-align: center;" colspan="2" ><span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span></th>
                <th ></th>
                <th style="border: 1px solid black; text-align: center;">BEG<br>$begBalCovered</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>
            EOF;

            $header .= $header_content4;

            $header_content5 = '';

            if ($day1_param > 0) {
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                $header_content5 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
            }
            if ($day2_param > 0) {
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                $header_content5 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
            }
            if ($day3_param > 0) {
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                $header_content5 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
            }
            if ($day4_param > 0) {
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                $header_content5 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
            }
            if ($day5_param > 0) {
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                $header_content5 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                $header_content5 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
            }

            $header .= $header_content5;


            $header_content6 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style="border: 1px solid black; text-align: center; font-size: 7px;"><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>   

                <tr>
                    <td colspan="26"></td>
                </tr>
                </table>
            EOF; 
            $header .= $header_content6;


            $SSS  = 'SSS';
            $GSIS = 'GSIS';

            $totalBeginningBalSSS = 0;
            $totalLastTransactionBalSSS = 0;

            $totalPenInDay1SSS = 0;
            $totalPenOutDay1SSS = 0;
            $totalPenNumDay1SSS = 0;

            $totalPenInDay2SSS = 0;
            $totalPenOutDay2SSS = 0;
            $totalPenNumDay2SSS = 0;

            $totalPenInDay3SSS = 0;
            $totalPenOutDay3SSS = 0;
            $totalPenNumDay3SSS = 0;

            $totalPenInDay4SSS = 0;
            $totalPenOutDay4SSS = 0;
            $totalPenNumDay4SSS = 0;

            $totalPenInDay5SSS = 0;
            $totalPenOutDay5SSS = 0;
            $totalPenNumDay5SSS = 0;

            $grandTotalPenInSSS = 0;
            $grandTotalPenOutSSS = 0;

            //GSIS

            $totalBeginningBalGSIS = 0;
            $totalLastTransactionBalGSIS = 0;

            $totalPenInDay1GSIS = 0;
            $totalPenOutDay1GSIS = 0;
            $totalPenNumDay1GSIS = 0;

            $totalPenInDay2GSIS = 0;
            $totalPenOutDay2GSIS = 0;
            $totalPenNumDay2GSIS = 0;

            $totalPenInDay3GSIS = 0;
            $totalPenOutDay3GSIS = 0;
            $totalPenNumDay3GSIS = 0;

            $totalPenInDay4GSIS = 0;
            $totalPenOutDay4GSIS = 0;
            $totalPenNumDay4GSIS = 0;

            $totalPenInDay5GSIS = 0;
            $totalPenOutDay5GSIS = 0;
            $totalPenNumDay5GSIS = 0;

            $grandTotalPenInGSIS = 0;
            $grandTotalPenOutGSIS = 0;

            //FCH BRANCHES

            $totalBeginningBalSSSfch = 0;
            $totalLastTransactionBalSSSfch = 0;

            $totalPenInDay1SSSfch = 0;
            $totalPenOutDay1SSSfch = 0;
            $totalPenNumDay1SSSfch = 0;

            $totalPenInDay2SSSfch = 0;
            $totalPenOutDay2SSSfch = 0;
            $totalPenNumDay2SSSfch = 0;

            $totalPenInDay3SSSfch = 0;
            $totalPenOutDay3SSSfch = 0;
            $totalPenNumDay3SSSfch = 0;

            $totalPenInDay4SSSfch = 0;
            $totalPenOutDay4SSSfch = 0;
            $totalPenNumDay4SSSfch = 0;

            $totalPenInDay5SSSfch = 0;
            $totalPenOutDay5SSSfch = 0;
            $totalPenNumDay5SSSfch = 0;

            $grandTotalPenInSSSfch = 0;
            $grandTotalPenOutSSSfch = 0;

            //GSIS

            $totalBeginningBalGSISfch = 0;
            $totalLastTransactionBalGSISfch = 0;

            $totalPenInDay1GSISfch = 0;
            $totalPenOutDay1GSISfch = 0;
            $totalPenNumDay1GSISfch = 0;

            $totalPenInDay2GSISfch = 0;
            $totalPenOutDay2GSISfch = 0;
            $totalPenNumDay2GSISfch = 0;

            $totalPenInDay3GSISfch = 0;
            $totalPenOutDay3GSISfch = 0;
            $totalPenNumDay3GSISfch = 0;

            $totalPenInDay4GSISfch = 0;
            $totalPenOutDay4GSISfch = 0;
            $totalPenNumDay4GSISfch = 0;

            $totalPenInDay5GSISfch = 0;
            $totalPenOutDay5GSISfch = 0;
            $totalPenNumDay5GSISfch = 0;

            $grandTotalPenInGSISfch = 0;
            $grandTotalPenOutGSISfch = 0;


            $data = (new ControllerPensioner)->ctrGetFCHANDEMBBranches1();

            foreach ($data as &$item1) {    
                $branch_name = $item1['branch_name'];
              

                if ($branch_name == 'EMB MAIN BRANCH') {
                    $branch_namenew = 'EMB-MAIN';   

                } else {
                    $branch_namenew = substr($branch_name, 3);
                }
                

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

                $firstDayOfYear = '1990-01-01';
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
                $body_content = '';

                $body_content = <<<EOF
                <table >
                    <tr>
                        <th colspan="2" rowspan="3" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br>$branch_namenew</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">$newBegBalValueSSS[0]</th>
                        <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>

                EOF;

                $header .= $body_content;

                $body_content1='';
                    
                        if ($day1_param > 0) {
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                            $body_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                        }
                        
                    $header .= $body_content1;

                    $netTotalSSS = $totalInSSS - $totalOutSSS;

                    $body_content2 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$netTotalSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$sss55</th>
                    
                    </tr>   
        
                    <tr>
        
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                    EOF;

                    $header .= $body_content2;

                    $body_content3 ='';
                    
                    if ($day1_param > 0) {
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                        $body_content3 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content3;


                $netTotalGSIS = $totalInGSIS - $totalInGSIS;
                $body_content4 = <<<EOF
                   
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$netTotalGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$gsis55</th>              
                </tr>  
                EOF;

                $header .= $body_content4;
                

                $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0];
                $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS;
                $sssgsis11 = $sss1[1] + $gsis1[1];
                $sssgsis12 = $sss1[2] + $gsis1[2];
                $sssgsis13 = $sss11 + $gsis11;

                $sssgsis21 = $sss2[1] + $gsis2[1];
                $sssgsis22 = $sss2[2] + $gsis2[2];
                $sssgsis23 = $sss22 + $gsis22;

                $sssgsis31 = $sss3[1] + $gsis3[1];
                $sssgsis32 = $sss3[2] + $gsis3[2];  
                $sssgsis33 = $sss33 + $gsis33;

                $sssgsis41 = $sss4[1] + $gsis4[1];
                $sssgsis42 = $sss4[2] + $gsis4[2];
                $sssgsis43 = $sss44 + $gsis44;

                $sssgsis51 = $sss5[1] + $gsis5[1];
                $sssgsis52 = $sss5[2] + $gsis5[2];
                $sssgsis53 = $sss55 + $gsis55;

                $totalGSISSSPenIn = $totalInGSIS + $totalInSSS;
                $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS;

           

                $footer_content = <<<EOF
        
                <tr>
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
                EOF;

                $header .= $footer_content;

            
                $footer_content1 ='';
                if ($day1_param > 0) {
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                }
                if ($day2_param > 0) {
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                }
                if ($day3_param > 0) {
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                }
                if ($day4_param > 0) {
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                }
                if ($day5_param > 0) {
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                    $footer_content1 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                }
                
            $header .= $footer_content1;

            $totalGSISSSSNET = $totalGSISSSPenIn - $totalGSISSSPenOut;

            $footer_content2 = <<<EOF
                   
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSSNET&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$sssgsis53</th>    
                </tr>  
    
                <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
            EOF;
            $header .= $footer_content2;
               
                $totalBeginningBalSSS += $newBegBalValueSSS[0];
                $totalLastTransactionBalSSS += $lastTransactionDataSSS;

                $totalPenInDay1SSS += $sss1[1];
                $totalPenOutDay1SSS += $sss1[2];
                $totalPenNumDay1SSS += $sss11;

                $totalPenInDay2SSS += $sss2[1];
                $totalPenOutDay2SSS += $sss2[2];
                $totalPenNumDay2SSS += $sss22;

                $totalPenInDay3SSS += $sss3[1];
                $totalPenOutDay3SSS += $sss3[2];
                $totalPenNumDay3SSS += $sss33;

                $totalPenInDay4SSS += $sss4[1];
                $totalPenOutDay4SSS += $sss4[2];
                $totalPenNumDay4SSS += $sss44;

                $totalPenInDay5SSS += $sss5[1];
                $totalPenOutDay5SSS += $sss5[2];
                $totalPenNumDay5SSS += $sss55;

                $grandTotalPenInSSS += $totalInSSS;
                $grandTotalPenOutSSS += $totalOutSSS;

                //GSIS

                $totalBeginningBalGSIS += $newBegBalValueGSIS[0];
                $totalLastTransactionBalGSIS += $lastTransactionDataGSIS;

                $totalPenInDay1GSIS += $gsis1[1];
                $totalPenOutDay1GSIS += $gsis1[2];
                $totalPenNumDay1GSIS += $gsis11;

                $totalPenInDay2GSIS += $gsis2[1];
                $totalPenOutDay2GSIS += $gsis2[2];
                $totalPenNumDay2GSIS += $gsis22;

                $totalPenInDay3GSIS += $gsis3[1];
                $totalPenOutDay3GSIS += $gsis3[2];
                $totalPenNumDay3GSIS += $gsis33;

                $totalPenInDay4GSIS += $gsis4[1];
                $totalPenOutDay4GSIS += $gsis4[2];
                $totalPenNumDay4GSIS += $gsis44;

                $totalPenInDay5GSIS += $gsis5[1];
                $totalPenOutDay5GSIS += $gsis5[2];
                $totalPenNumDay5GSIS += $gsis55;

                $grandTotalPenInGSIS += $totalInGSIS;
                $grandTotalPenOutGSIS += $totalOutGSIS;

                $b1 = $totalBeginningBalSSS + $totalBeginningBalGSIS;
                $t1 = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS;
                $p11 = $totalPenInDay1SSS  + $totalPenInDay1GSIS;
                $p12 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS;
                $p13 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS;
                $p21 = $totalPenInDay2SSS  + $totalPenInDay2GSIS;
                $p22 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS;
                $p23 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS;
                $p31 = $totalPenInDay3SSS  + $totalPenInDay3GSIS;
                $p32 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS;
                $p33 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS;
                $p41 = $totalPenInDay4SSS  + $totalPenInDay4GSIS;
                $p42 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS;
                $p43 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS;
                $p51 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
                $p52 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS;
                $p53 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
                $pi1 = $grandTotalPenInSSS + $grandTotalPenInGSIS;
                $po1 = $grandTotalPenOutSSS + $grandTotalPenOutGSIS;
                $pn1 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;

            }

 
            
        $header2 = <<<EOF


        <style>
        tr, td{
            font-size:7rem;
        
        }
        tr, th{
            font-size:7rem;
            
        }
        </style>

        <table>   

   
        
        
        <tr>         
        <th colspan="25"></th>
        
        </tr> 
    
    
    <tr>         
    <th colspan="25"></th>
    
    </tr> 


<tr>         
<th colspan="25"></th>

</tr> 


<tr>         
<th colspan="25"></th>

</tr> 


<tr>         
<th colspan="25"></th>

</tr> 


<tr>         
<th colspan="25"></th>

</tr> 

<tr>         
<th colspan="25"></th>

</tr> 


</table>
<table >

            <tr>         
                <th colspan="2"></th>
                <th></th>
                <th></th>
                <th></th>
EOF;

$header .= $header2;

                $header_content7 = '';

                if ($day1_param > 0) {
                    $header_content7 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay1 . '</th>';
                }
                if ($day2_param > 0) {
                    $header_content7 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay2 . '</th>';
                }
                if ($day3_param > 0) {
                    $header_content7 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay3 . '</th>';
                }
                if ($day4_param > 0) {
                    $header_content7 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay4 . '</th>';
                }
                if ($day5_param > 0) {
                    $header_content7 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay5 . '</th>';
                }
            $header .= $header_content7;

                $header_content8 = <<<EOF
                <th style="width: 10px;"></th>
                <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; border: 1px solid black">TOTAL</th>
                
            </tr>   

            <tr>
                <th colspan="2"></th>
                <th></th>
                <th></th>
                <th></th>
            EOF;
            $header .= $header_content8;
    
                $header_content9 = '';
    
                if ($day1_param > 0) {
                    $header_content9 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">MON</th>';
                }
                if ($day2_param > 0) {
                    $header_content9 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">TUE</th>';
                }
                if ($day3_param > 0) {
                    $header_content9 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">WED</th>';
                }
                if ($day4_param > 0) {
                    $header_content9 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">THU</th>';
                }
                if ($day5_param > 0) {
                    $header_content9 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">FRI</th>';
                }
    
                $header .= $header_content9;
    
                $header_content10 = <<<EOF
           
                <th></th>
                <!-- <th colspan="4"></th> -->
                
            </tr>   

            <tr>
            <th style="border: 1px solid black; text-align: center;" colspan="2" ><span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span></th>
            <th ></th>
            <th style="border: 1px solid black; text-align: center;">BEG<br>$begBalCovered</th>
            <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>
            EOF;

                $header .= $header_content10;
    
                $header_content11 = '';
    
                if ($day1_param > 0) {
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content11 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day2_param > 0) {
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content11 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day3_param > 0) {
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day4_param > 0) {
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day5_param > 0) {
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content11 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
    
                $header .= $header_content11;
    
    
                $header_content12 = <<<EOF
                <th style="width: 10px;"></th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                <th style="border: 1px solid black; text-align: center; font-size: 7px;"><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
            </tr>   

            <tr>
                <td colspan="26"></td>
            </tr>
            </table>
EOF; 

$header .= $header_content12;



            $data2 = (new ControllerPensioner)->ctrGetFCHANDEMBBranches2();

            foreach ($data2 as &$item1) {    
                $branch_name = $item1['branch_name'];
              

                if ($branch_name == 'EMB MAIN BRANCH') {
                    $branch_namenew = 'EMB-MAIN';   

                } else {
                    $branch_namenew = substr($branch_name, 3);
                }
                

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

                $firstDayOfYear = '1990-01-01';
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
        
                $body_content5 = <<<EOF
                <table>
                    <tr>
                        <th colspan="2" rowspan="3" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br>$branch_namenew</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                        <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                EOF;

                        $header .= $body_content5;
        
                        $body_content6='';
                            
                                if ($day1_param > 0) {
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                                    $body_content6 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content6;

                            $totalNetSSS = $totalInSSS - $totalOutSSS;
        
                    $body_content7 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$sss55</th>
                    
                    </tr>   
        
                    <tr>
        
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                    EOF;

                    $header .= $body_content7;

                    $body_content7 ='';
                    
                    if ($day1_param > 0) {
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                        $body_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content7;

                $netTotalGSIS = $totalInGSIS - $totalOutGSIS;
           
                $body_content8 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$netTotalGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$gsis55</th>              
                </tr>  

                EOF;

                $header .= $body_content8;

                $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0];
                $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS;
                $sssgsis11 = $sss1[1] + $gsis1[1];
                $sssgsis12 = $sss1[2] + $gsis1[2];
                $sssgsis13 = $sss11 + $gsis11;

                $sssgsis21 = $sss2[1] + $gsis2[1];
                $sssgsis22 = $sss2[2] + $gsis2[2];
                $sssgsis23 = $sss22 + $gsis22;

                $sssgsis31 = $sss3[1] + $gsis3[1];
                $sssgsis32 = $sss3[2] + $gsis3[2];
                $sssgsis33 = $sss33 + $gsis33;

                $sssgsis41 = $sss4[1] + $gsis4[1];
                $sssgsis42 = $sss4[2] + $gsis4[2];
                $sssgsis43 = $sss44 + $gsis44;

                $sssgsis51 = $sss5[1] + $gsis5[1];
                $sssgsis52 = $sss5[2] + $gsis5[2];
                $sssgsis53 = $sss55 + $gsis55;

                $totalGSISSSPenIn = $totalInGSIS + $totalInSSS;
                $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS;

                $footer_content3 = <<<EOF
        
                <tr>
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
                EOF;

                    $header .= $footer_content3;
    
                
                    $footer_content4 ='';
                    if ($day1_param > 0) {
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                        $footer_content4 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $footer_content4;

                $totalNetSSSGSIS = $totalGSISSSPenIn - $totalGSISSSPenOut;
    
                $footer_content5 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalNetSSSGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$sssgsis53</th>    
                </tr>  
    
                <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
                EOF;
                $header .= $footer_content5;
               
                $totalBeginningBalSSS += $newBegBalValueSSS[0];
                $totalLastTransactionBalSSS += $lastTransactionDataSSS;

                $totalPenInDay1SSS += $sss1[1];
                $totalPenOutDay1SSS += $sss1[2];
                $totalPenNumDay1SSS += $sss11;

                $totalPenInDay2SSS += $sss2[1];
                $totalPenOutDay2SSS += $sss2[2];
                $totalPenNumDay2SSS += $sss22;

                $totalPenInDay3SSS += $sss3[1];
                $totalPenOutDay3SSS += $sss3[2];
                $totalPenNumDay3SSS += $sss33;

                $totalPenInDay4SSS += $sss4[1];
                $totalPenOutDay4SSS += $sss4[2];
                $totalPenNumDay4SSS += $sss44;

                $totalPenInDay5SSS += $sss5[1];
                $totalPenOutDay5SSS += $sss5[2];
                $totalPenNumDay5SSS += $sss55;

                $grandTotalPenInSSS += $totalInSSS;
                $grandTotalPenOutSSS += $totalOutSSS;

                //GSIS

                $totalBeginningBalGSIS += $newBegBalValueGSIS[0];
                $totalLastTransactionBalGSIS += $lastTransactionDataGSIS;

                $totalPenInDay1GSIS += $gsis1[1];
                $totalPenOutDay1GSIS += $gsis1[2];
                $totalPenNumDay1GSIS += $gsis11;

                $totalPenInDay2GSIS += $gsis2[1];
                $totalPenOutDay2GSIS += $gsis2[2];
                $totalPenNumDay2GSIS += $gsis22;

                $totalPenInDay3GSIS += $gsis3[1];
                $totalPenOutDay3GSIS += $gsis3[2];
                $totalPenNumDay3GSIS += $gsis33;

                $totalPenInDay4GSIS += $gsis4[1];
                $totalPenOutDay4GSIS += $gsis4[2];
                $totalPenNumDay4GSIS += $gsis44;

                $totalPenInDay5GSIS += $gsis5[1];
                $totalPenOutDay5GSIS += $gsis5[2];
                $totalPenNumDay5GSIS += $gsis55;

                $grandTotalPenInGSIS += $totalInGSIS;
                $grandTotalPenOutGSIS += $totalOutGSIS;

                $b1 = $totalBeginningBalSSS + $totalBeginningBalGSIS;
                $t1 = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS;
                $p11 = $totalPenInDay1SSS  + $totalPenInDay1GSIS;
                $p12 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS;
                $p13 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS;
                $p21 = $totalPenInDay2SSS  + $totalPenInDay2GSIS;
                $p22 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS;
                $p23 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS;
                $p31 = $totalPenInDay3SSS  + $totalPenInDay3GSIS;
                $p32 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS;
                $p33 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS;
                $p41 = $totalPenInDay4SSS  + $totalPenInDay4GSIS;
                $p42 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS;
                $p43 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS;
                $p51 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
                $p52 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS;
                $p53 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
                $pi1 = $grandTotalPenInSSS + $grandTotalPenInGSIS;
                $po1 = $grandTotalPenOutSSS + $grandTotalPenOutGSIS;
                $pn1 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
            }

            

                    
            $additionalContent = <<<EOF
                        
                <table>
                    <tr>
                        <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem; color:gray; border: 1px solid black;"><span style="color: white;"></span><br>EMB TOTAL</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalBeginningBalSSS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalSSS</th>
            EOF;

            $header .= $additionalContent;

            $additionalContent3 = '';
                    
            if ($day1_param > 0) {
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1SSS.'&nbsp;&nbsp;</th>';
            }
            if ($day2_param > 0) {
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2SSS.'&nbsp;&nbsp;</th>';
            }
            if ($day3_param > 0) {
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3SSS.'&nbsp;&nbsp;</th>';
            }
            if ($day4_param > 0) {
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4SSS.'&nbsp;&nbsp;</th>';
            }
            if ($day5_param > 0) {
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5SSS.'&nbsp;&nbsp;</th>';
                $additionalContent3 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5SSS.'&nbsp;&nbsp;</th>';
            }
            
        $header .= $additionalContent3;

        $grandNetTotal = $grandTotalPenInSSS - $grandTotalPenOutSSS;


            $additionalContent4 = <<<EOF

                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenInSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandNetTotal&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5SSS</th>
                    
                    </tr>   
                    <tr>

                        <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">GSIS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalBeginningBalGSIS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSIS</th>
            EOF;

            $header .= $additionalContent4;

                $additionalContent5 = '';
                        
                if ($day1_param > 0) {
                    $additionalContent5 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1GSIS.'&nbsp;&nbsp;</th>';
                }
                if ($day2_param > 0) {
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2GSIS.'&nbsp;&nbsp;</th>';
                }
                if ($day3_param > 0) {
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3GSIS.'&nbsp;&nbsp;</th>';
                }
                if ($day4_param > 0) {
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4GSIS.'&nbsp;&nbsp;</th>';
                }
                if ($day5_param > 0) {
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5GSIS.'&nbsp;&nbsp;</th>';
                    $additionalContent5 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5GSIS.'&nbsp;&nbsp;</th>';
                }
                
            $header .= $additionalContent5;


            $additionalContent6 = <<<EOF

                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenInGSIS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutGSIS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">0&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5GSIS</th>
            
                    </tr>  
                    <tr>
                        <th style="padding:1.2rem 1.5rem; border: 1px solid black; text-align: center;">TOTAL</th>
                        <th style="border: 1px solid black; text-align: center;">$b1</th>
                        <th style="border: 1px solid black; text-align: center;">$t1</th>
            EOF;

            $header .= $additionalContent6;

            $additionalContent7 = '';
                    
            if ($day1_param > 0) {
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p11.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p12.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p13.'&nbsp;&nbsp;</th>';
            }
            if ($day2_param > 0) {
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p21.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p22.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p23.'&nbsp;&nbsp;</th>';
            }
            if ($day3_param > 0) {
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p31.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p32.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p33.'&nbsp;&nbsp;</th>';
            }
            if ($day4_param > 0) {
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p41.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p42.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p43.'&nbsp;&nbsp;</th>';
            }
            if ($day5_param > 0) {
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p51.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p52.'&nbsp;&nbsp;</th>';
                $additionalContent7 .= '<th style="border: 1px solid black; text-align: right;">'.$p53.'&nbsp;&nbsp;</th>';
            }
            
        $header .= $additionalContent7;

        $p99 = $pi1 - $po1;


            $additionalContent8 = <<<EOF

                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$pi1&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$po1&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;"> $p99 &nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$pn1</th>

                    </tr>  

                    <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
EOF;
$header .= $additionalContent8;


                                            
        $header_content13 = <<<EOF


        <style>
        tr, td{
            font-size:7rem;
        
        }
        tr, th{
            font-size:7rem;
            
        }
        </style>

        <table>   

            <tr><th colspan="25"></th></tr> 

            <tr><th colspan="25"></th></tr> 

            <tr><th colspan="25"></th></tr> 

            <tr><th colspan="25"></th></tr> 
            </table>
            <table>   
            <tr>         
                <th colspan="2"></th>
                <th></th>
                <th></th>
                <th></th>
        EOF;

                $header .= $header_content13;
                
                    $header_content14 = '';
    
                    if ($day1_param > 0) {
                        $header_content14 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay1 . '</th>';
                    }
                    if ($day2_param > 0) {
                        $header_content14 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay2 . '</th>';
                    }
                    if ($day3_param > 0) {
                        $header_content14 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay3 . '</th>';
                    }
                    if ($day4_param > 0) {
                        $header_content14 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay4 . '</th>';
                    }
                    if ($day5_param > 0) {
                        $header_content14 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay5 . '</th>';
                    }
                $header .= $header_content14;
                
                $header_content15 = <<<EOF
                <th style="width: 10px;"></th>
                <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; border: 1px solid black">TOTAL</th>
                
            </tr>   

            <tr>
                <th colspan="2"></th>
                <th></th>
                <th></th>
                <th></th>
            EOF;
                $header .= $header_content15;
        
                    $header_content16 = '';
        
                    if ($day1_param > 0) {
                        $header_content16 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">MON</th>';
                    }
                    if ($day2_param > 0) {
                        $header_content16 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">TUE</th>';
                    }
                    if ($day3_param > 0) {
                        $header_content16 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">WED</th>';
                    }
                    if ($day4_param > 0) {
                        $header_content16 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">THU</th>';
                    }
                    if ($day5_param > 0) {
                        $header_content16 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">FRI</th>';
                    }
        
                    $header .= $header_content16;
        
                    $header_content17 = <<<EOF
               
                    <th></th>
                    <!-- <th colspan="4"></th> -->
                    
                </tr>   

                <tr>
                <th style="border: 1px solid black; text-align: center;" colspan="2" ><span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span></th>
                <th ></th>
                <th style="border: 1px solid black; text-align: center;">BEG<br>$begBalCovered</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>
            EOF;

                $header .= $header_content17;
    
                $header_content18 = '';
    
                if ($day1_param > 0) {
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day2_param > 0) {
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day3_param > 0) {
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day4_param > 0) {
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
                if ($day5_param > 0) {
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                    $header_content18 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                }
    
                $header .= $header_content18;
    
    
                $header_content19 = <<<EOF
                <th style="width: 10px;"></th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                <th style="border: 1px solid black; text-align: center; font-size: 7px;"><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
            </tr>   

            <tr>
                <td colspan="26"></td>
            </tr>
            </table>
EOF; 

    $header .= $header_content19;

    
            $preparedBy = $_GET['preparedBy'];
            $checkedBy = $_GET['checkedBy'];
            $notedBy = $_GET['notedBy'];

            $FCH_branch = 'FCH';

            $data3 = (new ControllerPensioner)->ctrGetBranchesNames($FCH_branch);

            foreach ($data3 as &$item1) {    
                $branch_name_fch = $item1['branch_name'];
                          
                $branch_namenew = substr($branch_name_fch, 3);
                
            
                $sss1fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day1, $SSS);
                $sss2fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day2, $SSS);
                $sss3fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day3, $SSS);
                $sss4fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day4, $SSS);
                $sss5fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day5, $SSS);
        
                $gsis1fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day1, $GSIS);
                $gsis2fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day2, $GSIS);
                $gsis3fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day3, $GSIS);
                $gsis4fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day4, $GSIS);
                $gsis5fch = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name_fch, $day5, $GSIS);
    
                $firstDayOfYear ='1990-01-01';
                $lastDayOfYear = $lastYearDate . '-12-31';
        
                $newBegBalValueSSSfch = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name_fch, $firstDayOfYear, $lastDayOfYear, $SSS);
                
                $newBegBalValueGSISfch =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name_fch, $firstDayOfYear, $lastDayOfYear, $GSIS);
    
                // get last transaction
    
                $firstDayOfTrans = '1990-01-01';
                $lastDayOfTrans = date('Y-m-d', strtotime('-1 day', strtotime($weekfrom)));
      
                $lastTransactionDataSSSfch = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name_fch, $SSS, $firstDayOfTrans, $lastDayOfTrans);
                
                $lastTransactionDataGSISfch = (new ControllerPensioner)->ctrGetBeginningBalance($branch_name_fch, $GSIS, $firstDayOfTrans, $lastDayOfTrans);
      
          
                if ($sss1fch[0] === 0) {
                    
                    $penDateDataNewSSS = $lastTransactionDataSSSfch; 
                    
                } else {
                    $penDateDataNewSSS = $sss1fch[0];
                }
        
                $sss11fch = ($sss1fch[0] != 0) ? $sss1fch[0] : $penDateDataNewSSS;
                $sss22fch = ($sss2fch[0] != 0) ? $sss2fch[0] : $sss11fch;
                $sss33fch = ($sss3fch[0] != 0) ? $sss3fch[0] : $sss22fch;
                $sss44fch = ($sss4fch[0] != 0) ? $sss4fch[0] : $sss33fch;
                $sss55fch = ($sss5fch[0] != 0) ? $sss5fch[0] : $sss44fch;
        
        
                if ($gsis1fch[0] === 0) {
                    
                    $penDateDataNewGSIS = $lastTransactionDataGSISfch;
             
                } else {
                    $penDateDataNewGSIS = $gsis1fch[0];
                }
                
                
                $gsis11fch = ($gsis1fch[0] != 0) ? $gsis1fch[0] : $penDateDataNewGSIS;
                $gsis22fch = ($gsis2fch[0] != 0) ? $gsis2fch[0] : $gsis11fch;
                $gsis33fch = ($gsis3fch[0] != 0) ? $gsis3fch[0] : $gsis22fch;
                $gsis44fch = ($gsis4fch[0] != 0) ? $gsis4fch[0] : $gsis33fch;
                $gsis55fch = ($gsis5fch[0] != 0) ? $gsis5fch[0] : $gsis44fch;
        
                $totalInGSISfch = $gsis1fch[1]+$gsis2fch[1]+$gsis3fch[1]+$gsis4fch[1]+$gsis5fch[1];
                $totalOutGSISfch = $gsis1fch[2]+$gsis2fch[2]+$gsis3fch[2]+$gsis4fch[2]+$gsis5fch[2];
        
                $totalInSSSfch = $sss1fch[1]+$sss2fch[1]+$sss3fch[1]+$sss4fch[1]+$sss5fch[1];
                $totalOutSSSfch = $sss1fch[2]+$sss2fch[2]+$sss3fch[2]+$sss4fch[2]+$sss5fch[2];
        
                $body_content9 = <<<EOF
                <table>
                    <tr>
                        <th colspan="2" rowspan="3" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br>$branch_namenew</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSSfch[0]}</th>
                        <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSSfch</th>
                EOF;

                $header .= $body_content9;
        
                        $body_content10='';
                            
                        if ($day1_param > 0) {
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1fch[1].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1fch[2].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2fch[1].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2fch[2].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3fch[1].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3fch[2].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4fch[1].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4fch[2].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5fch[1].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5fch[2].'&nbsp;&nbsp;</th>';
                            $body_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55fch.'&nbsp;&nbsp;</th>';
                        }
                                
                            $header .= $body_content10;

                          $totalNetSSSfch = $totalInSSSfch - $totalOutSSSfch;
        
                    $body_content11 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalInSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalOutSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalNetSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$sss55fch</th>
                    
                    </tr>   
        
                    <tr>
        
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSISfch[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSISfch</th>
                    EOF;

                    $header .= $body_content11;

                    $body_content12 ='';
                    
                    if ($day1_param > 0) {
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1fch[1].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1fch[2].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2fch[1].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2fch[2].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3fch[1].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3fch[2].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4fch[1].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4fch[2].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5fch[1].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5fch[2].'&nbsp;&nbsp;</th>';
                        $body_content12 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55fch.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content12;


                $totalNetGSISfch = $totalInGSISfch - $totalOutGSISfch;
                $body_content13 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInGSISfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalOutGSISfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;"> $totalNetGSISfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$gsis55fch</th>              
                </tr>  

                EOF;

                $header .= $body_content13;

                $totalNewBegBalSSSGSISfch = $newBegBalValueSSSfch[0] + $newBegBalValueGSISfch[0];
                $totalLastTransactionBalGSISSSfch = $lastTransactionDataSSSfch + $lastTransactionDataGSISfch;
                $sssgsis11fch = $sss1fch[1] + $gsis1fch[1];
                $sssgsis12fch = $sss1fch[2] + $gsis1fch[2];
                $sssgsis13fch = $sss11fch + $gsis11fch;

                $sssgsis21fch = $sss2fch[1] + $gsis2fch[1];
                $sssgsis22fch = $sss2fch[2] + $gsis2fch[2];
                $sssgsis23fch = $sss22fch + $gsis22fch;

                $sssgsis31fch = $sss3fch[1] + $gsis3fch[1];
                $sssgsis32fch = $sss3fch[2] + $gsis3fch[2];
                $sssgsis33fch = $sss33fch + $gsis33fch;

                $sssgsis41fch = $sss4fch[1] + $gsis4fch[1];
                $sssgsis42fch = $sss4fch[2] + $gsis4fch[2];
                $sssgsis43fch = $sss44fch + $gsis44fch;

                $sssgsis51fch = $sss5fch[1] + $gsis5fch[1];
                $sssgsis52fch = $sss5fch[2] + $gsis5fch[2];
                $sssgsis53fch = $sss55fch + $gsis55fch;

                $totalGSISSSPenInfch = $totalInGSISfch + $totalInSSSfch;
                $totalGSISSSPenOutfch = $totalOutGSISfch + $totalOutSSSfch;

                $footer_content6 = <<<EOF
        
                <tr>
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSISfch</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSSfch</th>
                EOF;

                    $header .= $footer_content6;
    
                
                    $footer_content7 ='';
                    if ($day1_param > 0) {
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43fch.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52fch.'&nbsp;&nbsp;</th>';
                        $footer_content7 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53fch.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $footer_content7;

                $totalNetGSISSSSfch = $totalGSISSSPenInfch - $totalGSISSSPenOutfch;
    
                $footer_content8 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenInfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOutfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalNetGSISSSSfch&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$sssgsis53fch</th>    
                </tr>  
    
                <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
                EOF;

                $header .= $footer_content8;
    
               
                $totalBeginningBalSSSfch += $newBegBalValueSSSfch[0];
                $totalLastTransactionBalSSSfch += $lastTransactionDataSSSfch;

                $totalPenInDay1SSSfch += $sss1fch[1];
                $totalPenOutDay1SSSfch += $sss1fch[2];
                $totalPenNumDay1SSSfch += $sss11fch;

                $totalPenInDay2SSSfch += $sss2fch[1];
                $totalPenOutDay2SSSfch += $sss2fch[2];
                $totalPenNumDay2SSSfch += $sss22fch;

                $totalPenInDay3SSSfch += $sss3fch[1];
                $totalPenOutDay3SSSfch += $sss3fch[2];
                $totalPenNumDay3SSSfch += $sss33fch;

                $totalPenInDay4SSSfch += $sss4fch[1];
                $totalPenOutDay4SSSfch += $sss4fch[2];
                $totalPenNumDay4SSSfch += $sss44fch;

                $totalPenInDay5SSSfch += $sss5fch[1];
                $totalPenOutDay5SSSfch += $sss5fch[2];
                $totalPenNumDay5SSSfch += $sss55fch;

                $grandTotalPenInSSSfch += $totalInSSSfch;
                $grandTotalPenOutSSSfch += $totalOutSSSfch;

                //G

                $totalBeginningBalGSISfch += $newBegBalValueGSISfch[0];
                $totalLastTransactionBalGSISfch += $lastTransactionDataGSISfch;

                $totalPenInDay1GSISfch += $gsis1fch[1];
                $totalPenOutDay1GSISfch += $gsis1fch[2];
                $totalPenNumDay1GSISfch += $gsis11fch;

                $totalPenInDay2GSISfch += $gsis2fch[1];
                $totalPenOutDay2GSISfch += $gsis2fch[2];
                $totalPenNumDay2GSISfch += $gsis22fch;

                $totalPenInDay3GSISfch += $gsis3fch[1];
                $totalPenOutDay3GSISfch += $gsis3fch[2];
                $totalPenNumDay3GSISfch += $gsis33fch;

                $totalPenInDay4GSISfch += $gsis4fch[1];
                $totalPenOutDay4GSISfch += $gsis4fch[2];
                $totalPenNumDay4GSISfch += $gsis44fch;

                $totalPenInDay5GSISfch += $gsis5fch[1];
                $totalPenOutDay5GSISfch += $gsis5fch[2];
                $totalPenNumDay5GSISfch += $gsis55fch;

                $grandTotalPenInGSISfch += $totalInGSISfch;
                $grandTotalPenOutGSISfch += $totalOutGSISfch;

                $b1fch = $totalBeginningBalSSSfch + $totalBeginningBalGSISfch;
                $t1fch = $totalLastTransactionBalSSSfch + $totalLastTransactionBalGSISfch;
                $p11fch = $totalPenInDay1SSSfch  + $totalPenInDay1GSISfch;
                $p12fch = $totalPenOutDay1SSSfch + $totalPenOutDay1GSISfch;
                $p13fch = $totalPenNumDay1SSSfch + $totalPenNumDay1GSISfch;
                $p21fch = $totalPenInDay2SSSfch  + $totalPenInDay2GSISfch;
                $p22fch = $totalPenOutDay2SSSfch + $totalPenOutDay2GSISfch;
                $p23fch = $totalPenNumDay2SSSfch + $totalPenNumDay2GSISfch;
                $p31fch = $totalPenInDay3SSSfch  + $totalPenInDay3GSISfch;
                $p32fch = $totalPenOutDay3SSSfch + $totalPenOutDay3GSISfch;
                $p33fch = $totalPenNumDay3SSSfch + $totalPenNumDay3GSISfch;
                $p41fch = $totalPenInDay4SSSfch  + $totalPenInDay4GSISfch;
                $p42fch = $totalPenOutDay4SSSfch + $totalPenOutDay4GSISfch;
                $p43fch = $totalPenNumDay4SSSfch + $totalPenNumDay4GSISfch;
                $p51fch = $totalPenNumDay5SSSfch + $totalPenNumDay5GSISfch;
                $p52fch = $totalPenOutDay5SSSfch + $totalPenOutDay5GSISfch;
                $p53fch = $totalPenNumDay5SSSfch + $totalPenNumDay5GSISfch;
                $pi1fch = $grandTotalPenInSSSfch + $grandTotalPenInGSISfch;
                $po1fch = $grandTotalPenOutSSSfch + $grandTotalPenOutGSISfch;
                $pn1fch = $totalPenNumDay5SSSfch + $totalPenNumDay5GSISfch;
            }


            $additionalContent9 = <<<EOF
                        
            <table>
                        <tr>
                        <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem; color:gray; border: 1px solid black;"><span style="color: white;"></span><br>FCH TOTAL</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalBeginningBalSSSfch</th>
                        <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalSSSfch</th>
            EOF;

            $header .= $additionalContent9;
            
                        $additionalContent10 = '';
                                
                        if ($day1_param > 0) {
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1SSSfch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2SSSfch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3SSSfch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4SSSfch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5SSSfch.'&nbsp;&nbsp;</th>';
                            $additionalContent10 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5SSSfch.'&nbsp;&nbsp;</th>';
                        }
                        
                    $header .= $additionalContent10;
            
                        $grandTotalNetSSSfch = $grandTotalPenInSSSfch - $grandTotalPenOutSSSfch;
                        $additionalContent11 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenInSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalNetSSSfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5SSSfch</th>
                    
                        </tr>   

                        <tr>

                        <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">GSIS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalBeginningBalGSISfch</th>
                        <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISfch</th>
                        EOF;

                        $header .= $additionalContent11;
            
                            $additionalContent12 = '';
                                    
                            if ($day1_param > 0) {
                                $additionalContent12 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1GSISfch.'&nbsp;&nbsp;</th>';
                            }
                            if ($day2_param > 0) {
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2GSISfch.'&nbsp;&nbsp;</th>';
                            }
                            if ($day3_param > 0) {
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3GSISfch.'&nbsp;&nbsp;</th>';
                            }
                            if ($day4_param > 0) {
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4GSISfch.'&nbsp;&nbsp;</th>';
                            }
                            if ($day5_param > 0) {
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5GSISfch.'&nbsp;&nbsp;</th>';
                                $additionalContent12 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5GSISfch.'&nbsp;&nbsp;</th>';
                            }
                            
                        $header .= $additionalContent12;

                        $grandTotalNetGSISfch = $grandTotalPenInGSISfch - $grandTotalPenOutGSISfch;
            
            
                        $additionalContent13 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenInGSISfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutGSISfch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">0&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5GSISfch</th>
            
                    </tr>  
        
                    <tr>
                        <th style="padding:1.2rem 1.5rem; border: 1px solid black; text-align: center;">TOTAL</th>
                        <th style="border: 1px solid black; text-align: center;">$b1fch</th>
                        <th style="border: 1px solid black; text-align: center;">$t1fch</th>
                    EOF;

                        $header .= $additionalContent13;
            
                        $additionalContent14 = '';
                                
                        if ($day1_param > 0) {
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p11fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p12fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p13fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p21fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p22fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p23fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p31fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p32fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p33fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p41fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p42fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p43fch.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p51fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p52fch.'&nbsp;&nbsp;</th>';
                            $additionalContent14 .= '<th style="border: 1px solid black; text-align: right;">'.$p53fch.'&nbsp;&nbsp;</th>';
                        }
                        
                    $header .= $additionalContent14;
            
                        $p99fch = $pi1fch - $po1fch;
                        $additionalContent15 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$pi1fch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$po1fch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$p99fch&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$pn1fch</th>

                    </tr>  


                    <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
EOF;

$header .= $additionalContent15;

$header .= <<<EOF
<table>   

<tr><th colspan="25"></th></tr> 

<tr><th colspan="25"></th></tr> 


</table>

EOF;

$header .= <<<EOF
<table>
    <tr>  

        <td style="width:250px;text-align:left;font-size:8px; color: black;">Prepared by:</td>
    
        <td style="width:250px;text-align:left;font-size:8px; color: black;">Checked by:</td>
    
        <td style="width:250px;text-align:left;font-size:8px; color: black;">Noted by:</td>

    </tr>             
</table>
EOF;

$header .= <<<EOF
<table>
    <tr>  
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>


    </tr>             
</table>
EOF;


$header .= <<<EOF
<table>
    <tr>  
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$preparedBy</td>
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$checkedBy</td>
    
        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$notedBy</td>
   

    </tr>             
</table>
EOF;




    // Output the full header to PDF
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Pensioner Statistics Reports', 'I');
    
   }






public function showPensionerFilterRLC(){

        $connection = new connection;
        $connection->connect();
        $date = date('F j, Y');

        
        $preparedBy = $_GET['preparedBy'];
        $checkedBy = $_GET['checkedBy'];
        $notedBy = $_GET['notedBy'];

        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        // $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
        }
        $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
        $formattedDay1 = isset($dateRange[0]) ? date('j-M', strtotime($dateRange[0])) : null;
        
        $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
        $formattedDay2 = isset($dateRange[1]) ? date('j-M', strtotime($dateRange[1])) : null;
        
        $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
        $formattedDay3 = isset($dateRange[2]) ? date('j-M', strtotime($dateRange[2])) : null;
        
        $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
        $formattedDay4 = isset($dateRange[3]) ? date('j-M', strtotime($dateRange[3])) : null;
        
        $day5 = isset($dateRange[4]) ? $dateRange[4] : null;
        $formattedDay5 = isset($dateRange[4]) ? date('j-M', strtotime($dateRange[4])) : null;

        $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
        $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
        $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
        $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
        $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

        if (!empty($day1)) {
            if (!empty($day5)){
                $coveredDateStart = date('F j', strtotime($day1));
                $coveredDateEnd = date('-j, Y', strtotime($day5));
            } else if(!empty($day4)) {
                $coveredDateStart = date('F j', strtotime($day1));
                $coveredDateEnd = date('-j, Y', strtotime($day4));
            
            } else if(!empty($day3)) {
                $coveredDateStart = date('F j', strtotime($day1));
                $coveredDateEnd = date('-j, Y', strtotime($day3));

            } else if(!empty($day2)) {
                $coveredDateStart = date('F j', strtotime($day1));
                $coveredDateEnd = date('-j, Y', strtotime($day2));
            }else{
                $coveredDateStart = date('F j', strtotime($day1));
                $coveredDateEnd = date('-j, Y', strtotime($day1));

            }
            
        } 

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        $begBalCovered = 'Dec ' . $lastYearDate;
        $dateReportCoverage = $coveredDateStart . $coveredDateEnd;

        require_once('tcpdf_include.php');

        $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);  /*remove line on top of the page*/

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(10,7);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(5);

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

    // Initialize the header variable
    $header = '';

    $header_content20 = <<<EOF

        <style>
        tr, td{
            font-size:7rem;
        
        }
        tr, th{
            font-size:7rem;
            
        }
        </style>
                <table style="width: 100%;">

            <tr>
            
                <td style="width: 45%; text-align: left;"><p style="font-size: 12px;"><strong>RAMSGATE LENDING CORPORATION</strong></p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
                
            </tr>
            <tr>
                
                <td style="width: 45%; text-align: left;"><p style="font-size: 12px; color: gray;"><strong>BRANCH WEEKLY PENSIONER STATISTICS</strong></p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->

            </tr>
            <tr>
            
                <td style="width: 45%; text-align: left;"><p style="font-size: 12px; font-weight: 10;">PERIOD COVERED: $dateReportCoverage</p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            </tr>

            <tr>
            
                <td style="width: 45%; text-align: center;"><p style="font-size: 2px;"></p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            </tr>


            </table>

                <table>          
                    <tr>         
                        <th colspan="2"></th>
                        <th style="width: 90px;"></th>
                        <th></th>
                        <th></th>
        EOF;

        $header .= $header_content20;

        $header_content21 = '';

        if ($day1_param > 0) {
            $header_content21 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay1 . '</th>';
        }
        if ($day2_param > 0) {
            $header_content21 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay2 . '</th>';
        }
        if ($day3_param > 0) {
            $header_content21 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay3 . '</th>';
        }
        if ($day4_param > 0) {
            $header_content21 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay4 . '</th>';
        }
        if ($day5_param > 0) {
            $header_content21 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay5 . '</th>';
        }
    $header .= $header_content21;

        $header_content22 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; border: 1px solid black">TOTAL</th>
                        
                    </tr>   

                    <tr>
                        <th colspan="2"></th>
                        <th style="width: 90px;"></th>
                        <th></th>
                        <th></th>
        EOF;
                        $header .= $header_content22;
                
                            $header_content23 = '';
                
                            if ($day1_param > 0) {
                                $header_content23 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">MON</th>';
                            }
                            if ($day2_param > 0) {
                                $header_content23 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">TUE</th>';
                            }
                            if ($day3_param > 0) {
                                $header_content23 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">WED</th>';
                            }
                            if ($day4_param > 0) {
                                $header_content23 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">THU</th>';
                            }
                            if ($day5_param > 0) {
                                $header_content23 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">FRI</th>';
                            }
                
                            $header .= $header_content23;
                
                            $header_content24 = <<<EOF
            
            
                        <th></th>
                        <!-- <th colspan="4"></th> -->
                        
                    </tr>   

                    <tr>
                        <th style="border: 1px solid black; text-align: center;" colspan="2"><span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span></th>
                        <th style="width: 90px;"></th>
                        <th style="border: 1px solid black; text-align: center;">BEG<br>$begBalCovered</th>
                        <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>
                    EOF;

                        $header .= $header_content24;
            
                        $header_content25 = '';
            
                        if ($day1_param > 0) {
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                            $header_content25 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day2_param > 0) {
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                            $header_content25 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day3_param > 0) {
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                            $header_content25 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day4_param > 0) {
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                            $header_content25 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day5_param > 0) {
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                            $header_content25 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                            $header_content25 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
            
                        $header .= $header_content25;
            
            
                        $header_content26 = <<<EOF
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                        <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                        <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                        <th style="border: 1px solid black; text-align: center; font-size: 7px;"><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                    </tr>   

                    <tr>
                        <td colspan="26"></td>
                    </tr>
                    </table>
    EOF; 
                $header .= $header_content26;

                $SSS  = 'SSS';
                $GSIS = 'GSIS';
                $PACERS  = 'PACERS';
                $PVAO = 'PVAO';
                $PNP  = 'PNP';
                $OLR = 'OLR';
                $OLR_R_E  = 'OLR-REAL ESTATE';
                $OLR_H_L = 'OLR-HOUSE LOAN';
                $OLR_C = 'OLR-CHATTEL';

                $totalBeginningBalSSS = 0;
                $totalLastTransactionBalSSS = 0;

                $totalPenInDay1SSS = 0;
                $totalPenOutDay1SSS = 0;
                $totalPenNumDay1SSS = 0;

                $totalPenInDay2SSS = 0;
                $totalPenOutDay2SSS = 0;
                $totalPenNumDay2SSS = 0;

                $totalPenInDay3SSS = 0;
                $totalPenOutDay3SSS = 0;
                $totalPenNumDay3SSS = 0;

                $totalPenInDay4SSS = 0;
                $totalPenOutDay4SSS = 0;
                $totalPenNumDay4SSS = 0;

                $totalPenInDay5SSS = 0;
                $totalPenOutDay5SSS = 0;
                $totalPenNumDay5SSS = 0;

                $grandTotalPenInSSS = 0;
                $grandTotalPenOutSSS = 0;

                //GSIS

                $totalBeginningBalGSIS = 0;
                $totalLastTransactionBalGSIS = 0;

                $totalPenInDay1GSIS = 0;
                $totalPenOutDay1GSIS = 0;
                $totalPenNumDay1GSIS = 0;

                $totalPenInDay2GSIS = 0;
                $totalPenOutDay2GSIS = 0;
                $totalPenNumDay2GSIS = 0;

                $totalPenInDay3GSIS = 0;
                $totalPenOutDay3GSIS = 0;
                $totalPenNumDay3GSIS = 0;

                $totalPenInDay4GSIS = 0;
                $totalPenOutDay4GSIS = 0;
                $totalPenNumDay4GSIS = 0;

                $totalPenInDay5GSIS = 0;
                $totalPenOutDay5GSIS = 0;
                $totalPenNumDay5GSIS = 0;

                $grandTotalPenInGSIS = 0;
                $grandTotalPenOutGSIS = 0;

                //PVAO

                $totalBeginningBalPVAO = 0;
                $totalLastTransactionBalPVAO = 0;
        
                $totalPenInDay1PVAO = 0;
                $totalPenOutDay1PVAO = 0;
                $totalPenNumDay1PVAO = 0;
        
                $totalPenInDay2PVAO = 0;
                $totalPenOutDay2PVAO = 0;
                $totalPenNumDay2PVAO = 0;
        
                $totalPenInDay3PVAO = 0;
                $totalPenOutDay3PVAO = 0;
                $totalPenNumDay3PVAO = 0;
        
                $totalPenInDay4PVAO = 0;
                $totalPenOutDay4PVAO = 0;
                $totalPenNumDay4PVAO = 0;
        
                $totalPenInDay5PVAO = 0;
                $totalPenOutDay5PVAO = 0;
                $totalPenNumDay5PVAO = 0;
        
                $grandTotalPenInPVAO = 0;
                $grandTotalPenOutPVAO = 0;

                //PNP

                $totalBeginningBalPNP = 0;
                $totalLastTransactionBalPNP = 0;

                $totalPenInDay1PNP = 0;
                $totalPenOutDay1PNP = 0;
                $totalPenNumDay1PNP = 0;

                $totalPenInDay2PNP = 0;
                $totalPenOutDay2PNP = 0;
                $totalPenNumDay2PNP = 0;

                $totalPenInDay3PNP = 0;
                $totalPenOutDay3PNP = 0;
                $totalPenNumDay3PNP = 0;

                $totalPenInDay4PNP = 0;
                $totalPenOutDay4PNP = 0;
                $totalPenNumDay4PNP = 0;

                $totalPenInDay5PNP = 0;
                $totalPenOutDay5PNP = 0;
                $totalPenNumDay5PNP = 0;

                $grandTotalPenInPNP = 0;
                $grandTotalPenOutPNP = 0;

                // OLR 

                $totalBeginningBalOLR = 0;
                $totalLastTransactionBalOLR = 0;

                $totalPenInDay1OLR = 0;
                $totalPenOutDay1OLR = 0;
                $totalPenNumDay1OLR = 0;

                $totalPenInDay2OLR = 0;
                $totalPenOutDay2OLR = 0;
                $totalPenNumDay2OLR = 0;

                $totalPenInDay3OLR = 0;
                $totalPenOutDay3OLR = 0;
                $totalPenNumDay3OLR = 0;

                $totalPenInDay4OLR = 0;
                $totalPenOutDay4OLR = 0;
                $totalPenNumDay4OLR = 0;

                $totalPenInDay5OLR = 0;
                $totalPenOutDay5OLR = 0;
                $totalPenNumDay5OLR = 0;

                $grandTotalPenInOLR = 0;
                $grandTotalPenOutOLR = 0;

                // OLR-REAL ESTATE

                $totalBeginningBalOLR_R_E = 0;
                $totalLastTransactionBalOLR_R_E = 0;
        
                $totalPenInDay1OLR_R_E = 0;
                $totalPenOutDay1OLR_R_E = 0;
                $totalPenNumDay1OLR_R_E = 0;
        
                $totalPenInDay2OLR_R_E = 0;
                $totalPenOutDay2OLR_R_E = 0;
                $totalPenNumDay2OLR_R_E = 0;
        
                $totalPenInDay3OLR_R_E = 0;
                $totalPenOutDay3OLR_R_E = 0;
                $totalPenNumDay3OLR_R_E = 0;
        
                $totalPenInDay4OLR_R_E = 0;
                $totalPenOutDay4OLR_R_E = 0;
                $totalPenNumDay4OLR_R_E = 0;
        
                $totalPenInDay5OLR_R_E = 0;
                $totalPenOutDay5OLR_R_E = 0;
                $totalPenNumDay5OLR_R_E = 0;
        
                $grandTotalPenInOLR_R_E = 0;
                $grandTotalPenOutOLR_R_E = 0;

                // OLR-HOUSING LOAN

                $totalBeginningBalOLR_H_L = 0;
                $totalLastTransactionBalOLR_H_L = 0;
        
                $totalPenInDay1OLR_H_L = 0;
                $totalPenOutDay1OLR_H_L = 0;
                $totalPenNumDay1OLR_H_L = 0;
        
                $totalPenInDay2OLR_H_L = 0;
                $totalPenOutDay2OLR_H_L = 0;
                $totalPenNumDay2OLR_H_L = 0;
        
                $totalPenInDay3OLR_H_L = 0;
                $totalPenOutDay3OLR_H_L = 0;
                $totalPenNumDay3OLR_H_L = 0;
        
                $totalPenInDay4OLR_H_L = 0;
                $totalPenOutDay4OLR_H_L = 0;
                $totalPenNumDay4OLR_H_L = 0;
        
                $totalPenInDay5OLR_H_L = 0;
                $totalPenOutDay5OLR_H_L = 0;
                $totalPenNumDay5OLR_H_L = 0;
        
                $grandTotalPenInOLR_H_L = 0;
                $grandTotalPenOutOLR_H_L = 0;

                // OLR-CHATTEL

                $totalBeginningBalOLR_C = 0;
                $totalLastTransactionBalOLR_C = 0;
        
                $totalPenInDay1OLR_C = 0;
                $totalPenOutDay1OLR_C = 0;
                $totalPenNumDay1OLR_C = 0;
        
                $totalPenInDay2OLR_C = 0;
                $totalPenOutDay2OLR_C = 0;
                $totalPenNumDay2OLR_C = 0;
        
                $totalPenInDay3OLR_C = 0;
                $totalPenOutDay3OLR_C = 0;
                $totalPenNumDay3OLR_C = 0;
        
                $totalPenInDay4OLR_C = 0;
                $totalPenOutDay4OLR_C = 0;
                $totalPenNumDay4OLR_C = 0;
        
                $totalPenInDay5OLR_C = 0;
                $totalPenOutDay5OLR_C = 0;
                $totalPenNumDay5OLR_C = 0;  

                $grandTotalPenInOLR_C = 0;
                $grandTotalPenOutOLR_C = 0;

                
                $preparedBy = $_GET['preparedBy'];
                $checkedBy = $_GET['checkedBy'];
                $notedBy = $_GET['notedBy'];
        
                $RLC_branch = 'RLC';

                $data = (new ControllerPensioner)->ctrGetBranchesNames($RLC_branch);

                foreach ($data as &$item1) {    

                    $branch_name = $item1['branch_name'];       
                    $branch_namenew = substr($branch_name, 3);
                
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
        
                    $pnp1 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day1, $PNP);
                    $pnp2 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day2, $PNP);
                    $pnp3 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day3, $PNP);
                    $pnp4 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day4, $PNP);
                    $pnp5 = (new ControllerPensioner)->ctrShowDailyPensioner($branch_name, $day5, $PNP);
            
                    $newBegBalValueSSS = 0;
                    $newBegBalValueGSIS = 0;
                    $newBegBalValuePVAO = 0;
                    $newBegBalValueOLR_R_E = 0;

                    
                    $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        
                    $firstDayOfYear = '1990-01-01';
                    $lastDayOfYear = $lastYearDate . '-12-31';
            
                    $newBegBalValueSSS = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $SSS);
                    
                    $newBegBalValueGSIS =(new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $GSIS);
        
                    $newBegBalValuePVAO = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $PVAO);
        
                    $newBegBalValueOLR = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR);
        
                    $newBegBalValueOLR_R_E = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_R_E);
        
                    $newBegBalValueOLR_H_L = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_H_L);
        
                    $newBegBalValueOLR_C = (new ControllerPensioner)->ctrShowBegBalPensioner($branch_name, $firstDayOfYear, $lastDayOfYear, $OLR_C);
        
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
        
                    $totalInOLR_C = $olr_c1[1]+$olr_c2[1]+$olr_c3[1]+$olr_c4[1]+$olr_c5[1];
                    $totalOutOLR_C = $olr_c1[2]+$olr_c2[2]+$olr_c3[2]+$olr_c4[2]+$olr_c5[2];
                    
                    if ($branch_name == 'RLC BURGOS') {

                        $body_content14 = <<<EOF
                        <table>
                            <tr>
                                <th colspan="2" rowspan="8" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br><br><br>$branch_namenew</th>
                                <th style="width: 90px;border: 1px solid black; padding:10rem 1rem;text-align:center;">SSS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                        EOF;

                    $header .= $body_content14;

                    $body_content15 ='';
                    
                    if ($day1_param > 0) {
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                        $body_content15 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content15;

                $totalNetSSS = $totalInSSS - $totalOutSSS;
           
                $body_content16 = <<<EOF
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$sss55</th>
                            
                            </tr>               
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                EOF;

                    $header .= $body_content16;

                    $body_content17 ='';
                    
                    if ($day1_param > 0) {
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                        $body_content17 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content17;


                $totalNetGSIS = $totalInGSIS - $totalOutGSIS;
                $body_content18 = <<<EOF

                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$gsis55</th>  

                            </tr>               
                            <tr>
        
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PVAO</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePVAO[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPVAO</th>
                EOF;

                                $header .= $body_content18;
            
                                $body_content19 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pvao1[1].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao1[2].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[1].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[2].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[1].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[2].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[1].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[2].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[1].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[2].'&nbsp;&nbsp;</th>';
                                    $body_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content19;
            
                            $totalNetPVAO = $totalInPVAO - $totalInPVAO;
                       
                            $body_content20 = <<<EOF
                        
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pvao55</th>
                            
                            </tr>  
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PNP</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePNP[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPNP</th>
                            EOF;

                            $header .= $body_content20;
            
                                $body_content21 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pnp1[1].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp1[2].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[1].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[2].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[1].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[2].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[1].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[2].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[1].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[2].'&nbsp;&nbsp;</th>';
                                    $body_content21 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content21;

                            $totalNetPNP = $totalInPNP - $totalOutPNP;
            
                            $body_content22 = <<<EOF
            
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pnp55</th>
                    
                            </tr>  
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR</th>
                            EOF;

                                $header .= $body_content22;
            
                                $body_content23 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr1[1].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr1[2].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr2[1].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr2[2].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr3[1].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr3[2].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr4[1].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr4[2].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr5[1].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr5[2].'&nbsp;&nbsp;</th>';
                                    $body_content23 .= '<th style="border: 1px solid black; text-align: right;">'.$olr55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content23;

                            $totalNetOLR = $totalInOLR - $totalOutOLR;

                            $body_content24 = <<<EOF
            
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;"> $totalNetOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr55</th>
                    
                            </tr>  
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_R_E[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_R_E</th>
                            EOF;

                                $header .= $body_content24;
            
                                $body_content25 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_r_e1[1].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e1[2].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[1].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[2].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[1].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[2].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[1].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[2].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[1].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[2].'&nbsp;&nbsp;</th>';
                                    $body_content25 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content25;

                            $totalNetOLR = $totalInOLR - $totalOutOLR;
       
                            $body_content26 = <<<EOF

                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_r_e55</th>
                    
                            </tr>  
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR-HOUSING LOAN</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_H_L[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_H_L</th>
                            EOF;

                                $header .= $body_content26;
            
                                $body_content27 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_h_l1[1].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l1[2].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l2[1].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l2[2].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l3[1].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l3[2].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l4[1].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l4[2].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l5[1].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l5[2].'&nbsp;&nbsp;</th>';
                                    $body_content27 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content27;

                            $totalNetOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

                            $body_content28 = <<<EOF
              
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_h_l55</th>
                    
                            </tr>  
                      
                        EOF;

                        $header .= $body_content28;
                    


                    $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
                    $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
                    $sssgsis11 = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
                    $sssgsis12 = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
                    $sssgsis13 = $sss11   + $gsis11 + $pvao11 + $pnp11 + $olr11 + $olr_r_e11 + $olr_h_l11;

                    $sssgsis21 = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
                    $sssgsis22 = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
                    $sssgsis23 = $sss22   + $gsis22 + $pvao22 + $pnp22 + $olr22 + $olr_r_e22 + $olr_h_l22;

                    $sssgsis31 = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
                    $sssgsis32 = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
                    $sssgsis33 = $sss33   + $gsis33 +$pvao33 + $pnp33 + $olr33 + $olr_r_e33 + $olr_h_l33;

                    $sssgsis41 = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
                    $sssgsis42 = $sss4[2] + $gsis4[2] + $pvao4[2] + $pnp4[2] + $olr4[2] + $olr_r_e4[2] + $olr_h_l4[2];
                    $sssgsis43 = $sss44   +$gsis44 + $pvao44 + $pnp44 + $olr44 + $olr_r_e44 + $olr_h_l44;

                    $sssgsis51 = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                    $sssgsis52 = $sss5[2] + $gsis5[2] + $pvao5[2] + $pnp5[2] + $olr5[2] + $olr_r_e5[2] + $olr_h_l5[2];
                    $sssgsis53 = $sss55   + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
       
                    $totalGSISSSPenIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
                    $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;

                    $grandTotalSSSGSIS = $sss55 + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
         

                    $footer_content9 = <<<EOF
            
                    <tr>
                        <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                        <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                        <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
EOF;

                    $header .= $footer_content9;
    
                
                    $footer_content10 ='';
                    if ($day1_param > 0) {
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                        $footer_content10 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $footer_content10;

                $totalNetALL = $totalGSISSSPenIn - $totalGSISSSPenOut;
    
                $footer_content11 = <<<EOF

                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalNetALL&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$grandTotalSSSGSIS</th>    
                    </tr>  
        
                    <tr><td colspan="25" class="invisible"></td></tr>
                        </table>
                EOF;
                $header .= $footer_content11;


                    } else if($branch_name == 'RLC KALIBO' ) {

                        $body_content29 = <<<EOF
                        <table>
                            <tr>
                                <th colspan="2" rowspan="5" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br><br>$branch_namenew</th>
                                <th style="width: 90px;border: 1px solid black; padding:3rem 1rem;text-align:center;">SSS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                              
                        EOF;

                                $header .= $body_content29;
            
                                $body_content30 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                                    $body_content30 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content30;

                            $totalNetSSS = $totalInSSS - $totalOutSSS;
  
                            $body_content31 = <<<EOF

                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$sss55</th>
                            
                            </tr>               
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                            EOF;

                    $header .= $body_content31;

                    $body_content32 ='';
                    
                    if ($day1_param > 0) {
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                        $body_content32 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                    }
                    
                  
                    $header .= $body_content32;

                    $totalNetGSIS = $totalInGSIS - $totalOutGSIS;
  
                    $body_content33 = <<<EOF

                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;"> $totalNetGSIS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$gsis55</th>
                    
                    </tr>               
                            <tr>
        
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PVAO</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePVAO[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPVAO</th>
                    EOF;

                                $header .= $body_content33;
            
                                $body_content34 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pvao1[1].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao1[2].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[1].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[2].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[1].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[2].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[1].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[2].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[1].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[2].'&nbsp;&nbsp;</th>';
                                    $body_content34 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content34;

                            $totalNetPVAO = $totalInPVAO - $totalOutPVAO;
             
                            $body_content35 = <<<EOF

                            <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">0&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pvao55</th>
                            
                            </tr>  
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PNP</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePNP[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPNP</th>
                            EOF;

                                $header .= $body_content35;
            
                                $body_content36 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pnp1[1].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp1[2].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[1].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[2].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[1].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[2].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[1].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[2].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[1].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[2].'&nbsp;&nbsp;</th>';
                                    $body_content36 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content36;

                            $totalNetPNP = $totalInPNP - $totalOutPNP;
                            $body_content37 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pnp55</th>
                    
                            </tr>                         
                      
                        EOF;

                        $header .= $body_content37;
                    


                        $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0];
                        $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP;
                        $sssgsis11 = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1];
                        $sssgsis12 = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2];
                        $sssgsis13 = $sss11   + $gsis11 + $pvao11 + $pnp11;

                        $sssgsis21 = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1];
                        $sssgsis22 = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2];
                        $sssgsis23 = $sss22   + $gsis22 + $pvao22 + $pnp22;

                        $sssgsis31 = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1];
                        $sssgsis32 = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2];
                        $sssgsis33 = $sss33   + $gsis33 +$pvao33 + $pnp33;

                        $sssgsis41 = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1];
                        $sssgsis42 = $sss4[2] + $gsis4[2] + $pvao4[2] + $pnp4[2];
                        $sssgsis43 = $sss44   +$gsis44 + $pvao44 + $pnp44;

                        $sssgsis51 = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1];
                        $sssgsis52 = $sss5[2] + $gsis5[2] + $pvao5[2] + $pnp5[2];
                        $sssgsis53 = $sss55   + $gsis55 + $pvao55 + $pnp55;
        
                        $totalGSISSSPenIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP;
                        $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP;

                        $grandTotalSSSGSIS = $sss55 + $gsis55 + $pvao55 + $pnp55;
            

                        $footer_content12 = <<<EOF
                
                        <tr>
                            <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                            <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                            <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
                        EOF;

                            $header .= $footer_content12;
            
                        
                            $footer_content13 ='';
                            if ($day1_param > 0) {
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                            }
                            if ($day2_param > 0) {
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                            }
                            if ($day3_param > 0) {
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                            }
                            if ($day4_param > 0) {
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                            }
                            if ($day5_param > 0) {
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                                $footer_content13 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                            }
                            
                        $header .= $footer_content13;

                        $totalNetAll = $totalGSISSSPenIn - $totalGSISSSPenOut;
            
                        $footer_content14 = <<<EOF
                            <th style="width: 10px;"></th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;">$totalNetAll&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: center;">$grandTotalSSSGSIS</th>    
                        </tr>  
            
                        <tr><td colspan="25" class="invisible"></td></tr>
                            </table>
                        EOF;

                        $header .= $footer_content14;

                    } else if($branch_name == 'RLC SINGCANG'){ 

                        $body_content38 = <<<EOF
                        <table>
                            <tr>
                                <th colspan="2" rowspan="8" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br><br><br>$branch_namenew</th>
                                <th style="width: 90px;border: 1px solid black; padding: 25rem 1rem;text-align:center;">SSS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                        EOF;

                        $header .= $body_content38;
            
                                $body_content39 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                                    $body_content39 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content39;

                            $totalNetSSS = $totalInSSS - $totalOutSSS;
                            $body_content40 = <<<EOF
              
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$sss55</th>
                            
                            </tr>               
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                            EOF;

                                $header .= $body_content40;
            
                                $body_content41 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                                    $body_content41 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content41;
                            $totalNetGSIS = $totalInGSIS - $totalOutGSIS;
                            $body_content42 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$gsis55</th>  

                            </tr>               
                            <tr>
        
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PVAO</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePVAO[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPVAO</th>
                            EOF;

                            $header .= $body_content42;
            
                                $body_content43 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pvao1[1].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao1[2].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[1].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[2].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[1].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[2].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[1].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[2].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[1].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[2].'&nbsp;&nbsp;</th>';
                                    $body_content43 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content43;
                            $totalNetPVAO = $totalInPVAO - $totalOutPVAO;
                            $body_content44 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetPVAO&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pvao55</th>
                            
                            </tr>  
               
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem; text-align:center;">OLR</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR</th>
                            EOF;

                            $header .= $body_content44;
            
                                $body_content45 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr1[1].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr1[2].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr2[1].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr2[2].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr3[1].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr3[2].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr4[1].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr4[2].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr5[1].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr5[2].'&nbsp;&nbsp;</th>';
                                    $body_content45 .= '<th style="border: 1px solid black; text-align: right;">'.$olr55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content45;

                            $totalNetOLR = $totalInOLR - $totalOutOLR;
                            $body_content46 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr55</th>
                    
                            </tr>  
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_R_E[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_R_E</th>
                            EOF;

                            $header .= $body_content46;
            
                                $body_content47 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_r_e1[1].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e1[2].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[1].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[2].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[1].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[2].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[1].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[2].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[1].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[2].'&nbsp;&nbsp;</th>';
                                    $body_content47 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content47;
                            $totalNetOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

                            $body_content48 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_r_e55</th>
                    
                            </tr>  
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR-HOUSING LOAN</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_H_L[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_H_L</th>
                            EOF;

                    $header .= $body_content48;

                    $body_content49 ='';
                    
                    if ($day1_param > 0) {
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_h_l1[1].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l1[2].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l2[1].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l2[2].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l3[1].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l3[2].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l4[1].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l4[2].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l5[1].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l5[2].'&nbsp;&nbsp;</th>';
                        $body_content49 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_h_l55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content49;

                $totalNetOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

                $body_content50 = <<<EOF

                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR_H_L&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_h_l55</th>
                    
                            </tr>  
                            <tr>

                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center">OLR-CHATTEL</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_C[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_C</th>
                    EOF;

                    $header .= $body_content50;

                    $body_content51 ='';
                    
                    if ($day1_param > 0) {
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_c1[1].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c1[2].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c2[1].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c2[2].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c3[1].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c3[2].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c4[1].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c4[2].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c5[1].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c5[2].'&nbsp;&nbsp;</th>';
                        $body_content51 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_c55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content51;
                $totalNetOLR_C = $totalInOLR_C - $totalOutOLR_C;
                $body_content52 = <<<EOF

                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_C&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_C&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR_C&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_c55</th>
                    
                            </tr> 
                      
                    EOF;

                        $header .= $body_content52;
                    
                        $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValueOLR_C[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
                        $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataOLR_C + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
                        $sssgsis11 = $sss1[1] + $gsis1[1] + $pvao1[1] + $olr_c1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
                        $sssgsis12 = $sss1[2] + $gsis1[2] + $pvao1[2] + $olr_c1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
                        $sssgsis13 = $sss11   + $gsis11 + $pvao11 + $olr_c11 + $olr11 + $olr_r_e11 + $olr_h_l11;
    
                        $sssgsis21 = $sss2[1] + $gsis2[1] + $pvao2[1] + $olr_c2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
                        $sssgsis22 = $sss2[2] + $gsis2[2] + $pvao2[2] + $olr_c2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
                        $sssgsis23 = $sss22   + $gsis22 + $pvao22 + $olr_c22 + $olr22 + $olr_r_e22 + $olr_h_l22;
    
                        $sssgsis31 = $sss3[1] + $gsis3[1] + $pvao3[1] + $olr_c3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
                        $sssgsis32 = $sss3[2] + $gsis3[2] + $pvao3[2] + $olr_c3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
                        $sssgsis33 = $sss33   + $gsis33 +$pvao33 + $olr_c33 + $olr33 + $olr_r_e33 + $olr_h_l33;
    
                        $sssgsis41 = $sss4[1] + $gsis4[1] + $pvao4[1] + $olr_c4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
                        $sssgsis42 = $sss4[2] + $gsis4[2] + $pvao4[2] + $olr_c4[2] + $olr4[2] + $olr_r_e4[2] + $olr_h_l4[2];
                        $sssgsis43 = $sss44   +$gsis44 + $pvao44 + $olr_c44 + $olr44 + $olr_r_e44 + $olr_h_l44;
    
                        $sssgsis51 = $sss5[1] + $gsis5[1] + $pvao5[1] + $olr_c5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                        $sssgsis52 = $sss5[2] + $gsis5[2] + $pvao5[2] + $olr_c5[2] + $olr5[2] + $olr_r_e5[2] + $olr_h_l5[2];
                        $sssgsis53 = $sss55   + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
           
                        $totalGSISSSPenIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInOLR_C + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
                        $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutOLR_C + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;
    
                        $grandTotalSSSGSIS = $sss55 + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
         

                        $footer_content15 = <<<EOF
                
                        <tr>
                            <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                            <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                            <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
EOF;

                            $header .= $footer_content15;
            
                        
                            $footer_content16 ='';
                            if ($day1_param > 0) {
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                            }
                            if ($day2_param > 0) {
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                            }
                            if ($day3_param > 0) {
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                            }
                            if ($day4_param > 0) {
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                            }
                            if ($day5_param > 0) {
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                                $footer_content16 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                            }
                            
                        $header .= $footer_content16;
                        $totalNetALLs = $totalGSISSSPenIn - $totalGSISSSPenOut;
                        $footer_content17 = <<<EOF
                            <th style="width: 10px;"></th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;"> $totalNetALLs&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: center;">$grandTotalSSSGSIS</th>    
                        </tr>  
            
                        <tr><td colspan="25" class="invisible"></td></tr>
                            </table>
                        EOF;

                        $header .= $footer_content17;
            

                    } else if($branch_name == 'RLC ANTIQUE'){

                        $body_content53 = <<<EOF
                        <table>
                            <tr>
                                <th colspan="2" rowspan="5" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br><br>$branch_namenew</th>
                                <th style="width: 90px;border: 1px solid black; padding:15rem 1rem;text-align:center;">SSS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                        EOF;

                                $header .= $body_content53;
            
                                $body_content54 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                                    $body_content54 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content54;

                            $totalNetSSS = $totalInSSS - $totalOutSSS;
                            $body_content55 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$sss55</th>
                            
                            </tr>               
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                            EOF;

                                $header .= $body_content55;
            
                                $body_content56 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                                    $body_content56 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content56;

                            $totalNetGSIS = $totalInGSIS - $totalOutGSIS;
                            $body_content57 = <<<EOF
            
                                <th style="width: 10px;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;"> $totalNetGSIS&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$gsis55</th>  

                            </tr>               
                            <tr>
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValueOLR_R_E[0]}&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataOLR_R_E&nbsp;&nbsp;</th>
                            EOF;

                                $header .= $body_content57;
            
                                $body_content58 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$olr_r_e1[1].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e1[2].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[1].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e2[2].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[1].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e3[2].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[1].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e4[2].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[1].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e5[2].'&nbsp;&nbsp;</th>';
                                    $body_content58 .= '<th style="border: 1px solid black; text-align: right;">'.$olr_r_e55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content58;

                            $totalNetOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;
                            $body_content59 = <<<EOF
            
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalNetOLR_R_E&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$olr_r_e55</th>
                    
                            </tr> 
                            <tr>
                    
                                <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">PNP</th>
                                <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePNP[0]}&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPNP&nbsp;&nbsp;</th>
                            EOF;

                                $header .= $body_content59;
            
                                $body_content60 ='';
                                
                                if ($day1_param > 0) {
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pnp1[1].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp1[2].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp11.'&nbsp;&nbsp;</th>';
                                }
                                if ($day2_param > 0) {
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[1].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp2[2].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp22.'&nbsp;&nbsp;</th>';
                                }
                                if ($day3_param > 0) {
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[1].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp3[2].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp33.'&nbsp;&nbsp;</th>';
                                }
                                if ($day4_param > 0) {
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[1].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp4[2].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp44.'&nbsp;&nbsp;</th>';
                                }
                                if ($day5_param > 0) {
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[1].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp5[2].'&nbsp;&nbsp;</th>';
                                    $body_content60 .= '<th style="border: 1px solid black; text-align: right;">'.$pnp55.'&nbsp;&nbsp;</th>';
                                }
                                
                            $header .= $body_content60;

                            $totalNetPNP = $totalInPNP - $totalOutPNP;
                            $body_content61 = <<<EOF
            
                                <th style="visibility:hidden;"></th>
                                <th style="border: 1px solid black; text-align: right;">$totalInPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;">$totalOutPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: right;"> $totalNetPNP&nbsp;&nbsp;</th>
                                <th style="border: 1px solid black; text-align: center;">$pnp55</th>
                    
                            </tr>                          
                   
                        EOF;
                        $header .= $body_content61;
                    
                        $totalNewBegBalSSSGSIS = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePNP[0] + $newBegBalValueOLR_R_E[0];
                        $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPNP + $lastTransactionDataOLR_R_E;
                        $sssgsis11 = $sss1[1] + $gsis1[1] + $pnp1[1] + $olr_r_e1[1];
                        $sssgsis12 = $sss1[2] + $gsis1[2] + $pnp1[2] + $olr_r_e1[2];
                        $sssgsis13 = $sss11   + $gsis11 + $pnp11 + $olr_r_e11;
    
                        $sssgsis21 = $sss2[1] + $gsis2[1] + $pnp2[1] + $olr_r_e2[1];
                        $sssgsis22 = $sss2[2] + $gsis2[2] + $pnp2[2] + $olr_r_e2[2];
                        $sssgsis23 = $sss22   + $gsis22 + $pnp22 + $olr_r_e22;
    
                        $sssgsis31 = $sss3[1] + $gsis3[1] + $pnp3[1] + $olr_r_e3[1];
                        $sssgsis32 = $sss3[2] + $gsis3[2] + $pnp3[2] + $olr_r_e3[2];
                        $sssgsis33 = $sss33   + $gsis33 +$pnp33 + $olr_r_e33;
    
                        $sssgsis41 = $sss4[1] + $gsis4[1] + $pnp4[1] + $olr_r_e4[1];
                        $sssgsis42 = $sss4[2] + $gsis4[2] + $pnp4[1] + $olr_r_e4[1];
                        $sssgsis43 = $sss44   +$gsis44 + $pnp44 + $olr_r_e44;
    
                        $sssgsis51 = $sss5[1] + $gsis5[1] + $pnp5[1] + $olr_r_e5[1];
                        $sssgsis52 = $sss5[2] + $gsis5[2] + $pnp5[1] + $olr_r_e5[1];
                        $sssgsis53 = $sss55   + $gsis55 + $pnp55 + $olr_r_e55;
           
                        $totalGSISSSPenIn = $totalInGSIS + $totalInSSS + $totalInPNP + $totalInOLR_R_E;
                        $totalOutGSIS + $totalOutSSS + $totalOutPNP + $totalOutOLR_R_E;
    
                        $grandTotalSSSGSIS = $sss55 + $gsis55 + $pnp55 + $olr_r_e55;
         

                        $footer_content18 = <<<EOF
                
                        <tr>
                            <th style="width: 90px;border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                            <th style="border: 1px solid black; text-align: center;">$totalNewBegBalSSSGSIS</th>
                            <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
                        EOF;

                            $header .= $footer_content18;
            
                        
                            $footer_content19 ='';
                            if ($day1_param > 0) {
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                            }
                            if ($day2_param > 0) {
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                            }
                            if ($day3_param > 0) {
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                            }
                            if ($day4_param > 0) {
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                            }
                            if ($day5_param > 0) {
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                                $footer_content19 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                            }
                            
                        $header .= $footer_content19;

                        $totalNetAllR = $totalGSISSSPenIn - $totalGSISSSPenOut;
            
                        $footer_content20 = <<<EOF
                            <th style="width: 10px;"></th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: right;"> $totalNetAllR&nbsp;&nbsp;</th>
                            <th style="border: 1px solid black; text-align: center;">$grandTotalSSSGSIS</th>    
                        </tr>  
            
                        <tr><td colspan="25" class="invisible"></td></tr>
                            </table>
                        EOF;

                        $header .= $footer_content20;

                    }

                        //SSS//

                        $totalBeginningBalSSS += $newBegBalValueSSS[0];
                        $totalLastTransactionBalSSS += $lastTransactionDataSSS;

                        $totalPenInDay1SSS += $sss1[1];
                        $totalPenOutDay1SSS += $sss1[2];
                        $totalPenNumDay1SSS += $sss11;

                        $totalPenInDay2SSS += $sss2[1];
                        $totalPenOutDay2SSS += $sss2[2];
                        $totalPenNumDay2SSS += $sss22;

                        $totalPenInDay3SSS += $sss3[1];
                        $totalPenOutDay3SSS += $sss3[2];
                        $totalPenNumDay3SSS += $sss33;

                        $totalPenInDay4SSS += $sss4[1];
                        $totalPenOutDay4SSS += $sss4[2];
                        $totalPenNumDay4SSS += $sss44;

                        $totalPenInDay5SSS += $sss5[1];
                        $totalPenOutDay5SSS += $sss5[2];
                        $totalPenNumDay5SSS += $sss55;

                        $grandTotalPenInSSS += $totalInSSS;
                        $grandTotalPenOutSSS += $totalOutSSS;

                        //GSIS

                        $totalBeginningBalGSIS += $newBegBalValueGSIS[0];
                        $totalLastTransactionBalGSIS += $lastTransactionDataGSIS;

                        $totalPenInDay1GSIS += $gsis1[1];
                        $totalPenOutDay1GSIS += $gsis1[2];
                        $totalPenNumDay1GSIS += $gsis11;

                        $totalPenInDay2GSIS += $gsis2[1];
                        $totalPenOutDay2GSIS += $gsis2[2];
                        $totalPenNumDay2GSIS += $gsis22;

                        $totalPenInDay3GSIS += $gsis3[1];
                        $totalPenOutDay3GSIS += $gsis3[2];
                        $totalPenNumDay3GSIS += $gsis33;

                        $totalPenInDay4GSIS += $gsis4[1];
                        $totalPenOutDay4GSIS += $gsis4[2];
                        $totalPenNumDay4GSIS += $gsis44;

                        $totalPenInDay5GSIS += $gsis5[1];
                        $totalPenOutDay5GSIS += $gsis5[2];
                        $totalPenNumDay5GSIS += $gsis55;

                        $grandTotalPenInGSIS += $totalInGSIS;
                        $grandTotalPenOutGSIS += $totalOutGSIS;

                        //PVAO

                        $totalBeginningBalPVAO += $newBegBalValuePVAO[0];
                        $totalLastTransactionBalPVAO += $lastTransactionDataPVAO;

                        $totalPenInDay1PVAO += $pvao1[1];
                        $totalPenOutDay1PVAO += $pvao1[2];
                        $totalPenNumDay1PVAO += $pvao11;

                        $totalPenInDay2PVAO += $pvao2[1];
                        $totalPenOutDay2PVAO += $pvao2[2];
                        $totalPenNumDay2PVAO += $pvao22;

                        $totalPenInDay3PVAO += $pvao3[1];
                        $totalPenOutDay3PVAO += $pvao3[2];
                        $totalPenNumDay3PVAO += $pvao33;

                        $totalPenInDay4PVAO += $pvao4[1];
                        $totalPenOutDay4PVAO += $pvao4[2];
                        $totalPenNumDay4PVAO += $pvao44;

                        $totalPenInDay5PVAO += $pvao5[1];
                        $totalPenOutDay5PVAO += $pvao5[2];
                        $totalPenNumDay5PVAO += $pvao55;

                        $grandTotalPenInPVAO += $totalInPVAO;
                        $grandTotalPenOutPVAO += $totalOutPVAO;

                        //PNP

                        $totalBeginningBalPNP += $newBegBalValuePNP[0];
                        $totalLastTransactionBalPNP += $lastTransactionDataPNP;

                        $totalPenInDay1PNP += $pnp1[1];
                        $totalPenOutDay1PNP += $pnp1[2];
                        $totalPenNumDay1PNP += $pnp11;

                        $totalPenInDay2PNP += $pnp2[1];
                        $totalPenOutDay2PNP += $pnp2[2];
                        $totalPenNumDay2PNP += $pnp22;

                        $totalPenInDay3PNP += $pnp3[1];
                        $totalPenOutDay3PNP += $pnp3[2];
                        $totalPenNumDay3PNP += $pnp33;

                        $totalPenInDay4PNP += $pnp4[1];
                        $totalPenOutDay4PNP += $pnp4[2];
                        $totalPenNumDay4PNP += $pnp44;

                        $totalPenInDay5PNP += $pnp5[1];
                        $totalPenOutDay5PNP += $pnp5[2];
                        $totalPenNumDay5PNP += $pnp55;

                        $grandTotalPenInPNP += $totalInPNP;
                        $grandTotalPenOutPNP += $totalOutPNP;

                        //OLR

                        $totalBeginningBalOLR += $newBegBalValueOLR[0];
                        $totalLastTransactionBalOLR += $lastTransactionDataOLR;

                        $totalPenInDay1OLR += $olr1[1];
                        $totalPenOutDay1OLR += $olr1[2];
                        $totalPenNumDay1OLR += $olr11;

                        $totalPenInDay2OLR += $olr2[1];
                        $totalPenOutDay2OLR += $olr2[2];
                        $totalPenNumDay2OLR += $olr22;

                        $totalPenInDay3OLR += $olr3[1];
                        $totalPenOutDay3OLR += $olr3[2];
                        $totalPenNumDay3OLR += $olr33;

                        $totalPenInDay4OLR += $olr4[1];
                        $totalPenOutDay4OLR += $olr4[2];
                        $totalPenNumDay4OLR += $olr44;

                        $totalPenInDay5OLR += $olr5[1];
                        $totalPenOutDay5OLR += $olr5[2];
                        $totalPenNumDay5OLR += $olr55;

                        $grandTotalPenInOLR += $totalInOLR;
                        $grandTotalPenOutOLR += $totalOutOLR;

                        //OLR REAL ESTATE

                        $totalBeginningBalOLR_R_E += $newBegBalValueOLR_R_E[0];
                        $totalLastTransactionBalOLR_R_E += $lastTransactionDataOLR_R_E;

                        $totalPenInDay1OLR_R_E += $olr_r_e1[1];
                        $totalPenOutDay1OLR_R_E += $olr_r_e1[2];
                        $totalPenNumDay1OLR_R_E += $olr_r_e11;

                        $totalPenInDay2OLR_R_E += $olr_r_e2[1];
                        $totalPenOutDay2OLR_R_E += $olr_r_e2[2];
                        $totalPenNumDay2OLR_R_E += $olr_r_e22;

                        $totalPenInDay3OLR_R_E += $olr_r_e3[1];
                        $totalPenOutDay3OLR_R_E += $olr_r_e3[2];
                        $totalPenNumDay3OLR_R_E += $olr_r_e33;

                        $totalPenInDay4OLR_R_E += $olr_r_e4[1];
                        $totalPenOutDay4OLR_R_E += $olr_r_e4[2];
                        $totalPenNumDay4OLR_R_E += $olr_r_e44;

                        $totalPenInDay5OLR_R_E += $olr_r_e5[1];
                        $totalPenOutDay5OLR_R_E += $olr_r_e5[2];
                        $totalPenNumDay5OLR_R_E += $olr_r_e55;

                        $grandTotalPenInOLR_R_E += $totalInOLR_R_E;
                        $grandTotalPenOutOLR_R_E += $totalOutOLR_R_E;

                            //OLR HOUSING LOAN

                        $totalBeginningBalOLR_H_L += $newBegBalValueOLR_H_L[0];
                        $totalLastTransactionBalOLR_H_L += $lastTransactionDataOLR_H_L;

                        $totalPenInDay1OLR_H_L += $olr_h_l1[1];
                        $totalPenOutDay1OLR_H_L += $olr_h_l1[2];
                        $totalPenNumDay1OLR_H_L += $olr_h_l11;

                        $totalPenInDay2OLR_H_L += $olr_h_l2[1];
                        $totalPenOutDay2OLR_H_L += $olr_h_l2[2];
                        $totalPenNumDay2OLR_H_L += $olr_h_l22;

                        $totalPenInDay3OLR_H_L += $olr_h_l3[1];
                        $totalPenOutDay3OLR_H_L += $olr_h_l3[2];
                        $totalPenNumDay3OLR_H_L += $olr_h_l33;

                        $totalPenInDay4OLR_H_L += $olr_h_l4[1];
                        $totalPenOutDay4OLR_H_L += $olr_h_l4[2];
                        $totalPenNumDay4OLR_H_L += $olr_h_l44;

                        $totalPenInDay5OLR_H_L += $olr_h_l5[1];
                        $totalPenOutDay5OLR_H_L += $olr_h_l5[2];
                        $totalPenNumDay5OLR_H_L += $olr_h_l55;

                        $grandTotalPenInOLR_H_L += $totalInOLR_H_L;
                        $grandTotalPenOutOLR_H_L += $totalOutOLR_H_L;

                        //OLR CHATTEL

                        $totalBeginningBalOLR_C += $newBegBalValueOLR_C[0];
                        $totalLastTransactionBalOLR_C += $lastTransactionDataOLR_C;

                        $totalPenInDay1OLR_C += $olr_c1[1];
                        $totalPenOutDay1OLR_C += $olr_c1[2];
                        $totalPenNumDay1OLR_C += $olr_c11;

                        $totalPenInDay2OLR_C += $olr_c2[1];
                        $totalPenOutDay2OLR_C += $olr_c2[2];
                        $totalPenNumDay2OLR_C += $olr_c22;

                        $totalPenInDay3OLR_C += $olr_c3[1];
                        $totalPenOutDay3OLR_C += $olr_c3[2];
                        $totalPenNumDay3OLR_C += $olr_c33;

                        $totalPenInDay4OLR_C += $olr_c4[1];
                        $totalPenOutDay4OLR_C += $olr_c4[2];
                        $totalPenNumDay4OLR_C += $olr_c44;

                        $totalPenInDay5OLR_C += $olr_c5[1];
                        $totalPenOutDay5OLR_C += $olr_c5[2];
                        $totalPenNumDay5OLR_C += $olr_c55;

                        $grandTotalPenInOLR_C += $totalInOLR_C;
                        $grandTotalPenOutOLR_C += $totalOutOLR_C;     

                        $b1 = $totalBeginningBalSSS + $totalBeginningBalGSIS + $totalBeginningBalPNP + $totalBeginningBalPVAO + $totalBeginningBalOLR + $totalBeginningBalOLR_R_E + $totalBeginningBalOLR_H_L + $totalBeginningBalOLR_C;
                        $t1 = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS + $totalLastTransactionBalPNP + $totalLastTransactionBalPVAO + $totalLastTransactionBalOLR + $totalLastTransactionBalOLR_R_E + $totalLastTransactionBalOLR_H_L + $totalLastTransactionBalOLR_C;
                        $p11 = $totalPenInDay1SSS  + $totalPenInDay1GSIS + $totalPenInDay1PNP  + $totalPenInDay1PVAO + $totalPenInDay1OLR  + $totalPenInDay1OLR_R_E + $totalPenInDay1OLR_H_L  + $totalPenInDay1OLR_C;
                        $p12 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS + $totalPenOutDay1PNP + $totalPenOutDay1PVAO + $totalPenOutDay1OLR + $totalPenOutDay1OLR_R_E + $totalPenOutDay1OLR_H_L + $totalPenOutDay1OLR_C;
                        $p13 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS + $totalPenNumDay1PNP + $totalPenNumDay1PVAO + $totalPenNumDay1OLR + $totalPenNumDay1OLR_R_E + $totalPenNumDay1OLR_H_L + $totalPenNumDay1OLR_C;
                        $p21 = $totalPenInDay2SSS  + $totalPenInDay2GSIS + $totalPenInDay2PNP  + $totalPenInDay2PVAO + $totalPenInDay2OLR  + $totalPenInDay2OLR_R_E + $totalPenInDay2OLR_H_L  + $totalPenInDay2OLR_C;
                        $p22 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS + $totalPenOutDay2PNP + $totalPenOutDay2PVAO + $totalPenOutDay2OLR + $totalPenOutDay2OLR_R_E + $totalPenOutDay2OLR_H_L + $totalPenOutDay2OLR_C;
                        $p23 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS + $totalPenNumDay2PNP + $totalPenNumDay2PVAO + $totalPenNumDay2OLR + $totalPenNumDay2OLR_R_E + $totalPenNumDay2OLR_H_L + $totalPenNumDay2OLR_C;
                        $p31 = $totalPenInDay3SSS + $totalPenInDay3GSIS + $totalPenInDay3PNP  + $totalPenInDay3PVAO + $totalPenInDay3OLR  + $totalPenInDay3OLR_R_E + $totalPenInDay3OLR_H_L + $totalPenInDay3OLR_C;
                        $p32 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS + $totalPenOutDay3PNP + $totalPenOutDay3PVAO + $totalPenOutDay3OLR + $totalPenOutDay3OLR_R_E + $totalPenOutDay3OLR_H_L + $totalPenOutDay3OLR_C;
                        $p33 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS + $totalPenNumDay3PNP + $totalPenNumDay3PVAO + $totalPenNumDay3OLR + $totalPenNumDay3OLR_R_E + $totalPenNumDay3OLR_H_L + $totalPenNumDay3OLR_C;
                        $p41 = $totalPenInDay4SSS  + $totalPenInDay4GSIS + $totalPenInDay4PNP  + $totalPenInDay4PVAO + $totalPenInDay4OLR  + $totalPenInDay4OLR_R_E + $totalPenInDay4OLR_H_L  + $totalPenInDay4OLR_C;
                        $p42 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS + $totalPenOutDay4PNP + $totalPenOutDay4PVAO + $totalPenOutDay4OLR + $totalPenOutDay4OLR_R_E + $totalPenOutDay4OLR_H_L + $totalPenOutDay4OLR_C;
                        $p43 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS + $totalPenNumDay4PNP + $totalPenNumDay4PVAO + $totalPenNumDay4OLR + $totalPenNumDay4OLR_R_E + $totalPenNumDay4OLR_H_L + $totalPenNumDay4OLR_C;
                        $p51 = $totalPenInDay5SSS  + $totalPenInDay5GSIS + $totalPenInDay5PNP  + $totalPenInDay5PVAO + $totalPenInDay5OLR  + $totalPenInDay5OLR_R_E + $totalPenInDay5OLR_H_L  + $totalPenInDay5OLR_C;
                        $p52 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS + $totalPenOutDay5PNP + $totalPenOutDay5PVAO + $totalPenOutDay5OLR + $totalPenOutDay5OLR_R_E + $totalPenOutDay5OLR_H_L + $totalPenOutDay5OLR_C;
                        $p53 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PNP + $totalPenNumDay5PVAO + $totalPenNumDay5OLR + $totalPenNumDay5OLR_R_E + $totalPenNumDay5OLR_H_L + $totalPenNumDay5OLR_C;
                        $pi1 = $grandTotalPenInSSS + $grandTotalPenInGSIS + $grandTotalPenInPNP + $grandTotalPenInPVAO + $grandTotalPenInOLR + $grandTotalPenInOLR_R_E + $grandTotalPenInOLR_H_L + $grandTotalPenInOLR_C;
                        $po1 = $grandTotalPenOutSSS + $grandTotalPenOutGSIS + $grandTotalPenOutPNP + $grandTotalPenOutPVAO + $grandTotalPenOutOLR + $grandTotalPenOutOLR_R_E + $grandTotalPenOutOLR_H_L + $grandTotalPenOutOLR_C;
                        $pn1 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PNP + $totalPenNumDay5PVAO + $totalPenNumDay5OLR + $totalPenNumDay5OLR_R_E + $totalPenNumDay5OLR_H_L + $totalPenNumDay5OLR_C;

                }

            
                $additionalContent16 = <<<EOF
                            
                <table>
                    <tr>
                    <th colspan="2" rowspan="9" style="text-align:center;padding:5rem 1rem; color:gray; border: 1px solid black;"><span style="color: white;"></span><br><br><br><br>RLC TOTAL</th>
                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">SSS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalSSS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalSSS</th>
                EOF;

                $header .= $additionalContent16;

                $additionalContent17 = '';

                    // Check and add the formatted day headers only if they are not null
                    if ($day1_param > 0) {
                        $additionalContent17 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1SSS.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2SSS.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3SSS.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4SSS.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5SSS.'&nbsp;&nbsp;</th>';
                        $additionalContent17 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5SSS.'&nbsp;&nbsp;</th>';
                    }

                    $header .= $additionalContent17;

                    $grandTotalNetForSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;

                    $additionalContent18 = <<<EOF
    
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5SSS</th>
                
                    </tr>   

                    <tr>

                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalGSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSIS</th>
                    EOF;

                    $header .= $additionalContent18;

                    $grandTotalNetForGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;
    
                    $additionalContent19 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent19 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent19 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5GSIS.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent19;
    
                        $additionalContent20 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5GSIS</th>
        
                </tr>  
                <tr>

                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">PVAO</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalPVAO</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalPVAO</th>
                EOF;

                    $header .= $additionalContent20;
    
                    $additionalContent40 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent40 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent40 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5PVAO.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent40;

                        $grandTotalNetForPVAO = $grandTotalPenInPVAO - $grandTotalPenOutPVAO;
    
                        $additionalContent41 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5PVAO</th>
        
                </tr>  
                <tr>

                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">PNP</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalPNP</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalPNP</th>
                EOF;

                    $header .= $additionalContent41;

                    $additionalContent21 = '';

                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent21 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1PNP.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2PNP.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3PNP.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4PNP.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5PNP.'&nbsp;&nbsp;</th>';
                            $additionalContent21 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5PNP.'&nbsp;&nbsp;</th>';
                        }

                        $header .= $additionalContent21;

                        $grandTotalNetForPNP = $grandTotalPenInPNP - $grandTotalPenOutPNP;

                        $additionalContent22 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInPNP&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutPNP&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForPNP&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5PNP</th>
    
                 </tr>  
                <tr>

                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">OLR</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalOLR</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalOLR</th>
                EOF;

                    $header .= $additionalContent22;
    
                    $additionalContent23 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent23 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1OLR.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2OLR.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3OLR.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4OLR.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5OLR.'&nbsp;&nbsp;</th>';
                            $additionalContent23 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5OLR.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent23;

                        $grandTotalNetForOLR = $grandTotalPenInOLR - $grandTotalPenOutOLR;
    
                        $additionalContent24 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInOLR&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutOLR&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForOLR&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5OLR</th>
        
                </tr>  
                <tr>

                    <th style="width: 90px;text-align:center;padding:1.2rem 1rem; border: 1px solid black;">OLR-REAL ESTATE</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalOLR_R_E</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalOLR_R_E</th>
                EOF;

                    $header .= $additionalContent24;

    
                    $additionalContent25 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent25 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1OLR_R_E.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2OLR_R_E.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3OLR_R_E.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4OLR_R_E.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5OLR_R_E.'&nbsp;&nbsp;</th>';
                            $additionalContent25 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5OLR_R_E.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent25;

                        $grandTotalNetForOLR_R_E = $grandTotalPenInOLR_R_E - $grandTotalPenOutOLR_R_E;
    
                        $additionalContent26 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInOLR_R_E&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutOLR_R_E&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForOLR_R_E&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5OLR_R_E</th>
        
                </tr>  
                <tr>

                    <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black; ">OLR-HOUSING LOAN</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalOLR_H_L</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalOLR_H_L</th>
                EOF;

                    $header .= $additionalContent26;
    
                    $additionalContent27 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent27 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1OLR_H_L.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2OLR_H_L.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3OLR_H_L.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4OLR_H_L.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5OLR_H_L.'&nbsp;&nbsp;</th>';
                            $additionalContent27 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5OLR_H_L.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent27;

                        $grandTotalNetForOLR_H_L = $grandTotalPenInOLR_H_L - $grandTotalPenOutOLR_H_L;
    
                        $additionalContent28 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInOLR_H_L&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutOLR_H_L&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForOLR_H_L&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5OLR_H_L</th>
        
                </tr>  
                <tr>

                    <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">OLR-CHATTEL</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalOLR_C</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalOLR_C</th>
                EOF;

                    $header .= $additionalContent28;
    
                    $additionalContent29 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent29 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1OLR_C.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2OLR_C.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3OLR_C.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4OLR_C.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5OLR_C.'&nbsp;&nbsp;</th>';
                            $additionalContent29 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5OLR_C.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent29;

                        $grandTotalNetForOLR_C = $grandTotalPenInOLR_C - $grandTotalPenOutOLR_C;
    
                        $additionalContent30 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInOLR_C&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutOLR_C&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetForOLR_C&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5OLR_C</th>
        
                </tr>  

                <tr>
                    <th style="padding:1.2rem 1.5rem; border: 1px solid black; text-align: center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">$b1</th>
                    <th style="border: 1px solid black; text-align: center;">$t1</th>

                EOF;

                $header .= $additionalContent30;

                $additionalContent31 = '';
                    
                if ($day1_param > 0) {
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p11.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p12.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p13.'&nbsp;&nbsp;</th>';
                }
                if ($day2_param > 0) {
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p21.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p22.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p23.'&nbsp;&nbsp;</th>';
                }
                if ($day3_param > 0) {
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p31.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p32.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p33.'&nbsp;&nbsp;</th>';
                }
                if ($day4_param > 0) {
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p41.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p42.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p43.'&nbsp;&nbsp;</th>';
                }
                if ($day5_param > 0) {
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p51.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p52.'&nbsp;&nbsp;</th>';
                    $additionalContent31 .= '<th style="border: 1px solid black; text-align: right;">'.$p53.'&nbsp;&nbsp;</th>';
                }
                
            $header .= $additionalContent31;

            $AllnetRLC = $pi1 - $po1;

            $additionalContent32 = <<<EOF
    
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$pi1&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$po1&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$AllnetRLC&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$pn1</th>

                </tr>  


                <tr><td colspan="25" class="invisible"></td></tr>
                </table>
    EOF;


        $header .= $additionalContent32;

        $header .= <<<EOF
            <table>   

            <tr><th colspan="25"></th></tr> 

            <tr><th colspan="25"></th></tr> 

            <tr><th colspan="25"></th></tr> 
            
            </table>

            EOF;

            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
            

                </tr>             
            </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  

                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Prepared by:</td>
                
                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Checked by:</td>
                
                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Noted by:</td>
            
                </tr>             
            </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
            

                </tr>             
            </table>
            EOF;
        
            
            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$preparedBy</td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$checkedBy</td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$notedBy</td>
               

                </tr>             
            </table>
            EOF;


        // Output the full header to PDF
        $pdf->writeHTML($header, false, false, false, false, '');
        
        $pdf->Output('Pensioner Statistics Reports', 'I');
    
   }

    public function showPensionerFilterELC(){

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');

    $weekfrom = $_GET['penDateFrom'];
    $weekto = $_GET['penDateTo'];
    // $penBegBal = $_GET['penBegBal'];
    // $branch_name = $_SESSION['branch_name'];
    $startDate = new DateTime($weekfrom);
    $endDate = new DateTime($weekto);   
    $currentDate = clone $startDate;

    while ($currentDate <= $endDate) {
        $dateRange[] = $currentDate->format('Y-m-d');
        $currentDate->modify('+1 day');
     }
     $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
     $formattedDay1 = isset($dateRange[0]) ? date('j-M', strtotime($dateRange[0])) : null;
     
     $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
     $formattedDay2 = isset($dateRange[1]) ? date('j-M', strtotime($dateRange[1])) : null;
     
     $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
     $formattedDay3 = isset($dateRange[2]) ? date('j-M', strtotime($dateRange[2])) : null;
     
     $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
     $formattedDay4 = isset($dateRange[3]) ? date('j-M', strtotime($dateRange[3])) : null;
     
     $day5 = isset($dateRange[4]) ? $dateRange[4] : null;
     $formattedDay5 = isset($dateRange[4]) ? date('j-M', strtotime($dateRange[4])) : null;

     $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
     $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
     $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
     $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
     $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

     if (!empty($day1)) {
        if (!empty($day5)){
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day5));
        } else if(!empty($day4)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day4));
           
        } else if(!empty($day3)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day3));

        } else if(!empty($day2)) {
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day2));
        }else{
            $coveredDateStart = date('F j', strtotime($day1));
            $coveredDateEnd = date('-j, Y', strtotime($day1));

        }
          
     } 

     $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
     $begBalCovered = 'Dec ' . $lastYearDate;
     $dateReportCoverage = $coveredDateStart . $coveredDateEnd;

    require_once('tcpdf_include.php');

    $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetMargins(10,7);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(5);

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

// Initialize the header variable
$header = '';

$header_content27 = <<<EOF

    <style>
    tr, td{
        font-size:7rem;
       
    }
    tr, th{
        font-size:7rem;
        
    }
    #branch {
        display: inline-block;
        padding: 20rem 1rem;
      }
    </style>
            <table style="width: 100%;">

        <tr>
           
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px;"><strong>EVERYDAY LENDING CORPORATION</strong></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            
        </tr>
        <tr>
            
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px; color: gray;"><strong>BRANCH WEEKLY PENSIONER STATISTICS</strong></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->

        </tr>
        <tr>
          
            <td style="width: 45%; text-align: left;"><p style="font-size: 12px; font-weight: 10;">PERIOD COVERED: $dateReportCoverage</p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        </tr>

        <tr>
           
            <td style="width: 45%; text-align: center;"><p style="font-size: 2px;"></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        </tr>


        </table>

            <table >          
                <tr>         
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
EOF;

                    $header .= $header_content27;
                    
                    $header_content28 = '';
    
                    if ($day1_param > 0) {
                        $header_content28 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay1 . '</th>';
                    }
                    if ($day2_param > 0) {
                        $header_content28 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay2 . '</th>';
                    }
                    if ($day3_param > 0) {
                        $header_content28 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay3 . '</th>';
                    }
                    if ($day4_param > 0) {
                        $header_content28 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay4 . '</th>';
                    }
                    if ($day5_param > 0) {
                        $header_content28 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">' . $formattedDay5 . '</th>';
                    }
                $header .= $header_content28;
    
                    $header_content29 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; border: 1px solid black">TOTAL</th>
                    
                </tr>   

                <tr>
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                EOF;
                    $header .= $header_content29;
            
                        $header_content30 = '';
            
                        if ($day1_param > 0) {
                            $header_content30 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">MON</th>';
                        }
                        if ($day2_param > 0) {
                            $header_content30 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">TUE</th>';
                        }
                        if ($day3_param > 0) {
                            $header_content30 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">WED</th>';
                        }
                        if ($day4_param > 0) {
                            $header_content30 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">THU</th>';
                        }
                        if ($day5_param > 0) {
                            $header_content30 .= '<th style="text-align:center; border: 1px solid black;" colspan="3">FRI</th>';
                        }
            
                        $header .= $header_content30;
            
                        $header_content31 = <<<EOF
        
                    <th></th>
                    <!-- <th colspan="4"></th> -->
                    
                </tr>   

                <tr>
                    <th style="border: 1px solid black; text-align: center;" colspan="2"><span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span></th>
                    <th ></th>
                    <th style="border: 1px solid black; text-align: center;">BEG<br>$begBalCovered</th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>
                EOF;

                    $header .= $header_content31;
        
                    $header_content32 = '';
        
                    if ($day1_param > 0) {
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                        $header_content32 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                    }
                    if ($day2_param > 0) {
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                        $header_content32 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                    }
                    if ($day3_param > 0) {
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                        $header_content32 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                    }
                    if ($day4_param > 0) {
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                        $header_content32 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                    }
                    if ($day5_param > 0) {
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                        $header_content32 .= '<th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                        $header_content32 .= ' <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                    }
        
                    $header .= $header_content32;
        
        
                    $header_content33 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style="border: 1px solid black; text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style="border: 1px solid black; text-align: center; font-size: 7px;"><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>   

                <tr>
                    <td colspan="26"></td>
                </tr>
                </table>
EOF; 
$header .= $header_content33;


            $SSS  = 'SSS';
            $GSIS = 'GSIS';
            $PACERS  = 'PACERS';
            $PVAO = 'PVAO';

            $totalBeginningBalSSS = 0;
            $totalLastTransactionBalSSS = 0;

            $totalPenInDay1SSS = 0;
            $totalPenOutDay1SSS = 0;
            $totalPenNumDay1SSS = 0;

            $totalPenInDay2SSS = 0;
            $totalPenOutDay2SSS = 0;
            $totalPenNumDay2SSS = 0;

            $totalPenInDay3SSS = 0;
            $totalPenOutDay3SSS = 0;
            $totalPenNumDay3SSS = 0;

            $totalPenInDay4SSS = 0;
            $totalPenOutDay4SSS = 0;
            $totalPenNumDay4SSS = 0;

            $totalPenInDay5SSS = 0;
            $totalPenOutDay5SSS = 0;
            $totalPenNumDay5SSS = 0;

            $grandTotalPenInSSS = 0;
            $grandTotalPenOutSSS = 0;

            //GSIS

            $totalBeginningBalGSIS = 0;
            $totalLastTransactionBalGSIS = 0;

            $totalPenInDay1GSIS = 0;
            $totalPenOutDay1GSIS = 0;
            $totalPenNumDay1GSIS = 0;

            $totalPenInDay2GSIS = 0;
            $totalPenOutDay2GSIS = 0;
            $totalPenNumDay2GSIS = 0;

            $totalPenInDay3GSIS = 0;
            $totalPenOutDay3GSIS = 0;
            $totalPenNumDay3GSIS = 0;

            $totalPenInDay4GSIS = 0;
            $totalPenOutDay4GSIS = 0;
            $totalPenNumDay4GSIS = 0;

            $totalPenInDay5GSIS = 0;
            $totalPenOutDay5GSIS = 0;
            $totalPenNumDay5GSIS = 0;

            $grandTotalPenInGSIS = 0;
            $grandTotalPenOutGSIS = 0;

            //PACERS

            $totalBeginningBalPACERS = 0;
            $totalLastTransactionBalPACERS = 0;

            $totalPenInDay1PACERS = 0;
            $totalPenOutDay1PACERS = 0;
            $totalPenNumDay1PACERS = 0;

            $totalPenInDay2PACERS = 0;
            $totalPenOutDay2PACERS = 0;
            $totalPenNumDay2PACERS = 0;

            $totalPenInDay3PACERS = 0;
            $totalPenOutDay3PACERS = 0;
            $totalPenNumDay3PACERS = 0;

            $totalPenInDay4PACERS = 0;
            $totalPenOutDay4PACERS = 0;
            $totalPenNumDay4PACERS = 0;

            $totalPenInDay5PACERS = 0;
            $totalPenOutDay5PACERS = 0;
            $totalPenNumDay5PACERS = 0;

            $grandTotalPenInPACERS = 0;
            $grandTotalPenOutPACERS = 0;

            //PVAO

            $totalBeginningBalPVAO = 0;
            $totalLastTransactionBalPVAO = 0;

            $totalPenInDay1PVAO = 0;
            $totalPenOutDay1PVAO = 0;
            $totalPenNumDay1PVAO = 0;

            $totalPenInDay2PVAO = 0;
            $totalPenOutDay2PVAO = 0;
            $totalPenNumDay2PVAO = 0;

            $totalPenInDay3PVAO = 0;
            $totalPenOutDay3PVAO = 0;
            $totalPenNumDay3PVAO = 0;

            $totalPenInDay4PVAO = 0;
            $totalPenOutDay4PVAO = 0;
            $totalPenNumDay4PVAO = 0;

            $totalPenInDay5PVAO = 0;
            $totalPenOutDay5PVAO = 0;
            $totalPenNumDay5PVAO = 0;

            $grandTotalPenInPVAO = 0;
            $grandTotalPenOutPVAO = 0;

            $FCH_branch = 'ELC';

            $preparedBy = $_GET['preparedBy'];
            $checkedBy = $_GET['checkedBy'];
            $notedBy = $_GET['notedBy'];

            $data = (new ControllerPensioner)->ctrGetBranchesNames($FCH_branch);

            foreach ($data as &$item1) {    
                $branch_name = $item1['branch_name'];
              
                $branch_namenew = substr($branch_name, 3);
            

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
        
                $firstDayOfYear = '1990-01-01';
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
        
                $body_content62 = <<<EOF
                <table>
                    <tr>
                        <th colspan="2" rowspan="5" style="text-align:center; border: 1px solid black;"><span style="color:white;">s</span><br><br>$branch_namenew</th>
                        <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                        <th style="border: 1px solid black; text-align: center;">{$newBegBalValueSSS[0]}</th>
                        <th style="border: 1px solid black; text-align: center;">$lastTransactionDataSSS</th>
                EOF;

                        $header .= $body_content62;
    
                        $body_content63 ='';
                        
                        if ($day1_param > 0) {
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$sss1[1].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss1[2].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss11.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[1].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss2[2].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss22.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[1].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss3[2].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss33.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[1].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss4[2].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss44.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[1].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss5[2].'&nbsp;&nbsp;</th>';
                            $body_content63 .= '<th style="border: 1px solid black; text-align: right;">'.$sss55.'&nbsp;&nbsp;</th>';
                        }
                        
                    $header .= $body_content63;

                    $totalNetSSS = $totalInSSS - $totalOutSSS;
                    $body_content63 = <<<EOF
    
                        <th style="width: 10px;"></th>
                        <th style="border: 1px solid black; text-align: right;">$totalInSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalOutSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: right;">$totalNetSSS&nbsp;&nbsp;</th>
                        <th style="border: 1px solid black; text-align: center;">$sss55</th>
                    
                    </tr>   
        
                    <tr>
        
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValueGSIS[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataGSIS</th>
                    EOF;

                    $header .= $body_content63;

                    $body_content64 ='';
                    
                    if ($day1_param > 0) {
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$gsis1[1].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis1[2].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[1].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis2[2].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[1].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis3[2].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[1].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis4[2].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[1].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis5[2].'&nbsp;&nbsp;</th>';
                        $body_content64 .= '<th style="border: 1px solid black; text-align: right;">'.$gsis55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content64;

                $totalNetGSIS = $totalInGSIS - $totalOutGSIS;
                $body_content65 = <<<EOF

                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalOutGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalNetGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$gsis55</th>              
                </tr>  

                <tr>
        
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">PACERS</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePACERS[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPACERS</th>
                EOF;

                    $header .= $body_content65;

                    $body_content66 ='';
                    
                    if ($day1_param > 0) {
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pacers1[1].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers1[2].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers2[1].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers2[2].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers3[1].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers3[2].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers4[1].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers4[2].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers5[1].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers5[2].'&nbsp;&nbsp;</th>';
                        $body_content66 .= '<th style="border: 1px solid black; text-align: right;">'.$pacers55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content66;

                $totalNetPACERS = $totalInPACERS - $totalOutPACERS;
                $body_content67 = <<<EOF

                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalOutPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalNetPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$pacers55</th>              
                </tr>  
                <tr>
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">PVAO</th>
                    <th style="border: 1px solid black; text-align: center;">{$newBegBalValuePVAO[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$lastTransactionDataPVAO</th>
                EOF;

                    $header .= $body_content67;

                    $body_content68 ='';
                    
                    if ($day1_param > 0) {
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right; margin-right: 2px;">'.$pvao1[1].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao1[2].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao11.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[1].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao2[2].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao22.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[1].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao3[2].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[1].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao4[2].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao44.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[1].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao5[2].'&nbsp;&nbsp;</th>';
                        $body_content68 .= '<th style="border: 1px solid black; text-align: right;">'.$pvao55.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $body_content68;

                $totalNetPVAO = $totalInPVAO - $totalOutPVAO;
                $body_content69 = <<<EOF

                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalInPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalOutPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalNetPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$pvao55</th>              
                </tr>  

                EOF;

                $header .= $body_content69;

                $totalNewBegBalSSSGSIS = $newBegBalValueSSS + $newBegBalValueGSIS;
                $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS;
                $sssgsis11 = $sss1[1] + $gsis1[1];
                $sssgsis21 = $sss1[2] + $gsis1[2];
                $sssgsis31 = $sss11 + $gsis11;

                $sssgsis22 = $sss2[1] + $gsis2[1];
                $sssgsis22 = $sss2[2] + $gsis2[2];
                $sssgsis23 = $sss22 + $gsis22;

                $sssgsis31 = $sss3[1] + $gsis3[1];
                $sssgsis32 = $sss3[2] + $gsis3[2];
                $sssgsis33 = $sss33 + $gsis33;

                $sssgsis41 = $sss4[1] + $gsis4[1];
                $sssgsis42 = $sss4[2] + $gsis4[2];
                $sssgsis43 = $sss44 + $gsis44;

                $sssgsis51 = $sss5[1] + $gsis5[1];
                $sssgsis52 = $sss5[2] + $gsis5[2];
                $sssgsis53 = $sss55 + $gsis55;

                $totalGSISSSPenIn = $totalInGSIS + $totalInSSS;
                $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS;

                $totalNewBegBalSSSGSIS = $newBegBalValueSSS + $newBegBalValueGSIS + $newBegBalValuePACERS + $newBegBalValuePVAO;
                $totalLastTransactionBalGSISSS = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPACERS + $lastTransactionDataPVAO;
                $sssgsis11 = $sss1[1] + $gsis1[1] + $pacers1[1] + $pvao1[1];
                $sssgsis12 = $sss1[2] + $gsis1[2] + $pacers1[2] + $pvao1[2];
                $sssgsis13 = $sss11   + $gsis11 + $pacers11   + $pvao11;
                $sssgsis21 = $sss2[1] + $gsis2[1] + $pacers1[1] + $pvao1[1];
                $sssgsis22 = $sss2[2] + $gsis2[2] + $pacers1[2] + $pvao1[2];
                $sssgsis23 = $sss22   + $gsis22 + + $pacers22   + $pvao22;
                $sssgsis31 = $sss3[1] + $gsis3[1] + $pacers1[1] + $pvao1[1];
                $sssgsis32 = $sss3[2] + $gsis3[2] + $pacers1[2] + $pvao1[2];
                $sssgsis33 = $sss33   + $gsis33 + $pacers33   + $pvao33;
                $sssgsis41 = $sss4[1] + $gsis4[1] + $pacers1[1] + $pvao1[1];
                $sssgsis42 = $sss4[2] + $gsis4[2] + $pacers1[2] + $pvao1[2];
                $sssgsis43 = $sss44   + $gsis44 + $pacers44   + $pvao44;
                $sssgsis51 = $sss5[1] + $gsis5[1] + $pacers1[1] + $pvao1[1];
                $sssgsis52 = $sss5[2] + $gsis5[2] + $pacers1[2] + $pvao1[2];
                $sssgsis53 = $sss55   + $gsis55 + $pacers55  + $pvao55;
                $totalGSISSSPenIn = $totalInGSIS + $totalInSSS + $totalInPACERS + $totalInPVAO;
                $totalGSISSSPenOut = $totalOutGSIS + $totalOutSSS +$totalOutPACERS + $totalOutPVAO;

                $ooter_content21 = <<<EOF
        
                <tr>
                    <th style="border: 1px solid black; padding:.2rem 1rem;text-align:center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">{$totalNewBegBalSSSGSIS[0]}</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSISSS</th>
                EOF;

                    $header .= $ooter_content21;
    
                
                    $ooter_content22 ='';
                    if ($day1_param > 0) {
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis11.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis12.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis13.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis21.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis22.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis23.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis31.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis32.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis41.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis42.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis43.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis51.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis52.'&nbsp;&nbsp;</th>';
                        $ooter_content22 .= '<th style="border: 1px solid black; text-align: right;">'.$sssgsis53.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $ooter_content22;

                $totalELCNET = $totalGSISSSPenIn - $totalGSISSSPenOut;
    
                $ooter_content23 = <<<EOF

                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenIn&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalGSISSSPenOut&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$totalELCNET&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$sssgsis53</th>    
                </tr>  
    
                <tr><td colspan="25" class="invisible"></td></tr>
                    </table>
                EOF;

                $header .= $ooter_content23;

                $totalBeginningBalSSS += $newBegBalValueSSS[0];
                $totalLastTransactionBalSSS += $lastTransactionDataSSS;

                $totalPenInDay1SSS += $sss1[1];
                $totalPenOutDay1SSS += $sss1[2];
                $totalPenNumDay1SSS += $sss11;

                $totalPenInDay2SSS += $sss2[1];
                $totalPenOutDay2SSS += $sss2[2];
                $totalPenNumDay2SSS += $sss22;

                $totalPenInDay3SSS += $sss3[1];
                $totalPenOutDay3SSS += $sss3[2];
                $totalPenNumDay3SSS += $sss33;

                $totalPenInDay4SSS += $sss4[1];
                $totalPenOutDay4SSS += $sss4[2];
                $totalPenNumDay4SSS += $sss44;

                $totalPenInDay5SSS += $sss5[1];
                $totalPenOutDay5SSS += $sss5[2];
                $totalPenNumDay5SSS += $sss55;

                $grandTotalPenInSSS += $totalInSSS;
                $grandTotalPenOutSSS += $totalOutSSS;

                //GSIS

                $totalBeginningBalGSIS += $newBegBalValueGSIS[0];
                $totalLastTransactionBalGSIS += $lastTransactionDataGSIS;

                $totalPenInDay1GSIS += $gsis1[1];
                $totalPenOutDay1GSIS += $gsis1[2];
                $totalPenNumDay1GSIS += $gsis11;

                $totalPenInDay2GSIS += $gsis2[1];
                $totalPenOutDay2GSIS += $gsis2[2];
                $totalPenNumDay2GSIS += $gsis22;

                $totalPenInDay3GSIS += $gsis3[1];
                $totalPenOutDay3GSIS += $gsis3[2];
                $totalPenNumDay3GSIS += $gsis33;

                $totalPenInDay4GSIS += $gsis4[1];
                $totalPenOutDay4GSIS += $gsis4[2];
                $totalPenNumDay4GSIS += $gsis44;

                $totalPenInDay5GSIS += $gsis5[1];
                $totalPenOutDay5GSIS += $gsis5[2];
                $totalPenNumDay5GSIS += $gsis55;

                $grandTotalPenInGSIS += $totalInGSIS;
                $grandTotalPenOutGSIS += $totalOutGSIS;

                //PACERS

                $totalBeginningBalPACERS += $newBegBalValuePACERS[0];
                $totalLastTransactionBalPACERS += $lastTransactionDataPACERS;

                $totalPenInDay1PACERS += $pacers1[1];
                $totalPenOutDay1PACERS += $pacers1[2];
                $totalPenNumDay1PACERS += $pacers11;

                $totalPenInDay2PACERS += $pacers2[1];
                $totalPenOutDay2PACERS += $pacers2[2];
                $totalPenNumDay2PACERS += $pacers22;

                $totalPenInDay3PACERS += $pacers3[1];
                $totalPenOutDay3PACERS += $pacers3[2];
                $totalPenNumDay3PACERS += $pacers33;

                $totalPenInDay4PACERS += $pacers4[1];
                $totalPenOutDay4PACERS += $pacers4[2];
                $totalPenNumDay4PACERS += $pacers44;

                $totalPenInDay5PACERS += $pacers5[1];
                $totalPenOutDay5PACERS += $pacers5[2];
                $totalPenNumDay5PACERS += $pacers55;

                $grandTotalPenInPACERS += $totalInPACERS;
                $grandTotalPenOutPACERS += $totalOutPACERS;

                //PVAO

                $totalBeginningBalPVAO += $newBegBalValuePVAO[0];
                $totalLastTransactionBalPVAO += $lastTransactionDataPVAO;

                $totalPenInDay1PVAO += $pvao1[1];
                $totalPenOutDay1PVAO += $pvao1[2];
                $totalPenNumDay1PVAO += $pvao11;

                $totalPenInDay2PVAO += $pvao2[1];
                $totalPenOutDay2PVAO += $pvao2[2];
                $totalPenNumDay2PVAO += $pvao22;

                $totalPenInDay3PVAO += $pvao3[1];
                $totalPenOutDay3PVAO += $pvao3[2];
                $totalPenNumDay3PVAO += $pvao33;

                $totalPenInDay4PVAO += $pvao4[1];
                $totalPenOutDay4PVAO += $pvao4[2];
                $totalPenNumDay4PVAO += $pvao44;

                $totalPenInDay5PVAO += $pvao5[1];
                $totalPenOutDay5PVAO += $pvao5[2];
                $totalPenNumDay5PVAO += $pvao55;

                $grandTotalPenInPVAO += $totalInPVAO;
                $grandTotalPenOutPVAO += $totalOutPVAO;

                $b1 = $totalBeginningBalSSS + $totalBeginningBalGSIS + $totalBeginningBalPACERS + $totalBeginningBalPVAO;
                $t1 = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS + $totalLastTransactionBalPACERS + $totalLastTransactionBalPVAO;
                $p11 = $totalPenInDay1SSS  + $totalPenInDay1GSIS + $totalPenInDay1PACERS  + $totalPenInDay1PVAO;
                $p12 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS + $totalPenOutDay1PACERS + $totalPenOutDay1PVAO;
                $p13 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS + $totalPenNumDay1PACERS + $totalPenNumDay1PVAO;
                $p21 = $totalPenInDay2SSS  + $totalPenInDay2GSIS + $totalPenInDay2PACERS  + $totalPenInDay2PVAO;
                $p22 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS + $totalPenOutDay2PACERS + $totalPenOutDay2PVAO;
                $p23 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS + $totalPenNumDay2PACERS + $totalPenNumDay2PVAO;
                $p31 = $totalPenInDay3SSS  + $totalPenInDay3GSIS + $totalPenInDay3PACERS  + $totalPenInDay3PVAO;
                $p32 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS + $totalPenOutDay3PACERS + $totalPenOutDay3PVAO;
                $p33 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS + $totalPenNumDay3PACERS + $totalPenNumDay3PVAO;
                $p41 = $totalPenInDay4SSS  + $totalPenInDay4GSIS + $totalPenInDay4PACERS  + $totalPenInDay4PVAO;
                $p42 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS + $totalPenOutDay4PACERS + $totalPenOutDay4PVAO;
                $p43 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS + $totalPenNumDay4PACERS + $totalPenNumDay4PVAO;
                $p51 = $totalPenInDay5SSS  + $totalPenInDay5GSIS + $totalPenInDay5PACERS  + $totalPenInDay5PVAO;
                $p52 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS + $totalPenOutDay5PACERS + $totalPenOutDay5PVAO;
                $p53 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PACERS + $totalPenNumDay5PVAO;
                $pi1 = $grandTotalPenInSSS + $grandTotalPenInGSIS + $grandTotalPenInPACERS + $grandTotalPenInPVAO;
                $po1 = $grandTotalPenOutSSS + $grandTotalPenOutGSIS + $grandTotalPenOutPACERS + $grandTotalPenOutPVAO;
                $pn1 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PACERS + $totalPenNumDay5PVAO;

            }

        
            $additionalContent33 = <<<EOF
                        
            <table>
                <tr>
                    <th colspan="2" rowspan="5" style="text-align:center;padding:5rem 1rem; color:gray; border: 1px solid black;"><span style="color: white;"></span><br><br>ELC TOTAL</th>
                    <th style="border: 1px solid black; padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalSSS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalSSS</th>
            EOF;

                    $header .= $additionalContent33;
    
                    $additionalContent34 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent34 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1SSS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2SSS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'S&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3SSS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4SSS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5SSS.'&nbsp;&nbsp;</th>';
                            $additionalContent34 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5SSS.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent34;

                        $grandTotalNetSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;
    
                        $additionalContent35    = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetSSS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5SSS</th>
            
                </tr>   
                <tr>

                    <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">GSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalGSIS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalGSIS</th>
                EOF;

                    $header .= $additionalContent35;
    
                    $additionalContent36 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent36 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'S&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4GSIS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5GSIS.'&nbsp;&nbsp;</th>';
                            $additionalContent36 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5GSIS.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent36;

                        $grandTotalNetGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;
    
                        $additionalContent37 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetGSIS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5GSIS</th>
    
                </tr>  

                <tr>

                    <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">PACERS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalPACERS</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalPACERS</th>
                EOF;

                    $header .= $additionalContent37;
    
                    $additionalContent39 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent39 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1PACERS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2PACERS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'S&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3PACERS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4PACERS.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5PACERS.'&nbsp;&nbsp;</th>';
                            $additionalContent39 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5PACERS.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent39;

                        $grandTotalNetPACERS = $grandTotalPenInPACERS - $grandTotalPenOutPACERS;
    
                        $additionalContent40 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetPACERS&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5PACERS</th>

                </tr> 
                <tr>

                    <th style="text-align:center;padding:1.2rem 1rem; border: 1px solid black;">PVAO</th>
                    <th style="border: 1px solid black; text-align: center;">$totalBeginningBalPVAO</th>
                    <th style="border: 1px solid black; text-align: center;">$totalLastTransactionBalPVAO</th>
                EOF;

                    $header .= $additionalContent40;
    
                    $additionalContent41 = '';
    
                        // Check and add the formatted day headers only if they are not null
                        if ($day1_param > 0) {
                            $additionalContent41 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenInDay1PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay1PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= ' <th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay1PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day2_param > 0) {
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay2PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay2PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay2PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day3_param > 0) {
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay3PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay3SSS.'S&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay3PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day4_param > 0) {
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay4PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay4PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay4PVAO.'&nbsp;&nbsp;</th>';
                        }
                        if ($day5_param > 0) {
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenInDay5PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenOutDay5PVAO.'&nbsp;&nbsp;</th>';
                            $additionalContent41 .= '<th style="border: 1px solid black; text-align: right;">'.$totalPenNumDay5PVAO.'&nbsp;&nbsp;</th>';
                        }
    
                        $header .= $additionalContent41;

                        $grandTotalNetPVAO = $grandTotalPenInPVAO - $grandTotalPenOutPVAO;
    
                        $additionalContent42 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenInPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalPenOutPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandTotalNetPVAO&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$totalPenNumDay5PVAO</th>
        
                </tr>   

                <tr>
                    <th style="padding:1.2rem 1.5rem; border: 1px solid black; text-align: center;">TOTAL</th>
                    <th style="border: 1px solid black; text-align: center;">$b1</th>
                    <th style="border: 1px solid black; text-align: center;">$t1</th>
                EOF;

                    $header .= $additionalContent42;
    
                    $additionalContent43 = '';
                        
                    if ($day1_param > 0) {
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p11.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p12.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p13.'&nbsp;&nbsp;</th>';
                    }
                    if ($day2_param > 0) {
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p21.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p22.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p23.'&nbsp;&nbsp;</th>';
                    }
                    if ($day3_param > 0) {
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p31.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p32.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p33.'&nbsp;&nbsp;</th>';
                    }
                    if ($day4_param > 0) {
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p41.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p42.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p43.'&nbsp;&nbsp;</th>';
                    }
                    if ($day5_param > 0) {
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p51.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p52.'&nbsp;&nbsp;</th>';
                        $additionalContent43 .= '<th style="border: 1px solid black; text-align: right;">'.$p53.'&nbsp;&nbsp;</th>';
                    }
                    
                $header .= $additionalContent43;

                $grandNETTOTALs = $pi1 - $po1;
    
                $additionalContent44 = <<<EOF
                    <th style="width: 10px;"></th>
                    <th style="border: 1px solid black; text-align: right;">$pi1&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$po1&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: right;">$grandNETTOTALs&nbsp;&nbsp;</th>
                    <th style="border: 1px solid black; text-align: center;">$pn1</th>

                </tr>  


                <tr><td colspan="25" class="invisible"></td></tr>
                </table>
EOF;


    $header .= $additionalContent44;

            $header .= <<<EOF
            <table>   
            
            <tr><th colspan="25"></th></tr> 
            
            <tr><th colspan="25"></th></tr> 
            
            <tr><th colspan="25"></th></tr> 
            
            <tr><th colspan="25"></th></tr> 
            </table>
            
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  

                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Prepared by:</td>
                
                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Checked by:</td>
                
                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Noted by:</td>
            
                </tr>             
            </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
            

                </tr>             
            </table>
            EOF;
        
            
            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$preparedBy</td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$checkedBy</td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">$notedBy</td>
               

                </tr>             
            </table>
            EOF;


    // Output the full header to PDF
    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Pensioner Statistics Reports', 'I');
    
   }




  }  

  


?>