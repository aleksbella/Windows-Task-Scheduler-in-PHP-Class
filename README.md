# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

# How to use:

```
include_once "./includes/tasks.php";
$tj = new Tasks('domain\user','password');
```
  
  **Create:**   
  
	$tj->create($array);
	
> Example:

	$startdate = "04/01/2023"; //date('m/d/Y',strtotime(+1 week));
	
	$data = array(
		'sc' => 'monthly',
		'tn' => 'Aleks Schedule',
		'st' => '10:00:00',
		'sd' => date('m/d/Y',strtotime("+1 MONTH")),					
		'ed' => date('m/d/Y',strtotime("+7 MONTH")),					
		'tr' => 'c:\folder\myapp.exe'
	);
	$tj->create($data);

  **Update:**
  
  	$data = array(		
		'tn' => 'Aleks Schedule',
		'st' => '12:00:00',
		'tr' => 'c:\folder\new_myapp.exe'
	);
	
	echo  $tj->update($data);
	

Refer this link for other parameters and description: https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks-create

**Other:**
	
	remove($task) -> Remove selected task
	
	run($task) -> Force to run selected task
	
	query($task, $format = null) -> View selected task informaton
	
	queryAll() -> View all running task/schedule
	
	stop($task) -> Force to stop selected task
	
	execute($command) -> Execute other Windows Command
	
	

