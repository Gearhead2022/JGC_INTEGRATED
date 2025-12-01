<?php

require_once "connection.php";
class ModelPensioner{

  
    static public function mdlGetFCHANDEMBBranches(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%EMB%' ORDER BY id ASC");

        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
        
    }

    // monthly agent runnder production 


    static public function mdlAddMonthlyAgent($table, $data){

		try{		
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (mdate, agents, sales,branch_name) VALUES (:mdate, :agents, :sales, :branch_name)");
        $stmt->bindParam(":mdate", $data["mdate"], PDO::PARAM_STR);
        $stmt->bindParam(":agents", $data["agents"], PDO::PARAM_STR);
        $stmt->bindParam(":sales", $data["sales"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }
        else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
            
        

    }catch(PDOException $exception){
        $pdo->rollBack();
        return "error"; 
    }	

}





    static public function mdlAddMonthlyAgentBeg($table, $data1){
		try{
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();
        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (agent_beg_bal, sales_beg_bal, bdate, branch_name) VALUES (:agent_beg_bal, :sales_beg_bal, :bdate, :branch_name)");
        $stmt->bindParam(":agent_beg_bal",  $data1["agent_beg_bal"], PDO::PARAM_STR);
        $stmt->bindParam(":sales_beg_bal",  $data1["sales_beg_bal"], PDO::PARAM_STR);
        $stmt->bindParam(":bdate",  $data1["bdate"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name",  $data1["branch_name"], PDO::PARAM_STR);
        if($stmt->execute()){
            $pdo->commit();
            return "ok";
        }
        else{
            $pdo->rollBack();
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }catch(PDOException $exception){
        
        $pdo->rollBack();
        echo $exception->getMessage(); 
        return "error"; 
    }	

}



    static public function mdlshowTableMA($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM monthly_agent WHERE branch_name = '$branch_name' ORDER BY mdate");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	


    
    static public function mdlshowTableBegMA(){
        $stmt = (new Connection)->connect()->prepare("SELECT agent_beg_bal, sales_beg_bal, bdate FROM monthly_beginning_bal");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	


    static public function mdlGetAllEMB(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'EMB%'");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	
    
    static public function mdlGetDataFromBranch($branch_names){
  

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM monthly_agent WHERE branch_name = '$branch_names' ");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	

    
    static public function mdlGetDates($branch_names,$startDate,$endDate){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM monthly_beginning_bal WHERE branch_name = '$branch_names' AND bdate >= '$startDate' AND bdate <= '$endDate'"
         );        
        $stmt -> execute();
        return $stmt -> fetchAll();    
        $stmt -> close();
        $stmt = null;
    }	

    // for beg bal
    static public function mdlGetBegBal2024($branch_names, $startYearbeg, $endYearsbeg){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(agents) AS total_beg_agents, SUM(sales) AS total_beg_sales FROM monthly_agent WHERE branch_name = '$branch_names' AND mdate >= '$startYearbeg' AND mdate <= '$endYearsbeg'");        
        $stmt -> execute();
        return $stmt -> fetchAll();    
        $stmt -> close();
        $stmt = null;
    }	
      

    static public function mdlGetDataEveryMonth($branch_names,$startDateJan,$endDateJan){
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(agents) AS total_agents, SUM(sales) AS total_sales FROM monthly_agent WHERE branch_name = '$branch_names' AND mdate >= '$startDateJan' AND mdate <= '$endDateJan' ");
        $stmt -> execute();
        return $stmt -> fetchAll();    
        $stmt -> close();
        $stmt = null;
    }	
      

    static public function mdlGetAllFCHNegros(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'FCH%' AND branch_name != 'FCH PARANAQUE' AND branch_name != 'FCH MUNTINLUPA' ");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	
    
    static public function mdlGetAllFCHManila(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'FCH%' AND branch_name != 'FCH BACOLOD' AND branch_name != 'FCH SILAY' AND branch_name != 'FCH BAGO' AND branch_name != 'FCH MURCIA' AND branch_name != 'FCH HINIGARAN' AND branch_name != 'FCH BINALBAGAN' AND branch_name != 'FCH LAPU LAPU' AND branch_name != 'FCH SIQUIJOR' ");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	
    
    static public function mdlGetAllRLC(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'RLC%' ");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	
 

    static public function mdlGetAllELC(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names WHERE branch_name LIKE 'ELC%' ");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }	
    

	
	static public function mdlDeleteMonthlyAgent($table, $id){
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




    static public function mdlEditMonthlyAgent($table, $data){
        if (isset($data["id"])) {
            $stmt = (new Connection)->connect()->prepare("UPDATE $table SET `mdate` = :mdate, agents = :agents, sales = :sales WHERE id = :id");
            $stmt->bindParam(":mdate", $data["mdate"], PDO::PARAM_STR);
            $stmt->bindParam(":agents", $data["agents"], PDO::PARAM_INT);
            $stmt->bindParam(":sales", $data["sales"], PDO::PARAM_INT);
            $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT); // Add this line to bind the 'id' parameter
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
            $stmt->close();
            $stmt = null;
        } else {
            return "error"; // Handle the case where 'id' is not set
        }
    }
    




    static public function mdlshowMonthlyAgentEdit($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `monthly_agent` WHERE id = '$id'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}





    // new added by john


    static public function mdlAddPensioner($table, $data){ 

        $penDateId = $data['penDate'];
        $penInsurance = $data['penInsurance'];
        $penIn = $data['penIn'];
        $penOut = $data['penOut'];
        $branch_name = $data['branch_name']; //data fetched from controller//
	
        $penDateData = (new Connection)->connect()->query("SELECT * from $table WHERE penDate = '$penDateId' AND pen_ins_com = '$penInsurance' AND branch_name = '$branch_name' limit 1")->fetch(PDO::FETCH_ASSOC);
        
        if(empty($penDateData)){
            // get last value penNum from previous transactions//
            $penDateDataNew = (new Connection)->connect()->query("SELECT * from $table WHERE pen_ins_com = '$penInsurance' AND branch_name = '$branch_name' ORDER BY dateModified Desc limit 1")->fetch(PDO::FETCH_ASSOC);
        
            $penDataRef = '';
            $total = $penDateDataNew['penNum'];// hold value penNum//

            if ($penIn != 0 && $penOut != 0) {
                $penTotalIn = $penIn + $total;
                $finalPenTotal = $penTotalIn - $penOut;
            
            } else if($penOut != 0) {
                $finalPenTotal =  $total - $penOut;

            } else if($penIn != 0) {
                $finalPenTotal = $penIn + $total;
            }

            try{

                date_default_timezone_set('Asia/Manila');
                $currentTime = date('Y-m-d h:i:s', time());

                $pdo = (new Connection)->connect();
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("INSERT INTO $table(penIn, penOut, penNum, penDate, branch_name, pen_ins_com, dateModified) VALUES (:penIn, :penOut, :penNum, :penDate, :branch_name, :penInsurance, :dateModified)");
            
                $stmt->bindParam(":penIn", $data["penIn"], PDO::PARAM_INT);
                $stmt->bindParam(":penOut", $data["penOut"], PDO::PARAM_INT);
                $stmt->bindParam(":penNum", $finalPenTotal, PDO::PARAM_INT);
                $stmt->bindParam(":penDate", $data["penDate"], PDO::PARAM_STR);
                $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
                $stmt->bindParam(":penInsurance", $data["penInsurance"], PDO::PARAM_STR);
                $stmt->bindParam(":dateModified", $currentTime, PDO::PARAM_STR);
           
                $stmt->execute();
                $pdo->commit();
                return "ok";

            }catch(PDOException $exception){
                $pdo->rollBack();
                return "error";     
            }
            $stmt->close();
            $stmt = null;
           
        }else{
            $penDateDataNew = (new Connection)->connect()->query("SELECT * from $table WHERE pen_ins_com = '$penInsurance' AND branch_name = '$branch_name' ORDER BY dateModified Desc limit 1")->fetch(PDO::FETCH_ASSOC);
       
            $total = $penDateDataNew['penNum'];// hold value penNum//

            $penDateRef = $penDateData['penDate'];
            $penPenInsRef = $penDateData['pen_ins_com'];
            $lastPenIn = $penDateData['penIn'];
            $lastPenOut = $penDateData['penOut'];

            if ($penIn != 0 && $penOut != 0) {
                $penTotalIn = $penIn + $total;
                $finalPenTotal = $penTotalIn - $penOut;
                $totalPenIn = $lastPenIn + $penIn;
                $totalPenOut = $lastPenOut + $penOut;

            } else if($penOut != 0) {
                $finalPenTotal = $total - $penOut;
                $totalPenIn = $lastPenIn;
                $totalPenOut = $lastPenOut + $penOut;


            } else if($penIn != 0) {
                $finalPenTotal = $penIn + $total;
                $totalPenIn = $lastPenIn + $penIn;
                $totalPenOut = $lastPenOut;
            }
            
            date_default_timezone_set('Asia/Manila');
            $currentTime = date('Y-m-d h:i:s', time());

            $stmt = (new Connection)->connect()->prepare("UPDATE $table SET `penIn`= :penIn, `penOut`= :penOut, `penNum`= :penNum, `penDate`= :penDate, `branch_name`= :branch_name, `pen_ins_com`= :penInsurance, `dateModified` = :dateModified 
            WHERE penDate = '$penDateRef' 
            AND pen_ins_com = '$penPenInsRef'");

            $stmt->bindParam(":penIn", $totalPenIn, PDO::PARAM_INT);
            $stmt->bindParam(":penOut", $totalPenOut, PDO::PARAM_INT);
            $stmt->bindParam(":penNum", $finalPenTotal, PDO::PARAM_INT);
            $stmt->bindParam(":penDate", $data["penDate"], PDO::PARAM_STR);
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":penInsurance", $data["penInsurance"], PDO::PARAM_STR);
            $stmt->bindParam(":dateModified", $currentTime, PDO::PARAM_STR);
            
            if($stmt->execute()){
                return "ok";
                $stmt->close();
                $stmt = null;
            }else{
                return "error";
            }


        }
      
	}
    static public function mdlShowDailyPensioner($branch_name, $day, $type){

        $stmt = (new Connection)->connect()->prepare("SELECT 
        (SELECT SUM(penIn) FROM `pensioner` WHERE penDate <= '$day' AND pen_ins_com = '$type' AND branch_name = '$branch_name') 
    -   (SELECT SUM(penOut) FROM `pensioner` WHERE penDate <= '$day' AND pen_ins_com = '$type' AND branch_name = '$branch_name') as penNum,

        penIn, penOut FROM pensioner WHERE penDate = '$day' AND pen_ins_com = '$type' AND branch_name = '$branch_name'"); 
        $stmt -> execute();
        $result = $stmt->fetch(); // Fetch a single row
    
        if ($result) {
            // Extract the specific value you need (penNum)
            $penNum = $result['penNum'];
            $penIn = $result['penIn'];
            $penOut = $result['penOut'];
    
        } else {
            $penNum = 0; // or some default value if no result is found
            $penIn = 0;
            $penOut = 0;
        }
    
        $stmt->closeCursor(); // Close the cursor instead of close()
    
        return array($penNum, $penIn, $penOut);
    }

    static public function mdlShowBegBalPensioner($branch_name, $day1, $day2, $type){

        $stmt = (new Connection)->connect()->prepare("SELECT 
        (SELECT SUM(penIn) FROM `pensioner` WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name') 
    -   (SELECT SUM(penOut) FROM `pensioner` WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name') as penNum,

        penIn, penOut FROM pensioner WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name'"); 
        $stmt -> execute();
        $result = $stmt->fetch(); // Fetch a single row
    
        if ($result) {
            // Extract the specific value you need (penNum)
            $penNum = $result['penNum'];
            $penIn = $result['penIn'];
            $penOut = $result['penOut'];
    
        } else {
            $penNum = 0; // or some default value if no result is found
            $penIn = 0;
            $penOut = 0;
        }
    
        $stmt->closeCursor(); // Close the cursor instead of close()
    
        return array($penNum, $penIn, $penOut);
    }



    public function mdlShowDailyPensionerInRange($branch_name, $startDate, $endDate, $type) {
        $stmt = (new Connection)->connect()->prepare("SELECT penNum FROM pensioner WHERE penDate >= ? AND penDate <= ? AND pen_ins_com = ? AND branch_name = ?");
        $stmt->execute([$startDate, $endDate, $type, $branch_name]);
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        // Close the cursor
        $stmt->closeCursor();
    
        return $results;
    }
    

    static public function mdlGetBranchesNames($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%$branch_name%' ORDER BY id ASC");

        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
        
    }

    static public function mdlGetBeginningBalance($branch_name, $type, $day1, $day2){
        $stmt = (new Connection)->connect()->prepare("SELECT 
        (SELECT SUM(penIn) FROM `pensioner` WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name') 
    -   (SELECT SUM(penOut) FROM `pensioner` WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name') as penNum
        
        from pensioner WHERE penDate >= '$day1' AND penDate <= '$day2' AND pen_ins_com = '$type' AND branch_name = '$branch_name'");
        $stmt -> execute();
        $result = $stmt->fetch(); // Fetch a single row
        if ($result) {
            $penNum = $result['penNum'];
           
        } else {
            $penNum = 0; // or some default value if no result is found
        }
        $stmt->closeCursor(); // Close the cursor instead of close()
    
        return $penNum;
        
    }

    static public function mdlGetFCHANDEMBBranches1(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%EMB%' ORDER BY id ASC LIMIT 12");

        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
        
    }

    static public function mdlGetFCHANDEMBBranches2(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%EMB%' ORDER BY id ASC LIMIT 20 OFFSET 12");

        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
        
    }

    static public function mdlBatchTicketGet($area_code){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `ticket_last` WHERE area_code = '$area_code'");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();   
        $stmt = null;
        
    }

    static public function mdlShowAllBranchPensionerList($branch_session){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `pensioner` WHERE branch_name = '$branch_session' ORDER BY penDate DESC");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

    static public function mdlShowPensionerAccntTarget($branch_name, $id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `pensioner` WHERE branch_name = '$branch_name' AND id = '$id'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

    static public function mdlEditPensionerListAccnt($table, $data)
    {
        
        try{
    
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE $table SET `branch_name`= :branch_name,
            `penin`= :penIn, `penOut`= :penOut, `pen_ins_com` = :pen_ins_com, `penDate`= :penDate
            WHERE id = :pen_id" );
        
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":penIn", $data["penIn"], PDO::PARAM_INT);
            $stmt->bindParam(":penOut", $data["penOut"], PDO::PARAM_INT); 
            $stmt->bindParam(":pen_ins_com", $data["penInsurance"], PDO::PARAM_STR);
            $stmt->bindParam(":penDate", $data["penDate"], PDO::PARAM_STR); 
            $stmt->bindParam(":pen_id", $data["pen_id"], PDO::PARAM_INT);
        
            $stmt->execute();
            $pdo->commit();
        
            return "ok";
    
            $stmt = null;

        }catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
        }
        
    }

    static public function mdlDeletePensionerListAccnt($table, $pen_id, $branch_name){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id AND branch_name = :branch_name");
        $stmt ->bindParam(":id", $pen_id, PDO::PARAM_INT);
        $stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    //operationReport --------------------------------------------------------- //
    

    static public function mdlOperationFCHManila(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name = 'FCH MUNTINLUPA' 
        or branch_name = 'FCH PARANAQUE'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }
    static public function mdlOperationFCHNegros(){

        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%FCH%' AND branch_name != 'FCH MUNTINLUPA' AND branch_name != 'FCH PARANAQUE'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }
    static public function mdlOperationEMB(){
        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%EMB%' ORDER BY id");
        $stmt -> execute();
        return $stmt -> fetchAll();
    
        $stmt = null;
    }
    static public function mdlOperationELC(){

        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%ELC%' ORDER BY id");
        $stmt -> execute();
        return $stmt -> fetchAll();
        
        $stmt = null;
    }
    static public function mdlOperationRLC(){

        $stmt = (new Connection)->connect()->prepare("SELECT branch_name FROM `branch_names` WHERE branch_name LIKE '%RLC%' ORDER BY id");
        $stmt -> execute();
        return $stmt -> fetchAll();
    
        $stmt = null;
    }

    static public function mdlAddSalesRepresentative($table, $data)
    {
        try{
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

        
            $stmt = $pdo->prepare("INSERT INTO $table(branch_name, rep_fname, rep_lname) VALUES
            (:branch_name, :rep_fname, :rep_lname)");
        
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":rep_fname", $data["rep_fname"], PDO::PARAM_STR);
            $stmt->bindParam(":rep_lname", $data["rep_lname"], PDO::PARAM_STR); 
        
            $stmt->execute();
            $pdo->commit();
        
            return "ok";
    
            $stmt = null;

        }catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
        }
        
    }

    static public function mdlGetSalesRep($branch_name){

        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sales_representative` WHERE branch_name = '$branch_name'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }
    //get monthly and yearly gross in
    static public function mdlGetMonthlyGrossIn($branch_name, $startMonth, $endMonth)
    {
        $stmt = (new Connection)->connect()->prepare("SELECT COUNT(account_id) as totalGrossIn FROM `op_gross_out` WHERE branch_name = :branch_name 
        AND type = 'grossin' AND in_date >= :startMonth AND in_date <= :endMonth AND reftype != ''");
        
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':startMonth', $startMonth);
        $stmt->bindParam(':endMonth', $endMonth);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalGrossIn = $result['totalGrossIn'];

        return $totalGrossIn; // Return the total gross in
    }

    static public function mdlGetMonthlyAgent($branch_name, $startMonth, $endMonth)
    {
        $stmt = (new Connection)->connect()->prepare("SELECT SUM(agents) as totalAgent FROM `monthly_agent` WHERE branch_name = :branch_name 
        AND mdate >= :startMonth AND mdate <= :endMonth");
        
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':startMonth', $startMonth);
        $stmt->bindParam(':endMonth', $endMonth);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalAgent = $result['totalAgent'];

        return $totalAgent; // Return the total gross in
    }
    //add new accounts pensioner
    static public function mdlAddAccountpensioners($table, $data)
    {
        $branch_name = $data["branch_name"];
        $date = $data['date'];

        $accountBal = (new Connection)->connect()->query("SELECT * from $table WHERE branch_name = '$branch_name' AND date = '$date' limit 1")->fetch(PDO::FETCH_ASSOC);

            if(empty($accountBal)){
                
                try{
                    $pdo = (new Connection)->connect();

                    $pdo->beginTransaction();

                    $stmt = $pdo->prepare("INSERT INTO $table(branch_name, accnt_in, accnt_out, date) VALUES
                    (:branch_name, :accnt_in, :accnt_out, :date)");
                
                    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
                    $stmt->bindParam(":accnt_in", $data["accnt_in"], PDO::PARAM_INT);
                    $stmt->bindParam(":accnt_out", $data["accnt_out"], PDO::PARAM_INT);
                    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);  
                
                    $stmt->execute();
                    $pdo->commit();
                
                    return "ok";
        
                    $stmt = null;

                }catch(PDOException $exception){
                    $pdo->rollBack();
                    return "error";     
                }
            }else{

                $pdo = (new Connection)->connect();
               
                try{
                    $pdo = (new Connection)->connect();
                    $pdo->beginTransaction();

                    $stmt = $pdo->prepare("UPDATE $table SET `branch_name`=:branch_name,
                    `accnt_in`= :accnt_in, `accnt_out`= :accnt_out, `date`= :date 
                    WHERE date = :date AND branch_name = :branch_name");
                
                    $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
                    $stmt->bindParam(":accnt_in", $data["accnt_in"], PDO::PARAM_INT);
                    $stmt->bindParam(":accnt_out", $data["accnt_out"], PDO::PARAM_INT);
                    $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);  
                
                    $stmt->execute();
                    $pdo->commit();
                
                    return "ok";
            
                    $stmt = null;

                }catch(PDOException $exception){
                    $pdo->rollBack();
                    return "error";     
                }
                
            }
        
    }

    static public function mdleditAccountpensioners($table, $data)
    {
        
        try{
    
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE $table SET `branch_name`= :branch_name,
            `accnt_in`= :accnt_in, `accnt_out`= :accnt_out, `date`= :date 
            WHERE date = :date AND branch_name = :branch_name AND id = :id" );
        
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":accnt_in", $data["accnt_in"], PDO::PARAM_INT);
            $stmt->bindParam(":accnt_out", $data["accnt_out"], PDO::PARAM_INT);
            $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);  
            $stmt->bindParam(":id", $data["accnt_id"], PDO::PARAM_STR);
        
            $stmt->execute();
            $pdo->commit();
        
            return "ok";
    
            $stmt = null;

        }catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
        }
        
    }

    //get last month, this month, gross in cumulative end balance
    static public function mdlGetBegBal($branch_name, $monthStart, $monthEnd)
    {
        $stmt = (new Connection)->connect()->prepare("SELECT 
        (
         (SELECT SUM(penIn) FROM `pensioner` WHERE branch_name = :branch_name AND penDate >= :monthStart AND penDate <= :monthEnd) 
            - 
         (SELECT SUM(penOut) FROM `pensioner` WHERE branch_name = :branch_name AND penDate >= :monthStart AND penDate <= :monthEnd)
        ) as sum_total
        FROM `pensioner` 
        WHERE branch_name = :branch_name
        AND penDate >= :monthStart AND penDate <= :monthEnd");
        
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':monthStart', $monthStart);
        $stmt->bindParam(':monthEnd', $monthEnd);

        $stmt->execute();

        // Check if the query returned any results
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $accnt_num = $result['sum_total'];
        } else {
            // Handle the case where no results were found
            $accnt_num = 0; // or set it to a default value
        }

        return $accnt_num;
    }

    //get this month end balance
    static public function mdlGetNewBegBal($branch_name,$monthEnd){
        $stmt = (new Connection)->connect()->prepare("SELECT * from pensioner WHERE branch_name = :branch_name AND penDate < :monthEnd ORDER BY penDate Desc limit 1");
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':monthEnd', $monthEnd);
        $stmt -> execute();


        // Check if the query returned any results
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $accnt_new_num = $result['accnt_num'];
        } else {
            // Handle the case where no results were found
            $accnt_new_num = 0; // or set it to a default value
        }
        // Close the cursor instead of close()

        return $accnt_new_num;
        
    }

    //get this month end balance
    static public function mdlGetBranchAnnualTarget($branch_name,$year){
        $stmt = (new Connection)->connect()->prepare("SELECT * from branch_annual_taget WHERE branch_name = :branch_name AND year_encoded = :year");
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':year', $year);
        $stmt -> execute();


        // Check if the query returned any results
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $annual_target = $result['annual_target'];
        } else {
            // Handle the case where no results were found
            $annual_target = 0; // or set it to a default value
        }
        // Close the cursor instead of close()

        return $annual_target;
        
    }



    static public function mdlShowAccntTarget($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `pensioner` WHERE id = '$id' LIMIT 1");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

    static public function mdlShowAllSalesRepresentative(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sales_representative` ORDER BY branch_name");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }


    static public function mdlEditSalesrepresentative($table, $data)
    {
        
        try{
    
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE $table SET `branch_name`= :branch_name,
            `rep_fname`= :rep_fname, `rep_lname`= :rep_lname
            WHERE id = :rep_id" );
        
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":rep_fname", $data["rep_fname"], PDO::PARAM_STR);
            $stmt->bindParam(":rep_lname", $data["rep_lname"], PDO::PARAM_STR); 
            $stmt->bindParam(":rep_id", $data["rep_id"], PDO::PARAM_STR);
        
            $stmt->execute();
            $pdo->commit();
        
            return "ok";
    
            $stmt = null;

        }catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
        }
        
    }

    static public function mdlShowSRAccntTarget($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `sales_representative` WHERE id = '$id'");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

	


    static public function mdlDeleteTargetSR($table, $rep_id){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $rep_id, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlDeletePenAccountsTarget($table, $rep_accnt_id){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt ->bindParam(":id", $rep_accnt_id, PDO::PARAM_INT);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlAddSPCorrespondent($table, $data){

        $permit = (new Connection)->connect()->query("SELECT * from $table ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
              if(empty($permit)){
                $id = 0;
    
                $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (preparedBy ,checkedBy, notedBy) 
                    VALUES (:preparedBy, :checkedBy, :notedBy)");
    
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":checkedBy", $data["checkedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":notedBy", $data["notedBy"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
    
              }else{
    
                $id = $permit['id'];
    
                $stmt = (new Connection)->connect()->prepare("UPDATE $table SET preparedBy = :preparedBy, checkedBy = :checkedBy, notedBy = :notedBy WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":checkedBy", $data["checkedBy"], PDO::PARAM_STR);
                $stmt->bindParam(":notedBy", $data["notedBy"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
              }
    
    }

    // added

    static public function mdlShowBranchAnnualTarget(){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_annual_taget` ORDER BY year_encoded DESC ");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

    static public function mdlShowEditBranchAnnualTarget($id){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_annual_taget` WHERE id = $id LIMIT 1");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }

    static public function mdlEditBranchAnnualTarget($table, $data)
    {
        try{
    
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE $table SET `branch_name`= :branch_name,
            `annual_target`= :annual_target, `year_encoded`= :year_encoded
            WHERE id = :id AND branch_name = :branch_name");
        
            $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
            $stmt->bindParam(":annual_target", $data["target"], PDO::PARAM_STR);
            $stmt->bindParam(":year_encoded", $data["year"], PDO::PARAM_STR); 
            $stmt->bindParam(":id", $data["accnt_id"], PDO::PARAM_INT);
        
            $stmt->execute();
            $pdo->commit();
        
            return "ok";
    
            $stmt = null;

        }catch(PDOException $exception){
            $pdo->rollBack();
            return "error";     
        }
        
    }



    

    static public function mdlSalesPerformanceByBranch($branch_name, $monthEnd){

        $lastYearDate = date('Y', strtotime('-1 year', strtotime($monthEnd)));
        $lastDayOfMonth = $lastYearDate . '-12-31';

        $prevMonthAndYear = date('Y-m', strtotime('-1 month', strtotime($monthEnd)));
        $lastDayOfMonthPrev = date("Y-m-t", strtotime($prevMonthAndYear));

        $lastDayOfMonthCur = $monthEnd.'-31';

        $startMonth = date('Y-m-01', strtotime($monthEnd));
        $endMonth = date('Y-m-t', strtotime($monthEnd));

        $thisYearDate = date('Y', strtotime($monthEnd)); //get current year

        $startYear = $thisYearDate . '-01-01';
        $endYear = $thisYearDate . '-12-31';
        
        $stmt = (new Connection)->connect()->prepare("SELECT CONCAT(rep_fname, ' ', rep_lname) as sales_rep, branch_name,
        (
            SELECT SUM(penIn - penOut) 
            FROM pensioner 
            WHERE penDate >= '1990-01-01' AND penDate <= '$lastDayOfMonth' AND  branch_name = '$branch_name' LIMIT 1
        ) as begBal,
        (
            SELECT SUM(penIn - penOut) 
            FROM pensioner 
            WHERE penDate >= '1990-01-01' AND penDate <= '$lastDayOfMonthPrev' AND  branch_name = '$branch_name' LIMIT 1
        ) as begBal1,
        (
            SELECT SUM(penIn - penOut) 
            FROM pensioner 
            WHERE penDate >= '1990-01-01' AND penDate <= '$lastDayOfMonthCur' AND  branch_name = '$branch_name' LIMIT 1
        ) as begBal2,
        (
            SELECT COUNT(account_id)
            FROM `op_gross_out` 
            WHERE branch_name = '$branch_name'
            AND type = 'grossin' AND in_date >= '$startMonth' AND in_date <= '$endMonth' AND reftype != '' LIMIT 1
        ) as gross_in,  
        (
            SELECT COUNT(account_id)
            FROM `op_gross_out` 
            WHERE branch_name = '$branch_name'
            AND type = 'grossin' AND in_date >= '$startYear ' AND in_date <= '$endYear' AND reftype != '' LIMIT 1
        ) as yearly_gross_in,
        (
            SELECT SUM(agents)
            FROM `monthly_agent` 
            WHERE branch_name = '$branch_name'
            AND mdate >= '$startMonth' AND mdate <= '$endMonth' LIMIT 1
        ) as agents_in,
        (
            SELECT annual_target 
            FROM branch_annual_taget 
            WHERE branch_name = '$branch_name' AND year_encoded = '$thisYearDate'
        ) as annual_target
        
    FROM sales_representative WHERE branch_name = '$branch_name'");


        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }


    // new added



 
    

    static public function mdlDeleteBranchAnnualTarget($table, $rep_id, $branch_name){
        $stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE id = :id AND branch_name = :branch_name");
        $stmt ->bindParam(":id", $rep_id, PDO::PARAM_INT);
        $stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
        if($stmt -> execute()){
        return "ok";	
        }else{
            return "error";		
        }
        $stmt -> close();
        $stmt = null;

    }

    static public function mdlAddBranchAnnualTarget($table, $data){

        $year_encoded = $data['year_encoded'];
        $branch_name_select = $data['branch_name'];

        $permit = (new Connection)->connect()->query("SELECT * from $table WHERE branch_name = '$branch_name_select' AND year_encoded = '$year_encoded' limit 1")->fetch(PDO::FETCH_ASSOC);
              if(empty($permit)){
                $id = 0;
    
                $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (branch_name ,year_encoded, annual_target) 
                    VALUES (:branch_name, :year_encoded, :annual_target)");
    
                $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
                $stmt->bindParam(":year_encoded", $data["year_encoded"], PDO::PARAM_STR);
                $stmt->bindParam(":annual_target", $data["annual_target"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
    
              }else{
    
                $id = $permit['id'];
    
                $stmt = (new Connection)->connect()->prepare("UPDATE $table SET branch_name = :branch_name, year_encoded = :year_encoded, annual_target = :annual_target WHERE id = :id AND branch_name = :branch_name");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
                $stmt->bindParam(":year_encoded", $data["year_encoded"], PDO::PARAM_STR);
                $stmt->bindParam(":annual_target", $data["annual_target"], PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
              }
    
        
    }






        static public function mdlAddMACorrespondent($table, $data){

        $permit = (new Connection)->connect()->query("SELECT * from $table ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
              if(empty($permit)){
                $id = 0;
    
                $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (preparedBy) 
                    VALUES (:preparedBy)");
    
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
             
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
    
              }else{
    
                $id = $permit['id'];
    
                $stmt = (new Connection)->connect()->prepare("UPDATE $table SET preparedBy = :preparedBy WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":preparedBy", $data["preparedBy"], PDO::PARAM_STR);
               
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
              }
    
    }
    
    //added 10-12-23//

    static public function mdlShowOperationDailyAvailments($branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT selected_date as uploaded_date, branch_name, date, COUNT(id) as entry_data, id FROM `op_hourly_availments` WHERE branch_name = '$branch_name' GROUP BY uploaded_date");
        $stmt -> execute();
        return $stmt -> fetchAll();

        $stmt = null;
    }
    static public function mdlGetHourlyData($branch_name, $current_date, $hour_from, $hour_to) {
        $connection = (new Connection)->connect(); // Assuming $connection is a PDO instance
    
        $sql = "SELECT COUNT(pen_name) as result_count FROM `op_hourly_availments` 
            WHERE branch_name = :branch_name AND
            DATE(`date`) = :current_date AND
            HOUR(`time`) BETWEEN :hour_from AND :hour_to";
    
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':hour_from', $hour_from);
        $stmt->bindParam(':hour_to', $hour_to);
        $stmt->bindParam(':current_date', $current_date);
        $stmt->execute();

        $result = $stmt->fetch();
        $result_count = $result['result_count'];
          
        return $result_count;
        
    }

    static public function mdlCheckDuplication($date, $branch_name){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `op_hourly_availments` WHERE branch_name = '$branch_name' AND date = '$date';");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    static public function mdlAddBranchDailyAvailments($table, $data){
		try{
			
		$pdo = (new Connection)->connect();
		$pdo->beginTransaction();

        $stmt = (new Connection)->connect()->prepare("INSERT INTO $table( pen_ctr, pen_id, branch_name, pen_name, loan_type, time, date, selected_date)
		 VALUES (:pen_ctr, :pen_id, :branch_name, :pen_name, :loan_type, :time, :date, :selected_date)");
        $stmt->bindParam(":pen_ctr", $data["pen_ctr"], PDO::PARAM_STR);
        $stmt->bindParam(":pen_id", $data["pen_id"], PDO::PARAM_STR);
        $stmt->bindParam(":branch_name", $data["branch_name"], PDO::PARAM_STR);
		$stmt->bindParam(":pen_name", $data["pen_name"], PDO::PARAM_STR);
        $stmt->bindParam(":loan_type", $data["loan_type"], PDO::PARAM_STR);
		$stmt->bindParam(":time", $data["time"], PDO::PARAM_STR);
		$stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        $stmt->bindParam(":selected_date", $data["selected_date"], PDO::PARAM_STR);

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

    static public function mdlDeleteAPH($table, $uploaded_date, $branch_name){
		$stmt = (new Connection)->connect()->prepare("DELETE FROM $table WHERE selected_date = :uploaded_date AND branch_name = :branch_name");
		$stmt ->bindParam(":uploaded_date", $uploaded_date, PDO::PARAM_STR);
		$stmt ->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	
	}

    static public function mdlGetBranches($branch_abrv){
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM `branch_names` WHERE branch_name LIKE '%$branch_abrv%'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlShowBranches1(){
		$stmt = (new Connection)->connect()->prepare("SELECT branch_name as full_name FROM branch_names");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    // added 10-20-23 //
    
    static public function mdlShowSelectedYear($yearSelected){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM op_monthly_cut_off WHERE year = '$yearSelected'");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

    static public function mdlCountAllAvail($branch_name, $dateFrom, $dateTo){
        $connection = (new Connection)->connect(); // Assuming $connection is a PDO instance
    
        $sql = "SELECT COUNT(pen_name) as result_count FROM `op_hourly_availments` 
            WHERE branch_name = :branch_name AND
            DATE(`date`) BETWEEN :dateFrom AND :dateTo";
    
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':dateFrom', $dateFrom);
        $stmt->bindParam(':dateTo', $dateTo);
        $stmt->execute();

        $result = $stmt->fetch();
        $result_count = $result['result_count'];
          
        return $result_count;
        
	}

    static public function mdlCountAllAvailTotal($dateFrom, $dateTo){
        $connection = (new Connection)->connect(); // Assuming $connection is a PDO instance
    
        $sql = "SELECT COUNT(pen_name) as result_count FROM `op_hourly_availments` 
            WHERE DATE(`date`) BETWEEN :dateFrom AND :dateTo";
    
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':dateFrom', $dateFrom);
        $stmt->bindParam(':dateTo', $dateTo);
        $stmt->execute();

        $result = $stmt->fetch();
        $result_count = $result['result_count'];
          
        return $result_count;
        
	}

    // added 10-23-23 //

    static public function mdlCheckToUpdate($year, $data){

        $table = 'op_monthly_cut_off';
        $cur_year_jan = !empty($data["cur_year_jan"]) ? $data["cur_year_jan"] : '';
        $cur_year_feb = !empty($data["cur_year_feb"]) ? $data["cur_year_feb"] : '';
        $cur_year_mar = !empty($data["cur_year_mar"]) ? $data["cur_year_mar"] : '';
        $cur_year_apr = !empty($data["cur_year_apr"]) ? $data["cur_year_apr"] : '';
        $cur_year_may = !empty($data["cur_year_may"]) ? $data["cur_year_may"] : '';
        $cur_year_jun = !empty($data["cur_year_jun"]) ? $data["cur_year_jun"] : '';
        $cur_year_jul = !empty($data["cur_year_jul"]) ? $data["cur_year_jul"] : '';
        $cur_year_aug = !empty($data["cur_year_aug"]) ? $data["cur_year_aug"] : '';
        $cur_year_sep = !empty($data["cur_year_sep"]) ? $data["cur_year_sep"] : '';
        $cur_year_oct = !empty($data["cur_year_oct"]) ? $data["cur_year_oct"] : '';
        $cur_year_nov = !empty($data["cur_year_nov"]) ? $data["cur_year_nov"] : '';
        $cur_year_dec = !empty($data["cur_year_dec"]) ? $data["cur_year_dec"] : '';
        

        $checkYear = (new Connection)->connect()->query("SELECT * from $table WHERE year = '$year' limit 1")->fetch(PDO::FETCH_ASSOC);
              if(empty($checkYear)){
        
                $stmt = (new Connection)->connect()->prepare("INSERT INTO $table (year, cur_year_jan, cur_year_feb, cur_year_mar, cur_year_apr,
                cur_year_may, cur_year_jun, cur_year_jul, cur_year_aug, cur_year_sep, cur_year_oct, cur_year_nov, cur_year_dec) 
                    VALUES (:year, :cur_year_jan, :cur_year_feb, :cur_year_mar, :cur_year_apr,
                :cur_year_may, :cur_year_jun, :cur_year_jul, :cur_year_aug, :cur_year_sep, :cur_year_oct, :cur_year_nov, :cur_year_dec)");

                $stmt->bindParam(":year", $year, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jan", $cur_year_jan, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_feb", $cur_year_feb, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_mar", $cur_year_mar, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_apr", $cur_year_apr, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_may", $cur_year_may, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jun", $cur_year_jun, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jul", $cur_year_jul, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_aug", $cur_year_aug, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_sep", $cur_year_sep, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_oct", $cur_year_oct, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_nov", $cur_year_nov, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_dec", $cur_year_dec, PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
    
              }else{
    
                $stmt = (new Connection)->connect()->prepare("UPDATE $table SET cur_year_jan = :cur_year_jan,
                cur_year_feb = :cur_year_feb, cur_year_mar = :cur_year_mar, cur_year_apr = :cur_year_apr, cur_year_may = :cur_year_may, cur_year_jun = :cur_year_jun,
                cur_year_jul = :cur_year_jul, cur_year_aug = :cur_year_aug, cur_year_sep = :cur_year_sep, cur_year_oct = :cur_year_oct, cur_year_nov = :cur_year_nov,
                cur_year_dec = :cur_year_dec WHERE year = :year");
                
                $stmt->bindParam(":year", $year, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jan", $cur_year_jan, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_feb", $cur_year_feb, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_mar", $cur_year_mar, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_apr", $cur_year_apr, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_may", $cur_year_may, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jun", $cur_year_jun, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_jul", $cur_year_jul, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_aug", $cur_year_aug, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_sep", $cur_year_sep, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_oct", $cur_year_oct, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_nov", $cur_year_nov, PDO::PARAM_STR);
                $stmt->bindParam(":cur_year_dec", $cur_year_dec, PDO::PARAM_STR);
    
                if($stmt->execute()){
                    return "ok";
                    $stmt->close();
                    $stmt = null;
                }else{
                    return "error";
                }
              }
    
        
    }

    static public function mdlCountAllAvailPerBranch($branch_name_abv, $dateFrom, $dateTo){
        $connection = (new Connection)->connect(); // Assuming $connection is a PDO instance
    
        $sql = "SELECT COUNT(*) as result_count FROM `op_hourly_availments` 
            WHERE branch_name LIKE :branch_name AND
            DATE(`date`) BETWEEN :dateFrom AND :dateTo";
    
        $stmt = $connection->prepare($sql);
        
        // Bind the parameters with wildcards
        $stmt->bindValue(':branch_name', '%' . $branch_name_abv . '%', PDO::PARAM_STR);
        $stmt->bindParam(':dateFrom', $dateFrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateTo', $dateTo, PDO::PARAM_STR);
        
        $stmt->execute();
    
        $result = $stmt->fetch();
        $result_count = $result['result_count'];
    
        return $result_count;
    }
    



	
}

