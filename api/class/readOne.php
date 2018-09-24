<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
 
require_once('../../config/database.php');
require_once('../../objects/UnivClass.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new UnivClass($db);
 
$obj->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$stmt = $obj->readOne();
$num = $stmt->rowCount();

if($num == 1) {
	$objArr = array();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$obj->date = $row["date"];
	$obj->startTime = $row["start_time"];
	$obj->endTime = $row["end_time"];
	$obj->course = $row["course_name"];
	$obj->room = $row["room_name"];
	$objItem = array(
		"id" => $obj->id,
        "date" => $obj->date,
        "startTime" => $obj->startTime,
        "endTime" => $obj->endTime,
        "courseName" => $obj->course,
        "roomName" => $obj->room
	);

	$objArr[] = $objItem;

	echo(json_encode($objItem));
} else {
	echo(json_encode(new stdClass()));
}

?>