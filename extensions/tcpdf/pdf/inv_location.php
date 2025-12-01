<?php
require_once "../../../controllers/qrcode.controller.php";
require_once "../../../models/qrcode.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new Inventory();
$type = $_GET['type'];
if($type == "Undelivered Items"){
    $clientsForm->reportUndeliveredItems();
}
class Inventory {

    public function reportUndeliveredItems() {
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);

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
        $pdf->SetFont('helvetica', '', 12); // Set font to Helvetica
  
        $currentDate = date('Y-m-d');   
        $date = date('F j, Y');     

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
                font-size: 0.75em;
                padding-top: 3px;
                padding-bottom: 3px;
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
        .bold-text {
            font-weight: bold;
            }

        </style>
        
      
        <h4>Date: '.$date.'</h4>
        <table>
            <tr>
                <td  style="text-align: center; font-size: 1.4em;   font-weight: bold; ">REPORT OF UNDELIVERED ITEMS TO LOCATION</td>
            </tr>
            <tr>
                <td  style="text-align: center; font-size: 1em; height:25px;"></td>
            </tr>
        </table>
        
        <table>
            <thead>
                <tr>
                    <th class="border bold-text" style="width:40px;">NO.</th>
                    <th class="border bold-text" style="width:85px;">STICKER NO.</th>
                    <th class="border bold-text" style="width:180px;">ITEM DESCRIPTION</th>
                    <th class="border bold-text" style="width:148px;">BRANCH NAME</th>
                    <th class="border bold-text" style="width:120px;">DATE PURCHASED</th>
                    <th class="border bold-text" style="width:110px;">PENDING DAYS</th>
                </tr>
            </thead>
            <tbody>';
        $i = 1;
        $getUndelivered = (new ControllerQRCode)->ctrGetUndeliveredItem();
        foreach($getUndelivered as $item){
            $sticker_no = $item['sticker_no'];
            $item_description = $item['item_description'];
            $item_location = $item['item_location'];
            $date_purchased = $item['date_purchased'];

         // Convert to DateTime objects
        $currentDateTime = new DateTime($currentDate);
        $datePurchasedTime = new DateTime($date_purchased);

        // Calculate the difference
        $interval = $currentDateTime->diff($datePurchasedTime);

        // Get months and days
        $months = $interval->m;
        $days = $interval->d;

        // Display result
        if ($months > 0) {
            $days_pending = "{$months} month and {$days} days";
        } else {
            $days_pending = "{$days} days";
        }

        $header .= '
                <tr>
                    <td class="border1" style="width:40px;">'.$i.'</td>
                    <td class="border1" style="width:85px;">'.$sticker_no.'</td>
                    <td class="border1" style="width:180px;">'.$item_description.'</td>
                    <td class="border1" style="width:148px;">'.$item_location.'</td>
                    <td class="border1" style="width:120px;">'.$date_purchased.'</td>
                    <td class="border1" style="width:110px;">'.$days_pending.'</td>
                </tr>';
                $i++;
            }


        $header .= '     
            </tbody>
        </table>
      
        ';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }
}