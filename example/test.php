<?php

/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.1.2
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/

include "../tasks.php";
use AleksBella\Tools\AB\Tasks;
$ab = new Tasks();
$data = array(
	'sc' => 'daily',			// Schedule type
	'tn' => gethostname(),		// Task name
	'tr' => 'notepad.exe',		// App/script to run
	'sd' => '04/10/2023',		// Schedule date
	'ru'=> 'teen'				// Run as user
);
echo '<pre>';
//echo $ab->rawQuery('dir'); 
//echo $ab->query('create',$data); 
//echo $ab->query('delete',['tn'=>'Monthly Schedule']);
echo $ab->query('query',['v /tn'=>gethostname(),'fo'=>'list']); // [v /tn="task name"] is advanced properties of the task to the display. This parameter is valid with the LIST or CSV output formats.
echo '</pre>';



