<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/database.php');
require_once('../../objects/Major.php');

$database = new Database();
$db = $database->getConnection();
 
$obj = new Major($db);
 
$stmt = $obj->read();
$num = $stmt->rowCount();

if($num > 0) {
    $objArr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $objItem = array(
            "id" => $row["major_id"],
            "name" => $row["name"]
        );
        
        $objArr[] = $objItem;
    }
 
    echo json_encode($objArr);
} else {
    echo json_encode(array());
}

?>