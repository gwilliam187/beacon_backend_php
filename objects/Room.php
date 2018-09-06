<?php

class Room {
	
	private $conn;

	public $id;
	public $name;
	public $beacon;

	public function __construct($db) {
		$this->conn = $db;
	}

    function create() {
        $query = "INSERT INTO `room` VALUES(DEFAULT, :name, :beacon)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":beacon", $this->beacon, PDO::PARAM_STR);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

	function read() {
		$query = "SELECT * FROM `room`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

    function readOne() {
        $query = "SELECT * FROM `room` WHERE `room_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    function update() {
        $query = "
            UPDATE `room` 
            SET 
              `name` = :name,
              `beacon` = :beacon
            WHERE `room_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":beacon", $this->beacon, PDO::PARAM_STR);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "DELETE FROM `room` WHERE `room_id` = :id";

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