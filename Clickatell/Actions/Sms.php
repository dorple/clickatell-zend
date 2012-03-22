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
	* Transport Protocol
	* @const string
	*/ 
	const TRANSPORT_SMS = 1;

	/**
	* Initialize SMS vars
	* @var string
	*/
	public $to, $message;


	/**
	* @return string
	*/
	public function send() {

		if ($this->to && $this->message) {

			//init extra
			$extra['to'] = $this->to;
			$extra['text'] = urlencode($this->message);

			$uriRequest = new Clicaktell_Request('http/sendmsg', $this->credentials, $extra);

			return $this->handleResponse($uriRequest);
		}
		else {
			throw new TransportException(__CLASS__.': invalid send data');	
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
}
?>