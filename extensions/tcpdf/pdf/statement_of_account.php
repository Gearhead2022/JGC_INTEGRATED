<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/soa.controller.php";
require_once "../../../models/soa.model.php";

class PrintClientList {

    public function getClientsPrinting() {
       
        require_once('tcpdf_include.php');

        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false); // remove line on top of the page

        // set document information
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
          $pdf->setPrintFooter(false);  /*remove line on top of the page*/

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(10, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('Times');
        $pdf->AddPage();
        $id = $_REQUEST["id"];
        $date =  $_REQUEST["date"];
        $currentDate = date('l, F j, Y');
        $currentDate1 = date('m/d/Y');
        $con = new ControllerSOA();
        $SOA = $con->ctrShowAllSOA($id, $date);
        $soaInfo = $con->ctrShowSOAInfo();
        foreach($soaInfo as $info){
            $bAddress =$info["address"];
            $bTel =$info["tel"];
        }
        foreach($SOA as $row){
            $name = $row["name"];
            $address = $row["address"];
            $bank = $row["bank"];
            $principal = number_format($row["principal"], 2);
            $change = $row["change"];
            $interest =  number_format( $row["interest"], 2);
            $others =  number_format( $row["others"], 2);
            $baltot =  number_format(  abs($row["baltot"]), 2);
            $sl = number_format( abs($change), 2);
            $note = $row["note"];
            $fa = $row["fa"];
            $boh = $row["boh"];
            $from = $row["fmonth"]." ".$row["fyr"];
            $to = $row["tmonth"]." ".$row["tyr"];
            if($change >0){
                $cngColor = "color:red;";
                $sl1 = "($sl)";
            }else{
                $cngColor ="";
                $sl1 = $sl;
            }
            if($row["baltot"] < 0){
                $cngColor1 = "color:red;";
                $baltot1 = "($baltot)";
            }
            else{
                $cngColor1 ="";
                $baltot1 = $baltot;
            }

        }

 
        // $from = $_GET['incFrom'];
        // $to = $_GET['incTo'];
        $branch_name = $_SESSION["branch_name"];
        $brnh = strtok($branch_name, ' ');
        if($brnh == "EMB"){
            $branch_logo = 'images/emb.png';
        }elseif($brnh == "FCH"){
            $branch_logo = 'images/fch.jpg';
        }elseif($brnh == "RLC"){
            $branch_logo = 'images/rlc.png';
        }elseif($brnh == "ELC"){
            $branch_logo = 'images/elc.png';
        }else{
            $branch_logo = 'images/emb.png';
        }
        // HTML for table header
        if(!empty($SOA) && !empty($soaInfo)){
        $header = <<<EOF
    
            <table style="border:none;">
                <tbody>
                    <tr style="border:none; height:20px; text-align:center; ">
                        <td>
                            <img  src="$branch_logo" style="width: 110px; height:80px;">   
                        </td>
                    </tr>
                    <tr  style="text-align:center;">
                        <td>$bAddress</td>
                    </tr>
                    <tr style="text-align:center; font-size:12px;">
                         <td>TEL., NO. $bTel</td>
                    </tr>
                    <br>
                     <tr style="text-align:center; font-weight:bold; font-size:17px;">
                        <td>STATEMENT OF ACCOUNT</td>
                    </tr>
                    <tr>
                        <td style="border:none;  text-align:right;">$currentDate1</td>
                    </tr>
                    <tr style="border:none;  font-size:13px;">
                         <td style="width: 110px;height:23px;">Name: </td>
                         <td style="" >$name</td>
                     </tr>
                     <tr style="border:none;  font-size:13px;">
                        <td style="width: 110px;height:23px;">Address: </td>
                        <td style="">$address</td>
                     </tr>
                     <tr style="border:none;  font-size:13px;">
                        <td style="width: 110px;height:30px;">Bank: </td>
                        <td style="">$bank</td>
                     </tr>
                </tbody>
            </table>
            <hr>
            <table style="border:none;  font-size:11px;">
            <tr style="font-weight:bold;">
            <td></td>
            </tr>
                <tr style="font-weight:bold;">
                    <td>LOAN RECEIVABLE</td>
                </tr>
                <tr style="font-weight:bold;">
                   <td>PRINCIPAL:</td>
                </tr>
                <tr style="font-weight:bold; font-size:14px;">
                    <td style="width: 560px;"></td>
                    <td style=" text-align:right; width: 90px;">$principal</td>
                </tr>
                <br>
                <br>
                <tr style="font-weight:bold;">
                    <td style="width: 560px;">TOTAL LOANS RECEIVABLE</td>
                    <td style="font-size:14px; border-bottom: 0px thin black; text-align:right; width: 90px;">$principal</td>
                </tr>
                <br>
                <tr style="font-weight:bold;">
                    <td style="width: 560px;">ADD: SUPPLEMENTARY LOANS(SL)</td>
                    <td style=" text-align:right; width: 90px; font-size:14px; $cngColor">$sl1</td>
                </tr>
                <br>
                <tr style="font-weight:bold;">
                    <td style="width:560px; height:20px;">INTEREST ON SL ($from TO $to)</td>
                    <td style=" text-align:right; width: 90px; font-size:14px;">$interest</td>
                </tr>
              
                <tr style="font-weight:bold;">
                    <td style="width: 560px;">OTHERS</td>
                    <td style=" text-align:right; width: 90px; font-size:14px;">$others</td>
                </tr>
                <tr style="font-weight:bold;">
                    <td style="width: 560px;"></td>
                    <td style="font-size:14px; border-bottom: 0px thin black; text-align:right; width: 90px;"></td>
                </tr>
                <br>
                <tr style="font-weight:bold;">
                    <td style="width: 560px; color:red;">ACCOUNT BALANCE AS OF  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  $currentDate</td>
                    <td style="font-size:14px; border-bottom: 0px thin black; text-align:right; width: 90px; $cngColor1"> $baltot1</td>
                </tr>
                <tr style="font-weight:bold;">
                <td style="width: 560px;"></td>
                <td style="font-size:14px;  text-align:right; width: 90px;"></td>
            </tr>
            </table>
            <hr>
              <br>  
EOF;

        // Close the table
         $header .= <<<EOF
            <table>
            <tr style="font-size:11px;  text-weight:bold; color:red;">
                 <th style="border:none; text-align:right; width: 190px; ">NOTE:</th>
                 <th style="border:none; text-align:center; width: 400px; ">$note</th>
            </tr>
            <br>
            <tr style="font-size:11px;  text-weight:bold;">
                <th style="border:none; text-align:left; width: 80px; ">Prepared By: </th>
                <th style="border:none; text-align:left; width: 200px; border-bottom: 0px solid black; height:18px;">$fa</th>
            </tr>
            <tr style="font-size:11px;  text-weight:bold;">
                <th style="border:none; text-align:left; width: 80px; "></th>
                <th style="border:none; text-align:left; width: 200px; height:35px;">Branch Finance and Admin Head</th>
            </tr>
               
            <tr style="font-size:11px;  text-weight:bold;">
                <th style="border:none; text-align:left; width: 80px; ">Approved By: </th>
                <th style="border:none; text-align:left; width: 200px; border-bottom: 0px solid black; height:18px;">$boh</th>
            </tr>
            <tr style="font-size:11px;  text-weight:bold;">
                <th style="border:none; text-align:left; width: 80px; "></th>
                <th style="border:none; text-align:left; width: 200px; height:50px;">Branch Operations Head</th>
            </tr>
           
            <tr style="font-size:11px;  text-weight:bold; ">
                <th style="border:none; text-align:left; width: 80px; height:15px; ">Received By: </th>
                <th style="border:none; text-align:left; width: 200px; border-bottom: 0px solid black;"></th>
            </tr>
            <tr style="font-size:11px;  text-weight:bold;">
                <th style="border:none; text-align:left; width: 80px; ">Date: </th>
                <th style="border:none; text-align:left; width: 200px; border-bottom: 0px solid black; height:18px;"></th>
            </tr>
             
        </table>
        
            
EOF;
        }
        else{

            $header = <<<EOF

            <h1 style="text-align:center;">There is currently no data available for display.</h1>
EOF;
        }
        // Write HTML content to PDF
        $pdf->writeHTML($header, true, false, true, false, '');

        // Output PDF
        $pdf->Output('PDR Performance Summary.pdf', 'I');
    }
}

$clientsFormRequest = new PrintClientList();
$clientsFormRequest->getClientsPrinting();

?>
