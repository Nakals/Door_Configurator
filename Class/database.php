<?php 
class Database{
    public function conn_db(){		
		$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
		if($conn->connect_error){

			die("Connection Failed: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}
?>