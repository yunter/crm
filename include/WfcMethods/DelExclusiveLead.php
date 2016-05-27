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
define('MAX_TTME', 1); //day

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

function DelExclusiveLead() {
    $log =& LoggerManager::getLogger('ClickATell');
    $log->debug('Update exclusive counts start.');
    $tablePrefix	= 'vtiger_';

    $userid     = trim($_REQUEST['assigned_user_id']) ? : $_SESSION['authenticated_user_id'];
    $leadid 	= trim($_REQUEST['record']) ? : '';
    $result     = array('success' => false, 'message' => '');
    if(!empty($userid)) {
        $adb    = PearDatabase::getInstance();
        $leadCfSQL    = "UPDATE vtiger_leadscf ";
        $leadCfSQL   .= "LEFT JOIN " . $tablePrefix . "lead_exclusives ON vtiger_leadscf.leadid=" . $tablePrefix . "lead_exclusives.leadid ";
        $leadCfSQL   .= "SET vtiger_leadscf.cf_833='未独占' ";
        $leadCfSQL   .= "WHERE userid=" . $userid . " AND datediff(NOW(), " . $tablePrefix . "lead_exclusives.created) >=" . MAX_TTME;;
        $resultLeadCf = $adb->query($leadCfSQL);
        if($resultLeadCf){
            $log->debug('Update vtiger_leadscf status success.' . $leadCfSQL );
            $sql = "DELETE FROM " . $tablePrefix . "lead_exclusives WHERE userid=" . $userid . " AND leadid=" . $leadid;
            $result = $adb->query($sql);
            if($result){
                $log->debug('Update exclusive counts success .' . json_encode($result));
            }
            $counts = GetExclusiveCounts($userid);
            $result = array('success' => true, 'message' => $counts );
        } else {
            $log->debug('Update vtiger_leadscf status failed.' . $leadCfSQL );
            $counts = GetExclusiveCounts($userid);
            $result     = array('success' => false, 'message' => $counts);
        }
    }

    $log->debug('Update exclusive counts end. SQL:' . $sql);
    return  $result;

}