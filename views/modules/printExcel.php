<?php
    require_once "session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../views/img/JGC.png" type="image/x-icon">
    <title>Inventory-spreadsheet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <!-- DAtatables-->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

    <style>
        body {
            background-color: none;
        }
        .spreadsheet {
            overflow-x: hidden;
            overflow-y: hidden;
            white-space: nowrap;
            max-width: 1870px;
        }
        .container-fixed-width {
            width: 1870px; /* Fixed container width */
            margin: 0 auto; /* Center align the container */
        }
        .spreadsheet h6, p, textarea, select#est_life_year, select#est_life_year, input#status, select#category,
        .spreadsheet input[type="text"],
        .spreadsheet input[type="date"],
        .spreadsheet input[type="number"] {
            border: 1px solid black;
            margin: 0;
            padding: 2px;
            box-sizing: border-box;
            /* text-align: center; */
            width: 100%;
            font-size: 15px;
        }
        .header-cell {
            background-color:khaki;
        }

        .seperator-cell{
            height: 5px;
        }

        input::placeholder, textarea::placeholder{
            font-style: italic;
            color: lightsteelblue;
        }

        textarea{
            overflow-y: hidden;
        }
        select.spreadsheet-cell, select#est_life_mon, textarea#sticker_no, input#item_code, select#est_life_year, input#item_qty, input#date_purchased, input#status,
             input#ref_no, input#branch_name[type="text"], select#status[id="status"], input#type[type="text"] {
                text-align: center;
        }

        select.spreadsheet-cell, input#acq_cost, input#ffe_depr, input#prev_acc_depr, input#acc_depr, input#book_value,
        input#total_ffe_depr, input#total_acq_cost, input#total_prev_acc_depr, input#total_acc_depr, input#total_book_value {
                text-align: right;
        }

        .input-cell, .footer-cell,
        .spreadsheet select, .spreadsheet textarea,
        .spreadsheet input[type="text"],
        .spreadsheet input[type="date"],
        .spreadsheet input[type="number"] {
            background-color: aliceblue;
            line-height: 1.2em;
            margin-bottom:  -2px;
            /* text-align: center; */
        }
        .seperator-cell,
        .header-cell,
        .input-cell,
        .footer-cell {
            flex-shrink: 0;
            box-sizing: border-box;
        }
        .seperator-cell{
            width: 1850px;
        }
        .header-cell:nth-child(1),
        .input-cell:nth-child(1),
        .footer-cell:nth-child(1) {
            width: 130px;
        }
        .header-cell:nth-child(2),
        .input-cell:nth-child(2),
        .footer-cell:nth-child(2) {
            width: 100px;
        }
        .header-cell:nth-child(3),
        .input-cell:nth-child(3),
        .footer-cell:nth-child(3) {
            width: 230px;
        }
        .header-cell:nth-child(4),
        .input-cell:nth-child(4),
        .footer-cell:nth-child(4) {
            width: 130px;
        }
        .header-cell:nth-child(5),
        .input-cell:nth-child(5),
        .footer-cell:nth-child(5){
            width: 110px;
        }

        .header-cell:nth-child(6),
        .input-cell:nth-child(6),
        .footer-cell:nth-child(6) {
            width: 120px;
        }
        .header-cell:nth-child(7),
        .input-cell:nth-child(7),
        .footer-cell:nth-child(7) {
            width: 170px;
        }
        .header-cell:nth-child(8),
        .input-cell:nth-child(8),
        .footer-cell:nth-child(8) {
            width: 160px;
        }
        .header-cell:nth-child(9),
        .input-cell:nth-child(9),
        .footer-cell:nth-child(9) {
            width: 140px;
        }
        .header-cell:nth-child(10),
        .input-cell:nth-child(10),
        .footer-cell:nth-child(10) {
            width: 125px;
        }
        .header-cell:nth-child(11),
        .input-cell:nth-child(11),
        .footer-cell:nth-child(11) {
            width: 125px;
        }
        .header-cell:nth-child(12),
        .input-cell:nth-child(12),
        .footer-cell:nth-child(12) {
            width: 120px;
        }
        .header-cell:nth-child(13),
        .input-cell:nth-child(13),
        .footer-cell:nth-child(13) {
            width: 100px;
        }
        .header-cell:nth-child(14),
        .input-cell:nth-child(14),
        .footer-cell:nth-child(14) {
            width: 90px;
        }

        @media print {
            body{
                margin-left: 20px;
                color: black;
            }
            
            select.spreadsheet-cell, select#est_life_mon, select#est_life_year, input#acq_cost, input#acc_depr, input#prev_acc_depr ,input#status, #hideHeader,
            input#ffe_depr, input#book_value, input#ref_no, input#item_code, textarea#item_description, input#branch_name[type="text"], select#status[id="status"], input#type[type="text"] {
                display: none;
            }
            .header-cell{
                text-align: center;
            }

            .header-cell:nth-child(13),
            .input-cell:nth-child(13),
            .footer-cell:nth-child(13) {
                width: 0px !important;
            }
            .header-cell:nth-child(14),
            .input-cell:nth-child(14),
            .footer-cell:nth-child(14) {
                width: 0px !important;
            }

            .btn-custom-print{
                display: none;
            }

            .seperator-cell{
            width: 1660px !important;
            }

            input.print-value, textarea.print-value, #date_purchased, #item_qty, textarea#sticker_no, input.spreadsheet-cell  {
                display: inline !important;
                border: 1px solid black !important;
                margin: 0 !important;
                padding: 2px !important;
                box-sizing: border-box !important;
                /* text-align: center !important; */
                width: 100% !important;
                font-size: 12px !important;
                height: 100% !important;
            }

            .footer-cell .spreadsheet-cell {
                display: inline !important;
                border: 1px solid black !important;
                margin: 0 !important;
                padding: 2px !important;
                box-sizing: border-box !important;
                text-align: center !important;
                width: 100% !important;
                font-size: 12px !important;
                height: 100% !important;
            }


            .page-break {
                page-break-before: always;
                visibility: hidden;
                height: 0;
            }

            .content-wrapper {
                position: relative;
                padding-bottom: 100px;
            }

            .extended-cell {
                position: absolute;
                bottom: 50px;
                left: 20px;
                width: 100%;
                display: block !important;
            }

            .extended-cell input.note {
                border-style: none !important;
                background-color: transparent;
                text-justify: center;
            }

            input.print-value, .spreadsheet-cell {
                display: inline !important;
                border: 1px solid black !important;
                margin: 0 !important;
                padding: 2px !important;
                box-sizing: border-box !important;
                text-align: center !important;
                width: 100% !important;
                font-size: 12px !important;
            }
            input.print_value.spreadsheet-cell, input#acq_cost, input#ffe_depr, input#prev_acc_depr, input#acc_depr, input#book_value,
            input#total_ffe_depr, input#total_acq_cost, input#total_prev_acc_depr, input#total_acc_depr, input#total_book_value {
                    text-align: right !important;
            }
            .footer-cell input#knull{
                height: 40px;
            }
            .footer-cell input#total_ffe_depr, input#total_text, input#total_acq_cost, input#total_prev_acc_depr, input#total_acc_depr, input#total_book_value{
                height: 40px;
                font-weight: bold;
                background-color: burlywood;
                font-size: 15px;
            }

        }

        .extended-cell{
           display: none;
        }


        input.print-value {
            display: none;
        }


        .modal-content, .modal-footer{
            background-color: #C9E0DC;
        }
        .modal-title{
            color: black;
        }

        .modal-body{
            background-color: #F0FAF9;
        }

        .form-control:focus{
            background-color: #efebf5 !important;
            border: solid black 1px;
            color: black;
        }

