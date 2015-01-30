<form action='#' method="post" name="type" style="width:50%; margin:auto;">
	<select onchange="document.type.submit();" name="deviceSchedule" class="form-control" 
		style="font-weight:bold;">
		<?php foreach($_SESSION['deviceList'] as $device):?>
          	<option value="<?php echo $device; ?>" 
          		<?php if(isset($_POST['deviceSchedule']) 
          			AND $device == $_POST['deviceSchedule']){ echo 'selected="selected"';} ?> >
          		<?php echo $device; ?>
          	</option>
         <?php endforeach; ?>
	</select>
</form></br>
	
<?php if(isset($_POST['deviceSchedule'])){
	$deviceId = array_search($_POST['deviceSchedule'], $_SESSION['deviceList']);
	$results = events($_SESSION['choosingDate'], NULL, $deviceId);
	include("calendars.php"); 
}else{
	$deviceId = array_keys($_SESSION['deviceList'])[0];
	$results = events($_SESSION['choosingDate'], NULL, $deviceId);
	include("calendars.php"); 
} ?>