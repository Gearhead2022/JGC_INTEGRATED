<?php


require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/pensioner.controller.php";
require_once "../../../models/pensioner.model.php";

$filterSummary= new reportTable();
$filterSummary -> showSalesPerformanceFilter();

class reportTable{

public function showSalesPerformanceFilter(){

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');

    $preparedBy = $_GET['preparedBy'];
    $checkedBy = $_GET['checkedBy'];
    $notedBy = $_GET['notedBy'];

    $monthEnd = $_GET['monthEnd']; /*get date input*/
    // $branch_name_input = $_GET['branch_name_input']; /*get branch name input*/
    $lastYearDate = date('Y', strtotime('-1 year', strtotime($monthEnd))); //get last year
    $lastDateOfThePrevYear = $lastYearDate . "-12-31"; //last date of the previous year
    $lastMonthOfThePrevYear = $lastYearDate . "-12"; //last month of the previous year
    $thisYearDate = date('Y', strtotime($monthEnd)); //get current year

    $dateTitle = strtoupper(date('F Y', strtotime($monthEnd)));
    $prevMonthAndYear = date('Y-m', strtotime('-1 month', strtotime($monthEnd)));

    //for table headers
    $thLastYearDate = date('M, \'y', strtotime($lastDateOfThePrevYear)); //get last year
    $thCurYearDate = date('M, \'y', strtotime($monthEnd)); //get last year
    $thPrevMonth = date('M, \'y', strtotime('-1 month', strtotime($monthEnd))); //get last year

    $dataFCHM  = (new ControllerPensioner)->ctrPastOperationFCHManila();
    $dataFCHN = (new ControllerPensioner)->ctrOperationFCHNegros();
    $dataEMB = (new ControllerPensioner)->ctrOperationEMB();
    $dataELC = (new ControllerPensioner)->ctrOperationELC();
    $dataRLC = (new ControllerPensioner)->ctrOperationRLC();
   

  require_once('tcpdf_include.php');


    $pdf = new TCPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetMargins(7,7);
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



    $header = <<<EOF

        <table style="width: 100%;">
        <tr>
               
                <td style="width: 100%; text-align: left; padding-bottom: -300px;"><p style="font-size: 9px;"><strong></strong></p></td> <!-- Centered cell -->
                
                    
            </tr>
            <tr>
                        
                <td style="width: 100%; text-align: left; padding-bottom: -300px;"><p style="font-size: 9px;"><strong></strong></p></td> <!-- Centered cell -->
            
                
            </tr>
            <tr>
               
                <td style="width: 100%; text-align: left; padding-bottom: -300px;"><p style="font-size: 9px;"><strong>SALES REPRESENTATIVE AND SATELLITE OFFICERS SALES PERFORMANCE</strong></p></td> <!-- Centered cell -->
               
                
            </tr>
            <tr>
                
                <td style="width: 45%; text-align: left;"><p style="font-size: 10px;">FOR THE MONTH OF $dateTitle</p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            </tr>
        </table>
        <table >
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><span></span><br> EMB </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"><span></span><br> SALES REPRESENTATIVE </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thLastYearDate <span></span><br></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thPrevMonth </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> END <br> $thCurYearDate </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> GROSS IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> Agents IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"> GROSS IN Cumulative <br> $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"><span></span><br> BRANCH NET $thCurYearDate  </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"><span></span><br> BRANCH CUM NET $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"><span></span><br> % vs Target </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> Annual Target </th>
        </tr>
        </table>
       
    EOF;

        $total_newBegBal = 0;
        $total_newmonthBegBal  = 0;
        $total_newMonthBegBalCur  = 0;
        $total_getMonthlyGrossIn = 0;
        $total_getMonthlyAgent = 0;
        $total_getYearlyGrossIn  = 0;
        $total_branch_net_format = 0;
        $total_branch_cum_net_format  = 0;
        $total_branch_percent_target_format  = 0;
        $total_getBranchAnnualtarget  = 0;

        $total_newBegBal_fchn = 0;
        $total_newmonthBegBal_fchn  = 0;
        $total_newMonthBegBalCur_fchn  = 0;
        $total_getMonthlyGrossIn_fchn = 0;
        $total_getMonthlyAgent_fchn = 0;
        $total_getYearlyGrossIn_fchn  = 0;
        $total_branch_net_format_fchn = 0;
        $total_branch_cum_net_format_fchn  = 0;
        $total_branch_percent_target_format_fchn  = 0;
        $total_getBranchAnnualtarget_fchn  = 0;

        $total_newBegBal_fchm = 0;
        $total_newmonthBegBal_fchm  = 0;
        $total_newMonthBegBalCur_fchm  = 0;
        $total_getMonthlyGrossIn_fchm = 0;
        $total_getMonthlyAgent_fchm = 0;
        $total_getYearlyGrossIn_fchm  = 0;
        $total_branch_net_format_fchm = 0;
        $total_branch_cum_net_format_fchm  = 0;
        $total_branch_percent_target_format_fchm  = 0;
        $total_getBranchAnnualtarget_fchm  = 0;

        $grand_total_newBegBal = 0;
        $grand_total_newmonthBegBal  = 0;
        $grand_total_newMonthBegBalCur  = 0;
        $grand_total_getMonthlyGrossIn = 0;
        $grand_total_getMonthlyAgent= 0;
        $grand_total_getYearlyGrossIn  = 0;
        $grand_total_branch_net_format = 0;
        $grand_total_branch_cum_net_format  = 0;
        $grand_total_branch_percent_target_format  = 0;
        $grand_total_getBranchAnnualtarget  = 0;

        $total_newBegBal_rlc = 0;
        $total_newmonthBegBal_rlc  = 0;
        $total_newMonthBegBalCur_rlc  = 0;
        $total_getMonthlyGrossIn_rlc = 0;
        $total_getMonthlyAgent_rlc = 0;
        $total_getYearlyGrossIn_rlc  = 0;
        $total_branch_net_format_rlc = 0;
        $total_branch_cum_net_format_rlc  = 0;
        $total_branch_percent_target_format_rlc  = 0;
        $total_getBranchAnnualtarget_rlc  = 0;

        $total_newBegBal_elc = 0;
        $total_newmonthBegBal_elc  = 0;
        $total_newMonthBegBalCur_elc  = 0;
        $total_getMonthlyGrossIn_elc = 0;
        $total_getMonthlyAgent_elc = 0;
        $total_getYearlyGrossIn_elc  = 0;
        $total_branch_net_format_elc = 0;
        $total_branch_cum_net_format_elc  = 0;
        $total_branch_percent_target_format_elc  = 0;
        $total_getBranchAnnualtarget_elc  = 0;

        $final_grand_total_newBegBal = 0 ;
        $final_grand_total_newmonthBegBal = 0 ;
        $final_grand_total_newMonthBegBalCur = 0;
        $final_grand_toral_getMonthlyGrossIn = 0;
        $final_grand_total_getMonthlyAgent = 0;
        $final_grand_toral_getYearlyGrossIn = 0;
        $final_grand_total_branch_net_format = 0;
        $final_grand_total_branch_cum_net_format = 0;
        $final_grand_total_branch_percent_target_format = 0;
        $final_grand_total_getBranchAnnualtarget = 0;

        $previousBranchName = ''; // Initialize a variable to store the previous branch name

        foreach ($dataEMB as &$item1) {

            $branch_name = $item1['branch_name']; // Get the current branch name

            $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name);

            if (!empty($getSR)) {
                            
                foreach ($getSR as $key => $value) {

                    $sale_rep_emb_view = $value['rep_lname'].', '.$value['rep_fname'];

                    //get monthly gross in
                    $startMonth = date('Y-m-01', strtotime($monthEnd));
                    $endMonth = date('Y-m-t', strtotime($monthEnd));
                    $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name, $startMonth, $endMonth);

                    $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name, $startMonth, $endMonth);
    
                        //get last year end balance
                        $newBegBal = 0;
                   
                         $firstDayOfMonth = '1990-01-01';
                        $lastDayOfMonth = $lastYearDate . '-12-31';
                
                        $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonth, $lastDayOfMonth);
                        
                        $newBegBal = $begBal2;
                
        
                        //get last month end balance
                        $newmonthBegBal = 0;
        
                        $firstDayOfMonthPrev = '1990-01-01';
                        $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                      
                        // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                        $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                        
                        $newmonthBegBal = $begnewBal;                 
                  
            
                        //get this month end balance
                        $newMonthBegBalCur = 0;
        
