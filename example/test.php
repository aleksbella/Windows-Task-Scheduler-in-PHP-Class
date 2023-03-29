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
	'sc' => 'monthly',			// Schedule type
	'tn' => 'Monthly Schedule',	// Task name
	'tr' => 'notepad.exe',		// App/script to run
	'sd' => '03/29/2023',		// Schedule date
	'ru'=> 'teen'				// Run as user
);
echo $ab->query('create',$data);
//echo '<pre>'.$ab->query('query',['tn'=>'Monthly Schedule','fo'=>'list']).'</pre>';
//echo $ab->query('delete',['tn'=>'Monthly Schedule']);
