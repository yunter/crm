<?php
/**
 * Created by PhpStorm.
 * User: bluemorpho.cn
 * Date: 2016/5/19
 * Time: 10:21
 */
session_start();
require_once('config.php');
require_once('include/logging.php');
require_once('include/utils/utils.php');
require_once('modules/Users/Users.php');

define('MAX_COUNTS', 30);
if(isset($_SESSION['authenticated_user_id'])) {
    $current_user = new Users();
    $result       = $current_user->retrieveCurrentUserInfoFromFile($_SESSION['authenticated_user_id'],"Users");
    if($result == null) {
        session_destroy();
        header("Location: index.php?action=Login&module=Users");
        exit;
    }

} else {
    session_destroy();
    header("Location: index.php?action=Login&module=Users");
    exit;
}

function AddExclusiveLead() {
    $log =& LoggerManager::getLogger('ClickATell');
    $log->debug('Update exclusive counts start.');
    $tablePrefix	= 'vtiger_';

    $assigned_user_id = trim($_REQUEST['assigned_user_id']);
    $record     = trim($_REQUEST['record']);
    $userid     = $assigned_user_id ? $assigned_user_id : $_SESSION['authenticated_user_id'];
    $leadid 	= $record ? $record : '';

    $created 	= date('Y-m-d H:i:s');
    $result     = array('success' => false, 'message' => '');
    if(!empty($userid)) {
        $counts = GetExclusiveCounts($userid);
        $adb    = PearDatabase::getInstance();
        if(($counts <= MAX_COUNTS)){
            $sql    = "SELECT id FROM " . $tablePrefix . "lead_exclusives WHERE exclusive = 1 AND userid = " . $userid;
            $result = $adb->query($sql);
            $result = $adb->num_rows($result);
            if($result < 1){
                $sql  = 'INSERT INTO ' . $tablePrefix . 'lead_exclusives (';
                $sql .= 'userid, ';
                $sql .= 'leadid, ';
                $sql .= 'exclusive, ';
                $sql .= 'created ';
                $sql .= ') VALUES (';
                $sql .=  "$userid, ";
                $sql .=  "$leadid, ";
                $sql .=  "1, ";
                $sql .=  "'$created'";
                $sql .= ')';
                $result = $adb->query($sql);
            } else {
                $result = true;
            }

            if($result){
                $result = array('success' => true, 'message' => $counts );
                $log->debug('Update exclusive counts .' . json_encode($result));
            }
        } else{
            $modifySQL = "UPDATE vtiger_leadscf SET cf_833='未独占' WHERE leadid=" . $leadid;
            $result = $adb->query($modifySQL);
            if($result) {
                $log->debug('Update vtiger_leadscf exclusive status success .');
            }
            $counts = GetExclusiveCounts($userid);
            $result = array('success' => true, 'message' => $counts );
        }
    }

    $log->debug('Update exclusive counts end. SQL:' . $sql);
    return  $result;
    
}