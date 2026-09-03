<?php
// Report all PHP errors
// error_reporting(E_ALL);

// // Turn on error logging
// ini_set('log_errors', 'On');

// // Set the path to the error log file
// ini_set('error_log', 'log.txt');

// // Ensure the log file exists and set permissions
// if (!file_exists('log.txt')) {
//     file_put_contents('log.txt', '');
// }
// chmod('log.txt', 0644);

// Set the maximum file size for the error log (10MB)
// Note: ini_set does not directly support setting log size, this is more of a comment for awareness
// ini_set('log_errors_max_size', '10M');  // This will not work

require_once "connection.php";

class ModelAccounts
{
    // Your code starts here
    static public function get_user_id($user_id)
    {
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();
        $sql = 'SELECT id FROM accounts WHERE user_id = :user_id';
        $statement = $pdo->prepare($sql);

        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        try {
            if ($statement->execute()) {
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                return $row !== false ? $row['id'] : false;
            }
        } catch (PDOException $e) {
            error_log("Error executing get_user_id query: " . $e->getMessage());
        }
        return false;
    }

    static public function mdlAddAccounts($table, $data)
    {
        try {
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

            $user_id = $data["user_id"];
            $user_id1 = (new ModelAccounts)->get_user_id($user_id);
            $last_id = $user_id1 + 1;
            $id_holder = "UI" . str_repeat("0", 5 - strlen($last_id)) . $last_id;
            if (!$user_id1) {
                $id_holder = $user_id;
            }

            $stmt1 = $pdo->prepare("SELECT * FROM accounts WHERE username = :username LIMIT 1");
            $stmt1->bindParam(":username", $data["username"], PDO::PARAM_STR);
            if ($stmt1->execute()) {
                $check = $stmt1->fetch(PDO::FETCH_ASSOC);
                if ($stmt1->rowCount() > 0) {
                    return "error";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO $table(type, user_id, full_name, username, password, is_confirmed) VALUES (:type, :user_id, :full_name, :username, :password, :is_confirmed)");

                    $stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
                    $stmt->bindParam(":user_id", $id_holder, PDO::PARAM_STR);
                    $stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
                    $stmt->bindParam(":username", $data["username"], PDO::PARAM_STR);
                    $stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
                    $stmt->bindParam(":is_confirmed", $data["is_confirmed"], PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        $pdo->commit();
                        return "ok";
                    }
                }
            }
        } catch (PDOException $exception) {
            $pdo->rollBack();
            error_log("Error in mdlAddAccounts: " . $exception->getMessage());
            return "error";
        }
        return "error";
    }
	static public function mdlCheckAccounts($username, $password){
		
			$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE username = ? AND password = ? LIMIT 1");
			$result = $stmt ->execute([$username, $password]);
			if($result){
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount()>0){
				session_regenerate_id();
				$_SESSION['type']=$user['type'];
				$_SESSION['user_id']=$user['user_id'];
				$_SESSION['username']=$user['username'];
				$_SESSION['branch_name']=$user['full_name'];
				return "ok";


			}else{
				return "error";
			}
			$stmt->close();
			$stmt = null;
		}
	
}
static public function mdlEditAccounts($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table SET `type` = :type, full_name = :full_name, 
	username = :username, `password` = :password, `is_confirmed` = :is_confirmed WHERE id = :id");
	
	$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
	$stmt->bindParam(":type", $data["type"], PDO::PARAM_STR);
	$stmt->bindParam(":full_name", $data["full_name"], PDO::PARAM_STR);
	$stmt->bindParam(":username", $data["username"], PDO::PARAM_STR);
	$stmt->bindParam(":password", $data["password"], PDO::PARAM_STR);
    $stmt->bindParam(":is_confirmed", $data["is_confirmed"], PDO::PARAM_STR);

	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;
}	
static public function mdlShowAccount(){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE `status` = '0' ORDER BY id");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	

static public function mdlDelete($table, $data){
	$stmt = (new Connection)->connect()->prepare("UPDATE $table Set status ='1' WHERE id = :id");
	$stmt ->bindParam(":id", $data, PDO::PARAM_INT);
	if($stmt -> execute()){
		return "ok";
	}else{
		return "error";	
	}
	$stmt -> close();
	$stmt = null;

}

 
static public function mdlAddLoginRequest($username, $request_id, $full_name){
    try{
        $pdo = (new Connection)->connect();
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO login_requests (username, request_id, full_name) VALUES
         (:username, :request_id, :full_name)");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":request_id", $request_id, PDO::PARAM_STR);
        $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
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


static public function  mdlUpdateLoginRequest($request_id, $coordinator, $approved_time, $is_approved){
	$stmt = (new Connection)->connect()->prepare("UPDATE login_requests SET `is_approved` = :is_approved, coordinator = :coordinator , time_change = :approved_time  WHERE request_id = :request_id");
	$stmt->bindParam(":request_id", $request_id, PDO::PARAM_STR);
	$stmt->bindParam(":coordinator", $coordinator, PDO::PARAM_STR);
	$stmt->bindParam(":approved_time", $approved_time, PDO::PARAM_STR);
	$stmt->bindParam(":is_approved", $is_approved, PDO::PARAM_INT);
	if($stmt->execute()){
		return "ok";
	}else{
		return "error";
	}

	$stmt->close();
	$stmt = null;
}



static public function mdlCheckAccount($username, $password){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM accounts WHERE username = '$username' AND password = '$password'");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	


static public function mdlGetPendingLoginRequests(){
	$stmt = (new Connection)->connect()->prepare("SELECT * FROM login_requests WHERE is_approved = 0");
	$stmt -> execute();
	return $stmt -> fetchAll();
	$stmt -> close();
	$stmt = null;
}	

static public function mdlShowIDLedger(){
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM login_requests WHERE is_approved != 0 ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Force associative array
}


static public function mdlCheckRequestID($request_id){	
    $stmt = (new Connection)->connect()->prepare("SELECT * FROM login_requests WHERE request_id = :request_id limit 1");
    $stmt->bindParam(":request_id", $request_id, PDO::PARAM_STR);
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt = null;
}


	


	
}