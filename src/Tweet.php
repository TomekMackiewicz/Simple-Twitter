
<?php

require_once('Config.php');

class Tweet {

	private $id;
	private $userID;
	private $text;
	private $creationDate;

	public function __construct() {
		$this->id = -1;
		$this->userID = NULL;
		$this->text = "";
		$this->creationDate = "";
	}

	public function getID() {
		return $this->id;
	}

	public function getUserID() {
		return $this->userID;
	}

	public function getText() {
		return $this->text;
	}

	public function getCreationDate() {
		return $this->creationDate;
	}

	public function setUserID($userID) {
		return $this->userID = $userID;
	}

	public function setText($text) {
		return $this->text = $text;
	}

	public function setCreationDate() {
		return $this->creationDate = date('Y-m-d H:i:s');
	}

	static public function loadTweetById(PDO $conn, $id) {

		$sql = "SELECT * FROM Tweets WHERE id=? LIMIT 1";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$id]);
				if($stmt == true) {
					$row = $stmt->fetch();
					$loadTweetById = new Tweet();
					$loadTweetById->id = $row['id'];
					$loadTweetById->userID = $row['userID'];
					$loadTweetById->text = $row['text'];
					$loadTweetById->creationDate = $row['creationDate'];				
					return $loadTweetById;
				}
				return null;
		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	static public function loadAllTweetsByUserId(PDO $conn, $userID) {

		$sql = "SELECT * FROM Tweets WHERE userID=?";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$userID]);
				if($stmt == true && $stmt->rowCount() > 0) {

					foreach($stmt as $row) {
						$loadedTweets = new Tweet();
						$loadedTweets->id = $row['id'];
						$loadedTweets->text = $row['text'];
						$loadedTweets->creationDate = $row['creationDate'];
						$ret[] = $loadedTweets;
					}
					return $ret;
				}
				return false;

		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	static public function loadAllTweets(PDO $conn) {

		$sql = "SELECT * FROM Tweets";
		$ret = [];

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute();
				if($stmt == true) {
					foreach($stmt as $row){
						$loadedTweets = new Tweet();
						$loadedTweets->id = $row['id'];
						$loadedTweets->userID = $row['userID'];
						$loadedTweets->text = $row['text'];
						$loadedTweets->creationDate = $row['creationDate'];
						$ret[] = $loadedTweets;
					}
				  return $ret;
				}
				return false;

		} catch (PDOException $e) {
		        echo("Błąd: " . $e->getMessage());
		}
	}

	public function saveToDB(PDO $conn) {
		if($this->id == -1) {	
			$sql = "INSERT INTO Tweets(userID, text, creationDate) VALUES (?,?,?)";

			try {
			    $stmt = $conn->prepare($sql);
			    $stmt->execute([$this->userID,$this->text,$this->creationDate]);
			    $this->id = $conn->lastInsertId();
			    $_SESSION['message'] = "<div class=\"alert alert-success\" role=\"alert\">Do bazy danych został dodany nowy tweet o id ".$conn->lastInsertId().".</div>";

			} catch (PDOException $e) {
			        echo("Błąd: " . $e->getMessage());
			}
		} else {
				$sql = "UPDATE Tweets SET 
								userID=?,
								text=?,
								creationDate=?
								WHERE id=$this->id";

		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$this->userID,$this->text,$this->creationDate]);
				if($stmt == true) {
					return true;
				}
		return false;
		}
	}

	public function deleteTweet($conn,$id) {
		if($id != -1){
			$sql = "DELETE FROM Tweets WHERE id=? LIMIT 1";

			try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$id]);
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

} 