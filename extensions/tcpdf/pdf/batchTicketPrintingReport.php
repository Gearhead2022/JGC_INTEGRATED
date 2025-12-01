<?php
    require_once('tcpdf_include.php');
    require_once "../../../models/connection.php";
    require_once "../../../views/modules/session.php";
    require_once "../../../controllers/ticket.controller.php";
    require_once "../../../models/ticket.model.php";
    
    $printTicket = new printTicket();
    $printTicket->getTicketPrint();
    
class printTicket{
 
public function getTicketPrint(){

        $connection = new connection;
        $connection->connect();

        $area_code = $_GET['area_code'];
        $branch_name_selected = $_GET['branch_name'];


        $data_from_ticket_last = new ControllerTicket();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->setPrintHeader(false);  /*remove line on top of the page*/

        // set document information


        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(2,2);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 2);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('Times');
        $pdf->AddPage();

            // set JPEG quality
        $pdf->setJPEGQuality(75);
        // Example of Image from data stream ('PHP rules')
        $imgdata = base64_decode('');

        // Set the top position to -20 to adjust the content up by 20 units

            // The '@' character is used to indicate that follows an image data stream and not an image file name
        $pdf->Image('@'.$imgdata);
        // Set some content to print
       
        $html = '';
        $results = $data_from_ticket_last->ctrBatchTicketGet($area_code, $branch_name_selected);
        if(!empty($results)){
        $table = <<<EOF
        <table style="box-sizing:content-box;">
        <tr>
        EOF;
        $html .= $table ;

        $totalRows = count($results);

        for ($i = 0; $i < $totalRows; $i++) {
            if($i % 16 === 0 && $i !== 0){
                $line ="";
            }else{
                $line="------------------------------------------------------------------------------------------------------------------------------------------------";
            }

            if($area_code == "NORTH_NEG"){
                $area_codeName= "NORTH NEGROS";
              }elseif($area_code == "SOUTH_NEG"){
                $area_codeName= "SOUTH NEGROS";
              }elseif($area_code == "PANAY"){
                $area_codeName= "PANAY";
              }elseif($area_code == "CENT_VIS"){
                $area_codeName= "CENTRAL VISAYAS";
              }elseif($area_code == "NCR"){
                $area_codeName= "NCR";
              }elseif($area_code == "MAIN"){
                $area_codeName= "MAIN";
              }

            if ($i % 4 === 0 && $i !== 0) {
                $html .= '</tr><tr><th style="width:2000px;">
                '.$line.'
        </th></tr><tr>';
            
            }

            $id = $results[$i]['id'];
            $pensioner_name = $results[$i]['name'];
            $branch_name = $results[$i]['branch_name'];
            $ticket_no = $results[$i]['ticket_no'];
            $area_code = $results[$i]['area_code'];
            $tdate = $results[$i]['tdate'];
            
            $charCount = strlen($pensioner_name);
            if($charCount >=28){
              $fntSize = "line-height:11.1em;";
            }else{
              $fntSize="line-height:12em;";
            }


            $branchAbrv = substr($branch_name , 0, 3);

            if ($branchAbrv == 'EMB') {
                $branch_logo = 'images/emb3.jpg';
            }else if ($branchAbrv == 'FCH') {
                $branch_logo = 'images/fch.jpg';
            }else if ($branchAbrv == 'ELC') {
              $branch_logo = 'images/elc.jpg';
          }else if ($branchAbrv == 'RLC') {
            $branch_logo = 'images/rlc.jpg';
        }
            

            $html1 = <<<EOF
        
            <th style="border: 1px solid black;width:175px;">
            
            <div style="text-align: center;$fntSize">
            <br>
            <img  src="$branch_logo" style="width: 110px; height:80px;">   
            <div  style="height: 60px; line-height: 10em;">

            <h6>&nbsp;$pensioner_name</h6>
            <h6>&nbsp;$branch_name</h6>
            <h6>&nbsp;$area_codeName</h6>
            </div>
            
            <h5 style="font-size:12.6rem;background-color: lightgray; height: 1px;"><span style="color:lightgray;">s</span><br>$ticket_no<br><span style="color:lightgray;">sss</span></h5>
          
            
            </div>
        
            </th>
            
            <th style="width:10px;">
            </th>


            EOF;
            $html .= $html1 ;
        }
        $table2 = <<<EOF
        </tr>

        </table>
        EOF;
        $html .= $table2 ;
    }


        $pdf->writeHTML($html, false, false, false, false, '');

        // ---------------------------------------------------------
        $pdf->Output('ticket.pdf', 'I');
    }
}
// Close and output PDF document
// This method has several options, check the source code documentation for more information.



//============================================================+
// END OF FILE
//============================================================+
  ?>
 