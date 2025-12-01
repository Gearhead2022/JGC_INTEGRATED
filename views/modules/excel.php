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
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: gainsboro;
            margin-bottom: 100px;
        }
        .spreadsheet {
            overflow-x: hidden;
            overflow-y: hidden;
            white-space: nowrap;
            max-width: 1890px;
        }
        .container-fixed-width {
            width: 1890px; /* Fixed container width */
            margin: 0 auto; /* Center align the container */
        }
        .spreadsheet h6, p, textarea, select#est_life_year, select#est_life_year, input#status, select#category,
        .spreadsheet input[type="text"],
        .spreadsheet input[type="date"],
        .spreadsheet input[type="number"], .footer-cell input[type="text"], input[type="checkbox"] {
            border: 1px solid black;
            margin: 0;
            padding: 2px;
            box-sizing: border-box;
            /* text-align: center; */
            width: 100%;
            font-size: 13px;
        }
        .header-cell {
            background-color:khaki;
            text-align: center;
            position: sticky;
        }

        .header-cell {
            background-color:khaki;        
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .header-fixed {
            position: fixed;
            top: 0;
            left: 20px;
            width: 1865px;
            height: 20px;
            z-index: 999;
            background-color: khaki; 
            scrollbar-width: inherit;
            
        }

        .spreadsheet .row:first-child .header-cell {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: khaki; /* Match the header's background */
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
        .footer-cell input#total_ffe_depr, input#total_text, input#total_acq_cost, input#total_prev_acc_depr, input#total_acc_depr, input#total_book_value{
            height: 40px;
            font-weight: bold;
            background-color: burlywood;
            font-size: 15px;
        }
        .footer-cell input#knull{
            height: 40px;
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
            align-items: center;
        }
        .seperator-cell{
            width: 1855px;
        }
        .header-cell:nth-child(1),
        .input-cell:nth-child(1),
        .footer-cell:nth-child(1) {
            width: 20px;
            display: flex;
            align-items: center;
            border: 1px solid black;
        }
        .header-cell:nth-child(2),
        .input-cell:nth-child(2),
        .footer-cell:nth-child(2) {
            width: 130px;
        }
        .header-cell:nth-child(3),
        .input-cell:nth-child(3),
        .footer-cell:nth-child(3) {
            width: 100px;
        }
        .header-cell:nth-child(4),
        .input-cell:nth-child(4),
        .footer-cell:nth-child(4) {
            width: 230px;
        }
        .header-cell:nth-child(5),
        .input-cell:nth-child(5),
        .footer-cell:nth-child(5) {
            width: 130px;
        }
        .header-cell:nth-child(6),
        .input-cell:nth-child(6),
        .footer-cell:nth-child(6){
            width: 110px;
        }

        .header-cell:nth-child(7),
        .input-cell:nth-child(7),
        .footer-cell:nth-child(7) {
            width: 120px;
        }
        .header-cell:nth-child(8),
        .input-cell:nth-child(8),
        .footer-cell:nth-child(8) {
            width: 170px;
        }
        .header-cell:nth-child(9),
        .input-cell:nth-child(9),
        .footer-cell:nth-child(9) {
            width: 160px;
        }
        .header-cell:nth-child(10),
        .input-cell:nth-child(10),
        .footer-cell:nth-child(10) {
            width: 140px;
        }
        .header-cell:nth-child(11),
        .input-cell:nth-child(11),
        .footer-cell:nth-child(11) {
            width: 125px;
        }
        .header-cell:nth-child(12),
        .input-cell:nth-child(12),
        .footer-cell:nth-child(12) {
            width: 125px;
        }
        .header-cell:nth-child(13),
        .input-cell:nth-child(13),
        .footer-cell:nth-child(13) {
            width: 115px;
        }
        .header-cell:nth-child(14),
        .input-cell:nth-child(14),
        .footer-cell:nth-child(14) {
            width: 100px;
        }
        .header-cell:nth-child(15),
        .input-cell:nth-child(15),
        .footer-cell:nth-child(15) {
            width: 90px;
        }

        @media print {
            body{
                margin-left: 20px;
                color: black;
            }
            
            select.spreadsheet-cell, select#est_life_mon, select#est_life_year, input#acq_cost, input#acc_depr,input#status, #hideHeader,
            input#ffe_depr, input#book_value, input#ref_no, textarea#item_description, input#branch_name[type="text"], select#status[id="status"], input#type[type="text"] {
                display: none;
            }
            .header-cell:nth-child(13),
            .input-cell:nth-child(13) {
                width: 0px !important;
            }
            .header-cell:nth-child(14),
            .input-cell:nth-child(14) {
                width: 0px !important;
            }

            .btn-custom-print{
                display: none;
            }

            .seperator-cell{
            width: 1655px !important;
            }

            .extended-cell{
                position: absolute;
                bottom: 100px;
                width: 100%;
                display: block !important;
            }
            .extended-cell input.note{
                border-style: none !important;
                background-color: transparent;
            }

            input.print-value {
                display: inline !important;
                border: 1px solid black !important;
                margin: 0 !important;
                padding: 2px !important;
                box-sizing: border-box !important;
                text-align: center !important;
                width: 100% !important;
                font-size: 12px !important;
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

        .form-control{
            background-color: white;
            border: solid black 1px;
        }
        .form-control[readonly]{
            background-color: #efebf5;
            border: solid black 1px;
            color: black;
        }

        #addItem.select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff; /* Change pillbox color */
            color: white;
            border: none;
            border-radius: 50px; /* Rounded pill style */
            padding: 5px 10px;
        }
        #addItem.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-left: 5px;
        }
        #addItem.select2-container--default .select2-dropdown {
            z-index: 1050; /* Adjust as needed */
        }
        .modal {
            z-index: 1051; /* Ensure this is lower than Select2 dropdown z-index */
        }
        #addItem.select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #000; /* Default text color, including placeholder */
        }

        #addItem.select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: red; /* Placeholder text color */
        }

        span.select2-selection.select2-selection--multiple.select2-selection--clearable {
            border: 1px solid black;
        }

        span.select2-selection.select2-selection--multiple{
            border: 1px solid black;
        }
        .input-cell {
            display: flex;
            align-items: center; /* Vertically align textarea and button */
        }

        .spreadsheet-cell {
            resize: none; /* Prevent resizing of textarea */
        }

        .edit-btn {
            display: inline-block;
            height: 80%; /* Match the height of the textarea */
            width: 15px;
            padding: 0; /* Adjust padding for a smaller button */
            margin-left: 5px;
            top: -2px; /* Adjust this value to move the button higher */
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

    $item_id = (new Connection)->connect()->query("SELECT * from inventory ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
    if(empty($item_id)){
        $id = 0;
    }else{
        $id = $item_id['id'];
    }
    $last_id = $id + 1;
    $id_holder = "IC" . str_repeat("0",5-strlen($last_id)).$last_id;

    $header_date_timestamp = time(); 

    if (isset($_GET['header_date_timestamp'])) {
        $header_date_timestamp = $_GET['header_date_timestamp'];
    }else{
        $header_date_timestamp = time();
    }
    
    if (date('d', $header_date_timestamp) <= 25) {  // Compare as integer
        $prev_tbl_header = strtoupper(date('M Y', strtotime('-1 month', $header_date_timestamp)));
        $cur_tbl_header = strtoupper(date('M Y', $header_date_timestamp));
        $rep_month = strtoupper(date('F Y', $header_date_timestamp));
    } else {
        $prev_tbl_header = strtoupper(date('M Y', $header_date_timestamp));
        $cur_tbl_header = strtoupper(date('M Y', strtotime('+ 1 month', $header_date_timestamp)));
        $rep_month = strtoupper(date('F Y', strtotime('+ 1 month', $header_date_timestamp)));
    }
    $branch_name = $_SESSION['branch_name'];
    if (strpos($branch_name, "RLC") !== false) {
        $branch_name = str_replace("RLC", "RFC", $branch_name);
    }
    
    ?>
</head>
<body>
    
    <div class="clearfix"></div>
    <div class="content-wrapper">
        <div class="container-fluid container-fixed-width">
            <div class="row mb-3 mt-2">
                <div class="col-12 fs-5 fw-bold"><?php echo $title_str; ?></div>
                <div class="col-12 fs-6">SUMMARY OF FURNITURE, FIXTURES & EQUIPMENT</div>
                <div class="col-12 fs-6">AS OF <?php echo $rep_month; ?></div>
                <div class="col-12 fs-6"><?php echo $branch_name ?></div>

                <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                    <!-- Left-aligned checkbox and label -->
                    <div class="d-flex align-items-center me-2">
                        <input type="checkbox" id="checkAll" class="me-1" />
                        <label for="checkAll" class="form-label mb-0 me-5" style="white-space: nowrap;">Check all</label>
                        <!-- Delete button immediately beside the checkbox -->
                        <button class="btn btn-danger btn-sm text-light btn-round waves-effect me-2" id="deleteButton" style="display: none; white-space: nowrap;">
                            <span><i class="fa fa-trash"></i> &nbsp;Delete</span>
                        </button>
                    </div>
                    <!-- Right-aligned buttons -->
                    <div class="d-flex">
                        <span class="d-flex align-items-center me-2 fw-bold" style="white-space: nowrap;">SELECT MONTH&nbsp; 
                        <input type="month" id="header_month_input" value="<?php echo date('Y-m', $header_date_timestamp); ?>" class="me-2 form-control"></span>

                        <button class="btn btn-dark text-light btn-round waves-effect btn-custom-print me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <span><i class="fa fa-plus-circle"></i> &nbsp;Add Item</span>
                        </button>
                        <button class="btn btn-primary btn-round waves-effect btn-custom-print me-2 enableEdit" id="enableEdit">
                            <span><i class="fa fa-pencil"></i> &nbsp;Enable Edit</span>
                        </button>
                        <button class="btn btn-success btn-round waves-effect btn-custom-print me-2" data-bs-toggle="modal" data-bs-target="#addCorrespondentModal">
                            <span><i class="fa fa-print"></i> &nbsp;Print</span>
                        </button>
                        <button class="btn btn-warning btn-round waves-effect btn-custom-print" data-bs-toggle="modal" data-bs-target="#prevReports">
                            <span><i class="fa fa-file"></i> &nbsp;Previous Reports</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="spreadsheet">
                <div class="row g-0">
                    <div class="header-cell">
                        
                    </div>
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
                       
                    </div>
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
                        <p><?php echo $prev_tbl_header;?></p>
                    </div>
                    <div class="header-cell">
                        <p><?php echo $cur_tbl_header;?></p>
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
                    $branch_name = $_SESSION['branch_name'];
                    if (strpos($branch_name, "RLC") !== false) {
                        $branch_name = str_replace("RLC", "RFC", $branch_name);
                    }
                    $total_ffe_depr = 0;
                    $total_acq_cost = 0;
                    $total_prev_acc_depr = 0;
                    $total_acc_depr = 0;
                    $total_book_value = 0;

                    if (date('d', $header_date_timestamp) <= 25) { 
                        $month_from = date('Y-m-25', strtotime(' -1 month', $header_date_timestamp));
                        $month_to = date('Y-m-26', $header_date_timestamp);
                    }else{
                        $month_from = date('Y-m-25',$header_date_timestamp);
                        $month_to = date('Y-m-26', strtotime(' + 1 month', $header_date_timestamp));
                    }

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

                    foreach ($get_item_code as $code){
                        $qty_code = $code['qty_code'];

                        $get_values_to_sum = (new Connection)->connect()->query("SELECT inv.item_description 
                        FROM inventory inv LEFT JOIN inventory_log log  ON inv.item_code = log.item_code
                        WHERE inv.qty_code = '$qty_code' AND (inv.item_location = '$branch_name' OR log.branch_name = '$branch_name')
                        AND DATE(inv.date_purchased) < '$month_to' 
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
                            
                            if (isset($inv['est_life_mon']) && $inv['est_life_mon'] != 0) {
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
                            
                            $acquiredDateTime = new DateTime($date_purchased);

                            $format_selected_month_from_filter = date('Y-m-t', $header_date_timestamp); 
                         
                            $currentDateTime = new DateTime($format_selected_month_from_filter);
                    
                            $interval = $acquiredDateTime->diff($currentDateTime);
                    
                            $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
                            // echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';
                    
                            if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
                                $totalMonthsSincePurchase--;
                            }

                            $item_qty_for_calc = $totals[$item_desc];

                            $acq_cost_for_calc = $inv['acq_cost'];
                             echo '<script>console.log("'.$total_months.'");</script>';
                            
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
                                    $ffe_depr = '';
                                    $acq_cost = ($acq_cost_for_calc != '') ? number_format($acq_cost_for_calc, 2, '.', ',') : '';

                                    $acc_depr_for_calc = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                    $book_value_for_calc = $item_qty_for_calc;
                                    $prev_acc_depr_for_calc = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                    $ffe_depr_for_calc = 0;
                                    $acq_cost_for_calc2 = $acq_cost_for_calc;
                                }
                    
                            }else {

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
                            
                            $class_list = $inv['class_list'];
                            $class_code = $inv['class_code'];

                            if ($last_item_desc != $item_desc) {
                                $item_qty = $totals[$item_desc];
                             
                                $total_acq_cost += $acq_cost_for_calc;
                                $total_ffe_depr += $ffe_depr_for_calc;
                                $total_prev_acc_depr += $prev_acc_depr_for_calc;
                                $total_acc_depr +=  $acc_depr_for_calc;
                                $total_book_value += $book_value_for_calc;
                                
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
                                <input type="text" name="branch_name" id="branch_name"  hidden value="<?php echo $branch_name; ?> ">
                                <div class="row g-0">
                                    <div class="input-cell">
                                        <input type="checkbox" id="item_check_box" class="rowCheckbox" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" data-class-code="<?php echo $class_code;?>" data-branch-name="<?php echo $branch_name;?>" />
                                    </div>
                                    <div class="input-cell">
                                        <input type="date" name="date_purchased" disabled id="date_purchased" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" value="<?php echo $date_purchased;?>" placeholder="">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" disabled name="item_qty" id="item_qty" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" value="<?php echo $item_qty;?>" placeholder="0">
                                    </div>

                                    <div class="input-cell">
                                        <textarea name="item_description" disabled id="item_description" class="spreadsheet-cell cell-side" 
                                            data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" 
                                            placeholder="Description / Serial no."><?php echo $item_desc;?></textarea>
                                            <?php
                                            if ($class_list === 'COMPUTER SET' || $class_list === 'CCTV SET') {?>
                                                <button type="button" class="edit-btn btn btn-xs btn-primary edit_components" data-class-code="<?php echo $class_code?>" data-item-loc="<?php echo $branch_name;?>" style="display: none;"><i class="fa fa-pencil"></i></button>
                                            <?php } ?>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="ref_no" id="ref_no" class="spreadsheet-cell" value="<?php echo $ref_no; ?>" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" placeholder="Reference no.">
                                    </div>
                                    <div class="input-cell">
                                        <textarea type="text" disabled name="sticker_no" id="sticker_no" class="spreadsheet-cell edit_sticker_no" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code?>" data-item-loc="<?php echo $branch_name;?>" placeholder="Sticker no."><?php echo $last_sticker_list; ?></textarea>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="item_code" id="item_code" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $item_code.' '.$last_item_code;?>" placeholder="Item Code">
                                        <input type="text" class="print-value" value="<?php echo $item_code.' '.$last_item_code; ?> ">
                                    </div>
                                    <div class="input-cell d-flex">
                                        <select id="est_life_year" disabled name="est_life_year" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" style="width: 50%;">
                                            <option value="<?php echo $est_life_year; ?>" selected disabled><?php echo $est_life_year_disp; ?></option>
                                            <option value="">0 Year</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                        </select>
                                        <select id="est_life_mon" disabled name="est_life_mon" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" style="width: 50%; font-size: 12px;">
                                            <option value="<?php echo $est_life_mon; ?>" selected disabled><?php echo $est_life_mon_disp; ?></option>
                                            <option value="">0 Month</option>
                                            <option value="1">1 Month</option>
                                            <option value="2">2 Months</option>
                                            <option value="3">3 Months</option>
                                            <option value="4">4 Months</option>
                                            <option value="5">5 Months</option>
                                            <option value="6">6 Months</option>
                                            <option value="7">7 Months</option>
                                            <option value="8">8 Months</option>
                                            <option value="9">9 Months</option>
                                            <option value="10">10 Months</option>
                                            <option value="11">11 Months</option>
                            
                                        </select>
                                           <!-- Text to display selected year value during print -->
                                        <input type="text" class="print-value" value="<?php echo $print_display; ?> ">
                                    
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="acq_cost" id="acq_cost" class="spreadsheet-cell" value="<?php echo $acq_cost ?>" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $acq_cost; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="ffe_depr" id="ffe_depr" class="spreadsheet-cell" value="<?php echo $ffe_depr ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $ffe_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="prev_acc_depr" id="prev_acc_depr" class="spreadsheet-cell" value="<?php echo $prev_acc_depr; ?>" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" step="any" placeholder="0.00">
                                        <input type="text" disabled class="print-value" value="<?php echo $prev_acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="acc_depr" id="acc_depr" class="spreadsheet-cell" value="<?php echo $acc_depr ?>" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>" step="any" placeholder="0.00">
                                        <input type="text" disabled class="print-value" value="<?php echo $acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="book_value" id="book_value" class="spreadsheet-cell" value="<?php echo $book_value ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $book_value; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <select id="category" name="category" disabled class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" data-qty-code="<?php echo $group_qty_code;?>">
                                            <option value="<?php echo $type; ?>" selected disabled><?php echo $type; ?></option>
                                            <option value="Non-Accessories">Non-Accessories</option>
                                            <option value="Accessories">Accessories</option>
                                           
                                        </select>
                                        
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" id="status" name="status" readonly class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>"  value="<?php echo $status; ?> ">
                                       
                                    </div>
                                </div>        

                                <?php

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
                                                $item_code_ind = $lst['item_code'];
                                            } else {
                                                $sticker_ind = $component_sticker_nos .' '. $component_last_sticker_list;
                                                $item_code_ind = $component_item_codes . '' . $component_last_item_list;
                                            }
                                           
                                            echo '<script>
                                                var elements = document.querySelectorAll("[data-item-id=\'' . $item_id . '\'][id=\'item_description\']");
                                                elements.forEach(function(element) {
                                                    element.style.fontWeight = "bold";
                                                });
                                            </script>';

                                        ?>
                                        <div class="row g-0" >
                                            <div class="input-cell">
                                                
                                            </div>
                                            <div class="input-cell">
                                                <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                                <input type="text" readonly name="" data-code="<?php echo $lst['item_code'] ?>" id="" value="<?php echo $item_list_qty;?>" style="text-align: center;" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                                <textarea name="item_description" data-code="<?php echo $lst['item_code'] ?>" readonly id="item_description" class="spreadsheet-cell" class="nowrap" placeholder="Description / Serial no."><?php echo $lst['item_description'];?></textarea>
                                            </div>
                                            <div class="input-cell">
                                                <input type="text" disabled data-code="<?php echo $lst['item_code'] ?>" name="ref_no" id="ref_no" class="spreadsheet-cell">

                                            </div>
                                            <div class="input-cell">
                                                <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" style="text-align: center;" value="<?php echo $sticker_ind ?>" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                                <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id=""  style="text-align: center;" value="<?php echo $item_code_ind; ?>" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell d-flex">
                                                <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                                
                                            </div>
                                            <div class="input-cell">
                                            <input type="text" name="" data-code="<?php echo $lst['item_code'] ?>" readonly id="" class="spreadsheet-cell" placeholder="">
                                                
                                            </div>
                                        </div>        

                                    <?php 
                                    if ($ffe_depr > 0 && $ffe_depr != 0) { // added 10-15-24
                                        echo '<script>
                                        var elements = document.querySelectorAll("[data-code=\'' . $lst['item_code'] . '\']");
                                        elements.forEach(function(element) {
                                            element.style.backgroundColor = "lightgoldenrodyellow";
                                        });
                                        </script>';
                                    }
                                        $last_item_list_desc = $item_list_desc;
                                    }
                                }
                                    
                                // Update the last item description to the current one
                                $last_item_desc = $item_desc;
                            }
                        }
                     }
                    ?>     
                <div class="row g-0" >
                    <div class="footer-cell">
                        <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">
                    </div>
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
                    <div class="footer-cell">
                        <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">  
                    </div>
                    <div class="footer-cell">
                        <input type="text" name="" readonly id="knull" class="spreadsheet-cell" placeholder="">   
                    </div>
                </div>        
            </div>
            <div class="extended-cell">
                <div class="row mt-2">
                    <div class="col-4" style="margin-left: 20px;">PREPARED & CERTIFIED BY:</div>
                </div>
                <div class="row">
                    <div class="col-2" style="border-bottom: 1px solid black; margin-left: 20px; width: 200px;">
                    <input type="text" name="" id="note" class="note" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <input type="text" name="" id="printPreparedBy" style="margin-left: 5px;" class="note text-dark" placeholder="N/A">
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <input type="text" name="" id="printPosition" style="margin-left: 5px;" class="note text-dark" placeholder="Position">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD ITEM MODAL -->

    <!-- CREATE NEW ACCOUNT OR TRANSACTION MODAL2 -->
    <div class="modal fade" id="addItemModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
          <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h6 class="modal-title" id="exampleModalLongTitle">ADD ITEM LIST</h6>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="addNewItem" class="addNewItem" enctype="multipart/form-data">
                <div class="modal-body mb-0">
                    <div class="card">
                        <div class="card-header">
                        <div class="row">
                                <div class="col-2 mt-2">
                                    <label for="new_item_code" class="form-label">ITEM CODE :</label>
                                </div>
                                <div class="col-2">
                                    <input type="text" id="n_item_code" readonly name="n_item_code" value="<?php echo $id_holder; ?>" class="form-control" placeholder="">
                                </div>
                                <div class="col-1"></div>
                                <div class="col-2 mt-2">
                                    <label for="new_branch_name" class="form-label">BRANCH NAME :</label>
                                </div>
                                <div class="col-3">
                                    <input type="text" id="n_branch_name" name="n_branch_name" readonly value="<?php echo $branch_name; ?>" class="form-control" placeholder="">
                                </div>
                                <div class="col-2">
                                    <input type="text" id="class_code" hidden name="n_class_code" class="form-control" placeholder="Class Code" readonly>
                                </div>  
                            </div>
                        </div>
                
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_item_description" class="form-label">DESCRIPTION :</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="n_item_description" name="n_item_description" class="form-control" required placeholder="Enter Description / Serial no.">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_date_purchased" class="form-label">DATE ACQUIRED :</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" id="n_date_purchased" name="n_date_purchased" class="form-control comp_ffe" required placeholder="Enter Date">
                                </div>
                                <div class="col-3">
                                    <i>(Date Booked)</i>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="class" class="col-form-label">CLASS :</label>
                                </div>
                                <div class="col-3">
                                    <select id="class_type" name="n_class_type" class="form-control">
                                        <option value="" selected disabled>&lt; Select Class Type &gt;</option>
                                        <option value="FURNITURE">Furniture</option>
                                        <option value="FIXTURES">Fixtures</option>
                                        <option value="EQUIPMENT">Equipment</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select id="class_category" name="n_class_category" class="form-control">
                                        <option value="" selected disabled>&lt; Select Class Category &gt;</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select id="class_list" name="n_class_list" class="form-control">
                                        <option value="" selected disabled>&lt; Select Class List &gt;</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3" id="hidden_row" hidden>
                                <div class="col-3">
                                    <label for="computer-components" class="col-form-label">COMPONENTS | INCLUSIONS :</label>
                                </div>
                                <div class="col-5">
                                    <select id="components" name="components[]" class="form-control" multiple="multiple" style="width: 100%;">
                                        <option value="" disabled>&lt; Select Components | Inclusions &gt;</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label for="cam_count" hidden id="cam_label" class="col-form-label">NO. OF CAMERA :</label>
                                </div>
                                <div class="col-2">
                                    <input type="number" hidden id="cam_count" name="cam_count" class="form-control" required placeholder="No. of Camera">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2 mt-1">
                                    <label for="n_ref_no" class="form-label">REFERENCE NO. :</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="n_ref_no" required name="n_ref_no" class="form-control" placeholder="Enter Reference no.">
                                </div> 
                                <div class="col-2 mt-1">
                                    <label for="n_sticker_no" class="form-label">STICKER NO. :</label>
                                </div>
                                <div class="col-sm-3  d-flex">
                                    <input type="number" id="n_sticker_no" required name="n_sticker_no" class="form-control" placeholder="Enter Sticker no.">
                                    <input type="number" id="n_sticker_from" hidden required name="n_sticker_from" style="width: 46%; font-size: 12px;" class="form-control" placeholder="Sticker From.">
                                    <c id="dash" class="mt-2" hidden>&nbsp;-&nbsp;</c>
                                    <input type="number" id="n_sticker_to" hidden required name="n_sticker_to" style="width: 46%; font-size: 12px;" class="form-control" placeholder="Sticker To.">
                                </div> 
                                <div class="col-1 mt-1">
                                    <label for="n_item_qty" class="form-label">QUANTITY</label>
                                </div>
                                <div class="col-sm-1">
                                    <input type="number" id="n_item_qty" value="1" required name="n_item_qty" class="form-control comp_ffe" placeholder="0">
                                </div> 
                            </div>
                            <div class="row mb-3">
                                <div class="col-1 mt-2">EST. LIFE</div>
                                <div class="col-1">
                                    <label for="n_est_life_year" class="form-label mt-2">YEAR (s) :</label>
                                </div>
                                <div class="col-3">
                                    <select id="n_est_life_year" name="n_est_life_year" class="form-control comp_ffe">
                                        <option value="" selected disabled>&lt; Select year (s) &gt;</option>
                                        <option value="">0 Year</option>
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                        <option value="6">6 Years</option>
                                        <option value="7">7 Years</option>
                                        <option value="8">8 Years</option>
                                        <option value="9">9 Years</option>
                                        <option value="10">10 Years</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                <label for="n_est_life_mon" class="form-label mt-2">MONTH (s) :</label>
                                </div>
                                <div class="col-3">
                                     <select id="n_est_life_mon" name="n_est_life_mon" class="form-control comp_ffe">
                                        <option value="" selected disabled>&lt; Select month (s) &gt;</option>
                                        <option value="">0 Month</option>
                                        <option value="1">1 Month</option>
                                        <option value="2">2 Months</option>
                                        <option value="3">3 Months</option>
                                        <option value="4">4 Months</option>
                                        <option value="5">5 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="7">7 Months</option>
                                        <option value="8">8 Months</option>
                                        <option value="9">9 Months</option>
                                        <option value="10">10 Months</option>
                                        <option value="11">11 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_acq_cost" class="col-form-label">ACQUISITION COST :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="n_acq_cost" step="any" name="n_acq_cost" class="form-control comp_ffe" placeholder="0.00">
                                </div>

                                <div class="col-2">
                                    <label for="n_acc_depr" class="col-form-label">ACC. DEPRECIATION :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" readonly id="n_acc_depr" step="any" name="n_acc_depr" class="form-control" placeholder="0.00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_prev_acc_depr" class="col-form-label">PREV ACC. DEPRECATION :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="n_prev_acc_depr" step="any" name="n_prev_acc_depr" class="form-control comp_ffe" placeholder="0.00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_ffe_depr" class="col-form-label">FFE DEPRECIATION :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="n_ffe_depr" readonly step="any" name="n_ffe_depr" class="form-control comp_ffe" placeholder="0.00">
                                </div>

                                <div class="col-2">
                                    <label for="n_book_value" class="col-form-label">BOOK VALUE :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" readonly id="n_book_value" step="any" required name="n_book_value" class="form-control" placeholder="0.00">
                                </div>
                                <div class="col-2">
                                    <i>(as of this month)</i>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_type" class="col-form-label">TYPE :</label>
                                </div>
                                <div class="col-3">
                                    <select id="n_type" name="n_type" required class="form-control">
                                        <option value="" selected disabled>&lt; Select Type &gt;</option>
                                        <option value="Accessories">Accessories</option>
                                        <option value="Non-Accesories">Non-Accesories</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label for="n_status" class="col-form-label">STATUS :</label>
                                </div>
                                <div class="col-3">
                                        <select id="n_status" name="n_status" required class="form-control">
                                        <option value="" selected disabled>&lt; Select Status &gt;</option>
                                        <option value="WORKING">Working</option>
                                        <option value="DEFECTIVE">Defective</option>
                                        <option value="DISPOSED">Disposed</option>
                                    </select>
                                </div>
                            </div>
                        </div>        
                    </div><!--card-->
                    </div>
                        <div class="modal-footer">
                        <button type="button" name="" id="" class="btn btn-success saveItem">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="">Close</button>
                    </div>
                </div>
            </form>   
           </div>
        </div>
    <!-- END ADD ITEM MODAL -->

    <!-- PREVIOUS REPORT GENERATED MODAL -->
    <div class="modal fade" id="prevReports"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h6 class="modal-title" id="exampleModalLongTitle">PREVIOUS GENERATED REPORTS</h6>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" archiveTable">
                                    <thead>
                                        <tr>
                                            <th>REP CODE</th>
                                            <th>BRANCH NAME</th>
                                            <th>REPORT MONTH</th>
                                            <th>CREATED AT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                </table>       
                            </div>
                        </div>        
                    </div><!--card-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="">Close</button>
                </div>
            </div> 
        </div>
    </div>
    <!-- END PREVIOUS REPORT GENERATED MODAL -->

    <!-- START ADD PREPARED AND CERTIFIED BY MODAL -->
    <div class="modal fade" id="addCorrespondentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle">PREPARED & CERTIFIED BY:</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form  method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="input-6">FULL NAME:</label>
                            <input type="text" class="form-control" placeholder="Provide Name" id="preparedBy" name="preparedBy">
                        </div>
                        <div class="col-sm-12 form-group mt-2">
                            <label for="input-6">POSITION: </label>
                            <input type="text" class="form-control" id="position" placeholder="Provide Position">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="printScreen" class="btn btn-success printScreen">PRINT</button>
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD PREPARED AND CERTIFIED BY MODAL -->

    <!-- START EDIT COMPONENTS | INCLUSIONS MODAL -->
    <div class="modal fade" id="comModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h6 class="modal-title" id="exampleModalLongTitle">COMPONENTS | INCLUSIONS</h6>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="saveComChangesForm" class="saveComChangesForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                        </div>        
                    </div><!--card-->
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" id="saveComChanges" class="btn btn-success saveComChanges">Save</button>
                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="">Close</button>
                </div>
            </div> 
        </div>
    </div>
    <!-- END START EDIT COMPONENTS | INCLUSIONS MODAL -->

      <!-- START EDIT STICKER MODAL -->
    <div class="modal fade" id="editStickerModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h6 class="modal-title" id="exampleModalLongTitle">EDIT STICKER SERIES</h6>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="saveComChangesForm" class="saveComChangesForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                        </div>        
                    </div><!--card-->
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" id="saveStickerChanges" class="btn btn-success saveStickerChanges">Save</button>
                    <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="">Close</button>
                </div>
            </div> 
        </div>
    </div>
    <!-- END START EDIT STICKER MODAL -->
            
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>

    <script>

        // added 10-24-25 //

        $('.edit_sticker_no').on('click', function(){
            var qty_code = $(this).attr('data-qty-code');
            var item_loc = $(this).attr('data-item-loc');
            swal.fire({
                title: "Generating",
                text: "Please wait...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    swal.showLoading();
                }
            });
            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                type: 'post',
                data: { action: 'edit_sticker', qty_code: qty_code, item_loc: item_loc },
                success: function(response){ 
                    swal.close();
                    $('#editStickerModal .card-body').html(response);
            
                    // Display the modal
                    $('#editStickerModal').modal('show'); 
                }
            });
        });

        $('.saveStickerChanges').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('action', 'save_sticker'); 
        console.log(formData.get('action'));

        $('.edit-sticker-form').each(function (index, row) {
            let sticker = $(row).find('input[name="item_sticker[]"]').val();
            let description = $(row).find('input[name="item_description[]"]').val();
            let location = $(row).find('input[name="item_location[]"]').val();
            let qtyCode = $(row).find('input[name="item_qty[]"]').val();
            let itemCode = $(row).find('input[name="item_item_code[]"]').val();

            formData.append(`stickers[${index}][sticker]`, sticker);
            formData.append(`stickers[${index}][description]`, description);
            formData.append(`stickers[${index}][location]`, location);
            formData.append(`stickers[${index}][qtyCode]`, qtyCode);
            formData.append(`stickers[${index}][itemCode]`, itemCode);
        });
        swal.fire({
            title: "Updating...",
            text: "Please wait...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                swal.showLoading();
            }
        });

        setTimeout(() => {

        $.ajax({
            url: '../../ajax/saveInventoryChanges.ajax.php',
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false,
            success: function (response) {
                // alert(response);
                if (response === 'ok') {
                    swal.close();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to save update to inventory.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                swal.close();
                console.log(xhr.responseText); 
                alert("An error occurred while saving changes.");
            }
        });
    }, 1000);
    });


        $(document).on('click', '#delete_sticker', function() {
            var item_code = $(this).attr("data-item-code");

                Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to delete?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.isConfirmed) {
                    
                    swal.fire({
                        title: "Deleting...",
                        text: "Please wait...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                    $.ajax({
                        url: '../../ajax/saveInventoryChanges.ajax.php',
                        data: {
                            action: 'delete_sticker',
                            item_code: item_code
                        },
                        method: 'POST', 
                        success: function(data) {
                            if (data === 'ok') {
                                swal.close();
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Selected component deleted successfully.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal.close();
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to delete component from inventory.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred during the AJAX request.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                    }, 1000);
                }
            });
        });
  

        $(document).on('click', '#delete_component', function() {
            var item_code = $(this).attr("data-item-code");

                Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to delete?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.isConfirmed) {
                    
                    swal.fire({
                        title: "Deleting...",
                        text: "Please wait...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                    $.ajax({
                        url: '../../ajax/saveInventoryChanges.ajax.php',
                        data: {
                            action: 'delete_com',
                            item_code: item_code
                        },
                        method: 'POST', 
                        success: function(data) {
                            if (data === 'ok') {
                                swal.close();
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Selected component deleted successfully.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal.close();
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to delete component from inventory.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred during the AJAX request.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                    }, 1000);
                }
            });
        });

       // added 10-15-24 //
       $("#header_month_input").on('change', function() {
            var selectedMonth = $(this).val();
            
            if (selectedMonth) {
                var selectedDate = new Date(selectedMonth + "-25");
                var header_date_timestamp = Math.floor(selectedDate.getTime() / 1000);

                var currentUrl = window.location.href.split('?')[0];
                window.location.href = currentUrl + '?header_date_timestamp=' + header_date_timestamp;
            }
        });

        var getCurMonth = new Date();
        const searchParams = new URLSearchParams(window.location.search);
        var link_val = searchParams.get('header_date_timestamp') ?? Math.floor(getCurMonth.getTime() / 1000) ;
        var selectedDate = new Date(link_val * 1000);
        let curMonth = getCurMonth.getMonth();
        let selectedMonth = selectedDate.getMonth(); 
        let cur_year = getCurMonth.getFullYear();
        let selected_year = selectedDate.getFullYear();

        if(selectedMonth != curMonth || cur_year != selected_year){
            var printScreenBtn = document.getElementById('enableEdit');
            printScreenBtn.setAttribute('disabled', true);
        }

        $('#addItemModal').on('shown.bs.modal', function () {
            $('#components').select2({
                placeholder: "Select components | inclusions",
                allowClear: true,
                tags: true
            });
        });
        
         $(".printScreen").on('click', function() {
            var preparedBy = document.getElementById('preparedBy').value;
            var position = document.getElementById('position').value;
            var selectedDate = document.getElementById('header_month_input').value;

            if (preparedBy != '' && position != 0) {
                $('#addCorrespondentModal').modal('hide');
                swal.fire({
                    title: "Generating...",
                    text: "Please wait...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        swal.showLoading();
                    }
                });
               
                setTimeout(() => {
                    $.ajax({
                        url: '../../ajax/saveInventoryChanges.ajax.php',
                        data: {
                            action: 'archive',
                            preparedBy: preparedBy,
                            position: position,
                            selectedDate: selectedDate
                        },
                        method: 'GET',
                        success: function(response) {
                            if (response === 'ok') {
                                $('.archiveTable').DataTable().ajax.reload(null, false);
                                var printBatchsCAORFormat = 'printExcel.php?preparedBy=' + encodeURIComponent(preparedBy) + '&position=' + encodeURIComponent(position) + '&selectedDate=' + encodeURIComponent(selectedDate);

                                var iframe = document.createElement('iframe');
                                iframe.style.display = 'none';
                                iframe.src = printBatchsCAORFormat;
                                document.body.appendChild(iframe);

                                iframe.onload = function() {
                                    setTimeout(function() {
                                        swal.close();
                                        iframe.contentWindow.focus();
                                        iframe.contentWindow.print();
                                    }, 500);
                                };
                            } else {
                                swal.close();
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
                            swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred during the AJAX request.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

                }, 1000);
    
            } else {
                swal.close();
                Swal.fire({
                    title: 'Notice!',
                    text: 'Please fill in the required input fields.',
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                
            }
        });

        $(".spreadsheet-cell").on('change', function() {
            var item_id = $(this).attr("data-item-id");
            var field_id = $(this).attr("id");
            var field_value = $(this).val();
            var qty_code = $(this).attr("data-qty-code");

            swal.fire({
                title: "Updating...",
                text: "Please wait...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    swal.showLoading();
                }
            });
            setTimeout(() => {
            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: {
                    action: 'update',
                    item_id: item_id,
                    field_id: field_id,
                    field_value: field_value,
                    qty_code: qty_code
                },
                method: 'GET',
                success: function(data) {
                    if (data === 'ok') {
                        swal.close();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Inventory updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(result) {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    } else {
                        swal.close();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update inventory.',
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
        }, 1000);
        });

        $(".saveItem").on('click', function() {
            // Collect form data
            var formData = {
                item_code: $('#n_item_code').val(),
                branch_name: $('#n_branch_name').val(),
                date_purchased: $('#n_date_purchased').val(),
                item_qty: $('#n_item_qty').val(),
                item_description: $('#n_item_description').val(),
                ref_no: $('#n_ref_no').val(),
                sticker_no: $('#n_sticker_no').val(),
                sticker_from: $('#n_sticker_from').val(),
                sticker_to: $('#n_sticker_to').val(),
                est_life_mon: $('#n_est_life_mon').val(),
                est_life_year: $('#n_est_life_year').val(),
                acq_cost: $('#n_acq_cost').val(),
                prev_acc_depr: $('#n_prev_acc_depr').val(),
                acc_depr: $('#n_acc_depr').val(),
                ffe_depr: $('#n_ffe_depr').val(),
                book_value: $('#n_book_value').val(),
                type: $('#n_type').val(),
                status: $('#n_status').val(),
                class_type: $('#class_type').val(),
                class_category: $('#class_category').val(),
                class_list: $('#class_list').val(),
                class_code: $('#class_code').val(),
                components: $('#components').val(),
                cam_count: $('#cam_count').val()
            };

            // Define required fields for validation
            var requiredFields = ['branch_name', 'date_purchased', 'status', 'type', 'acq_cost', 'item_description', 'item_code', 'class_type', 'class_category', 'class_code'];
            
            // Conditional check for Accessories
            if (formData.type === 'Accessories') {
                requiredFields = requiredFields.filter(field => field !== 'sticker_no' && field !== 'sticker_from' && field !== 'sticker_to');
            } else {
                
                if (!formData.sticker_no && (!formData.sticker_from || !formData.sticker_to)) {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please fill either the sticker number or sticker range.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            var isValid = requiredFields.every(field => formData[field]);
            if (!isValid) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please make sure to fill all required fields.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            swal.fire({
                title: "Saving...",
                text: "Please wait...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    swal.showLoading();
                }
            });
            setTimeout(() => {
            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: $.extend({ action: 'insert' }, formData), // Merging action with formData
                method: 'GET',
                success: function(data) {
                    if (data === 'ok') {
                        swal.close();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Inventory saved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(result) {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    } else {
                        swal.close();
                        Swal.fire({
                            title: 'Error!',
                            text: data,
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX error:", textStatus, errorThrown);
                    swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during the AJAX request.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }, 1000);
        });


        $("#n_item_qty").on('change', function() {
            var item_qty = document.getElementById('n_item_qty').value;
            var sticker_no = document.getElementById('n_sticker_no');
            var sticker_from = document.getElementById('n_sticker_from');
            var sticker_to = document.getElementById('n_sticker_to');
            var dash = document.getElementById('dash');

            if (item_qty > 1) {
                sticker_from.removeAttribute('hidden');
                sticker_to.removeAttribute('hidden');
                sticker_no.setAttribute('hidden', true);
                dash.removeAttribute('hidden', true);
            } else {
                sticker_from.setAttribute('hidden', true);
                sticker_to.setAttribute('hidden', true);
                sticker_no.removeAttribute('hidden');
                dash.setAttribute('hidden', true);
            }
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

        // EDIT ENABLING FUNCTION //
        let isEditEnabled = false; // Initialize edit state

        $(".enableEdit").on('click', function() {
            isEditEnabled = !isEditEnabled; // Toggle the state
            const inputCells = document.getElementsByClassName('input-cell');
            // const editCell = document.querySelectorAll('.spreadsheet-cell::disabled');

            if (isEditEnabled) {
                // Enable editing mode
                $(this).removeClass('btn-primary').addClass('btn-secondary');
                $(this).html('<span><i class="fa fa-pencil"></i> &nbsp;Enabled</span>');
                $('.spreadsheet-cell').removeAttr('disabled');
                
                // Iterate over each input-cell
                Array.from(inputCells).forEach(cell => {
                    // Check if it has an edit button inside
                    if ($(cell).find('.edit-btn').length > 0) {
                        $(cell).find('.edit-btn').show();
                        $(cell).find('.spreadsheet-cell').removeAttr('disabled');
                        $(cell).find('.spreadsheet-cell').css('width', '90%');
                    }
                });

            } else {
                // Disable editing mode
                $(this).removeClass('btn-secondary').addClass('btn-primary');
                $(this).html('<span><i class="fa fa-pencil"></i> &nbsp;Enable Edit</span>');
                $('.spreadsheet-cell').attr('disabled', true);

                // Iterate over each input-cell
                Array.from(inputCells).forEach(cell => {
                    // Check if it has an edit button inside
                    if ($(cell).find('.edit-btn').length > 0) {
                        $(cell).find('.edit-btn').hide();
                        $(cell).find('.spreadsheet-cell').attr('disabled', 'disabled');
                        $(cell).find('.spreadsheet-cell').css('width', '');
                    }
                });
            }
        });


        // COMPUTATION SECTION //

        // -- FOR FFE DEPRECIATION -- //
        $(".comp_ffe").on('change', function() {
            var form = $(this).closest('form'); // Find the closest form
            var item_units = parseFloat(form.find('#n_item_qty').val()) || 0;
            var item_cost = parseFloat(form.find('#n_acq_cost').val()) || 0;
            var life_month = parseInt(form.find('#n_est_life_mon').val()) || 0;
            var life_year = parseInt(form.find('#n_est_life_year').val()) || 0;
            var prev_acc_depr = parseFloat(form.find('#n_prev_acc_depr').val()) || 0;
            var cur_def = parseFloat(form.find('#n_ffe_depr').val()) || 0;

            var datePurchased = document.getElementById('n_date_purchased').value;
            
            var total_months = 0;
            var ffe_depr_val = 0;
            var acc_depr_val = 0;
            var book_val = 0;
            var cur_acc_depr = 0;
            
            total_months = (life_year * 12) + life_month;

            var userDate = new Date(datePurchased);
            var currentDate = new Date();
            var totalMonthsSincePurchase = (currentDate.getFullYear() - userDate.getFullYear()) * 12;
            totalMonthsSincePurchase += currentDate.getMonth() - userDate.getMonth();

            if (currentDate.getDate() < userDate.getDate()) {
                totalMonthsSincePurchase--;
            }

            if (totalMonthsSincePurchase >= total_months) {
                if (item_cost != 0 && item_cost > 0) {
                    cur_acc_depr = item_cost - item_units;
                    form.find('#n_prev_acc_depr').val(cur_acc_depr.toFixed(2));
                    book_val = item_units;
                }else{
                    book_val = 0;
                    cur_acc_depr = 0;
                }
                ffe_depr_val = 0;
              
            } else {
                if (item_units > 0 && item_cost > 0 && total_months > 0) {
                    ffe_depr_val = (item_cost - item_units) / total_months;
                } else {
                    ffe_depr_val = 0;
                }

                cur_acc_depr = prev_acc_depr + ffe_depr_val;
                
                if (item_cost === 0) {
                    book_val = 0; 
                }else{
                    book_val = item_cost - cur_acc_depr; 
                }

            }

            // Update form fields with calculated values
            form.find('#n_ffe_depr').val(ffe_depr_val.toFixed(2));
            form.find('#n_acc_depr').val(cur_acc_depr.toFixed(2));
            form.find('#n_book_value').val(book_val.toFixed(2));
        });

    // display archive table modal
    $('.archiveTable').DataTable({
        "ajax": {
            "url": "../../ajax/saveInventoryChanges.ajax.php",
            "type": "GET",
            "data": {
                "action": "showArchive"
            },
            "dataSrc": "data"
        },
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "order": [[0, 'desc']],
        "iDisplayLength": 10
    });
    

    $(".archiveTable").on("click", "tbody .btnRePrintInventory", function(){
        swal.fire({
                title: "Generating...",
                text: "Please wait...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    swal.showLoading();
                }
        });
        var rep_code = $(this).attr("data-rep-code");
        // alert(rep_code);
        // window.open("printExcel.php?rep_code="+rep_code);
        var printBatchsCAORFormat = 'printArchiveExcel.php?rep_code=' + encodeURIComponent(rep_code);
        
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = printBatchsCAORFormat;
        document.body.appendChild(iframe);
     
        // Wait for iframe to load
        iframe.onload = function() {
            setTimeout(function() {
                swal.close();
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 500);  // Delay printing by 500ms
        };
    });

    </script>

<script>
    const subClassOptions = {
        'FURNITURE': [
            { value: 'TABLES', text: 'Table' },
            { value: 'CHAIRS', text: 'Chair' },
            { value: 'CABINETS', text: 'Cabinets' }
        ],
        'FIXTURES': [
            { value: 'IMAGES / STATUES', text: 'Images | Statues' },
            { value: 'DECORATIONS', text: 'Decorations' },
            { value: 'PAINTINGS', text: 'Paintings' },
            { value: 'HOUSEHOLD EFFECTS', text: 'Household Effects' },
            { value: 'APPLIANCES', text: 'Appliances' }
        ],
        'EQUIPMENT': [
            { value: 'COMPUTERS', text: 'Computers' },
            { value: 'PRINTERS / COPIERS', text: 'Printers & Copiers' },
            { value: 'PERIPHERALS / ACCESSORIES', text: 'Peripherals | Accessories' },
            { value: 'CCTV EQUIPMENTS', text: 'CCTV Equipments' },
            { value: 'SOUNDS AND MIXERS', text: 'Sounds & Mixers' },
            { value: 'GADGETS / COMMUNICATION / CONNECTIVITY', text: 'Gadgets | Communication | Connectivity' },
            { value: 'MOTOR VEHICLE', text: 'Motor Vehicle' },
            { value: 'OTHER FFE', text: 'Other FFE' }
        ]
    };

    const classDescOptions = {
        'TABLES': [  // FRT: //
            { value: 'OFFICE TABLE', text: 'Office Table' },
            { value: 'CONFERENCE TABLE', text: 'Conference Table' },
            { value: 'FOYERS', text: 'Foyers' },
            { value: 'CONSOLES', text: 'Consoles' },
            { value: 'SIDE TABLES', text: 'Side Tables' },
            { value: 'COMPUTER TABLE', text: 'Computer Table' },
            { value: 'DINING TABLE', text: 'Dining Table' }
        ],
        'CHAIRS': [ // FRCS: //
            { value: 'COMPUTER CHAIRS', text: 'Computer Chairs' },
            { value: 'SWIVEL CHAIRS', text: 'Swivel Chairs' },
            { value: 'CONFERENCE CHAIR', text: 'Conference Chair' },
            { value: 'VISITORS CHAIR', text: 'VISITORS\'s Chair' },
            { value: 'SOFA', text: 'Sofa' },
            { value: 'GANG CHAIRS', text: 'Gang Chairs' },
            { value: 'STOOL, BENCHES', text: 'Stool, Benches' },
            { value: 'MONOBLOCK CHAIR', text: 'Monoblock Chair' },
            { value: 'WOODEN CHAIR', text: 'Wooden Chair'},
            { value: 'WOODEN KNEELER', text: 'Wooden Kneeler'},
            { value: 'WHEEL CHAIR', text: 'Wheel Chair'}
        ],
        'CABINETS': [ // FRCB: //
            { value: 'STEEL CABINETS WITH VAULTS', text: 'Steel Cabinets with Vaults' },
            { value: 'STEEL CABINET', text: 'Steel Cabinet' },
            { value: 'VAULTS', text: 'Vaults' },
            { value: 'FILING CABINET (MOVABLES)', text: 'Filing Cabinets (movables)' },
            { value: 'OROCANS / CLOTHES CABINET / ARMOIREE', text: 'Orocans | Clothes Cabinet | Armoire' },
            { value: 'TV HOLDER', text: 'TV Holder' },
            { value: 'DIVIDER', text: 'Divider'},
            { value: 'STEEL RACK', text: 'Steel Rack'},
            { value: 'TV CART', text: 'TV Cart'},
            { value: 'BRACKET FOR TV', text: 'Bracket for TV'}
        ],
        'IMAGES / STATUES': [ // FXi: //
            { value: 'IMAGE OF SAINTS', text: 'Image of Saints' },
            { value: 'STATUES', text: 'Statues' },
            { value: 'CRUCIFIX', text: 'Crucifix'}
        ],
        'DECORATIONS': [ // FXD: //
            { value: 'VASES', text: 'Vases' },
            { value: 'FRAMES', text: 'Frames' },
            { value: 'OTHER DECORATIONS (CHRISTMAS DECORS)', text: 'Other Decorations (Christmas Decors)' }
        ],
        'PAINTINGS': [ // FXP: //
            { value: 'ALL PAINTINGS', text: 'All Paintings' },
            { value: 'PICTURES', text: 'Pictures' },
            { value: 'SIGNAGE MATERIALS', text: 'Signage Materials' }
        ],
        'HOUSEHOLD EFFECTS': [ // FXH: //
            { value: 'BED SHEETS, LINENS, PILLOWS', text: 'Bed Sheets | Linens | Pillows' },
            { value: 'ALL KITCHEN, DINNER WARES OTHER THAN APPLIANCES', text: 'All kitchen|Dinner wares other than appliances'},
            { value: 'CURTAINS', text: 'Curtains' },
            { value: 'BLINDS', text: 'Blinds' },
            { value: 'TRASHCANS, CONTAINERS, PAIL ETC', text: 'Trashcans | Containers | Pails etc' },
            { value: 'CURTAIN ROD', text: 'Curtain Rod'},
            { value: 'PASSBOOK PAN', text: 'Passbook Pan'},
            { value: 'FOAM', text: 'Foam'},
            { value: 'DOUBLE DECK WOODEN', text: 'Double Deck Wooden'},
            { value: 'STEEL DOUBLE DECK', text: 'Steel Double Deck'},
            { value: 'GAS STOVE', text: 'Gas Stove'},
            { value: 'ELECTRIC AIR POT', text: 'Electric Air Pot'},
            { value: 'CIGERETTE BUTT', text: 'Cigerette Butt'},
            { value: 'WATER HOSE', text: 'Water Hose'},
            { value: 'FOLDING BED', text: 'Folding Bed'},
            { value: 'GASUL TANK', text: 'Gasul Tank'}
        ],
        'APPLIANCES': [ // FXA: //
            { value: 'TV', text: 'TV' },
            { value: 'RICE COOKER', text: 'Rice Cooker' },
            { value: 'FLAT IRON', text: 'Flat iron'},
            { value: 'ELECTRIC FAN', text: 'Electric Fan'},
            { value: 'REFRIGeRATOR', text: 'Refrigerator'},
            { value: 'HIMIDIFIERS', text: 'Humidifiers'},
            { value: 'AIRCONS', text: 'Aircons'},
            { value: 'EMERGENCY LIGHT', text: 'Emergency Light'},
            { value: 'PURIFIER', text: 'Purifier'},
            { value: 'CEILING FAN', text: 'Ceiling Fan'},
            { value: 'SMOKE DETECTOR', text: 'Smoke Detector'},
            { value: 'UV LIGHT', text: 'UV Light'},
            { value: 'AIR COOLER', text: 'Air Cooler'},
            { value: 'VACUUM CLEANER', text: 'Vacuum Cleaner'},
            { value: 'ELECTRIC HEATER', text: 'Electric Heater'}
        ],
        'COMPUTERS': [  // EQC: //
            { value: 'COMPUTER SET', text: 'Computer Set' },
            { value: 'LAPTOP', text: 'Laptop' },
            { value: 'MONITOR', text: 'Monitor' },
            { value: 'AVR', text: 'AVR' },
            { value: 'UPS', text: 'UPS' },
            { value: 'ADDITIONAL HARD DRIVE, MOTHER BOARD', text: 'Additional Hard Drive | Mother Board' },
            { value: 'IPAD', text: 'Ipad' },
            { value: 'TABLETS', text: 'Tablets' }
        ],
        'PRINTERS / COPIERS': [  // EQPC: //
            { value: 'ALL PRINTERS', text: 'All Printers' },
            { value: 'PHOTOCOPIERS', text: 'Photocopiers' },
            { value: 'SCANNERS', text: 'Scanners' },
            { value: 'FAX MACHINE', text: 'Fax Machine' },
            { value: 'SHREDDER', text: 'Shredder'}
        ],
        'PERIPHERALS / ACCESSORIES': [ // EQPA:  //
            { value: 'MOUSE', text: 'Mouse' },
            { value: 'CAMERA', text: 'Camera' },
            { value: 'EXTERNAL DRIVES', text: 'External Drives' },
            { value: 'KEYBOARDS / NUMERIC PADS', text: 'Keyboards|Numeric Pads' },
            { value: 'PROJECTORS (LCD)', text: 'Projectors (LCD)' },
            { value: 'SCREEN', text: 'Screen' },
            { value: 'UNIT TYPE WRITER', text: 'Unit Type Writer'},
            { value: 'PRINTER CABLE', text: 'Printer Cable'},
            { value: 'UNIT ADDING MACHINE', text: 'Unit Adding Machine'},
            { value: 'CALCULATOR', text: 'Calculator'},
            { value: 'ELECTRICAL WIRINGS', text: 'Electrical Wirings'},
            { value: 'FIRE EXTINGUISHER', text: 'Fire Extinguisher'},
            { value: 'REFILL OF FIRE EXTINGUISHER', text: 'Refill of Fire Extinguisher'},
            { value: 'FILTER FOR WATER PURIFIER', text: 'Filter for Water Purifier'},
            { value: 'LADDER', text: 'Ladder'},
            { value: 'TYPE WRITER MANUAL', text: 'Type Writer Manual'},
            { value: 'ELECTRIC PIPE AND ELBOW', text: 'Electric Pipe and Elbow'}
        ],
        'CCTV EQUIPMENTS': [ // EQCV: //
            { value: 'CCTV SET', text: 'CCTV Set' },
            { value: 'CCTV CAMERA', text: 'CCTV Camera' },
            { value: 'DVR', text: 'DVR' },
            { value: 'POWER SUPPLY', text: 'Power Supply'}
        ],
        'SOUNDS AND MIXERS': [ // EQSM: //
            { value: 'MIC, WIRELESS, LAPEL', text: 'Mic | Wireless | Lapel' },
            { value: 'MIXER', text: 'Mixer' },
            { value: 'SPEAKERS', text: 'Speakers' },
            { value: 'PLAYERS', text: 'Players'},
            { value: 'CONSOLE', text: 'Console'},
            { value: 'AMPLIFIER', text: 'Amplifier'}
        ],
        'GADGETS / COMMUNICATION / CONNECTIVITY': [ // EQGC: //
            { value: 'CELLPHONE', text: 'Cellphone' },
            { value: 'TELEPHONES', text: 'Telephones' },
            { value: 'WIRELESS WIFI', text: 'Wireless Wifi' }
        ],
        'MOTOR VEHICLE': [ // EQMV: //
            { value: 'CARS, SEDAN, SUV, PICK UP, VANS', text: 'Cars | Sedan | SUV | Pickup | Vans' },
            { value: 'MOTORCYCLE', text: 'Motorcycle' }
        ],
        'OTHER FFE': [ // OFFE: //
            { value: 'COLLECTORS BAG', text: 'Collectors Bag'},
            { value: 'HELMET', text: 'Helmet'},
            { value: 'RAINCOATS, BOATS', text: 'Rain Coats, Boots'},
            { value: 'BLACK BOARD / WHITE BOARD', text: 'Black Board | White Board'},
            { value: 'CASH BOX', text: 'Cash Box'},
            { value: 'STEEL CART', text: 'Steel Cart'},
            { value: 'GENERATOR', text: 'Generator'},
            { value: 'WEIGHING SCALE', text: 'Weighing Scale'},
            { value: 'ACRYLIC BARRIER', text: 'Acrylic Barrier'},
            { value: 'SUBMETER', text: 'Submeter'},
            { value: 'WATER PRESSURE TANK', text: 'Water Pressure Tank'},
            { value: 'SENSORED ALCOHOL DISPENSER', text: 'Sensored Alcohol Dispenser'},
            { value: 'EXHAUST FAN', text: 'Exhaust Fan'},
            { value: 'TOP GLASS', text: 'Top Glass'},
            { value: 'FIRE ALARM', text: 'Fire Alarm'},
            { value: 'SIMCARD', text: 'Sim Card'},
            { value: 'TABLE BARRIER', text: 'Table Barrier'}
        ]
    };

    const compClassOptions = {
        CCTV: [
            { value: 'CCTV', text: 'CCTV' },
            { value: 'MONITOR', text: 'Monitor' },
            { value: 'HARD DRIVE', text: 'Hard Drive' },
            { value: 'POWER SUPPLY', text: 'Power Supply' }
        ],
        COMPUTER: [
            { value: 'MONITOR', text: 'Monitor' },
            { value: 'AVR', text: 'AVR' },
            { value: 'MOUSE', text: 'Mouse' },
            { value: 'KEYBOARD', text: 'Keyboard' },
            { value: 'UPS', text: 'UPS' }
        ]
    };

    document.getElementById('class_type').addEventListener('change', function() {
        const selectedClass = this.value;
        const subClassSelect = document.getElementById('class_category');
        const classDescSelect = document.getElementById('class_list');

        // Clear previous options in sub_class and class_desc
        subClassSelect.innerHTML = '<option value="" selected disabled>&lt; Select Class Category &gt;</option>';
        classDescSelect.innerHTML = '<option value="" selected disabled>&lt; Select Class List &gt;</option>';

        // Populate sub_class options based on selected class
        if (subClassOptions[selectedClass]) {
            subClassOptions[selectedClass].forEach(option => {
                const newOption = new Option(option.text, option.value);
                subClassSelect.add(newOption);
            });
        }
    });

    document.getElementById('class_category').addEventListener('change', function() {
        const selectedSubClass = this.value;
        const classDescSelect = document.getElementById('class_list');
        const codeInput = document.getElementById('class_code'); 

        // Clear previous options in class_desc
        classDescSelect.innerHTML = '<option value="" selected disabled>&lt; Select Class List &gt;</option>';

        // Populate class_desc options based on selected sub_class
        if (classDescOptions[selectedSubClass]) {
            classDescOptions[selectedSubClass].forEach(option => {
                const newOption = new Option(option.text, option.value);
                classDescSelect.add(newOption);
            });
        }
        switch (selectedSubClass) {
            case 'TABLES':
                code = 'FRT';
                break;
            case 'CHAIRS':
                code = 'FRCS';
                break;
            case 'CABINETS':
                code = 'FRCB';
                break;
            case 'IMAGES / STATUES':
                code = 'FXI';
                break;
            case 'DECORATIONS':
                code = 'FXD';
                break;
            case 'PAINTINGS':
                code = 'FXP';
                break;
            case 'HOUSEHOLD EFFECTS':
                code = 'FXH';
                break;
            case 'APPLIANCES':
                code = 'FXA';
                break;
            case 'COMPUTERS':
                code = 'EQC';
                break;
            case 'PRINTERS / COPIERS':
                code = 'EQPC';
                break;
            case 'PERIPHERALS / ACCESSORIES':
                code = 'EQPA';
                break;
            case 'CCTV EQUIPMENTS':
                code = 'EQCV';
                break;
            case 'SOUNDS AND MIXERS':
                code = 'EQSM';
                break;
            case 'GADGETS / COMMUNICATION / CONNECTIVITY':
                code = 'EQGC';
                break;
            case 'MOTOR VEHICLE':
                code = 'EQMT';
                break;
            case 'OTHER FFE':
                code = 'OFFE';
                break;
            default:
                code = '';
        }
        $.ajax({
            url: '../../ajax/saveInventoryChanges.ajax.php',
            data: {
                action: 'getNextClassCode',
                class_category: code
            },
            method: 'GET',
            success: function(response) {
                try {
                    const data = JSON.parse(response);  // Parse JSON response from the server
                    if (data.success) {
                        const nextCode = data.next_class_code;
                        // Set the generated code in the input field
                        codeInput.value = code + String(nextCode).padStart(5, '0');
                    } else {
                        console.error('Error fetching the next class code:', data.message);
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error:", textStatus, errorThrown);
                console.log("Response:", jqXHR.responseText);
            }
        });
    });

    document.getElementById('class_list').addEventListener('change', function() {
        const selectedClassList = this.value;
        const compClassSelect = document.getElementById('components');
        const hidden_row = document.getElementById('hidden_row');
        const cam_count = document.getElementById('cam_count');
        const cam_label = document.getElementById('cam_label');

        hidden_row.setAttribute('hidden', true);

        if (selectedClassList === 'COMPUTER SET') {
            selectedValue = 'COMPUTER';
            hidden_row.removeAttribute('hidden');
        }
        if (selectedClassList === 'CCTV SET') {
            selectedValue = 'CCTV';
            hidden_row.removeAttribute('hidden');
        }
        // Clear previous options
        compClassSelect.innerHTML = '';

        // Populate class_desc options based on selected sub_class
        if (compClassOptions[selectedValue]) {
            compClassOptions[selectedValue].forEach(option => {
                const newOption = new Option(option.text, option.value);
                compClassSelect.add(newOption);
            });
        }
    });

        function populateComponents(category) {
            const options = compClassOptions[category] || [];
            $('#components').empty();

            options.forEach(option => {
                const newOption = new Option(option.text, option.value, false, false);
                $('#components').append(newOption);
            });
            $('#components').trigger('change');
        }

        populateComponents('CCTV');
        $('#components').on('change', function() {
            const selectedOptions = $(this).val();
            const cam_count = document.getElementById('cam_count');
            const cam_label = document.getElementById('cam_label');

            if (selectedOptions.includes('CCTV')) {
                cam_count.removeAttribute('hidden');
                cam_label.removeAttribute('hidden');
                cam_count.value = 1;  // Set default value to 1
            } else {
                cam_count.setAttribute('hidden', true);
                cam_label.setAttribute('hidden', true);
                cam_count.value = 0;  // Set default value to 1
            }

            console.log(selectedOptions);
        });

        //FOR CHECK BOX DELETING ROWS //

        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.rowCheckbox');
        const deleteButton = document.getElementById('deleteButton');

        function updateDeleteButtonVisibility() {
 
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            
            deleteButton.style.display = anyChecked ? 'block' : 'none';
        }

        function getCheckedRowsData() {
            const checkedRows = [];
            const checkboxes = document.querySelectorAll('.rowCheckbox:checked'); // Select checked checkboxes

            checkboxes.forEach(checkbox => {
                checkedRows.push({
                    itemId: checkbox.getAttribute('data-item-id'),
                    qtyCode: checkbox.getAttribute('data-qty-code'),
                    classCode: checkbox.getAttribute('data-class-code'),
                    branchName: checkbox.getAttribute('data-branch-name')
                });
            });

            return checkedRows;
        }

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkAll.checked; 
            });
            updateDeleteButtonVisibility(); 
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (!checkbox.checked) {
                    checkAll.checked = false;  
                } else if (Array.from(checkboxes).every(cb => cb.checked)) {
                    checkAll.checked = true; 
                }
                updateDeleteButtonVisibility();
            });
        });

        updateDeleteButtonVisibility();

        document.getElementById('deleteButton').addEventListener('click', function() {
        const checkedRows = getCheckedRowsData(); 
        
        if (checkedRows.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Selection',
                text: 'Please select at least one row to delete.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        let formData = new FormData();
        formData.append('action', 'delete');

        checkedRows.forEach(function(row, index) {
            formData.append(`checkedRows[${index}][itemId]`, row.itemId);
            formData.append(`checkedRows[${index}][qtyCode]`, row.qtyCode);
            formData.append(`checkedRows[${index}][classCode]`, row.classCode);
            formData.append(`checkedRows[${index}][branchName]`, row.branchName);
        });

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to delete?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes'
        }).then(function(result) {
            if (result.isConfirmed) {
                
                swal.fire({
                    title: "Deleting...",
                    text: "Please wait...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        swal.showLoading();
                    }
                });

                setTimeout(() => {
                $.ajax({
                    url: '../../ajax/saveInventoryChanges.ajax.php',
                    data: formData,
                    method: 'POST',
                    processData: false,  
                    contentType: false, 
                    success: function(data) {
                        if (data === 'ok') {
                            swal.close();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Selected rows deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete selected rows from inventory.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        swal.close();
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred during the AJAX request.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                }, 1000);
            }
        });
    });

    window.addEventListener('scroll', function() {
        var header = document.querySelector('.spreadsheet .row:first-child');
        var sticky = header.offsetTop;
        var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        var screenMarginLeft = document.querySelector('.spreadsheet').offsetLeft;

        if (window.pageYOffset > sticky) {
            header.classList.add('header-fixed');
            header.style.left = -scrollLeft + screenMarginLeft + 'px';
        } else {
            header.classList.remove('header-fixed');
            header.style.left = '0px';
        }
    });


    $('.edit_components').on('click', function(){
        var class_code = $(this).attr('data-class-code');
        var item_loc = $(this).attr('data-item-loc');
        swal.fire({
            title: "Generating",
            text: "Please wait...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                swal.showLoading();
            }
        });
        $.ajax({
            url: '../../ajax/saveInventoryChanges.ajax.php',
            type: 'post',
            data: { action: 'edit_com', class_code: class_code, item_loc: item_loc },
            success: function(response){ 
                swal.close();
                $('#comModal .card-body').html(response);
        
                // Display the modal
                $('#comModal').modal('show'); 
            }
        });
    });

    $('.saveComChanges').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('action', 'save_com'); 
        console.log(formData.get('action'));

        $('.populated-form').each(function (index, row) {
            let sticker = $(row).find('input[name="com_sticker[]"]').val();
            let description = $(row).find('input[name="com_description[]"]').val();
            let location = $(row).find('input[name="com_location[]"]').val();
            let classCode = $(row).find('input[name="com_class[]"]').val();
            let itemCode = $(row).find('input[name="com_item[]"]').val();

            formData.append(`components[${index}][sticker]`, sticker);
            formData.append(`components[${index}][description]`, description);
            formData.append(`components[${index}][location]`, location);
            formData.append(`components[${index}][classCode]`, classCode);
            formData.append(`components[${index}][itemCode]`, itemCode);
        });
        swal.fire({
            title: "Updating...",
            text: "Please wait...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                swal.showLoading();
            }
        });

        setTimeout(() => {

        $.ajax({
            url: '../../ajax/saveInventoryChanges.ajax.php',
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false,
            success: function (response) {
                // alert(response);
                if (response === 'ok') {
                    swal.close();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to save update to inventory.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                swal.close();
                console.log(xhr.responseText); 
                alert("An error occurred while saving changes.");
            }
        });
    }, 1000);
    });

</script>

</body>
</html>
