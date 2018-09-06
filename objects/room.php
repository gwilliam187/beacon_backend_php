<?php

class Room {
	
	private $conn;

	public $id;
	public $name;
	public $beacon;

	public function __construct($db) {
		$this->conn = $db;
	}

	function read() {
		$query = "SELECT * FROM `room`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}
}

?>