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
            $result = GetExclusiveCounts($_SESSION['authenticated_user_id']);

        } else {
            $result = false;
        }
        $response 		= new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        if($result !== false){
            $response->setResult(array('success'=>true, 'message'=> $result));
        } else {
            $response->setResult(array('success'=>false, 'message'=>vtranslate('LBL_PLEASE_LOGIN')));
        }
        $response->emit();
    }

}