<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/UnivClassHasStudent.php');

$database = new Database();
$db = $database->getConnection();

$obj = new UnivClassHasStudent($db);

$rawDate = isset($_POST["date"]) ? $_POST["date"] : die();
$rawAttendTime = isset($_POST["attend_time"]) ? $_POST["attend_time"] : die();
$attendDatetime = $rawDate . ' ' . $rawAttendTime;
$attendDatetime = date("Y-m-d H:i:s",strtotime($attendDatetime));

$obj->classId = isset($_POST["class_id"]) ? $_POST["class_id"] : die();
$obj->studentId = isset($_POST["student_id"]) ? $_POST["student_id"] : die();
$obj->attendTime = $attendDatetime;

if($obj->update()) {
    echo json_encode(array("message" => "success"));
} else {
    echo json_encode(array("message" => "fail"));
}

?>