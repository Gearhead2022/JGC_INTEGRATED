<?php
require_once "connection.php";

class ModelPermit{
    static public function get_id($ref_id)
            {
                $pdo = (new Connection)->connect();
			    $pdo->beginTransaction();
                $sql = 'SELECT id 
                        FROM working_permit 
                        WHERE ref_id = :ref_id';
                $statement = $pdo->prepare($sql);

                $statement->bindParam(':ref_id', $ref_id, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    return $row !== false ? $row['id'] : false;
                }
                return false;
            }
			static public function mdlAddPermit($table, $data){
				try{
					$pdo = (new Connection)->connect();
					$pdo->beginTransaction();
					$ref_id =  $data["ref_id"];
					$ref_id1= (new ModelPermit)->get_id($ref_id);
					$last_id = $ref_id1 + 1;
					$id_holder =  $data['type'] === null || $data['type'] === 'MIS' ? "WP" : 'PR'  . str_repeat("0",5-strlen($last_id)).$last_id;   
					if (!$ref_id1) {
						$id_holder = $ref_id;
					}
					date_default_timezone_set('Asia/Manila');
					$date_now =date("F d Y h:i:sa");
					$stmt = $pdo->prepare("INSERT INTO $table(ref_id, user_id, wp_to, wp_from, wp_date, request_level,  wp_req_for, branch, 
					wp_req_by, wp_chk_by, wp_app_by, wp_app_by1, `type`) VALUES (:ref_id, :user_id, :wp_to, :wp_from, :wp_date, :request_level, :wp_req_for, :branch, :wp_req_by, :wp_chk_by, :wp_app_by, :wp_app_by1, :type1)");
					$stmt->bindParam(":ref_id", $id_holder, PDO::PARAM_STR);
					$stmt->bindParam(":user_id", $data["user_id"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_to", $data["wp_to"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_from", $data["wp_from"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_date", $date_now, PDO::PARAM_STR);
					$stmt->bindParam(":request_level", $data["request_level"], PDO::PARAM_INT);
					$stmt->bindParam(":wp_req_for", $data["wp_req_for"], PDO::PARAM_STR);
					$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_req_by", $data["wp_req_by"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_chk_by", $data["wp_chk_by"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_app_by", $data["wp_app_by"], PDO::PARAM_STR);
					$stmt->bindParam(":wp_app_by1", $data["wp_app_by1"], PDO::PARAM_STR);
					$stmt->bindParam(":type1", $data["type"], PDO::PARAM_STR);
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
    static public function mdlShowPermit($user_id, $filterType){
		if($filterType == "MIS" || $filterType == ""){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE user_id = '$user_id' AND `type` = 'MIS' ORDER BY id DESC");
		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE user_id = '$user_id' AND `type` = 'PSPMI' ORDER BY id DESC");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	static public function mdlShowPermitAdmin($type, $filter, $filterType){
		$username = $_SESSION['username'];
		$currentDate = date('Y-m-d');
		$filterType = $filterType ?? '';
		$typeFilter = ($filterType === "MIS" || $filterType === "") ? "MIS" : "PSPMI";
		if($type === "wp_accounting"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 1 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 1 AND `type` = :typeFilter
                )
                ORDER BY id DESC");

				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 1 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		}elseif($type === "wp_operation"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 2 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 2 AND `type` = :typeFilter
                )
                ORDER BY id DESC");

				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 2 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		
		}elseif($type === "wp_hrom"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 3 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 3 AND `type` = :typeFilter
                )
                ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 3 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		}elseif($type === "wp_financial"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from IN (4, 10, 11) AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from IN (4, 10, 11) AND `type` = :typeFilter
                )
                ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from IN (4, 10, 11) AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		
		}elseif($type === "wp_audit"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 5 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 5 AND `type` = :typeFilter
                )
                ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 5 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		
		}elseif($type === "wp_credit"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 6 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 6 AND `type` = :typeFilter
                )
                ORDER BY id DESC");

				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 6 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		}elseif($type === "wp_grcd"){
			if($filter == null){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
                WHERE (
                    wp_from = 7 AND `type` = :typeFilter
                    AND `status` NOT IN ('Done', 'Rejected')
                )
                OR (
                    DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :currentDate
                    AND wp_from = 7 AND `type` = :typeFilter
                )
                ORDER BY id DESC");

				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
				WHERE wp_from = 7 AND
				 (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = :filter AND `type` = :typeFilter)
				ORDER BY id DESC");
				$stmt->bindParam(":typeFilter", $typeFilter, PDO::PARAM_STR);
				$stmt->bindParam(":filter", $filter, PDO::PARAM_STR);
		}
		}elseif($type === "wp_pspmi"){
			if($filterType === "MIS" || $filterType === ""){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE wp_from = 8 AND `type` = 'MIS' ORDER BY id DESC");
				}elseif($filterType === 'PSPMI'){
					$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
					WHERE  
					(
					(`type` = 'PSPMI')
					AND
					(
					(wp_from != 8 AND chk = 'Approved' )
						OR
					(wp_from = 8)
					)
					)
					ORDER BY id DESC");
				}
			}elseif($type === "wp_approve" ){
				if($username === "CGN"){
					if($filterType === "MIS" || $filterType === ""){
						$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE
						(
						(chk = 'Approved' AND request_level = 2 AND `status` != 'Done'  AND `type` = 'MIS')
									OR
						(chk = 'Approved' AND wp_from = 4 AND `status` != 'Done' AND `type` = 'MIS')
						)
							OR
						(
							(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate' AND `type` = 'MIS'  AND chk = 'Approved' )
									AND
							(request_level = 2 OR wp_from = 4  AND chk = 'Approved' AND  `type` = 'MIS')
						)
						ORDER BY id DESC");
					}else{
						$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE
						(
							(
								(`status` != 'Done' AND `type` = 'PSPMI')
							)	
							AND 
							(
								(wp_from != 8 AND app1 = 1 )
										OR
								(wp_from = 8 AND chk = 'Approved')
							)
						)
						OR
							(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate' AND `type` = 'PSPMI' AND app = 1)
						ORDER BY id DESC");
					}
				}else{
					if($filter == null){
						if($filterType === "MIS" || $filterType === ""){
						$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE 
						(
							(request_level = 2 AND app = 1 AND `status` != 'Done'   AND `type` = 'MIS')
							OR
							(request_level = 1 AND chk = 'Approved' AND `status` != 'Done'  AND `type` = 'MIS')
						)
						OR
						(
							(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND request_level = 2 AND app = 1 AND `type` = 'MIS') 
									OR 
							(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND request_level = 1 AND chk = 'Approved' ) 
						)
						ORDER BY id DESC;
						");
						}else{
							$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
							WHERE
							
								(
									(`status` != 'Done' AND `type` = 'PSPMI'  AND wp_from = 9 )
								)	
									OR
								(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate' AND `type` = 'PSPMI' AND wp_from = 9)
							ORDER BY id DESC");

						}
					}else{
						$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE 
						(
							(request_level = 2 AND app = 1)
							OR
							(request_level = 1 AND chk = 'Approved')
						)
											AND
						DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$filter' 
						ORDER BY id DESC;
						");
					}
				
				}
		}
		elseif($type === "wp_mis" ){
			if($filter == null){
				if($filterType === "MIS" || $filterType === ""){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			 WHERE
				(
					(app1 = 1 AND  request_level = 1 AND `status` != 'Done' AND `type` = 'MIS')
							OR
					(request_level = 2 AND app = 1  AND app1 = 1 AND `status` != 'Done' AND `type` = 'MIS')
				)
				OR
				(
					DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND app1 = 1 AND `type` = 'MIS'
				)
			 ORDER BY id DESC");

				}else{
					$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
					WHERE
					   (
						   (wp_from = '9' AND `status` != 'Done' AND `type` = 'PSPMI')
					   )
					   OR
					   
					   (
						   DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND  wp_from = '9' AND `type` = 'PSPMI'
					   )
					ORDER BY id DESC");
					
				}
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE 
						(
							 app1 = 1
							
						)
											AND
						DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$filter' AND `type` = '$typeFilter'
						ORDER BY id DESC;
						");
			}
		}
		elseif($type === "wp_pspmi_admin"){
			if($filter == null){
			if($filterType === "MIS" || $filterType === ""){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
				WHERE
				(
					(wp_from = 8 AND `type` = 'MIS')
					  AND 
					(`status` != 'Done' AND `status` != 'Rejected' )
				)
				OR 
				(DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND wp_from = 8  AND `type` = 'MIS')
				 ORDER BY id DESC");
			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
				WHERE
				   (
					   (app = 1 AND  `status` != 'Done' AND `type` = 'PSPMI')
				   OR
					   (DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$currentDate'  AND app = 1 AND `type` = 'PSPMI')
				   )
				ORDER BY id DESC");
			}

		}else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
			WHERE 
			(
				 app = 1
			)
								AND
			DATE(STR_TO_DATE(wp_date, '%M %d %Y %h:%i:%s%p')) = '$filter' AND `type` = '$typeFilter'
			ORDER BY id DESC;
			");
		}
		}
		else{
			if($filterType === "MIS" || $filterType == ""){
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE `type` = 'MIS' ORDER BY id DESC");

			}else{
				$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE `type` = 'PSPMI' ORDER BY id DESC");
			}
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	
	
	static public function mdlEditPermit($table, $data){

		$stmt = (new Connection)->connect()->prepare("UPDATE $table SET wp_to = :wp_to, wp_from = :wp_from, 
		 wp_req_for = :wp_req_for, request_level = :request_level, branch = :branch, wp_req_by = :wp_req_by, wp_chk_by = :wp_chk_by, 
		wp_app_by = :wp_app_by, wp_app_by1 = :wp_app_by1, wp_remarks = :wp_remarks WHERE id = :id");
		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":wp_to", $data["wp_to"], PDO::PARAM_STR);	
		$stmt->bindParam(":wp_from", $data["wp_from"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_req_for", $data["wp_req_for"], PDO::PARAM_STR);
		$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
		$stmt->bindParam(":request_level", $data["request_level"], PDO::PARAM_INT);
		$stmt->bindParam(":wp_req_by", $data["wp_req_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_chk_by", $data["wp_chk_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_app_by", $data["wp_app_by"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_app_by1", $data["wp_app_by1"], PDO::PARAM_STR);
		$stmt->bindParam(":wp_remarks", $data["wp_remarks"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;

	}	
	static public function mdlDeletePermit($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
		$stmt -> bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	

	static public function mdlDone($table, $data, $wp_remarks){
		date_default_timezone_set('Asia/Manila');
		$date_done =date("F d Y h:i:sa");
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='Done', date_done =:date_done, wp_remarks = :wp_remarks WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		$stmt ->bindParam(":date_done", $date_done, PDO::PARAM_STR);
		$stmt ->bindParam(":wp_remarks", $wp_remarks, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;

	}
	
	static public function mdlAddPermitImg($table1, $data1){ 
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table1(ref_id,  file_name, image_time) VALUES (:ref_id, :file_name, :image_time)");
			$stmt->bindParam(":ref_id", $data1["ref_id"], PDO::PARAM_STR);
			$stmt->bindParam(":file_name", $data1["file_name"], PDO::PARAM_STR);
			$stmt->bindParam(":image_time", $data1["image_time"], PDO::PARAM_STR);
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

	static public function mdlShowImg($table, $ref_id){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE ref_id = '$ref_id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlDeleteAll($table1, $ref_id){
		$stmt = (new Connection)->connect()->prepare("DELETE  FROM $table1 WHERE ref_id =:ref_id");
	
		$stmt -> bindParam(":ref_id", $ref_id, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlApprove($table, $data, $username){
		if($username == "CGN"){
			$stmt = (new Connection)->connect()->prepare("UPDATE $table Set  app ='1' WHERE id = :id");
		}else{
			$stmt = (new Connection)->connect()->prepare("UPDATE $table Set  app1 ='1' WHERE id = :id");
		}
			$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
			$stmt -> close();
			$stmt = null;
	}

	static public function mdlCheck($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set chk ='Approved' WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}


	static public function mdlReject($table, $data){
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set chk ='Rejected', `status` = 'Rejected' WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetNotification($currentDate) {
		$type = $_SESSION['type'];
		$username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
		$db = (new Connection)->connect();
		if ($type === "wp_approve") {
			if($username === "EGG"){
				$stmt = $db->prepare("
					SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
					WHERE
					 `chk` = 'Approved' AND `request_level` = 1 AND `status` != 'Done' AND `type` = 'MIS'
							OR 
					`request_level` = 2 AND app = 1 AND `status` != 'Done'  AND `type` = 'MIS'
						OR
					`type` = 'PSPMI' AND wp_from = 9 AND `status` != 'Done'
				");
			}else{
				$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
					(
						(
							`chk` = 'Approved' AND `request_level` = 2 AND type = 'MIS'  
								OR
							wp_from = 8 AND type = 'PSPMI' AND `chk` = 'Approved' 
								OR
							wp_from != 8 AND type = 'PSPMI' AND app1 = 1

						)
						AND 
						`status` != 'Done'
					)
				");
			}
		
		}elseif ($type === "admin") {
			$stmt = $db->prepare("
					SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				status != 'Done'
				AND app1 = 1
			");
		}elseif ($type === "wp_accounting") {
			$stmt = $db->prepare("
					SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				 (wp_from = 1)
					  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			");

		}elseif ($type === "wp_operation") {
			$stmt = $db->prepare("
						SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				 (wp_from = 2)
					  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			");
		} elseif ($type === "wp_hrom") {
			$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				 (wp_from = 3)
					  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			");
		} elseif ($type === "wp_financial") {
				$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				(wp_from IN (4, 10, 11))
					AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			");
		}elseif ($type === "wp_audit") {
			$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				(wp_from = 5)
					AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			");
		}elseif ($type === "wp_credit") {
			$stmt = $db->prepare("
			SELECT
			COUNT(*) AS total,
			SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
			SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
			FROM working_permit 
			WHERE
			(wp_from = 6)
				AND 
			(`status` != 'Done' AND `status` != 'Rejected' )
		");
		}elseif ($type === "wp_grcd") {
			$stmt = $db->prepare("
			SELECT
			COUNT(*) AS total,
			SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
			SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
			FROM working_permit 
			WHERE
			(wp_from = 7)
				AND 
			(`status` != 'Done' AND `status` != 'Rejected' )
		");
		}elseif ($type === "wp_pspmi") {
			$stmt = $db->prepare("
					SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				(
					(
						`type` = 'PSPMI'
								OR
						`type` = 'MIS' AND wp_from = 8
					)
						AND
				(status != 'Done' AND status != 'Rejected')
				 )
			");
		}elseif ($type === "wp_pspmi_admin") {
			$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				 status != 'Done' AND status != 'Rejected'
				 AND 
				 `type` = 'PSPMI'
				AND 
				app = 1
			");
		}elseif ($type === "wp_mis") {
			$stmt = $db->prepare("
			SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				(	
					(
						(`app1` = 1 AND `type` = 'MIS')
							OR
						(`wp_from` = 9 AND `type` = 'PSPMI')
					)
					AND 
					(status != 'Done' AND status != 'Rejected')
				)
			");
		}elseif ($type === "wp_user") {
			$stmt = $db->prepare("
				SELECT
				COUNT(*) AS total,
				SUM(CASE WHEN type = 'PSPMI' THEN 1 ELSE 0 END) AS total_pspmi,
				SUM(CASE WHEN type = 'MIS' THEN 1 ELSE 0 END) AS total_mis
				FROM working_permit 
				WHERE
				user_id = :user_id
				AND  `chk` = 'Approved' 
				AND status != 'Done'
				AND status != 'Rejected'
			");
			$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
		}else {
			// Fallback query for other types
			$stmt = $db->prepare("
				SELECT * FROM working_permit 
				 WHERE
				(	
					(
						(`app1` = 1 AND `type` = 'MIS')
								OR
						(`app` = 1 AND `type` = 'PSPMI')
					)
						AND 
					(status != 'Done' AND status != 'Rejected')
				)
			");
		}
		$stmt->execute();
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$stmt = null;
		return $results;
	}
	

	static public function mdlReceived($table, $data, $user){
		date_default_timezone_set('Asia/Manila');
		$currentDate =date("F d Y h:i:sa");
		$stmt = (new Connection)->connect()->prepare("UPDATE $table Set  `status` = 'Inprogress', `received_by` = :user, `date_received` = :currentDate   WHERE id = :id");
		$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
		$stmt ->bindParam(":currentDate", $currentDate, PDO::PARAM_STR);
		$stmt ->bindParam(":user", $user, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlShowPermitByID($data){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit WHERE id = '$data' ORDER BY id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	

	static public function mdlShowNotification($type){
		$username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
		$currentDate = date('Y-m-d');
		if($type === "wp_accounting"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			WHERE
			(
				(wp_from = 1)
				  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			)
			  ORDER BY type ASC, id DESC");
	}elseif($type === "wp_operation"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			WHERE
			(
				(wp_from = 2)
				  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			)
			   ORDER BY type ASC, id DESC");
	
	}elseif($type === "wp_hrom"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			WHERE
			(
				(wp_from = 3)
				  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			)
			  ORDER BY type ASC, id DESC");
	}elseif($type === "wp_financial"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			WHERE
			(
				( wp_from IN (4, 10, 11))
				  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			)
			  ORDER BY type ASC, id DESC");
	
	}elseif($type === "wp_audit"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			WHERE
			(
				(wp_from = 5)
				  AND 
				(`status` != 'Done' AND `status` != 'Rejected' )
			)
			  ORDER BY type ASC, id DESC");
	
	}elseif($type === "wp_credit"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
		WHERE
		(
			(wp_from = 6)
			  AND 
			(`status` != 'Done' AND `status` != 'Rejected' )
		)
		  ORDER BY type ASC, id DESC");
	
	}elseif($type === "wp_grcd"){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
		WHERE
		(
			(wp_from = 7)
			  AND 
			(`status` != 'Done' AND `status` != 'Rejected' )
		)
		  ORDER BY type ASC, id DESC");
	
	}elseif($type === "wp_pspmi"){
		$stmt = (new Connection)->connect()->prepare(
			"SELECT * FROM working_permit
			 WHERE  
				 `type` = 'PSPMI'
				AND 
				status != 'DONE' AND status != 'REJECT'
			 ORDER BY id DESC");
	}elseif($type === "wp_pspmi_admin"){
		$stmt = (new Connection)->connect()->prepare(
			"SELECT * FROM working_permit
			 WHERE  
				 `type` = 'PSPMI'
				AND 
				status != 'DONE' AND status != 'REJECT'
				AND
				app = 1
			 ORDER BY id DESC");
	}elseif($type === "wp_approve" ){
				if($username === "CGN"){
					$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
					WHERE
					(
						(
							(chk = 'Approved' AND request_level = 2 AND `type` = 'MIS')
								OR
							(chk = 'Approved' AND wp_from = 8 AND `type` = 'PSPMI')
								OR
							(app1 = 1 AND wp_from != 8 AND `type` = 'PSPMI')
						)
						AND 
						(`status` != 'Done' AND `status` != 'Rejected')
					)
								
					ORDER BY type ASC, id DESC");
				}else{
					
						$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit 
						WHERE 
						(
							(request_level = 2 AND app = 1 AND `type` = 'MIS')
								OR
							(request_level = 1 AND chk = 'Approved' AND `type` = 'MIS')
								OR
							(`type` = 'PSPMI' AND wp_from = 9  ) 

						)
						AND
						(
						
							(`status` != 'Done' AND `status` != 'Rejected')
						)


						ORDER BY type ASC, id DESC");
				}
		}
		elseif($type === "wp_mis" ){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
			 WHERE
				(
					(
						(`type` = 'MIS' AND app1 = 1)
								OR
						(`type` = 'PSPMI' AND wp_from = 9)
					)
					AND
					(`status` != 'Done' AND `status` != 'Rejected')
				)
				
				ORDER BY type ASC, id DESC");
		}
		elseif($type === "wp_user"){
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit
					WHERE
						user_id = :user_id 
							AND
						(`status` != 'Done' AND `status` != 'Rejected')"
					);
					$stmt ->bindParam(":user_id", $user_id, PDO::PARAM_STR);
			}
		else{
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM working_permit ORDER BY id DESC");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}	
	
}