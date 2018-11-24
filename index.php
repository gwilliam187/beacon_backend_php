<?php

if(isset($_SESSION['username'])) {
	header("Location: views/home/home.php");
} else {
	header('Location: views/login/login.php');
}

?>