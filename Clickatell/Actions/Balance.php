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
	public function get() {

		$uriRequest = new Clicaktell_Request('http/getbalance', $this->credentials);
		
		return $this->handleResponse($uriRequest);
		
	}

}

?>