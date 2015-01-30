<?php session_start(); 

$_SESSION['todayTS'] = strtotime(date('Y-m-d'));
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Project</title>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<!-- phpGraph -->
		<link rel="stylesheet" type="text/css" href="phpGraph/phpGraph_style.css" media="all">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen"/>
		<!-- JavaScript -->
		<link rel="stylesheet" href="datepicker/jquery-ui.css">
		<!-- My JavaScript -->
		<script type="text/javascript">
			function action(){
				$('#error').hide();
				$('#info').hide();
			}
			window.onload=setTimeout(action, 4000);
		</script>
	</head>
<!-- ----------------------------------------------------------------------------------------- -->
	<body>
	<!-- ----------Requires---------- -->
	<?php 
		require 'function.php';
		require 'config.php';
	?>
	<!-- ----------Header---------- -->
	<header>
	<h1 class="titre">Device Schedule Manager</h1>
	<?php 
	include("error.php");
	if(!isset($_SESSION['user'])){
		// identification form
		echo '
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      			<ul class="nav navbar-nav navbar-right">
      				<div class="login">
					<form action="logIn.php" method="post" >
						<input name="username" type="text" placeholder="Username"/>
						<input name="password" type="password" placeholder="Password"/>
						<input type="submit" value="Log in" class="btn btn-default"/>
			  		</form></div>
			  	</ul>
			</div>
		</nav>
		<div>
		You need to be registered to use Device Schedule Manager please 
		contact us: xavier.bauquet@gmail.com
		</div>';
	}else{
		$testStatus = identificationVerif();
		echo '<div class="logout"><h1>'.$_SESSION['user'].'</h1></span>
				<form action="logOut.php">
					<input type="submit" value="Log out" class="btn btn-default"/>
				</form></div>';
	}
	?>
	</header>
	<?php 
	// loading of the good interface according to the status of the user
	if(isset($_SESSION['user'])){
		$req = $DB->query('SELECT id, device FROM device');
		while($info = $req -> fetch()){
			$_SESSION['deviceList'][$info['id']] = $info['device'];
		}

		if($testStatus == 'admin'){ include("adminPage.php"); }
		if($testStatus == 'user'){ include("userPage.php"); }
	}
	?>
	
	
<!-- Scripts -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
	// Datepicker
		$( "#datepicker" ).datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$( ".datepicker" ).datepicker({
			dateFormat : 'yy-mm-dd'
		});
		jQuery(function($){
			$('#dialogNewEvent').hide();
			$('#dialogDeleteUser').hide();
		});
	</script>
	<script src="js/script.js"></script>
	</body>
</html>