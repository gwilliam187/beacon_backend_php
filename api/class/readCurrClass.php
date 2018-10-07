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
 
$beaconId = isset($_GET['beacon_id']) ? $_GET['beacon_id'] : die();
 
$stmt = $obj->readCurrentClass($beaconId);
$num = $stmt->rowCount();

if($num == 1) {
	$objArr = array();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$obj->id = $row["class_id"];
	$obj->course = $row["name"];
	$obj->startTime = $row["start_time"];
	$obj->endTime = $row["end_time"];

	$objItem = array(
		"id" => $obj->id,
		"courseName" => $obj->course,
        "startTime" => $obj->startTime,
        "endTime" => $obj->endTime
	);

	$objArr[] = $objItem;

	echo(json_encode($objItem));
} else {
	echo(json_encode(new stdClass()));
}

?>