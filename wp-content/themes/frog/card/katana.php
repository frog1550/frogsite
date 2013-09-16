<?php

class Katana {
	protected $_url = 'https://api.test.chockstone.com/katana/v1/domains/%s/chains/%s/';
	
	protected $_options = array(
 		'key' => 'ch98ecuwa9af',
	 	'domain' => 'hps',
	 	'chain' => '111217050252'
	);
	
	function __construct($options = array()) {
		$this->_options = array_merge($this->_options, $options);
		$this->_url = sprintf($this->_url, $this->_options['domain'], $this->_options['chain']);
	}
	
	public function request($endpoint, $auth, $data = array()) {
		// Setup request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_url . $endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $this->_options['key']));
		curl_setopt($ch, CURLOPT_USERPWD, $auth['username'] . ':' . $auth['password']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		if (!empty($data)) {
			// POST / PUT / DELETE
		}
		
		$data = curl_exec($ch);
		if ($data == false) {
			debug('Curl Error #' . curl_errno($ch) . ': ' . curl_error($ch));
		}
		curl_close($ch);
		
		return $this->_response($endpoint, $data);
	}
	
	protected function _response($endpoint, $response) {
		if (empty($response)) {
			return false;
		}
		
		$response = json_decode($response, true);
		
		if (isset($response['code'])) {
			$response = array('error' => $response);
		}
		
		debug($response);
		
		return $response;
	}
	
	public function getAccount($auth) {
		return $this->request('account', $auth);
	}
	
}

function debug($value) {
	return;
	
	echo '<pre>';
	
	if (is_string($value)) {
		echo htmlentities($value);
	} else {
		var_dump($value);
	}

	echo '</pre>';
}