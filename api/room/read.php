<?php

header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/room.php');

// instantiate database
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$obj = new Room($db);
 
// query products
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
            "id" => $room_id,
            "name" => $name,
            "beacon" => $beacon
        );
 
        array_push($objArr["records"], $objItem);
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array("message" => "No products found."));
}

?>