<?php
require_once "../../../controllers/qrcode.controller.php";
require_once "../../../models/qrcode.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new CheckWriter();
$clientsForm->printCheckWriter();

class CheckWriter {

    public function printCheckWriter() {

        $connection = new Connection();
        if (!$connection->connect()) {
            die("Database connection failed.");
        }

      
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
        $pdf->SetMargins(12, 12, PDF_MARGIN_RIGHT);
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
        $pdf->SetFont('helvetica', '', 11); // Set font to Helvetica
    
        $currentDate = date("F j, Y");
       
        $date = $_GET['date'];

        $request = (new ControllerQRCode)->ctrGetAllRequest($date);
        
        $header = '
            <style>
                .border{

                    border: 1px solid black;
                    }  
                    
                    tr th{
                            font-size: 0.7em;
                            font-weight:bold;
                        }
                             tr td{
                            font-size: 0.7em;
                        }
            </style>
            <table>
                <tbody>
                <tr>
                    <td style="height:22px;  font-size: 1em;"><span style="font-weight:bold;">Request From:</span> MIS Department</td>
                </tr>
                 <tr>
                    <td style="height:22px;  font-size: 1em;"><span style="font-weight:bold;">To:</span> HROM Printing Department</td>
                </tr>
                 <tr>
                    <td style="height:22px;  font-size: 1em;"><span style="font-weight:bold;">DATE:</span> '.$currentDate.'</td>
                </tr>
                </tbody>
            </table>
            <br>
            <p><span style="font-weight:bold;">Subject:</span> Request for New Sticker Numbers</p>
          
            <p>The MIS Department has requested new sticker numbers for the following items:</p>
            <table class= "border" style="width: 680px;">
                <thead>
                    <tr style="background-color:#e5e5e5; text-align: center;">
                        <th style=" border: 1px solid black; width: 170px;height:17px;">BRANCH NAME</th>
                        <th style=" border: 1px solid black;width: 90px;">STICKER NO.</th>
                        <th style=" border: 1px solid black; width: 200px;">ITEM DESCRIPTION</th>
                        <th style=" border: 1px solid black;width: 100px;">SERIAL NO.</th>
                        <th style=" border: 1px solid black;width: 120px;">DATE PURCHASED</th>
                    </tr>
                </thead>
                <tbody>';
               
                foreach($request as $req){
                    $branch = $req['branch_name'];
                    $sticker_no = $req['sticker_no'];
                    $item_description = $req['item_description'];
                    $serial_no = $req['serial_no'];
                    $date_purchased = $req['date_purchased'];
             $header .='
                    <tr style=" text-align: center;">
                        <td style=" border: 1px solid black; width: 170px; height:17px;">'.$branch.'</td>
                        <td style=" border: 1px solid black;width: 90px;">'.$sticker_no.'</td>
                        <td style=" border: 1px solid black; width: 200px;">'.$item_description.'</td>
                        <td style=" border: 1px solid black;width: 100px;">'.$serial_no.'</td>
                        <td style=" border: 1px solid black;width: 120px;">'.$date_purchased.'</td>
                    </tr>';
                }
                   $header .='  
                </tbody>
            </table>
    <br>
            <p>Please proceed with printing the new stickers as requested. If there are any issues or additional details required, kindly contact the MIS Department.</p>
            <br>
            <p>Thank you for your prompt attention.</p>




      ';


        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Inventory Request', 'I');
    }
}
?>
