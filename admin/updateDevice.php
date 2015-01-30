<?php
if(isset($_POST['delete'])){
	$DB->exec('DELETE FROM device WHERE id='.$_POST['id']);
	$_SESSION['infoDevice']='deleted';
	echo '<script>window.location.reload();</script>';
}else if(isset($_POST['save'])){
	if(in_array($_POST['device'], $_SESSION['deviceList'])){
		$_SESSION['error']='existingDevice';
		echo '<script>window.location.reload();</script>';
	}else{
		$DB->exec('UPDATE device SET 
			device="'.$_POST['device'].'", information="'.$_POST['info'].'" 
			WHERE id='.$_POST['id']);
		$_SESSION['infoDevice']='updated';
		echo '<script>window.location.reload();</script>';
	}
}
?>

<table class="tab">
	<tr>
		<th>Device</th>
		<th>Information</th>
		<th>Save</th>
		<th>Delete</th>
	</tr>
<?php 
$req = $DB->query('SELECT * FROM device ');
while($info = $req->fetch()){
	echo '
	<tr>
		<form action="#" method="post" class="form-inline">
		<td><input type="text" name="device" class="form-control" value="'.$info['device'].'"/></td>
		<td><textarea style="width:100%;" class="form-control" rows="3" name="info">'
			.$info['information'].'</textarea></td>
		<td style="width:50px;">
			<input type="hidden" name="id" value="'.$info['id'].'"/>
			<input type="submit" class="btn btn-default" value="Save" name="save"/>
		</td>
		<td style="width:50px;">
			<input type="hidden" name="id" value="'.$info['id'].'"/>
			<input type="submit" class="btn btn-danger" value="X" name="delete" 
				style="width:100%;"/>
		</td>
		</form>
	</tr>
	';
}
?>
</table>
