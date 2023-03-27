<?php
include "../tasks.php";
$ab = new Tasks();

$d = array(
	//'sc' => 'monthly',
	'tn' => 'Aleks Schedule',
	'st' => '10:00:00',
	'sd' => date('m/d/Y',strtotime("+1 MONTH")),					
	'ed' => date('m/d/Y',strtotime("+7 MONTH")),					
	'tr' => 'notepad.exe'
);
echo $ab->update($d);
//echo '<pre>'.$ab->query('aleks schedule');
