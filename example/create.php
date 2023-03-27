<?php
include "../tasks.php";
$job = new Tasks('bat.bat');
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
<body>

<div class="navbar bg-base-300">
  <div class="flex-1">
    <a class="btn btn-ghost normal-case text-xl">AB WPS</a>
  </div>
  <div class="flex-none">
    <button class="btn btn-square btn-ghost">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
    </button>
  </div>
</div>

<div class="h-screen flex justify-center items-center">	
	<div class="w-1/2 bg-base-300 p-4 rounded-lg shadow-lg">
		<form action="" method="POST">
		<div class="overflow-y-scroll max-h-96 my-5">
			<?php
				if(isset($_POST['set'])){
					extract($_POST);
					echo $job->create($ttype,$tname,$ttime,$tdate);
				}
			?>
		</div>
			<div class="form-control space-y-4">
				<input type="text" class="input input-bordered" name="tname" placeholder="Task name">
				<input type="time" step="1" class="input input-bordered" name="ttime" placeholder="Time">
				<input type="date" class="input input-bordered" name="tdate" placeholder="Starting date">
				<select class="select select-bordered" name="ttype">
					<option value="daily">Daily</option>
					<option value="minutes">Minute</option>
					<option value="hourly">Hourly</option>
					<option value="weekly">Weekly</option>
					<option value="monthly">Monthly</option>
				</select>
				<button type="submit" name="set" class="btn btn-primary">Set</button>
			</div>
		</form>
	</div>
</div>

</body>
</html>