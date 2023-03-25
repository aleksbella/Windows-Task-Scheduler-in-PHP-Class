# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

# How to use:
	
    include_once "./includes/tasks.php";
  	$tj = new Tasks('test.bat');
  
  **Create:**   
	echo $tj->create($type, $task, $time, $startdate = null);
	
	e.g.: 
	$startdate = "04/01/2023"; //date('m/d/Y',strtotime(+1 week));
	$tj->create('weekly', 'My Schedule', '12:00:00', $startdate);

  **Update:**
  
	echo  $tj->update($task, $time, $newpath = null);
	
	> $task = task name
	> $time = new time
	> $newpath = new executable full path

  
  **Remove:**
  
	echo  $tj->remove($task);

**Other Example**

*View Task Information:*
	
	echo query($task, $format = null);
	
	Default: $format = LIST (TABLE, LIST)

*Stop Selected Task:*
	
	echo $tj->stop('My Schedule');

*Force to run Selected Task:*
	
	echo $tj->run('My Schedule');

*Also:*

echo $tj->execute($command);

To Run and Execute your own command using shell.


