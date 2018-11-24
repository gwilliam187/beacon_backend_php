<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/Utils.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new Utils($db);

$studentId = isset($_POST["student_id"]) ? $_POST["student_id"] : die();
$beaconId = isset($_POST["beacon_id"]) ? $_POST["beacon_id"] : die();

if($obj->createAttendanceFromMobile($studentId, $beaconId)) {
	$stmt = $obj->readCurrentClass($beaconId);
	$num = $stmt->rowCount();

	if($num == 1) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$classId = $row["class_id"];
		$courseName = $row["name"];
		$startTime = $row["start_time"];
		$endTime = $row["end_time"];

		$objItem = array(
			"id" => $classId,
			"courseName" => $courseName,
	        "startTime" => $startTime,
	        "endTime" => $endTime
		);
	} else {
		$objItem = new stdClass();
	}

    echo json_encode(array("message" => "success", "class_detail" => $objItem));
} else {
    echo json_encode(array("message" => "fail"));
}

?>