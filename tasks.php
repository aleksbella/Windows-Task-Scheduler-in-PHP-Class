<?php
class Tasks {
	private $torun;
	private $execute;
	
	function __construct($torun) {
		$this->torun = $torun;
  }
  public function create($task_type,$task_name,$tym){
	 try {		
	 	if(empty($task_type)) throw new Exception("Type is empty");
		if(empty($task_name)) throw new Exception("Name is empty");
		if(empty($tym)) throw new Exception("Time is empty");

	  switch($task_type){
		  default:	
				case 'hourly':
				$setcmd = 'SCHTASKS /CREATE /SC HOURLY /TN "'.$task_name.'" /TR "'.$this->torun.'" /ST '.$tym;
				break;
				
				case 'daily':
				$setcmd = 'SCHTASKS /CREATE /SC DAILY /TN "'.$task_name.'" /TR "'.$this->torun.'" /ST '.$tym;
				break;

				case 'monthly':
				$setcmd = 'SCHTASKS /CREATE /SC MONTHLY /D 15 /TN "'.$task_name.'" /TR "'.$this->torun.'" /ST '.$tym;
				break;
				
				case 'weekly':
				$setcmd = 'SCHTASKS /CREATE /SC WEEKLY /D SUN /TN "'.$task_name.'" /TR "'.$this->torun.'" /ST '.$tym;
				break;
	  }
	  	 return $this->execute($setcmd);
		  
		  
	 }catch(Exception $e){
		 return $e->getMessage();
	 }
  }
  public function change($task_name, $tym){
	  $se = 'SCHTASKS /CHANGE /TN "'.$task_name.'" /ST '. $tym;
	  return $this->execute($se);
  }
  public function remove($task_name){
	  return $this->execute('SCHTASKS /delete /TN "'.$task_name.'" /f');
  }
  public function execute($cmd){
	  return shell_exec(trim($cmd));
  }
}