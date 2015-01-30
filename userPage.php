<?php 
if(!isset($_POST['choosingDate']) AND !isset($_SESSION['choosingDate'])){
		$_SESSION['choosingDate'] = date('Y-m-d');
}else if(isset($_POST['choosingDate'])){
	$_SESSION['choosingDate'] = date($_POST['choosingDate']);
}
	
	
?>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="?user=<?php echo $_SESSION['user']; ?>">My reservations</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	Device reservation <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
          	<?php
          		foreach($_SESSION['deviceList'] as $device){
          			echo'<li><a href="?mode='.$device.'">'.$device.'</a></li>';
          		}
          	?>
          </ul>
        </li>
        <li>
        	<form method="post" action="#" class="navbar-form">
				<input type="text" name="choosingDate" autocomplete ="off" 
					class="form-control datepicker" 
					placeholder="<?php echo $_SESSION['choosingDate']; ?>"/>
				<button type="submit" class="btn btn-default">Ok</button>
			</form>
        </li>
      </ul>
    </div>
</nav>
<!-- ------------------------------------ -->
<section>
	
	<?php 
	if(!isset($_GET['mode']) AND !isset($_GET['user']) OR isset($_GET['user'])){
		$results = events($_SESSION['choosingDate'], $_SESSION['userId'], NULL);
		echo '<h2 style="text-align:center;">My reservations</h2>';
	}else if(isset($_GET['mode'])){
		$deviceId = array_search($_GET['mode'], $_SESSION['deviceList']);
		$results = events($_SESSION['choosingDate'], NULL, $deviceId);
		echo '<h2 style="text-align:center;">'.$_GET['mode'].'</h2>';
	}
	include("calendars.php"); ?>
</section>

