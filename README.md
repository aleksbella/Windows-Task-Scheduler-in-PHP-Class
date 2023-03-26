# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

# How to use:

```
include_once "./includes/tasks.php";
$tj = new Tasks('c:\test\test.bat','domain\user','password');
```

  
  **Create:**   
  
	$tj->create($type, $task, $time, $startdate = null);
	
> Example:

	$startdate = "04/01/2023"; //date('m/d/Y',strtotime(+1 week));
	
	$tj->create('weekly', 'My Schedule', '12:00:00', $startdate);

  **Update:**
  
	echo  $tj->update($task, $time, $newpath = null);
	
	> $task = task name
	> $time = new time
	> $newpath = new executable full path

 **Other:**

	update($task, $time, $newpath = null) -> Update selected task
	
	remove($task) -> Remove selected task
	
	run($task) -> Force to run selected task
	
	query($task, $format = null) -> View selected task informaton
	
	queryAll() -> View all running task/schedule
	
	stop($task) -> Force to stop selected task
	
	execute($command) -> Execute other Windows Command
	
	

