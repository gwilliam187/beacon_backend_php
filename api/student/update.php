<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/Student.php');

$database = new Database();
$db = $database->getConnection();

$obj = new Student($db);

$obj->id = isset($_POST['id']) ? $_POST['id'] : die();
$obj->name = isset($_POST['name']) ? $_POST['name'] : die();
$obj->entranceDate = isset($_POST["entrance_date"]) ? $_POST["entrance_date"] : die();
$obj->pass = isset($_POST["pass"]) ? $_POST["pass"] : die();
$obj->majorId = isset($_POST["major"]) ? $_POST["major"] : die();

if($obj->update()) {
    echo json_encode(array("message" => "Record was updated."));
} else {
    echo json_encode(array("message" => "Unable to update record."));
}

?>