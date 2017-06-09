<?php
/**
 * Created by PhpStorm.
 * User: bluemorpho.cn
 * Date: 2016/5/21
 * Time: 11:04
 */

class Vtiger_DealExclusiveAjax_Action extends Vtiger_IndexAjax_View {

    public function process(Vtiger_Request $request) {

        if(isset($_SESSION['authenticated_user_id'])) {
            $user_id = $_SESSION['authenticated_user_id'];
        }
        
        $fieldValue  = $request->get('fieldValue');
        $fieldValue  = trim($fieldValue);

        $companyName = $request->get('companyName');
        $companyName = trim($companyName);

        $response 	 = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        
        if(isset($user_id) && !empty($companyName) && ('已独占' == $fieldValue)){
            $db 		= PearDatabase::getInstance();
            //check account repeat
            $ACR_sql    = "SELECT accountid FROM vtiger_account WHERE accountname LIKE '%{$companyName}%' LIMIT 1";
            $ACR_result = $db->query($ACR_sql);
            $ACR_data   = $db->num_rows($ACR_result);
            if(!$ACR_data){
                $response->setResult(array('success'=>false, 'message'=>'repeat'));
                $response->emit();
                exit;
            }

            //check lead repeat
            $CLR_sql    = "SELECT leadid FROM vtiger_leaddetails WHERE company LIKE '%{$companyName}%' LIMIT 1";
            $CLR_result = $db->query($CLR_sql);
            $CLR_data   = $db->fetch_array($CLR_result);

            if(!empty($CLR_data['leadid'])){
                $VLE_sql    = "SELECT id FROM vtiger_lead_exclusives WHERE leadid={$CLR_data['leadid']} AND userid != {$user_id} LIMIT 1";
                $VLE_result = $db->query($VLE_sql);
                $VLE_data   = $db->num_rows($VLE_result);
                if(!$VLE_data) {
                    $response->setResult(array('success'=>false, 'message'=>'repeat'));
                    $response->emit();
                    exit;
                }
            }

           
        } 
        
        if(isset($user_id)){
            $result = GetExclusiveCounts($_SESSION['authenticated_user_id']);
        }else {
            $result = false;
        }
        if($result !== false){
            $response->setResult(array('success'=>true, 'message'=> $result));
        } else {
            $response->setResult(array('success'=>false, 'message'=>vtranslate('LBL_PLEASE_LOGIN')));
        }
        $response->emit();
    }

}