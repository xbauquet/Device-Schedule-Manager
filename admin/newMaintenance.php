<div class="adminForms">
	<form action="admin/maintenance.php" method="post">
		<select name="deviceMaintenance" class="form-control">
		<?php foreach($_SESSION['deviceList'] as $device){
          	echo'<option value="'.array_search($device, $_SESSION['deviceList']).'">
          		'.$device.'</option>';
       		} ?>
		</select></br>
		<div class="form-group form-inline">
			<input type="text" name="startMaintenance" autocomplete ="off" 
				class="form-control datepicker" placeholder="Start"/>
			<input type="text" name="endMaintenance" autocomplete ="off" 
				class="form-control datepicker" placeholder="End"/>
		</div>
		<textarea name="infoMaintenance" class="form-control" rows="3" 
			placeholder="Information"></textarea></br>
		<button type="submit" class="btn btn-default">Ok</button>
	</form>
</div>