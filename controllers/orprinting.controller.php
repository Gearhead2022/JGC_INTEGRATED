<?php


class ControllerORPrinting
{

    static public function ctrGetCollectionRecords($collDate, $branch_name)
    {
        $folderPaths = "../views/files/branchor/$branch_name/UPDTOR";
        // $folderPaths = "C:/RECEIPT/UPDTOR";
        $file = $folderPaths . '.DBF';

        /*
         * Open DBF
         */
        $dbf = dbase_open($file, 0);

        if ($dbf === false) {

            echo '<script>
                swal({
                    type: "warning",
                    title: "Only DBF Files!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                }).then(function(result){
                    if (result.value) {
                        window.location = "";
                    }
                });
            </script>';

            exit;
        }

        $existingAccountIds = (new ModelORPrinting)
            ->mdlGetExistingCLCTRecords(
                $collDate,
                $branch_name
            );


        $existingAccounts = [];

        foreach ($existingAccountIds as $accountId) {

            $accountId = trim((string) $accountId);

            if ($accountId !== '') {
                $existingAccounts[$accountId] = true;
            }
        }

        $num_records = dbase_numrecords($dbf);

        for ($i = 1; $i <= $num_records; $i++) {

            $record = dbase_get_record_with_names($dbf, $i);

            if ($record === false) {
                continue;
            }

            $date = date(
                'Y-m-d',
                strtotime(trim($record['CDATE']))
            );

            if ($date !== $collDate) {
                continue;
            }


            $account_id = trim((string) $record['ID']);

            if ($account_id === '') {
                continue;
            }

            if (isset($existingAccounts[$account_id])) {
                continue;
            }

            $cdate = $date;

            $batch = trim($record['BATCH']);
            $mntheff = trim($record['MNTHEFF']);
            $amount = $record['AMOUNT'];

            $posted = (strtoupper(trim($record['POSTED'])) === 'TRUE') ? 'TRUE' : 'FALSE';

            $collstat = preg_replace('/[^a-zA-Z0-9\s]/', '', $record['COLLSTAT']);

            $bankno = trim($record['BANKNO']);
            $balterm = trim($record['BALTERM']);
            $atmbal = trim($record['ATMBAL']);

            $name = rtrim(str_replace('¥', 'Ñ', iconv('ISO-8859-1', 'UTF-8', $record['NAME'])));
            $bank = trim($record['BANK']);
            $target = $record['COLLAMT'];
            $normal = $record['PENSION'];
            $actpnsn = $record['ACTPNSN'];

            $effective = date(
                'Y-m-d',
                strtotime($record['PERIOD'])
            );

            $data = [
                "cdate" => $cdate,
                "account_id" => $account_id,
                "batch" => $batch,
                "mntheff" => $mntheff,
                "amount" => $amount,
                "posted" => $posted,
                "collstat" => $collstat,
                "bankno" => $bankno,
                "balterm" => $balterm,
                "atmbal" => $atmbal,
                "branch_name" => $branch_name,

                "name" => $name,
                "bank" => $bank,
                "target" => $target,
                "normal" => $normal,
                "actpnsn" => $actpnsn,

                "effective" => $effective
            ];

            (new ModelORPrinting)->mdlAddCollectionRecords($data);

            $existingAccounts[$account_id] = true;
        }

        /*
         * Close DBF
         */
        dbase_close($dbf);

        return (new ModelORPrinting)->mdlGetCollectionRecords($collDate, $branch_name);
    }




    public static function ctrGetCollectionInfo($account_id, $collDate, $branch_name)
    {

        $clct = (new ModelORPrinting)->mdlGetCLCTRecords($account_id, $collDate, $branch_name);

        foreach ($clct as &$clctRecords) {
            $account_id = $clctRecords['account_id'];
            $name = $clctRecords['name'];
            $bank = $clctRecords['bank'];
            $target = $clctRecords['target'];
            $normal = $clctRecords['normal'];
            $actpnsn = $clctRecords['actpnsn'];
            $bankno = $clctRecords['bankno'];

            $collstat = $clctRecords['collstat'];
            $bankno = $clctRecords['bankno'];
            $amount = $clctRecords['amount'];
            $atmbal = $clctRecords['atmbal'];
            $cdate = $clctRecords['cdate'];

            $effective = $clctRecords['effective'];
        }

        $data[] = array(
            "accountid" => $account_id,
            "name" => $name,
            "bank" => $bank,
            "target" => $target,
            "normal" => $normal,
            "actpnsn" => $actpnsn,
            "amount" => $amount,
            "bankno" => $bankno,
            "collstat" => $collstat,
            "atmbal" => $atmbal,
            "cdate" => $cdate,
            "effective" => $effective
        );

        // Return the data as JSON
        return $data;
    }

