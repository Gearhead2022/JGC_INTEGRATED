<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";

$monthlyAgents = new MonthlyAgentTableAdmin();
$monthlyAgents->showTableMonthlyAgentAdmin();

class MonthlyAgentTableAdmin
{
    public function showTableMonthlyAgentAdmin(){
        $monthlyAgent = new ControllerPensioner();

        // Get the selected month from the user (you can retrieve it from your date picker)
        $selectedMonth = isset($_GET['mdate']) ? $_GET['mdate'] : date('Y-m');
        $selectedYear = date('Y', strtotime($_GET['mdate']));

        // Convert the selected month to the date format
        $startDate = $selectedYear. "-01-01";
        $endDate = $selectedYear. "-12-31";

        
        $asOflastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );

        $OVERALLGRANDTOTALOFAGENTS = 0;
        $OVERALLGRANDTOTALOFSALES = 0;
        $OVERALLGRANDTOTALMONTHLYAGENT = 0;
        $OVERALLGRANDTOTALMONTHLYSALES = 0;

        $html = '';

        $month = date('m', strtotime($_GET['mdate']));
        $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
        if ($month >= 1 && $month <= 12) {
            $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
            $value_span = $month * 2 + 3;
            $value = $month;
        }

        $html .= '
        <thead>
            <tr>
                <th rowspan="4" style="vertical-align:middle;text-align:center;font-size:1rem;">EMB BRANCHES</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL NUMBER OF AGENTS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE OF SALES</th>
                <th colspan="'.$value_span.'" style="text-align:center;">MONTHLY NUMBER OF AGENTS AND SALES</th>
            </tr>
            <tr>';

      

        $html .= '
            </tr>
            <tr>';
        
          
      

        foreach ($monthsToDisplay as $month) {
            $html .= '<th colspan="2" style="text-align:center;">' . strtoupper($month) . '</th>';
        }
        $html .= '<th></th>';
        $html .= '<th rowspan="2" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE SALES</th>';


        $html .= '
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;">AS OF DECEMBER '.$asOflastYear.'</th>';

        // Create empty headers for each month in the second row
        for ($i = 0; $i <  $value; $i++) {
            $html .= '<th>AGENTS</th><th>SALES</th>';

          
        }
        $html .= '<th style="text-align:center;">Total Agents</th>';

        $html .= '
            </tr>
        </thead>
        <tbody>';

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

        foreach ($getEMB as $emb) {
            
            $branch_namessss = $emb['full_name'];
            $branch_names = rtrim($branch_namessss);

            $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names);
            $monthf = date('Y-m', strtotime($_GET['mdate']));
        
         
            $beg_agents = 0;
            $beg_sales = 0;

         

            for ($i = 0; $i >= -11; $i--) {
                $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
                $startDatemonth = $currentMonth . "-01";
                $endDatemonth = $currentMonth . "-t";
        
               
                $getdate = $monthlyAgent->ctrGetDates($branch_names, $startDatemonth, $endDatemonth);

                $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
                $startYear = $lastYear . "-01-01";
                $endYear = $lastYear . "-12-31";


              
                $startYearbeg = $lastYear . "-01-01";
                $endYearsbeg = $lastYear . "-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);

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
        $getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);

