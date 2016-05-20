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

function DelExclusiveLead() {
    $log =& LoggerManager::getLogger('ClickATell');
    $log->debug('Update exclusive counts start.');
    $tablePrefix	= 'vtiger_';

    $userid     = trim($_REQUEST['assigned_user_id']) ? : $_SESSION['authenticated_user_id'];
    $leadid 	= trim($_REQUEST['record']) ? : '';
    $result     = array('success' => false, 'message' => '');
    if(!empty($userid)) {

        $sql = "DELETE FROM " . $tablePrefix . "lead_exclusives WHERE userid=" . $userid . " AND leadid=" . $leadid;
        $adb    = PearDatabase::getInstance();
        $result = $adb->query($sql);
        if($result){
            $counts = GetExclusiveCounts($userid);
            $result = array('success' => true, 'message' => $counts );
            $log->debug('Update exclusive counts .' . json_encode($result));
        }
    }

    $log->debug('Update exclusive counts end. SQL:' . $sql);
    return  $result;

}