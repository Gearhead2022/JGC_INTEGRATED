<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../models/connection.php";

$connection = new connection;
$connection->connect();

$filterDailyAvailments = new pensionerTable();
$filterDailyAvailments->showDailyAvailmentsReport();

class pensionerTable{
	public function showDailyAvailmentsReport(){
 
        $avl_date = $_GET['avl_date'];
        $current_date = date('Y-m-d', strtotime($avl_date));
        $previous_date = date('Y-m-d', strtotime(' -1 day',strtotime($avl_date)));

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
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> EMB BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($previous_date)).'</th>
                <th></th>
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> EMB BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($current_date)).'</th>
                <th></th>
                
            </tr>
            <tr>    
                <th>7 - 8 AM</th>
                <th>8 - 9 AM</th>
                <th>9 - 10 AM</th>
                <th>10 - 11 AM</th>
                <th>11 - 12 NN</th>
                <th>12 - 1 PM</th>
                <th>1 - 2 PM</th>
                <th>2 - 3 PM</th>
                <th>3 - 5 PM</th>
                <th></th>
                <th>7 - 8 AM</th>
                <th>8 - 9 AM</th>
                <th>9 - 10 AM</th>
                <th>10 - 11 AM</th>
                <th>11 - 12 NN</th>
                <th>12 - 1 PM</th>
                <th>1 - 2 PM</th>
                <th>2 - 3 PM</th>
                <th>3 - 5 PM</th>
                <th></th>
               
            </tr>
  
            <tbody>
            ';

            $total_hourly_prev_emb_data1  = 0;
            $total_hourly_prev_emb_data2  = 0;
            $total_hourly_prev_emb_data3  = 0;
            $total_hourly_prev_emb_data4  = 0;
            $total_hourly_prev_emb_data5  = 0;
            $total_hourly_prev_emb_data6  = 0;
            $total_hourly_prev_emb_data7  = 0;
            $total_hourly_prev_emb_data8  = 0;
            $total_hourly_prev_emb_data9  = 0;

            $total_hourly_cur_emb_data1 = 0;
            $total_hourly_cur_emb_data2 = 0;
            $total_hourly_cur_emb_data3 = 0;
            $total_hourly_cur_emb_data4 = 0;
            $total_hourly_cur_emb_data5 = 0;
            $total_hourly_cur_emb_data6 = 0;
            $total_hourly_cur_emb_data7 = 0;
            $total_hourly_cur_emb_data8 = 0;
            $total_hourly_cur_emb_data9 = 0;

            $data_EMB = (new ControllerPensioner)->ctrGetBranches('EMB');

            foreach ($data_EMB as &$item_EMB) {

                $branch_names = $item_EMB['branch_name'];

                $hourly_prev_emb_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '7:00:00','7:59:59');
                $hourly_prev_emb_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '8:00:00','8:59:59');
                $hourly_prev_emb_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '9:00:00','9:59:59');
                $hourly_prev_emb_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '10:00:00','10:59:59');
                $hourly_prev_emb_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '11:00:00','11:59:59');
                $hourly_prev_emb_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '12:00:00','12:59:59');
                $hourly_prev_emb_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '1:00:00','1:59:59');
                $hourly_prev_emb_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '2:00:00','2:59:59');
                $hourly_prev_emb_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '3:00:00','4:59:59');

                $hourly_cur_emb_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '7:00:00','7:59:59');
                $hourly_cur_emb_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '8:00:00','8:59:59');
                $hourly_cur_emb_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '9:00:00','9:59:59');
                $hourly_cur_emb_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '10:00:00','10:59:59');
                $hourly_cur_emb_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '11:00:00','11:59:59');
                $hourly_cur_emb_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '12:00:00','12:59:59');
                $hourly_cur_emb_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '1:00:00','1:59:59');
                $hourly_cur_emb_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '2:00:00','2:59:59');
                $hourly_cur_emb_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '3:00:00','4:59:59');

                $total_hourly_prev_emb_data = $hourly_prev_emb_data_1 + $hourly_prev_emb_data_2 + $hourly_prev_emb_data_3
                + $hourly_prev_emb_data_4 + $hourly_prev_emb_data_5 + $hourly_prev_emb_data_6 + $hourly_prev_emb_data_7
                + $hourly_prev_emb_data_8 + $hourly_prev_emb_data_9;

                $total_hourly_cur_emb_data = $hourly_cur_emb_data_1 + $hourly_cur_emb_data_2 + $hourly_cur_emb_data_3
                + $hourly_cur_emb_data_4 + $hourly_cur_emb_data_5 + $hourly_cur_emb_data_6 + $hourly_cur_emb_data_7
                + $hourly_cur_emb_data_8 + $hourly_cur_emb_data_9;

                $item['card'] .='
                <tr>
                    <td>'.$branch_names.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_1.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_2.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_3.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_4.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_5.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_6.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_7.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_8.'</td>
                    <td class="text-right">'.$hourly_prev_emb_data_9.'</td>
                    <td class="text-right" style="background-color: #96938c;">'.$total_hourly_prev_emb_data.'</td>
                    <td>'.$branch_names.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_1.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_2.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_3.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_4.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_5.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_6.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_7.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_8.'</td>
                    <td class="text-right">'.$hourly_cur_emb_data_9.'</td>
                    <td class="text-right" style="background-color: #96938c;">'.$total_hourly_cur_emb_data.'</td>
                
                </tr>
            
                ';

                $total_hourly_prev_emb_data1 += $hourly_prev_emb_data_1;
                $total_hourly_prev_emb_data2 += $hourly_prev_emb_data_2;
                $total_hourly_prev_emb_data3 += $hourly_prev_emb_data_3;
                $total_hourly_prev_emb_data4 += $hourly_prev_emb_data_4;
                $total_hourly_prev_emb_data5 += $hourly_prev_emb_data_5;
                $total_hourly_prev_emb_data6 += $hourly_prev_emb_data_6;
                $total_hourly_prev_emb_data7 += $hourly_prev_emb_data_7;
                $total_hourly_prev_emb_data8 += $hourly_prev_emb_data_8;
                $total_hourly_prev_emb_data9 += $hourly_prev_emb_data_9;

                $total_hourly_cur_emb_data1 += $hourly_cur_emb_data_1;
                $total_hourly_cur_emb_data2 += $hourly_cur_emb_data_2;
                $total_hourly_cur_emb_data3 += $hourly_cur_emb_data_3;
                $total_hourly_cur_emb_data4 += $hourly_cur_emb_data_4;
                $total_hourly_cur_emb_data5 += $hourly_cur_emb_data_5;
                $total_hourly_cur_emb_data6 += $hourly_cur_emb_data_6;
                $total_hourly_cur_emb_data7 += $hourly_cur_emb_data_7;
                $total_hourly_cur_emb_data8 += $hourly_cur_emb_data_8;
                $total_hourly_cur_emb_data9 += $hourly_cur_emb_data_9;

                }

                $sub_total_hourly_prev_emb_data = $total_hourly_prev_emb_data1 + $total_hourly_prev_emb_data2 +$total_hourly_prev_emb_data3
                + $total_hourly_prev_emb_data4 + $total_hourly_prev_emb_data5 + $total_hourly_prev_emb_data6 + $total_hourly_prev_emb_data7
                + $total_hourly_prev_emb_data8 + $total_hourly_prev_emb_data9;

                $sub_total_hourly_cur_emb_data = $total_hourly_cur_emb_data1 + $total_hourly_cur_emb_data2 +$total_hourly_cur_emb_data3
                + $total_hourly_cur_emb_data4 + $total_hourly_cur_emb_data5 + $total_hourly_cur_emb_data6 + $total_hourly_cur_emb_data7
                + $total_hourly_cur_emb_data8 + $total_hourly_cur_emb_data9;

                $item['card'] .='
                <tr>
                    <td class="text-danger">SUB TOTAL</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data1.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data2.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data3.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data4.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data5.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data6.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data7.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data8.'</td>
                    <td class="text-right">'.$total_hourly_prev_emb_data9.'</td>
                    <td class="text-right">'.$sub_total_hourly_prev_emb_data.'</td>
                    <td class="text-danger">SUB TOTAL</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data1.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data2.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data3.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data4.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data5.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data6.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data7.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data8.'</td>
                    <td class="text-right">'.$total_hourly_cur_emb_data9.'</td>
                    <td class="text-right">'.$sub_total_hourly_cur_emb_data.'</td>
                  
                </tr>
             
                ';

                $item['card'] .='
            
                <tr>    
                    <th colspan="22"></th>
                      
                </tr>
      
                ';


                $item['card'] .='
               
                <tr>
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> FCH BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($previous_date)).'</th>
                <th></th>
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> FCH BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($current_date)).'</th>
                <th></th>
                
            </tr>
                <tr>    
                    <th>7 - 8 AM</th>
                    <th>8 - 9 AM</th>
                    <th>9 - 10 AM</th>
                    <th>10 - 11 AM</th>
                    <th>11 - 12 NN</th>
                    <th>12 - 1 PM</th>
                    <th>1 - 2 PM</th>
                    <th>2 - 3 PM</th>
                    <th>3 - 5 PM</th>
                    <th></th>
                    <th>7 - 8 AM</th>
                    <th>8 - 9 AM</th>
                    <th>9 - 10 AM</th>
                    <th>10 - 11 AM</th>
                    <th>11 - 12 NN</th>
                    <th>12 - 1 PM</th>
                    <th>1 - 2 PM</th>
                    <th>2 - 3 PM</th>
                    <th>3 - 5 PM</th>
                    <th></th>
                   
                </tr>
      
                ';

                $total_hourly_prev_fch_data1  = 0;
                $total_hourly_prev_fch_data2  = 0;
                $total_hourly_prev_fch_data3  = 0;
                $total_hourly_prev_fch_data4  = 0;
                $total_hourly_prev_fch_data5  = 0;
                $total_hourly_prev_fch_data6  = 0;
                $total_hourly_prev_fch_data7  = 0;
                $total_hourly_prev_fch_data8  = 0;
                $total_hourly_prev_fch_data9  = 0;

                $total_hourly_cur_fch_data1 = 0;
                $total_hourly_cur_fch_data2 = 0;
                $total_hourly_cur_fch_data3 = 0;
                $total_hourly_cur_fch_data4 = 0;
                $total_hourly_cur_fch_data5 = 0;
                $total_hourly_cur_fch_data6 = 0;
                $total_hourly_cur_fch_data7 = 0;
                $total_hourly_cur_fch_data8 = 0;
                $total_hourly_cur_fch_data9 = 0;

                
            $data_FCH = (new ControllerPensioner)->ctrGetBranches('FCH');

            foreach ($data_FCH as &$item_FCH) {

                $branch_names = $item_FCH['branch_name'];

                $hourly_prev_fch_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '7:00:00','7:59:59');
                $hourly_prev_fch_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '8:00:00','8:59:59');
                $hourly_prev_fch_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '9:00:00','9:59:59');
                $hourly_prev_fch_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '10:00:00','10:59:59');
                $hourly_prev_fch_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '11:00:00','11:59:59');
                $hourly_prev_fch_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '12:00:00','12:59:59');
                $hourly_prev_fch_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '1:00:00','1:59:59');
                $hourly_prev_fch_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '2:00:00','2:59:59');
                $hourly_prev_fch_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '3:00:00','4:59:59');

                $hourly_cur_fch_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '7:00:00','7:59:59');
                $hourly_cur_fch_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '8:00:00','8:59:59');
                $hourly_cur_fch_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '9:00:00','9:59:59');
                $hourly_cur_fch_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '10:00:00','10:59:59');
                $hourly_cur_fch_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '11:00:00','11:59:59');
                $hourly_cur_fch_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '12:00:00','12:59:59');
                $hourly_cur_fch_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '1:00:00','1:59:59');
                $hourly_cur_fch_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '2:00:00','2:59:59');
                $hourly_cur_fch_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '3:00:00','4:59:59');

                $total_hourly_prev_fch_data = $hourly_prev_fch_data_1 + $hourly_prev_fch_data_2 + $hourly_prev_fch_data_3
                + $hourly_prev_fch_data_4 + $hourly_prev_fch_data_5 + $hourly_prev_fch_data_6 + $hourly_prev_fch_data_7
                + $hourly_prev_fch_data_8 + $hourly_prev_fch_data_9;

                $total_hourly_cur_fch_data = $hourly_cur_fch_data_1 + $hourly_cur_fch_data_2 + $hourly_cur_fch_data_3
                + $hourly_cur_fch_data_4 + $hourly_cur_fch_data_5 + $hourly_cur_fch_data_6 + $hourly_cur_fch_data_7
                + $hourly_cur_fch_data_8 + $hourly_cur_fch_data_9;

                $item['card'] .='
                <tr>
                    <td>'.$branch_names.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_1.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_2.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_3.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_4.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_5.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_6.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_7.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_8.'</td>
                    <td class="text-right">'.$hourly_prev_fch_data_9.'</td>_fch
                    <td class="text-right" style="background-color: #96938c;">'.$total_hourly_prev_fch_data.'</td>
                    <td>'.$branch_names.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_1.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_2.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_3.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_4.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_5.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_6.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_7.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_8.'</td>
                    <td class="text-right">'.$hourly_cur_fch_data_9.'</td>
                    <td class="text-right" style="background-color: #96938c;">'.$total_hourly_cur_fch_data.'</td>
                  
                </tr>
             
                ';

                $total_hourly_prev_fch_data1 += $hourly_prev_fch_data_1;
                $total_hourly_prev_fch_data2 += $hourly_prev_fch_data_2;
                $total_hourly_prev_fch_data3 += $hourly_prev_fch_data_3;
                $total_hourly_prev_fch_data4 += $hourly_prev_fch_data_4;
                $total_hourly_prev_fch_data5 += $hourly_prev_fch_data_5;
                $total_hourly_prev_fch_data6 += $hourly_prev_fch_data_6;
                $total_hourly_prev_fch_data7 += $hourly_prev_fch_data_7;
                $total_hourly_prev_fch_data8 += $hourly_prev_fch_data_8;
                $total_hourly_prev_fch_data9 += $hourly_prev_fch_data_8;

                $total_hourly_cur_fch_data1 += $hourly_cur_fch_data_1;
                $total_hourly_cur_fch_data2 += $hourly_cur_fch_data_2;
                $total_hourly_cur_fch_data3 += $hourly_cur_fch_data_3;
                $total_hourly_cur_fch_data4 += $hourly_cur_fch_data_4;
                $total_hourly_cur_fch_data5 += $hourly_cur_fch_data_5;
                $total_hourly_cur_fch_data6 += $hourly_cur_fch_data_6;
                $total_hourly_cur_fch_data7 += $hourly_cur_fch_data_7;
                $total_hourly_cur_fch_data8 += $hourly_cur_fch_data_8;
                $total_hourly_cur_fch_data9 += $hourly_cur_fch_data_8;

                $sub_total_hourly_prev_fch_data = $total_hourly_prev_fch_data1 + $total_hourly_prev_fch_data2 +$total_hourly_prev_fch_data3
                + $total_hourly_prev_fch_data4 + $total_hourly_prev_fch_data5 + $total_hourly_prev_fch_data6 + $total_hourly_prev_fch_data7
                + $total_hourly_prev_fch_data8 + $total_hourly_prev_fch_data9;

                $sub_total_hourly_cur_fch_data = $total_hourly_cur_fch_data1 + $total_hourly_cur_fch_data2 +$total_hourly_cur_fch_data3
                + $total_hourly_cur_fch_data4 + $total_hourly_cur_fch_data5 + $total_hourly_cur_fch_data6 + $total_hourly_cur_fch_data7
                + $total_hourly_cur_fch_data8 + $total_hourly_cur_fch_data9;

                }

                $item['card'] .='
                <tr>
                    <td class="text-danger">SUB TOTAL</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data1.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data2.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data3.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data4.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data5.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data6.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data7.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data8.'</td>
                    <td class="text-right">'.$total_hourly_prev_fch_data9.'</td>
                    <td class="text-right">'.$sub_total_hourly_prev_fch_data.'</td>
                    <td class="text-danger">SUB TOTAL</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data1.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data2.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data3.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data4.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data5.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data6.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data7.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data8.'</td>
                    <td class="text-right">'.$total_hourly_cur_fch_data9.'</td>
                    <td class="text-right">'.$sub_total_hourly_cur_fch_data.'</td>
                  
                </tr>
             
                ';

                $item['card'] .='
            
                <tr>    
                    <th colspan="22"></th>
                      
                </tr>
      
                ';

                $item['card'] .='
               
                <tr>
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> RLC BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($previous_date)).'</th>
                <th></th>
                <th colspan="1" style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> RLC BRANCHES <br><span style="visibility:hidden;">S</span></th>
                <th colspan="9" style="text-align:center; font-size: 15px;">'.date('m-d-y', strtotime($current_date)).'</th>
                <th></th>
                
            </tr>
                <tr>    
                    <th>7 - 8 AM</th>
                    <th>8 - 9 AM</th>
                    <th>9 - 10 AM</th>
                    <th>10 - 11 AM</th>
                    <th>11 - 12 NN</th>
                    <th>12 - 1 PM</th>
                    <th>1 - 2 PM</th>
                    <th>2 - 3 PM</th>
                    <th>3 - 5 PM</th>
                    <th></th>
                    <th>7 - 8 AM</th>
                    <th>8 - 9 AM</th>
                    <th>9 - 10 AM</th>
                    <th>10 - 11 AM</th>
                    <th>11 - 12 NN</th>
                    <th>12 - 1 PM</th>
                    <th>1 - 2 PM</th>
                    <th>2 - 3 PM</th>
                    <th>3 - 5 PM</th>
                    <th></th>
                   
                </tr>
      
                ';

                $total_hourly_prev_rlc_data1  = 0;
                $total_hourly_prev_rlc_data2  = 0;
                $total_hourly_prev_rlc_data3  = 0;
                $total_hourly_prev_rlc_data4  = 0;
                $total_hourly_prev_rlc_data5  = 0;
                $total_hourly_prev_rlc_data6  = 0;
                $total_hourly_prev_rlc_data7  = 0;
                $total_hourly_prev_rlc_data8  = 0;
                $total_hourly_prev_rlc_data9  = 0;

                $total_hourly_cur_rlc_data1 = 0;
                $total_hourly_cur_rlc_data2 = 0;
                $total_hourly_cur_rlc_data3 = 0;
                $total_hourly_cur_rlc_data4 = 0;
                $total_hourly_cur_rlc_data5 = 0;
                $total_hourly_cur_rlc_data6 = 0;
                $total_hourly_cur_rlc_data7 = 0;
                $total_hourly_cur_rlc_data8 = 0;
                $total_hourly_cur_rlc_data9 = 0;


                $data_RLC = (new ControllerPensioner)->ctrGetBranches('RLC');

                foreach ($data_RLC as &$item_RLC) {
    
                    $branch_names = $item_RLC['branch_name'];

                    $hourly_prev_rlc_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '7:00:00','7:59:59');
                    $hourly_prev_rlc_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '8:00:00','8:59:59');
                    $hourly_prev_rlc_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '9:00:00','9:59:59');
                    $hourly_prev_rlc_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '10:00:00','10:59:59');
                    $hourly_prev_rlc_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '11:00:00','11:59:59');
                    $hourly_prev_rlc_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '12:00:00','12:59:59');
                    $hourly_prev_rlc_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '1:00:00','1:59:59');
                    $hourly_prev_rlc_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '2:00:00','2:59:59');
                    $hourly_prev_rlc_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '3:00:00','4:59:59');
    
                    $hourly_cur_rlc_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '7:00:00','7:59:59');
                    $hourly_cur_rlc_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '8:00:00','8:59:59');
                    $hourly_cur_rlc_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '9:00:00','9:59:59');
                    $hourly_cur_rlc_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '10:00:00','10:59:59');
                    $hourly_cur_rlc_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '11:00:00','11:59:59');
                    $hourly_cur_rlc_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '12:00:00','12:59:59');
                    $hourly_cur_rlc_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '1:00:00','1:59:59');
                    $hourly_cur_rlc_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '2:00:00','2:59:59');
                    $hourly_cur_rlc_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '3:00:00','4:59:59');

                    $total_hourly_prev_rlc_data = $hourly_prev_rlc_data_1 + $hourly_prev_rlc_data_2 + $hourly_prev_rlc_data_3
                    + $hourly_prev_rlc_data_4 + $hourly_prev_rlc_data_5 + $hourly_prev_rlc_data_6 + $hourly_prev_rlc_data_7
                    + $hourly_prev_rlc_data_8 + $hourly_prev_rlc_data_9;
    
                    $total_hourly_cur_rlc_data = $hourly_cur_rlc_data_1 + $hourly_cur_rlc_data_2 + $hourly_cur_rlc_data_3
                    + $hourly_cur_rlc_data_4 + $hourly_cur_rlc_data_5 + $hourly_cur_rlc_data_6 + $hourly_cur_rlc_data_7
                    + $hourly_cur_rlc_data_8 + $hourly_cur_rlc_data_9;
    
                    $item['card'] .='
                    <tr>
                        <td>'.$branch_names.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_1.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_2.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_3.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_4.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_5.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_6.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_7.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_8.'</td>
                        <td class="text-right">'.$hourly_prev_rlc_data_9.'</td>
                        <td class="text-right" style="background-color: #96938c;">'.$total_hourly_prev_rlc_data.'</td>
                        <td>'.$branch_names.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_1.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_2.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_3.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_4.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_5.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_6.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_7.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_8.'</td>
                        <td class="text-right">'.$hourly_cur_rlc_data_9.'</td>
                        <td class="text-right" style="background-color: #96938c;">'.$total_hourly_cur_rlc_data.'</td>
                    
                    </tr>
                
                    ';
    
    
                    $total_hourly_prev_rlc_data1 += $hourly_prev_rlc_data_1;
                    $total_hourly_prev_rlc_data2 += $hourly_prev_rlc_data_2;
                    $total_hourly_prev_rlc_data3 += $hourly_prev_rlc_data_3;
                    $total_hourly_prev_rlc_data4 += $hourly_prev_rlc_data_4;
                    $total_hourly_prev_rlc_data5 += $hourly_prev_rlc_data_5;
                    $total_hourly_prev_rlc_data6 += $hourly_prev_rlc_data_6;
                    $total_hourly_prev_rlc_data7 += $hourly_prev_rlc_data_7;
                    $total_hourly_prev_rlc_data8 += $hourly_prev_rlc_data_8;
                    $total_hourly_prev_rlc_data9 += $hourly_prev_rlc_data_8;
    
                    $total_hourly_cur_rlc_data1 += $hourly_cur_rlc_data_1;
                    $total_hourly_cur_rlc_data2 += $hourly_cur_rlc_data_2;
                    $total_hourly_cur_rlc_data3 += $hourly_cur_rlc_data_3;
                    $total_hourly_cur_rlc_data4 += $hourly_cur_rlc_data_4;
                    $total_hourly_cur_rlc_data5 += $hourly_cur_rlc_data_5;
                    $total_hourly_cur_rlc_data6 += $hourly_cur_rlc_data_6;
                    $total_hourly_cur_rlc_data7 += $hourly_cur_rlc_data_7;
                    $total_hourly_cur_rlc_data8 += $hourly_cur_rlc_data_8;
                    $total_hourly_cur_rlc_data9 += $hourly_cur_rlc_data_8;
    
                    }

                    $sub_total_hourly_prev_rlc_data = $total_hourly_prev_rlc_data1 + $total_hourly_prev_rlc_data2 +$total_hourly_prev_rlc_data3
                    + $total_hourly_prev_rlc_data4 + $total_hourly_prev_rlc_data5 + $total_hourly_prev_rlc_data6 + $total_hourly_prev_rlc_data7
                    + $total_hourly_prev_rlc_data8 + $total_hourly_prev_rlc_data9;
    
                    $sub_total_hourly_cur_rlc_data = $total_hourly_cur_rlc_data1 + $total_hourly_cur_rlc_data2 +$total_hourly_cur_rlc_data3
                    + $total_hourly_cur_rlc_data4 + $total_hourly_cur_rlc_data5 + $total_hourly_cur_rlc_data6 + $total_hourly_cur_rlc_data7
                    + $total_hourly_cur_rlc_data8 + $total_hourly_cur_rlc_data9;
    
    
                    $item['card'] .='
                    <tr>
                        <td class="text-danger">SUB TOTAL</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data1.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data2.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data3.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data4.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data5.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data6.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data7.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data8.'</td>
                        <td class="text-right">'.$total_hourly_prev_rlc_data9.'</td>
                        <td class="text-right">'.$sub_total_hourly_prev_rlc_data.'</td>
                        <td class="text-danger">SUB TOTAL</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data1.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data2.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data3.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data4.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data5.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data6.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data7.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data8.'</td>
                        <td class="text-right">'.$total_hourly_cur_rlc_data9.'</td>
                        <td class="text-right">'.$sub_total_hourly_cur_rlc_data.'</td>
                      
                    </tr>
                 
                    ';

                    $item['card'] .='
            
                    <tr>    
                        <th colspan="22"></th>
                          
                    </tr>
          
                    ';

                    $total_hourly_prev_elc_data1  = 0;
                    $total_hourly_prev_elc_data2  = 0;
                    $total_hourly_prev_elc_data3  = 0;
                    $total_hourly_prev_elc_data4  = 0;
                    $total_hourly_prev_elc_data5  = 0;
                    $total_hourly_prev_elc_data6  = 0;
                    $total_hourly_prev_elc_data7  = 0;
                    $total_hourly_prev_elc_data8  = 0;
                    $total_hourly_prev_elc_data9  = 0;
    
                    $total_hourly_cur_elc_data1 = 0;
                    $total_hourly_cur_elc_data2 = 0;
                    $total_hourly_cur_elc_data3 = 0;
                    $total_hourly_cur_elc_data4 = 0;
                    $total_hourly_cur_elc_data5 = 0;
                    $total_hourly_cur_elc_data6 = 0;
                    $total_hourly_cur_elc_data7 = 0;
                    $total_hourly_cur_elc_data8 = 0;
                    $total_hourly_cur_elc_data9 = 0;
    

                $data_ELC = (new ControllerPensioner)->ctrGetBranches('ELC');

                foreach ($data_ELC as &$item_ELC) {
    
                    $branch_names = $item_ELC['branch_name'];

                    $hourly_prev_elc_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '7:00:00','7:59:59');
                    $hourly_prev_elc_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '8:00:00','8:59:59');
                    $hourly_prev_elc_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '9:00:00','9:59:59');
                    $hourly_prev_elc_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '10:00:00','10:59:59');
                    $hourly_prev_elc_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '11:00:00','11:59:59');
                    $hourly_prev_elc_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '12:00:00','12:59:59');
                    $hourly_prev_elc_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '1:00:00','1:59:59');
                    $hourly_prev_elc_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '2:00:00','2:59:59');
                    $hourly_prev_elc_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $previous_date, '3:00:00','4:59:59');
    
                    $hourly_cur_elc_data_1 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '7:00:00','7:59:59');
                    $hourly_cur_elc_data_2 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '8:00:00','8:59:59');
                    $hourly_cur_elc_data_3 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '9:00:00','9:59:59');
                    $hourly_cur_elc_data_4 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '10:00:00','10:59:59');
                    $hourly_cur_elc_data_5 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '11:00:00','11:59:59');
                    $hourly_cur_elc_data_6 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '12:00:00','12:59:59');
                    $hourly_cur_elc_data_7 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '1:00:00','1:59:59');
                    $hourly_cur_elc_data_8 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '2:00:00','2:59:59');
                    $hourly_cur_elc_data_9 = (new ControllerPensioner)->ctrGetHourlyData($branch_names, $current_date, '3:00:00','4:59:59');

                    $total_hourly_prev_elc_data = $hourly_prev_elc_data_1 + $hourly_prev_elc_data_2 + $hourly_prev_elc_data_3
                    + $hourly_prev_elc_data_4 + $hourly_prev_elc_data_5 + $hourly_prev_elc_data_6 + $hourly_prev_elc_data_7
                    + $hourly_prev_elc_data_8 + $hourly_prev_elc_data_9;
    
                    $total_hourly_cur_elc_data = $hourly_cur_elc_data_1 + $hourly_cur_elc_data_2 + $hourly_cur_elc_data_3
                    + $hourly_cur_elc_data_4 + $hourly_cur_elc_data_5 + $hourly_cur_elc_data_6 + $hourly_cur_elc_data_7
                    + $hourly_cur_elc_data_8 + $hourly_cur_elc_data_9;
    
                    $item['card'] .='
                    <tr>
                        <td>'.$branch_names.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_1.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_2.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_3.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_4.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_5.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_6.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_7.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_8.'</td>
                        <td class="text-right">'.$hourly_prev_elc_data_9.'</td>
                        <td class="text-right" style="background-color: #96938c;">'.$total_hourly_prev_elc_data.'</td>
                        <td>'.$branch_names.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_1.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_2.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_3.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_4.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_5.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_6.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_7.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_8.'</td>
                        <td class="text-right">'.$hourly_cur_elc_data_9.'</td>
                        <td class="text-right" style="background-color: #96938c;">'.$total_hourly_cur_elc_data.'</td>
                    
                    </tr>
                
                    ';
    
    
                    $total_hourly_prev_elc_data1 += $hourly_prev_elc_data_1;
                    $total_hourly_prev_elc_data2 += $hourly_prev_elc_data_2;
                    $total_hourly_prev_elc_data3 += $hourly_prev_elc_data_3;
                    $total_hourly_prev_elc_data4 += $hourly_prev_elc_data_4;
                    $total_hourly_prev_elc_data5 += $hourly_prev_elc_data_5;
                    $total_hourly_prev_elc_data6 += $hourly_prev_elc_data_6;
                    $total_hourly_prev_elc_data7 += $hourly_prev_elc_data_7;
                    $total_hourly_prev_elc_data8 += $hourly_prev_elc_data_8;
                    $total_hourly_prev_elc_data9 += $hourly_prev_elc_data_8;
    
                    $total_hourly_cur_elc_data1 += $hourly_cur_elc_data_1;
                    $total_hourly_cur_elc_data2 += $hourly_cur_elc_data_2;
                    $total_hourly_cur_elc_data3 += $hourly_cur_elc_data_3;
                    $total_hourly_cur_elc_data4 += $hourly_cur_elc_data_4;
                    $total_hourly_cur_elc_data5 += $hourly_cur_elc_data_5;
                    $total_hourly_cur_elc_data6 += $hourly_cur_elc_data_6;
                    $total_hourly_cur_elc_data7 += $hourly_cur_elc_data_7;
                    $total_hourly_cur_elc_data8 += $hourly_cur_elc_data_8;
                    $total_hourly_cur_elc_data9 += $hourly_cur_elc_data_8;
    
    
                    }

                    $sub_total_hourly_prev_elc_data = $total_hourly_prev_elc_data1 + $total_hourly_prev_elc_data2 +$total_hourly_prev_elc_data3
                    + $total_hourly_prev_elc_data4 + $total_hourly_prev_elc_data5 + $total_hourly_prev_elc_data6 + $total_hourly_prev_elc_data7
                    + $total_hourly_prev_elc_data8 + $total_hourly_prev_elc_data9;
    
                    $sub_total_hourly_cur_elc_data = $total_hourly_cur_elc_data1 + $total_hourly_cur_elc_data2 +$total_hourly_cur_elc_data3
                    + $total_hourly_cur_elc_data4 + $total_hourly_cur_elc_data5 + $total_hourly_cur_elc_data6 + $total_hourly_cur_elc_data7
                    + $total_hourly_cur_elc_data8 + $total_hourly_cur_elc_data9;
    
    
                    $item['card'] .='
                    <tr>
                        <td class="text-danger">SUB TOTAL</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data1.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data2.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data3.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data4.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data5.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data6.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data7.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data8.'</td>
                        <td class="text-right">'.$total_hourly_prev_elc_data9.'</td>
                        <td class="text-right">'.$sub_total_hourly_prev_elc_data.'</td>
                        <td class="text-danger">SUB TOTAL</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data1.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data2.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data3.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data4.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data5.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data6.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data7.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data8.'</td>
                        <td class="text-right">'.$total_hourly_cur_elc_data9.'</td>
                        <td class="text-right">'.$sub_total_hourly_cur_elc_data.'</td>
                      
                    </tr>
                 
                    ';
                    $item['card'] .='
            
                    <tr>    
                        <th colspan="22"></th>
                          
                    </tr>
          
                    ';

                    $grand_total_hourly_prev_data1  = $total_hourly_prev_emb_data1 + $total_hourly_prev_fch_data1 + $total_hourly_prev_rlc_data1 + $total_hourly_prev_elc_data1;
                    $grand_total_hourly_prev_data2  = $total_hourly_prev_emb_data2 + $total_hourly_prev_fch_data2 + $total_hourly_prev_rlc_data2 + $total_hourly_prev_elc_data2;
                    $grand_total_hourly_prev_data3  = $total_hourly_prev_emb_data3 + $total_hourly_prev_fch_data3 + $total_hourly_prev_rlc_data3 + $total_hourly_prev_elc_data3;
                    $grand_total_hourly_prev_data4  = $total_hourly_prev_emb_data4 + $total_hourly_prev_fch_data4 + $total_hourly_prev_rlc_data4 + $total_hourly_prev_elc_data4;
                    $grand_total_hourly_prev_data5  = $total_hourly_prev_emb_data5 + $total_hourly_prev_fch_data5 + $total_hourly_prev_rlc_data5 + $total_hourly_prev_elc_data5;
                    $grand_total_hourly_prev_data6  = $total_hourly_prev_emb_data6 + $total_hourly_prev_fch_data6 + $total_hourly_prev_rlc_data6 + $total_hourly_prev_elc_data6;
                    $grand_total_hourly_prev_data7  = $total_hourly_prev_emb_data7 + $total_hourly_prev_fch_data7 + $total_hourly_prev_rlc_data7 + $total_hourly_prev_elc_data7;
                    $grand_total_hourly_prev_data8  = $total_hourly_prev_emb_data8 + $total_hourly_prev_fch_data8 + $total_hourly_prev_rlc_data8 + $total_hourly_prev_elc_data8;
                    $grand_total_hourly_prev_data9  = $total_hourly_prev_emb_data9 + $total_hourly_prev_fch_data9 + $total_hourly_prev_rlc_data9 + $total_hourly_prev_elc_data9;
        
                    $grand_total_hourly_cur_data1 = $total_hourly_cur_emb_data1 + $total_hourly_cur_fch_data1 + $total_hourly_cur_rlc_data1 + $total_hourly_cur_elc_data1;
                    $grand_total_hourly_cur_data2 = $total_hourly_cur_emb_data2 + $total_hourly_cur_fch_data2 + $total_hourly_cur_rlc_data2 + $total_hourly_cur_elc_data2;
                    $grand_total_hourly_cur_data3 = $total_hourly_cur_emb_data3 + $total_hourly_cur_fch_data3 + $total_hourly_cur_rlc_data3 + $total_hourly_cur_elc_data3;
                    $grand_total_hourly_cur_data4 = $total_hourly_cur_emb_data4 + $total_hourly_cur_fch_data4 + $total_hourly_cur_rlc_data4 + $total_hourly_cur_elc_data4;
                    $grand_total_hourly_cur_data5 = $total_hourly_cur_emb_data5 + $total_hourly_cur_fch_data5 + $total_hourly_cur_rlc_data5 + $total_hourly_cur_elc_data5;
                    $grand_total_hourly_cur_data6 = $total_hourly_cur_emb_data6 + $total_hourly_cur_fch_data6 + $total_hourly_cur_rlc_data6 + $total_hourly_cur_elc_data6;
                    $grand_total_hourly_cur_data7 = $total_hourly_cur_emb_data7 + $total_hourly_cur_fch_data7 + $total_hourly_cur_rlc_data7 + $total_hourly_cur_elc_data7;
                    $grand_total_hourly_cur_data8 = $total_hourly_cur_emb_data8 + $total_hourly_cur_fch_data8 + $total_hourly_cur_rlc_data8 + $total_hourly_cur_elc_data8;
                    $grand_total_hourly_cur_data9 = $total_hourly_cur_emb_data9 + $total_hourly_cur_fch_data9 + $total_hourly_cur_rlc_data9 + $total_hourly_cur_elc_data9;
        
                    $grand_total_hourly_all_prev_data = $grand_total_hourly_prev_data1 + $grand_total_hourly_prev_data2 + $grand_total_hourly_prev_data3
                    + $grand_total_hourly_prev_data4 + $grand_total_hourly_prev_data5 + $grand_total_hourly_prev_data6 + $grand_total_hourly_prev_data7
                    + $grand_total_hourly_prev_data8 + $grand_total_hourly_prev_data9;

                    $grand_total_hourly_all_cur_data = $grand_total_hourly_cur_data1 + $grand_total_hourly_cur_data2 + $grand_total_hourly_cur_data3
                    + $grand_total_hourly_cur_data4 + $grand_total_hourly_cur_data5 + $grand_total_hourly_cur_data6 + $grand_total_hourly_cur_data7
                    + $grand_total_hourly_cur_data8 + $grand_total_hourly_cur_data9;

                    $item['card'] .='
                    <tr>
                        <td class="text-danger">GRAND TOTAL</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data1.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data2.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data3.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data4.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data5.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data6.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data7.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data8.'</td>
                        <td class="text-right">'. $grand_total_hourly_prev_data9.'</td>
                        <td class="text-right">'.$grand_total_hourly_all_prev_data.'</td>
                        <td class="text-danger">GRAND TOTAL</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data1.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data2.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data3.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data4.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data5.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data6.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data7.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data8.'</td>
                        <td class="text-right">'.$grand_total_hourly_cur_data9.'</td>
                        <td class="text-right">'.$grand_total_hourly_all_cur_data.'</td>
                      
                    </tr>
                 
                    ';
        }
        echo json_encode($data1);  

       

    }
            


}

    
   
