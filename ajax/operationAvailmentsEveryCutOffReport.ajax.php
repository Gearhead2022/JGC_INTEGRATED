<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
require_once "../models/connection.php";

$connection = new connection;
$connection->connect();

$filterDailyAvailments = new pensionerTable();
$filterDailyAvailments->showDailyAvailmentsReport();

class pensionerTable{
	public function showDailyAvailmentsReport(){
 
        $prev_year_dec = $_GET["prev_year_dec"];
        $cur_year_jan = $_GET["cur_year_jan"];
        $cur_year_feb = $_GET["cur_year_feb"];
        $cur_year_mar = $_GET["cur_year_mar"];
        $cur_year_apr = $_GET["cur_year_apr"];
        $cur_year_may = $_GET["cur_year_may"];
        $cur_year_jun = $_GET["cur_year_jun"];
        $cur_year_jul = $_GET["cur_year_jul"];
        $cur_year_aug = $_GET["cur_year_aug"];
        $cur_year_sep = $_GET["cur_year_sep"];
        $cur_year_oct = $_GET["cur_year_oct"];
        $cur_year_nov = $_GET["cur_year_nov"];
        $cur_year_dec = $_GET["cur_year_dec"];

        $data = array(
    
            'cur_year_jan' => $_GET["cur_year_jan"],
            'cur_year_feb' => $_GET["cur_year_feb"],
            'cur_year_mar' => $_GET["cur_year_mar"],
            'cur_year_apr' => $_GET["cur_year_apr"],
            'cur_year_may' => $_GET["cur_year_may"],
            'cur_year_jun' => $_GET["cur_year_jun"],
            'cur_year_jul' => $_GET["cur_year_jul"],
            'cur_year_aug' => $_GET["cur_year_aug"],
            'cur_year_sep' => $_GET["cur_year_sep"],
            'cur_year_oct' => $_GET["cur_year_oct"],
            'cur_year_nov' => $_GET["cur_year_nov"],
            'cur_year_dec' => $_GET["cur_year_dec"]
        );
        

        $year = $_GET["year"];
        // check for update and appending data//
        $check = (new ControllerPensioner)->ctrCheckToUpdate($year, $data);
        
        $item['card'] = '
        <thead>
            <tr>
                <th style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> EMB BRANCHES <br><span style="visibility:hidden;">S</span></th>';
        
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
         
            if (!empty($value)) {
                $item['card'] .= '<th id="prev" > <span style="visibility:hidden;">s</span><br>'.$day.'-'.$month.' <br><span style="visibility:hidden;">S</span></th>';
                $item['card'] .= '<th id="prev" >MONTH END <br> '.$month.'\' '.$year.'</th>';
            }
        
        }
        
        $item['card'] .= '</tr>
        </thead>
        <tbody>
        
        ';

        $data_EMB = (new ControllerPensioner)->ctrGetBranches('EMB');

