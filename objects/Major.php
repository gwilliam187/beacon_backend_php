<?php

class Major {
	
	private $conn;

	public $id;
	public $name;

	public function __construct($db) {
		$this->conn = $db;
	}

	function create() {
		$query = "INSERT INTO `major`(`name`) VALUES(:name)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function read() {
		$query = "SELECT * FROM `major` WHERE `is_deleted` = 0";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
		$query = "SELECT * FROM `major` WHERE `major_id` = :id AND `is_deleted` = 0";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	function update() {
		$query = "UPDATE `major` SET `name` = :name WHERE `major_id` = :id";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
		$stmt->bindValue(":name", $this->name, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function delete() {
	    $query = "UPDATE `major` SET `is_deleted` = 1 WHERE `major_id` = :id";

	    $stmt = $this->conn->prepare($query);
	    $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

	    if($stmt->execute()) {
	        return true;
        } else {
	        return false;
        }
    }
}

?>