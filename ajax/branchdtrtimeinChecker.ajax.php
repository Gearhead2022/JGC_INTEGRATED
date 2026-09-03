<?php
require_once "../controllers/dtr.controller.php";
require_once "../models/dtr.model.php";
require_once "../views/modules/session.php";

require_once "../controllers/operation.controller.php";
require_once "../models/operation.model.php";

require_once "../views/modules/fernet.php";

$filterDTR= new reportTable();

$filterDTR -> showFilter();

class reportTable{

	public function showFilter(){
 
        $check_time_in_entry_date = $_GET['check_time_in_entry_date'];

        // echo $check_time_in_entry_date;

        $remove_prev_data = (new ModelDTR)->mdlDeleteAllContents();

        $data = (new ControllerOperation)->ctrShowBranches();

        foreach ($data as &$item) {

            $branch_name = $item['branch_name'];

            $get_data = (new ModelDTR)->mdlGetDailyTimeInDTRExist($branch_name, $check_time_in_entry_date);

            foreach ($get_data as &$item) {

                $id = $item['id'];
                $branch_name = $item['branch_name'];
                $entry_date = $item['entry_date'];
                $entry_file = $item['entry_file'];

                $monthFolder = date('Y-M-d', strtotime($entry_date));

                // echo $monthFolder
                // Your encryption password (replace with your actual password)
                $encryption_password = '-qSaMATH3hnZqbD-DHPkQD9lXsxU59OOZZr7rfgSNbw=';
        
                // Assuming trydecrypt.php is inside the modules directory
                $moduleDirectory = __DIR__;
                $encrypted_file_path = realpath($moduleDirectory . "../../views/files/branchtimeindtr/$branch_name/$monthFolder/$entry_file");
        
                // Check if the path is not empty before proceeding
                if (empty($encrypted_file_path) || !file_exists($encrypted_file_path)) {
                    die("Error: The file path is empty or the file does not exist.");
                }
        
                // Read the encrypted file content
                $encrypted_content = file_get_contents($encrypted_file_path);
        
                // Create a Fernet instance
                $fernet = new Fernet($encryption_password);
        
                // Decrypt the content
                $decrypted_content = $fernet->decode($encrypted_content);
        
                // echo $decrypted_content;
                // print_r($decrypted_content);

                $has_data = (new ModelDTR)->mdlQueryTimeIn($decrypted_content);

                if ($has_data === 'ok') {

                    $updateStatus = (new ControllerDtr)->ctrUpdateBranchTimeInDTR($id, $entry_date, $branch_name);

                }

            }

            
        }

        $data = (new ModelDTR)->mdlGetTimeInformation();
        
        $i = 1;
        
        foreach ($data as &$item) {
        
            $name = $item['name'];
            $branch_name = $item['branch_name'];
            $timein = date('h:i:s' , strtotime($item['timein']));

            if ($timein > '07:00:00') {
                $text_style = 'text-danger';
                $remarks = 'LATE';
            } else {
                $text_style = 'text-info';
                $remarks = 'ON TIME';
            }
            
            $item['card'] = '
            <tr>
                <td>' . $i . '</td>
                <td>' . $name . '</td>
                <td>' . $branch_name . '</td>
                <td class="'.$text_style.'">' . $timein . '</td>
                <td class="'.$text_style.'">' . $remarks . '</td>
            </tr>
            ';

            $i++;

        }

        echo json_encode($data);
       
    }
   
}