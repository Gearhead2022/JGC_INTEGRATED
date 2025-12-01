<?php
require_once "connection.php";
class ModelORPrinting{

	static public function 
	
	
	mdlAddCollectionRecords($data){
		$stmt = (new Connection)->connect()->prepare("INSERT INTO `sspclct` (cdate, account_id, batch, mntheff, amount, posted, collstat, bankno,
        balterm, atmbal, branch_name) VALUES (:cdate, :account_id, :batch, :mntheff, :amount, :posted, :collstat, :bankno, :balterm, :atmbal, :branch_name)");
		
		$stmt->bindParam(":cdate", $data["cdate"], PDO::PARAM_STR);
		$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
		$stmt->bindParam(":batch", $data["batch"], PDO::PARAM_STR);
		$stmt->bindParam(":mntheff", $data["mntheff"], PDO::PARAM_STR);
		$stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
        $stmt->bindParam(":posted", $data["posted"], PDO::PARAM_STR);
        $stmt->bindParam(":collstat", $data["collstat"], PDO::PARAM_STR);
        $stmt->bindParam(":bankno", $data["bankno"], PDO::PARAM_STR);
        $stmt->bindParam(":balterm", $data["balterm"], PDO::PARAM_INT);
        $stmt->bindParam(":atmbal", $data["atmbal"], PDO::PARAM_STR);
		$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	

    static public function mdlCheckCollectionDuplication($collDate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sspclct` WHERE cdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlGetCollectionRecords($collDate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sspclct` WHERE cdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlCheckCollectionReceiptDuplication($account_id, $collDate){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE account_id = '$account_id' AND tdate = '$collDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetCollectionInfo($account_id, $collDate){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE account_id = '$account_id' AND tdate = '$collDate'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlAddTRy($data){
		$stmt = (new Connection)->connect()->prepare("INSERT INTO `birrec` (account_id, name, bank, target, normal, actpnsn, amount) VALUES (:account_id, :name, :bank, :target, :normal, :actpnsn, :amount)");
		
		$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
		$stmt->bindParam(":target", $data["target"], PDO::PARAM_STR);
		$stmt->bindParam(":normal", $data["normal"], PDO::PARAM_STR);
        $stmt->bindParam(":actpnsn", $data["actpnsn"], PDO::PARAM_STR);
        $stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}	
    static public function mdlGetCLCTRecords($account_id, $collDate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sspclct` WHERE account_id = $account_id AND cdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}
	
	static public function mdlAddBIRRECRecord($table, $data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$tdate =  $data["tdate"];
            $account_id =  $data["account_id"];
			$branch_name =  $data["branch_name"];

			$checker = self::mdlCheckIfRecordExist($account_id, $tdate, $branch_name);
        
            if($checker == "insert"){

				$stmt = (new Connection)->connect()->prepare("INSERT INTO `$table`(`rdate`, `name`, `amtwrd`, `amount`,`birsales`, `biramt`, 
				`birdue`, `tdate`, `ttime`, `desc`, `account_id`, `month`, `day`, `yr`, `branch_name`) VALUES (:rdate, :name, :amtwrd, :amount, :birsales, :biramt, :birdue, :tdate, :ttime, :desc, :account_id, :month, :day, :yr, :branch_name)");
				
				$stmt->bindParam(":rdate", $data["rdate"], PDO::PARAM_STR);
				$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
				$stmt->bindParam(":amtwrd", $data["amtwrd"], PDO::PARAM_STR);
				$stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
				$stmt->bindParam(":birsales", $data["birsales"], PDO::PARAM_STR);
				$stmt->bindParam(":biramt", $data["biramt"], PDO::PARAM_STR);
				$stmt->bindParam(":birdue", $data["birdue"], PDO::PARAM_STR);
				$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
				$stmt->bindParam(":ttime", $data["ttime"], PDO::PARAM_STR);
				$stmt->bindParam(":desc", $data["desc"], PDO::PARAM_STR);
				$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
				$stmt->bindParam(":month", $data["month"], PDO::PARAM_STR);
				$stmt->bindParam(":day", $data["day"], PDO::PARAM_STR);
				$stmt->bindParam(":yr", $data["yr"], PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);

				if($stmt->execute()){
					return "ok";
				}else{
					return "error";
				}

            }else{

				$stmt = (new Connection)->connect()->prepare("UPDATE `birrec` SET `rdate`= :rdate, `name`= :name, `amtwrd`= :amtwrd, `amount`= :amount, `birsales`= :birsales, `biramt`= :biramt, `birdue`= :birdue,
				`tdate`= :tdate, `ttime`= :ttime, `desc`= :desc, `account_id`= :account_id, `month`= :month, `day`= :day, `yr`= :yr, `branch_name`= :branch_name WHERE `account_id`= :account_id AND `tdate`= :tdate AND `branch_name`= :branch_name");
				
				$stmt->bindParam(":rdate", $data["rdate"], PDO::PARAM_STR);
				$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
				$stmt->bindParam(":amtwrd", $data["amtwrd"], PDO::PARAM_STR);
				$stmt->bindParam(":amount", $data["amount"], PDO::PARAM_STR);
				$stmt->bindParam(":birsales", $data["birsales"], PDO::PARAM_STR);
				$stmt->bindParam(":biramt", $data["biramt"], PDO::PARAM_STR);
				$stmt->bindParam(":birdue", $data["birdue"], PDO::PARAM_STR);
				$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
				$stmt->bindParam(":ttime", $data["ttime"], PDO::PARAM_STR);
				$stmt->bindParam(":desc", $data["desc"], PDO::PARAM_STR);
				$stmt->bindParam(":account_id", $data["account_id"], PDO::PARAM_STR);
				$stmt->bindParam(":month", $data["month"], PDO::PARAM_STR);
				$stmt->bindParam(":day", $data["day"], PDO::PARAM_STR);
				$stmt->bindParam(":yr", $data["yr"], PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);

				if($stmt->execute()){
					return "ok";
				}else{
					return "error";
				}

			}
		}catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
		}

	}	

	static public function mdlGetAllCollectionReceiptList($collDate, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE tdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetCollectionReceiptInfo($account_id, $collDate, $branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE account_id = '$account_id' AND tdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlGetLastSavedId($collDate, $branch_name) {
		$stmt = (new Connection)->connect()->prepare("SELECT account_id FROM `birrec` WHERE tdate = :collDate AND branch_name = '$branch_name' ORDER BY id DESC LIMIT 1");
		
		$stmt->bindParam(':collDate', $collDate, PDO::PARAM_STR);
		
		$stmt->execute();
	
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$stmt->closeCursor(); // Close the cursor to enable the next query on this connection
	
		return $result;
	}

	// added 1-25-24 //

	static public function mdlGetIdDescription($account_id, $collDate, $branch_name) {
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE tdate = :collDate AND branch_name = :branch_name AND account_id = :account_id LIMIT 1");
		
		$stmt->bindParam(':collDate', $collDate, PDO::PARAM_STR);
		$stmt->bindParam(':account_id', $account_id, PDO::PARAM_STR);
		$stmt->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);
		
		$stmt->execute();
	
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$stmt->closeCursor(); // Close the cursor to enable the next query on this connection
	
		return $result;
	}

	static public function mdlCheckIfRecordExist($account_id, $tdate, $branch_name){

		$stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE tdate = :tdate AND branch_name = :branch_name AND account_id = :account_id");
		$stmt ->bindParam(":account_id", $account_id, PDO::PARAM_STR);
		$stmt ->bindParam(":tdate", $tdate, PDO::PARAM_STR);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		$stmt -> execute();
		$total = $stmt->rowCount();
        if($total > 0){
            return "update";
        }else{
            return "insert";
        }
		$stmt -> close();
		$stmt = null;
	
	}

	//

	static public function mdlDeleteBIRRECRecord($table, $data){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE account_id = :account_id AND tdate = :tdate");
		$stmt ->bindParam(":account_id", $data['account_id'], PDO::PARAM_STR);
		$stmt ->bindParam(":tdate", $data['tdate'], PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}

	static public function mdlGetAllCollectionReceiptInfo($collDate, $branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `birrec` WHERE tdate = '$collDate' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}



}