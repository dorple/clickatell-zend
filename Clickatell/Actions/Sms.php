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
	* Define Action Namespace
	* @var array
	*/
	public $nameSpace = array(Clickatell::TRANSPORT_SMS => 'http/sendmsg',
							   Clickatell::TRANSPORT_XML => 'sendMsg');


	/**
	* Initialize SMS vars
	* @var string
	*/
	public $to, $message;

	/**
	* @return string
	*/
	public function send() {
		if ($this->transport) {

			if ($this->to && $this->message) {
				
				//init extra
				$extra['to'] = $this->to;
				$extra['text'] = urlencode($this->message);

				return $this->doRequest($this->nameSpace, $extra);

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

	
}
?>