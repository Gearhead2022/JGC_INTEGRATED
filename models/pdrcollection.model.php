<?php

require_once "connection.php";
class ModelPDRCollection{

    static public function mdlUpdatePDRRecords($data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO `tmp_pdr_coll` (account_no, first_name, middle_name, last_name, status, edate, tdate, ref, prev_bal, amt_credit, amt_debit, end_bal, branch_name, date_uploaded) VALUES (:account_no, :first_name, :middle_name, :last_name, :status, :edate, :tdate, :ref, :prev_bal, :amt_credit, :amt_debit, :end_bal, :branch_name, :date_uploaded)");
			
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":edate", $data["edate"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			$stmt->bindParam(":ref", $data["ref"], PDO::PARAM_STR);
			$stmt->bindParam(":prev_bal", $data["prev_bal"], PDO::PARAM_STR);
			$stmt->bindParam(":amt_credit", $data["amt_credit"], PDO::PARAM_STR);
			$stmt->bindParam(":amt_debit", $data["amt_debit"], PDO::PARAM_STR);
			$stmt->bindParam(":end_bal", $data["end_bal"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $data["date_uploaded"], PDO::PARAM_STR);

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

	static public function mdlCheckIDExist($account_no, $tdate, $branch_name) {
		// Initialize the connection just once and use it for both queries
		$dbConnection = (new Connection)->connect();
	
		// Consolidate the query and parameter binding into a reusable function
		$checkExistence = function($table) use ($dbConnection, $account_no, $tdate, $branch_name) {
			$stmt =  (new Connection)->connect()->prepare("SELECT 1 FROM $table WHERE account_no = :account_no AND tdate = :tdate AND branch_name = :branch_name LIMIT 1");
			$stmt->bindParam(':account_no', $account_no);
			$stmt->bindParam(':tdate', $tdate);
			$stmt->bindParam(':branch_name', $branch_name);
			$stmt->execute();
	
			return $stmt->rowCount() > 0;
		};
	
		// Use the reusable function to check both tables
		if ($checkExistence('tmp_pdr_coll') || $checkExistence('pdr_coll')) {
			return "exist";
		} else {
			return "not exist";
		}
	}
	
	
    static public function mdlShowAllPDRList($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `tmp_pdr_coll` WHERE branch_name = '$branch_name'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

	static public function mdlGetPDRAccountInfo($account_no, $tdate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `tmp_pdr_coll` WHERE account_no = '$account_no' AND tdate = '$tdate' AND branch_name = '$branch_name'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

	static public function mdlAddPDRColletionToArchieve($table, $data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO `$table` (account_no, first_name,  middle_name, last_name, status, edate, tdate, ref, prev_bal, credit, debit, end_bal, branch_name, date_uploaded) VALUES (:account_no, :first_name, :middle_name, :last_name, :status, :edate, :tdate, :ref, :prev_bal, :credit, :debit, :end_bal, :branch_name, :date_uploaded)");
		
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":edate", $data["edate"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			$stmt->bindParam(":ref", $data["ref"], PDO::PARAM_STR);
			$stmt->bindParam(":prev_bal", $data["prev_bal"], PDO::PARAM_STR);
			$stmt->bindParam(":credit", $data["credit"], PDO::PARAM_STR);
			$stmt->bindParam(":debit", $data["debit"], PDO::PARAM_STR);
			$stmt->bindParam(":end_bal", $data["end_bal"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $data["date_procceeed"], PDO::PARAM_STR);

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

	// static public function mdlShowAllArchivePDRList($branch_name){
    //     $stmt = (new Connection)->connect()->prepare("SELECT * FROM `pdr_coll` WHERE branch_name = '$branch_name'");
    //     $stmt -> execute();
    //     return $stmt -> fetchAll();

    //     $stmt = null;
    // }

	static public function mdlShowAllFilterArchivePDRList($branch_name, $from_date, $to_date, $report){

		if ($report == 'YES') {
			    // Prepare the SQL query with placeholders for parameters
				$stmt = (new Connection)->connect()->prepare("
				SELECT * FROM `pdr_coll`
				WHERE branch_name = :branch_name 
				AND tdate >= :from_date 
				AND tdate <= :to_date
			");
		} else {
			    // Prepare the SQL query with placeholders for parameters
				$stmt = (new Connection)->connect()->prepare("
				SELECT * FROM `pdr_coll`
				WHERE branch_name = :branch_name 
				AND tdate >= :from_date 
				AND tdate <= :to_date
			");
		}
		
		// Bind the parameters to the prepared statement
		$stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt->bindParam(":from_date", $from_date, PDO::PARAM_STR);
		$stmt->bindParam(":to_date", $to_date, PDO::PARAM_STR);

		// Execute the statement
		$stmt->execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
		
    }

	// get values from each acoount with transaction date//
	// static public function mdlShowGetPrevBalance($branch_name, $account_no, $date){
	
	//     $stmt = (new Connection)->connect()->prepare("SELECT
	// 			(
	// 				SELECT -SUM(balance)
	// 				FROM past_due 
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' 
	// 			) +
	// 			(
	// 				SELECT SUM(debit)
	// 				FROM past_due_ledger 
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' AND date <= '$date'
	// 			) +
	// 			(
	// 				SELECT SUM(credit)
	// 				FROM past_due_ledger
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' AND date <= '$date'
	// 			) AS prev_bal,
	// 				(
	// 				SELECT -SUM(balance)
	// 				FROM past_due
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' AND date <= '$date'
	// 			) as beginning,
	// 			(
	// 				SELECT SUM(debit)
	// 				FROM past_due_ledger
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' AND date <= '$date'
	// 			) as debit,
	// 			(
	// 				SELECT SUM(credit)
	// 				FROM past_due_ledger
	// 				WHERE branch_name = '$branch_name' AND account_no = '$account_no' AND date <= '$date'
	// 			) as credit,
				
	// 			pd.first_name, pd.last_name, pd.branch_name, pd.account_no
	// 		FROM past_due pd
	// 		INNER JOIN past_due_ledger pdl ON pd.account_no = pdl.account_no AND pd.branch_name = pdl.branch_name
	// 		WHERE pd.branch_name = '$branch_name' AND pd.account_no = '$account_no'
	// 	LIMIT 1");
						
	// 	$stmt -> execute();
	// 	return $stmt -> fetchAll();
	// 	$stmt -> close();
	// 	$stmt = null;
	// }

	
	// static public function mdlGetPDRAccountInfoById($account_no, $branch_name){
	// 	$stmt = (new Connection)->connect()->prepare("SELECT
	 
	// 	(SELECT -SUM(balance) FROM past_due pd INNER JOIN past_due_ledger pdl on pd.account_no = pdl.account_no WHERE pd.branch_name = '$branch_name' AND pd.account_no = '$account_no') + 
	// 	(SELECT SUM(debit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no' ) + 
	// 	(SELECT SUM(credit) FROM past_due_ledger WHERE branch_name = '$branch_name' AND account_no = '$account_no') AS prev_bal,
		
	// 	first_name, last_name, status, refdate, date, refno, branch_name
	// 	FROM past_due pd INNER JOIN past_due_ledger pdl ON pd.account_no = pdl.account_no and pd.branch_name = pdl.branch_name
	// 	WHERE pd.branch_name = '$branch_name' AND pd.account_no = '$account_no' ORDER BY date ASC LIMIT 1;
	// 	");

	// 	$stmt -> execute();
	// 	return $stmt -> fetchAll();
	// 	$stmt -> close();
	// 	$stmt = null;
	// }


	static public function mdlGetPDRAccountInfoById($account_no, $branch_name) {
		$db = (new Connection())->connect();

		$check= (new ModelPDRCollection)->mdlAccountCheckerInLedger($account_no, $branch_name);
        
		if($check == "no"){

			$sql = "SELECT balance as prev_bal, first_name, last_name, middle_name, status, refdate, class, branch_name, account_no, due_id FROM past_due WHERE branch_name = :branch_name AND account_no = :account_no
				LIMIT 1";

		} else {
			$sql = "SELECT
					(
						SELECT -SUM(pd.balance)
						FROM past_due pd
						WHERE pd.branch_name = :branch_name AND pd.account_no = :account_no
					) +
					(
						SELECT SUM(pdl.debit)
						FROM past_due_ledger pdl
						WHERE pdl.branch_name = :branch_name AND pdl.account_no = :account_no
					) +
					(
						SELECT SUM(pdl.credit)
						FROM past_due_ledger pdl
						WHERE pdl.branch_name = :branch_name AND pdl.account_no = :account_no
					) AS prev_bal,
					pd.due_id, pd.first_name, pd.last_name, pd.status, pd.refdate, pdl.date, pd.middle_name,  pd.balance, pd.class, pdl.refno, pd.branch_name, pd.account_no
				FROM past_due pd
				LEFT JOIN past_due_ledger pdl ON pd.account_no = pdl.account_no AND pd.branch_name = pdl.branch_name
				WHERE pd.branch_name = :branch_name AND pd.account_no = :account_no
				ORDER BY pdl.date ASC
				LIMIT 1";
		}

		$stmt = $db->prepare($sql);
	
		// Bind parameters
		$stmt->bindParam(':account_no', $account_no, PDO::PARAM_STR);
		$stmt->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);
	
		$stmt->execute();
	
		$result = $stmt->fetchAll();
	
		// No need to close the statement in PDO; just unset it if you want to clean up
		$stmt = null;
	
		return $result;
	}
	
	

	// migration of datatables of pastdue

	static public function mdlAccountChecker($account_no, $branch_name){
		
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no' AND branch_name = '$branch_name'");
		$stmt -> execute();
        $total = $stmt->rowCount();
        if($total > 0){
            return "yes";
        }else{
            return "no";
        }
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


	static public function mdlAddPastDueAccounts($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		
            $due_id =  $data["due_id"];
            $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];
            $full_id1= (new ModelPDRCollection)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }
            $check= (new ModelPDRCollection)->mdlAccountChecker($account_no, $branch_name);
        
            if($check == "no"){

				$stmt = $pdo->prepare("INSERT INTO $table(due_id, branch_name, last_name, first_name, middle_name, account_no, balance, refdate, class, date_change) 
				VALUES (:due_id, :branch_name, :last_name, :first_name, :middle_name, :account_no, :balance, :refdate, :status, :date_change)");
			
				$stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
				$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
				$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
				$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
				$stmt->bindParam(":balance", $data["prev_bal"], PDO::PARAM_STR);
				$stmt->bindParam(":refdate", $data["edate"], PDO::PARAM_STR);
				$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
				$stmt->bindParam(":date_change", $data["date_change"], PDO::PARAM_STR);
			$stmt->execute();
			$pdo->commit();
			return "ok";

            $stmt->close();
		    $stmt = null;
			
            }else{

				$stmt = (new Connection)->connect()->prepare("UPDATE $table SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name,
				branch_name = :branch_name, account_no = :account_no, refdate = :refdate, class = :status, date_change = :date_change WHERE account_no = :account_no and branch_name = :branch_name");
				
				$stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
				$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
				$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
				$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
				$stmt->bindParam(":refdate", $data["edate"], PDO::PARAM_STR);
				$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
				$stmt->bindParam(":date_change", $data["date_change"], PDO::PARAM_STR);
				if($stmt->execute()){
					return "ok";
					$stmt->close();
					$stmt = null;
				}else{
					return "error";
				}  
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

			$stmt = $pdo->prepare("INSERT INTO $table(branch_name, account_no, date, refno, credit, debit) VALUES
			(:branch_name, :account_no, :date, :refno, :credit, :debit)");
			
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
            $stmt->bindParam(":date", $data["tdate"], PDO::PARAM_STR);
			$stmt->bindParam(":refno", $data["ref"], PDO::PARAM_STR);
            $stmt->bindParam(":credit", $data["credit"], PDO::PARAM_STR);
			$stmt->bindParam(":debit", $data["debit"], PDO::PARAM_STR);

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

	static public function mdlAddPastDueAccountsById($table, $data)
    {
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
		
            $due_id =  $data["due_id"];
            $branch_name =  $data["branch_name"];
            $account_no =  $data["account_no"];
            $full_id1= (new ModelPDRCollection)->get_id($due_id);
            $last_id = $full_id1 + 1;
            $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;   
            if (!$full_id1) {
                $id_holder = $due_id;
            }
            $check= (new ModelPDRCollection)->mdlAccountChecker($account_no, $branch_name);
        
            if($check == "no"){

				$stmt = $pdo->prepare("INSERT INTO $table(due_id, branch_name, last_name, first_name, middle_name, account_no, balance, refdate, status) 
				VALUES (:due_id, :branch_name, :last_name, :first_name, :middle_name, :account_no, :balance, :refdate, :status)");
			
				$stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
				$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
				$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
				$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
				$stmt->bindParam(":balance", $data["prev_bal"], PDO::PARAM_STR);
				$stmt->bindParam(":refdate", $data["edate"], PDO::PARAM_STR);
				$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);

				$stmt->execute();
				$pdo->commit();
				return "ok";

				$stmt->close();
				$stmt = null;
			
            }else{

				$stmt = (new Connection)->connect()->prepare("UPDATE $table SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name,
				branch_name = :branch_name, account_no = :account_no, refdate = :refdate, status = :status WHERE account_no = :account_no and due_id = :due_id");
				
				$stmt->bindParam(":due_id", $id_holder, PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
				$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
				$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
				$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
				$stmt->bindParam(":refdate", $data["edate"], PDO::PARAM_STR);
				$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
				
				if($stmt->execute()){
					return "ok";
					$stmt->close();
					$stmt = null;
				}else{
					return "error";
				}  
            }
		}

			catch(PDOException $exception){
				$pdo->rollBack();
				return "error";     
			}
	}

	static public function mdlDeletePDRCollection($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE account_no = :account_no AND tdate = :tdate AND branch_name = :branch_name AND id = :id");
		$stmt->bindParam(":account_no", $data['account_no'], PDO::PARAM_STR);
		$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";	
		}else{
			return "error";		
		}
		$stmt -> close();
        $stmt = null;

	}

	static public function mdlDeletePDRCollectionArchive($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE account_no = :account_no AND tdate = :tdate AND branch_name = :branch_name");
	
		$stmt->bindParam(":account_no", $data['account_no'], PDO::PARAM_STR);
		$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		

		if($stmt -> execute()){
			return "ok";	
		}else{
			return "error";		
		}
		$stmt -> close();
        $stmt = null;

	}

	static public function mdlDeletePDRLedger($table, $data){
		
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE account_no = :account_no AND date = :tdate AND branch_name = :branch_name");
	
		$stmt->bindParam(":account_no", $data['account_no'], PDO::PARAM_STR);
		$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		
		if($stmt -> execute()){
			return "ok";	
		}else{
			return "error";		
		}
		$stmt -> close();
        $stmt = null;

	}

	static public function mdlShowPastDue($branch_name){
		
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowPastDueLedger($account_no, $branch_name){

	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger pdl INNER JOIN past_due pd ON pdl.account_no = pd.account_no AND pdl.branch_name = pd.branch_name
		 WHERE pd.account_no = '$account_no' AND pd.branch_name ='$branch_name'");
	
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlAccountIDChecker($account_no, $branch_name){
		
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due WHERE account_no = '$account_no' AND branch_name = '$branch_name'");
		$stmt -> execute();
        $total = $stmt->rowCount();
        if($total > 0){
            return "yes";
        }else{
            return "no";
        }
	}

	// 03-15-24 update

	static public function mdlUpdatePrintStatus($branch_name, $from_date, $to_date){
		
		$stmt = (new Connection)->connect()->prepare("UPDATE `pdr_coll` SET p_status = 'disabled' WHERE branch_name = :branch_name AND
		  tdate >= :from_date AND tdate <= :to_date");
				
		$stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt->bindParam(":from_date", $from_date, PDO::PARAM_STR);
		$stmt->bindParam(":to_date", $to_date, PDO::PARAM_STR);
	
		if($stmt->execute()){
			return "ok";
			$stmt->close();
			$stmt = null;
		}else{
			return "error";
		}  
	}		
	
	static public function mdlUpdatePDRRecordsNew($table, $data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO `$table` (due_id, account_no, first_name, middle_name, last_name, age, bank, address, type, class, refdate, balance, branch_name) VALUES (:due_id, :account_no, :first_name, :middle_name, :last_name, :age, :bank, :address, :type, :class, :refdate, :balance, :branch_name)");
			
			$stmt->bindParam(":due_id", $data["due_id"], PDO::PARAM_STR);
			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
			$stmt->bindParam(":first_name", $data["first_name"], PDO::PARAM_STR);
			$stmt->bindParam(":middle_name", $data["middle_name"], PDO::PARAM_STR);
			$stmt->bindParam(":last_name", $data["last_name"], PDO::PARAM_STR);
			$stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
			$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
			$stmt->bindParam(":class", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":refdate", $data["edate"], PDO::PARAM_STR);
			$stmt->bindParam(":balance", $data["prev_bal"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			// $stmt->bindParam(":date_uploaded", $data["date_uploaded"], PDO::PARAM_STR);

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
    
    // April 20 2024

	static public function mdlGetOLRIDSeries($branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * from past_due WHERE branch_name = '$branch_name' AND account_no LIKE '000%'");
        $stmt -> execute();
        $total = $stmt->rowCount();

		return $total;

        $stmt = null;
    }
    
    	static public function mdlAccountCheckerInLedger($account_no, $branch_name){
		
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM past_due_ledger WHERE account_no = '$account_no' AND branch_name = '$branch_name'");
		$stmt -> execute();
        $total = $stmt->rowCount();
        if($total > 0){
            return "yes";
        }else{
            return "no";
        }
	}
	
}