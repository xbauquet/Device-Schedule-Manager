<?php
$req = $DB->query('SELECT * FROM user WHERE username="'.$_SESSION['selectedUser'].'"');
while($info = $req->fetch()){
	$results[] = $info;
}

$_SESSION['idToUpdate'] = $results[0]['id'];
?>
<div class="adminForms">
	<h3>Update user: <?php echo $_SESSION['selectedUser']; ?></h3>
	<form action="#" method="post">
		<input type="text" name="username" class="form-control" 
			value="<?php echo $results[0]['username']; ?>"/></br>
		<select name="status" class="form-control">
			<option value="user"  <?php if($results[0]['status']=='user'){echo "selected";}?> >
				user</option>
			<option value="admin"  <?php if($results[0]['status']=='admin'){echo "selected";}?> >
				admin</option>
		</select></br>
				
		<button type="submit" name="user" class="btn btn-default">Confirm</button>
	</form>
</div>
<div class="adminForms">
	<h3>Update password</h3>
	<form action="#" method="post">
		<input type="password" name="password" class="form-control" placeholder="New password"/>
		</br>
		<input type="password" name="repassword" class="form-control" 
			placeholder="New password again"/>
		</br>
		<button type="submit" name="pass" class="btn btn-default">Confirm</button>
	</form>
</div>
<div class="deleteButton">
	<button type="submit" name="delete" id="<?php echo $_SESSION['idToUpdate']; ?>" 
		class="btn btn-danger btn-block deleteUser">Delete user</button>
</div>
		
<?php if(isset($_POST['user'])){
	$request = $DB->query('SELECT username FROM user WHERE username="'.$_POST["username"].'"');
	while($info = $request->fetch()){
		$return[] = $info;
	}
	if($return[0]==NULL){
		if($_POST["status"] == 'user' OR $_POST["status"] == 'admin'){
			$DB->exec('UPDATE user SET username="'.$_POST["username"].'", 
				status="'.$_POST["status"].'" WHERE id="'.$_SESSION['idToUpdate'].'"');

			$_SESSION['infoUpdateUser']=$_POST["username"];
			$_SESSION["selectedUser"]=$_POST["username"];
			echo '<script>window.location.reload();</script>';
		}else{
			$_SESSION['error']='statusError'; echo '<script>window.location.reload();</script>';
		}
	}else{
		$_SESSION['error']='existingUser'; echo '<script>window.location.reload();</script>';
	}
}
if(isset($_POST['pass'])){
	if($_POST["password"] == $_POST["repassword"]){
		$DB->exec('UPDATE user SET password="'.$_POST["password"].'" 
			WHERE id="'.$_SESSION['idToUpdate'].'"');

		$_SESSION['infoUpdateUser']=$_SESSION["selectedUser"];
		echo '<script>window.location.reload();</script>';
	}else{
		$_SESSION['error']='repasswordError'; echo '<script>window.location.reload();</script>';
	}
} ?>

<div id="dialogDeleteUser" title="Delete user"> Do you want to delete the user: 
	<?php echo $results[0]['username']; ?> ?</div>
<div id="ajax"></div>
		