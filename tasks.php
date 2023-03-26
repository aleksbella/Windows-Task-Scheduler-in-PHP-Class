<?php
/*
//===============================================================
	* Name:	PHP Windows Task Scheduler
	* Author: Aleks Bella
	* Homepage: https://github.com/aleksbella
	* Dated: 3/25/23
	* Version: 0.1.2
	* Note: Use with your own risk
//===============================================================
*/

class Tasks {
	private $fullpath;
	private $task_type = array('minutes','hourly','daily','weekly','monthly','once','onstart','onlogon');
	private $username;
	private $password;
	private $account = array();
	private $force = true;
	
	public function __construct($fullpath, $username = null, $password = null){
		$this->fullpath = $fullpath;
		
		if(!empty($username)){
			$this->username = '/RU ' .$username;
		}
		if(!empty($password) && !empty($username)){
			$this->password = '/RP ' . $password;
		}
		
		$this->account = array(
			'username' => is_null($this->username) ? '/RU ' . $this->whoami() : $this->username,
			'password' => $this->password
		);
			
	}
	public function create($type, $task, $time, $startdate = null){
			$start = $startdate == null ? date('m/d/Y') : date('m/d/Y',strtotime($startdate));
			$command = '';
			$overwrite = $this->force == true ? '/F' : '';
			$case_str = '/SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'" ' . $overwrite;
			$rurp = trim($this->account['username'].' '.$this->account['password']);
		try {
			if(!in_array($type,$this->task_type)) throw new Exception("Invalid task type");
			if(empty($task)) throw new Exception("No name added");
			if(empty($time)) throw new Exception("No time added");
			
			switch($type){
				case 'minutes':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC MINUTE /MO 5 ' . $case_str;
				break;
				
				case 'hourly':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC HOURLY ' . $case_str;
				break;
				
				default:
				case 'daily':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC DAILY ' . $case_str;
				break;

				case 'monthly':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC MONTHLY /D 15 ' . $case_str;
				break;
				
				case 'weekly':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC WEEKLY /D SUN /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST '.$time;
				break;
				
				case 'once':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC ONCE ' . $case_str;
				break;
				
				case 'onstart':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC ONSTART ' . $case_str;
				break;
				
				case 'onlogon':
				$command = 'SCHTASKS /CREATE '.$rurp.' /SC ONLOGON' . $case_str;
				break;
			}
				return  $this->execute($command);
		}catch(Exception $e){
				return $e->getMessage();
		}
	}
	
	public function update($task, $time, $newpath = null){
		$path = $newpath == null ? $this->fullpath : $newpath;
		$cmd = 'SCHTASKS /CHANGE '.trim($this->account['username'].' '.$this->account['password']).' /TN "'.$task.'" /TR "'.$path.'" /ST "'.$time.'"';
		return $this->execute($cmd);
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
		return $result == TRUE ? $result : 'ERROR: Unable to execute command ' . $command;
	}
	protected function whoami(){
		return $this->execute('whoami');
	}
}
