<?php
/**
* @see Action
*/
require_once('Zend/Clickatell/Action.php');

/**
* @package Clickatell
*/

class Sms extends Action {

	/**
	* Initialize SMS vars
	* @var string
	*/
	public $to, $message;

	/**
	* Initialize Transport var
	* @var int
	*/
	private $transport;

	/**
	* @param array $credentials
	* @param int $transport
	*/
	public function __construct($credentials, $transport = Clickatell::TRANSPORT_SMS) {

		if (!empty($credentials)) {
			$this->credentials = $credentials;
			$this->transport = $transport;
		}
		else {
			throw new TransportException(get_class($this).': invalid credentials array supplied');
		}

	}

	/**
	* @return string
	*/
	public function send() {
		if ($this->transport) {

			if ($this->to && $this->message) {
				
				//init extra
				$extra['to'] = $this->to;
				$extra['text'] = urlencode($this->message);

				switch($this->transport) {
					case Clickatell::TRANSPORT_SMS:

						$uriRequest = new Clicaktell_Request('http/sendmsg', array_merge($this->credentials, $extra));

						return $this->handleResponse($uriRequest);

						break;

					case Clickatell::TRANSPORT_EMAIL:
						break;

					case Clickatell::TRANSPORT_XML:
						
						$xmlPacket['data'] = urlencode($this->createXml($extra));
						$uriRequest = new Clicaktell_Request('xml/xml', $xmlPacket);

						return $this->handleResponse($uriRequest);

						break;

					default :
						throw new TransportException(__CLASS__.': transport method not recognized');

				}

			}
			else {
				throw new TransportException(__CLASS__.': invalid send data');
			}
			/*
			
			*/

		}
		else {
			throw new TransportException(__CLASS__.": transport protocol not set");
		}
	}

	/**
	* @param string $msgId
	* @return string
	*/
	public function retrieve($msgId) {

		if ($msgId) {

			//init extra
			$extra['apimsgid'] = $msgId;

			$uriRequest = new Clicaktell_Request('http/querymsg', $this->credentials, $extra);

			return $this->handleResponse($uriRequest);

		}
		else {
			throw new TransportException(__CLASS__.': no msg id specified');
		}
			
	}

	/**
	* @param array $msgId
	* @return string
	*/
	private function createXml($extra) {

		if ($this->credentials) {

			$packet .= "<clickAPI>";
			$packet .= "<sendMsg>";

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

			$packet .= "</sendMsg>";
			$packet .= "</clickAPI>";

			return $packet;

		}
		else {
			throw new TransportException(__CLASS__.': cannot create xml packet');
		}

	}
}
?>