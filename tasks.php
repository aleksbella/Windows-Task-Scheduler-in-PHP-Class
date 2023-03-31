<?php
namespace AleksBella\Scheduler;
/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.3.0
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/
date_default_timezone_set('Asia/Manila');
class Tasks {
	const AB = 'SCHTASKS';
	private $sch_type = array('minute','daily','hourly','monthly','weekly','once','onstart','onlogon');
	private $type = array('change','create','delete','end','run','query');
	private $output_type = array('default', 'live');
	public function __construct($output_type = 'default'){
		try{
			if(!in_array($output_type, $this->output_type)) throw new \Exception("Invalid output type");
			$this->output_type = $output_type;			
		}catch(\Exception $e){
			die($e->getMessage());
		}
	}
		
	private function get_data($data){
		$gd = '';
		if(is_array($data)){
			$gd .= implode(", ",$data);
		}
		return $gd;
	}
	public function rawquery($type,$data){
		if(empty($command) || is_array($command)){
			return null;
		}
		return $this->execute($command);
	}
	
	public function schedule($type, $data){
		$single_key = '';
		$with_value = '';
		try {
			if(!is_array($data)) throw new \Exception('Invalid data');			
			if(isset($data['sc']) && !in_array($data['sc'],$this->sch_type)) throw new \Exception('Invalid schedule! Use: ' . $this->get_data($this->sch_type));			
						
			foreach($data as $k => $v){
				if(is_int($k)){
					$single_key .= ' /'.strtoupper($v) . ' ';
				}else{
					$with_value .= ' /' .strtoupper($k) . ' "' . $v.'"';
				}
			}
			$command = self::AB .' /'.strtoupper($type). $with_value . $single_key;
			return $this->execute($command);
		}catch(\Exception $e){
			return $e->getMessage();
		}
	}
	
	public function execute($command){
		switch($this->output_type){
			default:
			case 'default':			
			$process = shell_exec(trim($command).' 2>&1');
			return $process;
			break;
			
			case 'live':
				$handle = popen($command ."2>&1", 'r');
				$live_output     = "";
				$complete_output = "";
				$result = "";
				while (!feof($handle)){
					$live_output     = fread($handle, 4096);
					$complete_output = $complete_output . $live_output;
					$result .= $live_output;
					@ flush();
				}
				pclose($handle);
				return $result;
			break;
			
		}
	}	
}
