<?php

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/UnivClass.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new UnivClass($db);
 
$stmt = $obj->read();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "id" => $row["class_id"],
            "date" => $row["date"],
            "startTime" => $row["start_time"],
            "endTime" => $row["end_time"],
            "courseName" => $row["course_name"],
            "roomName" => $row["room_name"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>