<?php

require_once('Config.php');

class Comment {
	
	private $id;
	private $userID;
	private $postID;	
	private $creationDate;
	private $text;

	public function __construct() {
		$this->id = -1;
		$this->userID = NULL;
		$this->postID = NULL;
		$this->creationDate = "";
		$this->text = "";
	}

	public function getID() {
		return $this->id;
	}

	public function getUserID() {
		return $this->userID;
	}

	public function setUserID($newUserID) {
		$this->userID = $newUserID;
	}

	public function getPostID() {
		return $this->postID;
	}

	public function setPostID($newPostID) {
		$this->postID = $newPostID;
	}

	public function getCreationDate() {
		return $this->creationDate;
	}

	public function setCreationDate() {
		return $this->creationDate = date('Y-m-d H:i:s');
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		return $this->text = $text;
	}

	static public function loadCommentById(PDO $conn, $id) {

		$sql = "SELECT * FROM Comments WHERE id=? LIMIT 1";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$id]);
				if($stmt == true) {
					$row = $stmt->fetch();
					$loadCommentById = new Comment();
					$loadCommentById->id = $row['id'];
					$loadCommentById->userID = $row['userID'];
					$loadCommentById->postID = $row['postID'];
					$loadCommentById->creationDate = $row['creationDate'];
					$loadCommentById->text = $row['text'];
					return $loadCommentById;
				}
				return null;

		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}

	}

	static public function loadAllCommentsByPostId(PDO $conn, $postID) {

		$sql = "SELECT * FROM Comments WHERE postID=? ORDER BY creationDate ASC";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$postID]);
				if($stmt == true && $stmt->rowCount() > 0) {

					foreach($stmt as $row) {
						$loadedComments = new Comment();
						$loadedComments->id = $row['id'];
						$loadedComments->userID = $row['userID'];
						$loadedComments->postID = $row['postID'];
						$loadedComments->creationDate = $row['creationDate'];
						$loadedComments->text = $row['text'];
						$ret[] = $loadedComments;
					}
					return $ret;
				}
				return false;

		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}	
	}

	static public function loadAllCommentsByUserId(PDO $conn, $userID) {

		$sql = "SELECT * FROM Comments WHERE userID=? ORDER BY creationDate ASC";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$userID]);
				if($stmt == true && $stmt->rowCount() > 0) {

					foreach($stmt as $row) {
						$loadedComments = new Comment();
						$loadedComments->id = $row['id'];
						$loadedComments->userID = $row['userID'];
						$loadedComments->postID = $row['postID'];
						$loadedComments->creationDate = $row['creationDate'];
						$loadedComments->text = $row['text'];
						$ret[] = $loadedComments;
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

			$sql = "INSERT INTO Comments(userID, postID, creationDate, text) VALUES (?,?,?,?)";

			try {
			    $stmt = $conn->prepare($sql);
			    $stmt->execute([$this->userID,$this->postID,$this->creationDate,$this->text]);
			    $this->id = $conn->lastInsertId();
			    $_SESSION['message'] = "<div class=\"alert alert-success\" role=\"alert\">Do bazy danych został dodany nowy komentarz o id ".$conn->lastInsertId().".</div>";
			} catch (PDOException $e) {
			        echo("Błąd: " . $e->getMessage());
			}
		} else {
				$sql = "UPDATE Comments SET 
								userID=?,
								postID=?,
								creationDate=?,
								text=?
								WHERE id=$this->id";

		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$this->userID,$this->postID,$this->creationDate,$this->text]);
				if($stmt == true) {
					return true;
				}
		return false;
		}
	}

	public function deleteComment($conn,$id) {
		if($id != -1){
			$sql = "DELETE FROM Comments WHERE id=? LIMIT 1";
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

?>