/* 
        input::placeholder{
        
            color: green;
        } */
        .form-control{
            background-color: white;
            border: solid black 1px;
        }
        .form-control[readonly]{
            background-color: #efebf5;
            border: solid black 1px;
            color: black;
        }

        .page-break {
        page-break-before: always; /* Forces the next content to appear on a new page */
         }
                
    </style>
    <?php require_once "../../models/connection.php";

    date_default_timezone_set('Asia/Manila');
    
    if (isset($_SESSION['branch_name'])) {
        $branch_str = substr($_SESSION['branch_name'], 0, 3);

        if ($branch_str === 'EMB') {
            $title_str = 'EMB FINANCE CORP';
        } else if($branch_str === 'FCH') {
            $title_str = 'FCH FINANCE CORP';
        } else if($branch_str === 'RLC') {
            $title_str = 'RFC FINANCE CORP';
        } else if($branch_str === 'ELC') {
            $title_str = 'ELC FINANCE CORP';
        }else{
            $title_str = 'MAIN HOLDING';
        }

    } else {
        echo "<script> location.href='../../index.php'; </script>";
        exit;
    }
    $branch_name = $_SESSION['branch_name'];
    if (strpos($branch_name, "RLC") !== false) {
        $branch_name = str_replace("RLC", "RFC", $branch_name);
    }
    $preparedBy = $_GET['preparedBy'];
    $position = $_GET['position'];
    $header_date_timestamp = $_GET['selectedDate'];
    
    if (date('d', strtotime($header_date_timestamp)) <= 25) {  // Compare as integer
        $prev_tbl_header = strtoupper(date('M Y', strtotime('-1 month', strtotime($header_date_timestamp))));
        $cur_tbl_header = strtoupper(date('M Y', strtotime($header_date_timestamp)));
        $rep_month = strtoupper(date('F Y', strtotime($header_date_timestamp)));
    } else {
        $prev_tbl_header = strtoupper(date('M Y', strtotime($header_date_timestamp)));
        $cur_tbl_header = strtoupper(date('M Y', strtotime('+ 1 month', $header_date_timestamp)));
        $rep_month = strtoupper(date('F Y', strtotime('+ 1 month', $header_date_timestamp)));
    }

    $height_value = 198;
    ?>