                        $firstDayOfMonthCur = '1990-01-01';
                        $lastDayOfMonthCur = $monthEnd.'-31';
                    
                      
                        $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonthCur, $lastDayOfMonthCur);
                        
                        $newMonthBegBalCur = $begnewBalcur;
                        
                        //get this year end cumulative gross in
        
                        $startYear = $thisYearDate . '-01-01';
                        $endYear = $thisYearDate . '-12-31';
                        $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name, $startYear, $endYear);

                    //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                    $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                    $branch_net_format = $branch_net;
    
                    $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                    $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                    $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                    $branch_cum_net_format = $branch_cum_net;
    
                    $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name, $thisYearDate);
    
                    if ($branch_cum_net >= 0) {
                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                            $branch_percent_target_format_color = 'black';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                    } else {

                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                            $branch_percent_target_format_color = 'red';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                        
                    }
                    
                   
                    $currentBranchName = $item1['branch_name']; // Get the current branch name
                    
                    // Compare the current branch name with the previous one
                    if ($currentBranchName == $previousBranchName) {
                        $branch_name_emb_view = '';  // Set the branch name to empty if they are equal
                        $newBegBal_new = 0; $newBegBal_new2 = '';
                        $newmonthBegBal_new = 0; $newmonthBegBal2 = '';
                        $newMonthBegBalCur_new = 0; $newMonthBegBalCur2 = '';
                        $getMonthlyGrossIn_new = 0; $getMonthlyGrossIn2 = '';
                        $getMonthlyAgent_new = 0; $getMonthlyAgent2 = '';
                        $getYearlyGrossIn_new = 0; $getYearlyGrossIn2 = '';
                        $branch_net_format_new = 0; $branch_net_format2 = '';
                        $branch_cum_net_format_new = 0; $branch_cum_net_format2 = '';
                        $branch_percent_target_format_new = 0; $branch_percent_target_format2 = '';
                        $getBranchAnnualtarget_new = 0; $getBranchAnnualtarget2 = '';
                    
                    } else {

                        $branch_name_emb_view = $currentBranchName;
                        $newBegBal_new = $newBegBal; $newBegBal_new2 = $newBegBal;
                        $newmonthBegBal_new = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                        $newMonthBegBalCur_new = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                        $getMonthlyGrossIn_new = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                        $getMonthlyAgent_new = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                        $getYearlyGrossIn_new = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                        $branch_net_format_new = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                        $branch_cum_net_format_new = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                        $branch_percent_target_format_new = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                        $getBranchAnnualtarget_new = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                        
                    }
                    
                    $previousBranchName = $currentBranchName; // Update the previous branch name

                    $header .= <<<EOF
                    <table>
                    <tr>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_emb_view</th>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_emb_view </th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal_new2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color:$branch_net_format_display_color;">$branch_net_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color:$branch_cum_net_format_display_color ;">$branch_cum_net_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color:$branch_percent_target_format_color;">$branch_percent_target_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                    </tr>
                    </table>

                    EOF;

                    $total_newBegBal += intval($newBegBal_new);
                    $total_newmonthBegBal += intval($newmonthBegBal_new);
                    $total_newMonthBegBalCur += intval($newMonthBegBalCur_new);
                    $total_getMonthlyGrossIn += intval($getMonthlyGrossIn_new);
                    $total_getMonthlyAgent += intval($getMonthlyAgent_new);
                    $total_getYearlyGrossIn += intval($getYearlyGrossIn_new);
                    
                    if (intval($branch_net_format_new) < 0) {
                        $total_branch_net_format = $total_branch_net_format - abs(intval($branch_net_format_new));
                    } else {
                        $total_branch_net_format = $total_branch_net_format + intval($branch_net_format_new);
                    }

                    if (intval($branch_cum_net_format_new) < 0) {
                        $total_branch_cum_net_format = $total_branch_cum_net_format - abs(intval($branch_cum_net_format_new));
                    } else {
                        $total_branch_cum_net_format = $total_branch_cum_net_format + intval($branch_cum_net_format_new);
                    }

                    $total_getBranchAnnualtarget += intval($getBranchAnnualtarget_new);

                }

            }else{

                    $sale_rep_emb_view ='';

                    //get monthly gross in
                    $startMonth = date('Y-m-01', strtotime($monthEnd));
                    $endMonth = date('Y-m-t', strtotime($monthEnd));
                    $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name, $startMonth, $endMonth);

                    $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name, $startMonth, $endMonth);
    
                        //get last year end balance
                        $newBegBal = 0;
                   
                         $firstDayOfMonth = '1990-01-01';
                        $lastDayOfMonth = $lastYearDate . '-12-31';
                
                        $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonth, $lastDayOfMonth);
                        
                        $newBegBal = $begBal2;
                
        
                        //get last month end balance
                        $newmonthBegBal = 0;
        
                        $firstDayOfMonthPrev = '1990-01-01';
                        $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                      
                        // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                        $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                        
                        $newmonthBegBal = $begnewBal;                 
                  
            
                        //get this month end balance
                        $newMonthBegBalCur = 0;
        
                        $firstDayOfMonthCur = '1990-01-01';
                        $lastDayOfMonthCur = $monthEnd.'-31';
                    
                      
                        $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name, $firstDayOfMonthCur, $lastDayOfMonthCur);
                        
                        $newMonthBegBalCur = $begnewBalcur;
                        
                        //get this year end cumulative gross in
        
                        $startYear = $thisYearDate . '-01-01';
                        $endYear = $thisYearDate . '-12-31';
                        $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name, $startYear, $endYear);
        
                       //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                       $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                       $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                       $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                       $branch_net_format = $branch_net;
       
                       $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                       $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                       $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                       $branch_cum_net_format = $branch_cum_net;
    
                    $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name, $thisYearDate);
                    if ($branch_cum_net >= 0) {
                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                            $branch_percent_target_format_color = 'black';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                    } else {

                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                            $branch_percent_target_format_color = 'red';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                        
                    }
    
                    $currentBranchName = $item1['branch_name']; // Get the current branch name
                    
                    // Compare the current branch name with the previous one
                    if ($currentBranchName == $previousBranchName) {
                        $branch_name_emb_view = '';  // Set the branch name to empty if they are equal
                        $newBegBal_new = 0; $newBegBal_new2 = '';
                        $newmonthBegBal_new = 0; $newmonthBegBal2 = '';
                        $newMonthBegBalCur_new = 0; $newMonthBegBalCur2 = '';
                        $getMonthlyGrossIn_new = 0; $getMonthlyGrossIn2 = '';
                        $getMonthlyAgent_new = 0; $getMonthlyAgent2 = '';
                        $getYearlyGrossIn_new = 0; $getYearlyGrossIn2 = '';
                        $branch_net_format_new = 0; $branch_net_format2 = '';
                        $branch_cum_net_format_new = 0; $branch_cum_net_format2 = '';
                        $branch_percent_target_format_new = 0; $branch_percent_target_format2 = '';
                        $getBranchAnnualtarget_new = 0; $getBranchAnnualtarget2 = '';
                    
                    } else {

                        $branch_name_emb_view = $currentBranchName;
                        $newBegBal_new = $newBegBal; $newBegBal_new2 = $newBegBal;
                        $newmonthBegBal_new = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                        $newMonthBegBalCur_new = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                        $getMonthlyGrossIn_new = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                        $getMonthlyAgent_new = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                        $getYearlyGrossIn_new = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                        $branch_net_format_new = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                        $branch_cum_net_format_new = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                        $branch_percent_target_format_new = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format.'%';
                        $getBranchAnnualtarget_new = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                        
                    }
                    
                    $previousBranchName = $currentBranchName; // Update the previous branch name

                    $header .= <<<EOF
                    <table>
                    <tr>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_emb_view</th>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_emb_view </th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal_new2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color:$branch_net_format_display_color;">$branch_net_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color:$branch_cum_net_format_display_color ;">$branch_cum_net_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color:$branch_percent_target_format_color;">$branch_percent_target_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                    </tr>
                    </table>

                    EOF;

                    $total_newBegBal += intval($newBegBal_new);
                    $total_newmonthBegBal += intval($newmonthBegBal_new);
                    $total_newMonthBegBalCur += intval($newMonthBegBalCur_new);
                    $total_getMonthlyGrossIn += intval($getMonthlyGrossIn_new);
                    $total_getMonthlyAgent += intval($getMonthlyAgent_new);
                    $total_getYearlyGrossIn += intval($getYearlyGrossIn_new);
                    if (intval($branch_net_format_new) < 0) {
                        $total_branch_net_format = $total_branch_net_format - abs(intval($branch_net_format_new));
                    } else {
                        $total_branch_net_format = $total_branch_net_format + intval($branch_net_format_new);
                    }
                    
                    if (intval($branch_cum_net_format_new) < 0) {
                        $total_branch_cum_net_format = $total_branch_cum_net_format - abs(intval($branch_cum_net_format_new));
                    } else {
                        $total_branch_cum_net_format = $total_branch_cum_net_form + intval($branch_cum_net_format_new);
                    }
                    $total_getBranchAnnualtarget += intval($getBranchAnnualtarget_new);


            }

        }

        if ($total_branch_net_format >=  0) {
            $total_branch_net_format_emb = $total_branch_net_format;
            $total_branch_net_format_emb_color = 'black';
        } else {
            $total_branch_net_format_emb = '('.abs($total_branch_net_format).')';
            $total_branch_net_format_emb_color = 'red';
        }

        if ($total_branch_cum_net_format >=  0) {
            $total_branch_cum_net_format_emb = $total_branch_cum_net_format;
            $total_branch_cum_net_format_emb_color = 'black';
        } else {
            $total_branch_cum_net_format_emb = '('.abs($total_branch_cum_net_format).')';
            $total_branch_cum_net_format_emb_color = 'red';
        }

        //prevent error division by zero

        if ($total_branch_cum_net_format >= 0) {
            if ($total_branch_cum_net_format >= 0 && $total_getBranchAnnualtarget > 0 || $total_getBranchAnnualtarget > 0) {
            
                $quotient_branch_percent_target_format = $total_branch_cum_net_format / $total_getBranchAnnualtarget;
                $total_branch_percent_target_format = round($quotient_branch_percent_target_format, 2) * 100 . '%';
                $total_branch_percent_target_format_color = 'black';

            } else{
                $total_branch_percent_target_format = 0;
                $total_branch_percent_target_format_color = 'black';

            }
        } else {

            if ($total_branch_cum_net_format > 0 && $total_getBranchAnnualtarget > 0 || $total_getBranchAnnualtarget > 0) {
            
                $quotient_branch_percent_target_format = $total_branch_cum_net_format / $total_getBranchAnnualtarget;
                $total_branch_percent_target_format = '('.abs(round($quotient_branch_percent_target_format, 0)).')';
                $total_branch_percent_target_format_color = 'red';


            } else{
                $total_branch_percent_target_format = 0;
                $total_branch_percent_target_format_color = 'black';

            }
            
        }

        $tn_emb = number_format($total_newBegBal, 2, '.', ',');
        $tnb_emb = number_format($total_newmonthBegBal, 2, '.', ',');
        $tnm_emb = number_format($total_newMonthBegBalCur, 2, '.', ',');
        $tg_emb = number_format($total_getYearlyGrossIn, 2, '.', ',');

        $header .= <<<EOF
        <table>
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL EMB</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyGrossIn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyAgent</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color:$total_branch_net_format_emb_color;"><strong>$total_branch_net_format_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color:$total_branch_cum_net_format_emb_color;"><strong>$total_branch_cum_net_format_emb</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color:$total_branch_percent_target_format_color;"><strong>$total_branch_percent_target_format</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$total_getBranchAnnualtarget </strong></th>
        </tr>
        </table>
        
        EOF;

        $header .= <<<EOF
        <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </table>
        EOF;

        $header .= <<<EOF
        <table style="width: 100%;">
            <tr>
            
                <td style="width: 100%; text-align: left; padding-bottom: -300px;"><p style="font-size: 9px;"><strong>SALES REPRESENTATIVE AND SATELLITE OFFICERS SALES PERFORMANCE</strong></p></td> <!-- Centered cell -->
            
                
            </tr>
            <tr>
                
                <td style="width: 45%; text-align: left;"><p style="font-size: 10px;">FOR THE MONTH OF $dateTitle</p></td> <!-- Centered cell -->
                <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            </tr>
        </table>
        <table >
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><span></span><br> FCH </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"><span></span><br> SALES REPRESENTATIVE </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thLastYearDate <span></span><br></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thPrevMonth </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> END <br> $thCurYearDate </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> GROSS IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> Agents IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"> GROSS IN Cumulative <br> $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"><span></span><br> BRANCH NET $thCurYearDate  </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"><span></span><br> BRANCH CUM NET $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"><span></span><br> % vs Target </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> Annual Target </th>
        </tr>
        <tr>    
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;">FCH NEGROS </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
        </tr>
        </table>
        EOF;

        
       


    foreach ($dataFCHN as &$item1) {
        $branch_name_fchn = $item1['branch_name']; // Get the current branch name

        $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name_fchn);

        if (!empty($getSR)) {
            foreach ($getSR as $key => $value) {
                $sale_rep = $value['rep_lname'].', '.$value['rep_fname'];

                //get monthly gross in
                $startMonth = date('Y-m-01', strtotime($monthEnd));
                $endMonth = date('Y-m-t', strtotime($monthEnd));
                $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchn, $startMonth, $endMonth);

                $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_fchn, $startMonth, $endMonth);
                   
                    //get last year end balance
                    $newBegBal = 0;
                   
                     $firstDayOfMonth = '1990-01-01';
                    $lastDayOfMonth = $lastYearDate . '-12-31';
            
                    $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonth, $lastDayOfMonth);
                    
                    $newBegBal = $begBal2;
            
    
                    //get last month end balance
                    $newmonthBegBal = 0;
    
                    $firstDayOfMonthPrev = '1990-01-01';
                    $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                  
                    // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                    $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                    
                    $newmonthBegBal = $begnewBal;                 
              
        
                    //get this month end balance
                    $newMonthBegBalCur = 0;
    
                    $firstDayOfMonthCur = '1990-01-01';
                    $lastDayOfMonthCur = $monthEnd.'-31';
                
                  
                    $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonthCur, $lastDayOfMonthCur);
                    
                    $newMonthBegBalCur = $begnewBalcur;
                    
                    //get this year end cumulative gross in
    
                    $startYear = $thisYearDate . '-01-01';
                    $endYear = $thisYearDate . '-12-31';
                    $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchn, $startYear, $endYear);
    
                //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
               
                $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                $branch_net_format = $branch_net;

                $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                $branch_cum_net_format = $branch_cum_net;

                $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchn, $thisYearDate);

                if ($branch_cum_net >= 0) {
                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                        $branch_percent_target_format_color = 'black';


                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';

                    }
                } else {

                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                        $branch_percent_target_format_color = 'red';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';

                    }
                    
                }
                
                // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                // $branch_percent_target_format = round($branch_percent_target, 2) * 100;

                $currentBranchName = $item1['branch_name']; // Get the current branch name
                
                // Compare the current branch name with the previous one
                if ($currentBranchName == $previousBranchName) {
                    $branch_name_fchn = '';  // Set the branch name to empty if they are equal
                    $newBegBal_fchn = 0; $newBegBal_new2 = '';
                    $newmonthBegBal_fchn = 0; $newmonthBegBal2 = '';
                    $newMonthBegBalCur_fchn = 0; $newMonthBegBalCur2 = '';
                    $getMonthlyGrossIn_fchn = 0; $getMonthlyGrossIn2 = '';
                    $getMonthlyAgent_fchn = 0; $getMonthlyAgent2 = '';
                    $getYearlyGrossIn_fchn = 0; $getYearlyGrossIn2 = '';
                    $branch_net_format_fchn = 0; $branch_net_format2 = '';
                    $branch_cum_net_format_fchn = 0; $branch_cum_net_format2 = '';
                    $branch_percent_target_format_fchn = 0; $branch_percent_target_format2 = '';
                    $getBranchAnnualtarget_fchn = 0; $getBranchAnnualtarget2 = '';
                   
                } else {

                    $branch_name_fchn = $currentBranchName;
                    $newBegBal_fchn = $newBegBal; $newBegBal2 = $newBegBal;
                    $newmonthBegBal_fchn = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                    $newMonthBegBalCur_fchn = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                    $getMonthlyGrossIn_fchn = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                    $getMonthlyAgent_fchn = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                    $getYearlyGrossIn_fchn = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                    $branch_net_format_fchn = $branch_net_format; $branch_net_format2 = $branch_net_format;
                    $branch_cum_net_format_fchn= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                    $branch_percent_target_format_fchn = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                    $getBranchAnnualtarget_fchn = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                    
                }

                $previousBranchName = $currentBranchName; // Update the previous branch name

                            
                if ($branch_net_format_fchn >=  0) {
                    $branch_net_format_fchn_view = $branch_net_format_fchn;
                    $branch_net_format_fchn_view_color = 'black';
                } else {
                    $branch_net_format_fchn_view = '('.abs($branch_net_format_fchn).')';
                    $branch_net_format_fchn_view_color = 'red';
                }

                if ($branch_cum_net_format_fchn >=  0) {
                    $branch_cum_net_format_fchn_view = $branch_cum_net_format_fchn;
                    $branch_cum_net_format_fchn_view_color = 'black';
                } else {
                    $branch_cum_net_format_fchn_view = '('.abs($branch_cum_net_format_fchn).')';
                    $branch_cum_net_format_fchn_view_color = 'red';
                }
                                
                $header .= <<<EOF
                <table>
                <tr>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_fchn</th>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep </th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_fchn_view_color;">$branch_net_format_fchn_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_fchn_view_color;">$branch_cum_net_format_fchn_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                </tr>
                </table>
                
                EOF;

                $total_newBegBal_fchn += intval($newBegBal_fchn);
                $total_newmonthBegBal_fchn += intval($newmonthBegBal_fchn);
                $total_newMonthBegBalCur_fchn += intval($newMonthBegBalCur_fchn);
                $total_getMonthlyGrossIn_fchn += intval($getMonthlyGrossIn_fchn);
                $total_getMonthlyAgent_fchn += intval($getMonthlyAgent_fchn);
                $total_getYearlyGrossIn_fchn += intval($getYearlyGrossIn_fchn);
                $total_getBranchAnnualtarget_fchn += intval($getBranchAnnualtarget_fchn);

                if (intval($branch_net_format_fchn) < 0) {
                    $total_branch_net_format_fchn = $total_branch_net_format_fchn - abs(intval($branch_net_format_fchn));
                } else {
                    $total_branch_net_format_fchn = $total_branch_net_format_fchn + intval($branch_net_format_fchn);
                }
                
                if (intval($branch_cum_net_format_fchn) < 0) {
                    $total_branch_cum_net_format_fchn = $total_branch_cum_net_format_fchn - abs(intval($branch_cum_net_format_fchn));
                } else {
                    $total_branch_cum_net_format_fchn = $total_branch_cum_net_format_fchn + intval($branch_cum_net_format_fchn);
                }

            }
        } else {
            $sale_rep = '';

                //get monthly gross in
                $startMonth = date('Y-m-01', strtotime($monthEnd));
                $endMonth = date('Y-m-t', strtotime($monthEnd));
                $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchn, $startMonth, $endMonth);

                $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_fchn, $startMonth, $endMonth);
                    
                  //get last year end balance
                  $newBegBal = 0;
                   
                   $firstDayOfMonth = '1990-01-01';
                  $lastDayOfMonth = $lastYearDate . '-12-31';
          
                  $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonth, $lastDayOfMonth);
                  
                  $newBegBal = $begBal2;
          
  
                  //get last month end balance
                  $newmonthBegBal = 0;
  
                  $firstDayOfMonthPrev = '1990-01-01';
                  $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                
                  // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                  $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                  
                  $newmonthBegBal = $begnewBal;                 
            
      
                  //get this month end balance
                  $newMonthBegBalCur = 0;
  
                  $firstDayOfMonthCur = '1990-01-01';
                  $lastDayOfMonthCur = $monthEnd.'-31';
              
                
                  $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchn, $firstDayOfMonthCur, $lastDayOfMonthCur);
                  
                  $newMonthBegBalCur = $begnewBalcur;
                  
                  //get this year end cumulative gross in
  
                  $startYear = $thisYearDate . '-01-01';
                  $endYear = $thisYearDate . '-12-31';
                  $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchn, $startYear, $endYear);
    
                //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                $branch_net_format = $branch_net;

                $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                $branch_cum_net_format = $branch_cum_net;

                $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchn, $thisYearDate);

                if ($branch_cum_net >= 0) {
                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                        $branch_percent_target_format_color = 'black';


                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';

                    }
                } else {

                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                        $branch_percent_target_format_color = 'red';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';

                    }
                    
                }
                
                // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                // $branch_percent_target_format = round($branch_percent_target, 2) * 100;

                $currentBranchName = $item1['branch_name']; // Get the current branch name
                
                // Compare the current branch name with the previous one
                if ($currentBranchName == $previousBranchName) {
                    $branch_name_fchn = '';  // Set the branch name to empty if they are equal
                    $newBegBal_fchn = 0; $newBegBal_new2 = '';
                    $newmonthBegBal_fchn = 0; $newmonthBegBal2 = '';
                    $newMonthBegBalCur_fchn = 0; $newMonthBegBalCur2 = '';
                    $getMonthlyGrossIn_fchn = 0; $getMonthlyGrossIn2 = '';
                    $getMonthlyAgent_fchn = 0; $getMonthlyAgent2 = '';
                    $getYearlyGrossIn_fchn = 0; $getYearlyGrossIn2 = '';
                    $branch_net_format_fchn = 0; $branch_net_format2 = '';
                    $branch_cum_net_format_fchn = 0; $branch_cum_net_format2 = '';
                    $branch_percent_target_format_fchn = 0; $branch_percent_target_format2 = '';
                    $getBranchAnnualtarget_fchn = 0; $getBranchAnnualtarget2 = '';
                   
                } else {

                    $branch_name_fchn = $currentBranchName;
                    $newBegBal_fchn = $newBegBal; $newBegBal2 = $newBegBal;
                    $newmonthBegBal_fchn = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                    $newMonthBegBalCur_fchn = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                    $getMonthlyGrossIn_fchn = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                    $getMonthlyAgent_fchn = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                    $getYearlyGrossIn_fchn = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                    $branch_net_format_fchn = $branch_net_format; $branch_net_format2 = $branch_net_format;
                    $branch_cum_net_format_fchn= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                    $branch_percent_target_format_fchn = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                    $getBranchAnnualtarget_fchn = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                    
                }

                $previousBranchName = $currentBranchName; // Update the previous branch name

                            
                if ($branch_net_format_fchn >=  0) {
                    $branch_net_format_fchn_view = $branch_net_format_fchn;
                    $branch_net_format_fchn_view_color = 'black';
                } else {
                    $branch_net_format_fchn_view = '('.abs($branch_net_format_fchn).')';
                    $branch_net_format_fchn_view_color = 'red';
                }

                if ($branch_cum_net_format_fchn >=  0) {
                    $branch_cum_net_format_fchn_view = $branch_cum_net_format_fchn;
                    $branch_cum_net_format_fchn_view_color = 'black';
                } else {
                    $branch_cum_net_format_fchn_view = '('.abs($branch_cum_net_format_fchn).')';
                    $branch_cum_net_format_fchn_view_color = 'red';
                }
                                
                $header .= <<<EOF
                <table>
                <tr>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_fchn</th>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep </th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_fchn_view_color;">$branch_net_format_fchn_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_fchn_view_color;">$branch_cum_net_format_fchn_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                </tr>
                </table>
                
                EOF;

                $total_newBegBal_fchn += intval($newBegBal_fchn);
                $total_newmonthBegBal_fchn += intval($newmonthBegBal_fchn);
                $total_newMonthBegBalCur_fchn += intval($newMonthBegBalCur_fchn);
                $total_getMonthlyGrossIn_fchn += intval($getMonthlyGrossIn_fchn);
                $total_getMonthlyAgent_fchn += intval($getMonthlyAgent_fchn);
                $total_getYearlyGrossIn_fchn += intval($getYearlyGrossIn_fchn);

                if (intval($branch_net_format_fchn) < 0) {
                    $total_branch_net_format_fchn = $total_branch_net_format_fchn - abs(intval($branch_net_format_fchn));
                } else {
                    $total_branch_net_format_fchn = $total_branch_net_format_fchn + intval($branch_net_format_fchn);
                }
                
                if (intval($branch_cum_net_format_fchn) < 0) {
                    $total_branch_cum_net_format_fchn = $total_branch_cum_net_format_fchn - abs(intval($branch_cum_net_format_fchn));
                } else {
                    $total_branch_cum_net_format_fchn = $total_branch_cum_net_format_fchn + intval($branch_cum_net_format_fchn);
                }
                $total_getBranchAnnualtarget_fchn += intval($getBranchAnnualtarget_fchn);
        }
        
    }

    if ($total_branch_net_format_fchn >=  0) {
        $total_branch_net_format_fchn_view = $total_branch_net_format_fchn;
        $total_branch_net_format_fchn_view_color = 'black';
    } else {
        $total_branch_net_format_fchn_view = '('.abs($total_branch_net_format_fchn).')';
        $total_branch_net_format_fchn_view_color = 'red';
    }

    if ($total_branch_cum_net_format_fchn >=  0) {
        $total_branch_cum_net_format_fchn_view = $total_branch_cum_net_format_fchn;
        $total_branch_cum_net_format_fchn_view_color = 'black';
    } else {
        $total_branch_cum_net_format_fchn_view = '('.abs($total_branch_cum_net_format_fchn).')';
        $total_branch_cum_net_format_fchn_view_color = 'red';
    }

    //prevent error division by zero

    if ($total_branch_cum_net_format_fchn >= 0) {
        if ($total_branch_cum_net_format_fchn > 0 && $total_getBranchAnnualtarget_fchn > 0 || $total_getBranchAnnualtarget_fchn > 0) {
        
            $quotient_branch_percent_target_format_fchn = $branch_cum_net / $getBranchAnnualtarget;
            $total_branch_percent_target_format_fchn = round($quotient_branch_percent_target_format_fchn, 2) * 100 . '%';
            $total_branch_percent_target_format_fchn_color = 'black';

        } else{
            $total_branch_percent_target_format_fchn = 0;
            $total_branch_percent_target_format_fchn_color = 'black';
        }
    } else {

        if ($total_branch_cum_net_format_fchn > 0 && $total_getBranchAnnualtarget_fchn > 0 || $total_getBranchAnnualtarget_fchn > 0) {
        
            $quotient_branch_percent_target_format_fchn = $branch_cum_net / $getBranchAnnualtarget;
            $total_branch_percent_target_format_fchn = '('.abs(round($quotient_branch_percent_target_format_fchn, 0)).')';
            $total_branch_percent_target_format_fchn_color = 'red';

        } else{
            $total_branch_percent_target_format_fchn = 0;
            $total_branch_percent_target_format_fchn_color = 'black';
        }
        
    }

    $tn_fchn = number_format($total_newBegBal_fchn, 2, '.', ',');
    $tnb_fchn = number_format($total_newmonthBegBal_fchn, 2, '.', ',');
    $tnm_fchn = number_format($total_newMonthBegBalCur_fchn, 2, '.', ',');
    $tg_fchn = number_format($total_getYearlyGrossIn_fchn, 2, '.', ',');

    
        $header .= <<<EOF
        <table>
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyGrossIn_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyAgent_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color:$total_branch_net_format_fchn_view_color;"><strong>$total_branch_net_format_fchn_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color:$total_branch_cum_net_format_fchn_view_color;"><strong>$total_branch_cum_net_format_fchn_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $total_branch_percent_target_format_fchn_color;"><strong>$total_branch_percent_target_format_fchn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$total_getBranchAnnualtarget_fchn </strong></th>
        </tr>
        </table>
        EOF;

        $header .= <<<EOF
        <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </table>
        EOF;

        $header .= <<<EOF
        <table >
        <tr>    
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;">FCH MANILA </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"></th>
        </tr>
        </table>
        EOF;
        foreach ($dataFCHM as &$item1) {
            $branch_name_fchm = $item1['branch_name']; // Get the current branch name

            $getSR_fchm = (new ControllerPensioner)->ctrGetSalesRep($branch_name_fchm);
            if (!empty($getSR_fchm)) {

            foreach ($getSR_fchm as $key => $values) {
                $sale_rep_fchm = $values['rep_lname'].', '.$values['rep_fname'];

                //get monthly gross in
                $startMonth = date('Y-m-01', strtotime($monthEnd));
                $endMonth = date('Y-m-t', strtotime($monthEnd));
                $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchm, $startMonth, $endMonth);

                $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_fchm, $startMonth, $endMonth);

                   //get last year end balance
                   $newBegBal = 0;
                   
                    $firstDayOfMonth = '1990-01-01';
                   $lastDayOfMonth = $lastYearDate . '-12-31';
           
                   $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonth, $lastDayOfMonth);
                   
                   $newBegBal = $begBal2;
           
   
                   //get last month end balance
                   $newmonthBegBal = 0;
   
                   $firstDayOfMonthPrev = '1990-01-01';
                   $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                 
                   // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                   $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                   
                   $newmonthBegBal = $begnewBal;                 
             
       
                   //get this month end balance
                   $newMonthBegBalCur = 0;
   
                   $firstDayOfMonthCur = '1990-01-01';
                   $lastDayOfMonthCur = $monthEnd.'-31';
               
                 
                   $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonthCur, $lastDayOfMonthCur);
                   
                   $newMonthBegBalCur = $begnewBalcur;
                   
                   //get this year end cumulative gross in
   
                   $startYear = $thisYearDate . '-01-01';
                   $endYear = $thisYearDate . '-12-31';
                   $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchm, $startYear, $endYear);
    
                //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
             
                $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                $branch_net_format = $branch_net;

                $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                $branch_cum_net_format = $branch_cum_net;

                $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchm, $thisYearDate);

                if ($branch_cum_net >= 0) {
                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                        $branch_percent_target_format_color = 'black';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';
                    }
                } else {

                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                        $branch_percent_target_format_color = 'red';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';
                    }
                    
                }
                
                // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                // $branch_percent_target_format = round($branch_percent_target, 2) * 100;

                $currentBranchName = $item1['branch_name']; // Get the current bran

                
                // Compare the current branch name with the previous one
                if ($currentBranchName == $previousBranchName) {
                    $branch_name_fchm = '';  // Set the branch name to empty if they are equal
                    $newBegBal_fchm = 0; $newBegBal_new2 = '';
                    $newmonthBegBal_fchm = 0; $newmonthBegBal2 = '';
                    $newMonthBegBalCur_fchm = 0; $newMonthBegBalCur2 = '';
                    $getMonthlyGrossIn_fchm = 0; $getMonthlyGrossIn2 = '';
                    $getMonthlyAgent_fchm = 0; $getMonthlyAgent2 = '';
                    $getYearlyGrossIn_fchm = 0; $getYearlyGrossIn2 = '';
                    $branch_net_format_fchm = 0; $branch_net_format2 = '';
                    $branch_cum_net_format_fchm = 0; $branch_cum_net_format2 = '';
                    $branch_percent_target_format_fchm = 0; $branch_percent_target_format2 = '';
                    $getBranchAnnualtarget_fchm = 0; $getBranchAnnualtarget2 = '';
                   
                } else {
                    $branch_name_fchm = $currentBranchName;
                    $newBegBal_fchm = $newBegBal; $newBegBal2 = $newBegBal;
                    $newmonthBegBal_fchm = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                    $newMonthBegBalCur_fchm = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                    $getMonthlyGrossIn_fchm = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                    $getMonthlyAgent_fchm = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                    $getYearlyGrossIn_fchm = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                    $branch_net_format_fchm = $branch_net_format; $branch_net_format2 = $branch_net_format;
                    $branch_cum_net_format_fchm= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                    $branch_percent_target_format_fchm = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                    $getBranchAnnualtarget_fchm = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                    
                }

                $previousBranchName = $currentBranchName; // Update the previous branch name

                if ($branch_net_format_fchm >=  0) {
                    $branch_net_format_fchm_view = $branch_net_format_fchm;
                    $branch_net_format_fchm_view_color = 'black';
                } else {
                    $branch_net_format_fchm_view = '('.abs($branch_net_format_fchm).')';
                    $branch_net_format_fchm_view_color = 'red';
                }

                if ($branch_cum_net_format_fchm >=  0) {
                    $branch_cum_net_format_fchm_view = $branch_cum_net_format_fchm;
                    $branch_cum_net_format_fchm_view_black = 'black';
                } else {
                    $branch_cum_net_format_fchm_view = '('.abs($branch_cum_net_format_fchm).')';
                    $branch_cum_net_format_fchm_view_black = 'red';
                }
                    
                        
                $header .= <<<EOF
                <table>
                <tr>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_fchm</th>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_fchm </th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_fchm_view_color;">$branch_net_format_fchm_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_fchm_view_black;">$branch_cum_net_format_fchm_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                </tr>
                </table>
                EOF;

                $total_newBegBal_fchm += intval($newBegBal_fchm);
                $total_newmonthBegBal_fchm += intval($newmonthBegBal_fchm);
                $total_newMonthBegBalCur_fchm += intval($newMonthBegBalCur_fchm);
                $total_getMonthlyGrossIn_fchm += intval($getMonthlyGrossIn_fchm);
                $total_getMonthlyAgent_fchm += intval($getMonthlyAgent_fchm);
                $total_getYearlyGrossIn_fchm += intval($getYearlyGrossIn_fchm);

                if (intval($branch_net_format_fchm) < 0) {
                    $total_branch_net_format_fchm = $total_branch_net_format_fchm - abs(intval($branch_net_format_fchm));
                } else {
                    $total_branch_net_format_fchm = $total_branch_net_format_fchm + intval($branch_net_format_fchm);
                }
                
                if (intval($branch_cum_net_format_fchm) < 0) {
                    $total_branch_cum_net_format_fchm = $total_branch_cum_net_format_fchm - abs(intval($branch_cum_net_format_fchm));
                } else {
                    $total_branch_cum_net_format_fchm = $total_branch_cum_net_format_fchm + intval($branch_cum_net_format_fchm);
                }
                $total_getBranchAnnualtarget_fchm += intval($getBranchAnnualtarget_fchm);
            }

            } else {

                $sale_rep_fchm = '';

                //get monthly gross in
                $startMonth = date('Y-m-01', strtotime($monthEnd));
                $endMonth = date('Y-m-t', strtotime($monthEnd));
                $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchm, $startMonth, $endMonth);

                $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_fchm, $startMonth, $endMonth);

                    //get last year end balance
                    $newBegBal = 0;
                   
                     $firstDayOfMonth = '1990-01-01';
                    $lastDayOfMonth = $lastYearDate . '-12-31';
            
                    $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonth, $lastDayOfMonth);
                    
                    $newBegBal = $begBal2;
            
    
                    //get last month end balance
                    $newmonthBegBal = 0;
    
                    $firstDayOfMonthPrev = '1990-01-01';
                    $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                  
                    // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                    $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                    
                    $newmonthBegBal = $begnewBal;                 
              
        
                    //get this month end balance
                    $newMonthBegBalCur = 0;
    
                    $firstDayOfMonthCur = '1990-01-01';
                    $lastDayOfMonthCur = $monthEnd.'-31';
                
                  
                    $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_fchm, $firstDayOfMonthCur, $lastDayOfMonthCur);
                    
                    $newMonthBegBalCur = $begnewBalcur;
                    
                    //get this year end cumulative gross in
    
                    $startYear = $thisYearDate . '-01-01';
                    $endYear = $thisYearDate . '-12-31';
                    $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_fchm, $startYear, $endYear);
    
                //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                $branch_net_format = $branch_net;

                $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                $branch_cum_net_format = $branch_cum_net;

                $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchm, $thisYearDate);

                if ($branch_cum_net >= 0) {
                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                        $branch_percent_target_format_color = 'black';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';
                    }
                } else {

                    if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                    
                        $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                        $branch_percent_target_format_color = 'red';

                    } else{
                        $branch_percent_target_format = 0;
                        $branch_percent_target_format_color = 'black';
                    }
                    
                }
                
                // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                // $branch_percent_target_format = round($branch_percent_target, 2) * 100;

                $currentBranchName = $item1['branch_name']; // Get the current bran

                
                // Compare the current branch name with the previous one
                if ($currentBranchName == $previousBranchName) {
                    $branch_name_fchm = '';  // Set the branch name to empty if they are equal
                    $newBegBal_fchm = 0; $newBegBal_new2 = '';
                    $newmonthBegBal_fchm = 0; $newmonthBegBal2 = '';
                    $newMonthBegBalCur_fchm = 0; $newMonthBegBalCur2 = '';
                    $getMonthlyGrossIn_fchm = 0; $getMonthlyGrossIn2 = '';
                    $getMonthlyAgent_fchm = 0; $getMonthlyAgent2 = '';
                    $getYearlyGrossIn_fchm = 0; $getYearlyGrossIn2 = '';
                    $branch_net_format_fchm = 0; $branch_net_format2 = '';
                    $branch_cum_net_format_fchm = 0; $branch_cum_net_format2 = '';
                    $branch_percent_target_format_fchm = 0; $branch_percent_target_format2 = '';
                    $getBranchAnnualtarget_fchm = 0; $getBranchAnnualtarget2 = '';
                   
                } else {
                    $branch_name_fchm = $currentBranchName;
                    $newBegBal_fchm = $newBegBal; $newBegBal2 = $newBegBal;
                    $newmonthBegBal_fchm = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                    $newMonthBegBalCur_fchm = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                    $getMonthlyGrossIn_fchm = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                    $getMonthlyAgent_fchm = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                    $getYearlyGrossIn_fchm = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                    $branch_net_format_fchm = $branch_net_format; $branch_net_format2 = $branch_net_format;
                    $branch_cum_net_format_fchm= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                    $branch_percent_target_format_fchm = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                    $getBranchAnnualtarget_fchm = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                    
                }

                $previousBranchName = $currentBranchName; // Update the previous branch name

                if ($branch_net_format_fchm >=  0) {
                    $branch_net_format_fchm_view = $branch_net_format_fchm;
                    $branch_net_format_fchm_view_color = 'black';
                } else {
                    $branch_net_format_fchm_view = '('.abs($branch_net_format_fchm).')';
                    $branch_net_format_fchm_view_color = 'red';
                }

                if ($branch_cum_net_format_fchm >=  0) {
                    $branch_cum_net_format_fchm_view = $branch_cum_net_format_fchm;
                    $branch_cum_net_format_fchm_view_black = 'black';
                } else {
                    $branch_cum_net_format_fchm_view = '('.abs($branch_cum_net_format_fchm).')';
                    $branch_cum_net_format_fchm_view_black = 'red';
                }
                    
                        
                $header .= <<<EOF
                <table>
                <tr>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_fchm</th>
                    <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_fchm </th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_fchm_view_color;">$branch_net_format_fchm_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_fchm_view_black;">$branch_cum_net_format_fchm_view</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                    <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                </tr>
                </table>
                EOF;

                $total_newBegBal_fchm += intval($newBegBal_fchm);
                $total_newmonthBegBal_fchm += intval($newmonthBegBal_fchm);
                $total_newMonthBegBalCur_fchm += intval($newMonthBegBalCur_fchm);
                $total_getMonthlyGrossIn_fchm += intval($getMonthlyGrossIn_fchm);
                $total_getMonthlyAgent_fchm += intval($getMonthlyAgent_fchm);
                $total_getYearlyGrossIn_fchm += intval($getYearlyGrossIn_fchm);
                if (intval($branch_net_format_fchm) < 0) {
                    $total_branch_net_format_fchm = $total_branch_net_format_fchm - abs(intval($branch_net_format_fchm));
                } else {
                    $total_branch_net_format_fchm = $total_branch_net_format_fchm + intval($branch_net_format_fchm);
                }
                
                if (intval($branch_cum_net_format_fchm) < 0) {
                    $total_branch_cum_net_format_fchm = $total_branch_cum_net_format_fchm - abs(intval($branch_cum_net_format_fchm));
                } else {
                    $total_branch_cum_net_format_fchm = $total_branch_cum_net_format_fchm + intval($branch_cum_net_format_fchm);
                }
                $total_getBranchAnnualtarget_fchm += intval($getBranchAnnualtarget_fchm);
            }
            
        }

        
        if ($total_branch_net_format_fchm >=  0) {
            $total_branch_net_format_fchm_view = $total_branch_net_format_fchm;
            $total_branch_net_format_fchm_view_color = 'black';
        } else {
            $total_branch_net_format_fchm_view = '('.abs($total_branch_net_format_fchm).')';
            $total_branch_net_format_fchm_view_color = 'red';
        }
    
        if ($total_branch_cum_net_format_fchm >=  0) {
            $total_branch_cum_net_format_fchm_view = $total_branch_cum_net_format_fchm;
            $total_branch_cum_net_format_fchm_view_color = 'black';
        } else {
            $total_branch_cum_net_format_fchm_view = '('.abs($total_branch_cum_net_format_fchm).')';
            $total_branch_cum_net_format_fchm_view_color = 'red';
        }
    
        //prevent error division by zero
    
        if ($total_branch_cum_net_format_fchm >= 0) {
            if ($total_branch_cum_net_format_fchm > 0 && $total_getBranchAnnualtarget_fchm > 0 || $total_getBranchAnnualtarget_fchm > 0) {
            
                $quotient_branch_percent_target_format_fchm = $branch_cum_net / $getBranchAnnualtarget;
                $total_branch_percent_target_format_fchm = round($quotient_branch_percent_target_format_fchm, 2) * 100 . '%';
                $total_branch_percent_target_format_fchm_color = 'black';
    
            } else{
                $total_branch_percent_target_format_fchm = 0;
                $total_branch_percent_target_format_fchm_color = 'black';
            }
        } else {
    
            if ($total_branch_cum_net_format_fchm > 0 && $total_getBranchAnnualtarget_fchm > 0 || $total_getBranchAnnualtarget_fchm > 0) {
            
                $quotient_branch_percent_target_format_fchm = $branch_cum_net / $getBranchAnnualtarget;
                $total_branch_percent_target_format_fchm = '('.abs(round($quotient_branch_percent_target_format_fchm, 0)).')';
                $total_branch_percent_target_format_fchm_color = 'red';
    
            } else{
                $total_branch_percent_target_format_fchm = 0;
                $total_branch_percent_target_format_fchm_color = 'black';
            }
            
        }


        $tn_fchm = number_format($total_newBegBal_fchm, 2, '.', ',');
        $tnb_fchm = number_format($total_newmonthBegBal_fchm, 2, '.', ',');
        $tnm_fchm = number_format($total_newMonthBegBalCur_fchm, 2, '.', ',');
        $tg_fchm = number_format($total_getYearlyGrossIn_fchm, 2, '.', ',');


        $header .= <<<EOF
        <table>
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyGrossIn_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyAgent_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color:$total_branch_net_format_fchm_view_color;"><strong>$total_branch_net_format_fchm_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color:$total_branch_cum_net_format_fchm_view_color;"><strong>$total_branch_cum_net_format_fchm_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $total_branch_percent_target_format_fchm_color;"><strong>$total_branch_percent_target_format_fchm</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$total_getBranchAnnualtarget_fchm </strong></th>
        </tr>
        </table>
        EOF;

        $grand_total_newBegBal = $total_newBegBal_fchm + $total_newBegBal_fchn;
        $grand_total_newmonthBegBal  = $total_newmonthBegBal_fchm + $total_newmonthBegBal_fchn;
        $grand_total_newMonthBegBalCur  = $total_newMonthBegBalCur_fchm + $total_newMonthBegBalCur_fchn;
        $grand_total_getMonthlyGrossIn = $total_getMonthlyGrossIn_fchm + $total_getMonthlyGrossIn_fchn;
        $grand_total_getMonthlyAgent = $total_getMonthlyAgent_fchm + $total_getMonthlyAgent_fchn;
        $grand_total_getYearlyGrossIn  = $total_getYearlyGrossIn_fchm +$total_getYearlyGrossIn_fchn;
        $grand_total_branch_net_format = $total_branch_net_format_fchm + $total_branch_net_format_fchn;
        $grand_total_branch_cum_net_format  = $total_branch_cum_net_format_fchm + $total_branch_cum_net_format_fchn;
       
        $grand_total_getBranchAnnualtarget  = $total_getBranchAnnualtarget_fchm + $total_getBranchAnnualtarget_fchn;

        if ($grand_total_branch_cum_net_format >= 0) {
            if ($grand_total_branch_cum_net_format > 0 && $grand_total_getBranchAnnualtarget > 0 || $grand_total_getBranchAnnualtarget > 0) {
            
                $grand_total_quotient_branch_percent_target_format = $grand_total_branch_cum_net_format / $grand_total_getBranchAnnualtarget;
                $grand_total_branch_percent_target_format = round($grand_total_quotient_branch_percent_target_format, 2) * 100 . '%';
                $grand_total_branch_percent_target_format_color = 'black';

            } else{
                $grand_total_branch_percent_target_format = 0;
                $grand_total_branch_percent_target_format_color = 'black';
            }
        } else {

            if ($grand_total_branch_cum_net_format > 0 && $grand_total_getBranchAnnualtarget > 0 || $grand_total_getBranchAnnualtarget > 0) {
            
                $grand_total_quotient_branch_percent_target_format = $grand_total_branch_cum_net_format / $grand_total_getBranchAnnualtarget;
                $grand_total_branch_percent_target_format = '('.abs(round($grand_total_quotient_branch_percent_target_format, 0)).')';
                $grand_total_branch_percent_target_format_color = 'red';

            } else{
                $grand_total_branch_percent_target_format = 0;
                $grand_total_branch_percent_target_format_color = 'black';
            }
            
        }


        if ($grand_total_branch_net_format >=  0) {
            $grand_total_branch_net_format_fchm_view = $grand_total_branch_net_format;
            $grand_total_branch_net_format_fchm_view_color = 'black';
        } else {
            $grand_total_branch_net_format_fchm_view = '('.abs($grand_total_branch_net_format).')';
            $grand_total_branch_net_format_fchm_view_color = 'red';
        }

        if ($grand_total_branch_cum_net_format >=  0) {
            $grand_total_branch_cum_net_format_fchm_view = $grand_total_branch_cum_net_format;
            $grand_total_branch_cum_net_format_fchm_view_color = 'black';
        } else {
            $grand_total_branch_cum_net_format_fchm_view = '('.abs($grand_total_branch_cum_net_format).')';
            $grand_total_branch_cum_net_format_fchm_view_color = 'red';
        }
        $tn_fch_total = number_format($grand_total_newBegBal, 2, '.', ',');
        $tnb_fch_total = number_format($grand_total_newmonthBegBal, 2, '.', ',');
        $tnm_fch_total = number_format($grand_total_newMonthBegBalCur, 2, '.', ',');
        $tg_fch_total = number_format($grand_total_getYearlyGrossIn, 2, '.', ',');


        $header .= <<<EOF
        <table>
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL FCH</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_fch_total</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_fch_total</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_fch_total</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$grand_total_getMonthlyGrossIn</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$grand_total_getMonthlyAgent</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_fch_total</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $grand_total_branch_net_format_fchm_view_color;"><strong>$grand_total_branch_net_format_fchm_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $grand_total_branch_cum_net_format_fchm_view_color;"><strong>$grand_total_branch_cum_net_format_fchm_view</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $grand_total_branch_percent_target_format_color;"><strong>$grand_total_branch_percent_target_format</strong></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$grand_total_getBranchAnnualtarget </strong></th>
        </tr>
        </table>
        
        EOF;

        
        $header .= <<<EOF
        <table>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </table>
        EOF;

        $header .= <<<EOF
        <table >
        <tr>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><span></span><br> RFC </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"><span></span><br> SALES REPRESENTATIVE </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thLastYearDate <span></span><br></th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thPrevMonth </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> END <br> $thCurYearDate </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> GROSS IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> Agents IN</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"> GROSS IN Cumulative <br> $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"><span></span><br> BRANCH NET $thCurYearDate  </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"><span></span><br> BRANCH CUM NET $thLastYearDate-$thCurYearDate</th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"><span></span><br> % vs Target </th>
            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> Annual Target </th>
        </tr>
        </table>
        EOF;

        

        foreach ($dataRLC as &$item1) {
            $branch_name_rlc = $item1['branch_name']; // Get the current branch name

            $getSR_RLC = (new ControllerPensioner)->ctrGetSalesRep($branch_name_rlc);

            if (!empty($getSR_RLC)) {
                foreach ($getSR_RLC as $key => $value) {
                    $sale_rep_rlc = $value['rep_lname'].', '.$value['rep_fname'];

                    //get monthly gross in
                    $startMonth = date('Y-m-01', strtotime($monthEnd));
                    $endMonth = date('Y-m-t', strtotime($monthEnd));
                    $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_rlc, $startMonth, $endMonth);

                    $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_rlc, $startMonth, $endMonth);
    
                     //get last year end balance
                     $newBegBal = 0;
                   
                     $firstDayOfMonth = '1990-01-01';
                     $lastDayOfMonth = $lastYearDate . '-12-31';
             
                     $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonth, $lastDayOfMonth);
                     
                     $newBegBal = $begBal2;
             
     
                     //get last month end balance
                     $newmonthBegBal = 0;
     
                     $firstDayOfMonthPrev = '1990-01-01';
                     $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                   
                     // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                     $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                     
                     $newmonthBegBal = $begnewBal;                 
               
         
                     //get this month end balance
                     $newMonthBegBalCur = 0;
     
                     $firstDayOfMonthCur = '1990-01-01';
                     $lastDayOfMonthCur = $monthEnd.'-31';
                 
                   
                     $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonthCur, $lastDayOfMonthCur);
                     
                     $newMonthBegBalCur = $begnewBalcur;
                     
                     //get this year end cumulative gross in
     
                     $startYear = $thisYearDate . '-01-01';
                     $endYear = $thisYearDate . '-12-31';
                     $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_rlc, $startYear, $endYear);
        
                   
                    $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                    $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                    $branch_net_format = $branch_net;
    
                    $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                    $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                    $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                    $branch_cum_net_format = $branch_cum_net;
                    $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_rlc, $thisYearDate);
    
                    if ($branch_cum_net >= 0) {
                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                            $branch_percent_target_format_color = 'black';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                    } else {

                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                            $branch_percent_target_format_color = 'red';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                        
                    }
                    
                    // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                    // $branch_percent_target_format = round($branch_percent_target, 2) * 100;
    
                    $currentBranchName = $item1['branch_name']; // Get the current branch name
                    
                    // Compare the current branch name with the previous one
                    if ($currentBranchName == $previousBranchName) {
                        $branch_name_rlc = '';  // Set the branch name to empty if they are equal
                        $newBegBal_rlc = 0; $newBegBal2 = '';
                        $newmonthBegBal_rlc = 0; $newmonthBegBal2 = '';
                        $newMonthBegBalCur_rlc = 0; $newMonthBegBalCur2 = '';
                        $getMonthlyAgent_rlc = 0; $getMonthlyAgent2 = '';
                        $getMonthlyGrossIn_rlc = 0; $getMonthlyGrossIn2 = '';
                        $getYearlyGrossIn_rlc = 0; $getYearlyGrossIn2 = '';
                        $branch_net_format_rlc = 0; $branch_net_format2 = '';
                        $branch_cum_net_format_rlc = 0; $branch_cum_net_format2 = '';
                        $branch_percent_target_format_rlc = 0; $branch_percent_target_format2 = '';
                        $getBranchAnnualtarget_rlc = 0; $getBranchAnnualtarget2 = '';
                       
                    } else {
                        $branch_name_rlc = $currentBranchName;
                        $newBegBal_rlc = $newBegBal; $newBegBal2 = $newBegBal;
                        $newmonthBegBal_rlc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                        $newMonthBegBalCur_rlc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                        $getMonthlyGrossIn_rlc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                        $getMonthlyAgent_rlc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                        $getYearlyGrossIn_rlc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                        $branch_net_format_rlc = $branch_net_format; $branch_net_format2 = $branch_net_format;
                        $branch_cum_net_format_rlc= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                        $branch_percent_target_format_rlc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                        $getBranchAnnualtarget_rlc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                        
                    }
    
                    $previousBranchName = $currentBranchName; // Update the previous branch name

                    if ($branch_net_format_rlc >=  0) {
                        $branch_net_format_rlc_view = $branch_net_format_rlc;
                        $branch_net_format_rlc_view_color = 'black';
                    } else {
                        $branch_net_format_rlc_view = '('.abs($branch_net_format_rlc).')';
                        $branch_net_format_rlc_view_color = 'red';
                    }
    
                    if ($branch_cum_net_format_rlc >=  0) {
                        $branch_cum_net_format_rlc_view = $branch_cum_net_format_rlc;
                        $branch_cum_net_format_rlc_view_color = 'black';
                    } else {
                        $branch_cum_net_format_rlc_view = '('.abs($branch_cum_net_format_rlc).')';
                        $branch_cum_net_format_rlc_view_color = 'red';
                    }
                        
                     $branch_name_rlc_to_rfc = preg_replace('/RLC/', 'RFC', $branch_name_rlc);
                        
                    $header .= <<<EOF
                    <table>
                    <tr>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_rlc_to_rfc</th>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_rlc </th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_rlc_view_color;">$branch_net_format_rlc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_rlc_view_color;">$branch_cum_net_format_rlc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                    </tr>
                    </table>
                    EOF;
    
                    $total_newBegBal_rlc += intval($newBegBal_rlc);
                    $total_newmonthBegBal_rlc += intval($newmonthBegBal_rlc);
                    $total_newMonthBegBalCur_rlc += intval($newMonthBegBalCur_rlc);
                    $total_getMonthlyGrossIn_rlc += intval($getMonthlyGrossIn_rlc);
                    $total_getYearlyGrossIn_rlc += intval($getYearlyGrossIn_rlc);
                    if (intval($branch_net_format_rlc) < 0) {
                        $total_branch_net_format_rlc = $total_branch_net_format_rlc - abs(intval($branch_net_format_rlc));
                    } else {
                        $total_branch_net_format_rlc = $total_branch_net_format_rlc + intval($branch_net_format_rlc);
                    }
                    
                    if (intval($branch_cum_net_format_rlc) < 0) {
                        $total_branch_cum_net_format_rlc = $total_branch_cum_net_format_rlc - abs(intval($branch_cum_net_format_rlc));
                    } else {
                        $total_branch_cum_net_format_rlc = $total_branch_cum_net_format_rlc + intval($branch_cum_net_format_rlc);
                    }
                    $total_getBranchAnnualtarget_rlc += intval($getBranchAnnualtarget_rlc);
                }
            } else {
              
                    $sale_rep_rlc = '';
    
                    //get monthly gross in
                    $startMonth = date('Y-m-01', strtotime($monthEnd));
                    $endMonth = date('Y-m-t', strtotime($monthEnd));
                    $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_rlc, $startMonth, $endMonth);

                    $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_rlc, $startMonth, $endMonth);
    
                      //get last year end balance
                      $newBegBal = 0;
                   
                      $firstDayOfMonth = '1990-01-01';
                      $lastDayOfMonth = $lastYearDate . '-12-31';
              
                      $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonth, $lastDayOfMonth);
                      
                      $newBegBal = $begBal2;
              
      
                      //get last month end balance
                      $newmonthBegBal = 0;
      
                      $firstDayOfMonthPrev = '1990-01-01';
                      $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                    
                      // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                      $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                      
                      $newmonthBegBal = $begnewBal;                 
                
          
                      //get this month end balance
                      $newMonthBegBalCur = 0;
      
                      $firstDayOfMonthCur = '1990-01-01';
                      $lastDayOfMonthCur = $monthEnd.'-31';
                  
                    
                      $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_rlc, $firstDayOfMonthCur, $lastDayOfMonthCur);
                      
                      $newMonthBegBalCur = $begnewBalcur;
                      
                      //get this year end cumulative gross in
      
                      $startYear = $thisYearDate . '-01-01';
                      $endYear = $thisYearDate . '-12-31';
                      $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_rlc, $startYear, $endYear);
        
                    //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                    $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                    $branch_net_format = $branch_net;
    
                    $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                    $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                    $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                    $branch_cum_net_format = $branch_cum_net;
                    $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_rlc, $thisYearDate);
    
                    if ($branch_cum_net >= 0) {
                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                            $branch_percent_target_format_color = 'black';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                    } else {

                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                            $branch_percent_target_format_color = 'red';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                        
                    }
                    
                    // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                    // $branch_percent_target_format = round($branch_percent_target, 2) * 100;
    
                    $currentBranchName = $item1['branch_name']; // Get the current branch name
                    
                    // Compare the current branch name with the previous one
                    if ($currentBranchName == $previousBranchName) {
                        $branch_name_rlc = '';  // Set the branch name to empty if they are equal
                        $newBegBal_rlc = 0; $newBegBal2 = '';
                        $newmonthBegBal_rlc = 0; $newmonthBegBal2 = '';
                        $newMonthBegBalCur_rlc = 0; $newMonthBegBalCur2 = '';
                        $getMonthlyAgent_rlc = 0; $getMonthlyAgent2 = '';
                        $getMonthlyGrossIn_rlc = 0; $getMonthlyGrossIn2 = '';
                        $getYearlyGrossIn_rlc = 0; $getYearlyGrossIn2 = '';
                        $branch_net_format_rlc = 0; $branch_net_format2 = '';
                        $branch_cum_net_format_rlc = 0; $branch_cum_net_format2 = '';
                        $branch_percent_target_format_rlc = 0; $branch_percent_target_format2 = '';
                        $getBranchAnnualtarget_rlc = 0; $getBranchAnnualtarget2 = '';
                       
                    } else {
                        $branch_name_rlc = $currentBranchName;
                        $newBegBal_rlc = $newBegBal; $newBegBal2 = $newBegBal;
                        $newmonthBegBal_rlc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                        $newMonthBegBalCur_rlc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                        $getMonthlyGrossIn_rlc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                        $getMonthlyAgent_rlc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                        $getYearlyGrossIn_rlc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                        $branch_net_format_rlc = $branch_net_format; $branch_net_format2 = $branch_net_format;
                        $branch_cum_net_format_rlc= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                        $branch_percent_target_format_rlc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                        $getBranchAnnualtarget_rlc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                        
                    }
    
                    $previousBranchName = $currentBranchName; // Update the previous branch name

                    if ($branch_net_format_rlc >=  0) {
                        $branch_net_format_rlc_view = $branch_net_format_rlc;
                        $branch_net_format_rlc_view_color = 'black';
                    } else {
                        $branch_net_format_rlc_view = '('.abs($branch_net_format_rlc).')';
                        $branch_net_format_rlc_view_color = 'red';
                    }
    
                    if ($branch_cum_net_format_rlc >=  0) {
                        $branch_cum_net_format_rlc_view = $branch_cum_net_format_rlc;
                        $branch_cum_net_format_rlc_view_color = 'black';
                    } else {
                        $branch_cum_net_format_rlc_view = '('.abs($branch_cum_net_format_rlc).')';
                        $branch_cum_net_format_rlc_view_color = 'red';
                    }
                        
                     $branch_name_rlc_to_rfc = preg_replace('/RLC/', 'RFC', $branch_name_rlc);
                        
                    $header .= <<<EOF
                    <table>
                    <tr>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_rlc_to_rfc</th>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_rlc </th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_rlc_view_color;">$branch_net_format_rlc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_rlc_view_color;">$branch_cum_net_format_rlc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                    </tr>
                    </table>
                    EOF;
    
                    $total_newBegBal_rlc += intval($newBegBal_rlc);
                    $total_newmonthBegBal_rlc += intval($newmonthBegBal_rlc);
                    $total_newMonthBegBalCur_rlc += intval($newMonthBegBalCur_rlc);
                    $total_getMonthlyGrossIn_rlc += intval($getMonthlyGrossIn_rlc);
                    $total_getMonthlyAgent_rlc += intval($getMonthlyAgent_rlc);
                    $total_getYearlyGrossIn_rlc += intval($getYearlyGrossIn_rlc);
                    if (intval($branch_net_format_rlc) < 0) {
                        $total_branch_net_format_rlc = $total_branch_net_format_rlc - abs(intval($branch_net_format_rlc));
                    } else {
                        $total_branch_net_format_rlc = $total_branch_net_format_rlc + intval($branch_net_format_rlc);
                    }
                    
                    if (intval($branch_cum_net_format_rlc) < 0) {
                        $total_branch_cum_net_format_rlc = $total_branch_cum_net_format_rlc - abs(intval($branch_cum_net_format_rlc));
                    } else {
                        $total_branch_cum_net_format_rlc = $total_branch_cum_net_format_rlc + intval($branch_cum_net_format_rlc);
                    }

                    $total_getBranchAnnualtarget_rlc += intval($getBranchAnnualtarget_rlc);
            
                }
            }

            if ($total_branch_cum_net_format_rlc >= 0) {
                if ($total_branch_cum_net_format_rlc >= 0 && $total_getBranchAnnualtarget_rlc > 0 || $total_getBranchAnnualtarget_rlc > 0) {
                
                    $quotient_branch_percent_target_format_rlc = $total_branch_cum_net_format_rlc / $total_getBranchAnnualtarget_rlc;
                    $total_branch_percent_target_format_rlc = round($quotient_branch_percent_target_format_rlc, 2) * 100 . '%';
                    $total_branch_percent_target_format_rlc_color = 'black';
    
                } else{
                    $total_branch_percent_target_format_rlc = 0;
                    $total_branch_percent_target_format_rlc_color = 'black';
    
                }
            } else {
    
                if ($total_branch_cum_net_format_rlc > 0 && $total_getBranchAnnualtarget_rlc > 0 || $total_getBranchAnnualtarget_rlc > 0) {
                
                    $quotient_branch_percent_target_format_rlc = $total_branch_cum_net_format_rlc / $total_getBranchAnnualtarget_rlc;
                    $total_branch_percent_target_format_rlc = '('.abs(round($quotient_branch_percent_target_format_rlc, 0)).')';
                    $total_branch_percent_target_format_rlc_color = 'red';
    
    
                } else{
                    $total_branch_percent_target_format_rlc = 0;
                    $total_branch_percent_target_format_rlc_color = 'black';
    
                }
                
            }

            if ($total_branch_net_format_rlc >=  0) {
                $total_branch_net_format_rlc_view = $total_branch_net_format_rlc;
                $total_branch_net_format_rlc_view_color = 'black';
            } else {
                $total_branch_net_format_rlc_view = '('.abs($total_branch_net_format_rlc).')';
                $total_branch_net_format_rlc_view_color = 'red';
            }

            if ($total_branch_cum_net_format_rlc >=  0) {
                $total_branch_cum_net_format_rlc_view = $total_branch_cum_net_format_rlc;
                $total_branch_cum_net_format_rlc_view_color = 'black';
            } else {
                $total_branch_cum_net_format_rlc_view = '('.abs($total_branch_cum_net_format_rlc).')';
                $total_branch_cum_net_format_rlc_view_color = 'red';
            }

            $tn_rlc = number_format($total_newBegBal_rlc, 2, '.', ',');
            $tnb_rlc = number_format($total_newmonthBegBal_rlc, 2, '.', ',');
            $tnm_rlc = number_format($total_newMonthBegBalCur_rlc, 2, '.', ',');
            $tg_rlc = number_format($total_getYearlyGrossIn_rlc, 2, '.', ',');


            $header .= <<<EOF
            <table>
            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL RFC</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyGrossIn_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyAgent_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $total_branch_net_format_rlc_view_color;"><strong>$total_branch_net_format_rlc_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $total_branch_cum_net_format_rlc_view_color;"><strong>$total_branch_cum_net_format_rlc_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $total_branch_percent_target_format_rlc_color;"><strong>$total_branch_percent_target_format_rlc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$total_getBranchAnnualtarget_rlc </strong></th>
            </tr>
            </table>
            
            EOF;

            $header .= <<<EOF
            <table>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <table>
            EOF;

            $header .= <<<EOF

            <table >
            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><span></span><br> FCH </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"><span></span><br> SALES REPRESENTATIVE </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thLastYearDate <span></span><br></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> BEG <br> $thPrevMonth </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> END <br> $thCurYearDate </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> GROSS IN</th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><span></span><br> Agents IN</th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"> GROSS IN Cumulative <br> $thLastYearDate-$thCurYearDate</th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px;"><span></span><br> BRANCH NET $thCurYearDate  </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px;"><span></span><br> BRANCH CUM NET $thLastYearDate-$thCurYearDate</th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px;"><span></span><br> % vs Target </th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><span></span><br> Annual Target </th>
            </tr>
            </table>
            EOF;

            foreach ($dataELC as &$item1) {
                $branch_name_elc = $item1['branch_name']; // Get the current branch name

                $getSR_ELC = (new ControllerPensioner)->ctrGetSalesRep($branch_name_elc);

                if (!empty($getSR_ELC)) {
                    foreach ($getSR_ELC as $key => $value) {
                        $sale_rep_elc = $value['rep_lname'].', '.$value['rep_fname'];

                        //get monthly gross in
                        $startMonth = date('Y-m-01', strtotime($monthEnd));
                        $endMonth = date('Y-m-t', strtotime($monthEnd));
                        $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_elc, $startMonth, $endMonth);

                        $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_elc, $startMonth, $endMonth);
        
                             //get last year end balance
                             $newBegBal = 0;
                   
                             $firstDayOfMonth = '1990-01-01';
                             $lastDayOfMonth = $lastYearDate . '-12-31';
                     
                             $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonth, $lastDayOfMonth);
                             
                             $newBegBal = $begBal2;
                     
             
                             //get last month end balance
                             $newmonthBegBal = 0;
             
                             $firstDayOfMonthPrev = '1990-01-01';
                             $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                           
                             // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);
     
                             $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                             
                             $newmonthBegBal = $begnewBal;                 
                       
                 
                             //get this month end balance
                             $newMonthBegBalCur = 0;
             
                             $firstDayOfMonthCur = '1990-01-01';
                             $lastDayOfMonthCur = $monthEnd.'-31';
                         
                           
                             $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonthCur, $lastDayOfMonthCur);
                             
                             $newMonthBegBalCur = $begnewBalcur;
                             
                             //get this year end cumulative gross in
             
                             $startYear = $thisYearDate . '-01-01';
                             $endYear = $thisYearDate . '-12-31';
                             $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_elc, $startYear, $endYear);
            
                        //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                     
                        $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                        $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                        $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                        $branch_cum_net_format = $branch_cum_net;

                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_elc, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                                $branch_percent_target_format_color = 'black';

                            } else{
                                $branch_percent_target_format = 0;
                                $branch_percent_target_format_color = 'black';
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                                $branch_percent_target_format_color = 'red';

                            } else{
                                $branch_percent_target_format = 0;
                                $branch_percent_target_format_color = 'black';
                            }
                            
                        }
                        
                        // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                        // $branch_percent_target_format = round($branch_percent_target, 2) * 100;
        
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_elc = '';  // Set the branch name to empty if they are equal
                            $newBegBal_elc = 0; $newBegBal2 = '';
                            $newmonthBegBal_elc = 0; $newmonthBegBal2 = '';
                            $newMonthBegBalCur_elc = 0; $newMonthBegBalCur2 = '';
                            $getMonthlyGrossIn_elc = 0; $getMonthlyGrossIn2 = '';
                            $getMonthlyAgent_elc = 0; $getMonthlyAgent2 = '';
                            $getYearlyGrossIn_elc = 0; $getYearlyGrossIn2 = '';
                            $branch_net_format_elc = 0; $branch_net_format2 = '';
                            $branch_cum_net_format_elc = 0; $branch_cum_net_format2 = '';
                            $branch_percent_target_format_elc = 0; $branch_percent_target_format2 = '';
                            $getBranchAnnualtarget_elc = 0; $getBranchAnnualtarget2 = '';
                           
                        } else {
                            $branch_name_elc = $currentBranchName;
                            $newBegBal_elc = $newBegBal; $newBegBal2 = $newBegBal;
                            $newmonthBegBal_elc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_elc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_elc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_elc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_elc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_elc = $branch_net_format; $branch_net_format2 = $branch_net_format;
                            $branch_cum_net_format_elc= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                            $branch_percent_target_format_elc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_elc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
        
                        $previousBranchName = $currentBranchName; // Update the previous branch name

                        if ($branch_net_format_elc >=  0) {
                            $branch_net_format_elc_view = $branch_net_format_elc;
                            $branch_net_format_elc_view_color = 'black';
                        } else {
                            $branch_net_format_elc_view = '('.abs($branch_net_format_elc).')';
                            $branch_net_format_elc_view_color = 'red';
                        }
        
                        if ($branch_cum_net_format_elc >=  0) {
                            $branch_cum_net_format_elc_view = $branch_cum_net_format_elc;
                            $branch_cum_net_format_elc_view_color = 'black';
                        } else {
                            $branch_cum_net_format_elc_view = '('.abs($branch_cum_net_format_elc).')';
                            $branch_cum_net_format_elc_view_color = 'red';
                        }

                        $header .= <<<EOF
                        <table>
                        <tr>
                            <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_elc</th>
                            <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_elc </th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_elc_view_color;">$branch_net_format_elc_view</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_elc_view_color;">$branch_cum_net_format_elc_view</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                            <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                        </tr>
                        </table>
                        EOF;


                        $total_newBegBal_elc += intval($newBegBal_elc);
                        $total_newmonthBegBal_elc += intval($newmonthBegBal_elc);
                        $total_newMonthBegBalCur_elc += intval($newMonthBegBalCur_elc);
                        $total_getMonthlyGrossIn_elc += intval($getMonthlyGrossIn_elc);
                        $total_getMonthlyAgent_rlc += intval($getMonthlyAgent_elc);
                        $total_getYearlyGrossIn_elc += intval($getYearlyGrossIn_elc);
                          if (intval($branch_net_format_elc) < 0) {
                            $total_branch_net_format_elc = $total_branch_net_format_elc - abs(intval($branch_net_format_elc));
                        } else {
                            $total_branch_net_format_elc = $total_branch_net_format_elc + intval($branch_net_format_elc);
                        }
                        
                        if (intval($branch_cum_net_format_elc) < 0) {
                            $total_branch_cum_net_format_elc = $total_branch_cum_net_format_elc - abs(intval($branch_cum_net_format_elc));
                        } else {
                            $total_branch_cum_net_format_elc = $total_branch_cum_net_format_elc + intval($branch_cum_net_format_elc);
                        }
                        $total_getBranchAnnualtarget_elc += intval($getBranchAnnualtarget_elc);
                    }
                } else {

                    $sale_rep_elc = '';

                    //get monthly gross in
                    $startMonth = date('Y-m-01', strtotime($monthEnd));
                    $endMonth = date('Y-m-t', strtotime($monthEnd));
                    $getMonthlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_elc, $startMonth, $endMonth);

                    $getMonthlyAgent = (new ControllerPensioner)->ctrGetMonthlyAgent($branch_name_elc, $startMonth, $endMonth);
    
                        //get last year end balance
                        $newBegBal = 0;
                   
                        $firstDayOfMonth = '1990-01-01';
                        $lastDayOfMonth = $lastYearDate . '-12-31';
                
                        $begBal2 = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonth, $lastDayOfMonth);
                        
                        $newBegBal = $begBal2;
                
        
                        //get last month end balance
                        $newmonthBegBal = 0;
        
                        $firstDayOfMonthPrev = '1990-01-01';
                        $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));
                      
                        // $begnewBal = (new ControllerPensioner)->ctrGetNewBegBal($branch_name, $currentDate);

                        $begnewBal = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonthPrev, $lastDayOfMonthPrev);
                        
                        $newmonthBegBal = $begnewBal;                 
                  
            
                        //get this month end balance
                        $newMonthBegBalCur = 0;
        
                        $firstDayOfMonthCur = '1990-01-01';
                        $lastDayOfMonthCur = $monthEnd.'-31';
                    
                      
                        $begnewBalcur = (new ControllerPensioner)->ctrGetBegBal($branch_name_elc, $firstDayOfMonthCur, $lastDayOfMonthCur);
                        
                        $newMonthBegBalCur = $begnewBalcur;
                        
                        //get this year end cumulative gross in
        
                        $startYear = $thisYearDate . '-01-01';
                        $endYear = $thisYearDate . '-12-31';
                        $getYearlyGrossIn = (new ControllerPensioner)->ctrGetMonthlyGrossIn($branch_name_elc, $startYear, $endYear);
        
                    //  $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net = $newMonthBegBalCur - $newmonthBegBal;
                    $branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";
                    $branch_net_format_display_color = ($branch_net >= 0)? "black" : "red";
                    $branch_net_format = $branch_net;
    
                    $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                    $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                    $branch_cum_net_format_display_color = ($branch_cum_net >= 0)? "black" : "red";
                    $branch_cum_net_format = $branch_cum_net;

                    $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_elc, $thisYearDate);
    
                    if ($branch_cum_net >= 0) {
                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';
                            $branch_percent_target_format_color = 'black';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                    } else {

                        if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                        
                            $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                            $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';
                            $branch_percent_target_format_color = 'red';

                        } else{
                            $branch_percent_target_format = 0;
                            $branch_percent_target_format_color = 'black';
                        }
                        
                    }
                    
                    // $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                    // $branch_percent_target_format = round($branch_percent_target, 2) * 100;
    
                    $currentBranchName = $item1['branch_name']; // Get the current branch name
                    
                    // Compare the current branch name with the previous one
                    if ($currentBranchName == $previousBranchName) {
                        $branch_name_elc = '';  // Set the branch name to empty if they are equal
                        $newBegBal_elc = 0; $newBegBal2 = '';
                        $newmonthBegBal_elc = 0; $newmonthBegBal2 = '';
                        $newMonthBegBalCur_elc = 0; $newMonthBegBalCur2 = '';
                        $getMonthlyGrossIn_elc = 0; $getMonthlyGrossIn2 = '';
                        $getMonthlyAgent_elc = 0; $getMonthlyAgent2 = '';
                        $getYearlyGrossIn_elc = 0; $getYearlyGrossIn2 = '';
                        $branch_net_format_elc = 0; $branch_net_format2 = '';
                        $branch_cum_net_format_elc = 0; $branch_cum_net_format2 = '';
                        $branch_percent_target_format_elc = 0; $branch_percent_target_format2 = '';
                        $getBranchAnnualtarget_elc = 0; $getBranchAnnualtarget2 = '';
                       
                    } else {
                        $branch_name_elc = $currentBranchName;
                        $newBegBal_elc = $newBegBal; $newBegBal2 = $newBegBal;
                        $newmonthBegBal_elc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                        $newMonthBegBalCur_elc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                        $getMonthlyGrossIn_elc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                        $getMonthlyAgent_elc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                        $getYearlyGrossIn_elc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                        $branch_net_format_elc = $branch_net_format; $branch_net_format2 = $branch_net_format;
                        $branch_cum_net_format_elc= $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format;
                        $branch_percent_target_format_elc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                        $getBranchAnnualtarget_elc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                        
                    }
    
                    $previousBranchName = $currentBranchName; // Update the previous branch name

                    if ($branch_net_format_elc >=  0) {
                        $branch_net_format_elc_view = $branch_net_format_elc;
                        $branch_net_format_elc_view_color = 'black';
                    } else {
                        $branch_net_format_elc_view = '('.abs($branch_net_format_elc).')';
                        $branch_net_format_elc_view_color = 'red';
                    }
    
                    if ($branch_cum_net_format_elc >=  0) {
                        $branch_cum_net_format_elc_view = $branch_cum_net_format_elc;
                        $branch_cum_net_format_elc_view_color = 'black';
                    } else {
                        $branch_cum_net_format_elc_view = '('.abs($branch_cum_net_format_elc).')';
                        $branch_cum_net_format_elc_view_color = 'red';
                    }

                    $header .= <<<EOF
                    <table>
                    <tr>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:90px;">&nbsp;$branch_name_elc</th>
                        <th style="text-align: left; border: 1px solid black; font-size:8px; width:105px;">&nbsp;$sale_rep_elc </th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newmonthBegBal2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$newMonthBegBalCur2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;">$getMonthlyAgent2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;">$getYearlyGrossIn2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_format_elc_view_color;">$branch_net_format_elc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_format_elc_view_color;">$$branch_cum_net_format_elc_view</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $branch_percent_target_format_color;">$branch_percent_target_format2</th>
                        <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;">$getBranchAnnualtarget2 </th>
                    </tr>
                    </table>
                    EOF;
    
                    $total_newBegBal_elc += intval($newBegBal_elc);
                    $total_newmonthBegBal_elc += intval($newmonthBegBal_elc);
                    $total_newMonthBegBalCur_elc += intval($newMonthBegBalCur_elc);
                    $total_getMonthlyGrossIn_elc += intval($getMonthlyGrossIn_elc);
                    $total_getMonthlyAgent_elc += intval($getMonthlyAgent_elc);
                    $total_getYearlyGrossIn_elc += intval($getYearlyGrossIn_elc);
                    if (intval($branch_net_format_elc) < 0) {
                        $total_branch_net_format_elc = $total_branch_net_format_elc - abs(intval($branch_net_format_elc));
                    } else {
                        $total_branch_net_format_elc = $total_branch_net_format_elc + intval($branch_net_format_elc);
                    }
                    
                    if (intval($branch_cum_net_format_elc) < 0) {
                        $total_branch_cum_net_format_elc = $total_branch_cum_net_format_elc - abs(intval($branch_cum_net_format_elc));
                    } else {
                        $total_branch_cum_net_format_elc = $total_branch_cum_net_format_elc + intval($branch_cum_net_format_elc);
                    }
                    $total_getBranchAnnualtarget_elc += intval($getBranchAnnualtarget_elc);
                }
            }

            if ($total_branch_net_format_elc >=  0) {
                $total_branch_net_format_elc_view = $total_branch_net_format_elc;
                $total_branch_net_format_elc_view_color = 'black';
            } else {
                $total_branch_net_format_elc_view = '('.abs($total_branch_net_format_elc).')';
                $total_branch_net_format_elc_view_color = 'red';
            }

            if ($total_branch_cum_net_format_elc >=  0) {
                $total_branch_cum_net_format_elc_view = $total_branch_cum_net_format_elc;
                $total_branch_cum_net_format_elc_view_color = 'black';
            } else {
                $total_branch_cum_net_format_elc_view = '('.abs($total_branch_cum_net_format_elc).')';
                $total_branch_cum_net_format_elc_view_color = 'red';
            }

            if ($total_branch_cum_net_format_elc >= 0) {
                if ($total_branch_cum_net_format_elc > 0 && $total_getBranchAnnualtarget_elc > 0 || $total_getBranchAnnualtarget_elc > 0) {
                
                    $quotient_branch_percent_target_format_elc = $total_branch_cum_net_format_elc / $total_getBranchAnnualtarget_elc;
                    $total_branch_percent_target_format_elc = round($quotient_branch_percent_target_format_elc, 2) * 100 . '%';
                    $total_branch_percent_target_format_elc_color = 'black';

                } else{
                    $total_branch_percent_target_format_elc = 0;
                    $total_branch_percent_target_format_elc_color = 'black';
                }
            } else {

                if ($total_branch_cum_net_format_elc > 0 && $total_getBranchAnnualtarget_elc > 0 || $total_getBranchAnnualtarget_elc > 0) {
                
                    $quotient_branch_percent_target_format_elc = $total_branch_cum_net_format_elc / $total_getBranchAnnualtarget_elc;
                    $total_branch_percent_target_format_elc = '('.abs(round($quotient_branch_percent_target_format_elc, 0)).')';
                    $total_branch_percent_target_format_elc_color = 'red';

                } else{
                    $total_branch_percent_target_format_elc = 0;
                    $total_branch_percent_target_format_elc_color = 'black';
                }
                
            }

            $tn_elc = number_format($total_newBegBal_elc, 2, '.', ',');
            $tnb_elc = number_format($total_newmonthBegBal_elc, 2, '.', ',');
            $tnm_elc = number_format($total_newMonthBegBalCur_elc, 2, '.', ',');
            $tg_elc = number_format($total_getYearlyGrossIn_elc, 2, '.', ',');

            $header .= <<<EOF
            <table>
            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>TOTAL ELC</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyGrossIn_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$total_getMonthlyAgent_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $total_branch_net_format_elc_view_color;"><strong>$total_branch_net_format_elc_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $total_branch_cum_net_format_elc_view_color;"><strong>$total_branch_cum_net_format_elc_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $total_branch_percent_target_format_elc_color;"><strong>$total_branch_percent_target_format_elc</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$total_getBranchAnnualtarget_elc </strong></th>
            </tr>
            </table>
            
            EOF;

            $header .= <<<EOF
            <table>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </table>
            EOF;

            $final_grand_total_newBegBal = $total_newBegBal + $total_newBegBal_fchn + $total_newBegBal_fchm + $total_newBegBal_rlc + $total_newBegBal_elc;
            $final_grand_total_newmonthBegBal = $total_newmonthBegBal + $total_newBegBal_fchn +$total_newBegBal_fchm +  $total_newBegBal_rlc +  $total_newBegBal_elc;
            $final_grand_total_newMonthBegBalCur = $total_newMonthBegBalCur + $total_newMonthBegBalCur_fchn + $total_newMonthBegBalCur_fchm + $total_newMonthBegBalCur_rlc + $total_newMonthBegBalCur_elc;
            $final_grand_toral_getMonthlyGrossIn = $total_getMonthlyGrossIn + $total_getMonthlyGrossIn_fchn + $total_getMonthlyGrossIn_fchm +  $total_getMonthlyGrossIn_rlc +  $total_getMonthlyGrossIn_elc;
            $final_grand_toral_getMonthlyAgent = $total_getMonthlyAgent + $total_getMonthlyAgent_fchn + $total_getMonthlyAgent_fchm +  $total_getMonthlyAgent_rlc +  $total_getMonthlyAgent_elc;
            $final_grand_toral_getYearlyGrossIn = $total_getYearlyGrossIn + $total_getYearlyGrossIn_fchn + $total_getYearlyGrossIn_fchm + $total_getYearlyGrossIn_rlc + $total_getYearlyGrossIn_elc;
            $final_grand_total_branch_net_format =  $total_branch_net_format + $total_branch_net_format_fchn + $total_branch_net_format_fchm + $total_branch_net_format_rlc + $total_branch_net_format_elc;
            $final_grand_total_branch_cum_net_format = $total_branch_cum_net_format + $total_branch_cum_net_format_fchn + $total_branch_cum_net_format_fchm + $total_branch_cum_net_format_rlc + $total_branch_cum_net_format_elc;
            // $final_grand_total_branch_percent_target_format = $total_branch_percent_target_format + $total_branch_percent_target_format_fchn + $total_branch_percent_target_format_fchm + $total_branch_percent_target_format_rlc + $total_branch_percent_target_format_elc;
            $final_grand_total_getBranchAnnualtarget = $total_getBranchAnnualtarget + $total_getBranchAnnualtarget_fchn + $total_getBranchAnnualtarget_fchm + $total_getBranchAnnualtarget_rlc + $total_getBranchAnnualtarget_elc;

            if ($final_grand_total_branch_cum_net_format >= 0) {
                if ($final_grand_total_branch_cum_net_format > 0 && $final_grand_total_getBranchAnnualtarget > 0 || $final_grand_total_getBranchAnnualtarget > 0) {
                
                    $final_grand_quotient_branch_percent_target_format = $final_grand_total_branch_cum_net_format / $final_grand_total_getBranchAnnualtarget;
                    $final_grand_total_branch_percent_target_format_view = round($final_grand_quotient_branch_percent_target_format, 2) * 100 . '%';
                    $final_grand_total_branch_percent_target_format_view_color = 'black';

                } else{
                    $final_grand_total_branch_percent_target_format_view = 0;
                    $final_grand_total_branch_percent_target_format_view_color = 'black';
                }
            } else {

                if ($final_grand_total_branch_cum_net_format > 0 && $final_grand_total_getBranchAnnualtarget > 0 || $final_grand_total_getBranchAnnualtarget > 0) {
                
                    $final_grand_quotient_branch_percent_target_format = $final_grand_total_branch_cum_net_format / $final_grand_total_getBranchAnnualtarget;
                    $final_grand_total_branch_percent_target_format_view = '('.abs(round($final_grand_quotient_branch_percent_target_format, 0)).')';
                    $final_grand_total_branch_percent_target_format_view_color = 'red';

                } else{
                    $final_grand_total_branch_percent_target_format_view = 0;
                    $final_grand_total_branch_percent_target_format_view_color = 'black';
                }
                
            }

            if ($final_grand_total_branch_net_format >=  0) {
                $branch_net_formatfinal_view = $final_grand_total_branch_net_format;
                $branch_net_formatfinal_view_color = 'black';
            } else {
                $branch_net_formatfinal_view = '('.abs($final_grand_total_branch_net_format).')';
                $branch_net_formatfinal_view_color = 'red';
            }

            if ($final_grand_total_branch_cum_net_format >=  0) {
                $branch_cum_net_formatfinal_view = $final_grand_total_branch_cum_net_format;
                $branch_cum_net_formatfinal_view_color = 'black';
            } else {
                $branch_cum_net_formatfinal_view = '('.abs($final_grand_total_branch_cum_net_format).')';
                $branch_cum_net_formatfinal_view_color = 'red';
            }

            $tn_grand_final = number_format($final_grand_total_newBegBal, 2, '.', ',');
            $tnb_grand_final = number_format($final_grand_total_newmonthBegBal, 2, '.', ',');
            $tnm_grand_final = number_format($final_grand_total_newMonthBegBalCur, 2, '.', ',');
            $tg_grand_final = number_format($final_grand_toral_getYearlyGrossIn, 2, '.', ',');    
            
            $header .= <<<EOF
            <table>
            <tr>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:90px;"><strong>GRAND TOTAL</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:105px;"></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tn_grand_final</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnb_grand_final</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$tnm_grand_final</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$final_grand_toral_getMonthlyGrossIn</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:45px;"><strong>$final_grand_toral_getMonthlyAgent</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:70px;"><strong>$tg_grand_final</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:60px; color: $branch_net_formatfinal_view_color;"><strong>$branch_net_formatfinal_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:85px; color: $branch_cum_net_formatfinal_view_color;"><strong>$branch_cum_net_formatfinal_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:50px; color: $final_grand_total_branch_percent_target_format_view_color;"><strong>$final_grand_total_branch_percent_target_format_view</strong></th>
                <th style="text-align: center; border: 1px solid black; font-size:8px; width:40px;"><strong>$final_grand_total_getBranchAnnualtarget </strong></th>
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

            // $header .= <<<EOF
            // <table>
            //     <tr>  

            //         <td style="width:250px;text-align:left;font-size:8px; color: black;">Position</td>
                
            //         <td style="width:250px;text-align:left;font-size:8px; color: black;">Position</td>
                
            //         <td style="width:250px;text-align:left;font-size:8px; color: black;">Position</td>
            
            //     </tr>             
            // </table>
            // EOF;


            




    
    


    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports', 'I');
    
   }
  }  

?>