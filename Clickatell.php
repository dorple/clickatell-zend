<?php
/**
* @see Clickatell_Request
*/
require_once('Zend/Clickatell/Request.php');

/**
* @see Sms
*/
require_once('Zend/Clickatell/Actions/Sms.php');

/**
* @see Coverage
*/
require_once('Zend/Clickatell/Actions/Coverage.php');

/**
* @see Balance
*/
require_once('Zend/Clickatell/Actions/Balance.php');


/**
* @package Clickatell
*/
class Clickatell {

	/**
	* Transport Constants
	* @const int
	*/
	const TRANSPORT_SMS = 1;
	const TRANSPORT_EMAIL = 2;
	const TRANSPORT_XML = 3;

	/**
	* Credentials array for api requests
	* @var array
	*/
	private $credentials 	= "";

	/**
	* Wheter or not the client has credits to send with
	* @var bool
	*/
	private $gotCredits 	= true; //assumption


	/**
	* @param int $apiId
	* @param string $apiUser
	* @param string $apiUser
	*/
	public function __construct($apiId, $apiUser, $apiPass) {

		$this->credentials['api_id'] =$apiId;
		$this->credentials['user'] =$apiUser;
		$this->credentials['password'] =$apiPass;


		$balance = new Balance($this->credentials);

		if ($balance->get() > 0) 
		{
			$this->gotCredits = true;
		}
		else 
		{
			$this->gotCredits = false;	
		}

	}	

	/**
	* @param string $to
	* @param string $message
	* @return string
	*/
	public function sendMsg($to, $message, $transport = self::TRANSPORT_SMS) {

		$this->gotCredits = true;
		if ($this->gotCredits) {

			$sms = new Sms($this->credentials, $transport);
			$sms->to = $to;
			$sms->message = $message;

			return $sms->send();

		}
		else {
			return 'sorry, you dont have any credits left';
		}
	}

	/**
	* @param string $msgId
	* @return string
	*/
	public function messageDetails($msgId) {

		$sms = new Sms($this->credentials);

		return $sms->retrieve($msgId);

	}

	/**
	* @param string $to
	* @return string
	*/
	public function checkCoverage($to) {

		$coverage = new Coverage($this->credentials);
		return $coverage->checkCoverage($to);

	}
	


}



?>