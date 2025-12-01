<?php

class ControllerPermits{
	static public function ctrShowPermit($user_id, $filterType){
		$answer = (new ModelPermit)->mdlShowPermit($user_id, $filterType);
		return $answer;
	}
	static public function ctrShowPermitAdmin($type, $filter, $filterType){
		$answer = (new ModelPermit)->mdlShowPermitAdmin($type, $filter, $filterType);
		return $answer;
	}
	  
	
    
    static public function ctrCreatePermit(){
		if(isset($_POST["add_permit"])){
			$table1 ="permit_files";
			$extension=array('jpeg','jpg','png','gif');
		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename_img=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename_img,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/permit/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/permit/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/permit/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("ref_id"=>$_POST["ref_id"],
								"file_name"=>$finalimg,
								"image_time"=>$creattime);
							$answer1 = (new ModelPermit)->mdlAddPermitImg($table1, $data1);
			
			}else
			{
			
			}
			
		}
		 $wp_req_for =   $_POST['wp_req_for'];
		 $wp_req_for1 =nl2br($wp_req_for);
		 $wp_req_by1 =   $_POST['wp_req_by'];
		 $wp_req_by =nl2br($wp_req_by1);
		 $wp_chk_by1 =   $_POST['wp_chk_by'];
		 $wp_chk_by =nl2br($wp_chk_by1);
		 $wp_from = $_POST['wp_from'];
		 $wp_to = $_POST['wp_to'];
		 if($wp_to === "MIS DEPARTMENT"){
			$type = "MIS";
		 }else{
			$type = "PSPMI";
		 }
		 if($wp_from == 4 || $wp_from == 8 || $wp_from == 7  || $type === 'PSPMI'){
			$request_level = "2";
		 }else{
			$request_level = $_POST['request_level'];
		 }
		$table = "working_permit";  
        $data = array("ref_id"=>$_POST['ref_id'],
                        "wp_to"=>$_POST['wp_to'],
                        "wp_from"=>$_POST['wp_from'],
                        "wp_date"=>$_POST['wp_date'],
                        "request_level"=>$request_level,
                        "wp_req_for"=> $wp_req_for1,
                        "branch"=>$_POST['branch'],
                        "wp_req_by"=>$wp_req_by,
                        "wp_chk_by"=>$wp_chk_by,
                        "wp_app_by"=>$_POST['wp_app_by'],
						"user_id"=>$_POST['user_id'],
                        "wp_app_by1"=>$_POST['wp_app_by1'],
                        "type"=>$type
					); 
                        $answer = (new ModelPermit)->mdlAddPermit($table, $data);
							
						 
						if($answer == "ok"){
							echo'<script>
							   const socket = new WebSocket("wss://jgcintegratedsystems.com/ws/");
								socket.onopen = () => {
									console.log("✅ Connected to WebSocket4444");
									socket.send(JSON.stringify({
									 message: "get_notification_count"
									  }));
								};
							swal({
								  type: "success",
								  title: "Request has been successfully updated!",
								  showConfirmButton: true,
								  confirmButtonText: "Ok"
								  }).then(function(result){
											if (result.value) {
												window.location = "workingpermit";
											}
										})
							</script>';
						}else if($answer == "error"){
							echo'<script>
			
							swal({
								  type: "warning",
								  title: "Theres an error occur!",
								  showConfirmButton: true,
								  confirmButtonText: "Ok"
								  }).then(function(result){
											if (result.value) {
											
											}
										})
							</script>';
			
						}		

        }
	}

	static public function ctrEditPermit(){
        if(isset($_POST["edit_permit"])){
			$table1 ="permit_files";
			$extension=array('jpeg','jpg','png','gif');

		foreach ($_FILES['image']['tmp_name'] as $key => $value) {
			$filename_img=$_FILES['image']['name'][$key];
			$filename_tmp=$_FILES['image']['tmp_name'][$key];
			echo '<br>';
			$ext=pathinfo($filename_img,PATHINFO_EXTENSION);

			$finalimg='';
			if(in_array($ext,$extension))
			{
				if(!file_exists('views/files/permit/'.$filename_img))
				{
				move_uploaded_file($filename_tmp, 'views/files/permit/'.$filename_img);
				$finalimg=$filename_img;
				}else
				{
					$filename_img=str_replace('.','-',basename($filename_img,$ext));
					$newfilename=$filename_img.time().".".$ext;
					move_uploaded_file($filename_tmp, 'views/files/permit/'.$newfilename);
					$finalimg=$newfilename;
				}
				$creattime=date('Y-m-d h:i:s');
				//insert
				
				$data1 = array("ref_id"=>$_POST["ref_id"],
								"file_name"=>$finalimg,
								"image_time"=>$creattime);
							$answer1 = (new ModelPermit)->mdlAddPermitImg($table1, $data1);
			
			}else
			{
			
			}
			
		}



		$wp_req_for =   $_POST['wp_req_for'];
		$wp_req_for1 =nl2br($wp_req_for);
		$wp_req_by1 =   $_POST['wp_req_by'];
		$wp_req_by =nl2br($wp_req_by1);
		$wp_chk_by1 =   $_POST['wp_chk_by'];
		$wp_chk_by =nl2br($wp_chk_by1);

		$wp_from = $_POST['wp_from'];
		if($wp_from == 4 || $wp_from == 8){
		   $request_level = "2";
		}else{
		   $request_level = $_POST['request_level'];
		}



        $table = "working_permit";
        $data = array("id"=>$_POST['id'],
						"ref_id"=>$_POST['ref_id'],
                        "wp_to"=>$_POST['wp_to'],
                        "wp_from"=>$_POST['wp_from'],
                        "wp_date"=>$_POST['wp_date'],
                        "request_level"=>$request_level,
                        "wp_req_for"=>$wp_req_for1,
                        "branch"=>$_POST['branch'],
                        "wp_req_by"=>$wp_req_by,
                        "wp_chk_by"=>$wp_chk_by,
                        "wp_app_by"=>$_POST['wp_app_by'],
                        "wp_app_by1"=>$_POST['wp_app_by1']); 
                        $answer = (new ModelPermit)->mdlEditPermit($table, $data);
							
						 
		   	if($answer == "ok"){
				
				echo'<script>

				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	

        }
	}
	static public function ctrDeletePermit(){
		if(isset($_GET["idClient"]) && $_GET["ref_id"]){
			$table ="working_permit";
			$table1 ="permit_files";
			$data = $_GET["idClient"];
			$ref_id = $_GET["ref_id"];

			$img =(new ControllerPermits)->ctrShowImg($table1, $ref_id);
			foreach ($img as $key => $value) {
				$img_name = $value["file_name"];
				$img_name = 'views/files/permit/'.$img_name;
				if (file_exists($img_name)){
					unlink($img_name);
				}
			} 
			$answer1 = (new ModelPermit)->mdlDeleteAll($table1, $ref_id);
			$answer = (new ModelPermit)->mdlDeletePermit($table, $data);
			if($answer == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "Request has been successfully deleted!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {
								window.location = "workingpermit";
								}
							})
				</script>';
			}		
		}
	}
	
	static public function ctrDone(){
		if(isset($_GET['idClient']) &&  isset($_GET['status'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$wp_remarks = $_GET["wp_remarks"];
		
			$answer = (new ModelPermit)->mdlDone($table, $data, $wp_remarks);
			if($answer == "ok"){
				echo'<script>
				   const socket = new WebSocket("wss://jgcintegratedsystems.com/ws/");
					socket.onopen = () => {
						console.log("✅ Connected to WebSocket");
						socket.send(JSON.stringify({
						 message: "get_notification_count"
						  }));
					};
				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	

		}

	}
	static public function ctrShowImg($table, $ref_id){
		$answer = (new ModelPermit)->mdlShowImg($table, $ref_id);
		return $answer;
		
	}
	static public function ctrDeleteImg($table){
		if(isset($_GET["idClient"]) && isset($_GET["img_name"]) ){
			$data = $_GET["img_name"];
			$idClient = $_GET["idClient"];
			$file_name1 = $_GET["img_name"];
			if($file_name1 !=""){
				$filename = 'views/files/permit/'.$file_name1;
				if (file_exists($filename)) {
					unlink($filename);
				}
			} 
			$answer = (new ModelClients)->mdlDeleteImg($table, $data);
			if($answer == "ok"){
				
				echo"<script>
				swal({
					  type: 'success',
					  title: 'Image has been successfully deleted!',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					  }).then(function(result){
								if (result.value) {
									window.location = 'index.php?route=workingpermitedit&idClient=$idClient';
								}
							})
				</script>";
			}elseif($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}		
		}
	}	
	
	static public function ctrApprove(){
		if(isset($_GET['idClient']) &&  isset($_GET['user'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$username = $_SESSION["username"];
			$answer = (new ModelPermit)->mdlApprove($table, $data, $username);
			if($answer == "ok"){
				echo'<script>
				   const socket = new WebSocket("wss://jgcintegratedsystems.com/ws/");
					socket.onopen = () => {
						console.log("✅ Connected to WebSocket");
						socket.send(JSON.stringify({
						 message: "get_notification_count"
						  }));
					};
				swal({
					  type: "success",
					  title: "Request has been successfully updated!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	


		}

	}
	static public function ctrCheck(){
		if(isset($_GET['idClient']) &&  isset($_GET['chk'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			include "email/email_approval.php";
			$answer = (new ModelPermit)->mdlCheck($table, $data);
			if($answer == "ok"){
				echo'<script>
				   const socket = new WebSocket("wss://jgcintegratedsystems.com/ws/");
					socket.onopen = () => {
						console.log("✅ Connected to WebSocket");
						socket.send(JSON.stringify({
						 message: "get_notification_count"
						  }));
					};
				swal({
					  type: "success",
					  title: "The request has been successfully approved!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	
		}

	}
	static public function ctrGetNotification($type) {
		if (!$type) {
			return [];
		}
	
		try {
			$currentDate = date('Y-m-d');
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			$_SESSION['type'] = $type;
			$answer = (new ModelPermit)->mdlGetNotification($currentDate);
			return $answer;
		} catch (\Exception $e) {
			file_put_contents(
				__DIR__ . '/ctrl_error.log',
				'[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL,
				FILE_APPEND
			);
			return [];
		}
	}


	
	static public function ctrReject(){
		if(isset($_GET['idClient']) &&  isset($_GET['reject'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$answer = (new ModelPermit)->mdlReject($table, $data);
			if($answer == "ok"){
				echo'<script>
				   const socket = new WebSocket("wss://jgcintegratedsystems.com/ws/");
					socket.onopen = () => {
						console.log("✅ Connected to WebSocket22");
						socket.send(JSON.stringify({
						 message: "get_notification_count"
						  }));
					};
				swal({
					  type: "success",
					  title: "The request has been successfully rejected!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	
		}

	}

	static public function ctrReceived(){
		if(isset($_GET['idClient']) &&  isset($_GET['receive'])){
			$table = "working_permit";
			$data = $_GET["idClient"];
			$user = $_GET["user"];
			$answer = (new ModelPermit)->mdlReceived($table, $data, $user);
			if($answer == "ok"){
				echo'<script>
				   const socket = new WebSocket("ws://192.168.1.80:8080");
					socket.onopen = () => {
						console.log("✅ Connected to WebSocket");
						socket.send(JSON.stringify({
						 message: "get_notification_count"
						  }));
					};
				swal({
					  type: "success",
					  title: "The request has been successfully received!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
									window.location = "workingpermit";
								}
							})
				</script>';
			}else if($answer == "error"){
				echo'<script>

				swal({
					  type: "warning",
					  title: "Theres an error occur!",
					  showConfirmButton: true,
					  confirmButtonText: "Ok"
					  }).then(function(result){
								if (result.value) {
								
								}
							})
				</script>';

			}	
		}

	}

	static public function ctrShowPermitByID($data){
		$answer = (new ModelPermit)->mdlShowPermitByID($data);
		return $answer;
	}

	static public function ctrShowNotifcation($type){
		$answer = (new ModelPermit)->mdlShowNotification($type);
		return $answer;
	}
	
}