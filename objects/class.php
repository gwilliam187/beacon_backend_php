<?php

class UnivClass {
	
	private $conn;
	
	public $id;
	public $date;
	public $startTime;
	public $endTime;
	public $course;
	public $room;

	public function __construct($db) {
		$this->conn = $db;
	}

	function read() {
		$query = "
			SELECT c.*, co.`name` AS `course_name`, r.`name` AS `room_name`
			FROM `class` c
			INNER JOIN `course` co ON co.`course_id` = c.`fk_course_id`
			INNER JOIN `room` r ON r.`room_id` = c.`fk_room_id`";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readCurrentClass($beaconId) {
		$query = "
			SELECT co.`name`, cl.`start_time`, cl.`end_time`
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