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
	* Initialize Transport var
	* @var int
	*/
	public $transport;

	/**
	* @param array $credentials
	*/
	public function __construct($credentials) {

		if (empty($this->nameSpace)) {
			throw new TransportException(get_class($this).': no namespace defined');
		}

		if (!empty($credentials)) {
			$this->credentials = $credentials;
			$this->transport = Clickatell::$useTransport;
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


	public function doRequest($call_namespace, $packet = array()) {
		if ($this->transport) {

			$uri = "";
			$data = "";

			switch($this->transport) {
				case Clickatell::TRANSPORT_SMS:

					$uri = $call_namespace[Clickatell::TRANSPORT_SMS];
					$data = $this->genQueryString($packet);					
					break;

				case Clickatell::TRANSPORT_EMAIL:
					break;

				case Clickatell::TRANSPORT_XML:

					$uri = 'xml/xml';
					$data = $this->createXml($call_namespace[Clickatell::TRANSPORT_XML], $packet);
					break;

				default :
					throw new TransportException(__CLASS__.': transport method not recognized');

			}

			$uriRequest = new Clicaktell_Request($uri, $data);

			return $this->handleResponse($uriRequest);

		}
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


	/**
	* @param array $msgId
	* @return string
	*/
	private function createXml($call, $extra) {

		if ($this->credentials) {

			$packet .= "<clickAPI>";
			$packet .= "<".$call.">";

			//add credentials, assumed the credentials packet has correct data
			$packet .= "<api_id>".$this->credentials['api_id']."</api_id>";
			$packet .= "<user>".$this->credentials['user']."</user>";
			$packet .= "<password>".$this->credentials['password']."</password>";

			//build extra
			if (!empty($extra)) {
				foreach($extra as $k => $v) {
					$packet .= "<".$k.">".$v."</".$k.">";
				}
			}

			$packet .= "</".$call.">";
			$packet .= "</clickAPI>";

			return '?data='.urlencode($packet);

		}
		else {
			throw new TransportException(__CLASS__.': cannot create xml packet');
		}

	}

}

?>