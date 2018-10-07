<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/CourseHasStudent.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new CourseHasStudent($db);

$obj->courseId = isset($_GET['course_id']) ? $_GET['course_id'] : die();
 
$stmt = $obj->readStudentsInCourse();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "studentId" => $row["student_id"],
            "student" => $row["student_name"],
            "majorId" => $row["major_id"],
            "major" => $row["major_name"],
            "courseId" => $row["course_id"],
            "course" => $row["course_name"],
            "startDate" => $row["start_date"],
            "endDate" => $row["end_date"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>