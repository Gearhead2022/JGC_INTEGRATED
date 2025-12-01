<?php
require_once "connection.php";


class ModelTicket{


	static public function mdlAddTicket($data) {
		try {
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
	
			$stmt = (new Connection)->connect()->prepare("INSERT INTO ticket_list (ctr_no, id, name, terms, tdate, branch_name,area_code) VALUES
			(:ctr_no, :id, :name, :terms, :tdate, :branch_name, :area_code)");
	
			$stmt->bindParam(":ctr_no", $data["ctr_no"], PDO::PARAM_STR);
			$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":terms", $data["terms"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":area_code", $data["area_code"], PDO::PARAM_STR);

			// $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
			// $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		
			$stmt->execute();
			
			$pdo->commit();
			return "ok";
	
		} catch (PDOException $exception) {
			$pdo->rollBack();
			return "error";
		}
	}
	

static public function modelShowTicket() {
	$type = $_SESSION['type'];
	$branch_name = $_SESSION['branch_name'];
	if($type == "admin" || $type == "operation_admin" ){
		$stmt = (new Connection)->connect()->prepare("SELECT id, name, tdate, MAX(index_id) AS index_id, MAX(ctr_no) AS ctr_no, MAX(area_code) AS area_code, MAX(branch_name) AS branch_name, MAX(date_time) AS date_time, SUM(terms) AS total_terms FROM ticket_list  GROUP BY id, name, tdate;");
	}else{
		$stmt = (new Connection)->connect()->prepare("SELECT id, name, tdate, MAX(index_id) AS index_id, MAX(ctr_no) AS ctr_no, MAX(area_code) AS area_code, MAX(branch_name) AS branch_name, MAX(date_time) AS date_time, SUM(terms) AS total_terms FROM ticket_list  WHERE branch_name = '$branch_name'  GROUP BY id, name, tdate;");
	}
	$stmt -> execute();
	return $stmt -> fetchAll();

}

static public function modelShowAcrhiveTicket(){
	$branch_name = $_SESSION['branch_name'];
	$stmt = (new Connection)->connect()->prepare("SELECT id, name, tdate, MAX(index_id) AS index_id, MAX(ctr_no) AS ctr_no, MAX(area_code) AS area_code, MAX(branch_name) AS branch_name, SUM(terms) AS total_terms FROM ticket_list_archive  WHERE branch_name = '$branch_name'  GROUP BY id, name, tdate;");
	$stmt -> execute();
	return $stmt -> fetchAll();
}

static public function createID($id) {
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM ticket_list WHERE id = '$id'");
	$stmt -> execute();
	return $stmt -> fetchAll();
}
static public function modelGetId($id) {
	$branch_name = $_SESSION['branch_name'];
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM ticket_list WHERE id ='$id' AND branch_name = '$branch_name' ");
	$stmt -> execute();
	return $stmt -> fetchAll();
}


static public function modelcheckDuplicate($id, $name, $tdate,$branch_name, $ctr_no) {
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM ticket_list WHERE ctr_no ='$ctr_no' AND id ='$id' AND  name ='$name' AND  tdate ='$tdate' AND branch_name = '$branch_name' ");
	   $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true; // Duplicate found
    } else {
        $stmt1 = (new Connection)->connect()->prepare("SELECT * FROM ticket_list_archive WHERE ctr_no ='$ctr_no' AND id ='$id' AND  name ='$name' AND  tdate ='$tdate' AND branch_name = '$branch_name' ");
	   $stmt1->execute();
	   if ($stmt1->rowCount() > 0) {
        return true; // Duplicate found
  		  }else{
			return false;
		  }
    }
		
	
}


static public function mdlSavePrintTicket($data) {
	try {
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();

		$stmt = (new Connection)->connect()->prepare("INSERT INTO ticket_last (id, name, branch_name, ticket_no,last_claim_ticket) VALUES
		(:id, :name, :branch_name, :ticket_no, :last_claim_ticket)");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":ticket_no", $data["ticket_no"], PDO::PARAM_STR);
		$stmt->bindParam(":last_claim_ticket", $data["last_claim_ticket"], PDO::PARAM_INT);
		// $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
		// $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		if($stmt->execute()){
			$stmt = (new Connection)->connect()->prepare("INSERT INTO ticket_list_archive (id, name, branch_name, ticket_no,last_claim_ticket) VALUES
		(:id, :name, :branch_name, :ticket_no, :last_claim_ticket)");
		}
		
		$pdo->commit();
		return "ok";

	} catch (PDOException $exception) {
		$pdo->rollBack();
		return "error";
	}
}



// static public function modelGetNames() {
// 	$stmt = (new Connection)->connect()->prepare("SELECT name FROM ticket_list");
// 	$stmt->execute();
// 	return $stmt->fetchAll(PDO::FETCH_COLUMN);
	
// }
static public function mdlGetLastID($branch_name){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM `ticket_last` WHERE branch_name = '$branch_name' ORDER BY `ticket_last`.`index_id` DESC LIMIT 1;");
	$stmt -> execute();
	return $stmt -> fetchAll();
}

static public function mdlMakeTiket($data) {
	try {
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
		$terms = $data['terms'];
		$branch_name = $data['branch_name'];
		$branch_code = $data['branch_code'];
		$counter = 0;
		
	
		
		for ($i=0; $i <$terms ; $i++) { 
			$getLast = (new ModelTicket)->mdlGetLastID($branch_name);
			if(!empty($getLast)){
				$lastId = $getLast[0]['last_claim_ticket'];
			}else{
				$lastId = 0;
			}
			$last = $lastId + 1; 
			$tickets = $branch_code ."-". str_repeat("0",5-strlen($last)).$last;
			# code...
		$stmt = (new Connection)->connect()->prepare("INSERT INTO ticket_last (id, name, branch_name, area_code, ticket_no, tdate, last_claim_ticket) VALUES
		(:id, :name, :branch_name, :area_code, :ticket_no, :tdate, :last_claim_ticket)");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":area_code", $data["area_code"], PDO::PARAM_STR);
		$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
		$stmt->bindParam(":ticket_no", $tickets, PDO::PARAM_STR);
		$stmt->bindParam(":last_claim_ticket", $last, PDO::PARAM_STR);
		$stmt->execute();
		$counter +=1;
		}

		if($counter == $terms){
			$stmt = (new Connection)->connect()->prepare("INSERT INTO ticket_list_archive (ctr_no, id, name, terms, tdate, area_code, branch_name)
			SELECT ctr_no, id, name, terms, tdate, area_code, branch_name
			FROM ticket_list
			WHERE id = :id and name =:name and tdate= :tdate and branch_name = :branch_name");
			$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			if($stmt->execute()){
			$stmt = (new Connection)->connect()->prepare("DELETE FROM `ticket_list` WHERE id = :id and name =:name and tdate= :tdate and branch_name = :branch_name");
			$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			$stmt->execute();
			}
		}

		$pdo->commit();
		return "ok";

	} catch (PDOException $exception) {
		$pdo->rollBack();
		return "error";
	}
}
static public function mdlGetTickets($data) {

	$stmt = (new Connection)->connect()->prepare("SELECT * FROM ticket_last WHERE branch_name = :branch_name AND id = :id AND name = :name AND tdate = :tdate");
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
	$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
	$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
	$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
	$stmt -> execute();
	return $stmt -> fetchAll();

}


static public function mdlBatchTicketGet($area_code, $branch_name){
	if ($branch_name == "") {
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `ticket_last` WHERE area_code = '$area_code'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	} else {
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `ticket_last` WHERE branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
	}
	
	
	
}


static public function mdlAddSingleTicket($table, $data) {
	try {
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();

		$stmt = (new Connection)->connect()->prepare("INSERT INTO $table (id, name, terms, tdate, branch_name,area_code, ctr_no) VALUES
		(:id, :name, :terms, :tdate, :branch_name, :area_code, :ctr_no)");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":terms", $data["terms"], PDO::PARAM_STR);
		$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":area_code", $data["area_code"], PDO::PARAM_STR);
		$stmt->bindParam(":ctr_no", $data["ctr_no"], PDO::PARAM_STR);
		$stmt->execute();
		$pdo->commit();
		return "ok";

	} catch (PDOException $exception) {
		$pdo->rollBack();
		return "error";
	}
}


static public function modelcheckChange($data) {
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM ticket_list WHERE id =:id AND  name = :name
	 AND  tdate =:tdate AND branch_name = :branch_name AND ctr_no != :ctr_no");
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
	$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
	$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
	$stmt->bindParam(":ctr_no", $data["ctr_no"], PDO::PARAM_STR);
	$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($results as $result) {
			$terms = $result["terms"];
			$ctr_no = $result["ctr_no"];
		}
		$orig = $data["terms"];
		$final_terms = (int)$terms + (int)$orig;
		$stmt1 = (new Connection)->connect()->prepare("UPDATE ticket_list SET `terms` = :terms  WHERE ctr_no = :ctr_no");
		$stmt1->bindParam(":ctr_no", $ctr_no, PDO::PARAM_STR);
		$stmt1->bindParam(":terms", $final_terms, PDO::PARAM_STR);
		$stmt1->execute();

		if($stmt1->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt1->close();
		$stmt = null;
   
	}

}


static public function mdlDelete($table, $data){
	$stmt = (new Connection)->connect()->prepare("DELETE FROM $table  WHERE index_id = :id");
	$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;
}

static public function mdlGetNewRenew($rDate, $branch_name){
    $stmt = (new Connection)->connect()->prepare("SELECT 
    	SUM(one_month) AS total_one_month,
    	SUM(two_month) AS total_two_month,
    	SUM(three_month) AS total_three_month,
    	SUM(four_month) AS total_four_month,
    	SUM(five_month) AS total_five_month,
    	SUM(six_month) AS total_six_month,
    	SUM(seven_month) AS total_seven_month,
    	SUM(eight_month) AS total_eight_month,
    	SUM(sham_month) AS total_sham_month,
    	SUM(ten_month) AS total_ten_month,
    	SUM(eleven_month) AS total_eleven_month,
    	SUM(twelve_month) AS total_twelve_month
    FROM (
    	SELECT 
    		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
    		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
    		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
    		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
    		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
    		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
    		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
    		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
    		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
    		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
    		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
    		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
    	FROM
    		ticket_list_archive
    	WHERE
    		branch_name = '$branch_name' AND tdate = '$rDate'
    	
    	UNION ALL
    	
    	SELECT 
    		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
    		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
    		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
    		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
    		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
    		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
    		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
    		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
    		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
    		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
    		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
    		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
    	FROM
    		ticket_list
    	WHERE
    		branch_name = '$branch_name' AND tdate = '$rDate'
    ) AS combined_results;
    ");
    	$stmt -> execute();
    	return $stmt -> fetchAll();
    	$stmt -> close();   
    	$stmt = null;
}

static public function mdlGetRenew($rDate, $branch_name){
		$stmt = (new Connection)->connect()->prepare("SELECT 
		SUM(one_month) AS total_one_month,
		SUM(two_month) AS total_two_month,
		SUM(three_month) AS total_three_month,
		SUM(four_month) AS total_four_month,
		SUM(five_month) AS total_five_month,
		SUM(six_month) AS total_six_month,
		SUM(seven_month) AS total_seven_month,
		SUM(eight_month) AS total_eight_month,
		SUM(sham_month) AS total_sham_month,
		SUM(ten_month) AS total_ten_month,
		SUM(eleven_month) AS total_eleven_month,
		SUM(twelve_month) AS total_twelve_month
	FROM (
		SELECT 
			SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
			SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
			SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
			SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
			SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
			SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
			SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
			SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
			SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
			SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
			SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
			SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
		FROM
			ticket_list_archive
		WHERE
			branch_name = '$branch_name' AND tdate = '$rDate'
		
		UNION ALL
		
		SELECT 
			SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
			SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
			SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
			SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
			SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
			SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
			SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
			SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
			SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
			SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
			SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
			SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
		FROM
			ticket_list
		WHERE
			branch_name = '$branch_name' AND tdate = '$rDate'
	) AS combined_results;
	");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();   
		$stmt = null;
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



static public function mdlGetTicketCumi($fDate,$prev, $branch_name){
	$stmt = (new Connection)->connect()->prepare("SELECT 
	SUM(one_month) AS total_one_month,
	SUM(two_month) AS total_two_month,
	SUM(three_month) AS total_three_month,
	SUM(four_month) AS total_four_month,
	SUM(five_month) AS total_five_month,
	SUM(six_month) AS total_six_month,
	SUM(seven_month) AS total_seven_month,
	SUM(eight_month) AS total_eight_month,
	SUM(sham_month) AS total_sham_month,
	SUM(ten_month) AS total_ten_month,
	SUM(eleven_month) AS total_eleven_month,
	SUM(twelve_month) AS total_twelve_month
FROM (
	SELECT 
		SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list_archive
	WHERE
		branch_name = '$branch_name' AND tdate >= '$fDate' AND tdate <= '$prev'
	
	UNION ALL
	
	SELECT 
		SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list
	WHERE
		branch_name = '$branch_name' AND tdate >= '$fDate' AND tdate <= '$prev'
) AS combined_results;
");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();   
	$stmt = null;
}

static public function mdlGetNewTicketCumi($fDate,$prev, $branch_name){
	$stmt = (new Connection)->connect()->prepare("SELECT 
	SUM(one_month) AS total_one_month,
	SUM(two_month) AS total_two_month,
	SUM(three_month) AS total_three_month,
	SUM(four_month) AS total_four_month,
	SUM(five_month) AS total_five_month,
	SUM(six_month) AS total_six_month,
	SUM(seven_month) AS total_seven_month,
	SUM(eight_month) AS total_eight_month,
	SUM(sham_month) AS total_sham_month,
	SUM(ten_month) AS total_ten_month,
	SUM(eleven_month) AS total_eleven_month,
	SUM(twelve_month) AS total_twelve_month
FROM (
	SELECT 
		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list_archive
	WHERE
		branch_name = '$branch_name' AND tdate >= '$fDate' AND tdate <= '$prev'
	
	UNION ALL
	
	SELECT 
		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list
	WHERE
		branch_name = '$branch_name' AND tdate >= '$fDate' AND tdate <= '$prev'
) AS combined_results;
");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();   
	$stmt = null;
}

static public function mdlGetTicketRenewCumi($prev, $branch_name){
	$stmt = (new Connection)->connect()->prepare("SELECT 
	SUM(one_month) AS total_one_month,
	SUM(two_month) AS total_two_month,
	SUM(three_month) AS total_three_month,
	SUM(four_month) AS total_four_month,
	SUM(five_month) AS total_five_month,
	SUM(six_month) AS total_six_month,
	SUM(seven_month) AS total_seven_month,
	SUM(eight_month) AS total_eight_month,
	SUM(sham_month) AS total_sham_month,
	SUM(ten_month) AS total_ten_month,
	SUM(eleven_month) AS total_eleven_month,
	SUM(twelve_month) AS total_twelve_month
FROM (
	SELECT 
		SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list_archive
	WHERE
		branch_name = '$branch_name' AND tdate <= '$prev'
	
	UNION ALL
	
	SELECT 
		SUM(CASE WHEN terms = 1 AND id != '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id != '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id != '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id != '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id != '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id != '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id != '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id != '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id != '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id != '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id != '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id != '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list
	WHERE
		branch_name = '$branch_name' AND tdate <= '$prev'
) AS combined_results;
");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();   
	$stmt = null;
}


static public function mdlGetNewRenewTicketCumi($prev, $branch_name){
	$stmt = (new Connection)->connect()->prepare("SELECT 
	SUM(one_month) AS total_one_month,
	SUM(two_month) AS total_two_month,
	SUM(three_month) AS total_three_month,
	SUM(four_month) AS total_four_month,
	SUM(five_month) AS total_five_month,
	SUM(six_month) AS total_six_month,
	SUM(seven_month) AS total_seven_month,
	SUM(eight_month) AS total_eight_month,
	SUM(sham_month) AS total_sham_month,
	SUM(ten_month) AS total_ten_month,
	SUM(eleven_month) AS total_eleven_month,
	SUM(twelve_month) AS total_twelve_month
FROM (
	SELECT 
		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list_archive
	WHERE
		branch_name = '$branch_name' AND tdate <= '$prev'
	
	UNION ALL
	
	SELECT 
		SUM(CASE WHEN terms = 1 AND id = '-1' THEN 1 ELSE 0 END) AS one_month,
		SUM(CASE WHEN terms = 2 AND id = '-1' THEN 1 ELSE 0 END) AS two_month,
		SUM(CASE WHEN terms = 3 AND id = '-1' THEN 1 ELSE 0 END) AS three_month,
		SUM(CASE WHEN terms = 4 AND id = '-1' THEN 1 ELSE 0 END) AS four_month,
		SUM(CASE WHEN terms = 5 AND id = '-1' THEN 1 ELSE 0 END) AS five_month,
		SUM(CASE WHEN terms = 6 AND id = '-1' THEN 1 ELSE 0 END) AS six_month,
		SUM(CASE WHEN terms = 7 AND id = '-1' THEN 1 ELSE 0 END) AS seven_month,
		SUM(CASE WHEN terms = 8 AND id = '-1' THEN 1 ELSE 0 END) AS eight_month,
		SUM(CASE WHEN terms = 9 AND id = '-1' THEN 1 ELSE 0 END) AS sham_month,
		SUM(CASE WHEN terms = 10 AND id = '-1' THEN 1 ELSE 0 END) AS ten_month,
		SUM(CASE WHEN terms = 11 AND id = '-1' THEN 1 ELSE 0 END) AS eleven_month,
		SUM(CASE WHEN terms = 12 AND id = '-1' THEN 1 ELSE 0 END) AS twelve_month
	FROM
		ticket_list
	WHERE
		branch_name = '$branch_name' AND tdate <= '$prev'
) AS combined_results;
");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();   
	$stmt = null;
}








}