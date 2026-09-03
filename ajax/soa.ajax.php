<?php
require_once "../controllers/soa.controller.php";
require_once "../models/soa.model.php";
require_once "../views/modules/session.php";

$filterBackup= new reportTable();
// if(isset($_GET['filterYear'])){
// $filterBackup -> showFilterMonth();
// }elseif(isset($_GET['backup_id'])){
//     $filterBackup -> showFilter();
// }
$type = $_REQUEST["type"];
if($type == "modal1"){
    $filterBackup -> showFilter();
}elseif($type == "modal2"){
    $filterBackup -> showSOAModal1();
}
elseif($type == "reprint"){
    $filterBackup -> ctrReprinting();
}
elseif($type == "delete"){
    $filterBackup -> ctrDeleteSOA();
}
elseif($type == "logs"){
    $filterBackup -> showSOALogs();
}
class reportTable{
    
   public function showFilter() {
        $id = $_REQUEST["id"];
        $date = $_REQUEST["date"];
        $con = new ControllerSOA();
        $SOA = $con->ctrShowAllSOA($id, $date);
        $data = [
            'card' => '', // Initialize 'card' key as an empty string
        ];
        foreach ($SOA as $row) {
            
            $button = '<button data-toggle="tooltip" data-placement="top" id="soaDltBtn" soaID="' . $row["id"] . '" title="Delete" class=" soaDltBtn btn btn-sm btn-danger waves-effect waves-light data-original-title="Delete"><i style="font-size: 15px;" class="fa fa-trash"></i></button>';
            $data['card'] .= '
                <tr id="arcTR" class="arcTR" account_no="' . $row["account_no"] . '">
                    <td>' . $button . '</td>
                    <td>' . $row["account_no"] . '</td>
                    <td>' . $row["name"] . '</td>
                    <td>' . $row["address"] . '</td>
                    <td>' . $row["bank"] . '</td>
                    <td>' . $row["pension"] . '</td>
                    <td>' . $row["principal"] . '</td>
                    <td>' . $row["baltot"] . '</td>
                </tr>
            ';
        }
        echo json_encode($data); // Move this line outside the loop
    }

