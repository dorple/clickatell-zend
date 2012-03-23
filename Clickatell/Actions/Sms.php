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
	* @return string
	*/
	public function send() {

		if ($this->to && $this->message) {
				
			//init extra
			$extra['to'] = $this->to;
			$extra['text'] = urlencode($this->message);

			return $this->doRequest("http/sendmsg", $extra);
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
			
			return $this->doRequest("http/querymsg", $extra);

		}
		else {
			throw new TransportException(__CLASS__.': no msg id specified');
		}
			
	}

	
}
?>