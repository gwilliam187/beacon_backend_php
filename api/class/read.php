<?php

header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/class.php');

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$obj = new UnivClass($db);
 
// query products
// $stmt = $class->read();
$stmt = $obj->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0) {
    // products array
    $objArr = array();
    $objArr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row this will make $row['name'] to just $name only
        extract($row);
 
        $objItem = array(
            "name" => $name,
            "date" => $date,
            "startTime" => $start_time,
            "endTime" => $end_time,
            "course" => $course_name,
            "room" => $room_name
        );
 
        array_push($objArr["records"], $objItem);
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array("message" => "No products found."));
}

?>