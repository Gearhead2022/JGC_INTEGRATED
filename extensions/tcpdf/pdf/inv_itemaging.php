<?php
require_once "../../../controllers/qrcode.controller.php";
require_once "../../../models/qrcode.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new Inventory();
$type = $_GET['type'];
if($type == "Aging Report"){
    $clientsForm->reportAging();
}elseif($type == "Pending Report"){
    $clientsForm->reportPending();
}elseif($type == "Repair Report"){
    $clientsForm->reportRepair();
}

class Inventory {

    public function reportAging() {
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set document information
        $pdf->SetHeaderData('', '', '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(8, 8, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage();
        // Set font
        $pdf->SetFont('aealarabiya', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
        $status = $_GET['status'];
        $currentDate = date('Y-m-d');   
        $date = date('F j, Y');     
       
        function getAges($date_purchased) {
            $startDate = new DateTime($date_purchased);
            $currentDate = new DateTime(); // Current date
        
            // Calculate the difference
            $interval = $startDate->diff($currentDate);
        
            // Get the difference in months and days
            $months = $interval->y * 12 + $interval->m;
            $days = $interval->d;
            if ($months == 0) {
                // Handle the case where there are no months
                return $days == 1 ? "$days day" : ($days > 1 ? "$days days" : "");
            } else {
                // Handle the case where there is at least one month
                $monthText = $months == 1 ? "month" : "months";
                $dayText = $days == 1 ? "day" : ($days > 1 ? "days" : "");
            
                if ($days == 0) {
                    return "$months $monthText";
                } else {
                    return "$months $monthText and $days $dayText";
                }
            }
            
        
        }


        $header = '
        <style>
            .border1 {
                border: 1px solid black;
                padding: 4px;
                text-align: center;
                vertical-align: middle; /* This works best with padding adjustments */
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                text-align: center;
                vertical-align: middle;
                font-size: 0.7em;
                padding-top: 3px;
                padding-bottom: 3px;
                height: 18px;
            }
            .border {
                background-color: #D9D9D9;
                border: 1px solid black;
                text-align: center;
                padding: 4px;
            }
                  .spacer{
                font-size: 0.5em;
                color: #D9D9D9;
         }
        </style>
        
        <h5 style="text-align: right; color: grey;">'.$currentDate.'</h5>
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
        <h1 style="text-align: center;">ITEM AGING REPORT</h1>
        
        <table>
            <thead>
                <tr>
                    <th class="border" style="width:50px;"><span class="spacer">dwdwdwaddwadwwada</span>No.</th>
                    <th class="border" style="width:60px;"><span class="spacer">dwdwdwaddwadwwada</span>Sticker No</th>
                    <th class="border" style="width:200px;"><span class="spacer">
                    dwdwdwaddwadwwadadawdwadddawdwadddwadwadwadawaddwadwadwadwadwadwd
                    </span>Item Description</th>
                    <th class="border" style="width:85px;"><span class="spacer">
                    ddwdasdasdssfffsssdawdw
                    </span>Date Purchased</th>
                    <th class="border" style="width:70px;">Age (months)</th>
                    <th class="border" style="width:140px;"><span class="spacer">
                    dwdwdwaddwadwwaddawdadssdsdsadawd
                    </span>Branch / Location</th>
                    <th class="border" style="width:85px;"><span class="spacer">
                    dwdwdwaddwadwwadadass
                    </span>Status</th>
                </tr>
            </thead>
            <tbody>';
        
        $i = 1;
        $inventory = (new ControllerQRCode)->ctrGetAllDataByBranch($branch, $status);
        foreach($inventory as $row) {
            $sticker_no = $row['sticker_no'];
            $item_description = $row['item_description'];
            $date_purchased = $row['date_purchased'];
            $age = getAges($date_purchased);// Static value here, can be dynamic
            $item_location = $row['item_location'];
            $status = $row['invstatus'];

            
        
            $header .= '
                <tr>
                    <td class="border1" style="width:50px;">'.$i.'</td>
                    <td class="border1" style="width:60px;">'.$sticker_no.'</td>
                    <td class="border1" style="width:200px;">'.$item_description.'</td>
                    <td class="border1" style="width:85px;">'.$date_purchased.'</td>
                    <td class="border1" style="width:70px;">'.$age.'</td>
                    <td class="border1" style="width:140px;">'.$item_location.'</td>
                    <td class="border1" style="width:85px;">'.$status.'</td>
                </tr>';
            $i++;
        }
        
        $header .= '
            </tbody>
        </table>';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }


    public function reportPending() {
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set document information
        $pdf->SetHeaderData('', '', '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(8, 8, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage();
        // Set font
        $pdf->SetFont('aealarabiya', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
        $currentDate = date('Y-m-d');   
        $date = date('F j, Y');     
       
        function getDaysDifference($date_purchased) {
            $startDate = new DateTime($date_purchased);
            $currentDate = new DateTime(); // Current date
        
            // Calculate the difference
            $interval = $startDate->diff($currentDate);
        
            // Get the difference in days
            $totalDays = $interval->days; // Returns the total difference in days
        
            return $totalDays;
        }
        


        $header = '
        <style>
            .border1 {
                border: 1px solid black;
                padding: 4px;
                height:15px;
                text-align: center;
                vertical-align: middle; /* This works best with padding adjustments */
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                text-align: center;
                vertical-align: middle;
                font-size: 0.7em;
            }
            .border {
                background-color: #D9D9D9;
                border: 1px solid black;
                text-align: center;
            }
        .spacer{
                font-size: 0.5em;
                color: #D9D9D9;
         }
        </style>
        
        <h5 style="text-align: right; color: grey;">'.$currentDate.'</h5>
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
        <h1 style="text-align: center;">PENDING REPAIR REPORT</h1>
        
        <table>
            <thead>
                <tr>
                    <th class="border" style="width:50px;"><span class="spacer">dwdwdwaddwadwwada</span>NO.</th>
                    <th class="border" style="width:60px;"><span class="spacer">dwdwdwdw</span>STICKER</th>
                    <th class="border" style="width:200px;"><span class="spacer">
                    dawdwadwaddwdwddwadwadwadwaddawdwadddddddddddddddawawawawawawawawaw
                    </span>ITEM DESCRIPTION</th>
                    <th class="border" style="width:140px;"><span class="spacer">
                   dawawawawawawawawawawawdwaddwadwadwdwdwaddw
                    </span>BRANCH</th>
                    <th class="border" style="width:95px;"><span class="spacer">
                          adwadddssdsdsdsdsad
                    </span>DATE RECEIVED</th>
                    <th class="border" style="width:70px;">DURATION (Days)</th>
                    <th class="border" style="width:85px;"><span class="spacer">
                    dwdwdwaddwaddawdawd
                    </span>STATUS</th>
                </tr>
            </thead>
            <tbody>';
        
        $i = 1;
        $inventory = (new ControllerQRCode)->ctrGetAllPendingItem($branch);
        foreach($inventory as $row) {
            $sticker_no = $row['sticker_no'];
            $item_description = $row['item_description'];
            $log_date = date('Y-m-d', strtotime($row['log_date']));
            $age = getDaysDifference($log_date);// Static value here, can be dynamic
            $item_location = $row['item_location'];
            $status = $row['invstatus'];

            
        
            $header .= '
                <tr>
                    <td class="border1" style="width:50px;">'.$i.'</td>
                    <td class="border1" style="width:60px;">'.$sticker_no.'</td>
                    <td class="border1" style="width:200px;">'.$item_description.'</td>
                    <td class="border1" style="width:140px;">'.$item_location.'</td>
                    <td class="border1" style="width:95px;">'.$log_date.'</td>
                    <td class="border1" style="width:70px;">'.$age.'</td>
                    <td class="border1" style="width:85px;">'.$status.'</td>
                </tr>';
            $i++;
        }
        
        $header .= '
            </tbody>
        </table>';
     
        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }


    public function reportRepair() {
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set document information
        $pdf->SetHeaderData('', '', '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(8, 8, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage();
        // Set font
        $pdf->SetFont('aealarabiya', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
        $currentDate = date('Y-m-d');   
        $date = date('F j, Y');     
       
        function getDaysDifference($date_purchased) {
            $startDate = new DateTime($date_purchased);
            $currentDate = new DateTime(); // Current date
        
            // Calculate the difference
            $interval = $startDate->diff($currentDate);
        
            // Get the difference in days
            $totalDays = $interval->days; // Returns the total difference in days
        
            return $totalDays;
        }
        


        $header = '
        <style>
            .border1 {
                border: 1px solid black;
                padding: 4px;
                height:13px;
                text-align: center;
                vertical-align: middle; /* This works best with padding adjustments */
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                text-align: center;
                vertical-align: middle;
                font-size: 0.7em;
            }
            .border {
                background-color: #D9D9D9;
                border: 1px solid black;
                text-align: center;
                height: 25px;
            }
        .spacer{
                font-size: 0.5em;
                color: #D9D9D9;
         }
        </style>
        
        <h5 style="text-align: right; color: grey;">'.$currentDate.'</h5>
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
        <h1 style="text-align: center;">REPAIR STATUS REPORT</h1>
        
        <table>
            <thead>
                <tr>
                    <th class="border" style="width:50px;"><span class="spacer">dwdwdwaddwadwwada</span>NO.</th>
                    <th class="border" style="width:60px;"><span class="spacer">
                    ddwaw
                    </span>STICKER</th>
                    <th class="border" style="width:200px;"><span class="spacer">
                    dawdwadwaddwdwddwadwadwadwaddawdwadddddddddddddddawawawawawawawawaw
                    </span>ITEM DESCRIPTION</th>
                    <th class="border" style="width:140px;"><span class="spacer">
                   dawawawawawawawawawawawdwaddwadwadwdwdwaddw
                    </span>BRANCH</th>
                    <th class="border" style="width:90px;"><span class="spacer">
                    dwdawdawdwadwasds
                    </span>LAST REPAIRED</th>
                    <th class="border" style="width:70px;"><span class="spacer">
                    dwdwdwaddwa
                    </span>REPAIR</th>
                    <th class="border" style="width:85px;"><span class="spacer">
                    dwdwdwaddwaddawdawd
                    </span>STATUS</th>
                </tr>
            </thead>
            <tbody>';
        
        $i = 1;
        $inventory = (new ControllerQRCode)->ctrGetAllRepairItem($branch);
        foreach($inventory as $row) {
            $sticker_no = $row['sticker_no'];
            $item_description = $row['item_description'];
            $last_repaired = !empty($row['last_repaired']) ? date('Y-m-d', strtotime($row['last_repaired'])) : "";
            $repair = $row['repair'];
            $item_location = $row['item_location'];
            $status = $row['status'];

            
        
            $header .= '
                <tr>
                    <td class="border1" style="width:50px;">'.$i.'</td>
                    <td class="border1" style="width:60px;">'.$sticker_no.'</td>
                    <td class="border1" style="width:200px;">'.$item_description.'</td>
                    <td class="border1" style="width:140px;">'.$item_location.'</td>
                    <td class="border1" style="width:90px;">'.$last_repaired.'</td>
                    <td class="border1" style="width:70px;">'.$repair.'</td>
                    <td class="border1" style="width:85px;">'.$status.'</td>
                </tr>';
            $i++;
        }
        
        $header .= '
            </tbody>
        </table>';
     
        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }
}
?>
