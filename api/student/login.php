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

$obj->id = isset($_POST["id"]) ? $_POST["id"] : die();
$obj->pass = isset($_POST["pass"]) ? $_POST["pass"] : die();

$stmt = $obj->login();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "id" => $row["student_id"],
            "name" => $row["name"],
            "entranceDate" => $row["entrance_date"],
            "majorName" => $row["major_name"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>