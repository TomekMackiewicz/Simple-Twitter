<?php
require_once('../src/Session.php');
require_once('../src/User.php');

$message = "";

if($_GET['id'] == $_SESSION['id']) {
	$user = User::loadUserById($conn, $_GET['id']);
	$location = $_GET['from'];	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
	 	if(!empty($_POST['changeUsername'])) {
			$_SESSION['username'] == $_POST['changeUsername'];
			$user->setUsername($_POST['changeUsername']);
			$user->setEmail($user->getEmail());
			$user->samePassword($user->getPassword());
			$user->saveToDB($conn);	
			$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Username changed successfully.</div>';	
			header("Location: ".$location);
	 	} else {
	 		$message = '<div class="alert alert-danger" role="alert">Please fill in the form.</div>';
	 	}
	}
} else {
	$message = '<div class="alert alert-danger" role="alert">You can\'t modify other user\'s data.</div>';
}

require_once('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-12">
  		<h2>New username</h2>

  		<?php echo $message ?>

			<form action="#" method="POST">
				<div class="form-group">
		    	<label for="changeUsername">Username</label>
		    	<input type="text" class="form-control" id="changeUsername" name="changeUsername">
		    </div>				  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>