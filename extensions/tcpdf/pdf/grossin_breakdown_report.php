<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/operation.controller.php";
require_once "../../../models/operation.model.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){
    $mntTo = $_GET['mntTo'];
    $montRange = date("m", strtotime($mntTo));
    if($montRange<=3){
        $yearWidth= "width: 200px";
        $branchWidth= "width: 110px";
        $pdfFormat ="P";
        $tableSize= "font-size:8.1rem";
        $fontSize="font-size:5.6rem";
    }else{
        $yearWidth=""; 
        $pdfFormat ="L";
        $branchWidth= "width: 110px";
        $fontSize= "font-size:4.5rem";
        $tableSize= "font-size:6.0rem";
    }

  require_once('tcpdf_include.php');


//   $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF($pdfFormat, 'mm', 'Letter', true, 'UTF-8', false);

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
$pdf->SetMargins(7,7);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 0); // Remove the bottom margin

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('Times');
$pdf->AddPage();



    // set JPEG quality
$pdf->setJPEGQuality(75);
// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('');

       // The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);



//rlwh//
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
// $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




$reportName = "PDR Performance Summary.pdf";

$Operation = new ControllerOperation();


$mntTo = $_GET['mntTo'];
$preBy1 = $_GET['preBy'];

$preBy = strtoupper($preBy1);
$givenMonth = $mntTo;
$dateArray = [];
while (true) {
    $dateArray[] = date("Y-m", strtotime($givenMonth));
    $currentYear = substr($givenMonth, 0, 4);
    $currentMonth = substr($givenMonth, 5, 2);
    if ($currentMonth == "01") {
        break;
    }
    $givenMonth = date("Y-m", strtotime("-1 month", strtotime($givenMonth)));
}
sort($dateArray);

$countArray = count($dateArray);
if($countArray<=5){
    $count = $countArray;
}else{
    $count = 6;
}

$Fmonth =  strtoupper(date("M", strtotime($dateArray[0])) . " - " . date("M Y", strtotime($mntTo)));

$widthValues = [
    '12' => "width:36px;",
    '11' => "width:39px;",
    '10' => "width:43px;",
    '09'  => "width:48px;",
    '08'  => "width:53px;",
    '07'  => "width:41px;",
    '06'  => "width:47px;",
    '05'  => "width:56px;",
    '04'  => "width:67px;",
    '03'  => "width:84px;",
    '02'  => "width:113px;",
    '01'  => "width:171px;"
];

if (isset($widthValues[$montRange])) {
    $width = $widthValues[$montRange];
} else {
    // Default width value or error handling
    $width = "width:100px;"; // Change this to your desired default value
}


// $formatted_to = date("m/d/Y", strtotime($to));

// $prev = date("Y-m-d", strtotime("-1 day", strtotime($from)));

// $formatted_prev = date("m/d/Y", strtotime($prev));
// $combDate =  strtoupper(date("F d", strtotime($from)) . " - " . date("d", strtotime($to)));

    $header = <<<EOF
                    <style>
                            tr,th{
                        border:1px solid black;
                        $tableSize;
                        text-align:center;
                        }
                            tr, td{
                        border:1px solid black;
                        $tableSize;
                        text-align:center;
                        }
                </style>
            <h6>MONTHLY GROSS IN BREAKDOWN<br><span style="font-size: 9px;">FOR $Fmonth</span></h6>
                <table style="border:1px solid black;">
                <tr style="">
                    <th style="text-align: left; $branchWidth; font-weight: bold;">NORTH NEGROS</th>
                
                    
            EOF;
             for ($i=0; $i<$count; $i++) { 
                $year = $dateArray[$i];
                $yearName = strtoupper(date("F Y", strtotime($year)));
               
                    
        $header .= <<<EOF
                <th style="background-color:#fcf0cc;$yearWidth;">
                    <table>
                        <tr>
                            <th style="border: none;font-weight: bold;" colspan="6">$yearName</th>
                        </tr>
                     </table>
                </th>
            EOF;
            }
    $header .= <<<EOF
                    </tr>  
                        <tr>
                            <th style="text-align: left;">BRANCHES</th>
                    EOF;
                    
                       for ($i=0; $i<$count; $i++) { 
            $header .= <<<EOF
                            <th>
                                <table>
                                    <tr >
                                        <th style="border:none;$fontSize;"> TOTAL IN</th>
                                        <th style="$fontSize;"> WALKIN</th>
                                        <th style="$fontSize;"> SALES REP</th>
                                        <th style="$fontSize;"> RETURNEE</th>
                                        <th style="$fontSize;"> RUNNERS/ AGENT</th>
                                        <th style="border:none;$fontSize;"> TRANSFER</th>
                                    </tr>
                                </table>
                            </th>
                            EOF;
                            }
        $header .= <<<EOF
                        </tr>  
                    EOF;  

                $getNorthNegros = $Operation->ctrGetNorthNegros();
          
                foreach($getNorthNegros as $getNorth){
                    
                    $branch_name = $getNorth['branch_name'];
                    $new_branch_name = str_replace("EMB", "", $branch_name);
                $header .= <<<EOF
                            <tr>
                                <td style="text-align: left;">$new_branch_name</td>
                    EOF;
                    $total_month = 0;
                    $total_walkin = 0;
                    $total_array = array();
                        for ($i=0; $i<$count; $i++) { 
                        $year = $dateArray[$i];
                        $monthFormat = date("F", strtotime($year));
                        $firstDay = $year . "-01";
                        $lastDay = date("Y-m-t", strtotime($year));
                        $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
                        foreach($getMonthlyData as $getGrossin){
                            $walkin = $getGrossin['walkin'];
                            $sales_rep = $getGrossin['sales_rep'];
                            $returnee = $getGrossin['returnee'];
                            $runners_agent = $getGrossin['runners_agent'];
                            $transfer = $getGrossin['transfer'];

                               // Append data for the current month into the yearlyData array
                            if (!isset($yearlyData[$branch_name])) {
                                $yearlyData[$branch_name] = array();
                            }
                            $yearlyData[$branch_name][$monthFormat] = array(
                                "walkin" => $walkin,
                                "sales_rep" => $sales_rep,
                                "returnee" => $returnee,
                                "runners_agent" => $runners_agent,
                                "transfer" => $transfer
                            );
                        }
                          // Insert data for the current month into the yearlyData array
                   
                      
                        $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
                        $total_walkin += $walkin;

        $header .= <<<EOF
                    <td>
                        <table>
                            <tr>
                                <td style="border: none; color:red;">$total_month</td>
                                <td>$walkin</td>
                                <td>$sales_rep</td>
                                <td>$returnee</td>
                                <td>$runners_agent</td>
                                <td style="border: none;">$transfer</td>
                            </tr>
                        </table>
                    </td>
                    EOF;
                }
          
                
        $header .= <<<EOF
                </tr>
                EOF; 

            }
  
    $header .= <<<EOF
                <tr>
                    <td style="text-align: left; font-weight: bold;">TOTAL</td>
            EOF; 
    
       
                for ($i=0; $i<$count; $i++) { 
            //    $total_walkin = $total_array['July']['total_walkin'];
            $year = $dateArray[$i];
            $monthFormat = date("F", strtotime($year));
            $walkinTotal = 0;
            $sales_repTotal = 0;
            $returneeTotal = 0;
            $runners_agentTotal = 0;
            $transferTotal = 0;
                  foreach($getNorthNegros as $getNorth){
                    $branch_name = $getNorth['branch_name'];
                $grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
                $grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
                $grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
                $grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
                $grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

                $walkinTotal +=$grand_totalWalkin;
                $sales_repTotal +=$grand_totalSales;
                $returneeTotal +=$grand_totalReturnee;
                $runners_agentTotal +=$grand_totalRunners;
                $transferTotal +=$grand_totalTransfer;
                  }
                  $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;
       
            $header .= <<<EOF
                  <td style="color: red;">
                   <table>
                            <tr style="font-weight: bold;">
                                <td style="border: none;">$grand_totalIn</td>
                                <td>$walkinTotal</td>
                                <td>$sales_repTotal</td>
                                <td>$returneeTotal</td>
                                <td>$runners_agentTotal</td>
                                <td style="border: none;">$transferTotal</td>
                            </tr>
                        </table>
                        </td>
                EOF; 
            }
            $header .= <<<EOF
                </tr>
                  
            EOF;
        $header .= <<<EOF
             <tr style="border: none;">
             <th style="border: none;"></th>
             </tr>
            <tr style="">
            <th style="text-align: left;  $branchWidth;font-weight: bold;">SOUTH NEGROS</th>
        
    EOF;
        for ($i=0; $i<$count; $i++) { 
        $year = $dateArray[$i];
        $yearName = strtoupper(date("F Y", strtotime($year)));
       
            
$header .= <<<EOF
        <th style="background-color:#fcf0cc;">
            <table>
                <tr>
                    <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
                </tr>
             </table>
        </th>
    EOF;
    }
