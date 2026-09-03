<?php
require_once "connection.php";
class ModelSOA {

    static public function mdlCheckIExist($account_no, $bcode, $tmonth, $tyear) {

        $stmt =  (new Connection)->connect()->prepare("SELECT * FROM `soa` WHERE account_no = :account_no AND MONTH(tdate) = :tmonth AND YEAR(tdate) = :tyear AND bcode = :bcode");
        $stmt->bindParam(':account_no', $account_no);
        $stmt->bindParam(':tmonth', $tmonth);
        $stmt->bindParam(':bcode', $bcode);
        $stmt->bindParam(':tyear', $tyear);
        $stmt->execute();
	
	    $countData = $stmt->rowCount();

		if ($countData > 0) {
			return "exist";
		} else {
			return "not exist";
		}
	}

	static public function mdlAddSOARecordById($table, $data){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			$stmt = $pdo->prepare("INSERT INTO `$table`(`account_no`, `name`, `address`, `bank`, `pension`, `principal`, `change`, `interest`, `from`, `to`, `fa`, `boh`, `tdate`, `ttime`, `others`, `fmonth`, `fyr`, `tmonth`, `tyr`, `branch`, `baltot`, `bcode`, `note`) 
        VALUES (:account_no, :name, :address, :bank, :pension, :principal, :change, :interest, :from, :to, :fa, :boh, :tdate, :ttime, :others, :fmonth, :fyr, :tmonth, :tyr, :branch, :baltot, :bcode, :note)");
			

			$stmt->bindParam(":account_no", $data["account_no"], PDO::PARAM_STR);
			$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
			$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
			$stmt->bindParam(":bank", $data["bank"], PDO::PARAM_STR);
			$stmt->bindParam(":pension", $data["pension"], PDO::PARAM_STR);
			$stmt->bindParam(":principal", $data["principal"], PDO::PARAM_STR);
			$stmt->bindParam(":change", $data["change"], PDO::PARAM_STR);
			$stmt->bindParam(":interest", $data["interest"], PDO::PARAM_STR);
			$stmt->bindParam(":from", $data["from"], PDO::PARAM_STR);
			$stmt->bindParam(":to", $data["to"], PDO::PARAM_STR);
			$stmt->bindParam(":fa", $data["fa"], PDO::PARAM_STR);
			$stmt->bindParam(":boh", $data["boh"], PDO::PARAM_STR);
			$stmt->bindParam(":tdate", $data["tdate"], PDO::PARAM_STR);
			$stmt->bindParam(":ttime", $data["ttime"], PDO::PARAM_STR);
			$stmt->bindParam(":others", $data["others"], PDO::PARAM_STR);
			$stmt->bindParam(":fmonth", $data["fmonth"], PDO::PARAM_STR);
			$stmt->bindParam(":fyr", $data["fyr"], PDO::PARAM_STR);
			$stmt->bindParam(":tmonth", $data["tmonth"], PDO::PARAM_STR);
			$stmt->bindParam(":tyr", $data["tyr"], PDO::PARAM_STR);
			$stmt->bindParam(":branch", $data["branch"], PDO::PARAM_STR);
			$stmt->bindParam(":baltot", $data["baltot"], PDO::PARAM_STR);
			$stmt->bindParam(":bcode", $data["bcode"], PDO::PARAM_STR);
			$stmt->bindParam(":note", $data["note"], PDO::PARAM_STR);

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

	static public function mdlGetBranchEmpRecords($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `soa_info` WHERE branch_name = :branch_name");
		$stmt->bindParam(':branch_name', $branch_name);
		$stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
		$stmt = null;
    }

	static public function mdlAddSOABranchInfo($table, $data, $action){

		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();

			if ($action == 'update') {

				$stmt = $pdo->prepare("UPDATE `$table` SET `fa`= :fa, `boh`= :boh, `address`= :address, `tel`= :tel, `branch_name` = :branch_name, `date` = :date WHERE `id` = :id AND `branch_name` = :branch_name");
				$stmt->bindParam(":id", $data["id"], PDO::PARAM_STR);
				$stmt->bindParam(":fa", $data["fa"], PDO::PARAM_STR);
				$stmt->bindParam(":boh", $data["boh"], PDO::PARAM_STR);
				$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
				$stmt->bindParam(":tel", $data["tel"], PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
				
				$stmt->execute();
				$pdo->commit();
				return "ok";

			} else {
				
				$stmt = $pdo->prepare("INSERT INTO `$table`(`fa`, `boh`, `address`, `tel`, `branch_name`, `date`) VALUES (:fa, :boh, :address, :tel, :branch_name, :date)");
				$stmt->bindParam(":fa", $data["fa"], PDO::PARAM_STR);
				$stmt->bindParam(":boh", $data["boh"], PDO::PARAM_STR);
				$stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
				$stmt->bindParam(":tel", $data["tel"], PDO::PARAM_STR);
				$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
				$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
				
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

	static public function mdlShowAllSOA($id, $fdate, $ldate){
        $type = $_SESSION['type'];
        $branch_name = $_SESSION['branch_name'];
        if($type !="admin"){
            if($id == 0){
                $stmt = (new Connection)->connect()->prepare("SELECT * FROM soa WHERE bcode = '$branch_name' AND `to`>='$fdate' AND `to`<='$ldate'");
            }else{
                $stmt = (new Connection)->connect()->prepare("SELECT * FROM soa WHERE account_no = $id AND bcode = '$branch_name' AND `to`>='$fdate' AND `to`<='$ldate'");
            }
        }else{
            if($id == 0){
                $stmt = (new Connection)->connect()->prepare("SELECT * FROM soa WHERE `to`>='$fdate' AND `to`<='$ldate'");
            }else{
                $stmt = (new Connection)->connect()->prepare("SELECT * FROM soa WHERE account_no = $id AND `to`>='$fdate' AND `to`<='$ldate'");
            }
        }
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlShowSOAInfo(){
        $branch_name = $_SESSION['branch_name'];
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM soa_info WHERE branch_name = '$branch_name'");
    
        
        $stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }
    
      

        static public function mdlReprintSOA($id, $time){
            // Connect to the database
            $conn = (new Connection)->connect();
            // Prepare and execute the select statement to fetch data from soa_info
            $stmt_select = $conn->prepare("SELECT * FROM soa WHERE id = ?");
            $stmt_select->execute([$id]);
            // Fetch all the rows from the select statement result
            $data = $stmt_select->fetchAll();
            // Close the select statement
            $stmt_select->closeCursor(); // Close cursor instead of closing statement
            // If there is data fetched
            if ($data) {
                // Prepare insert statement for soa_logs
                $stmt_insert = $conn->prepare("INSERT INTO soa_logs (account_no, name, type, branch_name, time) VALUES (?, ?, ?, ?, ?)");
                // Loop through the fetched data and insert into soa_logs
                foreach ($data as $row) {
                    $stmt_insert->execute([$row['account_no'], $row['name'], "REPRINTING", $row['bcode'], $time]);
                }
                $stmt_insert->closeCursor(); 
            }
            
            // Close the database connection
            $conn = null;
            return "ok";
        }


        static public function mdlDeleteSOA($id, $time){
            // Connect to the database
            $conn = (new Connection)->connect();
            // Prepare and execute the select statement to fetch data from soa_info
            $stmt_select = $conn->prepare("SELECT * FROM soa WHERE id = ?");
            $stmt_select->execute([$id]);
            // Fetch all the rows from the select statement result
            $data = $stmt_select->fetchAll();
            // Close the select statement
            $stmt_select->closeCursor(); // Close cursor instead of closing statement
            // If there is data fetched
            if ($data) {
                // Prepare insert statement for soa_logs
                $stmt_insert = $conn->prepare("INSERT INTO soa_logs (account_no, name, type, branch_name, time) VALUES (?, ?, ?, ?, ?)");
                // Loop through the fetched data and insert into soa_logs
                foreach ($data as $row) {
                    $stmt_insert->execute([$row['account_no'], $row['name'], "UPDATING", $row['bcode'], $time]);
                }
                
                // Close the insert statement
                $stmt_insert->closeCursor(); // Close cursor instead of closing statement
                
                // Prepare delete statement for soa_info
                $stmt_delete = $conn->prepare("DELETE FROM soa WHERE id = ?");
                
                // Execute delete statement for the specified id
                $stmt_delete->execute([$id]);
                
                // Close the delete statement
                $stmt_delete->closeCursor(); // Close cursor instead of closing statement
            }
            
            // Close the database connection
            $conn = null;
            return "ok";
        }
        
             static public function mdlShowAllLogs(){
            $branch_name = $_SESSION['branch_name'];
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM soa_logs WHERE branch_name = '$branch_name' ORDER BY id Desc;");
            $stmt -> execute();
            return $stmt -> fetchAll();
            $stmt -> close();
            $stmt = null;
        }
      
    
	
}