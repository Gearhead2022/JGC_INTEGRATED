<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";

$filterSummary= new reportTable();
$filterSummary -> showSalesPerformanceFilter();

class reportTable{
	public function showSalesPerformanceFilter(){
 
        $monthEnd = $_GET['monthEnd']; /*get date input*/
        // $branch_name_input = $_GET['branch_name_input']; /*get branch name input*/
        $lastYearDate = date('Y', strtotime('-1 year', strtotime($monthEnd))); //get last year
        $lastDateOfThePrevYear = $lastYearDate . "-12-31"; //last date of the previous year
        $lastMonthOfThePrevYear = $lastYearDate . "-12"; //last month of the previous year
        $thisYearDate = date('Y', strtotime($monthEnd)); //get current year
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
        // $dataRLC = (new ControllerPensioner)->ctrOperationRLC();

        $data1 = [
            [
                'id' => 58,
                0 => 58,
                'user_id' => 'UI00058',
                1 => 'UI00058'
            ]
        ];


        foreach ($data1 as &$item) {
            $item['card'] ='
            <thead>
            <tr>
                <th><span style="visibility:hidden;">s</span><br> EMB <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> SALES REPRESENTATIVE <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thLastYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thPrevMonth.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> END '.$thCurYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> GROSS IN<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Agents IN<br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;" >GROSS IN<br> Cumulative<br> '.$thLastYearDate.'-'.$thCurYearDate.'</th>
                <th style="text-align: center;"> BRANCH NET<br> '.$thCurYearDate.'  <br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;"> BRANCH CUM <br>NET '.$thLastYearDate.'-'.$thCurYearDate.' <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> % vs Target <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Annual Target <br><span style="visibility:hidden;">S</span></th>
            </tr>
            <tbody>
            ';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
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
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_emb_view.'</th>
                        <th>'.$sale_rep_emb_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name, $thisYearDate);

                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
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

                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_emb_view.'</th>
                        <th>'.$sale_rep_emb_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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

            }

            if ($total_branch_net_format >=  0) {
                $total_branch_net_format_emb = $total_branch_net_format;
            } else {
                $total_branch_net_format_emb = '('.abs($total_branch_net_format).')';
            }

            if ($total_branch_cum_net_format >=  0) {
                $total_branch_cum_net_format_emb = $total_branch_cum_net_format;
            } else {
                $total_branch_cum_net_format_emb = '('.abs($total_branch_cum_net_format).')';
            }

            //prevent error division by zero

            if ($total_branch_cum_net_format >= 0) {
                if ($total_branch_cum_net_format >= 0 && $total_getBranchAnnualtarget > 0 || $total_getBranchAnnualtarget > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format / $total_getBranchAnnualtarget;
                    $total_branch_percent_target_format = round($quotient_branch_percent_target_format, 2) * 100 . '%';

                } else{
                    $total_branch_percent_target_format = 0;
                }
            } else {

                if ($total_branch_cum_net_format > 0 && $total_getBranchAnnualtarget > 0 || $total_getBranchAnnualtarget > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format / $total_getBranchAnnualtarget;
                    $total_branch_percent_target_format = '('.abs(round($quotient_branch_percent_target_format, 0)).')';

                } else{
                    $total_branch_percent_target_format = 0;
                }
                
            }

            $item['card'] .='
            <tr>
            <th style="color: #b0aeac;">TOTAL EMB</th>
            <th></th>
            <th>'.number_format($total_newBegBal, 2, '.', ',').'</th>
            <th>'.number_format($total_newmonthBegBal, 2, '.', ',').'</th>
            <th>'.number_format($total_newMonthBegBalCur, 2, '.', ',').'</th>
            <th>'.$total_getMonthlyGrossIn.'</th>
            <th>'.$total_getMonthlyAgent.'</th>
            <th>'.number_format($total_getYearlyGrossIn, 2, '.', ',').'</th>
            <th>'.$total_branch_net_format_emb.'</th>
            <th>'.$total_branch_cum_net_format_emb.'</th>
            <th>'.$total_branch_percent_target_format.'</th>
            <th>'.$total_getBranchAnnualtarget.'</th>
            </tr>';

            $item['card'] .='
            <thead>
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
            <tbody>
            ';

            $item['card'] .='
            <thead>
            <tr>
                <th><span style="visibility:hidden;">s</span><br> FCH <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> SALES REPRESENTATIVE <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thLastYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thPrevMonth.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> END '.$thCurYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> GROSS IN<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Agents IN<br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;" >GROSS IN<br> Cumulative<br> '.$thLastYearDate.'-'.$thCurYearDate.'</th>
                <th style="text-align: center;"> BRANCH NET<br> '.$thCurYearDate.'  <br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;"> BRANCH CUM <br>NET '.$thLastYearDate.'-'.$thCurYearDate.' <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> % vs Target <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Annual Target <br><span style="visibility:hidden;">S</span></th>
            </tr>
            <tbody>
            ';

            $item['card'] .='
            <thead>
            <tr>
                <th>FCH NEGROS</th>
                <th colspan="10"></th>
              
            </tr>
            <tbody>
            ';

            foreach ($dataFCHN as &$item1) {

                $branch_name_fchn = $item1['branch_name']; // Get the current branch name

                $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name_fchn);

                if (!empty($getSR)) {
                                
                    foreach ($getSR as $key => $value) {

                        $sale_rep_fchn_view = $value['rep_lname'].', '.$value['rep_fname'];

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchn, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
                        
                       
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_fchn_view = '';  // Set the branch name to empty if they are equal
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

                            $branch_name_fchn_view = $currentBranchName;
                            $newBegBal_fchn = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_fchn = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_fchn = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_fchn = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_fchn = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_fchn = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_fchn = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_fchn = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_fchn = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_fchn = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_fchn_view.'</th>
                        <th>'.$sale_rep_fchn_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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

                }else{

                        $sale_rep_fchn_view ='';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchn, $thisYearDate);

                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
        
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_fchn_view = '';  // Set the branch name to empty if they are equal
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

                            $branch_name_fchn_view = $currentBranchName;
                            $newBegBal_fchn = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_fchn = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_fchn = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_fchn = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_fchn = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_fchn = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_fchn = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_fchn = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_fchn = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_fchn = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_fchn_view.'</th>
                        <th>'.$sale_rep_fchn_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';


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
            } else {
                $total_branch_net_format_fchn_view = '('.abs($total_branch_net_format_fchn).')';
            }

            if ($total_branch_cum_net_format_fchn >=  0) {
                $total_branch_cum_net_format_fchn_view = $total_branch_cum_net_format_fchn;
            } else {
                $total_branch_cum_net_format_fchn_view = '('.abs($total_branch_cum_net_format_fchn).')';
            }

            //prevent error division by zero

            if ($total_branch_cum_net_format_fchn >= 0) {
                if ($total_branch_cum_net_format_fchn >= 0 && $total_getBranchAnnualtarget_fchn > 0 || $total_getBranchAnnualtarget_fchn > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format_fchn / $total_getBranchAnnualtarget_fchn;
                    $total_branch_percent_target_format_fchn_view = round($quotient_branch_percent_target_format, 2) * 100 . '%';

                } else{
                    $total_branch_percent_target_format_fchn_view = 0;
                }
            } else {

                if ($total_branch_cum_net_format_fchn > 0 && $total_getBranchAnnualtarget_fchn > 0 || $total_getBranchAnnualtarget_fchn > 0) {
                
                    $quotient_branch_percent_target_format = intval($total_branch_cum_net_format_fchn) / intval($total_getBranchAnnualtarget_fchn);
                    $total_branch_percent_target_format_fchn_view = '('.abs(round($quotient_branch_percent_target_format, 0)).')';

                } else{
                    $total_branch_percent_target_format_fchn_view = 0;
                }
                
            }


            $item['card'] .='
            <tr>
            <th>TOTAL</th>
            <th></th>
            <th>'.number_format($total_newBegBal_fchn, 2, '.', ',').'</th>
            <th>'.number_format($total_newmonthBegBal_fchn, 2, '.', ',').'</th>
            <th>'.number_format($total_newMonthBegBalCur_fchn, 2, '.', ',').'</th>
            <th>'.$total_getMonthlyGrossIn_fchn.'</th>
            <th>'.$total_getMonthlyAgent_fchn.'</th>
            <th>'.number_format($total_getYearlyGrossIn_fchn, 2, '.', ',').'</th>
            <th>'.$total_branch_net_format_fchn_view.'</th>
            <th>'.$total_branch_cum_net_format_fchn_view.'</th>
            <th>'.$total_branch_percent_target_format_fchn_view.'</th>
            <th>'.$total_getBranchAnnualtarget_fchn.'</th>
            </tr>';

            $item['card'] .='
            <thead>
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
            <tbody>
            ';
            
            $item['card'] .='
            <thead>
            <tr>
                <th>FCH MANILA</th>
                <th colspan="10"></th>
              
            </tr>
            <tbody>
            ';

            foreach ($dataFCHM as &$item1) {

                $branch_name_fchm = $item1['branch_name']; // Get the current branch name

                $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name_fchm);

                if (!empty($getSR)) {
                                
                    foreach ($getSR as $key => $value) {

                        $sale_rep_fchm_view = $value['rep_lname'].', '.$value['rep_fname'];

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchm, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
                        
                       
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_fchm_view = '';  // Set the branch name to empty if they are equal
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

                            $branch_name_fchm_view = $currentBranchName;
                            $newBegBal_fchm = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_fchm = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_fchm = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_fchm = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_fchm = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_fchm = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_fchm = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_fchm = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_fchm = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_fchm = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_fchm_view.'</th>
                        <th>'.$sale_rep_fchm_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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

                }else{

                        $sale_rep_fchm_view ='';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_fchm, $thisYearDate);

                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
        
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_fchm_view = '';  // Set the branch name to empty if they are equal
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

                            $branch_name_fchm_view = $currentBranchName;
                            $newBegBal_fchm = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_fchm = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_fchm = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_fchm = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_fchm = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_fchm = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_fchm = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_fchm = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_fchm = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_fchm = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_fchm_view.'</th>
                        <th>'.$sale_rep_fchm_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';


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
            } else {
                $total_branch_net_format_fchm_view = '('.abs($total_branch_net_format_fchm).')';
            }

            if ($total_branch_cum_net_format_fchm >=  0) {
                $total_branch_cum_net_format_fchm_view = $total_branch_cum_net_format_fchm;
            } else {
                $total_branch_cum_net_format_fchm_view = '('.abs($total_branch_cum_net_format_fchm).')';
            }

            //prevent error division by zero

            if ($total_branch_cum_net_format_fchm >= 0) {
                if ($total_branch_cum_net_format_fchm >= 0 && $total_getBranchAnnualtarget_fchm > 0 || $total_getBranchAnnualtarget_fchm > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format_fchm / $total_getBranchAnnualtarget_fchm;
                    $total_branch_percent_target_format_fchm_view = round($quotient_branch_percent_target_format, 2) * 100 . '%';

                } else{
                    $total_branch_percent_target_format_fchm_view = 0;
                }
            } else {

                if ($total_branch_cum_net_format_fchm > 0 && $total_getBranchAnnualtarget_fchm > 0 || $total_getBranchAnnualtarget_fchm > 0) {
                
                    $quotient_branch_percent_target_format = intval($total_branch_cum_net_format_fchm) / intval($total_getBranchAnnualtarget_fchm);
                    $total_branch_percent_target_format_fchm_view = '('.abs(round($quotient_branch_percent_target_format, 0)).')';

                } else{
                    $total_branch_percent_target_format_fchm_view = 0;
                }
                
            }

            $item['card'] .='
            <tr>
            <th>TOTAL</th>
            <th></th>
            <th>'.number_format($total_newBegBal_fchm, 2, '.', ',').'</th>
            <th>'.number_format($total_newmonthBegBal_fchm, 2, '.', ',').'</th>
            <th>'.number_format($total_newMonthBegBalCur_fchm, 2, '.', ',').'</th>
            <th>'.$total_getMonthlyGrossIn_fchm.'</th>
            <th>'.$total_getMonthlyAgent_fchm.'</th>
            <th>'.number_format($total_getYearlyGrossIn_fchm, 2, '.', ',').'</th>
            <th>'.$total_branch_net_format_fchm_view.'</th>
            <th>'.$total_branch_cum_net_format_fchm_view.'</th>
            <th>'.$total_branch_percent_target_format_fchm_view.'</th>
            <th>'.$total_getBranchAnnualtarget_fchm.'</th>
            </tr>';

            $item['card'] .='
            <thead>
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
            <tbody>
            ';

            $grand_total_newBegBal = $total_newBegBal_fchm + $total_newBegBal_fchn;
            $grand_total_newmonthBegBal  = $total_newmonthBegBal_fchm + $total_newmonthBegBal_fchn;
            $grand_total_newMonthBegBalCur  = $total_newMonthBegBalCur_fchm + $total_newMonthBegBalCur_fchn;
            $grand_total_getMonthlyGrossIn = $total_getMonthlyGrossIn_fchm + $total_getMonthlyGrossIn_fchn;
            $grand_total_getMonthlyAgent = $total_getMonthlyAgent_fchm + $total_getMonthlyAgent_fchn;
            $grand_total_getYearlyGrossIn  = $total_getYearlyGrossIn_fchm +$total_getYearlyGrossIn_fchn;
            $grand_total_branch_net_format = intval($total_branch_net_format_fchm) + intval($total_branch_net_format_fchn);
            $grand_total_branch_cum_net_format  = intval($total_branch_cum_net_format_fchm) + intval($total_branch_cum_net_format_fchn);
           
            $grand_total_getBranchAnnualtarget  = intval($total_getBranchAnnualtarget_fchm) + intval($total_getBranchAnnualtarget_fchn);
    
            if ($grand_total_branch_cum_net_format >= 0) {
                if ($grand_total_branch_cum_net_format > 0 && $grand_total_getBranchAnnualtarget > 0 || $grand_total_getBranchAnnualtarget > 0) {
                
                    $grand_total_quotient_branch_percent_target_format = $grand_total_branch_cum_net_format / $grand_total_getBranchAnnualtarget;
                    $grand_total_branch_percent_target_format = round($grand_total_quotient_branch_percent_target_format, 2) * 100 . '%';
    
                } else{
                    $grand_total_branch_percent_target_format = 0;
                }
            } else {
    
                if ($grand_total_branch_cum_net_format > 0 && $grand_total_getBranchAnnualtarget > 0 || $grand_total_getBranchAnnualtarget > 0) {
                
                    $grand_total_quotient_branch_percent_target_format = $grand_total_branch_cum_net_format / $grand_total_getBranchAnnualtarget;
                    $grand_total_branch_percent_target_format = '('.abs(round($grand_total_quotient_branch_percent_target_format, 0)).')';
    
                } else{
                    $grand_total_branch_percent_target_format = 0;
                }
                
            }
    
            if ($grand_total_branch_net_format >=  0) {
                $grand_total_branch_net_format_fchm_view = $grand_total_branch_net_format;
            } else {
                $grand_total_branch_net_format_fchm_view = '('.abs($grand_total_branch_net_format).')';
            }
    
            if ($grand_total_branch_cum_net_format >=  0) {
                $grand_total_branch_cum_net_format_fchm_view = $grand_total_branch_cum_net_format;
            } else {
                $grand_total_branch_cum_net_format_fchm_view = '('.abs($grand_total_branch_cum_net_format).')';
            }
            $tn_fch_total = number_format($grand_total_newBegBal, 2, '.', ',');
            $tnb_fch_total = number_format($grand_total_newmonthBegBal, 2, '.', ',');
            $tnm_fch_total = number_format($grand_total_newMonthBegBalCur, 2, '.', ',');
            $tg_fch_total = number_format($grand_total_getYearlyGrossIn, 2, '.', ',');
    
    
            $item['card'] .='
         
            <tr>
                <th style="color: #b0aeac;"> TOTAL FCH</th>
                <th></th>
                <th>'.$tn_fch_total.'</th>
                <th>'.$tnb_fch_total.'</th>
                <th>'.$tnm_fch_total.'</th>
                <th>'.$grand_total_getMonthlyGrossIn.'</th>
                <th>'.$grand_total_getMonthlyAgent.'</th>
                <th>'.$tg_fch_total.'</th>
                <th>'.$grand_total_branch_net_format_fchm_view.'</th>
                <th>'.$grand_total_branch_cum_net_format_fchm_view.'</th>
                <th>'.$grand_total_branch_percent_target_format.'</th>
                <th>'.$grand_total_getBranchAnnualtarget.'</th>
            </tr>
          
            ';

            $item['card'] .='
            <thead>
            <tr>
                <th><span style="visibility:hidden;">s</span><br> RLC <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> SALES REPRESENTATIVE <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thLastYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thPrevMonth.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> END '.$thCurYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> GROSS IN<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Agents IN<br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;" >GROSS IN<br> Cumulative<br> '.$thLastYearDate.'-'.$thCurYearDate.'</th>
                <th style="text-align: center;"> BRANCH NET<br> '.$thCurYearDate.'  <br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;"> BRANCH CUM <br>NET '.$thLastYearDate.'-'.$thCurYearDate.' <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> % vs Target <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Annual Target <br><span style="visibility:hidden;">S</span></th>
            </tr>
            <tbody>
            ';

            foreach ($dataRLC as &$item1) {

                $branch_name_rlc = $item1['branch_name']; // Get the current branch name

                $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name_rlc);

                if (!empty($getSR)) {
                                
                    foreach ($getSR as $key => $value) {

                        $sale_rep_rlc_view = $value['rep_lname'].', '.$value['rep_fname'];

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_rlc, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
                        
                       
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_rlc_view = '';  // Set the branch name to empty if they are equal
                            $newBegBal_rlc = 0; $newBegBal_new2 = '';
                            $newmonthBegBal_rlc = 0; $newmonthBegBal2 = '';
                            $newMonthBegBalCur_rlc = 0; $newMonthBegBalCur2 = '';
                            $getMonthlyGrossIn_rlc = 0; $getMonthlyGrossIn2 = '';
                            $getMonthlyAgent_rlc = 0; $getMonthlyAgent2 = '';
                            $getYearlyGrossIn_rlc = 0; $getYearlyGrossIn2 = '';
                            $branch_net_format_rlc = 0; $branch_net_format2 = '';
                            $branch_cum_net_format_rlc = 0; $branch_cum_net_format2 = '';
                            $branch_percent_target_format_rlc = 0; $branch_percent_target_format2 = '';
                            $getBranchAnnualtarget_rlc = 0; $getBranchAnnualtarget2 = '';
                        
                        } else {

                            $branch_name_rlc_view = $currentBranchName;
                            $newBegBal_rlc = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_rlc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_rlc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_rlc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_rlc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_rlc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_rlc = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_rlc = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_rlc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_rlc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_rlc_view.'</th>
                        <th>'.$sale_rep_rlc_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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

                }else{

                        $sale_rep_rlc_view ='';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_rlc, $thisYearDate);

                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
        
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_rlc_view = '';  // Set the branch name to empty if they are equal
                            $newBegBal_rlc = 0; $newBegBal_new2 = '';
                            $newmonthBegBal_rlc = 0; $newmonthBegBal2 = '';
                            $newMonthBegBalCur_rlc = 0; $newMonthBegBalCur2 = '';
                            $getMonthlyGrossIn_rlc = 0; $getMonthlyGrossIn2 = '';
                            $getMonthlyAgent_rlc = 0; $getMonthlyAgent2 = '';
                            $getYearlyGrossIn_rlc = 0; $getYearlyGrossIn2 = '';
                            $branch_net_format_rlc = 0; $branch_net_format2 = '';
                            $branch_cum_net_format_rlc = 0; $branch_cum_net_format2 = '';
                            $branch_percent_target_format_rlc = 0; $branch_percent_target_format2 = '';
                            $getBranchAnnualtarget_rlc = 0; $getBranchAnnualtarget2 = '';
                        
                        } else {

                            $branch_name_rlc_view = $currentBranchName;
                            $newBegBal_rlc = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_rlc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_rlc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_rlc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_rlc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_rlc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_rlc = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_rlc = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_rlc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_rlc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_rlc_view.'</th>
                        <th>'.$sale_rep_rlc_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';


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

            if ($total_branch_net_format_rlc >=  0) {
                $total_branch_net_format_rlc_view = $total_branch_net_format_rlc;
            } else {
                $total_branch_net_format_rlc_view = '('.abs($total_branch_net_format_rlc).')';
            }

            if ($total_branch_cum_net_format_rlc >=  0) {
                $total_branch_cum_net_format_rlc_view = $total_branch_cum_net_format_rlc;
            } else {
                $total_branch_cum_net_format_rlc_view = '('.abs($total_branch_cum_net_format_rlc).')';
            }

            //prevent error division by zero

            if ($total_branch_cum_net_format_rlc >= 0) {
                if ($total_branch_cum_net_format_rlc >= 0 && $total_getBranchAnnualtarget_rlc > 0 || $total_getBranchAnnualtarget_rlc > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format_rlc / $total_getBranchAnnualtarget_rlc;
                    $total_branch_percent_target_format_rlc_view = round($quotient_branch_percent_target_format, 2) * 100 . '%';

                } else{
                    $total_branch_percent_target_format_rlc_view = 0;
                }
            } else {

                if ($total_branch_cum_net_format_rlc > 0 && $total_getBranchAnnualtarget_rlc > 0 || $total_getBranchAnnualtarget_rlc > 0) {
                
                    $quotient_branch_percent_target_format = intval($total_branch_cum_net_format_rlc) / intval($total_getBranchAnnualtarget_rlc);
                    $total_branch_percent_target_format_rlc_view = '('.abs(round($quotient_branch_percent_target_format, 0)).')';

                } else{
                    $total_branch_percent_target_format_rlc_view = 0;
                }
                
            }


            $item['card'] .='
            <tr>
            <th style="color: #b0aeac;">TOTAL RLC</th>
            <th></th>
            <th>'.number_format($total_newBegBal_rlc, 2, '.', ',').'</th>
            <th>'.number_format($total_newmonthBegBal_rlc, 2, '.', ',').'</th>
            <th>'.number_format($total_newMonthBegBalCur_rlc, 2, '.', ',').'</th>
            <th>'.$total_getMonthlyGrossIn_rlc.'</th>
            <th>'.$total_getMonthlyAgent_rlc.'</th>
            <th>'.number_format($total_getYearlyGrossIn_rlc, 2, '.', ',').'</th>
            <th>'.$total_branch_net_format_rlc_view.'</th>
            <th>'.$total_branch_cum_net_format_rlc_view.'</th>
            <th>'.$total_branch_percent_target_format_rlc_view.'</th>
            <th>'.$total_getBranchAnnualtarget_rlc.'</th>
            </tr>';

            $item['card'] .='
            <thead>
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
            <tbody>
            ';

            $item['card'] .='
            <thead>
            <tr>
                <th><span style="visibility:hidden;">s</span><br> ELC <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> SALES REPRESENTATIVE <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thLastYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> BEG '.$thPrevMonth.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> END '.$thCurYearDate.'<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> GROSS IN<br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Agents IN<br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;" >GROSS IN<br> Cumulative<br> '.$thLastYearDate.'-'.$thCurYearDate.'</th>
                <th style="text-align: center;"> BRANCH NET<br> '.$thCurYearDate.'  <br><span style="visibility:hidden;">S</span></th>
                <th style="text-align: center;"> BRANCH CUM <br>NET '.$thLastYearDate.'-'.$thCurYearDate.' <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> % vs Target <br><span style="visibility:hidden;">S</span></th>
                <th><span style="visibility:hidden;">s</span><br> Annual Target <br><span style="visibility:hidden;">S</span></th>
            </tr>
            <tbody>
            ';

            foreach ($dataELC as &$item1) {

                $branch_name_elc = $item1['branch_name']; // Get the current branch name

                $getSR = (new ControllerPensioner)->ctrGetSalesRep($branch_name_elc);

                if (!empty($getSR)) {
                                
                    foreach ($getSR as $key => $value) {

                        $sale_rep_elc_view = $value['rep_lname'].', '.$value['rep_fname'];

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_elc, $thisYearDate);
        
                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
                        
                       
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_elc_view = '';  // Set the branch name to empty if they are equal
                            $newBegBal_elc = 0; $newBegBal_new2 = '';
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

                            $branch_name_elc_view = $currentBranchName;
                            $newBegBal_elc = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_elc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_elc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_elc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_elc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_elc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_elc = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_elc = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_elc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_elc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_elc_view.'</th>
                        <th>'.$sale_rep_elc_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';

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

                }else{

                        $sale_rep_elc_view ='';

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
                        $branch_net_format = $branch_net;
        
                        $branch_cum_net = $newMonthBegBalCur - $newBegBal;
                        $branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";
                        $branch_cum_net_format = $branch_cum_net;
        
                        $getBranchAnnualtarget = (new ControllerPensioner)->ctrGetBranchAnnualTarget($branch_name_elc, $thisYearDate);

                        if ($branch_cum_net >= 0) {
                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                        } else {

                            if ($branch_cum_net > 0 && $getBranchAnnualtarget > 0 || $getBranchAnnualtarget > 0) {
                            
                                $branch_percent_target = $branch_cum_net / $getBranchAnnualtarget;
                                $branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

                            } else{
                                $branch_percent_target_format = 0;
                            }
                            
                        }
        
                        $currentBranchName = $item1['branch_name']; // Get the current branch name
                        
                        // Compare the current branch name with the previous one
                        if ($currentBranchName == $previousBranchName) {
                            $branch_name_elc_view = '';  // Set the branch name to empty if they are equal
                            $newBegBal_elc = 0; $newBegBal_new2 = '';
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

                            $branch_name_elc_view = $currentBranchName;
                            $newBegBal_elc = $newBegBal; $newBegBal_new2 = $newBegBal;
                            $newmonthBegBal_elc = $newmonthBegBal; $newmonthBegBal2 = $newmonthBegBal;
                            $newMonthBegBalCur_elc = $newMonthBegBalCur; $newMonthBegBalCur2 = $newMonthBegBalCur;
                            $getMonthlyGrossIn_elc = $getMonthlyGrossIn; $getMonthlyGrossIn2 = $getMonthlyGrossIn;
                            $getMonthlyAgent_elc = $getMonthlyAgent; $getMonthlyAgent2 = $getMonthlyAgent;
                            $getYearlyGrossIn_elc = $getYearlyGrossIn; $getYearlyGrossIn2 = $getYearlyGrossIn;
                            $branch_net_format_elc = $branch_net_format; $branch_net_format2 = $branch_net_format_display;
                            $branch_cum_net_format_elc = $branch_cum_net_format; $branch_cum_net_format2 = $branch_cum_net_format_display;
                            $branch_percent_target_format_elc = $branch_percent_target_format; $branch_percent_target_format2 = $branch_percent_target_format;
                            $getBranchAnnualtarget_elc = $getBranchAnnualtarget; $getBranchAnnualtarget2 = $getBranchAnnualtarget;
                            
                        }
                        
                        $previousBranchName = $currentBranchName; // Update the previous branch name
            
                        $item['card'] .='
                        <tr>
                        <th>'.$branch_name_elc_view.'</th>
                        <th>'.$sale_rep_elc_view.'</th>
                        <th>'.$newBegBal_new2.'</th>
                        <th>'.$newmonthBegBal2.'</th>
                        <th>'.$newMonthBegBalCur2.'</th>
                        <th>'.$getMonthlyGrossIn2.'</th>
                        <th>'.$getMonthlyAgent2.'</th>
                        <th>'.$getYearlyGrossIn2.'</th>
                        <th>'.$branch_net_format2.'</th>
                        <th>'.$branch_cum_net_format2.'</th>
                        <th>'.$branch_percent_target_format2.'</th>
                        <th>'.$getBranchAnnualtarget2.'</th>
                        </tr>';


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
            } else {
                $total_branch_net_format_elc_view = '('.abs($total_branch_net_format_elc).')';
            }

            if ($total_branch_cum_net_format_elc >=  0) {
                $total_branch_cum_net_format_elc_view = $total_branch_cum_net_format_elc;
            } else {
                $total_branch_cum_net_format_elc_view = '('.abs($total_branch_cum_net_format_elc).')';
            }

            //prevent error division by zero

            if ($total_branch_cum_net_format_elc >= 0) {
                if ($total_branch_cum_net_format_elc >= 0 && $total_getBranchAnnualtarget_elc > 0 || $total_getBranchAnnualtarget_elc > 0) {
                
                    $quotient_branch_percent_target_format = $total_branch_cum_net_format_elc / $total_getBranchAnnualtarget_elc;
                    $total_branch_percent_target_format_elc_view = round($quotient_branch_percent_target_format, 2) * 100 . '%';

                } else{
                    $total_branch_percent_target_format_elc_view = 0;
                }
            } else {

                if ($total_branch_cum_net_format_elc > 0 && $total_getBranchAnnualtarget_elc > 0 || $total_getBranchAnnualtarget_elc > 0) {
                
                    $quotient_branch_percent_target_format = intval($total_branch_cum_net_format_elc) / intval($total_getBranchAnnualtarget_elc);
                    $total_branch_percent_target_format_elc_view = '('.abs(round($quotient_branch_percent_target_format, 0)).')';

                } else{
                    $total_branch_percent_target_format_elc_view = 0;
                }
                
            }


            $item['card'] .='
            <tr>
            <th style="color: #b0aeac;">TOTAL ELC</th>
            <th></th>
            <th>'.number_format($total_newBegBal_elc, 2, '.', ',').'</th>
            <th>'.number_format($total_newmonthBegBal_elc, 2, '.', ',').'</th>
            <th>'.number_format($total_newMonthBegBalCur_elc, 2, '.', ',').'</th>
            <th>'.$total_getMonthlyGrossIn_elc.'</th>
            <th>'.$total_getMonthlyAgent_elc.'</th>
            <th>'.number_format($total_getYearlyGrossIn_elc, 2, '.', ',').'</th>
            <th>'.$total_branch_net_format_elc_view.'</th>
            <th>'.$total_branch_cum_net_format_elc_view.'</th>
            <th>'.$total_branch_percent_target_format_elc_view.'</th>
            <th>'.$total_getBranchAnnualtarget_elc.'</th>
            </tr>';

            $item['card'] .='
            <thead>
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
            <tbody>
            ';

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
                
                    $final_grand_quotient_branch_percent_target_format = intval($final_grand_total_branch_cum_net_format) / intval($final_grand_total_getBranchAnnualtarget);
                    $final_grand_total_branch_percent_target_format_view = round($final_grand_quotient_branch_percent_target_format, 2) * 100 . '%';
                    $final_grand_total_branch_percent_target_format_view_color = 'black';

                } else{
                    $final_grand_total_branch_percent_target_format_view = 0;
                    $final_grand_total_branch_percent_target_format_view_color = 'black';
                }
            } else {

                if ($final_grand_total_branch_cum_net_format > 0 && $final_grand_total_getBranchAnnualtarget > 0 || $final_grand_total_getBranchAnnualtarget > 0) {
                
                    $final_grand_quotient_branch_percent_target_format = intval($final_grand_total_branch_cum_net_format) / intval($final_grand_total_getBranchAnnualtarget);
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

            $item['card'] .='
            
            <tr>
                <th>GRAND TOTAL</th>
                <th></th>
                <th>'.$tn_grand_final.'</th>
                <th>'.$tnb_grand_final.'</th>
                <th>'.$tnm_grand_final.'</th>
                <th>'.$final_grand_toral_getMonthlyGrossIn.'</th>
                <th>'.$final_grand_toral_getMonthlyAgent.'</th>
                <th>'.$tg_grand_final.'</th>
                <th>'.$branch_net_formatfinal_view.'</th>
                <th>'.$branch_cum_net_formatfinal_view.'</th>
                <th>'.$final_grand_total_branch_percent_target_format_view.'</th>
                <th>'.$final_grand_total_getBranchAnnualtarget.'</th>
            </tr>
        ';
  

    
        echo json_encode($data1);  
        
        }

    }
}