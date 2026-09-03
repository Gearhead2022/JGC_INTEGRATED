<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../models/connection.php";
$connection = new connection;
$connection->connect();

$filterPensioner= new pensionerTable();

$branchName = $_GET['branchName'];

if ($branchName == 'EMB') {
    $filterPensioner -> showPensionerFilterEMB();
} else if($branchName == 'FCH') {
    $filterPensioner -> showPensionerFilterFCH();
} else if($branchName == 'ELC') {
    $filterPensioner -> showPensionerFilterELC();
} else if($branchName == 'RLC') {
    $filterPensioner -> showPensionerFilterRLC();
}

class pensionerTable{
	public function showPensionerFilterEMB(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branchName = $_GET['branchName'];

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        // $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        $begBalCovered = 'Dec ' . $lastYearDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

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

        $branchName = $_GET['branchName'];

        $data = (new ControllerPensioner)->ctrGetBranchesNames($branchName);
        $data1 = [
            [
                'id' => 58,
                0 => 58,
                'user_id' => 'UI00058',
                1 => 'UI00058'
            ]
        ];


        foreach ($data1 as &$item) {
           
            $item['card'] ='';

            $item['card'] .=' <thead> <tr>         
                <th colspan="5" rowspan="2"></th>
                ';
          
            
                if ($day1_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay1 . '</th>';
                }
                if ($day2_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay2 . '</th>';
                }
                if ($day3_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay3 . '</th>';
                }
                if ($day4_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay4 . '</th>';
                }
                if ($day5_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay5 . '</th>';
                }
        
            // Combine the day headers into the main header
            $item['card'] .='
                         <th class="table-border"> </th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; ">TOTAL</th>
                        
                    </tr> 
                    <tr>
                      ';

                        if ($day1_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">MON</th>';
                        }
                        if ($day2_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">TUE</th>';
                        }
                        if ($day3_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">WED</th>';
                        }
                        if ($day4_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">THU</th>';
                        }
                        if ($day5_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">FRI</th>';
                        }
        
                     
                        $item['card'] .='<th></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;" colspan="2">
                            <span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span>
                        </th>
                        <th ></th>
                        <th style=" text-align: center;">BEG<br>'.$begBalCovered.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>';

  
                        if ($day1_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day2_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day3_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day4_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day5_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
            
        
        
            $item['card'] .='
          
                     <th class="table-border"> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style=" text-align: center; "><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>
                <tr>
                    <td colspan="26"></td>
                </tr>
            </tbody>';
     

        foreach ($data as &$item1) {    
            $branch_name = $item1['branch_name'];

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
            $lastDayOfYear = $lastYearDate . '-12-t';
    
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

            $item['card'] .='
                <tr>
                    <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem;">'.$branch_name.'</th>
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                    <th class="table-border">'.$lastTransactionDataSSS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }

            $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item['card'] .='         
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>           
                </tr>';   
    
            $item['card'] .='<tr>
    
                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                    <th class="table-border">'.$gsis1[2].'</th>
                    <th class="table-border">'.$gsis11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                    <th class="table-border">'.$gsis2[2].'</th>
                    <th class="table-border">'.$gsis22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                    <th class="table-border">'.$gsis3[2].'</th>
                    <th class="table-border">'.$gsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                    <th class="table-border">'.$gsis4[2].'</th>
                    <th class="table-border">'.$gsis44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                    <th class="table-border">'.$gsis5[2].'</th>
                    <th class="table-border">'.$gsis55.'</th>';
                }

                $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item['card'] .= '
              
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
             
            </tr>';   

           
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
            $totalGSISSSGSISINPenOut = (($totalInGSIS + $totalInSSS) - ($totalOutGSIS + $totalOutSSS));
    
            $item['card'] .='  
                <tr>
                <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
                <th class="table-border">'.$totalNewBegBalSSSGSIS.'</th>
                <th class="table-border">'. $totalLastTransactionBalGSISSS.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sssgsis11.'</th>
                    <th class="table-border">'.$sssgsis12.'</th>
                    <th class="table-border">'.$sssgsis13.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sssgsis21.'</th>
                    <th class="table-border">'. $sssgsis22.'</th>
                    <th class="table-border">'.$sssgsis23.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$sssgsis31.'</th>
                    <th class="table-border">'.$sssgsis32.'</th>
                    <th class="table-border">'.$sssgsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$sssgsis41.'</th>
                    <th class="table-border">'.$sssgsis42.'</th>
                    <th class="table-border">'.$sssgsis43.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$sssgsis51.'</th>
                    <th class="table-border">'.$sssgsis52.'</th>
                    <th class="table-border">'.$sssgsis53.'</th>';
                }

            $item['card'] .='
    
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalGSISSSPenIn.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalGSISSSPenOut.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalGSISSSGSISINPenOut.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sssgsis53.'</th>
      
            </tr>';   
    
            $item['card'] .='  
    
            <tr><td colspan="25" class="invisible">d </td></tr>
            ';
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

        }
                
        $item['card'] .='
                <tr>
                <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem; color:gray;">EMB TOTAL</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$totalBeginningBalSSS.'</th>
                <th class="table-border">'.$totalLastTransactionBalSSS.'</th>
            ';

                if ($day1_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay1SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay1SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay1SSS.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay2SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay2SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay2SSS.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '        <th class="table-border">'.$totalPenInDay3SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay3SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay3SSS.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$totalPenInDay4SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay4SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay4SSS.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$totalPenInDay5SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay5SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay5SSS.'</th>';
                }

                $sub_grandTotalPenInSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;
        $item['card'] .='
  
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5SSS.'</th>
            
                </tr>';   
    
                $item['card'] .='   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$totalBeginningBalGSIS.'</th>
                <th class="table-border">'.$totalLastTransactionBalGSIS.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '<th class="table-border">'.$totalPenInDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay1GSIS.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay2GSIS.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay3GSIS.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay4GSIS.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay5GSIS.'</th>';
                }

                $sub_grandTotalPenInGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;

            $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5GSIS.'</th>
    
            </tr>';   
            $totalBeginningBalSSSGSIS = $totalBeginningBalSSS + $totalBeginningBalGSIS;
            $totalLastTransactionBalSSS = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS;

            $totalPenInDay1SSSGSIS = $totalPenInDay1SSS + $totalPenInDay1GSIS;
            $totalPenOutDay1SSSGSIS = $totalPenOutDay1SSS + $totalPenOutDay1GSIS;
            $totalPenNumDay1SSSGSIS = $totalPenNumDay1SSS + $totalPenNumDay1GSIS;

            $totalPenInDay2SSSGSIS = $totalPenInDay2SSS + $totalPenInDay2GSIS;
            $totalPenOutDay2SSSGSIS = $totalPenOutDay2SSS + $totalPenOutDay2GSIS;
            $totalPenNumDay2SSSGSIS = $totalPenNumDay2SSS + $totalPenNumDay2GSIS;

            $totalPenInDay3SSSGSIS = $totalPenInDay3SSS + $totalPenInDay3GSIS;
            $totalPenOutDay3SSSGSIS = $totalPenOutDay3SSS + $totalPenOutDay3GSIS;
            $totalPenNumDay3SSSGSIS = $totalPenNumDay3SSS + $totalPenNumDay3GSIS;

            $totalPenInDay4SSSGSIS = $totalPenInDay4SSS + $totalPenInDay4GSIS;
            $totalPenOutDay4SSSGSIS = $totalPenOutDay4SSS + $totalPenOutDay4GSIS;
            $totalPenNumDay4SSSGSIS = $totalPenNumDay4SSS + $totalPenNumDay4GSIS;

            $totalPenInDay5SSSGSIS = $totalPenInDay5SSS + $totalPenInDay5GSIS;
            $totalPenOutDay5SSSGSIS = $totalPenOutDay5SSS + $totalPenOutDay5GSIS;
            $totalPenNumDay5SSSGSIS = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;

