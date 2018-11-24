<?php

header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Credentials: true");

session_start();
 
require_once('../../config/database.php');
require_once('../../objects/Admin.php');
 
$database = new Database();
$db = $database->getConnection();
 
$obj = new Admin($db);
 
$username = isset($_POST['username']) ? $_POST['username'] : die();
$password = isset($_POST['password']) ? $_POST['password'] : die();
 
$stmt = $obj->login($username, $password);
$num = $stmt->rowCount();

if($num == 1) {
	$_SESSION['username'] = $username;

	header('Location: ../home/home.php');
} else {
	header('Location: ./login.php');
}

?>