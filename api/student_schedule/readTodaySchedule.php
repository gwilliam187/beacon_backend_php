<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
 
require_once('../../config/database.php');
require_once('../../objects/Utils.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new Utils($db);
 
$studentId = isset($_GET['student_id']) ? $_GET['student_id'] : die();
 
$stmt = $obj->readScheduleWhereDateIsNow($studentId);
$num = $stmt->rowCount();

if($num > 0) {
	$objArr = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "courseName" => $row["course_name"],
            "date" => date('l, d F Y', strtotime($row["start_time"])),
            "startTime" => date('H:i', strtotime($row["start_time"])),
            "endTime" => date('H:i', strtotime($row["end_time"])),
            "roomName" => $row["room_name"]
        );    
        $objArr[] = $objItem;
    }

	echo(json_encode($objArr));
} else {
	echo(json_encode(new stdClass()));
}

?>