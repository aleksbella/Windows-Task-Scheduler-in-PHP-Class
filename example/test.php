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
$d = array(
	'sc' => 'monthly', //for change method [sc] is NOT required
	'tn' => 'My Schedule',	
	'tr' => 'notepad.exe',
	'sd' => '04/01/2023'
);
echo $ab->query('create',$d);




