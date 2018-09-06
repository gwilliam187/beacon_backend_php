<?php

class Student {
	
	private $conn;

	public $id;
	public $name;
	public $entranceDate;
	public $majorId;
	public $major;

	public function __construct($db) {
		$this->conn = $db;
	}

    function create() {
        $query = "INSERT INTO `student` VALUES(:id, :name, :date, :majorId)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_STR);
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":date", $this->entranceDate, PDO::PARAM_STR);
        $stmt->bindValue(":majorId", $this->majorId, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

	function read() {
		$query = "
			SELECT s.*, m.`name` `major_name`
			FROM `student` s
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
        $query = "
			SELECT s.*, m.`name` `major_name`
			FROM `student` s
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`
			WHERE `student_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    function update() {
        $query = "
            UPDATE `student` 
            SET 
              `name` = :name,
              `entrance_date` = :date,
              `fk_major_id` = :majorId 
            WHERE `student_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindValue(":date", $this->entranceDate, PDO::PARAM_STR);
        $stmt->bindValue(":majorId", $this->majorId, PDO::PARAM_INT);


        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "DELETE FROM `student` WHERE `student_id` = :id";

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