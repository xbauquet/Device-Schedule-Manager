<?php
if(isset($_POST['delete'])){
	$DB->exec('DELETE FROM maintenance WHERE id='.$_POST['id']);
	$_SESSION['infoMaintenance']='deleted';
	echo '<script>window.location.reload();</script>';
}else if(isset($_POST['save'])){
	$firstDay = strtotime($_POST['firstDay']);
	$lastDay = strtotime($_POST['lastDay']);
	$deviceId = array_search($_POST['device'], $_SESSION['deviceList']);
	$DB->exec('UPDATE maintenance SET 
		firstDay='.$firstDay.', 
		lastDay='.$lastDay.', 
		deviceId='.$deviceId.', 
		info="'.$_POST["info"].'" 
		WHERE id='.$_POST['id']);
	$_SESSION['infoMaintenance']='updated';
	echo '<script>window.location.reload();</script>';
}
?>

<table class="tab">
	<tr>
		<th>First day</th>
		<th>Last day</th>
		<th>Device</th>
		<th>Information</th>
		<th>Save</th>
		<th>Delete</th>
	</tr>
<?php 
$req = $DB->query('SELECT * FROM maintenance WHERE lastDay >='.strtotime(date('Y-m-d')) );
while($info = $req->fetch()){
	echo '
	<tr>
		<form action="#" method="post" class="form-inline">
		<td style="width:110px;">
			<input type="text" name="firstDay" autocomplete ="off" 
				class="form-control datepicker" value="'.date('Y-m-d', $info['firstDay']).'"/>
		</td>
		<td style="width:110px;">
			<input type="text" name="lastDay" autocomplete ="off" 
				class="form-control datepicker" value="'.date('Y-m-d', $info['lastDay']).'"/>
		</td>
		<td>
		<select name="device" class="form-control">';
		foreach($_SESSION['deviceList'] as $device):?>
          	<option value="<?php echo $device; ?>" 
          		<?php if($device == $_SESSION['deviceList'][$info['deviceId']]){ 
          				echo 'selected="selected"';} ?>>
          		<?php echo $device; ?>
          	</option>
        <?php endforeach;  
        echo '</select>
		</td>
		<td><textarea style="width:100%;" class="form-control" rows="3" name="info">'
			.$info['info'].'</textarea></td>
		<td style="width:50px;">
			<input type="hidden" name="id" value="'.$info['id'].'">
			<input type="submit" class="btn btn-default" value="Save" name="save">
		</td>
		<td style="width:50px;">
			<input type="hidden" name="id" value="'.$info['id'].'">
			<input type="submit" class="btn btn-danger" value="X" name="delete" 
				style="width:100%;">
		</td>
		</form>
	</tr>
	';
}
?>
</table>
