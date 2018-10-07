<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/MajorHasCourse.php');

$database = new Database();
$db = $database->getConnection();

$obj = new MajorHasCourse($db);

$obj->majorId = isset($_POST['major_id']) ? $_POST['major_id'] : die();
$obj->courseId = isset($_POST['course_id']) ? $_POST['course_id'] : die();

if($obj->delete()) {
    echo json_encode(array("message" => "success"));
} else {
    echo json_encode(array("message" => "fail"));
}

?>