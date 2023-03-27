<?php
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
	private $fullpath = '';
	private $force = true;
	private $username = '';
	private $password = '';
	private $account = array();
	private $command_str = '';
	private $task_type = array('minutes','hourly','daily','weekly','monthly');
		
	public function __construct($username = null, $password = null){
		
		if(!empty($username)){
			$this->username = '/RU "' .$username.'"';
		}
		if(!empty($password) && !empty($username)){
			$this->password = '/RP "' . $password.'"';
		}
		
		$this->account = array($this->username,$this->password);
		
		if($this->force){
			$this->force = '/F';
		}
	}
	public function create($data = array()){
		try {
			if(!isset($data['sc'])) throw new Exception("Schedule type is empty");
			if(isset($data['sc']) && !in_array($data['sc'],$this->task_type)) throw new Exception("Invalid schedule type");			
			if(!isset($data['tn'])) throw new Exception("No task name");
			if(!isset($data['tr'])) throw new Exception("No task to run");			
			$this->command_str = 'SCHTASKS /CREATE' . $this->builder($data).' '.$this->force;		
			return  $this->execute($this->command_str);
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function builder($mo){
		//tr ru tn
		$data = [];
		$cmd = '';
		if(is_array($mo)){
			foreach($mo as $key => $val){
				if(!empty($key)){
					array_push($data,' /'.strtoupper($key).' "'. $val.'"');
				}
			}
		}
		foreach($data as $result){
			$cmd .= $result;
		}		
		return trim(array_values($this->account)[0] . array_values($this->account)[1]) . $cmd;
	}
	
	public function update($data){
		try{
			if(array_key_exists('sc',$data)) throw new Exception("Schedule [sc] for update is not allowed");
			$cmd = 'SCHTASKS /CHANGE '.$this->builder($data);
			return $this->execute($cmd);
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	public function remove($task){
		$cmd = 'SCHTASKS /DELETE /TN "'.$task.'" /F';
		return $this->execute($cmd);
	}
	public function run($task){
		$cmd = 'SCHTASKS /RUN /TN "'.$task.'"';
		return $this->execute($cmd);
	}
	public function query($task, $format = null){
		$fo = $format == null ? 'LIST' : $format;
		$cmd = 'SCHTASKS /QUERY /FO '.$fo.' /V /TN "'.$task.'"';
		return $this->execute($cmd);
	}
	public function queryAll(){
		$cmd = 'SCHTASKS /QUERY /FO LIST /V';
		return $this->execute($cmd);
	}
	
	public function stop($task){
		$cmd = 'SCHTASKS /END /TN "'.$task.'"';
		return $this->execute($cmd);
	}
	public function execute($command){
		$result = shell_exec(trim($command));
		if($result){
			return $result;
		}else{
			return 'ERROR: Unable to execute command: ' . $this->lastCmd($command) . ' Tips: Check all parameters and its spelling and or the user privileges.';
		}
	}
	
	protected function whoami(){
		return $this->execute('whoami');
	}
	public function lastCmd($cmd){
		return '<pre>'.$this->command_str = $cmd.'</pre>';
	}
}
