# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

# How to use:

```
include_once "./includes/tasks.php";
$ab = new Tasks();

or

$ab = new Tasks('domain\user','password');
```
  
  **Create:**   
  
	$data = array(
		'sc' => 'monthly',		//'minutes','hourly','daily','weekly','monthly'
		'tn' => 'Aleks Schedule',
		'tr' => 'c:\folder\myapp.exe'	//full path
	);
	$ab->create($data);

  **Update:**
  
  	$data = array(		
		'tn' => 'Aleks Schedule',
		'st' => '12:00:00',
		'tr' => 'c:\folder\new_myapp.exe'
	);
	
	echo  $ab->update($data);
	

Refer this link for other parameters and description: https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks-create

**Other method:**
	
	$ab->remove($task) -> Remove selected task
	
	$ab->run($task) -> Force to run selected task
	
	$ab->query($task, $format = null) -> View selected task informaton
	
	$ab->queryAll() -> View all running task/schedule
	
	$ab->stop($task) -> Force to stop selected task
	
	$ab->execute($command) -> Execute other Windows Command
	
	

