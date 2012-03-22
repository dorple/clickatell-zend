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

}

?>