    static public function ctrAddBIRRECRecord($data)
    {
        $table = "birrec";
        $answer = (new ModelORPrinting)->mdlAddBIRRECRecord($table, $data);
        return $answer;
    }

    // Batch controller method:
    static public function ctrBatchAddBIRRECRecords($records)
    {
        $results = [];
        $table = "birrec";
        foreach ($records as $data) {
            $results[] = (new ModelORPrinting)->mdlAddBIRRECRecord($table, $data);
        }

        return $results;
    }

    static public function ctrGetAllCollectionReceiptList($collDate, $branch_name)
    {
        $answer = (new ModelORPrinting)->mdlGetAllCollectionReceiptList($collDate, $branch_name);
        return $answer;

    }
    static public function ctrGetCollectionReceiptInfo($account_id, $tdate, $branch_name)
    {
        $collDate = date("Y-m-d", strtotime($tdate));

        $answer = (new ModelORPrinting)->mdlGetCollectionReceiptInfo($account_id, $collDate, $branch_name);
        return $answer;

    }

    static public function ctrGetLastSavedId($collDate, $branch_name)
    {
        $answer = (new ModelORPrinting)->mdlGetLastSavedId($collDate, $branch_name);
        return $answer;

    }

    static public function ctrGetIdDescription($account_id, $collDate, $branch_name)
    {
        $answer = (new ModelORPrinting)->mdlGetIdDescription($account_id, $collDate, $branch_name);
        return $answer;

    }

    // added 11-22-23 //

    static public function ctrDeleteBIRRECRecord()
    {
        if (isset($_GET['account_id'])) {
            $table = "birrec";
            $data = array(
                "account_id" => $_GET["account_id"],
                "tdate" => date("Y-m-d", strtotime($_GET["tdate"]))
            );

            $answer = (new ModelORPrinting)->mdlDeleteBIRRECRecord($table, $data);
            if ($answer == "ok") {

                echo '<script>
                swal({
                    type: "success",
                    title: "Record has been successfully deleted!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            $("#collDate").val("' . $data["tdate"] . '");
                            $(".generateReceiptList").trigger("click");
                        }
                    })
                </script>';
            } else if ($answer == "error") {
                echo '<script>

                swal({
                    type: "warning",
                    title: "Theres an error occur!",
                    showConfirmButton: true,
                    confirmButtonText: "Ok"
                    }).then(function(result){
                        if (result.value) {
                            $("#collDate").val("' . $data["tdate"] . '");
                            $(".generateReceiptList").trigger("click");
                        }
                    })
                </script>';

            }
        }
    }

    static public function ctrGetAllCollectionReceiptInfo($tdate, $branch_name)
    {
        $collDate = date("Y-m-d", strtotime($tdate));

        $answer = (new ModelORPrinting)->mdlGetAllCollectionReceiptInfo($collDate, $branch_name);
        return $answer;

    }

    static public function ctrUpdateFileRecords()
    {
        if (isset($_POST["updateRecord"])) {
            // $table = "branch_dtr_upload";

            // Check if a file was uploaded
            if (isset($_FILES["or_file"]) && $_FILES["or_file"]["error"] == 0) {
                $branch = $_POST["or_branch_name"];

                $uploadDir = "views/files/branchor/$branch/";

                // Check if the directory exists, create it if not
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadFile = $uploadDir . basename($_FILES["or_file"]["name"]);

                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES["or_file"]["tmp_name"], $uploadFile)) {
                    // File uploaded successfully
                    echo '<script>
                        swal({
                            type: "success",
                            title: "File Successfully Updated!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "branchCollectionReceipt";
                            }
                        });
                    </script>';

                    // 
                } else {
                    // Error in moving the uploaded file
                    echo '<script>
                            swal({
                                type: "error",
                                title: "Error in uploading file!",
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            });
                        </script>';
                }

            } else {
                // No file uploaded
                echo '<script>
                        swal({
                            type: "warning",
                            title: "Please select a file to upload!",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        });
                      </script>';
            }
        }
    }
}