            $item['card'] .='  
            <tr>
                <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
                <th class="table-border">'.$totalBeginningBalSSSGSIS.'</th>
                <th class="table-border">'.$totalLastTransactionBalSSS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay1SSSGSIS.'</th>
                <th class="table-border">'.$totalPenOutDay1SSSGSIS.'</th>
                <th class="table-border">'.$totalPenNumDay1SSSGSIS.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay2SSSGSIS.'</th>
                <th class="table-border">'.$totalPenOutDay2SSSGSIS.'</th>
                <th class="table-border">'.$totalPenNumDay2SSSGSIS.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay3SSSGSIS.'</th>
                <th class="table-border">'.$totalPenOutDay3SSSGSIS.'</th>
                <th class="table-border">'.$totalPenNumDay3SSSGSIS.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4SSSGSIS.'</th>
                <th class="table-border">'.$totalPenOutDay4SSSGSIS.'</th>
                <th class="table-border">'.$totalPenNumDay4SSSGSIS.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay5SSSGSIS.'</th>
                <th class="table-border">'.$totalPenOutDay5SSSGSIS.'</th>
                <th class="table-border">'.$totalPenNumDay5SSSGSIS.'</th>';
            }

            $add_grandTotalPenInSSSGSIS = $grandTotalPenInSSS + $grandTotalPenInGSIS;
            $add_grandTotalPenOutSSSGSIS = $grandTotalPenOutSSS + $grandTotalPenOutGSIS;
            $sub_grandTotalPenOutSSSGSIS = (($grandTotalPenInSSS + $grandTotalPenInGSIS) - ($grandTotalPenOutSSS + $grandTotalPenOutGSIS));
            $add_totalPenNumDay5SSS = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;

            $item['card'] .='

                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$add_grandTotalPenInSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$add_grandTotalPenOutSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenOutSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$add_totalPenNumDay5SSS.'</th>

            </tr>';   
    
            $item['card'] .='  

            <tr><td colspan="25" class="invisible">d </td></tr>
                ';

        }
        echo json_encode($data1);  
    }

    public function showPensionerFilterFCH(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branchName = $_GET['branchName'];

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        // $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

            $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
            $begBalCovered = 'Dec ' . $lastYearDate;
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

        $data = (new ControllerPensioner)->ctrGetBranchesNames($branchName);
        $data1 = [
            [
                'id' => 58,
                0 => 58,
                'user_id' => 'UI00058',
                1 => 'UI00058'
            ]
        ];


        foreach ($data1 as &$item) {
           
            $item['card'] ='';

            $item['card'] .=' <thead> <tr>         
                <th colspan="5" rowspan="2"></th>
                ';
          
            
                if ($day1_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay1 . '</th>';
                }
                if ($day2_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay2 . '</th>';
                }
                if ($day3_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay3 . '</th>';
                }
                if ($day4_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay4 . '</th>';
                }
                if ($day5_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay5 . '</th>';
                }
        
            // Combine the day headers into the main header
            $item['card'] .='
                         <th class="table-border"> </th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; ">TOTAL</th>
                        
                    </tr> 
                    <tr>
                      ';

                        if ($day1_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">MON</th>';
                        }
                        if ($day2_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">TUE</th>';
                        }
                        if ($day3_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">WED</th>';
                        }
                        if ($day4_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">THU</th>';
                        }
                        if ($day5_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">FRI</th>';
                        }
        
                $item['card'] .='<th></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;" colspan="2">
                            <span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span>
                        </th>
                        <th ></th>
                        <th style=" text-align: center;">BEG<br>'.$begBalCovered.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>';

  
                        if ($day1_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day2_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day3_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day4_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day5_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
            
            $item['card'] .='
          
                     <th class="table-border"> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style=" text-align: center; "><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>';   
    
                $item['card'] .='
                <tr>
                    <td colspan="26"></td>
                </tr>
            </tbody>';

        foreach ($data as &$item1) {    
            $branch_name = $item1['branch_name'];

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
            $lastDayOfYear = $lastYearDate . '-12-t';
    
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
    
            $item['card'] .='
            <tr>
                <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem;">'.$branch_name.'</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                <th class="table-border">'.$lastTransactionDataSSS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                <th class="table-border">'.$sss1[2].'</th>
                <th class="table-border">'.$sss11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                <th class="table-border">'.$sss2[2].'</th>
                <th class="table-border">'.$sss22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                <th class="table-border">'.$sss3[2].'</th>
                <th class="table-border">'.$sss33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                <th class="table-border">'.$sss4[2].'</th>
                <th class="table-border">'.$sss44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                <th class="table-border">'.$sss5[2].'</th>
                <th class="table-border">'.$sss55.'</th>';
            }

            $sub_totalSSS = $totalInSSS - $totalOutSSS;

            $item['card'] .='
           
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
               
            </tr>';   
    
            $item['card'] .='   

            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
            <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
            <th class="table-border">'.$lastTransactionDataGSIS.'</th>
        ';

        if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }

            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item['card'] .= '
            
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
            </tr>';   

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

            $item['card'] .='  
    
            <tr>
                <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
                <th class="table-border">'.$totalNewBegBalSSSGSIS.'</th>
                <th class="table-border">'.$totalLastTransactionBalGSISSS.'</th>
            ';
           
                if ($day1_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sssgsis11.'</th>
                    <th class="table-border">'.$sssgsis12.'</th>
                    <th class="table-border">'.$sssgsis13.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sssgsis21.'</th>
                    <th class="table-border">'.$sssgsis22.'</th>
                    <th class="table-border">'.$sssgsis23.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$sssgsis31.'</th>
                    <th class="table-border">'.$sssgsis32.'</th>
                    <th class="table-border">'.$sssgsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$sssgsis41.'</th>
                    <th class="table-border">'.$sssgsis42.'</th>
                    <th class="table-border">'.$sssgsis43.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$sssgsis51.'</th>
                    <th class="table-border">'.$sssgsis52.'</th>
                    <th class="table-border">'.$sssgsis53.'</th>';
                }

                $sub_totalInGSISSSS = $totalInSSS + $totalInGSIS;
                $sub_totalOutGSISSSS = $totalOutGSIS + $totalOutSSS;
                $add_sub_InOutSSSGSIS = (($totalInGSIS + $totalInSSS) - ($totalOutGSIS + $totalOutSSS));
                $sssgsis = $sss55 + $gsis55;


            $item['card'] .='
     
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalInGSISSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOutGSISSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$add_sub_InOutSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sssgsis.'</th>
      
            </tr>';   
    
            $item['card'] .='  
    
            <tr><td colspan="25" class="invisible">d </td></tr>
            ';
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

        }
                
        $item['card'] .='
                <tr>
                <th colspan="2" rowspan="3" style="text-align:center;padding:5rem 1rem; color:gray;">FCH TOTAL</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$totalBeginningBalSSS.'</th>
                <th class="table-border">'.$totalLastTransactionBalSSS.'</th>
            ';

                if ($day1_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay1SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay1SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay1SSS.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay2SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay2SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay2SSS.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '        <th class="table-border">'.$totalPenInDay3SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay3SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay3SSS.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$totalPenInDay4SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay4SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay4SSS.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$totalPenInDay5SSS.'</th>
                    <th class="table-border">'.$totalPenOutDay5SSS.'</th>
                    <th class="table-border">'.$totalPenNumDay5SSS.'</th>';
                }

                $grandTotalPenInOutSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;
            $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5SSS.'</th>
            
                </tr>';   
    
                $item['card'] .='   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$totalBeginningBalGSIS.'</th>
                <th class="table-border">'.$totalLastTransactionBalGSIS.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '<th class="table-border">'.$totalPenInDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay1GSIS.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay2GSIS.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay3GSIS.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay4GSIS.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay5GSIS.'</th>';
                }

                $grandTotalPenInOutGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;
            $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInGSIS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutGSIS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutGSIS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5GSIS.'</th>

            </tr> ';   
    
            $totalTotalBal = $totalBeginningBalSSS + $totalBeginningBalGSIS;
            $totalLastTransactionBal = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS;
            
            $item['card'] .= '
                <tr>
                    <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
                    <th class="table-border">' . $totalTotalBal . '</th>
                    <th class="table-border">' . $totalLastTransactionBal . '</th>
            ';
            
            if ($day1_param > 0) {
                $totalPenInDay1 = $totalPenInDay1SSS + $totalPenInDay1GSIS;
                $totalPenOutDay1 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS;
                $totalPenNumDay1 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS;
            
                $item['card'] .= '  
                    <th class="table-border">' . $totalPenInDay1 . '</th>
                    <th class="table-border">' . $totalPenOutDay1 . '</th>
                    <th class="table-border">' . $totalPenNumDay1 . '</th>';
            }
            
            if ($day2_param > 0) {
                $totalPenInDay2 = $totalPenInDay2SSS + $totalPenInDay2GSIS;
                $totalPenOutDay2 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS;
                $totalPenNumDay2 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay2 . '</th>
                    <th class="table-border">' . $totalPenOutDay2 . '</th>
                    <th class="table-border">' . $totalPenNumDay2 . '</th>';
            }

            if ($day3_param > 0) {
                $totalPenInDay3 = $totalPenInDay3SSS + $totalPenInDay3GSIS;
                $totalPenOutDay3 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS;
                $totalPenNumDay3 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay3 . '</th>
                    <th class="table-border">' . $totalPenOutDay3 . '</th>
                    <th class="table-border">' . $totalPenNumDay3 . '</th>';
            }

            if ($day4_param > 0) {
                $totalPenInDay4 = $totalPenInDay4SSS + $totalPenInDay4GSIS;
                $totalPenOutDay4 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS;
                $totalPenNumDay4 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay4 . '</th>
                    <th class="table-border">' . $totalPenOutDay4 . '</th>
                    <th class="table-border">' . $totalPenNumDay4 . '</th>';
            }

            if ($day5_param > 0) {
                $totalPenInDay5 = $totalPenInDay5SSS + $totalPenInDay5GSIS;
                $totalPenOutDay5 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS;
                $totalPenNumDay5 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay5 . '</th>
                    <th class="table-border">' . $totalPenOutDay5 . '</th>
                    <th class="table-border">' . $totalPenNumDay5 . '</th>';
            }

            $sub_grandTotalPenInSSSGSIS = $grandTotalPenInSSS + $grandTotalPenInGSIS;
            $sub_grandTotalPenOutSSSGSIS = $grandTotalPenOutSSS + $grandTotalPenOutGSIS;
            $sub_grandTotalPenTotal = $totalPenNumDay5SSS + $totalPenNumDay5GSIS;

            $sub_grandTotalPenINOUT = (($grandTotalPenInSSS + $grandTotalPenInGSIS) - ($grandTotalPenOutSSS + $grandTotalPenOutGSIS));

            $item['card'] .='

                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenOutSSSGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenINOUT.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenTotal.'</th>

            </tr>';   
    
            $item['card'] .='  


            <tr><td colspan="25" class="invisible">d </td></tr>
        ';
        }
    
        echo json_encode($data1);  
    }

    public function showPensionerFilterELC(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branchName = $_GET['branchName'];

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        // $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;

            $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
            $begBalCovered = 'Dec ' . $lastYearDate;
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

         //PACERS

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

        $data = (new ControllerPensioner)->ctrGetBranchesNames($branchName);
        $data1 = [
            [
                'id' => 58,
                0 => 58,
                'user_id' => 'UI00058',
                1 => 'UI00058'
            ]
        ];


        foreach ($data1 as &$item) {
           
            $item['card'] ='';

            $item['card'] .=' <thead> <tr>         
                <th colspan="5" rowspan="2"></th>
                ';
          
            
                if ($day1_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay1 . '</th>';
                }
                if ($day2_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay2 . '</th>';
                }
                if ($day3_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay3 . '</th>';
                }
                if ($day4_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay4 . '</th>';
                }
                if ($day5_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay5 . '</th>';
                }
        
            // Combine the day headers into the main header
            $item['card'] .='
                         <th class="table-border"> </th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; ">TOTAL</th>
                        
                    </tr> 
                    <tr>
                      ';

                        if ($day1_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">MON</th>';
                        }
                        if ($day2_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">TUE</th>';
                        }
                        if ($day3_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">WED</th>';
                        }
                        if ($day4_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">THU</th>';
                        }
                        if ($day5_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">FRI</th>';
                        }
        
                     
                        $item['card'] .='<th></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;" colspan="2">
                            <span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span>
                        </th>
                        <th ></th>
                        <th style=" text-align: center;">BEG<br>'.$begBalCovered.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>';

  
                        if ($day1_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day2_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day3_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day4_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day5_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
            
        
        
            $item['card'] .='
          
                     <th class="table-border"> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style=" text-align: center; "><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>
                ';   
    
                  $item['card'] .='
                <tr>
                    <td colspan="26"></td>
                </tr>
            </tbody>';


        foreach ($data as &$item1) {    
            $branch_name = $item1['branch_name'];

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


            $firstDayOfYear = '1990-01-01';
            $lastDayOfYear = $lastYearDate . '-12-t';
    
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
    
     
            $item['card'] .='
            <tr>
                <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem;">'.$branch_name.'</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                <th class="table-border">'.$lastTransactionDataSSS.'</th>
        ';

        if ($day1_param > 0) {
            $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
            <th class="table-border">'.$sss1[2].'</th>
            <th class="table-border">'.$sss11.'</th>';
        }
        if ($day2_param > 0) {
            $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
            <th class="table-border">'.$sss2[2].'</th>
            <th class="table-border">'.$sss22.'</th>';
        }
        if ($day3_param > 0) {
            $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
            <th class="table-border">'.$sss3[2].'</th>
            <th class="table-border">'.$sss33.'</th>';
        }
        if ($day4_param > 0) {
            $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
            <th class="table-border">'.$sss4[2].'</th>
            <th class="table-border">'.$sss44.'</th>';
        }
        if ($day5_param > 0) {
            $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
            <th class="table-border">'.$sss5[2].'</th>
            <th class="table-border">'.$sss55.'</th>';
        }

        $sub_totalSSS = $totalInSSS - $totalOutSSS;

        $item['card'] .='
           
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
               
            </tr> 
            ';   
    
                  $item['card'] .='  

            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
            <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
            <th class="table-border">'.$lastTransactionDataGSIS.'</th>
        ';

        if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                <th class="table-border">'.$gsis1[2].'</th>
                <th class="table-border">'.$gsis11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                <th class="table-border">'.$gsis2[2].'</th>
                <th class="table-border">'.$gsis22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                <th class="table-border">'.$gsis3[2].'</th>
                <th class="table-border">'.$gsis33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                <th class="table-border">'.$gsis4[2].'</th>
                <th class="table-border">'.$gsis44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                <th class="table-border">'.$gsis5[2].'</th>
                <th class="table-border">'.$gsis55.'</th>';
            }
            $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

            $item['card'] .= '
            
                 <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
            
            </tr>';   
    
            $item['card'] .='  
    
            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PACERS</th>
            <th class="table-border">'.$newBegBalValuePACERS[0].'</th>
            <th class="table-border">'.$lastTransactionDataPACERS.'</th>
        ';

        if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$pacers1[1].'</th>
                <th class="table-border">'.$pacers1[2].'</th>
                <th class="table-border">'.$pacers11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$pacers2[1].'</th>
                <th class="table-border">'.$pacers2[2].'</th>
                <th class="table-border">'.$pacers22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$pacers3[1].'</th>
                <th class="table-border">'.$pacers3[2].'</th>
                <th class="table-border">'.$pacers33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$pacers4[1].'</th>
                <th class="table-border">'.$pacers4[2].'</th>
                <th class="table-border">'.$pacers44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$pacers5[1].'</th>
                <th class="table-border">'.$pacers5[2].'</th>
                <th class="table-border">'.$pacers55.'</th>';
            }

            $sub_totalPACERS = $totalInPACERS - $totalOutPACERS;

            $item['card'] .= '
            
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPACERS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPACERS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPACERS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pacers55.'</th>
            
            </tr>';   
    
            $item['card'] .='  

            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
            <th class="table-border">'.$lastTransactionDataPVAO.'</th>
        ';

        if ($day1_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                <th class="table-border">'.$pvao1[2].'</th>
                <th class="table-border">'.$pvao11.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$pvao2[1].'</th>
                <th class="table-border">'.$pvao2[2].'</th>
                <th class="table-border">'.$pvao22.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$pvao3[1].'</th>
                <th class="table-border">'.$pvao3[2].'</th>
                <th class="table-border">'.$pvao33.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$pvao4[1].'</th>
                <th class="table-border">'.$pvao4[2].'</th>
                <th class="table-border">'.$pvao44.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$pvao5[1].'</th>
                <th class="table-border">'.$pvao5[2].'</th>
                <th class="table-border">'.$pvao55.'</th>';
            }

            $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

            $item['card'] .= '
            
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
            
            </tr>';   
    
            $totalTotalBal = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePACERS[0] + $newBegBalValuePVAO[0];
            $totalLastTransactionBal = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPACERS + $lastTransactionDataPVAO;
            
            $item['card'] .= '
                <tr>
                    <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                    <th class="table-border">' . $totalTotalBal . '</th>
                    <th class="table-border">' . $totalLastTransactionBal . '</th>
            ';
            
            if ($day1_param > 0) {
                $totalPenInDay1 = $sss1[1] + $gsis1[1] + $pacers1[1] + $pvao1[1];
                $totalPenOutDay1 = $sss1[2] + $gsis1[2] + $pacers1[2] + $pvao1[2];
                $totalPenNumDay1 = $sss11 + $gsis11 + $pacers11 + $pvao11;
            
                $item['card'] .= '  
                    <th class="table-border">' . $totalPenInDay1 . '</th>
                    <th class="table-border">' . $totalPenOutDay1 . '</th>
                    <th class="table-border">' . $totalPenNumDay1 . '</th>';
            }
            
            if ($day2_param > 0) {
                $totalPenInDay2 = $sss2[1] + $gsis2[1] + $pacers1[1] + $pvao1[1];
                $totalPenOutDay2 = $sss2[2] + $gsis2[2] + $pacers1[2] + $pvao1[2];
                $totalPenNumDay2 = $sss22 + $gsis22 + $pacers22 + $pvao22;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay2 . '</th>
                    <th class="table-border">' . $totalPenOutDay2 . '</th>
                    <th class="table-border">' . $totalPenNumDay2 . '</th>';
            }

            if ($day3_param > 0) {
                $totalPenInDay3 = $sss3[1] + $gsis3[1] + $pacers1[1] + $pvao1[1];
                $totalPenOutDay3 = $sss3[3] + $gsis3[3] + $pacers1[3] + $pvao1[3];
                $totalPenNumDay3 = $sss33 + $gsis33 + $pacers33 + $pvao33;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay3 . '</th>
                    <th class="table-border">' . $totalPenOutDay3 . '</th>
                    <th class="table-border">' . $totalPenNumDay3 . '</th>';
            }

            if ($day4_param > 0) {
                $totalPenInDay4 = $sss4[1] + $gsis4[1] + $pacers1[1] + $pvao1[1];
                $totalPenOutDay4 = $sss4[4] + $gsis4[4] + $pacers1[4] + $pvao1[4];
                $totalPenNumDay4 = $sss44 + $gsis44 + $pacers44 + $pvao44;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay4 . '</th>
                    <th class="table-border">' . $totalPenOutDay4 . '</th>
                    <th class="table-border">' . $totalPenNumDay4 . '</th>';
            }

            if ($day5_param > 0) {
                $totalPenInDay5 = $sss5[1] + $gsis5[1] + $pacers1[1] + $pvao1[1];
                $totalPenOutDay5 = $sss5[5] + $gsis5[5] + $pacers1[5] + $pvao1[5];
                $totalPenNumDay5 = $sss55 + $gsis55 + $pacers55 + $pvao55;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay5 . '</th>
                    <th class="table-border">' . $totalPenOutDay5 . '</th>
                    <th class="table-border">' . $totalPenNumDay5 . '</th>';
            }
            
            $totalTotalIn = $totalInGSIS + $totalInSSS + $totalInPACERS + $totalInPVAO;
            $totalTotalOut = $totalOutGSIS + $totalOutSSS + $totalOutPACERS + $totalOutPVAO;
            $totalNetTotal = $totalTotalIn - $totalTotalOut;
            $totalSSSAndGSIS = $sss55 + $gsis55 + $pacers55 + $pvao55;
            
            $item['card'] .= '
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalIn . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalOut . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalNetTotal . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalSSSAndGSIS . '</th>
            </tr>';
    
            $item['card'] .='  
    
            <tr><td colspan="25" class="invisible">d </td></tr>
            ';
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

        }
                
            $item['card'] .='
            <tr>
                <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem; color:gray;">ELC TOTAL</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$totalBeginningBalSSS.'</th>
                <th class="table-border">'.$totalLastTransactionBalSSS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay1SSS.'</th>
                <th class="table-border">'.$totalPenOutDay1SSS.'</th>
                <th class="table-border">'.$totalPenNumDay1SSS.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2SSS.'</th>
                <th class="table-border">'.$totalPenOutDay2SSS.'</th>
                <th class="table-border">'.$totalPenNumDay2SSS.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '        <th class="table-border">'.$totalPenInDay3SSS.'</th>
                <th class="table-border">'.$totalPenOutDay3SSS.'</th>
                <th class="table-border">'.$totalPenNumDay3SSS.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$totalPenInDay4SSS.'</th>
                <th class="table-border">'.$totalPenOutDay4SSS.'</th>
                <th class="table-border">'.$totalPenNumDay4SSS.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= ' <th class="table-border">'.$totalPenInDay5SSS.'</th>
                <th class="table-border">'.$totalPenOutDay5SSS.'</th>
                <th class="table-border">'.$totalPenNumDay5SSS.'</th>';
            }

            $sub_grandTotalPenInOutSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;
        $item['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInSSS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutSSS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInOutSSS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5SSS.'</th>
        
            </tr>';   
    
            $item['card'] .='   

            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
            <th class="table-border">'.$totalBeginningBalGSIS.'</th>
            <th class="table-border">'.$totalLastTransactionBalGSIS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '<th class="table-border">'.$totalPenInDay1GSIS.'</th>
                <th class="table-border">'.$totalPenOutDay1GSIS.'</th>
                <th class="table-border">'.$totalPenNumDay1GSIS.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay2GSIS.'</th>
                <th class="table-border">'.$totalPenOutDay2GSIS.'</th>
                <th class="table-border">'.$totalPenNumDay2GSIS.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay3GSIS.'</th>
                <th class="table-border">'.$totalPenOutDay3GSIS.'</th>
                <th class="table-border">'.$totalPenNumDay3GSIS.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4GSIS.'</th>
                <th class="table-border">'.$totalPenOutDay4GSIS.'</th>
                <th class="table-border">'.$totalPenNumDay4GSIS.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay5GSIS.'</th>
                <th class="table-border">'.$totalPenOutDay5GSIS.'</th>
                <th class="table-border">'.$totalPenNumDay5GSIS.'</th>';
            }

            $sub_grandTotalPenInOutGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;

            $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5GSIS.'</th>

            </tr>';   
        
            $item['card'] .='  
            <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PACERS</th>
            <th class="table-border">'.$totalBeginningBalPACERS.'</th>
            <th class="table-border">'.$totalLastTransactionBalPACERS.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '<th class="table-border">'.$totalPenInDay1PACERS.'</th>
                <th class="table-border">'.$totalPenOutDay1PACERS.'</th>
                <th class="table-border">'.$totalPenNumDay1PACERS.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay2PACERS.'</th>
                <th class="table-border">'.$totalPenOutDay2PACERS.'</th>
                <th class="table-border">'.$totalPenNumDay2PACERS.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay3PACERS.'</th>
                <th class="table-border">'.$totalPenOutDay3PACERS.'</th>
                <th class="table-border">'.$totalPenNumDay3PACERS.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4PACERS.'</th>
                <th class="table-border">'.$totalPenOutDay4PACERS.'</th>
                <th class="table-border">'.$totalPenNumDay4PACERS.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay5PACERS.'</th>
                <th class="table-border">'.$totalPenOutDay5PACERS.'</th>
                <th class="table-border">'.$totalPenNumDay5PACERS.'</th>';
            }

            $sub_grandTotalPenInOutPACERS = $grandTotalPenInPACERS - $grandTotalPenOutPACERS;

        $item['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInPACERS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutPACERS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInOutPACERS.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5PACERS.'</th>

        </tr>';   
    
        $item['card'] .=' 
        <tr>

            <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">PVAO</th>
            <th class="table-border">'.$totalBeginningBalPVAO.'</th>
            <th class="table-border">'.$totalLastTransactionBalPVAO.'</th>
            ';

            if ($day1_param > 0) {
                $item['card'] .= '<th class="table-border">'.$totalPenInDay1PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay1PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay1PVAO.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay2PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay2PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay2PVAO.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay3PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay3PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay3PVAO.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay4PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay4PVAO.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay5PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay5PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay5PVAO.'</th>';
            }

            $sub_grandTotalPenInOutPVAO = $grandTotalPenInPVAO - $grandTotalPenOutPVAO;
        $item['card'] .='

            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInPVAO.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutPVAO.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_grandTotalPenInOutPVAO.'</th>
            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5PVAO.'</th>

        </tr>';   
        $totalTotalBal = $totalBeginningBalSSS + $totalBeginningBalGSIS + $totalBeginningBalPACERS + $totalBeginningBalPVAO;
        $totalLastTransactionBal = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS + $totalLastTransactionBalPACERS + $totalLastTransactionBalPVAO;
        
        $item['card'] .= '
            <tr>
                <th class="table-border" style="padding:1.2rem 1.5rem;">TOTAL</th>
                <th class="table-border">' . $totalTotalBal . '</th>
                <th class="table-border">' . $totalLastTransactionBal . '</th>
        ';
        
        if ($day1_param > 0) {
            $totalPenInDay1 = $totalPenInDay1SSS + $totalPenInDay1GSIS + $totalPenInDay1PACERS + $totalPenInDay1PVAO;
            $totalPenOutDay1 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS + $totalPenOutDay1PACERS + $totalPenOutDay1PVAO;
            $totalPenNumDay1 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS + $totalPenNumDay1PACERS + $totalPenNumDay1PVAO;
        
            $item['card'] .= '  
                <th class="table-border">' . $totalPenInDay1 . '</th>
                <th class="table-border">' . $totalPenOutDay1 . '</th>
                <th class="table-border">' . $totalPenNumDay1 . '</th>';
        }
        
        if ($day2_param > 0) {
            $totalPenInDay2 = $totalPenInDay2SSS + $totalPenInDay2GSIS + $totalPenInDay2PACERS + $totalPenInDay2PVAO;
            $totalPenOutDay2 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS + $totalPenOutDay2PACERS + $totalPenOutDay2PVAO;
            $totalPenNumDay2 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS + $totalPenNumDay2PACERS + $totalPenNumDay2PVAO;
        
            $item['card'] .= ' 
                <th class="table-border">' . $totalPenInDay2 . '</th>
                <th class="table-border">' . $totalPenOutDay2 . '</th>
                <th class="table-border">' . $totalPenNumDay2 . '</th>';
        }

        if ($day3_param > 0) {
            $totalPenInDay3 = $totalPenInDay3SSS + $totalPenInDay3GSIS + $totalPenInDay3PACERS + $totalPenInDay3PVAO;
            $totalPenOutDay3 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS + $totalPenOutDay3PACERS + $totalPenOutDay3PVAO;
            $totalPenNumDay3 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS + $totalPenNumDay3PACERS + $totalPenNumDay3PVAO;
        
            $item['card'] .= ' 
                <th class="table-border">' . $totalPenInDay3 . '</th>
                <th class="table-border">' . $totalPenOutDay3 . '</th>
                <th class="table-border">' . $totalPenNumDay3 . '</th>';
        }

        if ($day4_param > 0) {
            $totalPenInDay4 = $totalPenInDay4SSS + $totalPenInDay4GSIS + $totalPenInDay4PACERS + $totalPenInDay4PVAO;
            $totalPenOutDay4 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS + $totalPenOutDay4PACERS + $totalPenOutDay4PVAO;
            $totalPenNumDay4 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS + $totalPenNumDay4PACERS + $totalPenNumDay4PVAO;
        
            $item['card'] .= ' 
                <th class="table-border">' . $totalPenInDay4 . '</th>
                <th class="table-border">' . $totalPenOutDay4 . '</th>
                <th class="table-border">' . $totalPenNumDay4 . '</th>';
        }

        if ($day5_param > 0) {
            $totalPenInDay5 = $totalPenInDay5SSS + $totalPenInDay5GSIS + $totalPenInDay5PACERS + $totalPenInDay5PVAO;
            $totalPenOutDay5 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS + $totalPenOutDay5PACERS + $totalPenOutDay5PVAO;
            $totalPenNumDay5 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PACERS + $totalPenNumDay5PVAO;
        
            $item['card'] .= ' 
                <th class="table-border">' . $totalPenInDay5 . '</th>
                <th class="table-border">' . $totalPenOutDay5 . '</th>
                <th class="table-border">' . $totalPenNumDay5 . '</th>';
        }
        
        // Repeat the same pattern for day3, day4, and day5 as needed.
        
        $totalTotalPenIn = $grandTotalPenInSSS + $grandTotalPenInGSIS + $grandTotalPenInPACERS + $grandTotalPenInPVAO;
        $totalTotalPenOut = $grandTotalPenOutSSS + $grandTotalPenOutGSIS + $grandTotalPenOutPACERS + $grandTotalPenOutPVAO;
        $totalNetTotalPen = $totalTotalPenIn - $totalTotalPenOut;
        $totalTotalPenNum = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PACERS + $totalPenNumDay5PVAO;
        
        $item['card'] .= '
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalPenIn . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalPenOut . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalNetTotalPen . '</th>
            <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalPenNum . '</th>
        </tr>';
            $item['card'] .='  

            <tr><td colspan="25" class="invisible">d </td></tr>
                ';

        }
        echo json_encode($data1);  
    }

    public function showPensionerFilterRLC(){
 
        $weekfrom = $_GET['penDateFrom'];
        $weekto = $_GET['penDateTo'];
        // $penBegBal = $_GET['penBegBal'];
        $branchName = $_GET['branchName'];

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
        // $branch_name = $_SESSION['branch_name'];
        $startDate = new DateTime($weekfrom);
        $endDate = new DateTime($weekto);   
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
         }
            $day1 = isset($dateRange[0]) ? $dateRange[0] : null;
            $day2 = isset($dateRange[1]) ? $dateRange[1] : null;
            $day3 = isset($dateRange[2]) ? $dateRange[2] : null;
            $day4 = isset($dateRange[3]) ? $dateRange[3] : null;
            $day5 = isset($dateRange[4]) ? $dateRange[4] : null;

            $day1_param = isset($dateRange[0]) ? $dateRange[0] : 0;
            $day2_param = isset($dateRange[1]) ? $dateRange[1] : 0;
            $day3_param = isset($dateRange[2]) ? $dateRange[2] : 0;
            $day4_param = isset($dateRange[3]) ? $dateRange[3] : 0;
            $day5_param = isset($dateRange[4]) ? $dateRange[4] : 0;
            $lastYearDate = date('Y', strtotime('-1 year', strtotime($weekfrom))); //get last year
            $begBalCovered = 'Dec ' . $lastYearDate;
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

        $data = (new ControllerPensioner)->ctrGetBranchesNames($branchName);
        $data1 = [
            [
                'id' => 58,
                0 => 58,
                'user_id' => 'UI00058',
                1 => 'UI00058'
            ]
        ];

        foreach ($data1 as &$item) {
           
            $item['card'] ='';

            $item['card'] .=' <thead> <tr>         
                <th colspan="5" rowspan="2"></th>
                ';
          
                if ($day1_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay1 . '</th>';
                }
                if ($day2_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay2 . '</th>';
                }
                if ($day3_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay3 . '</th>';
                }
                if ($day4_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay4 . '</th>';
                }
                if ($day5_param > 0) {
                      $item['card'] .='<th style="text-align:center;" colspan="3">' . $formattedDay5 . '</th>';
                }
        
            // Combine the day headers into the main header
            $item['card'] .='
                         <th class="table-border"> </th>
                        <th class="table-border" colspan="4" rowspan="2" style="padding:1.5rem;text-align:center; ">TOTAL</th> 
                    </tr> 
                    <tr>
                      ';

                        if ($day1_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">MON</th>';
                        }
                        if ($day2_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">TUE</th>';
                        }
                        if ($day3_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">WED</th>';
                        }
                        if ($day4_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">THU</th>';
                        }
                        if ($day5_param > 0) {
                            $item['card'] .='<th style="text-align:center; " colspan="3">FRI</th>';
                        }
        
                        $item['card'] .='<th></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;" colspan="2">
                            <span style="padding: 1rem 1rem"></span><br>BRANCH<br><span style="padding: 1rem 1rem"></span>
                        </th>
                        <th ></th>
                        <th style=" text-align: center;">BEG<br>'.$begBalCovered.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>BEG</th>';

  
                        if ($day1_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day2_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day3_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day4_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
                        if ($day5_param > 0) {
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>';
                             $item['card'] .='<th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>';
                             $item['card'] .=' <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>End. bal</th>';
                        }
            
            $item['card'] .='
          
                     <th class="table-border"> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>In</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Out</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>Net</th>
                    <th style=" text-align: center; "><span style="padding: 1rem 1rem"></span><br>BALANCE</th>
                </tr>';   
    
                $item['card'] .='
                <tr>
                    <td colspan="26"></td>
                </tr>
            </tbody>';
     


        foreach ($data as &$item1) {    
            $branch_name = $item1['branch_name'];

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

            $firstDayOfYear = '1990-01-01';
            $lastDayOfYear = $lastYearDate . '-12-t';
    
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
                 
                $item['card'] .='
                <tr>
                    <th colspan="2" rowspan="8" style="text-align:center;padding:15rem 1rem;">'.$branch_name.'</th>
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                    <th class="table-border">'.$lastTransactionDataSSS.'</th>
                    ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                    <th class="table-border">'.$sss1[2].'</th>
                    <th class="table-border">'.$sss11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                    <th class="table-border">'.$sss2[2].'</th>
                    <th class="table-border">'.$sss22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                    <th class="table-border">'.$sss3[2].'</th>
                    <th class="table-border">'.$sss33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                    <th class="table-border">'.$sss4[2].'</th>
                    <th class="table-border">'.$sss44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                    <th class="table-border">'.$sss5[2].'</th>
                    <th class="table-border">'.$sss55.'</th>';
                }

                $sub_totalSSS = $totalInSSS - $totalOutSSS;

                $item['card'] .='
                
                        <th style="width: 10px;"> </th>
                        <th class="table-border">'.$totalInSSS.'</th>
                        <th class="table-border">'.$totalOutSSS.'</th>
                        <th class="table-border">'.$sub_totalSSS.'</th>
                        <th class="table-border">'.$sss55.'</th>
                    
                    </tr> ';   
    
                    $item['card'] .='  

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                    <th class="table-border">'.$gsis1[2].'</th>
                    <th class="table-border">'.$gsis11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                    <th class="table-border">'.$gsis2[2].'</th>
                    <th class="table-border">'.$gsis22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                    <th class="table-border">'.$gsis3[2].'</th>
                    <th class="table-border">'.$gsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                    <th class="table-border">'.$gsis4[2].'</th>
                    <th class="table-border">'.$gsis44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                    <th class="table-border">'.$gsis5[2].'</th>
                    <th class="table-border">'.$gsis55.'</th>';
                }
                $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

                $item['card'] .= '
                
                     <th class="table-border"> </th>
                    <th class="table-border">'.$totalInGSIS.'</th>
                    <th class="table-border">'.$totalOutGSIS.'</th>
                    <th class="table-border">'.$sub_totalGSIS.'</th>
                    <th class="table-border">'.$gsis55.'</th>
                
                </tr>';   
    
                $item['card'] .=' 
                
                <tr>
              
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PVAO</th>
                    <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
                    <th class="table-border">'.$lastTransactionDataPVAO.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                        <th class="table-border">'.$pvao1[2].'</th>
                        <th class="table-border">'.$pvao11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pvao2[1].'</th>
                        <th class="table-border">'.$pvao2[2].'</th>
                        <th class="table-border">'.$pvao22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pvao3[1].'</th>
                        <th class="table-border">'.$pvao3[2].'</th>
                        <th class="table-border">'.$pvao33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pvao4[1].'</th>
                        <th class="table-border">'.$pvao4[2].'</th>
                        <th class="table-border">'.$pvao44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pvao5[1].'</th>
                        <th class="table-border">'.$pvao5[2].'</th>
                        <th class="table-border">'.$pvao55.'</th>';
                    }

                    $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
                    
                </tr>';   
    
                $item['card'] .='   
                <tr>
                  
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PNP</th>
                    <th class="table-border">'.$newBegBalValuePNP[0].'</th>
                    <th class="table-border">'.$lastTransactionDataPNP.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                        <th class="table-border">'.$pnp1[2].'</th>
                        <th class="table-border">'.$pnp11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                        <th class="table-border">'.$pnp2[2].'</th>
                        <th class="table-border">'.$pnp22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pnp3[1].'</th>
                        <th class="table-border">'.$pnp3[2].'</th>
                        <th class="table-border">'.$pnp33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pnp4[1].'</th>
                        <th class="table-border">'.$pnp4[2].'</th>
                        <th class="table-border">'.$pnp44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                        <th class="table-border">'.$pnp5[2].'</th>
                        <th class="table-border">'.$pnp55.'</th>';
                    }

                    $sub_totalPNP = $totalInPNP - $totalOutPNP;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>
                    
                </tr>';   
    
                $item['card'] .='   
                <tr>
                  
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR</th>
                    <th class="table-border">'.$newBegBalValueOLR[0].'</th>
                    <th class="table-border">'.$lastTransactionDataOLR.'</th>
                ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr1[1].'</th>
                        <th class="table-border">'.$olr1[2].'</th>
                        <th class="table-border">'.$olr11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr2[1].'</th>
                        <th class="table-border">'.$olr2[2].'</th>
                        <th class="table-border">'.$olr22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr3[1].'</th>
                        <th class="table-border">'.$olr3[2].'</th>
                        <th class="table-border">'.$olr33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr4[1].'</th>
                        <th class="table-border">'.$olr4[2].'</th>
                        <th class="table-border">'.$olr44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr5[1].'</th>
                        <th class="table-border">'.$olr5[2].'</th>
                        <th class="table-border">'.$olr55.'</th>';
                    }

                    $sub_totalOLR = $totalInOLR - $totalOutOLR;

                $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'. $sub_totalOLR.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr55.'</th>
                
                </tr>';   
    
                $item['card'] .='    
                <tr>
                  
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                    <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
                    <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                        <th class="table-border">'.$olr_r_e1[2].'</th>
                        <th class="table-border">'.$olr_r_e11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                        <th class="table-border">'.$olr_r_e2[2].'</th>
                        <th class="table-border">'.$olr_r_e22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_r_e3[1].'</th>
                        <th class="table-border">'.$olr_r_e3[2].'</th>
                        <th class="table-border">'.$olr_r_e33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_r_e4[1].'</th>
                        <th class="table-border">'.$olr_r_e4[2].'</th>
                        <th class="table-border">'.$olr_r_e44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                        <th class="table-border">'.$olr_r_e5[2].'</th>
                        <th class="table-border">'.$olr_r_e55.'</th>';
                    }

                    $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

                    $item['card'] .='
                    
                          <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                          <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
                          <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
                          <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E .'</th>
                          <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>
                    
                    </tr>';   
    
                    $item['card'] .='   
                    <tr>
                    
                        <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-HOUSE LOAN</th>
                        <th class="table-border">'.$newBegBalValueOLR_H_L[0].'</th>
                        <th class="table-border">'.$lastTransactionDataOLR_H_L.'</th>
                        ';

                        if ($day1_param > 0) {
                            $item['card'] .= '  <th class="table-border">'.$olr_h_l1[1].'</th>
                            <th class="table-border">'.$olr_h_l1[2].'</th>
                            <th class="table-border">'.$olr_h_l11.'</th>';
                        }
                        if ($day2_param > 0) {
                            $item['card'] .= '  <th class="table-border">'.$olr_h_l2[1].'</th>
                            <th class="table-border">'.$olr_h_l2[2].'</th>
                            <th class="table-border">'.$olr_h_l22.'</th>';
                        }
                        if ($day3_param > 0) {
                            $item['card'] .= ' <th class="table-border">'.$olr_h_l3[1].'</th>
                            <th class="table-border">'.$olr_h_l3[2].'</th>
                            <th class="table-border">'.$olr_h_l33.'</th>';
                        }
                        if ($day4_param > 0) {
                            $item['card'] .= ' <th class="table-border">'.$olr_h_l4[1].'</th>
                            <th class="table-border">'.$olr_h_l4[2].'</th>
                            <th class="table-border">'.$olr_h_l44.'</th>';
                        }
                        if ($day5_param > 0) {
                            $item['card'] .= '  <th class="table-border">'.$olr_h_l5[1].'</th>
                            <th class="table-border">'.$olr_h_l5[2].'</th>
                            <th class="table-border">'.$olr_h_l55.'</th>';
                        }

                        $sub_totalOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

                    $item['card'] .='
                    
                            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_H_L.'</th>
                            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_H_L.'</th>
                            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_H_L.'</th>
                            <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_h_l55.'</th>
                    
                    </tr>';   
    
                    $totalTotalBal = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
                    $totalLastTransactionBal = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
                    
                    $item['card'] .= '
                        <tr>
                            <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                            <th class="table-border">' . $totalTotalBal . '</th>
                            <th class="table-border">' . $totalLastTransactionBal . '</th>
                    ';
                    
                    if ($day1_param > 0) {
                        $totalPenInDay1 = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
                        $totalPenOutDay1 = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
                        $totalPenNumDay1 = $sss11 + $gsis11 + $pvao11 + $pnp11 + $olr11 + $olr_r_e11 + $olr_h_l11;
                    
                        $item['card'] .= '  
                            <th class="table-border">' . $totalPenInDay1 . '</th>
                            <th class="table-border">' . $totalPenOutDay1 . '</th>
                            <th class="table-border">' . $totalPenNumDay1 . '</th>';
                    }
                    
                    if ($day2_param > 0) {
                        $totalPenInDay2 = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
                        $totalPenOutDay2 = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
                        $totalPenNumDay2 = $sss22 + $gsis22 + $pvao22 + $pnp22 + $olr22 + $olr_r_e22 + $olr_h_l22;
                    
                        $item['card'] .= ' 
                            <th class="table-border">' . $totalPenInDay2 . '</th>
                            <th class="table-border">' . $totalPenOutDay2 . '</th>
                            <th class="table-border">' . $totalPenNumDay2 . '</th>';
                    }

                    if ($day3_param > 0) {
                        $totalPenInDay3 = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
                        $totalPenOutDay3 = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
                        $totalPenNumDay3 = $sss33 + $gsis33 + $pvao33 + $pnp33 + $olr33 + $olr_r_e33 + $olr_h_l33;
                    
                        $item['card'] .= ' 
                            <th class="table-border">' . $totalPenInDay3 . '</th>
                            <th class="table-border">' . $totalPenOutDay3 . '</th>
                            <th class="table-border">' . $totalPenNumDay3 . '</th>';
                    }
                    
                    if ($day4_param > 0) {
                        $totalPenInDay4 = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
                        $totalPenOutDay4 = $sss4[2] + $gsis4[2] + $pvao4[2] + $pnp4[2] + $olr4[2] + $olr_r_e4[2] + $olr_h_l4[2];
                        $totalPenNumDay4 = $sss44 + $gsis44 + $pvao44 + $pnp44 + $olr44 + $olr_r_e44 + $olr_h_l44;
                    
                        $item['card'] .= ' 
                            <th class="table-border">' . $totalPenInDay4 . '</th>
                            <th class="table-border">' . $totalPenOutDay4 . '</th>
                            <th class="table-border">' . $totalPenNumDay4 . '</th>';
                    }
                    
                    if ($day5_param > 0) {
                        $totalPenInDay5 = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                        $totalPenOutDay5 = $sss5[2] + $gsis5[2] + $pvao5[1] + $pnp5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                        $totalPenNumDay5 = $sss55 + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
                    
                        $item['card'] .= ' 
                            <th class="table-border">' . $totalPenInDay5 . '</th>
                            <th class="table-border">' . $totalPenOutDay5 . '</th>
                            <th class="table-border">' . $totalPenNumDay5 . '</th>';
                    }
                    
                    $totalTotalIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
                    $totalTotalOut = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;
                    $totalNetTotal = $totalTotalIn - $totalTotalOut;
                    $totalSSSAndGSIS = $sss55 + $gsis55 + $pvao55 + $pnp55 + $olr55 + $olr_r_e55 + $olr_h_l55;
                    
                    $item['card'] .= '
                        <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                        <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalIn . '</th>
                        <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalTotalOut . '</th>
                        <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalNetTotal . '</th>
                        <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalSSSAndGSIS . '</th>
                    </tr>';
                    
    
                $item['card'] .='  
                <tr><td colspan="25" class="invisible">d </td></tr>
                ';
            } else if($branch_name == 'RLC KALIBO' ) {

                $item['card'] .='
                <tr>
                    <th colspan="2" rowspan="5" style="text-align:center;padding:10rem 1rem;">'.$branch_name.'</th>
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                    <th class="table-border">'.$lastTransactionDataSSS.'</th>
                    ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                    <th class="table-border">'.$sss1[2].'</th>
                    <th class="table-border">'.$sss11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                    <th class="table-border">'.$sss2[2].'</th>
                    <th class="table-border">'.$sss22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                    <th class="table-border">'.$sss3[2].'</th>
                    <th class="table-border">'.$sss33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                    <th class="table-border">'.$sss4[2].'</th>
                    <th class="table-border">'.$sss44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                    <th class="table-border">'.$sss5[2].'</th>
                    <th class="table-border">'.$sss55.'</th>';
                }

                $sub_totalSSS = $totalInSSS - $totalOutSSS;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                    
                    </tr>';   
    
                    $item['card'] .='   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                    <th class="table-border">'.$gsis1[2].'</th>
                    <th class="table-border">'.$gsis11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                    <th class="table-border">'.$gsis2[2].'</th>
                    <th class="table-border">'.$gsis22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                    <th class="table-border">'.$gsis3[2].'</th>
                    <th class="table-border">'.$gsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                    <th class="table-border">'.$gsis4[2].'</th>
                    <th class="table-border">'.$gsis44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                    <th class="table-border">'.$gsis5[2].'</th>
                    <th class="table-border">'.$gsis55.'</th>';
                }

                $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

                $item['card'] .= '
                
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
                
                </tr>';   
    
                $item['card'] .=' 
            
                <tr>
          
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PVAO</th>
                <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
                <th class="table-border">'.$lastTransactionDataPVAO.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                    <th class="table-border">'.$pvao1[2].'</th>
                    <th class="table-border">'.$pvao11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao2[1].'</th>
                    <th class="table-border">'.$pvao2[2].'</th>
                    <th class="table-border">'.$pvao22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pvao3[1].'</th>
                    <th class="table-border">'.$pvao3[2].'</th>
                    <th class="table-border">'.$pvao33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pvao4[1].'</th>
                    <th class="table-border">'.$pvao4[2].'</th>
                    <th class="table-border">'.$pvao44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao5[1].'</th>
                    <th class="table-border">'.$pvao5[2].'</th>
                    <th class="table-border">'.$pvao55.'</th>';
                }

                $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

            $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
                
            </tr>';   
    
            $item['card'] .='   

            <tr>
          
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PNP</th>
                <th class="table-border">'.$newBegBalValuePNP[0].'</th>
                <th class="table-border">'.$lastTransactionDataPNP.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                    <th class="table-border">'.$pnp1[2].'</th>
                    <th class="table-border">'.$pnp11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                    <th class="table-border">'.$pnp2[2].'</th>
                    <th class="table-border">'.$pnp22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pnp3[1].'</th>
                    <th class="table-border">'.$pnp3[2].'</th>
                    <th class="table-border">'.$pnp33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pnp4[1].'</th>
                    <th class="table-border">'.$pnp4[2].'</th>
                    <th class="table-border">'.$pnp44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                    <th class="table-border">'.$pnp5[2].'</th>
                    <th class="table-border">'.$pnp55.'</th>';
                }
                $sub_totalPNP = $totalInPNP - $totalOutPNP;
            $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>
                
            </tr> ';   
    
            $totalTotalBal = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValuePNP[0];
            $totalLastTransactionBal = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataPNP;
            
            $item['card'] .= '
                <tr>
                    <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                    <th class="table-border">' . $totalTotalBal . '</th>
                    <th class="table-border">' . $totalLastTransactionBal . '</th>
            ';
            
            if ($day1_param > 0) {
                $totalPenInDay1 = $sss1[1] + $gsis1[1] + $pvao1[1] + $pnp1[1];
                $totalPenOutDay1 = $sss1[2] + $gsis1[2] + $pvao1[2] + $pnp1[2];
                $totalPenNumDay1 = $sss11 + $gsis11 + $pvao11 + $pnp11;
            
                $item['card'] .= '  
                    <th class="table-border">' . $totalPenInDay1 . '</th>
                    <th class="table-border">' . $totalPenOutDay1 . '</th>
                    <th class="table-border">' . $totalPenNumDay1 . '</th>';
            }
            
            if ($day2_param > 0) {
                $totalPenInDay2 = $sss2[1] + $gsis2[1] + $pvao2[1] + $pnp2[1];
                $totalPenOutDay2 = $sss2[2] + $gsis2[2] + $pvao2[2] + $pnp2[2];
                $totalPenNumDay2 = $sss22 + $gsis22 + $pvao22 + $pnp22;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay2 . '</th>
                    <th class="table-border">' . $totalPenOutDay2 . '</th>
                    <th class="table-border">' . $totalPenNumDay2 . '</th>';
            }
            
            if ($day3_param > 0) {
                $totalPenInDay3 = $sss3[1] + $gsis3[1] + $pvao3[1] + $pnp3[1];
                $totalPenOutDay3 = $sss3[2] + $gsis3[2] + $pvao3[2] + $pnp3[2];
                $totalPenNumDay3 = $sss33 + $gsis33 + $pvao33 + $pnp33;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay3 . '</th>
                    <th class="table-border">' . $totalPenOutDay3 . '</th>
                    <th class="table-border">' . $totalPenNumDay3 . '</th>';
            }
            
            if ($day4_param > 0) {
                $totalPenInDay4 = $sss4[1] + $gsis4[1] + $pvao4[1] + $pnp4[1];
                $totalPenOutDay4 = $sss4[2] + $gsis4[2] + $pvao4[1] + $pnp4[1];
                $totalPenNumDay4 = $sss44 + $gsis44 + $pvao44 + $pnp44;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay4 . '</th>
                    <th class="table-border">' . $totalPenOutDay4 . '</th>
                    <th class="table-border">' . $totalPenNumDay4 . '</th>';
            }
            
            if ($day5_param > 0) {
                $totalPenInDay5 = $sss5[1] + $gsis5[1] + $pvao5[1] + $pnp5[1];
                $totalPenOutDay5 = $sss5[2] + $gsis5[2] + $pvao5[1] + $pnp5[1];
                $totalPenNumDay5 = $sss55 + $gsis55 + $pvao55 + $pnp55;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay5 . '</th>
                    <th class="table-border">' . $totalPenOutDay5 . '</th>
                    <th class="table-border">' . $totalPenNumDay5 . '</th>';
            }
            
            $totalIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInPNP;
            $totalOut = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutPNP;
            $netTotal = $totalIn - $totalOut;
            $totalPen = $sss55 + $gsis55 + $pvao55 + $pnp55;
            
            $item['card'] .= '
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalIn . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOut . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotal . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalPen . '</th>
            </tr>';
    
            $item['card'] .='  
    
    
            <tr><td colspan="25" class="invisible">d </td></tr>
            ';
                
            } else if($branch_name == 'RLC SINGCANG'){

                $item1 = array();
                $item1['card'] = ''; 

                $item['card'] .='
                <tr>
                    <th colspan="2" rowspan="8" style="text-align:center;padding:15rem 1rem;">'.$branch_name.'</th>
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                    <th class="table-border">'.$lastTransactionDataSSS.'</th>
                    ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                    <th class="table-border">'.$sss1[2].'</th>
                    <th class="table-border">'.$sss11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                    <th class="table-border">'.$sss2[2].'</th>
                    <th class="table-border">'.$sss22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                    <th class="table-border">'.$sss3[2].'</th>
                    <th class="table-border">'.$sss33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                    <th class="table-border">'.$sss4[2].'</th>
                    <th class="table-border">'.$sss44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                    <th class="table-border">'.$sss5[2].'</th>
                    <th class="table-border">'.$sss55.'</th>';
                }

                $sub_totalSSS = $totalInSSS - $totalOutSSS;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                    
                    </tr>';   
    
                    $item['card'] .='   

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                    <th class="table-border">'.$gsis1[2].'</th>
                    <th class="table-border">'.$gsis11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                    <th class="table-border">'.$gsis2[2].'</th>
                    <th class="table-border">'.$gsis22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                    <th class="table-border">'.$gsis3[2].'</th>
                    <th class="table-border">'.$gsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                    <th class="table-border">'.$gsis4[2].'</th>
                    <th class="table-border">'.$gsis44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                    <th class="table-border">'.$gsis5[2].'</th>
                    <th class="table-border">'.$gsis55.'</th>';
                }

                $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

                $item['card'] .= '
                
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
                
                </tr>';   
    
                $item['card'] .=' 
            
                <tr>
          
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PVAO</th>
                <th class="table-border">'.$newBegBalValuePVAO[0].'</th>
                <th class="table-border">'.$lastTransactionDataPVAO.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao1[1].'</th>
                    <th class="table-border">'.$pvao1[2].'</th>
                    <th class="table-border">'.$pvao11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao2[1].'</th>
                    <th class="table-border">'.$pvao2[2].'</th>
                    <th class="table-border">'.$pvao22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pvao3[1].'</th>
                    <th class="table-border">'.$pvao3[2].'</th>
                    <th class="table-border">'.$pvao33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$pvao4[1].'</th>
                    <th class="table-border">'.$pvao4[2].'</th>
                    <th class="table-border">'.$pvao44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$pvao5[1].'</th>
                    <th class="table-border">'.$pvao5[2].'</th>
                    <th class="table-border">'.$pvao55.'</th>';
                }

                $sub_totalPVAO = $totalInPVAO - $totalOutPVAO;

            $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPVAO.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pvao55.'</th>
                
            </tr>';   
    
            $item['card'] .='   
        
            <tr>
              
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR</th>
                    <th class="table-border">'.$newBegBalValueOLR[0].'</th>
                    <th class="table-border">'.$lastTransactionDataOLR.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr1[1].'</th>
                        <th class="table-border">'.$olr1[2].'</th>
                        <th class="table-border">'.$olr11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr2[1].'</th>
                        <th class="table-border">'.$olr2[2].'</th>
                        <th class="table-border">'.$olr22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr3[1].'</th>
                        <th class="table-border">'.$olr3[2].'</th>
                        <th class="table-border">'.$olr33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr4[1].'</th>
                        <th class="table-border">'.$olr4[2].'</th>
                        <th class="table-border">'.$olr44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr5[1].'</th>
                        <th class="table-border">'.$olr5[2].'</th>
                        <th class="table-border">'.$olr55.'</th>';
                    }

                    $sub_totalOLR = $totalInOLR - $totalOutOLR;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="paddin<th style=" text-align: center;"><br> </th>
                        <th style=" text-align: center;"><span style="paddin<th style=" text-align: center;"><br>'.$totalInOLR.'</th>
                        <th style=" text-align: center;"><span style="paddin<th style=" text-align: center;"><br>'.$totalOutOLR.'</th>
                        <th style=" text-align: center;"><span style="paddin<th style=" text-align: center;"><br>'.$sub_totalOLR.'</th>
                        <th style=" text-align: center;"><span style="paddin<th style=" text-align: center;"><br>'.$olr55.'</th>
                    
                </tr>';   
    
                $item['card'] .='   
                <tr>
              
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR_REAL ESTATE</th>
                    <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
                    <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                        <th class="table-border">'.$olr_r_e1[2].'</th>
                        <th class="table-border">'.$olr_r_e11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                        <th class="table-border">'.$olr_r_e2[2].'</th>
                        <th class="table-border">'.$olr_r_e22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_r_e3[1].'</th>
                        <th class="table-border">'.$olr_r_e3[2].'</th>
                        <th class="table-border">'.$olr_r_e33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_r_e4[1].'</th>
                        <th class="table-border">'.$olr_r_e4[2].'</th>
                        <th class="table-border">'.$olr_r_e44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                        <th class="table-border">'.$olr_r_e5[2].'</th>
                        <th class="table-border">'.$olr_r_e55.'</th>';
                    }

                    $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>
                    
                </tr>';   
    
                $item['card'] .='   
                <tr>
              
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-HOUSE LOAN</th>
                <th class="table-border">'.$newBegBalValueOLR_H_L[0].'</th>
                <th class="table-border">'.$lastTransactionDataOLR_H_L.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_h_l1[1].'</th>
                    <th class="table-border">'.$olr_h_l1[2].'</th>
                    <th class="table-border">'.$olr_h_l11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_h_l2[1].'</th>
                    <th class="table-border">'.$olr_h_l2[2].'</th>
                    <th class="table-border">'.$olr_h_l22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$olr_h_l3[1].'</th>
                    <th class="table-border">'.$olr_h_l3[2].'</th>
                    <th class="table-border">'.$olr_h_l33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$olr_h_l4[1].'</th>
                    <th class="table-border">'.$olr_h_l4[2].'</th>
                    <th class="table-border">'.$olr_h_l44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_h_l5[1].'</th>
                    <th class="table-border">'.$olr_h_l5[2].'</th>
                    <th class="table-border">'.$olr_h_l55.'</th>';
                }

                $sub_totalOLR_H_L = $totalInOLR_H_L - $totalOutOLR_H_L;

            $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_H_L.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_H_L.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_H_L.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_h_l55.'</th>
                
            </tr>';   
    
            $item['card'] .='   
            <tr>
              
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-CHATTEL</th>
                    <th class="table-border">'.$newBegBalValueOLR_C[0].'</th>
                    <th class="table-border">'.$lastTransactionDataOLR_C.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_c1[1].'</th>
                        <th class="table-border">'.$olr_c1[2].'</th>
                        <th class="table-border">'.$olr_c11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_c2[1].'</th>
                        <th class="table-border">'.$olr_c2[2].'</th>
                        <th class="table-border">'.$olr_c22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_c3[1].'</th>
                        <th class="table-border">'.$olr_c3[2].'</th>
                        <th class="table-border">'.$olr_c33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$olr_c4[1].'</th>
                        <th class="table-border">'.$olr_c4[2].'</th>
                        <th class="table-border">'.$olr_c44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$olr_c5[1].'</th>
                        <th class="table-border">'.$olr_c5[2].'</th>
                        <th class="table-border">'.$olr_c55.'</th>';
                    }

                    $sub_totalOLR_C = $totalInOLR_C - $totalOutOLR_C;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_C.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_C.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_C.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_c55.'</th>
                    
                </tr> ';   
    
                $totalTotalBal = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValuePVAO[0] + $newBegBalValueOLR_C[0] + $newBegBalValueOLR[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValueOLR_H_L[0];
                $totalLastTransactionBal = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataPVAO + $lastTransactionDataOLR_C + $lastTransactionDataOLR + $lastTransactionDataOLR_R_E + $lastTransactionDataOLR_H_L;
                
                $item['card'] .= '
                    <tr>
                        <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                        <th class="table-border">' . $totalTotalBal . '</th>
                        <th class="table-border">' . $totalLastTransactionBal . '</th>
                ';
                
                if ($day1_param > 0) {
                    $totalPenInDay1 = $sss1[1] + $gsis1[1] + $pvao1[1] + $olr_c1[1] + $olr1[1] + $olr_r_e1[1] + $olr_h_l1[1];
                    $totalPenOutDay1 = $sss1[2] + $gsis1[2] + $pvao1[2] + $olr_c1[2] + $olr1[2] + $olr_r_e1[2] + $olr_h_l1[2];
                    $totalPenNumDay1 = $sss11 + $gsis11 + $pvao11 + $olr_c11 + $olr11 + $olr_r_e11 + $olr_h_l11;
                
                    $item['card'] .= '  
                        <th class="table-border">' . $totalPenInDay1 . '</th>
                        <th class="table-border">' . $totalPenOutDay1 . '</th>
                        <th class="table-border">' . $totalPenNumDay1 . '</th>';
                }
                
                if ($day2_param > 0) {
                    $totalPenInDay2 = $sss2[1] + $gsis2[1] + $pvao2[1] + $olr_c2[1] + $olr2[1] + $olr_r_e2[1] + $olr_h_l2[1];
                    $totalPenOutDay2 = $sss2[2] + $gsis2[2] + $pvao2[2] + $olr_c2[2] + $olr2[2] + $olr_r_e2[2] + $olr_h_l2[2];
                    $totalPenNumDay2 = $sss22 + $gsis22 + $pvao22 + $olr_c22 + $olr22 + $olr_r_e22 + $olr_h_l22;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay2 . '</th>
                        <th class="table-border">' . $totalPenOutDay2 . '</th>
                        <th class="table-border">' . $totalPenNumDay2 . '</th>';
                }
                
                if ($day3_param > 0) {
                    $totalPenInDay3 = $sss3[1] + $gsis3[1] + $pvao3[1] + $olr_c3[1] + $olr3[1] + $olr_r_e3[1] + $olr_h_l3[1];
                    $totalPenOutDay3 = $sss3[2] + $gsis3[2] + $pvao3[2] + $olr_c3[2] + $olr3[2] + $olr_r_e3[2] + $olr_h_l3[2];
                    $totalPenNumDay3 = $sss33 + $gsis33 + $pvao33 + $olr_c33 + $olr33 + $olr_r_e33 + $olr_h_l33;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay3 . '</th>
                        <th class="table-border">' . $totalPenOutDay3 . '</th>
                        <th class="table-border">' . $totalPenNumDay3 . '</th>';
                }
                
                if ($day4_param > 0) {
                    $totalPenInDay4 = $sss4[1] + $gsis4[1] + $pvao4[1] + $olr_c4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
                    $totalPenOutDay4 = $sss4[2] + $gsis4[2] + $pvao4[1] + $olr_c4[1] + $olr4[1] + $olr_r_e4[1] + $olr_h_l4[1];
                    $totalPenNumDay4 = $sss44 + $gsis44 + $pvao44 + $olr_c44 + $olr44 + $olr_r_e44 + $olr_h_l44;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay4 . '</th>
                        <th class="table-border">' . $totalPenOutDay4 . '</th>
                        <th class="table-border">' . $totalPenNumDay4 . '</th>';
                }
                
                if ($day5_param > 0) {
                    $totalPenInDay5 = $sss5[1] + $gsis5[1] + $pvao5[1] + $olr_c5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                    $totalPenOutDay5 = $sss5[2] + $gsis5[2] + $pvao5[1] + $olr_c5[1] + $olr5[1] + $olr_r_e5[1] + $olr_h_l5[1];
                    $totalPenNumDay5 = $sss55 + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay5 . '</th>
                        <th class="table-border">' . $totalPenOutDay5 . '</th>
                        <th class="table-border">' . $totalPenNumDay5 . '</th>';
                }
                
                $totalIn = $totalInGSIS + $totalInSSS + $totalInPVAO + $totalInOLR_C + $totalInOLR + $totalInOLR_R_E + $totalInOLR_H_L;
                $totalOut = $totalOutGSIS + $totalOutSSS + $totalOutPVAO + $totalOutOLR_C + $totalOutOLR + $totalOutOLR_R_E + $totalOutOLR_H_L;
                $netTotal = $totalIn - $totalOut;
                $totalPen = $sss55 + $gsis55 + $pvao55 + $olr_c55 + $olr55 + $olr_r_e55 + $olr_h_l55;
                
                $item['card'] .= '
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalIn . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOut . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotal . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalPen . '</th>
                </tr>';
                
    
            $item['card'] .='  

            <tr><td colspan="25" class="invisible">d </td></tr>
            ';

            }else if($branch_name == 'RLC ANTIQUE'){

               
                $item['card'] .='
                <tr>
                    <th colspan="2" rowspan="5" style="text-align:center;padding:9rem 1rem;">'.$branch_name.'</th>
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                    <th class="table-border">'.$newBegBalValueSSS[0].'</th>
                    <th class="table-border">'.$lastTransactionDataSSS.'</th>
                    ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss1[1].'</th>
                    <th class="table-border">'.$sss1[2].'</th>
                    <th class="table-border">'.$sss11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss2[1].'</th>
                    <th class="table-border">'.$sss2[2].'</th>
                    <th class="table-border">'.$sss22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss3[1].'</th>
                    <th class="table-border">'.$sss3[2].'</th>
                    <th class="table-border">'.$sss33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$sss4[1].'</th>
                    <th class="table-border">'.$sss4[2].'</th>
                    <th class="table-border">'.$sss44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$sss5[1].'</th>
                    <th class="table-border">'.$sss5[2].'</th>
                    <th class="table-border">'.$sss55.'</th>';
                }

                $sub_totalSSS = $totalInSSS - $totalOutSSS;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalSSS.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sss55.'</th>
                    
                    </tr> ';   
    
                    $item['card'] .='  

                <tr>

                <th class="table-border" style="text-align:center;padding:1.2rem 1rem;">GSIS</th>
                <th class="table-border">'.$newBegBalValueGSIS[0].'</th>
                <th class="table-border">'.$lastTransactionDataGSIS.'</th>
            ';

            if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis1[1].'</th>
                    <th class="table-border">'.$gsis1[2].'</th>
                    <th class="table-border">'.$gsis11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$gsis2[1].'</th>
                    <th class="table-border">'.$gsis2[2].'</th>
                    <th class="table-border">'.$gsis22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$gsis3[1].'</th>
                    <th class="table-border">'.$gsis3[2].'</th>
                    <th class="table-border">'.$gsis33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$gsis4[1].'</th>
                    <th class="table-border">'.$gsis4[2].'</th>
                    <th class="table-border">'.$gsis44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$gsis5[1].'</th>
                    <th class="table-border">'.$gsis5[2].'</th>
                    <th class="table-border">'.$gsis55.'</th>';
                }

                $sub_totalGSIS = $totalInGSIS - $totalOutGSIS;

                $item['card'] .= '
                
                     <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalGSIS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$gsis55.'</th>
                
                </tr>';   
    
                $item['card'] .=' 
            
    
                <tr>
              
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                <th class="table-border">'.$newBegBalValueOLR_R_E[0].'</th>
                <th class="table-border">'.$lastTransactionDataOLR_R_E.'</th>
                ';

                if ($day1_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_r_e1[1].'</th>
                    <th class="table-border">'.$olr_r_e1[2].'</th>
                    <th class="table-border">'.$olr_r_e11.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_r_e2[1].'</th>
                    <th class="table-border">'.$olr_r_e2[2].'</th>
                    <th class="table-border">'.$olr_r_e22.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$olr_r_e3[1].'</th>
                    <th class="table-border">'.$olr_r_e3[2].'</th>
                    <th class="table-border">'.$olr_r_e33.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= ' <th class="table-border">'.$olr_r_e4[1].'</th>
                    <th class="table-border">'.$olr_r_e4[2].'</th>
                    <th class="table-border">'.$olr_r_e44.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$olr_r_e5[1].'</th>
                    <th class="table-border">'.$olr_r_e5[2].'</th>
                    <th class="table-border">'.$olr_r_e55.'</th>';
                }

                $sub_totalOLR_R_E = $totalInOLR_R_E - $totalOutOLR_R_E;

            $item['card'] .='
            
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInOLR_R_E.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutOLR_R_E.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalOLR_R_E.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$olr_r_e55.'</th>
                
            </tr>';   
    
            $item['card'] .='   
            <tr>
              
                    <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PNP</th>
                    <th class="table-border">'.$newBegBalValuePNP[0].'</th>
                    <th class="table-border">'.$lastTransactionDataPNP.'</th>
                    ';

                    if ($day1_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp1[1].'</th>
                        <th class="table-border">'.$pnp1[2].'</th>
                        <th class="table-border">'.$pnp11.'</th>';
                    }
                    if ($day2_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp2[1].'</th>
                        <th class="table-border">'.$pnp2[2].'</th>
                        <th class="table-border">'.$pnp22.'</th>';
                    }
                    if ($day3_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pnp3[1].'</th>
                        <th class="table-border">'.$pnp3[2].'</th>
                        <th class="table-border">'.$pnp33.'</th>';
                    }
                    if ($day4_param > 0) {
                        $item['card'] .= ' <th class="table-border">'.$pnp4[1].'</th>
                        <th class="table-border">'.$pnp4[2].'</th>
                        <th class="table-border">'.$pnp44.'</th>';
                    }
                    if ($day5_param > 0) {
                        $item['card'] .= '  <th class="table-border">'.$pnp5[1].'</th>
                        <th class="table-border">'.$pnp5[2].'</th>
                        <th class="table-border">'.$pnp55.'</th>';
                    }

                    $sub_totalPNP = $totalInPNP - $totalOutPNP;

                $item['card'] .='
                
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalInPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalOutPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$sub_totalPNP.'</th>
                        <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$pnp55.'</th>
                    
                </tr>';   
    
                $totalTotalBal2 = $newBegBalValueSSS[0] + $newBegBalValueGSIS[0] + $newBegBalValueOLR_R_E[0] + $newBegBalValuePNP[0];
                $totalLastTransactionBal2 = $lastTransactionDataSSS + $lastTransactionDataGSIS + $lastTransactionDataOLR_R_E + $lastTransactionDataPNP;
                
                $item['card'] .= '
                    <tr>
                        <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                        <th class="table-border">' . $totalTotalBal2 . '</th>
                        <th class="table-border">' . $totalLastTransactionBal2 . '</th>
                ';
                
                if ($day1_param > 0) {
                    $totalPenInDay1 = $sss1[1] + $gsis1[1] + $olr_r_e1[1] + $pnp1[1];
                    $totalPenOutDay1 = $sss1[2] + $gsis1[2] + $olr_r_e1[2] + $pnp1[2];
                    $totalPenNumDay1 = $sss11 + $gsis11 + $olr_r_e11 + $pnp11;
                
                    $item['card'] .= '  
                        <th class="table-border">' . $totalPenInDay1 . '</th>
                        <th class="table-border">' . $totalPenOutDay1 . '</th>
                        <th class="table-border">' . $totalPenNumDay1 . '</th>';
                }
                
                if ($day2_param > 0) {
                    $totalPenInDay2 = $sss2[1] + $gsis2[1] + $olr_r_e2[1] + $pnp2[1];
                    $totalPenOutDay2 = $sss2[2] + $gsis2[2] + $olr_r_e2[2] + $pnp2[2];
                    $totalPenNumDay2 = $sss22 + $gsis22 + $olr_r_e22 + $pnp22;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay2 . '</th>
                        <th class="table-border">' . $totalPenOutDay2 . '</th>
                        <th class="table-border">' . $totalPenNumDay2 . '</th>';
                }
                
                if ($day3_param > 0) {
                    $totalPenInDay3 = $sss3[1] + $gsis3[1] + $olr_r_e3[1] + $pnp3[1];
                    $totalPenOutDay3 = $sss3[2] + $gsis3[2] + $olr_r_e3[2] + $pnp3[2];
                    $totalPenNumDay3 = $sss33 + $gsis33 + $olr_r_e33 + $pnp33;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay3 . '</th>
                        <th class="table-border">' . $totalPenOutDay3 . '</th>
                        <th class="table-border">' . $totalPenNumDay3 . '</th>';
                }
                
                if ($day4_param > 0) {
                    $totalPenInDay4 = $sss4[1] + $gsis4[1] + $olr_r_e4[1] + $pnp4[1];
                    $totalPenOutDay4 = $sss4[2] + $gsis4[2] + $olr_r_e4[1] + $pnp4[1];
                    $totalPenNumDay4 = $sss44 + $gsis44 + $olr_r_e44 + $pnp44;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay4 . '</th>
                        <th class="table-border">' . $totalPenOutDay4 . '</th>
                        <th class="table-border">' . $totalPenNumDay4 . '</th>';
                }
                
                if ($day5_param > 0) {
                    $totalPenInDay5 = $sss5[1] + $gsis5[1] + $olr_r_e5[1] + $pnp5[1];
                    $totalPenOutDay5 = $sss5[2] + $gsis5[2] + $olr_r_e5[1] + $pnp5[1];
                    $totalPenNumDay5 = $sss55 + $gsis55 + $olr_r_e55 + $pnp55;
                
                    $item['card'] .= ' 
                        <th class="table-border">' . $totalPenInDay5 . '</th>
                        <th class="table-border">' . $totalPenOutDay5 . '</th>
                        <th class="table-border">' . $totalPenNumDay5 . '</th>';
                }
                
                $totalIn2 = $totalInGSIS + $totalInSSS + $totalInOLR_R_E + $totalInPNP;
                $totalOut2 = $totalOutGSIS + $totalOutSSS + $totalOutOLR_R_E + $totalOutPNP;
                $netTotal2 = $totalIn2 - $totalOut2;
                $totalPen2 = $sss55 + $gsis55 + $olr_r_e55 + $pnp55;
                
                $item['card'] .= '
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalIn2 . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalOut2 . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netTotal2 . '</th>
                    <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalPen2 . '</th>
                </tr>';
                
    
                $item['card'] .='  
    
    
            <tr><td colspan="25" class="invisible">d </td></tr>
            ';
           

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

        }
                
        $item['card'] .='
                <tr>
                <th colspan="2" rowspan="9" style="text-align:center;padding:15rem 1rem; color:gray;">RLC TOTAL</th>
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">SSS</th>
                <th class="table-border">'.$totalBeginningBalSSS.'</th>
                <th class="table-border">'.$totalLastTransactionBalSSS.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1SSS.'</th>
                <th class="table-border">'.$totalPenOutDay1SSS.'</th>
                <th class="table-border">'.$totalPenNumDay1SSS.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2SSS.'</th>
                <th class="table-border">'.$totalPenOutDay2SSS.'</th>
                <th class="table-border">'.$totalPenNumDay2SSS.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3SSS.'</th>
                <th class="table-border">'.$totalPenOutDay3SSS.'</th>
                <th class="table-border">'.$totalPenNumDay3SSS.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4SSS.'</th>
                <th class="table-border">'.$totalPenOutDay4SSS.'</th>
                <th class="table-border">'.$totalPenNumDay4SSS.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5SSS.'</th>
                <th class="table-border">'.$totalPenOutDay5SSS.'</th>
                <th class="table-border">'.$totalPenNumDay5SSS.'</th>';
            }

            $grandTotalPenInOutSSS = $grandTotalPenInSSS - $grandTotalPenOutSSS;

            $item['card'] .='

                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutSSS.'</th>
                    <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5SSS.'</th>
                
            </tr> ';   
    
            $item['card'] .='  
            <tr>
               
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">GSIS</th>
                <th class="table-border">'.$totalBeginningBalGSIS.'</th>
                <th class="table-border">'.$totalLastTransactionBalGSIS.'</th>

            ';

                if ($day1_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$totalPenInDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay1GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay1GSIS.'</th>';
                }
                if ($day2_param > 0) {
                    $item['card'] .= '   <th class="table-border">'.$totalPenInDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay2GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay2GSIS.'</th>';
                }
                if ($day3_param > 0) {
                    $item['card'] .= '     <th class="table-border">'.$totalPenInDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay3GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay3GSIS.'</th>';
                }
                if ($day4_param > 0) {
                    $item['card'] .= '  <th class="table-border">'.$totalPenInDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay4GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay4GSIS.'</th>';
                }
                if ($day5_param > 0) {
                    $item['card'] .= '    <th class="table-border">'.$totalPenInDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenOutDay5GSIS.'</th>
                    <th class="table-border">'.$totalPenNumDay5GSIS.'</th>';
                }

                $grandTotalPenInOutGSIS = $grandTotalPenInGSIS - $grandTotalPenOutGSIS;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutGSIS.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5GSIS.'</th>
            
            </tr>';   
    
            $item['card'] .='  
            <tr>
           
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PVAO</th>
                <th class="table-border">'.$totalBeginningBalPVAO.'</th>
                <th class="table-border">'.$totalLastTransactionBalPVAO.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay1PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay1PVAO.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay2PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay2PVAO.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay3PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay3PVAO.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay4PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay4PVAO.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5PVAO.'</th>
                <th class="table-border">'.$totalPenOutDay5PVAO.'</th>
                <th class="table-border">'.$totalPenNumDay5PVAO.'</th>';
            }
            
            $grandTotalPenInOutPVAO = $grandTotalPenInPVAO - $grandTotalPenOutPVAO;
        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutPVAO.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5PVAO.'</th>
            
            </tr>';   
    
            $item['card'] .='  
            <tr>
                
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">PNP</th>
                <th class="table-border">'.$totalBeginningBalPNP.'</th>
                <th class="table-border">'.$totalLastTransactionBalPNP.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1PNP.'</th>
                <th class="table-border">'.$totalPenOutDay1PNP.'</th>
                <th class="table-border">'.$totalPenNumDay1PNP.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2PNP.'</th>
                <th class="table-border">'.$totalPenOutDay2PNP.'</th>
                <th class="table-border">'.$totalPenNumDay2PNP.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3PNP.'</th>
                <th class="table-border">'.$totalPenOutDay3PNP.'</th>
                <th class="table-border">'.$totalPenNumDay3PNP.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4PNP.'</th>
                <th class="table-border">'.$totalPenOutDay4PNP.'</th>
                <th class="table-border">'.$totalPenNumDay4PNP.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5PNP.'</th>
                <th class="table-border">'.$totalPenOutDay5PNP.'</th>
                <th class="table-border">'.$totalPenNumDay5PNP.'</th>';
            }

            $grandTotalPenInOutPNP = $grandTotalPenInPNP - $grandTotalPenOutPNP;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInPNP.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutPNP.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutPNP.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5PNP.'</th>
            
            </tr>';   
    
            $item['card'] .='  
            <tr>
         
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR</th>
                <th class="table-border">'.$totalBeginningBalOLR.'</th>
                <th class="table-border">'.$totalLastTransactionBalOLR.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1OLR.'</th>
                <th class="table-border">'.$totalPenOutDay1OLR.'</th>
                <th class="table-border">'.$totalPenNumDay1OLR.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2OLR.'</th>
                <th class="table-border">'.$totalPenOutDay2OLR.'</th>
                <th class="table-border">'.$totalPenNumDay2OLR.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3OLR.'</th>
                <th class="table-border">'.$totalPenOutDay3OLR.'</th>
                <th class="table-border">'.$totalPenNumDay3OLR.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4OLR.'</th>
                <th class="table-border">'.$totalPenOutDay4OLR.'</th>
                <th class="table-border">'.$totalPenNumDay4OLR.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5OLR.'</th>
                <th class="table-border">'.$totalPenOutDay5OLR.'</th>
                <th class="table-border">'.$totalPenNumDay5OLR.'</th>';
            }

            $grandTotalPenInOutOLR = $grandTotalPenInOLR - $grandTotalPenOutOLR;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOLR.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutOLR.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutOLR.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5OLR.'</th>
            
            </tr>';   
    
            $item['card'] .='  
            <tr>
             
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-REAL ESTATE</th>
                <th class="table-border">'.$totalBeginningBalOLR_R_E.'</th>
                <th class="table-border">'.$totalLastTransactionBalOLR_R_E.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1OLR_R_E.'</th>
                <th class="table-border">'.$totalPenOutDay1OLR_R_E.'</th>
                <th class="table-border">'.$totalPenNumDay1OLR_R_E.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2OLR_R_E.'</th>
                <th class="table-border">'.$totalPenOutDay2OLR_R_E.'</th>
                <th class="table-border">'.$totalPenNumDay2OLR_R_E.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3OLR_R_E.'</th>
                <th class="table-border">'.$totalPenOutDay3OLR_R_E.'</th>
                <th class="table-border">'.$totalPenNumDay3OLR_R_E.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4OLR_R_E.'</th>
                <th class="table-border">'.$totalPenOutDay4OLR_R_E.'</th>
                <th class="table-border">'.$totalPenNumDay4OLR_R_E.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5OLR_R_E.'</th>
                <th class="table-border">'.$totalPenOutDay5OLR_R_E.'</th>
                <th class="table-border">'.$totalPenNumDay5OLR_R_E.'</th>';
            }

            $grandTotalPenInOutOLR_R_E = $grandTotalPenInOLR_R_E - $grandTotalPenOutOLR_R_E;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOLR_R_E.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutOLR_R_E.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutOLR_R_E.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5OLR_R_E.'</th>
            
            </tr> ';   
    
            $item['card'] .=' 
            <tr>
           
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-HOUSE LOAN</th>
                <th class="table-border">'.$totalBeginningBalOLR_H_L.'</th>
                <th class="table-border">'.$totalLastTransactionBalOLR_H_L.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1OLR_H_L.'</th>
                <th class="table-border">'.$totalPenOutDay1OLR_H_L.'</th>
                <th class="table-border">'.$totalPenNumDay1OLR_H_L.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2OLR_H_L.'</th>
                <th class="table-border">'.$totalPenOutDay2OLR_H_L.'</th>
                <th class="table-border">'.$totalPenNumDay2OLR_H_L.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3OLR_H_L.'</th>
                <th class="table-border">'.$totalPenOutDay3OLR_H_L.'</th>
                <th class="table-border">'.$totalPenNumDay3OLR_H_L.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4OLR_H_L.'</th>
                <th class="table-border">'.$totalPenOutDay4OLR_H_L.'</th>
                <th class="table-border">'.$totalPenNumDay4OLR_H_L.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5OLR_H_L.'</th>
                <th class="table-border">'.$totalPenOutDay5OLR_H_L.'</th>
                <th class="table-border">'.$totalPenNumDay5OLR_H_L.'</th>';
            }

            $grandTotalPenInOutOLR_H_L = $grandTotalPenInOLR_H_L - $grandTotalPenOutOLR_H_L;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOLR_H_L.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutOLR_H_L.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutOLR_H_L.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5OLR_H_L.'</th>
            
            </tr>';   
    
            $item['card'] .='  
            <tr>
              
                <th class="table-border" style="padding:1.2rem 1rem;text-align:center;">OLR-CHATTEL</th>
                <th class="table-border">'.$totalBeginningBalOLR_C.'</th>
                <th class="table-border">'.$totalLastTransactionBalOLR_C.'</th>

        ';

            if ($day1_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay1OLR_C.'</th>
                <th class="table-border">'.$totalPenOutDay1OLR_C.'</th>
                <th class="table-border">'.$totalPenNumDay1OLR_C.'</th>';
            }
            if ($day2_param > 0) {
                $item['card'] .= '   <th class="table-border">'.$totalPenInDay2OLR_C.'</th>
                <th class="table-border">'.$totalPenOutDay2OLR_C.'</th>
                <th class="table-border">'.$totalPenNumDay2OLR_C.'</th>';
            }
            if ($day3_param > 0) {
                $item['card'] .= '     <th class="table-border">'.$totalPenInDay3OLR_C.'</th>
                <th class="table-border">'.$totalPenOutDay3OLR_C.'</th>
                <th class="table-border">'.$totalPenNumDay3OLR_C.'</th>';
            }
            if ($day4_param > 0) {
                $item['card'] .= '  <th class="table-border">'.$totalPenInDay4OLR_C.'</th>
                <th class="table-border">'.$totalPenOutDay4OLR_C.'</th>
                <th class="table-border">'.$totalPenNumDay4OLR_C.'</th>';
            }
            if ($day5_param > 0) {
                $item['card'] .= '    <th class="table-border">'.$totalPenInDay5OLR_C.'</th>
                <th class="table-border">'.$totalPenOutDay5OLR_C.'</th>
                <th class="table-border">'.$totalPenNumDay5OLR_C.'</th>';
            }

            $grandTotalPenInOutOLR_C = $grandTotalPenInOLR_C - $grandTotalPenOutOLR_C;

        $item['card'] .='

                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br> </th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOLR_C.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenOutOLR_C.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$grandTotalPenInOutOLR_C.'</th>
                <th style=" text-align: center;"><span style="padding: 1rem 1rem"></span><br>'.$totalPenNumDay5OLR_C.'</th>
            
            </tr>';   
    
            $totalTotalBal3 = $totalBeginningBalSSS + $totalBeginningBalGSIS + $totalBeginningBalPNP + $totalBeginningBalPVAO + $totalBeginningBalOLR + $totalBeginningBalOLR_R_E + $totalBeginningBalOLR_H_L + $totalBeginningBalOLR_C;
            $totalLastTransactionBal3 = $totalLastTransactionBalSSS + $totalLastTransactionBalGSIS + $totalLastTransactionBalPNP + $totalLastTransactionBalPVAO + $totalLastTransactionBalOLR + $totalLastTransactionBalOLR_R_E + $totalLastTransactionBalOLR_H_L + $totalLastTransactionBalOLR_C;
            
            $item['card'] .= '
                <tr>
                    <th class="table-border" style="padding:1.2rem 1.5rem; color: gray;">TOTAL</th>
                    <th class="table-border">' . $totalTotalBal3 . '</th>
                    <th class="table-border">' . $totalLastTransactionBal3 . '</th>
            ';
            
            if ($day1_param > 0) {
                $totalPenInDay1 = $totalPenInDay1SSS + $totalPenInDay1GSIS + $totalPenInDay1PNP + $totalPenInDay1PVAO + $totalPenInDay1OLR + $totalPenInDay1OLR_R_E + $totalPenInDay1OLR_H_L + $totalPenInDay1OLR_C;
                $totalPenOutDay1 = $totalPenOutDay1SSS + $totalPenOutDay1GSIS + $totalPenOutDay1PNP + $totalPenOutDay1PVAO + $totalPenOutDay1OLR + $totalPenOutDay1OLR_R_E + $totalPenOutDay1OLR_H_L + $totalPenOutDay1OLR_C;
                $totalPenNumDay1 = $totalPenNumDay1SSS + $totalPenNumDay1GSIS + $totalPenNumDay1PNP + $totalPenNumDay1PVAO + $totalPenNumDay1OLR + $totalPenNumDay1OLR_R_E + $totalPenNumDay1OLR_H_L + $totalPenNumDay1OLR_C;
            
                $item['card'] .= '  
                    <th class="table-border">' . $totalPenInDay1 . '</th>
                    <th class="table-border">' . $totalPenOutDay1 . '</th>
                    <th class="table-border">' . $totalPenNumDay1 . '</th>';
            }
            
            if ($day2_param > 0) {
                $totalPenInDay2 = $totalPenInDay2SSS + $totalPenInDay2GSIS + $totalPenInDay2PNP + $totalPenInDay2PVAO + $totalPenInDay2OLR + $totalPenInDay2OLR_R_E + $totalPenInDay2OLR_H_L + $totalPenInDay2OLR_C;
                $totalPenOutDay2 = $totalPenOutDay2SSS + $totalPenOutDay2GSIS + $totalPenOutDay2PNP + $totalPenOutDay2PVAO + $totalPenOutDay2OLR + $totalPenOutDay2OLR_R_E + $totalPenOutDay2OLR_H_L + $totalPenOutDay2OLR_C;
                $totalPenNumDay2 = $totalPenNumDay2SSS + $totalPenNumDay2GSIS + $totalPenNumDay2PNP + $totalPenNumDay2PVAO + $totalPenNumDay2OLR + $totalPenNumDay2OLR_R_E + $totalPenNumDay2OLR_H_L + $totalPenNumDay2OLR_C;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay2 . '</th>
                    <th class="table-border">' . $totalPenOutDay2 . '</th>
                    <th class="table-border">' . $totalPenNumDay2 . '</th>';
            }
            
            if ($day3_param > 0) {
                $totalPenInDay3 = $totalPenInDay3SSS + $totalPenInDay3GSIS + $totalPenInDay3PNP + $totalPenInDay3PVAO + $totalPenInDay3OLR + $totalPenInDay3OLR_R_E + $totalPenInDay3OLR_H_L + $totalPenInDay3OLR_C;
                $totalPenOutDay3 = $totalPenOutDay3SSS + $totalPenOutDay3GSIS + $totalPenOutDay3PNP + $totalPenOutDay3PVAO + $totalPenOutDay3OLR + $totalPenOutDay3OLR_R_E + $totalPenOutDay3OLR_H_L + $totalPenOutDay3OLR_C;
                $totalPenNumDay3 = $totalPenNumDay3SSS + $totalPenNumDay3GSIS + $totalPenNumDay3PNP + $totalPenNumDay3PVAO + $totalPenNumDay3OLR + $totalPenNumDay3OLR_R_E + $totalPenNumDay3OLR_H_L + $totalPenNumDay3OLR_C;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay3 . '</th>
                    <th class="table-border">' . $totalPenOutDay3 . '</th>
                    <th class="table-border">' . $totalPenNumDay3 . '</th>';
            }
            
            if ($day4_param > 0) {
                $totalPenInDay4 = $totalPenInDay4SSS + $totalPenInDay4GSIS + $totalPenInDay4PNP + $totalPenInDay4PVAO + $totalPenInDay4OLR + $totalPenInDay4OLR_R_E + $totalPenInDay4OLR_H_L + $totalPenInDay4OLR_C;
                $totalPenOutDay4 = $totalPenOutDay4SSS + $totalPenOutDay4GSIS + $totalPenOutDay4PNP + $totalPenOutDay4PVAO + $totalPenOutDay4OLR + $totalPenOutDay4OLR_R_E + $totalPenOutDay4OLR_H_L + $totalPenOutDay4OLR_C;
                $totalPenNumDay4 = $totalPenNumDay4SSS + $totalPenNumDay4GSIS + $totalPenNumDay4PNP + $totalPenNumDay4PVAO + $totalPenNumDay4OLR + $totalPenNumDay4OLR_R_E + $totalPenNumDay4OLR_H_L + $totalPenNumDay4OLR_C;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay4 . '</th>
                    <th class="table-border">' . $totalPenOutDay4 . '</th>
                    <th class="table-border">' . $totalPenNumDay4 . '</th>';
            }
            
            if ($day5_param > 0) {
                $totalPenInDay5 = $totalPenInDay5SSS + $totalPenInDay5GSIS + $totalPenInDay5PNP + $totalPenInDay5PVAO + $totalPenInDay5OLR + $totalPenInDay5OLR_R_E + $totalPenInDay5OLR_H_L + $totalPenInDay5OLR_C;
                $totalPenOutDay5 = $totalPenOutDay5SSS + $totalPenOutDay5GSIS + $totalPenOutDay5PNP + $totalPenOutDay5PVAO + $totalPenOutDay5OLR + $totalPenOutDay5OLR_R_E + $totalPenOutDay5OLR_H_L + $totalPenOutDay5OLR_C;
                $totalPenNumDay5 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PNP + $totalPenNumDay5PVAO + $totalPenNumDay5OLR + $totalPenNumDay5OLR_R_E + $totalPenNumDay5OLR_H_L + $totalPenNumDay5OLR_C;
            
                $item['card'] .= ' 
                    <th class="table-border">' . $totalPenInDay5 . '</th>
                    <th class="table-border">' . $totalPenOutDay5 . '</th>
                    <th class="table-border">' . $totalPenNumDay5 . '</th>';
            }
            
            $grandTotalPenIn = $grandTotalPenInSSS + $grandTotalPenInGSIS + $grandTotalPenInPNP + $grandTotalPenInPVAO + $grandTotalPenInOLR + $grandTotalPenInOLR_R_E + $grandTotalPenInOLR_H_L + $grandTotalPenInOLR_C;
            $grandTotalPenOut = $grandTotalPenOutSSS + $grandTotalPenOutGSIS + $grandTotalPenOutPNP + $grandTotalPenOutPVAO + $grandTotalPenOutOLR + $grandTotalPenOutOLR_R_E + $grandTotalPenOutOLR_H_L + $grandTotalPenOutOLR_C;
            $netGrandTotal = $grandTotalPenIn - $grandTotalPenOut;
            $totalPenNumDay5 = $totalPenNumDay5SSS + $totalPenNumDay5GSIS + $totalPenNumDay5PNP + $totalPenNumDay5PVAO + $totalPenNumDay5OLR + $totalPenNumDay5OLR_R_E + $totalPenNumDay5OLR_H_L + $totalPenNumDay5OLR_C;
            
            $item['card'] .= '
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br></th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $grandTotalPenIn . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $grandTotalPenOut . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $netGrandTotal . '</th>
                <th style="text-align: center;"><span style="padding: 1rem 1rem"></span><br>' . $totalPenNumDay5 . '</th>
            </tr>';
            
            $item['card'] .=' 

            <tr><td colspan="25" class="invisible">d </td></tr>
                ';

            }
        echo json_encode($data1);  
    }

}