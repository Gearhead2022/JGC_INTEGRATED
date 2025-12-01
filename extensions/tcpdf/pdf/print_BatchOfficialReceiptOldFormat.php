<?php
require_once "../../../controllers/orprinting.controller.php";
require_once "../../../models/orprinting.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new printClientList_2();
$clientsForm -> getClientsPrinting_2();

class printClientList_2{

public function getClientsPrinting_2(){

    $connection = new connection;
    $connection->connect();

    $tdate = $_GET['tdate'];  
    $branch_name = $_GET['branch_name'];


    require_once('tcpdf_include.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->startPageGroup();
    $pdf->setPrintHeader(false);  /*remove line on top of the page*/
    $pdf->setPrintFooter(false);  /*remove line on top of the page*/

    // set document information
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(2, 12, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    
    $time = time();
    $date=date("M-d-y", $time);

    $data = (new ControllerORPrinting)->ctrGetAllCollectionReceiptInfo($tdate, $branch_name);
    $header = '';
    foreach ($data as &$item) {

        $header = '';

        $account_id = $item['account_id'];
        $name = $item['name'];
        $amount = number_format($item['amount'], 2, '.', ',');
        $birsales = $item['birsales'];
        // $birsales = number_format($item['birsales'], 2, '.', ',');
        $biramt = number_format($item['biramt'], 2, '.', ',');
        $tdate = $item['tdate'];
        $rdate = $item['rdate'];
        $ttime = $item['ttime'];
        $desc = $item['desc'];
        $space = '  ';  // Two spaces
        $format_date_month = date("F", strtotime($tdate));
        $format_date_date = date("d", strtotime($tdate));
        $format_date_year = date("y", strtotime($tdate));

        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Set line height
        $lineHeight = 10; // Set your desired line height

            // set JPEG quality
        $pdf->setJPEGQuality(75);
        // Example of Image from data stream ('PHP rules')
        $imgdata = base64_decode('');

        // $img_file = K_PATH_IMAGES.'template6.jpg';
        // $pdf->Image($img_file, 0, 0, 203, 109, '', '', '', false, 300, '', false, false, 0);

            // The '@' character is used to indicate that follows an image data stream and not an image file name
        $pdf->Image('@'.$imgdata);

        //rlwh//
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Image example with resizing
        // $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

       $header = <<<EOF
    <table style="width:100%;">

    <tr style="line-height: 43px;">
        <th style="width:350px; font-size:8px;"></th>
        <td style="width:260px; font-size:12px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$format_date_month&nbsp;&nbsp;&nbsp;&nbsp;$format_date_date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$format_date_year</td>  
    </tr>
    <tr style="line-height: 1px;">
        <th style="width:525px; "></th> 
        <th style="width:300px; font-size:8px;"></th> 
    </tr>
 
    <tr style="line-height: 12px;">
        <th style="width:590px; "></th> 
        <th style="width:70px; font-size:12px; text-align: right;">$amount</th> 
    </tr>
    <tr style="line-height: 11px;">
        <th style="width:270px; font-size:12px; ">$name</th>
        <td style="width:320px; "></td> 
        <th style="width:70px; font-size:12px;  text-align: right;">0.00</th> 
    </tr>
    <tr style="line-height: 15px;">
        <th style="width:270px; font-size:8px;"></th>
        <td style="width:320px; "></td> 
        <th style="width:70px; font-size:12px;  text-align: right;"></th> 
    </tr>
    <tr style="line-height: 14px;">
        <th style="width:270px; font-size:8px;"></th>
        <td style="width:280px; "></td> 
        <th style="width:60px; font-size:12px;   text-align: right;"></th> 
    </tr>
    <tr style="line-height: 9px;">
        <th style="width:270px; font-size:8px;"></th>
        <td style="width:320px; "></td> 
        <th style="width:70px; font-size:12px; text-align: right;">$amount</th> 
    </tr>
    <tr style="line-height: 12px;">
        <th style="width:260px; font-size:8px;"></th>
        <td style="width:310px; "></td> 
        <th style="width:300px; font-size:8px;"></th> 
    </tr>
    <tr style="line-height: 30px;">
        <th style="width:270px; font-size:8px;"></th>
        <td style="width:320px; "></td> 
        <th style="width:70px; font-size:12px; text-align: right;">$amount</th> 
    </tr>
    <tr style="line-height: -9px;">
        <th style="width:275px; font-size:12px; line-height: 16px;">$desc</th>
        <th style="width:20px; font-size:8px;"></th>
        <td style="width:155px; font-size:12px; line-height: 12px; text-align: right;">$amount</td> 
        <th style="width:300px; font-size:8px;"></th> 
    </tr>

    EOF;

    $charLen = strlen($desc);

    if ($charLen <= 40) {
       
        $header .= <<<EOF
        <tr style="line-height: 15px;">
            <th style="width:270px; font-size:8px;"></th>
            <td style="width:320px; "></td> 
            <th style="width:70px; font-size:12px;   text-align: right;  line-height: 30px;"></th> 
        </tr>
        <tr style="line-height: 10px;">
            <th style="width:270px; font-size:8px;"></th>
            <td style="width:320px; "></td> 
            <th style="width:70px; font-size:12px;  text-align: right;">$amount</th> 
        </tr>
        EOF;
    } else {

        $header .= <<<EOF
        <tr style="line-height: 15px;">
            <th style="width:270px; font-size:8px;"></th>
            <td style="width:320px; "></td> 
            <th style="width:70px; font-size:12px;   text-align: right;"></th> 
        </tr>
        <tr style="line-height: 10px;">
            <th style="width:270px; font-size:8px;"></th>
            <td style="width:320px; "></td> 
            <th style="width:70px; font-size:12px;  text-align: right;">$amount</th> 
        </tr>
        EOF;
       
    }

    
       
$header .= <<<EOF
        
    </table>
EOF;
    
    $pdf->writeHTML($header, false, false, false, false, '');

    }
    

// ------------------------------------------------------------


    $pdf->Output('Batch_OR.pdf', 'I');
    
    
   }
  }  

?>