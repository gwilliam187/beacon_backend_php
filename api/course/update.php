<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/database.php');
require_once('../../objects/Course.php');

$database = new Database();
$db = $database->getConnection();

$obj = new Course($db);

$obj->id = isset($_GET['id']) ? $_GET['id'] : die();
$obj->name = isset($_GET['name']) ? $_GET['name'] : die();

if($obj->update()) {
    echo json_encode(array("message" => "Record was updated."));
} else {
    echo json_encode(array("message" => "Unable to update record."));
}

?>