<?php

class Student {
	
	private $conn;

	public $id;
	public $name;
	public $entranceDate;
	public $major;

	public function __construct($db) {
		$this->conn = $db;
	}

	function read() {
		$query = "
			SELECT s.*, m.`name` AS `major_name`
			FROM `student` s
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}
}

?>