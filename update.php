<?php  
	include_once 'connection.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$data = array(
		'id' => $_POST['id'],
		'name' => $_POST['name'],
		'age' => $_POST['age'],
		'gender' => $_POST['gender'],
		'address' => $_POST['address']
	);
	if ($user->update($data)) {
		$data = array('id' => $connect->insert_id, ) + $data;
		echo json_encode(array(
			'result' => 'success', 
			'message' => 'Data successfully updated!',
			'data' => json_encode($data),
		));
	} else {
		echo json_encode(array(
			'result' => 'error', 
			'message' => 'Error updating your data!', 
		));
	}
?>