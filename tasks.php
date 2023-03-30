<?php
namespace AleksBella\Tools\AB;
/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.2.2
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/
date_default_timezone_set('Asia/Manila');
class Tasks {
	const AB = 'SCHTASKS';
	private $force = true;
	private $sch_type = array('minute','daily','hourly','monthly','weekly','once','onstart','onlogon');
	private $type = array('change','create','delete','end','run','query');
	private $params = array('z','f');
	private $output_type = array('default', 'live');
	public function __construct($output_type = 'default'){
		try{
			if(!in_array($output_type, $this->output_type)) throw new \Exception("Invalid output type");
			if($this->force === true){
				$this->force = '/F';
			}
			$this->output_type = $output_type;			
		}catch(\Exception $e){
			die($e->getMessage());
		}
	}
	public function show_err($type,$message){
		return trigger_error($message,2);
	}
	public function build($data){
			$data_str = '';
			$z_param = '';
			try {
				if(!is_array($data))throw new \Exception("Unable to process data");
					if(array_key_exists('z',$data)){
						unset($data['z']);
						$z_param = '/Z /ET "' . date("H:i:s",strtotime("+20 MINUTE")).'"';
					}
				foreach($data as $k => $v){				
					$data_str .= '/' .strtoupper($k) . ' "' .$v.'" ';
				}
			return $data_str . $z_param;
		}catch(\Exception $e){
			return $e->getMessage();
		}
	}
	
	private function get_data($data){
		$gd = '';
		if(is_array($data)){
			$gd .= implode(", ",$data);
		}
		return $gd;
	}
	public function query($type,$data){
		try {
			if(!is_array($data)) throw new \Exception('Invalid array of data');
			if(isset($data['sc']) && !in_array($data['sc'],$this->sch_type)) throw new \Exception('Invalid schedule! Use: ' . $this->get_data($this->sch_type));
			if(!in_array($type,$this->type)) throw new \Exception('Invalid schedule type! Use: ' . $this->get_data($this->type));			
			if(array_key_exists('sc',$data) && $type == 'change') throw new \Exception("Schedule [sc] for change method is not required.");			
			return $this->execute(self::AB .' /'.strtoupper($type).' '. $this->build($data) . ' ' . $this->overwrite($type) .' ');
		}catch(\Exception $e){
			return 'ERROR: '.$e->getMessage();
		}
	}
	public function rawQuery($command = null){
		if(empty($command) || is_array($command)){
			return null;
		}
		return $this->execute($command);
		
	}
	public function overwrite($type){
		$no_force = array('change','query');
		$result = in_array($type,$no_force) ? null : $this->force;
		return $result;
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
	private function notify($result){
		$p = strtok($result," ");
		return $p === 'SUCCESS:' ? '' : 'ERROR: ' . $result;
	}
}
