<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../controllers/account.controller.php";
require_once "../models/account.model.php";
require_once "../views/modules/session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $request_id = $_POST['request_id'] ?? '';
    try {
        $user = (new ControllerAccounts)->ctrCheckAccount($username, $password);
        if ($user) {
            $type = $user[0]['type'];
            $full_name = $user[0]['full_name'];
            if ($user[0]['is_confirmed'] == 0) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                session_regenerate_id();
				$_SESSION['type']=$user[0]['type'];
				$_SESSION['user_id']=$user[0]['user_id'];
				$_SESSION['username']=$user[0]['username'];
				$_SESSION['branch_name']=$user[0]['full_name'];
                $uniqueCodeFound = false;
                while (!$uniqueCodeFound) {
                    $chkItemCode = (new ControllerAccounts)->ctrCheckRequestID($request_id);
                    // If the item code exists, increment the numeric part and check again
                    if (!empty($chkItemCode)) {
                        // Increment the numeric part
                            // Extract the numeric part of the item code
                        $prefix = substr($request_id, 0, 2);  // 'IC'
                        $numericPart = substr($request_id, 2); // '00002'
                        $numericPart = str_pad((int)$numericPart + 1, 5, '0', STR_PAD_LEFT);
                        $request_id = $prefix . $numericPart;
                    } else {
                        // If the item code does not exist, we can use it
                        $uniqueCodeFound = true;
                    }
                }
                echo json_encode(['success' => true, 'request_id'=>$request_id, 'full_name'=>$full_name ]);
            }elseif($type == "admin" || $type == "login_admin" || $type == "login_user" || $type = "pastdue_user"){
                session_regenerate_id();
				$_SESSION['type']=$user[0]['type'];
				$_SESSION['user_id']=$user[0]['user_id'];
				$_SESSION['username']=$user[0]['username'];
				$_SESSION['branch_name']=$user[0]['full_name'];
                $_SESSION['status'] = "true";
                $_SESSION['mode'] = "light";
                echo json_encode(['success' => false, 'type' => 'admin' , 'message' => 'Successfully login.']);
            }
            else {
                echo json_encode(['success' => false, 'message' => 'Login request is pending admin confirmation.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
}
