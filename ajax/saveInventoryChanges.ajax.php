<?php
require_once "../views/modules/session.php";
require_once "../controllers/qrcode.controller.php";
require_once "../models/qrcode.model.php";
require_once "../models/connection.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


date_default_timezone_set('Asia/Manila');

class Inventory {

    public function determineCompany($branch_name) {
        // Define branch names and their corresponding company values
        $pspmi_branches = [
            "SERVIAMUS",
            "HPC",
            "SAINT TERESA",
            "DV COMPOUND",
            "NAH",
            "13TH STREET",
            "SGI",
            "PSPMI HOLDING"
        ];
        $ubuntu_branches = ["UBUNTU"];
    
        // Check if branch_name is in the PSPMI branches
        if (in_array($branch_name, $pspmi_branches)) {
            $company = "PSPMI";
        }
        // Check if branch_name is in the UBUNTU branches
        elseif (in_array($branch_name, $ubuntu_branches)) {
            $company = "UBUNTU";
        }
        // Default case: use substring of branch_name
        else {
            $company = substr($branch_name, 0, 3);
        }
    
        return $company;
    }

    public function saveInventoryChanges() {
        $item_id = $_GET['item_id'];
        $field_id = $_GET['field_id'];
        $field_value = $_GET['field_value'];
        $qty_code = $_GET['qty_code'];
    
        if (!empty($item_id) && !empty($field_id) && !empty($qty_code)) {

            $this->mdlUpdate($item_id, $field_id, $field_value, $qty_code);
        } else {
            echo "Missing required fields.";
        }
    }

    private function mdlUpdate($item_id, $field_id, $field_value, $qty_code) {
        $allowed_fields = ['date_purchased', 'item_qty', 'acq_cost', 'item_description', 'ref_no', 'est_life_mon', 'est_life_year', 'category', 'type', 'prev_acc_depr', 'acc_depr'];
    
        if (!in_array($field_id, $allowed_fields)) {
            echo "Invalid field.";
            return;
        }

        if ($field_id === "item_qty") {
    
            $this->handleItemQtyUpdate($qty_code, $field_value);

        }else if($field_id === "est_life_mon" || $field_id === "est_life_year") {

            $this->handleUpdateComputation($qty_code, $field_id, $field_value);

        }else if($field_id === "prev_acc_depr" || $field_id === "acc_depr") {

            $this->handleUpdateComputationAccum($qty_code, $field_id, $field_value);

        }else if($field_id === "date_purchased") {

            $this->handleUpdateChangeDateAquired($qty_code, $field_id, $field_value);

        }else if($field_id === "acq_cost") {

            $this->handleUpdateChangeCostAquired($qty_code, $field_id, $field_value);
        
        } else {

            $query = "UPDATE `inventory` SET $field_id = :field_value WHERE qty_code = :qty_code";
            $stmt = (new Connection)->connect()->prepare($query);
    
            $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
    
            if ($field_value === '' || $field_value === null) {
                $stmt->bindValue(":field_value", null, PDO::PARAM_NULL);
            } elseif (is_numeric($field_value) && intval($field_value) == $field_value) {
                $stmt->bindValue(":field_value", $field_value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(":field_value", $field_value, PDO::PARAM_STR);
            }
    
            if ($stmt->execute()) {
                echo "ok";
            } else {
                echo "error";
            }
            $stmt->closeCursor();
        }
    }

    private function handleUpdateChangeCostAquired($qty_code, $field_id, $field_value) {

        // Query to get the relevant data from the inventory table
        $query = "SELECT est_life_mon, est_life_year, acc_depr, prev_acc_depr, book_value, date_purchased, 
                    (SELECT COUNT(*) FROM `inventory` WHERE qty_code = :qty_code) as item_count 
                    FROM `inventory` 
                    WHERE qty_code = :qty_code 
                    LIMIT 1";
                    
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $acquired_date = $result['date_purchased'];
        $acq_cost = $field_value;
        $item_count = $result['item_count'] ?? 0;
        $est_life_mon = $result['est_life_mon'] ?? 0;
        $est_life_year = $result['est_life_year'] ?? 0;
        $prev_acc_depr = $result['prev_acc_depr'] ?? 0;

        if ($est_life_year > 0 && $est_life_year != '') {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months = ($est_life_year * 12) + $est_life_mon;
            } else {
                $total_months = ($est_life_year * 12);
            }
        } else {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months =  $est_life_mon;
            } else {
                $total_months = 0;
            }
        }

        $acquiredDateTime = new DateTime($acquired_date);
        $currentDateTime = new DateTime();
        $interval = $acquiredDateTime->diff($currentDateTime);
        $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;

