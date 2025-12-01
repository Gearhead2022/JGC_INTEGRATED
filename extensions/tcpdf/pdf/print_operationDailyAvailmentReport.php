<?php

require_once "../../../controllers/pensioner.controller.php";
require_once "../../../models/pensioner.model.php";
require_once "../../../views/modules/session.php";
require_once "../../../models/connection.php";

$clientsFormRequest = new printClientList();
$clientsFormRequest -> getClientsPrinting();

class printClientList{

    public function getClientsPrinting(){

    $avl_date = $_GET['avl_date'];
    $current_date = date('Y-m-d', strtotime($avl_date));
    $previous_date = date('Y-m-d', strtotime(' -1 day',strtotime($avl_date)));

    $connection = new connection;
    $connection->connect();

    require_once('tcpdf_include.php');

    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetHeaderMargin(20);
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

    $header = <<<EOF
    <style>
    table tr, th{
        font-size:9rem;
    }
    </style>
    <table style="margin-top: 100px;">

   
  

        <tr>
        <th colspan="11" style="text-align:left;">AVAILMENTS PER HOUR</th>
        </tr>
    </table>

    EOF; 
    $formated_prev_date = date('m-d-y', strtotime($previous_date));
    $formated_cur_date = date('m-d-y', strtotime($current_date));



        $header .= <<<EOF
      
        <table style="border: none;margin-top: 5px;"> 
        <tr>
            <th style="width:100px;text-align:center;font-size:11px;color:black;border-left: 1px solid black; border-top: 1px solid black;"></th>
            <th style="width:405px;text-align:center;font-size:10px;color:black;border: 1px solid black;">$formated_prev_date</th>
            <th style="width:42px;text-align:center;font-size:11px;color:black;border: 1px solid black;"></th>
            <th style="width:405px;text-align:center;font-size:10px;color:black;border: 1px solid black;">$formated_cur_date</th>
            <th style="width:42px;text-align:center;font-size:11px;color:black;border: 1px solid black;"></th>
        </tr>
        <tr>    
            <th  style="width:100px; text-align: center; font-size: 9px; color: black; border-left: 1px solid black; vertical-align: middle;">EMB BRANCHES </th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">7-8 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">8-9 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">9-10 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">10-11 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">11-12 NN</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">12-1 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">1-2 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">2-3 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">3-5 PM</th>
            <th style="width:42px;text-align:center;font-size:9px;color: black;border: 1px solid black;"></th>
        
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">7-8 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">8-9 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">9-10 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">10-11 AM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">11-12 NN</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">12-1 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">1-2 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">2-3 PM</th>
            <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">3-5 PM</th>
            <th style="width:42px;text-align:center;font-size:9px;color: black;border: 1px solid black;"></th>
        
        </tr>

        </table>
        EOF;

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

        $counter = 0;

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

            $branch_names1 = substr($branch_names, 4);

            if($counter % 2 == 0){
                $background_color_branch = '#dae8f2';
            }else{
                $background_color_branch = '';
            }

            if($counter % 2 == 0){
                $background_color = '#b4ccd6';
            }else{
                $background_color = '';
            }

            $header .= <<<EOF
            <table style="border: none;margin-top: 5px;">  
            <tr>
            <td style="width:100px;text-align:left;font-size:8px;color:black;border: 1px solid black; background-color: $background_color_branch;">$branch_names</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_1</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_2</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_3</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_4</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_5</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_6</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_7</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_8</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_emb_data_9</td>
            <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: #deded3;">$total_hourly_prev_emb_data</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_1</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_2</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_3</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_4</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_5</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_6</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_7</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_8</td>
            <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_emb_data_9</td>
            <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;background-color: #deded3;">$total_hourly_cur_emb_data</td>
            
            </tr>
            </table>
        
            EOF;

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

            $counter++;

            }

            $sub_total_hourly_prev_emb_data = $total_hourly_prev_emb_data1 + $total_hourly_prev_emb_data2 +$total_hourly_prev_emb_data3
            + $total_hourly_prev_emb_data4 + $total_hourly_prev_emb_data5 + $total_hourly_prev_emb_data6 + $total_hourly_prev_emb_data7
            + $total_hourly_prev_emb_data8 + $total_hourly_prev_emb_data9;

            $sub_total_hourly_cur_emb_data = $total_hourly_cur_emb_data1 + $total_hourly_cur_emb_data2 +$total_hourly_cur_emb_data3
            + $total_hourly_cur_emb_data4 + $total_hourly_cur_emb_data5 + $total_hourly_cur_emb_data6 + $total_hourly_cur_emb_data7
            + $total_hourly_cur_emb_data8 + $total_hourly_cur_emb_data9;

            $header .= <<<EOF
            <table style="border: none;margin-top: 5px;">  
            <tr>
                <td  style="width:100px;text-align:left;font-size:8px;color:red;border: 1px solid black;">SUB TOTAL</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data1</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data2</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data3</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data4</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data5</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data6</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data7</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data8</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_emb_data9</td>
                <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_prev_emb_data</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data1</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data2</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data3</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data4</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data5</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data6</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data7</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data8</td>
                <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_emb_data9</td>
                <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_cur_emb_data</td>
              
