<?php  
	include_once 'connection.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$q = "%".$_GET['q']."%";
	echo $user->search($q);
?>