$header .= <<<EOF
            </tr>  
                <tr>
                    <th style="text-align: left;">BRANCHES</th>
            EOF;
            
    for ($i=0; $i<$count; $i++) { 
    $header .= <<<EOF
                    <th>
                        <table>
                            <tr >
                                <th style="border:none;$fontSize;"> TOTAL IN</th>
                                <th style="$fontSize;"> WALKIN</th>
                                <th style="$fontSize;"> SALES REP</th>
                                <th style="$fontSize;"> RETURNEE</th>
                                <th style="$fontSize;"> RUNNERS/ AGENT</th>
                                <th style="border:none;$fontSize;"> TRANSFER</th>
                            </tr>
                        </table>
                    </th>
                    EOF;
                    }
$header .= <<<EOF
                </tr>  
            EOF;  

        $getSouthNegros = $Operation->ctrGetSouthNegros();
  
        foreach($getSouthNegros as $getSouth){
            
            $branch_name = $getSouth['branch_name'];
            $new_branch_name = str_replace("EMB", "", $branch_name);
        $header .= <<<EOF
                    <tr>
                        <td style="text-align: left;">$new_branch_name</td>
            EOF;
            $total_month = 0;
            $total_walkin = 0;
            $total_array = array();
              for ($i=0; $i<$count; $i++) { 
                $year = $dateArray[$i];
                $monthFormat = date("F", strtotime($year));
                $firstDay = $year . "-01";
                $lastDay = date("Y-m-t", strtotime($year));
                $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
                foreach($getMonthlyData as $getGrossin){
                    $walkin = $getGrossin['walkin'];
                    $sales_rep = $getGrossin['sales_rep'];
                    $returnee = $getGrossin['returnee'];
                    $runners_agent = $getGrossin['runners_agent'];
                    $transfer = $getGrossin['transfer'];

                       // Append data for the current month into the yearlyData array
                    if (!isset($yearlyData[$branch_name])) {
                        $yearlyData[$branch_name] = array();
                    }
                    $yearlyData[$branch_name][$monthFormat] = array(
                        "walkin" => $walkin,
                        "sales_rep" => $sales_rep,
                        "returnee" => $returnee,    
                        "runners_agent" => $runners_agent,
                        "transfer" => $transfer
                    );
                }
                  // Insert data for the current month into the yearlyData array
           
              
                $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
                $total_walkin += $walkin;

$header .= <<<EOF
            <td>
                <table>
                    <tr>
                      <td style="border: none; color:red;">$total_month</td>
                        <td>$walkin</td>
                        <td>$sales_rep</td>
                        <td>$returnee</td>
                        <td>$runners_agent</td>
                        <td style="border: none;">$transfer</td>
                    </tr>
                </table>
            </td>
            EOF;
        }
  
$header .= <<<EOF
        </tr>
        EOF; 

    }

$header .= <<<EOF
        <tr>
            <td style="text-align: left; font-weight: bold;">TOTAL</td>
    EOF; 


      for ($i=0; $i<$count; $i++) { 
    //    $total_walkin = $total_array['July']['total_walkin'];
    $year = $dateArray[$i];
    $monthFormat = date("F", strtotime($year));
    $walkinTotal = 0;
    $sales_repTotal = 0;
    $returneeTotal = 0;
    $runners_agentTotal = 0;
    $transferTotal = 0;
          foreach($getSouthNegros as $getSouth){
            $branch_name = $getSouth['branch_name'];
        $grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
        $grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
        $grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
        $grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
        $grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

        $walkinTotal +=$grand_totalWalkin;
        $sales_repTotal +=$grand_totalSales;
        $returneeTotal +=$grand_totalReturnee;
        $runners_agentTotal +=$grand_totalRunners;
        $transferTotal +=$grand_totalTransfer;
          }
          $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

    $header .= <<<EOF
            <td style="color: red;">
           <table>
                    <tr style="font-weight: bold;">
                        <td style="border: none;">$grand_totalIn</td>
                        <td>$walkinTotal</td>
                        <td>$sales_repTotal</td>
                        <td>$returneeTotal</td>
                        <td>$runners_agentTotal</td>
                        <td style="border: none;">$transferTotal</td>
                    </tr>
                </table>
                </td>
        EOF; 
    }
    $header .= <<<EOF
        </tr>
           
    EOF;

    $header .= <<<EOF
    <tr style="border: none;">
    <th style="border: none;"></th>
    </tr>
   <tr style="">
   <th style="text-align: left;  $branchWidth;font-weight: bold;">PANAY</th>

