<?php  
	include_once 'config/database.php';
	include_once 'config/validator.php';
	include_once 'user.php';
	$database = new Database();
	$connect = $database->connect();
	$user = new User($connect);
	$validator = new arrayValidator();
	$data = array(
		'name' => $_POST['name'],
		'age' => $_POST['age'],
		'gender' => $_POST['gender'],
		'address' => $_POST['address']
	);
	$validate = $validator->validate($data);

	if ($validate === TRUE) {
		if ($user->create($data)) {
			$data = array('id' => $connect->insert_id, ) + $data;
			echo json_encode(array(
				'result' => 'success', 
				'message' => 'Data successfully saved!',
				'data' => json_encode($data),
			));
		} else {
			echo json_encode(array(
				'result' => 'error', 
				'message' => 'Error saving your data!', 
			));
		}
	} else {
		echo json_encode(array(
			'result' => 'error', 
			'data' => json_encode($validate), 
		));
	}

?>