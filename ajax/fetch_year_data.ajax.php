<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$filterSummary= new reportTable();
$filterSummary -> showDataFromSelectedDate();

class reportTable{
	public function showDataFromSelectedDate(){

        if (isset($_POST['year'])) {

            $year = $_POST['year'];

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
    
            $data = array("prev_year_dec"=>$prev_year_dec,
                            "cur_year_jan"=>$cur_year_jan,
                            "cur_year_feb"=>$cur_year_feb,
                            "cur_year_mar"=>$cur_year_mar,
                            "cur_year_apr"=>$cur_year_apr,
                            "cur_year_may"=>$cur_year_may,
                            "cur_year_jun"=>$cur_year_jun,
                            "cur_year_jul"=>$cur_year_jul,
                            "cur_year_aug"=>$cur_year_aug,
                            "cur_year_sep"=>$cur_year_sep,
                            "cur_year_oct"=>$cur_year_oct,
                            "cur_year_nov"=>$cur_year_nov,
                            "cur_year_dec"=>$cur_year_dec);
                    

            echo json_encode($data);


        }
        

       

	}
	
	
}