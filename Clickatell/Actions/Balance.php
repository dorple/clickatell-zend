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
	* @return string
	*/
	public function getCredits() {

		return $this->doRequest("http/getbalance");
		
	}

	public function hasCredits() {

		$response = $this->doRequest("http/getbalance");

		if ($response > 0) {
			return true;
		}
		else {
			return false;
		}
		
	}

}

?>