        foreach ($data_EMB as &$item_EMB) {

            $branch_names = $item_EMB['branch_name'];

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

            $item['card'] .='<tr>';
            $item['card'] .='<td>'.$branch_names.'</td>';
            
                foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $item['card'] .='<td>'.$perDateCount.'</td>';
                    $item['card'] .='<td>'.$perDateCount_ending.'</td>';
                }

            }
            $item['card'] .='</tr>';
        }

        $item['card'] .='<tr>';
        $item['card'] .='<td style="background-color: black;">TOTAL: </td>';
        
            foreach ($date as $month => $dates) {

            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
            $dateToCutOff = date('Y-m-d', strtotime($dates));

            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

            $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('EMB', $dateFromBeforeCutOff, $dateToCutOff);

            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('EMB', $dateFromAfterCutOff, $dateEndToCutOff);

            if (!empty($dates)) {

                $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount.'</td>';
                $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount_ending.'</td>';
            }

        }
        $item['card'] .='</tr>';



        // FCH //

        foreach ($columns as $month => $value) {
   
            if (!empty($value)) {
                $item['card'] .= '<th></th>';         
            }

        }
        
    

        $item['card'] .= '
        <thead>
            <tr>
                <th style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> FCH BRANCHES <br><span style="visibility:hidden;">S</span></th>';
        
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
         
            if (!empty($value)) {
                $item['card'] .= '<th id="prev" > <span style="visibility:hidden;">s</span><br>'.$day.'-'.$month.' <br><span style="visibility:hidden;">S</span></th>';
                $item['card'] .= '<th id="prev" >MONTH END <br> '.$month.'\' '.$year.'</th>';
            }
        
        }
        
        $item['card'] .= '</tr>
        </thead>
        <tbody>
        
        ';
        

        $data_FCH = (new ControllerPensioner)->ctrGetBranches('FCH');

        foreach ($data_FCH as &$item_FCH) {

            $branch_names = $item_FCH['branch_name'];

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

            $item['card'] .='<tr>';
            $item['card'] .='<td>'.$branch_names.'</td>';
            
                foreach ($date as $month => $dates) {

                $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                $dateToCutOff = date('Y-m-d', strtotime($dates));

                $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

                $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);

                $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);

                if (!empty($dates)) {

                    $item['card'] .='<td>'.$perDateCount.'</td>';
                    $item['card'] .='<td>'.$perDateCount_ending.'</td>';
                }

            }
            $item['card'] .='</tr>';
        }
        $item['card'] .='<tr>';
        $item['card'] .='<td style="background-color: black;">TOTAL: </td>';
        
            foreach ($date as $month => $dates) {

            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
            $dateToCutOff = date('Y-m-d', strtotime($dates));

            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));

            $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromBeforeCutOff, $dateToCutOff);

            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('FCH', $dateFromAfterCutOff, $dateEndToCutOff);

            if (!empty($dates)) {

                $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount.'</td>';
                $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount_ending.'</td>';
            }

        }
        $item['card'] .='</tr>';


                // RLC //

                foreach ($columns as $month => $value) {
   
                    if (!empty($value)) {
                        $item['card'] .= '<th></th>';         
                    }
        
                }
                
            
        
                $item['card'] .= '
                <thead>
                    <tr>
                        <th style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> RLC BRANCHES <br><span style="visibility:hidden;">S</span></th>';
                
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
                 
                    if (!empty($value)) {
                        $item['card'] .= '<th id="prev" > <span style="visibility:hidden;">s</span><br>'.$day.'-'.$month.' <br><span style="visibility:hidden;">S</span></th>';
                        $item['card'] .= '<th id="prev" >MONTH END <br> '.$month.'\' '.$year.'</th>';
                    }
                
                }
                
                $item['card'] .= '</tr>
                </thead>
                <tbody>
                
                ';
                
        
                $data_RLC = (new ControllerPensioner)->ctrGetBranches('RLC');
        
                foreach ($data_RLC as &$item_RLC) {
        
                    $branch_names = $item_RLC['branch_name'];
        
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
        
                    $item['card'] .='<tr>';
                    $item['card'] .='<td>'.$branch_names.'</td>';
                    
                        foreach ($date as $month => $dates) {
        
                        $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                        $dateToCutOff = date('Y-m-d', strtotime($dates));
        
                        $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                        $dateEndToCutOff = date('Y-m-t' , strtotime($dates));
        
                        $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);
        
                        $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);
        
                        if (!empty($dates)) {
        
                            $item['card'] .='<td>'.$perDateCount.'</td>';
                            $item['card'] .='<td>'.$perDateCount_ending.'</td>';
                        }
        
                    }
                    $item['card'] .='</tr>';
                }

                $item['card'] .='<tr>';
                $item['card'] .='<td style="background-color: black;">TOTAL: </td>';
                
                    foreach ($date as $month => $dates) {
        
                    $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                    $dateToCutOff = date('Y-m-d', strtotime($dates));
        
                    $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                    $dateEndToCutOff = date('Y-m-t' , strtotime($dates));
        
                    $perDateCount = (new ControllerPensioner)->ctrCountAllAvailPerBranch('RLC', $dateFromBeforeCutOff, $dateToCutOff);
        
                    $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailPerBranch('RLC', $dateFromAfterCutOff, $dateEndToCutOff);
        
                    if (!empty($dates)) {
        
                        $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount.'</td>';
                        $item['card'] .='<td style="color:white;background-color: black;">'.$perDateCount_ending.'</td>';
                    }
        
                }
                $item['card'] .='</tr>';

                      // ELC //

                      foreach ($columns as $month => $value) {
   
                        if (!empty($value)) {
                            $item['card'] .= '<th></th>';         
                        }
            
                    }
                    
                
            
                    $item['card'] .= '
                    <thead>
                        <tr>
                            <th style="font-size: 12px;" rowspan="2"><span style="visibility:hidden;">s</span><br> ELC BRANCHES <br><span style="visibility:hidden;">S</span></th>';
                    
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
                     
                        if (!empty($value)) {
                            $item['card'] .= '<th id="prev" > <span style="visibility:hidden;">s</span><br>'.$day.'-'.$month.' <br><span style="visibility:hidden;">S</span></th>';
                            $item['card'] .= '<th id="prev" >MONTH END <br> '.$month.'\' '.$year.'</th>';
                        }
                    
                    }
                    
                    $item['card'] .= '</tr>
                    </thead>
                    <tbody>
                    
                    ';
                    
            
                    $data_ELC = (new ControllerPensioner)->ctrGetBranches('ELC');
            
                    foreach ($data_ELC as &$item_ELC) {
            
                        $branch_names = $item_ELC['branch_name'];
            
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
            
                        $item['card'] .='<tr>';
                        $item['card'] .='<td>'.$branch_names.'</td>';
                        
                            foreach ($date as $month => $dates) {
            
                            $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                            $dateToCutOff = date('Y-m-d', strtotime($dates));
            
                            $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                            $dateEndToCutOff = date('Y-m-t' , strtotime($dates));
            
                            $perDateCount = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromBeforeCutOff, $dateToCutOff);
            
                            $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvail($branch_names, $dateFromAfterCutOff, $dateEndToCutOff);
            
                            if (!empty($dates)) {
            
                                $item['card'] .='<td>'.$perDateCount.'</td>';
                                $item['card'] .='<td>'.$perDateCount_ending.'</td>';
                            }
            
                        }
                        $item['card'] .='</tr>';
                    }
                    foreach ($columns as $month => $value) {
   
                        if (!empty($value)) {
                            $item['card'] .= '<th></th>';         
                        }
            
                    }

                    $item['card'] .='<tr>';
                    $item['card'] .='<td style="background-color: black;">GRAND TOTAL: </td>';
                    
                        foreach ($date as $month => $dates) {
        
                        $dateFromBeforeCutOff = date('Y-m-01' , strtotime($dates));
                        $dateToCutOff = date('Y-m-d', strtotime($dates));
        
                        $dateFromAfterCutOff = date('Y-m-d' , strtotime(' +1 day' ,strtotime($dates)));
                        $dateEndToCutOff = date('Y-m-t' , strtotime($dates));
        
                        $perDateCount = (new ControllerPensioner)->ctrCountAllAvailTotal($dateFromBeforeCutOff, $dateToCutOff);
        
                        $perDateCount_ending = (new ControllerPensioner)->ctrCountAllAvailTotal($dateFromAfterCutOff, $dateEndToCutOff);
        
                        if (!empty($dates)) {
        
                            $item['card'] .='<td style="color:white; background-color: black;">'.$perDateCount.'</td>';
                            $item['card'] .='<td style="color:white; background-color: black;">'.$perDateCount_ending.'</td>';
                        }
        
                    }
                    $item['card'] .='</tr>';
                    
                
    
        echo json_encode(array("card" => $item));

       

    }
            


}

    
   