EOF;
    for ($i=0; $i<$count; $i++) { 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));

   
$header .= <<<EOF
<th style="background-color:#fcf0cc;">
   <table>
       <tr>
           <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
       </tr>
    </table>
</th>
EOF;
}
$header .= <<<EOF
   </tr>  
       <tr>
           <th style="text-align: left;">BRANCHES</th>
   EOF;
   
             for ($i=0; $i<$count; $i++) { 
$header .= <<<EOF
                <th>
                <table>
                    <tr >
                        <th style="border:none;$fontSize;"> TOTAL IN</th>
                        <th style="$fontSize;"> WALKIN</th>
                        <th style="$fontSize;"> SALES REP</th>
                        <th style="$fontSize;"> RETURNEE</th>
                        <th style="$fontSize;"> RUNNERS/ AGENT</th>
                        <th style="border:none;$fontSize;"> TRANSFER</th>
                    </tr>
                </table>
                </th>
           EOF;
           }
$header .= <<<EOF
       </tr>  
   EOF;  

$getPanayBranch = $Operation->ctrGetPanay();

foreach($getPanayBranch as $getPanay){
   
   $branch_name = $getPanay['branch_name'];
   $new_branch_name = str_replace("EMB", "", $branch_name);
$header .= <<<EOF
           <tr>
               <td style="text-align: left;">$new_branch_name</td>
   EOF;
   $total_month = 0;
   $total_walkin = 0;
   $total_array = array();
     for ($i=0; $i<$count; $i++) { 
       $year = $dateArray[$i];
       $monthFormat = date("F", strtotime($year));
       $firstDay = $year . "-01";
       $lastDay = date("Y-m-t", strtotime($year));
       $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
       foreach($getMonthlyData as $getGrossin){
           $walkin = $getGrossin['walkin'];
           $sales_rep = $getGrossin['sales_rep'];
           $returnee = $getGrossin['returnee'];
           $runners_agent = $getGrossin['runners_agent'];
           $transfer = $getGrossin['transfer'];

              // Append data for the current month into the yearlyData array
           if (!isset($yearlyData[$branch_name])) {
               $yearlyData[$branch_name] = array();
           }
           $yearlyData[$branch_name][$monthFormat] = array(
               "walkin" => $walkin,
               "sales_rep" => $sales_rep,
               "returnee" => $returnee,
               "runners_agent" => $runners_agent,
               "transfer" => $transfer
           );
       }
         // Insert data for the current month into the yearlyData array
  
     
       $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
       $total_walkin += $walkin;

$header .= <<<EOF
   <td>
       <table>
           <tr>
              <td style="border: none; color:red;">$total_month</td>
               <td>$walkin</td>
               <td>$sales_rep</td>
               <td>$returnee</td>
               <td>$runners_agent</td>
               <td style="border: none;">$transfer</td>
           </tr>
       </table>
   </td>
   EOF;
}


$header .= <<<EOF
</tr>
EOF; 

}

$header .= <<<EOF
<tr>
   <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


    for ($i=0; $i<$count; $i++) { 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
 foreach($getPanayBranch as $getPanay){
   $branch_name = $getPanay['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
 }
 $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header .= <<<EOF
<td style="color: red;">
  <table>
           <tr style="font-weight: bold;">
               <td style="border: none;">$grand_totalIn</td>
               <td>$walkinTotal</td>
               <td>$sales_repTotal</td>
               <td>$returneeTotal</td>
               <td>$runners_agentTotal</td>
               <td style="border: none;">$transferTotal</td>
           </tr>
       </table>
       </td>
EOF; 
}
$header .= <<<EOF
</tr>

EOF;
$header .= <<<EOF
    <tr style="border: none;">
    <th style="border: none;"></th>
    </tr>
   <tr style="">
   <th style="text-align: left;  $branchWidth;font-weight: bold;">CENTRAL VISAYAS</th>

EOF;
    for ($i=0; $i<$count; $i++) { 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));

   
$header .= <<<EOF
<th style="background-color:#fcf0cc;">
   <table>
       <tr>
           <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
       </tr>
    </table>
</th>
EOF;
}
$header .= <<<EOF
   </tr>  
       <tr>
           <th style="text-align: left;">BRANCHES</th>
   EOF;
   
             for ($i=0; $i<$count; $i++) { 
$header .= <<<EOF
                <th>
                <table>
                    <tr >
                        <th style="border:none;$fontSize;"> TOTAL IN</th>
                        <th style="$fontSize;"> WALKIN</th>
                        <th style="$fontSize;"> SALES REP</th>
                        <th style="$fontSize;"> RETURNEE</th>
                        <th style="$fontSize;"> RUNNERS/ AGENT</th>
                        <th style="border:none;$fontSize;"> TRANSFER</th>
                    </tr>
                </table>
                </th>   
           EOF;
           }
$header .= <<<EOF
       </tr>  
   EOF;  

$getCentralVisayas= $Operation->ctrGetCentralVisayas();

foreach($getCentralVisayas as $getVisayas){
   
   $branch_name = $getVisayas['branch_name'];
   $new_branch_name = str_replace("EMB", "", $branch_name);
$header .= <<<EOF
           <tr>
               <td style="text-align: left;">$new_branch_name</td>
   EOF;
   $total_month = 0;
   $total_walkin = 0;
   $total_array = array();
     for ($i=0; $i<$count; $i++) { 
       $year = $dateArray[$i];
       $monthFormat = date("F", strtotime($year));
       $firstDay = $year . "-01";
       $lastDay = date("Y-m-t", strtotime($year));
       $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
       foreach($getMonthlyData as $getGrossin){
           $walkin = $getGrossin['walkin'];
           $sales_rep = $getGrossin['sales_rep'];
           $returnee = $getGrossin['returnee'];
           $runners_agent = $getGrossin['runners_agent'];
           $transfer = $getGrossin['transfer'];

              // Append data for the current month into the yearlyData array
           if (!isset($yearlyData[$branch_name])) {
               $yearlyData[$branch_name] = array();
           }
           $yearlyData[$branch_name][$monthFormat] = array(
               "walkin" => $walkin,
               "sales_rep" => $sales_rep,
               "returnee" => $returnee,
               "runners_agent" => $runners_agent,
               "transfer" => $transfer
           );
       }
         // Insert data for the current month into the yearlyData array
  
     
       $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
       $total_walkin += $walkin;

$header .= <<<EOF
   <td>
       <table>
           <tr>
              <td style="border: none; color:red;">$total_month</td>
               <td>$walkin</td>
               <td>$sales_rep</td>
               <td>$returnee</td>
               <td>$runners_agent</td>
               <td style="border: none;">$transfer</td>
           </tr>
       </table>
   </td>
   EOF;
}


$header .= <<<EOF
</tr>
EOF; 

}

