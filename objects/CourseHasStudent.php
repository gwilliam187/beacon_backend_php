<?php

class CourseHasStudent {
	
	private $conn;

	public $courseId;
	public $major;
	public $studentId;
	public $student;
	public $startDate;
	public $endDate;

	public function __construct($db) {
		$this->conn = $db;
	}

	function create() {
		$query = "INSERT INTO `student_has_course` VALUES(:studentId, :courseId, :startDate, :endDate)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':studentId', $this->studentId, PDO::PARAM_STR);
		$stmt->bindValue(':courseId', $this->courseId, PDO::PARAM_INT);
		$stmt->bindValue(':startDate', $this->startDate, PDO::PARAM_STR);
		$stmt->bindValue(':endDate', $this->endDate, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function readStudentsInCourse() {
		$query = "
			SELECT 
				s.`student_id`, s.`name` student_name, 
				m.`major_id`, m.`name` major_name, 
				c.`course_id`, c.`name` course_name,
				sc.`start_date`, sc.`end_date`  
			FROM `student` s 
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`
			INNER JOIN `student_has_course` sc ON sc.`fk_student_id` = s.`student_id`
			INNER JOIN `course` c ON c.`course_id` = sc.`fk_course_id`
			WHERE s.`is_deleted` = 0 AND c.`is_deleted` = 0 AND sc.`fk_course_id` = :courseId";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':courseId', $this->courseId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	function readStudentsNotInCourse() {
		$query = "
			SELECT 
				s.`student_id`, s.`name` student_name, 
				m.`major_id`, m.`name` major_name 
			FROM `student` s 
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`
			WHERE s.`is_deleted` = 0 AND s.`student_id` NOT IN (
				SELECT fk_student_id FROM student_has_course WHERE fk_course_id = :courseId
			)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':courseId', $this->courseId, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt;
	}

	function delete() {
	    $query = "DELETE FROM `student_has_course` WHERE `fk_student_id` = :studentId 
	    		AND `fk_course_id` = :courseId AND `start_date` = :startDate";

	    $stmt = $this->conn->prepare($query);
	    $stmt->bindValue(":studentId", $this->studentId, PDO::PARAM_INT);
	    $stmt->bindValue(":courseId", $this->courseId, PDO::PARAM_INT);
	    $stmt->bindValue(":startDate", $this->startDate, PDO::PARAM_STR);

	    if($stmt->execute()) {
	        return true;
        } else {
	        return false;
        }
    }
}

?>