    public function showSOAModal1() {
        $id = $_REQUEST["id"];
        $date = $_REQUEST["date"];
        $con = new ControllerSOA();
        $SOA = $con->ctrShowAllSOA($id, $date);
        $data = [
            'card' => '', // Initialize 'card' key as an empty string
            'id' => '', 
        ];
        foreach ($SOA as $row) {
            $unique = $row["id"];
            $name = $row["name"];
            $bank = $row["bank"];
            $date = date("F d, Y", strtotime($row["tdate"])) ."  ". $row["ttime"];
            $date1 = date("F d, Y", strtotime($row["tdate"]));
            $name = $row["name"];
            $address = $row["address"];
            $principal = $row["principal"]; $principal = number_format($row["principal"], 2);
            $change = $row["change"];
            $interest =  number_format( $row["interest"], 2);
            $others =  number_format( $row["others"], 2);
            $baltot =  number_format( $row["baltot"], 2);
            $sl = number_format($change, 2);
            $note = $row["note"];
            $fa = $row["fa"];
            $boh = $row["boh"];
            $from = $row["fmonth"]." ".$row["fyr"];
            $to = $row["tmonth"]." ".$row["tyr"];
          
        }
            $data['card'] .= '
            <section id="arcInfo">
            <div class="row">
              <div class="col-sm-12">
                  <p style="text-align:center; color:#08655D;font-size: 1.1em;">Last date printed: &nbsp;'. $date.'</p>
              </div>
            </div>
            <div class="arcHeader">
              <div class="row">
                <div class="col-sm-1">
                    <p style="text-align:lefth;">ID:</p>
                </div>
                <div class="col-sm-7 ml-5">
                    <p style="text-align:lefth;">'. $id.'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-1">
                    <p style="text-align:left;">Name:</p>  
                </div>
                <div class="col-sm-7 ml-5">
                    <p style="text-align:left;">'. $name.'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-1">
                    <p style="text-align:left;">Bank:</p>
                </div>
                <div class="col-sm-7 ml-5">
                    <p style="text-align:left;">'. $bank .'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-1">
                    <p style="text-align:left;">Address:</p>
                </div>
                <div class="col-sm-7 ml-5">
                    <p style="text-align:left;">'. $address .'</p>
                </div>
             </div>
            </div>
        </section>
        <section id="arcBody111">
            <div class="row">
              <div class="col-sm-12">
                <p style="text-align:center; color:#08655D; font-size: 1.3em;margin-top: 5px;">SOA Summary</p>
              </div>
            </div>
            <div class="noteContent">
              <div class="row">
                <div class="col-sm-10">
                    <p style="text-align:left;">TOTAL LOANS RECEIVABLE:</p>
                </div>
                <div class="col-sm-2">
                    <p style="text-align:right; border-bottom: 1px solid;">'. $principal .'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-10">
                    <p style="text-align:left;">ADD: SUPPLEMENTARY LOANS(SL):</p>
                </div>
                <div class="col-sm-2">
                    <p style="text-align:right;">'. $sl .'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-10">
                    <p style="text-align:left;">INTEREST ON SL ('. $from .' TO '. $to .'):</p>
                </div>
                <div class="col-sm-2">
                    <p style="text-align:right;">'. $interest .'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-10">
                    <p style="text-align:left;">OTHERS:</p>
                </div>
                <div class="col-sm-2">
                    <p style="text-align:right; border-bottom: 1px solid;">'. $others .'</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-10">
                    <p style="text-align:left;">ACCOUNT BALANCE AS OF '. $date1 .':</p>
                </div>
                <div class="col-sm-2">
                    <p style="text-align:right; border-bottom: 1px solid;">'. $baltot .'</p>
                </div>
              </div>
            </div>
            <div class="arcNote">
                <div class="row">
                  <div class="col-sm-12">
                  <p style="text-align:center; color:#08655D; margin: 2px; font-size: 1.3em;">NOTE</p><br>
                  <p style="margin: -10px 10px;">'. $note .'</p>
                  </div>
                </div>
            </div>
            <div class="noteFooter">
            <div class="row" style="min-height: 14px;">
                  <div class="col-sm-2" style="text-align:right; margin: 0px;">
                      <p style="margin: 0px;">Prepared By:</p>
                  </div>
                  <div class="col-sm-4" style="margin: 0px;">
                     <p style="text-decoration: underline;margin: 0px;">'. $fa .'</p>
                  </div>
                  <div class="col-sm-2" style="text-align: right; margin: 0px;">
                      <p style="margin: 0px;">Approved By:</p>
                  </div>
                  <div class="col-sm-4" style="margin: 0px;">
                      <p style="text-decoration: underline;margin: 0px;">'. $boh .'</p>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-2" style="text-align:right;">
                  </div>
                  <div class="col-sm-4" >
                     <p style="">Branch Finance and Admin Head</p>
                  </div>
                  <div class="col-sm-2" style="text-align: right;">
                  </div>
                  <div class="col-sm-4" >
                      <p style="">Branch Operations Head</p>
                  </div>
              </div>
          </div>
        </section>
         
            ';
             $data['id'] .=$unique;
        // }
        echo json_encode($data); // Move this line outside the loop
    }
    
    public function ctrReprinting(){
        $id = $_REQUEST['id'];
        $con = new ControllerSOA();
        $SOA = $con->ctrReprintSOA($id);
        
        // Check if $SOA is not empty to indicate success
        if ($SOA) {
            // Return success message in JSON format
            echo json_encode(array("success" => true));
        } else {
            // Return error message in JSON format
            echo json_encode(array("success" => false, "message" => "Failed to reprint SOA."));
        }
    }

    public function ctrDeleteSOA(){
        $id = $_REQUEST['id'];
        $con = new ControllerSOA();
        $SOA = $con->ctrDeleteSOA($id);
        
        // Check if $SOA is not empty to indicate success
        if ($SOA) {
            // Return success message in JSON format
            echo json_encode(array("success" => true));
        } else {
            // Return error message in JSON format
            echo json_encode(array("success" => false, "message" => "Failed to reprint SOA."));
        }
    }
    
        public function showSOALogs(){
        $con = new ControllerSOA();
        $SOA1 = $con->ctrShowAllLogs();
        $data = [
            'card' => '', // Initialize 'card' key as an empty string
        ];
        
        foreach ($SOA1 as $row) {
            if($row['type']=="REPRINTING"){
                $badge = '<span style="font-size: 12px;" class="badge badge-primary">' . $row["type"] . '</span>';

            }else{
                $badge = '<span style="font-size: 12px;" class="badge badge-success">' . $row["type"] . '</span>';

            }
            $data['card'] .= '
                <tr id="arcTR" class="arcTR">
                    <td>' . $row["account_no"] . '</td>
                    <td>' . $row["name"] . '</td>
                    <td>' . $badge. '</td>
                    <td>' . $row["time"] . '</td>
                </tr>
            ';
          
        }
        echo json_encode($data); // Move this line outside the loop
    }




}