$header .= <<<EOF
<tr>
   <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


    for ($i=0; $i<$count; $i++) { 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
 foreach($getCentralVisayas as $getVisayas){
   $branch_name = $getVisayas['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
 }
 $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header .= <<<EOF
<td style="color: red;">
  <table>
           <tr style="font-weight: bold;">
               <td style="border: none;">$grand_totalIn</td>
               <td>$walkinTotal</td>
               <td>$sales_repTotal</td>
               <td>$returneeTotal</td>
               <td>$runners_agentTotal</td>
               <td style="border: none;">$transferTotal</td>
           </tr>
       </table>
       </td>
EOF; 
}
$header .= <<<EOF
</tr>
EOF;

$header .= <<<EOF
    <tr style="border: none;">
    <th style="border: none;"></th>
    </tr>
   <tr style="">
   <th style="text-align: left;  $branchWidth;font-weight: bold;">RLC BRANCHES</th>

EOF;
    for ($i=0; $i<$count; $i++) { 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));

   
$header .= <<<EOF
<th style="background-color:#fcf0cc;">
   <table>
       <tr>
           <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
       </tr>
    </table>
</th>
EOF;
}
$header .= <<<EOF
   </tr>  
       <tr>
           <th style="text-align: left;">BRANCHES</th>
   EOF;
   
             for ($i=0; $i<$count; $i++) { 
$header .= <<<EOF
                <th>
                <table>
                    <tr >
                        <th style="border:none;$fontSize;"> TOTAL IN</th>
                        <th style="$fontSize;"> WALKIN</th>
                        <th style="$fontSize;"> SALES REP</th>
                        <th style="$fontSize;"> RETURNEE</th>
                        <th style="$fontSize;"> RUNNERS/ AGENT</th>
                        <th style="border:none;$fontSize;"> TRANSFER</th>
                    </tr>
                </table>
                </th>
           EOF;
           }
$header .= <<<EOF
       </tr>  
   EOF;  

$getRLC= $Operation->ctrGetAllRLCBranches();

foreach($getRLC as $rlc){
   
   $branch_name = $rlc['full_name'];
   $new_branch_name = str_replace("RLC", "", $branch_name);
$header .= <<<EOF
           <tr>
               <td style="text-align: left;">$new_branch_name</td>
   EOF;
   $total_month = 0;
   $total_walkin = 0;
   $total_array = array();
     for ($i=0; $i<$count; $i++) { 
       $year = $dateArray[$i];
       $monthFormat = date("F", strtotime($year));
       $firstDay = $year . "-01";
       $lastDay = date("Y-m-t", strtotime($year));
       $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
       foreach($getMonthlyData as $getGrossin){
           $walkin = $getGrossin['walkin'];
           $sales_rep = $getGrossin['sales_rep'];
           $returnee = $getGrossin['returnee'];
           $runners_agent = $getGrossin['runners_agent'];
           $transfer = $getGrossin['transfer'];

              // Append data for the current month into the yearlyData array
           if (!isset($yearlyData[$branch_name])) {
               $yearlyData[$branch_name] = array();
           }
           $yearlyData[$branch_name][$monthFormat] = array(
               "walkin" => $walkin,
               "sales_rep" => $sales_rep,
               "returnee" => $returnee,
               "runners_agent" => $runners_agent,
               "transfer" => $transfer
           );
       }
         // Insert data for the current month into the yearlyData array
  
     
       $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
       $total_walkin += $walkin;

$header .= <<<EOF
   <td>
       <table>
           <tr>
              <td style="border: none; color:red;">$total_month</td>
               <td>$walkin</td>
               <td>$sales_rep</td>
               <td>$returnee</td>
               <td>$runners_agent</td>
               <td style="border: none;">$transfer</td>
           </tr>
       </table>
   </td>
   EOF;
}


$header .= <<<EOF
</tr>
EOF; 

}

$header .= <<<EOF
<tr>
   <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


    for ($i=0; $i<$count; $i++) { 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
 foreach($getRLC as $rlc){
   $branch_name = $rlc['full_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
 }
 $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header .= <<<EOF
<td style="color: red;">
  <table>
           <tr style="font-weight: bold;">
               <td style="border: none;">$grand_totalIn</td>
               <td>$walkinTotal</td>
               <td>$sales_repTotal</td>
               <td>$returneeTotal</td>
               <td>$runners_agentTotal</td>
               <td style="border: none;">$transferTotal</td>
           </tr>
       </table>
       </td>
EOF; 
}
$header .= <<<EOF
</tr>
EOF;

$header .= <<<EOF
    <tr style="border: none;">
    <th style="border: none;"></th>
    </tr>
   <tr style="">
   <th style="text-align: left;  $branchWidth;font-weight: bold;">MANILA BRANCHES</th>

EOF;
    for ($i=0; $i<$count; $i++) { 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));

   
$header .= <<<EOF
<th style="background-color:#fcf0cc;">
   <table>
       <tr>
           <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
       </tr>
    </table>
</th>
EOF;
}
$header .= <<<EOF
   </tr>  
       <tr>
           <th style="text-align: left;">BRANCHES</th>
   EOF;
   
             for ($i=0; $i<$count; $i++) { 
$header .= <<<EOF
                    <th>
                    <table>
                        <tr >
                            <th style="border:none;$fontSize;"> TOTAL IN</th>
                            <th style="$fontSize;"> WALKIN</th>
                            <th style="$fontSize;"> SALES REP</th>
                            <th style="$fontSize;"> RETURNEE</th>
                            <th style="$fontSize;"> RUNNERS/ AGENT</th>
                            <th style="border:none;$fontSize;"> TRANSFER</th>
                        </tr>
                    </table>
                    </th>
           EOF;
           }
$header .= <<<EOF
       </tr>  
   EOF;  

$getManila= $Operation->ctrGetManila();

