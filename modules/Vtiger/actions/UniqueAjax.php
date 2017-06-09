<?php
/*+***********************************************************************************
author bluemorpho.cn
 ************************************************************************************ */

class Vtiger_UniqueAjax_Action extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		$tablePrefix	= 'vtiger_';
		$unique_keyword = $request->get('unique_keyword');
		$sourceModule 	= $request->getForSql('source_module');
		$record 		= $request->getForSql('record');
		$feildName 		= $request->getForSql('field_name');
		$moduleName		= $tablePrefix . $sourceModule;
		
		$db 			= PearDatabase::getInstance();

        $response 		= new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);

        //check account repeat
        if($feildName == 'company') {
            $ACR_sql    = "SELECT accountid FROM vtiger_account WHERE accountname LIKE '%{$feildName}%' LIMIT 1";
            $ACR_result = $db->query($ACR_sql);
            $ACR_data   = $db->num_rows($ACR_result);
            if(!$ACR_data){
                $response->setResult(array('success'=>false, 'message'=>vtranslate('LBL_RECORD_EXIST') ));
                $response->emit();
                exit;
            }
        }

		$ExcludeSql		= (empty($record) || ($record == 'null'))? '' : " AND " . $this->getKeyField($sourceModule) . " != " . $record;
		$sql 			= "SELECT $feildName FROM $moduleName WHERE $feildName = '". $unique_keyword . "'" . $ExcludeSql;
		$result			= $db->query($sql);
		$result			= $db->num_rows($result);

		if(!$result){
			$response->setResult(array('success'=>true, 'message'=>vtranslate('LBL_RECORD_NONE') ));
		} else {
			//存在重复记录
			$response->setResult(array('success'=>false, 'message'=>vtranslate('LBL_RECORD_EXIST') ));
		}
		$response->emit();
	}

	/**
	 * @param $sourceModule
	 * @return string
     */
	private function getKeyField($sourceModule){
		$KeyField = '';
		if(!empty($sourceModule)){
			switch ($sourceModule) {
				case 'leaddetails':
					$KeyField = 'leadid';
					break;
				default:
					$KeyField = $sourceModule . 'id';
					break;
			}
		}
		return $KeyField;
	}
}