            </tr>
            </table>
         
            EOF;

            $header .= <<<EOF
            <table style="border: none;margin-top: 5px;">  
        
            <tr>    
                <th colspan="22"></th>
                  
            </tr>
            </table>
  
            EOF;

            $formated_prev_date = date('m-d-y', strtotime($previous_date));
            $formated_cur_date = date('m-d-y', strtotime($current_date));
        
            $header .= <<<EOF
            <table style="border: none;margin-top: 5px;"> 
            <tr>
                <th style="width:100px;text-align:center;font-size:11px;color:black;border-left: 1px solid black; border-top: 1px solid black;"></th>
                <th style="width:405px;text-align:center;font-size:10px;color:black;border: 1px solid black;">$formated_prev_date</th>
                <th style="width:42px;text-align:center;font-size:11px;color:black;border: 1px solid black;"></th>
                <th style="width:405px;text-align:center;font-size:10px;color:black;border: 1px solid black;">$formated_cur_date</th>
                <th style="width:42px;text-align:center;font-size:11px;color:black;border: 1px solid black;"></th>
            </tr>
            <tr>    
                <th  style="width:100px; text-align: center; font-size: 9px; color: black; border-left: 1px solid black; vertical-align: middle;">FCH BRANCHES </th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">7-8 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">8-9 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">9-10 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">10-11 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">11-12 NN</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">12-1 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">1-2 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">2-3 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">3-5 PM</th>
                <th style="width:42px;text-align:center;font-size:9px;color: black;border: 1px solid black;"></th>

                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">7-8 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">8-9 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">9-10 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">10-11 AM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">11-12 NN</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">12-1 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">1-2 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">2-3 PM</th>
                <th style="width:45px;text-align:center;font-size:9px;color: black;border: 1px solid black;">3-5 PM</th>
                <th style="width:42px;text-align:center;font-size:9px;color: black;border: 1px solid black;"></th>
            
            </tr>
    
            </table>
            EOF;
    

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

            $counter_fch = 0;

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

                $branch_names1 = substr($branch_names, 4);

                if($counter_fch % 2 == 0){
                    $background_color_branch = '#dae8f2';
                }else{
                    $background_color_branch = '';
                }

                if($counter_fch % 2 == 0){
                    $background_color = '#b4ccd6';
                }else{
                    $background_color = '';
                }
                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                <td style="width:100px;;text-align:left;font-size:8px;color:black;border: 1px solid black; background-color: $background_color_branch;">$branch_names</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_1</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_2</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_3</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_4</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_5</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_6</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_7</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_8</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_fch_data_9</td>
                <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: #deded3;">$total_hourly_prev_fch_data</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_1</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_2</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_3</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_4</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_5</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_6</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_7</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_8</td>
                <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_fch_data_9</td>
                <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;background-color: #deded3;">$total_hourly_cur_fch_data</td>
                </tr>
                </table>
                EOF;

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

