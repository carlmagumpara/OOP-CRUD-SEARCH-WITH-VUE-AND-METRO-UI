<?php  
	include_once 'connection.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$id = $_GET['id'];
	if ($user->delete($id)) {
		echo json_encode(array(
			'result' => 'success', 
			'message' => 'Data successfully deleted!', 
		));
	} else {
		echo json_encode(array(
			'result' => 'error', 
			'message' => 'Error deleting your data!', 
		));
	}
?>