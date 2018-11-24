<?php

class Utils {
	
	private $conn;

	public function __construct($db) {
		$this->conn = $db;
	}

    function createAttendanceFromMobile($studentId, $beaconId) {
        $query = "
            INSERT INTO `student_has_class` VALUES(:studentId, (
                SELECT `class_id` 
                    FROM `class` c
                    INNER JOIN `room` r ON c.`fk_room_id` = r.`room_id`
                    WHERE NOW() BETWEEN `start_time` AND `END_TIME` AND
                        `beacon` = :beaconId AND
                        c.`is_deleted` = 0 AND
                        r.`is_deleted` = 0
                ), NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":studentId", $studentId, PDO::PARAM_STR);
        $stmt->bindValue(":beaconId", $beaconId, PDO::PARAM_STR);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function readScheduleWhereDateIsNow($studentId) {
        $query = "
            SELECT cl.`class_id`, cl.`start_time`, cl.`end_time`, co.`name` course_name, r.`name` room_name
            FROM `class` cl
            INNER JOIN `course` co ON cl.`fk_course_id` = co.`course_id`
            INNER JOIN `room` r ON cl.`fk_room_id` = r.`room_id`
            WHERE cl.`fk_course_id` IN (
                SELECT `fk_course_id` 
                FROM student_has_course 
                WHERE NOW() BETWEEN start_date AND end_date AND
                    `fk_student_id` = :studentId
            ) AND cl.`date` = DATE(NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":studentId", $studentId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

	function readCurrentClass($beaconId) {
        $query = "
            SELECT DISTINCT cl.`class_id`, co.`name`, cl.`start_time`, cl.`end_time`
            FROM student_has_course sco
            INNER JOIN `student` s ON s.`student_id` = sco.`fk_student_id`
            INNER JOIN `course` co ON co.`course_id` = sco.`fk_course_id`
            INNER JOIN `class` cl ON cl.`fk_course_id` = (
                SELECT DISTINCT fk_course_id FROM class WHERE fk_room_id = (
                    SELECT room_id FROM room WHERE beacon = :beaconId
                )
            )
            WHERE NOW() BETWEEN (cl.`start_time` - INTERVAL 10 MINUTE) AND cl.`end_time`";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":beaconId", $beaconId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
}

?>