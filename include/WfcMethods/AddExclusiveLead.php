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
    $userid         = trim($_REQUEST['assigned_user_id']) ? : $_SESSION['authenticated_user_id'];
    $leadid 	    = trim($_REQUEST['record']) ? : '';
    $created 		= date('Y-m-d H:i:s');
    $result = array('success' => false, 'message' => '');
    if(!empty($userid)) {
        $counts = GetExclusiveCounts($userid);
        $adb    = PearDatabase::getInstance();
        if(($counts < 2)){
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