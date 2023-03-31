<?php

/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.3.0
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/

include "../tasks.php";
use AleksBella\Scheduler\Tasks;
$ab = new Tasks();
$data = array(
	'sc' => 'daily',			// Schedule type
	'tn' => 'My Task',			// Task name
	'tr' => 'notepad.exe',		// App/script to run
	'sd' => '04/10/2023',		// Schedule date
	'ru'=> 'teen',				// Run as user
	'k',						//Stops the program that the task runs at the time specified by [et] or [du].
	'z',						//Specifies to delete the task upon the completion of its schedule.
	'et'=>'20:00',				//Specifies the time of day that a minute or hourly task schedule ends in 24-hour format. 
	'f'							//Specifies to create the task and suppress warnings if the specified task already exists.
);

echo '<pre>';
echo $ab->schedule('create',$data);
echo '</pre>';


