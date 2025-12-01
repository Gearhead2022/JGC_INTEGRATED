<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";

$filterSummary= new reportTable();
$filterSummary -> showAccountFilter();

class reportTable{
	public function showAccountFilter(){
 
        $dateFrom = $_GET['dateFrom']; /*get date input*/
        $branch_name_input = $_GET['branch_name_input']; /*get branch name input*/

        $dateFromYear = date('Y' , strtotime($dateFrom));

        // assign value for date start as jan one and year selected *//
        $dateStart = $dateFromYear.'-01-01';
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

            $dateFrom1 = date('Y-m-t', strtotime($dateFrom));
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
            /*Call function to loop each branch name to use as a parameter to another function */
       

        if ($branch_name_input === 'FCHN') {
            $data = (new ControllerPastdue)->ctrPastDueSummaryFCHNegross();
        } elseif ($branch_name_input === 'FCHM') {
            $data = (new ControllerPastdue)->ctrPastDueSummaryFCHManilas();
        } else{
            $data = (new ControllerPastdue)->ctrPastDueSummarys($branch_name_input);
        }
        
        
        /* Instatiate values used in calculation of total accounts and total amounts balances. */
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

            $item1['branch_name_clone'] = $branch_name_input;
            $item1['dateFrom_clone'] = $dateFrom;

            /* Loop each value branch names and use as parameter in function for calculation of balances. */

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

            /* Designate each values to variables */
            $total_balance1 = $dateResult1[0];  $count_accounts1 = $dateResult1[1];
            $total_balance2 = $dateResult2[0];  $count_accounts2 = $dateResult2[1];
            $total_balance3 = $dateResult3[0];  $count_accounts3 = $dateResult3[1];
            $total_balance4 = $dateResult4[0];  $count_accounts4 = $dateResult4[1];
            $total_balance5 = $dateResult5[0];  $count_accounts5 = $dateResult5[1];
            $total_balance6 = $dateResult6[0];  $count_accounts6 = $dateResult6[1];
            $total_balance7 = $dateResult7[0];  $count_accounts7 = $dateResult7[1];
            $total_balance8 = $dateResult8[0];  $count_accounts8 = $dateResult8[1];
            $total_balance9 = $dateResult9[0];  $count_accounts9 = $dateResult9[1];
            $total_balance10 = $dateResult10[0];  $count_accounts10 = $dateResult10[1];

            /* Check each value if less than 0 convert it into char '-' */
            // Assuming you have $total_balance1 calculated earlier

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

            /* Sum all balances in grand total variable */
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

             $branch_names = str_replace("RLC", "RFC", $branch_names);


            $item1['card'] ='
                <tr>
                    <td>'.$branch_names.'</td>
                    <td class="text-right border-bottom-0">'.$formatted_count_accounts1.'</td>
                    <td class="text-right">'.$formatted_count_accounts2.'</td>
                    <td class="text-right">'.$formatted_count_accounts3.'</td>
                    <td class="text-right">'.$formatted_count_accounts4.'</td>
                    <td class="text-right">'.$formatted_count_accounts5.'</td>
                    <td class="text-right">'.$formatted_count_accounts6.'</td>
                    <td class="text-right">'.$formatted_count_accounts7.'</td>
                    <td class="text-right">'.$formatted_count_accounts8.'</td>
                    <td class="text-right">'.$formatted_count_accounts9.'</td>
                    <td class="text-right">'.$formatted_count_accounts10.'</td>
                    <td class="text-right">'.$grand_total_accounts1.'</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-right">'.$formatted_preBal1.'</td>
                    <td class="text-right">'.$formatted_preBal2.'</td>
                    <td class="text-right">'.$formatted_preBal3.'</td>
                    <td class="text-right">'.$formatted_preBal4.'</td>
                    <td class="text-right">'.$formatted_preBal5.'</td>
                    <td class="text-right">'.$formatted_preBal6.'</td>
                    <td class="text-right">'.$formatted_preBal7.'</td>
                    <td class="text-right">'.$formatted_preBal8.'</td>
                    <td class="text-right">'.$formatted_preBal9.'</td>
                    <td class="text-right">'.$formatted_preBal10.'</td>
                    <td class="text-right">'.$formatted_grand_total1.'</td>
                </tr>
            ';

             /* Sum all account amount balances per year */
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

            /* Sum all accounts with balances per year */
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

        
        /* Format each values total balances per year into two decimal places. */
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

        
        $item1['card'] .='

        <tr>
            <td></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>                                                                                                                                                                                                                  
        </tr>
        <tr>
            <td></td>
            <td class="text-right">'.$formatted_total_count_accounts1.'</td>
            <td class="text-right">'.$formatted_total_count_accounts2.'</td>
            <td class="text-right">'.$formatted_total_count_accounts3.'</td>
            <td class="text-right">'.$formatted_total_count_accounts4.'</td>
            <td class="text-right">'.$formatted_total_count_accounts5.'</td>
            <td class="text-right">'.$formatted_total_count_accounts6.'</td>
            <td class="text-right">'.$formatted_total_count_accounts7.'</td>
            <td class="text-right">'.$formatted_total_count_accounts8.'</td>
            <td class="text-right">'.$formatted_total_count_accounts9.'</td>
            <td class="text-right">'.$formatted_total_count_accounts10.'</td>
            <td class="text-right">'.$formatted_grand_total_count_accounts.'</td>                                                                                                                                                                                                                  
        </tr>
        <tr>
            <td>GRAND TOTAL</td>
            <td class="text-right">'.$formatted_total_balance_per_year1.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year2.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year3.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year4.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year5.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year6.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year7.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year8.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year9.'</td>
            <td class="text-right">'.$formatted_total_balance_per_year10.'</td>
            <td class="text-right">'.$formatted_grand_total_balance.'</td>
        </tr>
        ';

    
        echo json_encode($data);

        
    }

    
   
}