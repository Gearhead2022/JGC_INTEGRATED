<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";
require_once "../../../controllers/operation.controller.php";
require_once "../../../models/operation.model.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    
  require_once('tcpdf_include.php');
  $mntTo = $_GET['mntTo'];
  $montRange = date("m", strtotime($mntTo));
  if($montRange <= 7){
    $format = "P";
  }else{
    $format = "L";
  }

//   $pdf = new TCPDF('L', PDF_UN IT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf = new TCPDF($format, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetMargins(7,6);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

$Fmonth =  date("M", strtotime($dateArray[0])) . " - " . date("M Y", strtotime($mntTo));
$dateNow = date("Y-m-d");

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
        font-size:7.5rem;
        text-align:center;
    }
    tr, td{
        border:1px solid black;
        font-size:7.5rem;
        text-align:center;
    }
</style>
<h4>EMB, FCH, RLC, & ELC <span style="text-align:center; font-style:italic; padding-left: 50px;"> "RETURNEE RATE"</span> <br><span style="font-size: 8.5rem;">Fully Paid & Returnee For ($Fmonth)</span></h4>
<table>
<tr style="border: none;">
    <th style="text-align: left; width: 100px; font-weight: bold;border: none;"></th>
EOF;

for ($i=0; $i <count($dateArray) ; $i++) { 
    $year = $dateArray[$i];
    $yearName = strtoupper(date("M Y", strtotime($year)));
                    
    $header .= <<<EOF
    <th style="border: none;">
        <table style="border: none;">
            <tr >
                <th style="border: none;font-weight: bold;">$yearName</th>
            </tr>
        </table>
    </th>
EOF;
}
$header .= <<<EOF
</tr>  
<tr>
    <th style="text-align: center; font-weight: bold; width:100px">BRANCH</th>
EOF;

for ($i=0; $i <count($dateArray) ; $i++) { 
    $header .= <<<EOF
    <th>
        <table>
            <tr>
                <th style="border:none; font-weight: bold; font-size: 6.5rem;">RETURNEE</th>
            </tr>
        </table>
    </th>
EOF;
}


$header .= <<<EOF
</tr>  
<tr>
    <th style="text-align: left; width:100px;"></th>
EOF;

for ($i=0; $i <count($dateArray) ; $i++) { 
    $header .= <<<EOF
    <th style="">
        <table style="">
            <tr>
                <th style="border:none">70 y/o &<span style="font-family: dejavusans;">↓</span></th>
                
                <th style="$width">71 y/o &<span style="font-family: dejavusans;">↑</span></th>
            </tr>
        </table>
    </th>
EOF;
}

