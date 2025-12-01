<?php
require_once "connection.php";

class ModelDTR{

    static public function mdlShowBranchDailyDTRUpload($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_dtr_upload WHERE branch_name = '$branch_name' ORDER BY entry_date DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }
    static public function mdlAddBranchDailyDTRUpload($table, $data){
		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);

		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {
			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(dtr_id, branch_name, entry_subj, entry_file, entry_date, date_uploaded) VALUES (:dtr_id, :branch_name, :entry_subj, :entry_file, :entry_date, :date_uploaded)");
			$stmt->bindParam(":dtr_id", $data["dtr_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_subj", $data["entry_subj"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $formattedDateTime, PDO::PARAM_STR);
	
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

    static public function mdlDeleteBranchDailyDTRUpload($table, $id, $entry_date, $branch_name){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE entry_date = :entry_date AND branch_name = :branch_name AND id = :id");
		$stmt ->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt ->bindParam(":entry_date", $entry_date, PDO::PARAM_STR);
        
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}
    
    static public function getFileInformation($table, $id, $entry_date, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT entry_file FROM $table WHERE branch_name = :branch_name AND entry_date = :entry_date AND id = :id LIMIT 1");
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':entry_date', $entry_date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Fetch a single row (since we're using LIMIT 1)
        $fileInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $stmt->closeCursor(); // Close the cursor to allow for subsequent queries
    
        return $fileInfo;
    }

    static public function mdlShowHRDailyDTRDownload(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_dtr_upload ORDER BY entry_date DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlUpdateDTRStatus($table, $data){

		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);

		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {

			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}

        $stmt = (new Connection)->connect()->prepare("UPDATE $table SET `status` = 'received', `date_received` = :date_received WHERE id = :id AND branch_name = :branch_name AND entry_date = :entry_date");
        
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        $stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
		$stmt->bindParam(":date_received", $formattedDateTime, PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    
        $stmt->close();
        $stmt = null;
    
    }	

	static public function mdlGetHRDailyDTRDownload($id, $branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_dtr_upload WHERE id = '$id' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlEditBranchDailyDTRUpload($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("UPDATE $table SET branch_name = :branch_name, entry_subj = :entry_subj, entry_file = :entry_file, entry_date = :entry_date WHERE id = :id AND branch_name = :branch_name");
			$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_subj", $data["entry_subj"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
	
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

	static public function mdlCheckDailyDTRExist($branch, $dateSelected){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_dtr_upload WHERE branch_name = '$branch' AND entry_date = '$dateSelected'");
		if($stmt -> execute()){
			 // Check if the query returned any results
			 if ($stmt->rowCount() > 0) {
				return "yes";
			} else {
				return "no";
			}
		}else{
			return "no";	
		}
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlGetBranchDailyDTRUploadList($check_entry_date){

		$stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_dtr_upload WHERE entry_date = '$check_entry_date'");
		if($stmt -> execute()){
			// Check if the query returned any results
			if ($stmt->rowCount() > 0) {
			   return "yes";
		   } else {
			   return "no";
		   }
	   }else{
		   return "no";	
	   }
	   $stmt -> close();
	   $stmt = null;
	
	}

	static public function mdlGetFileInfo($branch_name, $entry_date) {
		$conn = (new Connection)->connect();
		$stmt = $conn->prepare("SELECT * FROM branch_dtr_upload WHERE entry_date = :entry_date AND branch_name = :branch_name");
		$stmt->bindParam(':entry_date', $entry_date, PDO::PARAM_STR);
		$stmt->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor(); // Close cursor to allow for subsequent queries on the same connection
		$conn = null;
	
		return $result;
	}

	// // Branch Time in DTR UPLOAD

	static public function mdlShowBranchDailyTimeInDTRUpload($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE branch_name = '$branch_name' ORDER BY entry_date DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlCheckDailyTimeInDTRExist($branch, $dateSelected){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE branch_name = '$branch' AND entry_date = '$dateSelected'");
		if($stmt -> execute()){
			 // Check if the query returned any results
			 if ($stmt->rowCount() > 0) {
				return "yes";
			} else {
				return "no";
			}
		}else{
			return "no";	
		}
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlAddBranchDailyTimeInDTRUpload($table, $data){
		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);

		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {
			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(dtr_id, branch_name, entry_subj, entry_file, entry_date, date_uploaded) VALUES (:dtr_id, :branch_name, :entry_subj, :entry_file, :entry_date, :date_uploaded)");
			$stmt->bindParam(":dtr_id", $data["dtr_id"], PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_subj", $data["entry_subj"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $formattedDateTime, PDO::PARAM_STR);
	
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

	static public function mdlGetHRDailyTimeInDTRDownload($id, $branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE id = '$id' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlEditBranchDailyTimeInDTRUpload($table, $data){
		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("UPDATE $table SET branch_name = :branch_name, entry_subj = :entry_subj, entry_file = :entry_file, entry_date = :entry_date WHERE id = :id AND branch_name = :branch_name");
			$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_subj", $data["entry_subj"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
	
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

	static public function mdlDeleteBranchDailyTimeInDTRUpload($table, $id, $entry_date, $branch_name){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE entry_date = :entry_date AND branch_name = :branch_name AND id = :id");
		$stmt ->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt ->bindParam(":entry_date", $entry_date, PDO::PARAM_STR);
        
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}

	static public function mdlShowHRDailyTimeInDTRDownload(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload ORDER BY entry_date DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }

	static public function mdlQueryTimeIn($decrypted_content){
        $stmt = (new Connection)->connect()->prepare("$decrypted_content");
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlDeleteAllContents(){
        $stmt = (new Connection)->connect()->prepare("TRUNCATE TABLE `temporary`");
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlGetTimeInformation(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `temporary` ORDER BY timein DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlUpdateBranchTimeInDTR($id, $entry_date, $branch_name){

		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);

		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {

			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}

        $stmt = (new Connection)->connect()->prepare("UPDATE `branch_time_in_dtr_upload` SET `status`= 'checked', `date_received`= :date_received WHERE id = :id AND entry_date = :entry_date AND branch_name = :branch_name");
		$stmt ->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        $stmt ->bindParam(":entry_date", $entry_date, PDO::PARAM_STR);
		$stmt ->bindParam(":date_received", $formattedDateTime, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
    }

	static public function mdlGetBranchDailyTimeInDTRUploadList($check_entry_date){

		$stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE entry_date = '$check_entry_date'");
		if($stmt -> execute()){
			// Check if the query returned any results
			if ($stmt->rowCount() > 0) {
			   return "yes";
		   } else {
			   return "no";
		   }
	   }else{
		   return "no";	
	   }
	   $stmt -> close();
	   $stmt = null;
	
	}

	static public function mdlGetDailyTimeInDTRExist($branch, $dateSelected){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE branch_name = '$branch' AND entry_date = '$dateSelected'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }    

	static public function mdlGetHRDailyDTRTimeInDownload($id, $branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM branch_time_in_dtr_upload WHERE id = '$id' AND branch_name = '$branch_name'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

    }


	////// USING API ////

	static public function mdlAddBranchDailyDTRUploadAPI($table, $data){
		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);
	
		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {
			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));
	
			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}
	
		// Fetch the last inserted record from the table
		$dtr = (new Connection)->connect()->query("SELECT * FROM branch_dtr_upload ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
	
		// Set the initial value for $id
		$id = empty($dtr) ? 0 : $dtr['id'];
		$last_id = $id + 1;
		
		$id_holder = "DTR" . str_repeat("0", 5 - strlen($last_id)) . $last_id;
	
		try {
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(dtr_id, branch_name, entry_file, entry_date, date_uploaded) VALUES (:dtr_id, :branch_name, :entry_file, :entry_date, :date_uploaded)");
			$stmt->bindParam(":dtr_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $formattedDateTime, PDO::PARAM_STR);
	
			$stmt->execute();
			$pdo->commit();
	
			// Close the statement and set it to null inside the try block
		
			$stmt = null;
	
			return "ok";
	
		} catch (PDOException $exception) {
			$pdo->rollBack();
			return "error";
		}
	}
	
	
	static public function mdlAddBranchDailyTimeInDTRUploadAPI($table, $data){
		// Set the default timezone to Asia/Manila
		date_default_timezone_set('Asia/Manila');
		// URL of a reliable time server (you can change this if needed)
		$timeServer = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
		// Get the current time from the time server
		$response = file_get_contents($timeServer);
		// Decode the JSON response
		$timeData = json_decode($response, true);

		// Check if the response was successful
		if ($timeData && isset($timeData['datetime'])) {
			// Create a DateTime object with the received time and set the timezone to Asia/Manila
			$dateTime = new DateTime($timeData['datetime']);
			$dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

			// Format the date and time as needed
			$formattedDateTime = $dateTime->format('M d, Y H:i A');
		}

		// Fetch the last inserted record from the table
		$dtr = (new Connection)->connect()->query("SELECT * FROM branch_time_in_dtr_upload ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

		// Set the initial value for $id
		$id = empty($dtr) ? 0 : $dtr['id'];
		$last_id = $id + 1;
		
		$id_holder = "DTRT" . str_repeat("0", 5 - strlen($last_id)) . $last_id;


		try{
			$pdo = (new Connection)->connect();
			$pdo->beginTransaction();
			$stmt = $pdo->prepare("INSERT INTO $table(dtr_id, branch_name, entry_file, entry_date, date_uploaded) VALUES (:dtr_id, :branch_name, :entry_file, :entry_date, :date_uploaded)");
			$stmt->bindParam(":dtr_id", $id_holder, PDO::PARAM_STR);
			$stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_file", $data["entry_file"], PDO::PARAM_STR);
			$stmt->bindParam(":entry_date", $data["entry_date"], PDO::PARAM_STR);
			$stmt->bindParam(":date_uploaded", $formattedDateTime, PDO::PARAM_STR);
	
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
	


	

}

