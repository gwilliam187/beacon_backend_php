<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
 
require_once('../../config/database.php');
require_once('../../objects/Student.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new Student($db);
 
$obj->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$stmt = $obj->readOne();
$num = $stmt->rowCount();

if($num == 1) {
	$objArr = array();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$obj->name = $row["name"];
	$obj->entranceDate = $row["entrance_date"];
	$obj->major = $row["major_name"];
	$objItem = array(
		"id" => $obj->id,
	    "name" => $obj->name,
	    "entranceDate" => $obj->entranceDate,
	    "major" = $obj->major;
	);

	$objArr[] = $objItem;

	echo(json_encode($objItem));
} else {
	echo(json_encode(new stdClass()));
}

?>