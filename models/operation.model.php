<?php

require_once "connection.php";

class ModelOperation{

    static public function mdlShowOperation($branch_name){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "operation_admin"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_gross_out");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_gross_out WHERE branch_name = '$branch_name'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlGetGrossinBal($branch_name, $type){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal WHERE branch_name = '$branch_name' AND type = '$type'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function get_user_id($chk_id)
		{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$sql = 'SELECT id 
					FROM checklist 
					WHERE chk_id = :chk_id';
			$statement = $pdo->prepare($sql);

			$statement->bindParam(':chk_id', $chk_id, PDO::PARAM_STR);
			if ($statement->execute()) {
				$row = $statement->fetch(PDO::FETCH_ASSOC);
				return $row !== false ? $row['id'] : false;
			}
			return false;
		}
	static public function mdlAddBeginningBalance($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, amount) VALUES (:type, :date, :branch_name, :amount)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
    static public function mdlAddGrossin($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, walkin, sales_rep, returnee, runners_agent, transfer) 
        VALUES (:type, :date, :branch_name, :walkin, :sales_rep, :returnee, :runners_agent, :transfer)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":walkin", $data["walkin"], PDO::PARAM_INT);
        $stmt->bindParam(":sales_rep", $data["sales_rep"], PDO::PARAM_INT);
        $stmt->bindParam(":returnee", $data["returnee"], PDO::PARAM_INT);
        $stmt->bindParam(":runners_agent", $data["runners_agent"], PDO::PARAM_INT);
        $stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}
    static public function mdlAddOutgoing($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(type, date, branch_name, fully_paid, deceased, transfer, gawad, bad_accounts) 
        VALUES (:type, :date, :branch_name, :fully_paid, :deceased, :transfer, :gawad, :bad_accounts)");
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":fully_paid", $data["fully_paid"], PDO::PARAM_INT);
        $stmt->bindParam(":deceased", $data["deceased"], PDO::PARAM_INT);
        $stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_INT);
        $stmt->bindParam(":gawad", $data["gawad"], PDO::PARAM_INT);
        $stmt->bindParam(":bad_accounts", $data["bad_accounts"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function mdlGetGrossinCumi($previousDate, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT sum(walkin) + SUM(sales_rep) + SUM(returnee) + SUM(runners_agent) + SUM(transfer) as total_cumi 
		FROM `op_grossin` WHERE branch_name = '$full_name' AND date <= '$previousDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetOutgoingCumi($previousDate, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT sum(fully_paid) + SUM(deceased) + SUM(transfer) + SUM(gawad) + SUM(bad_accounts) as total_cumi 
		FROM `op_outgoing` WHERE branch_name = '$full_name' AND date <= '$previousDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowGrossinIdOperation($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_grossin` WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowOutgoingIdOperation($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_outgoing` WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlEditGrossin($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `date` = :date, walkin = :walkin, 
		sales_rep = :sales_rep, `returnee` = :returnee, `transfer` = :transfer, `runners_agent` = :runners_agent WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
		$stmt->bindParam(":walkin", $data["walkin"], PDO::PARAM_STR);
		$stmt->bindParam(":sales_rep", $data["sales_rep"], PDO::PARAM_STR);
		$stmt->bindParam(":returnee", $data["returnee"], PDO::PARAM_STR);
		$stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_STR);
		$stmt->bindParam(":runners_agent", $data["runners_agent"], PDO::PARAM_STR);
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}
	static public function mdlEditOutGoing($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `date` = :date, fully_paid = :fully_paid, 
		deceased = :deceased, `transfer` = :transfer, `gawad` = :gawad, `bad_accounts` = :bad_accounts WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
		$stmt->bindParam(":fully_paid", $data["fully_paid"], PDO::PARAM_STR);
		$stmt->bindParam(":deceased", $data["deceased"], PDO::PARAM_STR);
		$stmt->bindParam(":transfer", $data["transfer"], PDO::PARAM_STR);
		$stmt->bindParam(":gawad", $data["gawad"], PDO::PARAM_STR);
		$stmt->bindParam(":bad_accounts", $data["bad_accounts"], PDO::PARAM_STR);
	
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}  
	static public function mdlDelete($table, $id){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
		$stmt ->bindParam(":id", $id, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
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


	static public function mdlGetGrossinData($branch_name, $from, $to){
	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(walkin) as walkin, SUM(sales_rep) as sales_rep , SUM(returnee) as returnee, SUM(runners_agent) as runners_agent,
		SUM(transfer) as transfer FROM `op_grossin` WHERE branch_name = '$branch_name' AND date >= '$from' AND date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetOutgoingData($branch_name, $from, $to){
	    $stmt = (new Connection)->connect()->prepare("SELECT SUM(fully_paid) as fully_paid, SUM(deceased) as deceased,
		 SUM(gawad) as gawad, SUM(bad_accounts) as bad_accounts,
		SUM(transfer) as transfer FROM `op_outgoing` WHERE branch_name = '$branch_name' AND date >= '$from' AND date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllFCHBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'FCH%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllRLCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'RLC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllELCBranches(){
	    $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'ELC%'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlAddLSORBeginningBalance($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(datefrom, dateto, branch_name, amount) VALUES (:datefrom, :dateto, :branch_name, :amount)");
        $stmt->bindParam(":datefrom", $data["datefrom"], PDO::PARAM_STR);
        $stmt->bindParam(":dateto", $data["dateto"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function AddLSOR($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(branch_name, date, fin_stable, app_wc, low_cashout, existing_loan, other_resched_gawad, other_sched_gawad,
		sched_applynow, ssp_overage, lack_requirements, undecided, refuse_transfer, inquired_only, new_policy, not_goodcondition, guardianship, plp, not_qualified, 
		eighteen_mos_sssloan, on_process) VALUES (:branch_name, :date, :fin_stable, :app_wc, :low_cashout, :existing_loan, :other_resched_gawad, :other_sched_gawad,
		:sched_applynow, :ssp_overage, :lack_requirements, :undecided, :refuse_transfer, :inquired_only, :new_policy, :not_goodcondition, :guardianship, :plp, :not_qualified, 
		:eighteen_mos_sssloan, :on_process)");
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":fin_stable", $data["fin_stable"], PDO::PARAM_INT);
		$stmt->bindParam(":app_wc", $data["app_wc"], PDO::PARAM_INT);
		$stmt->bindParam(":low_cashout", $data["low_cashout"], PDO::PARAM_INT);
		$stmt->bindParam(":existing_loan", $data["existing_loan"], PDO::PARAM_INT);
		$stmt->bindParam(":other_resched_gawad", $data["other_resched_gawad"], PDO::PARAM_INT);
		$stmt->bindParam(":other_sched_gawad", $data["other_sched_gawad"], PDO::PARAM_INT);
		$stmt->bindParam(":sched_applynow", $data["sched_applynow"], PDO::PARAM_INT);
		$stmt->bindParam(":ssp_overage", $data["ssp_overage"], PDO::PARAM_INT);
		$stmt->bindParam(":lack_requirements", $data["lack_requirements"], PDO::PARAM_INT);
		$stmt->bindParam(":undecided", $data["undecided"], PDO::PARAM_INT);
		$stmt->bindParam(":refuse_transfer", $data["refuse_transfer"], PDO::PARAM_INT);
		$stmt->bindParam(":inquired_only", $data["inquired_only"], PDO::PARAM_INT);
		$stmt->bindParam(":new_policy", $data["new_policy"], PDO::PARAM_INT);
		$stmt->bindParam(":not_goodcondition", $data["not_goodcondition"], PDO::PARAM_INT);
		$stmt->bindParam(":guardianship", $data["guardianship"], PDO::PARAM_INT);
		$stmt->bindParam(":plp", $data["plp"], PDO::PARAM_INT);
		$stmt->bindParam(":not_qualified", $data["not_qualified"], PDO::PARAM_INT);
		$stmt->bindParam(":eighteen_mos_sssloan", $data["eighteen_mos_sssloan"], PDO::PARAM_INT);
		$stmt->bindParam(":on_process", $data["on_process"], PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function mdlGetLSOR($branch_name, $currentDate){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(fin_stable) as fin_stable, SUM(app_wc) as app_wc, SUM(low_cashout) as low_cashout, 
		SUM(existing_loan) as existing_loan, SUM(other_resched_gawad) as other_resched_gawad, SUM(other_sched_gawad) as other_sched_gawad, 
		SUM(sched_applynow) as sched_applynow, SUM(ssp_overage) as ssp_overage, SUM(lack_requirements) as lack_requirements, SUM(undecided) as undecided,
		 SUM(refuse_transfer) as refuse_transfer, SUM(inquired_only) as inquired_only, SUM(new_policy) as new_policy, 
		 SUM(not_goodcondition) as not_goodcondition, SUM(guardianship) as guardianship, SUM(plp) as plp, SUM(not_qualified) as not_qualified,
		  SUM(eighteen_mos_sssloan) as eighteen_mos_sssloan, SUM(on_process) as on_process FROM `op_lsor` WHERE branch_name = '$branch_name'
		   AND date = '$currentDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlGetBeginLSOR($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM op_lsor_begin WHERE branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowOperationLSOR($branch_name, $table){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "operation_admin"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table");

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE branch_name = '$branch_name'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetBeginLSORReport($branch_name, $month){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM op_lsor_begin WHERE branch_name = '$branch_name' AND dateto < '$month'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetAllLSOR($branch_name, $firstDay, $lastDay){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(fin_stable) as fin_stable, SUM(app_wc) as app_wc, SUM(low_cashout) as low_cashout, 
		SUM(existing_loan) as existing_loan, SUM(other_resched_gawad) as other_resched_gawad, SUM(other_sched_gawad) as other_sched_gawad, 
		SUM(sched_applynow) as sched_applynow, SUM(ssp_overage) as ssp_overage, SUM(lack_requirements) as lack_requirements, SUM(undecided) as undecided,
		 SUM(refuse_transfer) as refuse_transfer, SUM(inquired_only) as inquired_only, SUM(new_policy) as new_policy, 
		 SUM(not_goodcondition) as not_goodcondition, SUM(guardianship) as guardianship, SUM(plp) as plp, SUM(not_qualified) as not_qualified,
		  SUM(eighteen_mos_sssloan) as eighteen_mos_sssloan, SUM(on_process) as on_process FROM `op_lsor` WHERE branch_name = '$branch_name'
		   AND date >= '$firstDay' AND date <= '$lastDay';");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlEditLSOR($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `date` = :date, fin_stable = :fin_stable, 
		app_wc = :app_wc, `low_cashout` = :low_cashout, `existing_loan` = :existing_loan, `other_resched_gawad` = :other_resched_gawad, `other_sched_gawad` = :other_sched_gawad
		, `sched_applynow` = :sched_applynow, `ssp_overage` = :ssp_overage, `lack_requirements` = :lack_requirements, `undecided` = :undecided 
		, `refuse_transfer` = :refuse_transfer , `inquired_only` = :inquired_only , `new_policy` = :new_policy 
		, `not_goodcondition` = :not_goodcondition , `guardianship` = :guardianship , `plp` = :plp, `not_qualified` = :not_qualified,
		 `eighteen_mos_sssloan` = :eighteen_mos_sssloan, `on_process` = :on_process   WHERE id = :id");
		
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":fin_stable", $data["fin_stable"], PDO::PARAM_INT);
		$stmt->bindParam(":app_wc", $data["app_wc"], PDO::PARAM_INT);
		$stmt->bindParam(":low_cashout", $data["low_cashout"], PDO::PARAM_INT);
		$stmt->bindParam(":existing_loan", $data["existing_loan"], PDO::PARAM_INT);
		$stmt->bindParam(":other_resched_gawad", $data["other_resched_gawad"], PDO::PARAM_INT);
		$stmt->bindParam(":other_sched_gawad", $data["other_sched_gawad"], PDO::PARAM_INT);
		$stmt->bindParam(":sched_applynow", $data["sched_applynow"], PDO::PARAM_INT);
		$stmt->bindParam(":ssp_overage", $data["ssp_overage"], PDO::PARAM_INT);
		$stmt->bindParam(":lack_requirements", $data["lack_requirements"], PDO::PARAM_INT);
		$stmt->bindParam(":undecided", $data["undecided"], PDO::PARAM_INT);
		$stmt->bindParam(":refuse_transfer", $data["refuse_transfer"], PDO::PARAM_INT);
		$stmt->bindParam(":inquired_only", $data["inquired_only"], PDO::PARAM_INT);
		$stmt->bindParam(":new_policy", $data["new_policy"], PDO::PARAM_INT);
		$stmt->bindParam(":not_goodcondition", $data["not_goodcondition"], PDO::PARAM_INT);
		$stmt->bindParam(":guardianship", $data["guardianship"], PDO::PARAM_INT);
		$stmt->bindParam(":plp", $data["plp"], PDO::PARAM_INT);
		$stmt->bindParam(":not_qualified", $data["not_qualified"], PDO::PARAM_INT);
		$stmt->bindParam(":eighteen_mos_sssloan", $data["eighteen_mos_sssloan"], PDO::PARAM_INT);
		$stmt->bindParam(":on_process", $data["on_process"], PDO::PARAM_INT);
	
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}  
	static public function mdlGetLSOPCumi($branch_name, $preLastDay){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(fin_stable) + SUM(app_wc) + SUM(low_cashout) +
		SUM(existing_loan) + SUM(other_resched_gawad) + SUM(other_sched_gawad) +
		SUM(sched_applynow) + SUM(ssp_overage) + SUM(lack_requirements) + SUM(undecided) + 
		 SUM(refuse_transfer) + SUM(inquired_only) + SUM(new_policy) +
		 SUM(not_goodcondition) + SUM(guardianship) + SUM(plp) + SUM(not_qualified) +
		  SUM(eighteen_mos_sssloan) + SUM(on_process) as total_cumi FROM `op_lsor` WHERE branch_name = '$branch_name'
		   AND date <= '$preLastDay'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function ctrGrossinChecker($data){
		$stmt = (new Connection)->connect()->prepare("SELECT COUNT(*) as count FROM op_gross_out WHERE branch_name = :branch_name AND account_id = :account_id 
        AND type = :type AND in_date = :in_date");

			$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
			$stmt->bindParam(":in_date", $data["in_date"], PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $result['count'];
			if ($count > 0) {
				return "not";
			} else {
				return "ok";
			}
	}

	static public function ctrOutgoingChecker($data){
		$stmt = (new Connection)->connect()->prepare("SELECT COUNT(*) as count FROM op_gross_out WHERE branch_name = :branch_name AND account_id = :account_id 
        AND type = :type AND out_date = :out_date");

			$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
			$stmt->bindParam(":out_date", $data["out_date"], PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $result['count'];
			if ($count > 0) {
				return "not";
			} else {
				return "ok";
			}
	}

	static public function mdlAddDataGrossin($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();

		$chk = (new ModelOperation)->ctrGrossinChecker($data);
		
	if($chk == "ok"){
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(account_id, branch_name, name, birth_date, type, in_date, reftype)
		 VALUES (:account_id, :branch_name, :name, :birth_date, :type, :in_date, :reftype)");
        $stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
		$stmt->bindParam(":in_date", $data["in_date"], PDO::PARAM_STR);
		$stmt->bindParam(":reftype", $data["reftype"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }

        $stmt->close();
        $stmt = null;
	}
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function mdlAddDataOutgoing($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$chk = (new ModelOperation)->ctrOutgoingChecker($data);
		if($chk == "ok"){
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table(account_id, branch_name, name, birth_date, type, out_date, status)
		 VALUES (:account_id, :branch_name, :name, :birth_date, :type, :out_date, :status)");
        $stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
        $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
		$stmt->bindParam(":out_date", $data["out_date"], PDO::PARAM_STR);
		$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        $stmt->close();
        $stmt = null;
	}
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}


	static public function mdlShowBeginBalance($branch_name){
		$type = $_SESSION['type'];
		if($type == "admin" || $type == "operation_admin"  ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal WHERE branch_name = '$branch_name'");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowById($id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_beginning_bal WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlShowBranches(){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_names");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlShowBranches1(){
		$stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM accounting_branches");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlEditBeginBal($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `type` = :type, date = :date, 
		branch_name = :branch_name, `amount` = :amount WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}

	static public function mdlNewGetGrossinCumi($prev, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN reftype = 'WI' THEN 1 ELSE 0 END) AS walkin,
		SUM(CASE WHEN reftype = 'SR' THEN 1 ELSE 0 END) AS sales_rep,
		SUM(CASE WHEN reftype = 'R' THEN 1 ELSE 0 END) AS returnee,
		SUM(CASE WHEN reftype = 'RA' THEN 1 ELSE 0 END) AS runners_agent,
		SUM(CASE WHEN reftype = 'T' THEN 1 ELSE 0 END) AS transfer,
		SUM(CASE WHEN reftype IN ('WI', 'SR', 'R', 'RA', 'T') THEN 1 ELSE 0 END) AS total_cumi
	FROM `op_gross_out`
	WHERE type = 'grossin' AND branch_name = '$full_name' AND in_date <= '$prev'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlNewGetGrossinData($branch_name, $from, $to){
	    $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN reftype = 'WI' THEN 1 ELSE 0 END) AS walkin,
		SUM(CASE WHEN reftype = 'SR' THEN 1 ELSE 0 END) AS sales_rep,
		SUM(CASE WHEN reftype = 'R' THEN 1 ELSE 0 END) AS returnee,
		SUM(CASE WHEN reftype = 'RA' THEN 1 ELSE 0 END) AS runners_agent,
		SUM(CASE WHEN reftype = 'T' THEN 1 ELSE 0 END) AS transfer 	FROM `op_gross_out` WHERE  type = 'grossin' AND branch_name = '$branch_name' AND in_date >= '$from' AND in_date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlNewGetOutgoingData($branch_name, $from, $to){
        $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) AS fully_paid,
		SUM(CASE WHEN status = 'D' THEN 1 ELSE 0 END) AS deceased,
		SUM(CASE WHEN status = 'G' THEN 1 ELSE 0 END) AS gawad,
		SUM(CASE WHEN status = 'B' THEN 1 ELSE 0 END) AS bad_accounts,
		SUM(CASE WHEN status = 'T' THEN 1 ELSE 0 END) AS transfer 	FROM `op_gross_out` 
		WHERE  type = 'outgoing' AND branch_name = '$branch_name' AND out_date >= '$from' AND out_date <= '$to'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlNewGetOutgoingCumi($previousDate, $full_name){
        $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) AS fully_paid,
		SUM(CASE WHEN status = 'D' THEN 1 ELSE 0 END) AS deceased,
		SUM(CASE WHEN status = 'G' THEN 1 ELSE 0 END) AS gawad,
		SUM(CASE WHEN status = 'B' THEN 1 ELSE 0 END) AS bad_accounts,
		SUM(CASE WHEN status = 'T' THEN 1 ELSE 0 END) AS transfer,
		SUM(CASE WHEN status IN ('F', 'D', 'G', 'B', 'T') THEN 1 ELSE 0 END) AS total_cumi
		FROM `op_gross_out` 
		WHERE type = 'outgoing' AND branch_name = '$full_name' AND out_date <= '$previousDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlEditLSORBeginningBalance($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `datefrom` = :datefrom, dateto = :dateto, 
		amount = :amount WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":datefrom", $data["datefrom"], PDO::PARAM_STR);
        $stmt->bindParam(":dateto", $data["dateto"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
	
	
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
	
		$stmt->close();
		$stmt = null;
	
	}

	static public function mdlGetGrossinMonthlyData($branch_name, $firstDay, $lastDay){
        $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN reftype = 'WI' THEN 1 ELSE 0 END) AS walkin,
		SUM(CASE WHEN reftype = 'SR' THEN 1 ELSE 0 END) AS sales_rep,
		SUM(CASE WHEN reftype = 'R' THEN 1 ELSE 0 END) AS returnee,
		SUM(CASE WHEN reftype = 'RA' THEN 1 ELSE 0 END) AS runners_agent,
		SUM(CASE WHEN reftype = 'T' THEN 1 ELSE 0 END) AS transfer,
		SUM(CASE WHEN reftype IN ('WI', 'SR', 'R', 'RA', 'T') THEN 1 ELSE 0 END) AS total_cumi
	FROM `op_gross_out`
	WHERE type = 'grossin' AND branch_name = '$branch_name' AND in_date >= '$firstDay' AND in_date <= '$lastDay'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetGrossoutMonthlyData($branch_name, $firstDay, $lastDay){
        $stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(CASE WHEN status = 'F' THEN 1 ELSE 0 END) AS fully_paid,
		SUM(CASE WHEN status = 'D' THEN 1 ELSE 0 END) AS deceased,
		SUM(CASE WHEN status = 'G' THEN 1 ELSE 0 END) AS gawad,
		SUM(CASE WHEN status = 'B' THEN 1 ELSE 0 END) AS bad_accounts,
		SUM(CASE WHEN status = 'T' THEN 1 ELSE 0 END) AS transfer,
		SUM(CASE WHEN status IN ('F', 'D', 'G', 'B', 'T') THEN 1 ELSE 0 END) AS total_cumi
		FROM `op_gross_out` 
	WHERE type = 'outgoing' AND branch_name = '$branch_name' AND out_date >= '$firstDay' AND out_date <= '$lastDay'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetNorthNegros(){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name = 'EMB MAIN BRANCH' 
		OR branch_name = 'EMB CADIZ' OR branch_name = 'EMB SAN CARLOS' OR branch_name = 'EMB SAGAY' OR branch_name = 'EMB VICTORIAS' OR 
		branch_name = 'EMB TALISAY' OR branch_name = 'FCH BACOLOD 'OR branch_name = 'FCH SILAY' OR branch_name = 'FCH MURCIA';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetSouthNegros(){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name = 'EMB LA CARLOTA' 
		OR branch_name = 'EMB KABANKALAN' OR branch_name = 'EMB DUMAGUETE' OR branch_name = 'EMB LA CASTELLANA' OR branch_name = 'EMB BAYAWAN' OR 
		branch_name = 'EMB BAIS' OR branch_name = 'EMB SIPALAY' OR branch_name = 'FCH BAGO 'OR branch_name = 'FCH BINALBAGAN' OR branch_name = 'FCH HINIGARAN';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetPanay(){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name = 'EMB ILOILO' OR branch_name = 'EMB ROXAS' 
		OR branch_name = 'EMB PASSI' OR branch_name = 'EMB SARA' OR branch_name = 'EMB MAMBUSAO' OR branch_name = 'EMB MIAG AO';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetCentralVisayas(){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name = 'EMB TAGBILARAN' OR branch_name = 'EMB MANDAUE'
		 OR branch_name = 'EMB CEBU' OR branch_name = 'EMB TOLEDO' OR branch_name = 'EMB DANAO' OR branch_name = 'EMB TUBIGON';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetManila(){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name = 'FCH PARANAQUE' OR branch_name = 'FCH MUNTINLUPA'
		OR branch_name = 'ELC BULACAN';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllReturnee($branch_name, $firstDay, $lastDay){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_gross_out` WHERE branch_name = '$branch_name' AND reftype = 'R' 
		AND in_date >='$firstDay' AND in_date <='$lastDay';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetAllFullyPaid($branch_name, $firstDay, $lastDay){
	    $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_gross_out` WHERE branch_name = '$branch_name' AND status = 'F' 
		AND out_date >='$firstDay' AND out_date <='$lastDay';");
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlAddLoansAging($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();

		$chk = (new ModelOperation)->ctrGrossinChecker($data);
		
	if($chk == "ok"){
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table( branch_name, account_id, name, birth_date, lrterm, op_change, ntotal, syxlnmo, date)
		 VALUES (:branch_name, :account_id, :name, :birth_date, :lrterm, :op_change, :ntotal, :syxlnmo, :date)");
        $stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":birth_date", $data["birth_date"], PDO::PARAM_STR);
        $stmt->bindParam(":lrterm", $data["lrterm"], PDO::PARAM_STR);
		$stmt->bindParam(":op_change", $data["op_change"], PDO::PARAM_STR);
		$stmt->bindParam(":ntotal", $data["ntotal"], PDO::PARAM_STR);
		$stmt->bindParam(":syxlnmo", $data["syxlnmo"], PDO::PARAM_STR);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }

        $stmt->close();
        $stmt = null;
	}
		}catch(PDOException $exception){
			$pdo->rollBack();
			return "error"; 
		}	

	}

	static public function mdlShowTotalLoanAging($branch_name){
	
	$stmt = (new Connection)->connect()->prepare("SELECT branch_name, date, COUNT(account_id) as total_ssp, SUM(op_change) as total_sl, SUM(ntotal) as total_lr FROM `op_loans_aging` GROUP BY branch_name, date ORDER BY `op_loans_aging`.`date` DESC");
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetSPPWithSL($branch_name, $month, $date){
	    $stmt = (new Connection)->connect()->prepare("SELECT
		SUM(CASE WHEN lrterm = '0' THEN 1 ELSE 0 END) AS total_ssp_sl,
		SUM(CASE WHEN lrterm = '1' THEN 1 ELSE 0 END) AS total_ssp_4m,
		SUM(CASE WHEN lrterm = '2' THEN 1 ELSE 0 END) AS total_ssp_5and6,
		SUM(CASE WHEN lrterm = '3' THEN 1 ELSE 0 END) AS total_ssp_7and8,
		SUM(CASE WHEN lrterm = '4' THEN 1 ELSE 0 END) AS total_ssp_9and10,
		SUM(CASE WHEN lrterm = '5' THEN 1 ELSE 0 END) AS total_ssp_11,
		SUM(CASE WHEN lrterm = '6' THEN 1 ELSE 0 END) AS total_ssp_12
	  FROM op_loans_aging
	  WHERE branch_name = :branch_name AND syxlnmo = :month AND date= :date;");
		$stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt->bindParam(":month", $month, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetLoansChange($branch_name, $month, $date){
	    $stmt = (new Connection)->connect()->prepare("SELECT
		SUM(CASE WHEN lrterm = '0' THEN op_change ELSE 0 END) AS total_chng_sl,
		SUM(CASE WHEN lrterm = '1' THEN op_change ELSE 0 END) AS total_chng_4m,
		SUM(CASE WHEN lrterm = '2' THEN op_change ELSE 0 END) AS total_chng_5and6,
		SUM(CASE WHEN lrterm = '3' THEN op_change ELSE 0 END) AS total_chng_7and8,
		SUM(CASE WHEN lrterm = '4' THEN op_change ELSE 0 END) AS total_chng_9and10,
		SUM(CASE WHEN lrterm = '5' THEN op_change ELSE 0 END) AS total_chng_11,
		SUM(CASE WHEN lrterm = '6' THEN op_change ELSE 0 END) AS total_chng_12
	  FROM op_loans_aging
	  WHERE branch_name = :branch_name AND syxlnmo = :month AND date = :date;");
		$stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt->bindParam(":month", $month, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlGetLoansNtotal($branch_name, $month, $date){
	    $stmt = (new Connection)->connect()->prepare("SELECT
		SUM(CASE WHEN lrterm = '0' THEN ntotal ELSE 0 END) AS total_ntotal_sl,
		SUM(CASE WHEN lrterm = '1' THEN ntotal ELSE 0 END) AS total_ntotal_4m,
		SUM(CASE WHEN lrterm = '2' THEN ntotal ELSE 0 END) AS total_ntotal_5and6,
		SUM(CASE WHEN lrterm = '3' THEN ntotal ELSE 0 END) AS total_ntotal_7and8,
		SUM(CASE WHEN lrterm = '4' THEN ntotal ELSE 0 END) AS total_ntotal_9and10,
		SUM(CASE WHEN lrterm = '5' THEN ntotal ELSE 0 END) AS total_ntotal_11,
		SUM(CASE WHEN lrterm = '6' THEN ntotal ELSE 0 END) AS total_ntotal_12
	  FROM op_loans_aging
	  WHERE branch_name = :branch_name AND syxlnmo = :month AND date = :date;");
		$stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt->bindParam(":month", $month, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll(); 
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlDeleteLoansAging($table, $date, $branch_name){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE date = :date AND branch_name = :branch_name");
		$stmt ->bindParam(":date", $date, PDO::PARAM_STR);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}



	static public function mdlCheckDuplication($date1, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_loans_aging` WHERE branch_name = '$branch_name' AND date = '$date1';");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}




	
}