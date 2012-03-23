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
	* Define Action Namespace
	* @var array
	*/
	public $nameSpace = array(Clickatell::TRANSPORT_SMS => 'utils/routeCoverage.php',
							   Clickatell::TRANSPORT_XML => 'routeCoverage');

	/**
	* @param string $number
	* @return string
	*/
	public function checkCoverage($number) {

		//set extra
		$extra['msisdn'] = $number;

		return $this->doRequest($this->nameSpace, $extra);
		
	}

}

?>