</head>
<body>
    <div class="clearfix"></div>
  
    <div class="content-wrapper">
        <div class="container-fluid container-fixed-width">
            <div class="row mb-3 mt-2">
                <div class="col-12 fs-5 fw-bold"><?php echo $title_str?></div>
                <div class="col-12 fs-6">SUMMARY OF FURNITURE, FIXTURES & EQUIPMENT</div>
                <div class="col-11 fs-6">FOR THE MONTH OF <?php echo $rep_month; ?></div>
                <div class="col-12 fs-6"><?php echo $branch_name; ?></div>
            </div>
            <div class="spreadsheet">
                <div class="row g-0">
                    <div class="header-cell">
                        <h6>DATE ACQUIRED</h6>
                    </div>
                    <div class="header-cell">
                        <h6>QTY UNIT</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ITEM DESCRIPTION/SERIAL NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>REF. NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>STICKER NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ITEM CODE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>EST. LIFE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ACQUISITION COST</h6>
                    </div>
                    <div class="header-cell">
                        <h6>FFE DEPRECIATION</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ACCUM DEPN</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ACCUM DEPN</h6>
                    </div>
                    <div class="header-cell">
                        <h6>BOOK VALUE</h6>
                    </div>
                    <div class="header-cell" id="hideHeader">
                        <h6>TYPE</h6>
                    </div>
                    <div class="header-cell" id="hideHeader">
                        <h6>STATUS</h6>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="header-cell">
                        <p>(Date Booked)</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>(Years)</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p><?php echo $prev_tbl_header; ?></p>
                    </div>
                    <div class="header-cell">
                        <p><?php echo $cur_tbl_header; ?></p>
                    </div>
                    <div class="header-cell">
                        <p>(as of this month)</p>
                    </div>
                    <div class="header-cell" id="hideHeader">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell" id="hideHeader">
                        <p>&nbsp;</p>
                    </div>
                </div>

                <?php
             
                    $month_from = date('Y-m-26', strtotime(' -1 month', strtotime($header_date_timestamp)));
                    $month_to = date('Y-m-25', strtotime($header_date_timestamp));

                    $total_ffe_depr = 0;
                    $total_acq_cost = 0;
                    $total_prev_acc_depr = 0;
                    $total_acc_depr = 0;
                    $total_book_value = 0;
                    $get_item_code = (new Connection)->connect()->query("SELECT DISTINCT inv.qty_code, inv.date_purchased
                        FROM inventory inv
                        LEFT JOIN (
							SELECT log.item_code, log.branch_name, log.status, log.id
                                FROM inventory_log log
                                 INNER JOIN (
                                    SELECT item_code, MAX(id) AS max_id
                                    FROM inventory_log
                                     WHERE branch_name = '$branch_name'
                                    GROUP BY item_code
                            ) log_max ON log.item_code = log_max.item_code AND log.id = log_max.max_id
                            ) i_log ON inv.item_code = i_log.item_code
                         WHERE (
                            inv.item_location = '$branch_name'
                            OR (i_log.branch_name = '$branch_name' AND inv.item_location != '$branch_name' OR i_log.branch_name = '')
                        )
                        AND (i_log.status != 'ITEM OUT' OR i_log.status IS NULL)
                        AND DATE(inv.date_purchased) < '$month_to' ORDER BY inv.date_purchased")->fetchAll(PDO::FETCH_ASSOC);
                    
                    $count_all_data = (new Connection)->connect()->query("SELECT * FROM inventory_itemset iset INNER JOIN inventory inv ON iset.item_code = inv.item_code WHERE inv.item_location = '$branch_name'AND DATE(inv.date_purchased) <= '$month_to'")->fetchAll(PDO::FETCH_ASSOC);

                    $batch_size = 25;
                    $item_count = 0; 
                    $back_to_zero = 0;
                    $page_number = 1; 
                    $total_items = count($get_item_code);
                    $count_all_data = count($count_all_data) + $total_items;
                  
                    if ($count_all_data < 26 && $count_all_data >= 23) {
                        $batch_size = 23;
                        $height_value = 98;
                        echo '<script>
                       document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                       </script>';
                    }
        
                  
                    $separator_html = '<div style="page-break-before: always; border: none; visibility: hidden; height: 0;" aria-hidden="true"></div>';
                    $header_html ='<div class="row g-0">
                            <div class="header-cell">
                                <h6>DATE ACQUIRED</h6>
                            </div>
                            <div class="header-cell">
                                <h6>QTY UNIT</h6>
                            </div>
                            <div class="header-cell">
                                <h6>ITEM DESCRIPTION/SERIAL NO.</h6>
                            </div>
                            <div class="header-cell">
                                <h6>REF. NO.</h6>
                            </div>
                            <div class="header-cell">
                                <h6>STICKER NO.</h6>
                            </div>
                            <div class="header-cell">
                                <h6>ITEM CODE</h6>
                            </div>
                            <div class="header-cell">
                                <h6>EST. LIFE</h6>
                            </div>
                            <div class="header-cell">
                                <h6>ACQUISITION COST</h6>
                            </div>
                            <div class="header-cell">
                                <h6>FFE DEPRECIATION</h6>
                            </div>
                            <div class="header-cell">
                                <h6>ACCUM DEPN</h6>
                            </div>
                            <div class="header-cell">
                                <h6>ACCUM DEPN</h6>
                            </div>
                            <div class="header-cell">
                                <h6>BOOK VALUE</h6>
                            </div>
                            <div class="header-cell" id="hideHeader">
                                <h6>TYPE</h6>
                            </div>
                            <div class="header-cell" id="hideHeader">
                                <h6>STATUS</h6>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="header-cell">
                                <p>(Date Booked)</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>(Years)</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell">
                                <p>'.$prev_tbl_header.'</p>
                            </div>
                            <div class="header-cell">
                                <p>'.$cur_tbl_header.'</p>
                            </div>
                            <div class="header-cell">
                                <p>(as of this month)</p>
                            </div>
                            <div class="header-cell" id="hideHeader">
                                <p>&nbsp;</p>
                            </div>
                            <div class="header-cell" id="hideHeader">
                                <p>&nbsp;</p>
                            </div>
                        </div>';
                    $title_html = ' <div class="row mb-3 mt-2">
                        <div class="col-12 fs-5 fw-bold">'.$title_str.'</div>
                        <div class="col-12 fs-6">SUMMARY OF FURNITURE, FIXTURES & EQUIPMENT</div>
                        <div class="col-11 fs-6">AS OF '.$rep_month.'</div>
                        <div class="col-12 fs-6">'.$branch_name.'</div>
                    </div>';

                    foreach ($get_item_code as $code){

                        $qty_code = $code['qty_code'];

                        $get_values_to_sum = (new Connection)->connect()->query("SELECT inv.item_description 
                        FROM inventory inv LEFT JOIN inventory_log log  ON inv.item_code = log.item_code
                        WHERE inv.qty_code = '$qty_code' AND (inv.item_location = '$branch_name' OR log.branch_name = '$branch_name') 
                        LIMIT 1
                    ")->fetch(PDO::FETCH_ASSOC);
                        
                        if ($get_values_to_sum) {
                            $item_descripts = $get_values_to_sum['item_description'];
                        }
                        $get_inventory_list = (new Connection)->connect()->query("SELECT * FROM inventory WHERE qty_code = '$qty_code' AND item_description =  '$item_descripts'")->fetchAll(PDO::FETCH_ASSOC);

                        $totals = [];
                        $sticker_list = [];
                        $code_list = [];
                        $i = 0;
                        $j = 0;
                        $code_list = [];
                        
                        $items_divisible =  floor($count_all_data / $batch_size) * 26;
                        $remainder = $count_all_data - $items_divisible;
                        // $totalislisticdas = $item_count + $remainder;
               
                        // echo ' remainder='.$remainder.' item count='.$item_count.' count_all_data='.$count_all_data.' count_all_datas='.$totalislisticdas.'back2xero='.$back_to_zero.' batch_size='.$batch_size;
                        if ($back_to_zero > 0 && $back_to_zero % $batch_size == 0) {
                            echo $separator_html;
                            echo $title_html;
                            echo $header_html;
                            $page_number++;
                            $back_to_zero = 1;
        
                            echo '<script>
                            document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                            </script>';
            
                            $height_value += 100;
                        }

                        if ($item_count > 0 && $item_count % $batch_size == 0) {
                            $batch_size = 23;
                        }

                        if ($count_all_data === 25 || $count_all_data === 24) {
                            $height_value = 198;
                            echo '<script>
                           document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                           </script>';
                        }

                        if ($count_all_data < 24) {
                            $height_value = 98;
                            echo '<script>
                           document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                           </script>';
                        }

                        foreach ($get_inventory_list as $inv) {
                            $item_desc = $inv['item_description'];
                            $sticker_no = $inv['sticker_no'];
                            $item_code = $inv['item_code'];
                            
                            if (!isset($totals[$item_desc])) {
                                $totals[$item_desc] = 0;
                            }
                            $totals[$item_desc]++;

                            if (!in_array($sticker_no, $sticker_list)) {
                                $sticker_list[$i] = $sticker_no;
                                $i++;
                            } 
                            if (!in_array($item_code, $code_list)) {
                                $code_list[$j] = $item_code;
                                $j++;
                            } 
                        }

                        ?>
                        <div class="row g-0">
                            <div class="seperator-cell">
                                <p>&nbsp;</p>
                            </div>
                        </div>

                        <?php
                        $last_item_desc = '';

                        foreach ($get_inventory_list as $inv) {

                            $date_purchased = $inv['date_purchased'];
                            $ref_no = $inv['ref_no'];
                            $item_desc = $inv['item_description'];
                            $sticker_no = $inv['sticker_no'];
                            $item_code = $inv['item_code'];
                            $group_qty_code = $inv['qty_code'];
                            $item_id = $inv['id'];
                            $type = $inv['category'];
                            $status = $inv['status'];
                            $class_code = $inv['class_code'];

                            if ($inv['status'] === 'DEFECTIVE' || $inv['status'] === 'DISPOSED') {
                                echo '<script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var elements = document.querySelectorAll("[data-item-id=\'' . $item_id . '\']");
                                    elements.forEach(function(element) {
                                        element.style.color = "red";
                                    });
                                });
                                </script>';
                            }

                            if (isset($inv['est_life_mon'])) {
                                if ($inv['est_life_mon'] > 1) {
                                    $est_life_mon = $inv['est_life_mon'];
                                    $est_life_mon_disp = $inv['est_life_mon'].' '. 'months';
                                }else{
                                    $est_life_mon = $inv['est_life_mon'];
                                    $est_life_mon_disp = $inv['est_life_mon'].' '. 'month';
                                }
                            } else {
                                $est_life_mon = '';
                                $est_life_mon_disp = '<-month->';
                            }

                            if (isset($inv['est_life_year']) && $inv['est_life_year'] != 0) {
                                if ($inv['est_life_year'] > 1) {
                                    $est_life_year = $inv['est_life_year'];
                                    $est_life_year_disp = $inv['est_life_year'].' '. 'years';
                                }else{
                                    $est_life_year = $inv['est_life_year'];
                                    $est_life_year_disp = $inv['est_life_year'].' '. 'year';
                                }
                            } else {
                                $est_life_year = '';
                                $est_life_year_disp = '<-year->';
                            }

                            if (isset($inv['est_life_mon']) && $inv['est_life_mon'] != 0 && isset($inv['est_life_year']) && $inv['est_life_year'] != 0) {
                                $print_display = $est_life_year_disp . ' & ' . $est_life_mon_disp;
                            } else {
                                if (isset($inv['est_life_mon']) && $inv['est_life_mon'] != 0) {
                                    $print_display = $est_life_mon_disp;
                                } elseif (isset($inv['est_life_year'])) {
                                    $print_display = $est_life_year_disp;
                                } else {
                                    $print_display = '';
                                }
                            }

                            $acquiredDateTime = new DateTime($date_purchased);

                            $format_selected_month_from_filter = date('Y-m-t', strtotime($header_date_timestamp)); 
                         
                            $currentDateTime = new DateTime($format_selected_month_from_filter);
                    
                            $interval = $acquiredDateTime->diff($currentDateTime);
                    
                            $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
                            // echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';
                    
                            if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
                                $totalMonthsSincePurchase--;
                            }

                            $item_qty_for_calc = $totals[$item_desc];

                            $acq_cost_for_calc = $inv['acq_cost'];
                            //  echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';

                            if ($est_life_year > 0 && $est_life_year != '') {
                                if ($est_life_mon > 0 && $est_life_mon != '') {
                                    $total_months = ($est_life_year * 12) + $est_life_mon;
                                } else {
                                    $total_months = ($est_life_year * 12);
                                }
                            } else {
                                if ($est_life_mon > 0 && $est_life_mon != '') {
                                    $total_months =  $est_life_mon;
                                } else {
                                    $total_months = 0;
                                }
                            }

                            if ($totalMonthsSincePurchase >= $total_months) {

                                if ($acq_cost_for_calc == 0 || $acq_cost_for_calc == '') {
                                    $acc_depr = '';
                                    $book_value = '';
                                    $prev_acc_depr = '';
                                    $ffe_depr = '';
                                    $acq_cost = '';

                                    $acc_depr_for_calc = 0;
                                    $book_value_for_calc = 0;
                                    $prev_acc_depr_for_calc = 0;
                                    $ffe_depr_for_calc = 0;
                                    $acq_cost_for_calc2 = 0;
                                } else {
                                    $prev_acc_depr = number_format(round($acq_cost_for_calc - $item_qty_for_calc, 2), 2);
                                    $acc_depr = number_format(round($acq_cost_for_calc - $item_qty_for_calc, 2), 2);
                                    $book_value = $item_qty_for_calc;
                                    $ffe_depr = '0.00';
                                    $acq_cost = ($acq_cost_for_calc != '') ? number_format($acq_cost_for_calc, 2, '.', ',') : '';
                                
                                    $acc_depr_for_calc = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                    $book_value_for_calc = $item_qty_for_calc;
                                    $prev_acc_depr_for_calc = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                    $ffe_depr_for_calc = 0;
                                    $acq_cost_for_calc2 = $acq_cost_for_calc;
                                }
                    
                            }else {

                                if ($acq_cost_for_calc == 0 || $acq_cost_for_calc == '') {
                                    $ffe_depr = '';
                                    $acc_depr = '';
                                    $book_value = '';
                                    $prev_acc_depr = '';
                                    $acq_cost = '';

                                    $acc_depr_for_calc = 0;
                                    $book_value_for_calc = 0;
                                    $prev_acc_depr_for_calc = 0;
                                    $ffe_depr_for_calc = 0;
                                    $acq_cost_for_calc2 = 0;
                                } else {

                                    if ($item_qty_for_calc > 0 && $acq_cost_for_calc > 0 && $total_months > 0) {
                                        $ffe_depr_for_calc = round(($acq_cost_for_calc - $item_qty_for_calc) / $total_months, 2);
                                    } else {
                                        $ffe_depr_for_calc = 0;
                                    }
                                
                                    $prev_acc_depr_for_calc = round($ffe_depr_for_calc * ($totalMonthsSincePurchase), 2);
                        
                                    if ($prev_acc_depr_for_calc == 0) {
                                        $acc_depr_for_calc = $ffe_depr_for_calc;
                                        $acc_depr = number_format($ffe_depr_for_calc, 2);
                                    } else {
                                        $acc_depr_for_calc = round($prev_acc_depr_for_calc + $ffe_depr_for_calc, 2);
                                        $acc_depr =  number_format(round($prev_acc_depr_for_calc + $ffe_depr_for_calc, 2), 2);
                                    }
                                  
                                    $book_value_for_calc = round($acq_cost_for_calc - $acc_depr_for_calc, 2);

                                    $prev_acc_depr =  number_format(round($ffe_depr_for_calc * ($totalMonthsSincePurchase), 2), 2);
                                    $ffe_depr =  number_format(round(($acq_cost_for_calc - $item_qty_for_calc) / $total_months, 2), 2);
                                    $book_value = number_format(round($acq_cost_for_calc - $acc_depr_for_calc, 2), 2);
                                    $acq_cost = ($acq_cost_for_calc != '') ? number_format($acq_cost_for_calc, 2, '.', ',') : '';
                                
                                    $acq_cost_for_calc2 = $acq_cost_for_calc;
                                }
                                
                            }

                            if ($ffe_depr > 0 && $ffe_depr != 0) {
                                echo '<script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var elements = document.querySelectorAll("[data-item-id=\'' . $item_id . '\']");
                                    elements.forEach(function(element) {
                                        element.style.backgroundColor = "lightyellow";
                                    });
                                });
                                </script>';
                            }

                            if ($last_item_desc != $item_desc) {
                                $item_qty = $totals[$item_desc];

                                $total_acq_cost += $acq_cost_for_calc;
                                $total_ffe_depr += $ffe_depr_for_calc;
                                $total_prev_acc_depr += $prev_acc_depr_for_calc;
                                $total_acc_depr +=  $acc_depr_for_calc;
                                $total_book_value +=  $book_value_for_calc;

                                $item_sticker_count = count($sticker_list);
                                        
                                if ($item_sticker_count > 1) {
                                    $is_consecutive = true;
                                    for ($i = 1; $i < $item_sticker_count; $i++) {
                                        if ($sticker_list[$i] - $sticker_list[$i - 1] != 1) {
                                            $is_consecutive = false;
                                            break;
                                        }
                                    }
                                    
                                    if ($is_consecutive) {
                                        $last_sticker_list = $sticker_no .'- ' . end($sticker_list);
                                    } else {
                                        $last_sticker_list = implode(', ', $sticker_list);
                            
                                    }
                                }else if ($item_sticker_count == 1){
                                    $last_sticker_list = $sticker_list[0];
                                }else {
                                    $last_sticker_list = '';
                                }
                               
                                // $last_sticker_list = $item_qty > 1 ? '- ' .end($sticker_list) : '';
                                $last_item_code = $item_qty > 1 ? '- ' .end($code_list) : '';
                                ?>
                                <input type="text" name="branch_name" id="branch_name"  hidden value="<?php echo $_SESSION['branch_name']; ?> ">
                                <div class="row g-0">
                              
                                    <div class="input-cell">
                                        <input type="date" name="date_purchased" disabled id="date_purchased" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" value="<?php echo $date_purchased;?>" placeholder="">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number"  name="item_qty" id="item_qty" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" value="<?php echo $item_qty;?>" placeholder="0">
                                    </div>
                                    <div class="input-cell">
                                        <textarea type="text" id="item_description" data-item-id="<?php echo $item_id;?>" class="print-value" value=""><?php echo $item_desc;?></textarea>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" data-item-id="<?php echo $item_id;?>" class="print-value" value="<?php echo $ref_no; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <textarea type="text" readonly name="sticker_no" id="sticker_no" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" placeholder="Sticker no."><?php echo $last_sticker_list?></textarea>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" data-item-id="<?php echo $item_id;?>" class="print-value" value="<?php echo $item_code.' '.$last_item_code; ?> ">
                                    </div>
                                    <div class="input-cell d-flex">
                                        <input type="text" data-item-id="<?php echo $item_id;?>" class="print-value" value="<?php echo $print_display; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="acq_cost" data-item-id="<?php echo $item_id;?>"class="print-value" value="<?php echo $acq_cost; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="ffe_depr" data-item-id="<?php echo $item_id;?>" class="print-value" value="<?php echo $ffe_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="prev_acc_depr" data-item-id="<?php echo $item_id;?>" disabled class="print-value" value="<?php echo $prev_acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="acc_depr" data-item-id="<?php echo $item_id;?>" disabled class="print-value" value="<?php echo $acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="book_value" data-item-id="<?php echo $item_id;?>" class="print-value" value="<?php echo $book_value; ?> ">
                                    </div>
                                </div>        

                                <?php
                                $last_item_desc = $item_desc;
                                $item_count++;
                                $back_to_zero++;

                                $itemlist_code = $inv['class_code'];
                                $component_desc = $inv['item_description'];

                                $totalslist = [];
                                $get_inventory_item_list = (new Connection)->connect()->query("SELECT * FROM inventory_itemset WHERE class_code = '$itemlist_code' AND item_description != '$component_desc'")->fetchAll(PDO::FETCH_ASSOC);
            
                                $last_item_list_desc = '';

                                foreach ($get_inventory_item_list as $lst) {
                                    $item_list_desc = $lst['item_description'];

                                    if (!isset($totalslist[$item_list_desc])) {
                                        $totalslist[$item_list_desc] = 0;
                                    }
                                    $totalslist[$item_list_desc]++;
                                }
                            
                                foreach ($get_inventory_item_list as $lst) { 
                                    $item_list_desc = $lst['item_description'];
                                    $component_location = $lst['item_location'];
                                    $item_code = $lst['item_code'];
                                    $component_class_code = $lst['class_code'];
                                    
                                    $get_inventory_list_component = (new Connection)->connect()->query("SELECT * FROM inventory WHERE class_code = '$component_class_code' AND item_description = '$item_list_desc' AND item_description != 'MOUSE' AND item_description != 'KEYBOARD'")->fetchAll(PDO::FETCH_ASSOC);
                                    $component_sticker_list = [];
                                    $component_item_code_list = [];
                                    $k = 0;
                                    $l = 0;
                                    foreach ($get_inventory_list_component as $inv_lst) {
                                        $component_sticker_no = $inv_lst['sticker_no'];
                                        $component_item_code = $inv_lst['item_code'];
                                  
                                        if (!in_array($component_sticker_no, $component_sticker_list)) {
                                            $component_sticker_list[$k] = $component_sticker_no;
                                            $k++;
                                        } 
                                        
                                        $component_sticker_nos = $component_sticker_list[0];

                                        if (!in_array($component_item_code, $component_item_code_list)) {
                                            $component_item_code_list[$l] = $component_item_code;
                                            $l++;
                                        } 
                                        $component_item_codes = $component_item_code_list[0];
                                    }
                                    
                                    if ($last_item_list_desc != $item_list_desc) {
                                        // $item_list_qty = $totalslist[$item_list_desc];
                                        $item_list_qty = ($totalslist[$item_list_desc]) > 1 ? $totalslist[$item_list_desc] : '';
                                        $component_last_sticker_list = ($item_list_qty > 1) ? '- ' .end($component_sticker_list) : '';
                                        $component_last_item_list = ($item_list_qty > 1) ? '- ' .end($component_item_code_list) : '';

                                        if ($lst['item_description'] === 'MOUSE' || $lst['item_description'] === 'KEYBOARD') {
                                            $sticker_ind = '';
                                        } else {
                                            $sticker_ind = $component_sticker_nos .' '. $component_last_sticker_list;
                                        }

                                        echo '<script>
                                            var elements = document.querySelectorAll("[data-item-id=\'' . $item_id . '\'][id=\'item_description\']");
                                            elements.forEach(function(element) {
                                                element.style.fontWeight = "bold";
                                            });
                                        </script>';

                                        // echo ' remainder='.$remainder.' item count='.$item_count.' count_all_data='.$count_all_data.' count_all_datas='.$totalislisticdas.'back2xero='.$back_to_zero.' batch_size='.$batch_size;
                                        if ($back_to_zero > 0 && $back_to_zero % $batch_size == 0) {
                                            echo $separator_html;
                                            echo $title_html;
                                            echo $header_html;
                                            $page_number++;
                                            $back_to_zero = 1;

                                            echo '<script>
                                            document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                                            </script>';
                                            $height_value += 100;
                                        }

                                        if ($item_count > 0 && $item_count % $batch_size == 0) {
                                            $batch_size = 23;
                                        }

                                        if ($count_all_data === 25 || $count_all_data === 24) {
                                            $height_value = 198;
                                            echo '<script>
                                        document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                                        </script>';
                                        }

                                        if ($count_all_data < 24) {
                                            $height_value = 98;
                                            echo '<script>
                                        document.getElementsByClassName("content-wrapper")[0].style.minHeight = "' . $height_value . 'vh";
                                        </script>';
                                        }


                                        ?>
                                            
                                        <div class="row g-0">
                                
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" value="<?php echo $item_list_qty;?>" class="print-value" value=""  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                                <textarea type="text" data-code="<?php echo $lst['item_code'] ?>" class="print-value"><?php echo $lst['item_description'];?></textarea>
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" value="<?php echo $sticker_ind; ?>" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" value="<?php echo $component_item_codes . '' . $component_last_item_list; ?>" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell d-flex">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" class="print-value"  placeholder="">
                                            </div>
                                        </div> 
                    
                                        <?php 
                                        if ($ffe_depr > 0 && $ffe_depr != 0) {
                                            echo '<script>
                                            var elements = document.querySelectorAll("[data-code=\'' . $lst['item_code'] . '\']");
                                            elements.forEach(function(element) {
                                                element.style.backgroundColor = "lightgoldenrodyellow";
                                            });
                                            </script>';
                                        }
                                        //  $item_count++;
                                        $back_to_zero++;
                                        $last_item_list_desc = $item_list_desc;
                                    }
                                }
                            }

                        }
                    }
                    
                    ?>
                      <div class="row g-0" >
                <div class="footer-cell">
                    <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" readonly name="" id="knull" class="spreadsheet-cell" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_text" class="spreadsheet-cell"value="TOTAL " placeholder="Description / Serial no.">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" id="knull" class="spreadsheet-cell">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">
                </div>
                <div class="footer-cell d-flex">
                    <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_acq_cost" class="spreadsheet-cell" value="<?php echo number_format($total_acq_cost, 2, '.', ',');?>" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_ffe_depr" class="spreadsheet-cell" value="<?php echo number_format($total_ffe_depr, 2, '.', ',');?>" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_prev_acc_depr" class="spreadsheet-cell" value="<?php echo number_format($total_prev_acc_depr, 2, '.', ',');?>" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_acc_depr" class="spreadsheet-cell" value="<?php echo number_format($total_acc_depr, 2, '.', ',');?>" placeholder="">
                </div>
                <div class="footer-cell">
                    <input type="text" name="" readonly id="total_book_value" class="spreadsheet-cell" value="<?php echo number_format($total_book_value, 2, '.', ',');?>" placeholder="">
                </div>
               
            </div>        
            </div>
        </div>
      
        
        <div class="extended-cell">
        <div class="row mt-2">
            <div class="col-4" style="margin-left: 8px;">PREPARED & CERTIFIED BY:</div>
        </div>
        <div class="row">
            <div class="col-2" style="border-bottom: 1px solid black; margin-left: 20px; width: 200px;">
            <input type="text" name="" id="note" class="note" placeholder="">
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <input type="text" name="" id="printPreparedBy" style="margin-left: 5px;" value="<?php echo $_GET['preparedBy'];?>" class="note text-darkd" placeholder="N/A">
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <input type="text" name="" id="printPosition" style="margin-left: 5px;" value="<?php echo $_GET['position'];?>" class="note text-dark" placeholder="Position">
            </div>
        </div>    
    </div>
       
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <!-- DataTables JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
    <script>

         $(".printScreen").on('click', function() {
            var preparedBy = document.getElementById('preparedBy').value;
            var position = document.getElementById('position').value;

            // Ensure the element exists and is an input field
            var printPreparedBy = document.getElementById('printPreparedBy');
            var printPosition = document.getElementById('printPosition');

            $('#addCorrespondentModal').modal('hide');

            if (printPreparedBy && printPosition) {
                printPreparedBy.value = preparedBy;
                printPosition.value = position;
            }

            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: {
                    action: 'archive',
                    preparedBy: preparedBy,
                    position: position
                },
                method: 'GET',
                success: function(response) {
                    if (response === 'ok') {
                        setTimeout(function() {
                            window.print();
                        }, 200);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed saving to archive.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during the AJAX request.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto'; 
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        function adjustInputHeights(textarea) {
            const row = textarea.closest('.row');
            const inputs = row.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select, text');
            inputs.forEach(input => {
                input.style.height = textarea.style.height;
            });
        }

         document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                autoResizeTextarea(this);
                adjustInputHeights(this);
            });

            autoResizeTextarea(textarea);
            adjustInputHeights(textarea);
        });

        $(".enableEdit").on('click', function() {
            $(this).addClass('btn-secondary');
            $(this).html('<span><i class="fa fa-pencil"></i> &nbsp;Enabled</span>');
            $(".spreadsheet-cell").removeAttr('disabled'); 
        });
    </script>

</body>
</html>
 