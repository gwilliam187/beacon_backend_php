<?php

class MajorHasCourse {
	
	private $conn;

	public $majorId;
	public $major;
	public $courseId;
	public $course;
	public $semester;

	public function __construct($db) {
		$this->conn = $db;
	}

	function create() {
		$query = "INSERT INTO `course_has_major` VALUES(:courseId, :majorId, :semester)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':courseId', $this->courseId, PDO::PARAM_STR);
		$stmt->bindValue(':majorId', $this->majorId, PDO::PARAM_STR);
		$stmt->bindValue(':semester', $this->semester, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function read() {
		$query = "
			SELECT c.`course_id`, c.`name` course_name, m.`major_id`, m.`name` major_name, cm.`semester`  
			FROM `course` c 
			INNER JOIN `course_has_major` cm ON cm.`fk_course_id` = c.`course_id`
			INNER JOIN `major` m ON m.`major_id` = cm.`fk_major_id`
			WHERE c.`is_deleted` = 0 AND m.`is_deleted` = 0";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readWhereMajor() {
		$query = "
			SELECT c.`course_id`, c.`name` course_name, m.`major_id`, m.`name` major_name, cm.`semester`  
			FROM `course` c 
			INNER JOIN `course_has_major` cm ON cm.`fk_course_id` = c.`course_id`
			INNER JOIN `major` m ON m.`major_id` = cm.`fk_major_id`
			WHERE c.`is_deleted` = 0 AND m.`is_deleted` = 0 AND `major_id` = :majorId";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':majorId', $this->majorId, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt;
	}

	function delete() {
	    $query = "DELETE FROM `course_has_major` WHERE `fk_course_id` = :courseId AND `fk_major_id` = :majorId";

	    $stmt = $this->conn->prepare($query);
	    $stmt->bindValue(":courseId", $this->courseId, PDO::PARAM_INT);
	    $stmt->bindValue(":majorId", $this->majorId, PDO::PARAM_INT);

	    if($stmt->execute()) {
	        return true;
        } else {
	        return false;
        }
    }
}

?>