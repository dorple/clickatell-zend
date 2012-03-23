<?php
/**
* @see Zend_Http_Client
*/
require_once('Zend/Http/Client.php');
/**
* @see RequestException
*/
require_once('Zend/Clickatell/Exception/RequestException.php');

/**
* @package Clickatell
*/
class Clicaktell_Request extends Zend_Http_Client {
	
	/**
	* API location
	* @const string
	*/
	const URI_API = 'http://api.clickatell.com/';

	/**
	* Initialize Request Vars
	*/
	private $requestObj, $responseArr, $body;

	/**
	* @param string $uri
	* @param array $credentials
	* @param array $extra
	*/
	public function __construct($uri, $packet) {

		$uriConstruct = self::URI_API.$uri;

		if ($packet) {
			$uriConstruct .= $packet;
		}

		parent::__construct($uriConstruct);

		$this->request();

	}

	public function request() {

		$this->requestObj = parent::request();

		$this->body = $this->requestObj->getBody();
		
	}

	/**
	* @return string
	*/
	public function getBody() {
		return $this->body;
	}

	


}

?>