                $counter_fch++;
    
                }

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                    <td  style="width:100px;text-align:left;font-size:8px;color:red;border: 1px solid black;">SUB TOTAL</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data1</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data2</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data3</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data4</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data5</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data6</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data7</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data8</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_fch_data9</td>
                    <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_prev_fch_data</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data1</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data2</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data3</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data4</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data5</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data6</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data7</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data8</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_fch_data9</td>
                    <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_cur_fch_data</td>

            </tr>
            </table>
         
            EOF;

            $header .= <<<EOF
            <table style="border: none;margin-top: 5px;">  
            <tr>    
                <th colspan="22"></th>
                  
            </tr>
            </table>
            EOF;

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

            $counter_rlc = 0;

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

                $branch_names1 = substr($branch_names, 4);

                if($counter_rlc % 2 == 0){
                    $background_color_branch = '#dae8f2';
                }else{
                    $background_color_branch = '';
                }

                if($counter_rlc % 2 == 0){
                    $background_color = '#b4ccd6';
                }else{
                    $background_color = '';
                }
                
                $branch_name_to_rfc = preg_replace('/RLC/', 'RFC', $branch_names);

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                    <td style="width:100px;text-align:left;font-size:8px;color:black;border: 1px solid black; background-color: $background_color_branch;">$branch_name_to_rfc</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_prev_rlc_data_9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: #deded3;">$total_hourly_prev_rlc_data</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: $background_color;">$hourly_cur_rlc_data_9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;background-color: #deded3;">$total_hourly_cur_rlc_data</td>
                
                </tr>
                </table>
                EOF;


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

                $counter_rlc++;

                }

                
                $sub_total_hourly_prev_rlc_data = $total_hourly_prev_rlc_data1 + $total_hourly_prev_rlc_data2 +$total_hourly_prev_rlc_data3
                + $total_hourly_prev_rlc_data4 + $total_hourly_prev_rlc_data5 + $total_hourly_prev_rlc_data6 + $total_hourly_prev_rlc_data7
                + $total_hourly_prev_rlc_data8 + $total_hourly_prev_rlc_data9;

                $sub_total_hourly_cur_rlc_data = $total_hourly_cur_rlc_data1 + $total_hourly_cur_rlc_data2 +$total_hourly_cur_rlc_data3
                + $total_hourly_cur_rlc_data4 + $total_hourly_cur_rlc_data5 + $total_hourly_cur_rlc_data6 + $total_hourly_cur_rlc_data7
                + $total_hourly_cur_rlc_data8 + $total_hourly_cur_rlc_data9;

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                    <td  style="width:100px;text-align:left;font-size:8px;color:red;border: 1px solid black;">SUB TOTAL</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data1</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data2</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data3</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data4</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data5</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data6</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data7</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data8</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_rlc_data9</td>
                    <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_prev_rlc_data</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data1</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data2</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data3</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data4</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data5</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data6</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data7</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data8</td>
                    <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_rlc_data9</td>
                    <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_cur_rlc_data</td>
                  
                </tr>
                </table>
             
                EOF;

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>    
                    <th colspan="22"></th>
                      
                </tr>
                </table>
                EOF;

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

            $counter_elc=0;

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

                $branch_names1 = substr($branch_names, 4);

                if($counter_elc % 2 == 0){
                    $background_color_branch = '#dae8f2';
                }else{
                    $background_color_branch = '';
                }

                if($counter_elc % 2 == 0){
                    $background_color = '#b4ccd6';
                }else{
                    $background_color = '';
                }

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                    <td style="width:100px;text-align:left;font-size:8px;color:black;border: 1px solid black;">$branch_names</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_prev_elc_data_9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black; background-color: #deded3;">$total_hourly_prev_elc_data</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$hourly_cur_elc_data_9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;background-color: #deded3;">$total_hourly_cur_elc_data</td>
                </tr>
                </table>
                EOF;


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

                $counter_elc++;

                }


                $sub_total_hourly_prev_elc_data = $total_hourly_prev_elc_data1 + $total_hourly_prev_elc_data2 +$total_hourly_prev_elc_data3
                + $total_hourly_prev_elc_data4 + $total_hourly_prev_elc_data5 + $total_hourly_prev_elc_data6 + $total_hourly_prev_elc_data7
                + $total_hourly_prev_elc_data8 + $total_hourly_prev_elc_data9;

                $sub_total_hourly_cur_elc_data = $total_hourly_cur_elc_data1 + $total_hourly_cur_elc_data2 +$total_hourly_cur_elc_data3
                + $total_hourly_cur_elc_data4 + $total_hourly_cur_elc_data5 + $total_hourly_cur_elc_data6 + $total_hourly_cur_elc_data7
                + $total_hourly_cur_elc_data8 + $total_hourly_cur_elc_data9;

                // $header .= <<<EOF
                // <table style="border: none;margin-top: 5px;">  
                // <tr>
                //     <td  style="width:100px;text-align:left;font-size:8px;color:red;border: 1px solid black;">SUB TOTAL</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data1</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data2</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data3</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data4</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data5</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data6</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data7</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data8</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_prev_elc_data9</td>
                //     <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_prev_elc_data</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data1</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data2</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data3</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data4</td>
                //     <td  style="width:45px;text-align:center;font-size:black;r:black;border: 1px solid black;">$total_hourly_cur_elc_data5</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data6</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data7</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data8</td>
                //     <td  style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$total_hourly_cur_elc_data9</td>
                //     <td  style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$sub_total_hourly_cur_elc_data</td>
                    
                // </tr>
                // </table>
             
                // EOF;

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>    
                    <th colspan="22"></th>
                      
                </tr>
                </table>
                EOF;


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

                $header .= <<<EOF
                <table style="border: none;margin-top: 5px;">  
                <tr>
                    <td style="width:100px;text-align:left;font-size:8px;color:red;border: 1px solid black;">GRAND TOTAL</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_prev_data9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_all_prev_data</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data1</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data2</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data3</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data4</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data5</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data6</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data7</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data8</td>
                    <td style="width:45px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_cur_data9</td>
                    <td style="width:42px;text-align:center;font-size:9px;color:black;border: 1px solid black;">$grand_total_hourly_all_cur_data</td>
                    
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
                    
                    </tr>             
                </table>
                EOF;
    
                $header .= <<<EOF
                <table>
                    <tr>  
                    
                        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
            
                    </tr>             
                </table>
                EOF;
            
                $header .= <<<EOF
                <table>
                    <tr>  
                    
                        <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">GLORY MAE JUNTADO</td>
    
                    </tr>             
                </table>
                EOF;



       
    

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('AVAILMENT PER HOUR.pdf', 'I');
    
   }
  }  

?>