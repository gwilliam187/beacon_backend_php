<?php

class Course {
	
	private $conn;

	public $id;
	public $name;
	public $semester;

	public function __construct($db) {
		$this->conn = $db;
	}

	function read() {
		$query = "SELECT * FROM `course`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}
}

?>