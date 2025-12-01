<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/dtr.controller.php";
require_once "../../../models/dtr.model.php";


require_once "../../../controllers/operation.controller.php";
require_once "../../../models/operation.model.php";

$clientsForm = new printClientList_2();
$clientsForm -> getClientsPrinting_2();

class printClientList_2{

public function getClientsPrinting_2(){

    $connection = new connection;
    $connection->connect();

    $check_entry_date = $_GET['check_entry_date'];

    $time = time();
    $date=date("M-d-y", $time);

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
    $pdf->SetMargins(2, 17, PDF_MARGIN_RIGHT);
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

    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Set line height
    $lineHeight = 10; // Set your desired line height

        // set JPEG quality
    $pdf->setJPEGQuality(75);
    // Example of Image from data stream ('PHP rules')
    $imgdata = base64_decode('');

    // $img_file = K_PATH_IMAGES.'template9.jpg';
    // $pdf->Image($img_file, 0, 0, 204, 110, '', '', '', false, 300, '', false, false, 0);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
    $pdf->Image('@'.$imgdata);

    //rlwh//
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // Image example with resizing
    // $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $has_data = (new ModelDTR)->mdlGetBranchDailyTimeInDTRUploadList($check_entry_date);

    $header = <<<EOF

    <table style="width: 100%;">
        <tr>
            <td style="width:1200px;text-align:center;font-size:10px;float: right;">$date</td>
        </tr>  
        <tr>
            <td style="width: 20%;"></td> <!-- Empty cell for spacing -->
            <td style="width: 60%; text-align: center;"><h1>DTR TIME-IN SUBMISSION REPORT</h1></td> <!-- Centered cell -->
            <td style="width: 22%;"></td> <!-- Empty cell for spacing -->
        </tr>
    
        <tr>

            <td style="width: 20%;"></td> <!-- Empty cell for spacing -->
            <td style="width: 70%; text-align: center;"><p>Branch Breakdown</p></td> <!-- Centered cell -->
            <td style="width: 20%;"></td> <!-- Empty cell for spacing -->

        </tr>
        <tr>
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
            <td style="width: 45%; text-align: center;"><p></p></td> <!-- Centered cell -->
            <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        </tr>
    </table>

    <table style="margin-top: 5px;"> 

        <tr style="border-style: solid;">

            <td style="width: 140px;"></td>

            <td style="width:29px;text-align:center;font-size:11px;color:white;background-color:black;"><strong>No.</strong></td>

            <td style="width:115px;text-align:center;font-size:11px;color:white;background-color:black;"><strong>Branch Name</strong></td>
                                                                
            <td style="width:85px;text-align:center;font-size:11px;color:white;background-color:black;"><strong>Remarks</strong></td>
    
            <td style="width:75px;text-align:center;font-size:11px;color:white;background-color:black;"><strong>Entry Date</strong></td>
        
            <td style="width:115px;text-align:center;font-size:11px;color:white;background-color:black;"><strong>Date Uploaded</strong></td>
                                                                
        </tr>                 
    </table>
EOF; 

$header .= <<<EOF

    <table>  

        <tr style="border: 1px solid #black;">

            <td></td>
            <td></td>
            <td></td>                                                          
            <td></td>
            <td></td>
            <td></td>
                                                                
        </tr>
    </table>

    EOF; 

    if ($has_data === 'yes') {

        $i = 1;

        $data = (new ControllerOperation)->ctrShowBranches();

        foreach ($data as &$item) {

            $branch_name = $item['branch_name'];

            //Function to check if branch had been submitted a file or not
            $if_has_upload = (new ControllerDTR)->ctrGetBranchDailyTimeInDTRUploadList($branch_name, $check_entry_date);
            
              // Condition if the branch has submitted a file or not
            $answer = ($if_has_upload === 'yes') ? 'DONE' : 'UNDONE';

            $file_info = (new ModelDTR)->mdlGetDailyTimeInDTRExist($branch_name, $check_entry_date);
            if (!empty($file_info)) {
                $entry_date = $file_info[0]['entry_date'];
                $date_uploaded = $file_info[0]['date_uploaded'];

                $format_entry_date = date('M d, Y', strtotime($entry_date));
            } else {
                // Handle the case when $file_info is empty (e.g., set default values or show an error message)
                $entry_date = '---';
                $date_uploaded = '---';
                $format_entry_date = '---';
            }

        
            $header .= <<<EOF

            <table style="border: none;">  

                <tr style="border: 1px solid black;">

                    <td style="width: 141px;"></td>

                    <td style="width:30px;text-align:left;font-size:8px; border: 1px solid black;">$i.</td>

                    <td style="width:125px;text-align:left;font-size:8px; border: 1px solid black;">$branch_name</td>
                                                                        
                    <td style="width:80px;text-align:left;font-size:7px; border: 1px solid black;"><i>$answer</i></td>

                    <td style="width:80px;text-align:left;font-size:8px; border: 1px solid black;">$format_entry_date</td>

                    <td style="width:100px;text-align:left;font-size:8px; border: 1px solid black;">$date_uploaded</td>
                                                                        
                </tr>
                
            </table>
            EOF;

            $i++;
        }
    }


    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Daily Branch DTR Reports', 'I');
    
   }
  } 

?>