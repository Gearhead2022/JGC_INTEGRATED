<?php

require_once "connection.php";

class ModelQRCode{

	
	static public function mdlAddItem($table, $data) {
		try {
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
	
			$stmt = $pdo->prepare("INSERT INTO $table(
			company, item_code,  sticker_no, date_purchased, 
			item_location, price, serial_no, item_description,
			 supplier, last_sticker, type, qty_code, class_type, class_category, class_list, class_code) 
			VALUES
			 (:company, :item_code, :sticker_no, 
			 :date_purchased, :item_location, :price, :serial_no,
			  :item_description, :supplier, :sticker_no, :type, :qty_code, :class_type, :class_category, :class_list, :class_code)");
	
			$stmt->bindParam(":company", $data["company"], PDO::PARAM_STR);
			$stmt->bindParam(":item_code", $data["item_code"], PDO::PARAM_STR);
			$stmt->bindParam(":sticker_no", $data["sticker_no"], PDO::PARAM_STR);
			$stmt->bindParam(":date_purchased", $data["date_purchased"], PDO::PARAM_STR);
			$stmt->bindParam(":item_location", $data["item_location"], PDO::PARAM_STR);
			$stmt->bindParam(":price", $data["price"], PDO::PARAM_STR);
			$stmt->bindParam(":serial_no", $data["serial_no"], PDO::PARAM_STR);
			$stmt->bindParam(":item_description", $data["item_description"], PDO::PARAM_STR);
			$stmt->bindParam(":supplier", $data["supplier"], PDO::PARAM_STR);
			$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
			$stmt->bindParam(":qty_code", $data["qty_code"], PDO::PARAM_STR);
			$stmt->bindParam(":class_type", $data["class_type"], PDO::PARAM_STR);
			$stmt->bindParam(":class_category", $data["class_category"], PDO::PARAM_STR);
			$stmt->bindParam(":class_list", $data["class_list"], PDO::PARAM_STR);
			$stmt->bindParam(":class_code", $data["class_code"], PDO::PARAM_STR);
	
			if ($stmt->execute()) {
				$pdo->commit();
				return "ok";
			} else {
				$pdo->rollBack();
				return "error";
			}
		} catch (PDOException $exception) {
			if ($pdo) {
				$pdo->rollBack();
			}
			return "error: " . $exception->getMessage(); // Return detailed error message
		} finally {
			if ($stmt) {
				$stmt->closeCursor();
				$stmt = null;
			}
			if ($pdo) {
				$pdo = null; // Close the connection
			}
		}
	}
	
