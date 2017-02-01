<?php

require_once('Config.php');

class Message {
	
	private $id;
	private $senderID;
	private $receiverID;
	private $text;
	private $viewed;		
	private $creationDate;


	public function __construct() {
		$this->id = -1;
		$this->senderID = NULL;
		$this->receiverID = NULL;
		$this->text = "";
		$this->viewed = NULL;
		$this->creationDate = "";

	}

	public function getID() {
		return $this->id;
	}

	public function getSenderID() {
		return $this->senderID;
	}

	public function setSenderID($newSenderID) {
		$this->senderID = $newSenderID;
	}

	public function getReceiverID() {
		return $this->receiverID;
	}

	public function setReceiverID($newReceiverID) {
		$this->receiverID = $newReceiverID;
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		return $this->text = $text;
	}

	public function getViewed() {
		return $this->viewed;
	}

	public function setViewed($newViewed) {
		return $this->viewed = $newViewed;
	}

	public function getCreationDate() {
		return $this->creationDate;
	}

	public function setCreationDate() {
		return $this->creationDate = date('Y-m-d H:i:s');
	}

	static public function loadMessageById(PDO $conn, $id) {

		$sql = "SELECT * FROM Messages WHERE id=? LIMIT 1";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$id]);
				if($stmt == true) {
					$row = $stmt->fetch();
					$loadMessageById = new Message();
					$loadMessageById->id = $row['ID'];
					$loadMessageById->senderID = $row['senderID'];
					$loadMessageById->receiverID = $row['receiverID'];
					$loadMessageById->text = $row['text'];
					$loadMessageById->viewed = $row['viewed'];					
					$loadMessageById->creationDate = $row['creationDate'];
					return $loadMessageById;
				}
				return null;

		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}

	}

	static public function loadAllMessagesBySender(PDO $conn, $senderID) {

		$sql = "SELECT * FROM Messages WHERE senderID=? ORDER BY creationDate ASC";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$senderID]);
				if($stmt == true && $stmt->rowCount() > 0) {

					foreach($stmt as $row) {
						$loadedMessages = new Message();
						$loadedMessages->id = $row['ID'];
						$loadedMessages->senderID = $row['senderID'];
						$loadedMessages->receiverID = $row['receiverID'];
						$loadedMessages->text = $row['text'];
						$loadedMessages->viewed = $row['viewed'];					
						$loadedMessages->creationDate = $row['creationDate'];
						$ret[] = $loadedMessages;
					}
					return $ret;
				}
				return false;

		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}	
	}

	static public function loadAllMessagesByReceiver(PDO $conn, $receiverID) {

		$sql = "SELECT * FROM Messages WHERE receiverID=? ORDER BY creationDate ASC";

		try {
		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$receiverID]);
				if($stmt == true && $stmt->rowCount() > 0) {

					foreach($stmt as $row) {
						$loadedMessages = new Message();
						$loadedMessages->id = $row['ID'];
						$loadedMessages->senderID = $row['senderID'];
						$loadedMessages->receiverID = $row['receiverID'];
						$loadedMessages->text = $row['text'];
						$loadedMessages->viewed = $row['viewed'];					
						$loadedMessages->creationDate = $row['creationDate'];
						$ret[] = $loadedMessages;
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

			$sql = "INSERT INTO Messages(senderID, receiverID, text, viewed, creationDate) VALUES (?,?,?,?,?)";

			try {
			    $stmt = $conn->prepare($sql);
			    $stmt->execute([$this->senderID,$this->receiverID,$this->text,$this->viewed,$this->creationDate]);
			    $this->id = $conn->lastInsertId();
			    $_SESSION['message'] = "<div class=\"alert alert-success\" role=\"alert\">Do bazy danych została dodana nowa wiadomość o id ".$conn->lastInsertId().".</div>";
			} catch (PDOException $e) {
			        echo("Błąd: " . $e->getMessage());
			}
		} else {
				$sql = "UPDATE Messages SET 
								senderID=?,
								receiverID=?,
								text=?,
								viewed=?,
								creationDate=?,
								WHERE id=$this->id";

		    $stmt = $conn->prepare($sql);
		    $stmt->execute([$this->senderID,$this->receiverID,$this->text,$this->viewed,$this->creationDate]);
				if($stmt == true) {
					return true;
				}
		return false;
		}
	}

	public function markAsRead(PDO $conn) {
		$sql = "UPDATE Messages SET viewed=? WHERE id=$this->id";
		try {
	    $stmt = $conn->prepare($sql);
	    $stmt->execute([$this->viewed]);
			if($stmt == true) {
				return true;
			}
			return false;
		} catch (PDOException $e) {
		    echo("Błąd: " . $e->getMessage());
		}
	}

	public function deleteMessage($conn,$id) {
		if($id != -1){
			$sql = "DELETE FROM Messages WHERE id=? LIMIT 1";
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