<?php

require_once('Config.php');

class User {
	
	private $id;
	private $username;
	private $email;	
	private $hashedPassword;

	public function __construct() {
		$this->id = -1;
		$this->username = "";
		$this->email = "";
		$this->hashedPassword = "";
	}

	public function getID() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($newUsername) {
		return $this->username = $newUsername;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($newEmail) {
		return $this->email = $newEmail;
	}

	public function getPassword() {
		return $this->hashedPassword;
	}

	public function samePassword($newPassword) {
		$newHashedPassword = $newPassword;
		return $this->hashedPassword = $newHashedPassword;
	}

	public function setPassword($newPassword) {
		$newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
		return $this->hashedPassword = $newHashedPassword;
	}

	public function saveToDB(PDO $conn) {
		if($this->id == -1) {	
			$sql = "INSERT INTO Users(username, email, hashed_password) VALUES (?,?,?)";

			try {
			    $stmt = $conn->prepare($sql);
			    $stmt->execute([$this->username,$this->email,$this->hashedPassword]);
			    $this->id = $conn->lastInsertId();
			} catch (PDOException $e) {
			    echo("Błąd: " . $e->getMessage());
			}
		} else {
				$sql = "UPDATE Users SET 
								username=?,
								email=?,
								hashed_password=?
								WHERE id=$this->id";

		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$this->username,$this->email,$this->hashedPassword]);
				if($stmt == true) {
					return true;
				}
		return false;
		}
	}

	static public function loadUserById(PDO $conn, $id) {

		$sql = "SELECT * FROM Users WHERE id=? LIMIT 1";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$id]);
				if($stmt == true) {
					$row = $stmt->fetch();
					$loadedUser = new User();
					$loadedUser->id = $row['id'];
					$loadedUser->username = $row['username'];
					$loadedUser->hashedPassword = $row['hashed_password'];
					$loadedUser->email = $row['email'];
					return $loadedUser;
				}
				return null;
		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	static public function loadUserByEmail(PDO $conn, $email) {

		$sql = "SELECT * FROM Users WHERE email=? LIMIT 1";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$email]);
				if($stmt == true) {
					$row = $stmt->fetch();
					$loadedUser = new User();
					$loadedUser->id = $row['id'];
					return $loadedUser;
				}
				return null;
		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	static public function loadAllUsers(PDO $conn) {

		$sql = "SELECT * FROM Users";
		$ret = [];

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute();
				if($stmt == true) {
					foreach($stmt as $row){
						$loadedUser = new User();
						$loadedUser->id = $row['id'];
						$loadedUser->username = $row['username'];
						$loadedUser->hashedPassword = $row['hashed_password'];
						$loadedUser->email = $row['email'];
						$ret[] = $loadedUser;
					}
				}
				return $ret;
		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	public function deleteUser(PDO $conn,$id) {
		if($id != -1) {
			$sql = "DELETE FROM Users WHERE id=$id";

			try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute();
		 		if($stmt == true) {
					$id = -1;
					return true;
		 		}
		 		return false;
			} catch (PDOException $e) {
			  	echo("Błąd: " . $e->getMessage());
			}
		}
		return true;
	}

	static public function authenticateUser(PDO $conn, $email = '', $password = '') {

		$sql  = "SELECT * FROM Users ";
		$sql .= "WHERE email = '{$email}' ";
		$sql .= "LIMIT 1";

		try {
	    $stmt = $conn->prepare($sql);
	    $stmt->execute();
	 		if($stmt == true && $stmt->rowCount() > 0) {
				$row = $stmt->fetch();
				$dbPass = $row['hashed_password'];

				if(password_verify($password, $dbPass)) {
					$_SESSION['id'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					return true;
				} else {
					return false;
				}
	 		}
	 		return false;
		} catch (PDOException $e) {
		  	echo("Błąd: " . $e->getMessage());
		}		
	}	

}