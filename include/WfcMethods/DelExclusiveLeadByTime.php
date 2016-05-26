<?php
/**
 * Created by PhpStorm.
 * User: bluemorpho.cn
 * Date: 2016/5/19
 * Time: 10:21
 */
require_once('config.php');
require_once('include/logging.php');
require_once('include/utils/utils.php');
require_once('modules/Users/Users.php');
define('MAX_TTME', 1); //day

function DelExclusiveLeadByTime() {
    $log =& LoggerManager::getLogger('ClickATell');
    $log->debug('update exclusive status start.');
    $tablePrefix	= 'vtiger_';

    $result     = array('success' => false, 'message' => '', 'tip'=>'');
    $adb    = PearDatabase::getInstance();
    $leadExclusivesTable = $tablePrefix . 'lead_exclusives';
    $leadCfSQL  = "UPDATE vtiger_leadscf SET vtiger_leadscf.cf_833='未独占' ";
    $leadCfSQL .= "LEFT JOIN $leadExclusivesTable ON $leadExclusivesTable.leadid = vtiger_leadscf.leadid ";
    $leadCfSQL .= "SET vtiger_leadscf.cf_833='未独占' ";
    $leadCfSQL .= "WHERE datediff(NOW(), $leadExclusivesTable.created) >=" . MAX_TTME;;
    $resultLeadCf = $adb->query($leadCfSQL);
    if($resultLeadCf){
        $result = array('success' => true, 'message' => $leadCfSQL );
        $log->debug('Update vtiger_leadscf status success. SQL:' . $leadCfSQL );
    } else {
        $log->debug('Update vtiger_leadscf status failed.' );
    }
    $delSQL = "DELETE FROM $leadExclusivesTable WHERE datediff(NOW(), created) >=" . MAX_TTME;
    $resultDelSQL = $adb->query($delSQL);
    if($resultDelSQL){
        $result = array('success' => true, 'tip' => $delSQL );
        $log->debug('DEL exclusive counts success.SQL:' . $delSQL);
    } else {
        $log->debug('DEL exclusive failed.' );
    }

    $log->debug('update exclusive status end.');
    return  $result;
}