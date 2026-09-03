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

        if (!isset($_GET['data']) || empty($_GET['data'])) {
            die("ID is not set or invalid.");
        }
        $data = $_GET['data'];
        $arrayData = json_decode($data, true);
        

   

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
        $pdf->SetMargins(3, 5, PDF_MARGIN_RIGHT);
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
        function splitString($input) {
            // Check if the string is longer than 20 characters
            if (strlen($input) > 13) {
                // If the 21st character is a letter
                if (ctype_alpha($input[13])) {
                    // Find the last space within the first 20 characters
                    $lastSpace = strrpos(substr($input, 0, 13), ' ');
        
                    // If a space is found, split the string there
                    if ($lastSpace !== false) {
                        $firstPart = substr($input, 0, $lastSpace);
                        $secondPart = substr($input, $lastSpace + 1);
                    } else {
                        // If no space is found, split after 20 characters
                        $firstPart = substr($input, 0, 13);
                        $secondPart = substr($input, 13);
                    }
                } else {
                    // If the 21st character is not a letter, split normally after 20 characters
                    $firstPart = substr($input, 0, 13);
                    $secondPart = substr($input, 13);
                }
            } else {
                // If the string is 20 characters or less, the first part is the whole string, and the second part is empty
                $firstPart = $input;
                $secondPart = '';
            }
        
            return [$firstPart, $secondPart];
        }
        
       
      
    
        
        $header = '
        <style>
            .table-bordered {
                border: 1px solid black;
                width: 235px;
                background-color: #EDFAF8;
            }
            table tr td{
                 font-size: 0.7em;
            }
            .border {
                border: 1px solid black;
            }
            .text-bottom {
                vertical-align: bottom;
            }
            .text-center {
                text-align: center;
            }
            .bold {
                font-weight: bold;
            }
            .loc{
                width: 37px;
               font-size: 0.7em;
             }.loc1{
                width: 150px;
                border-bottom: 1px solid black;
                font-weight: bold;
                 font-size: 0.7em;
             }
            .des{
                width: 50px;
                font-size: 0.7em;
             }.des1{
                width: 83px;
                border-bottom: 1px solid black;
                font-weight: bold;
                 font-size: 0.8em;
             }
            .date{
                width: 70px;
                font-size: 0.7em;
             }.date1{
               font-size: 0.7em;
                width: 63px;
                border-bottom: 1px solid black;
                font-weight: bold;
             }
            .img{
                width:120px;
                height:120px;
            }
            .logo{
                font-size: 13px;
                }
                .none{
                    color:#EDFAF8;
                }
            .spacer{
                  border-bottom: 1px solid black;
                   width: 150rem;
            }
            .spacer1{
                width: 5px;
               
                
            }
            .series{
                 font-size: 0.8em;
                width: 100px;
                border-bottom: 1px solid black;
                font-weight: bold;
            }
            .series1{
                font-size: 1.8em;
                border-bottom: 1px solid black;
                width: 90px;
                font-weight: bold;
                color:red;
            }
        .spacing{
    
            width:15px;
        }
            .alert{
                 font-size: 0.6em;
                color: #26704C;
          
            }
        .logoImg{
            width: 40rem;
            height: 28rem;
            margin-top:
        }
        </style>
            <table class="" style="">
            <tr>';
            // Sample data for demonstration

            // Loop through the data and create tables
foreach ($arrayData as $index => $item) {
    // Start a new row every 2 tables
    if ($index % 3 == 0 && $index != 0) {
        $header .= '</tr><br><tr>';
    }
    $con = (new ControllerQRCode)->ctrGetItmebyID($item);
    $item_name = '';
    foreach ($con as $items) {
        $item_location = $items['item_location'];
        $item_description = $items['item_description'];
        $date_purchased = $items['date_purchased'];
        $serial_no = $items['serial_no'];
        $sticker_no = $items['sticker_no'];
        $item_code = $items['item_code'];
        $company = $items['company'];
    }
    $company1 = strtolower($company);
    list($firstPart, $secondPart) = splitString($item_description);
                  
        $header .= '  
                <td style="width:225rem;">
                <table class="table-bordered" style="width:225rem;">
                    <tr>
                        <td style="height: 1px; font-size:0.2em; color:#EDFAF8;">daw
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="bold logo" style="width:135rem;">
                            <img class="logoImg" src="images/'.$company1.'.png">
                        </td>
                         <td rowspan="5" class="text-center" style=" width:90px; ">  <img class="border img" style="width:280px; height:300px;" src="../../../views/files/qrcodes/'.$item_code.'.png"></td>
                    </tr>
                    
                    <tr>
                        <td class="text-bottom loc "><span class="none"> </span>&nbsp; Location:</td>
                        <td class="text-bottom loc1  "><span class="none"><br> </span>'.$item_location.'</td>
                    </tr>
                    <tr>
                        <td class="text-bottom des"><span class="none"> <br></span>Description:</td>
                        <td class="text-bottom des1"><span class="none"> <br></span>'.$firstPart.'</td>
                    </tr>
                    <tr>  
                        <td class="text-bottom spacer1" ></td>
                        <td class="text-bottom spacer" style="font-weight: bold; font-size: 0.8em;" colspan="2"> '.$secondPart.'</td>
                    </tr>
                    <tr>
                        <td class="text-bottom date"><span class="none"> <br></span>Date Purchased:</td>
                        <td class="text-bottom date1"><span class="none"> <br></span>'.$date_purchased.'</td>
                    </tr>
                    <tr>
                    <td class="text-center text-bottom spacing "></td>
                        <td  class="text-center text-bottom  series  "><span class="none">dwad<br></span>'.$serial_no.'</td>
                        <td class="text-center text-bottom spacing "></td>
                        <td class="text-center text-bottom  series1 "><span class="none"></span>'.$sticker_no.'</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center text-bottom">Serial No.</td>
                        <td class="text-center text-bottom  ">Sticker No.</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center text-bottom alert">Please do not remove the sticker</td>
                    </tr>
                </table>

              </td>
                 <td style ="background-color: white; border:none; width:15rem;">
              </td>
        '
        ;
        
    }
        $header.='</tr>
         </table>
      ';


        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }
}
?>
