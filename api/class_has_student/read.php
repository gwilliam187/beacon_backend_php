<?php

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/UnivClassHasStudent.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new UnivClassHasStudent($db);
 
$stmt = $obj->read();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "studentId" => $row["student_id"],
            "studentName" => $row["student_name"],
            "majorId" => $row["major_id"],
            "majorname" => $row["major_name"],
            "classId" => $row["course_name"],
            "courseName" => $row["room_name"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>