<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class SMSNotifier_HaoService_Provider implements SMSNotifier_ISMSProvider_Model {

	//private $userName;
	//private $password;
	private $parameters = array();

	const SERVICE_URI = 'http://apis.haoservice.com';
	private static $REQUIRED_PARAMETERS = array('key', 'tpl_id');

	/**
	 * Function to get provider name
	 * @return <String> provider name
	 */
	public function getName() {
		return 'HaoService';
	}

	/**
	 * Function to get required parameters other than (userName, password)
	 * @return <array> required parameters list
	 */
	public function getRequiredParams() {
		return self::$REQUIRED_PARAMETERS;
	}

	/**
	 * Function to get service URL to use for a given type
	 * @param <String> $type like SEND, PING, QUERY
	 */
	public function getServiceURL($type = false) {
		if($type) {
			switch(strtoupper($type)) {
				case self::SERVICE_SEND:	return self::SERVICE_URI . '/sms/send';
				default:
					return self::SERVICE_URI . '/sms/send';
			}
		}
		return false;
	}

	/**
	 * Function to set authentication parameters
	 * @param <String> $userName
	 * @param <String> $password
	 */
	public function setAuthParameters($userName, $password) {
		//$this->userName = $userName;
		//$this->password = $password;
	}

	/**
	 * Function to set non-auth parameter.
	 * @param <String> $key
	 * @param <String> $value
	 */
	public function setParameter($key, $value) {
		$this->parameters[$key] = $value;
	}

	/**
	 * Function to get parameter value
	 * @param <String> $key
	 * @param <String> $defaultValue
	 * @return <String> value/$default value
	 */
	public function getParameter($key, $defaultValue = false) {
		if(isset($this->parameters[$key])) {
			return $this->parameters[$key];
		}
		return $defaultValue;
	}

	/**
	 * Function to prepare parameters
	 * @return <Array> parameters
	 */
	protected function prepareParameters() {
		//$params = array('user' => $this->userName, 'password' => $this->password);
		$params = array();
		foreach (self::$REQUIRED_PARAMETERS as $key) {
			$params[$key] = $this->getParameter($key);
		}
		return $params;
	}

	/**
	 * Function to handle SMS Send operation
	 * @param <String> $message
	 * @param <Mixed> $toNumbers One or Array of numbers
	 */
	private function sendSMS($params, $message, $number) {
		$log =& LoggerManager::getLogger('ClickATell');

		$params['text'] = urlencode($message);
		$params['tpl_value'] = urlencode("#no#=" . $params['text']);
		$params['mobile'] = $number;

		$serviceURL = $this->getServiceURL(self::SERVICE_SEND);
		$paramsUri = '';
		foreach ($params as $key => $val) {
			$paramsUri .= $key . '=' . $val . '&';
		}
		
		$response = file_get_contents($serviceURL . "?" . rtrim($paramsUri, "&"));
		$log->debug($serviceURL . "?" . rtrim($paramsUri, "&"));
		//$log->debug($response);

		$response     = json_decode($response);
		$result       = array( 'error' => false, 'statusmessage' => '' );
		$result['to'] = $params['mobile'];
		$responseData = array();
		foreach ($response as $key => $value) {
			$responseData[$key] = $value;
		}
		if($responseData['error_code'] == 0 ) {
			$result['id'] = md5(date('YmdHis') . rand(10000, 99999));
			$result['status'] = self::MSG_STATUS_PROCESSING;
		} else {
			$result['error'] = true;
			$result['statusmessage'] = "error_code:" . $responseData['error_code'] . ' reason:' . $responseData['reason'];
		}
		$log->debug("\n\n---");
		$log->debug(json_encode($result));
		return $result;
	}

	public function send($message, $toNumbers){
		$log =& LoggerManager::getLogger('ClickATell');
		if(!is_array($toNumbers)) {
			$toNumbers = array($toNumbers);
		}
		$params  = $this->prepareParameters();
		$results = array();
		foreach ($toNumbers as $key => $number) {
			$results[] = $this->sendSMS($params, $message, $number);
		}
		//$results = array( 'error' => false, 'statusmessage' => json_encode($results) );
		//$log->debug(json_encode($results));
		return $results;
	}

	/**
	 * Function to get query for status using messgae id
	 * @param <Number> $messageId
	 */
	public function query($messageId) {
		$params = $this->prepareParameters();
		$params['apimsgid'] = $messageId;

		//$serviceURL = $this->getServiceURL(self::SERVICE_QUERY);
		//$httpClient = new Vtiger_Net_Client($serviceURL);
		//$response = $httpClient->doPost($params);
		//$response = trim($response);

		$result = array( 'error' => false, 'needlookup' => 1, 'statusmessage' => '' );

		return $result;
	}
}
?>
