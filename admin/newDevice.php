<div class="adminForms">
<h3>New device</h3>
<form action="#" method="post">
	<input type="text" name="device" class="form-control" placeholder="Device name" 
		autocomplete="off"/></br>
	<textarea type="text" name="deviceInformation" class="form-control" 
		placeholder="Device information"></textarea></br>
	<button type="submit" class="btn btn-default">Confirm</button>
</form></div>
<?php
if(isset($_POST['device'])){
	$req= $DB->query('SELECT device FROM device WHERE device="'.$_POST["device"].'"');
	while($info = $req->fetch()){
		$return[] = $info;
	}
	if($return==NULL){
		$DB->exec('INSERT INTO device (device, information) VALUE ("'.$_POST["device"].'", 
			"'.$_POST["deviceInformation"].'")');
		$_SESSION['infoNewDevice']=$_POST["device"];
		echo '<script>window.location.reload();</script>';
	}else{
		$_SESSION['error']='existingDevice'; echo '<script>window.location.reload();</script>';
	}
}
?>