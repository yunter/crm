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
        
        $fieldValue = $request->get('fieldValue');
        $companyName = $request->get('companyName');
        $response 	 = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        
        if(isset($user_id) && !empty($companyName) && ('已独占' == $fieldValue)){
            $db 		 = PearDatabase::getInstance();
            $sql         = "SELECT leadid FROM vtiger_leaddetails WHERE company LIKE '%{$companyName}%' limit 1";
            $result		 = $db->query($sql);
            $data		 = $db->fetch_array($result);

            if(!empty($data['leadid'])){
                $sql			= "SELECT id FROM vtiger_lead_exclusives WHERE leadid={$data['leadid']} AND userid != {$user_id}";
                $result		= $db->query($sql);
                $data			= $db->fetch_array($result);
                if(!empty( $data['id'])) {
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