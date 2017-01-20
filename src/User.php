<?php

class User {
	
	private $id;
	private $username;
	private $hashedPassword;
	private $email;

	public function __construct() {
		$this->id = -1;
		$this->username = "";
		$this->email = "";
		$this->hashedPassword = "";
	}

	public function setPassword($newPassword) {
		$newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
		$this->hashedPassword = $newHashedPassword;
	}

	public function saveToDB() {

	}

	static public function loadUserById(mysqli $connection, $id) {
		
	}

}

echo password_hash("Tomek", PASSWORD_BCRYPT);