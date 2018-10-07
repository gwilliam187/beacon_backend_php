<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/CourseHasStudent.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new CourseHasStudent($db);

$obj->studentId = isset($_POST["student_id"]) ? $_POST["student_id"] : die();
$obj->courseId = isset($_POST["course_id"]) ? $_POST["course_id"] : die();
$obj->startDate = isset($_POST["start_date"]) ? $_POST["start_date"] : die();
$obj->endDate = isset($_POST["end_date"]) ? $_POST["end_date"] : die();
 
if($obj->create()) {
    echo json_encode(array("message" => "success"));
} else {
    echo json_encode(array("message" => "fail"));
}
?>