<?php 
session_start();
require 'config.php';

$req = $DB->query('SELECT id, password FROM user WHERE username="'.$_POST['username'].'"');
while($info = $req->fetch()){
	$userInfo[] = $info;
}

if($userInfo[0] == NULL){
	$_SESSION['error'] = 'username';
	header('Location: index.php');
}else{
	if($userInfo[0]['password'] == $_POST['password']){
		$_SESSION['user'] = $_POST['username'];
		$_SESSION['password'] =  $_POST['password'];
		$_SESSION['userId'] = $userInfo[0]['id'];
		header('Location: index.php');
	}else{
		$_SESSION['error'] = 'password';
		header('Location: index.php');
	}
}