<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/MajorHasCourse.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new MajorHasCourse($db);

$obj->majorId = isset($_GET['major_id']) ? $_GET['major_id'] : die();
 
$stmt = $obj->readWhereMajor();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "courseId" => $row["course_id"],
            "course" => $row["course_name"],
            "majorId" => $row["major_id"],
            "major" => $row["major_name"],
            "semester" => $row["semester"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>