        $startDateFeb = $selectedYear. "-02-01";
        $endDateFeb = date("Y-m-t", strtotime($startDateFeb));
        $getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateFeb,$endDateFeb);

        $startDateMar = $selectedYear. "-03-01";
        $endDateMar = date("Y-m-t", strtotime($startDateMar));
        $getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMar,$endDateMar);

        $startDateApr = $selectedYear. "-04-01";
        $endDateApr = date("Y-m-t", strtotime($startDateApr));
        $getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateApr,$endDateApr);

        $startDateMay = $selectedYear. "-05-01";
        $endDateMay = date("Y-m-t", strtotime($startDateMay));
        $getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMay,$endDateMay);

        
        $startDateJun = $selectedYear. "-06-01";
        $endDateJun = date("Y-m-t", strtotime($startDateJun));
        $getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJun,$endDateJun);

        $startDateJul = $selectedYear. "-07-01";
        $endDateJul = date("Y-m-t", strtotime($startDateJul));
        $getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJul,$endDateJul);

        $startDateAug = $selectedYear. "-08-01";
        $endDateAug = date("Y-m-t", strtotime($startDateAug));
        $getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateAug,$endDateAug);

        $startDateSep = $selectedYear. "-09-01";
        $endDateSep = date("Y-m-t", strtotime($startDateSep));
        $getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateSep,$endDateSep);

        $startDateOct = $selectedYear. "-10-01";
        $endDateOct = date("Y-m-t", strtotime($startDateOct));
        $getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateOct,$endDateOct);

        $startDateNov = $selectedYear. "-11-01";
        $endDateNov = date("Y-m-t", strtotime($startDateNov));
        $getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateNov,$endDateNov);

        $startDateDec = $selectedYear. "-12-01";
        $endDateDec = date("Y-m-t", strtotime($startDateDec));
        $getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateDec,$endDateDec);
        
    
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

        $html .= '<tr>';
        $html .= '<th>' . $branch_names . '</th>';
            
          
            // display beginning balance and agents sales per month
      
            $totalAgentsMonthlyEMB = 0;
            $totalSalesMonthly = 0;
           for($i = 0; $i < 1; $i++){
            $html .= '<th>' . $beg_agents . '</th><th>' . $beg_sales . '</th>';
     
            $totalAgentBegBalEMB += $beg_agents;
            $totalSalesBegBalEMB += $beg_sales;
            
                for($j = 0; $j < $value; $j++){
                    $html .= '<th>' . $eachMonthTotalAgent[$j] . '</th><th>'.$eachMonthTotalSales[$j].'</th>';

                    $totalAgentsMonthlyEMB +=  $eachMonthTotalAgent[$j];  
                    $totalSalesMonthly += $eachMonthTotalSales[$j];
                 
                }
            
                $grandtotalofTotalAgentsMonthlyEMB +=  $totalAgentsMonthlyEMB;
                $grandtotalofTotalSalesMonthlyEMB += $totalSalesMonthly;
           }
       
        
           $html .= '<th> '.$totalAgentsMonthlyEMB.'</th>';
           $html .= '<th>'.$totalSalesMonthly.'</th>';
           $html .= '</tr>';
        }

       



        // TOTAL
        $html .= '<tr>';

  
        $html .= '<th>TOTAL</th> <th>'.$totalAgentBegBalEMB.'</th> <th>'.$totalSalesBegBalEMB.'</th>';
        
        for ($i = 0; $i < $value; $i++) {
            $html .= '<th>'.$OverallTotalAgents[$i].'</th> <th style="background-color:#EEBD38;color:black;">'.$OverallTotalSales[$i].'</th>';
                  
        }
        $html .= '<th>'.$grandtotalofTotalAgentsMonthlyEMB.'</th> <th>'.$grandtotalofTotalSalesMonthlyEMB.'</th>';

        $html .= '</tr>';














        // FCH BRANCH NEGROS

        $html .= '<tr>
        <th colspan="5" style="color:transparent;">a</th>
        </tr>';

        $month = date('m', strtotime($_GET['mdate']));
        $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
        if ($month >= 1 && $month <= 12) {
            $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
            $value_span = $month * 2 + 3;
            $value = $month;
        }

        $html .= '
        <thead>
            <tr>
                <th rowspan="4" style="vertical-align:middle;text-align:center;font-size:1rem;">FCH VISAYAS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL NUMBER OF AGENTS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE OF SALES</th>
                <th colspan="'.$value_span.'" style="text-align:center;">MONTHLY NUMBER OF AGENTS AND SALES</th>
            </tr>
            <tr>';

      

        $html .= '
            </tr>
            <tr>';
        
          
      

        foreach ($monthsToDisplay as $month) {
            $html .= '<th colspan="2" style="text-align:center;">' . strtoupper($month) . '</th>';
        }
        $html .= '<th></th>';
        $html .= '<th rowspan="2" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE SALES</th>';


        $html .= '
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;">AS OF DECEMBER '.$asOflastYear.'</th>';

        // Create empty headers for each month in the second row
        for ($i = 0; $i <  $value; $i++) {
            $html .= '<th>AGENTS</th><th>SALES</th>';

          
        }
        $html .= '<th style="text-align:center;">Total Agents</th>';

        $html .= '
            </tr>
        </thead>
        <tbody>';

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


        $totalAgentBegBalFCHN = 0;
        $totalSalesBegBalFCHN = 0;
        foreach ($getEMB as $emb) {
            
            $branch_namessss = $emb['full_name'];
            $branch_names = rtrim($branch_namessss);

            $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names);
            $monthf = date('Y-m', strtotime($_GET['mdate']));
        
         
            $beg_agents = 0;
            $beg_sales = 0;

         

            for ($i = 0; $i >= -11; $i--) {
                $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
                $startDatemonth = $currentMonth . "-01";
                $endDatemonth = $currentMonth . "-31";
        
               
                $getdate = $monthlyAgent->ctrGetDates($branch_names, $startDatemonth, $endDatemonth);
        

                $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
                $startYear = $lastYear . "-01-01";
                $endYear = $lastYear . "-12-31";

                $startYearbeg = $lastYear ."-01-01";
                $endYearsbeg = $lastYear ."-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);

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
        $getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);

        $startDateFeb = $selectedYear. "-02-01";
        $endDateFeb = date("Y-m-t", strtotime($startDateFeb));
        $getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateFeb,$endDateFeb);

        $startDateMar = $selectedYear. "-03-01";
        $endDateMar = date("Y-m-t", strtotime($startDateMar));
        $getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMar,$endDateMar);

        $startDateApr = $selectedYear. "-04-01";
        $endDateApr = date("Y-m-t", strtotime($startDateApr));
        $getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateApr,$endDateApr);

        $startDateMay = $selectedYear. "-05-01";
        $endDateMay = date("Y-m-t", strtotime($startDateMay));
        $getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMay,$endDateMay);

        
        $startDateJun = $selectedYear. "-06-01";
        $endDateJun = date("Y-m-t", strtotime($startDateJun));
        $getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJun,$endDateJun);

        $startDateJul = $selectedYear. "-07-01";
        $endDateJul = date("Y-m-t", strtotime($startDateJul));
        $getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJul,$endDateJul);

        $startDateAug = $selectedYear. "-08-01";
        $endDateAug = date("Y-m-t", strtotime($startDateAug));
        $getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateAug,$endDateAug);

        $startDateSep = $selectedYear. "-09-01";
        $endDateSep = date("Y-m-t", strtotime($startDateSep));
        $getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateSep,$endDateSep);

        $startDateOct = $selectedYear. "-10-01";
        $endDateOct = date("Y-m-t", strtotime($startDateOct));
        $getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateOct,$endDateOct);

        $startDateNov = $selectedYear. "-11-01";
        $endDateNov = date("Y-m-t", strtotime($startDateNov));
        $getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateNov,$endDateNov);

        $startDateDec = $selectedYear. "-11-01";
        $endDateDec = date("Y-m-t", strtotime($startDateDec));
        $getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateDec,$endDateDec);
        
    
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

        $html .= '<tr>';
        $html .= '<th>' . $branch_names . '</th>';
            
          
            // display beginning balance and agents sales per month
      
            $totalAgentsMonthlyFCHN = 0;
            $totalSalesMonthly = 0;
           for($i = 0; $i < 1; $i++){
            $html .= '<th>' . $beg_agents . '</th><th>' . $beg_sales . '</th>';
     
            $totalAgentBegBalFCHN += $beg_agents;
            $totalSalesBegBalFCHN += $beg_sales;
            
        
        
                for($j = 0; $j < $value; $j++){
                    $html .= '<th>' . $eachMonthTotalAgent[$j] . '</th><th>'.$eachMonthTotalSales[$j].'</th>';

                    $totalAgentsMonthlyFCHN +=  $eachMonthTotalAgent[$j];  
                    $totalSalesMonthly += $eachMonthTotalSales[$j];

                 
                 
                }
            
                $grandtotalofTotalAgentsMonthlyFCHN +=  $totalAgentsMonthlyFCHN;
                $grandtotalofTotalSalesMonthlyFCHN += $totalSalesMonthly;
           }
       
        
           $html .= '<th> '.$totalAgentsMonthlyFCHN.'</th>';

           $html .= '<th>'.$totalSalesMonthly.'</th>';

    

            $html .= '</tr>';
        }

       



        // TOTAL
        $html .= '<tr>';

  
        $html .= '<th>TOTAL</th> <th>'.$totalAgentBegBalFCHN.'</th> <th>'.$totalSalesBegBalFCHN.'</th>';
        
        for ($i = 0; $i < $value; $i++) {
            $html .= '<th>'.$OverallTotalAgents[$i].'</th> <th style="background-color:#EEBD38;color:black;">'.$OverallTotalSales[$i].'</th>';
                  
        }
        $html .= '<th>'.$grandtotalofTotalAgentsMonthlyFCHN.'</th> <th>'.$grandtotalofTotalSalesMonthlyFCHN.'</th>';

        $html .= '</tr>';


    
        


















        // FCH MANILA
        $html .= '<tr>
        <th colspan="5" style="color:transparent;">a</th>
        </tr>';

        $month = date('m', strtotime($_GET['mdate']));
        $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
        if ($month >= 1 && $month <= 12) {
            $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
            $value_span = $month * 2 + 3;
            $value = $month;
        }

        $html .= '
        <thead>
            <tr>
                <th rowspan="4" style="vertical-align:middle;text-align:center;font-size:1rem;">FCH MANILA</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL NUMBER OF AGENTS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE OF SALES</th>
                <th colspan="'.$value_span.'" style="text-align:center;">MONTHLY NUMBER OF AGENTS AND SALES</th>
            </tr>
            <tr>';

      

        $html .= '
            </tr>
            <tr>';
        
          
      

        foreach ($monthsToDisplay as $month) {
            $html .= '<th colspan="2" style="text-align:center;">' . strtoupper($month) . '</th>';
        }
        $html .= '<th></th>';
        $html .= '<th rowspan="2" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE SALES</th>';


        $html .= '
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;">AS OF DECEMBER 2022</th>';

        // Create empty headers for each month in the second row
        for ($i = 0; $i <  $value; $i++) {
            $html .= '<th>AGENTS</th><th>SALES</th>';

          
        }
        $html .= '<th style="text-align:center;">Total Agents</th>';

        $html .= '
            </tr>
        </thead>
        <tbody>';

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


        $totalAgentBegBalFCHM = 0;
        $totalSalesBegBalFCHM = 0;

        foreach ($getEMB as $emb) {
            
            $branch_namessss = $emb['full_name'];
            $branch_names = rtrim($branch_namessss);

            $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names);
            $monthf = date('Y-m', strtotime($_GET['mdate']));
        
         
            $beg_agents = 0;
            $beg_sales = 0;

         

            for ($i = 0; $i >= -11; $i--) {
                $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
                $startDatemonth = $currentMonth . "-01";
                $endDatemonth = $currentMonth . "-31";
        
               
                $getdate = $monthlyAgent->ctrGetDates($branch_names, $startDatemonth, $endDatemonth);
        

                $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
                $startYear = $lastYear . "-01-01";
                $endYear = $lastYear . "-12-31";

                $startYearbeg = $lastYear . "-01-01";
                $endYearsbeg = $lastYear . "-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);
               
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
        $getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);

        $startDateFeb = $selectedYear. "-02-01";
        $endDateFeb = date("Y-m-t", strtotime($startDateFeb));
        $getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateFeb,$endDateFeb);

        $startDateMar = $selectedYear. "-03-01";
        $endDateMar = date("Y-m-t", strtotime($startDateMar));
        $getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMar,$endDateMar);

        $startDateApr = $selectedYear. "-04-01";
        $endDateApr = date("Y-m-t", strtotime($startDateApr));
        $getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateApr,$endDateApr);

        $startDateMay = $selectedYear. "-05-01";
        $endDateMay = date("Y-m-t", strtotime($startDateMay));
        $getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMay,$endDateMay);

        
        $startDateJun = $selectedYear. "-06-01";
        $endDateJun = date("Y-m-t", strtotime($startDateJun));
        $getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJun,$endDateJun);

        $startDateJul = $selectedYear. "-07-01";
        $endDateJul = date("Y-m-t", strtotime($startDateJul));
        $getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJul,$endDateJul);

        $startDateAug = $selectedYear. "-08-01";
        $endDateAug = date("Y-m-t", strtotime($startDateAug));
        $getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateAug,$endDateAug);

        $startDateSep = $selectedYear. "-09-01";
        $endDateSep = date("Y-m-t", strtotime($startDateSep));
        $getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateSep,$endDateSep);

        $startDateOct = $selectedYear. "-10-01";
        $endDateOct = date("Y-m-t", strtotime($startDateOct));
        $getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateOct,$endDateOct);

        $startDateNov = $selectedYear. "-11-01";
        $endDateNov = date("Y-m-t", strtotime($startDateNov));
        $getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateNov,$endDateNov);

        $startDateDec = $selectedYear. "-11-01";
        $endDateDec = date("Y-m-t", strtotime($startDateDec));
        $getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateDec,$endDateDec);
        
    
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

        $html .= '<tr>';
        $html .= '<th>' . $branch_names . '</th>';
            
          
            // display beginning balance and agents sales per month
      
            $totalAgentsMonthlyFCHM = 0;
            $totalSalesMonthly = 0;
           for($i = 0; $i < 1; $i++){
            $html .= '<th>' . $beg_agents . '</th><th>' . $beg_sales . '</th>';
     
            $totalAgentBegBalFCHM += $beg_agents;
            $totalSalesBegBalFCHM += $beg_sales;
            
        
        
                for($j = 0; $j < $value; $j++){
                    $html .= '<th>' . $eachMonthTotalAgent[$j] . '</th><th>'.$eachMonthTotalSales[$j].'</th>';

                    $totalAgentsMonthlyFCHM +=  $eachMonthTotalAgent[$j];  
                    $totalSalesMonthly += $eachMonthTotalSales[$j];

                 
                 
                }
            
                $grandtotalofTotalAgentsMonthlyFCHM +=  $totalAgentsMonthlyFCHM;
                $grandtotalofTotalSalesMonthlyFCHM += $totalSalesMonthly;
           }
       
        
           $html .= '<th> '.$totalAgentsMonthlyFCHM.'</th>';

           $html .= '<th>'.$totalSalesMonthly.'</th>';

    

            $html .= '</tr>';
        }

       



        // TOTAL
        $html .= '<tr>';

  
        $html .= '<th>TOTAL</th> <th>'.$totalAgentBegBalFCHM.'</th> <th>'.$totalSalesBegBalFCHM.'</th>';
        
        for ($i = 0; $i < $value; $i++) {
            $html .= '<th>'.$OverallTotalAgents[$i].'</th> <th style="background-color:#EEBD38;color:black;">'.$OverallTotalSales[$i].'</th>';
                  
        }
        $html .= '<th>'.$grandtotalofTotalAgentsMonthlyFCHM.'</th> <th>'.$grandtotalofTotalSalesMonthlyFCHM.'</th>';

        $html .= '</tr>';




















        // RLC BRANCH 
        $html .= '<tr>
        <th colspan="5" style="color:transparent;">a</th>
        </tr>';

        $month = date('m', strtotime($_GET['mdate']));
        $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
        if ($month >= 1 && $month <= 12) {
            $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
            $value_span = $month * 2 + 3;
            $value = $month;
        }

        $html .= '
        <thead>
            <tr>
                <th rowspan="4" style="vertical-align:middle;text-align:center;font-size:1rem;">RLC BRANCHES</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL NUMBER OF AGENTS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE OF SALES</th>
                <th colspan="'.$value_span.'" style="text-align:center;">MONTHLY NUMBER OF AGENTS AND SALES</th>
            </tr>
            <tr>';

      

        $html .= '
            </tr>
            <tr>';
        
          
      

        foreach ($monthsToDisplay as $month) {
            $html .= '<th colspan="2" style="text-align:center;">' . strtoupper($month) . '</th>';
        }
        $html .= '<th></th>';
        $html .= '<th rowspan="2" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE SALES</th>';


        $html .= '
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;">AS OF DECEMBER '.$asOflastYear.'</th>';

        // Create empty headers for each month in the second row
        for ($i = 0; $i <  $value; $i++) {
            $html .= '<th>AGENTS</th><th>SALES</th>';

          
        }
        $html .= '<th style="text-align:center;">Total Agents</th>';

        $html .= '
            </tr>
        </thead>
        <tbody>';

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


        $totalAgentBegBalRLC = 0;
        $totalSalesBegBalRLC = 0;

        foreach ($getEMB as $emb) {
            
            $branch_namessss = $emb['full_name'];
            $branch_names = rtrim($branch_namessss);

            $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names);
            $monthf = date('Y-m', strtotime($_GET['mdate']));
        
         
            $beg_agents = 0;
            $beg_sales = 0;

         

            for ($i = 0; $i >= -11; $i--) {
                $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
                $startDatemonth = $currentMonth . "-01";
                $endDatemonth = $currentMonth . "-31";
        
               
                $getdate = $monthlyAgent->ctrGetDates($branch_names, $startDatemonth, $endDatemonth);
        

                $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
                $startYear = $lastYear . "-01-01";
                $endYear = $lastYear . "-12-31";
                
                $startYearbeg = $lastYear . "-01-01";
                $endYearsbeg = $lastYear . "-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);

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
        $getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);

        $startDateFeb = $selectedYear. "-02-01";
        $endDateFeb = date("Y-m-t", strtotime($startDateFeb));
        $getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateFeb,$endDateFeb);

        $startDateMar = $selectedYear. "-03-01";
        $endDateMar = date("Y-m-t", strtotime($startDateMar));
        $getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMar,$endDateMar);

        $startDateApr = $selectedYear. "-04-01";
        $endDateApr = date("Y-m-t", strtotime($startDateApr));
        $getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateApr,$endDateApr);

        $startDateMay = $selectedYear. "-05-01";
        $endDateMay = date("Y-m-t", strtotime($startDateMay));
        $getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMay,$endDateMay);

        
        $startDateJun = $selectedYear. "-06-01";
        $endDateJun = date("Y-m-t", strtotime($startDateJun));
        $getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJun,$endDateJun);

        $startDateJul = $selectedYear. "-07-01";
        $endDateJul = date("Y-m-t", strtotime($startDateJul));
        $getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJul,$endDateJul);

        $startDateAug = $selectedYear. "-08-01";
        $endDateAug = date("Y-m-t", strtotime($startDateAug));
        $getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateAug,$endDateAug);

        $startDateSep = $selectedYear. "-09-01";
        $endDateSep = date("Y-m-t", strtotime($startDateSep));
        $getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateSep,$endDateSep);

        $startDateOct = $selectedYear. "-10-01";
        $endDateOct = date("Y-m-t", strtotime($startDateOct));
        $getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateOct,$endDateOct);

        $startDateNov = $selectedYear. "-11-01";
        $endDateNov = date("Y-m-t", strtotime($startDateNov));
        $getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateNov,$endDateNov);

        $startDateDec = $selectedYear. "-11-01";
        $endDateDec = date("Y-m-t", strtotime($startDateDec));
        $getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateDec,$endDateDec);
        
    
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

        $html .= '<tr>';
        $html .= '<th>' . $branch_names . '</th>';
            
          
            // display beginning balance and agents sales per month
      
            $totalAgentsMonthlyRLC = 0;
            $totalSalesMonthly = 0;
           for($i = 0; $i < 1; $i++){
            $html .= '<th>' . $beg_agents . '</th><th>' . $beg_sales . '</th>';
     
            $totalAgentBegBalRLC += $beg_agents;
            $totalSalesBegBalRLC += $beg_sales;
            
        
        
                for($j = 0; $j < $value; $j++){
                    $html .= '<th>' . $eachMonthTotalAgent[$j] . '</th><th>'.$eachMonthTotalSales[$j].'</th>';

                    $totalAgentsMonthlyRLC +=  $eachMonthTotalAgent[$j];  
                    $totalSalesMonthly += $eachMonthTotalSales[$j];

                 
                 
                }
            
                $grandtotalofTotalAgentsMonthlyRLC +=  $totalAgentsMonthlyRLC;
                $grandtotalofTotalSalesMonthlyRLC += $totalSalesMonthly;
           }
       
        
           $html .= '<th> '.$totalAgentsMonthlyRLC.'</th>';

           $html .= '<th>'.$totalSalesMonthly.'</th>';

    

            $html .= '</tr>';
        }

       



        // TOTAL
        $html .= '<tr>';

  
        $html .= '<th>TOTAL</th> <th>'.$totalAgentBegBalRLC.'</th> <th>'.$totalSalesBegBalRLC.'</th>';
        
        for ($i = 0; $i < $value; $i++) {
            $html .= '<th>'.$OverallTotalAgents[$i].'</th> <th style="background-color:#EEBD38;color:black;">'.$OverallTotalSales[$i].'</th>';
                  
        }
        $html .= '<th>'.$grandtotalofTotalAgentsMonthlyRLC.'</th> <th>'.$grandtotalofTotalSalesMonthlyRLC.'</th>';

        $html .= '</tr>';
















        // ELC
        $html .= '<tr>
        <th colspan="5" style="color:transparent;">a</th>
        </tr>';

        $month = date('m', strtotime($_GET['mdate']));
        $monthsToDisplay = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
        if ($month >= 1 && $month <= 12) {
            $monthsToDisplay = array_slice($monthsToDisplay, 0, $month);
            $value_span = $month * 2 + 3;
            $value = $month;
        }

        $html .= '
        <thead>
            <tr>
                <th rowspan="4" style="vertical-align:middle;text-align:center;font-size:1rem;">ELC BRANCHES</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL NUMBER OF AGENTS</th>
                <th rowspan="3" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE OF SALES</th>
                <th colspan="'.$value_span.'" style="text-align:center;">MONTHLY NUMBER OF AGENTS AND SALES</th>
            </tr>
            <tr>';

      

        $html .= '
            </tr>
            <tr>';
        
          
      

        foreach ($monthsToDisplay as $month) {
            $html .= '<th colspan="2" style="text-align:center;">' . strtoupper($month) . '</th>';
        }
        $html .= '<th></th>';
        $html .= '<th rowspan="2" style="vertical-align:middle;text-align:center;">TOTAL CUMULATIVE SALES</th>';


        $html .= '
            </tr>
            <tr>
                <th colspan="2" style="text-align:center;">AS OF DECEMBER '.$asOflastYear.'</th>';

        // Create empty headers for each month in the second row
        for ($i = 0; $i <  $value; $i++) {
            $html .= '<th>AGENTS</th><th>SALES</th>';

          
        }
        $html .= '<th style="text-align:center;">Total Agents</th>';

        $html .= '
            </tr>
        </thead>
        <tbody>';

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

        $grandtotalofTotalAgentsMonthlyELC = 0;
        $grandtotalofTotalSalesMonthlyELC = 0;


        $totalAgentBegBalELC = 0;
        $totalSalesBegBalELC = 0;

        foreach ($getEMB as $emb) {
            
            $branch_namessss = $emb['full_name'];
            $branch_names = rtrim($branch_namessss);

            $getdata = $monthlyAgent->ctrGetDataFromBranch($branch_names);
            $monthf = date('Y-m', strtotime($_GET['mdate']));
        
         
            $beg_agents = 0;
            $beg_sales = 0;

         

            for ($i = 0; $i >= -11; $i--) {
                $currentMonth = date('Y-m', strtotime($monthf . " " . $i . " months"));
                $startDatemonth = $currentMonth . "-01";
                $endDatemonth = $currentMonth . "-31";
        
               
                $getdate = $monthlyAgent->ctrGetDates($branch_names, $startDatemonth, $endDatemonth);
        

                $lastYear = date('Y',strtotime('-1 year', strtotime($_GET['mdate'])) );
                $startYear = $lastYear . "-01-01";
                $endYear = $lastYear . "-12-31";
                
                $startYearbeg = $lastYear . "-01-01";
                $endYearsbeg = $lastYear . "-12-31";
                
                $getYear = $monthlyAgent->ctrGetDates($branch_names, $startYear, $endYear);
                $begYear = $monthlyAgent->ctrGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg);

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
        $getjan = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJan,$endDateJan);

        $startDateFeb = $selectedYear. "-02-01";
        $endDateFeb = date("Y-m-t", strtotime($startDateFeb));
        $getfeb = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateFeb,$endDateFeb);

        $startDateMar = $selectedYear. "-03-01";
        $endDateMar = date("Y-m-t", strtotime($startDateMar));
        $getMar = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMar,$endDateMar);

        $startDateApr = $selectedYear. "-04-01";
        $endDateApr = date("Y-m-t", strtotime($startDateApr));
        $getApr = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateApr,$endDateApr);

        $startDateMay = $selectedYear. "-05-01";
        $endDateMay = date("Y-m-t", strtotime($startDateMay));
        $getMay = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateMay,$endDateMay);

        
        $startDateJun = $selectedYear. "-06-01";
        $endDateJun = date("Y-m-t", strtotime($startDateJun));
        $getJun = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJun,$endDateJun);

        $startDateJul = $selectedYear. "-07-01";
        $endDateJul = date("Y-m-t", strtotime($startDateJul));
        $getJul = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateJul,$endDateJul);

        $startDateAug = $selectedYear. "-08-01";
        $endDateAug = date("Y-m-t", strtotime($startDateAug));
        $getAug = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateAug,$endDateAug);

        $startDateSep = $selectedYear. "-09-01";
        $endDateSep = date("Y-m-t", strtotime($startDateSep));
        $getsep = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateSep,$endDateSep);

        $startDateOct = $selectedYear. "-10-01";
        $endDateOct = date("Y-m-t", strtotime($startDateOct));
        $getoct = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateOct,$endDateOct);

        $startDateNov = $selectedYear. "-11-01";
        $endDateNov = date("Y-m-t", strtotime($startDateNov));
        $getnov = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateNov,$endDateNov);

        $startDateDec = $selectedYear. "-11-01";
        $endDateDec = date("Y-m-t", strtotime($startDateDec));
        $getdec = $monthlyAgent->ctrGetDataEveryMonth($branch_names,$startDateDec,$endDateDec);
        
    
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

        $html .= '<tr>';
        $html .= '<th>' . $branch_names . '</th>';
            
          
            // display beginning balance and agents sales per month
      
            $totalAgentsMonthlyELC = 0;
            $totalSalesMonthly = 0;
           for($i = 0; $i < 1; $i++){
            $html .= '<th>' . $beg_agents . '</th><th>' . $beg_sales . '</th>';
     
            $totalAgentBegBalELC += $beg_agents;
            $totalSalesBegBalELC += $beg_sales;
            
        
        
                for($j = 0; $j < $value; $j++){
                    $html .= '<th>' . $eachMonthTotalAgent[$j] . '</th><th>'.$eachMonthTotalSales[$j].'</th>';

                    $totalAgentsMonthlyELC +=  $eachMonthTotalAgent[$j];  
                    $totalSalesMonthly += $eachMonthTotalSales[$j];

                 
                 
                }
            
                $grandtotalofTotalAgentsMonthlyELC +=  $totalAgentsMonthlyELC;
                $grandtotalofTotalSalesMonthlyELC += $totalSalesMonthly;
           }
       
          

           $html .= '<th> '.$totalAgentsMonthlyELC.'</th>';

           $html .= '<th>'.$totalSalesMonthly.'</th>';

    

            $html .= '</tr>';
        }

        $OVERALLGRANDTOTALOFAGENTS = $totalAgentBegBalELC + $totalAgentBegBalRLC + $totalAgentBegBalFCHM + $totalAgentBegBalFCHN + $totalAgentBegBalEMB;
        $OVERALLGRANDTOTALOFSALES = $totalSalesBegBalELC + $totalSalesBegBalRLC + $totalSalesBegBalFCHM + $totalSalesBegBalFCHN + $totalSalesBegBalEMB;
        $OVERALLGRANDTOTALMONTHLYAGENT = $grandtotalofTotalAgentsMonthlyELC + $grandtotalofTotalAgentsMonthlyRLC + $grandtotalofTotalAgentsMonthlyFCHM + $grandtotalofTotalAgentsMonthlyFCHN + $grandtotalofTotalAgentsMonthlyEMB;
        $OVERALLGRANDTOTALMONTHLYSALES = $grandtotalofTotalSalesMonthlyELC + $grandtotalofTotalSalesMonthlyRLC + $grandtotalofTotalSalesMonthlyFCHM + $grandtotalofTotalSalesMonthlyFCHN + $grandtotalofTotalSalesMonthlyEMB;

        $html .= '<tr> <th colspan="5" style="border:none;"> </th> </tr>';
        $html .= '<tr> <th colspan="5" style="border:none;"> </th> </tr>';

       
        $html .= '<tr>';

  
        $html .= '<th style="color:#0a7b70;background-color:#E0E0E0;">GRAND TOTAL</th> <th>'.$OVERALLGRANDTOTALOFAGENTS.'</th> 
        <th>'.$OVERALLGRANDTOTALOFSALES.'</th>
        
        ';
        
        for ($i = 0; $i < $value; $i++) {
            $html .= '<th></th> <th></th>';       
        }

        $html .= '<th>'.$OVERALLGRANDTOTALMONTHLYAGENT.'</th> <th>'.$OVERALLGRANDTOTALMONTHLYSALES.'</th>';


        $html .= '</tr>';


        $html .= '</tbody>';

        echo json_encode(['card' => $html]);

    }
}
?>
