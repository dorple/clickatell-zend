<?php
/**
* @see Zend_Http_Client
*/
require_once('Zend/Http/Client.php');


/**
* @see TransportException
*/
require_once('Zend/Clickatell/Exception/TransportException.php');


/**
* @package Clickatell
*/
class Action {

	/**
	* API location
	* @const string
	*/
	const URI_API = 'http://api.clickatell.com/';


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
		
		$uriRequest = new Zend_Http_Client(self::URI_API.$uri.$data);		
		$uriRequest = $uriRequest->request();		

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