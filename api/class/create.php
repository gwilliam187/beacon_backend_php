<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/UnivClass.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new UnivClass($db);

$obj->date = isset($_POST["date"]) ? $_POST["date"] : die();
$obj->startTime = isset($_POST["start_time"]) ? $_POST["start_time"] : die();
$obj->endTime = isset($_POST["end_time"]) ? $_POST["end_time"] : die();
$obj->courseId = isset($_POST["course"]) ? $_POST["course"] : die();
$obj->roomId = isset($_POST["room"]) ? $_POST["room"] : die();
 
if($obj->create()) {
    echo json_encode(array("message" => "Record was created."));
} else {
    echo json_encode(array("message" => "Unable to create record."));
}
?>