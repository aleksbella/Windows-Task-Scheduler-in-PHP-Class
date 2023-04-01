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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Aleks Bella - Windows PHP Scheduler</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="bg-base-200">
<div class="h-screen flex">	
	<div class="w-96 bg-base-100 p-7 shadow-lg">
		<form action="" method="POST">
		
			<?php
				if(isset($_POST['set'])){
					extract($_POST);
					$data = array();
					$data['sc'] = $ttype;
					$data['tn'] = $tname;
					$data['tr'] = 'notepad.exe';
					$data['st'] = $ttime;
					$data['sd'] = date('m/d/Y',strtotime($tdate));
					$data['et'] = $etime;
					/*
						f = Create the task and suppress warnings if the specified task already exists.
						z = Delete the task upon the completion of its schedule.
					*/					
					$params = array('z','f');						
					
					$process = array_merge($data,$params);
					
					echo '<div class="bg-yellow-400 p-5 mb-5">';
					echo $ab->schedule('create',$process);
					echo '</div>';
				}
				
				if(isset($_POST['rbtn'])){
					$rname = $_POST['rname'];
					echo '<div class="bg-yellow-400 p-5 mb-5">';
					echo $ab->schedule('delete',['tn'=>$rname,'f']);
					echo '</div>';
				}
				
			?>

			<div class="space-y-4">
				<div class="mb-3 form-control">
					<label>Schedule Type</label>
					<select class="select select-bordered" name="ttype">
						<option value="once">Once</option>
						<option value="daily">Daily</option>
						<option value="minute">Minute</option>
						<option value="hourly">Hourly</option>
						<option value="weekly">Weekly</option>
						<option value="monthly">Monthly</option>
						<option value="onstart">Onstart</option>
						<option value="onlogon">Onlogon</option>
						<option value="onidle">Onidle</option>
					</select>
				</div>
				<div class="mb-3 form-control">
					<label>Task name</label>
					<input type="text" class="input input-bordered" name="tname" placeholder="Task name" value="My Schedule">
				</div>
				<div class="mb-3 form-control">
					<label>Start Time</label>
					<input type="time" step="1" class="input input-bordered" name="ttime" value="<?=date("H:i:s");?>">
				</div>
				
				<div class="mb-3 form-control">
					<label>End Time</label>
					<input type="time" step="1" class="input input-bordered" name="etime" value="<?=date("H:i:s",strtotime("+30 MINUTE"));?>">
				</div>
				
				<div class="mb-3 form-control">
					<label>Starting Date</label>
					<input type="date" value="<?=date("Y-m-d");?>" class="input input-bordered" name="tdate" placeholder="Starting date">
				</div>
						
				<button type="submit" name="set" class="btn btn-primary">Set Schedule</button>
			</div>
		</form>
		
		
		<div class="divider"></div>
		<form method="post">
			<label>Enter task name below to remove. This will return error if task name does not exists or not specified.</label>
			<input type="text" name="rname" class="input input-bordered mr-3 my-3 w-full block" placeholder="Enter task name"><button class="btn" type="submit" name="rbtn">Remove</button>
		</form>
	</div>
</div>

</body>
</html>
