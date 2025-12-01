<?php

require_once "../../../controllers/pensioner.controller.php";
require_once "../../../models/pensioner.model.php";
require_once "../../../views/modules/session.php";
require_once "../../../models/connection.php";

$clientsFormRequest = new printClientList();
$clientsFormRequest -> getClientsPrinting();

class printClientList{

    public function getClientsPrinting(){

    $year = $_GET['year'];

    $connection = new connection;
    $connection->connect();

    require_once('tcpdf_include.php');

    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
    $pdf->SetHeaderMargin(10);
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

    $header = <<<EOF
    <style>
    table tr, th{
        font-size:9rem;
    }
    </style>
    <table>
    <tr>
    <th colspan="11" style="text-align:left;"></th>
    </tr>
        <tr>
            <th colspan="6" style="text-align:left;">AVAILMENTS</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align:left;">EVERY CUT OFF & END OF THE MONTH</th>
        </tr>
    </table>

    EOF; 

    $prevYear = $year - 1;

    $prev =(new ControllerPensioner)->ctrShowSelectedYear($prevYear);

    if (!empty( $prev)) {

        foreach ($prev as $key => $prevCutOff) {
            $prev_year_dec = $prevCutOff["cur_year_dec"];
        }
    } else {
        $prev_year_dec = '';
    }

    $dates =(new ControllerPensioner)->ctrShowSelectedYear($year);

    if (!empty($dates)) {
        foreach ($dates as $key => $cutOffs) {
            $cur_year_jan = $cutOffs["cur_year_jan"];
            $cur_year_feb = $cutOffs["cur_year_feb"];
            $cur_year_mar = $cutOffs["cur_year_mar"];
            $cur_year_apr = $cutOffs["cur_year_apr"];
            $cur_year_may = $cutOffs["cur_year_may"];
            $cur_year_jun = $cutOffs["cur_year_jun"];
            $cur_year_jul = $cutOffs["cur_year_jul"];
            $cur_year_aug = $cutOffs["cur_year_aug"];
            $cur_year_sep = $cutOffs["cur_year_sep"];
            $cur_year_oct = $cutOffs["cur_year_oct"];
            $cur_year_nov = $cutOffs["cur_year_nov"];
            $cur_year_dec = $cutOffs["cur_year_dec"];
            
        }
    } else {
       
        $cur_year_jan = '';
        $cur_year_feb = '';
        $cur_year_mar = '';
        $cur_year_apr = '';
        $cur_year_may = '';
        $cur_year_jun = '';
        $cur_year_jul = '';
        $cur_year_aug = '';
        $cur_year_sep = '';
        $cur_year_oct = '';
        $cur_year_nov = '';
        $cur_year_dec = '';
            
    }

    $header .= <<<EOF
        <table>
        <tr>
            <th style="width:55px;text-align:center;font-size:8px;color: black;border: 1px solid black;"> EMB BRANCHES</th> 
    EOF;
    
    $columns = array(
        'prev' => $prev_year_dec,
        'jan' => $cur_year_jan,
        'feb' => $cur_year_feb,
        'mar' => $cur_year_mar,
        'apr' => $cur_year_apr,
        'may' => $cur_year_may,
        'jun' => $cur_year_jun,
        'jul' => $cur_year_jul,
        'aug' => $cur_year_aug,
        'sep' => $cur_year_sep,
        'oct' => $cur_year_oct,
        'nov' => $cur_year_nov,
        'dec' => $cur_year_dec
    );
    
    foreach ($columns as $month => $value) {

        $day = date('d' , strtotime($value));
        $year = date('y' , strtotime($value));
        $month = date('M' , strtotime($value));

        $upper = strtoupper($month);
     
        if (!empty($value)) {
            $header .= <<<EOF
                 <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;"><span></span><br>$day-$upper</td> 
            EOF;
            $header .= <<<EOF
                <td style="width:40px;text-align:center;font-size:8px;color: black; background-color: #d5e3ba; border: 1px solid black;">MONTH END <br> $upper '$year</td>
            EOF;
        }
    
    }
    
    $header .= <<<EOF
    </tr>
    </table>
 
    EOF;

    $data_EMB = (new ControllerPensioner)->ctrGetBranches('EMB');

    foreach ($data_EMB as &$item_EMB) {

        $branch_names = $item_EMB['branch_name'];

        $sub_branch_names = substr($branch_names, 4); 

        $date = array(
            'prev' => $prev_year_dec,
            'jan' => $cur_year_jan,
            'feb' => $cur_year_feb,
            'mar' => $cur_year_mar,
            'apr' => $cur_year_apr,
            'may' => $cur_year_may,
            'jun' => $cur_year_jun,
            'jul' => $cur_year_jul,
            'aug' => $cur_year_aug,
            'sep' => $cur_year_sep,
            'oct' => $cur_year_oct,
            'nov' => $cur_year_nov,
            'dec' => $cur_year_dec
        );

        $header .= <<<EOF
            <table><tr>
            <td style="width:55px;text-align:left;font-size:6px;color: black;border: 1px solid black;">&nbsp;$sub_branch_names</td>
        EOF;
        
            foreach ($date as $month => $dates) {

            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
            $dateToCutOff = date('Y-m-d', strtotime($dates));

            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

            $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);

            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);

            if (!empty($dates)) {

                $header .= <<<EOF
                    <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount</td>
                    <td style="width:40px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount_ending</td>
                EOF;
            }

        }
        $header .= <<<EOF
            </tr>
            </table>
        EOF;
    }

         $header .= <<<EOF
                <table><tr><td style="width:55px;text-align:left;font-size: 6px;color: black;border: 1px solid black;"><strong>TOTAL:</strong></td>
            EOF;
            
                foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('EMB', $dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('EMB', $dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $header .= <<<EOF
                        <td style="width:35px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount</td>
                        <td style="width:40px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount_ending</td>
                    EOF;
                }

            }
            $header .= <<<EOF
                </tr>
                </table>
            EOF;
        

        // FCH //

        $header .= <<<EOF
            <table>
            <tr>
            <td style="width:55px;text-align:left;font-size:6px;color: black;"></td>
            EOF;

        foreach ($columns as $month => $value) {
    
            if (!empty($value)) {
                $header .= <<<EOF
                <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                EOF;
            }

        }
        $header .= <<<EOF
        </tr></table>
        EOF;



        $header .= <<<EOF
            <table>
            <tr>
                <th style="width:55px;text-align:center;font-size:8px;color: black;border: 1px solid black;">FCH BRANCHES</th> 
        EOF;
        
        $columns = array(
            'prev' => $prev_year_dec,
            'jan' => $cur_year_jan,
            'feb' => $cur_year_feb,
            'mar' => $cur_year_mar,
            'apr' => $cur_year_apr,
            'may' => $cur_year_may,
            'jun' => $cur_year_jun,
            'jul' => $cur_year_jul,
            'aug' => $cur_year_aug,
            'sep' => $cur_year_sep,
            'oct' => $cur_year_oct,
            'nov' => $cur_year_nov,
            'dec' => $cur_year_dec
        );
        
        foreach ($columns as $month => $value) {

            $day = date('d' , strtotime($value));
            $year = date('y' , strtotime($value));
            $month = date('M' , strtotime($value));
        
            $upper = strtoupper($month);
        
            if (!empty($value)) {
                $header .= <<<EOF
                    <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;"><span></span><br>$day-$upper</td> 
                EOF;
                $header .= <<<EOF
                    <td style="width:40px;text-align:center;font-size:8px;color: black; background-color: #98d6eb; border: 1px solid black;">MONTH END <br> $upper '$year</td>
                EOF;
            }
        
        }
        
        $header .= <<<EOF
            </tr>
            </table>
        EOF;
        

        $data_FCH = (new ControllerPensioner)->ctrGetBranches('FCH');

        foreach ($data_FCH as &$item_FCH) {

            $branch_names = $item_FCH['branch_name'];

            $sub_branch_names = substr($branch_names, 4); 

            $date = array(
                'prev' => $prev_year_dec,
                'jan' => $cur_year_jan,
                'feb' => $cur_year_feb,
                'mar' => $cur_year_mar,
                'apr' => $cur_year_apr,
                'may' => $cur_year_may,
                'jun' => $cur_year_jun,
                'jul' => $cur_year_jul,
                'aug' => $cur_year_aug,
                'sep' => $cur_year_sep,
                'oct' => $cur_year_oct,
                'nov' => $cur_year_nov,
                'dec' => $cur_year_dec
            );

            $header .= <<<EOF
                <table><tr>
                <td style="width:55px;text-align:left;font-size:6px;color: black;border: 1px solid black;">&nbsp;$sub_branch_names</td>
            EOF;
            
            foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $header .= <<<EOF
                        <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount</td>
                        <td style="width:40px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount_ending</td>
                    EOF;
                }

            }
            $header .= <<<EOF
                </tr>
                </table>
            EOF;
        }

        $header .= <<<EOF
        <table><tr><td style="width:55px;text-align:left;font-size: 6px;color: black;border: 1px solid black;"><strong>TOTAL:</strong></td>
        EOF;
        
            foreach ($date as $month => $dates) {

            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
            $dateToCutOff = date('Y-m-d', strtotime($dates));

            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

            $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromBeforeCutOff, $dateToCutOff);

            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromAfterCutOff, $dateEndToCutOff);

            if (!empty($dates)) {

                $header .= <<<EOF
                    <td style="width:35px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount</td>
                    <td style="width:40px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount_ending</td>
                EOF;
            }

        }
        $header .= <<<EOF
            </tr>
            </table>
        EOF;

         // RLC//

         $header .= <<<EOF
            <table>
            <tr>
            <td style="width:55px;text-align:left;font-size:6px;color: black;"></td>
         EOF;
 
        foreach ($columns as $month => $value) {
        
            if (!empty($value)) {
                $header .= <<<EOF
                    <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                    <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                EOF;
            }
    
        }
        $header .= <<<EOF
        </tr></table>
        EOF;


        $header .= <<<EOF
        <table>
        <tr>
            <th style="width:55px;text-align:center;font-size:8px;color: black;border: 1px solid black;"> RLC BRANCHES</th> 
    EOF;
    
    $columns = array(
        'prev' => $prev_year_dec,
        'jan' => $cur_year_jan,
        'feb' => $cur_year_feb,
        'mar' => $cur_year_mar,
        'apr' => $cur_year_apr,
        'may' => $cur_year_may,
        'jun' => $cur_year_jun,
        'jul' => $cur_year_jul,
        'aug' => $cur_year_aug,
        'sep' => $cur_year_sep,
        'oct' => $cur_year_oct,
        'nov' => $cur_year_nov,
        'dec' => $cur_year_dec
    );
    
    foreach ($columns as $month => $value) {

        $day = date('d' , strtotime($value));
        $year = date('y' , strtotime($value));
        $month = date('M' , strtotime($value));

        $upper = strtoupper($month);
     
        if (!empty($value)) {
            $header .= <<<EOF
                 <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;"><span></span><br>$day-$upper</td> 
            EOF;
            $header .= <<<EOF
                <td style="width:40px;text-align:center;font-size:8px;color: black; background-color:#ebccae; border: 1px solid black;">MONTH END <br> $upper '$year</td>
            EOF;
        }
    
    }
    
    $header .= <<<EOF
    </tr>
    </table>
 
    EOF;

    $data_RLC = (new ControllerPensioner)->ctrGetBranches('RLC');

    foreach ($data_RLC as &$item_RLC) {

        $branch_names = $item_RLC['branch_name'];

        $sub_branch_names = substr($branch_names, 4); 

        $date = array(
            'prev' => $prev_year_dec,
            'jan' => $cur_year_jan,
            'feb' => $cur_year_feb,
            'mar' => $cur_year_mar,
            'apr' => $cur_year_apr,
            'may' => $cur_year_may,
            'jun' => $cur_year_jun,
            'jul' => $cur_year_jul,
            'aug' => $cur_year_aug,
            'sep' => $cur_year_sep,
            'oct' => $cur_year_oct,
            'nov' => $cur_year_nov,
            'dec' => $cur_year_dec
        );
        
           $branch_name_to_rfc = preg_replace('/RLC/', 'RFC', $sub_branch_names);

        $header .= <<<EOF
            <table><tr>
            <td style="width:55px;text-align:left;font-size:6px;color: black;border: 1px solid black;">&nbsp;$branch_name_to_rfc</td>
        EOF;
        
        foreach ($date as $month => $dates) {

            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
            $dateToCutOff = date('Y-m-d', strtotime($dates));

            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

            $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);

            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);

            if (!empty($dates)) {

                $header .= <<<EOF
                    <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount</td>
                    <td style="width:40px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount_ending</td>
                EOF;
            }

        }
        $header .= <<<EOF
            </tr>
            </table>
        EOF;
        }

          $header .= <<<EOF
                <table><tr><td style="width:55px;text-align:left;font-size: 6px;color: black;border: 1px solid black;"><strong>TOTAL:</strong></td>
            EOF;
            
                foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $header .= <<<EOF
                        <td style="width:35px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount</td>
                        <td style="width:40px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount_ending</td>
                    EOF;
                }

            }
            $header .= <<<EOF
                </tr>
                </table>
            EOF;

         // ELC //

        $header .= <<<EOF
        <table>
        <tr>
        <td style="width:55px;text-align:left;font-size:6px;color: black;"></td>
        EOF;
 
        foreach ($columns as $month => $value) {
        
            if (!empty($value)) {
                $header .= <<<EOF
                    <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                    <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                EOF;
            }
    
        }
        $header .= <<<EOF
        </tr></table>
        EOF;

        $data_ELC = (new ControllerPensioner)->ctrGetBranches('ELC');

        foreach ($data_ELC as &$item_ELC) {
    
            $branch_names = $item_ELC['branch_name'];
    
            $sub_branch_names = substr($branch_names, 4); 
    
            $date = array(
                'prev' => $prev_year_dec,
                'jan' => $cur_year_jan,
                'feb' => $cur_year_feb,
                'mar' => $cur_year_mar,
                'apr' => $cur_year_apr,
                'may' => $cur_year_may,
                'jun' => $cur_year_jun,
                'jul' => $cur_year_jul,
                'aug' => $cur_year_aug,
                'sep' => $cur_year_sep,
                'oct' => $cur_year_oct,
                'nov' => $cur_year_nov,
                'dec' => $cur_year_dec
            );
    
            $header .= <<<EOF
                <table><tr>
                <th style="width:55px;text-align:center;font-size:8px;color: black;border: 1px solid black;">ELC</th> 
            EOF;
            
            foreach ($date as $month => $dates) {
    
                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));
    
                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));
    
                $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);
    
                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);
    
                if (!empty($dates)) {
    
                    $header .= <<<EOF
                        <td style="width:35px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount</td>
                        <td style="width:40px;text-align:center;font-size:8px;color: black;border: 1px solid black;">$perDateCount_ending</td>
                    EOF;
                }
    
            }
            $header .= <<<EOF
                </tr>
                </table>
            EOF;
            }

            $header .= <<<EOF
            <table>
            <tr>
            <td style="width:55px;text-align:left;font-size:6px;color: black;"></td>
            EOF;
     
            foreach ($columns as $month => $value) {
            
                if (!empty($value)) {
                    $header .= <<<EOF
                        <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                        <td style="width:40px;text-align:center;font-size:8px;color: black;"></td>
                    EOF;
                }
        
            }
            $header .= <<<EOF
            </tr></table>
            EOF;

            $header .= <<<EOF
                <table><tr><td style="width:55px;text-align:left;font-size: 7px;color: black;border: 1px solid black;"><strong>GRAND TOTAL:</strong></td>
            EOF;
            
                foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvailTotal($dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailTotal($dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $header .= <<<EOF
                        <td style="width:35px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount</td>
                        <td style="width:40px;text-align:center;font-size:8px;color: red;border: 1px solid black;">$perDateCount_ending</td>
                    EOF;
                }

            }
            $header .= <<<EOF
                </tr>
                </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
            

                </tr>             
            </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  

                    <td style="width:250px;text-align:left;font-size:8px; color: black;">Prepared by:</td>
                
                </tr>             
            </table>
            EOF;

            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;"></td>
        
                </tr>             
            </table>
            EOF;
        
            $header .= <<<EOF
            <table>
                <tr>  
                
                    <td style="width:250px;text-align:left;font-size:10px; color: black; font-weight: 50px;">GLORY MAE JUNTADO</td>

                </tr>             
            </table>
            EOF;

        

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('AVAILMENT PER CUTOFF AND END.pdf', 'I');
    
   }
  }  

?>