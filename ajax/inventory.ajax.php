<?php
require_once "../controllers/qrcode.controller.php";
require_once "../models/qrcode.model.php";
require_once "../views/modules/session.php";
$inventoryTabale= new inventoryTable();
$inventoryTabale -> showInventoryable();
class inventoryTable {
    public function showInventoryable() {
        $type = $_SESSION['type'];
        $account = (new ControllerQRCode)->ctrShowInventoryTable($type);
        
        if(count($account) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }

        $jsonData = '{ "data":[';

        $processedSets = []; // Array to track processed set_codes
        for($i = 0; $i < count($account); $i++) {
            $sticker_no = $account[$i]["sticker_no"];
            
            // Skip if sticker_no contains a decimal point
            if (strpos($sticker_no, '.') !== false) {
                continue;
            }

            $class_list  = $account[$i]["class_list"];
            $class_code  = $account[$i]["class_code"];
            
            
            $isFirstItemInSet = !in_array($class_code, $processedSets);
         // Check if this is the last item in the set
    $isLastItemInSet = ($i === count($account) - 1) || ($i < count($account) - 1 && $account[$i + 1]["class_code"] !== $class_code);
        
            if($type == "admin" || $type == "inventory_admin") {
                    // Mark the set as processed after checking
            if ($isFirstItemInSet) {
                $processedSets[] = $class_code;
            }

                if($class_list == "COMPUTER SET" || $class_list == "CCTV SET") {
                    $desktopIcon = $isLastItemInSet ? "<button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-warning waves-effect waves-light btnSet' id='btnSet' class_code='".$account[$i]["class_code"]."' idClient='".$account[$i]["id"]."' title='Set'><i class='fa fa-desktop'></i></button>":"";
                    $buttons = "<div class='btn-group group-round m-1 btnGroup'><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-info waves-effect waves-light btnEditItem' title='Edit' idClient='".$account[$i]["id"]."' ><i class='fa fa-pencil'></i></button><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-danger waves-effect waves-light btnDeleteItem' title='Delete' idClient='".$account[$i]["id"]."' sticker='".$account[$i]["sticker_no"]."' item_code='".$account[$i]["item_code"]."' ><i class='fa fa-trash'></i></button>$desktopIcon<button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-success waves-effect waves-light btnHistory' id='btnHistory' idClient='".$account[$i]["id"]."' title='History'><i class='fa fa-history'></i></button></div>";
                } else {
                    $buttons = "<div class='btn-group group-round m-1 btnGroup'><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-info waves-effect waves-light btnEditItem' title='Edit' idClient='".$account[$i]["id"]."' ><i class='fa fa-pencil'></i></button><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-danger waves-effect waves-light btnDeleteItem' title='Delete' idClient='".$account[$i]["id"]."' sticker='".$account[$i]["sticker_no"]."' item_code='".$account[$i]["item_code"]."' ><i class='fa fa-trash'></i></button><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-success waves-effect waves-light btnHistory' id='btnHistory' idClient='".$account[$i]["id"]."' title='History'><i class='fa fa-history'></i></button></div>";
                }
            } else if($type == "inventory_mis") {
                $buttons = "<div class='btn-group group-round m-1 btnGroup'><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-info waves-effect waves-light btnEditItem' title='Edit' idClient='".$account[$i]["id"]."' ><i class='fa fa-pencil'></i></button><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-success waves-effect waves-light btnHistory' id='btnHistory' idClient='".$account[$i]["id"]."' title='History'><i class='fa fa-history'></i></button></div>";
            } else {
                $buttons = "<div class='btn-group group-round m-1 btnGroup'><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-info waves-effect waves-light btnEditItem' title='View' idClient='".$account[$i]["id"]."' ><i class='fa fa-eye'></i></button><button data-toggle='tooltip' data-placement='top' class='btn btn-sm btn-success waves-effect waves-light btnHistory' id='btnHistory' idClient='".$account[$i]["id"]."' title='History'><i class='fa fa-history'></i></button></div>";
            }

            $statuses = [
                "WORKING" => "#5cac83;",
                "DEFECTIVE" => "#9f805b",
                "DISPOSED" => "#8e3444",
                "PENDING" => "#7a595f",
                "REPAIRED" => "#467f42",
            ];
            $stat = $account[$i]["invstatus"];
            $badge = $statuses[$stat] ?? "default"; // "default" as a fallback if status doesn't match any key
            $invstatus = "<span class='btn btn-sm' style='color:white; background-color:$badge'>$stat</span>";
            
            $jsonData .= '[
                "'.$buttons.'",
                "'.$account[$i]["sticker_no"].'",
                "'.$account[$i]["item_description"].'",
                "'.$account[$i]["item_location"].'",
                "'.$account[$i]["date_purchased"].'",
                "'.$invstatus.'",
                "'.$account[$i]["log_branch_name"].'",
                "'.$account[$i]["status"].'"
            ],';

        }


        $jsonData = substr($jsonData, 0, -1);
        $jsonData .= '] }';

        echo $jsonData;
    }
}
