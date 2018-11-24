<?php

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/UnivClassHasStudent.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new UnivClassHasStudent($db);

$obj->classId = isset($_GET['class_id']) ? $_GET['class_id'] : die();
 
$stmt = $obj->readAllStudentsNotAttendedInClass();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "studentId" => $row["student_id"],
            "student" => $row["student_name"],
            "majorId" => $row["major_id"],
            "major" => $row["major_name"],
            "classId" => $row["course_name"],
            "courseId" => $row["course_id"],
            "course" => $row["course_name"],
            "attendTime" => $row["attend_time"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>