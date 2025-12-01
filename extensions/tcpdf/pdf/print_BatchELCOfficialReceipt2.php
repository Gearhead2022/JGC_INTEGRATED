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
    $pdf->SetMargins(-2, 18, PDF_MARGIN_RIGHT);
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
        $format_date_month = date("M", strtotime($tdate));
        $format_date_date = date("d", strtotime($tdate));
        $format_date_year = date("Y", strtotime($tdate));

        $amtwrd = $item['amtwrd'];

        $pdf->AddPage();

        // Set font
        $pdf->SetFont('larabieb', '', 12);

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
    
    <tr style="line-height: 40px;">
        <th style="width:350px; font-size:8px;"></th>
        <td style="width:35px; font-size:8px;"></td>
        <td style="width:260px; font-size:12px; "></td>  
    </tr>

    <tr style="line-height: 7px;">
        <th style="width:130px; "></th> 
        <td style="width:248px; line-height: 15px;"></td> 
        <td style="width:350px; font-size:12px; text-align: right;">&nbsp;$format_date_month&nbsp;&nbsp;$format_date_date,&nbsp;$format_date_year</td> 
    </tr>
    <tr style="line-height: 5px;">
        <th style="width:130px; "></th> 
        <td style="width:10px;  line-height: -14px;"></td>
        <td style="width:400px; ">$name</td> 
        <td style="width:60px; font-size:12px;  text-align: right;"></td> 
    </tr>
    <tr style="line-height: 60px;">
        <th style="width:130px; font-size:8px;"></th>
        <td style="width:460px; "></td> 
        <td style="width:20px; "></td> 
        <td style="width:60px; font-size:12px;  text-align: right;"></td> 
    </tr>

    <tr style="line-height: 9px;">
        <th style="width:40px; "></th> 
        <td style="width:265px; font-size:12px; line-height: 12px; text-align: right;">$desc</td> 
        <th style="width:321px; font-size:8px;"></th>
        <td style="width:295px; font-size:12px; line-height: 22px;">$amount</td>        
    </tr>
    <tr style="line-height: 20px;">
        <th style="width:270px; font-size:8px;"></th>
        <td style="width:295px; "></td> 
        <th style="width:65px; font-size:12px;  text-align: right; line-height: 16px;"></th> 
    </tr>

    EOF;
    $charLen = strlen($desc);

    if ($charLen <= 40) {

        $header .= <<<EOF
            <tr style="line-height: 73px;">
                <th style="width:10px; font-size:8px;"></th>
                <td style="width:460px; "></td> 
                <td style="width:20px; "></td> 
                <td style="width:60px; font-size:12px; line-height: 50px; text-align: right;"></td> 
            </tr>
            <tr style="line-height: 11px;">
                <th style="width:50px; "></th> 
                <td style="width:190px; font-size:12px; line-height: 15px; text-align: right;">$amtwrd</td>
                <th style="width:385px; font-size:8px;"></th> 
                <td style="width:295px; font-size:12px; line-height: 48px;">$amount</td>  
            </tr>
        EOF;
        
    } else {

        $header .= <<<EOF
            <tr style="line-height: 70px;">
                <th style="width:10px; font-size:8px;"></th>
                <td style="width:460px; "></td> 
                <td style="width:20px; "></td> 
                <td style="width:60px; font-size:12px; line-height: 50px;  text-align: right;"></td> 
            </tr>
            <tr style="line-height: 11px;">
                <th style="width:50px; "></th> 
                <td style="width:190px; font-size:12px; line-height: 15px; text-align: right;">$amtwrd</td>
                <th style="width:385px; font-size:8px;"></th> 
                <td style="width:295px; font-size:12px; line-height: 37px;">$amount</td>
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