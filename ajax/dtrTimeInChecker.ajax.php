<?php
require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";

require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";

$filterDTR= new reportTable();

$filterDTR -> showFilter();

class reportTable{
	public function showFilter(){
 
        $check_entry_date = $_GET['check_entry_date'];

        $has_data = (new ModelDTR)->mdlGetBranchDailyTimeInDTRUploadList($check_entry_date);

        if ($has_data === 'yes') {

            $i = 1;

            $data = (new ControllerOperation)->ctrShowBranches();

            foreach ($data as &$item) {

                $branch_name = $item['branch_name'];

                //Function to check if branch had been submitted a file or not
                $if_has_upload = (new ControllerDTR)->ctrGetBranchDailyTimeInDTRUploadList($branch_name, $check_entry_date);
                
                //Condition if branch had been submitted a file or not
                if ($if_has_upload === 'yes') {
                    $answer = 'DONE';
                } else {
                    $answer = 'UNDONE';
                }
                
                $item['card'] = '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $branch_name . '</td>
                    <td><i>' . $answer . '</i></td>
                </tr>
                ';

                $i++;
    
            }

            echo json_encode($data);
        
        }else {

            $i = 1;

            $data = (new ControllerOperation)->ctrShowBranches();

            foreach ($data as &$item) {

                $branch_name = $item['branch_name'];

                $item['card'] = '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $branch_name . '</td>
                    <td>UNDONE</td>
                </tr>
                ';

                $i++;
            }

            echo json_encode($data);





            //   // Adjustments for the else block
            //   $item = array(
            //     'card' => '
            //     <tr>
            //         <td></td>
            //         <td>No records found.</td>
            //         <td></td>
            //     </tr>'
            // );
            // echo json_encode(array($item));
        }
           
    }
   
}