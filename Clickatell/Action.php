<?php
/**
* @see Clickatell_Request
*/
require_once('Zend/Clickatell/Request.php');


/**
* @see TransportException
*/
require_once('Zend/Clickatell/Exception/TransportException.php');


/**
* @package Clickatell
*/
class Action {

	/**
	* Initialize Credentials Object
	* @var array
	*/
	public $credentials;


	/**
	* @param array $credentials
	*/
	public function __construct($credentials) {

		if (!empty($credentials)) {
			$this->credentials = $credentials;
		}
		else {
			throw new TransportException(get_class($this).': invalid credentials array supplied');
		}

	}

	/**
	* @param Zend_Http_Response $response
	* @return string
	*/
	public function handleResponse($response) {

		return $response->getBody();

	}


	public function doRequest ($call_namespace, $packet = array()) {



		if (empty($call_namespace)) {
			throw new TransportException(get_class($this).': no namespace defined');
		}

		$uri = $call_namespace;
		$data = $this->genQueryString($packet);		

		$uriRequest = new Clickatell_Request($uri, $data);				

		return $this->handleResponse($uriRequest);
	}


	/**
	* @param array $credentials
	* @param array $extra
	* @return string
	*/
	private function genQueryString($packet) {

		$packet = array_merge($packet, $this->credentials);

		if ($packet) {

			if (!empty($packet)) {
				foreach($packet as $k => $v) {
					$string .= "&".$k."=".$v;
				}
			}

			return "?".trim($string, "&");

		}
		else {
			return "";
		}
	}

}

?>