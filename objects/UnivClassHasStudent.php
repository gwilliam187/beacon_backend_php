<?php

class UnivClassHasStudent {
	
	private $conn;

	public $classId;
	public $courseId;
	public $course;
	public $studentId;
	public $student;
	public $attendTime;

	public function __construct($db) {
		$this->conn = $db;
	}

	function create() {
		$query = "INSERT INTO `student_has_class` VALUES(:studentId, :classId, :attendTime)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':studentId', $this->studentId, PDO::PARAM_STR);
		$stmt->bindValue(':classId', $this->classId, PDO::PARAM_INT);
		$stmt->bindValue(':attendTime', $this->attendTime, PDO::PARAM_STR);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function readAllStudentsInClass() {
		$query = "
			SELECT DISTINCT s.`student_id`, s.`name` student_name,
				m.`major_id`, m.`name` major_name, 
				co.`course_id`, co.`name` course_name,
                IFNULL(sc.`attend_time`, 'Not attended') `attend_time`
			FROM `student` s 
			INNER JOIN `student_has_course` sco ON sco.`fk_student_id` = s.`student_id`
			INNER JOIN `course` co ON co.`course_id` = sco.`fk_course_id`
			INNER JOIN `class` c ON c.`fk_course_id` = co.`course_id`
            LEFT JOIN `student_has_class` sc ON s.`student_id` = sc.`fk_student_id`
            LEFT JOIN `student_has_class` sc2 ON c.`class_id` = sc2.`fk_class_id`
            INNER JOIN `major` m ON s.`fk_major_id` = m.`major_id`
			WHERE 
				s.`is_deleted` = 0 AND 
				co.`is_deleted` = 0 AND
				c.`is_deleted` = 0 AND
				c.`class_id` = :classId AND
				c.`date` BETWEEN sco.`start_date` AND sco.`end_date`"; 

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':classId', $this->classId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	//Fix this
	function readAllStudentsAttendedInClass() {
		$query = "
			SELECT DISTINCT s.`student_id`, s.`name` student_name,
				m.`major_id`, m.`name` major_name, 
				co.`course_id`, co.`name` course_name,
                sc.`attend_time`
			FROM `student` s 
            INNER JOIN `student_has_class` sc ON s.`student_id` = sc.`fk_student_id`
            INNER JOIN `class` c ON sc.`fk_class_id` = c.`class_id`
			INNER JOIN `course` co ON c.`fk_course_id` = co.`course_id`
            INNER JOIN `student_has_course` sco ON co.`course_id` = sco.`fk_course_id` 
            INNER JOIN `major` m ON s.`fk_major_id` = m.`major_id`
			WHERE
				s.`is_deleted` = 0 AND 
				co.`is_deleted` = 0 AND
				c.`is_deleted` = 0 AND
				c.`class_id` = :classId AND
				c.`date` BETWEEN sco.`start_date` AND sco.`end_date`"; 

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':classId', $this->classId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	function readAllStudentsNotAttendedInClass() {
		$query = "
			SELECT 
				s.`student_id`, s.`name` student_name,
				m.`major_id`, m.`name` major_name, 
				co.`course_id`, co.`name` course_name,
                IFNULL(sc.`attend_time`, 'Not attended') `attend_time`
			FROM `student` s 
			INNER JOIN `student_has_course` sco ON sco.`fk_student_id` = s.`student_id`
			INNER JOIN `course` co ON co.`course_id` = sco.`fk_course_id`
			INNER JOIN `class` c ON c.`fk_course_id` = co.`course_id`
            LEFT JOIN `student_has_class` sc ON c.`class_id` = sc.`fk_class_id`
            INNER JOIN `major` m ON s.`fk_major_id` = m.`major_id`
			WHERE
            	s.`student_id` NOT IN (SELECT `fk_student_id` FROM `student_has_class` WHERE `fk_class_id` = :classId) AND
				s.`is_deleted` = 0 AND 
				co.`is_deleted` = 0 AND
				c.`is_deleted` = 0 AND
				c.`class_id` = :classId AND
				c.`date` BETWEEN sco.`start_date` AND sco.`end_date`"; 

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':classId', $this->classId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	function readStudentsInClass() {
		$query = "
			SELECT 
				s.`student_id`, s.`name` student_name, 
				m.`major_id`, m.`name` major_name, 
				c.`class_id`, co.`name` course_name,
				sc.`attend_time`  
			FROM `student` s 
			INNER JOIN `major` m ON m.`major_id` = s.`fk_major_id`
			INNER JOIN `student_has_class` sc ON sc.`fk_student_id` = s.`student_id`
			INNER JOIN `class` c ON c.`class_id` = sc.`fk_class_id`
            INNER JOIN `course` co ON co.`course_id` = c.`fk_course_id`
            INNER JOIN `room` r ON r.`room_id` = c.`fk_room_id`
			WHERE s.`is_deleted` = 0 AND c.`is_deleted` = 0 AND sc.`fk_class_id` = :classId";

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':classId', $this->classId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt;
	}

	function update() {
		$query = "
			UPDATE `student_has_class` 
			SET `attend_time` = :attendTime 
			WHERE `fk_student_id` = :studentId AND `fk_class_id` = :classId";

		$stmt = $this->conn->prepare($query);
	    $stmt->bindValue(":studentId", $this->studentId, PDO::PARAM_STR);
	    $stmt->bindValue(":classId", $this->classId, PDO::PARAM_INT);
	    $stmt->bindValue(":attendTime", $this->attendTime, PDO::PARAM_STR);

	    if($stmt->execute()) {
	        return true;
        } else {
	        return false;
        }
	}

	function delete() {
	    $query = "DELETE FROM `student_has_class` WHERE `fk_student_id` = :studentId 
	    		AND `fk_class_id` = :classId";

	    $stmt = $this->conn->prepare($query);
	    $stmt->bindValue(":studentId", $this->studentId, PDO::PARAM_STR);
	    $stmt->bindValue(":classId", $this->classId, PDO::PARAM_INT);

	    if($stmt->execute()) {
	        return true;
        } else {
	        return false;
        }
    }
}

?>