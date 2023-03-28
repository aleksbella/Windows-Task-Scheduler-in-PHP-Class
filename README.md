# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP

## Usage:

```
include_once "./includes/tasks.php";
use AleksBella\Tools\AB\Tasks;
$ab = new Tasks();
```
  
## Create:
  
	$data = array(
		'sc' => 'monthly',		//'minute','hourly','daily','weekly','monthly', etc...
		'tn' => 'Aleks Schedule',
		'tr' => 'c:\folder\myapp.exe'	//full path
	);
	$ab->query('create',$data);
---
## Change or Update:
  
	$data = array(		
		'tn' => 'Aleks Schedule',
		'tr' => 'c:\folder\new-myapp.exe',	//full path
		'st' => '15:20:00'
	);
	$ab->query('change',$data);

>**Note**: Scheduletype [sc] could NOT be change, returns error if added.
	
---

## Other values:
```
$data['sc'] = 'scheduletype';		//The schedule type ('minute','hourly','daily','weekly','monthly', etc...)
$data['tn'] = 'taskname';		//Name for the task.
$data['tr'] = 'Taskrun';		//Program or command that the task runs.
$data['s'] = 'computer';		//Name or IP address of a remote computer (with or without backslashes). The default is the local computer.
$data['u'] = 'domain';			//Runs this command with the permissions of the specified user account. 
$data['p'] = 'password';		//Password of the user account specified in the /u parameter. 
$data['ru'] = 'domain\user|system';	//Runs the task with permissions of the specified user account.
$data['rp'] = 'password';		//Specifies the password for the existing user account, or the user account specified by the /ru parameter.
$data['mo'] = 'modifiers';		//How often the task runs within its schedule type e.g. 'minute','daily','hourly','monthly','weekly','once', etc...
$data['d'] = 'day';			//Weekly [MON - SUN...], Monthly [runs weekly each month by providing a value of FIRST, SECOND, THIRD, FOURTH, LAST].
$data['m'] = 'month';			//The valid options include JAN - DEC and * (every month).
$data['i'] = 'Idletime';		//How many minutes the computer is idle before the task starts. Valid only with an ONIDLE schedule.
$data['st'] = 'Starttime';		//Start time for the task, using the 24-hour time format.
$data['ri'] = 'interval';		//Repetition interval for the scheduled task.
$data['rl'] = 'level';			//Run Level for the job. LIMITED is the default value, HIGHEST for superuser accounts.
$data['et'] = 'Endtime';		//Time of day that a minute or hourly task schedule ends in 24 hour format.
$data['du'] = 'duration';		//Maximum length of time for a minute or hourly schedule in 24-hour format. Works with MINUTE & HOURLY schedule.
$data['sd'] = 'Startdate';		//Date on which the task schedule starts. 
$data['ed'] = 'Enddate';		//Date on which the schedule ends. It isn't valid in a ONCE, ONSTART, ONLOGON, or ONIDLE schedule.
```	

---

>**Note**: For other parameters and complete description: [Microsoft Homepage](https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks-create)

---

## Parameters:
```
$ab->query('delete',['tn'=>'My Schedule']);	//Remove selected schedule

$ab->query('end',['tn'=>'My Schedule']);	//Stop running schedule

$ab->query('run',['tn'=>'My Schedule']);	//Run selected schedule
```