foreach($getManila as $getMnl){
   
   $branch_name = $getMnl['branch_name'];
   $new_branch_name = str_replace("RLC", "", $branch_name);
$header .= <<<EOF
           <tr>
               <td style="text-align: left;">$new_branch_name</td>
   EOF;
   $total_month = 0;
   $total_walkin = 0;
   $total_array = array();
     for ($i=0; $i<$count; $i++) { 
       $year = $dateArray[$i];
       $monthFormat = date("F", strtotime($year));
       $firstDay = $year . "-01";
       $lastDay = date("Y-m-t", strtotime($year));
       $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
       foreach($getMonthlyData as $getGrossin){
           $walkin = $getGrossin['walkin'];
           $sales_rep = $getGrossin['sales_rep'];
           $returnee = $getGrossin['returnee'];
           $runners_agent = $getGrossin['runners_agent'];
           $transfer = $getGrossin['transfer'];

              // Append data for the current month into the yearlyData array
           if (!isset($yearlyData[$branch_name])) {
               $yearlyData[$branch_name] = array();
           }
           $yearlyData[$branch_name][$monthFormat] = array(
               "walkin" => $walkin,
               "sales_rep" => $sales_rep,
               "returnee" => $returnee,
               "runners_agent" => $runners_agent,
               "transfer" => $transfer
           );
       }
         // Insert data for the current month into the yearlyData array
  
     
       $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
       $total_walkin += $walkin;

$header .= <<<EOF
   <td>
       <table>
           <tr>
              <td style="border: none; color:red;">$total_month</td>
               <td>$walkin</td>
               <td>$sales_rep</td>
               <td>$returnee</td>
               <td>$runners_agent</td>
               <td style="border: none;">$transfer</td>
           </tr>
       </table>
   </td>
   EOF;
}


$header .= <<<EOF
</tr>
EOF; 

}

$header .= <<<EOF
<tr>
   <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


    for ($i=0; $i<$count; $i++) { 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
 foreach($getManila as $getMnl){
   $branch_name = $getMnl['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
 }
 $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header .= <<<EOF
<td style="color: red;">
  <table>
           <tr style="font-weight: bold;">
               <td style="border: none;">$grand_totalIn</td>
               <td>$walkinTotal</td>
               <td>$sales_repTotal</td>
               <td>$returneeTotal</td>
               <td>$runners_agentTotal</td>
               <td style="border: none;">$transferTotal</td>
           </tr>
       </table>
       </td>
EOF; 
}
$header .= <<<EOF
</tr>
   </table>
   <table style="border:none;">
   <tr style="border:none;">
        <th style="border:none;"></th>
    </tr>
    <tr style="border:none;">
        <th style="border:none; text-align:left; font-size:10px;"><br>Prepared by:</th>
    </tr>
    <tr style="border:none;">
      <th style="border:none; text-align:left; font-size:10px;">$preBy</th>
    </tr>
    </table>
EOF;

   
    $pdf->writeHTML($header, false, false, false, false, '');
    if($montRange>6){
        $totalRange = $montRange - 6;
        if($totalRange<=3){
            $addPage = "P";
            $yearWidth= "width: 200px";
            $branchWidth= "width: 110px";
            $pdfFormat ="P";
            $tableSize= "font-size:8.1rem";
            $fontSize="font-size:5.6rem";
        }else{
            $addPage = "L";
            $yearWidth=""; 
            $branchWidth= "width: 110px";
            $fontSize= "font-size:4.5rem";
            $tableSize= "font-size:6.0rem";
        }
    $pdf->AddPage($addPage);

 
    
    $header1 = <<<EOF
    <style>
            tr,th{
        border:1px solid black;
        $tableSize;
        text-align:center;
        }
            tr, td{
        border:1px solid black;
        $tableSize;
        text-align:center;
        }
</style>
<h6>MONTHLY GROSS IN BREAKDOWN<br><span style="font-size: 9px;">FOR $Fmonth</span></h6>
<table style="border:1px solid black;">
    <tr style="">
        <th style="text-align: left; $branchWidth; font-weight: bold;">NORTH NEGROS</th>

    
EOF;
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));

    
$header1 .= <<<EOF
    <th style="background-color:#fcf0cc;$yearWidth;">
        <table>
            <tr>
                <th style="border: none;font-weight: bold;" colspan="6">$yearName</th>
            </tr>
        </table>
    </th>
EOF;
}
$header1 .= <<<EOF
    </tr>  
        <tr>
            <th style="text-align: left;">BRANCHES</th>
    EOF;
    
    for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
            <th>
                <table>
                    <tr >
                        <th style="border:none;$fontSize;"> TOTAL IN</th>
                        <th style="$fontSize;"> WALKIN</th>
                        <th style="$fontSize;"> SALES REP</th>
                        <th style="$fontSize;"> RETURNEE</th>
                        <th style="$fontSize;"> RUNNERS/ AGENT</th>
                        <th style="border:none;$fontSize;"> TRANSFER</th>
                    </tr>
                </table>
            </th>
            EOF;
            }
$header1 .= <<<EOF
        </tr>  
    EOF;  

$getNorthNegros = $Operation->ctrGetNorthNegros();

foreach($getNorthNegros as $getNorth){
    
    $branch_name = $getNorth['branch_name'];
    $new_branch_name = str_replace("EMB", "", $branch_name);
$header1 .= <<<EOF
            <tr>
                <td style="text-align: left;">$new_branch_name</td>
    EOF;
    $total_month = 0;
    $total_walkin = 0;
    $total_array = array();
        for ($i=6; $i<count($dateArray); $i++){ 
        $year = $dateArray[$i];
        $monthFormat = date("F", strtotime($year));
        $firstDay = $year . "-01";
        $lastDay = date("Y-m-t", strtotime($year));
        $getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
        foreach($getMonthlyData as $getGrossin){
            $walkin = $getGrossin['walkin'];
            $sales_rep = $getGrossin['sales_rep'];
            $returnee = $getGrossin['returnee'];
            $runners_agent = $getGrossin['runners_agent'];
            $transfer = $getGrossin['transfer'];

               // Append data for the current month into the yearlyData array
            if (!isset($yearlyData[$branch_name])) {
                $yearlyData[$branch_name] = array();
            }
            $yearlyData[$branch_name][$monthFormat] = array(
                "walkin" => $walkin,
                "sales_rep" => $sales_rep,
                "returnee" => $returnee,
                "runners_agent" => $runners_agent,
                "transfer" => $transfer
            );
        }
          // Insert data for the current month into the yearlyData array
   
      
        $total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
        $total_walkin += $walkin;

$header1 .= <<<EOF
    <td>
        <table>
            <tr>
                 <td style="border: none; color:red;">$total_month</td>
                <td>$walkin</td>
                <td>$sales_rep</td>
                <td>$returnee</td>
                <td>$runners_agent</td>
                <td style="border: none;">$transfer</td>
            </tr>
        </table>
    </td>
    EOF;
}


$header1 .= <<<EOF
</tr>
EOF; 

}

