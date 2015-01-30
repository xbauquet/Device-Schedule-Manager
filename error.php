<?php 
if(isset($_SESSION['error'])){
	switch($_SESSION['error']){
		case "username":
			echo '<div id="error"> Error on the username </div>';
			break;
		case "password":
			echo '<div id="error"> Error on the password </div>'; 
			break;
		case "slot":
			echo '<div id="error"> One event exist in this time slot.</br> 
					Please choose an other slot.</div>';
			break; 
		case "existingUser":
			echo '<div id="error"> This username is already used.</br> 
					Please choose an other uername </div>';
			break;
		case "repasswordError":
			echo '<div id="error"> Both password are different.</div>';
			break;
		case "unknowUser":
			echo '<div id="error"> No user with this username. </div>';
			break; 
		case "existingDevice":
			echo '<div id="error"> This device is already registered. </div>';
			break;
	}
	unset($_SESSION['error']);
}

	
if(isset($_SESSION['infoNewUser'])){
	echo '<div id="info"> User: '.$_SESSION['infoNewUser'].' registered.</div>';
	unset($_SESSION['infoNewUser']);
}
if(isset($_SESSION['infoUpdateUser'])){
	echo '<div id="info">'.$_SESSION['infoUpdateUser'].' information ubdated.</div>';
	unset($_SESSION['infoUpdateUser']);
}
if(isset($_SESSION['infoDeletedUser'])){
	echo '<div id="info">User:'.$_SESSION['infoDeletedUser'].' deleted.</div>';
	unset($_SESSION['infoDeletedUser']);
}
if(isset($_SESSION['infoNewDevice'])){
	echo '<div id="info">User:'.$_SESSION['infoNewDevice'].' registered.</div>';
	unset($_SESSION['infoNewDevice']);
}
if(isset($_SESSION['infoMaintenance'])){
	if($_SESSION['infoMaintenance']=='updated'){
		echo '<div id="info">Maintenance updated.</div>';
	}else if($_SESSION['infoMaintenance']=='deleted'){
		echo '<div id="info">Maintenance deleted.</div>';
	}
	unset($_SESSION['infoMaintenance']);
}
if(isset($_SESSION['infoDevice'])){
	if($_SESSION['infoDevice']=='updated'){
		echo '<div id="info">Device updated.</div>';
	}else if($_SESSION['infoDevice']=='deleted'){
		echo '<div id="info">Device deleted.</div>';
	}
	unset($_SESSION['infoDevice']);
}