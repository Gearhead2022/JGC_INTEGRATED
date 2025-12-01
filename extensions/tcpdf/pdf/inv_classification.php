<?php
require_once "../../../controllers/qrcode.controller.php";
require_once "../../../models/qrcode.model.php";
require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

$clientsForm = new Inventory();

$slctClass = $_GET['slctClass'];
$branch = $_GET['branch'];
if($slctClass == "FURNITURE" && $branch == "ALL"){
    $clientsForm->reportFurniture();
}else if($slctClass == "FIXTURES" && $branch == "ALL" ){
    $clientsForm->reportFixture();
}else if($slctClass == "EQUIPMENT" && $branch == "ALL"){
    $clientsForm->reportEquipment();
}else if($slctClass == "FIXTURES" || $slctClass == "EQUIPMENT" || $slctClass == "FURNITURE"  && $branch != "ALL" ){
    $clientsForm->reportFixtureByBranch();
}
class Inventory {

    public function reportFurniture() {
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
        $pdf->SetFont('helvetica', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
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
        
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
        <table>
            <tr>
                <td  style="text-align: center; font-size: 1.4em;   font-weight: bold; ">ITEM CLASSIFICATION SUMMARY</td>
            </tr>
            <tr>
                <td  style="text-align: center; font-size: 1em; height:25px;">FURNITURE - FR</td>
            </tr>
        </table>
        
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FURNITURE</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:150px;">EMB BRANCHES</th>
                    <th class="border bold-text" style="width:128px;">TABLE</th>
                    <th class="border bold-text" style="width:128px;">CHAIRS</th>
                    <th class="border bold-text" style="width:128px;">CABINETS</th>
                    <th class="border bold-text" style="width:128px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_table = 0;
            $sub_chair = 0;
            $sub_cabinets = 0;
            $sub_total = 0;
            $grand_table = 0;
            $grand_chair = 0;
            $grand_cabinets = 0;
            $grand_total = 0;
            $getEMB = (new ControllerQRCode)->ctrGetFurnitureByBranch("EMB");
            foreach($getEMB as $emb){

          
            $header .='
                <tr>
                    <td class="border1" style="width:150px; text-align: left;"> '.$emb['item_location'].'</td>
                    <td class="border1" style="width:128px;">'.$emb['total_tables'].'</td>
                    <td class="border1" style="width:128px;">'.$emb['total_chairs'].'</td>
                    <td class="border1" style="width:128px;">'.$emb['total_cabinets'].'</td>
                    <td class="border1 bold-text" style="width:128px;">'.$emb['total_items'].'</td>
                </tr>';

                $sub_table += $emb['total_tables'];
                $sub_chair += $emb['total_chairs'];
                $sub_cabinets += $emb['total_cabinets'];
                $sub_total += $emb['total_items'];
            }
            $grand_table += $sub_table;
            $grand_chair += $sub_chair;
            $grand_cabinets += $sub_cabinets;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:150px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_table.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_chair.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_cabinets.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
        
          <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FURNITURE</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:150px;">FCH BRANCHES</th>
                    <th class="border bold-text" style="width:128px;">TABLE</th>
                    <th class="border bold-text" style="width:128px;">CHAIRS</th>
                    <th class="border bold-text" style="width:128px;">CABINETS</th>
                    <th class="border bold-text" style="width:128px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_table = 0;
          $sub_chair = 0;
          $sub_cabinets = 0;
          $sub_total = 0;
            $getFCH = (new ControllerQRCode)->ctrGetFurnitureByBranch("FCH");
            foreach($getFCH as $fch){

          
            $header .='
                <tr>
                    <td class="border1" style="width:150px; text-align: left;"> '.$fch['item_location'].'</td>
                    <td class="border1" style="width:128px;">'.$fch['total_tables'].'</td>
                    <td class="border1" style="width:128px;">'.$fch['total_chairs'].'</td>
                    <td class="border1" style="width:128px;">'.$fch['total_cabinets'].'</td>
                    <td class="border1 bold-text" style="width:128px;">'.$fch['total_items'].'</td>
                </tr>';
                $sub_table += $fch['total_tables'];
                $sub_chair += $fch['total_chairs'];
                $sub_cabinets += $fch['total_cabinets'];
                $sub_total += $fch['total_items'];
            }
            $grand_table += $sub_table;
            $grand_chair += $sub_chair;
            $grand_cabinets += $sub_cabinets;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:150px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_table.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_chair.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_cabinets.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>    
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
          
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FURNITURE</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:150px;">RFC BRANCHES</th>
                    <th class="border bold-text" style="width:128px;">TABLE</th>
                    <th class="border bold-text" style="width:128px;">CHAIRS</th>
                    <th class="border bold-text" style="width:128px;">CABINETS</th>
                    <th class="border bold-text" style="width:128px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_table = 0;
          $sub_chair = 0;
          $sub_cabinets = 0;
          $sub_total = 0;
            $getRFC = (new ControllerQRCode)->ctrGetFurnitureByBranch("RLC");
            foreach($getRFC as $rfc){
                $branch_name = str_replace('RLC', 'RFC', $rfc['item_location']);
                $header .='
                <tr>
                    <td class="border1" style="width:150px; text-align: left;"> '.$branch_name.'</td>
                    <td class="border1" style="width:128px;">'.$rfc['total_tables'].'</td>
                    <td class="border1" style="width:128px;">'.$rfc['total_chairs'].'</td>
                    <td class="border1" style="width:128px;">'.$rfc['total_cabinets'].'</td>
                    <td class="border1 bold-text" style="width:128px;">'.$rfc['total_items'].'</td>
                </tr>';
                $sub_table += $rfc['total_tables'];
                $sub_chair += $rfc['total_chairs'];
                $sub_cabinets += $rfc['total_cabinets'];
                $sub_total += $rfc['total_items'];
            }
            $grand_table += $sub_table;
            $grand_chair += $sub_chair;
            $grand_cabinets += $sub_cabinets;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:150px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_table.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_chair.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_cabinets.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>  
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>

         <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FURNITURE</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:150px;">ELC BRANCHES</th>
                    <th class="border bold-text" style="width:128px;">TABLE</th>
                    <th class="border bold-text" style="width:128px;">CHAIRS</th>
                    <th class="border bold-text" style="width:128px;">CABINETS</th>
                    <th class="border bold-text" style="width:128px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_table = 0;
          $sub_chair = 0;
          $sub_cabinets = 0;
          $sub_total = 0;
            $getELC = (new ControllerQRCode)->ctrGetFurnitureByBranch("ELC");
            foreach($getELC as $elc){
                
                $header .='
                <tr>
                    <td class="border1" style="width:150px; text-align: left;"> '.$elc['item_location'].'</td>
                    <td class="border1" style="width:128px;">'.$elc['total_tables'].'</td>
                    <td class="border1" style="width:128px;">'.$elc['total_chairs'].'</td>
                    <td class="border1" style="width:128px;">'.$elc['total_cabinets'].'</td>
                    <td class="border1 bold-text" style="width:128px;">'.$elc['total_items'].'</td>
                </tr>';
                $sub_table += $elc['total_tables'];
                $sub_chair += $elc['total_chairs'];
                $sub_cabinets += $elc['total_cabinets'];
                $sub_total += $elc['total_items'];
            }
            $grand_table += $sub_table;
            $grand_chair += $sub_chair;
            $grand_cabinets += $sub_cabinets;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:150px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_table.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_chair.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_cabinets.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>    
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
                   <tr>
                    <td class="border1" style="width:150px; color:red; font-weight:bold; text-align: left;"> GRAND TOTAL</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$grand_table.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$grand_chair.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$grand_cabinets.'</td>
                    <td class="border1" style="width:128px; color:red; font-weight:bold;">'.$grand_total.'</td>
                </tr>  
            </tbody>
        </table>
        ';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }


    public function reportFixture() {
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
        $pdf->SetFont('helvetica', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
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
                font-size: 0.7em;
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
        
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
          <table>
            <tr>
                <td  style="text-align: center; font-size: 1.4em;   font-weight: bold; ">ITEM CLASSIFICATION SUMMARY</td>
            </tr>
            <tr>
                <td  style="text-align: center; font-size: 1em; height:25px;">FIXTURES - FX</td>
            </tr>
        </table>
        
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FIXTURES</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:140px;">EMB BRANCHES</th>
                    <th class="border bold-text" style="width:87px;">IMAGES / STATUES</th>
                    <th class="border bold-text" style="width:87px;">DECORATIONS</th>
                    <th class="border bold-text" style="width:87px;">PAINTINGS</th>
                    <th class="border bold-text" style="width:87px;">HOUSEHOLD EFFECTS</th>
                    <th class="border bold-text" style="width:87px;">APPLIANCES</th>
                    <th class="border bold-text" style="width:87px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_images = 0;
            $sub_decoration = 0;
            $sub_paintings = 0;
            $sub_household = 0;
            $sub_appliances = 0;
            $sub_total = 0;

            $grand_images = 0;
            $grand_decoration = 0;
            $grand_paintings = 0;
            $grand_household = 0;
            $grand_appliances = 0;
            $grand_total = 0;

            $getEMB = (new ControllerQRCode)->ctrGetFixtureByBranch("EMB");
            foreach($getEMB as $emb){

          
            $header .='
                <tr>
                    <td class="border1" style="width:140px; text-align: left;"> '.$emb['item_location'].'</td>
                    <td class="border1" style="width:87px;">'.$emb['total_images'].'</td>
                    <td class="border1" style="width:87px;">'.$emb['total_decoration'].'</td>
                    <td class="border1" style="width:87px;">'.$emb['total_paintings'].'</td>
                    <td class="border1" style="width:87px;">'.$emb['total_household'].'</td>
                    <td class="border1" style="width:87px;">'.$emb['total_appliances'].'</td>
                    <td class="border1 bold-text" style="width:87px;">'.$emb['total_items'].'</td>
                </tr>';

                $sub_images += $emb['total_images'];
                $sub_decoration += $emb['total_decoration'];
                $sub_paintings += $emb['total_paintings'];
                $sub_household += $emb['total_household'];
                $sub_appliances += $emb['total_appliances'];
                $sub_total += $emb['total_items'];
            }
            $grand_images += $sub_images;
            $grand_decoration += $sub_decoration;
            $grand_paintings += $sub_paintings;
            $grand_household += $sub_household;
            $grand_appliances += $sub_appliances;
            $grand_total += $sub_total;

            $header .='    
              <tr>
                    <td class="border1" style="width:140px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_images.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_decoration.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_paintings.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_household.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_appliances.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
        
          <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FIXTURES</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:140px;">FCH BRANCHES</th>
                    <th class="border bold-text" style="width:87px;">IMAGES / STATUES</th>
                    <th class="border bold-text" style="width:87px;">DECORATIONS</th>
                    <th class="border bold-text" style="width:87px;">PAINTINGS</th>
                    <th class="border bold-text" style="width:87px;">HOUSEHOLD EFFECTS</th>
                    <th class="border bold-text" style="width:87px;">APPLIANCES</th>
                    <th class="border bold-text" style="width:87px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_images = 0;
          $sub_decoration = 0;
          $sub_paintings = 0;
          $sub_household = 0;
          $sub_appliances = 0;
          $sub_total = 0;

     
            $getFCH = (new ControllerQRCode)->ctrGetFixtureByBranch("FCH");
            foreach($getFCH as $fch){
                $header .='
                <tr>
                    <td class="border1" style="width:140px; text-align: left;"> '.$fch['item_location'].'</td>
                    <td class="border1" style="width:87px;">'.$fch['total_images'].'</td>
                    <td class="border1" style="width:87px;">'.$fch['total_decoration'].'</td>
                    <td class="border1" style="width:87px;">'.$fch['total_paintings'].'</td>
                    <td class="border1" style="width:87px;">'.$fch['total_household'].'</td>
                    <td class="border1" style="width:87px;">'.$fch['total_appliances'].'</td>
                    <td class="border1 bold-text" style="width:87px;">'.$fch['total_items'].'</td>
                </tr>';

                $sub_images += $fch['total_images'];
                $sub_decoration += $fch['total_decoration'];
                $sub_paintings += $fch['total_paintings'];
                $sub_household += $fch['total_household'];
                $sub_appliances += $fch['total_appliances'];
                $sub_total += $fch['total_items'];
            }
            $grand_images += $sub_images;
            $grand_decoration += $sub_decoration;
            $grand_paintings += $sub_paintings;
            $grand_household += $sub_household;
            $grand_appliances += $sub_appliances;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:140px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_images.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_decoration.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_paintings.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_household.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_appliances.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
          
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FIXTURES</th>
                </tr>
                  <tr>
                    <th class="border bold-text" style="width:140px;">RFC BRANCHES</th>
                    <th class="border bold-text" style="width:87px;">IMAGES / STATUES</th>
                    <th class="border bold-text" style="width:87px;">DECORATIONS</th>
                    <th class="border bold-text" style="width:87px;">PAINTINGS</th>
                    <th class="border bold-text" style="width:87px;">HOUSEHOLD EFFECTS</th>
                    <th class="border bold-text" style="width:87px;">APPLIANCES</th>
                    <th class="border bold-text" style="width:87px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_images = 0;
          $sub_decoration = 0;
          $sub_paintings = 0;
          $sub_household = 0;
          $sub_appliances = 0;
          $sub_total = 0;

       
            $getRFC = (new ControllerQRCode)->ctrGetFixtureByBranch("RLC");
            foreach($getRFC as $rfc){
                $header .='
                <tr>
                    <td class="border1" style="width:140px; text-align: left;"> '.$rfc['item_location'].'</td>
                    <td class="border1" style="width:87px;">'.$rfc['total_images'].'</td>
                    <td class="border1" style="width:87px;">'.$rfc['total_decoration'].'</td>
                    <td class="border1" style="width:87px;">'.$rfc['total_paintings'].'</td>
                    <td class="border1" style="width:87px;">'.$rfc['total_household'].'</td>
                    <td class="border1" style="width:87px;">'.$rfc['total_appliances'].'</td>
                    <td class="border1 bold-text" style="width:87px;">'.$rfc['total_items'].'</td>
                </tr>';

                $sub_images += $rfc['total_images'];
                $sub_decoration += $rfc['total_decoration'];
                $sub_paintings += $rfc['total_paintings'];
                $sub_household += $rfc['total_household'];
                $sub_appliances += $rfc['total_appliances'];
                $sub_total += $rfc['total_items'];
            }
            $grand_images += $sub_images;
            $grand_decoration += $sub_decoration;
            $grand_paintings += $sub_paintings;
            $grand_household += $sub_household;
            $grand_appliances += $sub_appliances;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:140px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_images.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_decoration.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_paintings.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_household.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_appliances.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>

         <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">FIXTURES</th>
                </tr>
                 <tr>
                    <th class="border bold-text" style="width:140px;">ELC BRANCHES</th>
                    <th class="border bold-text" style="width:87px;">IMAGES / STATUES</th>
                    <th class="border bold-text" style="width:87px;">DECORATIONS</th>
                    <th class="border bold-text" style="width:87px;">PAINTINGS</th>
                    <th class="border bold-text" style="width:87px;">HOUSEHOLD EFFECTS</th>
                    <th class="border bold-text" style="width:87px;">APPLIANCES</th>
                    <th class="border bold-text" style="width:87px;">TOTAL</th>
                </tr>
            </thead>
          <tbody>';
          $sub_images = 0;
          $sub_decoration = 0;
          $sub_paintings = 0;
          $sub_household = 0;
          $sub_appliances = 0;
          $sub_total = 0;

       
            $getELC = (new ControllerQRCode)->ctrGetFixtureByBranch("ELC");
            foreach($getELC as $elc){
                $header .='
                <tr>
                    <td class="border1" style="width:140px; text-align: left;"> '.$elc['item_location'].'</td>
                    <td class="border1" style="width:87px;">'.$elc['total_images'].'</td>
                    <td class="border1" style="width:87px;">'.$elc['total_decoration'].'</td>
                    <td class="border1" style="width:87px;">'.$elc['total_paintings'].'</td>
                    <td class="border1" style="width:87px;">'.$elc['total_household'].'</td>
                    <td class="border1" style="width:87px;">'.$elc['total_appliances'].'</td>
                    <td class="border1 bold-text" style="width:87px;">'.$elc['total_items'].'</td>
                </tr>';

                $sub_images += $elc['total_images'];
                $sub_decoration += $elc['total_decoration'];
                $sub_paintings += $elc['total_paintings'];
                $sub_household += $elc['total_household'];
                $sub_appliances += $elc['total_appliances'];
                $sub_total += $elc['total_items'];
            }
            $grand_images += $sub_images;
            $grand_decoration += $sub_decoration;
            $grand_paintings += $sub_paintings;
            $grand_household += $sub_household;
            $grand_appliances += $sub_appliances;
            $grand_total += $sub_total;
            $header .='    
              <tr>
                    <td class="border1" style="width:140px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_images.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_decoration.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_paintings.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_household.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_appliances.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
                   <tr>
                    <td class="border1" style="width:140px; color:red; font-weight:bold; text-align: left;"> GRAND TOTAL</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_images.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_decoration.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_paintings.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_household.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_appliances.'</td>
                    <td class="border1" style="width:87px; color:red; font-weight:bold;">'.$grand_total.'</td>
                </tr>  
            </tbody>
        </table>
        ';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }


    public function reportEquipment() {
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
        $pdf->SetMargins(4, 8, 4);
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
        $branch = $_GET['branch'];
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
                font-size: 0.65em;
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
        
        <h4>Branch: '.$branch.'</h4>
        <h4>Date: '.$date.'</h4>
        <table>
            <tr>
                <td  style="text-align: center; font-size: 1.4em;   font-weight: bold; ">ITEM CLASSIFICATION SUMMARY</td>
            </tr>
            <tr>
                <td  style="text-align: center; font-size: 1em; height:25px;">EQUIPMENT - EQ</td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">EQUIPMENT</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:125px;">EMB BRANCHES</th>
                    <th class="border bold-text" style="width:70px;">COMPUTERS</th>
                    <th class="border bold-text" style="width:62px;;">PRINTERS / COPIERS</th>
                    <th class="border bold-text" style="width:82px;">PERIPHERALS / ACCESSORIES</th>
                    <th class="border bold-text" style="width:72px;">CCTV EQUIPMENTS</th>
                    <th class="border bold-text" style="width:72px;">SOUNDS AND MIXERS</th>
                    <th class="border bold-text" style="width:93px;">GADGETS / COMMUNICATION</th>
                    <th class="border bold-text" style="width:53px;">MOTOR VEHICLE</th>
                    <th class="border bold-text" style="width:44px;">OTHER FFE</th>
                    <th class="border bold-text" style="width:43px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_computers= 0;
            $sub_printers = 0;
            $sub_peripherals = 0;
            $sub_cctv = 0;
            $sub_sounds = 0;
            $sub_gadgets = 0;
            $sub_motor = 0;
            $sub_other = 0;
            $sub_total = 0;

            $grand_computers = 0;
            $grand_printers = 0;
            $grand_peripherals = 0;
            $grand_cctv = 0;
            $grand_sounds = 0;
            $grand_gadgets = 0;
            $grand_motor = 0;
            $grand_other = 0;
            $grand_total = 0;

            $getEMB = (new ControllerQRCode)->ctrGetEquipmentByBranch("EMB");
            foreach($getEMB as $emb){

          
            $header .='
                <tr>
                    <td class="border1" style="width:125px; text-align: left;"> '.$emb['item_location'].'</td>
                    <td class="border1" style="width:70px;">'.$emb['total_computers'].'</td>
                    <td class="border1" style="width:62px;">'.$emb['total_printers'].'</td>
                    <td class="border1" style="width:82px;">'.$emb['total_peripherals'].'</td>
                    <td class="border1" style="width:72px;">'.$emb['total_cctv'].'</td>
                    <td class="border1" style="width:72px;">'.$emb['total_sounds'].'</td>
                    <td class="border1 bold-text" style="width:93px;">'.$emb['total_gadgets'].'</td>
                    <td class="border1 bold-text" style="width:53px;">'.$emb['total_motor'].'</td>
                    <td class="border1 bold-text" style="width:44px;">'.$emb['total_other'].'</td>
                    <td class="border1 bold-text" style="width:43px;">'.$emb['total_items'].'</td>
                </tr>';

                $sub_computers += $emb['total_computers'];
                $sub_printers += $emb['total_printers'];
                $sub_peripherals += $emb['total_peripherals'];
                $sub_cctv += $emb['total_cctv'];
                $sub_sounds += $emb['total_sounds'];
                $sub_gadgets += $emb['total_gadgets'];
                $sub_motor += $emb['total_motor'];
                $sub_other += $emb['total_other'];
                $sub_total += $emb['total_items'];
            }

            
            $grand_computers += $sub_computers;
            $grand_printers += $sub_printers;
            $grand_peripherals = $sub_peripherals;
            $grand_cctv += $sub_cctv;
            $grand_sounds += $sub_sounds;
            $grand_gadgets += $sub_gadgets;
            $grand_motor += $sub_motor;
            $grand_other += $sub_other;
            $grand_total += $sub_total;


            $header .='    
              <tr>
                    <td class="border1" style="width:125px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:70px; color:red; font-weight:bold;">'.$sub_computers.'</td>
                    <td class="border1" style="width:62px; color:red; font-weight:bold;">'.$sub_printers.'</td>
                    <td class="border1" style="width:82px; color:red; font-weight:bold;">'.$sub_peripherals.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_cctv.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_sounds.'</td>
                    <td class="border1" style="width:93px; color:red; font-weight:bold;">'.$sub_gadgets.'</td>
                    <td class="border1" style="width:53px; color:red; font-weight:bold;">'.$sub_motor.'</td>
                    <td class="border1" style="width:44px; color:red; font-weight:bold;">'.$sub_other.'</td>
                    <td class="border1" style="width:43px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
        
        <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">EQUIPMENT</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:125px;">FCH BRANCHES</th>
                    <th class="border bold-text" style="width:70px;">COMPUTERS</th>
                    <th class="border bold-text" style="width:62px;;">PRINTERS / COPIERS</th>
                    <th class="border bold-text" style="width:82px;">PERIPHERALS / ACCESSORIES</th>
                    <th class="border bold-text" style="width:72px;">CCTV EQUIPMENTS</th>
                    <th class="border bold-text" style="width:72px;">SOUNDS AND MIXERS</th>
                    <th class="border bold-text" style="width:93px;">GADGETS / COMMUNICATION</th>
                    <th class="border bold-text" style="width:53px;">MOTOR VEHICLE</th>
                    <th class="border bold-text" style="width:44px;">OTHER FFE</th>
                    <th class="border bold-text" style="width:43px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_computers= 0;
            $sub_printers = 0;
            $sub_peripherals = 0;
            $sub_cctv = 0;
            $sub_sounds = 0;
            $sub_gadgets = 0;
            $sub_motor = 0;
            $sub_other = 0;
            $sub_total = 0;

       

            $getFCH = (new ControllerQRCode)->ctrGetEquipmentByBranch("FCH");
            foreach($getFCH as $fch){

          
            $header .='
                <tr>
                    <td class="border1" style="width:125px; text-align: left;"> '.$fch['item_location'].'</td>
                    <td class="border1" style="width:70px;">'.$fch['total_computers'].'</td>
                    <td class="border1" style="width:62px;">'.$fch['total_printers'].'</td>
                    <td class="border1" style="width:82px;">'.$fch['total_peripherals'].'</td>
                    <td class="border1" style="width:72px;">'.$fch['total_cctv'].'</td>
                    <td class="border1" style="width:72px;">'.$fch['total_sounds'].'</td>
                    <td class="border1 bold-text" style="width:93px;">'.$fch['total_gadgets'].'</td>
                    <td class="border1 bold-text" style="width:53px;">'.$fch['total_motor'].'</td>
                    <td class="border1 bold-text" style="width:44px;">'.$fch['total_other'].'</td>
                    <td class="border1 bold-text" style="width:43px;">'.$fch['total_items'].'</td>
                </tr>';

                $sub_computers += $fch['total_computers'];
                $sub_printers += $fch['total_printers'];
                $sub_peripherals += $fch['total_peripherals'];
                $sub_cctv += $fch['total_cctv'];
                $sub_sounds += $fch['total_sounds'];
                $sub_gadgets += $fch['total_gadgets'];
                $sub_motor += $fch['total_motor'];
                $sub_other += $fch['total_other'];
                $sub_total += $fch['total_items'];
            }

            
            $grand_computers += $sub_computers;
            $grand_printers += $sub_printers;
            $grand_peripherals += $sub_peripherals;
            $grand_cctv += $sub_cctv;
            $grand_sounds += $sub_sounds;
            $grand_gadgets += $sub_gadgets;
            $grand_motor += $sub_motor;
            $grand_other += $sub_other;
            $grand_total += $sub_total;


            $header .='    
              <tr>
                    <td class="border1" style="width:125px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:70px; color:red; font-weight:bold;">'.$sub_computers.'</td>
                    <td class="border1" style="width:62px; color:red; font-weight:bold;">'.$sub_printers.'</td>
                    <td class="border1" style="width:82px; color:red; font-weight:bold;">'.$sub_peripherals.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_cctv.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_sounds.'</td>
                    <td class="border1" style="width:93px; color:red; font-weight:bold;">'.$sub_gadgets.'</td>
                    <td class="border1" style="width:53px; color:red; font-weight:bold;">'.$sub_motor.'</td>
                    <td class="border1" style="width:44px; color:red; font-weight:bold;">'.$sub_other.'</td>
                    <td class="border1" style="width:43px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>
          
         <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">EQUIPMENT</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:125px;">RFC BRANCHES</th>
                    <th class="border bold-text" style="width:70px;">COMPUTERS</th>
                    <th class="border bold-text" style="width:62px;;">PRINTERS / COPIERS</th>
                    <th class="border bold-text" style="width:82px;">PERIPHERALS / ACCESSORIES</th>
                    <th class="border bold-text" style="width:72px;">CCTV EQUIPMENTS</th>
                    <th class="border bold-text" style="width:72px;">SOUNDS AND MIXERS</th>
                    <th class="border bold-text" style="width:93px;">GADGETS / COMMUNICATION</th>
                    <th class="border bold-text" style="width:53px;">MOTOR VEHICLE</th>
                    <th class="border bold-text" style="width:44px;">OTHER FFE</th>
                    <th class="border bold-text" style="width:43px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_computers= 0;
            $sub_printers = 0;
            $sub_peripherals = 0;
            $sub_cctv = 0;
            $sub_sounds = 0;
            $sub_gadgets = 0;
            $sub_motor = 0;
            $sub_other = 0;
            $sub_total = 0;


            $getRFC = (new ControllerQRCode)->ctrGetEquipmentByBranch("RLC");
            foreach($getRFC as $rfc){

          
            $header .='
                <tr>
                    <td class="border1" style="width:125px; text-align: left;"> '.$rfc['item_location'].'</td>
                    <td class="border1" style="width:70px;">'.$rfc['total_computers'].'</td>
                    <td class="border1" style="width:62px;">'.$rfc['total_printers'].'</td>
                    <td class="border1" style="width:82px;">'.$rfc['total_peripherals'].'</td>
                    <td class="border1" style="width:72px;">'.$rfc['total_cctv'].'</td>
                    <td class="border1" style="width:72px;">'.$rfc['total_sounds'].'</td>
                    <td class="border1 bold-text" style="width:93px;">'.$rfc['total_gadgets'].'</td>
                    <td class="border1 bold-text" style="width:53px;">'.$rfc['total_motor'].'</td>
                    <td class="border1 bold-text" style="width:44px;">'.$rfc['total_other'].'</td>
                    <td class="border1 bold-text" style="width:43px;">'.$rfc['total_items'].'</td>
                </tr>';

                $sub_computers += $rfc['total_computers'];
                $sub_printers += $rfc['total_printers'];
                $sub_peripherals += $rfc['total_peripherals'];
                $sub_cctv += $rfc['total_cctv'];
                $sub_sounds += $rfc['total_sounds'];
                $sub_gadgets += $rfc['total_gadgets'];
                $sub_motor += $rfc['total_motor'];
                $sub_other += $rfc['total_other'];
                $sub_total += $rfc['total_items'];
            }

            
            $grand_computers += $sub_computers;
            $grand_printers += $sub_printers;
            $grand_peripherals += $sub_peripherals;
            $grand_cctv += $sub_cctv;
            $grand_sounds += $sub_sounds;
            $grand_gadgets += $sub_gadgets;
            $grand_motor += $sub_motor;
            $grand_other += $sub_other;
            $grand_total += $sub_total;


            $header .='    
              <tr>
                    <td class="border1" style="width:125px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:70px; color:red; font-weight:bold;">'.$sub_computers.'</td>
                    <td class="border1" style="width:62px; color:red; font-weight:bold;">'.$sub_printers.'</td>
                    <td class="border1" style="width:82px; color:red; font-weight:bold;">'.$sub_peripherals.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_cctv.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_sounds.'</td>
                    <td class="border1" style="width:93px; color:red; font-weight:bold;">'.$sub_gadgets.'</td>
                    <td class="border1" style="width:53px; color:red; font-weight:bold;">'.$sub_motor.'</td>
                    <td class="border1" style="width:44px; color:red; font-weight:bold;">'.$sub_other.'</td>
                    <td class="border1" style="width:43px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
            </tbody>
        </table>

          <table>
            <thead>
                <tr>
               <th class="border bold-text" rowspan="">EQUIPMENT</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:125px;">ELC BRANCHES</th>
                    <th class="border bold-text" style="width:70px;">COMPUTERS</th>
                    <th class="border bold-text" style="width:62px;;">PRINTERS / COPIERS</th>
                    <th class="border bold-text" style="width:82px;">PERIPHERALS / ACCESSORIES</th>
                    <th class="border bold-text" style="width:72px;">CCTV EQUIPMENTS</th>
                    <th class="border bold-text" style="width:72px;">SOUNDS AND MIXERS</th>
                    <th class="border bold-text" style="width:93px;">GADGETS / COMMUNICATION</th>
                    <th class="border bold-text" style="width:53px;">MOTOR VEHICLE</th>
                    <th class="border bold-text" style="width:44px;">OTHER FFE</th>
                    <th class="border bold-text" style="width:43px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>';
            $sub_computers= 0;
            $sub_printers = 0;
            $sub_peripherals = 0;
            $sub_cctv = 0;
            $sub_sounds = 0;
            $sub_gadgets = 0;
            $sub_motor = 0;
            $sub_other = 0;
            $sub_total = 0;

       

            $getELC= (new ControllerQRCode)->ctrGetEquipmentByBranch("ELC");
            foreach($getELC as $elc){

          
            $header .='
                <tr>
                    <td class="border1" style="width:125px; text-align: left;"> '.$elc['item_location'].'</td>
                    <td class="border1" style="width:70px;">'.$elc['total_computers'].'</td>
                    <td class="border1" style="width:62px;">'.$elc['total_printers'].'</td>
                    <td class="border1" style="width:82px;">'.$elc['total_peripherals'].'</td>
                    <td class="border1" style="width:72px;">'.$elc['total_cctv'].'</td>
                    <td class="border1" style="width:72px;">'.$elc['total_sounds'].'</td>
                    <td class="border1 bold-text" style="width:93px;">'.$elc['total_gadgets'].'</td>
                    <td class="border1 bold-text" style="width:53px;">'.$elc['total_motor'].'</td>
                    <td class="border1 bold-text" style="width:44px;">'.$elc['total_other'].'</td>
                    <td class="border1 bold-text" style="width:43px;">'.$elc['total_items'].'</td>
                </tr>';

                $sub_computers += $elc['total_computers'];
                $sub_printers += $elc['total_printers'];
                $sub_peripherals += $elc['total_peripherals'];
                $sub_cctv += $elc['total_cctv'];
                $sub_sounds += $elc['total_sounds'];
                $sub_gadgets += $elc['total_gadgets'];
                $sub_motor += $elc['total_motor'];
                $sub_other += $elc['total_other'];
                $sub_total += $elc['total_items'];
            }

            
            $grand_computers += $sub_computers;
            $grand_printers += $sub_printers;
            $grand_peripherals += $sub_peripherals;
            $grand_cctv += $sub_cctv;
            $grand_sounds += $sub_sounds;
            $grand_gadgets += $sub_gadgets;
            $grand_motor += $sub_motor;
            $grand_other += $sub_other;
            $grand_total += $sub_total;


            $header .='    
              <tr>
                    <td class="border1" style="width:125px; color:red; font-weight:bold; text-align: left;"> SUB TOTAL</td>
                    <td class="border1" style="width:70px; color:red; font-weight:bold;">'.$sub_computers.'</td>
                    <td class="border1" style="width:62px; color:red; font-weight:bold;">'.$sub_printers.'</td>
                    <td class="border1" style="width:82px; color:red; font-weight:bold;">'.$sub_peripherals.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_cctv.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$sub_sounds.'</td>
                    <td class="border1" style="width:93px; color:red; font-weight:bold;">'.$sub_gadgets.'</td>
                    <td class="border1" style="width:53px; color:red; font-weight:bold;">'.$sub_motor.'</td>
                    <td class="border1" style="width:44px; color:red; font-weight:bold;">'.$sub_other.'</td>
                    <td class="border1" style="width:43px; color:red; font-weight:bold;">'.$sub_total.'</td>
                </tr>
                 <tr>
                    <td class=""  style="width:150px;"></td>
                </tr>
                   <tr>
                    <td class="border1" style="width:125px; color:red; font-weight:bold; text-align: left;"> GRAND TOTAL</td>
                    <td class="border1" style="width:70px; color:red; font-weight:bold;">'.$grand_computers.'</td>
                    <td class="border1" style="width:62px; color:red; font-weight:bold;">'.$grand_printers.'</td>
                    <td class="border1" style="width:82px; color:red; font-weight:bold;">'.$grand_peripherals.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$grand_cctv.'</td>
                    <td class="border1" style="width:72px; color:red; font-weight:bold;">'.$grand_sounds.'</td>
                    <td class="border1" style="width:93px; color:red; font-weight:bold;">'.$grand_gadgets.'</td>
                    <td class="border1" style="width:53px; color:red; font-weight:bold;">'.$grand_motor.'</td>
                    <td class="border1" style="width:44px; color:red; font-weight:bold;">'.$grand_other.'</td>
                    <td class="border1" style="width:43px; color:red; font-weight:bold;">'.$grand_total.'</td>
                </tr>  
            </tbody>
        </table>
        ';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }
    public function reportFixtureByBranch() {
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
        $pdf->SetFont('helvetica', '', 12); // Set font to Helvetica
        $branch = $_GET['branch'];
        $currentDate = date('Y-m-d');   
        $date = date('F j, Y');     
        $class_type = $_GET['slctClass'];
        if($class_type == 'FIXTURES'){
            $classTitle = "FIXTURES - FX";
            $fontSize = "0.7em";
        }else if($class_type == 'FURNITURE'){
            $classTitle = "FURNITURE - FR";
            $fontSize = "0.7em";
        }else if($class_type == 'EQUIPMENT'){
            $classTitle = "EQUIPMENT - EQ";
            $fontSize = "0.7em";
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
                font-size: '.$fontSize.';
                padding-top: 3px;
                padding-bottom: 3px;
            }
            .border {
                background-color: #D9D9D9;
                border: 1px solid black;
                text-align: center;
              
            }
            .spacer{
                font-size: 0.4em;
                color: #D9D9D9;
         }
        .bold-text {
            font-weight: bold;
            }

        </style>
       
            <table>
                <tr>
                    <td style="text-align: left;font-size: 1em; font-weight:bold;" >Branch: '.$branch.'</td>
                    <td style="text-align: right; font-size: 0.9em; font-weight:bold; width: 355px;">'.$date.'</td>
                </tr>
                 <tr>
                    <td style="height:20px;"></td>
                    
                </tr>
            </table>
       
          <table>
            <tr>
                <td  style="text-align: center; font-size: 1.4em;   font-weight: bold; ">ITEM CLASSIFICATION SUMMARY</td>
            </tr>
            <tr>
                <td  style="text-align: center; font-size: 1em; height:25px;">'.$classTitle.'</td>
            </tr>
        </table>
        
        <table>
            <thead>
                <tr>
               <th class="border bold-text" style="width:678px;" rowspan="">'.$class_type.'</th>
                </tr>
                <tr>
                    <th class="border bold-text" style="width:40px;">NO.</th>
                    <th class="border bold-text" style="width:55px;">STICKER NO.</th>
                    <th class="border bold-text" style="width:190px;">ITEM DESCRIPTION</th>
                    <th class="border bold-text" style="width:78px;">DATE PURCHASED</th>
                    <th class="border bold-text" style="width:131px;">CLASSIFICATION CATEGORY</th>
                    <th class="border bold-text" style="width:116px;">CLASSIFICATION LIST</th>
                    <th class="border bold-text" style="width:68px;">STATUS</th>
                </tr>
            </thead>
            <tbody>';
            $i = 1;
            // Equipment
            $sub_computers= 0;
            $sub_printers = 0;
            $sub_peripherals = 0;
            $sub_cctv = 0;
            $sub_sounds = 0;
            $sub_gadgets = 0;
            $sub_motor = 0;
            $sub_other = 0;

            // Furniture
            $sub_table = 0;
            $sub_chair = 0;
            $sub_cabinets = 0;

            // Fixtures
            $sub_images = 0;
            $sub_decoration = 0;
            $sub_paintings = 0;
            $sub_household = 0;
            $sub_appliances = 0;


            $working = 0;
            $repaired = 0;
            $defective = 0;
            $disposed = 0;
          

            $getEMB = (new ControllerQRCode)->ctrGetFixtureByBranch1($branch, $class_type);
            foreach($getEMB as $emb){
                $class_category = $emb['class_category'];
                $status = $emb['status'];

               // Arrays to map categories and statuses
                $class_categories = [
                    "COMPUTERS" => &$sub_computers,
                    "PRINTERS / COPIERS" => &$sub_printers,
                    "PERIPHERALS / ACCESSORIES" => &$sub_peripherals,
                    "CCTV EQUIPMENTS" => &$sub_cctv,
                    "SOUNDS AND MIXERS" => &$sub_sounds,
                    "GADGETS / COMMUNICATION / CONNECTIVITY" => &$sub_gadgets,
                    "MOTOR VEHICLE" => &$sub_motor,
                    "OTHER FFE" => &$sub_other,
                    "CHAIRS" => &$sub_chair,
                    "CABINETS" => &$sub_cabinets,
                    "TABLES" => &$sub_table,
                    "IMAGES / STATUES" => &$sub_images,
                    "DECORATIONS" => &$sub_decoration,
                    "PAINTINGS" => &$sub_paintings,
                    "HOUSEHOLD EFFECTS" => &$sub_household,
                    "APPLIANCES" => &$sub_appliances,
                ];

                $statuses = [
                    "WORKING" => &$working,
                    "REPAIRED" => &$repaired,
                    "DEFECTIVE" => &$defective,
                    "DISPOSED" => &$disposed
                ];

                // Increment the appropriate category counter
                if (isset($class_categories[$class_category])) {
                    $class_categories[$class_category]++;
                }

                // Increment the appropriate status counter
                if (isset($statuses[$status])) {
                    $statuses[$status]++;
                }


          
            $header .='
                <tr>
                    <td class="border1" style="width:40px;">'.$i.'</td>
                    <td class="border1" style="width:55px;">'.$emb['sticker_no'].'</td>
                    <td class="border1" style="width:190px;">'.$emb['item_description'].'</td>
                    <td class="border1" style="width:78px;">'.$emb['date_purchased'].'</td>
                    <td class="border1" style="width:131px;">'.$emb['class_category'].'</td>
                    <td class="border1" style="width:116px;">'.$emb['class_list'].'</td>
                    <td class="border1" style="width:68px;">'.$emb['status'].'</td>
                </tr>';
                $i++;
            }

            if($class_type == "FURNITURE"){
                $sub_total = $sub_table + $sub_chair + $sub_cabinets;
            }elseif($class_type == "EQUIPMENT"){
              $sub_total =  $sub_computers + $sub_printers + $sub_peripherals + $sub_cctv + $sub_sounds + $sub_gadgets + $sub_motor + $sub_other;
            }elseif($class_type == "FIXTURES"){
                $sub_total =  $sub_images + $sub_decoration + $sub_paintings + $sub_household + $sub_appliances;
              }
            $header .='    
                <tr>
                    <td style="height:25px;"></td>
                </tr>
                 <tr>
                    <td style="width:500px; text-align:left; font-size:1.2em; font-weight:bold;">SUMMARY</td>
                </tr>';
        if($class_type == "EQUIPMENT"){      
            $header .='   
                <tr>
                    <td class="border bold-text" style="width:80px;"><span class="spacer">dwadwadwdsda</span>COMPUTERS</td>
                    <td class="border bold-text" style="width:72px;">PRINTERS / COPIERS</td>
                    <td class="border bold-text" style="width:95px;">PERIPHERALS / ACCESSORIES</td>
                    <td class="border bold-text" style="width:80px;">CCTV EQUIPMENTS</td>
                    <td class="border bold-text" style="width:60px;">SOUNDS AND MIXERS</td>
                    <td class="border bold-text" style="width:105px;">GADGETS / COMMUNICATION</td>
                    <td class="border bold-text" style="width:70px;">MOTOR VEHICLE</td>
                    <td class="border bold-text" style="width:70px;"><span class="spacer">dwadwaddda</span>OTHER FFE</td>
                    <td class="border bold-text" style="width:45px;"><span class="spacer">dwadwad</span>TOTAL</td>
                </tr>
                <tr>
                    <td class="border1" style="width:80px;">'.$sub_computers.'</td>
                    <td class="border1" style="width:72px;">'.$sub_printers.'</td>
                    <td class="border1" style="width:95px;">'.$sub_peripherals.'</td>
                    <td class="border1" style="width:80px;">'.$sub_cctv.'</td>
                    <td class="border1" style="width:60px;">'.$sub_sounds.'</td>
                    <td class="border1" style="width:105px;">'.$sub_gadgets.'</td>
                    <td class="border1" style="width:70px;">'.$sub_motor.'</td>
                    <td class="border1" style="width:70px;">'.$sub_other.'</td>
                    <td class="border1 bold-text" style="width:45px;">'.$sub_total.'</td>
                </tr>';
                }elseif($class_type == "FURNITURE"){
                    $header .='   
                    <tr>
                        <td class="border bold-text" style="width:170px;">TABLES</td>
                        <td class="border bold-text" style="width:170px;">CHAIRS</td>
                        <td class="border bold-text" style="width:170px;">CABINETS</td>
                        <td class="border bold-text" style="width:170px;">TOTAL</td>
                    </tr>
                    <tr>
                        <td class="border1" style="width:170px;">'.$sub_table.'</td>
                        <td class="border1" style="width:170px;">'.$sub_chair.'</td>
                        <td class="border1" style="width:170px;">'.$sub_cabinets.'</td>
                        <td class="border1 bold-text" style="width:170px;">'.$sub_total.'</td>
                    </tr>';
                }elseif($class_type == "FIXTURES"){
                    $header .='   
                    <tr>
                        <td class="border bold-text" style="width:113px;">IMAGES / STATUES</td>
                        <td class="border bold-text" style="width:113px;">DECORATIONS </td>
                        <td class="border bold-text" style="width:113px;">PAINTINGS </td>
                        <td class="border bold-text" style="width:113px;">HOUSEHOLD EFFECTS</td>
                        <td class="border bold-text" style="width:113px;">APPLIANCES </td>
                        <td class="border bold-text" style="width:113px;">TOTAL</td>
                    </tr>
                    <tr>
                        <td class="border1" style="width:113px;">'.$sub_images.'</td>
                        <td class="border1" style="width:113px;">'.$sub_decoration.'</td>
                        <td class="border1" style="width:113px;">'.$sub_paintings.'</td>
                        <td class="border1" style="width:113px;">'.$sub_household.'</td>
                        <td class="border1" style="width:113px;">'.$sub_appliances.'</td>
                        <td class="border1 bold-text" style="width:113px;">'.$sub_total.'</td>
                    </tr>';
                }
            $header .='   
                <tr>
                    <td style="height:20px;"></td>
                </tr>
                 <tr>
                    <td  class="bold-text" style="width:500px; height:25px;  text-align:left; font-size:1em;">GRAND TOTAL: '.$sub_total.'</td>
                </tr>
                <tr >
                    <td class="bold-text" style="width:170px; font-size:1em;  text-align:left;">WORKING: '.$working.'</td>
                    <td class="bold-text" style="width:170px; font-size:1em;  text-align:left;">REPAIRED: '.$repaired.'</td>
                    <td class="bold-text" style="width:170px; font-size:1em; text-align:left;">DEFECTIVE: '.$defective.'</td>
                    <td class="bold-text" style="width:170px; font-size:1em; text-align:left;">DISPOSED: '.$disposed.'</td>
                </tr>
            </tbody>
        </table>
        ';
     

        // Write HTML content to PDF
        $pdf->writeHTML($header, false, false, false, false, '');

        $pdf->Output('Check Writer', 'I');
    }
}