        if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
            $totalMonthsSincePurchase--;
        }

        if ($totalMonthsSincePurchase >= $total_months) {

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $prev_acc_depr = 0;
                $cur_acc_depr = 0;
                $book_val = 0;
            } else {
                $prev_acc_depr = round($acq_cost - $item_count, 2);
                $cur_acc_depr = round($acq_cost - $item_count, 2);
                $book_val = $item_count;
            }

            $ffe_depr_val = 0;

        } else {

            if ($item_count > 0 && $acq_cost > 0 && $total_months > 0) {
                $ffe_depr_val = round(($acq_cost - $item_count) / $total_months, 2);
            } else {
                $ffe_depr_val = 0;
            }

            if ($prev_acc_depr == 0) {

                $prev_acc_depr = 0;
                $cur_acc_depr = $ffe_depr_val;
                $book_val = round($acq_cost - $cur_acc_depr, 2);

            } else {

                $prev_acc_depr = ($field_value != 0) ? $field_value : 0;
                $cur_acc_depr = round($prev_acc_depr + $ffe_depr_val, 2);
                $book_val = round($acq_cost - $cur_acc_depr, 2);
            }
        }

        $data = array(
            "acq_cost" => $acq_cost,
            "est_life_mon" => $est_life_mon,
            "est_life_year" => $est_life_year,
            "acc_depr" => $cur_acc_depr,
            "prev_acc_depr" => $prev_acc_depr,
            "ffe_depr" => $ffe_depr_val,
            "book_value" => $book_val
        );

        $updateQuery = "UPDATE inventory SET
                            acq_cost = :acq_cost,
                            est_life_mon = :est_life_mon,
                            est_life_year = :est_life_year,
                            acc_depr = :acc_depr,
                            ffe_depr = :ffe_depr,
                            book_value = :book_value
                        WHERE qty_code = :qty_code";
        
        $updateStmt = (new Connection)->connect()->prepare($updateQuery);
        $updateStmt->bindParam(":acq_cost", $data['acq_cost'], PDO::PARAM_STR);
        $updateStmt->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
        $updateStmt->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
        $updateStmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
        $updateStmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        
        // Execute the update query
        if ($updateStmt->execute()) {
            echo "ok";
        } else {
            echo "error";
        }
    }

    private function handleUpdateChangeDateAquired($qty_code, $field_id, $field_value) {

          $query = "SELECT est_life_mon, est_life_year, acq_cost, acc_depr, prev_acc_depr, book_value,
          (SELECT COUNT(*) FROM `inventory` WHERE qty_code = :qty_code) as item_count 
          FROM `inventory` 
          WHERE qty_code = :qty_code 
          LIMIT 1";
          
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $acquired_date = $field_value;
        $acq_cost = $result['acq_cost'] ?? 0;
        $item_count = $result['item_count'] ?? 0;
        $est_life_mon = $result['est_life_mon'] ?? 0;
        $est_life_year = $result['est_life_year'] ?? 0;
        $prev_acc_depr = $result['prev_acc_depr'] ?? 0;

        if ($est_life_year > 0 && $est_life_year != '') {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months = ($est_life_year * 12) + $est_life_mon;
            } else {
                $total_months = ($est_life_year * 12);
            }
        } else {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months =  $est_life_mon;
            } else {
                $total_months = 0;
            }
        }

        $acquiredDateTime = new DateTime($acquired_date);
        $currentDateTime = new DateTime();
        $interval = $acquiredDateTime->diff($currentDateTime);
        $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
        // echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';

        if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
            $totalMonthsSincePurchase--;
        }

        if ($totalMonthsSincePurchase >= $total_months) {

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $cur_acc_depr = 0;
                $book_val = 0;
                $new_prev_acc_depr = 0;
            } else {
                $new_prev_acc_depr = round($acq_cost - $item_count, 2);
                $cur_acc_depr = round($acq_cost - $item_count, 2);
                $book_val = $item_count;
            }

            $ffe_depr_val = 0;
        
        } else {
            if ($item_count > 0 && $acq_cost > 0 && $total_months > 0) {
                $ffe_depr_val = round(($acq_cost - $item_count) / $total_months, 2);
            } else {
                $ffe_depr_val = 0;
            }

            if ($prev_acc_depr == 0) {
                $cur_acc_depr = $ffe_depr_val;
            } else {
                $cur_acc_depr = round($prev_acc_depr + $ffe_depr_val, 2);
            }
            
            if ($acq_cost == 0 || is_null($acq_cost)) {
                $book_val = 0;
            } else {
                $book_val = $acq_cost - $cur_acc_depr;
            }
            $new_prev_acc_depr = round($ffe_depr_val * ($totalMonthsSincePurchase + 1), 2);
        }

        $date_purchased = date('Y-m-d', strtotime($acquired_date));

        $data = array(
            "acquired_date" => $date_purchased,
            "est_life_mon" => $est_life_mon,
            "est_life_year" => $est_life_year,
            "prev_acc_depr" => $new_prev_acc_depr,
            "acc_depr" => $cur_acc_depr,
            "ffe_depr" => $ffe_depr_val,
            "book_value" => $book_val
        );
    
        $updateQuery = "UPDATE inventory SET
                            date_purchased = :acquired_date,
                            est_life_mon = :est_life_mon,
                            est_life_year = :est_life_year,
                            prev_acc_depr = :prev_acc_depr,
                            acc_depr = :acc_depr,
                            ffe_depr = :ffe_depr,
                            book_value = :book_value
                        WHERE qty_code = :qty_code";
        
        $updateStmt = (new Connection)->connect()->prepare($updateQuery);
        $updateStmt->bindParam(":acquired_date", $data['acquired_date'], PDO::PARAM_STR);
        $updateStmt->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
        $updateStmt->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
        $updateStmt->bindParam(":prev_acc_depr", $data['prev_acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
        $updateStmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        
        // Execute the update query
        if ($updateStmt->execute()) {
            echo "ok";
        } else {
            echo "error";
        }
    }

    private function handleUpdateComputationAccum($qty_code, $field_id, $field_value) {
    
        // Query to get the relevant data from the inventory table
        $query = "SELECT est_life_mon, est_life_year, acq_cost, acc_depr, prev_acc_depr, book_value, date_purchased, 
                  (SELECT COUNT(*) FROM `inventory` WHERE qty_code = :qty_code) as item_count 
                  FROM `inventory` 
                  WHERE qty_code = :qty_code 
                  LIMIT 1";
                  
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extract remaining values from the result
        $acquired_date = $result['date_purchased'];
        $acq_cost = $result['acq_cost'] ?? 0;
        $item_count = $result['item_count'] ?? 0;
        $est_life_mon = $result['est_life_mon'] ?? 0;
        $est_life_year = $result['est_life_year'] ?? 0;

        if ($field_id === "acc_depr") {
            $prev_acc_depr = $result['prev_acc_depr'] ?? 0;
            $acc_depr = ($field_value != 0) ? $field_value : 0;
        } else {
            $prev_acc_depr = ($field_value != 0) ? $field_value : 0;
            $acc_depr = $result['acc_depr'] ?? 0;
        }
  
        if ($est_life_year > 0 && $est_life_year != '') {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months = ($est_life_year * 12) + $est_life_mon;
            } else {
                $total_months = ($est_life_year * 12);
            }
        } else {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months =  $est_life_mon;
            } else {
                $total_months = 0;
            }
        }

         $acquiredDateTime = new DateTime($acquired_date);
         $currentDateTime = new DateTime();
         $interval = $acquiredDateTime->diff($currentDateTime);
         $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
 
         if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
             $totalMonthsSincePurchase--;
         }

         if ($totalMonthsSincePurchase >= $total_months) {

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $cur_acc_depr = 0;
                $book_val = 0;
            } else {
                $cur_acc_depr = round($acq_cost - $item_count);
                $book_val = $item_count;
            }

            $ffe_depr_val = 0;

         } else {

            if ($item_count > 0 && $acq_cost > 0 && $total_months > 0) {
                $ffe_depr_val = round(($acq_cost - $item_count) / $total_months, 2);
            } else {
                $ffe_depr_val = 0;
            }

            if ($prev_acc_depr == 0) {

                $prev_acc_depr = 0;
                $cur_acc_depr = $ffe_depr_val;
                $book_val = $acq_cost - $cur_acc_depr;

            } else {

                if ($field_id === "acc_depr") {
                    $cur_acc_depr = $acc_depr;
                    $book_val = round($acq_cost - $cur_acc_depr, 2);
                } else {
                    $prev_acc_depr = ($field_value != 0) ? $field_value : 0;
                    $cur_acc_depr = round($prev_acc_depr + $ffe_depr_val, 2);
                    $book_val = round($acq_cost - $acc_depr, 2);
                }
            }
            
         }
 
         $data = array(
             "est_life_mon" => $est_life_mon,
             "est_life_year" => $est_life_year,
             "acc_depr" => $cur_acc_depr,
             "prev_acc_depr" => $prev_acc_depr,
             "ffe_depr" => $ffe_depr_val,
             "book_value" => $book_val
         );
     
         $updateQuery = "UPDATE inventory SET
                             est_life_mon = :est_life_mon,
                             est_life_year = :est_life_year,
                             acc_depr = :acc_depr,
                             prev_acc_depr = :prev_acc_depr,
                             ffe_depr = :ffe_depr,
                             book_value = :book_value
                         WHERE qty_code = :qty_code";
         
         $updateStmt = (new Connection)->connect()->prepare($updateQuery);
         $updateStmt->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
         $updateStmt->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
         $updateStmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
         $updateStmt->bindParam(":prev_acc_depr", $data['prev_acc_depr'], PDO::PARAM_STR);
         $updateStmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
         $updateStmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
         $updateStmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
         
         // Execute the update query
         if ($updateStmt->execute()) {
             echo "ok";
         } else {
             echo "error";
         }
    }

    private function handleUpdateComputation($qty_code, $field_id, $field_value) {
    
        // Query to get the relevant data from the inventory table
        $query = "SELECT est_life_mon, est_life_year, acq_cost, prev_acc_depr, book_value, date_purchased,
                  (SELECT COUNT(*) FROM `inventory` WHERE qty_code = :qty_code) as item_count 
                  FROM `inventory` 
                  WHERE qty_code = :qty_code 
                  LIMIT 1";
                  
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($field_id === "est_life_year") {
            $est_life_mon = $result['est_life_mon'] ?? 0;
            $est_life_year = ($field_value != 0) ? $field_value : 0;
        } else {
            $est_life_mon = ($field_value != 0) ? $field_value : 0;
            $est_life_year = $result['est_life_year'] ?? 0;
        }

        $acquired_date = $result['date_purchased'];
        $acq_cost = $result['acq_cost'] ?? 0;
        $item_count = $result['item_count'] ?? 0;
        $prev_acc_depr = $result['prev_acc_depr'] ?? 0;
    
        if ($est_life_year > 0 && $est_life_year != '') {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months = ($est_life_year * 12) + $est_life_mon;
            } else {
                $total_months = ($est_life_year * 12);
            }
        } else {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months =  $est_life_mon;
            } else {
                $total_months = 0;
            }
        }

        $acquiredDateTime = new DateTime($acquired_date);
        $currentDateTime = new DateTime();
        $interval = $acquiredDateTime->diff($currentDateTime);
        $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;

        if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
            $totalMonthsSincePurchase--;
        }

        if ($totalMonthsSincePurchase >= $total_months) {

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $book_val = 0;
                $cur_acc_depr = 0;
                $new_prev_acc_depr = 0;
            } else {
                $book_val = $item_count;
                $cur_acc_depr = round($acq_cost - $item_count, 2);
                $new_prev_acc_depr = round($acq_cost - $item_count, 2);
            }

            $ffe_depr_val = 0;

        } else {

            if ($item_count > 0 && $acq_cost > 0 && $total_months > 0) {
                $ffe_depr_val = round(($acq_cost - $item_count) / $total_months, 2);
            } else {
                $ffe_depr_val = 0;
            }

            if ($prev_acc_depr == 0) {
                $cur_acc_depr = $ffe_depr_val;
            } else {
                $cur_acc_depr = round($prev_acc_depr + $ffe_depr_val, 2);
            }
            
            if ($acq_cost == 0 || is_null($acq_cost)) {
                $book_val = 0;
            } else {
                $book_val = round($acq_cost - $cur_acc_depr, 2);
            }

            $new_prev_acc_depr = $prev_acc_depr;
        }

        $data = array(
            "est_life_mon" => $est_life_mon,
            "est_life_year" => $est_life_year,
            "prev_acc_depr" => $new_prev_acc_depr,
            "acc_depr" => $cur_acc_depr,
            "ffe_depr" => $ffe_depr_val,
            "book_value" => $book_val
        );

        $updateQuery = "UPDATE inventory SET
                            est_life_mon = :est_life_mon,
                            est_life_year = :est_life_year,
                            prev_acc_depr = :prev_acc_depr,
                            acc_depr = :acc_depr,
                            ffe_depr = :ffe_depr,
                            book_value = :book_value
                        WHERE qty_code = :qty_code";
        
        $updateStmt = (new Connection)->connect()->prepare($updateQuery);
        $updateStmt->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
        $updateStmt->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
        $updateStmt->bindParam(":prev_acc_depr", $data['prev_acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
        $updateStmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);

        if ($updateStmt->execute()) {
            echo "ok";
        } else {
            echo "error";
        }
    }
    
    private function handleItemQtyUpdate($qty_code, $new_qty) {
        $query = "SELECT *, (SELECT COUNT(*) FROM `inventory` WHERE qty_code = :qty_code) as item_count FROM `inventory` WHERE qty_code = :qty_code ORDER BY id DESC LIMIT 1";
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_count = $result['item_count'];

        $est_life_mon = $result['est_life_mon'] ?? 0;
        $est_life_year = $result['est_life_year'] ?? 0;
        // Extract remaining values from the result
        $acq_cost = $result['acq_cost'] ?? 0;
        $item_count = $new_qty;
        $prev_acc_depr = $result['prev_acc_depr'] ?? 0;
        $acquired_date = $result['date_purchased'];
    
        if ($est_life_year > 0 && $est_life_year != '') {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months = ($est_life_year * 12) + $est_life_mon;
            } else {
                $total_months = ($est_life_year * 12);
            }
        } else {
            if ($est_life_mon > 0 && $est_life_mon != '') {
                $total_months =  $est_life_mon;
            } else {
                $total_months = 0;
            }
        }

         $acquiredDateTime = new DateTime($acquired_date);
         $currentDateTime = new DateTime();
         $interval = $acquiredDateTime->diff($currentDateTime);
         $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
 
         if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
             $totalMonthsSincePurchase--;
         }

         if ($totalMonthsSincePurchase >= $total_months) {

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $book_val = 0;
                $cur_acc_depr = 0;
            } else {
                $book_val = $item_count;
                $cur_acc_depr = round($acq_cost - $item_count, 2);
            }
            $ffe_depr_val = 0; 

        } else {
            if ($item_count > 0 && $acq_cost > 0 && $total_months > 0) {
                $ffe_depr_val = round(($acq_cost - $item_count) / $total_months, 2);
            } else {
                $ffe_depr_val = 0;
            }

            if ($prev_acc_depr == 0) {
                $cur_acc_depr = $ffe_depr_val;
            } else {
                $cur_acc_depr = round($prev_acc_depr + $ffe_depr_val, 2);
            }

            if ($acq_cost == 0 || is_null($acq_cost)) {
                $book_val = 0;
            } else {
                $book_val = round($acq_cost - $cur_acc_depr, 2);
            }
        }
    
        $data = array(
            "item_location" => $result['item_location'],
            "company" => self::determineCompany($result['item_location']),
            "date_purchased" => $result['date_purchased'],
            "item_description" => $result['item_description'],
            "sticker_no" => $result['sticker_no'],
            "ref_no" => $result['ref_no'],
            "est_life_mon" => $est_life_mon,
            "est_life_year" => $est_life_year,
            "prev_acc_depr" => $prev_acc_depr,
            "acq_cost" => $acq_cost,
            "acc_depr" => $cur_acc_depr,
            "ffe_depr" => $ffe_depr_val,
            "book_value" => $book_val,
            "type" => $result['type'],
            "status" => $result['status'],
            "qty_code" => $result['qty_code'],
            "class_type" => $result['class_type'],
            "class_category" => $result['class_category'],
            "class_list" => $result['class_list'],
            "class_code" => $result['class_code']
        );
    
        if ($new_qty > $current_count) {
            // Add new items to match the quantity
            $items_to_add = $new_qty - $current_count;
            $last_sticker_no = $data['sticker_no'] ?? '';
            
            for ($i = 0; $i < $items_to_add; $i++) {
                if ($last_sticker_no != '') {
                    $new_sticker_no = $last_sticker_no + 1;
                    $last_sticker_no = $new_sticker_no;
                } else {
                    $new_sticker_no = '';
                }
                
                if (!$this->addItemToInventory($data, $new_sticker_no)) {
                    echo "error";
                }
            }
            if (!$this->handleUpdateAllData($data)) {
                echo "error";
            }
            echo "ok";
        } elseif ($new_qty < $current_count) {
            $items_to_delete = $current_count - $new_qty;
            $query = "DELETE FROM `inventory` WHERE qty_code = :qty_code ORDER BY id DESC LIMIT :items_to_delete";
            $stmt = (new Connection)->connect()->prepare($query);
            $stmt->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
            $stmt->bindParam(":items_to_delete", $items_to_delete, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if (!$this->handleUpdateAllData($data)) {
                    echo "error";
                }
                echo "ok";
            } else {
                echo "error";
            }
        }
    
        $stmt->closeCursor();
    }
    private function handleUpdateAllData($data) {
        $updateQuery = "UPDATE inventory SET
            acc_depr = :acc_depr,
            ffe_depr = :ffe_depr,
            book_value = :book_value
        WHERE qty_code = :qty_code";

        $updateStmt = (new Connection)->connect()->prepare($updateQuery);
        $updateStmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
        $updateStmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
        $updateStmt->bindParam(":qty_code", $data['qty_code'], PDO::PARAM_STR);

        $result = $updateStmt->execute();
    
        $updateStmt->closeCursor();
        return $result; 

    }
    private function addItemToInventory($data, $new_sticker_no) {
        try {
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction(); // Start transaction
    
            $add_item_code = $this->getNextItemCode();
            $last_id = $add_item_code + 1;
            $id_holder = "IC" . str_pad($last_id, 5, '0', STR_PAD_LEFT);

            $class_codes = [
                'TABLES' => 'FRT',
                'CHAIRS' => 'FRCS',
                'CABINETS' => 'FRCB',
                'IMAGES / STATUES' => 'FXI',
                'DECORATIONS' => 'FXD',
                'PAINTINGS' => 'FXP',
                'HOUSEHOLD EFFECTS' => 'FXH',
                'APPLIANCES' => 'FXA',
                'COMPUTERS' => 'EQC',
                'PRINTERS / COPIERS' => 'EQPC',
                'PERIPHERALS / ACCESSORIES' => 'EQPA',
                'CCTV EQUIPMENTS' => 'EQCV',
                'SOUNDS AND MIXERS' => 'EQSM',
                'GADGETS / COMMUNICATION / CONNECTIVITY' => 'EQGC',
                'MOTOR VEHICLE' => 'EQMT',
                'OTHER FFE' => 'OFFE',
            ];
            
            $code = isset($class_codes[$data['class_category']]) ? $class_codes[$data['class_category']] : null;
            $next_class_code = (new Inventory)->getNextClassCode($code);
            $next_class_code = $next_class_code + 1; 

            $class_code = $code . str_pad($next_class_code++, 5, '0', STR_PAD_LEFT);
            $query = "INSERT INTO `inventory` (item_code, item_location, company, ref_no, date_purchased, item_description, sticker_no, last_sticker,
                    est_life_mon, est_life_year, acq_cost, prev_acc_depr, acc_depr, ffe_depr, book_value, type, status, qty_code, class_type, class_category, class_list, class_code) 
                    VALUES (:item_code, :item_location, :company, :ref_no, :date_purchased, :item_description, :sticker_no, :last_sticker, :est_life_mon, :est_life_year,
                    :acq_cost, :prev_acc_depr, :acc_depr, :ffe_depr, :book_value, :type, :status, :qty_code, :class_type, :class_category, :class_list, :class_code)";
            
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":item_code", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":item_location", $data['item_location'], PDO::PARAM_STR);
            $stmt->bindParam(":company", $data['company'], PDO::PARAM_STR);
            $stmt->bindParam(":ref_no", $data['ref_no'], PDO::PARAM_STR);
            $stmt->bindParam(":date_purchased", $data['date_purchased'], PDO::PARAM_STR);
            $stmt->bindParam(":item_description", $data['item_description'], PDO::PARAM_STR);
            $stmt->bindParam(":sticker_no", $new_sticker_no, PDO::PARAM_STR);
            $stmt->bindParam(":last_sticker", $new_sticker_no, PDO::PARAM_STR);
            $stmt->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
            $stmt->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
            $stmt->bindParam(":acq_cost", $data['acq_cost'], PDO::PARAM_STR);
            $stmt->bindParam(":prev_acc_depr", $data['prev_acc_depr'], PDO::PARAM_STR);
            $stmt->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
            $stmt->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
            $stmt->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
            $stmt->bindParam(":type", $data['type'], PDO::PARAM_STR);
            $stmt->bindParam(":status", $data['status'], PDO::PARAM_STR);
            $stmt->bindParam(":qty_code", $data['qty_code'], PDO::PARAM_STR);
            $stmt->bindParam(":class_type", $data['class_type'], PDO::PARAM_STR);
            $stmt->bindParam(":class_category", $data['class_category'], PDO::PARAM_STR);
            $stmt->bindParam(":class_list", $data['class_list'], PDO::PARAM_STR);
            $stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
    
            $result = $stmt->execute();
            $pdo->commit();
            
            $stmt->closeCursor();
            return $result;
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $pdo->rollBack();
            echo "Failed to add item to inventory: " . $e->getMessage();
            return false;
        }
    }
    
    private function getNextItemCode() {
        $query = "SELECT id FROM inventory ORDER BY id DESC LIMIT 1";
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_item_code = $result['id'];
        return $next_item_code;
    }

    public function saveAddInventoryList() {
        $item_qty = $_GET['item_qty'];
        $item_code = $_GET['item_code'];
        $branch_name = $_GET['branch_name'];
        $company =  self::determineCompany($branch_name);
        $date_purchased = $_GET['date_purchased'];
        $item_description = $_GET['item_description'];
        $ref_no = $_GET['ref_no'];
        $sticker_from = $_GET['sticker_from'];
        $sticker_to = $_GET['sticker_to'];
        $est_life_mon = $_GET['est_life_mon'];
        $est_life_year = $_GET['est_life_year'];
        $acq_cost = $_GET['acq_cost'];
        $prev_acc_depr = $_GET['prev_acc_depr'];
        $acc_depr = $_GET['acc_depr'];
        $ffe_depr = $_GET['ffe_depr'];
        $book_value = $_GET['book_value'];
        $type = $_GET['type'];
        $status = $_GET['status'];
        $class_type = $_GET['class_type'];
        $class_category = $_GET['class_category'];
        $class_list = $_GET['class_list'];
        $class_code = $_GET['class_code'];
        $selectedComponents = isset($_GET['components']) ? $_GET['components'] : '';
        $cam_count = $_GET['cam_count'];
        $date_added = date('Y-m-d');
    
        try {
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction(); 

            $class_codes = [
                'TABLES' => 'FRT',
                'CHAIRS' => 'FRCS',
                'CABINETS' => 'FRCB',
                'IMAGES / STATUES' => 'FXI',
                'DECORATIONS' => 'FXD',
                'PAINTINGS' => 'FXP',
                'HOUSEHOLD EFFECTS' => 'FXH',
                'APPLIANCES' => 'FXA',
                'COMPUTERS' => 'EQC',
                'PRINTERS / COPIERS' => 'EQPC',
                'PERIPHERALS / ACCESSORIES' => 'EQPA',
                'CCTV EQUIPMENTS' => 'EQCV',
                'SOUNDS AND MIXERS' => 'EQSM',
                'GADGETS / COMMUNICATION / CONNECTIVITY' => 'EQGC',
                'MOTOR VEHICLE' => 'EQMT',
                'OTHER FFE' => 'OFFE',
            ];
            
            $code = isset($class_codes[$class_category]) ? $class_codes[$class_category] : null;
    
            $next_class_code = (new Inventory)->getNextClassCode($code);
            $next_class_code = $next_class_code + 1; 
            
            $last_sticker_no = 0;
            
            $first_unique = "";

            for ($i = 0; $i < $item_qty; $i++) {
                if ($sticker_from && $sticker_to && ($sticker_to - $sticker_from + 1) >= $item_qty) {
                    $sticker_length = strlen($sticker_from);  // Get the length to pad correctly
                    $sticker_no = str_pad($sticker_from + $i, $sticker_length, '0', STR_PAD_LEFT);
                } else {
                    $sticker_no = $_GET['sticker_no'];  // Default to single sticker number if range is invalid
                }

                $last_sticker_no = $sticker_no;
                $new_item_code = 0;
                $uniqueCodeFound = false;
                while (!$uniqueCodeFound) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `inventory` WHERE item_code = :item_code");
                    $stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                    
                    if ($count > 0) {
                        $prefix = substr($item_code, 0, 2);  // 'IC'
                        $numericPart = substr($item_code, 2); // '00002'
                        $numericPart = str_pad((int)$numericPart + 1, 5, '0', STR_PAD_LEFT);
                        $item_code = $prefix . $numericPart;
                    } else {
                        $uniqueCodeFound = true;
                        if ($i == 0) {
                            $first_unique = $item_code;
                        }
                    }
                }
    
                $class_code = $code . str_pad($next_class_code++, 5, '0', STR_PAD_LEFT);
    
                (new ControllerQRCode)->ctrCreateFFEItemQRCode($item_code);
 
                $stmt = $pdo->prepare("INSERT INTO `inventory` (item_code, company, item_location, date_purchased, item_description, ref_no, sticker_no, 
                est_life_mon, est_life_year, acq_cost, prev_acc_depr, acc_depr, ffe_depr, book_value, category, status, last_sticker, qty_code, class_type, class_category, class_list, class_code) 
                VALUES (:item_code, :company, :branch_name, :date_purchased, :item_description, :ref_no, :sticker_no, :est_life_mon, :est_life_year,
                :acq_cost, :prev_acc_depr, :acc_depr, :ffe_depr, :book_value, :category, :status, :last_sticker, :qty_code, :class_type, :class_category, :class_list, :class_code)");
    
                // Bind parameters for the inventory
                $stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
                $stmt->bindParam(":company", $company, PDO::PARAM_STR);
                $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
                $stmt->bindParam(":date_purchased", $date_purchased, PDO::PARAM_STR);
                $stmt->bindParam(":item_description", $item_description, PDO::PARAM_STR);
                $stmt->bindParam(":ref_no", $ref_no, PDO::PARAM_STR);
                $stmt->bindParam(":sticker_no", $sticker_no, PDO::PARAM_STR);
                $stmt->bindParam(":est_life_mon", $est_life_mon, PDO::PARAM_INT);
                $stmt->bindParam(":est_life_year", $est_life_year, PDO::PARAM_INT);
                $stmt->bindParam(":acq_cost", $acq_cost, PDO::PARAM_STR);
                $stmt->bindParam(":prev_acc_depr", $prev_acc_depr, PDO::PARAM_STR);
                $stmt->bindParam(":acc_depr", $acc_depr, PDO::PARAM_STR);
                $stmt->bindParam(":ffe_depr", $ffe_depr, PDO::PARAM_STR);
                $stmt->bindParam(":book_value", $book_value, PDO::PARAM_STR);
                $stmt->bindParam(":category", $type, PDO::PARAM_STR);
                $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                $stmt->bindParam(":last_sticker", $sticker_no, PDO::PARAM_STR);
                $stmt->bindParam(":qty_code", $first_unique, PDO::PARAM_STR);
                $stmt->bindParam(":class_type", $class_type, PDO::PARAM_STR);
                $stmt->bindParam(":class_category", $class_category, PDO::PARAM_STR);
                $stmt->bindParam(":class_list", $class_list, PDO::PARAM_STR);
                $stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
                if($stmt->execute()){
                    $add_item_code = $this->getNextItemCode();
                    $new_item_code = $add_item_code + 1;
                }
            }

            if ($selectedComponents != '') {

                $decimal_sticker = 1;
                $num_sticker = 1;

                foreach ($selectedComponents as $component) {
                  
                    if ($component === 'CCTV') {
                        continue;
                    }
    
                    $new_item_code++;
                    $id_holder = "IC" . str_pad($new_item_code, 5, '0', STR_PAD_LEFT);

                    $item_description = $component;
                
                    $stmt = $pdo->prepare("INSERT INTO `inventory_itemset` (`item_code`, `item_description`, `set_type`, `status`, `item_location`, `class_code`, `date_added`) 
                        VALUES (:item_code, :item_description, :class_list, :status, :branch_name, :class_code, :date_added)");
                
                    $stmt->bindParam(":item_code", $id_holder, PDO::PARAM_STR);
                    $stmt->bindParam(":item_description", $item_description, PDO::PARAM_STR);
                    $stmt->bindParam(":class_list", $class_list, PDO::PARAM_STR);
                    $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                    $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
                    $stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
                    $stmt->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                
                    $stmt->execute();
                 
                    if ($item_description === 'MOUSE') {
                        $list_sticker_no = $sticker_no . '.' . $decimal_sticker;
                        $decimal_sticker++;
                    }else if($item_description === 'KEYBOARD') {
                        $list_sticker_no = $sticker_no . '.' . $decimal_sticker;
                        $decimal_sticker++;
                    } else {
                        $list_sticker_no = $last_sticker_no + $num_sticker;
                        $num_sticker++;
                    }

                    $data = array(
                        "item_code" => $id_holder,
                        "item_location" => $branch_name,
                        "company" => $company,
                        "date_purchased" => $date_purchased,
                        "component" => $item_description,
                        "sticker_no" => $list_sticker_no,
                        "ref_no" => $ref_no,
                        "est_life_mon" => $est_life_mon,
                        "est_life_year" => $est_life_year,
                        "prev_acc_depr" => $prev_acc_depr,
                        "acq_cost" => $acq_cost,
                        "acc_depr" => $acc_depr,
                        "ffe_depr" => $ffe_depr,
                        "book_value" => $book_value,
                        "type" => $type,
                        "status" => $status,
                        "qty_code" => $first_unique,
                        "class_type" => $class_type,
                        "class_category" => $class_category,
                        "class_list" => $class_list,
                        "class_code" => $class_code
                    );
                    $this->insertComponent($data);
                }

            $num_sticker_cctv = 1;
            for ($i = 0; $i < $cam_count; $i++) {
                $item_description = 'CCTV';

                $new_item_code++;
                $id_holder = "IC" . str_pad($new_item_code, 5, '0', STR_PAD_LEFT);

                $stmt = $pdo->prepare("INSERT INTO `inventory_itemset` (`item_code`, `item_description`, `set_type`, `status`, `item_location`, `class_code`, `date_added`) 
                    VALUES (:item_code, :item_description, :class_list, :status, :branch_name, :class_code, :date_added)");

                $stmt->bindParam(":item_code", $id_holder, PDO::PARAM_STR);
                $stmt->bindParam(":item_description", $item_description, PDO::PARAM_STR);
                $stmt->bindParam(":class_list", $class_list, PDO::PARAM_STR);
                $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
                $stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
                $stmt->bindParam(":date_added", $date_added, PDO::PARAM_STR);
                $stmt->execute();

                $list_sticker_no = $last_sticker_no + $num_sticker;
                $num_sticker++;

                $data = array(
                    "item_code" => $id_holder,
                    "item_location" => $branch_name,
                    "company" => $company,
                    "date_purchased" => $date_purchased,
                    "component" => $item_description,
                    "sticker_no" => $list_sticker_no,
                    "ref_no" => $ref_no,
                    "est_life_mon" => $est_life_mon,
                    "est_life_year" => $est_life_year,
                    "prev_acc_depr" => $prev_acc_depr,
                    "acq_cost" => $acq_cost,
                    "acc_depr" => $acc_depr,
                    "ffe_depr" => $ffe_depr,
                    "book_value" => $book_value,
                    "type" => $type,
                    "status" => $status,
                    "qty_code" => $first_unique,
                    "class_type" => $class_type,
                    "class_category" => $class_category,
                    "class_list" => $class_list,
                    "class_code" => $class_code
                );
                $this->insertComponent($data);
            }
        }
    
            $pdo->commit();
            echo "ok";
    
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Failed to insert: " . $e->getMessage();
        }
    
        $stmt = null;
    }

    public function insertComponent($data) {
        try {
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();
            $stmt_list = $pdo->prepare("INSERT INTO `inventory` (item_code, company, item_location, date_purchased, item_description, ref_no, sticker_no, 
            est_life_mon, est_life_year, acq_cost, prev_acc_depr, acc_depr, ffe_depr, book_value, category, status, last_sticker, qty_code, class_type, class_category, class_list, class_code) 
            VALUES (:item_code, :company, :branch_name, :date_purchased, :item_description, :ref_no, :sticker_no, :est_life_mon, :est_life_year,
            :acq_cost, :prev_acc_depr, :acc_depr, :ffe_depr, :book_value, :category, :status, :last_sticker, :qty_code, :class_type, :class_category, :class_list, :class_code)");

            $stmt_list->bindParam(":item_code", $data['item_code'], PDO::PARAM_STR);
            $stmt_list->bindParam(":company", $data['company'], PDO::PARAM_STR);
            $stmt_list->bindParam(":branch_name", $data['item_location'], PDO::PARAM_STR);
            $stmt_list->bindParam(":date_purchased", $data['date_purchased'], PDO::PARAM_STR);
            $stmt_list->bindParam(":item_description", $data['component'], PDO::PARAM_STR);
            $stmt_list->bindParam(":ref_no", $data['ref_no'], PDO::PARAM_STR);
            $stmt_list->bindParam(":sticker_no", $data['sticker_no'], PDO::PARAM_STR);
            $stmt_list->bindParam(":est_life_mon", $data['est_life_mon'], PDO::PARAM_INT);
            $stmt_list->bindParam(":est_life_year", $data['est_life_year'], PDO::PARAM_INT);
            $stmt_list->bindParam(":acq_cost", $data['acq_cost'], PDO::PARAM_STR);
            $stmt_list->bindParam(":prev_acc_depr", $data['prev_acc_depr'], PDO::PARAM_STR);
            $stmt_list->bindParam(":acc_depr", $data['acc_depr'], PDO::PARAM_STR);
            $stmt_list->bindParam(":ffe_depr", $data['ffe_depr'], PDO::PARAM_STR);
            $stmt_list->bindParam(":book_value", $data['book_value'], PDO::PARAM_STR);
            $stmt_list->bindParam(":category", $data['type'], PDO::PARAM_STR);
            $stmt_list->bindParam(":status", $data['status'], PDO::PARAM_STR);
            $stmt_list->bindParam(":last_sticker", $data['sticker_no'], PDO::PARAM_STR);
            $stmt_list->bindParam(":qty_code", $data['qty_code'], PDO::PARAM_STR);
            $stmt_list->bindParam(":class_type", $data['class_type'], PDO::PARAM_STR);
            $stmt_list->bindParam(":class_category", $data['class_category'], PDO::PARAM_STR);
            $stmt_list->bindParam(":class_list", $data['class_list'], PDO::PARAM_STR);
            $stmt_list->bindParam(":class_code", $data['class_code'], PDO::PARAM_STR);
            $stmt_list->execute();

            $pdo->commit();
    
        } catch (Exception $e) {
            // Rollback the transaction in case of failure
            $pdo->rollBack();
            echo "Failed to insert: " . $e->getMessage();
        }
        $stmt = null;
    }
    
    public function SavePrintedReportArchive() {
        $action = $_GET['action'];
        $preparedBy = $_GET['preparedBy'];
        $position = $_GET['position'];
        $item_location = $_SESSION['branch_name'];
        $selected_date = $_GET['selectedDate'];
        if (strpos($item_location, "RLC") !== false) {
            $item_location = str_replace("RLC", "RFC", $item_location);
        }
     
        if (isset($action) && $action === 'archive') {
            $add_rep_code = $this->getNextReportCode();
            $last_id = $add_rep_code + 1;
            
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();
    
            try {
                $month_year_checking = date('Y-m', strtotime($selected_date));
                $cur_month_year_checking = date('Y-m', time());
                if ($month_year_checking == $cur_month_year_checking) {
                    $report_date = date('Y-m-d', time()); 
                } else {
                    $report_date = date('Y-m-25', strtotime($selected_date));
                }
                
                if (date('d', strtotime($report_date)) <= 25) { 
                    $month_from = date('Y-m-25', strtotime(' -1 month', strtotime($report_date)));
                    $month_to = date('Y-m-26', strtotime($report_date));
                }else{
                    $month_from = date('Y-m-25',strtotime($report_date));
                    $month_to = date('Y-m-26', strtotime(' + 1 month', strtotime($report_date)));
                }
                // Fetch the inventory details based on item location
                $query = "SELECT inv.item_code, inv.company, inv.sticker_no, inv.item_location, inv.price, inv.item_description, inv.serial_no, inv.date_purchased, inv.supplier, inv.repair, inv.last_repaired, inv.status, inv.type, inv.date_defective, inv.date_dispose, inv.last_sticker, inv.ref_no, inv.class_type, inv.class_category, inv.class_list, inv.class_code, inv.est_life_mon, inv.est_life_year, inv.acq_cost, inv.acc_depr, inv.prev_acc_depr, inv.ffe_depr, inv.book_value, inv.category, inv.qty_code
                        FROM inventory inv
                        LEFT JOIN (
							SELECT log.item_code, log.branch_name, log.status, log.id
                                FROM inventory_log log
                                 INNER JOIN (
                                    SELECT item_code, MAX(id) AS max_id
                                    FROM inventory_log
                                     WHERE branch_name = :item_location
                                    GROUP BY item_code
                            ) log_max ON log.item_code = log_max.item_code AND log.id = log_max.max_id
                            ) i_log ON inv.item_code = i_log.item_code
                         WHERE (
                            inv.item_location = :item_location
                            OR (i_log.branch_name = :item_location AND inv.item_location != :item_location OR i_log.branch_name = '')
                        )
                        AND (i_log.status != 'ITEM OUT' OR i_log.status IS NULL)
                        AND DATE(inv.date_purchased) < :month_to";
                        
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":item_location", $item_location, PDO::PARAM_STR);
                $stmt->bindParam(":month_to", $month_to, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                // Get REP ID to retain same id //
                $selectQuery = "SELECT rep_code, last_rep_id 
                FROM `inventory_archive` 
                WHERE item_location = :item_location 
                AND `rep_date` > :month_from 
                AND `rep_date` < :month_to 
                LIMIT 1";
                $selectStmt = $pdo->prepare($selectQuery);
                $selectStmt->bindParam(":item_location", $item_location, PDO::PARAM_STR);
                $selectStmt->bindParam(":month_from", $month_from, PDO::PARAM_STR);
                $selectStmt->bindParam(":month_to", $month_to, PDO::PARAM_STR);
                $selectStmt->execute();
    
                $recordsToDelete = $selectStmt->fetch(PDO::FETCH_ASSOC);
    
                if (!empty($recordsToDelete)) {
                    $id_holder = $recordsToDelete['rep_code'];
                    $last_rep_id = $recordsToDelete['last_rep_id'];
                }else{
                    $last_rep_id = $add_rep_code + 1;
                    $id_holder = "REP" . str_pad($last_id++, 6, '0', STR_PAD_LEFT);
                }
                // DELETE REP ID TO INSERT UPDATED REPORT //
                $deleteQuery = "DELETE FROM `inventory_archive` WHERE item_location = :item_location AND rep_code = :rep_code";
                $deleteStmt = $pdo->prepare($deleteQuery);
                $deleteStmt->bindParam(":item_location", $item_location, PDO::PARAM_STR);
                $deleteStmt->bindParam(":rep_code", $id_holder, PDO::PARAM_STR);
    
                if (!$deleteStmt->execute()) {
                    throw new Exception("Error deleting existing records from inventory_archive.");
                }

                if ($result && count($result) > 0) {

                    $totals = [];
                    foreach ($result as $inv) {
                        $item_desc = $inv['item_description'];
                        
                        if (!isset($totals[$item_desc])) {
                            $totals[$item_desc] = 0;
                        }
                        $totals[$item_desc]++;
                    }
                    foreach ($result as $row) {

                        $date_purchased = $row['date_purchased'];

                        if (isset($row['est_life_mon']) && $row['est_life_mon'] != 0) {
                            $est_life_mon = $row['est_life_mon'];
                        } else {
                            $est_life_mon = '';
                        }
                        if (isset($row['est_life_year']) && $row['est_life_year'] != 0) {
                            $est_life_year = $row['est_life_year'];
                        } else {
                            $est_life_year = '';
                        }

                        if ($est_life_year > 0 && $est_life_year != '') {
                            if ($est_life_mon > 0 && $est_life_mon != '') {
                                $total_months = ($est_life_year * 12) + $est_life_mon;
                            } else {
                                $total_months = ($est_life_year * 12);
                            }
                        } else {
                            if ($est_life_mon > 0 && $est_life_mon != '') {
                                $total_months =  $est_life_mon;
                            } else {
                                $total_months = 0;
                            }
                        }
                
                        $acquiredDateTime = new DateTime($date_purchased);

                        $format_selected_month_from_filter = date('Y-m-t', strtotime($report_date)); 
                     
                        $currentDateTime = new DateTime($format_selected_month_from_filter);
                
                        $interval = $acquiredDateTime->diff($currentDateTime);
                
                        $totalMonthsSincePurchase = ($interval->y * 12) + $interval->m;
                        // echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';
                
                        if ($currentDateTime->format('d') < $acquiredDateTime->format('d')) {
                            $totalMonthsSincePurchase--;
                        }

                        $item_qty_for_calc = $totals[$item_desc];

                        $acq_cost_for_calc = $row['acq_cost'];
                        //  echo '<script>console.log("'.$totalMonthsSincePurchase.'");</script>';
                        
                        if ($totalMonthsSincePurchase >= $total_months) {

                            if ($acq_cost_for_calc == 0 || $acq_cost_for_calc == '') {
                                $acc_depr = '';
                                $book_value = '';
                                $prev_acc_depr = '';
                                $ffe_depr = '';
                                $acq_cost = '';
                            } else {
                                $prev_acc_depr = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                $acc_depr = round($acq_cost_for_calc - $item_qty_for_calc, 2);
                                $book_value = $item_qty_for_calc;
                                $ffe_depr = '';
                                $acq_cost = $acq_cost_for_calc;
                            }        
                        }else {
                            if ($acq_cost_for_calc == 0 || $acq_cost_for_calc == '') {
                                $ffe_depr = '';
                                $acc_depr = '';
                                $book_value = '';
                                $prev_acc_depr = '';
                                $acq_cost = '';
                            } else {

                                if ($item_qty_for_calc > 0 && $acq_cost_for_calc > 0 && $total_months > 0) {
                                    $ffe_depr = round(($acq_cost_for_calc - $item_qty_for_calc) / $total_months, 2);
                                } else {
                                    $ffe_depr = '';
                                }
                            
                                $prev_acc_depr = round($ffe_depr * ($totalMonthsSincePurchase), 2);
                    
                                if ($prev_acc_depr == 0) {
                                    $acc_depr = $ffe_depr;
                                } else {
                                    $acc_depr = round($prev_acc_depr + $ffe_depr, 2);
                                }
                              
                                $book_value = $acq_cost_for_calc - $acc_depr;
                                $acq_cost = ($acq_cost_for_calc != '') ? $acq_cost_for_calc : '';
                            
                            }
                            
                        }

                        $insertQuery = "INSERT INTO `inventory_archive`(`rep_code`, `item_code`, `company`, `sticker_no`, `item_location`, `price`, 
                            `item_description`, `serial_no`, `date_purchased`, `supplier`, `repair`, `last_repaired`, `status`, `type`, `date_dispose`, 
                            `last_sticker`, `ref_no`, `est_life_mon`, `est_life_year`, `acq_cost`, `prev_acc_depr`, `acc_depr`, `ffe_depr`, `book_value`, 
                            `category`, `qty_code`, `class_type`, `class_category`, `class_list`, `class_code`, `preparedBy`, `position`, `last_rep_id`, `rep_date`) 
                        VALUES (:rep_code, :item_code, :company, :sticker_no, :item_location, :price, :item_description, :serial_no, :date_purchased, 
                            :supplier, :repair, :last_repaired, :status, :type, :date_dispose, :last_sticker, :ref_no, :est_life_mon, :est_life_year, 
                            :acq_cost, :prev_acc_depr, :acc_depr, :ffe_depr, :book_value, :category, :qty_code, :class_type, :class_category, :class_list, :class_code, :preparedBy, :position, :last_rep_id, :rep_date)";
                        
                        $insertStmt = $pdo->prepare($insertQuery);
                        $insertStmt->bindParam(":rep_code", $id_holder, PDO::PARAM_STR);
                        $insertStmt->bindParam(":item_code", $row['item_code'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":company", $row['company'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":sticker_no", $row['sticker_no'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":item_location", $row['item_location'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":price", $row['price'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":item_description", $row['item_description'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":serial_no", $row['serial_no'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":date_purchased", $row['date_purchased'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":supplier", $row['supplier'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":repair", $row['repair'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":last_repaired", $row['last_repaired'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":status", $row['status'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":type", $row['type'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":date_dispose", $row['date_dispose'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":last_sticker", $row['last_sticker'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":ref_no", $row['ref_no'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":est_life_mon", $est_life_mon, PDO::PARAM_INT);
                        $insertStmt->bindParam(":est_life_year", $est_life_year, PDO::PARAM_INT);
                        $insertStmt->bindParam(":acq_cost", $acq_cost, PDO::PARAM_STR);
                        $insertStmt->bindParam(":prev_acc_depr", $prev_acc_depr, PDO::PARAM_STR);
                        $insertStmt->bindParam(":acc_depr", $acc_depr, PDO::PARAM_STR);
                        $insertStmt->bindParam(":ffe_depr", $ffe_depr, PDO::PARAM_STR);
                        $insertStmt->bindParam(":book_value", $book_value, PDO::PARAM_STR);
                        $insertStmt->bindParam(":category", $row['category'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":qty_code", $row['qty_code'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":class_type", $row['class_type'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":class_category", $row['class_category'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":class_list", $row['class_list'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":class_code", $row['class_code'], PDO::PARAM_STR);
                        $insertStmt->bindParam(":preparedBy", $preparedBy, PDO::PARAM_STR);
                        $insertStmt->bindParam(":position", $position, PDO::PARAM_STR);
                        $insertStmt->bindParam(":last_rep_id", $last_rep_id, PDO::PARAM_STR);
                        $insertStmt->bindParam(":rep_date", $report_date, PDO::PARAM_STR);
    
                        if (!$insertStmt->execute()) {
                            throw new Exception("Error inserting into inventory_archive.");
                        }
                    }
                    $pdo->commit();
                    echo "ok";
                } else {
                    throw new Exception("No records found in the inventory.");
                }
            } catch (Exception $e) {
                // Rollback the transaction if any error occurs
                $pdo->rollBack();
                echo "error: " . $e->getMessage();
            }
        } else {
            echo "error";
        }
    }
    
    private function getNextReportCode() {
        try {
            $pdo = (new Connection)->connect();
            // Prepare and execute the query
            $stmt = $pdo->prepare("SELECT last_rep_id FROM inventory_archive ORDER BY last_rep_id DESC LIMIT 1");
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $next_rep_code = $result['last_rep_id'] ?? 0;
            
            return $next_rep_code;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return "error"; 
        }	
    }

    private function getAllRecordsInArchive($branch_name) {
        $query = "SELECT DISTINCT rep_code, item_location, date, rep_date
                  FROM inventory_archive 
                  WHERE item_location = :branch_name ORDER BY rep_code DESC";
        
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        return $result;
    }
    

    public function showArchiveRecords(){
        $branch_name = $_SESSION['branch_name'];
        if (strpos($branch_name, "RLC") !== false) {
            $branch_name = str_replace("RLC", "RFC", $branch_name);
        }
        $archive = $this->getAllRecordsInArchive($branch_name);
//         echo '<script>';
// echo 'console.log(' . json_encode($archive) . ');';
// echo '</script>';

        
        if(count($archive) == 0){
            echo '{"data":[]}';
            return;
        }
        $jsonData = '{
			"data":[';
            for($i=0; $i < count($archive); $i++){
                $rep_day = date('d', strtotime($archive[$i]["rep_date"]));
                if ($rep_day > '25') {
                    $rep_date_month = date('M Y', strtotime(' +1 month ', strtotime($archive[$i]["rep_date"])));
                } else {
                    $rep_date_month = date('M Y', strtotime($archive[$i]["rep_date"]));
                }
                
                $buttons = "<div class='btn-group group-round m-1'><button class='btn btn-sm btn-success waves-effect waves-light btnRePrintInventory' data-rep-code='".$archive[$i]["rep_code"]."' data-toggle='tooltip' data-placement='top' title='View'>RE-PRINT</button></div>";
                $jsonData .='[
                    "'.$archive[$i]["rep_code"].'",
                    "'.$archive[$i]["item_location"].'",
                    "'.$rep_date_month.'",
                    "'.date('Y-M-d h:i A', strtotime($archive[$i]["date"])).'",
                    "'.$buttons.'"
                ],';
            }
        
     	$jsonData = substr($jsonData, 0, -1);
		$jsonData .= '] 
        	}';
		echo $jsonData;
    }
    
    public function getNextClassCode($class_category) {
        $query = "
            SELECT CAST(SUBSTRING(class_code, LENGTH(:class_category) + 1) AS UNSIGNED) AS numeric_code
            FROM inventory
            WHERE class_code LIKE :class_category_pattern
            ORDER BY numeric_code DESC
            LIMIT 1
        ";
    
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(':class_category', $class_category, PDO::PARAM_STR);
        $stmt->bindValue(':class_category_pattern', '%'.$class_category . '%', PDO::PARAM_STR); 
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['numeric_code'] : 0;
    }

    public function deleteRowsSelected($qty_code, $branch_name, $class_code) {
        $queryDeleteItem = "DELETE FROM `inventory` WHERE qty_code = :qty_code AND item_location = :branch_name";
        $stmtDeleteItem = (new Connection)->connect()->prepare($queryDeleteItem);
    
        // Bind parameters
        $stmtDeleteItem->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmtDeleteItem->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
    
        if ($stmtDeleteItem->execute()) {
            $queryDeleteCompo = "DELETE FROM `inventory_itemset` WHERE class_code = :class_code AND item_location = :branch_name";
            $stmtDeleteCompo = (new Connection)->connect()->prepare($queryDeleteCompo);
        
            $stmtDeleteCompo->bindParam(":class_code", $class_code, PDO::PARAM_STR);
            $stmtDeleteCompo->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);

            if ($stmtDeleteCompo->execute()) {
                return "ok";
            } else {
                return "error";
            }

        } else {
            return "error";
        }
    }    

    public function showComponentsRecords($class_code, $item_loc) {
        $queryComponents = "SELECT * FROM `inventory_itemset` invitm INNER JOIN `inventory` inv ON invitm.item_code = inv.item_code WHERE invitm.class_code = :class_code AND invitm.item_location = :item_loc";
        $stmtComponents = (new Connection)->connect()->prepare($queryComponents);

        $stmtComponents->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmtComponents->bindParam(":item_loc", $item_loc, PDO::PARAM_STR);

        if ($stmtComponents->execute()) {
            $html = '';

            $html .= '<div class="row mb-3 populated-form">
                        <div class="col-1">
                            
                        </div>
                        <div class="col-3">
                            TICKET NO.
                        </div>
                        <div class="col-5">
                            DESCRIPTION
                        </div>
                        <div class="col-3">
                            ACTION
                        </div>
                    </div>';

            foreach ($stmtComponents as $i => $values) {
                $class_code = $values['class_code'];
                $item_description = $values['item_description'];
                $sticker_no = $values['sticker_no'];
                $item_loc = $values['item_location'];
                $item_code = $values['item_code'];

                $html .= '<div class="row mb-3 populated-form">
                    <div class="col-1">
                        <label for="" class="form-label"><i class="fa fa-arrow-right mt-2"></i></label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="com_sticker_'.$i.'" name="com_sticker[]" class="form-control" value="'.$sticker_no.'" placeholder="">
                    </div>
                    <div class="col-5">
                        <input type="text" id="com_description_'.$i.'" name="com_description[]" class="form-control" value="'.$item_description.'" placeholder="">
                    </div>
                    <div class="col-3">
                        <button type="button" data-item-code="'.$item_code.'" class="btn btn-danger delete_component waves-effects" id="delete_component"> DELETE </button>
                    </div>
                    <div class="col-3">
                        <input type="text" id="com_location_'.$i.'" name="com_location[]" class="form-control" hidden value="'.$item_loc.'" placeholder="">
                    </div>
                     <div class="col-3">
                        <input type="text" id="com_class_'.$i.'" name="com_class[]" class="form-control" hidden value="'.$class_code.'" placeholder="">
                    </div>
                    <div class="col-3">
                        <input type="text" id="com_item_'.$i.'" name="com_item[]" class="form-control" hidden value="'.$item_code.'" placeholder="">
                    </div>
                </div>';
            }
            return $html;
        } else {
            return "error";
        }
    }    
    public function saveComponentsRecords($class_code, $description, $location, $sticker, $item_code) {
        $queryToUpdate = "UPDATE `inventory` 
                SET `sticker_no` = :sticker_no, 
                    `item_description` = :item_description 
                WHERE `class_code` = :class_code 
                AND `item_code` = :item_code
                AND `item_location` = :item_location";

        $stmt_list = (new Connection)->connect()->prepare($queryToUpdate);

        $stmt_list->bindParam(":sticker_no", $sticker, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_location", $location, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_description", $description, PDO::PARAM_STR);
        $stmt_list->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_code", $item_code, PDO::PARAM_STR);

        if ($stmt_list->execute()) {
    
            $queryToUpdate2 = "UPDATE `inventory_itemset` 
                                            SET `item_description` = :item_description 
                                            WHERE `class_code` = :class_code 
                                            AND `item_code` = :item_code";
            $stmt_list_1 = (new Connection)->connect()->prepare($queryToUpdate2);
            // Bind parameters for the second query
            $stmt_list_1->bindParam(":item_description", $description, PDO::PARAM_STR);
            $stmt_list_1->bindParam(":class_code", $class_code, PDO::PARAM_STR);
            $stmt_list_1->bindParam(":item_code", $item_code, PDO::PARAM_STR);

            if ($stmt_list_1->execute()) {
                return "ok";
            }else{
                return "error";
            }
        } else{
            return "error";
        }
        
    }

    public function deleteComponentsRecords($table, $item_code){
        $query = "DELETE FROM $table WHERE item_code = :item_code";
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    public function showStickerRecords($qty_code, $item_loc) {
        $querySticker = "SELECT * FROM `inventory` WHERE qty_code = :qty_code AND item_location = :item_loc";
        $stmtSticker = (new Connection)->connect()->prepare($querySticker);

        $stmtSticker->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmtSticker->bindParam(":item_loc", $item_loc, PDO::PARAM_STR);

        if ($stmtSticker->execute()) {
            $html = '';

            $html .= '<div class="row mb-3 edit-sticker-form">
                        <div class="col-1">
                            
                        </div>
                        <div class="col-3">
                            STICKER NO.
                        </div>
                        <div class="col-5">
                            DESCRIPTION
                        </div>
                        <div class="col-3">
                            ACTION
                        </div>
                    </div>';

            foreach ($stmtSticker as $i => $values) {
                $qty_code = $values['qty_code'];
                $item_description = $values['item_description'];
                $sticker_no = $values['sticker_no'];
                $item_loc = $values['item_location'];
                $item_code = $values['item_code'];

                $html .= '<div class="row mb-3 edit-sticker-form">
                    <div class="col-1">
                        <label for="" class="form-label"><i class="fa fa-arrow-right mt-2"></i></label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="item_sticker_'.$i.'" name="item_sticker[]" class="form-control" value="'.$sticker_no.'" placeholder="">
                    </div>
                    <div class="col-5">
                        <input type="text" id="item_description_'.$i.'" name="item_description[]" class="form-control" value="'.$item_description.'" placeholder="">
                    </div>
                    <div class="col-3">
                        <button type="button" data-item-code="'.$item_code.'" class="btn btn-danger delete_sticker waves-effects" id="delete_sticker"> DELETE </button>
                    </div>
                    <div class="col-3">
                        <input type="text" id="item_location_'.$i.'" name="item_location[]" class="form-control" hidden value="'.$item_loc.'" placeholder="">
                    </div>
                     <div class="col-3">
                        <input type="text" id="item_qty_'.$i.'" name="item_qty[]" class="form-control" hidden value="'.$qty_code.'" placeholder="">
                    </div>
                    <div class="col-3">
                        <input type="text" id="item_item_code_'.$i.'" name="item_item_code[]" class="form-control" hidden value="'.$item_code.'" placeholder="">
                    </div>
                </div>';
            }
            return $html;
        } else {
            return "error";
        }
    }    

    public function saveStickersRecords($qty_code, $description, $location, $sticker, $item_code) {
        $queryToUpdate = "UPDATE `inventory` 
                SET `sticker_no` = :sticker_no, 
                    `item_description` = :item_description 
                WHERE `qty_code` = :qty_code 
                AND `item_code` = :item_code
                AND `item_location` = :item_location";

        $stmt_list = (new Connection)->connect()->prepare($queryToUpdate);
        $stmt_list->bindParam(":sticker_no", $sticker, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_location", $location, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_description", $description, PDO::PARAM_STR);
        $stmt_list->bindParam(":qty_code", $qty_code, PDO::PARAM_STR);
        $stmt_list->bindParam(":item_code", $item_code, PDO::PARAM_STR);

        if ($stmt_list->execute()) {
            return "ok";
        }else{
            return "error";
        }
    }

    public function deleteStickersRecords($item_code){
        $query = "DELETE FROM `inventory` WHERE item_code = :item_code";
        $stmt = (new Connection)->connect()->prepare($query);
        $stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}


$inventory = new Inventory();
if (isset($_GET['action']) && $_GET['action'] === 'update') {
    $inventory->saveInventoryChanges();
} else if (isset($_GET['action']) && $_GET['action'] === 'insert') {
    $inventory->saveAddInventoryList();
} else if (isset($_GET['action']) && $_GET['action'] === 'archive') {
    $inventory->SavePrintedReportArchive();
} else if (isset($_GET['action']) && $_GET['action'] === 'showArchive') {
    $inventory->showArchiveRecords();
} else if (isset($_GET['action']) && $_GET['action'] === 'getNextClassCode') {
    if (isset($_GET['class_category'])) {
        $class_category = $_GET['class_category'];
       
        try {
            $next_class_code = $inventory->getNextClassCode($class_category);

            echo json_encode([
                'success' => true,
                'next_class_code' => $next_class_code + 1
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No class category provided.'
        ]);
    }

} else if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $checkedRows = $_POST['checkedRows'];  
    
    foreach ($checkedRows as $values) {
        $qty_code = $values['qtyCode']; 
        $branch_name = $values['branchName'];
        $classCode = $values['classCode'];

        $result = $inventory->deleteRowsSelected($qty_code, $branch_name, $classCode);
        
        if ($result === 'error') {
            echo 'error';
            return;  
        }
    }
    echo 'ok';

} else if (isset($_POST['action']) && $_POST['action'] === 'edit_com') {
    $class_code = $_POST['class_code'];
    $item_loc = $_POST['item_loc'];

    $response = $inventory->showComponentsRecords($class_code, $item_loc);
    echo $response;

} else if (isset($_POST['action']) && $_POST['action'] === 'save_com') {

    if (isset($_POST['components'])) {
        $components = $_POST['components'];

        $all_success = true;
        $errors = [];

        foreach ($components as $component) {
            $class_code = $component['classCode'];
            $description = $component['description'];
            $location = $component['location'];
            $sticker = $component['sticker'];
            $item_code = $component['itemCode'];
        
            $result = $inventory->saveComponentsRecords($class_code, $description, $location, $sticker, $item_code);
        
            if ($result !== 'ok') {
                $all_success = false;
                $errors[] = "Failed to save component with class code: $class_code and item code: $item_code";
                error_log("Error saving component: $result");
            }
        }
        
        if ($all_success) {
            echo 'ok';
        } else {
            echo json_encode([
                'status' => 'error',
                'messages' => $errors
            ]);
        }
        
    } else {
        echo 'error';
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'delete_com') {
    $item_code = $_POST['item_code'];
    $inv_table = 'inventory';
    $list_table = 'inventory_itemset';

    $inv_table = $inventory->deleteComponentsRecords($inv_table, $item_code);
    if ($inv_table === 'ok') {
        $list_table = $inventory->deleteComponentsRecords($list_table, $item_code);
        if ($inv_table === 'ok') {
            $response = 'ok';
        } else {
            $response = 'error';
        }
    } else {
        $response = 'error';
    }

    echo $response;
} else if (isset($_POST['action']) && $_POST['action'] === 'edit_sticker') {
    $qty_code = $_POST['qty_code'];
    $item_loc = $_POST['item_loc'];

    $response = $inventory->showStickerRecords($qty_code, $item_loc);
    echo $response;
    
} else if (isset($_POST['action']) && $_POST['action'] === 'save_sticker') {

    if (isset($_POST['stickers'])) {
        $stickers = $_POST['stickers'];

        $all_success = true;
        $errors = [];

        foreach ($stickers as $sticker) {
            $qty_code = $sticker['qtyCode'];
            $description = $sticker['description'];
            $location = $sticker['location'];
            $sticker_no = $sticker['sticker'];
            $item_code = $sticker['itemCode'];
        
            $result = $inventory->saveStickersRecords($qty_code, $description, $location, $sticker_no, $item_code);
        
            if ($result !== 'ok') {
                $all_success = false;
                $errors[] = "Failed to save component with class code: $qty_code and item code: $item_code";
                error_log("Error saving component: $result");
            }
        }
        
        if ($all_success) {
            echo 'ok';
        } else {
            echo json_encode([
                'status' => 'error',
                'messages' => $errors
            ]);
        }
        
    } else {
        echo 'error';
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'delete_sticker') {
    $item_code = $_POST['item_code'];

    $inv_table = $inventory->deleteStickersRecords($item_code);
    if ($inv_table === 'ok') {
        $response = 'ok';
    } else {
        $response = 'error';
    }

    echo $response;
}
