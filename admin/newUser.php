<div class="adminForms">
	<h3>New user</h3>
		<form action="#" method="post">
			<input type="text" name="username" class="form-control" placeholder="Username" 
				autocomplete="off" required="required"/></br>
			<input type="password" name="password" class="form-control" placeholder="password" 
				required="required"/></br>
			<input type="password" name="repassword" class="form-control" 
				placeholder="password again" required="required"/></br>
			<input type="email" name="email" class="form-control" placeholder="email" 
				required="required"/></br>
			<select name="status" class="form-control">
				<option value="user">user</option>
				<option value="admin">admin</option>
			</select></br>
			<button type="submit" class="btn btn-default">Confirm</button>
		</form></div>
<?php
if(isset($_POST["username"]) AND isset($_POST["password"]) AND isset($_POST["email"]) 
	AND isset($_POST["repassword"])){
	if($_POST["password"] != $_POST["repassword"]){
		$_SESSION['error']='repasswordError'; echo '<script>window.location.reload();</script>';
	}else if(readDataBase('username', 'user', 'username="'.$_POST["username"].'"')!=NULL){
		$_SESSION['error']='existingUser'; echo '<script>window.location.reload();</script>';
	}else{
		$DB->exec('INSERT INTO user (username, password, status, mail) 
			VALUE ("'.$_POST["username"].'", "'.$_POST["password"].'", "'.$_POST["status"].'", 
			"'.$_POST["email"].'")');
		$_SESSION['infoNewUser']=$_POST["username"];
		echo '<script>window.location.reload();</script>';
	}
}
?>
			
			