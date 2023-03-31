# Windows-Task-Scheduler-in-PHP
A basic Windows Task Scheduler in PHP. Create a windows task schedule without jumping into the system.

---
## Table of Contents

 - [Installation](#installation)
 - [Usage/Examples](#usageexamples)
 - [Create](#create)
 - [Change or to update](#change-or-to-update)
 - [Other values](#other-values)
 - [Parameters](#parameters)
 - [Contributing](#contributing)

## Installation

```php
include_once "./includes/tasks.php";
use AleksBella\Scheduler\Tasks;
$ab = new Tasks();
```

## Usage/Examples

### Create
 ```php
	$data = array(
		'sc' => 'monthly',		//'minute','hourly','daily','weekly','monthly', etc...
		'tn' => 'My Schedule',		//Task name
		'tr' => 'c:\folder\myapp.exe',	//full path
		'f'				////Specifies to create the task and suppress warnings if the specified task already exists.
	);
	$ab->schedule('create',$data);
```
---
### Change or to update
 ```php
	$data = array(		
		'tn' => 'Aleks Schedule',		//Task name
		'tr' => 'c:\folder\new-myapp.exe',	//Full path
		'st' => '15:20:00'			//Start time for the task
	);
	$ab->schedule('change',$data);
```

>**Note**: Scheduletype ['sc'] could NOT be change, returns error if added.
	
---

### Other values
```php
$data['sc'] = 'monthly';		//The schedule type ('minute','hourly','daily','weekly','monthly', etc...)
$data['tn'] = 'My Schedule';		//Name for the task.
$data['tr'] = 'c:\folder\app.exe';	//Program or command that the task runs.
$data['s'] = 'computer';		//Name or IP address of a remote computer (with or without backslashes). The default is the local computer.
$data['u'] = 'domain';			//Runs this command with the permissions of the specified user account. 
$data['p'] = 'pass123';			//Password of the user account specified in the /u parameter. 
$data['ru'] = 'domain\user|system';	//Runs the task with permissions of the specified user account.
$data['rp'] = 'pass123';		//Password for the existing user account, or the user account specified by the ['ru'] parameter.
$data['mo'] = 'modifiers';		//How often the task runs within its schedule type e.g. 'minute','daily','hourly','monthly','weekly','once', etc...
$data['d'] = 'FRI';			//Weekly [MON - SUN...], Monthly [runs weekly each month by providing a value of FIRST, SECOND, THIRD, FOURTH, LAST].
$data['m'] = 'APR';			//The valid options include JAN - DEC and * (every month).
$data['i'] = '30';			//How many minutes the computer is idle before the task starts. Valid only with an ONIDLE schedule.
$data['st'] = '14:30:00';		//Start time for the task, using the 24-hour time format.
$data['ri'] = '15';			//Repetition interval for the scheduled task.
$data['rl'] = 'HIGHEST';		//Run Level for the job. LIMITED is the default value, HIGHEST for superuser accounts.
$data['et'] = '14:50:00';		//Time of day that a minute or hourly task schedule ends in 24 hour format.
$data['du'] = '20:00:00';		//Maximum length of time for a minute or hourly schedule in 24-hour format. Works with MINUTE & HOURLY schedule.
$data['sd'] = '04/01/2023';		//Date on which the task schedule starts. (Format: Mm/dd/YYYY)
$data['ed'] = '12/31/2023';		//Date on which the schedule ends. It isn't valid in a ONCE, ONSTART, ONLOGON, or ONIDLE schedule.
$data['k'];				//Stops the program that the task runs at the time specified by ['et'] or ['du'].
$data['it'];				//Run the scheduled task only when the run as user (the user account under which the task runs) is logged on. 
$data['np'];				//No password is stored. The task runs non-interactively as the given user. Only local resources are available.
$data['z'];				//Delete the task upon the completion of its schedule.
$data['f'];				//Create the task and suppress warnings if the specified task already exists.
```	

---

>**Note**: For other parameters and complete description: [Microsoft Homepage](https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks-create)

---

### Parameters
```php
$ab->schedule('delete',['tn'=>'My Schedule']);	//Remove selected schedule

$ab->schedule('end',['tn'=>'My Schedule']);	//Stop running schedule

$ab->schedule('run',['tn'=>'My Schedule']);	//Run selected schedule

$ab->rawquery($command);			//Run and execute your own windows command
```

### Contributing

Contributions are always welcome!

See `contributing.md` for ways to get started.

Please adhere to this project's `code of conduct`.
