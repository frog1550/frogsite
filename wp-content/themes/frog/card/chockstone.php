<?php

require_once('xml.php');

class Chockstone {
	
	protected $_url = 'https://cws.test.chockstone.com/cws';
	protected $_version = 1;
	protected $_revision = 3;
	
	protected $_connection = array(
		'domain' => '',
		'store-id' => '',
		'service-user' => '',
		'service-password' => '',
		'locale' => 'en_US'
	);
	
	function __construct($options = array()) {
		if (isset($options['url'])) {
			$this->_url = $options['url'];
			unset($options['url']);
		}
		
		$this->_connection = array_merge($this->_connection, $options);
	}
	
	public function request($method, $data) {
		$request = array(
			'request' => array(
				'@version' => $this->_version,
				'@revision' => $this->_revision,
				'@expirationDetail' => 'true',
				'connection' => $this->_connection,
				$method => $data
			)
		);
		
		$xml = Xml::build($request, array('return' => 'domdocument'));
		$xml->formatOutput = true;
		$xml = $xml->saveXML();
		
		$response = $this->_post($xml);
		return $this->_response($method, $response);
	}
	
	protected function _response($method, $response) {
		if (empty($response)) {
			return false;
		}
		
		debug($response);
		
		$response = Xml::toArray(Xml::build($response));		
		
		if (empty($response['response']['status'])) {
			debug('Unknown Error');
			return array('error' => array(
				'alert-name' => 'Unknown',
				'description' => 'An unknown error occurred.'
			));
		}
		
		$status = $response['response']['status'];
		if ($status['code'] == 'fail') {
			debug($status['alert-name'] . ': ' . $status['description']);
			return array('error' => $status);
		}
		
		return $response;
	}
	
	protected function _post($body) {
		debug($body);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		$data = curl_exec($ch);
		if ($data == false) {
			debug('Curl Error #' . curl_errno($ch) . ': ' . curl_error($ch));
		}
		curl_close($ch);
		
		return $data;
	}
	
	protected function _authorization($account) {
		if (isset($account['id'])) {
			return array('pin-authorization' => $account);
		}
		
		if (isset($account['expiration-date'])) {
			return array('credit-card-authorization' => $account);
		}
		
		return array('phone-number-authorization' => $account);
	}
	
	public function getAccountBalance($account) {
		$account = $this->_authorization($account);
		return $this->request('get-account-balance', array('account' => $account));
	}
	
	public function getUser($user_id) {
		return $this->request('get-user', array(
			'user' => array('id' => $user_id)
		));
	}
	
	public function createUser($user, $account = false) {
		if ($account) {
			$account = $this->_authorization($account);
			return $this->request('create-user', array(
				'account' => $account,
				'user' => $user
			));
		}
		
		return $this->request('create-user', array('user' => $user));
	}
	
}

function debug($value) {
	echo '<pre>';
	
	if (is_string($value)) {
		echo htmlentities($value);
	} else {
		var_dump($value);
	}

	echo '</pre>';
}