<?php

require_once "../controllers/orprinting.controller.php";
require_once "../models/orprinting.model.php";
require_once "../views/modules/session.php";

$activateList = new CLCTRecords();
$activateList->showCLCTDataList();

class CLCTRecords
{
    public function showCLCTDataList()
    {
        if (isset($_GET['collDate']) && $_GET['collDate'] != '') {
            $collDate = date(
                'Y-m-d',
                strtotime($_GET['collDate'])
            );
        } else {
            $collDate = '';
        }

        if (!empty($_SESSION['branch_name'])) {
            $branch_name = $_SESSION['branch_name'];
        } else {
            $branch_name = 'admin';
        }

        /*
         * Get collection records
         */
        $List = (new ControllerORPrinting)->ctrGetCollectionRecords($collDate, $branch_name);

        if (empty($List)) {

            header('Content-Type: application/json');

            echo json_encode([
                "data" => []
            ]);

            return;
        }

        $existingBIRRecords = (new ModelORPrinting)->mdlGetExistingBIRRecords($collDate, $branch_name);

        /*
         * Create lookup
         */
        $existingBIRLookup = [];

        foreach ($existingBIRRecords as $accountId) {
            $existingBIRLookup[trim($accountId)] = true;
        }

        $data = [];

        foreach ($List as $row) {

            $account_id = trim($row["account_id"]);
            $cdate = $row["cdate"];

            /*
             * Check birrec WITHOUT SQL
             */
            if (isset($existingBIRLookup[$account_id])) {

                $buttons = "
                    <div class='btn-group group-round m-1'>
                        <button
                            data-toggle='tooltip'
                            data-placement='top'
                            title='Re-Edit'
                            class='btn btn-sm btn-danger waves-effect waves-light btnEditColl'
                            account_id='" . htmlspecialchars($account_id, ENT_QUOTES, 'UTF-8') . "'cdate='" . date("Ymd", strtotime($cdate)) . "'>
                            Re-Edit
                        </button>
                    </div>
                ";

            } else {

                $buttons = "
                    <div class='btn-group group-round m-1'>
                        <button
                            data-toggle='tooltip'
                            data-placement='top'
                            title='Edit'
                            class='btn btn-sm btn-info waves-effect waves-light btnEditColl'
                            account_id='" . htmlspecialchars($account_id, ENT_QUOTES, 'UTF-8') . "'
                            cdate='" . date("Ymd", strtotime($cdate)) . "'
                        >
                            Edit
                        </button>
                    </div>
                ";
            }

            $checkbox = "
                <input
                    type='checkbox'
                    class='collectionRowCheckbox'
                    value='" . htmlspecialchars($account_id, ENT_QUOTES, 'UTF-8') . "'
                    data-account-id='" . htmlspecialchars($account_id, ENT_QUOTES, 'UTF-8') . "'
                    data-name='" . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . "'
                    data-amount='" . htmlspecialchars($row["amount"], ENT_QUOTES, 'UTF-8') . "'
                    data-cdate='" . htmlspecialchars($row["cdate"], ENT_QUOTES, 'UTF-8') . "'
                    data-bank='" . htmlspecialchars($row["bank"], ENT_QUOTES, 'UTF-8') . "'
                >
            ";

            $data[] = [
                $checkbox,
                $buttons,
                $row["cdate"],
                $row["account_id"],
                $row["name"],
                $row["mntheff"],
                number_format(
                    $row["amount"],
                    2,
                    '.',
                    ''
                ),
                $row["posted"],
                $row["collstat"],
                $row["bank"],
                $row["balterm"],
                number_format(
                    $row["atmbal"],
                    2,
                    '.',
                    ''
                )
            ];
        }

        header('Content-Type: application/json');

        echo json_encode([
            "data" => $data
        ]);
    }
}