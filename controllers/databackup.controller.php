<?php

class ControllerDataBackup{
	static public function ctrShowDataBackup(){
		$answer = (new ModelDataBackup)->mdlGetBackupSummaries();
		return $answer;
	}
    static public function ctrGetDataBackup($data_id) {
        return ModelDataBackup::mdlShowDataBAckup($data_id);
    }

	static public function ctrHandleUpdateDataFiles($backup_at, $dbname) {
		return ModelDataBackup::mdlHandleUpdateDataFiles($backup_at, $dbname);
	}

	 static public function ctrHandleUpdateDatabase($data_id,
        $dbname,
        $filename,
        $filePath,
        $backup_user,
        $backup_at,
        $time_at) {
        return ModelDataBackup::mdlHandleUpdateDatabase($data_id,
        $dbname,
        $filename,
        $filePath,
        $backup_user,
        $backup_at,
        $time_at);
    }

}