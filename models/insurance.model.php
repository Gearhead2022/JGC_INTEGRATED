<?php 
require_once "connection.php";

class ModelInsurance{
    static public function mdlShowInsurance(){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
        if($type == "admin" || $type == "insurance_admin"){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance");
        }else{
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE branch_name = '$branch_name'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowBranches(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounting_branches");
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowFilterInsurance($date){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
        if($type == "admin" || $type == "insurance_admin"){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND ins_type = 'OONA' ORDER BY b.id, a.id");
        }else{
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'OONA'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowFilterInsuranceByBranch($date, $branch){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
       
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND a.branch_name LIKE '$branch%' AND ins_type = 'OONA'  ORDER BY b.id, a.id");
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    static public function mdlShowFilterInsuranceBranch($date, $branch_name){
        if ($date == "") {
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE branch_name = '$branch_name' AND ins_type = 'OONA' ");

        }else{
              $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'OONA'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }
    static public function mdlCheckInsurance($branch_name, $avail_date, $account_id, $name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE branch_name = :branch_name 
        AND avail_date = :avail_date AND account_id = :account_id");
        $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt->bindParam(":avail_date", $avail_date, PDO::PARAM_STR);
        $stmt->bindParam(":account_id", $account_id, PDO::PARAM_STR);
     
        $stmt -> execute();
		$total = $stmt->rowCount();
        if($total>0){
            return "not";
        }else{
            return "ok";
        }
		$stmt -> close();
		$stmt = null;
    }
    
    static public function mdlShowInsuranceID($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlCountInsurance($branch_name, $date, $type){
        $stmt = (new Connection)->connect()->prepare("SELECT count(id) as ins_total FROM insurance WHERE avail_date = :date AND branch_name = :branch_name AND ins_type = :type");
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    static public function mdlAddInsurance($table, $data){
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO $table(account_id, name, birth_date, age, terms, branch_name, avail_date, expire_date, ins_rate, amount, ins_type ,`days`) VALUES
             (:account_id, :name, :birth_date, :age, :terms, :branch_name, :avail_date, :expire_date, :ins_rate, :amount, :ins_type, :days1)");
		
   
            $stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
            $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
            $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
            $stmt->bindParam(":terms", $data["terms"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":avail_date", $data["avail_date"], PDO::PARAM_STR);
            $stmt->bindParam(":expire_date", $data["expire_date"], PDO::PARAM_STR);
            $stmt->bindParam(":ins_rate", $data["ins_rate"], PDO::PARAM_STR);
            $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
            $stmt->bindParam(":ins_type", $data["ins_type"], PDO::PARAM_STR);
            $stmt->bindParam(":days1", $data["days"], PDO::PARAM_STR);
		
			$stmt->execute();
			$pdo->commit();
           
			return "ok";
            $stmt->close();
	    	$stmt = null;
        
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }


    static public function mdlEditInsurance($table, $data){
        $stmt = (new Connection)->connect()->prepare("UPDATE $table SET `name` = :name, `occupation` = :occupation, `civil_status` = :civil_status, `gender` = :gender,
        `terms` = :terms, `birth_date` = :birth_date, `age` = :age, `amount_loan` = :amount_loan, `expire_date` = :expire_date, `ins_rate` = :ins_rate, `cbi_illness` = :cbi_illness, `dchs` = :dchs,  `days` = :days WHERE id = :id");
        
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":occupation", $data["occupation"], PDO::PARAM_STR);
        $stmt->bindParam(":civil_status", $data["civil_status"], PDO::PARAM_STR);
        $stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
        $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
        $stmt->bindParam(":gender", $data["gender"], PDO::PARAM_STR);
        $stmt->bindParam(":terms", $data["terms"], PDO::PARAM_STR);
        $stmt->bindParam(":amount_loan", $data["amount_loan"], PDO::PARAM_STR);
        $stmt->bindParam(":expire_date", $data["expire_date"], PDO::PARAM_STR);
        $stmt->bindParam(":ins_rate", $data["ins_rate"], PDO::PARAM_STR);
        $stmt->bindParam(":cbi_illness", $data["cbi_illness"], PDO::PARAM_STR);
        $stmt->bindParam(":dchs", $data["dchs"], PDO::PARAM_STR);
        $stmt->bindParam(":days", $data["days"], PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    
        $stmt->close();
        $stmt = null;
    
    }	

 
    static public function mdlDelete($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE  FROM $table WHERE  id =:id");
        $stmt -> bindParam(":id", $data, PDO::PARAM_STR);
        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";	
        }
        $stmt -> close();
        $stmt = null;
    }	


    
    static public function mdlgetRate($age, $terms) {   
        try {
            // Create a new database connection
            $conn = (new Connection)->connect();
            // Prepare the SQL statement based on the age
            if($age >= 18 && $age <= 59){
               $stmt = $conn->prepare("SELECT * FROM insurance_oona1 WHERE terms = :terms LIMIT 1");
            }else if($age >= 60 && $age <= 65){
                $stmt = $conn->prepare("SELECT * FROM insurance_oona2 WHERE terms = :terms LIMIT 1");
            }else if($age >= 71 && $age <= 80){
                $stmt = $conn->prepare("SELECT * FROM insurance_oona3 WHERE terms = :terms LIMIT 1");
            }else{
                $stmt = $conn->prepare("SELECT * FROM insurance_oona1 WHERE terms = :terms LIMIT 1");
            }
            // Bind the terms parameter
            $stmt->bindParam(":terms", $terms, PDO::PARAM_STR);
            // Execute the statement
            $stmt->execute();
            // Fetch and return the results
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error: " . $e->getMessage();
            return [];
        } finally {
            // Free up the resources
            $stmt = null;
            $conn = null;
        }
    }
    


    static public function mdlShowEMBBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM accounting_branches WHERE branch_name LIKE 'EMB%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowFCHBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM accounting_branches WHERE branch_name LIKE 'FCH%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowRLCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM accounting_branches WHERE branch_name LIKE 'RLC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowELCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM accounting_branches WHERE branch_name LIKE 'ELC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlGetTotalAmount($branch_name, $date, $type){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(amount) as total_amount FROM insurance WHERE avail_date = :date AND branch_name = :branch_name AND ins_type = :ins_type ");
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt->bindParam(":ins_type", $type, PDO::PARAM_STR);
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlGetInsuranceChecker($avail_date){
        $stmt = (new Connection)->connect()->prepare("SELECT DISTINCT a.id, a.branch_name
        FROM accounting_branches a
        LEFT JOIN insurance b ON a.branch_name = b.branch_name AND b.avail_date = :avail_date
        WHERE (b.avail_date IS NULL OR b.amount_loan IS NULL OR b.amount_loan = '')
           OR (a.branch_name IN (
                SELECT i.branch_name
                FROM insurance i
                WHERE i.avail_date = :avail_date AND (i.amount_loan IS NULL OR i.amount_loan = '')
            ) AND b.branch_name IS NULL)
        ORDER BY a.id ASC;");
        $stmt->bindParam(":avail_date", $avail_date, PDO::PARAM_STR);
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlget_cbi_Rate($terms){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance_cbi WHERE terms = :terms LIMIT 1");
        $stmt->bindParam(":terms", $terms, PDO::PARAM_STR);
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    

    static public function mdlShowFilterCBIInsurance($date){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
        if($type == "admin" || $type == "insurance_admin"){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND ins_type = 'CBI' ORDER BY b.id, a.id");
        }else{
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'CBI'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowFilterCBIInsuranceByBranch($date, $branch){
     
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND a.branch_name LIKE '$branch%' AND ins_type = 'CBI' ORDER BY b.id, a.id");
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowFilterCBIInsuranceBranch($date, $branch_name){
        if ($date == "") {
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE branch_name = '$branch_name' AND ins_type = 'CBI' ");

        }else{
              $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'CBI'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    static public function mdlgetPhilRate($age, $terms) {   
        try {
            // Create a new database connection
            $conn = (new Connection)->connect();
            // Prepare the SQL statement based on the age
            if($age >= 60 && $age <= 65){
                $stmt = $conn->prepare("SELECT rate1 as amount, terms FROM insurance_phil WHERE terms = :terms LIMIT 1");
            }else if($age >= 71 && $age <= 75){
                $stmt = $conn->prepare("SELECT rate2 as amount, terms FROM insurance_phil WHERE terms = :terms LIMIT 1");
            }else{
                $stmt = $conn->prepare("SELECT rate1 as amount, terms FROM insurance_phil WHERE terms = :terms LIMIT 1");
            }
            // Bind the terms parameter
            $stmt->bindParam(":terms", $terms, PDO::PARAM_STR);
            // Execute the statement
            $stmt->execute();
            // Fetch and return the results
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error: " . $e->getMessage();
            return [];
        } finally {
            // Free up the resources
            $stmt = null;
            $conn = null;
        }
    }


    static public function mdlShowFilterPhilInsurance($date){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
        if($type == "admin" || $type == "insurance_admin"){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND ins_type = 'PHIL' ORDER BY b.id, a.id");
        }else{
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'PHIL'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

    static public function mdlShowFilterPhilInsuranceByBranch($date, $branch){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
       
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance a INNER JOIN accounting_branches b
         ON a.branch_name = b.branch_name WHERE avail_date = '$date' AND a.branch_name LIKE '$branch%' AND ins_type = 'PHIL'  ORDER BY b.id, a.id");
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    static public function mdlShowFilterPhilInsuranceBranch($date, $branch_name){
        if ($date == "") {
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE branch_name = '$branch_name' AND ins_type = 'PHIL' ");
        }else{
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM insurance WHERE avail_date = '$date' AND branch_name = '$branch_name' AND ins_type = 'PHIL'");
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }


    

    
}