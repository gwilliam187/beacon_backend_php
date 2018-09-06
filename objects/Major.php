<?php

class Major {
	
	private $conn;

	public $id;
	public $name;

	public function __construct($db) {
		$this->conn = $db;
	}

	function create() {
		$query = "INSERT INTO `major` VALUES(DEFAULT, :name)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function read() {
		$query = "SELECT * FROM `major`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
		$query = "SELECT * FROM `major` WHERE `major_id` = :id";

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
	    $query = "DELETE FROM `major` WHERE `major_id` = :id";

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