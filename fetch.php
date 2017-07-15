<?php  
	include_once 'config/database.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$page = $_GET['users'];
	if ($user->fetch($page)) {
		echo $user->fetch($page);
	} else {
		echo '[]';
	}
	
?>