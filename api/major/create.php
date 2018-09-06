<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../config/database.php');
require_once('../objects/major.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new Major($db);

$obj->name = isset($_POST["name"]) ? $_POST["name"] : die();
 
// create the product
if($product->create()) {
    echo json_encode(array("message" => "Object was created."));
} else {
    echo json_encode(array("message" => "Unable to create object."));
}
?>