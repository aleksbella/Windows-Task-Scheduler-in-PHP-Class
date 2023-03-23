# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

# How to use:
	
 
    include_once "./includes/tasks.php";
  	$tj = new Tasks('test.bat');
 
  
  **Create:**
  
  //hourly, daily, weekly and monthly only
  
	echo $tj->create('hourly','my task','14:39:00');

  
  **Change or Update:**

	echo $tj->change('my task','15:00:00');

  
  **Remove/Deleting:**

	echo $tj->remove('my task');