$header .= <<<EOF
        </tr> 
            <tr>
                <th style="border:none; text-align:left; font-weight:bold;">EMB:</th>
            </tr> 

    EOF;

    $getEMBBRanch = $Operation->ctrGetAllEMBBranches();
    foreach($getEMBBRanch as $emb){
        $branch_name = $emb['full_name'];
        $new_branch_name = str_replace("EMB", "", $branch_name);
    $header .= <<<EOF
                <tr>
                    <td style="text-align: left;">$new_branch_name</td>
               
        EOF;
        for ($i=0; $i <count($dateArray) ; $i++) { 
                 $year = $dateArray[$i];
                 $monthFormat = date("F", strtotime($year));

                 $firstDay = $year . "-01";
                 $lastDay = date("Y-m-t", strtotime($year));
                $getReturnee = $Operation->crtGetAllReturnee($branch_name, $firstDay, $lastDay);
                $below70 = 0;
                $above71 = 0;
                    foreach($getReturnee as $returnee){
                        $birth = $returnee['birth_date'];
                        $age = (new DateTime($birth))->diff(new DateTime())->y;
                        if($age <= 70){
                            $below70 = $below70 + 1;
                        }elseif($age >= 71){
                            $above71 = $above71 + 1;
                        }
                    }
                    if (!isset($yearlyData[$branch_name])) {
                        $yearlyData[$branch_name] = array();
                    }
                    $yearlyData[$branch_name][$monthFormat] = array(
                        "below70" => $below70,
                        "above71" => $above71
                    );
                
             
                $header .= <<<EOF
               
                    <th style="text-align: left;">
                        <table>
                            <tr>
                                <td style="border:none;">$below70</td>
                                <td style="$width">$above71</td>
                            </tr>
                        </table>
                    </th>
                
        EOF;

        }
        $header .= <<<EOF
        </tr>
        EOF;

    }   

    $header .= <<<EOF
            <tr style="font-weight:bold;">
                <td style="text-align: center;">TOTAL</td>
            EOF;
            for ($i=0; $i <count($dateArray) ; $i++) { 
                $year = $dateArray[$i];
                $monthFormat = date("F", strtotime($year));
                $below70Total = 0;
                $above71Total = 0;
                foreach($getEMBBRanch as $emb){
                    $branch_name = $emb['full_name'];
                $grand_totalBelow70 = $yearlyData[$branch_name][$monthFormat]['below70'];
                $grand_totalAbove71 = $yearlyData[$branch_name][$monthFormat]['above71'];
    

                $below70Total +=$grand_totalBelow70;
                $above71Total +=$grand_totalAbove71;
              
                  }

            $header .= <<<EOF
                 <th style="text-align: left;">
                    <table>
                        <tr style="font-weight: bold;">
                            <td style="border:none;text-align:center;">$below70Total</td>
                            <td style="$width">$above71Total</td>
                        </tr>
                    </table>
                </th>
                EOF; 
            }
        $header .= <<<EOF
            </tr>
             
            EOF;
    $getFCHBRanch = $Operation->ctrGetAllFCHBranches();
    foreach($getFCHBRanch as $fch){
        $branch_name = $fch['full_name'];
        $new_branch_name = str_replace("EMB", "", $branch_name);
    $header .= <<<EOF
                <tr>
                    <td style="text-align: left;"> $new_branch_name</td>
               
        EOF;
        for ($i=0; $i <count($dateArray) ; $i++) { 
                 $year = $dateArray[$i];
                 $monthFormat = date("F", strtotime($year));

                 $firstDay = $year . "-01";
                 $lastDay = date("Y-m-t", strtotime($year));
                $getReturnee = $Operation->crtGetAllReturnee($branch_name, $firstDay, $lastDay);
                $below70 = 0;
                $above71 = 0;
                    foreach($getReturnee as $returnee){
                        $birth = $returnee['birth_date'];
                        $age = (new DateTime($birth))->diff(new DateTime())->y;
                        if($age <= 70){
                            $below70 = $below70 + 1;
                        }elseif($age >= 71){
                            $above71 = $above71 + 1;
                        }
                    }
                    if (!isset($yearlyData[$branch_name])) {
                        $yearlyData[$branch_name] = array();
                    }
                    $yearlyData[$branch_name][$monthFormat] = array(
                        "below70" => $below70,
                        "above71" => $above71
                    );
                
             
                $header .= <<<EOF
               
                    <th>
                        <table>
                            <tr>
                                <td style="border:none;">$below70</td>
                                <td style="border-left:none;$width">$above71</td>
                            </tr>
                        </table>
                  </th>
                
        EOF;

        }
        $header .= <<<EOF
        </tr>
        EOF;

    }   

    $header .= <<<EOF
            <tr style="font-weight:bold;">
                <td style="text-align: center;">TOTAL</td>
            EOF;
            for ($i=0; $i <count($dateArray) ; $i++) { 
                $year = $dateArray[$i];
                $monthFormat = date("F", strtotime($year));
                $below70Total = 0;
                $above71Total = 0;
                foreach($getFCHBRanch as $fch){
                    $branch_name = $fch['full_name'];
                $grand_totalBelow70 = $yearlyData[$branch_name][$monthFormat]['below70'];
                $grand_totalAbove71 = $yearlyData[$branch_name][$monthFormat]['above71'];
    

                $below70Total +=$grand_totalBelow70;
                $above71Total +=$grand_totalAbove71;
              
                  }

            $header .= <<<EOF
                <td>
                    <table>
                        <tr style="font-weight: bold;">
                            <td style="border:none;">$below70Total</td>
                            <td style="$width">$above71Total</td>
                        </tr>
                    </table>
                </td>
                EOF; 
            }
        $header .= <<<EOF
            </tr>
               
            EOF;

            $getRLCBranch = $Operation->ctrGetAllRLCBranches();
            foreach($getRLCBranch as $rlc){
                $branch_name = $rlc['full_name'];
                $new_branch_name = str_replace("EMB", "", $branch_name);
            $header .= <<<EOF
                        <tr>
                            <td style="text-align: left;"> $new_branch_name</td>
                       
                EOF;
                for ($i=0; $i <count($dateArray) ; $i++) { 
                         $year = $dateArray[$i];
                         $monthFormat = date("F", strtotime($year));
        
                         $firstDay = $year . "-01";
                         $lastDay = date("Y-m-t", strtotime($year));
                        $getReturnee = $Operation->crtGetAllReturnee($branch_name, $firstDay, $lastDay);
                        $below70 = 0;
                        $above71 = 0;
                            foreach($getReturnee as $returnee){
                                $birth = $returnee['birth_date'];
                                $age = (new DateTime($birth))->diff(new DateTime())->y;
                                if($age <= 70){
                                    $below70 = $below70 + 1;
                                }elseif($age >= 71){
                                    $above71 = $above71 + 1;
                                }
                            }
                            if (!isset($yearlyData[$branch_name])) {
                                $yearlyData[$branch_name] = array();
                            }
                            $yearlyData[$branch_name][$monthFormat] = array(
                                "below70" => $below70,
                                "above71" => $above71
                            );
                        
                     
                        $header .= <<<EOF
                       
                            <th>
                                <table>
                                    <tr>
                                        <td style="border:none;">$below70</td>
                                        <td style="border-left:none;$width">$above71</td>
                                    </tr>
                                </table>
                          </th>
                        
                EOF;
        
                }
                $header .= <<<EOF
                </tr>
                EOF;
        
            }   
        
            $header .= <<<EOF
                    <tr style="font-weight:bold;">
                        <td style="text-align: center;">TOTAL</td>
                    EOF;
                    for ($i=0; $i <count($dateArray) ; $i++) { 
                        $year = $dateArray[$i];
                        $monthFormat = date("F", strtotime($year));
                        $below70Total = 0;
                        $above71Total = 0;
                        foreach($getRLCBranch as $rlc){
                            $branch_name = $rlc['full_name'];
                        $grand_totalBelow70 = $yearlyData[$branch_name][$monthFormat]['below70'];
                        $grand_totalAbove71 = $yearlyData[$branch_name][$monthFormat]['above71'];
            
        
                        $below70Total +=$grand_totalBelow70;
                        $above71Total +=$grand_totalAbove71;
                      
                          }
        
                    $header .= <<<EOF
                        <td>
                            <table>
                                <tr style="font-weight: bold;">
                                    <td style="border:none;">$below70Total</td>
                                    <td style="$width">$above71Total</td>
                                </tr>
                            </table>
                        </td>
                        EOF; 
                    }
                $header .= <<<EOF
                    </tr>
                       
                    EOF;
                    $getELCBranch = $Operation->ctrGetAllELCBranches();
                    foreach($getELCBranch as $elc){
                        $branch_name = $elc['full_name'];
                        $new_branch_name = str_replace("EMB", "", $branch_name);
                    $header .= <<<EOF
                                <tr>
                                    <td style="text-align: left;"> $new_branch_name</td>
                               
                        EOF;
                        for ($i=0; $i <count($dateArray) ; $i++) { 
                                 $year = $dateArray[$i];
                                 $monthFormat = date("F", strtotime($year));
                
                                 $firstDay = $year . "-01";
                                 $lastDay = date("Y-m-t", strtotime($year));
                                $getReturnee = $Operation->crtGetAllReturnee($branch_name, $firstDay, $lastDay);
                                $below70 = 0;
                                $above71 = 0;
                                    foreach($getReturnee as $returnee){
                                        $birth = $returnee['birth_date'];
                                        $age = (new DateTime($birth))->diff(new DateTime())->y;
                                        if($age <= 70){
                                            $below70 = $below70 + 1;
                                        }elseif($age >= 71){
                                            $above71 = $above71 + 1;
                                        }
                                    }
                                    if (!isset($yearlyData[$branch_name])) {
                                        $yearlyData[$branch_name] = array();
                                    }
                                    $yearlyData[$branch_name][$monthFormat] = array(
                                        "below70" => $below70,
                                        "above71" => $above71
                                    );
                                
                             
                                $header .= <<<EOF
                               
                                    <th>
                                        <table>
                                            <tr>
                                                <td style="border:none;">$below70</td>
                                                <td style="border-left:none;$width">$above71</td>
                                            </tr>
                                        </table>
                                  </th>
                                
                        EOF;
                
                        }
                        $header .= <<<EOF
                        </tr>
                        EOF;
                
                    }   
                
                    $header .= <<<EOF
                            <tr style="font-weight:bold;">
                                <td style="text-align: center;">TOTAL</td>
                            EOF;
                            for ($i=0; $i <count($dateArray) ; $i++) { 
                                $year = $dateArray[$i];
                                $monthFormat = date("F", strtotime($year));
                                $below70Total = 0;
                                $above71Total = 0;
                                foreach($getELCBranch as $elc){
                                    $branch_name = $elc['full_name'];
                                $grand_totalBelow70 = $yearlyData[$branch_name][$monthFormat]['below70'];
                                $grand_totalAbove71 = $yearlyData[$branch_name][$monthFormat]['above71'];
                    
                
                                $below70Total +=$grand_totalBelow70;
                                $above71Total +=$grand_totalAbove71;
                              
                                  }
                
                            $header .= <<<EOF
                                <td>
                                    <table>
                                        <tr style="font-weight: bold;">
                                            <td style="border:none;">$below70Total</td>
                                            <td style="$width">$above71Total</td>
                                        </tr>
                                    </table>
                                </td>
                                EOF; 
                            }
                        $header .= <<<EOF
                            </tr>
                                <tr style="border:none;">
                                    <th style="border:none; text-align:left; font-size:10px;"><br>Prepared by:</th>
                                </tr>
                                <tr style="border:none;">
                                     <th style="border:none; text-align:left; font-size:10px;" colspan="12">$preBy</th>
                                </tr>
                                </table>
                              
                            EOF;

$pdf->writeHTML($header, false, false, false, false, '');
$pdf->Output($reportName, 'I');
}
}  

$clientsFormRequest = new printClientList();
$clientsFormRequest -> getClientsPrinting();

?>
