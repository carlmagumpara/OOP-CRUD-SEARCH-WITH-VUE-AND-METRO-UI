<?php  
	include_once 'config/database.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$q = "%".$_GET['q']."%";
	if ($user->search($q)) {
		echo $user->search($q);
	} else {
		echo '[]';
	}
?>