$header1 .= <<<EOF
<tr>
    <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
  foreach($getNorthNegros as $getNorth){
    $branch_name = $getNorth['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
  }
  $grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
  <td style="color: red;">
   <table>
            <tr style="font-weight: bold;">
                <td style="border: none;">$grand_totalIn</td>
                <td>$walkinTotal</td>
                <td>$sales_repTotal</td>
                <td>$returneeTotal</td>
                <td>$runners_agentTotal</td>
                <td style="border: none;">$transferTotal</td>
            </tr>
        </table>
        </td>
EOF; 
}
$header1 .= <<<EOF
</tr>
  
EOF;
$header1 .= <<<EOF
        <tr style="border: none;">
            <th style="border: none;"></th>
        </tr>
        <tr>
             <th style="text-align: left;$branchWidth;font-weight: bold;">SOUTH NEGROS</th>

EOF;
            for ($i=6; $i<count($dateArray); $i++){ 
            $year = $dateArray[$i];
            $yearName = strtoupper(date("F Y", strtotime($year)));
    $header1 .= <<<EOF
        <th style="background-color:#fcf0cc;">
            <table>
                <tr>
                    <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
                </tr>
            </table>
        </th>
EOF;
    }
    $header1 .= <<<EOF
        </tr>  
    <tr>
         <th style="text-align: left;">BRANCHES</th>
EOF;

for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
        <th>
            <table>
                <tr >
                    <th style="border:none;$fontSize;"> TOTAL IN</th>
                    <th style="$fontSize;"> WALKIN</th>
                    <th style="$fontSize;"> SALES REP</th>
                    <th style="$fontSize;"> RETURNEE</th>
                    <th style="$fontSize;"> RUNNERS/ AGENT</th>
                    <th style="border:none;$fontSize;"> TRANSFER</th>
                </tr>
            </table>
        </th>
    EOF;
    }
$header1 .= <<<EOF
    </tr>  
EOF;  

$getSouthNegros = $Operation->ctrGetSouthNegros();

foreach($getSouthNegros as $getSouth){

$branch_name = $getSouth['branch_name'];
$new_branch_name = str_replace("EMB", "", $branch_name);
$header1 .= <<<EOF
    <tr>
        <td style="text-align: left;">$new_branch_name</td>
EOF;
$total_month = 0;
$total_walkin = 0;
$total_array = array();
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$firstDay = $year . "-01";
$lastDay = date("Y-m-t", strtotime($year));
$getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
foreach($getMonthlyData as $getGrossin){
    $walkin = $getGrossin['walkin'];
    $sales_rep = $getGrossin['sales_rep'];
    $returnee = $getGrossin['returnee'];
    $runners_agent = $getGrossin['runners_agent'];
    $transfer = $getGrossin['transfer'];

       // Append data for the current month into the yearlyData array
    if (!isset($yearlyData[$branch_name])) {
        $yearlyData[$branch_name] = array();
    }
    $yearlyData[$branch_name][$monthFormat] = array(
        "walkin" => $walkin,
        "sales_rep" => $sales_rep,
        "returnee" => $returnee,    
        "runners_agent" => $runners_agent,
        "transfer" => $transfer
    );
}
  // Insert data for the current month into the yearlyData array


$total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
$total_walkin += $walkin;

$header1 .= <<<EOF
    <td>
        <table>
            <tr>
                <td style="border: none; color:red;">$total_month</td>
                <td>$walkin</td>
                <td>$sales_rep</td>
                <td>$returnee</td>
                <td>$runners_agent</td>
                <td style="border: none;">$transfer</td>
            </tr>
        </table>
    </td>
EOF;
}

$header1 .= <<<EOF
    </tr>
EOF; 

}

$header1 .= <<<EOF
<tr>
    <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
foreach($getSouthNegros as $getSouth){
$branch_name = $getSouth['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
}
$grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
    <td style="color: red;">
        <table>
            <tr style="font-weight: bold;">
                <td style="border: none;">$grand_totalIn</td>
                <td>$walkinTotal</td>
                <td>$sales_repTotal</td>
                <td>$returneeTotal</td>
                <td>$runners_agentTotal</td>
                <td style="border: none;">$transferTotal</td>
            </tr>
        </table>
    </td>
EOF; 
}
$header1 .= <<<EOF
    </tr>

EOF;

$header1 .= <<<EOF
<tr style="border: none;">
<th style="border: none;"></th>
</tr>
<tr style="">
<th style="text-align: left;  $branchWidth;font-weight: bold;">PANAY</th>

EOF;
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));


$header1 .= <<<EOF
<th style="background-color:#fcf0cc;">
<table>
<tr>
<th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
</tr>
</table>
</th>
EOF;
}
$header1 .= <<<EOF
</tr>  
<tr>
<th style="text-align: left;">BRANCHES</th>
EOF;

for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
<th>
<table>
    <tr >
        <th style="border:none;$fontSize;"> TOTAL IN</th>
        <th style="$fontSize;"> WALKIN</th>
        <th style="$fontSize;"> SALES REP</th>
        <th style="$fontSize;"> RETURNEE</th>
        <th style="$fontSize;"> RUNNERS/ AGENT</th>
        <th style="border:none;$fontSize;"> TRANSFER</th>
    </tr>
</table>
</th>
EOF;
}
$header1 .= <<<EOF
</tr>  
EOF;  

$getPanayBranch = $Operation->ctrGetPanay();

foreach($getPanayBranch as $getPanay){

$branch_name = $getPanay['branch_name'];
$new_branch_name = str_replace("EMB", "", $branch_name);
$header1 .= <<<EOF
<tr>
<td style="text-align: left;">$new_branch_name</td>
EOF;
$total_month = 0;
$total_walkin = 0;
$total_array = array();
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$firstDay = $year . "-01";
$lastDay = date("Y-m-t", strtotime($year));
$getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
foreach($getMonthlyData as $getGrossin){
$walkin = $getGrossin['walkin'];
$sales_rep = $getGrossin['sales_rep'];
$returnee = $getGrossin['returnee'];
$runners_agent = $getGrossin['runners_agent'];
$transfer = $getGrossin['transfer'];

// Append data for the current month into the yearlyData array
if (!isset($yearlyData[$branch_name])) {
$yearlyData[$branch_name] = array();
}
$yearlyData[$branch_name][$monthFormat] = array(
"walkin" => $walkin,
"sales_rep" => $sales_rep,
"returnee" => $returnee,
"runners_agent" => $runners_agent,
"transfer" => $transfer
);
}
// Insert data for the current month into the yearlyData array


$total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
$total_walkin += $walkin;

$header1 .= <<<EOF
<td>
<table>
<tr>
<td style="border: none; color:red;">$total_month</td>
<td>$walkin</td>
<td>$sales_rep</td>
<td>$returnee</td>
<td>$runners_agent</td>
<td style="border: none;">$transfer</td>
</tr>
</table>
</td>
EOF;
}


