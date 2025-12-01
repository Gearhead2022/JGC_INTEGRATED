<?php
require_once "connection.php";

class ModelPastDue{
    static public function mdlShowPastDue($user_id){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "pastdue_user"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE user_id = '$user_id'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlAccountChecker($account_no, $branch_name){
		
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no' AND branch_name = '$branch_name'");
		$stmt -> execute();
        $total = $stmt->rowCount();
        if($total > 0){
            return "not";
        }else{
            return "ok";
        }
	}
    static public function mdlShowBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE full_name LIKE 'EMB%' OR full_name LIKE 'ELC%' OR full_name LIKE 'FCH%' OR full_name LIKE 'RLC%' ORDER BY full_name");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowEMBBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'EMB%'");
	
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlShowFCHNBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names 
        WHERE branch_name LIKE 'FCH%' AND branch_name NOT IN ('FCH PARANAQUE', 'FCH MUNTINLUPA', 'FCH ANTIPOLO')");
	
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlShowFCHMBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names 
        WHERE branch_name LIKE 'FCH%' AND branch_name = 'FCH PARANAQUE' OR branch_name  =  'FCH MUNTINLUPA' OR branch_name  =  'FCH ANTIPOLO' ");
	
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlShowFCHBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'FCH%'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShoRLCBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name  FROM branch_names WHERE branch_name LIKE 'RLC%'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlShoELCBranches(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'ELC%'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowReportTarget($full_name, $date){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `past_due_targets` WHERE date = '$date' AND branch_name = '$full_name'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowFilterPastDueReport($table, $dateFrom, $dateTo, $branch_name, $class){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE refdate >= '$dateFrom' AND refdate <= '$dateTo' AND class = '$class' AND branch_name = '$branch_name' ORDER BY last_name;");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowFilterAllClass($table, $branch_name, $class){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE class = '$class' AND branch_name = '$branch_name' ORDER BY last_name");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGetDay1($full_name, $day1){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger` WHERE date = '$day1' AND include_week = 1 AND branch_name = '$full_name') AS total_debit1, (SELECT SUM(credit) FROM `past_due_ledger` 
        WHERE date = '$day1' AND credit >= 0 AND branch_name = '$full_name') AS total_day1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}
    static public function mdlGetDay2($full_name, $day2){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger` WHERE date = '$day2' AND include_week = 1 AND branch_name = '$full_name') AS total_debit1, (SELECT SUM(credit) FROM `past_due_ledger` 
        WHERE date = '$day2' AND credit >= 0 AND branch_name = '$full_name') AS total_day1");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}


    static public function mdlGetBelow6($full_name, $minRange, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger` a 
        INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE  a.date >= '$minRange' 
        AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.include_week = 1 AND b.refdate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)) AS total_debit1  ,(SELECT SUM(credit) FROM `past_due_ledger` a 
        INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE  a.date >= '$minRange' 
        AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.credit >= 0 AND b.refdate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)) AS total_below6  ");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGet6And1year($full_name, $minRange, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger` a 
        INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE  a.date >= '$minRange' 
        AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.include_week = 1 AND b.refdate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        AND b.refdate < DATE_SUB(CURDATE(), INTERVAL 6 MONTH)) AS total_debit1 ,
        (SELECT SUM(credit) FROM `past_due_ledger` a INNER JOIN past_due b ON a.account_no = b.account_no  AND a.branch_name = b.branch_name
        WHERE  a.date >= '$minRange' AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.credit >= 0 AND b.refdate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        AND b.refdate < DATE_SUB(CURDATE(), INTERVAL 6 MONTH)) AS total_below6and1 ");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}


    static public function mdlGetAbove1($full_name, $minRange, $day5){

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger` a 
        INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE  a.date >= '$minRange' 
        AND a.date <= '$day5' AND a.branch_name = '$full_name' AND a.include_week = 1 AND b.refdate <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AS total_debit1,
         (SELECT SUM(credit) FROM `past_due_ledger` a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name
         WHERE  a.date >= '$minRange' AND a.date <= '$day5' AND a.branch_name = '$full_name'
          AND a.credit >= 0 AND b.refdate <= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) AS total_above1");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlGetCumTota($full_name, $minRange, $maxRange){

	    $stmt = (new Connection)->connect()->prepare("SELECT (SELECT SUM(debit) FROM `past_due_ledger`
         WHERE  date >= '$minRange' AND date <= '$maxRange' AND include_week = 1 AND branch_name = '$full_name') as total_debit, (SELECT SUM(credit) FROM `past_due_ledger`
         WHERE  date >= '$minRange' AND date <= '$maxRange' AND credit >= 0 AND branch_name = '$full_name') as total;
         ");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}

    static public function mdlShowPastDueTarget(){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets ORDER BY `date`");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlShowPastDueLedger($account_no, $branch_name){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger WHERE account_no = '$account_no' AND branch_name ='$branch_name'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
    static public function mdlGetID($account_no){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlGetAllPastDue($idClient){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE id = '$idClient'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

static public function mdlShowGetPrevBalance($branch_name1, $account_no, $dateFrom, $dateTo){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(debit) as total_debit, SUM(credit) as total_credit  FROM past_due_ledger WHERE branch_name = '$branch_name1' AND account_no = '$account_no' AND date <= '$dateFrom'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowGetDebitAndCredit($branch_name1, $account_no, $dateFrom, $dateTo){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(debit) as get_debit, SUM(credit) as get_credit  FROM past_due_ledger WHERE branch_name = '$branch_name1' 
        AND account_no = '$account_no' AND date >= '$dateFrom' AND date <= '$dateTo' ");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowIDLedger($id){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger WHERE id = '$id'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlShowIDTarget($id){
	

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets WHERE id = '$id'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	
    static public function get_id($due_id)
    {
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();
        $sql = 'SELECT id 
                FROM past_due
                WHERE due_id = :due_id';
        $statement = $pdo->prepare($sql);
		$sql1 = 'SELECT id 
                FROM past_due ORDER BY id
                 Desc limit 1';
        $statement1 = $pdo->prepare($sql1);
		$statement1->execute();
		$row2 =$statement1->fetch(PDO::FETCH_ASSOC);


        $statement->bindParam(':due_id', $due_id, PDO::PARAM_STR);
        if ($statement->execute()) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row !== false ? $row2['id'] : false;
        }
        return false;
    }

    static public function mdlAddPastDue($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		     $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];

            $due_id =  $data["due_id"];
            $full_id1= (new ModelPastDue)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }

            $check= (new ModelPastDue)->mdlAccountChecker($account_no, $branch_name);
        
            
            if($check == "ok"){

			$stmt = $pdo->prepare("INSERT INTO $table(due_id, user_id, branch_name, account_no, last_name, first_name, middle_name, balance,
             bank, class, status, refdate, age, address, type) VALUES
             (:due_id, :user_id, :branch_name, :account_no, :last_name, :first_name, :middle_name, :balance, :bank, :class, :status, :refdate,
             :age, :address, :type)");
		
            $stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
            $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
            $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
            $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
		
		
			$stmt->execute();
			$pdo->commit();
           
			return "ok";
            $stmt->close();
	    	$stmt = null;
            }
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		
    }



    static public function mdlAddPastDueAccounts($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		
            $due_id =  $data["due_id"];
            $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];
            $due_id =  $data["due_id"];
            $full_id1= (new ModelPastDue)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }
            $check= (new ModelPastDue)->mdlAccountChecker($account_no, $branch_name);
        
            
            if($check == "ok"){

        

			$stmt = $pdo->prepare("INSERT INTO $table(due_id, user_id, branch_name, last_name, first_name, middle_name, account_no, age,
              address, balance, type, class, bank, refdate) VALUES
             (:due_id, :user_id, :branch_name, :last_name, :first_name, :middle_name, :account_no, :age, :address, :balance,
             :type, :class, :bank, :refdate)");
		
            $stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
            $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
            $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
            $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
            $stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
            $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
        
		
		
			$stmt->execute();
			$pdo->commit();
			return "ok";

            $stmt->close();
		    $stmt = null;
            }else{
                return "error2";  
            }

		}
        catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }


    static public function mdlAddLedger($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

            $amountToCheck = $data["amount"];
            if($amountToCheck < 0){
                $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, debit) VALUES
                (:user_id, :branch_name, :account_no, :date, :refno, :amount)");
            }else{
                $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, credit) VALUES
                (:user_id, :branch_name, :account_no, :date, :refno, :amount)");
            }
	
            $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
			$stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);
            $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);

			$stmt->execute();
			$pdo->commit();
			return "ok";
 
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
		$stmt->close();
		$stmt = null;
    }
    

    
static public function mdlEditPastDueAccount($table, $data){
  

    

	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name,
    branch_name = :branch_name, account_no = :account_no, age = :age, address = :address, balance = :balance, type = :type,
    class = :class, bank = :bank, refdate = :refdate, date_change = :date_change WHERE id = :id");
    
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
    $stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
    $stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
    $stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
    $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
    $stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
    $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
    $stmt->bindParam(":balance", $data["balance"], PDO::PARAM_STR);
    $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
    $stmt->bindParam(":class", $data["class"], PDO::PARAM_STR);
    $stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
    $stmt->bindParam(":refdate", $data["refdate"], PDO::PARAM_STR);
    $stmt->bindParam(":date_change", $data["date_change"], PDO::PARAM_STR);
	


	if($stmt->execute()){
		return "ok";
        $stmt->close();
	    $stmt = null;
	}else{
		return "error";
	}

}


static public function mdlAddLedgerAccount($table, $data)
{
    try{
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();

        $amountToCheck = $data["amount"];
        if($amountToCheck < 0){
            $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, debit, pay_mis, include_week) VALUES
            (:user_id, :branch_name, :account_no, :date, :refno, :amount, :pay_mis, :include_week)");
        }else{
            $stmt = $pdo->prepare("INSERT INTO $table(user_id, branch_name, account_no, date, refno, credit, pay_mis, include_week) VALUES
            (:user_id, :branch_name, :account_no, :date, :refno, :amount, :pay_mis, :include_week)");
        }
    
        $stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);  
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        $stmt->bindParam(":pay_mis", $data["pay_mis"], PDO::PARAM_STR);
        $stmt->bindParam(":include_week", $data["include_week"], PDO::PARAM_STR);

    
        $stmt->execute();
        $pdo->commit();
        return "ok";

    }catch(PDOException $exception){
        $pdo->rollBack();
        return "error";     
    }
    $stmt->close();
    $stmt = null;
}


static public function mdlEditLedger($table, $data){

    $amountToCheck = $data["amount"];

    if($amountToCheck < 0){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET date = :date, refno = :refno, credit = '', debit = :amount, pay_mis = :pay_mis, include_week = :include_week WHERE id = :id");
    }else{
        $stmt = (new Connection)->connect()->prepare("UPDATE $table SET date = :date, refno = :refno, debit = '', credit = :amount, pay_mis = :pay_mis, include_week = :include_week WHERE id = :id");
    }
    
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);   
    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
    $stmt->bindParam(":refno", $data["refno"], PDO::PARAM_STR);  
    $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
    $stmt->bindParam(":pay_mis", $data["pay_mis"], PDO::PARAM_STR);
    $stmt->bindParam(":include_week", $data["include_week"], PDO::PARAM_STR);


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}


    static public function mdlDeleteTarget($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlDeletePastdue($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlDeleteLedger($table, $data){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $data, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlAddPastDueTarget($table, $data)
{
    try{
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();

        $stmt1 = (new Connection)->connect()->prepare("SELECT * FROM past_due_targets WHERE branch_name = :branch_name AND date = :date  LIMIT 1");
        $stmt1->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt1->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $result1 = $stmt1 ->execute();

        if($stmt1->rowCount()>0){
            return "error";
        }else{

        $stmt = $pdo->prepare("INSERT INTO $table(branch_name, date, amount) VALUES
         (:branch_name, :date, :amount)");
  
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        $stmt->execute();
        $pdo->commit();
        return "ok";
        }

    }catch(PDOException $exception){
        $pdo->rollBack();
        return "error";     
    }
    $stmt->close();
    $stmt = null;
}


static public function mdlEditTarget($table, $data){

    
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET branch_name = :branch_name, date = :date, amount = :amount WHERE id = :id");
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);   
    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
    $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);


	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;

}


static public function mdlShowDuplicate(){
	

    $stmt = (new Connection)->connect()->prepare("SELECT branch_name, first_name, last_name, COUNT(*) AS duplication_count
    FROM past_due
    GROUP BY first_name, last_name
    HAVING COUNT(*) > 1 AND COUNT(DISTINCT branch_name) = COUNT(*);");

    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}


static public function mdlCheckLedger(){

    $stmt = (new Connection)->connect()->prepare("SELECT p.account_no, P.branch_name
    FROM past_due_ledger p
    LEFT JOIN past_due pd ON p.account_no = pd.account_no AND p.branch_name = pd.branch_name
    WHERE pd.account_no is null ORDER by p.branch_name");

    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlShowAllLedger(){
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlCheckFullyPaid($branch_name, $account_no){
    $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_balance,
    (SELECT SUM(debit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_debit,
      (SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS total_credit,
    (SELECT -SUM(balance) FROM past_due WHERE branch_name = '$branch_name' AND account_no = '$account_no') + 
    (SELECT SUM(debit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no' )+ 
    (SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS result");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}
static public function mdlGetAllPDRPerBranch($selectedbranch_name){
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE branch_name = '$selectedbranch_name' AND class NOT IN ('F', 'W') ORDER by account_no;");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlGetAllBadAccounts($branch_name, $lastMonth){
  
    $stmt = (new Connection)->connect()->prepare("SELECT
    COALESCE(
        (
            SELECT COUNT(account_no)
            FROM past_due
            WHERE branch_name = '$branch_name'
            AND refdate <= '$lastMonth'
            AND class NOT IN ('F', 'W')
        ), 0
    ) + COALESCE(
        (
            SELECT COUNT(account_no)
            FROM past_due
            WHERE branch_name = '$branch_name' AND refdate <= '$lastMonth'
            AND date_change > '$lastMonth'
        ), 0
    ) AS total_Bad,

    (COALESCE(
        (
            SELECT -SUM(balance)
            FROM past_due
            WHERE branch_name = '$branch_name'
            AND refdate <= '$lastMonth'
            AND class NOT IN ('F', 'W')
        ), 0
    )
    +
    COALESCE(
        (
            SELECT -SUM(balance)
            FROM past_due
            WHERE branch_name = '$branch_name'
            AND date_change > '$lastMonth'   AND refdate <= '$lastMonth'
          
        ), 0
    ))
    +
    COALESCE(
        (
            SELECT SUM(pl.debit)
            FROM past_due_ledger pl
            INNER JOIN (
                SELECT branch_name, account_no
                FROM past_due
                WHERE branch_name = '$branch_name'
                AND class NOT IN ('F', 'W')  AND refdate <= '$lastMonth'
            ) pd ON pl.branch_name = pd.branch_name AND pl.account_no = pd.account_no
            WHERE pl.date <= '$lastMonth'
        ), 0
    )
    +
    COALESCE(
        (
            SELECT SUM(pl.debit)
            FROM past_due_ledger pl
            INNER JOIN (
                SELECT branch_name, account_no
                FROM past_due
                WHERE branch_name = '$branch_name'
                AND date_change > '$lastMonth'   AND refdate <= '$lastMonth'
            ) pd ON pl.branch_name = pd.branch_name AND pl.account_no = pd.account_no
            WHERE pl.date <= '$lastMonth'
        ), 0
    )
    +
    COALESCE(
        (
            SELECT SUM(pl.credit)
            FROM past_due_ledger pl
            INNER JOIN (
                SELECT branch_name, account_no
                FROM past_due
                WHERE branch_name = '$branch_name'
                AND class NOT IN ('F', 'W')   AND refdate <= '$lastMonth'
            ) pd ON pl.branch_name = pd.branch_name AND pl.account_no = pd.account_no
            WHERE pl.date <= '$lastMonth'
        ), 0
    )
    +
    COALESCE(
        (
            SELECT SUM(pl.credit)
            FROM past_due_ledger pl
            INNER JOIN (
                SELECT branch_name, account_no
                FROM past_due
                WHERE branch_name = '$branch_name'
                AND date_change > '$lastMonth'   AND refdate <= '$lastMonth'
            ) pd ON pl.branch_name = pd.branch_name AND pl.account_no = pd.account_no
            WHERE pl.date <= '$lastMonth'
        ), 0
    ) AS result;
");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}


static public function mdlGetGoodToBad($branch_name, $month, $lastDay){
  
    $stmt = (new Connection)->connect()->prepare("SELECT account_no, branch_name, refdate, balance FROM `past_due` WHERE branch_name = '$branch_name' AND refdate >= '$month' 
    AND refdate <= '$lastDay'");
    
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlGetGoodToBad1($account_no, $branch_name, $refdate){
  
    $stmt = (new Connection)->connect()->prepare("SELECT sum(debit) as debit FROM `past_due_ledger` WHERE account_no = '$account_no' AND branch_name = '$branch_name' AND date = '$refdate'");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlGetMiscellaneous($branch_name, $month, $lastDay){
  
    $stmt = (new Connection)->connect()->prepare("SELECT sum(debit) as debit FROM `past_due_ledger` WHERE branch_name = '$branch_name' AND date >= '$month' 
    AND date <= '$lastDay' AND pay_mis = 1");
    
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlGetPDRWrittenOff($branch_name, $month, $lastDay){
  
    $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT COUNT(account_no) FROM past_due WHERE branch_name = '$branch_name' AND date_change >= '$month' AND  date_change <= '$lastDay' AND class = 'W' ) AS total_w,
 (SELECT SUM(balance) FROM past_due WHERE branch_name = '$branch_name' AND date_change >= '$month' AND  date_change <= '$lastDay' AND class = 'W'  )
 +
(SELECT abs(SUM(debit)) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.date_change >= '$month' AND  b.date_change <= '$lastDay' AND b.class = 'W')
-
(SELECT SUM(credit) FROM past_due_ledger a INNER JOIN past_due b ON a.account_no = b.account_no AND a.branch_name = b.branch_name WHERE a.branch_name = '$branch_name' AND b.date_change >= '$month' AND  b.date_change <= '$lastDay' AND b.class = 'W') AS result;");
    
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}

static public function mdlGetFullyPaid($branch_name, $month, $lastDay){
  
    $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT COUNT(account_no) FROM past_due WHERE branch_name = '$branch_name' AND date_change >= '$month' 
    AND  date_change <= '$lastDay' AND class = 'F' ) AS total_f,

(SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND date >= '$month' AND  date <= '$lastDay') as total_collection");
    
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
}



// fch negros

static public function mdlPastDueSummaryFCHNegros($branch_name_input,$dateFromMonth,$dateStart){
    $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM branch_names 
    WHERE branch_name LIKE '%FCH%' AND branch_name != 'FCH MUNTINLUPA' AND branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH ANTIPOLO' ORDER BY id");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
    }

// fch manila


static public function mdlPastDueSummaryFCHManila($branch_name_input,$dateFromMonth,$dateStart){
    $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM branch_names 
    WHERE branch_name LIKE '%FCH%' AND branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH BAGO' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH LAPU LAPU' AND branch_name != 'FCH SIQUIJOR' ORDER BY id");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
    }






// get branch name a
    static public function mdlbadAccounts($branch_name_input,$dateFromMonth,$dateStart){
        $stmt = (new Connection)->connect()->prepare("SELECT bn.branch_name
        FROM past_due pd 
        INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name
        WHERE ((pd.class = 'D' AND pd.refdate <= '$dateFromMonth')
        OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth'))
        AND bn.branch_name LIKE '%$branch_name_input%'
        GROUP BY bn.branch_name;
        
        ");
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
    }




// get total amount of S for deceased 

    static public function mdlTotalOfAmountDecease_S($branch_name_input,$dateFromMonth,$dateStart){
        $stmt = (new Connection)->connect()->prepare("SELECT
        (SELECT COUNT(type) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'S' AND class = 'D' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'D' AND date_change > '$dateFromMonth' AND refdate <= '$dateFromMonth')) AS total_S,
        (SELECT -SUM(balance) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'S' AND class = 'D' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'D' AND date_change > '$dateFromMonth' AND refdate <= '$dateFromMonth')) AS total_balance,
        (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_debit,
        (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_credit,
        (
        (SELECT -SUM(balance) FROM past_due WHERE (branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth' AND type = 'S' AND class = 'D') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'D' AND date_change > '$dateFromMonth')) +
        (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))  +
        (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))
        ) AS result
        ");
    $stmt -> execute();
    while($info2 = $stmt->fetch()){
       // $total_amount2 = abs($info2['result']);
        $total_Decease_S = $info2['total_S'];

        $try4 = $info2['result'];
        if($try4 < 0){
            $total_amount2 = abs($info2['result']);
        }else{
            $total_amount2 = $info2['result'] * -1; 
        }


    }
    return array($total_amount2, $total_Decease_S);
    }




// get total amouunt E for deceased 

    static public function mdlTotalOfAmountDecease_E($branch_name_input,$dateFromMonth,$dateStart){
    $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT COUNT(type) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'E' AND class = 'D' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'E' AND status = 'D' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) AS total_E,
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'E' AND class = 'D' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'E' AND status = 'D' AND refdate <= '$dateStart' AND date_change > '$dateFromMonth')) AS total_balance,
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_debit,
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_credit,
    (
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth' AND type = 'E' AND class = 'D') OR (branch_name = '$branch_name_input' AND type = 'E' AND status = 'D' AND date_change > '$dateFromMonth')) +
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth' ))  +
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'D' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'D' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))
    ) AS result");
    $stmt -> execute();
    while($info3 = $stmt->fetch()){
        $total_Decease_E = $info3['total_E'];

        $try3 = $info3['result'];
        if($try3 < 0){
            $total_amount3 = abs($info3['result']);
        }else{
            $total_amount3 = $info3['result'] * -1; 
        } 
    }
    return array($total_amount3, $total_Decease_E);
    }



// police action 

    static public function mdlbadAccounts_TypeP($branch_name_input,$dateFromMonth,$dateStart){
        $stmt = (new Connection)->connect()->prepare("SELECT
    (SELECT COUNT(type) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'S' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) AS total_S_type_P,
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'S' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) AS total_balance,
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_debit,
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_credit,
    (
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name = '$branch_name_input' AND type = 'S' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'S' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) +
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))  +
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'S' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'S' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))
    ) AS result,


        -- type E POLICE 
        

    (SELECT COUNT(type) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'E' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'E' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) AS total_E_type_P,
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name LIKE '%$branch_name_input%' AND type = 'E' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND type = 'E' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth')) AS total_balance,
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_debit,
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name LIKE '%$branch_name_input%' AND refdate <= '$dateFromMonth')) AS total_credit,
    (
    (SELECT -SUM(balance) FROM past_due WHERE (branch_name = '$branch_name_input' AND type = 'E' AND class = 'P' AND refdate <= '$dateFromMonth') OR (branch_name = '$branch_name_input' AND status = 'P' AND refdate <= '$dateFromMonth' AND date_change > '$dateFromMonth' AND type = 'E')) +
    (SELECT SUM(pdl.debit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))  +
    (SELECT SUM(pdl.credit) FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name INNER JOIN branch_names bn ON bn.branch_name = pd.branch_name WHERE (pd.type = 'E' AND pd.class = 'P' AND pd.refdate <= '$dateFromMonth' AND pdl.date <= '$dateFromMonth' AND bn.branch_name = '$branch_name_input') OR (bn.branch_name = '$branch_name_input' AND pd.type = 'E' AND pd.status = 'P' AND pd.date_change > '$dateFromMonth' AND bn.branch_name = '$branch_name_input' AND refdate <= '$dateFromMonth'))
    ) AS result2   
        ");
    $stmt -> execute();
    $total_ES_Police = 0;
    $totalAmountPolice_ES = 0;

    while($info4 = $stmt->fetch()){
        $total_S_Police = $info4['total_S_type_P'];
        $total_E_Police = $info4['total_E_type_P'];
        $try = $info4['result2'];
        if($try < 0){
            $Police_AmountTypeE = abs($info4['result2']);
        }else{
            $Police_AmountTypeE = $info4['result2'] * -1; 
        }
       
        
        $try2 = $info4['result'];
        if($try2 < 0){
            $Police_Amount = abs($info4['result']);
        }else{
            $Police_Amount = $info4['result'] * -1; 
        }
       // $Police_Amount = abs($info4['result']);
        $formatted_Police_Amount = number_format($Police_Amount, 2, '.',',');

        $formatted_Police_AmountTypeE = number_format($Police_AmountTypeE, 2, '.',',');
        // total of e and s type police
        $total_ES_Police = $total_S_Police + $total_E_Police;
    
        $totalAmountPolice_ES_Notformatted = $Police_Amount + $Police_AmountTypeE;
        $totalAmountPolice_ES = number_format($Police_Amount + $Police_AmountTypeE, 2, '.', ',');
    }
        // $Police_AmountTypeE = abs($info4['result2']);
    return array($total_S_Police, $total_E_Police, $formatted_Police_Amount, $formatted_Police_AmountTypeE, $total_ES_Police, $totalAmountPolice_ES,$totalAmountPolice_ES_Notformatted, $Police_Amount,$Police_AmountTypeE);

    }

    // past due account summary yearly

    static public function mdlPastDueSummarys($branch_name_input){
	
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE 
        '%$branch_name_input%'");
    
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
    }
    
    static public function mdlPastDueSummaryFCHManilas(){
        
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name = 'FCH MUNTINLUPA' 
        or branch_name = 'FCH PARANAQUE' or branch_name = 'FCH ANTIPOLO' ");
    
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
    }
    
    static public function mdlPastDueSummaryFCHNegross(){
        
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%FCH%' AND branch_name != 'FCH MUNTINLUPA' AND branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH ANTIPOLO'");
    
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
    }
    
    static public function mdlPastDueAccountsPerBranchs($branch_name, $dateFrom, $dateStart, $payEnd) {
        $conn = (new Connection)->connect();
        
        $stmt = $conn->prepare("SELECT
        pd.branch_name,
        pd.account_no,
        pd.balance,
        pd.refdate,
        CASE
    
            WHEN pd.balance > 0 THEN
                ((-1 * pd.balance) 
                + SUM(CASE WHEN (pl.date <= :payEnd AND pl.date >= :dateStart AND pd.refdate <= :dateFrom AND pd.refdate >= :dateStart AND pd.class NOT IN ('W', 'F') and ( pl.debit != null or pl.debit != '')) THEN pl.debit ELSE 0 END)) 
                + SUM(CASE WHEN (pl.date <= :payEnd AND pl.date >= :dateStart AND pd.refdate <= :dateFrom AND pd.refdate >= :dateStart AND pd.class NOT IN ('W', 'F') and ( pl.credit != null or pl.credit != '')) THEN pl.credit ELSE 0 END)
            ELSE
                  SUM(CASE WHEN (pl.date <= :payEnd AND pl.date >= :dateStart AND pd.refdate <= :dateFrom AND pd.refdate >= :dateStart AND pd.class NOT IN ('W', 'F') and ( pl.debit != null or pl.debit != '')) THEN pl.debit ELSE 0 END)
                + SUM(CASE WHEN (pl.date <= :payEnd AND pl.date >= :dateStart AND pd.refdate <= :dateFrom AND pd.refdate >= :dateStart AND pd.class NOT IN ('W', 'F') and ( pl.credit != null or pl.credit != '')) THEN pl.credit ELSE 0 END)
        
        END AS calculated_balance
        
        FROM past_due pd
        LEFT JOIN past_due_ledger pl ON pd.branch_name = pl.branch_name AND pd.account_no = pl.account_no
        WHERE pd.branch_name = :branch_name AND pd.refdate <= :dateFrom AND pd.refdate >= :dateStart AND pd.class NOT IN ('W', 'F')
        GROUP BY pd.branch_name, pd.account_no, pd.balance, pd.refdate
        ORDER BY calculated_balance ASC;
        ");
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':dateFrom', $dateFrom);
        $stmt->bindParam(':dateStart', $dateStart);
        $stmt->bindParam(':payEnd', $payEnd);
        $stmt->execute();
    
        $total_balance = 0;
        $count_accounts = 0;
    
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $calculated_balance = $result['calculated_balance'];
    
            $total_balance += $calculated_balance;
    
            if ($calculated_balance != 0) {
                $count_accounts++;
            }
        }
    
        return array($total_balance, $count_accounts);
    }
    
    
    
    static public function mdlAddCorrespondent($table, $data){
    
        $permit = (new Connection)->connect()->query("SELECT * from $table ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
              if(empty($permit)){
                $id = 0;
    
                $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (preparedBy ,checkedBy, notedBy) 
                    VALUES (:preparedBy, :checkedBy, :notedBy)");
    
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":checkedBy", $data["checkedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":notedBy", $data["notedBy"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
    
              }else{
    
                $id = $permit['id'];
    
                $stmt = (new Connection)->connect()->prepare("UPDATE $table SET preparedBy = :preparedBy, checkedBy = :checkedBy, notedBy = :notedBy WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":checkedBy", $data["checkedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":notedBy", $data["notedBy"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
              }
    
        
    }

     static public function mdlAddReportSequence($print_id, $report_type)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO report_logs(print_id, report_type) VALUES
             (:print_id, :report_type)");
            $stmt->bindParam(":print_id", $print_id, PDO::PARAM_STR);
            $stmt->bindParam(":report_type", $report_type, PDO::PARAM_STR);
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
    


}