<?php
/**
* @see Action
*/
require_once('Zend/Clickatell/Action.php');


/**
* @package Clickatell
*/
class Coverage extends Action {


	/**
	* @param string $number
	* @return string
	*/
	public function checkCoverage($number) {

		//set extra
		$extra['msisdn'] = $number;

		return $this->doRequest('utils/routeCoverage.php', $extra);
		
	}

}

?>