	static public function mdlAddItemLog($table, $data)
    {	
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(item_code, item_description, branch_name, status, time_scan) VALUES
			(:item_code, :item_description, :branch_name, :status, :time_scan)");
			$stmt->bindParam(":item_code", $data["item_code"], PDO::PARAM_STR);
			$stmt->bindParam(":item_description", $data["item_description"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
			$stmt->bindParam(":time_scan", $data["time_scan"], PDO::PARAM_STR);
			if($stmt->execute()){
				$pdo->commit();
				return "ok";
			}
			$stmt->close();
			$stmt = null;
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }


	static public function mdlGetItemLog($table, $data){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE item_code = :item_code ORDER BY id desc limit 1");
		$stmt->bindParam(":item_code", $data["item_code"], PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlGetItems($data){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE item_code = :item_code limit 1");
		$stmt->bindParam(":item_code", $data["item_code"], PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlShowInventoryTable($type){
		$branch_name = $_SESSION['branch_name'];
		try{
		$pdo = (new Connection)->connect();
		if (strpos($branch_name, "RLC") !== false) {
			$branch_name = str_replace("RLC", "RFC", $branch_name);
		}
		if($type == "admin" || $type == "inventory_mis" || $type == "inventory_audit" || $type == "inventory_admin"){
        $stmt = $pdo->prepare("SELECT 
		i.id,
		i.class_code,
		i.item_code,
		i.class_list,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
	ORDER BY `i`.`id` DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }else{
		$stmt = (new Connection)->connect()->prepare(" SELECT 
        i.id,
		i.class_code,
		i.class_list,
        i.item_code,
        i.sticker_no,
        i.company,
        i.item_location,
        i.status AS invstatus,
        i.item_description,
        i.serial_no,
        i.date_purchased,
        il.branch_name AS log_branch_name,
        il.status,
        il.time_scan AS log_date
    FROM 
        inventory i
    LEFT JOIN (
        SELECT 
            item_code, 
            MAX(id) AS max_id
        FROM 
            inventory_log
        GROUP BY 
            item_code
    ) il_max ON i.item_code = il_max.item_code
    LEFT JOIN 
        inventory_log il ON il_max.max_id = il.id
    WHERE 
        i.item_location = '$branch_name'
        OR il.branch_name = '$branch_name'
    ORDER BY 
        i.id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
		}
	}
	catch (PDOException $exception) {
        error_log($exception->getMessage()); // Log the error message for debugging
        return [];
    }
}


	static public function mdlGetItmebyID($id){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE id = :id limit 1");
		$stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlEditInventory($table, $data){
        $stmt = (new Connection)->connect()->prepare("UPDATE $table SET
			sticker_no = :sticker_no,
			date_purchased = :date_purchased,
			item_location = :item_location,
			serial_no = :serial_no,
			item_description = :item_description,
			company = :company,
			price = :price,
			supplier = :supplier,
			status = :status,
			date_dispose = :date_dispose,
			date_defective = :date_defective

		 WHERE id = :id");
        $stmt->bindParam(":id", $data["item_id"], PDO::PARAM_INT);
        $stmt->bindParam(":sticker_no", $data["sticker_no"], PDO::PARAM_STR);
        $stmt->bindParam(":date_purchased", $data["date_purchased"], PDO::PARAM_STR);
        $stmt->bindParam(":item_location", $data["item_location"], PDO::PARAM_STR);
        $stmt->bindParam(":serial_no", $data["serial_no"], PDO::PARAM_STR);
        $stmt->bindParam(":item_description", $data["item_description"], PDO::PARAM_STR);
        $stmt->bindParam(":company", $data["company"], PDO::PARAM_STR);
        $stmt->bindParam(":price", $data["price"], PDO::PARAM_STR);
        $stmt->bindParam(":supplier", $data["supplier"], PDO::PARAM_STR);
        $stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
        $stmt->bindParam(":date_dispose", $data["date_dispose"], PDO::PARAM_STR);
        $stmt->bindParam(":date_defective", $data["date_defective"], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	
		$stmt = null;
	}

	static public function mdlGetLastSticker($branch){	
        $stmt = (new Connection)->connect()->prepare("SELECT * 
FROM inventory 
WHERE item_location = :item_location 
ORDER BY CAST(last_sticker AS UNSIGNED) DESC 
LIMIT 1;
");
		$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function 	mdlCheckDuplication($company, $sticker_no){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE company = :company AND sticker_no = :sticker_no");
		$stmt->bindParam(":company", $company, PDO::PARAM_STR);
		$stmt->bindParam(":sticker_no", $sticker_no, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }
	public static function mdlDeleteData($id, $table) {
		try {
			$conn = (new Connection)->connect();
			$stmt = $conn->prepare("DELETE FROM $table WHERE id = :id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
	
			// Check if any rows were affected (deleted)
			if ($stmt->rowCount() > 0) {
				return "ok";
			} else {
				return "error"; // Optional: Indicate if no rows were deleted
			}
			
		} catch (PDOException $e) {
			// Handle error (log it, rethrow it, etc.)
			error_log($e->getMessage());
			return "error"; // Indicate an error occurred
		} finally {
			// Ensure the statement and connection are closed
			$stmt = null;
			$conn = null;
		}
	}
	
	static public function mdlGetStickerByCompany($company){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory 
		WHERE item_location = :company 
		ORDER BY CAST(sticker_no AS UNSIGNED) DESC;");
		$stmt->bindParam(":company", $company, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlGetItemLogs($item_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory_log WHERE item_code = :item_code ORDER by id DESC");
		$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlGetItemCode(){	
        $stmt = (new Connection)->connect()->prepare("SELECT item_code FROM inventory   WHERE item_code LIKE 'UI%'  ORDER BY CAST(SUBSTRING(item_code, 3) AS UNSIGNED) DESC 
        LIMIT 1");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	static public function mdlEditRepair($item_code, $date, $repair, $edit_status) {
		$stmt = (new Connection)->connect()->prepare("UPDATE inventory SET
			last_repaired = :last_repaired, repair = :repair, status = :status
			WHERE item_code = :item_code");
			
		$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
		$stmt->bindParam(":last_repaired", $date, PDO::PARAM_STR);
		$stmt->bindParam(":repair", $repair, PDO::PARAM_STR);
		$stmt->bindParam(":status", $edit_status, PDO::PARAM_STR);
	   
		if ($stmt->execute()) {
			return "ok";
		} else {
			$errorInfo = $stmt->errorInfo(); // Fetch the error information
			return "error: " . $errorInfo[2]; // Return the error message
		}
	
		$stmt = null;
	}

	static public function mdlGetLastStickerMain($branch) {	
		$stmt = (new Connection)->connect()->prepare("SELECT * 
FROM inventory 
WHERE item_location LIKE :item_location 
ORDER BY CAST(last_sticker AS UNSIGNED) DESC 
LIMIT 1;
");
		// Add the wildcard to the branch value
		$branch = $branch . '%';
		$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null; // Close the statement
	}

	
	static public function mdlCheckItemCode($id_holder){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE item_code = :item_code limit 1");
		$stmt->bindParam(":item_code", $id_holder, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	static public function mdlGetAllDataByBranch($branch, $status){	
		if($branch == "ALL" && $status == "ALL"){
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       
	ORDER BY `i`.`item_location` ;");
		}else if($branch == "ALL" && $status != "ALL" ){
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       WHERE i.status = '$status'
	ORDER BY `i`.`item_location` ;");
		}
	else if($branch !="ALL" && $status == "ALL"){
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       WHERE i.item_location = :item_location
	ORDER BY `i`.`item_location` ");
			$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
			}else{
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       WHERE i.item_location = :item_location AND i.status = '$status'
	ORDER BY `i`.`item_location` ");
			$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
		}
     
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	
	static public function mdlGetAllPendingItem($branch){	
		if($branch == "ALL"){
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       WHERE i.status = 'PENDING'
	ORDER BY `i`.`id` DESC;");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT 
		i.id,
		i.item_code,
		i.sticker_no,
		i.company,
		i.item_location,
		i.status as invstatus,
		i.item_description,
		i.serial_no,
		i.date_purchased,
		il.branch_name AS log_branch_name,
		il.status,
		il.time_scan AS log_date
	FROM 
		inventory i
	LEFT JOIN (
		SELECT 
			item_code, 
			MAX(id) AS max_id
		FROM 
			inventory_log
		GROUP BY 
			item_code
	) il_max ON i.item_code = il_max.item_code
	LEFT JOIN 
		inventory_log il ON il_max.max_id = il.id  
       WHERE i.item_location = :item_location
	ORDER BY `i`.`id` DESC");
			$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
		}
     
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	static public function mdlGetAllRepairItem($branch){	
		if($branch == "ALL"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE status = 'PENDING' || status = 'REPAIRED'
		");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE item_location = :item_location");
			$stmt->bindParam(":item_location", $branch, PDO::PARAM_STR);
		}
     
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlGetItmebyBranch($branch){	
        $stmt = (new Connection)->connect()->prepare("SELECT COUNT(id) as total_item FROM `inventory` WHERE item_location = :branch AND status != 'DEFECTIVE' AND status != 'DISPOSED'; ");
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	
	static public function mdlGetItmebyItemCode($branch, $item_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `inventory` WHERE item_location = :branch AND item_code = :item_code");
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
		$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }
	
	
	
	
	
	static public function mdlAddAuditLog($data1)
    {	
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO inventory_audit(item_code, sticker_no, item_description, branch_name, date_scan) VALUES
			(:item_code, :sticker_no, :item_description, :branch_name, :date_scan)");
			$stmt->bindParam(":item_code", $data1["item_code"], PDO::PARAM_STR);
			$stmt->bindParam(":sticker_no", $data1["sticker_no"], PDO::PARAM_STR);
			$stmt->bindParam(":item_description", $data1["item_description"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data1["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":date_scan", $data1["date_scan"], PDO::PARAM_STR);
			if($stmt->execute()){
				$pdo->commit();
				return "ok";
			}
			$stmt->close();
			$stmt = null;
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }
	

	static public function mdlGetAuditScanQR($branch, $date){	
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `inventory_audit` WHERE branch_name = :branch AND date_scan =:date;");
		
		// Bind parameters
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
		
		// Execute the statement
		$stmt->execute();
		
		// Fetch and return all results
		return $stmt->fetchAll();
		
		// Close the statement
		$stmt = null;
	}
	

	static public function mdlCheckAuditlogs($item_code, $date){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory_audit WHERE item_code = :item_code AND date_scan = :date limit 1");
		$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
		$stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlAuditListToScan($branch,  $date){	
        $stmt = (new Connection)->connect()->prepare("SELECT inv.sticker_no, inv.item_description, inv.status,
       log.branch_name as current_location
FROM inventory inv
LEFT JOIN inventory_log log ON inv.item_code = log.item_code
LEFT JOIN inventory_audit audit ON inv.item_code = audit.item_code 
      AND audit.date_scan = :date
WHERE inv.item_location = :branch
  AND audit.item_code IS NULL AND inv.status != 'DEFECTIVE' AND inv.status != 'DISPOSED';");
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	static public function mdlAddUnregister($table, $data) {
		try {
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
	
			$stmt = $pdo->prepare("INSERT INTO $table(
			branch_name, sticker_no,  item_description, serial_no, 
			date_purchased) 
			VALUES
			 (:branch_name, :sticker_no, :item_description, 
			 :serial_no, :date_purchased)");

			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":sticker_no", $data["sticker_no"], PDO::PARAM_STR);
			$stmt->bindParam(":item_description", $data["item_description"], PDO::PARAM_STR);
			$stmt->bindParam(":serial_no", $data["serial_no"], PDO::PARAM_STR);
			$stmt->bindParam(":date_purchased", $data["date_purchased"], PDO::PARAM_STR);

			if ($stmt->execute()) {
				$pdo->commit();
				return "ok";
			} else {
				$pdo->rollBack();
				return "error";
			}
		} catch (PDOException $exception) {
			if ($pdo) {
				$pdo->rollBack();
			}
			return "error: " . $exception->getMessage(); // Return detailed error message
		} finally {
			if ($stmt) {
				$stmt->closeCursor();
				$stmt = null;
			}
			if ($pdo) {
				$pdo = null; // Close the connection
			}
		}
	}
	static public function mdlGetAllRequest($date) {
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `inventory_unregistered` WHERE `date` LIKE :date");
		$stmt->bindValue(":date", $date.'%', PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt = null;
		return $result;
	}


	static public function mdlCheckSticker($sticker_no, $branch){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `inventory` WHERE `sticker_no` = :sticker_no AND `item_location` = :item_location");
		$stmt->bindValue(":sticker_no",$sticker_no, PDO::PARAM_STR);
		$stmt->bindValue(":item_location",$branch, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt = null;
		return $result;
	
	}

	static public function mdlCheckItemLog($item_code){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `inventory_log` WHERE `item_code` = :item_code");
		$stmt->bindValue(":item_code",$item_code, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt = null;
		return $result;
	
	}

	
	static public function mdlgetLastCountCategory($class_categ){
		$stmt = (new Connection)->connect()->prepare("SELECT COUNT(id) as total FROM `inventory` WHERE `class_category` = :class_category");
		$stmt->bindValue(":class_category",$class_categ, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt = null;
		return $result;
	
	}

	static public function mdlCheckClassCode($class_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory WHERE class_code = :class_code limit 1");
		$stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }


	static public function mdlAddItemSet($data)
    {	
        try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO inventory_itemset(class_code, item_code, item_description, set_type, item_location, set_categ) VALUES
			(:class_code, :item_code, :item_description, :set_type, :item_location, :set_categ)");
			$stmt->bindParam(":class_code", $data["class_code"], PDO::PARAM_STR);
			$stmt->bindParam(":item_code", $data["item_code"], PDO::PARAM_STR);
			$stmt->bindParam(":item_description", $data["item_description"], PDO::PARAM_STR);
			$stmt->bindParam(":set_type", $data["set_type"], PDO::PARAM_STR);
			$stmt->bindParam(":item_location", $data["item_location"], PDO::PARAM_STR);
			$stmt->bindParam(":set_categ", $data["set_categ"], PDO::PARAM_STR);
			if($stmt->execute()){
				$pdo->commit();
				return "ok";
			}
			$stmt->close();
			$stmt = null;
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}
    }


	static public function mdlGetItemSetPrim($class_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT b.sticker_no, a.item_description, a.status FROM inventory_itemset a INNER JOIN inventory b ON(a.item_code = b.item_code)  WHERE a.class_code = :class_code AND set_categ = 'PRIMARY' ORDER by b.sticker_no ASC;");
		$stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	
	static public function mdlGetItemSetAdd($class_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT a.id, b.sticker_no, a.item_description, a.status,a.date_added FROM inventory_itemset a INNER JOIN inventory b ON(a.item_code = b.item_code)  WHERE a.class_code = :class_code AND set_categ = 'ADDITIONAL' ORDER by a.id ASC;");
		$stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	
	static public function mdlGetAdditionalItem($item_location){	
        $stmt = (new Connection)->connect()->prepare("SELECT a.*
FROM inventory a
LEFT JOIN inventory_itemset b ON a.item_code = b.item_code
WHERE b.item_code IS NULL 
  AND a.item_location = :item_location
  AND a.class_list != 'COMPUTER SET'
  AND a.class_list != 'CCTV SET'
ORDER BY a.id DESC;
");
		$stmt->bindParam(":item_location", $item_location, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	static public function mdlGetDataByItemCode($item_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory  WHERE item_code = :item_code LIMIT 1;");
		$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }
	


	static public function mdlGetItmebyBranchAudit($branch, $date){	
        $stmt = (new Connection)->connect()->prepare("SELECT COUNT(id) as total_item FROM `inventory` WHERE item_location = :branch AND status != 'DEFECTIVE' AND status != 'DISPOSED' AND date_scan = :date; ");
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
		$stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }

	public static function mdlGetFurnitureByBranch($branch) {
		// Prepare the SQL query with adjustments to match branch names correctly
		$stmt = (new Connection)->connect()->prepare("
			SELECT 
    b.branch_name AS item_location, 
    b.id,         
    COUNT(i.id) AS total_items,
    SUM(CASE WHEN i.class_category = 'CHAIRS' THEN 1 ELSE 0 END) AS total_chairs,
    SUM(CASE WHEN i.class_category = 'CABINETS' THEN 1 ELSE 0 END) AS total_cabinets,
    SUM(CASE WHEN i.class_category = 'TABLES' THEN 1 ELSE 0 END) AS total_tables
FROM 
    accounting_branches b
LEFT JOIN 
    inventory i 
ON 
    (CASE 
        WHEN b.branch_name LIKE 'RLC%' THEN REPLACE(b.branch_name, 'RLC', 'RFC')
        ELSE b.branch_name 
     END) = i.item_location
    AND i.class_type = 'FURNITURE'
  WHERE b.branch_name LIKE :branch
GROUP BY 
    b.id, b.branch_name
ORDER BY 
    b.id;
		");
	
		// Bind the parameter with the wildcard for the LIKE condition
		$branch1 = $branch . '%';
		$stmt->bindParam(":branch", $branch1, PDO::PARAM_STR);
	
		// Execute the statement
		$stmt->execute();
	
		// Fetch the result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Nullify the statement to close the connection
		$stmt = null;
	
		// Return the result
		return $result;
	}

	public static function mdlGetFixtureByBranch($branch) {
		// Prepare the SQL query with adjustments to match branch names correctly
		$stmt = (new Connection)->connect()->prepare("
			SELECT 
    b.branch_name AS item_location, 
    b.id,         
    COUNT(i.id) AS total_items,
    SUM(CASE WHEN i.class_category = 'IMAGES / STATUES' THEN 1 ELSE 0 END) AS total_images,
    SUM(CASE WHEN i.class_category = 'DECORATIONS' THEN 1 ELSE 0 END) AS total_decoration,
    SUM(CASE WHEN i.class_category = 'PAINTINGS' THEN 1 ELSE 0 END) AS total_paintings,
    SUM(CASE WHEN i.class_category = 'HOUSEHOLD EFFECTS' THEN 1 ELSE 0 END) AS total_household,
    SUM(CASE WHEN i.class_category = 'APPLIANCES' THEN 1 ELSE 0 END) AS total_appliances
FROM 
    accounting_branches b
LEFT JOIN 
    inventory i 
ON 
    (CASE 
        WHEN b.branch_name LIKE 'RLC%' THEN REPLACE(b.branch_name, 'RLC', 'RFC')
        ELSE b.branch_name 
     END) = i.item_location
    AND i.class_type = 'FIXTURES'
  WHERE b.branch_name LIKE :branch
GROUP BY 
    b.id, b.branch_name
ORDER BY 
    b.id;
		");
	
		// Bind the parameter with the wildcard for the LIKE condition
		$branch1 = $branch . '%';
		$stmt->bindParam(":branch", $branch1, PDO::PARAM_STR);
	
		// Execute the statement
		$stmt->execute();
	
		// Fetch the result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Nullify the statement to close the connection
		$stmt = null;
	
		// Return the result
		return $result;
	}


	public static function mdlGetEquipmentByBranch($branch) {
		// Prepare the SQL query with adjustments to match branch names correctly
		$stmt = (new Connection)->connect()->prepare("
			SELECT 
    b.branch_name AS item_location, 
    b.id,         
    COUNT(i.id) AS total_items,
    SUM(CASE WHEN i.class_category = 'COMPUTERS' THEN 1 ELSE 0 END) AS total_computers,
    SUM(CASE WHEN i.class_category = 'PRINTERS / COPIERS' THEN 1 ELSE 0 END) AS total_printers,
    SUM(CASE WHEN i.class_category = 'PERIPHERALS / ACCESSORIES' THEN 1 ELSE 0 END) AS total_peripherals,
    SUM(CASE WHEN i.class_category = 'CCTV EQUIPMENTS' THEN 1 ELSE 0 END) AS total_cctv,
    SUM(CASE WHEN i.class_category = 'SOUNDS AND MIXERS' THEN 1 ELSE 0 END) AS total_sounds,
    SUM(CASE WHEN i.class_category = 'GADGETS / COMMUNICATION / CONNECTIVITY' THEN 1 ELSE 0 END) AS total_gadgets,
    SUM(CASE WHEN i.class_category = 'MOTOR VEHICLE' THEN 1 ELSE 0 END) AS total_motor,
    SUM(CASE WHEN i.class_category = 'OTHER FFE' THEN 1 ELSE 0 END) AS total_other
FROM 
    accounting_branches b
LEFT JOIN 
    inventory i 
ON 
    (CASE 
        WHEN b.branch_name LIKE 'RLC%' THEN REPLACE(b.branch_name, 'RLC', 'RFC')
        ELSE b.branch_name 
     END) = i.item_location
    AND i.class_type = 'EQUIPMENT'
  WHERE b.branch_name LIKE :branch
GROUP BY 
    b.id, b.branch_name
ORDER BY 
    b.id;
		");
	
		// Bind the parameter with the wildcard for the LIKE condition
		$branch1 = $branch . '%';
		$stmt->bindParam(":branch", $branch1, PDO::PARAM_STR);
	
		// Execute the statement
		$stmt->execute();
	
		// Fetch the result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Nullify the statement to close the connection
		$stmt = null;
	
		// Return the result
		return $result;
	}


	public static function mdlGetFixtureByBranch1($branch, $class_type) {
		// Prepare the SQL query with adjustments to match branch names correctly
		$stmt = (new Connection)->connect()->prepare("
			SELECT * FROM `inventory` 
				WHERE item_location = :branch AND class_type = :class_type 
			ORDER BY  date_purchased ASC
		");
		$stmt->bindParam(":branch", $branch, PDO::PARAM_STR);
		$stmt->bindParam(":class_type", $class_type, PDO::PARAM_STR);
	
		// Execute the statement
		$stmt->execute();
	
		// Fetch the result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Nullify the statement to close the connection
		$stmt = null;
	
		// Return the result
		return $result;
	}

	
	public static function mdlGetUndeliveredItem() {
		// Prepare the SQL query with adjustments to match branch names correctly
		$stmt = (new Connection)->connect()->prepare("
			SELECT a.sticker_no, a.item_description, a.item_location, a.date_purchased FROM `inventory` a LEFT JOIN inventory_log b 
			ON(a.item_code  = b.item_code) WHERE  b.branch_name is null  
			ORDER BY `a`.`date_purchased` ASC
		");
		// Execute the statement
		$stmt->execute();
	
		// Fetch the result
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Nullify the statement to close the connection
		$stmt = null;
	
		// Return the result
		return $result;
	}

	
	static public function mdlGetDataByID($id){	
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM inventory  WHERE id = :id LIMIT 1;");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }



	public static function mdlDeleteSet($class_code, $table) {
		try {
			// Create a connection
			$conn = (new Connection)->connect();
			
			// Start a transaction to ensure both queries are executed together
			$conn->beginTransaction();
	
			// Delete from the first table
			$stmt = $conn->prepare("DELETE FROM $table WHERE class_code = :class_code");
			$stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
			$stmt->execute();
	
			// Check if any rows were deleted
			if ($stmt->rowCount() > 0) {
				// Delete from the inventory_itemset table if the first delete was successful
				$stmt1 = $conn->prepare("DELETE FROM inventory_itemset WHERE class_code = :class_code");
				$stmt1->bindParam(":class_code", $class_code, PDO::PARAM_STR);
				$stmt1->execute();
	
				// Commit the transaction
				$conn->commit();
				
				return "ok"; // Return success
			} else {
				// No rows were deleted, roll back the transaction
				$conn->rollBack();
				return "error"; // Return specific message
			}
	
		} catch (PDOException $e) {
			// Rollback in case of error
			$conn->rollBack();
			
			// Log the error message for debugging
			error_log($e->getMessage());
			return "error"; // Return general error
		} finally {
			// Close the statement and connection
			$stmt = null;
			$conn = null;
		}
	}


	static public function mdlCheckDatSet($class_code){	
        $stmt = (new Connection)->connect()->prepare("SELECT  a.id, a.sticker_no FROM inventory a LEFT JOIN inventory_itemset b 
		ON(a.item_code = b.item_code) 
		WHERE a.class_code = :class_code and b.class_code is null;");
		$stmt->bindParam(":class_code", $class_code, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt = null;
    }
	
	public static function mdlDeleteDataByItemCode($item_code, $table) {
		try {
			$conn = (new Connection)->connect();
			$stmt = $conn->prepare("DELETE FROM $table WHERE item_code = :item_code");
			$stmt->bindParam(":item_code", $item_code, PDO::PARAM_STR);
			$stmt->execute();
	
			// Check if any rows were affected (deleted)
			if ($stmt->rowCount() > 0) {
				return "ok";
			} else {
				return "error"; // Optional: Indicate if no rows were deleted
			}
			
		} catch (PDOException $e) {
			// Handle error (log it, rethrow it, etc.)
			error_log($e->getMessage());
			return "error"; // Indicate an error occurred
		} finally {
			// Ensure the statement and connection are closed
			$stmt = null;
			$conn = null;
		}
	}
	
	
}

