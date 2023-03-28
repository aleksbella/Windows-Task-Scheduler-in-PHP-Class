<?php
namespace AleksBella\Tools\AB;
/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.1.2
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/

class Tasks {
	const AB = 'SCHTASKS';
	private $cmd = '';
	private $force = true;
	private $sch_type = array('minute','daily','hourly','monthly','weekly','once','onstart','onlogon');
	private $type = array('change','create','delete','end','run','query');
	public function __construct(){
		if(is_bool($this->force)){
			$this->force = '/F';
		}
	}
	
	public function build($data){
			$data_str = '';
		try {
			if(!is_array($data))throw new Exception("Unable to process");
				foreach($data as $k => $v){
					$data_str .= '/' .strtoupper($k) . ' "' .$v.'" ';
				}

			return $data_str;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function get_data($data){
		$gd = '';
		if(is_array($data)){
			$gd .= implode(", ",$data);
		}
		return $gd;
	}
	public function query($type,$data){
		try {
			if(!is_array($data)) throw new \Exception('Invalid data');
			if(isset($data['sc']) && !in_array($data['sc'],$this->sch_type)) throw new \Exception('Invalid schedule! Use: ' . $this->get_data($this->sch_type));
			if(!in_array($type,$this->type)) throw new \Exception('Invalid schedule type! Use: ' . $this->get_data($this->type));
			
			if(array_key_exists('sc',$data) && $type == 'change') throw new \Exception("Schedule [sc] for change method is not required.");
			
			return $this->execute(self::AB .' /'.strtoupper($type).' '. $this->build($data) . ' ' . $this->overwrite($type));
		}catch(\Exception $e){
			return 'ERROR: '.$e->getMessage();
		}
	}
	public function overwrite($type){
		$no_force = array('change','query');
		$result = in_array($type,$no_force) ? null : $this->force;
		return $result;
	}
	public function execute($command){
		$process = shell_exec(trim($command));
		if($process){
			return $process;
		}else{
			return 'ERROR: ' . $command;
		}
	}
	public function notify($result){
		return strtok($result," ");
	}
}
