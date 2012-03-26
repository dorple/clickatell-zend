<?php
/**
* @see Action
*/
require_once('Zend/Clickatell/Action.php');


/**
* @package Clickatell
*/
class Batch extends Action {

	/**
	* Initialize SMS vars
	* @var string
	*/
	public $to;

	/**
	* @param string $template
	* @param array $values
	* @return array
	*/
	public function runBatch($template, $values) {

		if (!empty($this->to)) {
			//start batch

			$success = array();
			$batch_id = $this->startBatch($template);

			if (strpos($batch_id, "ID") !== false) {
				
				$batch_id = explode(":", $batch_id);
				$batch_id = trim($batch_id[1]);

				foreach($values as $field) {


					//send item
					$extra['batch_id'] = $batch_id;
					$extra['to'] = $this->to;

					foreach($field as $k => $v) {
						$extra[$k] = urlencode($v);
					}
					
					$success[] = $this->doRequest("http_batch/senditem", $extra);

				}				

				$this->endBatch($batch_id); 

				return $success;
			}
			else {
				throw new TransportException(__CLASS__.": ".$batch_id);	
			}	
		}	
		else {
			throw new TransportException(__CLASS__.": to value not set");	
		}	
	}
	
	/**
	* @param string $template
	* @return string
	*/
	private function startBatch($template) {

		$extra['template'] = urlencode($template);

		$batch_id = $this->doRequest("http_batch/startbatch", $extra);

		return $batch_id;
	}


	/**
	* @param string $batch_id
	* @return string
	*/
	private function endBatch($batch_id) {

		$extra['batch_id'] = urlencode($batch_id);

		$batch_id = $this->doRequest("http_batch/endbatch", $extra);

		return $batch_id;
	}

	/**
	* @param string $template
	* @param array $values
	* @return array
	*/
	public function simBatch($template, $values) {

		$return = array();

		foreach($values as $field) {
			
			$pos = sizeof($return);
			$return[$pos] = $template;

			foreach($field as $k => $v) {

				$return[$pos] = str_replace("#".$k."#", $v, $return[$pos]);

			}

		}

		return $return;

	}

}
?>