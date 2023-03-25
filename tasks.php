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
	# Format: create($type, $task, $time, $startdate = null);
	# type: "hourly"
	# task: "My Schedule - Preferred name"
	# $time: "12:00:00";
	# $startdate: "03/25/2023";
//===============================================================	
*/

class Tasks {
	private $fullpath;
	private $task_name = array('minutes','hourly','daily','weekly','monthly','once','onstart','onlogon');
	public function __construct($fullpath){
		$this->fullpath = $fullpath;
	}
	public function create($type, $task, $time, $startdate = null){
			$start = $startdate == null ? date('m/d/Y') : $startdate;
			$command = '';
		try {
			if(!in_array($type,$this->task_name)) throw new Exception("Invalid task type");
			if(empty($task)) throw new Exception("No name added");
			if(empty($time)) throw new Exception("No time added");
			
			switch($type){
				case 'minutes':
				$command = 'SCHTASKS /CREATE /SC MINUTE /MO 5 /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;
				
				case 'hourly':
				$command = 'SCHTASKS /CREATE /SC HOURLY /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;
				
				default:
				case 'daily':
				$command = 'SCHTASKS /CREATE /SC DAILY /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;

				case 'monthly':
				$command = 'SCHTASKS /CREATE /SC MONTHLY /D 15 /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;
				
				case 'weekly':
				$command = 'SCHTASKS /CREATE /SC WEEKLY /D SUN /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST '.$time;
				break;
				
				case 'once':
				$command = 'SCHTASKS /CREATE /SC ONCE /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;
				
				case 'onstart':
				$command = 'SCHTASKS /CREATE /SC ONSTART /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;
				
				case 'onlogon':
				$command = 'SCHTASKS /CREATE /SC ONLOGON /SD "'.$start.'" /TN "'.$task.'" /TR "'.$this->fullpath.'" /ST "'.$time.'"';
				break;				
			}
				return  $this->execute($command);
		}catch(Exception $e){
				return $e->getMessage();
		}
	}
	public function update($task, $time, $newpath = null){
		$path = $newpath == null ? $this->fullpath : $newpath;
		$cmd = 'SCHTASKS /change /TN "'.$task.'" /TR "'.$path.'" /ST "'.$time.'"';
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
	public function query($task){
		$cmd = 'SCHTASKS /QUERY /FO LIST /v /TN "'.$task.'"';
		return $this->execute($cmd);
	}
	public function stop($task){
		$cmd = 'SCHTASKS /END /TN "'.$task.'"';
		return $this->execute($cmd);
	}
	public function execute($command){
		return shell_exec(trim($command));
	}
}
//**Uncomment below for Example or Testing**
//$tj = new Tasks('c:\test\test.bat');
//echo $tj->create('hourly','My Schedule','01:45:00','04/01/2023');
//echo $tj->remove('oncess only');
//echo '<pre>'.$tj->query('My Schedule').'</pre>';
//echo $tj->stop('My Schedule');
//echo $tj->run('My Schedule');
