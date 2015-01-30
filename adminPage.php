<?php 
if(!isset($_POST['choosingDate']) AND !isset($_SESSION['choosingDate'])){
		$_SESSION['choosingDate'] = date('Y-m-d');
	}else if(isset($_POST['choosingDate'])){
		$_SESSION['choosingDate'] = date($_POST['choosingDate']);
	}

if(isset($_POST['selectedUser'])){
	selectedUserFct($_POST["selectedUser"]);
}
?>

<!-- Navigation bar for Admin users -->
<nav class="navbar navbar-inverse" role="navigation">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
     	<!-- ----------Statistic---------- -->        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	Statistic<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
          	<li><a href="?page=statByDevice">By device</a></li>
          	<li><a href="?page=statByUser">By user</a></li>
          </ul>
        </li>
		<!-- ----------Users---------- -->
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Users<span class="caret"></span>
          	</a>
          <ul class="dropdown-menu" role="menu">
          	<li><a href="?page=usersList">Users list</a></li>
          	<li><a href="?page=newUser">New user</a></li>
          	<li><a href="?page=updateUser">Update user</a></li>
          	<li><a href="?page=userSchedule">User schedule</a></li>
          </ul>
        </li>
        <!-- ----------Devices---------- -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	Devices<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
          	<li><a href="?page=newDevice">New device</a></li>
          	<li><a href="?page=updateDevice">Update device</a></li>
          	<li><a href="?page=devicesSchedule">Devices schedule</a></li>
          </ul>
        </li>
        
        <!-- ----------Maintenance---------- -->
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	Maintenance<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
          	<li><a href="?page=newMaintenance">New maintenance</a></li>
          	<li><a href="?page=updateMaintenance">Update maintenance</a></li>
          	<li><a href="?page=oldMaintenance">Old maintenance</a></li>
          </ul>
        </li>
		<!-- ----------Date form---------- -->
        <li>
        	<form method="post" action="#" class="navbar-form">
				<input type="text" name="choosingDate" autocomplete ="off" 
					class="form-control datepicker" 
					placeholder="<?php echo $_SESSION['choosingDate']; ?>"/>
				<button type="submit" class="btn btn-default">Ok</button>
			</form>
        </li>
        <!-- ----------User form---------- -->
        <li>
        	<form action="#" method="post" class="navbar-form">
        		<?php if(isset($_SESSION['selectedUser'])){ 
        			$placeholderSelectedUser = $_SESSION['selectedUser']; 
        		}else{ 
        			$placeholderSelectedUser = 'User'; 
        		}; ?>
				<input type="text" name="selectedUser" class="form-control" 
					placeholder="<?php echo $placeholderSelectedUser; ?>"/>
				<button type="submit" class="btn btn-default">Ok</button>
			</form>
        </li>
      </ul>
    </div>
</nav>

<section>

	<?php 
	if(isset($_GET['page'])){
		switch ($_GET['page']){
//----- Users
		case 'usersList':
			include("admin/usersList.php");
			break;
		case 'newUser':
			include("admin/newUser.php");
			break;
		case 'updateUser':
			if(isset($_SESSION['selectedUser'])){
				include("admin/updateUser.php");
			}else{
				echo '<p><h3>Please select a user.</h3></p>';
			}
			break;
		case 'userSchedule':
			if(isset($_SESSION['selectedUser'])){
				echo '<p><h3>User : '.$_SESSION['selectedUser'].'</h3></p>';
				$results = events($_SESSION['choosingDate'], $_SESSION['selectedUserId'], NULL);
				include("calendars.php");
			}else{
				echo '<p><h3>Please select a user.</h3></p>';
			}
			break;
//----- Devices
		case 'newDevice':
			include("admin/newDevice.php");
			break;
		case 'updateDevice':
			include("admin/updateDevice.php");
			break;
		case 'devicesSchedule':
			include("admin/devicesSchedule.php");
			break;
//----- Maintenances
		case 'newMaintenance':
			include("admin/newMaintenance.php");
			break;
		case 'updateMaintenance':
			include("admin/updateMaintenance.php");
			break;
		case 'oldMaintenance':
			include("admin/oldMaintenance.php");
			break;
//----- Statistic			
		case 'statByDevice':
			include("admin/statByDevice.php");
			break;
		case 'statByUser':
			if(isset($_SESSION['selectedUser'])){
				include("admin/statByUser.php");
			}else{
				echo '<p><h3>Please select a user.</h3></p>';
			}
			break;
		}
	}else{
		include("admin/statByDevice.php");
	}
	?>
</section>