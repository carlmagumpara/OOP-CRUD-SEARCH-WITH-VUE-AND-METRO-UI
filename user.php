<?php  

	class User
	{
		private $conn;

		function __construct($db)
		{
			$this->conn = $db;
		}

		function create($data)
		{
			$stmt = $this->conn->prepare('INSERT INTO users (name, age, gender, address) VALUES (?,?,?,?)');
			$stmt->bind_param('ssbs', $data['name'], $data['age'], $data['gender'], $data['address']);
			if ($stmt->execute()) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		function update($data)
		{
			$stmt = $this->conn->prepare('UPDATE users SET name = ?, age = ?, gender = ?, address = ? WHERE  id  = ?');
			$stmt->bind_param('ssbsi', $data['name'], $data['age'], $data['gender'], $data['address'], $data['id']);
			if ($stmt->execute()) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		function delete($id) 
		{
			$stmt = $this->conn->prepare('DELETE FROM users WHERE id = ?');
			$stmt->bind_param('i', $id);
			if ($stmt->execute()) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		function search($q)
		{
			$stmt = $this->conn->prepare('SELECT * FROM users WHERE name LIKE ? OR address LIKE ?');
			$stmt->bind_param('ss', $q, $q);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			if ($result) {
				if ($result->num_rows > 0) {
				    while($row = mysqli_fetch_assoc($result)) {
				        $data[] = array(
				        	'id' => $row['id'],
				        	'name' => $row['name'],
				        	'name' => $row['name'], 
				        	'age' => $row['age'], 
				        	'gender' => $row['gender'],
				        	'address' => $row['address'],  
				        	);
				    }
				    return json_encode($data);
				} else {
					return FALSE;
				}
			} else {
				return json_encode(array(
					'result' => 'error', 
					'message' => 'Error!', 
				));
			}
		}

		function fetch($page) 
		{
			$stmt = $this->conn->prepare('SELECT * FROM users ORDER BY id DESC LIMIT 5 OFFSET ?');
			$stmt->bind_param('i', $page);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			if ($result) {
				if ($result->num_rows > 0) {
				    while($row = mysqli_fetch_assoc($result)) {
				        $data[] = array(
				        	'id' => $row['id'],
				        	'name' => $row['name'],
				        	'name' => $row['name'], 
				        	'age' => $row['age'], 
				        	'gender' => $row['gender'],
				        	'address' => $row['address'],  
				        	);
				    }
				    return json_encode($data);
				}
			} else {
				return json_encode(array(
					'result' => 'error', 
					'message' => $this->conn->error, 
				));
			}
		}
	}
?>