$header1 .= <<<EOF
</tr>
EOF; 

}

$header1 .= <<<EOF
<tr>
<td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
foreach($getPanayBranch as $getPanay){
$branch_name = $getPanay['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
}
$grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
<td style="color: red;">
<table>
<tr style="font-weight: bold;">
<td style="border: none;">$grand_totalIn</td>
<td>$walkinTotal</td>
<td>$sales_repTotal</td>
<td>$returneeTotal</td>
<td>$runners_agentTotal</td>
<td style="border: none;">$transferTotal</td>
</tr>
</table>
</td>
EOF; 
}
$header1 .= <<<EOF
</tr>

EOF;
$header1 .= <<<EOF
<tr style="border: none;">
<th style="border: none;"></th>
</tr>
<tr style="">
<th style="text-align: left;  $branchWidth;font-weight: bold;">CENTRAL VISAYAS</th>

EOF;
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));


$header1 .= <<<EOF
<th style="background-color:#fcf0cc;">
<table>
<tr>
<th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
</tr>
</table>
</th>
EOF;
}
$header1 .= <<<EOF
</tr>  
<tr>
<th style="text-align: left;">BRANCHES</th>
EOF;

for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
<th>
<table>
    <tr >
        <th style="border:none;$fontSize;"> TOTAL IN</th>
        <th style="$fontSize;"> WALKIN</th>
        <th style="$fontSize;"> SALES REP</th>
        <th style="$fontSize;"> RETURNEE</th>
        <th style="$fontSize;"> RUNNERS/ AGENT</th>
        <th style="border:none;$fontSize;"> TRANSFER</th>
    </tr>
</table>
</th>   
EOF;
}
$header1 .= <<<EOF
</tr>  
EOF;  

$getCentralVisayas= $Operation->ctrGetCentralVisayas();

foreach($getCentralVisayas as $getVisayas){

$branch_name = $getVisayas['branch_name'];
$new_branch_name = str_replace("EMB", "", $branch_name);
$header1 .= <<<EOF
<tr>
<td style="text-align: left;">$new_branch_name</td>
EOF;
$total_month = 0;
$total_walkin = 0;
$total_array = array();
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$firstDay = $year . "-01";
$lastDay = date("Y-m-t", strtotime($year));
$getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
foreach($getMonthlyData as $getGrossin){
$walkin = $getGrossin['walkin'];
$sales_rep = $getGrossin['sales_rep'];
$returnee = $getGrossin['returnee'];
$runners_agent = $getGrossin['runners_agent'];
$transfer = $getGrossin['transfer'];

// Append data for the current month into the yearlyData array
if (!isset($yearlyData[$branch_name])) {
$yearlyData[$branch_name] = array();
}
$yearlyData[$branch_name][$monthFormat] = array(
"walkin" => $walkin,
"sales_rep" => $sales_rep,
"returnee" => $returnee,
"runners_agent" => $runners_agent,
"transfer" => $transfer
);
}
// Insert data for the current month into the yearlyData array


$total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
$total_walkin += $walkin;

$header1 .= <<<EOF
<td>
<table>
<tr>
<td style="border: none; color:red;">$total_month</td>
<td>$walkin</td>
<td>$sales_rep</td>
<td>$returnee</td>
<td>$runners_agent</td>
<td style="border: none;">$transfer</td>
</tr>
</table>
</td>
EOF;
}


$header1 .= <<<EOF
</tr>
EOF; 

}

$header1 .= <<<EOF
<tr>
<td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
foreach($getCentralVisayas as $getVisayas){
$branch_name = $getVisayas['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
}
$grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
<td style="color: red;">
<table>
<tr style="font-weight: bold;">
<td style="border: none;">$grand_totalIn</td>
<td>$walkinTotal</td>
<td>$sales_repTotal</td>
<td>$returneeTotal</td>
<td>$runners_agentTotal</td>
<td style="border: none;">$transferTotal</td>
</tr>
</table>
</td>
EOF; 
}
$header1 .= <<<EOF
</tr>
EOF;

$header1 .= <<<EOF
<tr style="border: none;">
<th style="border: none;"></th>
</tr>
<tr style="">
<th style="text-align: left;  $branchWidth;font-weight: bold;">RLC BRANCHES</th>

EOF;
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));


$header1 .= <<<EOF
<th style="background-color:#fcf0cc;">
<table>
<tr>
<th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
</tr>
</table>
</th>
EOF;
}
$header1 .= <<<EOF
</tr>  
<tr>
<th style="text-align: left;">BRANCHES</th>
EOF;

for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
<th>
<table>
    <tr >
        <th style="border:none;$fontSize;"> TOTAL IN</th>
        <th style="$fontSize;"> WALKIN</th>
        <th style="$fontSize;"> SALES REP</th>
        <th style="$fontSize;"> RETURNEE</th>
        <th style="$fontSize;"> RUNNERS/ AGENT</th>
        <th style="border:none;$fontSize;"> TRANSFER</th>
    </tr>
</table>
</th>
EOF;
}
$header1 .= <<<EOF
</tr>  
EOF;  

$getRLC= $Operation->ctrGetAllRLCBranches();

foreach($getRLC as $rlc){

$branch_name = $rlc['full_name'];
$new_branch_name = str_replace("RLC", "", $branch_name);
$header1 .= <<<EOF
<tr>
<td style="text-align: left;">$new_branch_name</td>
EOF;
$total_month = 0;
$total_walkin = 0;
$total_array = array();
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$firstDay = $year . "-01";
$lastDay = date("Y-m-t", strtotime($year));
$getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
foreach($getMonthlyData as $getGrossin){
$walkin = $getGrossin['walkin'];
$sales_rep = $getGrossin['sales_rep'];
$returnee = $getGrossin['returnee'];
$runners_agent = $getGrossin['runners_agent'];
$transfer = $getGrossin['transfer'];

// Append data for the current month into the yearlyData array
if (!isset($yearlyData[$branch_name])) {
$yearlyData[$branch_name] = array();
}
$yearlyData[$branch_name][$monthFormat] = array(
"walkin" => $walkin,
"sales_rep" => $sales_rep,
"returnee" => $returnee,
"runners_agent" => $runners_agent,
"transfer" => $transfer
);
}
// Insert data for the current month into the yearlyData array


$total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
$total_walkin += $walkin;

$header1 .= <<<EOF
<td>
<table>
<tr>
<td style="border: none; color:red;">$total_month</td>
<td>$walkin</td>
<td>$sales_rep</td>
<td>$returnee</td>
<td>$runners_agent</td>
<td style="border: none;">$transfer</td>
</tr>
</table>
</td>
EOF;
}


