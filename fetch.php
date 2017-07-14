<?php  
	include_once 'config/database.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	echo $user->fetch();
?>