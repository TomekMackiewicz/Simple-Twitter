
<?php

class Session {
	
	private $logged_in = false;
	public $user_id;
	public $message;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
		if($this->logged_in) {
			// Action if user is logged in.
		} else {
			// Action if user is not logged in.
		}
	}

	public function is_logged_in() {
		return $this->logged_in;	
	}

	public function login($user) {
		if($user) {
			//$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->logged_in = true;
		}
	}

	public function logout() {
		unset($_SESSION['id']);
		unset($_SESSION['username']);
		unset($this->user_id);
		$this->logged_in = false;
	}

	private function check_login() {
		if(isset($_SESSION['id'])) {
			$this->user_id = $_SESSION['id'];
			$this->logged_in = true;
		} else {
			unset($this->user_id);
			$this->logged_in = false;
		}
	}

	public function message($msg = "") {
		if(!empty($msg)) {
			// then this is "set message"
			$_SESSION['message'] = $msg;
		} else {
			// then this is "get message"
			return $this->message;
		}
	}

	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attr ane erase the stored version
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {
			$this->message = '';
		}
	}

}

$session = new Session();
//$sessionMessage = $session->message();

?>