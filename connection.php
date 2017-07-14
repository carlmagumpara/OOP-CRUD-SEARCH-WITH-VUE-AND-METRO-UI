<?php  

	class Database
	{
		
		private $host = 'localhost';
	    private $username = 'root';
	    private $password = '';
	    private $database = 'database';
	    public $conn;

		function __construct()
		{
			$this->conn = new mysqli($this->host,$this->username, $this->password, $this->database);
		}

		function connect(){
			if (!$this->conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			return $this->conn;
		}

	}
?>