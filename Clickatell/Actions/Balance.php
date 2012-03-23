<?php
/**
* @see Action
*/
require_once('Zend/Clickatell/Action.php');

/**
* @package Clickatell
*/
class Balance extends Action {

	/**
	* Define Action Namespace
	* @var array
	*/
	public $nameSpace = array(Clickatell::TRANSPORT_SMS => 'http/getbalance',
							   Clickatell::TRANSPORT_XML => 'getBalance');


	/**
	* @return string
	*/
	public function getCredits() {

		return $this->doRequest($this->nameSpace);
		
	}

	public function hasCredits() {

		$response = $this->doRequest($this->nameSpace);

		if ($response > 0) {
			return true;
		}
		else {
			return false;
		}
		
	}

}

?>