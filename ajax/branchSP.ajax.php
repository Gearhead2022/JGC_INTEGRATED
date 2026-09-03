<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";
$filterSummary= new reportTable();
$filterSummary -> showSalesPerformanceByBranch();

class reportTable{
	public function showSalesPerformanceByBranch(){

        $branch_name_session = $_SESSION['branch_name'];
 
		$monthEnd = $_GET['monthEnd'];

        $check = (new ControllerPensioner)->ctrSalesPerformanceByBranch($branch_name_session, $monthEnd);

		$item1['card'] ='';

		$previousBranchName = '';

        foreach ($check as &$item1) {

			$currentBranchName = $item1['branch_name']; // Get the current branch name

			 // Update the previous branch name
                        
			// Compare the current branch name with the previous one
			if ($currentBranchName == $previousBranchName) {

				$branch_name = $item1['branch_name'];

				$branch_cum_net = '';

				// $percentage = ($branch_cum_net / $item1['annual_target']) * 100;

				$branch_net = '';

				$sales_rep = $item1['sales_rep'];
				$begBal =  '';
				$begBal1 = '';
				$begBal2 = '';
				$gross_in = '';
				$agents_in = '';
				$annual_target = '';

				$yearly_gross_in = '';
				$branch_net_format_display = '';

				$branch_cum_net_format_display = '';

				
				$branch_percent_target_format = '';
			

			}else{

				$branch_name = $item1['branch_name'];

				$branch_cum_net = $item1['begBal2'] - $item1['begBal'];

				// $percentage = ($branch_cum_net / $item1['annual_target']) * 100;

				$branch_net = $item1['begBal2'] - $item1['begBal1'];

				$sales_rep = $item1['sales_rep'];
				$begBal =  $item1['begBal'];
				$begBal1 = $item1['begBal1'];
				$begBal2 = $item1['begBal2'];
				$gross_in = $item1['gross_in'];
				$agents_in = $item1['agents_in'];
				$annual_target = $item1['annual_target'];

				$yearly_gross_in = $item1['yearly_gross_in'];

				$branch_net_format_display = ($branch_net >= 0)? $branch_net : "(".abs($branch_net).")";

				$branch_cum_net_format_display = ($branch_cum_net >= 0)? $branch_cum_net : "(".abs($branch_cum_net).")";

				if ($branch_cum_net >= 0) {
					if ($branch_cum_net > 0 && $annual_target > 0 || $annual_target > 0) {
					
						$branch_percent_target = $branch_cum_net / $annual_target;
						$branch_percent_target_format = round($branch_percent_target, 2) * 100 . '%';

					} else{
						$branch_percent_target_format = 0;
					}
				} else {

					if ($branch_cum_net > 0 && $annual_target > 0 || $annual_target > 0) {
					
						$branch_percent_target = $branch_cum_net / $annual_target;
						$branch_percent_target_format = '('.abs(round($branch_percent_target, 0)).')';

					} else{
						$branch_percent_target_format = 0;
					}
					
				}
			}

			$previousBranchName = $currentBranchName;

            $item1['card'] ='
            <tr>
                <td class="text-right border-bottom-0">'.$branch_name.'</td>
                <td class="text-right">'.$sales_rep.'</td>
                <td class="text-right">'.$begBal.'</td>
                <td class="text-right">'.$begBal1.'</td>
                <td class="text-right">'.$begBal2.'</td>
				<td class="text-right">'.$gross_in.'</td>
                <td class="text-right">'.$agents_in.'</td>
				<td class="text-right">'.$yearly_gross_in.'</td>
                <td class="text-right">'.$branch_net_format_display.'</td>
                <td class="text-right">'.$branch_cum_net_format_display.'</td>
				<td class="text-right">'.$branch_percent_target_format.'</td>
				<td class="text-right">'.$annual_target.'</td>
            </tr>
            ';

        }
        

        echo json_encode($check);

	}
	
	
}