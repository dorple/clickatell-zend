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
	public function __construct($uri, $credentials, $extra = array()) {

		parent::__construct(self::URI_API.$uri.$this->genQueryString($credentials, $extra));

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

	/**
	* @param array $credentials
	* @param array $extra
	* @return string
	*/
	private function genQueryString($credentials, $extra) {

		$string = "?";

		if (!empty($credentials['apiId']) && !empty($credentials['apiUser']) && !empty($credentials['apiPass'])) {
			$string .= "api_id=".$credentials['apiId'];
			$string .= "&user=".$credentials['apiUser'];
			$string .= "&password=".$credentials['apiPass'];

			if (!empty($extra)) {
				foreach($extra as $k => $v) {
					$string .= "&".$k."=".$v;
				}
			}
		}
		else {
			throw new RequestException(__CLASS__.': Invalid Credential Object Supplied');
		}

		return $string;
	}


}

?>