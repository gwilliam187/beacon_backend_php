<?php

class UnivClass {
	
	private $conn;
	
	public $id;
	public $date;
	public $startTime;
	public $endTime;
	public $courseId;
	public $course;
	public $roomId;
	public $room;

	public function __construct($db) {
		$this->conn = $db;
	}

    function create() {
        $query = "
        	INSERT INTO `class`(`date`, `start_time`, `end_time`, `fk_course_id`, `fk_room_id`) 
        	VALUES(:date, :startTime, :endTime, :courseId, :roomId)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":date", $this->date, PDO::PARAM_STR);
        $stmt->bindValue(":startTime", $this->startTime, PDO::PARAM_STR);
        $stmt->bindValue(":endTime", $this->endTime, PDO::PARAM_STR);
        $stmt->bindValue(":courseId", $this->courseId, PDO::PARAM_INT);
        $stmt->bindValue(":roomId", $this->roomId, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

	function read() {
		$query = "
			SELECT 
			  c.*,
			  co.`course_id`, 
			  co.`name` `course_name`, 
			  r.`room_id`,
			  r.`name` `room_name`
			FROM `class` c
			INNER JOIN `course` co ON co.`course_id` = c.`fk_course_id`
			INNER JOIN `room` r ON r.`room_id` = c.`fk_room_id`
			WHERE `is_deleted` = 0";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

    function readOne() {
        $query = "
			SELECT 
			  c.*,
			  co.`course_id`, 
			  co.`name` `course_name`, 
			  r.`room_id`,
			  r.`name` `room_name`
			FROM `class` c
			INNER JOIN `course` co ON co.`course_id` = c.`fk_course_id`
			INNER JOIN `room` r ON r.`room_id` = c.`fk_room_id`
			WHERE `class_id` = :id AND `is_deleted` = 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    function update() {
        $query = "
            UPDATE `class` 
            SET 
                `date` = :date,
                `startTime` = :startDate,
                `endTime` = :endTime,
                `fk_course_id` = :courseId,
                `fk_room_id` = :roomId  
            WHERE `class_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindValue(":date", $this->date, PDO::PARAM_STR);
        $stmt->bindValue(":startTime", $this->startTime, PDO::PARAM_STR);
        $stmt->bindValue(":endTime", $this->endTime, PDO::PARAM_STR);
        $stmt->bindValue(":courseId", $this->courseId, PDO::PARAM_INT);
        $stmt->bindValue(":roomId", $this->roomId, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "UPDATE `class` SET `is_deleted` = 1 WHERE `class_id` = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


	function readCurrentClass($beaconId) {
		$query = "
			SELECT cl.`class_id`, co.`name`, cl.`start_time`, cl.`end_time`
			FROM student_has_course sco
			INNER JOIN `student` s ON s.`student_id` = sco.`fk_student_id`
			INNER JOIN `course` co ON co.`course_id` = sco.`fk_course_id`
			INNER JOIN `class` cl ON cl.`fk_course_id` = (
				SELECT fk_course_id FROM class WHERE fk_room_id = (
					SELECT room_id FROM room WHERE beacon='" . $beaconId . "'
				)
			)
			WHERE NOW() BETWEEN (cl.`start_time` - INTERVAL 10 MINUTE) AND cl.`end_time`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}
}

?>