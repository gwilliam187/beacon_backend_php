<?php

class Admin {
	
	private $conn;

	public function __construct($db) {
		$this->conn = $db;
	}

    function login($username, $password) {
        $query = "
            SELECT `username`
            FROM `admin`
            WHERE `username` = :user AND `password` = :pass";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":user", $username, PDO::PARAM_STR);
        $stmt->bindValue(":pass", $password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
}

?>