$header1 .= <<<EOF
</tr>
EOF; 

}

$header1 .= <<<EOF
<tr>
<td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 

for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
foreach($getRLC as $rlc){
$branch_name = $rlc['full_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
}
$grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
<td style="color: red;">
<table>
<tr style="font-weight: bold;">
<td style="border: none;">$grand_totalIn</td>
<td>$walkinTotal</td>
<td>$sales_repTotal</td>
<td>$returneeTotal</td>
<td>$runners_agentTotal</td>
<td style="border: none;">$transferTotal</td>
</tr>
</table>
</td>
EOF; 
}
$header1 .= <<<EOF
</tr>
EOF;

$header1 .= <<<EOF
<tr style="border: none;">
<th style="border: none;"></th>
</tr>
<tr style="">
<th style="text-align: left;  $branchWidth;font-weight: bold;">MANILA BRANCHES</th>

EOF;
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$yearName = strtoupper(date("F Y", strtotime($year)));


$header1 .= <<<EOF
    <th style="background-color:#fcf0cc;">
        <table>
            <tr>
            <th style="border: none; font-weight: bold;" colspan="6">$yearName</th>
            </tr>
        </table>
    </th>
EOF;
}
$header1 .= <<<EOF
</tr>  
<tr>
    <th style="text-align: left;">BRANCHES</th>
EOF;

for ($i=6; $i<count($dateArray); $i++){ 
$header1 .= <<<EOF
    <th>
        <table>
            <tr >
                <th style="border:none;$fontSize;"> TOTAL IN</th>
                <th style="$fontSize;"> WALKIN</th>
                <th style="$fontSize;"> SALES REP</th>
                <th style="$fontSize;"> RETURNEE</th>
                <th style="$fontSize;"> RUNNERS/ AGENT</th>
                <th style="border:none;$fontSize;"> TRANSFER</th>
            </tr>
        </table>
    </th>
EOF;
}
$header1 .= <<<EOF
    </tr>  
EOF;  

$getManila= $Operation->ctrGetManila();

foreach($getManila as $getMnl){

$branch_name = $getMnl['branch_name'];
$new_branch_name = str_replace("RLC", "", $branch_name);
$header1 .= <<<EOF
<tr>
<td style="text-align: left;">$new_branch_name</td>
EOF;
$total_month = 0;
$total_walkin = 0;
$total_array = array();
for ($i=6; $i<count($dateArray); $i++){ 
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$firstDay = $year . "-01";
$lastDay = date("Y-m-t", strtotime($year));
$getMonthlyData = $Operation->ctrGetGrossinMonthlyData($branch_name, $firstDay, $lastDay);
foreach($getMonthlyData as $getGrossin){
$walkin = $getGrossin['walkin'];
$sales_rep = $getGrossin['sales_rep'];
$returnee = $getGrossin['returnee'];
$runners_agent = $getGrossin['runners_agent'];
$transfer = $getGrossin['transfer'];

// Append data for the current month into the yearlyData array
if (!isset($yearlyData[$branch_name])) {
$yearlyData[$branch_name] = array();
}
$yearlyData[$branch_name][$monthFormat] = array(
"walkin" => $walkin,
"sales_rep" => $sales_rep,
"returnee" => $returnee,
"runners_agent" => $runners_agent,
"transfer" => $transfer
);
}
// Insert data for the current month into the yearlyData array


$total_month = $walkin + $sales_rep + $returnee + $runners_agent + $transfer;
$total_walkin += $walkin;

$header1 .= <<<EOF
    <td>
        <table>
            <tr>
                <td style="border: none; color:red;">$total_month</td>
                <td>$walkin</td>
                <td>$sales_rep</td>
                <td>$returnee</td>
                <td>$runners_agent</td>
                <td style="border: none;">$transfer</td>
            </tr>
        </table>
    </td>
EOF;
}


$header1 .= <<<EOF
</tr>
EOF; 

}

$header1 .= <<<EOF
    <tr>
        <td style="text-align: left; font-weight: bold;">TOTAL</td>
EOF; 


for ($i=6; $i<count($dateArray); $i++){ 
//    $total_walkin = $total_array['July']['total_walkin'];
$year = $dateArray[$i];
$monthFormat = date("F", strtotime($year));
$walkinTotal = 0;
$sales_repTotal = 0;
$returneeTotal = 0;
$runners_agentTotal = 0;
$transferTotal = 0;
foreach($getManila as $getMnl){
$branch_name = $getMnl['branch_name'];
$grand_totalWalkin = $yearlyData[$branch_name][$monthFormat]['walkin'];
$grand_totalSales = $yearlyData[$branch_name][$monthFormat]['sales_rep'];
$grand_totalReturnee = $yearlyData[$branch_name][$monthFormat]['returnee'];
$grand_totalRunners = $yearlyData[$branch_name][$monthFormat]['runners_agent'];
$grand_totalTransfer = $yearlyData[$branch_name][$monthFormat]['transfer'];

$walkinTotal +=$grand_totalWalkin;
$sales_repTotal +=$grand_totalSales;
$returneeTotal +=$grand_totalReturnee;
$runners_agentTotal +=$grand_totalRunners;
$transferTotal +=$grand_totalTransfer;
}
$grand_totalIn = $walkinTotal + $sales_repTotal + $returneeTotal + $runners_agentTotal + $transferTotal;

$header1 .= <<<EOF
        <td style="color: red;">
            <table>
                <tr style="font-weight: bold;">
                    <td style="border: none;">$grand_totalIn</td>
                    <td>$walkinTotal</td>
                    <td>$sales_repTotal</td>
                    <td>$returneeTotal</td>
                    <td>$runners_agentTotal</td>
                    <td style="border: none;">$transferTotal</td>
                </tr>
            </table>
        </td>
EOF; 
}
$header1 .= <<<EOF
    </tr>
</table>
<table style="border:none;">
    <tr style="border:none;">
        <th style="border:none;"></th>
    </tr>
    <tr style="border:none;">
        <th style="border:none; text-align:left; font-size:10px;"><br>Prepared by:</th>
    </tr>
    <tr style="border:none;">
        <th style="border:none; text-align:left; font-size:10px;">$preBy</th>
    </tr>
</table>
EOF;




$pdf->writeHTML($header1, false, false, false, false, '');

    
}

    $pdf->Output($reportName, 'I');

    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>
